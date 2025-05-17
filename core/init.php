<?php
session_start();

// App Root - /home/alex/www/myframework
define('APP_ROOT', dirname(__FILE__, 2));
// URL Root - http://127.0.0.1:8000
define('URL_ROOT', 'http://' . $_SERVER['HTTP_HOST']);

// DB Params
const DB_HOST = 'localhost';
const DB_USER = 'alex';
const DB_PASS = 'alex1970MD3214';
const DB_NAME = 'login';

const DS = DIRECTORY_SEPARATOR;
const APP_NAME = 'Login Lite';
const APP_VERSION = '1.0.0';
const COOKIE_NAME = 'hash';
const COOKIE_LIFETIME = 604800;
const SESSION_NAME = 'user';

//$GLOBALS['config'] = [
//    'mysql' => [
//        'host' => 'localhost',
//        'username' => 'alex',
//        'password' => 'alex1970MD3214',
//        'db' => 'login',
//    ],
//    'remember' => [
//        'cookie_name' => 'hash',
//        'cookie_lifetime' => 604800,
//    ],
//    'session' => [
//        'cookie_name' => 'user',
//    ],
//    'link' => [
//        'app_root' => dirname(__FILE__, 1),
//    ]
//];

spl_autoload_register(static function($class_name) {
    $dirs = [
        'core', // Project specific classes (Core).
        'src', // Applications classes.
    ];

    foreach( $dirs as $dir ) {
        $file = APP_ROOT . DS . str_replace('\\', DS, $class_name) . '.php';
        if (file_exists($file)) {
            require_once($file);
            return;
        }
    }
});

require_once 'functions' . DS . 'sanitize.php';
