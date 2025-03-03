<?php
header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT berkas_id as id, created_at as tanggal, filename, title, type, src, size FROM berkas ORDER BY created_at DESC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT berkas_id as id, created_at as tanggal, filename, title, type, src, size FROM berkas WHERE berkas_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($query);

            if ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Berkas tidak ditemukan']);
            }
        }
        break;

    case 'POST':
        $title = $_POST['title'] ?? null;
        $file = $_FILES['file'] ?? null;
        $timestamp = date('Y-m-d H:i:s');

        if ($id == null) {
            if (!$file) {
                http_response_code(400);
                echo json_encode(['message' => 'File tidak ditemukan', 'status' => false]);
                die;
            }

            $oldName = $file['name'];
            $mime_type = mime_content_type($file['tmp_name']);
            $ext = strtolower(pathinfo($oldName, PATHINFO_EXTENSION));
            $size = $file['size'];

            $filename = date('ymd-') . strtolower(random_string(8)) . '.' . $ext;
            $dir = '../uploads/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                chmod($dir, 0777);
            }

            $path = $dir . $filename;
            $loc = './uploads/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $path)) {
                http_response_code(500);
                echo json_encode(['message' => 'Upload error', 'status' => false]);
                die;
            }

            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM berkas WHERE berkas_id = '$unique'")) > 0);

            $sql = "INSERT INTO berkas (berkas_id, filename, title, src, created_at, type, size) 
                    VALUES (?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $unique, $filename, $title, $loc, $timestamp, $mime_type, $size);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Berkas berhasil ditambahkan.',
                'data' => [
                    'id' => $unique,
                    'type' => $mime_type,
                    'ext' => $ext,
                    'size' => $size,
                    'src' => $loc,
                    'filename' => $filename,
                    'title' => $title
                ]
            ];
            http_response_code(201);
        } else {
            $sql = "UPDATE berkas SET title = ? WHERE berkas_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $title, $id);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Berkas berhasil diperbaharui.',
                'data' => ['id' => $id]
            ];
        }

        echo json_encode($response);
        break;

    case 'DELETE':
        if ($id == null) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong']);
            die;
        }

        $dataDeleted = query("SELECT * FROM berkas WHERE berkas_id = '$id'");

        if (!$dataDeleted) {
            http_response_code(404);
            echo json_encode(['message' => 'Berkas tidak ditemukan']);
            die;
        }

        // Hapus file dari folder
        $filePath = str_replace('./', '../', $dataDeleted[0]['src']);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        $sql = "DELETE FROM berkas WHERE berkas_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Berkas berhasil dihapus permanen.',
            'data' => ['id' => $id]
        ];

        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
