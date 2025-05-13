<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: /panel/manage.php");
    exit;
}

include '../core/functions.php';
include '../core/DBBuilder.php';

$db = new DBBuilder();
$favicon = $db->table('logo')->where('type', 'favicon')->first();

view('../view/templates/head.php', [
    'title' => 'Login ke sistem',
    'style' => [
        '/plugins/bootstrap/bootstrap.min.css',
        '/plugins/bootstrap-icon/bootstrap-icons.css',
        '/assets/css/style.css',
        '/assets/css/sign-in.css',
    ],
    'favicon' => [$favicon ? $favicon['src'] : ''],
    'body' => [
        'className' => 'd-flex align-items-center py-4 bg-body-tertiary'
    ]
]);

view('../view/templates/toogle-theme.php'); ?>

<main class="form-signin w-100 m-auto bg-body rounded rounded-4 shadow">
    <form class="mb-3" action="" method="post">
        <div style="height: 100px;" class="mb-2 d-flex justify-content-center w-100">
            <img src="" alt="" id="logo" class="img-fluid h-100">
        </div>
        <h1 class="h3 fw-bold">Manage Website</h1>
        <h6 class="">Please Sign In</h6>
        <div class="form-floating">
            <input type="text" class="form-control" id="username" placeholder="Input Username" name="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control password" id="password" placeholder="Password" name="password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="row row-cols-2">
            <div class="col">
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="checkbox" id="showPass">
                    <label class="form-check-label" for="showPass">
                        Lihat Password
                    </label>
                </div>
            </div>
        </div>
        <div id="registrasiElm"></div>

        <button class="btn btn-primary w-100 py-2" type="submit" name="signin" id="btnSignIn">Sign in</button>
    </form>

    <a href="../index.php" class="small text-decoration-none">Homepage</a>
</main>
<?php
view('../view/templates/footer.php', [
    'script' => [
        '/plugins/jquery/jquery.min.js',
        '/plugins/bootstrap/bootstrap.bundle.min.js',
        '/plugins/fetchData/fetchData.js',
        '/assets/js/functions.js',
        '/assets/js/global.js',
        '/plugins/simple-toast/toast.js',
        '/assets/js/sign-in.js',
    ]
]);
?>