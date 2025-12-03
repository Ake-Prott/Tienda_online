<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $titulo ?? 'ElectroShop'; ?> - Tienda Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --gradiente: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --azul: #00d2ff;
      --morado: #3a7bd5;
    }
    body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
    .navbar { background: rgba(0,0,0,0.9) !important; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.3); }
    .card-product { border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.18); transition: all 0.4s ease; }
    .card-product:hover { transform: translateY(-20px); box-shadow: 0 30px 70px rgba(0,0,0,0.35) !important; }
    .precio { font-size: 2.2rem; font-weight: 800; background: linear-gradient(45deg, var(--azul), var(--morado)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .btn-gradiente { background: var(--gradiente); border: none; border-radius: 50px; padding: 14px 32px; font-weight: 600; color: white; box-shadow: 0 10px 30px rgba(102,126,234,0.4); transition: all 0.3s; }
    .btn-gradiente:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(102,126,234,0.6); }
    .hero { background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9)), url('https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=1920') center/cover; height: 90vh; display: flex; align-items: center; color: white; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fs-2 fw-bold" href="index.php">ElectroShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav mx-auto fs-5">
        <li class="nav-item"><a class="nav-link px-4" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link px-4" href="catalogo.php">Catálogo</a></li>
        <li class="nav-item"><a class="nav-link px-4" href="destacados.php">Ofertas</a></li>
        <li class="nav-item"><a class="nav-link px-4" href="nosotros.php">Nosotros</a></li>
      </ul>
      <div class="d-flex gap-3 align-items-center">
        <?php if(isset($_SESSION['usuario_id'])): ?>
          <div class="dropdown">
            <a class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
              Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="perfil.php">Mi Perfil</a></li>
              <li><a class="dropdown-item" href="carrito.php">Mi Carrito</a></li>
              <li><a class="dropdown-item" href="pedidos.php">Mis Pedidos</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php">Cerrar Sesión</a></li>
            </ul>
          </div>
          <a href="carrito.php" class="btn btn-danger position-relative">
            <i class="bi bi-cart4 fs-4"></i>
            <?php
            if(isset($_SESSION['usuario_id'])) {
              include 'includes/db.php';
              $stmt = $pdo->prepare("SELECT SUM(cantidad) FROM carrito_detalle cd JOIN carrito c ON cd.id_carrito = c.id_carrito WHERE c.id_usuario = ?");
              $stmt->execute([$_SESSION['usuario_id']]);
              $total = $stmt->fetchColumn() ?: 0;
              if($total > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-danger"><?= $total ?></span>
              <?php endif; }
            ?>
          </a>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-light">Login</a>
          <a href="registro.php" class="btn btn-gradiente">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="pt-5"></div>