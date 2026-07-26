<nav class="header navbar navbar-expand navbar-dark bg-dark px-3">
    <div class="container-fluid p-0">
        <button class="btn btn-outline-light d-lg-none me-2" onclick="document.body.classList.toggle('sidebar-show')">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="<?= $DATA['http_domain'] ?>panel">
            <i class="fa-solid fa-network-wired text-primary me-2"></i> <span>API WISP</span>
        </a>
        <!-- Options | ini -->
        <ul class="navbar-nav ms-auto mb-0 align-items-center">
            <li class="nav-item me-3 d-none d-sm-block">
                <span id="globalHeaderStatus" class="connection-status-badge online">
                    <span class="status-dot"></span> <span class="status-text">Verificando...</span>
                </span>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="header-user-photo rounded-circle me-2" src="<?= $DATA['http_domain'] ?>public/img.users/<?= $_SESSION['user_photo'] ?? 'default.png' ?>?last=<?= $_SESSION['user_last'] ?? '' ?>" alt="User photo">
                    <span class="d-none d-md-inline"><?= $_SESSION['user_name'] ?? ($_SESSION['user_nombre'] ?? 'Administrador') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-3 shadow" aria-labelledby="navbarDropdown">
                    <li class="text-center mb-2">
                        <img class="dropdown-user-photo rounded-circle mb-2" src="<?= $DATA['http_domain'] ?>public/img.users/<?= $_SESSION['user_photo'] ?? 'default.png' ?>?last=<?= $_SESSION['user_last'] ?? '' ?>" alt="User photo">
                        <h6 class="mb-0 text-white"><?= $_SESSION['user_name'] ?? ($_SESSION['user_nombre'] ?? 'Administrador') ?></h6>
                        <small class="text-muted"><?= $_SESSION['user_user'] ?? 'admin' ?></small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button class="btn btn-outline-danger w-100 btn-sm" onclick="logout()">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Cerrar sesión
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Options | end -->
    </div>
</nav>