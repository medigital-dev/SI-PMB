<?php

if (!function_exists('timeAgo')) {
    function timeAgo($datetime): string
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = date_diff($now, $ago);

        if ($diff->s < 60 && $diff->i === 0 && $diff->h === 0 && $diff->d === 0) {
            return 'baru saja';
        } elseif ($diff->i < 60 && $diff->h === 0 && $diff->d === 0) {
            return $diff->i . ' menit yang lalu';
        } elseif ($diff->h < 24 && $diff->d === 0) {
            return $diff->h . ' jam yang lalu';
        } else {
            return $diff->d . ' hari yang lalu';
        }
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
