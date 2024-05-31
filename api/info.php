<?php
header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT info_id as id, created_at, judul, isi FROM informasi ORDER BY created_at DESC";
            $result = query($sql);
            echo json_encode($result);
        } else {
            $sql = "SELECT info_id as id, created_at, judul, isi FROM informasi WHERE info_id = '$id'";
            $query = query($sql);
            if ($query) {
                echo json_encode($query);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Item not found']);
            }
        }
        break;

    case 'POST':
        $judul = isset($_POST['judul']) ? $_POST['judul'] : null;
        $isi = isset($_POST['isi']) ? $_POST['isi'] : null;
        $delete = isset($_POST['delete']) ? true : false;
        $tabel = isset($_POST['getTable']) ? true : false;
        $timestamp = date('Y-m-d H:i:s', time());

        if ($id == null) {
            if ($tabel) {
                $sql = "SELECT info_id as id, created_at, judul, isi FROM informasi ORDER BY created_at DESC";
                $result = query($sql);
                $res = [];
                $no = 1;
                foreach ($result as $row) {
                    $temp = [
                        'no' => $no++,
                        'tanggal' => date('d-m-Y H:i:s', strtotime($row['created_at'])) . ' WIB',
                        'isi' => '<h5 class="m-0">' . $row['judul'] . '</h5><p class="m-0">' . $row['isi'] . '</p>',
                        'aksi' => '
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary btnEditInfo" data-id="' . $row['id'] . '"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger btnHapusInfo" data-id="' . $row['id'] . '"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        '
                    ];
                    array_push($res, $temp);
                }
                echo json_encode($res);
                die;
            } else {
                do {
                    $unique = random_string();
                } while (count(query("SELECT * FROM informasi WHERE info_id = '$unique'")) > 0);

                $sql = "INSERT INTO informasi VALUES (NULL, '$unique', '$timestamp', '$judul', '$isi')";
                $message = 'Informasi berhasil ditambahkan.';
                $data = [
                    'info_id' => $unique,
                    'created' => $timestamp,
                    'judul' => $judul,
                    'isi' => $isi
                ];
            }
        } else {
            if ($delete) {
                $sql = "DELETE FROM informasi WHERE info_id = '$id'";
                $message = 'Informasi berhasil dihapus permanen.';
                $data = ['id' => $id];
            } else {
                $sql = "UPDATE informasi SET judul = '$judul', isi = '$isi' WHERE info_id = '$id'";
                $message = 'Informasi berhasil diperbaharui.';
                $data = [
                    'info_id' => $id,
                    'created' => $timestamp,
                    'judul' => $judul,
                    'isi' => $isi
                ];
            }
        }

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error.', 'error' => mysqli_error($conn)]);
            die;
        }
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data
        ];
        http_response_code(200);
        echo json_encode($response);

        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
