<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: /auth/login.php");
    exit;
}

require_once '../core/functions.php';
require_once '../core/DBBuilder.php';
$db = new DBBuilder();

$data['logo']['dark'] = $db->table('logo')->where('type', 'dark')->first();
$data['logo']['light'] = $db->table('logo')->where('type', 'light')->first();
$data['logo']['default'] = $db->table('logo')->where('type', 'default')->first();
$data['logo']['favicon'] = $db->table('logo')->where('type', 'favicon')->first();
$data['admin'] = $db->table('admin')->select('id, username, name')->where('username', $_SESSION['user']['username'])->first();
$data['header'] = $db->table('header')->first();
$data['heroes'] = $db->table('heroes')->first();
$data['syarat'] = $db->table('syarat')->first();
$data['dokumen'] = $db->table('dokumen')->first();
$data['identitas'] = $db->table('identitas')->first();

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
