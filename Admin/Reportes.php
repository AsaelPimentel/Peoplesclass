<?php 
session_start();
include('../Config/Conexion.php');
include('Includes/Header.php');
$conexion = ConexionBD::obtenerConexion();
$sql = "SELECT * FROM `vw_clases` ORDER BY `Nombre_Entrenador` ASC";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear una tabla HTML para mostrar los datos
    echo "<table><tr><th>Clase</th><th>Dia</th><th>Entrenador</th></tr>";
    // Output de los datos de cada fila
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr><td>" . $fila["N_Clase"]. "</td><td>" . $fila["N_Dia"]. "</td><td>" . $fila["Nombre_Entrenador"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados";
}
?>


<?php include('Includes/Footer.php'); ?>