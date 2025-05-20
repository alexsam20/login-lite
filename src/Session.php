<?php

namespace src;

class Session
{
    public static function exists(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    public static function put(string $name, string $value): string
    {
        return $_SESSION[$name] = $value;
    }

    public static function get(string $name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function delete(string $name): void
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function flash(string $name, string $message = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);

            return $session;
        }

        self::put($name, $message);
    }
}