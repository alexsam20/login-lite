<?php
function escape($string): string {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function print_pre($var, $flag = null): void {
    echo '<pre>' , print_r($var, 1) . '</pre>';
    if ($flag) { exit(); }
}