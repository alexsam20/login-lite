<?php
function escape($string): string {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function print_pre($var, $flag = null): void {
    echo '<pre>';
    if (is_null($var)) {
        print_r('null');
    } elseif (is_bool($var)) {
        if ($var = true) {
            print_r('true');
        } else {
            print_r('false');
        }
    }
    if (!is_null($var) && !is_bool($var)) {
        print_r($var, 1);
    }
    echo '</pre>';
    if ($flag) { exit(); }
}