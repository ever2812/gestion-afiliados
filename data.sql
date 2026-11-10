
CREATE TABLE IF NOT EXISTS `usuarios` (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE COMMENT 'Clave de promotor ej. PM-0104 o usuario',
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin', 'promotor', 'supervisor') NOT NULL DEFAULT 'promotor',  
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_el TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_el TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



   // Datos del nuevo usuario
    $usuario  = 'ever2812@gmail.com';
    $nombre   = 'Ever Lopez';
    $email    = 'ever2812@gmail.com';
    $password = 'Daira2812';
    $rol      = 'admin';
INSERT INTO usuarios (usuario, nombre, email, password_hash, rol, estado) 
            VALUES (:usuario, :nombre, :email, :password_hash, :rol, 1)