<?php
require_once 'dbconn.php';

if (!function_exists('query')) {
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
}

if (!function_exists('db_get')) {
    /**
     * @param string $table Nama Tabel
     * @param array $condition
     * string|array 'select'
     * string|array 'where'
     * string|array 'orderBy'
     * string|array 'join'
     */
    function db_get($table, array $condition = [], $returnRow = false)
    {
        global $conn;

        $primaryKey = get_primary_key($table);
        $select = '*';
        $where = '';
        $orderBy = '';
        $joins = '';

        if (isset($condition['select'])) {
            $select = is_array($condition['select']) ? implode(', ', $condition['select']) : $condition['select'];
        }

        if (isset($condition['where']) && is_array($condition['where'])) {
            $whereParts = [];
            foreach ($condition['where'] as $key => $value) {
                $whereParts[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
            }
            $where = " WHERE " . implode(' AND ', $whereParts);
        }

        if (isset($condition['orderBy'])) {
            if (is_array($condition['orderBy'])) {
                $orderByParts = [];
                foreach ($condition['orderBy'] as $column => $direction) {
                    $orderByParts[] = "$column $direction";
                }
                $orderBy = " ORDER BY " . implode(', ', $orderByParts);
            } else {
                $orderBy = " ORDER BY " . $condition['orderBy'];
            }
        }

        if (isset($condition['join'])) {
            if (isset($condition['join'][0]) && !is_array($condition['join'][0])) {
                $condition['join'] = [$condition['join']];
            }

            foreach ($condition['join'] as $join) {
                list($joinTable, $joinCondition, $joinType) = $join + [2 => 'INNER'];
                $joins .= " $joinType JOIN $joinTable ON $joinCondition";
            }
        }

        // Check if querying by primary key or forcing single row return
        if ($returnRow || ($primaryKey && isset($condition['where']) && count($condition['where']) === 1 && array_key_exists($primaryKey, $condition['where']))) {
            $sql = "SELECT $select FROM $table$joins$where$orderBy LIMIT 1";
            $result = mysqli_query($conn, $sql);
            return mysqli_fetch_assoc($result);
        }

        // Normal SELECT query
        $sql = "SELECT $select FROM $table$joins$where$orderBy";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_primary_key($table)
    {
        global $conn;
        $sql = "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['Column_name'];
        }
        return null;
    }
}

if (!function_exists('db_save')) {
    function db_save($table, array $condition)
    {
        global $conn;

        if (!isset($condition['set']) || !is_array($condition['set'])) {
            return false;
        }

        $setParts = [];
        foreach ($condition['set'] as $key => $value) {
            $setParts[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
        }
        $set = implode(', ', $setParts);

        if (isset($condition['where']) && is_array($condition['where']) && !empty($condition['where'])) {
            // UPDATE query
            $whereParts = [];
            foreach ($condition['where'] as $key => $value) {
                $whereParts[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
            }
            $where = " WHERE " . implode(' AND ', $whereParts);
            $sql = "UPDATE $table SET $set$where";
        } else {
            // INSERT query
            $columns = implode(', ', array_keys($condition['set']));
            $values = "'" . implode("', '", array_map(fn($v) => mysqli_real_escape_string($conn, $v), array_values($condition['set']))) . "'";
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        }

        return mysqli_query($conn, $sql);
    }
}

if (!function_exists('db_delete')) {
    function db_delete($table, $condition)
    {
        global $conn;

        if (!isset($condition['where']) || empty($condition['where'])) {
            return "Error: WHERE condition is required for DELETE";
        }

        $whereParts = [];
        foreach ($condition['where'] as $key => $value) {
            $whereParts[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
        }
        $where = " WHERE " . implode(' AND ', $whereParts);

        $sql = "DELETE FROM $table$where";

        return mysqli_query($conn, $sql) ? true : "Error: " . mysqli_error($conn);
    }
}

if (!function_exists('timeAgo')) {
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
}

if (!function_exists('random_string')) {
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
}

if (!function_exists('updateProfil')) {
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
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, $dir = '/uploads/', $filename = ''): array|false
    {
        $oldName = $file['name'];
        $mime_type = mime_content_type($file['tmp_name']);
        $ext = strtolower(pathinfo($oldName, PATHINFO_EXTENSION));
        $size = $file['size'];

        $filename = $filename == '' ? date('ymd-') . strtolower(random_string(8)) . '.' . $ext : $filename;

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
}

if (!function_exists('view')) {
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
}

if (!function_exists('tanggal')) {
    /**
     * Mengonversi tanggal dan waktu ke format bahasa Indonesia.
     *
     * @param string|null $tanggalWaktu Input dalam format US (default: null, akan menggunakan waktu saat ini)
     * @param string $format Format keluaran (default: 'd-m-Y')
     * @return string Tanggal dan waktu dalam format bahasa Indonesia
     */
    function tanggal($tanggalWaktu = null, $format = 'd-m-Y')
    {
        if ($tanggalWaktu == null) {
            $tanggalWaktu = 'now';
        }

        $namaHariIndonesia = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sun' => 'Min',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab'
        );

        $namaBulanIndonesia = array(
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
            'Jan' => 'Jan',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Apr',
            'May' => 'Mei',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Agu',
            'Sep' => 'Sep',
            'Oct' => 'Okt',
            'Nov' => 'Nov',
            'Dec' => 'Des'
        );

        $timestamp = strtotime($tanggalWaktu);
        $tanggalWaktuIndonesia = date($format, $timestamp);
        $tanggalWaktuIndonesia = strtr($tanggalWaktuIndonesia, array_merge($namaHariIndonesia, $namaBulanIndonesia));
        return $tanggalWaktuIndonesia;
    }
}
