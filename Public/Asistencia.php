<?php
session_start(); // Verifica si existen las variables de sesión NombreUsuario y RolUsuario
if (!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 3) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: login.php"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');
include('../Config/Codigos.php');
$conexion = ConexionBD::obtenerConexion();
// Obtener el nombre del usuario asociado
$nombreUsuario = $_SESSION['NombreUsuario'];

// Consulta para obtener las clases asociadas al usuario
$query_clases = "SELECT NID_Clase, N_Clase FROM vw_clases WHERE Nombre_Entrenador = '$nombreUsuario'";
$resultado_clases = mysqli_query($conexion, $query_clases);
?>

<script>
    // Cambiar el título de la página a "Inicio"
    cambiarTituloPagina("Asistencia");
</script>


<div class="container p-4 text-center">
    <div class="row">
        <div class="col-md-4">
            <form method="post">
                <div class="form-group">
                    <label for="fecha_caducidad">Fecha de caducidad:</label>
                    <input type="datetime-local" name="fecha_caducidad" id="fecha_caducidad" class="form-control" placeholder="Seleccione la fecha de caducidad" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Seleccione la fecha en la que el código expirará</small>
                </div>
                <div class="form-group">
                    <label for="clase">Clase</label>
                    <select class="form-control" name="clase" id="clase">
                        <option value=""> -- Seleccionar --</option>
                        <?php
                        // Iterar sobre los resultados de la consulta y generar opciones del select
                        while ($fila = mysqli_fetch_assoc($resultado_clases)) {
                            echo "<option value='" . $fila['NID_Clase'] . "'>" . $fila['N_Clase'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="generarCodigo" class="btn btn-outline-primary">Generar Código</button>
            </form>
        </div>
        <div class="col-md-8">
            <div class="container p-4 text-center">
                <div class="card card-body">
                    <?php
                    // Si se envió el formulario, genera el código
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $codigoAleatorio = generarCodigoAleatorio();
                        echo "<div><h4>El código generado es: $codigoAleatorio</h4></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>