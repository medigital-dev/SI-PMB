<?php
require 'dbconn.php';

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
