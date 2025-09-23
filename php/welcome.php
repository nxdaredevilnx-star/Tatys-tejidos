<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../php/login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Bienvenido</title>
</head>
<body>
  <h1>Hola, <?= htmlspecialchars($user['name']) ?> 👋</h1>
  <p>Email: <?= htmlspecialchars($user['email']) ?></p>
  <img src="<?= htmlspecialchars($user['picture']) ?>" alt="Foto de perfil">
</body>
</html>
