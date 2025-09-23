<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - CoffeeCorner</title>

  <style>

body { 
          font-family: Arial, sans-serif; 
          background: #f7f3ef; 
          margin: 0; 
          padding: 20px; 
}


h1 { 
          text-align: center; 
          color: #4a2c2a; 
}


    .container-options { 
          display: flex; 
          justify-content: center; 
          gap: 15px; 
          margin: 20px 0; 
}


    .container-options span { 
          padding: 8px 15px; 
          background: #f1e0d6; 
          border-radius: 20px; 
          cursor: pointer; 
          font-size: 14px; 
          color: #4a2c2a; 
          transition: background 0.3s; 
}


.container-options span.active, .container-options span:hover { 
       background: #b85c38;  
          color: #fff; 
}

    .productos-container { 
      display: grid; 
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
      gap: 20px; 
      margin-top: 30px; 
}


    .producto-card { 
      background: #fff; 
      border-radius: 12px; 
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
      overflow: hidden; 
      transition: transform 0.2s; 
}


    .producto-card:hover { 
      transform: translateY(-5px); 
}

    .producto-card img { 
      width: 100%; 
      height: 180px; 
      object-fit: cover; 
}

    .producto-info { 
      padding: 15px;
}

    .producto-info h3 { 
      margin: 0; 
     color: #4a2c2a; 
}

    .producto-info p {
       margin: 5px 0; 
       color: #555; 
       font-size: 14px;
}

    .precio { 
      color: #b85c38; 
      font-weight: bold; 
      margin-top: 10px; 
      font-size: 16px;
}

    .categoria { 
      display: inline-block;
      padding: 5px 10px; 
      background: #f1e0d6; 
      border-radius: 20px; 
      font-size: 12px; 
      color: #4a2c2a; 
}

  </style>
  
</head>
<body>
  <h1>Menú CoffeeCorner</h1>

  <div class="container-options">
    <span class="active" data-filter="all">Todos</span>
    <span data-filter="1">Llaveros</span>
    <span data-filter="2">Ropa</span>
    <span data-filter="3">Accesorios</span>
    <span data-filter="4">Decoración de temporada</span>
    <span data-filter="5">Amigurumis</span>
  </div>

  <div class="productos-container">
    <?php

      include "conexion.php";

        $registros = mysqli_query($conexion,"SELECT id_categoria, id_proveedor, descripcion, stock, precio, photo_producto FROM productos ORDER BY id_producto DESC")  esor die("Problemas con el select: ".mysqli_error($conexion));

            while($reg = mysqli_fetch_assoc($registros)) {
                $descripcion = $reg['descripcion'];
                $img = !empty($reg['photo_producto']) ? $reg['photo_producto'] : 'placeholder.jpg';

                   echo '<div class="producto-card" data-category="'.htmlspecialchars($reg['id_categoria']).'">';
                   echo '<img src="../IMG/'. htmlspecialchars($img) .'" alt="'.htmlspecialchars($descripcion).'">';
                   echo '<div class="producto-info">';
                   echo '<h3>'.htmlspecialchars($descripcion).'</h3>'; // título del producto
                   echo '<p>Proveedor: '.htmlspecialchars($reg['id_proveedor']).'</p>';
                   echo '<p>Stock: '.htmlspecialchars($reg['stock']).'</p>';
                   echo '<p class="precio">$'.htmlspecialchars($reg['precio']).'</p>';
                   echo '<span class="categoria">Categoría: '.htmlspecialchars($reg['id_categoria']).'</span>';
                   echo '</div>';
                   echo '</div>';
                  }
            mysqli_close($conexion);
    ?>

  </div>

  <script>
    const buttons = document.querySelectorAll(".container-options span");
    const cards = document.querySelectorAll(".producto-card");

    buttons.forEach(btn => {
      btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        const filter = btn.getAttribute("data-filter");
        cards.forEach(card => {
          const cat = card.getAttribute("data-category");
          card.style.display = (filter === "all" || cat === filter) ? "block" : "none";
        });
      });
    });
  </script>
</body>
</html>