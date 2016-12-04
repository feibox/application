<?php

use Illuminate\Support\Debug\Dumper;

if ( ! function_exists('class_case')) {

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

if ( ! function_exists('human_readable')) {

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

if ( ! function_exists('set_active_paths')) {

    /**
     * @param string|array $paths
     * @param string       $active
     *
     * @return string
     */
    function set_active_paths($paths, $active = 'active')
    {
        if ( ! is_array($paths)) {
            $paths = (array) $paths;
        }

        foreach ($paths as $path) {
            if (call_user_func_array('Request::is', (array) $path)) {
                return $active;
            }
        }
    }
}

if ( ! function_exists('set_active_routes')) {

    /**
     * @param string|array $routes
     * @param string       $output
     *
     * @return string
     */
    function set_active_routes($routes, $output = 'active')
    {
        if ( ! is_array($routes)) {
            $routes = (array) $routes;
        }

        foreach ($routes as $route) {
            if (Route::is($route)) {
                return $output;
            }
        }
    }
}

if ( ! function_exists('array_value_replace')) {

    /**
     * @param array $array
     * @param       $replace
     * @param null  $with
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

if ( ! function_exists('d')) {
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

if ( ! function_exists('is_email')) {
    function is_email($email)
    {
        return ( ! filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true : false;
    }
}

if ( ! function_exists('system_account')) {
    function system_account()
    {
        if ( ! app()->bound('system_account')) {
            app()->singleton('system_account', function () {
                return app(App\User::class)->systemAccount();
            });
        }

        return app('system_account');
    }
}

if ( ! function_exists('breadcrumb_subject_folders')) {
    function breadcrumb_subject_folders(\App\Subject $subject)
    {
        $segments = request()->segments();
        $route_name = request()->segment(1).'.folder';
        $data = [];

        if (count($segments) >= 3) {
            if (str_contains($segments[2], '-')) {
                $folders = explode('-', $segments[2]);
            } else {
                $folders = [ $segments[2] ];
            }

            $previous_folder = null;
            foreach ($folders as $folder) {
                if (is_null($previous_folder)) {
                    array_push($data, '<a href="'.url()->route($route_name,
                            [ 'subject_id' => $subject->id, 'folder' => $folder ]).'">'.ucfirst($folder).'</a>');
                } else {
                    array_push($data, '<a href="'.url()->route($route_name, [
                            'subject_id' => $subject->id,
                            'folder'     => $previous_folder.$folder,
                        ]).'">'.ucfirst($folder).'</a>');
                }
                $previous_folder .= $folder.'-';
            }
        }

        $data = array_reverse($data);

        if (count($segments) >= 2) {
            array_push($data, '<a href="'.url()->route($route_name,
                    [ 'subject_id' => $subject->id ]).'">'.ucfirst($subject->code).'</a>');
        }
        if ($segments[0] === 'subjects') {
            array_push($data, '<a href="'.url()->route('admin.subjects.index').'">Subjects</a>');
        } else {
            array_push($data, '<a href="'.url()->route('courses.index').'">Courses</a>');
        }

        return array_reverse($data);
    }
}
