<?php
date_default_timezone_set('Asia/Jakarta');

$server   = "localhost";
$user     = "root";
$pass     = "";
$database = "ppdb";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($server, $user, $pass, $database);
} catch (Exception $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}
