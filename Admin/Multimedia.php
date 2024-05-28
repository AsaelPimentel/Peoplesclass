<?php session_start();
if (!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
include('Includes/Header.php');
include('../Config/Conexion.php');
?>
<script>
    // Cambiar el título de la página a "Clases"
    cambiarTituloPagina("Videos");
</script>
<div class="container p-4">
    <h4>Subir video de rutinas para las clases</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="Clase">Seleccionar Clase</label>
                        <select name="Clase" id="Clase" class="form-control">
                            <option value="">Seleccinar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Recurso">Tipo de recurso</label>
                        <select name="Recurso" id="Recurso" class="form-control">
                            <option value="">Seleccinar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Seleccionar archivo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang"></label>
                        </div>
                    </div>
                    <button type="submit" id="Guardar" class="btn btn-success btn-block" name="Guardar">Subir Archivo</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Clase</th>
                                <th>Tipo</th>
                                <th>Recurso</th>
                                <th>Descrpcioon</th>
                                <th> Acciones </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Imprimir el contenido</td>
                                <td>Imprimir el contenido</td>
                                <td>Imprimir el contenido</td>
                                <td>Imprimir el contenido</td>
                                <td>Imprimir el contenido</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('Includes/Footer.php'); ?>