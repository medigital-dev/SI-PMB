<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('event');
$db->addIndex('event_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db
                ->select('event_id as id, tanggal, status, name, created_at')
                ->orderBy('created_at')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db
                ->select('event_id as id, tanggal, status, name, created_at')
                ->where('event_id', $id)
                ->first();
            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
        }
        break;

    case 'DELETE':
        requireLogin();
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $data = $db->where('event_id', $id)
            ->first();
        if (!$data) {
            http_response_code(404);
            echo json_encode(['message' => 'Data tidak ditemukan.']);
            die;
        }

        if (!$db->delete($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Data gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Event berhasil dihapus permanen.',
            'data' => ['id' => $id]
        ];

        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT);

        break;

    case 'POST':
        requireLogin();
        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->where('event_id', $id)->first());
            $set['event_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('event_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan.']);
                die;
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = date('Y-m-d H:i:s');
            http_response_code(200);
        }

        if (!$db->save($set)) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Event berhasil diperbarui.',
            'data' => [
                'id' => $id ?? $unique,
            ]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
