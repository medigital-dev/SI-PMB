<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$model = new DBBuilder('jalur');
$model->addIndex('jalur_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $model
                ->select(['jalur_id as id', 'nama', 'persen', 'jumlah'])
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $result = $model
                ->select(['jalur_id as id', 'nama', 'persen', 'jumlah'])
                ->where('jalur_id', $id)
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
        $set = $_POST;

        if ($id == null) {
            do {
                $unique = random_string();
            } while ($model->where('jalur_id', $unique)->first());
            $set['jalur_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $model->where('jalur_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data jalur tidak ditemukan.']);
                die;
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = date('Y-m-d H:i:s');
        }

        $result = $model->save($set);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $model->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Jalur pendaftaran berhasil disimpan.',
            'data' => [
                'id' => $unique,
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

        $result = $model->delete($id);

        if (!$result) {
            http_response_code(404);
            echo json_encode(['message' => 'Data jalur pendaftaran gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data jalur pendaftaran berhasil dihapus permanen.',
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
