<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./src/templates/panel.component/head.php') ?>
    <title>Expedientes y Archivos | Panel API WISP</title>
</head>

<body>
    <?php require_once('./src/templates/panel.component/header.php') ?>
    <div class="app-container">
        <?php require_once('./src/templates/panel.component/sidebar.php') ?>
        <main class="main-content">
            <div class="container-fluid p-0">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
                    <div>
                        <h3 class="fw-bold text-dark mb-1"><i class="fa-solid fa-folder-open text-primary me-2"></i>Archivos y Expedientes de Clientes</h3>
                        <p class="text-muted mb-0">Gestión de contratos y documentos digitales</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddFile">
                            <i class="fa-solid fa-plus me-1"></i> Adjuntar Archivo
                        </button>
                    </div>
                </div>

                <!-- TABLA DE ARCHIVOS DE CLIENTES -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-file-lines text-primary me-2"></i>Documentos Registrados</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del Archivo</th>
                                        <th>Descripción</th>
                                        <th>Cliente (ID)</th>
                                        <th>Documento Almacenado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($DATA['archivos']) && is_array($DATA['archivos'])) : ?>
                                        <?php foreach ($DATA['archivos'] as $file) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($file['client_file_id'] ?? '') ?></td>
                                                <td><strong><?= htmlspecialchars($file['client_file_name'] ?? '') ?></strong></td>
                                                <td><?= htmlspecialchars($file['client_file_desc'] ?? '') ?></td>
                                                <td><span class="badge bg-secondary">Cliente #<?= htmlspecialchars($file['client_id'] ?? '') ?></span></td>
                                                <td>
                                                    <?php if (!empty($file['client_file_stored'])) : ?>
                                                        <a href="<?= $DATA['http_domain'] ?>public/file.client_files/<?= htmlspecialchars($file['client_file_stored']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fa-solid fa-download me-1"></i> Ver / Descargar
                                                        </a>
                                                    <?php else : ?>
                                                        <span class="text-muted">Sin archivo</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteFile(<?= $file['client_file_id'] ?>)">
                                                        <i class="fa-solid fa-trash"></i> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center p-4 text-muted">No se han registrado archivos en los expedientes.</td>
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

    <!-- MODAL DE NUEVO ARCHIVO -->
    <div class="modal fade" id="modalAddFile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="formAddFile" enctype="multipart/form-data">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title"><i class="fa-solid fa-file-circle-plus me-2"></i>Adjuntar Archivo al Expediente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Cliente</label>
                            <select class="form-select" name="client_id" required>
                                <option value="">Seleccione un cliente...</option>
                                <?php if (!empty($DATA['clientes']) && is_array($DATA['clientes'])) : ?>
                                    <?php foreach ($DATA['clientes'] as $client) : ?>
                                        <option value="<?= $client['client_id'] ?>"><?= htmlspecialchars($client['client_name']) ?> (ID: <?= $client['client_id'] ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre del Documento</label>
                            <input type="text" class="form-control" name="client_file_name" placeholder="Ej. Contrato Servicio, Cédula ID" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea class="form-control" name="client_file_desc" rows="2" placeholder="Notas sobre el documento..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Seleccionar Archivo (PDF, Img, Doc)</label>
                            <input type="file" class="form-control" name="client_file_stored" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload me-1"></i> Guardar Archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once('./src/templates/panel.component/foot.php') ?>
    <script>
        const HTTP_DOMAIN = "<?= $DATA['http_domain'] ?>";

        document.getElementById('formAddFile').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            try {
                const res = await fetch(HTTP_DOMAIN + 'services/client_file/insert', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.response) {
                    alert('Archivo guardado exitosamente.');
                    location.reload();
                } else {
                    alert(data.message || 'Error al guardar el archivo.');
                }
            } catch (err) {
                console.error(err);
                alert('Error al conectar con el servidor.');
            }
        });

        async function deleteFile(id) {
            if (!confirm('¿Está seguro de eliminar este archivo del expediente?')) return;
            const formData = new FormData();
            formData.append('client_file_id', id);
            try {
                const res = await fetch(HTTP_DOMAIN + 'services/client_file/delete', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.response) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al eliminar el archivo.');
                }
            } catch (err) {
                console.error(err);
                alert('Error de servidor.');
            }
        }
    </script>
</body>

</html>
