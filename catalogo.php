<?php 
$titulo = "Catálogo"; 
include 'includes/header.php'; 
include 'includes/db.php'; 

// Obtener filtros (solo si no están vacíos)
$busqueda = trim($_GET['busqueda'] ?? '');
$categoria = $_GET['categoria'] ?? '';
$precio_min = max(0, (float)($_GET['precio_min'] ?? 0));  // No negativos
$precio_max = (float)($_GET['precio_max'] ?? 9999);       // Valor alto si vacío

// Query base
$sql = "SELECT p.*, c.nombre AS categoria FROM producto p
        LEFT JOIN categoria_producto c ON p.id_categoria = c.id_categoria
        WHERE 1=1";  // Base siempre verdadera

$params = [];

// Filtro de precio solo si tiene sentido (min < max)
if ($precio_min > 0 || $precio_max < 9999) {
    $sql .= " AND p.precio BETWEEN ? AND ?";
    $params[] = $precio_min;
    $params[] = $precio_max;
}

// Filtro de categoría solo si no vacío
if (!empty($categoria)) {
    $sql .= " AND p.id_categoria = ?";
    $params[] = $categoria;
}

// Buscador solo si no vacío (case-insensitive)
if (!empty($busqueda)) {
    $sql .= " AND (LOWER(p.nombre_producto) LIKE LOWER(?) OR LOWER(p.descripcion) LIKE LOWER(?))";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}

$sql .= " ORDER BY p.id_producto DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$productos = $stmt->fetchAll();

// Categorías para dropdown
$categorias = $pdo->query("SELECT * FROM categoria_producto ORDER BY nombre")->fetchAll();
?>

<div class="container py-5 mt-5">
  <div class="text-center mb-5">
    <h1 class="display-4 fw-bold" style="background: linear-gradient(45deg,#00d2ff,#3a7bd5);-webkit-background-clip:text;color:transparent;">
      Catálogo Completo
    </h1>
    <p class="lead text-muted">Explora todos nuestros productos</p>
  </div>

  <!-- Buscador + Filtros SOLO en Catálogo -->
  <form method="GET" class="bg-white p-4 rounded-4 shadow-lg mb-5">
    <div class="row g-3 align-items-end">
      <div class="col-lg-4">
        <input type="text" name="busqueda" class="form-control form-control-lg rounded-pill" 
               placeholder="Buscar productos..." value="<?= htmlspecialchars($busqueda) ?>">
      </div>
      <div class="col-lg-3">
        <select name="categoria" class="form-select form-select-lg rounded-pill">
          <option value="">Todas las categorías</option>
          <?php foreach($categorias as $cat): ?>
            <option value="<?= $cat['id_categoria'] ?>" <?= $categoria == $cat['id_categoria'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-lg-2">
        <input type="number" name="precio_min" class="form-control form-control-lg rounded-pill" 
               placeholder="Mín" min="0" step="0.01" value="<?= $precio_min > 0 ? $precio_min : '' ?>">
      </div>
      <div class="col-lg-2">
        <input type="number" name="precio_max" class="form-control form-control-lg rounded-pill" 
               placeholder="Máx" min="0" step="0.01" value="<?= $precio_max < 9999 ? $precio_max : '' ?>">
      </div>
      <div class="col-lg-1">
        <button type="submit" class="btn btn-gradiente btn-lg w-100 rounded-pill">
          <i class="bi bi-funnel"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Resultados -->
  <div class="row g-4">
    <?php if(empty($productos)): ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-search display-1 text-muted mb-3"></i>
        <h3>No se encontraron productos</h3>
        <p class="text-muted">Prueba con otros términos o quita filtros.</p>
        <a href="catalogo.php" class="btn btn-gradiente">Ver todo el catálogo</a>
      </div>
    <?php else: ?>
      <?php foreach($productos as $p): ?>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <a href="producto-detalle.php?id=<?= $p['id_producto'] ?>" class="text-decoration-none">
            <div class="card h-100 card-product shadow-lg border-0 rounded-4 overflow-hidden position-relative">
              <?php if($p['stock'] <= 5): ?>
                <span class="position-absolute top-0 start-0 m-3 badge bg-danger fs-6 z-3">¡Últimas unidades!</span>
              <?php endif; ?>
              <img src="assets/img/<?= $p['imagen'] ?: 'placeholder.jpg' ?>" class="card-img-top" style="height:260px; object-fit:cover;">
              <div class="card-body d-flex flex-column p-4">
                <span class="badge bg-primary mb-2"><?= $p['categoria'] ?? 'Sin categoría' ?></span>
                <h5 class="fw-bold"><?= htmlspecialchars($p['nombre_producto']) ?></h5>
                <p class="text-muted small flex-grow-1"><?= substr(htmlspecialchars($p['descripcion']),0,90) ?>...</p>
                <div class="mt-auto text-center">
                  <div class="precio fs-3">$<?= number_format($p['precio'],0,',','.') ?></div>
                  <small class="text-success fw-bold">Stock: <?= $p['stock'] ?></small>
                </div>
              </div>
              <div class="card-footer bg-white border-0 p-3">
                <button class="btn btn-gradiente w-100 rounded-pill shadow">Ver Detalle</button>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>