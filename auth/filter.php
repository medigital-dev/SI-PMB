<?php
include '../core/functions.php';

// Daftar metode yang bisa diakses tanpa token
$public_methods = ['GET'];  // Hanya GET yang bisa tanpa token

if (!function_exists('isLoggedIn')) {
    function isLoggedIn()
    {
        return isset($_SESSION["login"]) && $_SESSION["login"] === true;
    }
}

if (!function_exists('requireLogin')) {
    function requireLogin()
    {
        if (!isLoggedIn()) {
            http_response_code(403);
            echo json_encode(['message' => 'Unauthorized. Anda harus login untuk mengakses API ini.']);
            exit;
        }
    }
}

if (!function_exists('getBearerToken')) {
    function getBearerToken()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            return null;
        }
        list(, $token) = explode(" ", $headers['Authorization'], 2);
        return $token;
    }
}
