<section>
    <div class="container pb-5">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 mb-4">
            <div class="col">
                <div class="card card-body shadow text-bg-primary bg-gradient">
                    <h6 class="card-title">Informasi</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalInfo">0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-body shadow text-bg-secondary bg-gradient">
                    <h6 class="card-title">Banner</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalBanner">0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-body shadow text-bg-danger bg-gradient">
                    <h6 class="card-title">Event</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalEvent">0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-body shadow text-bg-success bg-gradient">
                    <h6 class="card-title">Berkas</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalBerkas">0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-body shadow text-bg-warning bg-gradient">
                    <h6 class="card-title">Tautan</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalTautan">0</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-body shadow text-bg-info bg-gradient">
                    <h6 class="card-title">Diskusi</h6>
                    <div class="d-flex justify-content-between">
                        <span class="h1 fs-1 m-0" id="totalForum">0</span>
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
                        <button class="nav-link text-start" id="v-pills-tautan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tautan" type="button" role="tab" aria-controls="v-pills-tautan" aria-selected="true">Tautan</button>
                        <button class="nav-link text-start" id="v-pills-forum-tab" data-bs-toggle="pill" data-bs-target="#v-pills-forum" type="button" role="tab" aria-controls="v-pills-forum" aria-selected="true">Forum</button>
                        <button class="nav-link text-start" id="v-pills-pengaturan-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pengaturan" type="button" role="tab" aria-controls="v-pills-pengaturan" aria-selected="true">Pengaturan</button>
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
                                <table class="table table-bordered table-hover w-100" id="tabelBerkas">
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
                                <table class="table table-bordered table-hover w-100" id="tabelBanner">
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
                                <table class="table table-bordered table-hover w-100" id="tabelEvent">
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
                <div class="tab-pane fade" id="v-pills-tautan" role="tabpanel" aria-labelledby="v-pills-tautan-tab" tabindex="0">
                    <div class="card shadow mb-4">
                        <div class="card-header text-bg-primary">Data Tautan</div>
                        <div class="card-body">
                            <div class="sticky-top py-2 bg-body">
                                <div class="btn-toolbar">
                                    <div class="btn-group btn-group-sm my-1 me-1">
                                        <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelTautan"><i class="bi bi-arrow-repeat"></i></button>
                                        <button type="button" class="btn btn-primary" title="Tambah Banner" id="btnTambahTautan" data-bs-toggle="modal" data-bs-target="#modalTambahTautan"><i class="bi bi-plus-circle"></i></button>
                                    </div>
                                    <div class="input-group input-group-sm my-1 ms-auto">
                                        <input type="text" class="form-control" id="searchTabelTautan" placeholder="Cari Tautan">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover w-100" id="tabelTautan">
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
                <div class="tab-pane fade" id="v-pills-forum" role="tabpanel" aria-labelledby="v-pills-forum-tab" tabindex="0">
                    <div class="card shadow mb-4">
                        <div class="card-header text-bg-primary">Forum Diskusi</div>
                        <div class="card-body">
                            <div class="sticky-top py-2 bg-body">
                                <div class="btn-toolbar">
                                    <div class="btn-group btn-group-sm my-1 me-1">
                                        <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelForum"><i class="bi bi-arrow-repeat"></i></button>
                                    </div>
                                    <div class="input-group input-group-sm my-1 ms-auto">
                                        <input type="text" class="form-control" id="searchTabelForum" placeholder="Cari Forum">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover w-100" id="tabelForum">
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
                <div class="tab-pane fade" id="v-pills-pengaturan" role="tabpanel" aria-labelledby="v-pills-pengaturan-tab" tabindex="0">
                    <div class="card shadow mb-4">
                        <div class="card-header text-bg-primary">Pengaturan Aplikasi</div>
                        <div class="card-body">
                            <div class="d-flex flex-column flex-lg-row align-items-start">
                                <div class="nav flex-lg-column flex-row nav-pills me-lg-4 justify-content-center mb-sm-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link text-start active" id="v-pills-identitas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-identitas" type="button" role="tab" aria-controls="v-pills-identitas" aria-selected="true">Identitas</button>
                                    <button class="nav-link text-start" id="v-pills-logo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-logo" type="button" role="tab" aria-controls="v-pills-logo" aria-selected="false">Logo</button>
                                    <button class="nav-link text-start" id="v-pills-header-tab" data-bs-toggle="pill" data-bs-target="#v-pills-header" type="button" role="tab" aria-controls="v-pills-header" aria-selected="false">Header</button>
                                    <button class="nav-link text-start" id="v-pills-heroes-tab" data-bs-toggle="pill" data-bs-target="#v-pills-heroes" type="button" role="tab" aria-controls="v-pills-heroes" aria-selected="false">Heroes</button>
                                    <button class="nav-link text-start" id="v-pills-jadwal-tab" data-bs-toggle="pill" data-bs-target="#v-pills-jadwal" type="button" role="tab" aria-controls="v-pills-jadwal" aria-selected="false">Jadwal</button>
                                    <button class="nav-link text-start" id="v-pills-jalur-tab" data-bs-toggle="pill" data-bs-target="#v-pills-jalur" type="button" role="tab" aria-controls="v-pills-jalur" aria-selected="false">Jalur</button>
                                    <button class="nav-link text-start" id="v-pills-syarat-tab" data-bs-toggle="pill" data-bs-target="#v-pills-syarat" type="button" role="tab" aria-controls="v-pills-syarat" aria-selected="false">Syarat</button>
                                    <button class="nav-link text-start" id="v-pills-dokumen-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dokumen" type="button" role="tab" aria-controls="v-pills-dokumen" aria-selected="false">Dokumen</button>
                                </div>
                                <div class="tab-content w-100" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-identitas" role="tabpanel" aria-labelledby="v-pills-identitas-tab" tabindex="0">
                                        <input type="hidden" id="idIdentitas" value="<?= $data['identitas'] ? $data['identitas']['identitas_id'] : '' ?>">
                                        <form id="formIdentitas">
                                            <div class="row mb-3">
                                                <label for="namaIndentitas" class="col-sm-2 col-form-label">Nama Sekolah</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="namaIndentitas" name="nama" value="<?= $data['identitas'] ? $data['identitas']['nama'] : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="alamatIdentitas" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamatIdentitas" name="alamat" value="<?= $data['identitas'] ? $data['identitas']['alamat'] : ''; ?>">
                                                </div>
                                            </div>
                                            <label class="form-label">Kontak dan Media Sosial</label>
                                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2">
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-telephone"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="text" class="form-control" id="telephoneIndentitas" name="telepon" value="<?= $data['identitas'] ? $data['identitas']['telepon'] : ''; ?>" placeholder="Nomor Telepon" aria-label="telephone" aria-describedby="basic-telephone">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-email"><i class="bi bi-envelope-at-fill"></i></span>
                                                        <input type="email" class="form-control" id="emailIdentitas" name="email" placeholder="Alamat email" value="<?= $data['identitas'] ? $data['identitas']['email'] : ''; ?>" aria-label="email" aria-describedby="basic-email">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-web"><i class="bi bi-browser-chrome"></i></span>
                                                        <input type="text" class="form-control" id="webIdentitas" name="website" placeholder="Alamat website" aria-label="web" aria-describedby="basic-web" value="<?= $data['identitas'] ? $data['identitas']['website'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-whatsapp"><i class="bi bi-whatsapp"></i></span>
                                                        <input type="text" class="form-control" id="whatsappIdentitas" name="whatsapp" placeholder="Nomor Whatsapp" aria-label="whatsapp" aria-describedby="basic-whatsapp" value="<?= $data['identitas'] ? $data['identitas']['whatsapp'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-telegram"><i class="bi bi-telegram"></i></span>
                                                        <input type="text" class="form-control" id="telegramIdentitas" name="telegram" placeholder="Nomor telegram" aria-label="telegram" aria-describedby="basic-telegram" value="<?= $data['identitas'] ? $data['identitas']['telegram'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-facebook"><i class="bi bi-facebook"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">@</span>
                                                        <input type="text" class="form-control" id="facebookIdentitas" name="facebook" placeholder="Akun facebook" aria-label="facebook" aria-describedby="basic-facebook" value="<?= $data['identitas'] ? $data['identitas']['facebook'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-instagram"><i class="bi bi-instagram"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">@</span>
                                                        <input type="text" class="form-control" id="instagramIdentitas" name="instagram" placeholder="Akun instagram" aria-label="instagram" aria-describedby="basic-instagram" value="<?= $data['identitas'] ? $data['identitas']['instagram'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-twitterX"><i class="bi bi-twitter-x"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">@</span>
                                                        <input type="text" class="form-control" id="twitterXIdentitas" name="x" placeholder="Akun X" aria-label="twitterX" aria-describedby="basic-twitterX" value="<?= $data['identitas'] ? $data['identitas']['x'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-threads"><i class="bi bi-threads"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">@</span>
                                                        <input type="text" class="form-control" id="threadsIdentitas" name="threads" placeholder="Akun threads" aria-label="threads" aria-describedby="basic-threads" value="<?= $data['identitas'] ? $data['identitas']['threads'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-tiktok"><i class="bi bi-tiktok"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">@</span>
                                                        <input type="text" class="form-control" id="tiktokIdentitas" name="tiktok" placeholder="Akun tiktok" aria-label="tiktok" aria-describedby="basic-tiktok" value="<?= $data['identitas'] ? $data['identitas']['tiktok'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-youtube"><i class="bi bi-youtube"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">url</span>
                                                        <input type="text" class="form-control" id="youtubeIdentitas" name="youtube" placeholder="Alamat youtube" aria-label="youtube" aria-describedby="basic-youtube" value="<?= $data['identitas'] ? $data['identitas']['youtube'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-maps"><i class="bi bi-geo-alt-fill"></i></span>
                                                        <span class="input-group-text" id="basic-facebook">url</span>
                                                        <input type="text" class="form-control" id="mapsIdentitas" name="maps" placeholder="Alamat maps" aria-label="maps" aria-describedby="basic-maps" value="<?= $data['identitas'] ? $data['identitas']['maps'] : ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-primary" id="btnSimpanIdentitas">Simpan</button>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-header" role="tabpanel" aria-labelledby="v-pills-header-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="isiHeader" class="form-label">Header Homepage</label>
                                            <div id="isiHeader" class="form-control py-4">
                                                <?= $data['header'] ? $data['header']['isi'] : '' ?>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?= $data['header'] ? $data['header']['header_id'] : '' ?>" id="idHeader">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnEditHeader">Edit</button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnSaveHeader">Simpan</button>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-logo" role="tabpanel" aria-labelledby="v-pills-logo-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-3">
                                                    <label for="fileDark" class="form-label">Mode Gelap</label>
                                                    <input type="hidden" id="idDark" value="<?= $data['logo']['dark'] ? $data['logo']['dark']['logo_id'] : ''; ?>">
                                                    <div class="border-primary p-4 mb-2 text-center text-bg-dark" id="previewDark" style="height: 200px;">
                                                        <?php if ($data['logo']['dark']) : ?>
                                                            <img src="<?= base_url($data['logo']['dark']['src']); ?>" alt="Logo dark" class="img-fluid h-100">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="file" class="form-control" name="fileDark" id="fileDark" accept="image/*">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnSimpanLogoDark">Simpan</button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-3">
                                                    <label for="fileLight" class="form-label">Mode Terang</label>
                                                    <input type="hidden" id="idLight" value="<?= $data['logo']['light'] ? $data['logo']['light']['logo_id'] : ''; ?>">
                                                    <div class="border-primary p-4 mb-2 text-center text-bg-light" id="previewLight" style="height: 200px;">
                                                        <?php if ($data['logo']['light']) : ?>
                                                            <img src="<?= base_url($data['logo']['light']['src']) ?>" alt="Logo light" class="img-fluid h-100">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="file" class="form-control" name="fileLight" id="fileLight" accept="image/*">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnSimpanLogoLight">Simpan</button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-3">
                                                    <label for="fileDefault" class="form-label">Mode Default</label>
                                                    <input type="hidden" id="idDefault" value="<?= $data['logo']['default'] ? $data['logo']['default']['logo_id'] : ''; ?>">
                                                    <div class="border-primary p-4 mb-2 text-center" id="previewDefault" style="height: 200px;">
                                                        <?php if ($data['logo']['default']) : ?>
                                                            <img src="<?= base_url($data['logo']['default']['src']) ?>" alt="Logo default" class="img-fluid h-100">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="file" class="form-control" name="fileDefault" id="fileDefault" accept="image/*">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnSimpanLogoDefault">Simpan</button>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-3">
                                                    <label for="fileFavicon" class="form-label">Mode Favicon</label>
                                                    <input type="hidden" id="idFavicon" value="<?= $data['logo']['favicon'] ? $data['logo']['favicon']['logo_id'] : ''; ?>">
                                                    <div class="border-primary p-4 mb-2 text-center" id="previewFavicon" style="height: 200px;">
                                                        <?php if ($data['logo']['favicon']) : ?>
                                                            <img src="<?= base_url($data['logo']['favicon']['src']) ?>" alt="Logo favicon" class="img-fluid h-100">
                                                        <?php endif; ?>
                                                    </div>
                                                    <input type="file" class="form-control" name="fileFavicon" id="fileFavicon" accept="image/*">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary" id="btnSimpanLogoFavicon">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-heroes" role="tabpanel" aria-labelledby="v-pills-heroes-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="isiHeroes" class="form-label">Heros Homepage</label>
                                            <div id="isiHeroes" class="form-control py-4">
                                                <?= $data['heroes'] ? $data['heroes']['content'] : '' ?>
                                            </div>
                                            <div class="form-text small">Heroes homepage adalah pesan selamat datang pada halaman utama.</div>
                                        </div>
                                        <input type="hidden" value="<?= $data['heroes'] ? $data['heroes']['hero_id'] : '' ?>" id="idHeroes">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnEditHeroes">Edit</button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnSaveHeroes">Simpan</button>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-jadwal" role="tabpanel" aria-labelledby="v-pills-jadwal-tab" tabindex="0">
                                        <div class="sticky-top py-2 bg-body">
                                            <div class="btn-toolbar">
                                                <div class="btn-group btn-group-sm my-1 me-1">
                                                    <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelJadwal"><i class="bi bi-arrow-repeat"></i></button>
                                                    <button type="button" class="btn btn-primary" title="Tambah Jadwal" id="btnTambahJadwal" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal"><i class="bi bi-plus-circle"></i></button>
                                                </div>
                                                <div class="input-group input-group-sm my-1 ms-auto">
                                                    <input type="text" class="form-control" id="searchTabelJadwal" placeholder="Cari Jadwal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover w-100" id="tabelJadwal">
                                                <thead>
                                                    <tr>
                                                        <th class="text-bg-primary text-center align-middle">Data</th>
                                                        <th class="text-bg-primary text-center align-middle">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-jalur" role="tabpanel" aria-labelledby="v-pills-jalur-tab" tabindex="0">
                                        <div class="sticky-top py-2 bg-body">
                                            <div class="btn-toolbar">
                                                <div class="btn-group btn-group-sm my-1 me-1">
                                                    <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelJalur"><i class="bi bi-arrow-repeat"></i></button>
                                                    <button type="button" class="btn btn-primary" title="Tambah Jalur" id="btnTambahJalur" data-bs-toggle="modal" data-bs-target="#modalTambahJalur"><i class="bi bi-plus-circle"></i></button>
                                                </div>
                                                <div class="input-group input-group-sm my-1 ms-auto">
                                                    <input type="text" class="form-control" id="searchTabelJalur" placeholder="Cari Jalur">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover w-100" id="tabelJalur">
                                                <thead>
                                                    <tr>
                                                        <th class="text-bg-primary text-center align-middle">Data</th>
                                                        <th class="text-bg-primary text-center align-middle">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-syarat" role="tabpanel" aria-labelledby="v-pills-syarat-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="isiSyarat" class="form-label">Syarat Pendaftaran</label>
                                            <div id="isiSyarat" class="form-control py-4">
                                                <?= $data['syarat'] ? $data['syarat']['content'] : '' ?>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?= $data['syarat'] ? $data['syarat']['syarat_id'] : '' ?>" id="idSyarat">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnEditSyarat">Edit</button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnSaveSyarat">Simpan</button>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-dokumen" role="tabpanel" aria-labelledby="v-pills-dokumen-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label for="isiDokumen" class="form-label">Dokumen Pendaftaran</label>
                                            <div id="isiDokumen" class="form-control py-4">
                                                <?= $data['dokumen'] ? $data['dokumen']['content'] : '' ?>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?= $data['dokumen'] ? $data['dokumen']['dokumen_id'] : '' ?>" id="idDokumen">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnEditDokumen">Edit</button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnSaveDokumen">Simpan</button>
                                    </div>
                                </div>
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
        <input type="hidden" name="id" id="idAdmin" value="<?= $data['admin']['id']; ?>">
        <form action="" method="post" id="formProfil">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalProfilLabel">Profil Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama User</label>
                        <input type="text" class="form-control" name="name" id="nama" value="<?= $admin['name']; ?>">
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
                <input type="hidden" id="idEvent">
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
<div class="modal fade" id="modalTambahTautan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahTautanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTambahTautan">Tambah Tautan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="titleTautan" class="col-form-label col-sm-3">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" id="titleTautan">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="urlTautan" class="col-form-label col-sm-3">URL</label>
                    <div class="col-sm-9">
                        <textarea rows="4" class="form-control" name="description" id="urlTautan"></textarea>
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanTautan">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalBalasForum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalBalasForumLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalBalasForum">Balas Diskusi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card card-body mb-3">
                    <input type="hidden" id="parentForum">
                    <input type="hidden" id="namaAdmin" value="<?= $admin['name']; ?>">
                    <h6 class="card-title m-0" id="namaForum"></h6>
                    <span class="small text-muted mb-2" id="tanggalForum"></span>
                    <p class="card-text" id="isiForum"></p>
                </div>
                <div class="mb-2">
                    <label for="balasForum" class="form-label">Balasan Diskusi</label>
                    <textarea class="form-control" id="balasForum" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnBalasForumAdmin">Balas</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetailForum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailForumLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDetailForum">Detail Forum Diskusi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                            <input type="hidden" class="form-control" id="namaAndaBalasan" placeholder="Nama Anda" value="<?= $admin['name']; ?>">
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
<div class="modal fade" id="modalTambahJadwal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTambahJadwal">Tambah Jadwal Pelaksanaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idJadwal">
                <div class="row mb-3">
                    <label for="title" class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="titleJadwal" name="title">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="content" class="col-sm-3 col-form-label">Isi</label>
                    <div class="col-sm-9">
                        <textarea name="content" rows="3" id="contentJadwal" class="form-control"></textarea>
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanJadwal">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambahJalur" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahJalurLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTambahJalur">Tambah Jalur Pendaftaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idJalur">
                <div class="row mb-3">
                    <label for="namaJalur" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="namaJalur" name="namaJalur">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="persenJalur" class="col-sm-3 col-form-label">Prosentase</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="persenJalur" name="persenJalur">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jumlahPdJalur" class="col-sm-3 col-form-label">Jumlah Peserta Didik </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="jumlahPdJalur" name="jumlahPdJalur">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanJalur">Simpan</button>
            </div>
        </div>
    </div>
</div>