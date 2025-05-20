<?php

namespace src;

class Redirect
{

    public static function to(string $location = null): void
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.1 404 Not Found');
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }

            header('location: ' . $location);
            exit();
        }
    }
}