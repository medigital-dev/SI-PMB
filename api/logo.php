<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('logo');
$db->addIndex('logo_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db->select('logo_id as id, created_at as tanggal, src,type, updated_at')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db->select('logo_id as id, created_at as tanggal, src,type, updated_at')
                ->find($id);
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
        $set = $_POST;
        $file = $_FILES['file'];

        if ($file) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = 'logo-' . $type . '.' . $ext;
            $dir = '../assets/brand/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                chmod($dir, 0777);
            }

            $path = $dir . $filename;
            $loc = '/assets/brand/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $path)) {
                http_response_code(500);
                echo json_encode(['message' => 'Upload error', 'status' => false]);
                die;
            }
            $set['src'] = $loc;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->find($unique));
            $set['logo_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->find($id);
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data logo tidak ditemukan.']);
                die;
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = date('Y-m-d H:i:s');
            http_response_code(200);
        }

        $result = $db->save($set);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Logo berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
            ]
        ];

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
