<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die('Aksess Denied!');

header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$response = [
    'info' => count(query("SELECT * FROM informasi")),
];

echo json_encode($response);
