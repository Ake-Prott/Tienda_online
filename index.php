<?php $titulo = "Inicio"; include 'includes/header.php'; include 'includes/db.php'; ?>

<div class="hero text-center">
  <div class="container">
    <h1 class="display-1 fw-bold mb-4">ElectroShop</h1>
    <p class="lead fs-2 mb-5">Tecnología, moda y hogar al mejor precio</p>
    
    <!-- Buscador SOLO en Inicio -->
    <form action="catalogo.php" method="GET" class="d-flex justify-content-center mb-5" style="max-width: 700px; margin: 0 auto;">
      <input type="text" name="busqueda" class="form-control form-control-lg rounded-pill shadow-lg me-2" 
             placeholder="Buscar productos..." style="height: 65px; font-size: 1.2rem;">
      <button type="submit" class="btn btn-gradiente btn-lg rounded-pill px-5 shadow-lg">
        <i class="bi bi-search fs-4"></i> Buscar
      </button>
    </form>
    
    <a href="catalogo.php" class="btn btn-gradiente btn-lg px-5 py-4 fs-4">COMPRAR AHORA</a>
  </div>
</div>

<div class="container py-5">
  <h2 class="display-5 text-center fw-bold mb-5">Productos Destacados</h2>
  <div class="row g-4">
    <?php
    $stmt = $pdo->query("SELECT p.*, c.nombre AS categoria FROM producto p
                         JOIN producto_destacado pd ON p.id_producto = pd.id_producto
                         LEFT JOIN categoria_producto c ON p.id_categoria = c.id_categoria");
    while($p = $stmt->fetch()):
    ?>
    <div class="col-md-6 col-lg-4 col-xl-3">
      <a href="producto-detalle.php?id=<?= $p['id_producto'] ?>" class="text-decoration-none">
        <div class="card h-100 card-product">
          <img src="assets/img/<?= $p['imagen'] ?>" class="card-img-top" style="height:280px; object-fit:cover;">
          <div class="card-body d-flex flex-column text-center p-4">
            <span class="badge bg-danger fs-6 mb-3">OFERTA</span>
            <h5 class="fw-bold"><?= $p['nombre_producto'] ?></h5>
            <p class="text-muted small"><?= $p['categoria'] ?></p>
            <div class="precio mt-auto">$<?= number_format($p['precio'],0,',','.') ?></div>
          </div>
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>