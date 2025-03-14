<?php

require_once 'config.php';

$server   = DB_SERVER;
$user     = DB_USER;
$pass     = DB_PASSWORD;
$database = DB_NAME;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($server, $user, $pass, $database);
} catch (Exception $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}
