<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../core/functions.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('admin');

$method = $_SERVER['REQUEST_METHOD'];

$key = $_GET['key'] ?? null;
$by = $_GET['by'] ?? null;
$type = $_GET['type'] ?? null;

switch ($method) {
    case 'GET':
        if ($by === 'id' || $by === 'username') {
            $column = $by === 'id' ? 'id' : 'username';
            $data = $db->select('username, password, name, created_at as tanggal')
                ->where($column, $key)
                ->first();

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
            exit;
        }

        $result = $db->select('username, password, name, created_at as tanggal')->findAll();
        echo json_encode($result, JSON_PRETTY_PRINT);
        break;

    case 'POST':
        $username = $_POST["username"] ?? '';
        $password = $_POST["password"] ?? '';
        $remember = $_POST['remember'] ?? null;
        $name = $_POST['name'] ?? null;

        if ($type == 'login') {
            $result = $db->where('username', $username)->first();

            if ($result) {
                if (password_verify($password, $result["password"])) {
                    $_SESSION["login"] = true;
                    $_SESSION['user'] = [
                        'username' => $result['username'],
                        'name' => $result['name'],
                    ];

                    if ($remember) {
                        setcookie('id', $result['id'], time() + 1440);
                        setcookie('key', hash('sha384', $result['username']), time() + 1440);
                    }
                    echo json_encode(1, JSON_PRETTY_PRINT);
                } else {
                    http_response_code(401);
                    echo json_encode(['message' => 'Password salah.'], JSON_PRETTY_PRINT);
                }
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Username: <strong>' . $username . '</strong> tidak ditemukan.'], JSON_PRETTY_PRINT);
            }
        } else if ($type == 'registrasi') {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $timestamp = date('Y-m-d H:i:s');

            $result = $db->set(['username' => $username, 'password' => $password, 'name' => $name, 'created_at' => $timestamp])->insert();
            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Admin berhasil ditambahkan.',
                'data' => [
                    'username' => $username,
                ]
            ];
            http_response_code(201);
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else if ($type == 'update') {
            requireLogin();

            $data = $db->where('id', $key)->first();
            if (!$data) {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
            $username = $_POST['username'];
            $name = $_POST['name'];
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPassword2 = $_POST['newPassword2'];

            $set['id'] = $key;
            $set['username'] = $username;
            $set['name'] = $name;

            if ($oldPassword !== '') {
                if (password_verify($oldPassword, $data['password'])) {
                    if ($newPassword == $newPassword2) {
                        $set['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Konfirmasi password tidak sama.']);
                        die;
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Password lama tidak sesuai.']);
                    die;
                }
            }

            if (!$db->save($set)) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => $db->getLastError()]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Profil admin berhasil disimpan.',
                'data' => [
                    'username' => $username,
                    'affected' => $db->getAffectedRows(),
                ]
            ];

            http_response_code(201);
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Tipe post tidak ditemukan.']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
