<?php

if (!function_exists('grunt_asset')) {

    function grunt_asset($path, $secure = null)
    {
        static $publishPath = null;

        if (null === $publishPath) {
            $publishPath = Config::get('laravel-grunt::publish_path');
        }

        $path = $publishPath . '/' . ltrim($path, '/');

        return asset($path, $secure);
    }

}
