<?php
$host = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos = "mp_tatys_tejidos"; 

$conexion = mysqli_connect($host, $usuario, $contraseña, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>