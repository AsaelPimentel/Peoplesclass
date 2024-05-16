<?php
session_start();
include('../Config/Conexion.php');
include('Includes/Header.php');
$conexion = ConexionBD::obtenerConexion();


// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tipo_reporte'])) {
        if ($_POST['tipo_reporte'] == "clase") {
            // Si se seleccionó "reporte asistencias de clase"
            if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']) && isset($_POST['clase'])) {
                // Procesar el rango de fechas y la clase seleccionada
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];
                $clase_seleccionada = $_POST['clase'];
                // Aquí deberías incluir la lógica para generar el reporte de asistencias por clase
                 // Generar la consulta SQL para obtener las asistencias de la clase en el rango de fechas
                 $query_asistencias = "SELECT * FROM tb_asistencias WHERE ID_Clase = '$clase_seleccionada' AND N_Fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                // Luego redirigir al usuario para descargar el reporte generado
            }
             else {
                echo "Por favor, complete el rango de fechas y seleccione una clase.";
            }
        } elseif ($_POST['tipo_reporte'] == "general") {
            // Si se seleccionó "reporte general"
            if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
                // Procesar el rango de fechas
                $fecha_inicio = $_POST['fecha_inicio'];
                $fecha_fin = $_POST['fecha_fin'];
                // Aquí deberías incluir la lógica para generar el reporte general
                // Luego redirigir al usuario para descargar el reporte generado
            } else {
                echo "Por favor, complete el rango de fechas.";
            }
        }
    }
}
?>

<div class="container p-4">
    <div class="container p-4">

        <div class="row">
            <div class="col-md-6">
                <div class="container text-center">
                    <form action="GenerarReporte.php" method="post">
                        <div class="form-group">
                            <label for="tipo_reporte">Tipo de Reporte:</label>
                            <select class="form-control" id="tipo_reporte" name="tipo_reporte">
                                <option value="0"> -- SELECCIONAR -- </option>
                                <option value="clase">Reporte Asistencias de Clases</option>
                                <option value="general">Reporte General</option>
                            </select>
                        </div>
                        <div class="form-group" id="rango_fecha_1" style="display:none;">
                            <label for="fecha_inicio_clase">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="fecha_inicio_clase" name="fecha_inicio">
                        </div>
                        <div class="form-group" id="rango_fecha_2" style="display:none;">
                            <label for="fecha_fin_clase">Fecha de Fin:</label>
                            <input type="date" class="form-control" id="fecha_fin_clase" name="fecha_fin">
                        </div>
                        <div class="form-group" id="select_clase" style="display:none;">
                            <label for="clase">Clase:</label>
                            <select class="form-control" id="clase" name="clase">
                                <!-- Aquí deberías llenar las opciones del select con las clases disponibles -->
                                <?php
                                $query_clases = "SELECT NID_Clase, N_Clase FROM cat_clases";
                                $resultado_clases = mysqli_query($conexion, $query_clases);
                                while ($filas = mysqli_fetch_assoc($resultado_clases)) {
                                    echo "<option value='" . $filas['N_Clase'] . "'>" . $filas['N_Clase'] . "</option>";
                                }
                                ?>
                                <!-- Puedes llenarlas dinámicamente desde la base de datos si es necesario -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>

<script>
    document.getElementById('tipo_reporte').addEventListener('change', function() {
        var tipoReporte = this.value;
        if (tipoReporte === 'clase') {
            document.getElementById('rango_fecha_1').style.display = 'block';
            document.getElementById('rango_fecha_2').style.display = 'block';
            document.getElementById('select_clase').style.display = 'block';
        } else if (tipoReporte === 'general') {
            document.getElementById('rango_fecha_1').style.display = 'block';
            document.getElementById('rango_fecha_2').style.display = 'block';
            document.getElementById('select_clase').style.display = 'none';
        } else {
            document.getElementById('rango_fecha_1').style.display = 'none';
            document.getElementById('rango_fecha_2').style.display = 'none';
            document.getElementById('select_clase').style.display = 'none';
        }
    });
</script>