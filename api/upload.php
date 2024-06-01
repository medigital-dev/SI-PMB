<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die('Aksess Denied!');

header('Content-Type: application/json; charset=utf-8');

include '../functions.php';
global $conn;

$dir = './files/';
if (!file_exists($dir))
    mkdir($dir, 0777);

$file = $_FILES['file'];
$filename = $file['name'];
$path = $dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $path)) {
    http_response_code(500);
    echo json_encode(['message' => 'Upload error']);
    die;
}
