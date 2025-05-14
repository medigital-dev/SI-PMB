<?php

/**
 * environment
 * development|production|testing
 */
define('ENV', 'development');

/**
 * Set timezone
 */
date_default_timezone_set('Asia/Jakarta');

/**
 * Base URL
 */
define('BASE_URL', 'http://localhost/');
if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        $base = rtrim(BASE_URL, '/') . '/';
        if (strpos($path, $base) === 0) {
            return $path;
        }
        if (empty($path)) {
            return $base;
        }
        return $base . ltrim($path, '/');
    }
}

/**
 * Database config
 */
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ppdb');
