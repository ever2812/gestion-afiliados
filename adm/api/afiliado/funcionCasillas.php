<?php
function obtenerCodigoApellido($apellidoPaterno)
{
    $apellidoPaterno = mb_strtoupper(trim($apellidoPaterno), 'UTF-8');

    // Obtener la primera letra
    $primeraLetra = mb_substr($apellidoPaterno, 0, 1, 'UTF-8');

    // Arreglo de equivalencias de la primera letra del apellido
    $codigos = [
        'A' => 65,
        'B' => 66,
        'C' => 67,
        'D' => 68,
        'E' => 69,
        'F' => 70,
        'G' => 71,
        'H' => 72,
        'I' => 73,
        'J' => 74,
        'K' => 75,
        'L' => 76,
        'M' => 77,
        'N' => 78,
        'O' => 79,
        'P' => 80,
        'Q' => 81,
        'R' => 82,
        'S' => 83,
        'T' => 84,
        'U' => 85,
        'V' => 86,
        'W' => 87,
        'X' => 88,
        'Y' => 89,
        'Z' => 90
    ];

    return $codigos[$primeraLetra] ?? null;
}


//VALORES ABECEDARIO
// A: 65 | B: 66 | C: 67 | D: 68 | E: 69 | F: 70
// G: 71 | H: 72 | I: 73 | J: 74 | K: 75 | L: 76
// M: 77 | N: 78 | O: 79 | P: 80 | Q: 81 | R: 82
// S: 83 | T: 84 | U: 85 | V: 86 | W: 87 | X: 88
// Y: 89 | Z: 90

function obtenerCasilla($seccion, $codigoApellido)
{

    $matriz = [
        '0433' => [
            ['casilla' => 'B', 'min' => 65, 'max' => 73],  // APELLIDOS DE LA LETRA A:65 - HASTA LA LETRA I:73
            ['casilla' => 'C1', 'min' => 74, 'max' => 80], // APELLIDOS DE LA LETRA J:74 - HASTA LA LETRA P:80
            ['casilla' => 'C2', 'min' => 81, 'max' => 90]  // APELLIDOS DE LA LETRA Q:81 - HASTA LA LETRA Z:90 
        ],

        '0434' => [
            ['casilla' => 'B', 'min' => 65, 'max' => 73],   // APELLIDOS DE LA LETRA A:65 - HASTA LA LETRA I:73
            ['casilla' => 'C1', 'min' => 74, 'max' => 80],  // APELLIDOS DE LA LETRA J:74 - HASTA LA LETRA P:80
            ['casilla' => 'C2', 'min' => 81, 'max' => 90]   // APELLIDOS DE LA LETRA Q:81 - HASTA LA LETRA Z:90
        ],

        '0435' => [
            ['casilla' => 'B', 'min' => 65, 'max' => 73],   // APELLIDOS DE LA LETRA A:65 - HASTA LA LETRA I:73
            ['casilla' => 'C1', 'min' => 74, 'max' => 80],  // APELLIDOS DE LA LETRA J:74 - HASTA LA LETRA P:80
            ['casilla' => 'C2', 'min' => 81, 'max' => 90]   // APELLIDOS DE LA LETRA Q:81 - HASTA LA LETRA Z:90
        ]
    ];

    $seccion = str_pad(trim($seccion), 4, '0', STR_PAD_LEFT);

    if (!isset($matriz[$seccion])) {
        return null;
    }

    foreach ($matriz[$seccion] as $rango) {

        if (
            $codigoApellido >= $rango['min'] &&
            $codigoApellido <= $rango['max']
        ) {
            return $rango['casilla'];
        }
    }

    return null;
}
