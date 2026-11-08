<?php
// adm/index.php
session_start();

if (empty($_SESSION['usuario_autenticado'])) {
    // Si no hay sesión activa, redirige al login
    header('Location: ../login.html');
    exit;
}

// Opcional: Cerrar sesión por inactividad tras 30 minutos
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: ../login.html?expirada=1');
    exit;
}
$_SESSION['ultimo_acceso'] = time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
</head>
<body>
  <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? ''); ?></h1>
  <a href="../logout.php">Cerrar Sesión</a>
</body>
</html>