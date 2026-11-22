
<?php

header('Content-Type: application/json; charset=utf-8');

require_once '../config/conexion.php';

// Aceptar únicamente solicitudes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'mensaje' => 'Método no permitido.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

try {

    // Recibir datos JSON
    $datos = json_decode(file_get_contents('php://input'), true);

    if (!is_array($datos)) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'mensaje' => 'Los datos enviados no son válidos.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // Obtener y limpiar datos
    $nombres = trim($datos['nombres'] ?? '');
    $aPaterno = trim($datos['aPaterno'] ?? '');
    $aMaterno = trim($datos['aMaterno'] ?? '');
    $idUsuario = filter_var(
        $datos['idUsuario'] ?? null,
        FILTER_VALIDATE_INT
    );

    // Validar campos obligatorios
    if (
        $nombres === '' ||
        $aPaterno === '' ||
        $aMaterno === '' ||
        $idUsuario === false ||
        $idUsuario === null ||
        $idUsuario <= 0
    ) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'mensaje' => 'Todos los campos son obligatorios.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // Validar longitud de campos
    if (
        mb_strlen($nombres) > 50 ||
        mb_strlen($aPaterno) > 50 ||
        mb_strlen($aMaterno) > 50
    ) {

        http_response_code(400);

        echo json_encode([
            'success' => false,
            'mensaje' => 'Los nombres y apellidos no deben superar los 50 caracteres.'
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // Insertar nuevo promotor
    $sql = "INSERT INTO promotores
            (nombres, aPaterno, aMaterno, idUsuario)
            VALUES
            (:nombres, :aPaterno, :aMaterno, :idUsuario)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':nombres' => $nombres,
        ':aPaterno' => $aPaterno,
        ':aMaterno' => $aMaterno,
        ':idUsuario' => $idUsuario
    ]);

    // Obtener ID del nuevo registro
    $idPromotor = $conexion->lastInsertId();

    http_response_code(201);

    echo json_encode([
        'success' => true,
        'mensaje' => 'Promotor registrado correctamente.',
        'data' => [
            'idPromotor' => (int) $idPromotor,
            'nombres' => $nombres,
            'aPaterno' => $aPaterno,
            'aMaterno' => $aMaterno
        ]
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {

    error_log($e->getMessage());

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'mensaje' => 'Ocurrió un error al registrar el promotor.'
    ], JSON_UNESCAPED_UNICODE);

}
