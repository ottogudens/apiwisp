<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./src/templates/panel.component/head.php') ?>
    <title>Clientes | Panel API WISP</title>
</head>

<body class="bg-light">
    <?php require_once('./src/templates/panel.component/header.php') ?>
    <div class="d-flex">
        <?php require_once('./src/templates/panel.component/sidebar.php') ?>
        <div class="main-content w-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fa-solid fa-users text-primary me-2"></i>Gestión de Clientes Mikrowisp</h2>
            </div>

            <!-- BUSCADOR POR DNI -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fa-solid fa-magnifying-glass me-2"></i>Consultar Cliente Mikrowisp por DNI / Cédula</h5>
                    <form id="formSearchClient" class="row g-3">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="client_mkw_dni" name="client_mkw_dni" placeholder="Ingrese número de cédula o DNI" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-search me-1"></i> Consultar y Sincronizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RESULTADO DE BUSQUEDA -->
            <div id="searchResult" class="mb-4" style="display: none;">
                <div class="card border-info shadow-sm">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" id="resNombre">Detalles del Cliente</h5>
                        <span class="badge bg-light text-dark" id="resEstado">--</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID Mikrowisp:</strong> <span id="resMkwId">--</span></p>
                                <p><strong>Cédula/DNI:</strong> <span id="resCedula">--</span></p>
                                <p><strong>Teléfono/Móvil:</strong> <span id="resTelefono">--</span></p>
                                <p><strong>Correo:</strong> <span id="resCorreo">--</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Dirección:</strong> <span id="resDireccion">--</span></p>
                                <p><strong>Facturas Impagas:</strong> <span class="badge bg-danger" id="resFacturas">0</span></p>
                                <p><strong>Total Facturas:</strong> <span id="resTotalFacturas">0</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLA DE CLIENTES REGISTRADOS LOCALMENTE -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i>Clientes Sincronizados Localmente</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
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
                                                <button class="btn btn-sm btn-outline-info me-1" onclick="consultarDni('<?= htmlspecialchars($client['client_mkw_dni'] ?? '') ?>')">
                                                    <i class="fa-solid fa-arrows-rotate"></i> Sincronizar
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
