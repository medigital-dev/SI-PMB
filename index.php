<?php
include 'functions.php';
$data['informasi'] = query('SELECT * FROM informasi ORDER BY created_at DESC LIMIT 8');
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
  <title>Info PPDB SMPN 2 Wonosari</title>

  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/bootstrap-icons.css" rel="stylesheet" />
  <link href="./assets/css/fancybox.css" rel="stylesheet" />
  <link href="./assets/css/datatables.min.css" rel="stylesheet" />
  <link href="./assets/css/style.css" rel="stylesheet" />

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="180x180" />
  <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="32x32" type="image/png" />
  <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="16x16" type="image/png" />
  <link rel="manifest" href="./assets/manifest.json" />
  <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" />
  <meta name="theme-color" content="#712cf9" />

</head>

<body>
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

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
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
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
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
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
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
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

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <symbol id="arrow-right-circle" viewBox="0 0 16 16">
      <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
    </symbol>
    <symbol id="bootstrap" viewBox="0 0 118 94">
      <title>Bootstrap</title>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z">
      </path>
    </symbol>
  </svg>

  <section class="sticky-top">
    <div class="col-lg-8 mx-auto">
      <header class="d-flex p-3 align-items-center justify-content-between border-bottom">
        <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
          <img src="./assets/images/smp2wonosari-shadow_black.png" alt="Logo SMPN 2 Wonosari" width="60" class="me-2" />
          <p class="m-0 p-0 lh-1">
            <span class="fs-4 fw-bold text-uppercase d-block">Info PPDB 2024</span>
            <span class="fs-5 fw-bold d-block">SMPN 2 Wonosari</span>
          </p>
        </a>
        <div class="d-flex">
          <a href="https://ppdb.pendidikan.gunungkidulkab.go.id/" target="_blank" class="btn btn-primary mx-1 d-none d-lg-block d-sm-block">Daftar</a>
          <a href="https://chat.whatsapp.com/GKjS4ZwfHqb2HQEVthtleC" class="btn btn-success mx-1 d-none d-lg-block d-sm-block" target="_blank">WA
            Group</a>
          <button class="btn btn-link" title="Menu" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Selamat Datang</a></li>
            <li>
              <a class="dropdown-item" href="#countdown">Countdown</a>
            </li>
            <li>
              <a class="dropdown-item" href="#informasi">Informasi</a>
            </li>
            <li>
              <a class="dropdown-item" href="#peraturan">Peraturan</a>
            </li>
            <li><a class="dropdown-item" href="#unduhan">Unduhan</a></li>
            <li>
              <a class="dropdown-item" href="#pelaksanaan">Pelaksanaan</a>
            </li>
            <li>
              <a class="dropdown-item" href="#jalur-kuota">Jalur dan Kuota</a>
            </li>
            <li><a class="dropdown-item" href="#syarat">Syarat</a></li>
            <li>
              <a class="dropdown-item" href="#berkas">Berkas Upload</a>
            </li>
            <li><a class="dropdown-item" href="#link">Link</a></li>
            <li><a class="dropdown-item" href="#wa-group">WA Group</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="./login.php">Sign In</a></li>
          </ul>
        </div>
      </header>
    </div>
  </section>
  <div class="col-lg-8 mx-auto p-4 py-md-5">
    <main>
      <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./assets/images/banner-welcome.jpg" class="d-block img-fluid img-thumbnail" alt="banner 1" />
          </div>
        </div>
      </div>
      <h3 class="text-body-emphasis">Selamat Datang di Laman</h3>
      <h1 class="text-body-emphasis">Info PPDB SMPN 2 Wonosari 2024</h1>
      <p class="fs-5">
        Selamat datang di Laman Pusat Informasi Penerimaan Peserta Didik Baru
        (PPDB) SMP Negeri 2 Wonosari Tahun Pelajaran 2024/2025. Segala
        informasi terkait PPDB akan kami infokan di halaman ini.
      </p>

      <hr class="col-3 col-md-2 mb-2" />

      <div class="row">
        <h2 id="countdown" class="text-body-emphasis" style="padding-top: 7rem">
          Countdown
        </h2>
        <p class="text-lg-center fs-4 lh-1 mb-4 fw-bold" id="eventName"></p>
        <div class="row row-cols-lg-4 row-cols-sm-4 row-cols-2 gy-3">
          <div class="col">
            <div class="days-container mx-auto">
              <div class="days"></div>
              <div class="days-label">Hari</div>
            </div>
          </div>
          <div class="col">
            <div class="hours-container mx-auto">
              <div class="hours"></div>
              <div class="hours-label">Jam</div>
            </div>
          </div>
          <div class="col">
            <div class="minutes-container mx-auto">
              <div class="minutes"></div>
              <div class="minutes-label">Menit</div>
            </div>
          </div>
          <div class="col">
            <div class="seconds-container mx-auto">
              <div class="seconds"></div>
              <div class="seconds-label">Detik</div>
            </div>
          </div>
        </div>
      </div>

      <hr class="col-3 col-md-2 mb-2" />

      <div class="row">
        <div class="col-md-8">
          <div class="row d-flex justify-content-between mb-2" style="padding-top: 7rem">
            <div class="col-4">
              <h2 id="informasi" class="text-body-emphasis">
                Informasi
              </h2>
            </div>
            <div class="col-auto">
              <input type="text" id="seach" placeholder="Cari" class="form-control">
            </div>
          </div>
          <div class="list-group mb-4">
            <?php foreach ($data['informasi'] as $row) : ?>
              <a type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1"><?= $row['judul']; ?></h5>
                  <small class="text-muted"><?= timeAgo($row['created_at']); ?></small>
                </div>
                <p class="mb-1"><?= $row['isi']; ?></p>
              </a>
            <?php endforeach; ?>

          </div>
          <div class="btn-group btn-group-sm">
            <button type="button" href="#" class="btn btn-outline-secondary"><i class="bi bi-chevron-left"></i></button>
            <button type="button" href="#" class="btn btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
          </div>
          <hr class="col-3 col-md-2 mb-2" />
        </div>
        <div class="col-md-4">
          <h2 id="peraturan" class="text-body-emphasis" style="padding-top: 7rem">
            Peraturan
          </h2>
          <ul class="list-unstyled ps-0">
            <li>
              <a class="icon-link mb-1" target="_blank" href="files/permendikbud-1-2021.pdf">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Permendikbud No 1 Tahun 2021
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="files/Perbup_PPDB_2024.pdf">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Peraturan Bupati GK - PPDB
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="files/pedoman_ppdb_2024-2025.pdf">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Pedoman PPDB 2024-2025
              </a>
            </li>
          </ul>
          <hr class="col-3 col-md-2 mb-2" />
          <h2 id="unduhan" class="text-body-emphasis" style="padding-top: 7rem">
            Unduhan
          </h2>

          <hr class="col-3 col-md-2 mb-2" />
        </div>
      </div>

      <div class="row">
        <h2 id="pelaksanaan" class="text-body-emphasis" style="padding-top: 7rem">
          Pelaksanaan
        </h2>
        <div class="col-md-3">
          <h5 class="text-body-emphasis">Pendaftaran</h5>
          <p class="">
            Senin-Rabu <br />
            24 - 26 Juni 2024<br>
            <span>Ditutup: 26 Juni 2024 pukul 15.30 WIB</span>
          </p>
        </div>
        <div class="col-md-3">
          <h5 class="text-body-emphasis">Seleksi</h5>
          <p class="">Rabu<br />26 Juni 2024<br>
            Diakhiri pukul 15.45 WIB</p>
        </div>
        <div class="col-md-3">
          <h5 class="text-body-emphasis">Pengumuman</h5>
          <p class="">Jumat<br />28 Juni 2024 <br> Pukul 10.00 WIB</p>
        </div>
        <div class="col-md-3">
          <h5 class="text-body-emphasis">Daftar Ulang</h5>
          <p class="">Senin-Selasa<br />1 - 2 Juli 2024<br>Pada jam kerja.</p>
        </div>
      </div>

      <hr class="col-3 col-md-2 mb-2" />

      <h2 id="jalur-kuota" class="text-body-emphasis" style="padding-top: 7rem">
        Jalur Pendaftaran & Kuota Peserta Didik
      </h2>
      <h1 class="text-lg-center">
        <span class="fs-1 h1 fw-bold badge bg-success">224</span>
      </h1>
      <p class="text-lg-center mb-3">
        <span class="small">Peserta Didik</span>
      </p>
      <div class="row">
        <div class="col-sm-3">
          <h5 class="text-body-emphasis">Zonasi (55%)</h5>
          <p class="fs-3">123</p>
        </div>
        <div class="col-sm-3">
          <h5 class="text-body-emphasis">Afirmasi (15%)</h5>
          <p class="fs-3">34</p>
        </div>
        <div class="col-sm-3">
          <h5 class="text-body-emphasis">Perpindahan (5%)</h5>
          <p class="fs-3">11</p>
        </div>
        <div class="col-sm-3">
          <h5 class="text-body-emphasis">Prestasi (25%)</h5>
          <p class="fs-3">56</p>
        </div>
      </div>

      <hr class="col-3 col-md-2 mb-2" />

      <div class="row">
        <div class="col-md-6">
          <h2 id="syarat" class="text-body-emphasis" style="padding-top: 7rem">
            Syarat
          </h2>

          <ul class="list-group">
            <li class="list-group-item">
              Berusia paling tinggi 15 (lima belas) tahun pada tanggal 1 Juli 2024;
            </li>
            <li class="list-group-item">
              Telah menyelesaikan kelas 6 (enam) SD atau sederajat dengan
              dibuktikan dengan ijazah atau dokumen lain yang menyatakan
              kelulusan;
            </li>
            <li class="list-group-item">
              Telah melengkapi data pada Data Pokok Pendidikan di sekolah
              asal, bagi calon peserta didik dari jenjang SD;
            </li>
            <li class="list-group-item">
              Memiliki Kartu Keluarga yang diterbitkan paling singkat 1 (satu) tahun sebelum pelaksanaan PPDB kecuali
              pada jalur perpindahan orang tua;
            </li>
            <li class="list-group-item">
              Memiliki Akta Kelahiran, apabila saat mendaftar belum memiliki maka orang
              tua/wali harus melampirkan surat pernyataan kesanggupan
              melengkapi.
            </li>
            <li class="list-group-item">
              Apabila terdapat calon peserta didik baru, baik warga negara Indonesia
              atau warga negara asing untuk kelas 7 (tujuh) yang berasal dari
              sekolah di luar negeri, selain memenuhi persyaratan wajib
              mendapatkan surat keterangan dari Direktur Jenderal di Kemendikbud
              Ristek Republik Indonesia yang menangani bidang pendidikan dasar
              dan menengah;
            </li>
            <li class="list-group-item">
              Peserta didik warga negara asing wajib mengikuti matrikulasi
              pendidikan Bahasa Indonesia paling singkat 6 bulan yang
              diselenggarakan oleh Sekolah yang bersangkutan;
            </li>
            <li class="list-group-item">
              Pembuatan akun pendaftaran dan penitikan domisili bagi pendaftar
              yang berasal dari luar Kabupaten Gunungkidul (termasuk untuk
              sekolah SMP perbatasan) dilaksanakan di sekolah tujuan atau Dinas
              Pendidikan pada hari Senin s.d. Jumat tanggal 10 s.d. 14 Juni 2024.
            </li>
          </ul>
        </div>

        <div class="col-md-6">
          <h2 id="berkas" class="text-body-emphasis" style="padding-top: 7rem">
            Berkas Upload
          </h2>

          <ul class="list-group">
            <li class="list-group-item">Bukti cetak pendaftaran online;</li>
            <li class="list-group-item">scan surat Pernyataan Tanggungjawab Mutlak bermaterai yang
              ditandatangani oleh orangtua/wali (diunduh dari laman PPDB)
            </li>
            <li class="list-group-item">Scan ijazah atau surat keterangan kelulusan;</li>
            <li class="list-group-item">Scan pas foto 3x4;</li>
            <li class="list-group-item">Scan Akte Kelahiran atau surat keterangan lahir;</li>
            <li class="list-group-item">Scan Kartu Keluarga atau surat keterangan domisili;</li>
            <li class="list-group-item">
              Bukti keikutsertaan dalam program penanganan keluarga tidak
              mampu dari Pemerintah Pusat atau Pemerintah Daerah (Afirmasi);
            </li>
            <li class="list-group-item">
              Scan surat penyandang disabilitas/berkebutuhan khusus
              (Afirmasi);
            </li>
            <li class="list-group-item">
              Scan surat pindah tugas orangtua dari instansi, lembaga, kantor,
              atau perusahaan yang mempekejakan (Perpindahan Orangtua/Wali);
            </li>
            <li class="list-group-item">
              Scan surat keputusan Orangtua/Wali bagi calon peserta didik yang
              orangtuanya mengajar di sekolah tersebut (Perpindahan
              Orangtua/Wali);
            </li>
            <li class="list-group-item">
              Scan surat keterangan yang mencantumkan rata-rata nilai dan
              peringkat nilai rapor 3 (tiga) mata pelajaran (Matematika,
              Bahasa Indonesia, dan IPA) dalam 5 (lima) semester terakhir
              (Prestasi);
            </li>
            <li class="list-group-item">Scan SHASPD atau surat pengganti SHASPD (Prestasi);</li>
            <li class="list-group-item">
              Scan bukti hasil perlombaan dan/atau penghargaan (Prestasi);
            </li>
          </ul>
        </div>
      </div>

      <hr class="col-3 col-md-2 mb-2" />

      <div class="row">
        <div class="col-md-8">
          <h2 id="link" class="text-body-emphasis" style="padding-top: 7rem">
            Link
          </h2>
          <ul class="list-unstyled ps-0">
            <li>
              <p class="mb-0">PPDB</p>
              <a class="icon-link mb-1" target="_blank" href="https://ppdb.pendidikan.gunungkidulkab.go.id">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Pendaftaran PPDB
              </a>
            </li>

            <hr class="col-3 col-md-2" />
            <p class="mb-0">Official</p>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://www.smp2wonosari.sch.id">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Website SMPN 2 Wonosari
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://instagram.com/smp2wonosari">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Instagram
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://facebook.com/smp2wonosari">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Facebook
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://twitter.com/smp2wonosari">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Twitter
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://wa.me/+6281227774007">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                WA Bussiness
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="mailto:hi@smp2wonosari.sch.id">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Email Us
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="phone:+62274391037">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Telepon
              </a>
            </li>
            <li>
              <a class="icon-link mb-1" target="_blank" href="https://goo.gl/maps/8FMryRA6vSWdNgg4A">
                <svg class="bi" width="16" height="16">
                  <use xlink:href="#arrow-right-circle" />
                </svg>
                Maps
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <h2 id="wa-group" class="text-body-emphasis" style="padding-top: 7rem">
            WA Grup
          </h2>
          <img src="./assets/images/wagroup.jpg" alt="WA Group" class="img-fluid img-thumbnail" height="150" />
          <p>
            <a href="https://chat.whatsapp.com/GKjS4ZwfHqb2HQEVthtleC" target="_blank">Klik disini untuk bergabung</a>
          </p>
        </div>
      </div>
    </main>

    <footer class="pt-5 my-5 text-body-secondary border-top justify-content-lg-between d-lg-flex d-block text-center text-lg-start">
      <span class="m-0">
        &copy; 2023-2024 Dibuat dan dikembangkan oleh
        <a href="https://muhsaidlg.my.id" target="_blank" class="text-decoration-none">Muhammad Said Latif Ghofari</a>
      </span>
      <span class="m-0 text-muted text-end">v2024.01</span>
    </footer>
  </div>

  <script src="./assets/js/jquery.min.js"></script>
  <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/datatables.min.js"></script>
  <script src="./assets/js/fancybox.umd.js"></script>

  <script>
    const dataEvent = [
      /*
              ['event name', 'date']
          */
      ["Mulai Pendaftaran PPDB", "2024-06-24T08:00:00"],
      ["Akhir Pendaftaran PPDB", "2024-06-26T15:30:00"],
      ["Seleksi Akhir", "2024-06-26T15:45:00"],
      ["Pengumuman PPDB", "2024-06-28T10:00:00"],
      ["Daftar Ulang", "2024-07-01T08:00:00"],
      ["Akhir Daftar Ulang", "2024-07-02T14:00:00"],
    ];

    const countDownClock = (number = 100, format = "seconds") => {
      const d = document;
      const daysElement = d.querySelector(".days");
      const hoursElement = d.querySelector(".hours");
      const minutesElement = d.querySelector(".minutes");
      const secondsElement = d.querySelector(".seconds");
      let countdown;
      convertFormat(format);

      function convertFormat(format) {
        switch (format) {
          case "seconds":
            return timer(number);
          case "minutes":
            return timer(number * 60);
          case "hours":
            return timer(number * 60 * 60);
          case "days":
            return timer(number * 60 * 60 * 24);
        }
      }

      function timer(seconds) {
        const now = Date.now();
        const then = now + seconds * 1000;

        countdown = setInterval(() => {
          const secondsLeft = Math.round((then - Date.now()) / 1000);

          if (secondsLeft <= 0) {
            clearInterval(countdown);
            return;
          }

          displayTimeLeft(secondsLeft);
        }, 1000);
      }

      function displayTimeLeft(seconds) {
        daysElement.textContent = Math.floor(seconds / 86400);
        hoursElement.textContent = Math.floor((seconds % 86400) / 3600);
        minutesElement.textContent = Math.floor(
          ((seconds % 86400) % 3600) / 60
        );
        secondsElement.textContent =
          seconds % 60 < 10 ? `0${seconds % 60}` : seconds % 60;
      }
    };

    /*
        start countdown
        enter number and format
        days, hours, minutes or seconds
      */

    let i;
    var eventName = document.querySelector("#eventName");
    var today = new Date();
    for (i = 0; i < dataEvent.length; i++) {
      var target = new Date(dataEvent[i][1]);
      var diff = (target.getTime() - today.getTime()) / 1000;
      if (diff > 0) {
        countDownClock(diff, "seconds");
        eventName.innerHTML =
          dataEvent[i][0] +
          '<br><span class="small fs-6">(' +
          target.getDate() +
          "-" +
          (target.getMonth() + 1) +
          "-" +
          target.getFullYear() +
          ")</span>";
        break;
      }
    }
  </script>
  <script>
    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });
    $(document).ready(function() {
      $("#table").DataTable({
        lengthMenu: [
          [5, 25, 50, -1],
          [5, 25, 50, "All"],
        ],
        order: [
          [0, "desc"]
        ],
        language: {
          paginate: {
            previous: "Newest",
            next: "Olders",
          },
        },
        columnDefs: [{
          targets: [1],
          orderable: false,
        }, ],
      });
    });
  </script>
</body>

</html>