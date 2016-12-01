<?php

use Illuminate\Support\Debug\Dumper;

if (!function_exists('class_case')) {

    /**
     * @param $str
     *
     * @return mixed
     */
    function class_case($str)
    {
        return str_replace('_', '-', $str);
    }
}

if (!function_exists('human_readable')) {

    /**
     * @param $str
     *
     * @return mixed
     */
    function human_readable($str)
    {
        return str_replace('_', ' ', $str);
    }
}

if (!function_exists('set_active_paths')) {

    /**
     * @param string|array $paths
     * @param string       $active
     *
     * @return string
     */
    function set_active_paths($paths, $active = 'active')
    {
        if (!is_array($paths)) {
            $paths = (array) $paths;
        }

        foreach ($paths as $path) {
            if (call_user_func_array('Request::is', (array) $path)) {
                return $active;
            }
        }
    }
}

if (!function_exists('set_active_routes')) {

    /**
     * @param string|array $routes
     * @param string       $output
     *
     * @return string
     */
    function set_active_routes($routes, $output = 'active')
    {
        if (!is_array($routes)) {
            $routes = (array) $routes;
        }

        foreach ($routes as $route) {
            if (Route::is($route)) {
                return $output;
            }
        }
    }
}

if (!function_exists('array_value_replace')) {

    /**
     * @param array $array
     * @param $replace
     * @param null $with
     *
     * @return array
     */
    function array_value_replace(array $array, $replace, $with = null)
    {
        return array_map(function ($value) use ($replace, $with) {
            return $value === $replace ? $with : $value;
        }, $array);
    }
}

if (!function_exists('d')) {
    /**
     * @param  mixed
     */
    function d()
    {
        array_map(function ($x) {
            (new Dumper())->dump($x);
        }, func_get_args());
    }
}
