<?php
session_start();

if (!isset($_SESSION['Usuario'])) {
    header('location: ../index.html');
    exit();
}
include ('Includes/Header.php');
include ('../Config/Conexion.php');
// Obtener la conexion de la clase ConexionDB
$conexion = ConexionBD::obtenerConexion();
// Obtener el nombre del usuario asociado
$nombreUsuario = $_SESSION['Usuario'];
// Consulta para obtener el nombre del entrenador asociado al usuario
$query_nombre_entrenador = "SELECT N_Nombre FROM vw_clases_socios WHERE N_Nombre = '$nombreUsuario'";
$resultado_nombre_entrenador = mysqli_query($conexion, $query_nombre_entrenador);
$nombreEntrenador = mysqli_fetch_assoc($resultado_nombre_entrenador)['N_Nombre'];
// Definir el número de registros por página
$registros_por_pagina = 10;

// Calcular el número total de registros para la consulta específica del usuario
$query_total_registros = "SELECT COUNT(*) as total_registros FROM vw_clases_socios WHERE N_Nombre = '$nombreEntrenador'";
$resultado_total_registros = mysqli_query($conexion, $query_total_registros);
$total_registros = mysqli_fetch_assoc($resultado_total_registros)['total_registros'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener los registros para la página actual asociados al usuario
$query_registros = "SELECT * FROM vw_clases_socios WHERE N_Nombre = '$nombreEntrenador' LIMIT $inicio, $registros_por_pagina";
$resultado_registros = mysqli_query($conexion, $query_registros);
?>
<script>
    // Cambiar el título de la página a "Inicio"
    cambiarTituloPagina("Mis clases");
</script>
<!-- apartado par ala tabla y demas cosas -->
<div class="container p-4">
    <!-- codigo para la busqueda  -->
    <div class="row">
        <div class="col-md-4 offset-md-8"> <!-- Cambio aquí: 8 columnas para la tabla, 4 columnas para el campo de búsqueda -->
            <div class="input-group">
                <input type="text" class="form-control" id="busqueda" placeholder="Buscar">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i> <!-- Icono de búsqueda -->
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- codigo para la tabla -->
    <div class="row justify-content-center">
        <table id="miTabla" class="table table-sm table-striped table-hover table-bordered text-center">
            <thead class="thead-dark text-white">
                <tr>
                <th>#</th>
                    <th>Nombre de clase</th>
                    <th>Día</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Turno</th>
                    <th>Entrenador</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ($fila = mysqli_fetch_assoc($resultado_registros)) {
                    echo "<tr>";
                    echo "<td>{$fila['NID_Clase']}</td>";
                    echo "<td>{$fila['N_Clase']}</td>";
                    echo "<td>{$fila['N_Dia']}</td>";
                    echo "<td>{$fila['N_HoraInicio']}</td>";
                    echo "<td>{$fila['N_HoraFin']}</td>";
                    echo "<td>{$fila['N_Turno']}</td>";
                    echo "<td>{$fila['N_Nombre']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- navegacion -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center bg-success text-white">
                <?php
                // Mostrar enlaces de páginas
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo "<li class='page-item'><a class='page-link bg-success text-white' href='Clases.php?pagina={$i}'>{$i}</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<?php include('Includes/Footer.php') ?>
<!-- script adicional -->
<script>
    $(document).ready(function() {
        // Función para filtrar la tabla
        $('#busqueda').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>