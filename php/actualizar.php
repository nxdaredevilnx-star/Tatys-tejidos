<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Actualizar cliente | CoffeeCorner</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3ebe0;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 60%;
      margin: 50px auto;
      background: #fffdf9;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
    }
    h1 {
      color: #5c3d2e;
      margin-bottom: 20px;
    }
    form {
      margin-top: 20px;
    }
    input[type="text"] {
      padding: 8px;
      width: 60%;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    input[type="submit"] {
      background: #6f4e37;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }
    input[type="submit"]:hover {
      background: #5c3d2e;
    }
    .btn-volver {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 18px;
      background-color: #a47148;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-volver:hover {
      background-color: #8b5e3c;
    }
    .mensaje {
      font-size: 16px;
      margin-top: 20px;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1> Actualizar Email de Cliente</h1>
    <?php
     include "conexion.php";

    $registros = mysqli_query($conexion, 
      "select * from clientes where email='$_REQUEST[email]'") 
      or die("Problemas en el select:" . mysqli_error($conexion));

    if ($reg = mysqli_fetch_array($registros)) {
    ?>
      <form action="actualizar3.php" method="post">
        <label>Ingrese nuevo email:</label><br>
        <input type="text" name="mailnuevo" value="<?php echo $reg['email'] ?>"><br>
        <input type="hidden" name="mailviejo" value="<?php echo $reg['email'] ?>">
        <input type="submit" value="Modificar">
      </form>
    <?php
    } else {
      echo "<p class='mensaje'>❌ No existe cliente con dicho email.</p>";
    }
    mysqli_close($conexion);
    ?>
    <a href="../html/clientesadmin.html" class="btn-volver">⬅ Volver al inicio</a>
  </div>
</body>
</html>