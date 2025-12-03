<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id_producto = (int)($_POST['id_producto'] ?? 0);
$cantidad    = max(1, (int)($_POST['cantidad'] ?? 1));

if ($id_producto <= 0) {
    header("Location: catalogo.php");
    exit;
}

// Verificar stock
$stmt = $pdo->prepare("SELECT stock, precio FROM producto WHERE id_producto = ?");
$stmt->execute([$id_producto]);
$prod = $stmt->fetch();

if (!$prod || $prod['stock'] < $cantidad) {
    $_SESSION['mensaje'] = "Stock insuficiente";
    header("Location: producto-detalle.php?id=$id_producto");
    exit;
}

// Obtener o crear carrito
$stmt = $pdo->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$carrito = $stmt->fetch();

if (!$carrito) {
    $pdo->prepare("INSERT INTO carrito (id_usuario, total) VALUES (?, 0)")
        ->execute([$_SESSION['usuario_id']]);
    $id_carrito = $pdo->lastInsertId();
} else {
    $id_carrito = $carrito['id_carrito'];
}

// Ver si el producto ya está en el carrito
$stmt = $pdo->prepare("SELECT * FROM carrito_detalle WHERE id_carrito = ? AND id_producto = ?");
$stmt->execute([$id_carrito, $id_producto]);
$existe = $stmt->fetch();

$subtotal = $prod['precio'] * $cantidad;

if ($existe) {
    $nueva_cant = $existe['cantidad'] + $cantidad;
    $nuevo_subtotal = $prod['precio'] * $nueva_cant;

    $pdo->prepare("UPDATE carrito_detalle SET cantidad = ?, subtotal = ? WHERE id_carrito = ? AND id_producto = ?")
        ->execute([$nueva_cant, $nuevo_subtotal, $id_carrito, $id_producto]);
} else {
    $pdo->prepare("INSERT INTO carrito_detalle (id_carrito, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)")
        ->execute([$id_carrito, $id_producto, $cantidad, $prod['precio'], $subtotal]);
}

// Actualizar total del carrito
actualizarTotalCarrito($pdo, $_SESSION['usuario_id']);

$_SESSION['mensaje'] = "¡Producto agregado al carrito!";
header("Location: carrito.php");
exit;
?>