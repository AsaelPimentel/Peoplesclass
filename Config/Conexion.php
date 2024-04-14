<?php
class ConexionBD {
    private static $conexion = null;
    private static $host = "localhost";
    private static $usuario = "root";
    private static $contrasena = "";
    private static $base_de_datos = "Gymclass";

    public static function obtenerConexion() {
        if (self::$conexion === null) {
            self::$conexion = mysqli_connect(self::$host, self::$usuario, self::$contrasena, self::$base_de_datos);
            if (!self::$conexion) {
                // Manejar error de conexión
                die("Error de conexión: " . mysqli_connect_error());
            }
        }
        return self::$conexion;
    }
}
?>
