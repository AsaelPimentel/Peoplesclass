<?php
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('../COnfig/Conexion.php');
$conexion = ConexionBD::obtenerConexion();

// Si se envió el formulario
if (isset($_POST['Actualizar'])) {
    // Obtener el ID del empleado a actualizar
    $id = $_GET['id'];
    // Obtener los valores del formulario
    $Usuario = $_POST['usuario'];
    $Contra = $_POST['password'];
    $Nombre = $_POST['nombre'];
    $Apellido1 = $_POST['apeliido1'];
    $Apellido2 = $_POST['apellido2'];
    $Genero = $_POST['genero'];
    $Telefono = $_POST['telefono'];
    $Correo = $_POST['email'];
    $clase = $_POST['clase'];
    $Estatus = $_POST['estatus'];

    // Actualizar el registro en la base de datos
    $query = "UPDATE tb_Socios SET N_Usuario = '$Usuario', N_Password = '$Contra', N_Nombre = '$Nombre', N_ApellidoPa = '$Apellido1', N_ApellidoMa = '$Apellido2', N_Genero = '$Genero', N_Telefono = '$Telefono', N_Clases = '$clase', N_Correo = '$Correo', ID_Estado = '$Estatus' WHERE N_Socio = '$id'";
    mysqli_query($conexion, $query);

    // Establecer mensaje de éxito
    $_SESSION['mensaje'] = 'El registro se actualizó correctamente.';
    $_SESSION['TipoMensaje'] = 'warning';

    // Redirigir a la página de Empleados
    header('Location: Socios.php');
    exit(); // Terminar la ejecución del script después de redirigir
}

// Obtener el ID del empleado de la URL y cargar los datos del empleado correspondiente
if (isset($_GET['id'])) {
    $Id = $_GET['id'];
    $Query = "SELECT * FROM tb_Socios WHERE N_Socio = '$Id'";
    $Resultado = mysqli_query($conexion, $Query);
    if (mysqli_num_rows($Resultado) == 1) {
        $row = mysqli_fetch_array($Resultado);
        $Usuario = $row['N_Usuario'];
        $Contra = $row['N_Password'];
        $Genero = $row['N_Genero'];
        $clase = $row['N_Clases'];
        $Nombre = $row['N_Nombre'];
        $Apellido1 = $row['N_ApellidoPa'];
        $Apellido2 = $row['N_ApellidoMa'];
        $Telefono = $row['N_Telefono'];
        $Correo = $row['N_Correo'];
        $Estatus = $row['ID_Estado'];
    }
}
?>
<?php include('Includes/Header.php'); ?>

<script>
    // Cambiar el título de la página a "Editar Empleado"
    cambiarTituloPagina("Editar Empleado");
</script>
<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form id="actualizarForm" action="UpdateSocio.php?id=<?php echo $_GET['id']; ?>" method="POST">
                <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario" form="form-label">Usuario</label>
                                    <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $Usuario ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="clase" class="form-label">Clase</label>
                                    <select class="form-control" name="clase" id="clase" required>
                                        <?php
                                        $query_roles = "SELECT NID_Clase,N_Clase FROM cat_clases";
                                        $resultado_roles = mysqli_query($conexion, $query_roles);
                                        while ($row = mysqli_fetch_assoc($resultado_roles)) {
                                            $selected = ($row['N_Clase'] == $clase) ? 'selected' : '';
                                            echo "<option value='" . $row['N_Clase'] . "' $selected>" . $row['N_Clase'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre (s)</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $Nombre ?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellido2">Apellido materno</label>
                                    <input type="text" name="apellido2" id="apellido2" class="form-control" value="<?php echo $Apellido2 ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electronico</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $Correo ?>" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Opcional *</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control" value="<?php echo $Contra ?>">
                                </div>
                                <div class="form-group">
                                    <label for="genero" class="form-label">Genero</label>
                                    <select class="form-control" name="genero" id="genero">
                                        <?php
                                        $query_generos = "SELECT * FROM cat_generos";
                                        $resultado_generos = mysqli_query($conexion, $query_generos);
                                        while ($filas = mysqli_fetch_assoc($resultado_generos)) {
                                            $selected = ($filas['NID_Genero'] == $Genero) ? 'selected' : '';
                                            echo "<option value='" . $filas['NID_Genero'] . "' $selected>" . $filas['N_Genero'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="apeliido1">Apellido paterno</label>
                                    <input type="text" name="apeliido1" id="apeliido1" class="form-control" value="<?php echo $Apellido1 ?>">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $Telefono ?>">
                                </div>
                                <div class="form-group">
                                    <label for="estatus" class="form-label">Estatus</label>
                                    <select class="form-control" name="estatus" id="estatus">
                                        <?php
                                        $query_estados = "SELECT * FROM cat_estados";
                                        $resultado_estados = mysqli_query($conexion, $query_estados);
                                        while ($filas = mysqli_fetch_assoc($resultado_estados)) {
                                            $selected = ($filas['NID_Estado'] == $Estatus) ? 'selected' : '';
                                            echo "<option value='" . $filas['NID_Estado'] . "' $selected>" . $filas['N_Estado'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#confirmacionModal">Actualizar</button>
                    <a href="Socios.php" class="btn btn-secondary btn-block">Cancelar</a>
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
                ¿Seguro que deseas actualizar este empleado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="actualizarEmpleado()">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function actualizarEmpleado() {
        document.getElementById("Actualizar").value = "true";
        document.getElementById("actualizarForm").submit();
    }
</script>

<?php include('Includes/Footer.php'); ?>