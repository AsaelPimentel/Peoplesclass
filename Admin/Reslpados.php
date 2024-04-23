<?php
$db_host = 'localhost'; // Host del Servidor MySQL
$db_name = 'gymclass'; // Nombre de la Base de datos
$db_user = 'root'; // Usuario de MySQL
$db_pass = ''; // Contraseña de Usuario MySQL

$fecha = date("Ymd-His"); // Obtenemos la fecha y hora para identificar el respaldo

// Construimos el nombre de archivo SQL Ejemplo: mibase_20170101-081120.sql
$salida_sql = $db_name . '_' . $fecha . '.sql';

// Comando para generar respaldo de MySQL, enviamos las variables de conexión y el destino
$dump = "mysqldump --host=$db_host --user=$db_user --password='$db_pass' $db_name > $salida_sql";
exec($dump, $output, $return_var); // Usamos exec() en lugar de system() para obtener la salida del comando

if ($return_var === 0) { // Verificamos si el comando se ejecutó correctamente
    // Objeto de Librería ZipArchive
    $zip = new ZipArchive();

    // Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
    $salida_zip = $db_name . '_' . $fecha . '.zip';

    if ($zip->open($salida_zip, ZipArchive::CREATE) === true) { // Creamos y abrimos el archivo ZIP
        $zip->addFile($salida_sql, basename($salida_sql)); // Agregamos el archivo SQL a ZIP
        $zip->close(); // Cerramos el ZIP
        unlink($salida_sql); // Eliminamos el archivo temporal SQL

        // Redireccionamos para descargar el archivo ZIP
        header("Location: $salida_zip");
        exit();
    } else {
        echo 'Error al crear el archivo ZIP'; // Enviamos el mensaje de error
    }
} else {
    echo 'Error al generar el respaldo'; // Enviamos el mensaje de error
}
?>
