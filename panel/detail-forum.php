<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
include '../core/functions.php';

$id = $_POST['id'] ?? null;
$parent = $_POST['parent'] ?? null;

function nestedGenerator($id)
{
    $data = query("SELECT * FROM forum WHERE forum_id = '$id'");
    if (!$data) return '';

    $data = $data[0]; // Ambil data pertama
    $html = '';

    $html .= '<div class="card card-body mb-2">
                <h6 class="card-title m-0">@<strong>' . $data['nama'] . '</strong></h6>
                <span class="small text-muted mb-2">' . $data['created_at'] . '</span>
                <p class="card-text mb-2">' . $data['isi'] . '</p>';

    // Ambil semua balasan (anak) dari komentar ini
    $replies = query("SELECT * FROM forum WHERE parent_id = '$id' ORDER BY created_at ASC");
    if ($replies) {
        foreach ($replies as $reply) {
            $html .= '<div class="ms-3">' . nestedGenerator($reply['forum_id']) . '</div>';
        }
    }

    $html .= '</div>';

    return $html;
}

if ($parent) {
    $data = query("SELECT * FROM forum WHERE forum_id = '$parent'");
    if ($data) {
        $data = $data[0];
        echo
        '<div class="card card-body mb-3">
        <h6 class="card-title m-0">Reply dari: ' . $data['nama'] . '</h6>
        <span class="small text-muted mb-2">' . $data['created_at'] . '</span>
        <p class="card-text">' . $data['isi'] . '</p>
    </div>';
    }
}

echo nestedGenerator($id);
