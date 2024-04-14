<?php 
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
    include('../Config/Conexion.php');
    if (isset($_POST['Guardar'])) {
       $conexion = ConexionBD::obtenerConexion();
       $Empleado = $_POST['empleado'];

       $query = "INSERT INTO cat_entrenadores (ID_Empleado) VALUES ('$Empleado')";
       $resultado = mysqli_query($conexion, $query);
       if ($resultado) {
            session_start();
            $_SESSION['mensaje'] = 'Se registró correctamente';
            $_SESSION['tipomensaje'] = 'success';
            header('Location: Coach.php');
            exit();
       }
       else {
        die('Error: ' . mysqli_error($conexion));
       }
    }
?>