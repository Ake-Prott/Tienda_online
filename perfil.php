<?php
$titulo = "Mi Perfil";
include 'includes/header.php'; 
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$mensaje = '';
$editando = false;

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']);
    $apellido  = trim($_POST['apellido']);
    $telefono  = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $pass_nueva = $_POST['pass_nueva'] ?? '';
    $pass_confirm = $_POST['pass_confirm'] ?? '';

    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion)) {
        $mensaje = '<div class="alert alert-danger">Todos los campos son obligatorios</div>';
    } elseif ($pass_nueva !== '' && strlen($pass_nueva) < 6) {
        $mensaje = '<div class="alert alert-danger">La contraseña debe tener al menos 6 caracteres</div>';
    } elseif ($pass_nueva !== $pass_confirm) {
        $mensaje = '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
    } else {
        $sql = "UPDATE usuario SET nombre = ?, apellido = ?, telefono = ?, dirrecion = ? WHERE id_usuario = ?";
        $params = [$nombre, $apellido, $telefono, $direccion, $id];

        if ($pass_nueva !== '') {
            $sql = "UPDATE usuario SET nombre = ?, apellido = ?, telefono = ?, dirrecion = ?, contraseña = ? WHERE id_usuario = ?";
            $params[] = $pass_nueva;
        }

        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            $mensaje = '<div class="alert alert-success text-center fs-5">¡Datos actualizados correctamente!</div>';
            $_SESSION['usuario_nombre'] = $nombre;
        } else {
            $mensaje = '<div class="alert alert-danger">Error al guardar</div>';
        }
    }
}

// Si viene del botón "Editar"
if (isset($_GET['editar'])) {
    $editando = true;
}

// Cargar datos del usuario
$stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

// Estadísticas
$stmt = $pdo->prepare("SELECT COUNT(*) FROM pedido WHERE id_usuario = ?");
$stmt->execute([$id]);
$total_pedidos = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COALESCE(SUM(total), 0) FROM pedido WHERE id_usuario = ?");
$stmt->execute([$id]);
$total_gastado = $stmt->fetchColumn();
?>

<div class="container py-5 mt-5 min-vh-100">

  <?= $mensaje ?>

  <?php if ($editando): // =================== MODO EDICIÓN =================== ?>
    
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-header text-white text-center py-4" style="background:var(--gradiente);">
            <h3>Editar Mis Datos</h3>
          </div>
          <div class="card-body p-5">
            <form method="POST">
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="fw-bold">Nombre</label>
                  <input type="text" name="nombre" class="form-control form-control-lg rounded-pill" 
                         value="<?= htmlspecialchars($user['nombre']) ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="fw-bold">Apellido</label>
                  <input type="text" name="apellido" class="form-control form-control-lg rounded-pill" 
                         value="<?= htmlspecialchars($user['apellido']) ?>" required>
                </div>
                <div class="col-12">
                  <label class="fw-bold">Email (no editable)</label>
                  <input type="email" class="form-control form-control-lg rounded-pill bg-light" 
                         value="<?= htmlspecialchars($user['email']) ?>" disabled>
                </div>
                <div class="col-md-6">
                  <label class="fw-bold">Teléfono</label>
                  <input type="text" name="telefono" class="form-control form-control-lg rounded-pill" 
                         value="<?= htmlspecialchars($user['telefono']) ?>" required>
                </div>
                <div class="col-12">
                  <label class="fw-bold">Dirección completa</label>
                  <textarea name="direccion" class="form-control rounded-4" rows="4" required><?= htmlspecialchars($user['dirrecion']) ?></textarea>
                </div>

                <hr class="my-4">
                <div class="col-12">
                  <small class="text-muted">Cambiar contraseña (opcional)</small>
                </div>
                <div class="col-md-6">
                  <input type="password" name="pass_nueva" class="form-control form-control-lg rounded-pill" placeholder="Nueva contraseña">
                </div>
                <div class="col-md-6">
                  <input type="password" name="pass_confirm" class="form-control form-control-lg rounded-pill" placeholder="Confirmar contraseña">
                </div>

                <div class="col-12 text-center mt-4">
                  <button type="submit" class="btn btn-gradiente btn-lg px-5 rounded-pill shadow-lg">
                    Guardar Cambios
                  </button>
                  <a href="perfil.php" class="btn btn-outline-secondary btn-lg px-5 rounded-pill ms-3">
                    Cancelar
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <?php else: // =================== MODO VER DATOS (normal) =================== ?>

    <!-- Avatar y saludo -->
    <div class="text-center mb-5">
      <div class="position-relative d-inline-block">
        <div class="bg-gradient rounded-circle p-3 shadow-lg" style="background:var(--gradiente);">
          <i class="bi bi-person-circle text-white" style="font-size: 6rem;"></i>
        </div>
        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-5 border-white" style="width:40px;height:40px;"></span>
      </div>
      <h1 class="display-4 fw-bold mt-4" style="background: linear-gradient(135deg,#667eea,#764ba2);-webkit-background-clip:text;color:transparent;">
        ¡Hola, <?= htmlspecialchars($user['nombre']) ?>!
      </h1>
      <p class="lead text-muted">Este es tu espacio personal</p>
    </div>

    <!-- Estadísticas -->
    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="card border-0 shadow text-center p-4 hover-lift rounded-4">
          <i class="bi bi-bag-check-fill display-4 text-primary"></i>
          <h3 class="mt-3 fw-bold"><?= $total_pedidos ?></h3>
          <p>Pedidos realizados</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow text-center p-4 hover-lift rounded-4">
          <i class="bi bi-currency-dollar display-4 text-success"></i>
          <h3 class="mt-3 fw-bold">$<?= number_format($total_gastado,0,',','.') ?></h3>
          <p>Total gastado</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow text-center p-4 hover-lift rounded-4 text-white" style="background:var(--gradiente);">
          <i class="bi bi-star-fill display-4"></i>
          <h3 class="mt-3 fw-bold">VIP</h3>
          <p>Cliente Premium</p>
        </div>
      </div>
    </div>

    <!-- Datos del usuario -->
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header text-white text-center py-4" style="background:var(--gradiente);">
            <h4>Mis Datos Personales</h4>
          </div>
          <div class="card-body p-5">
            <div class="row g-4">
              <div class="col-md-6"><strong>Nombre:</strong> <span class="fs-5"><?= htmlspecialchars($user['nombre'].' '.$user['apellido']) ?></span></div>
              <div class="col-md-6"><strong>Email:</strong> <span class="fs-5"><?= htmlspecialchars($user['email']) ?></span></div>
              <div class="col-md-6"><strong>Teléfono:</strong> <span class="fs-5"><?= htmlspecialchars($user['telefono']) ?></span></div>
              <div class="col-12"><strong>Dirección:</strong> <div class="fs-5 mt-2"><?= nl2br(htmlspecialchars($user['dirrecion'])) ?></div></div>
            </div>
            <div class="text-center mt-5">
              <a href="?editar=1" class="btn btn-gradiente btn-lg px-5 py-3 rounded-pill shadow-lg">
                Editar mis datos
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Accesos rápidos -->
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <a href="pedidos.php" class="btn btn-outline-primary btn-lg rounded-pill">Mis Pedidos</a>
          <a href="carrito.php" class="btn btn-outline-danger btn-lg rounded-pill">Mi Carrito</a>
          <a href="catalogo.php" class="btn btn-gradiente btn-lg rounded-pill shadow">Seguir Comprando</a>
          <a href="logout.php" class="btn btn-outline-dark btn-lg rounded-pill">Cerrar Sesión</a>
        </div>
      </div>
    </div>

  <?php endif; ?>
</div>

<style>
  .hover-lift:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.2)!important; transition: all 0.3s; }
</style>

<?php include 'includes/footer.php'; ?>
