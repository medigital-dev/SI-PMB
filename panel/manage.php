<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION["login"])) {
    header("Location: " . base_url('auth/login.php'));
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
        base_url('plugins/bootstrap/bootstrap.min.css'),
        base_url('plugins/bootstrap-icon/bootstrap-icons.css'),
        base_url('plugins/fancybox/fancybox.css'),
        base_url('plugins/datatables/datatables.min.css'),
        base_url('plugins/summernote/summernote-bs4.css'),
        base_url('assets/css/style.css'),
        base_url('assets/css/admin.css'),
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
        base_url('plugins/jquery/jquery.min.js'),
        base_url('plugins/bootstrap/bootstrap.bundle.min.js'),
        base_url('plugins/datatables/datatables.min.js'),
        base_url('plugins/fancybox/fancybox.umd.js'),
        base_url('plugins/summernote/summernote-bs4.js'),
        base_url('plugins/summernote/summernote-file.js'),
        base_url('plugins/fetchData/fetchData.js'),
        base_url('plugins/simple-toast/toast.js'),
        base_url('assets/js/functions.js'),
        base_url('assets/js/global.js'),
        base_url('assets/js/manage.js'),
    ]
]);
