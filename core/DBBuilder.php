<?php

require_once 'dbconn.php';

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

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function set($data)
    {
        if (empty($data)) return $this;

        $this->data = array_merge($this->data, $data);
        return $this;
    }


    public function table($table)
    {
        $this->table = $this->escapeColumn($table);
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

    public function where($namaField, $value, $type = 'AND')
    {
        $namaField = $this->escapeColumn($namaField);
        $prefix = empty($this->where) ? '' : " $type ";

        if (is_null($value)) {
            $this->where[] = "$prefix$namaField IS NULL";
        } elseif (is_bool($value)) {
            $this->where[] = "$prefix$namaField = " . (int)$value;
        } elseif (is_numeric($value)) {
            $this->where[] = "$prefix$namaField = $value";
        } else {
            $this->where[] = "$prefix$namaField = '" . mysqli_real_escape_string($this->conn, $value) . "'";
        }
        return $this;
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
            $sql .= " WHERE " . implode(' AND ', $this->where);
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
        return '`' . preg_replace('/[^a-zA-Z0-9_.]/', '', $column) . '`';
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
        if ($id)
            $this->where($this->primaryKey, $id);

        if (empty($this->table) || empty($this->where)) {
            $this->lastError = "Error: Table name and WHERE condition are required";
            return false;
        }

        $sql = "DELETE FROM $this->table WHERE " . implode(' AND ', $this->where);
        $result = mysqli_query($this->conn, $sql);

        $this->resetQuery();  // ✅ Pastikan query tidak bercampur dengan yang lain

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

        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
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
}
