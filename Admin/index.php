<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión
// Verifica si existen las variables de sesión NombreUsuario y RolUsuario
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
// Incluir el archivo de conexión a la base de datos
include('../Config/Conexion.php');
// Establecer la zona horaria a México, Baja California
date_default_timezone_set('America/Tijuana');
$conexion = ConexionBD::obtenerConexion();
// Consulta para obtener el conteo total de clases
$query_clases = "SELECT COUNT(*) AS total_clases FROM cat_clases";
$resultado_clases = mysqli_query($conexion, $query_clases);
$total_clases = mysqli_fetch_assoc($resultado_clases)['total_clases'];

// Consulta para obtener el conteo total de socios
$query_socios = "SELECT COUNT(*) AS total_socios FROM vw_socios WHERE ID_Estado = 2";
$resultado_socios = mysqli_query($conexion, $query_socios);
$total_socios = mysqli_fetch_assoc($resultado_socios)['total_socios'];

// Consulta para obtener el conteo total de entrenadores
$query_entrenadores = "SELECT COUNT(*) AS total_entrenadores FROM cat_entrenadores";
$resultado_entrenadores = mysqli_query($conexion, $query_entrenadores);
$total_entrenadores = mysqli_fetch_assoc($resultado_entrenadores)['total_entrenadores'];
?>

<?php include('Includes/Header.php'); ?>
<script>
    // Cambiar el título de la página a "Inicio"
    cambiarTituloPagina("Inicio");
</script>

<div class="container p-4">
    <main>
        <div class="container-fluid px-4 text-center">
            <h3 class="bg-secondary text-white">Bienvenido <?php echo $_SESSION['NombreUsuario']; ?></h3>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <i class="fas fa-chalkboard fa-3x mr-2"></i> <!-- Icono de clases -->
                        <h1 class="mb-0"><?php echo $total_clases; ?></h1> <!-- Conteo total de clases -->
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a class="btn btn-outline-light stretched-link btn-block" href="Clases.php">Ver Clases <i class="fas fa-angle-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-friends fa-3x mr-2"></i> <!-- Icono de socios -->
                        <h1 class="mb-0"><?php echo $total_socios; ?></h1> <!-- Conteo total de socios -->
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a class="btn btn-outline-light stretched-link btn-block" href="Socios.php">Ver Socios <i class="fas fa-angle-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <i class="fas fa-user fa-3x mr-2"></i> <!-- Icono de entrenadores -->
                        <h1 class="mb-0"><?php echo $total_entrenadores; ?></h1> <!-- Conteo total de entrenadores -->
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a class="btn btn-outline-light stretched-link btn-block" href="Coach.php">Ver Entrenadores <i class="fas fa-angle-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <i class="far fa-file-alt fa-3x mr-2"></i> <!-- Icono de reportes -->
                        <!-- Puedes agregar contenido adicional aquí si lo deseas -->
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a class="btn btn-outline-light stretched-link btn-block" href="#">Ver Reportes <i class="fas fa-angle-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<?php include('Includes/Footer.php'); ?>
