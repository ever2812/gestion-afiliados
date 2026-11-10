<?php
// crear_usuario.php
declare(strict_types=1);

// Conexión PDO
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

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Datos del nuevo usuario
    $usuario  = 'ever2812@gmail.com';
    $nombre   = 'Ever Lopez';
    $email    = 'ever2812@gmail.com';
    $password = 'Daira2812';
    $rol      = 'admin';
    

    // Cifrado seguro
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    $sql = "INSERT INTO usuarios (usuario, nombre, email, password_hash, rol, estado) 
            VALUES (:usuario, :nombre, :email, :password_hash, :rol, 1)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario'         => $usuario,
        ':nombre'        => $nombre,
        ':email'         => $email,
        ':password_hash' => $passwordHash,
        ':rol'           => $rol,        
    ]);

    echo "Usuario {$nombre} ({$usuario}) registrado correctamente.";

} catch (PDOException $e) {
    echo "Error al crear usuario: " . $e->getMessage();
}