<?php
session_start();
$titulo = "Mi Carrito";
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// === ELIMINAR PRODUCTO ===
if (isset($_GET['eliminar'])) {
    $id_detalle = (int)$_GET['eliminar'];
    $pdo->prepare("DELETE cd FROM carrito_detalle cd
                   JOIN carrito c ON cd.id_carrito = c.id_carrito
                   WHERE cd.id_carrito_detalle = ? AND c.id_usuario = ?")
        ->execute([$id_detalle, $_SESSION['usuario_id']]);
    actualizarTotalCarrito($pdo, $_SESSION['usuario_id']);
    $_SESSION['mensaje'] = "Producto eliminado";
    header("Location: carrito.php");
    exit;
}

// === ACTUALIZAR CANTIDADES ===
if (isset($_POST['actualizar'])) {
    foreach ($_POST['cantidad'] as $id_detalle => $cant) {
        $cant = (int)$cant;
        $id_detalle = (int)$id_detalle;

        if ($cant <= 0) {
            $pdo->prepare("DELETE cd FROM carrito_detalle cd
                           JOIN carrito c ON cd.id_carrito = c.id_carrito
                           WHERE cd.id_carrito_detalle = ? AND c.id_usuario = ?")
                ->execute([$id_detalle, $_SESSION['usuario_id']]);
        } else {
            // Verificar stock actualizado
            $stmt = $pdo->prepare("SELECT p.stock FROM carrito_detalle cd
                                   JOIN producto p ON cd.id_producto = p.id_producto
                                   WHERE cd.id_carrito_detalle = ?");
            $stmt->execute([$id_detalle]);
            $stock_actual = $stmt->fetchColumn();

            if ($cant > $stock_actual) $cant = $stock_actual;

            $pdo->prepare("UPDATE carrito_detalle cd
                           JOIN producto p ON cd.id_producto = p.id_producto
                           SET cd.cantidad = ?, cd.subtotal = cd.precio_unitario * ?
                           WHERE cd.id_carrito_detalle = ? AND cd.id_carrito IN (SELECT id_carrito FROM carrito WHERE id_usuario = ?)")
                ->execute([$cant, $cant, $id_detalle, $_SESSION['usuario_id']]);
        }
    }
    actualizarTotalCarrito($pdo, $_SESSION['usuario_id']);
    $_SESSION['mensaje'] = "Carrito actualizado";
    header("Location: carrito.php");
    exit;
}

// === CARGAR ITEMS DEL CARRITO ===
$stmt = $pdo->prepare("
    SELECT cd.id_carrito_detalle, cd.cantidad, cd.precio_unitario, cd.subtotal,
           p.nombre_producto, p.imagen, p.stock
    FROM carrito_detalle cd
    JOIN carrito c ON cd.id_carrito = c.id_carrito
    JOIN producto p ON cd.id_producto = p.id_producto
    WHERE c.id_usuario = ?
");
$stmt->execute([$_SESSION['usuario_id']]);
$items = $stmt->fetchAll();

$total = array_sum(array_column($items, 'subtotal'));
?>

<div class="container py-5 mt-5 min-vh-100">
    <h1 class="display-4 fw-bold text-center mb-5" style="background:linear-gradient(45deg,#ff6b6b,#ee5a52);-webkit-background-clip:text;color:transparent;">
        Mi Carrito de Compras
    </h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success text-center"><?= $_SESSION['mensaje'] ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h3>Tu carrito está vacío</h3>
            <a href="catalogo.php" class="btn btn-gradiente btn-lg">Ir a Comprar</a>
        </div>
    <?php else: ?>
        <form method="POST">
            <div class="row g-5">
                <div class="col-lg-8">
                    <?php foreach ($items as $item): ?>
                        <div class="card mb-4 shadow-lg border-0 rounded-4">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3">
                                    <img src="assets/img/<?= $item['imagen'] ?: 'placeholder.jpg' ?>" class="img-fluid rounded-start" style="height:200px;object-fit:cover;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h4 class="fw-bold"><?= htmlspecialchars($item['nombre_producto']) ?></h4>
                                        <p class="text-muted">Precio: $<?= number_format($item['precio_unitario'],0,',','.') ?></p>
                                        <div class="d-flex align-items-center gap-3 my-3">
                                            <input type="number" name="cantidad[<?= $item['id_carrito_detalle'] ?>]"
                                                   value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['stock'] ?>"
                                                   class="form-control" style="width:100px;">
                                            <button type="submit" name="actualizar" class="btn btn-outline-primary">Actualizar</button>
                                            <a href="?eliminar=<?= $item['id_carrito_detalle'] ?>" class="btn btn-danger">Eliminar</a>
                                        </div>
                                        <div class="fs-4 text-primary fw-bold">
                                            Subtotal: $<?= number_format($item['subtotal'],0,',','.') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 rounded-4 sticky-top" style="top:120px;">
                        <div class="card-header text-white text-center py-4" style="background:var(--gradiente);">
                            <h3>Resumen del Pedido</h3>
                        </div>
                        <div class="card-body p-5 text-center">
                            <h2 class="text-primary fw-bold">$<?= number_format($total,0,',','.') ?></h2>
                            <button type="submit" formaction="checkout.php" class="btn btn-success btn-lg w-100 rounded-pill py-3">
                                Proceder al Pago
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>