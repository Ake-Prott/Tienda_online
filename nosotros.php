<?php $titulo = "Nosotros - ElectroShop"; include 'includes/header.php'; ?>

<div class="container py-5 mt-5 min-vh-100">
  <!-- Hero Nosotros -->
  <div class="text-center mb-5 pt-5">
    <h1 class="display-3 fw-bold mb-4" style="background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; color: transparent;">
      ElectroShop
    </h1>
    <p class="lead fs-3 text-muted">Tu tienda tecnológica de confianza desde 2025</p>
  </div>

  <div class="row g-5 align-items-center mb-5">
    <div class="col-lg-6">
      <div class="p-5 bg-white rounded-4 shadow-lg">
        <h2 class="fw-bold mb-4 text-primary">¿Quiénes Somos?</h2>
        <p class="fs-5 text-muted lh-lg">
          Somos una tienda online mexicana líder en tecnología, gaming, hogar inteligente y accesorios premium. 
          Nacimos en 2025 con un solo objetivo: llevar los mejores productos del mundo a tu puerta con precios justos, 
          envíos ultra-rápidos y una experiencia de compra inolvidable.
        </p>
        <p class="fs-5 text-muted lh-lg">
          Hoy, miles de clientes en todo México confían en nosotros porque no solo vendemos productos… 
          <strong>vendemos confianza, calidad y felicidad tecnológica</strong>.
        </p>
      </div>
    </div>
    <div class="col-lg-6">
      <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800" 
           alt="Equipo ElectroShop" class="img-fluid rounded-4 shadow-lg">
    </div>
  </div>

  <!-- Misión y Visión -->
  <div class="row g-5 my-5">
    <div class="col-md-6">
      <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white text-center py-5">
          <i class="bi bi-rocket-takeoff-fill display-4"></i>
          <h3 class="mt-3">Misión</h3>
        </div>
        <div class="card-body p-5 bg-gradient" style="background: linear-gradient(135deg, #f0f2ff, #e0e7ff);">
          <p class="fs-5 text-dark lh-lg">
            Ofrecer la mejor experiencia de compra online en tecnología, 
            con productos de calidad mundial, precios honestos, variedad de productos y envios rapidos.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
        <div class="card-header text-white text-center py-5" style="background: linear-gradient(135deg, #667eea, #764ba2);">
          <i class="bi bi-binoculars-fill display-4"></i>
          <h3 class="mt-3">Visión</h3>
        </div>
        <div class="card-body p-5 bg-gradient" style="background: linear-gradient(135deg, #f5e6ff, #e8daff);">
          <p class="fs-5 text-dark lh-lg">
            Ser la tienda online #1 de tecnología en México para 2030, 
            reconocida por innovación, sostenibilidad y por hacer que la vida más fácil y divertida a millones de personas.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Valores -->
  <div class="my-5">
    <h2 class="text-center display-5 fw-bold mb-5">Nuestros Valores</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="text-center p-4 bg-white rounded-4 shadow hover-lift">
          <i class="bi bi-shield-check text-success display-4 mb-3"></i>
          <h5 class="fw-bold">Confianza</h5>
          <p class="text-muted">Trabajamos con transparencia y compromiso, con productos originales.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="text-center p-4 bg-white rounded-4 shadow hover-lift">
          <i class="bi bi-lightning-charge-fill text-warning display-4 mb-3"></i>
          <h5 class="fw-bold">Velocidad</h5>
          <p class="text-muted">Envíos el mismo día en CDMX y 24-48h al interior de la república.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="text-center p-4 bg-white rounded-4 shadow hover-lift">
          <i class="bi bi-heart-fill text-danger display-4 mb-3"></i>
          <h5 class="fw-bold">Pasión</h5>
          <p class="text-muted">Amamos la tecnología y te ayudamos a elegir lo que realmente necesitas.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Qué nos diferencia -->
  <div class="my-5 py-5 bg-dark text-white rounded-4 overflow-hidden position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
         style="background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1500') center/cover;"></div>
    <div class="container position-relative">
      <h2 class="text-center display-4 fw-bold mb-5">¿Qué nos hace diferentes?</h2>
      <div class="row g-5 text-center">
        <div class="col-md-3">
          <h1 class="display-1 fw-bold text-primary">24h</h1>
          <p class="fs-5">Entrega express en las principales ciudades</p>
        </div>
        <div class="col-md-3">
          <h1 class="display-1 fw-bold text-success">100%</h1>
          <p class="fs-5">Productos originales con garantía oficial</p>
        </div>
        <div class="col-md-3">
          <h1 class="display-1 fw-bold text-warning">7 días</h1>
          <p class="fs-5">Devoluciones gratis si no te enamora</p>
        </div>
        <div class="col-md-3">
          <h1 class="display-1 fw-bold text-info">24/7</h1>
          <p class="fs-5">Soporte humano real, no bots</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Llamado final -->
  <div class="text-center py-5">
    <h3 class="fw-bold mb-4">¿Listo para vivir la experiencia ElectroShop?</h3>
    <a href="catalogo.php" class="btn btn-gradiente btn-lg px-5 py-3 fs-4 rounded-pill shadow-lg">
      Explora Nuestro Catálogo
    </a>
  </div>
</div>

<style>
  .hover-lift {
    transition: all 0.4s ease;
  }
  .hover-lift:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.25) !important;
  }
</style>

<?php include 'includes/footer.php'; ?>