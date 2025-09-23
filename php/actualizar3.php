<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado actualización | CoffeeCorner</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image:url(../image/backdetodo.jpg);
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
    .mensaje {
      font-size: 18px;
      color: green;
      font-weight: bold;
      margin-top: 15px;
    }
    .btn-volver {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 18px;
      background-color: #6f4e37;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-volver:hover {
      background-color: #5c3d2e;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>☕ Resultado de actualización</h1>
    <?php
     include "conexion.php";

    mysqli_query($conexion, 
      "update clientes set email='$_REQUEST[mailnuevo]' 
       where email='$_REQUEST[mailviejo]'") 
      or die("Problemas en el update:" . mysqli_error($conexion));

    mysqli_close($conexion);

    echo "<p class='mensaje'>✅ El email fue modificado con éxito.</p>";
    ?>
    <a href="../html/clientesadmin.html" class="btn-volver">⬅ Volver al inicio</a>
  </div>
</body>
</html>