<?php 
session_start();
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 2) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: ../Public/index.html"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
    include('../Config/Conexion.php');
    if (isset($_POST)) {
        $conexion = ConexionBD::obtenerConexion();
        $usuario    = $_POST['usuario'];
        $password  = $_POST['password'] ;
        $genero     = $_POST['genero'] ;
        $nombre     = $_POST['nombre'] ;
        $apellidopa = $_POST['apeliido1'] ;
        $apellidoma = !empty($_POST['apellido2']) ? $_POST['apellido2'] : 'Null'; // Valor por defecto si está vacío
        $telefono   = !empty($_POST['telefono']) ? $_POST['telefono'] : '(777) 777 77 77'; // Valor por defecto si está vacío
        $clase      = $_POST['clase']; 
        $correo     = !empty($_POST['email']) ? $_POST['email'] : 'ejemplo@ejemplo.com'; // Valor por defecto si está vacío
        $estado     = 3 ;

        $query = "INSERT INTO tb_socios (N_Usuario, N_Password, N_Genero, N_Nombre, N_ApellidoPa, N_ApellidoMa, N_Telefono, N_Correo, N_Clases, ID_Estado) 
        VALUES ('$usuario', '$password', '$genero', '$nombre', '$apellidopa', '$apellidoma', '$telefono', '$correo', '$clase', '$estado')";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            session_start();
            $_SESSION['mensaje'] = 'Se registró correctamente';
            $_SESSION['tipomensaje'] = 'success';
            header('Location: Socios.php');
            exit();
       }
       else {
        die('Error: ' . mysqli_error($conexion));
       }
    }
?>