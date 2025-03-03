<?php
header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT banner_id as id, title, `description`, `order`, created_at as tanggal, berkas_id FROM banner ORDER BY `order` ASC";
            $result = query($sql);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            $sql = "SELECT banner_id as id, title, `description`, `order`, created_at as tanggal, berkas_id FROM banner WHERE banner_id = ?";
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
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $idBerkas = $_POST['idBerkas'] ?? null;
        $order = $_POST['order'] ?? null;
        $dataBanner = query("SELECT * FROM BANNER");
        $jumlahBanner = count($dataBanner);
        $urutan = $jumlahBanner + 1;

        if (!$title) {
            http_response_code(400);
            echo json_encode(['message' => 'Judul dan Deskripsi tidak boleh kosong.']);
            die;
        }

        if ($id == null) {
            $timestamp = date('Y-m-d H:i:s');
            do {
                $unique = random_string();
            } while (count(query("SELECT * FROM banner WHERE banner_id = '$unique'")) > 0);

            $sql = "INSERT INTO banner (banner_id, title, `description`, `order`, created_at, berkas_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $unique, $title, $description, $urutan, $timestamp, $idBerkas);
            $result = mysqli_stmt_execute($stmt);

            if (!$result) {
                http_response_code(500);
                echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
                die;
            }

            $response = [
                'status' => true,
                'message' => 'Banner berhasil ditambahkan.',
                'data' => [
                    'id' => $unique,
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

            if ($description !== null) {
                $updates[] = "description = ?";
                $params[] = $description;
                $types .= "s";
            }

            if ($idBerkas !== null) {
                $updates[] = "berkas_id = ?";
                $params[] = $idBerkas;
                $types .= "s";
            }

            if ($order !== null) {
                $updates[] = "`order` = ?";
                $params[] = $order;
                $types .= "i";
            }

            if (empty($updates)) {
                http_response_code(400);
                echo json_encode(['message' => 'Tidak ada data yang diperbarui.']);
                die;
            }

            $sql = "UPDATE banner SET " . implode(", ", $updates) . " WHERE banner_id = ?";
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
                'message' => 'Banner berhasil diperbarui.',
                'data' => ['id' => $id]
            ];
            http_response_code(200);
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak boleh kosong.']);
            die;
        }

        $sql = "DELETE FROM banner WHERE banner_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        $result = mysqli_stmt_execute($stmt);

        if (!$result || mysqli_affected_rows($conn) == 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Data banner tidak ditemukan atau gagal dihapus.']);
            die;
        }

        $response = [
            'status' => true,
            'message' => 'Banner berhasil dihapus permanen.',
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
