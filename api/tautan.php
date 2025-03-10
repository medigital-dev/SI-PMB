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
            $sql = "SELECT tautan_id as id, created_at as tanggal, title, url, aktif, on_menu, urutan FROM tautan ORDER BY urutan ASC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT tautan_id as id, created_at as tanggal, title, url, aktif, on_menu, urutan FROM tautan WHERE tautan_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($query);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data tautan tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        requireLogin();
        $data = query("SELECT * FROM tautan");
        $jumlahData = count($data);

        $title = $_POST['title'] ?? null;
        $url = $_POST['url'] ?? null;
        $aktif = $_POST['aktif'] ?? true;
        $on_menu = $_POST['on_menu'] ?? null;
        $urutan = $_POST['urutan'] ?? null;

        if ($id == null) {
            if (!$title || !$url) {
                http_response_code(400);
                echo json_encode(['message' => 'Judul dan alamat url tidak boleh kosong.']);
                die;
            }

            $timestamp = date('Y-m-d H:i:s');
            $urutan = $jumlahData + 1;

            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM tautan WHERE tautan_id = '$unique'")) > 0);

            $sql = "INSERT INTO tautan (tautan_id, title, `url`, aktif, on_menu, urutan, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $unique, $title, $url, $aktif, $on_menu, $urutan, $timestamp);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Tautan berhasil ditambahkan.',
                'data' => [
                    'id' => $unique,
                    'title' => $title,
                    'url' => $url,
                ]
            ];
            http_response_code(201);
        } else {
            $updates = [];
            $params = [];
            $types = "";

            if ($title !== null) {
                $updates[] = "title = ?";
                $params[] = $title;
                $types .= "s";
            }

            if ($url !== null) {
                $updates[] = "url = ?";
                $params[] = $url;
                $types .= "s";
            }

            if ($aktif !== null) {
                $updates[] = "aktif = ?";
                $params[] = $aktif == 'true' ? 1 : 0;
                $types .= "s";
            }

            if ($on_menu !== null) {
                $updates[] = "on_menu = ?";
                $params[] = $on_menu == 'true' ? 1 : 0;
                $types .= "i";
            }

            if ($urutan !== null) {
                $updates[] = "urutan = ?";
                $params[] = $urutan;
                $types .= "i";
            }

            if (empty($updates)) {
                http_response_code(400);
                echo json_encode(['message' => 'Tidak ada data yang diperbarui.']);
                die;
            }

            $sql = "UPDATE tautan SET " . implode(", ", $updates) . " WHERE tautan_id = ?";
            $params[] = $id;
            $types .= "s";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Daftar tautan berhasil diperbarui.',
                'data' => ['id' => $id]
            ];
            http_response_code(200);
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

        $sql = "DELETE FROM tautan WHERE tautan_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

        if (!$result || mysqli_affected_rows($conn) == 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Data tautan tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Data tautan berhasil dihapus permanen.',
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
