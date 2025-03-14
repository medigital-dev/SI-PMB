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
            $sql = "SELECT logo_id as id, created_at as tanggal, src, aktif, type FROM logo";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT logo_id as id, created_at as tanggal, src, aktif, type FROM logo WHERE info_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($query);

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
        $type = $_POST['type'] ?? null;
        $aktif = $_POST['aktif'] ?? null;
        $file = $_FILES['file'] ?? null;

        if (!$file || !$type) {
            http_response_code(400);
            echo json_encode(['message' => 'File dan teme harus ada', 'status' => false]);
            die;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'logo-' . $type . '.' . $ext;
        $dir = '../assets/brand/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $path = $dir . $filename;
        $loc = '/assets/brand/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $path)) {
            http_response_code(500);
            echo json_encode(['message' => 'Upload error', 'status' => false]);
            die;
        }

        if ($id == null) {
            $timestamp = date('Y-m-d H:i:s');

            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM logo WHERE logo_id = '$unique'")) > 0);

            $sql = "INSERT INTO logo (logo_id, src, type, aktif, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $unique, $loc, $type, $aktif, $timestamp);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Logo berhasil ditambahkan.',
                'data' => [
                    'id' => $unique,
                    'src' => $loc,
                    'filename' => $filename,
                ]
            ];
            http_response_code(201);
        } else {
            $sql = "UPDATE logo SET src = ?, type = ?, aktif = ? WHERE logo_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $loc, $type, $aktif, $id);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Logo berhasil diperbaharui.',
                'data' => ['id' => $id]
            ];
        }

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
