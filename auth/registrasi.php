<?php
session_start();

require_once '../config.php';
include '../core/functions.php';
include '../core/DBBuilder.php';

$db = new DBBuilder();
$table = $db->table('admin');
if ($table->findAll()) die('Anda tidak diizinkan untuk mengakses halaman ini, silahkan <a href="' . base_url('auth/login.php') . '">Login</a> atau Kembali ke <a href="/index.php">Homepage</a>');
$table = $db->table('logo');
$favicon = $table->where('type', 'favicon')->first();

view('../view/templates/head.php', [
    'title' => 'Login ke sistem',
    'style' => [
        base_url('plugins/bootstrap/bootstrap.min.css'),
        base_url('plugins/bootstrap-icon/bootstrap-icons.css'),
        base_url('assets/css/style.css'),
        base_url('assets/css/sign-in.css'),
    ],
    'favicon' => [$favicon ? $favicon['src'] : ''],
    'body' => [
        'className' => 'd-flex align-items-center py-4 bg-body-tertiary'
    ]
]);

view('../view/templates/toogle-theme.php');
?>

<main class="form-signin w-100 m-auto bg-body rounded rounded-4 shadow">
    <form class="mb-3" action="" method="post">
        <div style="height: 100px;" class="mb-2 d-flex justify-content-center w-100">
            <img src="" alt="" id="logo" class="img-fluid h-100">
        </div>
        <h1 class="h3 fw-bold">Registrasi Admin</h1>
        <h6 class="">Silahkan registrasi</h6>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" id="username" placeholder="Input Username" name="username">
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-2">
            <input type="text" class="form-control" id="name" placeholder="Input nama" name="nama">
            <label for="name">Nama</label>
        </div>
        <div class="form-floating mb-2">
            <input type="password" class="form-control password" id="password" placeholder="Password" name="password">
            <label for="password">Password</label>
        </div>
        <div class="form-floating ">
            <input type="password" class="form-control password" id="password2" placeholder="Konfirmasi password" name="password2">
            <label for="password2">Konfirmasi password</label>
        </div>
        <div class="row row-cols-2">
            <div class="col">
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="checkbox" id="showPass">
                    <label class="form-check-label" for="showPass">
                        Lihat Password
                    </label>
                </div>
            </div>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit" name="signin" id="btnRegistrasi">Registrasi</button>
    </form>

    <div class="d-flex justify-content-between">
        <a href="/auth/login.php" class="small text-decoration-none">Login</a> <a href="/index.php" class="small text-decoration-none">Homepage</a>
    </div>
</main>
<?php
view('../view/templates/footer.php', [
    'script' => [
        base_url('plugins/jquery/jquery.min.js'),
        base_url('plugins/bootstrap/bootstrap.bundle.min.js'),
        base_url('plugins/fetchData/fetchData.js'),
        base_url('plugins/simple-toast/toast.js'),
        base_url('assets/js/global.js'),
        base_url('assets/js/functions.js'),
        base_url('assets/js/registrasi.js'),
    ]
]);
?>