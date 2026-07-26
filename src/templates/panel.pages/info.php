<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./src/templates/panel.component/head.php') ?>
    <title>Configuración API | Panel API WISP</title>
</head>

<body class="bg-light">
    <?php require_once('./src/templates/panel.component/header.php') ?>
    <div class="d-flex">
        <?php require_once('./src/templates/panel.component/sidebar.php') ?>
        <div class="main-content w-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fa-solid fa-sliders text-primary me-2"></i>Configuración de API Mikrowisp</h2>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fa-solid fa-key me-2"></i>Credenciales de Conexión a Mikrowisp</h5>
                </div>
                <div class="card-body p-4">
                    <form id="formUpdateInfo">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombre del Sistema / Instancia</label>
                                <input type="text" class="form-control" name="info_nombre" value="<?= htmlspecialchars($DATA['info']['info_nombre'] ?? 'API WISP') ?>" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">URL de la API Mikrowisp</label>
                                <input type="url" class="form-control" name="info_mkw_api_url" value="<?= htmlspecialchars($DATA['info']['info_mkw_api_url'] ?? '') ?>" placeholder="http://tu-mikrowisp.com/api/v1/ o https://tu-mikrowisp.com/api/v2/" required>
                                <div class="form-text">Ejemplo v5: <code>http://167.71.189.123/api/v1/</code> | Ejemplo v6: <code>https://miwisp.com/api/v2/</code></div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Token / Password API Mikrowisp</label>
                                <input type="text" class="form-control" name="info_mkw_api_token" value="<?= htmlspecialchars($DATA['info']['info_mkw_api_token'] ?? '') ?>" placeholder="Token o Contraseña API" required>
                                <div class="form-text">En Mikrowisp v5 se ingresa la contraseña API. En Mikrowisp v6 se ingresa el API Token generado.</div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-1"></i> Guardar Configuración</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('./src/templates/panel.component/foot.php') ?>
    <script>
        const HTTP_DOMAIN = "<?= $DATA['http_domain'] ?>";

        document.getElementById('formUpdateInfo').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            try {
                const res = await fetch(HTTP_DOMAIN + 'services/info/update', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.response) {
                    alert('Configuración guardada correctamente.');
                    location.reload();
                } else {
                    alert(data.message || 'Error al guardar la configuración.');
                }
            } catch (err) {
                console.error(err);
                alert('Error al conectar con el servidor.');
            }
        });
    </script>
</body>

</html>