<?php
require '../config/app.php';

function query($query): array
{
    global $conn;
    if (!$conn) {
        return ['error' => 'Koneksi database tidak tersedia'];
    }

    $result = mysqli_query($conn, $query);
    if (!$result) {
        return ['error' => 'Query error: ' . mysqli_error($conn)];
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result))
        $rows[] = $row;

    return $rows;
}

function timeAgo($datetime, $full = false): string
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = date_diff($now, $ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}

function random_string($length = 8): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function updateProfil($data): int
{
    global $conn;

    $nama = $data['nama'];
    $username = $data['username'];
    $oldPassword = $data['oldPassword'];
    $newPassword = $data['newPassword'];
    $newPassword2 = $data['newPassword2'];

    $data = query("SELECT * FROM admin");
    if (count($data) < 1) return 'Data admin tidak ditemukan.';
    $data = $data[0];
    $id = $data['id'];

    if ($oldPassword !== '') {
        if (!password_verify($oldPassword, $data['password']))
            return 'Password lama tidak cocok';
        if ($newPassword == '' || $newPassword2 == '')
            return 'Password baru harap diisi.';
        if ($newPassword !== $newPassword2)
            return 'Password baru tidak sama dengan konfirmasi password.';
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET name = '$nama', username = '$username', password = '$hash' WHERE id = '$id'";
    } else $sql = "UPDATE admin SET name = '$nama', username = '$username' WHERE id = '$id'";

    if (!mysqli_query($conn, $sql)) return 'Database error!';
    return mysqli_affected_rows($conn);
}

function uploadFile($file): array|false
{
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
        return ['message' => 'Upload error', 'status' => false, 'data' => null];
        die;
    }

    return [
        'status' => true,
        'message' => 'Upload berhasil',
        'data' => [
            'filename' => $filename,
            'oldName' => $oldName,
            'mime' => $mime_type,
            'ext' => $ext,
            'size' => $size,
            'src' => $loc
        ]
    ];
}

/**
 * Fungsi include file
 * @param string $path Lokasi file view tanpa .php
 * @param array $data Array informasi yang dibutuhkan
 * @return string kode html
 */
function view(string $path, array $data = [])
{
    if (!file_exists($path)) die("file <code>$path</code> tidak ditemukan.");
    extract($data);
    include $path;
}

/**
 * Fungsi include file
 * @param string $headerPath Lokasi file header
 * @param array $data Data judul, css dan icon halaman 'title'|'style'|'favicon|body['className','id']|script'
 * ['title'=> string 'Judul Halaman']
 * ['style'=>array ['lokasi css','dst']]
 * ['favicon'=> string 'lokasi icon']
 * ['body'=>['className'=> 'nama class body', id=>'ID Body']]
 * ['script'=> array ['lokasi script','dst']]
 * @return string kode html
 */
function _renderHeader(string $headerPath, array $data = [])
{
    if (!file_exists($headerPath)) die("file <code>$headerPath</code> tidak ditemukan.");
    extract($data);
    include $headerPath;
}

function _renderFooter(string $footerPath, array $data = [])
{
    if (!file_exists($footerPath)) die("file <code>$footerPath</code> tidak ditemukan.");
    extract($data);
    include $headerPath;
}
