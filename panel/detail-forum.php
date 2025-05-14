<style>
  .nested-comments {
    margin-left: 20px;
  }

  .comment-item {
    border-left: 3px solid #ccc;
    padding-left: 15px;
    margin-bottom: 10px;
  }
</style>

<?php
if (!function_exists('renderNestedCommentsById')) {
  function renderNestedCommentsById(array $comments, string $targetParentId): string
  {
    $html = '<ul class="list-unstyled">';
    foreach ($comments as $comment) {
      if ($comment['id'] == $targetParentId) {
        $replies = renderChildrenComments($comments, $comment['id']);
        $countChild = countChildren($comments, $comment['id']);

        $html .= '<li class="mb-3 comment-item">';
        $html .= '<div class="d-flex w-100 justify-content-start">';
        $html .= '<h6 class="mb-1 me-1">' . htmlspecialchars($comment['nama']) . '</h6>';
        $html .= '<small class="text-muted"> - ' . htmlspecialchars(timeAgo($comment['created_at'])) . '</small>';
        $html .= '</div>';
        $html .= '<p class="mb-0">' . htmlspecialchars($comment['isi']) . '</p>';
        $html .= '<a type="button" class="mb-2 small text-decoration-none btnBalasDiskusi" data-id="' . $comment['id'] . '">Balas</a> | <a type="button" class="text-decoration-none small mb-2" data-bs-toggle="collapse" data-bs-target="#replies-' . $comment['id'] . '">' . $countChild . ' Balasan</a>';

        if ($replies !== '<ul class="list-unstyled"></ul>') {
          $html .= '<ul class="list-unstyled nested-comments collapse" id="replies-' . $comment['id'] . '">' . $replies . '</ul>';
        }

        $html .= '</li>';
        $html .= '</ul>'; // Tutup ul setelah induk dan semua anaknya
        return $html; // Keluar dari fungsi setelah menemukan induk yang dicari
      }
    }
    return ''; // Mengembalikan string kosong jika induk tidak ditemukan
  }
}

if (!function_exists('renderChildrenComments')) {
  function renderChildrenComments(array $comments, string $parentId): string
  {
    $html = '<ul class="list-unstyled">';
    foreach ($comments as $comment) {
      if ($comment['parent_id'] == $parentId) {
        $replies = renderChildrenComments($comments, $comment['id']);
        $countChild = countChildren($comments, $comment['id']);

        $html .= '<li class="mb-3 comment-item">';
        $html .= '<div class="d-flex w-100 justify-content-start">';
        $html .= '<h6 class="mb-1 me-1">' . htmlspecialchars($comment['nama']) . '</h6>';
        $html .= '<small class="text-muted"> - ' . htmlspecialchars(timeAgo($comment['created_at'])) . '</small>';
        $html .= '</div>';
        $html .= '<div class="mb-0">' . $comment['isi'] . '</div>';
        $html .= '<a type="button" class="mb-2 small text-decoration-none btnBalasDiskusi" data-id="' . $comment['id'] . '">Balas</a> | <a type="button" class="text-decoration-none small mb-2" data-bs-toggle="collapse" data-bs-target="#replies-' . $comment['id'] . '">' . $countChild . ' Balasan</a>';

        if ($replies !== '<ul class="list-unstyled"></ul>') {
          $html .= '<ul class="list-unstyled nested-comments collapse" id="replies-' . $comment['id'] . '">' . $replies . '</ul>';
        }

        $html .= '</li>';
      }
    }
    $html .= '</ul>';
    return $html;
  }
}

if (!function_exists('countChildren')) {
  function countChildren(array $comments, string $parentId): int
  {
    $count = 0;
    foreach ($comments as $comment) {
      if ($comment['parent_id'] == $parentId) {
        $count++;
      }
    }
    return $count;
  }
}

session_start();
header("Content-Type: text/html; charset=UTF-8");

require_once '../config.php';
require_once '../core/functions.php';
require_once '../core/DBBuilder.php';

$db = new DBBuilder('forum');
$db->addIndex('forum_id');

$id = $_GET['id'] ?? null;
$data = $db
  ->select(['forum_id as id', 'parent_id', 'nama', 'isi', 'created_at'])
  ->findAll();
$html = renderNestedCommentsById($data, $id);
echo $html;
