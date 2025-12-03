<?php 
$titulo = "Detalle del Producto"; 
include 'includes/header.php'; 
include 'includes/db.php';

$id = $_GET['id'] ?? 0;

// Mostrar mensaje si viene de agregar al carrito
$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = '<div class="alert alert-success alert-dismissible fade show text-center fs-5">
                    <i class="bi bi-check-circle"></i> ' . $_SESSION['mensaje'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
    unset($_SESSION['mensaje']);
}

$stmt = $pdo->prepare("SELECT p.*, c.nombre AS categoria 
                       FROM producto p 
                       LEFT JOIN categoria_producto c ON p.id_categoria = c.id_categoria 
                       WHERE p.id_producto = ?");
$stmt->execute([$id]);
$prod = $stmt->fetch();

if (!$prod) { 
  echo '<div class="container py-5 text-center"><h1 class="text-danger">Producto no encontrado</h1></div>'; 
  include 'includes/footer.php'; 
  exit; 
}
?>

<div class="container py-5 mt-5">
  <?= $mensaje ?>

  <div class="row g-5 align-items-stretch">
    <!-- Imagen del producto -->
    <div class="col-lg-6">
      <div class="position-sticky" style="top:120px;">
        <img src="assets/img/<?= $prod['imagen'] ?: 'placeholder.jpg' ?>" 
             class="img-fluid rounded-4 shadow-lg border border-5 border-white" 
             style="max-height:650px; object-fit:contain; width:100%;">
      </div>
    </div>

    <!-- Información del producto -->
    <div class="col-lg-6">
      <div class="bg-white rounded-4 shadow-lg p-5 h-100 d-flex flex-column">
        <span class="badge bg-primary fs-5 px-4 py-2 mb-3"><?= $prod['categoria'] ?? 'Sin categoría' ?></span>
        <h1 class="display-5 fw-bold mb-4"><?= htmlspecialchars($prod['nombre_producto']) ?></h1>
        
        <div class="precio fs-1 mb-4 text-primary fw-bold">$<?= number_format($prod['precio'],0,',','.') ?></div>

        <div class="bg-light rounded-4 p-4 mb-4 flex-grow-1">
          <p class="lead fs-5"><?= nl2br(htmlspecialchars($prod['descripcion'])) ?></p>
        </div>

        <div class="alert <?= $prod['stock'] > 0 ? 'alert-success' : 'alert-danger' ?> mb-4 fw-bold fs-5">
          Disponibilidad: 
          <?= $prod['stock'] > 0 ? "$prod[stock] unidades en stock" : "Producto agotado" ?>
        </div>

        <!-- Formulario para agregar al carrito -->
        <?php if($prod['stock'] > 0): ?>
        <form method="POST" action="agregar-carrito.php" class="row g-4 align-items-end">
          <div class="col-auto">
            <label class="fw-bold fs-5">Cantidad:</label>
            <input type="number" 
                   name="cantidad" 
                   class="form-control form-control-lg text-center rounded-pill shadow-sm" 
                   value="1" 
                   min="1" 
                   max="<?= $prod['stock'] ?>" 
                   style="width:140px;" 
                   required>
            <input type="hidden" name="id_producto" value="<?= $prod['id_producto'] ?>">
          </div>
          <div class="col">
            <button type="submit" class="btn btn-gradiente btn-lg w-100 rounded-pill shadow-lg fs-5">
              Agregar al Carrito
            </button>
          </div>
        </form>

        <!-- Botón alternativo más grande -->
        <div class="text-center mt-4">
          <a href="catalogo.php" class="btn btn-outline-secondary btn-lg rounded-pill px-5">
            Seguir comprando
          </a>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
          <i class="bi bi-x-circle display-1 text-danger"></i>
          <h3 class="mt-3 text-danger">Producto agotado</h3>
          <a href="catalogo.php" class="btn btn-outline-primary btn-lg mt-3">Volver al catálogo</a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Productos relacionados (opcional, puedes borrarlo si quieres) -->
  <div class="my-5 py-5">
    <h2 class="text-center display-5 fw-bold mb-5">Productos que te pueden interesar</h2>
    <div class="row g-4">
      <?php
      $rel = $pdo->prepare("SELECT * FROM producto WHERE id_categoria = ? AND id_producto != ? ORDER BY RAND() LIMIT 4");
      $rel->execute([$prod['id_categoria'], $id]);
      while($r = $rel->fetch()):
      ?>
      <div class="col-md-6 col-lg-3">
        <a href="producto-detalle.php?id=<?= $r['id_producto'] ?>" class="text-decoration-none">
          <div class="card h-100 card-product shadow-lg border-0 rounded-4 overflow-hidden">
            <img src="assets/img/<?= $r['imagen'] ?>" class="card-img-top" style="height:220px; object-fit:cover;">
            <div class="card-body text-center p-4">
              <h6 class="fw-bold"><?= htmlspecialchars($r['nombre_producto']) ?></h6>
              <div class="precio fs-4">$<?= number_format($r['precio'],0,',','.') ?></div>
            </div>
          </div>
        </a>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>