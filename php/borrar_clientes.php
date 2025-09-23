<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(../img/fondo-of.jpg); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #555;
            margin: 15px 0;
        }
        .menu {
            margin-top: 25px;
        }
        .menu a {
            text-decoration: none;
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .menu a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado de la operación</h1>
        <p>
            <?php
                 include "conexion.php";

                $registros=mysqli_query($conexion,"select * from clientes where N_documento='$_REQUEST[N_documento]'")
                or die ("problemas en el select".mysqli_error($conexion));

                if($reg=mysqli_fetch_array($registros)){
                    mysqli_query($conexion,"DELETE FROM clientes WHERE N_documento='$_REQUEST[N_documento]'")
                    or die ("problemas en el select".mysqli_error($conexion));
                    echo "✅ El cliente fue eliminado";
                }else{
                    echo "⚠ No existe el cliente a eliminar";
                }   
                mysqli_close($conexion);
            ?>    
        </p>

        <div class="menu">
            <a href="../html/clientesadmin.html">⬅ Volver al menú principal</a>
        </div>
    </div>
</body>
</html>