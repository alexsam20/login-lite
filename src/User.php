<?php

namespace src;

class User
{
    private ?DB $_db;

    private $_data;

    private bool $_isLoggedIn = false;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
        if (!$user) {
            if (Session::exists(SESSION_NAME)) {
                $user = Session::get(SESSION_NAME);
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    // process Logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = []): void
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new \RuntimeException('Error inserting user.');
        }
    }

    public function find($user = null): bool
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', [$field, '=', $user]);

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }

        return false;
    }

    public function login(string $username = null, string $password = null, bool $remember = false): bool
    {
        if (!$username && !$password && $this->exists()) {
            Session::put(SESSION_NAME, $this->data()->id);
        } else {
            $user = $this->find($username);
            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put(SESSION_NAME, $this->data()->id);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', ['user_id', '=', $this->data()->id]);
                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', [
                                'user_id' => $this->data()->id,
                                'hash' => $hash,
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put(COOKIE_NAME, $hash, COOKIE_LIFETIME);
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function exists()
    {
        return !empty($this->_data);
    }

    public function logout(): void
    {
        $this->_db->delete('users_session', ['user_id', '=', $this->data()->id]);
        Session::delete(SESSION_NAME);
        Cookie::delete(COOKIE_NAME);
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn(): bool
    {
        return $this->_isLoggedIn;
    }
}