<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';
$db = new DBBuilder();
$table = $db->table('heroes');

global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $table->select(['hero_id as id', 'content', 'updated_at', 'created_at'])->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $data = $table->where('heros_id', $id)->first();
            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
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
            } while ($table->where('hero_id', $unique)->first());
            $set['hero_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $table->where('hero_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan.']);
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
            'message' => 'Heroes berhasil disimpan.',
            'data' => [
                'id' => $unique,
            ]
        ];

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
