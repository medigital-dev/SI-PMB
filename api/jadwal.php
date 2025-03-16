<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include '../core/functions.php';
include '../auth/filter.php';

global $conn;
$tableName = 'jadwal';
$primaryKey = 'jadwal_id';

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = db_get($tableName, ['select' => ["$primaryKey as id", 'title', 'content', 'created_at as tanggal', 'aktif']]);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = db_get($tableName, ['where' => [$primaryKey => $id], 'select' => ["$primaryKey as id", 'title', 'content', 'created_at as tanggal', 'aktif']], true);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data jadwal tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;
        $aktif = $_POST['aktif'] ?? null;
        $timestamp = date('Y-m-d H:i:s');

        if (!$content || !$title) {
            http_response_code(400);
            echo json_encode(['message' => 'Title dan content wajib diisi', 'status' => false]);
            die;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while (db_get($tableName, ['where' => [$primaryKey => $unique]]) != null);

            $result = db_save($tableName, ['set' => [$primaryKey => $unique, 'title' => $title, 'content' => $content, 'aktif' => $aktif, 'created_at' => $timestamp]]);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Jadwal berhasil disimpan.',
                'data' => [
                    'id' => $unique,
                ]
            ];
            http_response_code(201);
        } else {
            $result = db_save($tableName, ['set' => ['content' => $content, 'aktif' => $aktif, 'created_at' => $timestamp], 'where' => [$primaryKey => $id]]);
            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Jadwal pelaksanaan berhasil diperbaharui.',
                'data' => ['id' => $id]
            ];
        }

        echo json_encode($response);
        break;

    case 'DELETE':
        requireLogin();
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $result = db_delete($tableName, ['where' => [$primaryKey => $id]]);

        if (!$result || mysqli_affected_rows($conn) == 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Data jadwal pelaksanaan tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data jadwal pelaksanaan berhasil dihapus permanen.',
            'data' => ['id' => $id]
        ];

        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
