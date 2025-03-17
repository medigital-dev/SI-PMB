<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$builder = new DBBuilder();
$model = $builder->table('jalur');

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $model
                ->select(['jalur_id as id', 'nama', 'persen', 'jumlah'])
                ->findAll();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $result = $model->select('jalur_id as id, nama, persen, jumlah')
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
        $nama = $_POST['nama'] ?? null;
        $persen = $_POST['persen'] ?? null;
        $jumlah = $_POST['jumlah'] ?? null;

        if (!$nama || !$persen || !$jumlah) {
            http_response_code(400);
            echo json_encode(['message' => 'Nama, Persentase dan Jumlah dari setiap jalur wajib diisi', 'status' => false]);
            die;
        }

        if ($id == null) {
            $timestamp = date('Y-m-d H:i:s');

            do {
                $unique = random_string();
            } while ($model->where('jalur_id', $id)->first());

            $result = $model->set(['jalur_id' => $unique, 'nama' => $nama, 'persen' => $persen, 'jumlah' => $jumlah, 'created_at' => $timestamp])->insert();
            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Jalur pendaftaran berhasil disimpan.',
                'data' => [
                    'id' => $unique,
                ]
            ];
            http_response_code(201);
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'DELETE':
        requireLogin();
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $result = $model->where('jalur_id', $id)->delete();

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
