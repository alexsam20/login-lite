<?php

use src\Session;
use src\DB;

require_once 'core/init.php';

// Select Where
/*$user = DB::getInstance()->query("SELECT `username` FROM `users` WHERE `username` = ?", ['billy']);
if (!$user->count()) {
    echo 'No user found';
} else {
    echo 'OK!';
}
// select
$user = DB::getInstance()->query("SELECT * FROM `users`");
if (!$user->count()) {
    echo 'No user found';
} else {
    foreach ($user->results() as $user) {
        echo $user->username . '<br />';
    }
}
// select one
$user = DB::getInstance()->get('users', ['username', '=', 'alex']);
if (!$user->count()) {
    echo 'No user found';
} else {
    echo $user->first()->username;
}
// Insert
$user = DB::getInstance()->insert('users', [
    'username' => 'Mary',
    'password' => 'password',
    'salt' => 'salt',
    'name' => 'Mary Russell',
    'group' => 1,
]);
// Update
$user = DB::getInstance()->update('users', 3, [
    'username' => 'new_name',
    'password' => 'new_password',
]);
// Test Success
if (\src\Session::exists('success')) {
    echo '<p>';
    echo \src\Session::flash('success');
}*/
// Create user account
if (Session::exists('home')) {
    echo '<p style="color: green">' . Session::flash('home') . '</p>';
}

echo Session::get(SESSION_NAME);
