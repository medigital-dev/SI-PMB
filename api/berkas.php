<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('berkas');
$db->addIndex('berkas_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;
$status = $_GET['s'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $db->select('berkas_id as id, created_at as tanggal, filename, title, type, src, size, status');
            if ($status) $db->where('status', $status);
            $result = $db
                ->orderBy('created_at', 'DESC')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db
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
            $set['src'] = base_url($loc);
            $set['type'] = $mime_type;
            $set['size'] = $size;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->where('berkas_id', $unique)->first());
            $set['berkas_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('berkas_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Berkas tidak ditemukan']);
                die;
            }
            $set['id'] = $data['id'];
            http_response_code(200);
        }

        if (!$db->save($set)) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Berkas berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
            ]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'DELETE':
        requireLogin();
        if ($id == null) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong']);
            die;
        }
        $data = $db->where('berkas_id', $id)->first();
        if (!$data) {
            http_response_code(404);
            echo json_encode(['message' => 'Berkas tidak ditemukan']);
            die;
        }

        if (!$db->delete($data['id'])) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
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

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
