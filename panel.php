<?php
require_once 'includes/header.php';

// Protección de ruta privada
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/nav.php';
?>

<main>
    <h2>Panel Privado</h2>
    <p>¡Hola, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>! Has ingresado con éxito al área protegida.</p>
</main>

<?php require_once 'includes/footer.php'; ?>