
<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['idUsuario'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'mensaje' => 'No existe una sesión activa.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once '../config/conexion.php';

try {
    $idUsuario = $_SESSION['idUsuario'];

    // Total de afiliados activos
    $sqlTotal = "
        SELECT COUNT(*) AS total
        FROM afiliados
        WHERE estado = 1
    ";

    $stmt = $conexion->prepare($sqlTotal);
    $stmt->execute();
    $total = (int) $stmt->fetchColumn();

    // Agrupación por sección y casilla
    $sqlResumen = "
        SELECT
            seccion,
            casilla,
            COUNT(*) AS total
        FROM afiliados
        WHERE estado = 1
        GROUP BY seccion, casilla
        ORDER BY seccion, casilla
    ";

    $stmt = $conexion->prepare($sqlResumen);
    $stmt->execute();
    $resumen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Listado de afiliados
    $sqlAfiliados = "
        SELECT
            a.nombres,
            a.aPaterno,
            a.aMaterno,
            a.curp,
            a.seccion,
            a.casilla,
            a.fechaRegistro,
            CONCAT_WS(
                ' ',
                p.nombres,
                p.aPaterno,
                p.aMaterno
            ) AS promotor
        FROM afiliados a
        LEFT JOIN promotores p
            ON p.idPromotor = a.idPromotor
        WHERE a.estado = 1
        ORDER BY a.fechaRegistro DESC
    ";

    $stmt = $conexion->prepare($sqlAfiliados);
    $stmt->execute();
    $afiliados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => [
            'total' => $total,
            'resumen' => $resumen,
            'afiliados' => $afiliados
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    error_log($e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'mensaje' => 'No fue posible obtener los datos del dashboard.'
    ], JSON_UNESCAPED_UNICODE);
}
