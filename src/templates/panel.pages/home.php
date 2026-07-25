<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./src/templates/panel.component/head.php') ?>
    <style>
        /* Estilos para el dashboard */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 1px 6px 0 rgba(0, 0, 0, 0.5);
        }

        .card-title {
            font-size: 1.5rem;
        }

        .card-footer {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 0px 0px 10px 10px;
            text-align: center;
            cursor: pointer;
        }

        .card-footer i {
            margin-right: 5px;
        }

        main {
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php include('./src/templates/panel.component/header.php') ?>
    <?php include('./src/templates/panel.component/sidebar.php') ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <!-- RESTRICCION PARA DOCTORES | INICIO -->
                <?php if (($_SESSION['user_tipo'] ?? 'user') == "user") { ?>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Slider</span>
                                    <i class="fas fa-images"></i>
                                </h5>
                                <p class="card-text">Total de slides: <?= $DATA['slider_total'] ?? 0 ?></p>
                            </div>
                            <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/slider">Ver slider</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card bg-secondary text-dark">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Redes</span>
                                    <i class="fas fa-share-alt"></i>
                                </h5>
                                <p class="card-text">Total de redes: <?= $DATA['social_total'] ?? 0 ?></p>
                            </div>
                            <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/social">Ver redes</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Horas</span>
                                    <i class="fas fa-clock"></i>
                                </h5>
                                <p class="card-text">Total de horarios: <?= $DATA['horas_total'] ?? 0 ?></p>
                            </div>
                            <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/horas">Ver horas</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Servicios</span>
                                    <i class="fas fa-clipboard-list"></i>
                                </h5>
                                <p class="card-text">Total de servicios: <?= $DATA['servicios_total'] ?? 0 ?></p>
                            </div>
                            <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/servicios">Ver servicios</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Usuarios</span>
                                    <i class="fas fa-user"></i>
                                </h5>
                                <p class="card-text">Total de usuarios: <?= $DATA['user_total'] ?? 0 ?></p>
                            </div>
                            <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/user">Ver usuarios</a>
                        </div>
                    </div>
                <?php } ?>
                <!-- RESTRICCION PARA DOCTORES | FIN -->
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <span>Clientes</span>
                                <i class="fas fa-users"></i>
                            </h5>
                            <p class="card-text m-auto">Total de clientes: <?= $DATA['clientes_total'] ?? 0 ?></p>
                        </div>
                        <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/clientes">Ver clientes</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <span>Citas</span>
                                <i class="fas fa-calendar-alt"></i>
                            </h5>
                            <p class="card-text">Total de citas: <?= $DATA['citas_total'] ?? 0 ?></p>
                        </div>
                        <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/citas">Ver citas</a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-3">
                    <div class="card text-white" style="background-color: #343a40;">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <span>Mensajes</span>
                                <i class="fas fa-envelope"></i>
                            </h5>
                            <p class="card-text">Total de mensajes: <?= $DATA['mensajes_total'] ?? 0 ?></p>
                        </div>
                        <a class="card-footer btn" href="<?= $DATA['http_domain'] ?>panel/mensajes">Ver buzon</a>
                    </div>
                </div>
            </div>
    </main>
</body>
<foot>
    <?php include('./src/templates/panel.component/foot.php') ?>
</foot>

</html>