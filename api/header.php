<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$table = new DBBuilder('header');
$table->addIndex('header_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $table->select(['header_id as id', 'isi', 'updated_at'])->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $table->where('header_id', $id)->first();
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

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($table->where('header_id', $unique)->first());
            $set['header_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $table->where('header_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data logo tidak ditemukan.']);
                die;
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = date('Y-m-d H:i:s');
            http_response_code(200);
        }

        $result = $table->save($set);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $table->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Header berhasil disimpan.',
            'data' => ['id' => $id]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
