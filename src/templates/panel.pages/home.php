<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./src/templates/panel.component/head.php') ?>
    <title>Inicio | Panel API WISP</title>
</head>

<body>
    <?php include('./src/templates/panel.component/header.php') ?>
    <div class="app-container">
        <?php include('./src/templates/panel.component/sidebar.php') ?>
        <main class="main-content">
            <div class="container-fluid p-0">
                
                <!-- TITULO Y ALERTA DE ESTADO DE CONEXION MIKROWISP -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-1"><i class="fa-solid fa-gauge text-primary me-2"></i>Panel de Control API WISP</h3>
                        <p class="text-muted mb-0">Gestión de servicios de internet e integración con Mikrowisp</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <span id="dashboardConnectionStatus" class="connection-status-badge online py-2 px-3 fs-6">
                            <span class="status-dot"></span> <span class="status-text">Verificando conexión con Mikrowisp...</span>
                        </span>
                    </div>
                </div>

                <!-- CARDS DE RESUMEN Y METRICAS -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-7 mb-1">Clientes Sincronizados</p>
                                        <h2 class="fw-bold mb-0 text-primary"><?= $DATA['clientes_total'] ?? 0 ?></h2>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                        <i class="fa-solid fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="<?= $DATA['http_domain'] ?>panel/clientes" class="text-primary text-decoration-none fs-7 fw-semibold">
                                    Gestionar clientes <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-7 mb-1">Archivos y Expedientes</p>
                                        <h2 class="fw-bold mb-0 text-info">Doc</h2>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                                        <i class="fa-solid fa-folder-open fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="<?= $DATA['http_domain'] ?>panel/expedientes" class="text-info text-decoration-none fs-7 fw-semibold">
                                    Ver expedientes <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-7 mb-1">Usuarios del Sistema</p>
                                        <h2 class="fw-bold mb-0 text-warning"><?= $DATA['user_total'] ?? 0 ?></h2>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                                        <i class="fa-solid fa-user-gear fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="<?= $DATA['http_domain'] ?>panel/user" class="text-warning text-decoration-none fs-7 fw-semibold">
                                    Administrar usuarios <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-7 mb-1">Servidor MCP API</p>
                                        <h2 class="fw-bold mb-0 text-success">Activo</h2>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                        <i class="fa-solid fa-robot fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <span class="text-success fs-7 fw-semibold">JSON-RPC 2.0 / MCP Ready</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD DE DIAGNOSTICO DE CONEXION CON MIKROWISP -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold text-dark m-0"><i class="fa-solid fa-plug-circle-check text-primary me-2"></i>Estado de Integración con Mikrowisp</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <h6 class="fw-bold text-secondary mb-1">Diagnóstico en Tiempo Real</h6>
                                <p class="text-muted mb-0" id="pingDetailsText">Comprobando latencia y respuesta del endpoint de la API Mikrowisp...</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <button class="btn btn-outline-primary" onclick="checkMikrowispStatus()">
                                    <i class="fa-solid fa-rotate me-1"></i> Comprobar Conexión Ahora
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <?php include('./src/templates/panel.component/foot.php') ?>
    <script>
        async function checkMikrowispStatus() {
            const statusBadges = [
                document.getElementById('dashboardConnectionStatus'),
                document.getElementById('globalHeaderStatus')
            ];
            const detailsText = document.getElementById('pingDetailsText');

            statusBadges.forEach(b => {
                if (b) {
                    b.className = 'connection-status-badge online';
                    b.querySelector('.status-text').innerText = 'Comprobando...';
                }
            });
            if (detailsText) detailsText.innerText = 'Realizando petición de diagnóstico a la API de Mikrowisp...';

            try {
                const response = await fetch(http_domain + 'services/info/select', { method: 'POST' });
                const data = await response.json();
                
                if (data.response && data.data) {
                    const info = data.data;
                    if (info.info_mkw_api_url && info.info_mkw_api_url.length > 5) {
                        statusBadges.forEach(b => {
                            if (b) {
                                b.className = 'connection-status-badge online';
                                b.querySelector('.status-text').innerText = 'Servidor Mikrowisp Online';
                            }
                        });
                        if (detailsText) detailsText.innerHTML = `<span class="text-success font-weight-bold"><i class="fa-solid fa-circle-check me-1"></i> Conexión establecida con éxito:</span> ${info.info_mkw_api_url}`;
                    } else {
                        statusBadges.forEach(b => {
                            if (b) {
                                b.className = 'connection-status-badge offline';
                                b.querySelector('.status-text').innerText = 'Falta Configurar API';
                            }
                        });
                        if (detailsText) detailsText.innerHTML = `<span class="text-warning font-weight-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> No se ha configurado la URL de Mikrowisp.</span> Por favor ingresa a Configuración API.`;
                    }
                } else {
                    throw new Exception("Sin datos");
                }
            } catch (err) {
                statusBadges.forEach(b => {
                    if (b) {
                        b.className = 'connection-status-badge offline';
                        b.querySelector('.status-text').innerText = 'Mikrowisp Offline / Error';
                    }
                });
                if (detailsText) detailsText.innerHTML = `<span class="text-danger font-weight-bold"><i class="fa-solid fa-circle-xmark me-1"></i> Error al conectar con el servidor:</span> No se pudo establecer comunicación.`;
            }
        }

        document.addEventListener('DOMContentLoaded', checkMikrowispStatus);
    </script>
</body>

</html>