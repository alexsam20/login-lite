<?php

namespace src;

class DB
{
    private static ?DB $_instance = null;

    private \PDO $_pdo;
    private $_query;
    private bool $_error = false;
    private $_results;
    private int $_count = 0;

    private function __construct()
    {
        try {
            // Set DSN
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $this->_pdo = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
//        if (self::$_instance === null) {
//            self::$_instance = new DB();
//        }
//        return self::$_instance;
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query(string $sql, $params = []): static
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    private function action(string $action, string $table, $where = []): false|static
    {
        if (count($where) === 3) {
            $operators = ['=', '>', '<', '>=', '<=', '<>', '!='];

            [$field, $operator, $value] = $where;

            if (in_array($operator, $operators, true)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get(string $table, $where): false|static
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete(string $table, $where): false|static
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert(string $table, $fields = []): bool
    {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function update(string $table, int $id, $fields)
    {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first(): mixed
    {
        return $this->results()[0];
    }

    public function error(): bool
    {
        return $this->_error;
    }

    public function count(): int
    {
        return $this->_count;
    }
}