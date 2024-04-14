<?php
include 'Config/Conexion.php';
session_start();

$Usuario = $_POST['socio'];
$Pass = $_POST['pass'];

$conexion = ConexionBD::obtenerConexion();
$consulta = "SELECT * FROM Vw_Socios WHERE N_Usuario ='$Usuario' AND N_Password='$Pass'";
$resultado = mysqli_query($conexion, $consulta);
if ($filas = mysqli_fetch_array($resultado)) {
    $estado = $filas['ID_Estado '];
    if ($estado == 1 || $estado == 3) {
        header("Location: index.html?error=2");
    } else {
        $_SESSION['Usuario'] = $filas['N_Nombre'];
        header("Location: Client/Index.php");
    }
} else {
    header("Location: index.html?error=1");
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>
