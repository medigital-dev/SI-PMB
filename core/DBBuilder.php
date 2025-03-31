<?php

require_once 'config.php';

class DBBuilder
{
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';
    protected $select = '*';
    protected $where = [];
    protected $joins = [];
    protected $orderBy = [];
    protected $data = [];
    protected $limit = '';
    protected $debug = false;
    protected $lastInsertedId;
    protected $lastAffectedRows;
    protected $lastError;
    protected $groupStarted = false;
    protected $indexKey = [];
    protected $useTimestamp = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function __construct($tableName = null)
    {
        $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->table = $tableName;
    }

    /**
     * @param boolean $status
     * 
     * Default true
     */
    public function setTimestamp(bool $status)
    {
        $this->useTimestamp = $status;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    public function set($data)
    {
        if (empty($data)) return $this;

        $this->data = array_merge($this->data, $data);
        return $this;
    }


    public function table($tableName = null)
    {
        $this->indexKey = [];
        $this->table = $this->escapeColumn($tableName);
        return $this;
    }

    public function select($columns = '*')
    {
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $columns = array_map('trim', $columns);

        $this->select = implode(', ', array_map([$this, 'escapeColumnWithAlias'], $columns));

        return $this;
    }

    private function escapeColumnWithAlias($column)
    {
        if (preg_match('/\s+as\s+/i', $column)) {
            list($col, $alias) = preg_split('/\s+as\s+/i', $column);
            return $this->escapeColumn(trim($col)) . ' AS ' . $this->escapeColumn(trim($alias));
        }
        return $this->escapeColumn($column);
    }

    public function where($field, $value = null, $type = 'AND')
    {
        if (is_array($field)) {
            if ($value !== null) {
                throw new InvalidArgumentException("Invalid usage: when using an array, the second parameter must be null.");
            }
            foreach ($field as $key => $val) {
                $this->where($key, $val, $type);
            }
            return $this;
        }

        if (empty($field)) {
            return $this;
        }

        $field = $this->escapeColumn($field);

        $condition = '';

        if (is_null($value)) {
            $condition = "$field IS NULL";
        } elseif (is_bool($value)) {
            $condition = "$field = " . (int)$value;
        } elseif (is_numeric($value)) {
            $condition = "$field = $value";
        } else {
            $escapedValue = mysqli_real_escape_string($this->conn, trim($value));
            $condition = "$field = '$escapedValue'";
        }

        // Tambahkan kondisi ke dalam array
        if (!empty($this->where)) {
            $this->where[] = "$type $condition";
        } else {
            $this->where[] = $condition;
        }

        return $this;
    }

    public function orWhere($field, $value = null)
    {
        return $this->where($field, $value, 'OR');
    }

    public function groupStart()
    {
        $this->where[] = "(";
        $this->groupStarted = true;
        return $this;
    }

    public function groupEnd()
    {
        if ($this->groupStarted) {
            $this->where[] = ")";
            $this->groupStarted = false;
        }
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $column = $this->escapeColumn($column);
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = ["$column $direction"];
        return $this;
    }

    public function limit($limit, $offset = null)
    {
        $this->limit = isset($offset) ? "LIMIT " . (int)$offset . ", " . (int)$limit : "LIMIT " . (int)$limit;
        return $this;
    }

    public function join($table, $condition, $type = 'INNER')
    {
        $allowedTypes = ['INNER', 'LEFT', 'RIGHT'];
        $type = strtoupper($type);
        if (!in_array($type, $allowedTypes)) {
            $type = 'INNER';
        }

        $table = $this->escapeColumn($table);
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    public function getQuery()
    {
        if (empty($this->table)) {
            if (property_exists($this, 'table') && !empty($this->table)) {
                $this->table($this->table);
            } else {
                throw new Exception("Error: Table name is required");
            }
        }

        $sql = "SELECT $this->select FROM $this->table";
        if (!empty($this->joins)) {
            $sql .= " " . implode(' ', $this->joins);
        }
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' ', $this->where);
        }
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }
        if (!empty($this->limit)) {
            $sql .= " $this->limit";
        }

        if ($this->debug) {
            echo "Debug Query: " . $sql . "<br>";
        }

        return $sql;
    }

    public function findAll($reset = true)
    {
        $sql = $this->getQuery();
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return "Error: " . mysqli_error($this->conn);
        }

        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if ($reset) $this->resetQuery(); // Reset setelah query dieksekusi
        return $data;
    }

    public function first($reset = true)
    {
        $this->limit(1);
        $data = $this->findAll(false); // Jangan reset dua kali
        if ($reset) $this->resetQuery();
        return $data[0] ?? null;
    }

    public function insert($data = [])
    {
        if (!$this->set($data)) return false;

        if (empty($this->table) || empty($this->data)) {
            $this->lastError = "Error: Table name is required or no valid data provided.";
            return false;
        }

        if ($this->useTimestamp) {
            $this->data[$this->createdField] = date('Y-m-d H:i:s');
            $this->data[$this->updatedField] = date('Y-m-d H:i:s');
        }

        $columns = implode(', ', array_map([$this, 'escapeColumn'], array_keys($this->data)));
        $values = implode(', ', array_map([$this, 'prepareValue'], array_values($this->data)));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            $this->lastInsertedId = mysqli_insert_id($this->conn);
            $this->lastAffectedRows = mysqli_affected_rows($this->conn);
        } else {
            $this->lastError = mysqli_error($this->conn);
        }

        $this->resetQuery();
        return $result;
    }


    public function update($id = null, $data = [])
    {
        if (!$this->set($data)) return false;

        if ($id) {
            $this->where($this->primaryKey, $id);
        }

        if (empty($this->table) || empty($this->data) || empty($this->where)) {
            $this->lastError = "Error: Table name, data, and WHERE condition are required";
            return false;
        }

        if ($this->useTimestamp)
            $this->data[$this->updatedField] = date('Y-m-d H:i:s');

        $set = implode(', ', array_map(function ($key, $val) {
            return $this->escapeColumn($key) . " = " . $this->prepareValue($val);
        }, array_keys($this->data), array_values($this->data)));

        $sql = "UPDATE $this->table SET $set WHERE " . implode(' AND ', $this->where);
        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            $this->lastAffectedRows = mysqli_affected_rows($this->conn);
        } else {
            $this->lastError = mysqli_error($this->conn);
        }

        $this->resetQuery();
        return $result;
    }

    private function escapeColumn($column)
    {
        if (strpos($column, '.') !== false) {
            list($table, $col) = explode('.', $column, 2);
            return "`$table`.`$col`";  // ✅ Format yang benar: `table`.`column`
        }
        return "`$column`";
    }


    private function prepareValue($value)
    {
        return is_null($value) ? "NULL" : (is_numeric($value) ? $value : "'" . mysqli_real_escape_string($this->conn, $value) . "'");
    }

    public function resetQuery()
    {
        $this->select = '*';
        $this->where = [];
        $this->joins = [];
        $this->orderBy = [];
        $this->limit = '';
        $this->data = [];
        $this->debug = false;
        $this->groupStarted = false;
    }

    public function getInsertedId()
    {
        return $this->lastInsertedId;
    }

    public function getAffectedRows()
    {
        return $this->lastAffectedRows;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function delete($id = null)
    {
        if (empty($this->table)) {
            $this->lastError = "Error: Table name is required";
            return false;
        }

        $escapedValue = mysqli_real_escape_string($this->conn, trim($id));

        // Coba cari data berdasarkan primary key dulu
        $checkQuery = "SELECT * FROM $this->table WHERE $this->primaryKey = '$escapedValue' LIMIT 1";
        $checkResult = mysqli_query($this->conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // Data ditemukan berdasarkan primary key, hapus berdasarkan primary key
            $sql = "DELETE FROM $this->table WHERE $this->primaryKey = '$escapedValue'";
        } else {
            // Jika ID tidak ditemukan, coba cari berdasarkan index key
            $conditions = [];
            foreach ($this->indexKey as $index) {
                $conditions[] = "$index = '$escapedValue'";
            }

            if (!empty($conditions)) {
                $sql = "DELETE FROM $this->table WHERE " . implode(' OR ', $conditions);
            } else {
                $this->lastError = "Error: No valid primary key or index key found";
                return false;
            }
        }

        if ($this->debug) {
            echo "Debug Query: " . $sql . "<br>";
        }

        $result = mysqli_query($this->conn, $sql);
        $this->resetQuery(); // Reset query setelah eksekusi

        if (!$result) {
            $this->lastError = mysqli_error($this->conn);
            return false;
        }

        return true;
    }

    public function selectSum($column, $alias = null)
    {
        $column = $this->escapeColumn($column);
        $alias = $alias ? $this->escapeColumn($alias) : $column;

        $this->select = "SUM($column) AS $alias";

        return $this;
    }

    public function countAll()
    {
        if (empty($this->table)) {
            $this->lastError = "Error: Table name is required";
            return false;
        }

        $sql = "SELECT COUNT(*) AS total FROM $this->table";

        $validWhere = array_filter($this->where, fn($w) => trim($w) !== "");
        if (!empty($validWhere)) {
            $sql .= " WHERE " . implode(' ', $validWhere);
        }

        if ($this->debug) {
            echo "Debug Query: " . $sql . "<br>";
        }

        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $this->resetQuery(); // Reset setelah eksekusi countAll
            return (int) $row['total'];
        }

        $this->lastError = mysqli_error($this->conn);
        return false;
    }

    public function selectMin($column)
    {
        return $this->aggregateFunction('MIN', $column);
    }

    public function selectMax($column)
    {
        return $this->aggregateFunction('MAX', $column);
    }

    public function selectAvg($column)
    {
        return $this->aggregateFunction('AVG', $column);
    }

    private function aggregateFunction($function, $column)
    {
        if (empty($this->table)) {
            $this->lastError = "Error: Table name is required";
            return false;
        }

        $column = $this->escapeColumn($column);
        $sql = "SELECT $function($column) AS result FROM $this->table";

        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['result'] ?? null;
        }

        $this->lastError = mysqli_error($this->conn);
        return false;
    }

    public function like($field, $value)
    {
        return $this->addLikeCondition($field, $value, 'AND');
    }

    public function orLike($field, $value)
    {
        return $this->addLikeCondition($field, $value, 'OR');
    }

    private function addLikeCondition($field, $value, $type)
    {
        $field = $this->escapeColumn($field);
        $prefix = (empty($this->where) || end($this->where) === '(') ? '' : " $type ";

        $value = mysqli_real_escape_string($this->conn, $value);
        $this->where[] = "$prefix$field LIKE '%$value%'";

        return $this;
    }

    public function save($data = [])
    {
        if (!empty($data)) {
            $this->set($data);
        }

        if (empty($this->data)) {
            $this->lastError = "Error: No data provided to save.";
            return false;
        }

        if (isset($this->data[$this->primaryKey])) {
            return $this->update($this->data[$this->primaryKey], $this->data);
        } else {
            return $this->insert($this->data);
        }
    }

    public function addIndex($key)
    {
        $this->indexKey[] = $key;
    }

    public function find($value)
    {
        if (empty($this->table)) {
            $this->lastError = "Error: Table name is required";
            return false;
        }

        $escapedValue = mysqli_real_escape_string($this->conn, trim($value));
        $result = $this->where($this->primaryKey, $escapedValue)->first();

        if ($result) {
            return $result;
        }

        foreach ($this->indexKey as $index) {
            $result = $this->where($index, $escapedValue)->first();
            if ($result) {
                return $result;
            }
        }

        $this->lastError = "Data not found";
        return false;
    }
}
