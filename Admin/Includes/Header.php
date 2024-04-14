<!doctype html>
<html lang="en">

<head>
    <title>People's | </title>
    <link rel="icon" href="../Assets/Img/Logo.png" type="image/png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../Assets/css/style.css">

</head>

<body>
    <!-- Menu de navegacion-->
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-light demo">
            <a class="navbar-brand" href="Index.php" style="color:white;">
                <picture>
                    <source srcset="../Assets/Img/Logo.png" type="image/png">
                    <img src="../Assets/Img/Logo.png" alt="Logo de la empresa" style="width: 75px;">
                </picture>
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="Clases.php" style="color:white;">Clases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Coach.php" style="color:white;">Entrenadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Empleados.php" style="color:white;">Empleados</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">Asistencia</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="#">Registro de asistencia</a>
                            <a class="dropdown-item" href="#">Reportes</a>
                            <a class="dropdown-item" href="Socios.php">Socios</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="POST" action="Cerrar.php">
                    <span class="mr-3 text-primary">
                        <i class="fas fa-user mr-1"></i>
                        <?php echo $_SESSION['NombreUsuario']; ?>
                    </span>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </nav>
    </header>
    <script>
        // Cambiar dinámicamente el título de la página
        function cambiarTituloPagina(nuevoTitulo) {
            document.title = "People's | " + nuevoTitulo;
        }
    </script>