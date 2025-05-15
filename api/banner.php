<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('banner');
$db->addIndex('banner_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db
                ->select('banner_id as id, title, description, created_at as tanggal, berkas_id')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db
                ->select('banner_id as id, title, description, created_at as tanggal, berkas_id')
                ->where('banner_id', $id)
                ->first();
            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->where('banner_id', $unique)->first());
            $set['banner_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('banner_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
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
            'message' => 'Banner berhasil disimpan.',
            'data' => ['id' => $id]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'DELETE':
        requireLogin();
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }
        $data = $db->where('banner_id', $id)->first();
        if (!$data) {
            http_response_code(404);
            echo json_encode(['message' => 'Item not found']);
            die;
        }

        if (!$db->delete($data['id'])) {
            http_response_code(404);
            echo json_encode(['message' => 'Data banner gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Banner berhasil dihapus permanen.',
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
