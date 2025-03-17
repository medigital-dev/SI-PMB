<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: /auth/login.php");
    exit;
}

require_once '../core/functions.php';

$data['logo']['dark'] = db_get('logo', ['where' => ['type' => 'dark']], true);
$data['logo']['light'] = db_get('logo', ['where' => ['type' => 'light']], true);
$data['logo']['default'] = db_get('logo', ['where' => ['type' => 'default']], true);
$data['logo']['favicon'] = db_get('logo', ['where' => ['type' => 'favicon']], true);
$data['admin'] = $_SESSION['user'];
$data['header'] = db_get('header', [], true);
$data['heroes'] = db_get('heroes', [], true);
$data['syarat'] = db_get('syarat', [], true);
$data['dokumen'] = db_get('dokumen', [], true);

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
    'favicon' => [$data['logo']['favicon'] ? $data['logo']['favicon']['src'] : '']
]);

view('../view/templates/toogle-theme.php');
view('../view/panel/navbar.php', $data);
// content
view('../view/panel/manage.php', $data);
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
