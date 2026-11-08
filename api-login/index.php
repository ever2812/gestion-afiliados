<?php
// login_process.php
declare(strict_types=1);

// Configuración de cookies de sesión seguras antes de iniciar
session_set_cookie_params([
    'lifetime' => 0,             // Dura hasta cerrar el navegador (o ajústalo a segundos)
    'path'     => '/',
    'domain'   => '',
    'secure'   => isset($_SERVER['HTTPS']), // Solo HTTPS si está disponible
    'httponly' => true,         // Evita que JavaScript pueda leer la cookie (protege contra XSS)
    'samesite' => 'Lax'
]);

session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Leer el JSON enviado desde fetch
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

$username = trim($data['username'] ?? '');
$password = trim($data['pswd'] ?? '');

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Usuario y contraseña requeridos']);
    exit;
}

/*
 * AQUÍ HACES LA CONSULTA A TU BASE DE DATOS (PDO)
 * Ejemplo:
 * $stmt = $pdo->prepare('SELECT id, nombre, password_hash, rol FROM promotores WHERE clave = ? OR email = ?');
 * $stmt->execute([$username, $username]);
 * $user = $stmt->fetch();
 */

// Simulación de verificación con hash seguro (password_verify)
// Para pruebas, sustituye con tus datos reales de BD:
$usuarioValido = ($username === 'admin' && $password === '123456');

if (!$usuarioValido) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Usuario o contraseña incorrectos']);
    exit;
}

// Regenerar ID de sesión para prevenir Session Fixation
session_regenerate_id(true);

// Guardar datos en la sesión de PHP
$_SESSION['usuario_autenticado'] = true;
$_SESSION['usuario_id'] = 1;
$_SESSION['usuario_nombre'] = $username;
$_SESSION['ultimo_acceso'] = time();

echo json_encode([
    'success' => true,
    'redirect' => './adm/'
]);
exit;