<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
require_once '../core/functions.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('forum');
$db->addIndex('forum_id');

$id = $_GET['id'] ?? null;
$result = $db->find($id);
$html = '';
if (!$result) die('Diskusi tidak ditemukan.');
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
$jawaban = $db->where('parent_id', $id)->orderBy('created_at', 'ASC')->findAll();
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
