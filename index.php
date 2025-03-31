<?php
require_once './core/functions.php';
require_once './core/DBBuilder.php';
$db = new DBBuilder();

$data['banner'] =
  $db
  ->table('banner')
  ->select('banner.title, description, src')
  ->join('berkas', 'banner.berkas_id = berkas.berkas_id', 'LEFT')
  ->findAll();
$data['tautan'] =
  $db
  ->table('tautan')
  ->where('aktif', true)
  ->findAll();
$data['on_menu'] =
  $db
  ->table('tautan')
  ->where('aktif', true)
  ->where('on_menu', true)
  ->findAll();
$data['header'] =
  $db
  ->table('header')
  ->first();
$data['favicon'] =
  $db
  ->table('logo')
  ->where('type', 'favicon')
  ->first();
$data['heroes'] =
  $db
  ->table('heroes')
  ->first();
$data['jadwal'] =
  $db
  ->table('jadwal')
  ->findAll();
$data['jalur'] =
  $db
  ->table('jalur')
  ->findAll();
$data['syarat'] =
  $db
  ->table('syarat')
  ->first();
$data['dokumen'] =
  $db
  ->table('dokumen')
  ->first();
$data['identitas'] =
  $db
  ->table('identitas')
  ->first();

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
  ],
  'favicon' => [$data['favicon'] ? $data['favicon']['src'] : '']
]);
view('./view/templates/toogle-theme.php')

?>

<section class="sticky-top" id="mainHeader">
  <div class="col-lg-8 mx-auto bg-body shadow">
    <header class="d-flex p-3 align-items-center justify-content-between border-bottom">
      <a href="./" class="d-flex align-items-center text-body-emphasis text-decoration-none">
        <img src="" id="logo" alt="Logo SMPN 2 Wonosari" width="60" class="img-fluid h-100 me-2" />
        <div class="m-0 p-0 lh-1">
          <?= $data['header'] ? $data['header']['isi'] : '' ?>
        </div>
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
      <?= $data['heroes'] ? $data['heroes']['content'] : ''; ?>
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
      <div class="row d-flex flex-column flex-lg-row justify-content-center">
        <?php foreach ($data['jadwal'] as $jadwal): ?>
          <div class="col">
            <h5 class="text-body-emphasis"><?= $jadwal['title']; ?></h5>
            <p class="m-0">
              <?= $jadwal['content']; ?>
            </p>
          </div>
        <?php endforeach ?>
      </div>
    </div>

    <hr class="col-3 col-md-2 mb-2" />

    <h2 id="jalur-kuota" class="text-body-emphasis pt-3 mt-3">
      Jalur Pendaftaran & Kuota Peserta Didik
    </h2>
    <h1 class="text-lg-center py-3">
      <span class="fs-1 h1 fw-bold badge bg-success"><?= array_sum(array_column($data['jalur'], 'jumlah')) ?></span>
    </h1>
    <p class="text-lg-center mb-3">
      <span class="small">Peserta Didik</span>
    </p>
    <div class="row d-flex flex-column flex-lg-row justify-content-center">
      <?php foreach ($data['jalur'] as $jalur): ?>
        <div class="col">
          <h5 class="text-body-emphasis fw-bold"><?= $jalur['nama']; ?> (<?= $jalur['persen']; ?>%)</h5>
          <p class="fs-4"><?= $jalur['jumlah']; ?></p>
        </div>
      <?php endforeach ?>
    </div>

    <hr class="col-3 col-md-2 mb-2" />

    <div class="row">
      <div class="col-md-6">
        <h2 id="syarat" class="text-body-emphasis pt-3 mt-3">
          Syarat
        </h2>
        <?= $data['syarat'] ? $data['syarat']['content'] : ''; ?>
      </div>

      <div class="col-md-6">
        <h2 id="berkas" class="text-body-emphasis pt-3 mt-3">
          Berkas Upload
        </h2>
        <?= $data['dokumen'] ? $data['dokumen']['content'] : ''; ?>
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
          <textarea class="form-control pertanyaanAnda" placeholder="Pertanyaan anda" id="pertanyaanAnda" style="height: 100px;"></textarea>
          <label for="pertanyaanAnda">Pertanyaan anda.</label>
          <div class="invalid-feedback">Wajib.</div>
        </div>
        <button type="button" class="btn btn-sm btn-primary" id="btnKirimPertanyaan">Kirim</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
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
      <div class="col-md-6">
        <h2 id="official" class="text-body-emphasis pt-3 mt-3">
          Official
        </h2>
        <?php if ($data['identitas']) : ?>
          <h4 class="fw-bold"><?= $data['identitas']['nama']; ?></h4>
          <p class="small"><?= $data['identitas']['alamat']; ?></p>
          <div class="row">
            <div class="col">
              <?php $identitas = $data['identitas']; ?>
              <?php if ($identitas['telepon'] != ''): ?>
                <a type="button" target="_blank" href="tel:<?= $identitas['telepon']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-telephone-fill"></i></a>
              <?php endif ?>
              <?php if ($identitas['email'] != ''): ?>
                <a type="button" target="_blank" href="mailto:<?= $identitas['email']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-envelope-at-fill"></i></a>
              <?php endif ?>
              <?php if ($identitas['website'] != ''): ?>
                <a type="button" target="_blank" href="//<?= $identitas['website']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-browser-chrome"></i></a>
              <?php endif ?>
              <?php if ($identitas['maps'] != ''): ?>
                <a type="button" target="_blank" href="//<?= $identitas['maps']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-geo-alt-fill"></i></a>
              <?php endif ?>
              <?php if ($identitas['whatsapp'] != ''): ?>
                <a type="button" target="_blank" href="//wa.me/+62<?= $identitas['whatsapp']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-whatsapp"></i></a>
              <?php endif ?>
              <?php if ($identitas['telegram'] != ''): ?>
                <a type="button" target="_blank" href="//t.me/<?= $identitas['telegram']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-telegram"></i></a>
              <?php endif ?>
              <?php if ($identitas['facebook'] != ''): ?>
                <a type="button" target="_blank" href="//facebook.com/<?= $identitas['facebook']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-facebook"></i></a>
              <?php endif ?>
              <?php if ($identitas['instagram'] != ''): ?>
                <a type="button" target="_blank" href="//instagram.com/<?= $identitas['instagram']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-instagram"></i></a>
              <?php endif ?>
              <?php if ($identitas['x'] != ''): ?>
                <a type="button" target="_blank" href="//x.com/<?= $identitas['x']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-twitter-x"></i></a>
              <?php endif ?>
              <?php if ($identitas['tiktok'] != ''): ?>
                <a type="button" target="_blank" href="//tiktok.com/<?= $identitas['tiktok']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-tiktok"></i></a>
              <?php endif ?>
              <?php if ($identitas['threads'] != ''): ?>
                <a type="button" target="_blank" href="//threads.com/<?= $identitas['threads']; ?>" class="btn btn-sm btn-outline-primary my-1"><i class="bi bi-threads"></i></a>
              <?php endif ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer class="pt-5 my-5 px-5 text-body-secondary border-top d-flex flex-column flex-lg-row justify-content-between align-items-center text-center text-lg-start">
    <span class="m-0">
      &copy; 2024 Dibuat dan dikembangkan oleh
      <a href="https://muhsaidlg.my.id" target="_blank" class="text-decoration-none">Muhammad Said Latif Ghofari</a>
    </span>
    <a href="https://github.com/medigital-dev/PPDB_SMP-2-Wonosari" target="_blank" class="text-muted text-center text-lg-end text-decoration-none small"><i class="bi bi-github me-1"></i>v2.1.03_beta1</a>
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
              <input type="hidden" id="idIndukPublic">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" id="namaAndaBalasan" placeholder="Nama Anda">
                <label for="namaAndaBalasan">Nama Anda</label>
              </div>
              <div class="form-floating mb-2">
                <textarea class="form-control pertanyaanAnda" placeholder="Pertanyaan anda" id="pertanyaanAndaBalasan"></textarea>
                <label for="pertanyaanAndaBalasan">Balasan Anda</label>
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