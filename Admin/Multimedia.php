<?php session_start();
if (!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');
?>
<script>
    // Cambiar el título de la página a "Clases"
    cambiarTituloPagina("Videos");
</script>
<div class="container p-4">
    <h4>Subir video de rutinas para las clases</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>