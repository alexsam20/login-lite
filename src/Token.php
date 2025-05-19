<?php

namespace src;

class Token
{
    public static function generate()
    {
        return Session::put(TOKEN_NAME, md5(uniqid(mt_rand(), true)));
    }

    public static function check($token)
    {
        if (Session::exists(TOKEN_NAME) && $token === Session::get(TOKEN_NAME)) {
            Session::delete(TOKEN_NAME);
            return true;
        }

        return false;
    }
}