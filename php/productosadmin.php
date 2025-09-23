<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         include "conexion.php";

        mysqli_query($conexion,"insert into productos(id_categoria,id_proveedor,descripcion,stock,precio, photo_producto) values 
        ('$_REQUEST[id_categoria]','$_REQUEST[id_proveedor]','$_REQUEST[descripcion]','$_REQUEST[stock]','$_REQUEST[precio]','$_REQUEST[photo_producto]')" ) 
        or die("Problemas en el select".mysqli_error($conexion));

        mysqli_close($conexion);

       header("Location: ../html/productosadmin.html");
        

    ?>
</body>
</html>