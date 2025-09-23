<?php
// procesar_pedido.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['confirm'])) {
    $cart = !empty($_SESSION['cart_temp']) ? $_SESSION['cart_temp'] : [];
    if (empty($cart)) {
        echo "No hay items para procesar. <a href='index.html'>Volver</a>";
        exit;
    }

    // Aquí podrías: conectar a BD e insertar pedido + detalles (productos).
    // Ejemplo simulado:
    $orderId = time(); // id de prueba
    // limpiar carrito temporal
    unset($_SESSION['cart_temp']);
    // redirigir a página de gracias
    header("Location: gracias.php?order_id={$orderId}");
    exit;
} else {
    header("Location: index.html");
    exit;
}
