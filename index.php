<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingresar-[Gestión de Afiliados]</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="./pubs/estilo.css" rel="stylesheet">

</head>

<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Minimal Header (Igual que en la pantalla de captura) -->
  <header class="bg-white border-bottom py-3 sticky-top shadow-sm">
    <div class="container d-flex align-items-center justify-content-between" style="max-width: 460px;">
      <div class="d-flex align-items-center gap-2">
        <div class="bg-dark text-white rounded-2 d-flex align-items-center justify-content-center"
          style="width: 34px; height: 34px;">
          <i class="bi bi-person-vcard fs-5"></i>
        </div>
        <div>
          <span class="fw-bold text-dark fs-6 tracking-tight d-block lh-1">Gestión de Afiliados</span>
          <!-- <span class="text-muted" style="font-size: 0.75rem;">Extraer datos de INE</span> -->
        </div>
      </div>
    </div>
  </header>

  <!-- Contenedor Principal Centrado para Móvil y Desktop -->
  <main class="container my-auto py-4 px-3" style="max-width: 460px;">

    <!-- Tarjeta de Login -->
    <section class="card card-modern p-4 shadow-sm border-0">

      <!-- Encabezado de la Card -->
      <div class="text-center mb-4">
        <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center border mb-2"
          style="width: 52px; height: 52px;">
          <i class="bi bi-shield-lock fs-4 text-primary"></i>
        </div>
        <h1 class="h5 fw-bold text-dark mb-1">Acceso a Plataforma</h1>
        <p class="text-muted small mb-0">Ingresa tus datos de acceso</p>
      </div>

      <!-- Alerta de Error / Notificación -->
      <div id="loginAlert" class="alert alert-danger py-2 px-3 rounded-3 small mb-3 d-none" role="alert">
        <i class="bi bi-exclamation-circle me-1"></i>
        <span id="loginAlertText">Usuario o contraseña incorrectos.</span>
      </div>

      <!-- Formulario de Login -->
      <form id="loginForm" onsubmit="event.preventDefault(); handleLogin();" novalidate>

        <!-- Campo: Usuario / Identificador / Correo -->
        <div class="mb-3">
          <label for="usernameInput" class="form-label-subtle mb-1">
            <i class="bi bi-person text-primary me-1"></i> Usuario/correo <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted">
              <i class="bi bi-person-badge"></i>
            </span>
            <input type="text" id="usernameInput"
              class="form-control form-control-modern border-start-0 ps-0"
              placeholder="usuario@correo.com" autocomplete="username" autocapitalize="none" required>
          </div>
        </div>

        <!-- Campo: Contraseña con Visor -->
        <div class="mb-3">
          <div class="d-flex align-items-center justify-content-between mb-1">
            <label for="passwordInput" class="form-label-subtle m-0">
              <i class="bi bi-key text-primary me-1"></i> Contraseña <span class="text-danger">*</span>
            </label>
            <a href="#" class="text-decoration-none small text-muted" style="font-size: 0.75rem;">¿La
              olvidaste?</a>
          </div>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted">
              <i class="bi bi-lock"></i>
            </span>
            <input type="password" id="passwordInput"
              class="form-control form-control-modern border-start-0 border-end-0 px-0"
              placeholder="••••••••" autocomplete="current-password" required>
            <button type="button" class="btn btn-password-toggle px-3 shadow-none" id="btnTogglePassword"
              onclick="togglePasswordVisibility()" tabindex="-1">
              <i class="bi bi-eye fs-6" id="passwordEyeIcon"></i>
            </button>
          </div>
        </div>

        <!-- Recordar sesión -->
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label text-muted small" for="rememberMe" style="font-size: 0.8rem;">
              Mantener sesión iniciada
            </label>
          </div>
        </div>

        <!-- Botón de Ingreso con Feedback de Carga -->
        <div class="d-grid">
          <button type="submit" id="btnLoginSubmit"
            class="btn btn-dark py-2 rounded-3 d-flex align-items-center justify-content-center gap-2 shadow-sm">
            <i class="bi bi-box-arrow-in-right"></i>
            <span id="btnLoginText">Ingresar</span>
            <div id="btnLoginSpinner" class="spinner-border spinner-border-sm d-none" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
          </button>
        </div>

      </form>
    </section>

    <!-- Footer Idéntico -->
    <footer class="text-center text-muted small mt-4 pt-2">
      Gestión de Afiliados
    </footer>
  </main>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="./pubs/js/app.js"></script>

</body>

</html>