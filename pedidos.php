<?php
$titulo = "Mis Pedidos";
include 'includes/header.php'; 
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT p.*, e.nombre_estado, mp.nombre_pago 
                       FROM pedido p 
                       JOIN estado_pedido e ON p.id_estado = e.id_estado
                       JOIN metodo_pago mp ON p.id_metodoPago = mp.id_metodoPago
                       WHERE p.id_usuario = ? 
                       ORDER BY p.fecha_pedido DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$pedidos = $stmt->fetchAll();
?>

<div class="container py-5 mt-5">
  <h1 class="display-4 fw-bold text-center mb-5" style="background:linear-gradient(45deg,#ff6b6b,#ee5a52);-webkit-background-clip:text;color:transparent;">
    Mis Pedidos
  </h1>

  <?php if(empty($pedidos)): ?>
    <div class="text-center py-5">
      <i class="bi bi-box-seam display-1 text-muted"></i>
      <h3 class="mt-4">Aún no tienes pedidos</h3>
      <a href="catalogo.php" class="btn btn-gradiente btn-lg mt-3">Ir a Comprar</a>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach($pedidos as $p): 
        $color = match($p['nombre_estado']) {
          'Entregado' => 'success',
          'Enviado' => 'primary',
          'Procesando' => 'warning',
          'Pendiente' => 'secondary',
          default => 'dark'
        };
      ?>
      <div class="col-lg-6">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100">
          <div class="card-header bg-<?= $color ?> text-white py-4">
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Pedido #<?= $p['id_pedido'] ?></h4>
              <span class="badge bg-white text-<?= $color ?> fs-6 px-3 py-2"><?= $p['nombre_estado'] ?></span>
            </div>
          </div>
          <div class="card-body p-4">
            <div class="row">
              <div class="col-md-6">
                <p class="mb-2"><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($p['fecha_pedido'])) ?></p>
                <p class="mb-2"><strong>Pago:</strong> <?= $p['nombre_pago'] ?></p>
              </div>
              <div class="col-md-6 text-md-end">
                <div class="precio fs-2">$<?= number_format($p['total'],0,',','.') ?></div>
              </div>
            </div>
            <hr>
            <div class="text-center">
              <small class="text-muted">Verás los productos al hacer clic</small><br>
              <a href="detalle-pedido.php?id=<?= $p['id_pedido'] ?>" class="btn btn-outline-primary rounded-pill mt-2">
                Ver Detalle Completo
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>