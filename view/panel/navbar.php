<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow">
    <div class="container">
        <a class="navbar-brand" href="/panel/manage.php">CMS-Info PPDB</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/panel/manage.php">Manage</a>
                </li>
            </ul>
            <div class="ms-auto">
                <div class="btn-group btn-group-sm">
                    <a href="/" target="_blank" class="btn btn-outline-primary btn-sm" title="Homepage"><i class="bi bi-box-arrow-up-right me-1 me-sm-0"></i><span class="d-lg-none">Homepage</span></a>
                    <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1 me-sm-0"></i>
                        <span class="d-lg-none">
                            User
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <h6 class="dropdown-header"><?= $admin['name']; ?></h6>
                        </li>
                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalProfil">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/auth/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>