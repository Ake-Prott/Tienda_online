<?php $titulo = "Ofertas"; include 'includes/header.php'; include 'includes/db.php'; ?>

<div class="container py-5 mt-5">
  <div class="text-center mb-5">
    <h1 class="display-4 fw-bold text-danger">Ofertas Imperdibles</h1>
    <p class="lead">Productos destacados con los mejores precios</p>
  </div>

  <div class="row g-5">
    <?php
    $stmt = $pdo->query("SELECT p.* FROM producto p JOIN producto_destacado pd ON p.id_producto = pd.id_producto");
    while($p = $stmt->fetch()):
    ?>
    <div class="col-md-6 col-lg-4">
      <div class="card card-product border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="position-relative">
          <img src="assets/img/<?= $p['imagen'] ?>" class="card-img-top" style="height:300px; object-fit:cover;">
          <div class="position-absolute top-0 end-0 m-3">
            <span class="badge bg-danger fs-5 px-3 py-2">OFERTA</span>
          </div>
        </div>
        <div class="card-body text-center p-4">
          <h4 class="fw-bold"><?= $p['nombre_producto'] ?></h4>
          <div class="precio fs-2 my-3">$<?= number_format($p['precio'],0,',','.') ?></div>
          <a href="producto-detalle.php?id=<?= $p['id_producto'] ?>" class="btn btn-gradiente w-100">Comprar Ahora</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>