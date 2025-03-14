<?php
require './core/functions.php';
$data['banner'] = query("SELECT banner.title, `description`, `order`, src FROM banner LEFT JOIN berkas ON banner.berkas_id =  berkas.berkas_id");
$data['tautan'] = query("SELECT * FROM tautan WHERE aktif = 1");
$data['on_menu'] = query("SELECT * FROM tautan WHERE aktif = 1 AND on_menu = 1");

view('./view/templates/head.php', [
  'title' => 'Informasi PPDB SMPN 2 Wonosari 2025',
  'style' => [
    '/plugins/bootstrap/bootstrap.min.css',
    '/plugins/bootstrap-icon/bootstrap-icons.css',
    '/plugins/summernote/summernote-bs4.css',
    '/plugins/fancybox/fancybox.css',
    '/plugins/datatables/datatables.min.css',
    '/assets/css/style.css'
  ],
  'body' => [
    'className' => 'bg-body'
  ]
]);
view('./view/templates/toogle-theme.php')

?>

<section class="sticky-top" id="mainHeader">
  <div class="col-lg-8 mx-auto bg-body shadow">
    <header class="d-flex p-3 align-items-center justify-content-between border-bottom">
      <a href="./" class="d-flex align-items-center text-body-emphasis text-decoration-none">
        <img src="" id="logo" alt="Logo SMPN 2 Wonosari" width="60" class="img-fluid h-100 me-2" />
        <p class="m-0 p-0 lh-1">
          <span class="fs-4 fw-bold text-uppercase d-block">Info PPDB 2024</span>
          <span class="fs-5 fw-bold d-block">SMPN 2 Wonosari</span>
        </p>
      </a>
      <div class="d-flex">
        <div class="btn-group">
          <?php foreach ($data['on_menu'] as $link): ?>
            <a href="<?= $link['url']; ?>" target="_blank" class="btn btn-outline-primary d-none d-lg-block d-sm-block"><?= $link['title']; ?></a>
          <?php endforeach; ?>
        </div>
        <button class="btn btn-link" title="Menu" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-three-dots-vertical"></i>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#banner">Banner</a></li>
          <li><a class="dropdown-item" href="#welcome">Welcome</a></li>
          <li><a class="dropdown-item" href="#countdown">Countdown</a></li>
          <li><a class="dropdown-item" href="#informasi">Informasi</a></li>
          <li><a class="dropdown-item" href="#unduhan">Unduhan</a></li>
          <li><a class="dropdown-item" href="#pelaksanaan">Pelaksanaan</a></li>
          <li><a class="dropdown-item" href="#jalur-kuota">Jalur dan Kuota</a></li>
          <li><a class="dropdown-item" href="#syarat">Syarat</a></li>
          <li><a class="dropdown-item" href="#berkas">Berkas Upload</a></li>
          <li><a class="dropdown-item" href="#forum">Forum</a></li>
          <li><a class="dropdown-item" href="#pertanyaan">Pertanyaan Anda</a></li>
          <li><a class="dropdown-item" href="#link">Link</a></li>
          <li><a class="dropdown-item" href="#official">Official</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="./auth/login.php">Sign In</a></li>
        </ul>
      </div>
    </header>
  </div>
</section>
<div class="col-lg-8 mx-auto p-4 py-md-5 bg-body shadow-lg">
  <main class="px-lg-5">
    <div id="banner" class="pt-3 mt-3 text-body-emphasis">
      <div id="carousel" class="carousel slide carousel-fade mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php $i = 0;
          foreach ($data['banner'] as $banner) : ?>
            <div class="carousel-item <?= $i == 0 ? 'active' : ''; ?>">
              <a href="<?= $banner['src']; ?>" data-fancybox="banner-hero">
                <img src="<?= $banner['src']; ?>" class="d-block img-fluid" />
              </a>
            </div>
            <?php $i++; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div id="welcome" class="pt-3 mt-3 text-body-emphasis">
      <h3 class="text-body-emphasis">Selamat Datang di Laman</h3>
      <h1 class="text-body-emphasis">Info PPDB SMPN 2 Wonosari 2024</h1>
      <p class="fs-5">
        Selamat datang di Laman Pusat Informasi Penerimaan Peserta Didik Baru
        (PPDB) SMP Negeri 2 Wonosari Tahun Pelajaran 2024/2025. Segala
        informasi terkait PPDB akan kami infokan di halaman ini.
      </p>
    </div>

    <hr class="col-3 col-md-2 mb-2" />

    <div class="row">
      <h2 id="countdown" class="text-body-emphasis pt-3 mt-3">
        Countdown
      </h2>
      <div id="eventName"></div>
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
        <div class="row d-flex justify-content-between mb-2">
          <div class="col-4">
            <h2 id="informasi" class="text-body-emphasis pt-3 mt-3">
              Informasi
            </h2>
          </div>
          <div class="col-auto pt-3 mt-3">
            <input type="text" id="cariInfo" placeholder="Cari" class="form-control">
          </div>
        </div>
        <table class="table table-hover" id="tabelInfoPublic">
          <thead>
            <tr>
              <th>Daftar Informasi</th>
            </tr>
          </thead>
        </table>
        <hr class="col-3 col-md-2 mb-2" />
      </div>
      <div class="col-md-4">
        <h2 id="unduhan" class="text-body-emphasis pt-3 mt-3">
          Unduhan
        </h2>
        <table class="table table-hover" id="tabelUnduhan">
          <thead>
            <tr>
              <th>Daftar Berkas</th>
            </tr>
          </thead>
        </table>
        <hr class="col-3 col-md-2 mb-2" />
      </div>
    </div>

    <div class="row">
      <h2 id="pelaksanaan" class="text-body-emphasis pt-3 mt-3">
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

    <h2 id="jalur-kuota" class="text-body-emphasis pt-3 mt-3">
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
        <h2 id="syarat" class="text-body-emphasis pt-3 mt-3">
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
        <h2 id="berkas" class="text-body-emphasis pt-3 mt-3">
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
        <div class="row d-flex justify-content-between mb-2">
          <div class="col-6">
            <h2 id="forum" class="text-body-emphasis pt-3 mt-3">
              Forum Diskusi
            </h2>
          </div>
          <div class="col-auto pt-3 mt-3">
            <input type="text" id="cariForum" placeholder="Cari" class="form-control">
          </div>
        </div>
        <table class="table table-hover" id="tabelForumPublic">
          <thead>
            <tr>
              <th>Daftar Pertanyaan</th>
            </tr>
          </thead>
        </table>
        <hr class="col-3 col-md-2 mb-2" />
      </div>
      <div class="col-md-4">
        <h2 id="pertanyaan" class="text-body-emphasis pt-3 mt-3">
          Pertanyaan anda
        </h2>
        <div class="form-text mb-2">Silahkan sampaikan pertanyaan anda pada form berikut.</div>
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="namaAnda" placeholder="Nama Anda">
          <label for="namaAnda">Nama Anda</label>
        </div>
        <div class="form-floating mb-2">
          <textarea class="form-control pertanyaanAnda" placeholder="Pertanyaan anda" id="pertanyaanAnda"></textarea>
          <div class="invalid-feedback">Wajib.</div>
        </div>
        <button type="button" class="btn btn-sm btn-primary" id="btnKirimPertanyaan">Kirim</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <h2 id="link" class="text-body-emphasis pt-3 mt-3">
          Link PPDB
        </h2>
        <ul class="list-unstyled ps-0">
          <?php foreach ($data['tautan'] as $tautan): ?>
            <li>
              <a class="icon-link mb-1" target="_blank" href="<?= $tautan['url']; ?>">
                <i class="bi bi-browser-chrome me-1"></i>
                <?= $tautan['title']; ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-md-4">
        <h2 id="official" class="text-body-emphasis pt-3 mt-3">
          Link Official
        </h2>
        <ul class="list-unstyled ps-0">
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://www.smp2wonosari.sch.id">
              <i class="bi bi-browser-chrome me-1"></i>
              Website SMPN 2 Wonosari
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://instagram.com/smp2wonosari">
              <i class="bi bi-browser-chrome me-1"></i>
              Instagram
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://facebook.com/smp2wonosari">
              <i class="bi bi-browser-chrome me-1"></i>
              Facebook
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://twitter.com/smp2wonosari">
              <i class="bi bi-browser-chrome me-1"></i>
              Twitter
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://wa.me/+6281227774007">
              <i class="bi bi-browser-chrome me-1"></i>
              WA Bussiness
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="mailto:hi@smp2wonosari.sch.id">
              <i class="bi bi-browser-chrome me-1"></i>
              Email Us
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="phone:+62274391037">
              <i class="bi bi-browser-chrome me-1"></i>
              Telepon
            </a>
          </li>
          <li>
            <a class="icon-link mb-1" target="_blank" href="https://goo.gl/maps/8FMryRA6vSWdNgg4A">
              <i class="bi bi-browser-chrome me-1"></i>
              Maps
            </a>
          </li>
        </ul>
      </div>
    </div>
  </main>

  <footer class="pt-5 my-5 px-5 text-body-secondary border-top d-flex flex-column flex-lg-row justify-content-between align-items-center text-center text-lg-start">
    <span class="m-0">
      &copy; 2024 Dibuat dan dikembangkan oleh
      <a href="https://muhsaidlg.my.id" target="_blank" class="text-decoration-none">Muhammad Said Latif Ghofari</a>
    </span>
    <a href="https://github.com/medigital-dev/PPDB_SMP-2-Wonosari" target="_blank" class="text-muted text-center text-lg-end text-decoration-none small"><i class="bi bi-github me-1"></i>v25.03.001</a>
  </footer>
</div>

<div class="modal fade" id="modalDetailForumPublic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailForumPublicLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDetailForumPublic">Forum Diskusi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-0">
        <div class="" id="jawaban">
          <div class="d-flex align-items-center">
            <strong role="status">Memuat balasan...</strong>
            <div class="spinner-border spinner-border-sm ms-auto" aria-hidden="true"></div>
          </div>
        </div>
        <div class="sticky-bottom py-2 bg-body">
          <div class="collapse" id="collapse-balas">
            <div class="card card-body border-primary shadow">
              <input type="hidden" id="idForumPublic">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" id="namaAndaBalasan" placeholder="Nama Anda">
                <label for="namaAndaBalasan">Nama Anda</label>
              </div>
              <div class="form-floating mb-2">
                <textarea class="form-control pertanyaanAnda" placeholder="Pertanyaan anda" id="pertanyaanAndaBalasan"></textarea>
                <div class="invalid-feedback">Wajib.</div>
              </div>
              <div>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#collapse-balas">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="btnKirimBalasan">Kirim</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php view('./view/templates/footer.php', [
  'script' => [
    './plugins/jquery/jquery.min.js',
    './plugins/bootstrap/bootstrap.bundle.min.js',
    '/plugins/summernote/summernote-bs4.js',
    '/plugins/summernote/summernote-file.js',
    '/plugins/datatables/datatables.min.js',
    './plugins/fancybox/fancybox.umd.js',
    '/plugins/fetchData/fetchData.js',
    '/plugins/simple-toast/toast.js',
    '/assets/js/functions.js',
    '/assets/js/global.js',
    '/assets/js/homepage.js',
    '/assets/js/header-autohide.js'
  ]
]); ?>