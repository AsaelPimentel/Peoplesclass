<?php
session_start(); // Inicia la sesión

// Eliminar la variable de sesión específica
unset($_SESSION['Usuario']); // Cambia 'Usuario' por el nombre de la variable de sesión que deseas eliminar

// Redirigir a la página de inicio de sesión
header("Location: ../index.html");
exit;
?>
