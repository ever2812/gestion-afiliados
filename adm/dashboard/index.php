<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../login/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gestión de Afiliados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../pubs/estilo.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f7f8fa;
        }

        .dashboard-container {
            max-width: 1250px;
        }

        .metric-card {
            border: 1px solid #edf0f2;
            border-radius: 14px;
            background: #fff;
            height: 100%;
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .metric-number {
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .section-card {
            border: 1px solid #edf0f2;
            border-radius: 12px;
            background: #fff;
        }

        .progress {
            height: 8px;
            background: #edf0f2;
        }

        .progress-bar {
            background: #2563eb;
        }

        .table thead th {
            color: #64748b;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
            background: #f8fafc;
            padding: 13px 12px;
        }

        .table tbody td {
            font-size: .84rem;
            padding: 13px 12px;
            vertical-align: middle;
        }

        .table-responsive {
            border-radius: 10px;
        }

        .search-box {
            max-width: 360px;
        }

        .badge-casilla {
            background: #eef2ff;
            color: #4338ca;
            font-weight: 600;
        }

        .section-number {
            font-weight: 700;
            font-family: monospace;
        }
    </style>
</head>

<body class="pb-5">

    <header class="bg-white border-bottom py-2 py-md-3 mb-4 sticky-top shadow-sm">
        <div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-between">

            <!-- Extremo Izquierdo: Identidad / Logo -->
            <a href="./index.php" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="bg-dark text-white rounded-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; min-width: 36px;">
                    <i class="bi bi-person-vcard fs-5"></i>
                </div>
                <div>
                    <span class="fw-bold text-dark fs-6 tracking-tight d-block lh-1">Dashboard y Resumen</span>
                    <span class="text-muted" style="font-size: 0.75rem;">Conteo General</span>
                </div>
            </a>

            <!-- Botón Hamburguesa / Menú -->
            <button
                class="btn btn-light border-0 rounded-2 p-2 text-dark d-flex align-items-center justify-content-center"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#navMenuOffcanvas"
                aria-controls="navMenuOffcanvas"
                aria-label="Abrir menú de navegación"
                style="width: 38px; height: 38px;">
                <i class="bi bi-list fs-4 lh-1"></i>
            </button>

        </div>
    </header>

    <div class="offcanvas offcanvas-end border-0 shadow"
        tabindex="-1" id="navMenuOffcanvas"
        style="max-width:300px;">

        <div class="offcanvas-header border-bottom">
            <h6 class="offcanvas-title fw-bold">Navegación</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
            <div class="list-group list-group-flush">
                <a href="../registro/"
                    class="list-group-item list-group-item-action border-0 rounded-3 py-3">
                    <i class="bi bi-camera-fill me-2"></i> Registro
                    <small class="d-block text-muted ms-4">Escanear y afiliar</small>
                </a>

                <a href="../promotor/"
                    class="list-group-item list-group-item-action border-0 rounded-3 py-3">
                    <i class="bi bi-person-badge-fill me-2"></i> Promotores
                    <small class="d-block text-muted ms-4">Alta y gestión de equipo</small>
                </a>

                <a href="../dashboard/"
                    class="list-group-item list-group-item-action border-0 bg-light rounded-3 py-3">
                    <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
                    <strong>Dashboard</strong>
                    <small class="d-block text-muted ms-4">Resultados y métricas</small>
                </a>
            </div>

            <div class="pt-3 border-top">
                <div class="small fw-bold mb-2">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?>
                </div>
                <a href="../api/session/end.php"
                    class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </div>

    <main class="container-fluid dashboard-container px-3 px-md-4">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1">Avance de Capturas</h1>
                <!-- <p class="text-muted small mb-0">
                    Resumen general de las capturas realizadas
                </p> -->
            </div>
            <button class="btn btn-outline-secondary btn-sm rounded-3"
                id="btnActualizar">
                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar datos
            </button>
        </div>

        <div id="dashboardError" class="alert alert-danger d-none small"></div>

        <!-- Indicadores principales -->
        <div class="row g-3 mb-4">

            <div class="col-12 col-md-6 col-xl-4">
                <div class="metric-card p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small fw-medium mb-2">Total de Afiliados</div>
                            <div class="metric-number text-dark" id="totalAfiliados">0</div>
                            <div class="text-muted small mt-1">Registros Activos</div>
                        </div>
                        <div class="metric-icon bg-primary-subtle text-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <div class="metric-card p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small fw-medium mb-2">Secciones registradas</div>
                            <div class="metric-number text-dark" id="totalSecciones">0</div>
                            <div class="text-muted small mt-1">Con al menos un afiliado</div>
                        </div>
                        <div class="metric-icon bg-success-subtle text-success">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <div class="metric-card p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small fw-medium mb-2">Casillas con registros</div>
                            <div class="metric-number text-dark" id="totalCasillas">0</div>
                            <div class="text-muted small mt-1">Combinaciones Sección/Casilla</div>
                        </div>
                        <div class="metric-icon bg-warning-subtle text-warning">
                            <i class="bi bi-pin-map-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Resumen por sección -->
        <section class="card card-modern p-3 p-md-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="metric-icon bg-primary-subtle text-primary" style="width:36px;height:36px;">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
                <div>
                    <h2 class="h6 fw-bold mb-0">Distribución por Secciones</h2>
                    <!-- <small class="text-muted">Distribución de registros por sección</small> -->
                </div>
            </div>

            <div id="resumenSecciones" class="row g-3">
                <div class="col-12 text-muted small">Cargando información...</div>
            </div>
        </section>

        <!-- Resumen por casilla -->
        <section class="card card-modern p-3 p-md-4 mb-4">
            <div class="mb-3">
                <h2 class="h6 fw-bold mb-1">Distribución por Casilllas</h2>
                <!-- <small class="text-muted">Distribución de afiliados por sección y tipo de casilla</small> -->
            </div>

            <div class="row g-3" id="resumenCasillas">
                <div class="col-12 text-muted small">Cargando información...</div>
            </div>
        </section>

        <!-- Tabla de afiliados -->
        <section class="card card-modern p-3 p-md-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div>
                    <h2 class="h6 fw-bold mb-1">Listado Completo</h2>
                    <!-- <small class="text-muted">
                        Consulta y búsqueda de los registros capturados
                    </small> -->
                </div>

                <div class="input-group input-group-sm search-box">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="search" id="buscarAfiliado"
                        class="form-control"
                        placeholder="Buscar nombre, CURP, sección...">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted" id="contadorResultados">0 registros</small>
                <small class="text-muted">Más recientes primero</small>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Afiliado</th>
                            <th>CURP</th>
                            <th>Sección</th>
                            <th>Casilla</th>
                            <th>Promotor</th>
                            <th>Fecha de registro</th>
                        </tr>
                    </thead>
                    <tbody id="tablaAfiliados">
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Cargando afiliados...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/getDashboard.js"></script>

</body>

</html>