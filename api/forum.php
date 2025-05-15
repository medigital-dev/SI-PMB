<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../core/functions.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('forum');
$db->addIndex('forum_id');

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $result = $db
                ->select('forum_id as id, parent_id as parent, nama, isi, aktif, created_at as tanggal, dibaca')
                ->where('parent_id', null)
                ->orderBy('created_at', 'DESC')
                ->findAll();
            $response = [];
            foreach ($result as $row) {
                $row['balasan'] = count($db->where('parent_id', $row['id'])->findAll());
                $response[] = $row;
            }

            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            $data = $db->where('forum_id', $id)->first();

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
        }
        break;

    case 'POST':
        $set = $_POST;
        $timestamp = date('Y-m-d H:i:s');

        if (!$id) {
            do {
                $unique = random_string();
            } while ($db->where('forum_id', $unique)->first());
            $set['forum_id'] = $unique;
            http_response_code(201);
        } else {
            $data = $db->where('forum_id', $id)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
            $set['id'] = $data['id'];
            $set['updated_at'] = $timestamp;
            http_response_code(200);
        }
        if (isset($set['parent_id']) && $set['parent_id'] !== null)
            $db->where('forum_id', $set['parent_id'])->set(['dibaca' => 0])->update();

        $result = $db->save($set);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data berhasil disimpan.',
            'data' => [
                'id' => $unique ?? $id,
                'parent' => $set['parent_id'] ?? null,
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

        $result = $db->where('forum_id', $id)->delete();

        if (!$result) {
            http_response_code(404);
            echo json_encode(['message' => 'Data tautan tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data forum berhasil dihapus permanen.',
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
