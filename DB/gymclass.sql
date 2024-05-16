CREATE SCHEMA `gymclass` DEFAULT CHARACTER SET utf8mb4 ;

CREATE TABLE `cat_asistencia` (
 `NID_Asistio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiacion de y asociacion de si asitio o no el socio',
 `N_Asistio` varchar(50) NOT NULL COMMENT 'dato texto de la asitencia ej si asistio o no asistio',
 PRIMARY KEY (`NID_Asistio`),
 UNIQUE KEY `N_Asistio` (`N_Asistio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de catoalogo de asistencias '

CREATE TABLE `cat_clases` (
 `NID_Clase` int(11) NOT NULL AUTO_INCREMENT,
 `N_Clase` varchar(100) NOT NULL COMMENT 'Nombre de la clase',
 `ID_Horario` int(11) NOT NULL,
 `ID_Entrenador` int(11) NOT NULL,
 PRIMARY KEY (`NID_Clase`),
 KEY `ID_Horario` (`ID_Horario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci

CREATE TABLE `cat_codigos` (
 `NID_Codigos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'idenitficador de codigos para hcer un historial de codigos',
 `N_Codigo` varchar(25) NOT NULL COMMENT 'Codigo en si este se alimetara de una fucnion echa en el sistema se utilizara para comparar con el que ingrese el usuario',
 `N_FechaGeneracion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de inicio de validez del codigo empezara dede que se guarda',
 `N_FechaExpiracion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fechad onde dejara de ser valido el codigo',
 `ID_Clase` int(11) NOT NULL COMMENT 'Asociar el codigo a una clase para tener un mejor control',
 PRIMARY KEY (`NID_Codigos`),
 KEY `fk_clase` (`ID_Clase`),
 CONSTRAINT `fk_clase` FOREIGN KEY (`ID_Clase`) REFERENCES `cat_clases` (`NID_Clase`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla de codigos para un mejor control de los mismos'

CREATE TABLE `cat_entrenadores` (
 `NID_Entrenador` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del catalogo cuando se agrege un nuevo entrendaor',
 `ID_Empleado` int(11) NOT NULL COMMENT 'referencia a la tabla empelados para traer su inforamcion',
 `ID_Clase` int(11) DEFAULT NULL COMMENT 'Enlace de las clases del entrenador ',
 PRIMARY KEY (`NID_Entrenador`),
 KEY `ID_Empleado` (`ID_Empleado`),
 KEY `ID_Clase` (`ID_Clase`),
 CONSTRAINT `cat_entrenadores_ibfk_1` FOREIGN KEY (`ID_Empleado`) REFERENCES `tb_empleados` (`N_Empleado`),
 CONSTRAINT `fk_empleado` FOREIGN KEY (`ID_Empleado`) REFERENCES `tb_empleados` (`N_Empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci

CREATE TABLE `cat_estados` (
 `NID_Estado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Indentificador unico del estado',
 `N_Estado` varchar(50) NOT NULL COMMENT 'Nombre del estado (activo, inactivo, etc)',
 PRIMARY KEY (`NID_Estado`),
 UNIQUE KEY `N_Estado` (`N_Estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar estado disponibles en el sistema'

CREATE TABLE `cat_generos` (
 `NID_Genero` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del genero',
 `N_Genero` varchar(50) NOT NULL COMMENT 'Nombre del genero',
 PRIMARY KEY (`NID_Genero`),
 UNIQUE KEY `N_Genero` (`N_Genero`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar generos disponibles en el sistema'

	CREATE TABLE `cat_horarios` (
 `NID_Horario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del horario',
 `N_Dia` varchar(50) NOT NULL COMMENT 'Día al que corresponde el horario.',
 `N_HoraInicio` time NOT NULL COMMENT 'Hora de inicio del horario.',
 `N_HoraFin` time NOT NULL COMMENT 'Hora de finalización del horario.',
 `N_Turno` varchar(2) NOT NULL COMMENT 'Turno del horario (AM o PM).',
 PRIMARY KEY (`NID_Horario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT=' Tabla para almacenar horarios de actividades'

	CREATE TABLE `cat_recursos` (
 `NID_Recurso` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de del recurso',
 `N_Recurso` varchar(100) NOT NULL COMMENT 'nombre del tipo de recurso ejmplo video imagen etc',
 PRIMARY KEY (`NID_Recurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de realcion de recursos de apoyo'

CREATE TABLE `cat_roles` (
 `NID_Rol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del rol',
 `N_Rol` varchar(50) NOT NULL COMMENT 'Nombre del rol ej: Administrador, Entrenador, etc',
 PRIMARY KEY (`NID_Rol`),
 UNIQUE KEY `N_Rol` (`N_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar roles disponibles en el sistema'

	CREATE TABLE `tb_asistencias` (
 `NID_Asistencias` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de asistencias',
 `ID_Clase` int(11) NOT NULL COMMENT 'Asociacion de la asitencia a la clase',
 `ID_Socio` int(11) NOT NULL COMMENT 'asociacion del socio ',
 `N_Fecha` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de que se registra la asistencia',
 `N_Codigo` varchar(25) NOT NULL COMMENT 'codigo que se ingreso el cual se comapra con el de la tabla cat_codigos',
 `ID_Asistio` int(11) NOT NULL COMMENT 'Catalogo donde se hace la el si o no asistio',
 `N_Comentario` text DEFAULT NULL COMMENT 'comatario opcional de la clase por parte del socio',
 PRIMARY KEY (`NID_Asistencias`),
 KEY `fk_asistencia` (`ID_Asistio`),
 CONSTRAINT `fk_asistencia` FOREIGN KEY (`ID_Asistio`) REFERENCES `cat_asistencia` (`NID_Asistio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de asistencias de clases'

	CREATE TABLE `tb_empleados` (
 `N_Empleado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de empleado',
 `N_Usuario` varchar(100) NOT NULL COMMENT 'Nombre de usuario para iniciar sesión',
 `N_Password` varchar(255) NOT NULL COMMENT 'Contraseña',
 `ID_Rol` int(11) NOT NULL COMMENT 'ID del rol del empleado',
 `ID_Genero` int(11) NOT NULL COMMENT 'ID del género del empleado',
 `N_Nombre` varchar(100) NOT NULL COMMENT 'Nombre del empleado',
 `N_ApellidoPa` varchar(100) NOT NULL COMMENT 'Primer apellido del empleado',
 `N_ApellidoMa` varchar(100) NOT NULL COMMENT 'Segundo apellido del empleado',
 `N_Telefono` varchar(20) NOT NULL COMMENT 'Número de teléfono del empleado',
 `N_Correo` varchar(150) NOT NULL COMMENT 'Correo electrónico del empleado',
 `ID_Estado` int(11) NOT NULL COMMENT 'ID del estado del empleado (activo, inactivo, etc.)',
 PRIMARY KEY (`N_Empleado`),
 UNIQUE KEY `N_Usuario` (`N_Usuario`),
 KEY `fk_rol` (`ID_Rol`),
 KEY `fk_genero` (`ID_Genero`),
 KEY `fk_estado_empleado` (`ID_Estado`),
 CONSTRAINT `fk_estado_empleado` FOREIGN KEY (`ID_Estado`) REFERENCES `cat_estados` (`NID_Estado`),
 CONSTRAINT `fk_genero` FOREIGN KEY (`ID_Genero`) REFERENCES `cat_generos` (`NID_Genero`),
 CONSTRAINT `fk_rol` FOREIGN KEY (`ID_Rol`) REFERENCES `cat_roles` (`NID_Rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Tabla para almacenar información de empleados'

CREATE TABLE `tb_material` (
 `ID_Material` int(11) NOT NULL AUTO_INCREMENT COMMENT 'nimero de material',
 `ID_Clase` int(11) NOT NULL COMMENT 'identificador de la calse',
 `ID_TipoRecurso` int(11) NOT NULL COMMENT 'tipo de recurso asicado a la tabla correspondiente',
 `N_Contenido` blob NOT NULL COMMENT 'cadena de almacenamiento del recurso ya sea iamgen o video',
 `N_Descripcion` text NOT NULL COMMENT 'descripcion general',
 PRIMARY KEY (`ID_Material`),
 KEY `ID_Clase` (`ID_Clase`),
 KEY `ID_TipoRecurso` (`ID_TipoRecurso`),
 CONSTRAINT `tb_material_ibfk_1` FOREIGN KEY (`ID_Clase`) REFERENCES `cat_clases` (`NID_Clase`),
 CONSTRAINT `tb_material_ibfk_2` FOREIGN KEY (`ID_TipoRecurso`) REFERENCES `cat_recursos` (`NID_Recurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla de recursos generales de apoyo a la clases '

CREATE TABLE `tb_socios` (
 `N_Socio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numero de socio',
 `N_Usuario` varchar(50) NOT NULL COMMENT 'Nombre de usuario para acceso al sistema',
 `N_Password` varchar(255) NOT NULL COMMENT 'Contraseña para acceso al sistema',
 `N_Genero` int(11) NOT NULL COMMENT 'Genero del socio',
 `N_Nombre` varchar(100) NOT NULL COMMENT 'Nombre del socio',
 `N_ApellidoPa` varchar(100) NOT NULL COMMENT 'Primer apellido del socio',
 `N_ApellidoMa` varchar(100) NOT NULL COMMENT 'Sgundo apellido del socio',
 `N_Telefono` varchar(20) NOT NULL COMMENT 'telefono de contacto opcional',
 `N_Correo` varchar(100) NOT NULL COMMENT 'Correo de contacto opcional',
 `N_Clases` varchar(100) NOT NULL COMMENT 'Identificador de la clase que toma (opcional)',
 `ID_Estado` int(11) NOT NULL COMMENT 'Indeitifcador del estado del usuario (Activo, inactivo, etc)',
 PRIMARY KEY (`N_Socio`,`N_Clases`),
 UNIQUE KEY `N_Usuario` (`N_Usuario`),
 KEY `fk_genero_socio` (`N_Genero`),
 KEY `fk_estado_socio` (`ID_Estado`),
 CONSTRAINT `fk_estado_socio` FOREIGN KEY (`ID_Estado`) REFERENCES `cat_estados` (`NID_Estado`),
 CONSTRAINT `fk_genero_socio` FOREIGN KEY (`N_Genero`) REFERENCES `cat_generos` (`NID_Genero`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='tabla socios para accesos al sistema y datos generales'


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gymclass`.`vw_clases` AS select `cc`.`NID_Clase` AS `NID_Clase`,coalesce(`cc`.`N_Clase`,'-- Seleccionar --') AS `N_Clase`,coalesce(`ch`.`N_Dia`,'') AS `N_Dia`,coalesce(`ch`.`N_HoraInicio`,'') AS `N_HoraInicio`,coalesce(`ch`.`N_HoraFin`,'') AS `N_HoraFin`,coalesce(`ch`.`N_Turno`,'') AS `N_Turno`,coalesce(`ce`.`NID_Entrenador`,'') AS `ID_Entrenador`,coalesce(`te`.`N_Nombre`,'') AS `Nombre_Entrenador` from (((`gymclass`.`cat_clases` `cc` left join `gymclass`.`cat_horarios` `ch` on(`cc`.`ID_Horario` = `ch`.`NID_Horario`)) left join `gymclass`.`cat_entrenadores` `ce` on(`cc`.`ID_Entrenador` = `ce`.`NID_Entrenador`)) left join `gymclass`.`tb_empleados` `te` on(`ce`.`ID_Empleado` = `te`.`N_Empleado`))

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gymclass`.`vw_clases_socios` AS select `cc`.`NID_Clase` AS `NID_Clase`,`cc`.`N_Clase` AS `N_Clase`,`cc`.`ID_Horario` AS `ID_Horario`,`ch`.`N_Dia` AS `N_Dia`,`ch`.`N_HoraInicio` AS `N_HoraInicio`,`ch`.`N_HoraFin` AS `N_HoraFin`,`ch`.`N_Turno` AS `N_Turno`,`ts`.`N_Socio` AS `N_Socio`,`ts`.`N_Nombre` AS `N_Nombre` from ((`gymclass`.`cat_clases` `cc` join `gymclass`.`cat_horarios` `ch` on(`cc`.`ID_Horario` = `ch`.`NID_Horario`)) join `gymclass`.`tb_socios` `ts` on(`ts`.`N_Clases` = `cc`.`N_Clase`))

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gymclass`.`vw_empleados` AS select `e`.`N_Empleado` AS `N_Empleado`,`e`.`N_Usuario` AS `N_Usuario`,`e`.`N_Password` AS `N_Password`,`r`.`NID_Rol` AS `ID_Rol`,`r`.`N_Rol` AS `N_Rol`,`g`.`NID_Genero` AS `ID_Genero`,`g`.`N_Genero` AS `N_Genero`,`e`.`N_Nombre` AS `N_Nombre`,`e`.`N_ApellidoPa` AS `N_ApellidoPa`,`e`.`N_ApellidoMa` AS `N_ApellidoMa`,`e`.`N_Telefono` AS `N_Telefono`,`e`.`N_Correo` AS `N_Correo`,`est`.`NID_Estado` AS `ID_Estado`,`est`.`N_Estado` AS `N_Estado` from (((`gymclass`.`tb_empleados` `e` join `gymclass`.`cat_roles` `r` on(`e`.`ID_Rol` = `r`.`NID_Rol`)) join `gymclass`.`cat_generos` `g` on(`e`.`ID_Genero` = `g`.`NID_Genero`)) join `gymclass`.`cat_estados` `est` on(`e`.`ID_Estado` = `est`.`NID_Estado`))

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gymclass`.`vw_entrenadores` AS select `ce`.`NID_Entrenador` AS `NID_Entrenador`,`te`.`N_Nombre` AS `Nombre_Empleado`,`te`.`N_ApellidoPa` AS `Apellido_Paterno`,`te`.`N_ApellidoMa` AS `Apellido_Materno` from (`gymclass`.`cat_entrenadores` `ce` join `gymclass`.`tb_empleados` `te` on(`ce`.`ID_Empleado` = `te`.`N_Empleado`))

	CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gymclass`.`vw_socios` AS select `s`.`N_Socio` AS `N_Socio`,`s`.`N_Usuario` AS `N_Usuario`,`s`.`N_Password` AS `N_Password`,`g`.`NID_Genero` AS `ID_Genero`,`g`.`N_Genero` AS `N_Genero`,`s`.`N_Nombre` AS `N_Nombre`,`s`.`N_ApellidoPa` AS `N_ApellidoPa`,`s`.`N_ApellidoMa` AS `N_ApellidoMa`,`s`.`N_Telefono` AS `N_Telefono`,`s`.`N_Correo` AS `N_Correo`,`s`.`N_Clases` AS `N_Clases`,`e`.`NID_Estado` AS `ID_Estado`,`e`.`N_Estado` AS `N_Estado` from ((`gymclass`.`tb_socios` `s` join `gymclass`.`cat_generos` `g` on(`s`.`N_Genero` = `g`.`NID_Genero`)) join `gymclass`.`cat_estados` `e` on(`s`.`ID_Estado` = `e`.`NID_Estado`))