<?php

namespace src;

class DB
{
    private static $_instance = null;

    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct() {
        try {
            // Set DSN
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $this->_pdo = new \PDO($dsn, DB_USER, DB_PASS);
            echo 'Connected successfully';
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        } else {
            return self::$_instance;
        }
    }
}