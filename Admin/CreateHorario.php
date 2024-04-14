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
        $dia        = $_POST['dia'];
        $horainicio = $_POST['horaInicio'];
        $horafin    = $_POST['horaFin'];
        $turno      = $_POST['turno'];

        $query = "INSERT INTO cat_horarios(N_Dia,N_HoraInicio,N_HoraFin,N_Turno) VALUES ('$dia','$horainicio','$horafin','$turno')";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            session_start();
            $_SESSION['mensaje'] = 'Se registró correctamente';
            $_SESSION['tipomensaje'] = 'success';
            header('Location: Horarios.php');
            exit();
       }
       else {
        die('Error: ' . mysqli_error($conexion));
       }
    }
?>