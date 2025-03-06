<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include '../core/functions.php';

$admin = $_SESSION['user'];

view('../view/templates/head.php', [
    'title' => 'Manage | SI-PPDB',
    'style' => [
        '/plugins/bootstrap/bootstrap.min.css',
        '/plugins/bootstrap-icon/bootstrap-icons.css',
        '/plugins/fancybox/fancybox.css',
        '/plugins/datatables/datatables.min.css',
        '/plugins/summernote/summernote-bs4.css',
        '/assets/css/style.css',
        '/assets/css/admin.css',
    ],
    'body' => [
        'className' => 'bg-body-tertiary',
    ],
]);

view('../view/templates/toogle-theme.php');
view('../view/panel/navbar.php', ['admin' => $admin]);
// content
view('../view/panel/manage.php');
// end content
view('../view/templates/footer.php', [
    'script' => [
        '/plugins/jquery/jquery.min.js',
        '/plugins/bootstrap/bootstrap.bundle.min.js',
        '/plugins/datatables/datatables.min.js',
        '/plugins/fancybox/fancybox.umd.js',
        '/plugins/summernote/summernote-bs4.js',
        '/plugins/summernote/summernote-file.js',
        '/plugins/fetchData/fetchData.js',
        '/plugins/simple-toast/toast.js',
        '/assets/js/functions.js',
        '/assets/js/global.js',
        '/assets/js/manage.js',
    ]
]);
