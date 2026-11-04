<?php
// extract.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

if (!isset($_FILES['image_front'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió la imagen frontal']);
    exit;
}

$apiKey = 'ine_3VHQEtU0T6po9cHvOPp68Whw01dcBYR2'; // Tu clave queda protegida en el servidor
$file = $_FILES['image_front'];

$cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
$postData = ['image_front' => $cfile];

$ch = curl_init('https://extraerdatosdeine.com/api/v1/extract');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-API-Key: ' . $apiKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión: ' . $curlError]);
    exit;
}

http_response_code($httpCode);
echo $response;