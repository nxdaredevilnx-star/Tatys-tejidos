<?php
// checkout.php
session_start();

$cart = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['cart_json'])) {
        $json = $_POST['cart_json'];
        $cart = json_decode($json, true);
        // guardamos en sesión por si el usuario confirma
        $_SESSION['cart_temp'] = $cart;
    }
} else {
    // si no viene por POST, intentamos leer de sesión
    if (!empty($_SESSION['cart_temp'])) {
        $cart = $_SESSION['cart_temp'];
    }
}

function money($n){ return number_format((float)$n, 2, '.', ''); }

$total = 0.0;
foreach ($cart as $item) {
    $total += floatval($item['price']) * intval($item['qty']);
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout</title>
  <link rel="stylesheet" href="./css/style.css">
  <style>
    body{font-family:Verdana, Geneva, Tahoma, sans-serif;padding:20px;}
    table{width:100%;border-collapse:collapse}
    th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
    .total{font-weight:bold;font-size:1.2rem}
    .actions{margin-top:12px}
  </style>
</head>
<body>
  <h2>Resumen del pedido</h2>

  <?php if (empty($cart)): ?>
    <p>Tu carrito está vacío. <a href="index.html">Volver a la tienda</a></p>
  <?php else: ?>
    <table>
      <thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th></tr></thead>
      <tbody>
        <?php foreach ($cart as $it): 
          $sub = floatval($it['price']) * intval($it['qty']);
          $total = $total; // ya calculado arriba
        ?>
          <tr>
            <td><?php echo htmlspecialchars($it['name']); ?></td>
            <td>$<?php echo money($it['price']); ?></td>
            <td><?php echo intval($it['qty']); ?></td>
            <td>$<?php echo money($sub); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p class="total">Total: $<?php echo money($total); ?></p>

    <div class="actions">
      <!-- formulario para confirmar (podrías enviar a procesar_pedido.php que guarde en DB) -->
      <form method="POST" action="./procesar_pedido.php">
        <input type="hidden" name="confirm" value="1">
        <button type="submit" style="padding:8px 12px;background:#e84393;color:white;border:none;border-radius:6px;cursor:pointer;">
          Confirmar pedido
        </button>
      </form>
      <a href="./index.html" style="margin-left:12px">Seguir comprando</a>
    </div>
  <?php endif; ?>
</body>
</html>
