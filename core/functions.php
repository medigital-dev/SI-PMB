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
    function db_get(string $table, string $select = '*', array $where = [], array $orderBy = [])
    {
        global $conn;
        if (!$conn) {
            return ['error' => 'Koneksi database tidak tersedia'];
        }

        // Ambil informasi indeks dari tabel
        $indexColumns = [];
        $indexQuery = $conn->query("SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY' OR Non_unique = 0");
        if ($indexQuery) {
            while ($row = $indexQuery->fetch_assoc()) {
                $indexColumns[] = $row['Column_name'];
            }
        }

        // Bangun query dasar
        $query = "SELECT $select FROM $table";

        // Tambahkan WHERE jika ada
        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                $conditions[] = "$key = ?";
            }
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Tambahkan ORDER BY jika ada
        if (!empty($orderBy)) {
            $orderClauses = [];
            foreach ($orderBy as $column => $direction) {
                $orderClauses[] = "$column $direction";
            }
            $query .= " ORDER BY " . implode(", ", $orderClauses);
        }

        // **Cek apakah `WHERE` hanya menggunakan kolom INDEX**
        $whereKeys = array_keys($where);
        $useFirst = !empty($whereKeys) && count(array_intersect($whereKeys, $indexColumns)) > 0;

        // Siapkan statement
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            return ['error' => 'Gagal menyiapkan query: ' . $conn->error];
        }

        // Binding parameter jika ada kondisi WHERE
        if (!empty($where)) {
            $types = str_repeat("s", count($where)); // Semua parameter dianggap string
            $stmt->bind_param($types, ...array_values($where));
        }

        // Eksekusi query
        if (!$stmt->execute()) {
            return ['error' => 'Gagal mengeksekusi query: ' . $stmt->error];
        }

        // Ambil hasil query
        $result = $stmt->get_result();

        // **Gunakan first() jika PRIMARY KEY digunakan, else gunakan findAll()**
        return $useFirst ? $result->fetch_assoc() : $result->fetch_all(MYSQLI_ASSOC);
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
