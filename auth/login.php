<?php
session_start();

include '../core/functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha384', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: /panel/manage.php");
    exit;
}

$admin = query('SELECT * FROM admin');
?>

<?php
view('../view/templates/head.php', [
    'title' => 'Login ke sistem',
    'style' => [
        '/plugins/bootstrap/bootstrap.min.css',
        '/plugins/bootstrap-icon/bootstrap-icons.css',
        '/assets/css/style.css',
        '/assets/css/sign-in.css',
    ],
    'body' => [
        'className' => 'd-flex align-items-center py-4 bg-body-tertiary'
    ]
]);

view('../view/templates/toogle-theme.php'); ?>

<main class="form-signin w-100 m-auto bg-body rounded rounded-4 shadow">
    <form class="mb-3" action="" method="post">
        <img class="mb-4" src="./assets/images/smp2wonosari-shadow_black.png" alt="" width="100">
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
                    <label class="form-check-label" for="flexCheckDefault">
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
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Username / Password salah
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!$conn) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Koneksi Database ERROR.<br>Cek dbconn.php
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!$admin): ?>
            <div class="alert alert-primary">
                Administrator tidak ditemukan. Silahkan <a href="registrasi.php">registrasi</a> terlebih dahulu.
            </div>
        <?php endif; ?>

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
        '/plugins/simple-toast/toast.js',
        '/assets/js/sign-in.js',
    ]
]);
?>