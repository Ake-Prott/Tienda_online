<?php
$host = 'localhost';
$db   = 'tienda_online';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// ====== FUNCIÓN ÚNICA Y CORRECTA (solo una vez) ======
if (!function_exists('actualizarTotalCarrito')) {
    function actualizarTotalCarrito($pdo, $id_usuario) {
        $stmt = $pdo->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $id_carrito = $stmt->fetchColumn();

        if (!$id_carrito) return;

        $stmt = $pdo->prepare("SELECT COALESCE(SUM(subtotal), 0) FROM carrito_detalle WHERE id_carrito = ?");
        $stmt->execute([$id_carrito]);
        $total = $stmt->fetchColumn();

        $pdo->prepare("UPDATE carrito SET total = ? WHERE id_carrito = ?")
            ->execute([$total, $id_carrito]);
    }
}
?>