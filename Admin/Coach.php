<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');
$conexion = ConexionBD::obtenerConexion();
$consulta_coachs = "SELECT * FROM vw_entrenadores";
$resultado_coachs = mysqli_query($conexion, $consulta_coachs);
// Definir el número de registros por página
$registros_por_pagina = 10;
// Calcular el número total de páginas
$query_total_registros = "SELECT COUNT(*) as total_registros FROM vw_entrenadores";
$resultado_total_registros = mysqli_query($conexion, $query_total_registros);
$total_registros = mysqli_fetch_assoc($resultado_total_registros)['total_registros'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_actual - 1) * $registros_por_pagina;
?>
<script>
    // Cambiar el título de la página a "Clases"
    cambiarTituloPagina("Entrenadores");
</script>
<!-- Botones de arribba de la tabla para dar de alta una clase y para ir al horarios -->
<div class="caontainer p-4">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-auto">
                <div class="fixed-left">
                </div>
            </div>
            <div class="col-md-auto">
                <div class="fixed-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoCoach" data-toggle="tooltip" data-placement="top" title="Agregar Nueva clase">
                        <i class="fas fa-plus"></i> Agregar Coach
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal de insercion -->
<div class="modal fade" id="modalNuevoCoach" tabindex="-1" aria-labelledby="modalNuevoEntrenadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoEntrenadorLabel">Agregar Coach</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <!-- Aquí coloca el formulario para agregar un nuevo entrenador -->
                <form action="CreateCoach.php" method="POST">
                    <!-- formulario pendiente -->
                    <div class="form-group">
                        <label for="empleado">Empleado</label>
                        <select class="form-control" id="empleado" name="empleado" required>
                            <option value="">-- Seleccionar --</option>
                            <?php
                            // Query para obtener los horarios disponibles
                            $query_empleados = "SELECT N_Empleado, CONCAT(N_Nombre, ' ', N_ApellidoPa, ' ', N_ApellidoMa ) AS NombreEmpleado FROM tb_empleados WHERE ID_Rol = 3";
                            $result_empleados = mysqli_query($conexion, $query_empleados);
                            // Iterar sobre los resultados y generar opciones del menú desplegable
                            while ($row = mysqli_fetch_assoc($result_empleados)) {
                                echo "<option value='" . $row['N_Empleado'] . "'>" . $row['NombreEmpleado'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row justify-content-end">
                        <div class="container">
                            <button type="submit" class="btn btn-success btn-block" name="Guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Agregar Coach</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- codigo para los mensajes de cuadno se haga una operacion con la tabla  -->
<div class="cotainer ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipomensaje']; ?> alert-dismissible fade show mt-2" role="alert">
                    <?= $_SESSION['mensaje']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php unset($_SESSION['mensaje']);
            }; ?>
        </div>
    </div>
</div>
<!-- apartado par ala tabla y demas cosas -->
<div class="container p-4">
        <!-- Mensaje informativo -->
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-info alert-dismissible fade show mt-2" role="alert">
                Por integridad de la información, no es posible editar o eliminar registros de esta tabla. Solamente se pueden agregar nuevas asignaciones de clases a los entrenadores.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        </div>
    </div>

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
                        <th>Nombre</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($filas = mysqli_fetch_assoc($resultado_coachs)) {
                        // Mostrar los datos de cada fila de la tabla
                        echo "<tr class='table-success'>";
                        echo "<td>{$filas['NID_Entrenador']}</td>";
                        echo "<td>{$filas['Nombre_Empleado']}</td>";
                        echo "<td>{$filas['Apellido_Paterno']}</td>";
                        echo "<td>{$filas['Apellido_Materno']}</td>";
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

    <?php include('Includes/Footer.php'); ?>
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