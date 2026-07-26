<div class="sidebar bg-dark text-white p-3">
    <div class="d-none d-lg-block pb-3 mb-3 border-bottom border-secondary text-center">
        <h5 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-server me-2"></i>Mikrowisp API</h5>
        <small class="text-muted">Panel de Control</small>
    </div>
    <!-- List | ini -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="<?= $DATA['http_domain'] ?>panel/" class="nav-link text-white <?= ($DATA['name'] == "home") ? "active bg-primary" : "" ?>">
                <i class="fa-solid fa-house me-2"></i>
                <span>Inicio</span>
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= $DATA['http_domain'] ?>panel/clientes" class="nav-link text-white <?= ($DATA['name'] == "clientes" || $DATA['name'] == "client") ? "active bg-primary" : "" ?>">
                <i class="fa-solid fa-users me-2"></i>
                <span>Clientes Mikrowisp</span>
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= $DATA['http_domain'] ?>panel/expedientes" class="nav-link text-white <?= ($DATA['name'] == "client_file") ? "active bg-primary" : "" ?>">
                <i class="fa-solid fa-folder-open me-2"></i>
                <span>Archivos y Expedientes</span>
            </a>
        </li>
        <?php if (($_SESSION['user_tipo'] ?? 'admin') == "admin") { ?>
            <li class="nav-item mb-1">
                <a href="<?= $DATA['http_domain'] ?>panel/info" class="nav-link text-white <?= ($DATA['name'] == "info") ? "active bg-primary" : "" ?>">
                    <i class="fa-solid fa-sliders me-2"></i>
                    <span>Configuración API</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="<?= $DATA['http_domain'] ?>panel/user" class="nav-link text-white <?= ($DATA['name'] == "user") ? "active bg-primary" : "" ?>">
                    <i class="fa-solid fa-user-gear me-2"></i>
                    <span>Usuarios Sistema</span>
                </a>
            </li>
        <?php } ?>
    </ul>
    <!-- List | end -->
</div>