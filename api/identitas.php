<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$builder = new DBBuilder();
$model = $builder->table('identitas');

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $model->select([
                'identitas_id as id',
                'nama',
                'alamat',
                'telepon',
                'email',
                'website',
                'facebook',
                'instagram',
                'tiktok',
                'youtube',
                'whatsapp',
                'telegram',
                'x',
                'maps',
                'threads',
            ])
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $result = $model->select([
                'identitas_id as id',
                'nama',
                'alamat',
                'telepon',
                'email',
                'website',
                'facebook',
                'instagram',
                'tiktok',
                'youtube',
                'whatsapp',
                'telegram',
                'x',
                'maps',
                'threads',
            ])
                ->where('dokumen_id', $id)
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
        $set = $_POST ?? null;

        if (!$id) {
            do {
                $unique = random_string();
            } while ($model->where('identitas_id', $unique)->first());
            $set['identitas_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $model->where('identitas_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Data jalur tidak ditemukan.']);
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = date('Y-m-d H:i:s');
            http_response_code(200);
        }

        $result = $model->set($set)->save();
        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data identitas sekolah berhasil disimpan.',
            'data' => [
                'identitas_id' => $unique,
            ]
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
        break;
}
