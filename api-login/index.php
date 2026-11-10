<?php
// login_process.php
declare(strict_types=1);

// Mostrar errores en respuesta JSON durante desarrollo
ini_set('display_errors', '0'); // Mantener en 0 para no corromper la salida JSON
error_reporting(E_ALL);

// Configuración de cookies de sesión seguras antes de iniciar
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => isset($_SERVER['HTTPS']),
    'httponly' => true,
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

$username = trim($data['user'] ?? '');
$password = trim($data['pswd'] ?? '');

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Usuario y contraseña requeridos']);
    exit;
}

// -------------------------------------------------------------
// CONEXIÓN A BASE DE DATOS (Ajusta la ruta a tu archivo de conexión)
// -------------------------------------------------------------
try {
    // Si ya tienes un archivo de conexión, descomenta la siguiente línea:
    // require_once __DIR__ . '/../conexion.php'; 

    // O si conectas directamente aquí:
    $host = 'localhost';
    $db   = 'gestion_afiliados';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error de conexión con la base de datos: ' . $e->getMessage()]);
    exit;
}

// -------------------------------------------------------------
// CONSULTA Y AUTENTICACIÓN
// -------------------------------------------------------------
try {
    // Buscar por usuario o por email
    $stmt = $pdo->prepare("SELECT id, usuario, nombre, password_hash, rol, estado FROM usuarios WHERE usuario = :input LIMIT 1");
    $stmt->execute([':input' => $username]);
    $usuario = $stmt->fetch();

    // 1. Validar si existe y si el hash coincide
    if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Usuario o contraseña incorrectos']);
        exit;
    }

    // 2. Validar si está activo
    if ((int)$usuario['estado'] !== 1) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.']);
        exit;
    }

    // 3. Prevenir Session Fixation
    session_regenerate_id(true);

    // 4. Guardar datos reales en la sesión de PHP
    $_SESSION['usuario_autenticado'] = true;
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_login'] = $usuario['usuario'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['ultimo_acceso'] = time();

    echo json_encode([
        'success' => true,
        'redirect' => './adm/'
    ]);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error interno al procesar el login: ' . $e->getMessage()]);
    exit;
}