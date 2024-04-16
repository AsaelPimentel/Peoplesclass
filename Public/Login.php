<?php
include '../Config/Conexion.php';
ob_start(); // Iniciar el búfer de salida
$Usuario = $_POST['socio'];
$Pass = $_POST['pass'];
session_start();

$conexion = ConexionBD::obtenerConexion();
$consulta = "SELECT * FROM vw_empleados WHERE N_Usuario ='$Usuario' AND N_Password='$Pass'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_fetch_array($resultado);
if ($filas) {
    if ($filas['ID_Estado'] == 2) {
        $_SESSION['NombreUsuario'] = $filas['N_Nombre'];
        $_SESSION['RolUsuario'] = $filas['ID_Rol'];
        if ($filas['ID_Rol'] == 2) {
            header("Location: ../Admin/index.php");
        } elseif ($filas['ID_Rol'] == 3) {
            header("Location: Inicio.php");
        }
    } else {
        // Redirigir con el parámetro de error
        header("Location: Index.html?error=2");
        exit(); // Terminar la ejecución del script después de la redirección
    }
} else {
    header("Location: Index.html?error=1");
    exit(); // Terminar la ejecución del script después de la redirección
}

mysqli_free_result($resultado);
mysqli_close($conexion);
ob_end_flush(); // Enviar la salida almacenada en el búfer
?>
