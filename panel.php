<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="text-align: center;">Mi Cuenta</h2>
    <p style="text-align: center; color: #555; margin-bottom: 30px;">
        Bienvenid@, <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>. Has ingresado con éxito a COOLSWAG.
    </p>

    
    <div class="contenedorDashboard">
        
      
        <div class="tarjeta">
            <h3>Perfil de Usuario</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></p>
            <p><strong>ID de Cliente:</strong> #000<?php echo htmlspecialchars($_SESSION['usuario_id']); ?></p>
            <p><strong>Estado:</strong> <span class="activoBadge">Activo</span></p>
            <br>
            <a href="index.php" class="btnDashboard">Ir a la tienda</a>
        </div>

       
        <div class="tarjeta">
            <h3>Mis Beneficios exclusivos</h3>
            <ul class="listaBenefi">
                <li>🚚 <strong>Envío Gratis:</strong> En tu próxima compra.</li>
                <li>🔥 <strong>Acceso VIP:</strong> Compras anticipadas de nuevos lanzamientos.</li>
                <li>👟 <strong>Descuento:</strong> 10% OFF en la línea Adidas Samba.</li>
            </ul>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>