<?php

if (!function_exists('app')) {
    function app($key = null) {
        return $key ? App\SlimFit::getKey($key) : App\SlimFit::getInstance();
    }
}

if (!function_exists('app_path')) {
    function app_path($path = null) {
        return realpath(app('app_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('config_path')) {
    function config_path($path = null) {
        return realpath(app('config_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = null) {
        return realpath(app('storage_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('resources_path')) {
    function resources_path($path = null) {
        return realpath(app('resources_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('public_path')) {
    function public_path($path = null) {
        return realpath(app('public_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        $len = strlen($value);
        if ($len > 1 && ($value[0] == '"' && $value[$len - 1] == '"')) {
            return substr($value, 1, -1);
        }
        return $value;
    }
}
