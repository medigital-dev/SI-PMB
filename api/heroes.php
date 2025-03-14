<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include '../core/functions.php';
include '../auth/filter.php';

global $conn;
$tableName = 'heroes';
$primaryKey = 'hero_id';

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = db_get($tableName, ['select' => ["$primaryKey as id", 'content', 'updated_at']]);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = db_get($tableName, [$primaryKey => $id]);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data logo tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $content = $_POST['content'] ?? null;
        $timestamp = date('Y-m-d H:i:s');

        if (!$content) {
            http_response_code(400);
            echo json_encode(['message' => 'Konten heros wajib diisi', 'status' => false]);
            die;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while (db_get($tableName, ['where' => [$primaryKey => $unique]]) != null);

            $result = db_save($tableName, ['set' => [$primaryKey => $unique, 'content' => $content, 'updated_at' => $timestamp]]);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Heroes berhasil disimpan.',
                'data' => [
                    'id' => $unique,
                ]
            ];
            http_response_code(201);
        } else {
            $result = db_save($tableName, ['set' => ['content' => $content, 'updated_at' => $timestamp], 'where' => [$primaryKey => $id]]);
            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Heroes berhasil diperbaharui.',
                'data' => ['id' => $id]
            ];
        }

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
