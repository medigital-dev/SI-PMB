<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die('Aksess Denied!');

header('Content-Type: application/json; charset=utf-8');

include '../functions.php';
global $conn;

$dir = '../uploads/';
if (!file_exists($dir))
    mkdir($dir, 0777);

$file = $_FILES['file'];
$type = $_POST['type'];
$filename = $file['name'];
$newName = random_string(4) . '-' . $filename;
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
$time = date('Y-m-d H:i:s', time());
$sql = "INSERT INTO berkas VALUE (null, '$unique', '$filename', '$loc', '$type', '$time')";

if (!mysqli_query($conn, $sql)) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error', 'status' => false]);
    die;
} else echo json_encode(['status' => true, 'src' => $loc]);
