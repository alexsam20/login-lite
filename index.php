<?php
require_once 'core/init.php';

use src\DB;

//$user = DB::getInstance()->query("SELECT `username` FROM `users` WHERE `username` = ?", ['billy']);
//$user = DB::getInstance()->query("SELECT * FROM `users`");
$user = DB::getInstance()->get('users', ['username', '=', 'alex']);

if (!$user->count()) {
    echo 'No user found';
} else {
    echo $user->first()->username;
//    foreach ($user->results() as $user) {
//        echo $user->username . '<br />';
//    }
}