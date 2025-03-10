<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include '../core/functions.php';
include '../auth/filter.php';

global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT event_id as id, tanggal, `status`, `name`, created_at FROM `event` ORDER BY tanggal ASC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT event_id as id, tanggal, `status`, `name`, created_at FROM `event` WHERE event_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($query);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
        }
        break;

    case 'DELETE':
        requireLogin();
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $sql = "DELETE FROM `event` WHERE event_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

        if (!$result || mysqli_affected_rows($conn) == 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Data tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Event berhasil dihapus permanen.',
            'data' => ['id' => $id]
        ];
        http_response_code(200);
        echo json_encode($response, JSON_PRETTY_PRINT);

        break;

    case 'POST':
        requireLogin();
        $name = $_POST['name'] ?? null;
        $tanggal = $_POST['tanggal'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$name || !$tanggal) {
            http_response_code(400);
            echo json_encode(['message' => 'Nama dan tanggal event tidak boleh kosong.']);
            die;
        }

        if ($id && $id !== '') {
            $sql = "UPDATE `event` SET `name` = ?, tanggal = ?, `status` = ? WHERE event_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $tanggal, $status, $id);
            $result = mysqli_stmt_execute($stmt);

            if (!$result || mysqli_affected_rows($conn) == 0) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan atau gagal diperbarui.']);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Event berhasil diperbarui.',
                'data' => [
                    'id' => $id,
                    'name' => $name,
                    'tanggal' => $tanggal,
                    'status' => $status,
                ]
            ];
            http_response_code(200);
        } else {
            $timestamp = date('Y-m-d H:i:s');

            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM `event` WHERE event_id = '$unique'")) > 0);

            $sql = "INSERT INTO `event` (event_id, `name`, tanggal, `status`, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $unique, $name, $tanggal, $status, $timestamp);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Event berhasil ditambahkan.',
                'data' => [
                    'id' => $id,
                    'name' => $name,
                    'tanggal' => $tanggal,
                    'status' => $status,
                ]
            ];
            http_response_code(201);
        }

        echo json_encode($response, JSON_PRETTY_PRINT);

        break;

    default:
        # code...
        break;
}
