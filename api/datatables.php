<?php
header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        $id = $_GET('id');
        break;

    case 'POST':
        # code...
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
