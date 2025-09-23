<?php
include "conexion.php";

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $nombre, $correo, $contraseña);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../index.html?status=ok"); // Redirige a la página principal con mensaje
    exit();
} else {
    header("Location: ../index.html?status=error");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>