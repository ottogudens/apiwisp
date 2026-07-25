<link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/sidebar.css">
<div class="sidebar bg-dark">
    <button class="burguer-button" onclick="handleBurgerSidebar()">
        <i class="fa-solid fa-bars text-light"></i>
    </button>
    <div class="sidebar-header">
        <h4 class="text-truncate p-2">Dr. Ayora</h4>
    </div>
    <div class="logo"><img src="<?= $DATA['http_domain'] ?>public/img/logo1.png?last=<?= $DATA['info']['info_last'] ?? '' ?>" alt="Logo"></div>
    <!-- List | ini -->
    <ul class="list-group rounded-0 p-2 border-0">
        <a href="<?= $DATA['http_domain'] ?>panel/" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "home") ? "shadow  active" : "" ?>">
            <i class="fa-solid fa-house"></i>
            <span class="ms-2">Inicio</span>
        </a>
        <!-- RESTRICCION PARA DOCTORES | INICIO -->
        <?php if (($_SESSION['user_tipo'] ?? 'user') == "user") { ?>

            <a href="<?= $DATA['http_domain'] ?>panel/info" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "info") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-info-circle"></i>
                <span class="ms-2">Informacion</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/slider" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "slider") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-images"></i>
                <span class="ms-2">Slider</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/social" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "social") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-share-alt"></i>
                <span class="ms-2">Redes Sociales</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/horas" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "horas") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-clock"></i>
                <span class="ms-2">Horas</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/servicios" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "servicios") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-tools"></i>
                <span class="ms-2">Servicios</span>
            </a>
            <a href="<?= $DATA['http_domain'] ?>panel/user" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "user") ? "shadow  active" : "" ?>">
                <i class="fa-solid fa-user"></i>
                <span class="ms-2">Usuarios</span>
            </a>
        <?php } ?>
        <!-- RESTRICCION PARA DOCTORES | FIN -->
        <a href="<?= $DATA['http_domain'] ?>panel/clientes" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "clientes") ? "shadow  active" : "" ?>">
            <i class="fa-solid fa-users"></i>
            <span class="ms-2">Clientes</span>
        </a>
        <a href="<?= $DATA['http_domain'] ?>panel/citas" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "citas") ? "shadow  active" : "" ?>">
            <i class="fa-solid fa-calendar"></i>
            <span class="ms-2">Citas</span>
        </a>
        <a href="<?= $DATA['http_domain'] ?>panel/mensajes" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($DATA['name'] == "mensajes") ? "shadow  active" : "" ?>">
            <i class="fa-solid fa-envelope"></i>
            <span class="ms-2">Mensajes</span>
        </a>
    </ul>
    <!-- List | end -->
</div>