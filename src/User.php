<?php

namespace src;

class User
{
    private $_db;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
    }

    public function create($fields = [])
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new \Exception('Error inserting user.');
        }
    }
}