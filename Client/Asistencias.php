<?php 
session_start();
if (!isset($_SESSION['Socio'])) {
    header('location: ../index.html');
    exit();
}
if (!isset($_SESSION['Usuario'])) {
    header('location: ../index.html');
    exit();
}
include ('Includes/Header.php');
include ('../Config/Conexion.php');

$conexion = ConexionBD::obtenerConexion();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos ingresados por el usuario
    $codigo_ingresado = $_POST['codigo'];
    $comentario = $_POST['comentario'];

    // Consulta para verificar si el código existe y aún no ha expirado
    $query = "SELECT * FROM Cat_Codigos WHERE N_Codigo = '$codigo_ingresado' AND N_FechaExpiracion > NOW()";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        // Si el código coincide y aún no ha expirado, se inserta un registro en la tabla NID_Asistencias
        $row = mysqli_fetch_assoc($resultado);
        $id_clase = $row['ID_Clase'];
        $id_socio = $_SESSION['Socio']['N_Socio']; // Corrige aquí el nombre de la columna de ID_Socio según tu tabla de Vw_Socios
        $fecha_actual = date("Y-m-d H:i:s");

        $insert_query = "INSERT INTO tb_asistencias (ID_Clase, ID_Socio, N_Fecha, N_Codigo, ID_Asistio, N_Comentario) 
                         VALUES ('$id_clase', '$id_socio', '$fecha_actual', '$codigo_ingresado', '1' , '$comentario')";
        mysqli_query($conexion, $insert_query);

        echo "<script>alert('Asistencia registrada correctamente.');</script>";
    } else {
        echo "<script>alert('El código ingresado no es válido o ha expirado.');</script>";
    }
}
?>
<script>
    // Cambia el título de la página a "Asistencia"
    cambiarTituloPagina("Asistencia");
</script>
<div class="container p-4 text-center">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h4>Registro de asistencias</h4>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                    <label for="codigo">Ingrese el código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                </div>
                <div class="form-group">
                    <label for="comentario">Comentario:</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
            </form>
        </div>
    </div>
</div>
<?php include ('Includes/Footer.php'); ?>
