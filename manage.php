<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include 'functions.php';

$admin = $_SESSION['user'];

if (isset($_POST['saveProfil'])) {
    $result = updateProfil($_POST);
    if ($result == 1) {
        echo "
			<script>
				alert('Data profil berhasil diperbaharui.');
				document.location.href = 'manage.php';
			</script>
		";
    } else {
        echo '
			<script>
				alert("' . $result . '");
			</script>
			';
    }
}

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="./assets/js/color-modes.js"></script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="CMS-Sistem Informasi PPDB" />
    <meta name="author" content="muhsaidlg.my.id" />
    <title>Manage CMS</title>

    <!-- Global Style -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet" />
    <link href="./assets/css/fancybox.css" rel="stylesheet" />
    <link href="./assets/css/datatables.min.css" rel="stylesheet" />
    <link href="./assets/css/summernote-bs4.css" rel="stylesheet" />
    <link href="./assets/css/style.css" rel="stylesheet" />
    <!-- Custom Style -->
    <link href="./assets/css/admin.css" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="32x32" type="image/png" />

    <!-- theme -->
    <meta name="theme-color" content="#712cf9" />
    <link rel="manifest" href="./assets/manifest.json" />
</head>

<body class="bg-body-tertiary">

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

    <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow">
        <div class="container">
            <a class="navbar-brand" href="./manage.php">CMS-Info PPDB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/manage.php">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Content</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <h6 class="dropdown-header"><?= $admin['name']; ?></h6>
                            </li>
                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalProfil">Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="row row-cols-2 row-cols-md-4 g-4 mb-4">
                <div class="col">
                    <div class="card card-body shadow text-bg-primary bg-gradient">
                        <h6 class="card-title">Informasi</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalInfo">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-danger bg-gradient">
                        <h6 class="card-title">Banner</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalBanner">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-warning bg-gradient">
                        <h6 class="card-title">Event</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalEvent">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-success bg-gradient">
                        <h6 class="card-title">Berkas/Unduhan</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalBerkas">0/0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-block d-lg-flex align-items-start">
                <div class="card shadow mb-4 me-lg-4">
                    <div class="card-header text-bg-primary text-center">Menu</div>
                    <div class="card-body p-2">
                        <div class="nav flex-lg-column nav-pills justify-content-center pe-lg-4" role="tablist" aria-orientation="vertical">
                            <button class="nav-link text-start active" id="v-pills-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-info" type="button" role="tab" aria-controls="v-pills-info" aria-selected="true">Informasi</button>
                            <button class="nav-link text-start" id="v-pills-banner-tab" data-bs-toggle="pill" data-bs-target="#v-pills-banner" type="button" role="tab" aria-controls="v-pills-banner" aria-selected="true">Banner</button>
                            <button class="nav-link text-start" id="v-pills-event-tab" data-bs-toggle="pill" data-bs-target="#v-pills-event" type="button" role="tab" aria-controls="v-pills-event" aria-selected="true">Event</button>
                            <button class="nav-link text-start" id="v-pills-berkas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-berkas" type="button" role="tab" aria-controls="v-pills-berkas" aria-selected="true">Berkas</button>
                        </div>
                    </div>
                </div>
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Informasi</div>
                            <div class="card-body">
                                <div class="sticky-top py-2 bg-body">
                                    <div class="btn-toolbar">
                                        <div class="btn-group btn-group-sm my-1 me-1">
                                            <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelInformasi"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-primary" title="Tambah Informasi" id="btnTambahInformasi" data-bs-toggle="modal" data-bs-target="#modalTambahInformasi"><i class="bi bi-plus-circle"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm my-1 ms-auto">
                                            <input type="text" class="form-control" id="searchTabelInformasi" placeholder="Cari Informasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover w-100" id="tabelInformasi">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle">Informasi</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-berkas" role="tabpanel" aria-labelledby="v-pills-berkas-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Berkas Upload</div>
                            <div class="card-body">
                                <div class="sticky-top py-2 bg-body">
                                    <div class="btn-toolbar">
                                        <div class="btn-group btn-group-sm my-1 me-1">
                                            <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelBerkas"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-primary" title="Tambah Berkas" id="btnTambahBerkas" data-bs-toggle="modal" data-bs-target="#modalTambahBerkas"><i class="bi bi-plus-circle"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm ms-auto my-1">
                                            <input type="text" class="form-control" id="searchTabelBerkas" placeholder="Cari Berkas">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="tabelBerkas">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle">Data</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-banner" role="tabpanel" aria-labelledby="v-pills-banner-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Banner Hero</div>
                            <div class="card-body">
                                <div class="sticky-top py-2 bg-body">
                                    <div class="btn-toolbar">
                                        <div class="btn-group btn-group-sm my-1 me-1">
                                            <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelBanner"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-primary" title="Tambah Banner" id="btnTambahBanner" data-bs-toggle="modal" data-bs-target="#modalTambahBanner"><i class="bi bi-plus-circle"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm my-1 ms-auto">
                                            <input type="text" class="form-control" id="searchTabelBanner" placeholder="Cari Banner">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="tabelBanner">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle">Data</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-event" role="tabpanel" aria-labelledby="v-pills-event-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Event</div>
                            <div class="card-body">
                                <div class="sticky-top py-2 bg-body">
                                    <div class="btn-toolbar">
                                        <div class="btn-group btn-group-sm my-1 me-1">
                                            <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelEvent"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-primary" title="Tambah Banner" id="btnTambahEvent" data-bs-toggle="modal" data-bs-target="#modalTambahEvent"><i class="bi bi-plus-circle"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm my-1 ms-auto">
                                            <input type="text" class="form-control" id="searchTabelEvent" placeholder="Cari Event">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="tabelEvent">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle">Uraian</th>
                                                <th class="text-bg-primary text-center align-middle">Waktu &<br>Tanggal</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahInformasi" tabindex="-1" aria-labelledby="modalTambahInformasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahInformasiLabel">Tambah Informasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idInformasi">
                    <div class="mb-3">
                        <label class="form-label" for="judul">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul">
                        <div class="invalid-feedback">Input ini diperlukan!</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="isi">Isi</label>
                        <textarea name="isi" id="isi" rows="10" class="form-control"></textarea>
                        <div class="invalid-feedback">Input ini diperlukan!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveInfo">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalProfil" tabindex="-1" aria-labelledby="modalProfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalProfilLabel">Profil Pengguna</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama User</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $admin['name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= $admin['username']; ?>">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Password Lama</label>
                            <input type="password" class="form-control password" name="oldPassword" id="oldPassword">
                            <div class="form-text">Input password lama jika ingin mengganti password.</div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control password" name="newPassword" id="newPassword">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="newPassword2" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control password" name="newPassword2" id="newPassword2">
                            </div>
                        </div>
                        <div class="form-check text-start mb-3">
                            <input class="form-check-input" type="checkbox" id="showPass">
                            <label class="form-check-label" for="showPass">
                                Lihat Password
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="saveProfil" id="btnSaveProfil">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahBerkas" tabindex="-1" aria-labelledby="modalTambahBerkasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahBerkasLabel">Tambah Berkas Unduhan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titleFile" class="form-label">Judul File</label>
                        <input type="text" class="form-control" name="title" id="titleFile">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                    <div class="mb-3">
                        <label for="fileBerkas" class="form-label">Pilih file</label>
                        <input class="form-control" type="file" id="fileBerkas">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveBerkas">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahBanner" tabindex="-1" aria-labelledby="modalTambahBannerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahBannerLabel">Tambah Banner Hero</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="titleFileBanner" class="col-form-label col-sm-3">Judul</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" id="titleFileBanner">
                            <div class="invalid-feedback">Wajib.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="bannerDescription" class="col-form-label col-sm-3">Deskripsi</label>
                        <div class="col-sm-9">
                            <textarea rows="4" class="form-control" name="description" id="bannerDescription"></textarea>
                            <div class="invalid-feedback">Wajib.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="fileBanner" class="col-form-label col-sm-3">Pilih file</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" id="fileBanner" accept="image/*">
                            <div class="invalid-feedback">Wajib.</div>
                            <a href="" data-fancybox>
                                <img id="previewBanner" class="img-fluid mt-2">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveBanner">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahEvent" tabindex="-1" aria-labelledby="modalTambahEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahEventLabel">Tambah Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="namaEvent" class="col-form-label col-sm-3">Nama Event</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" id="namaEvent">
                            <div class="invalid-feedback">Wajib.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tanggalEvent" class="col-form-label col-sm-3">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" name="tanggalEvent" id="tanggalEvent" class="form-control">
                            <div class="invalid-feedback">Wajib.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveEvent">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/datatables.min.js"></script>
    <script src="./assets/js/fancybox.umd.js"></script>
    <script src="./assets/js/summernote-bs4.js"></script>
    <script src="./assets/js/summernote-file.js"></script>
    <script src="./assets/js/fetchData.js"></script>
    <script src="./assets/js/simple-notif.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]");
    </script>
    <script>
        $(document).ready(function() {
            $('#showPass').on('click', function() {
                if ($(this).is(':checked')) $('.password').attr('type', 'text');
                else $('.password').attr('type', 'password');
            });

            $('#isi').summernote({
                dialogsInBody: true,
                height: 200,
                toolbar: [
                    ['misc', ['undo', 'redo']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'table', 'file']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                callbacks: {
                    onFileUpload: (file) => {
                        for (let i = 0; i < file.length; i++) {
                            uploadMedia(file[i]);
                        }
                    },
                    onMediaDelete: (file) => deleteMedia(file[0]),
                },
            });

            const tabelInformasi = $('#tabelInformasi').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"],
                ],
                responsive: true,
                ordering: false,
                processing: true,
                pagingType: 'simple',
                ajax: {
                    url: '/api/info.php',
                    dataSrc: '',
                },
                columns: [{
                    data: 'judul',
                    render: (data, type, rows, meta) => {
                        return ('<a class="text-decoration-none" role="button" data-bs-toggle="collapse" href="#collapse-' + rows.id + '"><h6 class="m-0">' + data + '</h6></a>' +
                            '<span class="text-muted small">' + rows.tanggal + '</span>' +
                            '<div class="collapse" id="collapse-' + rows.id + '"><hr class="my-2">' + rows.isi + '</div>');
                    }
                }, {
                    data: 'id',
                    className: 'text-center',
                    width: '70px',
                    render: (data, type, rows, meta) => {
                        return ('<div class="btn-group btn-group-sm">' +
                            '<button type="button" class="btn btn-primary btnEditInfo" data-id="' + data +
                            '"><i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn btn-danger btnHapusInfo" data-id="' + data +
                            '"><i class="bi bi-trash-fill"></i></button>' +
                            '</div>');
                    }
                }]
            });

            tabelInformasi.on('draw', () => {
                reloadWidget();

                $('.btnEditInfo').on('click', function() {
                    const id = $(this).data('id');
                    fetchData('/api/info.php?id=' + id).then(e => {
                        $('#idInformasi').val(e.id)
                        $('#judul').val(e.judul);
                        $('#isi').summernote('code', e.isi);
                        $('#modalTambahInformasi').modal('show');
                    }).catch(err => toast(err.responseJSON.message, 'error'));
                });

                $('.btnHapusInfo').on('click', async function() {
                    const id = $(this).data('id');
                    const data = await fetchData('/api/info.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;
                    const action = await toast({
                        title: 'Hapus informasi?',
                        message: 'Informasi: <strong>' + data.judul + '</strong> akan dihapus permanen. Yakin?',
                        icon: 'question',
                        position: 'middle-center'
                    });
                    if (action) {
                        const res = await fetchData({
                            url: '/api/info.php?id=' + id,
                            method: 'DELETE'
                        }).catch(err => {
                            toast(err.responseJSON.message, 'error');
                            return false;
                        });
                        if (!res) return;
                        toast({
                            message: 'Informasi: <strong>' + data.judul + '</strong> berhasil dihapus.',
                            delay: 5000,
                            icon: 'success'
                        });
                        tabelInformasi.ajax.reload(null, false);
                    }
                });
            });

            const tabelBerkas = $('#tabelBerkas').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"],
                ],
                responsive: true,
                ordering: false,
                processing: true,
                pagingType: 'simple',
                ajax: {
                    url: '/api/berkas.php',
                    dataSrc: '',
                },
                columns: [{
                        data: 'id',
                        className: 'w-100',
                        render: (data, type, rows, meta) => {
                            const checked = rows.status == '1' ? 'checked' : '';
                            const label = rows.status == '1' ? 'Ditampilkan' : 'Tidak ditampilkan';

                            return ('<div class="d-flex justify-content-start">' +
                                '<div class="px-2 d-flex" style="width: 75px; height: 75px;"><a title="Preview" href="' + rows.src + '" data-fancybox class="mx-auto fs-1">' +
                                getFileIcon(rows.type) +
                                '</a></div>' +
                                '<div class="w-100"><div class="d-flex justify-content-between"><h6 class="m-0">' + rows.title + '</h6><span class="text-muted small">' + timeAgo(rows.tanggal) + '</span></div><p class="m-0 small text-muted">[' + fileSize(parseInt(rows.size)) + '] ' + rows.filename + '</p>' +
                                '<div class="form-check form-switch">' +
                                '<input class="form-check-input btnSwitchBerkas" data-id="' + data + '" type="checkbox" role="switch" id="' + data + '" ' + checked + '>' +
                                '<label class="form-check-label small text-muted" for="' + data + '">' + label + ' pada unduhan</label>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        }
                    },
                    {
                        data: 'id',
                        width: '70px',
                        className: 'text-center',
                        render: (data, type, rows, meta) => {
                            return ('<div class="btn-group btn-group-sm">' +
                                '<a href="' + rows.src +
                                '" class="btn btn-primary" download title="Unduh berkas"><i class="bi bi-download"></i></a>' +
                                '<button type="button" class="btn btn-danger btnHapusBerkas" data-id="' + rows.id +
                                '" title="Hapus berkas"><i class="bi bi-trash-fill"></i></button>' +
                                '</div>');
                        }
                    },
                ]
            });

            tabelBerkas.on('draw', () => {
                reloadWidget();

                $('.btnHapusBerkas').on('click', async function() {
                    const id = $(this).data('id');
                    const data = await fetchData('/api/berkas.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;
                    const action = await toast({
                        title: 'Hapus berkas?',
                        message: 'Berkas: ' + data.title + ' akan dihapus permanen. Yakin?',
                        icon: 'question'
                    });
                    if (action) {
                        const result = await fetchData({
                            url: '/api/berkas.php?id=' + id,
                            method: 'DELETE'
                        }).catch(err => {
                            toast(err.responseJSON.message, 'error');
                            return false;
                        });
                        if (!result) return;
                        toast({
                            message: 'Berkas: ' + data.title + ' berhasil dihapus permanen?',
                            icon: 'success',
                            delay: 5000
                        });
                    }
                    tabelBerkas.ajax.reload(null, false);
                });

                $('.btnSwitchBerkas').on('click', async function() {
                    const id = $(this).data('id');
                    const state = $(this).is(':checked') ? 1 : 0;
                    const data = await fetchData('/api/berkas.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;

                    const res = await fetchData({
                        url: '/api/berkas.php?id=' + id,
                        data: {
                            title: data.title,
                            status: state,
                        },
                        method: 'POST'
                    }).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!res) {
                        $(this).prop('checked', !state);
                        return;
                    }
                    toast({
                        message: 'Data berkas: <strong>' + data.title + '</strong> berhasil diubah.',
                        icon: 'success',
                        delay: 5000,
                    });
                    tabelBerkas.ajax.reload(null, false);
                });
            });

            $('#btnReloadTabelInformasi').on('click', () => tabelInformasi.ajax.reload(null, false));
            $('#btnReloadTabelBerkas').on('click', () => tabelBerkas.ajax.reload(null, false));
            $('#btnReloadTabelBanner').on('click', () => tabelBanner.ajax.reload(null, false));
            $('#btnReloadTabelEvent').on('click', () => tabelEvent.ajax.reload(null, false));

            $('#btnSaveInfo').on('click', async function() {
                const btnElm = $(this);
                const judulElm = $('#judul');
                const isiElm = $('#isi');
                const id = $('#idInformasi');

                if (judulElm.val() == '' || isiElm.val() == '') {
                    if (judulElm.val() == '') judulElm.addClass('is-invalid');
                    else judulElm.removeClass('is-invalid');
                    if (isiElm.val() == '') isiElm.addClass('is-invalid');
                    else isiElm.removeClass('is-invalid');
                    toast('Lengkapi form.', 'info');
                    return
                }

                $('.is-invalid').removeClass('is-invalid');
                toggleButton(btnElm, 'Menyimpan...');
                const idVal = id.val();
                let data = new FormData();
                data.append('judul', judulElm.val());
                data.append('isi', isiElm.val());
                const res = await fetchData({
                    url: '/api/info.php?id=' + id.val(),
                    data: {
                        judul: judulElm.val(),
                        isi: isiElm.val(),
                    },
                    method: 'POST'
                }).catch(err => {
                    toast(err.responseJSON.message, 'error');
                    return false;
                });
                if (!res) return;
                toast({
                    message: 'Informasi dengan judul: <strong>' + judulElm.val() + '</strong> berhasil disimpan.',
                    icon: 'success',
                    delay: 5000,
                });
                tabelInformasi.ajax.reload(null, false);
                toggleButton(btnElm, 'Simpan');
                $('#modalTambahInformasi').modal('hide');
            });

            $('#modalTambahInformasi').on('hide.bs.modal', function() {
                $('#judul,#idInformasi').val('');
                $('#isi').summernote('code', '');
            });

            $('#searchTabelInformasi').on('keyup', e => {
                const keyword = e.target.value;
                if (keyword !== '') {
                    $('.collapse').collapse('show');
                    tabelInformasi.search(keyword).draw();
                } else
                    $('.collapse').collapse('hide');
            });
            $('#searchTabelBerkas').on('keyup', e => tabelBerkas.columns(0).search(e.target.value).draw());
            $('#searchTabelBanner').on('keyup', e => tabelBanner.columns(0).search(e.target.value).draw());
            $('#searchTabelEvent').on('keyup', e => tabelEvent.columns(0).search(e.target.value).draw());

            $('#btnSaveBerkas').on('click', async function() {
                const btnElm = $(this);
                const fileElm = $('#fileBerkas');
                const titleElm = $('#titleFile');

                if (fileElm.val() == '' || titleElm.val() == '') {
                    if (fileElm.val() == '') fileElm.addClass('is-invalid');
                    else fileElm.removeClass('is-invalid');
                    if (titleElm.val() == '') titleElm.addClass('is-invalid');
                    else titleElm.removeClass('is-invalid');
                    toast('Lengkapi form terlebih dahulu', 'error');
                    return;
                }
                $('is-invalid').removeClass('is-invalid');
                toggleButton(btnElm, 'Menyimpan...');
                const file = fileElm.prop('files');
                let data = new FormData();
                data.append('title', titleElm.val());
                data.append('file', file[0]);
                const res = await fetchData({
                    url: '/api/berkas.php',
                    data: data,
                    method: 'POST'
                }).catch(err => {
                    toast(err.responseJSON.message, 'error');
                    return false;
                });
                if (!res) return;
                toggleButton(btnElm, 'Simpan');
                fileElm.val('');
                titleElm.val('');
                $('#modalTambahBerkas').modal('hide');
                tabelBerkas.ajax.reload(null, false);
            });

            const tabelBanner = $('#tabelBanner').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"],
                ],
                responsive: true,
                ordering: false,
                processing: true,
                pagingType: 'simple',
                ajax: {
                    url: '/api/banner.php',
                    dataSrc: '',
                },
                deferRender: true,
                columns: [{
                    data: 'id',
                    className: 'w-100',
                    render: (data, type, rows, meta) => {
                        return ('<div class="d-flex justify-content-start">' +
                            '<div class="px-2 d-flex" style="width: 150px; height: 50px;"><a title="Preview" href="#" data-fancybox class="mx-auto placeholder-image" data-id="' + rows.berkas_id + '">' +
                            '<img src="#" class="img-thumbnail" style="object-fit: cover; height: 100%;">' +
                            '</a></div>' +
                            '<div><h6 class="m-0">' + rows.title + '</h6><p class="m-0 small text-muted">' + rows.description + '</p></div>' +
                            '</div>');
                    }
                }, {
                    data: 'id',
                    className: 'text-center',
                    width: '70px',
                    render: (data, type, rows, meta) => {
                        return ('<div class="btn-group btn-group-sm">' +
                            '<button type="button" class="btn btn-danger btnHapusBanner" data-id="' + data +
                            '" title="Hapus Banner"><i class="bi bi-trash-fill"></i></button>' +
                            '</div>');
                    }
                }],
                drawCallback: async function(settings) {
                    const placeholders = $('.placeholder-image');
                    placeholders.each(async function() {
                        const id = $(this).data('id');
                        const imgData = await fetchData('/api/berkas.php?id=' + id).catch(err => {
                            toast(err.responseJSON.message, 'error');
                            return false;
                        });
                        if (imgData) {
                            $(this).attr('href', imgData.src).find('img').attr('src', imgData.src);
                        }
                    });
                }
            });

            tabelBanner.on('draw', () => {
                reloadWidget();

                $('.btnHapusBanner').on('click', async function() {
                    const id = $(this).data('id');
                    const data = await fetchData('/api/banner.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;
                    const action = await toast({
                        title: 'Hapus Banner?',
                        message: 'Data banner: ' + data.title + ' akan dihapus permanen.',
                        icon: 'question'
                    });
                    if (action) {
                        const res = await fetchData({
                            url: '/api/banner.php?id=' + id,
                            method: 'DELETE'
                        }).catch(err => {
                            toast(err.responseJSON.message, 'error');
                            return false;
                        });
                        if (!res) return;
                        toast({
                            message: 'Data banner: <strong>' + data.title + '</strong> berhasil dihapus.',
                            icon: 'success',
                            delay: 5000,
                        });
                        tabelBanner.ajax.reload(null, false);
                    }
                });
            });

            $('#fileBanner').on('change', function() {
                const file = $(this).prop('files')[0];
                const inputElm = $(this);
                const previewElm = $('#previewBanner');

                inputElm.next('.invalid-feedback').remove();
                inputElm.removeClass('is-invalid');

                if (!file) return;

                const img = new Image();
                img.onload = function() {
                    const width = img.width;
                    const height = img.height;
                    const aspectRatio = width / height;
                    const tolerance = 0.5;
                    const targetRatio = 3;

                    if (Math.abs(aspectRatio - targetRatio) > tolerance) {
                        inputElm.addClass('is-invalid').after('<div class="invalid-feedback">Aspek rasio pada gambar yang diupload harus 3:1.</div>');
                        previewElm.attr('src', '').parent('a').attr('href', '').hide();
                        $('#btnSaveBanner').prop('disabled', true);
                    } else {
                        previewElm.attr('src', img.src).parent('a').attr('href', img.src).show();
                        $('#btnSaveBanner').prop('disabled', false);
                    }
                };
                img.src = URL.createObjectURL(file);
            });


            $('#btnSaveBanner').on('click', async function() {
                const btnElm = $(this);
                const fileElm = $('#fileBanner');
                const titleElm = $('#titleFileBanner');
                const description = $('#bannerDescription');

                if (!fileElm.val().trim() || !titleElm.val().trim() || fileElm.hasClass('is-invalid')) {
                    if (!fileElm.val().trim())
                        fileElm.addClass('is-invalid');
                    else fileElm.removeClass('is-invalid');
                    if (!titleElm.val().trim()) titleElm.addClass('is-invalid');
                    else titleElm.removeClass('is-invalid');
                    toast('Form isian belum valid.', 'error');
                    return;
                }
                $('.is-invalid').removeClass('is-invalid');
                toggleButton(btnElm, 'Menyimpan...');
                const file = fileElm.prop('files')[0];
                let image = new FormData();
                image.append('file', file);
                image.append('title', titleElm.val());

                const sendImage = await fetchData({
                    url: '/api/berkas.php',
                    data: image,
                    method: 'POST'
                }).catch(err => {
                    toast(err.responseJSON.message, 'error');
                    return false;
                });
                if (!sendImage) return;
                const setData = await fetchData({
                    url: '/api/banner.php',
                    data: {
                        title: titleElm.val(),
                        description: description.val(),
                        idBerkas: sendImage.data.id,
                    },
                    method: 'POST'
                }).catch(err => {
                    toast(err.responseJSON.message, 'error');
                    return false;
                });
                if (!setData) return;
                toggleButton(btnElm, 'Simpan');
                fileElm.val('');
                titleElm.val('');
                $('#modalTambahBanner').modal('hide');
                toast({
                    message: 'Data banner berhasil ditambahkan.',
                    icon: 'success',
                    delay: 5000
                });
                tabelBanner.ajax.reload(null, false);
            });

            const tabelEvent = $('#tabelEvent').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"],
                ],
                responsive: true,
                ordering: false,
                processing: true,
                pagingType: 'simple',
                ajax: {
                    url: '/api/event.php',
                    dataSrc: '',
                },
                columns: [{
                        data: 'id',
                        className: 'w-75',
                        render: (data, type, rows, meta) => {
                            const checked = rows.status == 1 ? 'checked' : '';
                            const label = rows.status == 1 ? 'Ditampilkan' : 'Tidak ditampilkan';
                            return ('<h6 class="mb-1">' + rows.name + '</h6>' +
                                '<div class="form-check form-switch">' +
                                '<input class="form-check-input btnSwitchEvent" data-id="' + data + '" type="checkbox" role="switch" id="' + data + '" ' + checked + '>' +
                                '<label class="form-check-label small text-muted" for="' + data + '">' + label + ' pada counter</label>' +
                                '</div>'
                            );
                        }
                    },
                    {
                        data: 'tanggal',
                        width: '120px',
                        className: 'text-center',
                        render: (data, type, rows, meta) => {
                            return tanggal(data, 'D F Y<br>H:i:s WIB')
                        }
                    },
                    {
                        width: '70px',
                        data: 'id',
                        className: 'text-center',
                        render: (data, type, rows, meta) => {
                            return ('<div class="btn-group btn-group-sm">' +
                                '<button type="button" class="btn btn-danger btnHapusEvent" data-id="' + data +
                                '" title="Hapus Event"><i class="bi bi-trash-fill"></i></button>' +
                                '</div>');
                        }
                    }
                ],
            });

            tabelEvent.on('draw', function() {
                reloadWidget();

                $('.btnHapusEvent').on('click', async function() {
                    const id = $(this).data('id');
                    const data = await fetchData('/api/event.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;
                    const conf = await toast({
                        title: 'Hapus Event?',
                        message: 'Data event: <strong>' + data.name + '</strong> akan dihapus permanen, anda yakin?',
                        icon: 'question'
                    });
                    if (!conf) return;
                    const res = await fetchData({
                        url: '/api/event.php?id=' + id,
                        method: 'DELETE'
                    }).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!res) return;
                    toast('Data event: <strong>' + data.name + '</strong> berhasil dihapus permanen.', 'success', null, 5000);
                    tabelEvent.ajax.reload(null, false);
                });

                $('.btnSwitchEvent').on('change', async function() {
                    const id = $(this).data('id');
                    const state = $(this).is(':checked') ? 1 : 0;
                    const data = await fetchData('/api/event.php?id=' + id).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!data) return;
                    const res = await fetchData({
                        url: '/api/event.php?id=' + id,
                        data: {
                            name: data.name,
                            tanggal: data.tanggal,
                            status: state,
                        },
                        method: 'POST',
                    }).catch(err => {
                        toast(err.responseJSON.message, 'error');
                        return false;
                    });
                    if (!res) {
                        $(this).prop('checked', !state);
                        return;
                    }
                    toast({
                        message: 'Status event: <strong>' + data.name + '</strong> berhasil diubah.',
                        icon: 'success',
                        delay: 5000,
                    });
                    tabelEvent.ajax.reload(null, false);
                });
            });

            $('#btnSaveEvent').on('click', async function() {
                const btn = $(this);
                const nameElm = $('#namaEvent');
                const tanggalElm = $('#tanggalEvent');
                if (!nameElm.val().trim() || !tanggalElm.val().trim()) {
                    if (!nameElm.val().trim()) nameElm.addClass('is-invalid');
                    else nameElm.removeClass('is-invalid');
                    if (!tanggalElm.val().trim()) tanggalElm.addClass('is-invalid');
                    else tanggalElm.removeClass('is-invalid');
                    toast('Lengkapi form terlebih dahulu.')
                    return;
                }
                toggleButton(btn, 'Menyimpan...');
                const res = await fetchData({
                    url: '/api/event.php',
                    data: {
                        name: nameElm.val(),
                        tanggal: tanggalElm.val(),
                        status: 1,
                    },
                    method: 'POST'
                }).catch(err => {
                    toast(err.responseJSON.message, 'error');
                    return false;
                });
                if (!res) {
                    toggleButton(btn, 'Simpan');
                    return;
                }
                toggleButton(btn, 'Simpan');
                nameElm.val('');
                tanggalElm.val('');
                $('#modalTambahEvent').modal('hide');
                toast({
                    message: 'Data event: <strong>' + nameElm.val() + '</strong> berhasil disimpan.',
                    icon: 'success',
                    delay: 5000
                });
                tabelEvent.ajax.reload(null, false);
            });
        });
    </script>
</body>

</html>