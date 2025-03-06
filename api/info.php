<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include '../core/functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT info_id as id, created_at as tanggal, judul, isi FROM informasi ORDER BY created_at DESC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT info_id as id, created_at as tanggal, judul, isi FROM informasi WHERE info_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($query);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Data informasi tidak ditemukan.']);
            }
        }
        break;

    case 'POST':
        $judul = $_POST['judul'] ?? null;
        $isi = $_POST['isi'] ?? null;

        if (!$judul || !$isi) {
            http_response_code(400);
            echo json_encode(['message' => 'Judul dan isi tidak boleh kosong.']);
            die;
        }

        if ($id && $id !== '') {
            $sql = "UPDATE informasi SET judul = ?, isi = ? WHERE info_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $judul, $isi, $id);
            $result = mysqli_stmt_execute($stmt);

            if (!$result || mysqli_affected_rows($conn) == 0) {
                http_response_code(404);
                echo json_encode(['message' => 'Data tidak ditemukan atau gagal diperbarui.']);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Informasi berhasil diperbarui.',
                'data' => [
                    'info_id' => $id,
                    'judul' => $judul,
                    'isi' => $isi
                ]
            ];
            http_response_code(200);
        } else {
            $timestamp = date('Y-m-d H:i:s');

            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM informasi WHERE info_id = '$unique'")) > 0);

            $sql = "INSERT INTO informasi (info_id, created_at, judul, isi) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $unique, $timestamp, $judul, $isi);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Informasi berhasil ditambahkan.',
                'data' => [
                    'info_id' => $unique,
                    'created' => $timestamp,
                    'judul' => $judul,
                    'isi' => $isi
                ]
            ];
            http_response_code(201);
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $sql = "DELETE FROM informasi WHERE info_id = ?";
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
            'message' => 'Informasi berhasil dihapus permanen.',
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
