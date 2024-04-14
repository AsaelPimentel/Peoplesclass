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
        $passoword  = $_POST['password'] ;
        $rol        = $_POST['cargo'] ;
        $genero     = $_POST['genero'] ;
        $nombre     = $_POST['nombre'] ;
        $apellidopa = $_POST['apeliido1'] ;
        $apellidoma = !empty($_POST['apellido2']) ? $_POST['apellido2'] : 'Null'; // Valor por defecto si está vacío
        $telefono   = !empty($_POST['telefono']) ? $_POST['telefono'] : '(777) 777 77 77'; // Valor por defecto si está vacío
        $correo     = !empty($_POST['email']) ? $_POST['email'] : 'ejemplo@ejemplo.com'; // Valor por defecto si está vacío
        $estado     = 3 ;

        $query = "INSERT INTO tb_empleados (N_Usuario, N_Password, ID_Rol, ID_Genero, N_Nombre, N_ApellidoPa, N_ApellidoMa, N_Telefono, N_Correo, ID_Estado) 
        VALUES ('$usuario', '$password', '$rol', '$genero', '$nombre', '$apellidopa', '$apellidoma', '$telefono', '$correo', '$estado')";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado) {
            session_start();
            $_SESSION['mensaje'] = 'Se registró correctamente';
            $_SESSION['tipomensaje'] = 'success';
            header('Location: Empleados.php');
            exit();
       }
       else {
        die('Error: ' . mysqli_error($conexion));
       }
    }
?>