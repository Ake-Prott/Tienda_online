<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Cargar items del carrito
$stmt = $pdo->prepare("
    SELECT cd.*, p.stock
    FROM carrito_detalle cd
    JOIN carrito c ON cd.id_carrito = c.id_carrito
    JOIN producto p ON cd.id_producto = p.id_producto
    WHERE c.id_usuario = ?
");
$stmt->execute([$_SESSION['usuario_id']]);
$items = $stmt->fetchAll();

if (empty($items)) {
    header("Location: carrito.php");
    exit;
}

$total = array_sum(array_column($items, 'subtotal'));

try {
    $pdo->beginTransaction();

    // Crear pedido
    $metodo_pago = $_POST['metodo_pago'] ?? 1; // 1 = Tarjeta por defecto
    $stmt = $pdo->prepare("INSERT INTO pedido 
        (id_usuario, fecha_pedido, total, id_estado, id_metodoPago) 
        VALUES (?, NOW(), ?, 1, $metodo_pago)");
    $stmt->execute([$_SESSION['usuario_id'], $total]);
    $id_pedido = $pdo->lastInsertId();

    // Guardar detalle del pedido en historial_pedidos y restar stock
    $insert = $pdo->prepare("INSERT INTO historial_pedidos 
        (id_pedido, id_producto, cantidad, precio_unitario, subtotal) 
        VALUES (?, ?, ?, ?, ?)");
    $restar = $pdo->prepare("UPDATE producto SET stock = stock - ? WHERE id_producto = ?");

    foreach ($items as $item) {
        $insert->execute([
            $id_pedido,
            $item['id_producto'],
            $item['cantidad'],
            $item['precio_unitario'],
            $item['subtotal']
        ]);
        $restar->execute([$item['cantidad'], $item['id_producto']]);
    }

    // Vaciar carrito
    $pdo->prepare("DELETE FROM carrito_detalle WHERE id_carrito = (
        SELECT id_carrito FROM carrito WHERE id_usuario = ?
    )")->execute([$_SESSION['usuario_id']]);

    actualizarTotalCarrito($pdo, $_SESSION['usuario_id']);

    $pdo->commit();

    $_SESSION['mensaje'] = "¡Pedido #$id_pedido realizado con éxito! Gracias por tu compra";
    header("Location: pedidos.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al procesar el pago: " . $e->getMessage());
}
?>