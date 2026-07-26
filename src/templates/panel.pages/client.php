<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./src/templates/panel.component/head.php') ?>
    <title>Clientes | Panel API WISP</title>
</head>

<body>
    <?php require_once('./src/templates/panel.component/header.php') ?>
    <div class="app-container">
        <?php require_once('./src/templates/panel.component/sidebar.php') ?>
        <main class="main-content">
            <div class="container-fluid p-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Gestión de Clientes Mikrowisp</h3>
                        <p class="text-muted mb-0">Consulta por DNI/Cédula y sincronización con Mikrowisp</p>
                    </div>
                </div>

                <!-- BUSCADOR POR DNI -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-magnifying-glass text-primary me-2"></i>Consultar Cliente por DNI / Cédula</h5>
                        <form id="formSearchClient" class="row g-3">
                            <div class="col-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control form-control-lg" id="client_mkw_dni" name="client_mkw_dni" placeholder="Ingrese número de cédula o DNI" required>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-search me-1"></i> Consultar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- RESULTADO DE BUSQUEDA -->
                <div id="searchResult" class="mb-4" style="display: none;">
                    <div class="card border-0 shadow-sm border-start border-info border-4">
                        <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                            <h5 class="fw-bold mb-1 mb-sm-0 text-dark" id="resNombre">Detalles del Cliente</h5>
                            <span class="badge bg-info text-dark fs-6" id="resEstado">--</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent px-0"><strong>ID Mikrowisp:</strong> <span id="resMkwId">--</span></li>
                                        <li class="list-group-item bg-transparent px-0"><strong>Cédula/DNI:</strong> <span id="resCedula">--</span></li>
                                        <li class="list-group-item bg-transparent px-0"><strong>Teléfono/Móvil:</strong> <span id="resTelefono">--</span></li>
                                        <li class="list-group-item bg-transparent px-0"><strong>Correo:</strong> <span id="resCorreo">--</span></li>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent px-0"><strong>Dirección:</strong> <span id="resDireccion">--</span></li>
                                        <li class="list-group-item bg-transparent px-0"><strong>Facturas Impagas:</strong> <span class="badge bg-danger fs-6" id="resFacturas">0</span></li>
                                        <li class="list-group-item bg-transparent px-0"><strong>Total Facturas:</strong> <span id="resTotalFacturas">0</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE CLIENTES REGISTRADOS LOCALMENTE -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list text-primary me-2"></i>Clientes Sincronizados Localmente</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Local</th>
                                        <th>Nombre</th>
                                        <th>ID Mikrowisp</th>
                                        <th>Cédula / DNI</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($DATA['clientes']) && is_array($DATA['clientes'])) : ?>
                                        <?php foreach ($DATA['clientes'] as $client) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($client['client_id'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($client['client_name'] ?? '') ?></strong></td>
                                                <td><span class="badge bg-secondary"><?= htmlspecialchars($client['client_mkw_id'] ?? '') ?></span></td>
                                                <td><?= htmlspecialchars($client['client_mkw_dni'] ?? '') ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="consultarDni('<?= htmlspecialchars($client['client_mkw_dni'] ?? '') ?>')">
                                                        <i class="fa-solid fa-arrows-rotate me-1"></i> Sincronizar
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center p-4 text-muted">No hay clientes sincronizados en la base de datos local.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <?php require_once('./src/templates/panel.component/foot.php') ?>
    <script>
        const HTTP_DOMAIN = "<?= $DATA['http_domain'] ?>";

        function consultarDni(dni) {
            document.getElementById('client_mkw_dni').value = dni;
            document.getElementById('formSearchClient').dispatchEvent(new Event('submit'));
        }

        document.getElementById('formSearchClient').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const resBox = document.getElementById('searchResult');
            resBox.style.display = 'none';

            try {
                const response = await fetch(HTTP_DOMAIN + 'services/client/select_by_dni', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.response && result.data) {
                    const c = result.data;
                    document.getElementById('resNombre').innerText = c.nombre || 'Sin nombre';
                    document.getElementById('resEstado').innerText = c.estado || 'Desconocido';
                    document.getElementById('resMkwId').innerText = c.id || '--';
                    document.getElementById('resCedula').innerText = c.cedula || '--';
                    document.getElementById('resTelefono').innerText = (c.telefono || '') + ' ' + (c.movil || '');
                    document.getElementById('resCorreo').innerText = c.correo || '--';
                    document.getElementById('resDireccion').innerText = c.direccion_principal || '--';
                    document.getElementById('resFacturas').innerText = c.facturacion ? c.facturacion.facturas_nopagadas : 0;
                    document.getElementById('resTotalFacturas').innerText = c.facturacion ? c.facturacion.total_facturas : 0;
                    resBox.style.display = 'block';
                } else {
                    alert(result.message || 'No se encontró el cliente en Mikrowisp');
                }
            } catch (err) {
                console.error(err);
                alert('Error al conectar con el servidor.');
            }
        });
    </script>
</body>

</html>
