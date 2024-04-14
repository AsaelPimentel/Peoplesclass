<?php
require('../Resource/phpqrcode/qrlib.php');
$codigoAleatorio = '';// Inicializar la variable $codigoAleatorio
function generarCodigoAleatorio($longitud = 10) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    // Definir la carpeta donde se guardarán los códigos QR
    $dir = '../Assets/Img/temp/';

    // Verificar si la carpeta existe, si no, crearla
    if (!file_exists($dir)) {
        mkdir($dir);
    }

    // Definir el nombre del archivo de imagen del código QR
    $filename = $dir . 'codigo_qr_' . $codigo . '.png';

    // Generar el código QR
    $tamanio = 10;
    $level = 'M';
    $frameSize = 3;
    QRcode::png($codigo, $filename, $level, $tamanio, $frameSize);

    // Devolver el código generado y la ruta del archivo de imagen del código QR
    return array(
        'codigo' => $codigo,
        'qr_path' => $filename
    );
}

// Generar un código aleatorio junto con su código QR
//$resultado = generarCodigoAleatorio();

//$codigo = $resultado['codigo'];
//$ruta_qr = $resultado['qr_path'];

//echo "El código generado es: $codigo";
//echo "<br>";
//echo "El código QR se ha guardado en: $ruta_qr";
?>
