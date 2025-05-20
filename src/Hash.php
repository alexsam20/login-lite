<?php

namespace src;

class Hash
{
    public static function make(string $string, string $salt = ''): string
    {
        return hash('sha256', $string . $salt);
    }
    public static function salt(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
    public static function unique(): string
    {
        return self::make(uniqid('', true));
    }
}