<?php

header('Content-Type: application/json; charset=utf-8');

require_once '../config/conexion.php';

try {

    $sql = "SELECT
                idPromotor,
                CONCAT(
                    nombres, ' ',
                    aPaterno, ' ',
                    aMaterno
                ) AS nombreCompleto
            FROM promotores
            WHERE estado = 1
            ORDER BY aPaterno, aMaterno, nombres";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $promotores = $stmt->fetchAll();

    http_response_code(200);

    echo json_encode([
        'success' => true,
        'total' => count($promotores),
        'data' => $promotores
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {

    error_log($e->getMessage());

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'mensaje' => 'No fue posible obtener la lista de promotores.'
    ], JSON_UNESCAPED_UNICODE);

}