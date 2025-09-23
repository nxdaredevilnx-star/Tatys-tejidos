<?php
    include("conexion.php"); 

    // Cabeceras para que el navegador lo descargue como Excel
    header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=clientes.xls");

    // Consulta a tu tabla Clientes
    $clientes = "SELECT id_cliente, tipo_documento, N_documento, primer_apellido, 
                        segundo_apellido, nombres, fecha_nacimiento, direccion, 
                        telefono, email 
                 FROM Clientes";
?>
<meta charset="UTF-8">
<table border="1">
    <caption><strong>Datos de Clientes</strong></caption>
    <tr>
        <th>ID Cliente</th>
        <th>Tipo Documento</th>
        <th>N° Documento</th>
        <th>Primer Apellido</th>
        <th>Segundo Apellido</th>
        <th>Nombres</th>
        <th>Fecha Nacimiento</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Email</th>
    </tr>
    <?php
        $resultado = mysqli_query($conexion, $clientes);
        while($row = mysqli_fetch_assoc($resultado)){ ?>
            <tr>
                <td><?php echo $row["id_cliente"]; ?></td>
                <td><?php echo $row["tipo_documento"]; ?></td>
                <td><?php echo $row["N_documento"]; ?></td>
                <td><?php echo $row["primer_apellido"]; ?></td>
                <td><?php echo $row["segundo_apellido"]; ?></td>
                <td><?php echo $row["nombres"]; ?></td>
                <td><?php echo $row["fecha_nacimiento"]; ?></td>
                <td><?php echo $row["direccion"]; ?></td>
                <td><?php echo $row["telefono"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
            </tr>
    <?php } ?>
</table>
