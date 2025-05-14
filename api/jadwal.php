<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('jadwal');
$db->addIndex('jadwal_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db
                ->select(["jadwal_id as id", 'title', 'content', 'created_at as tanggal', 'aktif', 'updated_at'])
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db
                ->select(["jadwal_id as id", 'title', 'content', 'created_at as tanggal', 'aktif', 'updated_at'])
                ->find($id);

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
        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->find($unique));
            $set['jadwal_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->find($id);
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan.']);
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
            'message' => 'Jadwal berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
            ]
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

        $result = $db->delete($id);

        if (!$result) {
            http_response_code(404);
            echo json_encode(['message' => 'Data jadwal pelaksanaan gagal dihapus.']);
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
