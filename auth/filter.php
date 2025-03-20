<?php
include '../core/functions.php';

global $conn;

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

if (!function_exists('validateApiKey')) {
    function validateApiKey()
    {
        $headers = getallheaders();
        if (!isset($headers['X-API-KEY']) || $headers['X-API-KEY'] !== API_KEY) {
            http_response_code(403);
            echo json_encode(['message' => 'Unauthorized']);
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

if (!function_exists('validateToken')) {
    function validateToken()
    {
        global $public_methods;

        // Jika metode HTTP ada di daftar public, izinkan akses tanpa token
        if (in_array($_SERVER['REQUEST_METHOD'], $public_methods)) {
            return null;
        }

        $token = getBearerToken();
        if (!$token) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized - Token missing']);
            exit;
        }

        global $conn;
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM sessions WHERE token = ? AND expires_at > NOW()");
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized - Invalid token']);
            exit;
        }

        return $user['user_id']; // Kembalikan ID user yang login
    }
}
