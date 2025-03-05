<?php
session_start();
include 'functions.php';

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
    header("Location: manage.php");
    exit;
}

if (isset($_POST["signin"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            $_SESSION["login"] = true;
            $_SESSION['user'] = [
                'username' => $row['username'],
                'name' => $row['name'],
            ];

            if (isset($_POST['remember'])) {
                setcookie('id', $row['id'], time() + 1440);
                setcookie('key', hash('sha384', $row['username']), time() + 1440);
            }

            header("Location: manage.php");
            exit;
        }
    }

    $error = true;
}

$admin = query('SELECT * FROM admin');
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="./assets/js/color-modes.js"></script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.112.5" />
    <title>Manage Content</title>

    <!-- Global Style -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet" />
    <link href="./assets/css/fancybox.css" rel="stylesheet" />
    <link href="./assets/css/datatables.min.css" rel="stylesheet" />
    <link href="./assets/css/style.css" rel="stylesheet" />
    <!-- Custom Style -->
    <link href="./assets/css/sign-in.css" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="180x180" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="32x32" type="image/png" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="16x16" type="image/png" />
    <link rel="manifest" href="./assets/manifest.json" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" />
    <meta name="theme-color" content="#712cf9" />

</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <main class="form-signin w-100 m-auto bg-body rounded rounded-4 shadow">
        <form class="mb-3" action="" method="post">
            <img class="mb-4" src="./assets/images/smp2wonosari-shadow_black.png" alt="" width="100">
            <h1 class="h3 fw-bold">Manage Website</h1>
            <h6 class="">Please Sign In</h6>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Input Username" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control password" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="row row-cols-2">
                <div class="col">
                    <div class="form-check text-start mb-3">
                        <input class="form-check-input" type="checkbox" value="remember-me" name="remember" id="flexCheckDefault">
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
                    Administrator tidak ditemukan. Silahkan <a href="/registrasi.php">registrasi</a> terlebih dahulu.
                </div>
            <?php endif; ?>

            <button class="btn btn-primary w-100 py-2" type="submit" name="signin">Sign in</button>
        </form>

        <a href="./" class="small text-decoration-none">Back</a>
    </main>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#showPass').on('click', function() {
                if ($(this).is(':checked')) $('.password').attr('type', 'text');
                else $('.password').attr('type', 'password');
            });
        });
    </script>
</body>

</html>