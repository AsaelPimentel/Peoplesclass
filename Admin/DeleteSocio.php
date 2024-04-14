<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include ('../Config/Conexion.php');
if (isset($_GET['id'])) {
    // Conexión a la base de datos
    $conexion = ConexionBD::obtenerConexion();
    // Sanitizar el ID para evitar posibles ataques de inyección SQL
    $Id = mysqli_real_escape_string($conexion, $_GET['id']);
    // Consulta preparada para eliminar el registro
    $Query = "DELETE FROM tb_socios WHERE N_Socio = ?";
    $stmt = mysqli_prepare($conexion, $Query);
    mysqli_stmt_bind_param($stmt, "i", $Id);
    $Resultado = mysqli_stmt_execute($stmt);
    if ($Resultado) {
        // Establecer mensaje de éxito en la sesión
        session_start();
        $_SESSION['mensaje'] = 'Se eliminó correctamente.';
        $_SESSION['tipomensaje'] = 'danger';
    } else {
        die('Error: ' . mysqli_error($conexion));
    }
    // Redireccionar a la página de Horarios después de eliminar el registro
    header('Location: Socios.php');
    exit(); // Terminar la ejecución del script después de la redirección
}
?>
