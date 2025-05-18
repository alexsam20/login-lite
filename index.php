<?php
require_once 'core/init.php';

use src\DB;

/*$user = DB::getInstance()->query("SELECT `username` FROM `users` WHERE `username` = ?", ['billy']);
if (!$user->count()) {
    echo 'No user found';
} else {
    echo 'OK!';
}

$user = DB::getInstance()->query("SELECT * FROM `users`");
if (!$user->count()) {
    echo 'No user found';
} else {
    foreach ($user->results() as $user) {
        echo $user->username . '<br />';
    }
}

$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
if (!$user->count()) {
    echo 'No user found';
} else {
    echo $user->first()->username;
}

$user = DB::getInstance()->insert('users', [
    'username' => 'Mary',
    'password' => 'password',
    'salt' => 'salt',
    'name' => 'Mary Russell',
    'group' => 1,
]);*/
$user = DB::getInstance()->update('users', 3, [
    'username' => 'new_name',
    'password' => 'new_password',
]);
