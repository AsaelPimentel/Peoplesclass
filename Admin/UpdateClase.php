<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}

include('../Config/Conexion.php');
$conexion = ConexionBD::obtenerConexion();

// Verificar si existe el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    $Id = $_GET['id'];
    // Consultar la clase con el ID proporcionado
    $Query = "SELECT * FROM Cat_Clases WHERE NID_Clase = '$Id'";
    $Resultado = mysqli_query($conexion, $Query);
    // Verificar si se encontró una sola fila
    if (mysqli_num_rows($Resultado) == 1) {
        $row =  mysqli_fetch_array($Resultado);
        // Almacenar los datos de la clase en variables
        $Clase = $row['N_Clase'];
        $Entrenador = $row['ID_Entrenador'];
        $Horario = $row['ID_Horario'];
    }
}

// Verificar si se envió el formulario para actualizar la clase
if (isset($_POST['Actulizar'])) {
    $id = $_GET['id'];
    $Clase = $_POST['nombre'];
    $Entrenador = $_POST['entrenador'];
    $Horario = $_POST['horario'];
    // Actualizar la clase en la base de datos
    $query = "UPDATE cat_clases SET N_Clase = '$Clase', ID_Entrenador = '$Entrenador', ID_Horario = '$Horario' WHERE NID_Clase = '$id'";
    mysqli_query($conexion, $query);
    $_SESSION['mensaje'] = 'El registro se actualizó correctamente.';
    $_SESSION['tipomensaje'] = 'warning';
    header('Location: Clases.php');
}
?>
<?php include('Includes/Header.php'); ?>
<script>
    // Cambiar el título de la página a "Editar Clase"
    cambiarTituloPagina("Editar Clase");
</script>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form id="actualizarForm" action="UpdateClase.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre de la Clase</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo $Clase ?>" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="entrenador">Entrenador</label>
                        <select class="form-control" id="entrenador" name="entrenador" required>
                            <?php
                            // Query para obtener los entrenadores
                            $query_entrenadores = "SELECT NID_Entrenador, CONCAT(Nombre_Empleado, ' ', Apellido_Paterno) AS Nombre FROM vw_entrenadores";
                            $result_entrenadores = mysqli_query($conexion, $query_entrenadores);
                            // Iterar sobre los resultados y generar opciones del menú desplegable
                            while ($row = mysqli_fetch_assoc($result_entrenadores)) {
                                // Verificar si el ID del entrenador coincide con el valor almacenado en $Entrenador
                                $selected = ($row['NID_Entrenador'] == $Entrenador) ? 'selected' : '';
                                echo "<option value='" . $row['NID_Entrenador'] . "' $selected>" . $row['Nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horario">Horario</label>
                        <select class="form-control" id="horario" name="horario" required>
                            <?php
                            // Query para obtener los horarios disponibles
                            $query_horarios = "SELECT NID_Horario, CONCAT(N_Dia, ' - ', N_HoraInicio, ' a ', N_HoraFin, ' ', N_Turno) AS HorarioCompleto FROM Cat_Horarios";
                            $result_horarios = mysqli_query($conexion, $query_horarios);
                            // Iterar sobre los resultados y generar opciones del menú desplegable
                            while ($row = mysqli_fetch_assoc($result_horarios)) {
                                // Verificar si el ID del horario coincide con el valor almacenado en $Horario
                                $selected = ($row['NID_Horario'] == $Horario) ? 'selected' : '';
                                echo "<option value='" . $row['NID_Horario'] . "' $selected>" . $row['HorarioCompleto'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Botón para mostrar modal de confirmación -->
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#confirmacionModal">Actualizar Clase</button>
                    <!-- Enlace para cancelar -->
                    <a href="Clases.php" class="btn btn-secondary btn-block">Cancelar</a>
                    <!-- Campo oculto para indicar que se ha enviado el formulario -->
                    <input type="hidden" name="Actulizar" id="Actulizar">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmacionModal" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Seguro que deseas actualizar esta clase?
            </div>
            <div class="modal-footer">
                <!-- Llamar a la función actualizarClase al hacer clic en el botón -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="actualizarClase()">Actualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- Función para enviar el formulario -->
<script>
    function actualizarClase() {
        document.getElementById("Actulizar").value = "true";
        document.getElementById("actualizarForm").submit();
    }
</script>
<?php include('Includes/Footer.php'); ?>
