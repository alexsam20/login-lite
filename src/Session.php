<?php

namespace src;

class Session
{
    public static function exists(string $name): bool
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    public static function put(string $name, string $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get(string $name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function delete(string $name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
}