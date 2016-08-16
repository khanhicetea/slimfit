<?php

if (!function_exists('app')) {
    function app(string $key = null) {
        return App\SlimFit::getKey($key);
    }
}

if (!function_exists('app_path')) {
    function app_path($path = null) {
        return realpath(app('app_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = null) {
        return realpath(app('storage_path').'/'.ltrim($path, '/'));
    }
}

if (!function_exists('public_path')) {
    function public_path($path = null) {
        return realpath(app('public_path').'/'.ltrim($path, '/'));
    }
}
