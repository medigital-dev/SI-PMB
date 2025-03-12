<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
include '../core/functions.php';
global $conn;

$id = $_GET['id'] ?? null;
$sql = "SELECT * FROM forum WHERE forum_id = '$id'";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$html = '';
if (!$result) echo 'Diskusi tidak ditemukan.';
$html .= '<div class="card card-body border-primary mb-2">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title m-0">' . $result['nama'] . '</h6>
                <span class="small text-muted">' . tanggal($result['created_at'], 'd F Y H:i') . ' WIB</span>
              </div>
              <button type="button" class="btn btn-sm btn-link btnBalasDiskusi" data-id="' . $result['forum_id'] . '"><i class="bi bi-reply-fill me-1"></i>Balas</button>
            </div>
            <p class="card-text">' . $result['isi'] . '</p>
          </div>';
$jawaban = query("SELECT * FROM forum WHERE parent_id = '$id' ORDER BY created_at ASC");
foreach ($jawaban as $row) {
    $html .= '<div class="card card-body mb-2">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="card-title m-0">' . $row['nama'] . '</h6>
                <span class="small text-muted">' . tanggal($row['created_at'], 'd F Y H:i') . ' WIB</span>
              </div>
              <button type="button" class="btn btn-sm btn-link btnBalasDiskusi" data-id="' . $row['forum_id'] . '"><i class="bi bi-reply-fill me-1"></i>Balas</button>
            </div>
            <p class="card-text">' . $row['isi'] . '</p>
          </div>';
}
echo $html;
