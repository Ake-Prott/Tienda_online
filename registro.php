<?php
$titulo = "Crear Cuenta";
include 'includes/header.php';
include 'includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $contraseña = $_POST['contraseña'];
    $confirmar = $_POST['confirmar'];
    $telefono = $_POST['telefono'];
    $direccion = trim($_POST['direccion']);

    if ($contraseña !== $confirmar) {
        $mensaje = '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
    } elseif (strlen($contraseña) < 6) {
        $mensaje = '<div class="alert alert-danger">La contraseña debe tener al menos 6 caracteres</div>';
    } else {
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $mensaje = '<div class="alert alert-warning">Este email ya está registrado</div>';
        } else {
            $sql = "INSERT INTO usuario (nombre, apellido, email, contraseña, telefono, dirrecion) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nombre, $apellido, $email, $contraseña, $telefono, $direccion])) {
                $mensaje = '<div class="alert alert-success text-center fs-5">
                                ¡Cuenta creada con éxito!<br>
                                <a href="login.php" class="btn btn-gradiente mt-3">Iniciar Sesión Ahora</a>
                            </div>';
            } else {
                $mensaje = '<div class="alert alert-danger">Error al registrar. Intenta de nuevo.</div>';
            }
        }
    }
}
?>

<div class="container py-5 mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header text-white text-center py-5" style="background:var(--gradiente);">
          <i class="bi bi-person-add display-1"></i>
          <h2 class="mt-3 fw-bold">Crear Cuenta Nueva</h2>
          <p class="lead">Únete a miles de clientes felices</p>
        </div>
        
        <div class="card-body p-5">
          <?= $mensaje ?>

          <form method="POST" class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nombre</label>
              <input type="text" name="nombre" class="form-control form-control-lg rounded-pill" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Apellido</label>
              <input type="text" name="apellido" class="form-control form-control-lg rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Email</label>
              <input type="email" name="email" class="form-control form-control-lg rounded-pill" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Contraseña</label>
              <input type="password" name="contraseña" class="form-control form-control-lg rounded-pill" required minlength="6">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Confirmar Contraseña</label>
              <input type="password" name="confirmar" class="form-control form-control-lg rounded-pill" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Teléfono</label>
              <input type="text" name="telefono" class="form-control form-control-lg rounded-pill" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Dirección completa</label>
              <textarea name="direccion" class="form-control form-control-lg rounded-4" rows="3" required></textarea>
            </div>

            <div class="col-12 text-center mt-5">
              <button type="submit" class="btn btn-gradiente btn-lg px-5 py-3 fs-5 rounded-pill shadow-lg">
                Crear Mi Cuenta
              </button>
            </div>
          </form>

          <p class="text-center mt-4 text-muted">
            ¿Ya tienes cuenta? <a href="login.php" class="fw-bold text-primary">Inicia sesión aquí</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?-php include 'includes/footer.php'; ?>