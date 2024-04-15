<?php
// Inicia la sesión y verifica si existen las variables de sesión NombreUsuario y RolUsuario
session_start(); 
include('../Config/Conexion.php'); // Incluye el archivo de conexión a la base de datos
require_once('../Resource/phpqrcode/qrlib.php'); // Incluye la librería para generar códigos QR

// Verifica si existen las variables de sesión NombreUsuario y RolUsuario
if (!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 3) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 3, redirecciona al login
    header("Location: login.php");
    exit(); // Termina la ejecución del script después de redireccionar
}

// Obtener el nombre del usuario asociado
$nombreUsuario = $_SESSION['NombreUsuario'];

// Recuperar los datos del formulario si se envió mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_caducidad = $_POST['fecha_caducidad'];
    $id_clase = $_POST['clase'];
    $codigo_ingresado = $_POST['codigo'];

    // Insertar los datos en la base de datos
    $conexion = ConexionBD::obtenerConexion();
    $query_insertar = "INSERT INTO cat_codigos (N_Codigo, N_FechaExpiracion, ID_Clase) VALUES ('$codigo_ingresado', '$fecha_caducidad', '$id_clase')";
    $resultado_insertar = mysqli_query($conexion, $query_insertar);
    
    // Generar el código QR
    $dir = '../Assets/Img/temp/';
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $filename = $dir . 'codigo_qr_' . $codigo_ingresado . '.png';
    QRcode::png($codigo_ingresado, $filename, QR_ECLEVEL_L, 10, 2);

    // Redirigir a la página de Asistencia.php
    header("Location: Asistencia.php?codigo=$codigo_ingresado&qr_path=$filename");
    exit();
}
?>
