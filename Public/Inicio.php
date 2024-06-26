<?php 
session_start();// Verifica si existen las variables de sesión NombreUsuario y RolUsuario
if(!isset($_SESSION['NombreUsuario']) || !isset($_SESSION['RolUsuario']) || $_SESSION['RolUsuario'] != 3) {
    // Si alguna de las variables de sesión no existe o el RolUsuario no es igual a 2, redirecciona al login
    header("Location: login.php"); // Cambia "login.php" por la página de login de tu aplicación
    exit(); // Termina la ejecución del script después de redireccionar
}
 
include('../Config/Conexion.php');
include('../Config/Traduccion.php');

// Establecer la zona horaria a México, Baja California
date_default_timezone_set('America/Tijuana');
$dia_actual = TraductorDia::traducir(date('l'));
$conexion = ConexionBD::obtenerConexion();

// Obtener el nombre del usuario desde la sesión
$nombreEmpleado = $_SESSION['NombreUsuario'];
?>
<?php include('Includes/Header.php'); ?>
<script>
    // Cambiar el título de la página a "Inicio"
    cambiarTituloPagina("Inicio");
</script>

<div class='container p-4'>
  <div class='jumbotron text-white text-center shadow-lg p-3 mb-5 bg-body-tertiary rounded' style="background-color: #559139;">
    <h1 class='display-6'>¡Hola de nuevo, <?php echo $nombreEmpleado; ?>!</h1>
    <hr class='my-3 bg-light'>
  </div>
</div>

<div class="container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title text-center"><i class="fas fa-calendar-alt mr-2"></i> Clases del entrenador <?php echo $nombreEmpleado; ?>:</h5>
      <hr class='my-3 bg-light'>
      <div class="d-flex flex-row flex-wrap justify-content-center align-items-start">
        <?php 
        // Consulta para obtener las clases relacionadas con el usuario para el día actual
        $query_clases_usuario = "SELECT * FROM vw_clases WHERE Nombre_Entrenador = '$nombreEmpleado' AND N_Dia = '$dia_actual'";
        $resultado_clases_usuario = mysqli_query($conexion, $query_clases_usuario);
        if (!$resultado_clases_usuario) {
            die("Error al obtener las clases del usuario: " . mysqli_error($conexion));
        }
        
        // Verificar si hay clases para el usuario y el día actual
        if (mysqli_num_rows($resultado_clases_usuario) > 0) {
            while ($fila_clase = mysqli_fetch_assoc($resultado_clases_usuario)) { ?>
              <div class="card text-white bg-secondary m-2" style="max-width: 18rem;">
                <div class="card-header">
                  <?php
                  // Determinar el icono según el tipo de clase
                  $icono = '';
                  switch ($fila_clase['N_Clase']) {
                    case 'Spinning':
                      $icono = '<i class="fas fa-biking"></i>';
                      break;
                    case 'Zumba':
                      $icono = '<i class="fas fa-drum"></i>';
                      break;
                    case 'Ejercicio Funcional':
                      $icono = '<i class="fas fa-dumbbell"></i>';
                      break;
                    case 'Fit Combat':
                      $icono = '<i class="fas fa-fist-raised"></i>';
                      break;
                    case 'Ejercicio de Rebote':
                      $icono = '<i class="fas fa-bounce"></i>';
                      break;
                    case 'Yoga':
                      $icono = '<i class="fas fa-om"></i>';
                      break;
                    case 'Boot Combat':
                      $icono = '<i class="fas fa-boot"></i>';
                      break;
                    case 'Steel Combat':
                      $icono = '<i class="fas fa-shield-alt"></i>';
                      break;
                    case 'Steel Jump':
                      $icono = '<i class="fas fa-tachometer-alt"></i>';
                      break;
                    default:
                      $icono = '';
                      break;
                  }
                  echo $icono . ' ' . $fila_clase['N_Clase'];
                  ?>
                </div>
                <div class="card-body">
                  <p class="card-text">Día: <?php echo $fila_clase['N_Dia']; ?></p>
                  <p class="card-text">Horario: <?php echo $fila_clase['N_HoraInicio'] . " - " . $fila_clase['N_HoraFin']; ?></p>
                </div>
              </div>
            <?php } 
        } else {
            // Si no hay clases, mostrar un mensaje
            echo "<p class='text-center'>No tienes clases para el día de hoy.</p>";
        }
        ?>
      </div>
    </div>
  </div>
</div>


<?php include('Includes/Footer.php'); ?>
