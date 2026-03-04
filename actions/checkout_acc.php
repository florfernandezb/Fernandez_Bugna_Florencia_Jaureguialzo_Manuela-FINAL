<?php
require_once "../functions/autoload.php";

require_login_and_redirect("cart");

$cart = new Cart();
$items = $cart->get_carrito();

// Guardamos un resumen para mostrar en la vista de éxito
$_SESSION['last_order'] = [
    'created_at' => date('Y-m-d H:i:s'),
    'items' => $items,
    'total' => $cart->precio_total(),
    'quantity' => $cart->cantidad_total(),
];

// Vaciar carrito
$cart->clear_items();

header("Location: ../index.php?s=checkout_success");
exit;

