<?php 
session_start();

if (!isset($_SESSION['Usuario'])) {
    header('location: ../index.html');
    exit();
}
include ('Includes/Header.php');
include ('../Config/Conexion.php');
?>

<?php include ('Includes/Footer.php'); ?>