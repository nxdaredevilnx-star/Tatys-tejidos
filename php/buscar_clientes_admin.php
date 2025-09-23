<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultados de Cliente</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: url(../images/background.jpg);
      margin: 0;
      padding: 0;
    }
    .container {
      width: 70%;
      margin: 30px auto;
      background: #fffdf9;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
    }
    h1 {
      text-align: center;
      color: #5c3d2e;
      margin-bottom: 25px;
    }
    .factura {
      background: #fff8f0;
      border: 2px solid #d4a373;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 20px;
      text-align: left;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .factura h2 {
      margin-top: 0;
      color: #6f4e37;
      border-bottom: 1px solid #d4a373;
      padding-bottom: 8px;
    }
    .factura p {
      margin: 8px 0;
      font-size: 15px;
    }
    .factura strong {
      color: #6f4e37;
    }
    .error {
      text-align: center;
      color: red;
      font-weight: bold;
      margin-top: 20px;
    }
    .btn-volver {
      display: inline-block;
      margin-top: 20px;
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
    <h1> Resultados de Cliente</h1>
    <?php
    include "conexion.php";

    $registros = mysqli_query($conexion, "select * from clientes where nombres like '$_REQUEST[nombres]' or N_documento = '$_REQUEST[N_documento]'") 
      or die("Problemas en el select:".mysqli_error($conexion));

    if ($reg = mysqli_fetch_array($registros)) {
      do {
        echo "<div class='factura'>";
        echo "<h2>".$reg['nombres']." ".$reg['primer_apellido']." ".$reg['segundo_apellido']."</h2>";
        echo "<p><strong>ID Cliente:</strong> ".$reg['id_cliente']."</p>";
        echo "<p><strong>Usuario:</strong> ".$reg['usuario']."</p>";
        echo "<p><strong>Documento:</strong> ".$reg['tipo_documento']." - ".$reg['N_documento']."</p>";
        echo "<p><strong>Email:</strong> ".$reg['email']."</p>";
        echo "<p><strong>Teléfono:</strong> ".$reg['telefono']."</p>";
        echo "<p><strong>Fecha de Nacimiento:</strong> ".$reg['fecha_nacimiento']."</p>";
        echo "<p><strong>direccion:</strong> ".$reg['direccion']."</p>";
        echo "</div>";
      } while ($reg = mysqli_fetch_array($registros));
    } else {
      echo "<p class='error'> No se encontró ningún cliente con esos datos.</p>";
    }

    mysqli_close($conexion);
    ?>
    <a href="../html/clientesadmin.html" class="btn-volver">⬅ Volver a Clientes</a>
  </div>
</body>
</html>