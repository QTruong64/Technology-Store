<?php

use Illuminate\Support\Facades\Route;

class Navigation
{
    public static function isActiveRoute($route, $output = 'active')
    {
        $routeName = explode(".", Route::currentRouteName());
        if (is_array($route)) {
            if (in_array($routeName[0], $route)) {
                return $output;
            }
        }
        if ($routeName[0] == $route) {
            return $output;
        }
    }

}
