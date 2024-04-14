<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');

// Genero la conexion para evitar rehacerla cada que la necesite 
$conexion = ConexionBD::obtenerConexion();

// Definir el número de registros por página
$registros_por_pagina = 10;

// Consulta para obtener el total de registros
$query_total_registros = "SELECT COUNT(*) as total_registros FROM vw_socios";
$resultado_total_registros = mysqli_query($conexion, $query_total_registros);
$total_registros = mysqli_fetch_assoc($resultado_total_registros)['total_registros'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consulta para obtener los datos de los socios
$consulta_Socios = "SELECT * FROM `vw_socios` ORDER BY `vw_socios`.`N_Socio` ASC";
$resultado_Socios = mysqli_query($conexion, $consulta_Socios);

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_actual - 1) * $registros_por_pagina;

?>
<script>
    // Cambiar el título de la página a "Clases"
    cambiarTituloPagina("Socios");
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoSocio" data-toggle="tooltip" data-placement="top" title="Agregar Nuevo empleado">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>Agregar Socio
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal de insercion -->
<div class="modal fade" id="modalNuevoSocio" tabindex="-1" aria-labelledby="modalNuevoSocioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevoSocioLabel">Agregar Socio</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <!-- Aquí coloca el formulario para agregar un nuevo entrenador -->
                <form action="CreateSocio.php" method="POST">
                    <!-- formulario pendiente -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario" form="form-label">Usuario</label>
                                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingrese un usuario" required>
                                </div>
                                <div class="form-group">
                                    <label for="genero" class="form-label">Genero</label>
                                    <select class="form-control" name="genero" id="genero">
                                        <?php
                                        $query_generos = "SELECT * FROM cat_generos";
                                        $resultado_generos = mysqli_query($conexion, $query_generos);
                                        while ($filas = mysqli_fetch_assoc($resultado_generos)) {
                                            echo "<option value='" . $filas['NID_Genero'] . "'>" . $filas['N_Genero'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="apellido2">Apellido materno</label>
                                    <input type="text" name="apellido2" id="apellido2" class="form-control" placeholder="Ingrese su apellido">
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electronico</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Opcional *</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese una contraseña" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre (s)</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese su nombre">
                                </div>
                                <div class="form-group">
                                    <label for="apeliido1">Apellido paterno</label>
                                    <input type="text" name="apeliido1" id="apeliido1" class="form-control" placeholder="Ingrese apellido">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="(777) 77 77 77" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Opcional *</small>
                                </div>
                                <div class="form-group">
                                    <label for="clase" class="form-label">Clase</label>
                                    <select class="form-control" name="clase" id="clase">
                                        <option value="">-- selecionar --</option>
                                        <?php
                                        $query_clases = "SELECT NID_Clase, N_Clase FROM cat_clases";
                                        $resultado_clases = mysqli_query($conexion, $query_clases);
                                        while ($filas = mysqli_fetch_assoc($resultado_clases)) {
                                            echo "<option value='" . $filas['NID_Clase'] . "'>" . $filas['N_Clase'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                        <th>Usuario</th>
                        <th>Genero</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($filas = mysqli_fetch_assoc($resultado_Socios)) {
                        // Mostrar los datos de cada fila de la tabla
                        echo "<tr class='table-success'>";
                        echo "<td>{$filas['N_Socio']}</td>";
                        echo "<td>{$filas['N_Usuario']}</td>";
                        echo "<td>{$filas['N_Genero']}</td>";
                        echo "<td>{$filas['N_Nombre']}</td>";
                        echo "<td>{$filas['N_ApellidoPa']}</td>";
                        echo "<td>{$filas['N_ApellidoMa']}</td>";
                        echo "<td>{$filas['N_Telefono']}</td>";
                        echo "<td>{$filas['N_Correo']}</td>";
                        echo "<td>{$filas['N_Estado']}</td>";
                        echo "<td>";
                        echo "<a href='UpdateSocio.php?id={$filas['N_Socio']}' class='btn btn-warning' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-marker'></i></a>";
                        echo "<a href='#' class='btn btn-danger btnEliminar' data-toggle='tooltip' data-placement='top' title='Eliminar' data-id='{$filas['N_Socio']}'><i class='fas fa-trash-alt'></i></a>";
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
            $('#btnConfirmarEliminar').attr('href', 'DeleteSocio.php?id=' + idClase);
            $('#confirmarEliminar').modal('show');
        });
    });
</script>