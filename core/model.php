<?php

require_once 'dbconn.php';

class DBBuilder
{
    private $conn;
    private $table;
    private $select = '*';
    private $where = [];
    private $joins = [];
    private $orderBy = [];
    private $limit = '';
    private $debug = false;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function table($table)
    {
        $this->table = $this->escapeColumn($table);
        return $this;
    }

    public function select($columns = '*')
    {
        $this->select = is_array($columns) ? implode(', ', array_map([$this, 'escapeColumn'], $columns)) : $this->escapeColumn($columns);
        return $this;
    }

    public function where($conditions)
    {
        if (!is_array($conditions)) return $this;

        foreach ($conditions as $key => $value) {
            $key = $this->escapeColumn($key);
            if (is_null($value)) {
                $this->where[] = "$key IS NULL";
            } elseif (is_bool($value)) {
                $this->where[] = "$key = " . (int)$value;
            } elseif (is_numeric($value)) {
                $this->where[] = "$key = $value";
            } else {
                $this->where[] = "$key = '" . mysqli_real_escape_string($this->conn, $value) . "'";
            }
        }
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $column = $this->escapeColumn($column);
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy[] = "$column $direction";
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
            throw new Exception("Error: Table name is required");
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

    public function insert($data)
    {
        if (empty($this->table)) {
            throw new Exception("Error: Table name is required");
        }
        if (empty($data)) {
            throw new Exception("Error: No data to insert");
        }

        $columns = implode(', ', array_map([$this, 'escapeColumn'], array_keys($data)));
        $values = implode(', ', array_map([$this, 'prepareValue'], array_values($data)));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        if ($this->debug) echo "Debug Query: " . $sql . "<br>";

        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            throw new Exception(mysqli_error($this->conn));
        }

        return mysqli_insert_id($this->conn);
    }

    public function update($data)
    {
        if (empty($this->table)) {
            throw new Exception("Error: Table name is required");
        }
        if (empty($this->where)) {
            throw new Exception("Error: WHERE condition is required for UPDATE");
        }
        if (empty($data)) {
            throw new Exception("Error: No data to update");
        }

        $set = implode(', ', array_map(function ($key, $val) {
            return $this->escapeColumn($key) . " = " . $this->prepareValue($val);
        }, array_keys($data), array_values($data)));

        $sql = "UPDATE $this->table SET $set WHERE " . implode(' AND ', $this->where);
        if ($this->debug) echo "Debug Query: " . $sql . "<br>";

        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            throw new Exception(mysqli_error($this->conn));
        }

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
        // $this->table = '';
        $this->select = '*';
        $this->where = [];
        $this->joins = [];
        $this->orderBy = '';
        $this->limit = '';
        return $this;
    }
}
