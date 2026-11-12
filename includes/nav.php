<nav>
    
        <a href="index.php">Inicio</a>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="panel.php">Panel Privado</a>
            <a href="cierre.php">Cerrar Sesión (<?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>)</a>
        <?php else: ?>
            <a href="login.php">Iniciar Sesión</a>
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
    
</nav>