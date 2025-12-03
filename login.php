<?php
session_start();
$titulo = "Iniciar Sesión";
include 'includes/header.php';
include 'includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['contraseña'];

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $pass === $user['contraseña']) {
        $_SESSION['usuario_id']     = $user['id_usuario'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        header("Location: index.php");
        exit;
    } else {
        $mensaje = '<div class="alert alert-danger text-center">Email o contraseña incorrectos</div>';
    }
}
?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header text-white text-center py-5" style="background:var(--gradiente);">
                    <i class="bi bi-person-circle display-1"></i>
                    <h2 class="mt-3">Bienvenido de vuelta</h2>
                </div>
                <div class="card-body p-5">
                    <?= $mensaje ?>
                    <form method="POST">
                        <div class="mb-4">
                            <input type="email" name="email" class="form-control form-control-lg rounded-pill" 
                                   placeholder="Email" required autofocus>
                        </div>
                        <div class="mb-4">
                            <input type="password" name="contraseña" class="form-control form-control-lg rounded-pill" 
                                   placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-gradiente btn-lg w-100 rounded-pill shadow-lg">
                            Iniciar Sesión
                        </button>
                    </form>
                    <p class="text-center mt-4 text-muted">
                        ¿No tienes cuenta? <a href="registro.php" class="fw-bold text-primary">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>