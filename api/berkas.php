<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
include '../core/functions.php';
include '../auth/filter.php';
include '../core/DBBuilder.php';
$db = new DBBuilder();
$table = $db->table('berkas');

global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
$status = isset($_GET['s']) ? mysqli_real_escape_string($conn, $_GET['s']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $table->select('berkas_id as id, created_at as tanggal, filename, title, type, src, size, status');
            if ($status) $table->where('status', $status);
            $result = $table
                ->orderBy('created_at', 'DESC')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $table
                ->select('berkas_id as id, created_at as tanggal, filename, title, type, src, size, status')
                ->where('berkas_id', $id)
                ->first();

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Berkas tidak ditemukan']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $set = $_POST;
        $file = $_FILES['file'] ?? null;

        if ($file) {
            $oldName = $file['name'];
            $mime_type = mime_content_type($file['tmp_name']);
            $ext = strtolower(pathinfo($oldName, PATHINFO_EXTENSION));
            $size = $file['size'];

            $filename = date('ymd-') . strtolower(random_string(8)) . '.' . $ext;
            $dir = '../uploads/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                chmod($dir, 0777);
            }

            $path = $dir . $filename;
            $loc = '/uploads/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $path)) {
                http_response_code(500);
                echo json_encode(['message' => 'Upload error', 'status' => false]);
                die;
            }
            $set['filename'] = $filename;
            $set['src'] = $loc;
            $set['type'] = $mime_type;
            $set['size'] = $size;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($table->where('berkas_id', $unique)->first());
            $set['berkas_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $table->where('berkas_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Berkas tidak ditemukan']);
                die;
            }
            $set['id'] = $data['id'];
            http_response_code(200);
        }

        if (!$table->save($set)) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $table->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Berkas berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
            ]
        ];

        echo json_encode($response);
        break;

    case 'DELETE':
        requireLogin();
        if ($id == null) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong']);
            die;
        }
        $data = $table->where('berkas_id', $id)->first();
        if (!$data) {
            http_response_code(404);
            echo json_encode(['message' => 'Berkas tidak ditemukan']);
            die;
        }

        if (!$table->delete($data['id'])) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
            die;
        }

        $filePath = '..' . $data['src'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $response = [
            'status' => true,
            'message' => 'Berkas berhasil dihapus permanen.',
            'data' => ['id' => $id]
        ];

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
