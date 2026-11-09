<?php
// adm/index.php
session_start();

if (empty($_SESSION['usuario_autenticado'])) {
    // Si no hay sesión activa, redirige al login
    header('Location: ../');
    exit;
}

// Opcional: Cerrar sesión por inactividad tras 30 minutos
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: ../');
    exit;
}
$_SESSION['ultimo_acceso'] = time();
?>