<?php
// Inicia la sesión y verifica si existen las variables de sesión NombreUsuario y RolUsuario
session_start();
if (!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 3) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 3, redirecciona al login
    header("Location: login.php");
    exit(); // Termina la ejecución del script después de redireccionar
}

// Incluye el archivo de cabecera y el archivo de conexión a la base de datos
include('Includes/Header.php');
include('../Config/Traduccion.php');
// Establecer la zona horaria a México, Baja California
date_default_timezone_set('America/Tijuana');
$dia_actual = TraductorDia::traducir(date('l'));
include('../Config/Conexion.php');

// Obtiene la conexión a la base de datos
$conexion = ConexionBD::obtenerConexion();

// Obtiene el nombre del usuario asociado
$nombreUsuario = $_SESSION['NombreUsuario'];

// Consulta para obtener las clases y horarios asociados al día actual y al usuario
$query_clases_horarios = "SELECT NID_Clase, N_Clase, N_Dia, N_HoraInicio, N_HoraFin
                          FROM vw_clases
                          WHERE N_Dia = '$dia_actual' AND Nombre_Entrenador = '$nombreUsuario'";
$resultado_clases_horarios = mysqli_query($conexion, $query_clases_horarios);

// Recupera el código y la ruta del código QR desde la URL
$codigo = $_GET['codigo'] ?? '';
$ruta_qr = $_GET['qr_path'] ?? '';
?>

<script>
    // Cambia el título de la página a "Asistencia"
    cambiarTituloPagina("Asistencia");
</script>

<div class="container p-4 text-center">
    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="Codigos.php">
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
                        // Verificar si se obtuvieron resultados
                        if (mysqli_num_rows($resultado_clases_horarios) > 0) {
                            // Mostrar opciones del select
                            while ($fila = mysqli_fetch_assoc($resultado_clases_horarios)) {
                                echo "<option value='" . $fila['NID_Clase'] . "'>" . $fila['N_Clase'] . " - " . $fila['N_Dia'] . " - " . $fila['N_HoraInicio'] . " - " . $fila['N_HoraFin'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay clases disponibles para hoy</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="codigo">Codigo</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo de 10 digitos" aria-describedby="helpId" maxlength="10">
                    <small id="helpId" class="text-muted">Ingrese el código manualmente</small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="generarAleatorio" name="generarAleatorio">
                    <label class="form-check-label" for="generarAleatorio">
                        Generar código aleatorio
                    </label>
                </div>
                <br>
                <button type="submit" class="btn btn-outline-primary">Generar Código</button>
            </form>
        </div>
        <div class="col-md-8">
            <div class=" text-center">
                <div class="card card-body">
                    <h4>Código generado: <?php echo $codigo; ?></h4>
                    <?php if (!empty($ruta_qr)) : ?>
                        <img src="<?php echo $ruta_qr; ?>" alt="Código QR" class="img-fluid rounded mx-auto d-block mt-4" style="max-width: 500px; max-height: 500px;">
                    <?php else : ?>
                        <p>No se ha generado ningún código QR.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>