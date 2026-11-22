<?php
// api/afiliados/guardarAfiliado.php

header('Content-Type: application/json; charset=utf-8');
session_start();

// Verificar sesión
if (!isset($_SESSION['idUsuario'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Sesión no válida. Inicie sesión nuevamente.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once '../config/conexion.php';

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Método no permitido.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Recibir datos
$nombres     = trim($_POST['nombres'] ?? '');
$aPaterno    = trim($_POST['aPaterno'] ?? '');
$aMaterno    = trim($_POST['aMaterno'] ?? '');
$curp        = strtoupper(trim($_POST['curp'] ?? ''));
$cveElector  = strtoupper(trim($_POST['cveElector'] ?? ''));
$domicilio   = trim($_POST['domicilio'] ?? '');
$seccion     = trim($_POST['seccion'] ?? '');
$ineVigencia = $_POST['ineVigencia'] ?? null;
$casilla     = trim($_POST['casilla'] ?? '');
$numLista    = $_POST['numLista'] ?? null;
$idPromotor  = $_POST['idPromotor'] ?? null;

$idUsuario = $_SESSION['idUsuario'];

// Validar campos obligatorios
if (
    $nombres === '' ||
    $aPaterno === '' ||
    $aMaterno === '' ||
    $curp === '' ||
    $cveElector === '' ||
    $domicilio === '' ||
    $seccion === '' ||
    $ineVigencia === null ||
    $ineVigencia === '' ||
    $idPromotor === null ||
    $idPromotor === ''
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Todos los campos obligatorios deben completarse.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar CURP
if (!preg_match('/^[A-Z0-9]{18}$/', $curp)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'La CURP debe contener 18 caracteres alfanuméricos.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar clave de elector
if (strlen($cveElector) !== 18) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'La clave de elector debe contener 18 caracteres.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar vigencia
if (filter_var($ineVigencia, FILTER_VALIDATE_INT) === false) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'La vigencia de la INE no es válida.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar idPromotor
if (filter_var($idPromotor, FILTER_VALIDATE_INT) === false || (int)$idPromotor <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'El promotor seleccionado no es válido.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar numLista -  por ahora no se agregará numero de lista
// if ($numLista !== null && $numLista !== '') {
//     if (filter_var($numLista, FILTER_VALIDATE_INT) === false) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'mensaje' => 'El número de lista no es válido.'
//         ], JSON_UNESCAPED_UNICODE);
//         exit;
//     }
// } else {
//     $numLista = null;
// }

// Validar casilla
$casilla = ($casilla === '') ? null : $casilla;

// Validar archivo
if (!isset($_FILES['fotoIne']) || $_FILES['fotoIne']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Es obligatorio subir la fotografía de la INE.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$archivo = $_FILES['fotoIne'];

// Limitar tamaño a 5 MB
$maximo = 5 * 1024 * 1024;

if ($archivo['size'] > $maximo) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'La imagen no debe superar los 5 MB.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Validar tipo MIME real
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($archivo['tmp_name']);

$tiposPermitidos = [
    'image/jpeg' => 'jpeg',
    'image/jpg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

if (!isset($tiposPermitidos[$mime])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'mensaje' => 'El archivo debe ser una imagen JPG, PNG o WEBP.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Usar la extensión correspondiente al tipo real de imagen
$extension = $tiposPermitidos[$mime];

// Directorio de imágenes
$directorio = '../../docs/';

// Crear carpeta si no existe
if (!is_dir($directorio)) {
    if (!mkdir($directorio, 0755, true)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'mensaje' => 'No fue posible crear el directorio de imágenes.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Nombre del archivo basado en la CURP
$nombreArchivo = $curp . '.' . $extension;

// Ruta física donde se guardará
$rutaFisica = $directorio . $nombreArchivo;

// Ruta que se guardará en MySQL
$rutaBD = 'docs/' . $nombreArchivo;

// Evitar sobrescribir archivos
if (file_exists($rutaFisica)) {
    http_response_code(409);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Ya existe un archivo con esta CURP.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

include 'funcionCasillas.php';

$codigoApellido = obtenerCodigoApellido($aPaterno);

$casilla = obtenerCasilla($seccion, $codigoApellido);

try {

    // Mover archivo a docs
    if (!move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
        throw new RuntimeException('No fue posible guardar la imagen.');
    }

    // Insertar afiliado
    $sql = "INSERT INTO afiliados (nombres,aPaterno,aMaterno,curp,cveElector,domicilio,seccion,ineVigencia,casilla,idPromotor,idUsuario,fechaRegistro,fotoIne) 
            VALUES (
                :nombres,
                :aPaterno,
                :aMaterno,
                :curp,
                :cveElector,
                :domicilio,
                :seccion,
                :ineVigencia,
                :casilla,                
                :idPromotor,
                :idUsuario,
                NOW(),
                :fotoIne
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':nombres'     => $nombres,
        ':aPaterno'    => $aPaterno,
        ':aMaterno'    => $aMaterno,
        ':curp'        => $curp,
        ':cveElector'  => $cveElector,
        ':domicilio'   => $domicilio,
        ':seccion'     => $seccion,
        ':ineVigencia' => $ineVigencia,
        ':casilla'     => $casilla,
        ':idPromotor'  => $idPromotor,
        ':idUsuario'   => $idUsuario,
        ':fotoIne'     => $rutaBD
    ]);

    http_response_code(201);

    echo json_encode([
        'success' => true,
        'mensaje' => 'Afiliado registrado correctamente.',
        'data' => [
            'curp' => $curp,
            'fotoIne' => $rutaBD
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {

    // Si ocurrió un error, eliminar la imagen que ya se guardó
    if (isset($rutaFisica) && file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }

    error_log($e->getMessage());

    // CURP duplicada
    if ($e instanceof PDOException && $e->getCode() === '23000') {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'mensaje' => 'Ya existe un afiliado registrado con esta CURP.'
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'mensaje' => 'Ocurrió un error al guardar el afiliado o su fotografía.' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
}
