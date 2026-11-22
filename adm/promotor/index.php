<?php
  include '../api/session/check.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Promotores</title>
  
  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../pubs/estilo.css">
</head>
<body class="pb-5">

  <!-- Minimal Header con Menú de Navegación -->
  <header class="bg-white border-bottom py-2 py-md-3 mb-4 sticky-top shadow-sm">
    <div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-between">
      
      <!-- Extremo Izquierdo: Identidad / Logo -->
      <a href="./index.php" class="d-flex align-items-center gap-2 text-decoration-none">
        <div class="bg-dark text-white rounded-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; min-width: 36px;">
          <i class="bi bi-person-vcard fs-5"></i>
        </div>
        <div>
          <span class="fw-bold text-dark fs-6 tracking-tight d-block lh-1">Gestión de Afiliados</span>
          <span class="text-muted" style="font-size: 0.75rem;">Alta de Promotores</span>
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
        style="width: 38px; height: 38px;"
      >
        <i class="bi bi-list fs-4 lh-1"></i>
      </button>

    </div>
  </header>

  <!-- Menú Lateral Deslizante (Offcanvas) -->
  <div class="offcanvas offcanvas-end border-0 shadow" tabindex="-1" id="navMenuOffcanvas" aria-labelledby="navMenuLabel" style="max-width: 300px;">
    
    <!-- Encabezado del Menú -->
    <div class="offcanvas-header border-bottom py-3">
      <div class="d-flex align-items-center gap-2">
        <div class="bg-primary-subtle text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
          <i class="bi bi-grid-fill fs-6"></i>
        </div>
        <h6 class="offcanvas-title fw-bold text-dark mb-0" id="navMenuLabel">Navegación</h6>
      </div>
      <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <!-- Cuerpo con Enlaces -->
    <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
      <div class="list-group list-group-flush border-0">
        
        <!-- Opción: Captura de INE -->
       <a href="../registro/" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-3 rounded-3 mb-1 border-0 text-secondary">
          <i class="bi bi-camera-fill text-muted fs-5"></i>
          <div>
            <span class="d-block lh-1 text-dark fw-medium">Registro</span>
            <small class="text-muted" style="font-size: 0.75rem;">Escanear y afiliar</small>
          </div>
        </a>

        <!-- Opción: Promotores (Activa en esta pantalla) -->
        <a href="../promotor/" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-3 rounded-3 mb-1 border-0 bg-light text-dark fw-semibold">
          <i class="bi bi-person-badge-fill text-primary fs-5"></i>
          <div>
            <span class="d-block lh-1">Promotores</span>
            <small class="text-muted fw-normal" style="font-size: 0.75rem;">Alta y gestión de equipo</small>
          </div>
        </a>

        <!-- Opción: Mini Dashboard / Estadísticas -->
        <a href="./dashboard.php" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-3 rounded-3 mb-1 border-0 text-secondary">
          <i class="bi bi-bar-chart-line-fill text-muted fs-5"></i>
          <div>
            <span class="d-block lh-1 text-dark fw-medium">Dashboard</span>
            <small class="text-muted" style="font-size: 0.75rem;">Resultados y métricas</small>
          </div>
        </a>

        <!-- Opción: Listado de Afiliados Capturados -->
        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-3 rounded-3 mb-1 border-0 text-secondary">
          <i class="bi bi-people-fill text-muted fs-5"></i>
          <div>
            <span class="d-block lh-1 text-dark fw-medium">Afiliados</span>
            <small class="text-muted" style="font-size: 0.75rem;">Consulta de registros</small>
          </div>
        </a>

      </div>

      <!-- Sección Inferior: Usuario & Logout -->
      <div class="pt-3 border-top mt-auto">
        <div class="d-flex align-items-center justify-content-between mb-3 px-1">
          <div class="d-flex align-items-center gap-2 overflow-hidden">
            <div class="bg-secondary-subtle text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; min-width: 32px;">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="text-truncate">
              <div class="small fw-bold text-dark text-truncate">
                <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Promotor'); ?>
              </div>
              <div class="text-muted text-truncate" style="font-size: 0.7rem;">Sesión activa</div>
            </div>
          </div>
        </div>

        <a href="api/session/end.php" class="btn btn-outline-danger w-100 rounded-2 btn-sm d-flex align-items-center justify-content-center gap-2 py-2">
          <i class="bi bi-box-arrow-right"></i>
          <span>Cerrar Sesión</span>
        </a>
      </div>

    </div>
  </div>

  <main class="container" style="max-width: 760px;">

    <!-- Alert / Status Notifications -->
    <div id="statusMessage" class="alert d-none py-2 px-3 rounded-3 small mb-3 shadow-sm" role="alert"></div>

    <!-- SECCIÓN: FORMULARIO DE ALTA DE PROMOTOR -->
    <section class="card card-modern p-4 mb-4">
      <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
        <div>
          <h1 class="h6 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill text-primary"></i> Registrar Nuevo Promotor
          </h1>
          <p class="text-muted small mb-0">Completa los datos personales para habilitarlo en la lista de captura</p>
        </div>
      </div>

      <form id="promotorForm" onsubmit="event.preventDefault(); handleSavePromotor();">
        <div class="row g-3">
          
          <!-- Nombre(s) -->
          <div class="col-md-4">
            <label for="nombre" class="form-label-subtle">
              Nombre(s) <span class="text-danger">*</span>
            </label>
            <input 
              type="text" 
              id="nombre" 
              name="nombre"
              class="form-control form-control-modern" 
              placeholder="Ej. Carlos" 
              autocomplete="given-name"
              required
            >
          </div>

          <!-- Apellido Paterno -->
          <div class="col-md-4">
            <label for="apellidoPaterno" class="form-label-subtle">
              Apellido Paterno <span class="text-danger">*</span>
            </label>
            <input 
              type="text" 
              id="apellidoPaterno" 
              name="apellidoPaterno"
              class="form-control form-control-modern" 
              placeholder="Ej. Mendoza" 
              autocomplete="family-name"
              required
            >
          </div>

          <!-- Apellido Materno -->
          <div class="col-md-4">
            <label for="apellidoMaterno" class="form-label-subtle">
              Apellido Materno
            </label>
            <input 
              type="text" 
              id="apellidoMaterno" 
              name="apellidoMaterno"
              class="form-control form-control-modern" 
              placeholder="Ej. López"
            >
          </div>

          <!-- Teléfono -->
          <div class="col-md-6">
            <label for="telefono" class="form-label-subtle">
              Teléfono (10 dígitos) <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #dee2e6;">
                <i class="bi bi-telephone"></i>
              </span>
              <input 
                type="tel" 
                id="telefono" 
                name="telefono"
                class="form-control form-control-modern border-start-0 ps-1 font-monospace" 
                placeholder="Ej. 9611234567" 
                inputmode="tel"
                maxlength="10"
                pattern="[0-9]{10}"
                required
              >
            </div>
          </div>

        </div>

        <!-- Botones de Acción -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-4 pt-3 border-top">
          <button type="button" class="btn btn-outline-secondary rounded-2 btn-sm px-3" onclick="resetPromotorForm()">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar Campos
          </button>
          
          <button type="submit" id="btnSavePromotor" class="btn btn-dark rounded-2 btn-sm px-4 py-2 d-flex align-items-center gap-2">
            <i class="bi bi-check2-circle"></i>
            <span id="btnSaveText">Guardar Promotor</span>
            <div id="btnSaveSpinner" class="spinner-border spinner-border-sm d-none" role="status">
              <span class="visually-hidden">Guardando...</span>
            </div>
          </button>
        </div>
      </form>
    </section>

    <!-- SECCIÓN: PROMOTORES REGISTRADOS (Vista rápida responsiva) -->
    <section class="card card-modern p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h6 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
          <i class="bi bi-people text-secondary"></i> Promotores Activos
        </h2>
        <span class="badge bg-light text-secondary border fw-normal" id="promotoresCountBadge">0 registros</span>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
          <thead class="table-light text-muted">
            <tr>
              <th class="fw-semibold border-0">Nombre Completo</th>
              <th class="fw-semibold border-0">Teléfono</th>
              <th class="fw-semibold border-0 text-end">Estatus</th>
            </tr>
          </thead>
          <tbody id="promotoresTableBody">
            <!-- Ejemplo estático inicial / se poblará dinámicamente -->
            <tr>
              <td class="fw-medium text-dark">Carlos Mendoza</td>
              <td class="font-monospace text-muted">9611234567</td>
              <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-muted small mt-5 pt-3">
      Gestion de Afiliados - @ever2812      
    </footer>
  </main>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Solo permitir dígitos en el teléfono
    document.getElementById('telefono').addEventListener('input', function (e) {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    function showStatus(message, type = 'success') {
      const box = document.getElementById('statusMessage');
      box.className = `alert alert-${type} py-2 px-3 rounded-3 small mb-3 shadow-sm`;
      box.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-1"></i> ${message}`;
      box.classList.remove('d-none');
    }

    function resetPromotorForm() {
      document.getElementById('promotorForm').reset();
      document.getElementById('statusMessage').classList.add('d-none');
    }

    async function handleSavePromotor() {
      const nombre = document.getElementById('nombre').value.trim();
      const apellidoPaterno = document.getElementById('apellidoPaterno').value.trim();
      const apellidoMaterno = document.getElementById('apellidoMaterno').value.trim();
      const telefono = document.getElementById('telefono').value.trim();

      const btn = document.getElementById('btnSavePromotor');
      const btnText = document.getElementById('btnSaveText');
      const spinner = document.getElementById('btnSaveSpinner');

      if (!nombre || !apellidoPaterno || telefono.length !== 10) {
        showStatus('Verifica que el nombre, apellido paterno y teléfono (10 dígitos) sean válidos.', 'danger');
        return;
      }

      btn.disabled = true;
      btnText.textContent = 'Guardando...';
      spinner.classList.remove('d-none');

      try {
        /* 
        // Integración con tu endpoint PHP:
        const response = await fetch('./api/promotores/create.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ nombre, apellidoPaterno, apellidoMaterno, telefono })
        });
        const result = await response.json();
        if (!response.ok || !result.success) throw new Error(result.error || 'No se pudo guardar');
        */

        // Simulación de guardado
        await new Promise(r => setTimeout(r, 600));

        // Agregar a la tabla visualmente
        const tbody = document.getElementById('promotoresTableBody');
        const nombreCompleto = `${nombre} ${apellidoPaterno} ${apellidoMaterno}`.trim();
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td class="fw-medium text-dark">${nombreCompleto}</td>
          <td class="font-monospace text-muted">${telefono}</td>
          <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span></td>
        `;
        tbody.prepend(tr);

        showStatus(`Promotor <strong>${nombreCompleto}</strong> guardado correctamente.`, 'success');
        document.getElementById('promotorForm').reset();

      } catch (err) {
        showStatus(err.message || 'Error al registrar promotor.', 'danger');
      } finally {
        btn.disabled = false;
        btnText.textContent = 'Guardar Promotor';
        spinner.classList.add('d-none');
      }
    }
  </script>
</body>
</html>