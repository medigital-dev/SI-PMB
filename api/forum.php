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
            $sql = "SELECT forum_id as id, parent_id as parent, nama, isi, aktif, created_at as tanggal, dibaca FROM forum ORDER BY dibaca asc, created_at DESC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT forum_id as id, parent_id as parent, nama, isi, aktif, created_at as tanggal, dibaca FROM forum WHERE forum_id = ?";
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

    case 'POST':
        requireLogin();

        $parent = $_POST['parent_id'] ?? null;
        $nama = $_POST['nama'] ?? null;
        $isi = $_POST['isi'] ?? null;
        $aktif = $_POST['aktif'] ?? null;
        $dibaca = $_POST['dibaca'] ?? null;

        if ($id == null) {
            if (!$nama || !$isi) {
                http_response_code(400);
                echo json_encode(['message' => 'Nama dan isi tidak boleh kosong.']);
                die;
            }

            $timestamp = date('Y-m-d H:i:s');
            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM forum WHERE forum_id = '$unique'")) > 0);

            $sql = "INSERT INTO forum (forum_id, parent_id, nama, isi, aktif, created_at, dibaca) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $unique, $parent, $nama, $isi, $aktif, $timestamp, $dibaca);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => [
                    'id' => $unique,
                ]
            ];
            http_response_code(201);
        } else {
            $updates = [];
            $params = [];
            $types = "";

            if ($parent !== null) {
                $updates[] = "parent_id = ?";
                $params[] = $parent;
                $types .= "s";
            }

            if ($nama !== null) {
                $updates[] = "nama = ?";
                $params[] = $nama;
                $types .= "s";
            }

            if ($isi !== null) {
                $updates[] = "isi = ?";
                $params[] = $isi == 'true' ? 1 : 0;
                $types .= "s";
            }

            if ($aktif !== null) {
                $updates[] = "aktif = ?";
                $params[] = $aktif == 'true' ? 1 : 0;
                $types .= "i";
            }

            if ($dibaca !== null) {
                $updates[] = "dibaca = ?";
                $params[] = $dibaca;
                $types .= "i";
            }

            if (empty($updates)) {
                http_response_code(400);
                echo json_encode(['message' => 'Tidak ada data yang diperbarui.']);
                die;
            }

            $sql = "UPDATE forum SET " . implode(", ", $updates) . " WHERE forum_id = ?";
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
                'message' => 'Data forum berhasil diperbarui.',
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

        $sql = "DELETE FROM forum WHERE forum_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

        if (!$result || mysqli_affected_rows($conn) == 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Data tautan tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $sql = "DELETE FROM forum WHERE parent_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

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
