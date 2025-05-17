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

    private function action($action, $table, $where = []): false|static
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

    public function get($table, $where): false|static
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where): false|static
    {
        return $this->action('DELETE', $table, $where);
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
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