-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2024 a las 00:38:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gymclass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_asistencia`
--

CREATE TABLE `cat_asistencia` (
  `NID_Asistio` int(11) NOT NULL COMMENT 'identifiacion de y asociacion de si asitio o no el socio',
  `N_Asistio` varchar(50) NOT NULL COMMENT 'dato texto de la asitencia ej si asistio o no asistio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de catoalogo de asistencias ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_clases`
--

CREATE TABLE `cat_clases` (
  `NID_Clase` int(11) NOT NULL,
  `N_Clase` varchar(100) NOT NULL COMMENT 'Nombre de la clase',
  `ID_Horario` int(11) NOT NULL,
  `ID_Entrenador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_clases`
--

INSERT INTO `cat_clases` (`NID_Clase`, `N_Clase`, `ID_Horario`, `ID_Entrenador`) VALUES
(1, '-- Seleccionar --', 1, 0),
(2, 'Spinning', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_codigos`
--

CREATE TABLE `cat_codigos` (
  `NID_Codigos` int(11) NOT NULL COMMENT 'idenitficador de codigos para hcer un historial de codigos',
  `N_Codigo` varchar(25) NOT NULL COMMENT 'Codigo en si este se alimetara de una fucnion echa en el sistema se utilizara para comparar con el que ingrese el usuario',
  `N_FechaGeneracion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de inicio de validez del codigo empezara dede que se guarda',
  `N_FechaExpiracion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fechad onde dejara de ser valido el codigo',
  `ID_Clase` int(11) NOT NULL COMMENT 'Asociar el codigo a una clase para tener un mejor control'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla de codigos para un mejor control de los mismos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_entrenadores`
--

CREATE TABLE `cat_entrenadores` (
  `NID_Entrenador` int(11) NOT NULL COMMENT 'Identificador del catalogo cuando se agrege un nuevo entrendaor',
  `ID_Empleado` int(11) NOT NULL COMMENT 'referencia a la tabla empelados para traer su inforamcion',
  `ID_Clase` int(11) DEFAULT NULL COMMENT 'Enlace de las clases del entrenador '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_entrenadores`
--

INSERT INTO `cat_entrenadores` (`NID_Entrenador`, `ID_Empleado`, `ID_Clase`) VALUES
(1, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estados`
--

CREATE TABLE `cat_estados` (
  `NID_Estado` int(11) NOT NULL COMMENT 'Indentificador unico del estado',
  `N_Estado` varchar(50) NOT NULL COMMENT 'Nombre del estado (activo, inactivo, etc)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar estado disponibles en el sistema';

--
-- Volcado de datos para la tabla `cat_estados`
--

INSERT INTO `cat_estados` (`NID_Estado`, `N_Estado`) VALUES
(1, '-- Seleccionar --'),
(2, 'Activo'),
(3, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_generos`
--

CREATE TABLE `cat_generos` (
  `NID_Genero` int(11) NOT NULL COMMENT 'Identificador único del genero',
  `N_Genero` varchar(50) NOT NULL COMMENT 'Nombre del genero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar generos disponibles en el sistema';

--
-- Volcado de datos para la tabla `cat_generos`
--

INSERT INTO `cat_generos` (`NID_Genero`, `N_Genero`) VALUES
(1, '-- Seleccionar --'),
(3, 'Femenino'),
(2, 'Masculino'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_horarios`
--

CREATE TABLE `cat_horarios` (
  `NID_Horario` int(11) NOT NULL COMMENT 'Identificador único del horario',
  `N_Dia` varchar(50) NOT NULL COMMENT 'Día al que corresponde el horario.',
  `N_HoraInicio` time NOT NULL COMMENT 'Hora de inicio del horario.',
  `N_HoraFin` time NOT NULL COMMENT 'Hora de finalización del horario.',
  `N_Turno` varchar(2) NOT NULL COMMENT 'Turno del horario (AM o PM).'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT=' Tabla para almacenar horarios de actividades';

--
-- Volcado de datos para la tabla `cat_horarios`
--

INSERT INTO `cat_horarios` (`NID_Horario`, `N_Dia`, `N_HoraInicio`, `N_HoraFin`, `N_Turno`) VALUES
(1, '--> Seleccionar <--', '00:00:00', '00:00:00', ''),
(2, 'Lunes', '06:00:00', '07:00:00', 'AM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_recursos`
--

CREATE TABLE `cat_recursos` (
  `NID_Recurso` int(11) NOT NULL COMMENT 'identificador de del recurso',
  `N_Recurso` varchar(100) NOT NULL COMMENT 'nombre del tipo de recurso ejmplo video imagen etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de realcion de recursos de apoyo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_roles`
--

CREATE TABLE `cat_roles` (
  `NID_Rol` int(11) NOT NULL COMMENT 'Identificador único del rol',
  `N_Rol` varchar(50) NOT NULL COMMENT 'Nombre del rol ej: Administrador, Entrenador, etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar roles disponibles en el sistema';

--
-- Volcado de datos para la tabla `cat_roles`
--

INSERT INTO `cat_roles` (`NID_Rol`, `N_Rol`) VALUES
(1, '-- Seleccionar --'),
(2, 'Adminstrador'),
(3, 'Entrenador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_asistencias`
--

CREATE TABLE `tb_asistencias` (
  `NID_Asistencias` int(11) NOT NULL COMMENT 'identificador de asistencias',
  `ID_Clase` int(11) NOT NULL COMMENT 'Asociacion de la asitencia a la clase',
  `ID_Socio` int(11) NOT NULL COMMENT 'asociacion del socio ',
  `N_Fecha` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de que se registra la asistencia',
  `N_Codigo` varchar(25) NOT NULL COMMENT 'codigo que se ingreso el cual se comapra con el de la tabla cat_codigos',
  `ID_Asistio` int(11) NOT NULL COMMENT 'Catalogo donde se hace la el si o no asistio',
  `N_Comentario` text DEFAULT NULL COMMENT 'comatario opcional de la clase por parte del socio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de asistencias de clases';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_empleados`
--

CREATE TABLE `tb_empleados` (
  `N_Empleado` int(11) NOT NULL COMMENT 'Número de empleado',
  `N_Usuario` varchar(100) NOT NULL COMMENT 'Nombre de usuario para iniciar sesión',
  `N_Password` varchar(255) NOT NULL COMMENT 'Contraseña',
  `ID_Rol` int(11) NOT NULL COMMENT 'ID del rol del empleado',
  `ID_Genero` int(11) NOT NULL COMMENT 'ID del género del empleado',
  `N_Nombre` varchar(100) NOT NULL COMMENT 'Nombre del empleado',
  `N_ApellidoPa` varchar(100) NOT NULL COMMENT 'Primer apellido del empleado',
  `N_ApellidoMa` varchar(100) NOT NULL COMMENT 'Segundo apellido del empleado',
  `N_Telefono` varchar(20) NOT NULL COMMENT 'Número de teléfono del empleado',
  `N_Correo` varchar(150) NOT NULL COMMENT 'Correo electrónico del empleado',
  `ID_Estado` int(11) NOT NULL COMMENT 'ID del estado del empleado (activo, inactivo, etc.)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar información de empleados';

--
-- Volcado de datos para la tabla `tb_empleados`
--

INSERT INTO `tb_empleados` (`N_Empleado`, `N_Usuario`, `N_Password`, `ID_Rol`, `ID_Genero`, `N_Nombre`, `N_ApellidoPa`, `N_ApellidoMa`, `N_Telefono`, `N_Correo`, `ID_Estado`) VALUES
(1, 'Admin', 'Admin', 2, 2, 'test', 'Prueba', 'Evaluación', '(777) 777 77 77', 'ejemplo@ejemplo.com', 2),
(2, 'testuser123', 'Password123', 3, 2, 'Juan', 'Perez', 'Garcia', '555-123-4567', 'juanpg@example.com', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_material`
--

CREATE TABLE `tb_material` (
  `ID_Material` int(11) NOT NULL COMMENT 'nimero de material',
  `ID_Clase` int(11) NOT NULL COMMENT 'identificador de la calse',
  `ID_TipoRecurso` int(11) NOT NULL COMMENT 'tipo de recurso asicado a la tabla correspondiente',
  `N_Contenido` blob NOT NULL COMMENT 'cadena de almacenamiento del recurso ya sea iamgen o video',
  `N_Descripcion` text NOT NULL COMMENT 'descripcion general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de recursos generales de apoyo a la clases ';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_socios`
--

CREATE TABLE `tb_socios` (
  `N_Socio` int(11) NOT NULL COMMENT 'Numero de socio',
  `N_Usuario` varchar(50) NOT NULL COMMENT 'Nombre de usuario para acceso al sistema',
  `N_Password` varchar(255) NOT NULL COMMENT 'Contraseña para acceso al sistema',
  `N_Genero` int(11) NOT NULL COMMENT 'Genero del socio',
  `N_Nombre` varchar(100) NOT NULL COMMENT 'Nombre del socio',
  `N_ApellidoPa` varchar(100) NOT NULL COMMENT 'Primer apellido del socio',
  `N_ApellidoMa` varchar(100) NOT NULL COMMENT 'Sgundo apellido del socio',
  `N_Telefono` varchar(20) NOT NULL COMMENT 'telefono de contacto opcional',
  `N_Correo` varchar(100) NOT NULL COMMENT 'Correo de contacto opcional',
  `N_Clases` int(11) NOT NULL COMMENT 'Identificador de la clase que toma (opcional)',
  `ID_Estado` int(11) NOT NULL COMMENT 'Indeitifcador del estado del usuario (Activo, inactivo, etc)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla socios para accesos al sistema y datos generales';

--
-- Volcado de datos para la tabla `tb_socios`
--

INSERT INTO `tb_socios` (`N_Socio`, `N_Usuario`, `N_Password`, `N_Genero`, `N_Nombre`, `N_ApellidoPa`, `N_ApellidoMa`, `N_Telefono`, `N_Correo`, `N_Clases`, `ID_Estado`) VALUES
(1, 'sociouser1', 'SocioPass123', 3, 'María', 'López', 'Gutiérrez', '555-123-4567', 'maria.gl@example.com', 1, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_clases`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_clases` (
`NID_Clase` int(11)
,`N_Clase` varchar(100)
,`N_Dia` varchar(50)
,`N_HoraInicio` varchar(10)
,`N_HoraFin` varchar(10)
,`N_Turno` varchar(2)
,`ID_Entrenador` varchar(11)
,`Nombre_Entrenador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_empleados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_empleados` (
`N_Empleado` int(11)
,`N_Usuario` varchar(100)
,`N_Password` varchar(255)
,`ID_Rol` int(11)
,`N_Rol` varchar(50)
,`ID_Genero` int(11)
,`N_Genero` varchar(50)
,`N_Nombre` varchar(100)
,`N_ApellidoPa` varchar(100)
,`N_ApellidoMa` varchar(100)
,`N_Telefono` varchar(20)
,`N_Correo` varchar(150)
,`ID_Estado` int(11)
,`N_Estado` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_entrenadores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_entrenadores` (
`NID_Entrenador` int(11)
,`Nombre_Empleado` varchar(100)
,`Apellido_Paterno` varchar(100)
,`Apellido_Materno` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_socios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_socios` (
`N_Socio` int(11)
,`N_Usuario` varchar(50)
,`N_Password` varchar(255)
,`ID_Genero` int(11)
,`N_Genero` varchar(50)
,`N_Nombre` varchar(100)
,`N_ApellidoPa` varchar(100)
,`N_ApellidoMa` varchar(100)
,`N_Telefono` varchar(20)
,`N_Correo` varchar(100)
,`N_Clases` int(11)
,`N_Clase` varchar(100)
,`ID_Estado` int(11)
,`N_Estado` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_clases`
--
DROP TABLE IF EXISTS `vw_clases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_clases`  AS SELECT `cc`.`NID_Clase` AS `NID_Clase`, coalesce(`cc`.`N_Clase`,'-- Seleccionar --') AS `N_Clase`, coalesce(`ch`.`N_Dia`,'') AS `N_Dia`, coalesce(`ch`.`N_HoraInicio`,'') AS `N_HoraInicio`, coalesce(`ch`.`N_HoraFin`,'') AS `N_HoraFin`, coalesce(`ch`.`N_Turno`,'') AS `N_Turno`, coalesce(`ce`.`NID_Entrenador`,'') AS `ID_Entrenador`, coalesce(`te`.`N_Nombre`,'') AS `Nombre_Entrenador` FROM (((`cat_clases` `cc` left join `cat_horarios` `ch` on(`cc`.`ID_Horario` = `ch`.`NID_Horario`)) left join `cat_entrenadores` `ce` on(`cc`.`ID_Entrenador` = `ce`.`NID_Entrenador`)) left join `tb_empleados` `te` on(`ce`.`ID_Empleado` = `te`.`N_Empleado`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_empleados`
--
DROP TABLE IF EXISTS `vw_empleados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_empleados`  AS SELECT `e`.`N_Empleado` AS `N_Empleado`, `e`.`N_Usuario` AS `N_Usuario`, `e`.`N_Password` AS `N_Password`, `r`.`NID_Rol` AS `ID_Rol`, `r`.`N_Rol` AS `N_Rol`, `g`.`NID_Genero` AS `ID_Genero`, `g`.`N_Genero` AS `N_Genero`, `e`.`N_Nombre` AS `N_Nombre`, `e`.`N_ApellidoPa` AS `N_ApellidoPa`, `e`.`N_ApellidoMa` AS `N_ApellidoMa`, `e`.`N_Telefono` AS `N_Telefono`, `e`.`N_Correo` AS `N_Correo`, `est`.`NID_Estado` AS `ID_Estado`, `est`.`N_Estado` AS `N_Estado` FROM (((`tb_empleados` `e` join `cat_roles` `r` on(`e`.`ID_Rol` = `r`.`NID_Rol`)) join `cat_generos` `g` on(`e`.`ID_Genero` = `g`.`NID_Genero`)) join `cat_estados` `est` on(`e`.`ID_Estado` = `est`.`NID_Estado`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_entrenadores`
--
DROP TABLE IF EXISTS `vw_entrenadores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_entrenadores`  AS SELECT `ce`.`NID_Entrenador` AS `NID_Entrenador`, `te`.`N_Nombre` AS `Nombre_Empleado`, `te`.`N_ApellidoPa` AS `Apellido_Paterno`, `te`.`N_ApellidoMa` AS `Apellido_Materno` FROM (`cat_entrenadores` `ce` join `tb_empleados` `te` on(`ce`.`ID_Empleado` = `te`.`N_Empleado`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_socios`
--
DROP TABLE IF EXISTS `vw_socios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_socios`  AS SELECT `s`.`N_Socio` AS `N_Socio`, `s`.`N_Usuario` AS `N_Usuario`, `s`.`N_Password` AS `N_Password`, `g`.`NID_Genero` AS `ID_Genero`, `g`.`N_Genero` AS `N_Genero`, `s`.`N_Nombre` AS `N_Nombre`, `s`.`N_ApellidoPa` AS `N_ApellidoPa`, `s`.`N_ApellidoMa` AS `N_ApellidoMa`, `s`.`N_Telefono` AS `N_Telefono`, `s`.`N_Correo` AS `N_Correo`, `s`.`N_Clases` AS `N_Clases`, `c`.`N_Clase` AS `N_Clase`, `e`.`NID_Estado` AS `ID_Estado`, `e`.`N_Estado` AS `N_Estado` FROM (((`tb_socios` `s` join `cat_generos` `g` on(`s`.`N_Genero` = `g`.`NID_Genero`)) join `cat_estados` `e` on(`s`.`ID_Estado` = `e`.`NID_Estado`)) join `cat_clases` `c` on(`s`.`N_Clases` = `c`.`NID_Clase`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_asistencia`
--
ALTER TABLE `cat_asistencia`
  ADD PRIMARY KEY (`NID_Asistio`),
  ADD UNIQUE KEY `N_Asistio` (`N_Asistio`);

--
-- Indices de la tabla `cat_clases`
--
ALTER TABLE `cat_clases`
  ADD PRIMARY KEY (`NID_Clase`),
  ADD KEY `ID_Horario` (`ID_Horario`);

--
-- Indices de la tabla `cat_codigos`
--
ALTER TABLE `cat_codigos`
  ADD PRIMARY KEY (`NID_Codigos`),
  ADD UNIQUE KEY `N_Codigo` (`N_Codigo`),
  ADD KEY `fk_clase` (`ID_Clase`);

--
-- Indices de la tabla `cat_entrenadores`
--
ALTER TABLE `cat_entrenadores`
  ADD PRIMARY KEY (`NID_Entrenador`),
  ADD KEY `ID_Empleado` (`ID_Empleado`),
  ADD KEY `ID_Clase` (`ID_Clase`);

--
-- Indices de la tabla `cat_estados`
--
ALTER TABLE `cat_estados`
  ADD PRIMARY KEY (`NID_Estado`),
  ADD UNIQUE KEY `N_Estado` (`N_Estado`);

--
-- Indices de la tabla `cat_generos`
--
ALTER TABLE `cat_generos`
  ADD PRIMARY KEY (`NID_Genero`),
  ADD UNIQUE KEY `N_Genero` (`N_Genero`);

--
-- Indices de la tabla `cat_horarios`
--
ALTER TABLE `cat_horarios`
  ADD PRIMARY KEY (`NID_Horario`),
  ADD UNIQUE KEY `N_HoraInicio` (`N_HoraInicio`),
  ADD UNIQUE KEY `N_HoraFin` (`N_HoraFin`);

--
-- Indices de la tabla `cat_recursos`
--
ALTER TABLE `cat_recursos`
  ADD PRIMARY KEY (`NID_Recurso`);

--
-- Indices de la tabla `cat_roles`
--
ALTER TABLE `cat_roles`
  ADD PRIMARY KEY (`NID_Rol`),
  ADD UNIQUE KEY `N_Rol` (`N_Rol`);

--
-- Indices de la tabla `tb_asistencias`
--
ALTER TABLE `tb_asistencias`
  ADD PRIMARY KEY (`NID_Asistencias`),
  ADD KEY `fk_asistencia` (`ID_Asistio`);

--
-- Indices de la tabla `tb_empleados`
--
ALTER TABLE `tb_empleados`
  ADD PRIMARY KEY (`N_Empleado`),
  ADD UNIQUE KEY `N_Usuario` (`N_Usuario`),
  ADD KEY `fk_rol` (`ID_Rol`),
  ADD KEY `fk_genero` (`ID_Genero`),
  ADD KEY `fk_estado_empleado` (`ID_Estado`);

--
-- Indices de la tabla `tb_material`
--
ALTER TABLE `tb_material`
  ADD PRIMARY KEY (`ID_Material`),
  ADD KEY `ID_Clase` (`ID_Clase`),
  ADD KEY `ID_TipoRecurso` (`ID_TipoRecurso`);

--
-- Indices de la tabla `tb_socios`
--
ALTER TABLE `tb_socios`
  ADD PRIMARY KEY (`N_Socio`,`N_Clases`),
  ADD UNIQUE KEY `N_Usuario` (`N_Usuario`),
  ADD KEY `fk_genero_socio` (`N_Genero`),
  ADD KEY `fk_estado_socio` (`ID_Estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_asistencia`
--
ALTER TABLE `cat_asistencia`
  MODIFY `NID_Asistio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiacion de y asociacion de si asitio o no el socio';

--
-- AUTO_INCREMENT de la tabla `cat_clases`
--
ALTER TABLE `cat_clases`
  MODIFY `NID_Clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_codigos`
--
ALTER TABLE `cat_codigos`
  MODIFY `NID_Codigos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'idenitficador de codigos para hcer un historial de codigos', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cat_entrenadores`
--
ALTER TABLE `cat_entrenadores`
  MODIFY `NID_Entrenador` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del catalogo cuando se agrege un nuevo entrendaor', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cat_estados`
--
ALTER TABLE `cat_estados`
  MODIFY `NID_Estado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Indentificador unico del estado', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_generos`
--
ALTER TABLE `cat_generos`
  MODIFY `NID_Genero` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del genero', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_horarios`
--
ALTER TABLE `cat_horarios`
  MODIFY `NID_Horario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del horario', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_recursos`
--
ALTER TABLE `cat_recursos`
  MODIFY `NID_Recurso` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de del recurso';

--
-- AUTO_INCREMENT de la tabla `cat_roles`
--
ALTER TABLE `cat_roles`
  MODIFY `NID_Rol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_asistencias`
--
ALTER TABLE `tb_asistencias`
  MODIFY `NID_Asistencias` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de asistencias';

--
-- AUTO_INCREMENT de la tabla `tb_empleados`
--
ALTER TABLE `tb_empleados`
  MODIFY `N_Empleado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de empleado', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_material`
--
ALTER TABLE `tb_material`
  MODIFY `ID_Material` int(11) NOT NULL AUTO_INCREMENT COMMENT 'nimero de material';

--
-- AUTO_INCREMENT de la tabla `tb_socios`
--
ALTER TABLE `tb_socios`
  MODIFY `N_Socio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numero de socio', AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cat_codigos`
--
ALTER TABLE `cat_codigos`
  ADD CONSTRAINT `fk_clase` FOREIGN KEY (`ID_Clase`) REFERENCES `cat_clases` (`NID_Clase`);

--
-- Filtros para la tabla `cat_entrenadores`
--
ALTER TABLE `cat_entrenadores`
  ADD CONSTRAINT `cat_entrenadores_ibfk_1` FOREIGN KEY (`ID_Empleado`) REFERENCES `tb_empleados` (`N_Empleado`),
  ADD CONSTRAINT `fk_empleado` FOREIGN KEY (`ID_Empleado`) REFERENCES `tb_empleados` (`N_Empleado`);

--
-- Filtros para la tabla `tb_asistencias`
--
ALTER TABLE `tb_asistencias`
  ADD CONSTRAINT `fk_asistencia` FOREIGN KEY (`ID_Asistio`) REFERENCES `cat_asistencia` (`NID_Asistio`);

--
-- Filtros para la tabla `tb_empleados`
--
ALTER TABLE `tb_empleados`
  ADD CONSTRAINT `fk_estado_empleado` FOREIGN KEY (`ID_Estado`) REFERENCES `cat_estados` (`NID_Estado`),
  ADD CONSTRAINT `fk_genero` FOREIGN KEY (`ID_Genero`) REFERENCES `cat_generos` (`NID_Genero`),
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `cat_roles` (`NID_Rol`);

--
-- Filtros para la tabla `tb_material`
--
ALTER TABLE `tb_material`
  ADD CONSTRAINT `tb_material_ibfk_1` FOREIGN KEY (`ID_Clase`) REFERENCES `cat_clases` (`NID_Clase`),
  ADD CONSTRAINT `tb_material_ibfk_2` FOREIGN KEY (`ID_TipoRecurso`) REFERENCES `cat_recursos` (`NID_Recurso`);

--
-- Filtros para la tabla `tb_socios`
--
ALTER TABLE `tb_socios`
  ADD CONSTRAINT `fk_estado_socio` FOREIGN KEY (`ID_Estado`) REFERENCES `cat_estados` (`NID_Estado`),
  ADD CONSTRAINT `fk_genero_socio` FOREIGN KEY (`N_Genero`) REFERENCES `cat_generos` (`NID_Genero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
