<?php

namespace src;

class Cookie
{
    public static function exists(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    public static function get(string $name): mixed
    {
        return $_COOKIE[$name] ?? null;
    }

    public static function put(string $name, $value, $expire = 0): bool
    {
        if (setcookie($name, $value, time() + $expire, '/')) {
            return true;
        }

        return false;
    }

    public static function delete(string $name): void
    {
        self::put($name, '', time() - 1);
    }
}