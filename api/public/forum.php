<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
include '../../core/functions.php';

global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT forum_id as id, parent_id as parent, nama, isi, aktif, created_at as tanggal, dibaca FROM forum WHERE parent_id IS NULL ORDER BY created_at DESC";
            $result = query($sql);
            $response = [];
            foreach ($result as $row) {
                $parent = $row['id'];
                $child = query("SELECT * FROM forum WHERE parent_id = '$parent'");
                $row['balasan'] = count($child);
                $response[] = $row;
            }
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
