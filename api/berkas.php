<?php
header('Content-Type: application/json; charset=utf-8');
include '../functions.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? $_GET['id'] : null;
$dataDeleted = false;

switch ($method) {
    case 'GET':
        if ($id == null) {
            $sql = "SELECT berkas_id as id, created_at, filename, src FROM berkas ORDER BY created_at DESC";
            $result = query($sql);
            echo json_encode($result);
        } else {
            $sql = "SELECT berkas_id as id, created_at, filename, src FROM berkas WHERE info_id = '$id'";
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
        $delete = isset($_POST['delete']) ? true : false;
        $tabel = isset($_POST['getTable']) ? true : false;
        $time = date('Y-m-d H:i:s', time());

        if ($id == null) {
            if ($tabel) {
                $type = $_POST['type'];
                $sql = "SELECT berkas_id as id, created_at, title, filename, src FROM berkas WHERE type = '$type' ORDER BY created_at DESC";
                $result = query($sql);
                $res = [];
                $no = 1;
                foreach ($result as $row) {
                    $temp = [
                        'no' => $no++,
                        'tanggal' => date('d-m-Y H:i:s', strtotime($row['created_at'])) . ' WIB',
                        'filename' => $row['filename'],
                        'judul' => $row['title'],
                        'src' => $row['src'],
                        'preview' => '
                            <a href="' . $row['src'] . '" data-fancybox>
                                <img class="img-thumbnail" width="" src="' . $row['src'] . '">
                            </a>
                        ',
                        'aksi' => '
                            <div class="btn-group btn-group-sm">
                                <a href="' . $row['src'] . '" class="btn btn-primary" target="_blank"><i class="bi bi-download"></i></a>
                                <button type="button" class="btn btn-danger btnHapusBerkas" data-id="' . $row['id'] . '"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        '
                    ];
                    array_push($res, $temp);
                }
                echo json_encode($res);
                die;
            } else {
                $file = $_FILES['file'];
                $type = $_POST['type'];
                $title = $_POST['title'];
                $filename = str_replace(' ', '_', $file['name']);
                $newName = random_string(4) . '-' . $filename;

                $dir = '../uploads/';
                if (!file_exists($dir))
                    mkdir($dir, 0777);
                $path = $dir . $newName;
                $loc = './uploads/' . $newName;

                if (!move_uploaded_file($file['tmp_name'], $path)) {
                    http_response_code(500);
                    echo json_encode(['message' => 'Upload error', 'status' => false]);
                    die;
                }

                do {
                    $unique = random_string();
                } while (count(query("SELECT * FROM berkas WHERE berkas_id = '$unique'")));

                $sql = "INSERT INTO berkas VALUE (null, '$unique', '$filename','$title', '$loc', '$type', '$time')";
                $response = [
                    'status' => true,
                    'message' => 'Berkas berhasil disimpan dalam database.',
                    'src' => $loc
                ];
            }
        } else {
            if ($delete) {
                $dataDeleted = query("SELECT * FROM berkas WHERE berkas_id = '$id'");
                $sql = "DELETE FROM berkas WHERE berkas_id = '$id'";
                $response = [
                    'status' => true,
                    'message' => 'Berkas berhasil dihapus permanen.',
                    'data' => ['id' => $id]
                ];
            } else {
                $sql = "UPDATE berkas SET filename = '$newName', src = '$loc' WHERE berkas_id = '$id'";
                $response = [
                    'status' => true,
                    'message' => 'Berkas berhasil diperbaharui.',
                    'data' => [
                        'info_id' => $id,
                        'created' => $timestamp,
                        'judul' => $judul,
                        'isi' => $isi
                    ]
                ];
            }
        }
        if (!mysqli_query($conn, $sql)) {
            http_response_code(500);
            echo json_encode(['message' => 'Database error', 'status' => false]);
            die;
        }
        if ($dataDeleted)
            unlink('.' . $dataDeleted[0]['src']);


        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
