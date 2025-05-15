<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('dokumen');
$db->addIndex('dokumen_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db->select(['dokumen_id as id', 'content', 'created_at', 'updated_at'])
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $result = $db->select(['dokumen_id as id', 'content', 'created_at', 'updated_at'])
                ->where('dokumen_id', $id)
                ->first();
            if ($result) {
                echo json_encode($result, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($db->where('dokumen_id', $unique)->first());
            $set['dokument_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('dokument_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan.']);
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
            'message' => 'Dokumen kelengkapan pendaftaran berhasil disimpan.',
            'data' => [
                'id' => $unique,
            ]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
