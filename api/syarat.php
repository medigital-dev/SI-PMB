<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$builder = new DBBuilder();
$model = $builder->table('syarat');

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $model->select(['syarat_id as id', 'content', 'created_at', 'updated_at'])->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $result = $model->select(['syarat_id as id', 'content', 'created_at', 'updated_at'])
                ->where('syarat_id', $id)
                ->first();
            if ($result) {
                echo json_encode($result, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data jalur tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $content = $_POST['content'] ?? null;
        $timestamp = date('Y-m-d H:i:s');

        if (!$content) {
            http_response_code(400);
            echo json_encode(['message' => 'Konten syarat pendaftaran wajib diisi', 'status' => false]);
            die;
        }

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($model->where('syarat_id', $unique)->first());

            $result = $model->insert(['syarat_id' => $unique, 'content' => $content]);
            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Syarat pendaftaran berhasil disimpan.',
                'data' => [
                    'id' => $unique,
                ]
            ];
            http_response_code(201);
        } else {
            $result = $model
                ->set(['content' => $content, 'updated_at' => $timestamp])
                ->where('syarat_id', $id)
                ->update();

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Syarat pendaftaran berhasil diperbaharui.',
                'data' => ['id' => $id]
            ];
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
