<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Privado</title>
</head>
<body>
    <main>
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</h1>
        <p>Has iniciado sesión correctamente en la zona privada del sistema.</p>
        
        <hr>
        
        <p><a href="cierre.php">Cerrar Sesión</a></p>
    </main>
</body>
</html>