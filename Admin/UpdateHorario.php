<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('../Config/Conexion.php');
$conexion = ConexionBD::obtenerConexion();


// Si se envió el formulario
if (isset($_POST['Actualizar'])) {
    // Obtener el ID del horario a actualizar
    $id = $_GET['id'];
    // Obtener los valores del formulario
    $Dia = $_POST['dia'];
    $HoraInicio = $_POST['horaInicio'];
    $HoraFin = $_POST['horaFin'];
    $Turno = $_POST['turno'];

    // Actualizar el registro en la base de datos
    $query = "UPDATE Cat_Horarios SET N_Dia = '$Dia', N_HoraInicio = '$HoraInicio', N_HoraFin = '$HoraFin', N_Turno = '$Turno' WHERE NID_Horario = '$id'";
    mysqli_query($conexion, $query);

    // Establecer mensaje de éxito
    $_SESSION['mensaje'] = 'El registro se actualizó correctamente.';
    $_SESSION['tipomensaje'] = 'warning';

    // Redirigir a la página de horarios
    header('Location: Horarios.php');
    exit(); // Terminar la ejecución del script después de redirigir
}

// Obtener el ID del horario de la URL y cargar los datos del horario correspondiente
if (isset($_GET['id'])) {
    $Id = $_GET['id'];
    $Query = "SELECT * FROM Cat_Horarios WHERE NID_Horario = '$Id'";
    $Resultado = mysqli_query($conexion, $Query);
    if (mysqli_num_rows($Resultado) == 1) {
        $row = mysqli_fetch_array($Resultado);
        $Dia = $row['N_Dia'];
        $HoraInicio = $row['N_HoraInicio'];
        $HoraFin = $row['N_HoraFin'];
        $Turno = $row['N_Turno'];
    }
}
?>

<?php include('Includes/Header.php'); ?>

<script>
    // Cambiar el título de la página a "Editar Horario"
    cambiarTituloPagina("Editar Horario");
</script>

<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form id="actualizarForm" action="UpdateHorario.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <label for="nombre">Dia</label>
                        <select class="form-control" id="dia" name="dia" required>
                            <?php
                            $dias_semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                            foreach ($dias_semana as $dia_semana) {
                                // Compara cada opción con el valor del campo "Día" de la base de datos
                                if ($dia_semana == $Dia) {
                                    echo "<option value='$dia_semana' selected>$dia_semana</option>";
                                } else {
                                    echo "<option value='$dia_semana'>$dia_semana</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horaInicio">Hora de inicio</label>
                        <input type="time" class="form-control" id="horaInicio" name="horaInicio" value="<?php echo $HoraInicio; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="horaFin">Hora de fin</label>
                        <input type="time" class="form-control" id="horaFin" name="horaFin" value="<?php echo $HoraFin; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="turno">Turno</label>
                        <select class="form-control" id="turno" name="turno" required>
                            <?php
                            $turnos = array("AM", "PM");
                            foreach ($turnos as $turno_option) {
                                // Compara cada opción con el valor del campo "Turno" de la base de datos
                                if ($turno_option == $Turno) {
                                    echo "<option value='$turno_option' selected>$turno_option</option>";
                                } else {
                                    echo "<option value='$turno_option'>$turno_option</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#confirmacionModal">Actualizar</button>
                    <a href="Horarios.php" class="btn btn-secondary btn-block">Cancelar</a>
                    <input type="hidden" name="Actualizar" id="Actualizar">
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
                ¿Seguro que deseas actualizar este Horario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="actualizarHorario()">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function actualizarHorario() {
        document.getElementById("Actualizar").value = "true";
        document.getElementById("actualizarForm").submit();
    }
</script>

<?php include('Includes/Footer.php'); ?>
