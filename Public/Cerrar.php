<?php
// Iniciar sesión
session_start();
// Verificar si existe una sesión y si el rol del usuario es 2 (Entrenador)
if (isset($_SESSION['NombreUsuario']) && $_SESSION['RolUsuario'] == 3) {
    // Destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio de sesión o a cualquier otra página
    header("Location: index.html");
    exit();
} else {
    // Si el usuario no es administrador, simplemente redirige a la página de inicio
    header("Location: index.html");
    exit();
}
?>
