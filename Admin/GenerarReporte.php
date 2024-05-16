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
                // Generar la consulta SQL para obtener las asistencias de la clase en el rango de fechas
                $query_asistencias = "SELECT * FROM tb_asistencias WHERE ID_Clase = '$clase_seleccionada' AND N_Fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                // Ejecutar la consulta
                $resultado_asistencias = mysqli_query($conexion, $query_asistencias);
                // Mostrar el resultado en la tabla
                if (mysqli_num_rows($resultado_asistencias) > 0) {
                    echo '<div class="container">';
                    echo '<table class="table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID Asistencias</th>';
                    echo '<th>ID Clase</th>';
                    echo '<th>ID Socio</th>';
                    echo '<th>Fecha</th>';
                    echo '<th>Código</th>';
                    echo '<th>Asistió</th>';
                    echo '<th>Comentario</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($fila = mysqli_fetch_assoc($resultado_asistencias)) {
                        echo '<tr>';
                        echo '<td>' . $fila['NID_Asistencias'] . '</td>';
                        echo '<td>' . $fila['ID_Clase'] . '</td>';
                        echo '<td>' . $fila['ID_Socio'] . '</td>';
                        echo '<td>' . $fila['N_Fecha'] . '</td>';
                        echo '<td>' . $fila['N_Codigo'] . '</td>';
                        echo '<td>' . ($fila['ID_Asistio'] == 1 ? 'Sí' : 'No') . '</td>';
                        echo '<td>' . $fila['N_Comentario'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo "No se encontraron registros de asistencias para la clase seleccionada en el rango de fechas especificado.";
                }
            } else {
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
                        <!-- Resto del formulario -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>

<script>
    // Script JS para controlar la visibilidad de los campos del formulario
</script>
