<link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/sidebar.css">
<div class="sidebar bg-dark">
    <button class="burguer-button" onclick="handleBurgerSidebar()">
        <i class="fa-solid fa-bars text-light"></i>
    </button>
    <div class="sidebar-header">
        <h4 class="text-truncate p-2 text-light"><i class="fa-solid fa-network-wired me-2"></i>API WISP</h4>
    </div>
    <!-- List | ini -->
    <ul class="list-group rounded-0 p-2 border-0">
        <a href="<?= $DATA['http_domain'] ?>panel/" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "home") ? "shadow active" : "" ?>">
            <i class="fa-solid fa-house"></i>
            <span class="ms-2">Inicio</span>
        </a>
        <a href="<?= $DATA['http_domain'] ?>panel/clientes" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "clientes" || $DATA['name'] == "client") ? "shadow active" : "" ?>">
            <i class="fa-solid fa-users"></i>
            <span class="ms-2">Clientes Mikrowisp</span>
        </a>
        <a href="<?= $DATA['http_domain'] ?>panel/expedientes" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "client_file") ? "shadow active" : "" ?>">
            <i class="fa-solid fa-folder-open"></i>
            <span class="ms-2">Archivos y Expedientes</span>
        </a>
        <?php if (($_SESSION['user_tipo'] ?? 'admin') == "admin") { ?>
            <a href="<?= $DATA['http_domain'] ?>panel/info" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "info") ? "shadow active" : "" ?>">
                <i class="fa-solid fa-sliders"></i>
                <span class="ms-2">Configuración API</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/user" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "user") ? "shadow active" : "" ?>">
                <i class="fa-solid fa-user-gear"></i>
                <span class="ms-2">Usuarios Sistema</span>
            </a>
        <?php } ?>
    </ul>
    <!-- List | end -->
</div>