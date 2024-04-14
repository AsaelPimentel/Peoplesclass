<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');
//genero la conexion para evitar rehacerla cada que la necesite 
$conexion = ConexionBD::obtenerConexion();
// Definir el número de registros por página
$registros_por_pagina = 10;
// Calcular el número total de páginas
$query_total_registros = "SELECT COUNT(*) as total_registros FROM cat_horarios";
$resultado_total_registros = mysqli_query($conexion, $query_total_registros);
$total_registros = mysqli_fetch_assoc($resultado_total_registros)['total_registros'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_actual - 1) * $registros_por_pagina;
// Obtener los registros para la página actual
$consulta_horarios = "SELECT * FROM cat_horarios";
$resultado_horarios = mysqli_query($conexion, $consulta_horarios);
?>
<script>
    // Cambiar el título de la página a "Clases"
    cambiarTituloPagina("Horarios");
</script>
<!-- botones de navegacion -->
<div class="container p-4">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-auto">
                <div class="fixed-left">
                    <a href="Clases.php" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Volver"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atras</a>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="fixed-left">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoHorario" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo horario"><i class="fas fa-plus"></i> Nuevo Horario</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Insercion  -->
<div class="modal fade" id="modalNuevoHorario" tabindex="-1" aria-labelledby="modalNuevoEntrenadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoEntrenadorLabel">Agregar Horario</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <!-- Aquí coloca el formulario para agregar un nuevo entrenador -->
                <form action="CreateHorario.php" method="POST">
                    <div class="form-group">
                        <label for="dia">Dia</label>
                        <select class="form-control" id="dia" name="dia" required>
                            <option value="">-- Seleccionar --</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="horaInicio">Hora de inicio</label>
                        <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
                    </div>
                    <div class="form-group">
                        <label for="horaFin">Hora de fin</label>
                        <input type="time" class="form-control" id="horaFin" name="horaFin" required>
                    </div>
                    <div class="form-group">
                        <label for="turno">Turno</label>
                        <select class="form-control" id="turno" name="turno" required>
                            <option value="">-- Seleccionar --</option>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <button type="submit" id="Guardar" class="btn btn-success btn-block" name="Guardar">Agregar Horario</button>
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
<!-- apartado de la tabla -->
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
                    <th>Dia</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Turno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($filas = mysqli_fetch_assoc($resultado_horarios)) {
                    // Mostrar los datos de cada fila de la tabla
                    echo "<tr class='table-success'>";
                    echo "<td>{$filas['NID_Horario']}</td>";
                    echo "<td>{$filas['N_Dia']}</td>";
                    echo "<td>{$filas['N_HoraInicio']}</td>";
                    echo "<td>{$filas['N_HoraFin']}</td>";
                    echo "<td>{$filas['N_Turno']}</td>";
                    echo "<td>";
                    echo "<a href='UpdateHorario.php?id={$filas['NID_Horario']}' class='btn btn-warning' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-marker'></i></a>";
                    echo "<a href='#' class='btn btn-danger btnEliminar' data-toggle='tooltip' data-placement='top' title='Eliminar' data-id='{$filas['NID_Horario']}'><i class='fas fa-trash-alt'></i></a>";
                    echo "</td>";
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
<!-- modal de eliminacion -->
<div class="modal fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta clase?
            </div>
            <div class="modal-footer">
                <a id="btnConfirmarEliminar" class="btn btn-danger">Eliminar</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include('Includes/Footer.php'); ?>
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
        // Función para mostrar el modal de confirmación para eliminar
        $('.btnEliminar').click(function() {
            var idClase = $(this).data('id');
            $('#btnConfirmarEliminar').attr('href', 'DeleteHorario.php?id=' + idClase);
            $('#confirmarEliminar').modal('show');
        });
    });
</script>