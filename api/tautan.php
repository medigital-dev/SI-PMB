<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('tautan');
$db->addIndex('tautan_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db->select('tautan_id as id, created_at as tanggal, title, url, aktif, on_menu, updated_at')
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $db->select('tautan_id as id, created_at as tanggal, title, url, aktif, on_menu, updated_at')
                ->where('tautan_id', $id)->first();
            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data tautan tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();

        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->where('tautan_id', $unique)->first());
            $set['tautan_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('tautan_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tautan tidak ditemukan.']);
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
            'message' => 'Tautan berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
            ]
        ];
        http_response_code(200);

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
            echo json_encode(['message' => 'Data tautan gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data tautan berhasil dihapus permanen.',
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
