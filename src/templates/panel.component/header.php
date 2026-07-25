<nav class="header navbar navbar-expand navbar-dark p-0 bg-primary">
    <div class="container-fluid">
        <!-- Options | ini -->
        <ul class="navbar-nav mb-0 mb-lg-0 ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="header-user-photo rounded-circle" src="<?= $DATA['http_domain'] ?>public/img.users/<?= $_SESSION['user_photo'] ?? 'default.png' ?>?last=<?= $_SESSION['user_last'] ?? '' ?>" alt="User photo">
                    <span><?= $_SESSION['user_name'] ?? ($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-2" aria-labelledby="navbarDropdown">
                    <li class="text-center">
                        <img class="dropdown-user-photo rounded-circle" src="<?= $DATA['http_domain'] ?>public/img.users/<?= $_SESSION['user_photo'] ?? 'default.png' ?>?last=<?= $_SESSION['user_last'] ?? '' ?>" alt="User photo">
                        <br>
                        <span class="text-primary"><?= $_SESSION['user_name'] ?? ($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <!-- <li><a class="btn btn-outline-primary p-1 mb-1" style="width:100%" href="#">Perfil</a></li> -->
                    <li><button class="btn btn-outline-primary p-1 mb-1" style="width:100%" onclick="logout()">Cerrar sesion</button></li>
                </ul>
            </li>
        </ul>
        <!-- Options | end -->
    </div>
</nav>