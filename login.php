<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/conexion.php';

require_once 'includes/conexion.php';
require_once 'includes/header.php';
require_once 'includes/nav.php';

$errores = [];
$correo_guardado = $_COOKIE['recordar_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $recordar = isset($_POST['recordar']);

    if (empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
     
        $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            if (password_verify($password, $fila['password'])) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $fila['id'];
                $_SESSION['usuario_nombre'] = $fila['nombre'];

               
                if ($recordar) {
                    setcookie("recordar_email", $email, time() + (86400 * 30), "/");
                } else {
                    setcookie("recordar_email", "", time() - 3600, "/");
                }

                header("Location: panel.php");
                exit();
            } else {
                $errores[] = "Contraseña incorrecta.";
            }
        } else {
            $errores[] = "No existe un usuario con ese correo electrónico.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<main style="display: flex; justify-content: center; padding: 40px 20px;">
    <div class="formularioConte">
        <h2>Iniciar Sesión</h2>

        
        <?php if (isset($_SESSION['flash_exito'])): ?>
            <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                <?php 
                    echo htmlspecialchars($_SESSION['flash_exito']); 
                    unset($_SESSION['flash_exito']);
                ?>
            </div>
        <?php endif; ?>

       
        <?php if (!empty($errores)): ?>
            <div class="alerta-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="formuEstilo">
            <div class="grupo-input">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($correo_guardado); ?>" required>
            </div>
            
            <div class="grupo-input">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
           
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 0.9rem; color: #555;">
                <input type="checkbox" id="recordar" name="recordar" <?php echo !empty($correo_guardado) ? 'checked' : ''; ?> style="width: auto;">
                <label for="recordar" style="margin: 0; font-weight: normal; cursor: pointer;">Recordar mi correo</label>
            </div>
            
            <button type="submit" class="btnFormulario">Entrar</button>
            
            <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
                ¿No tienes cuenta? <a href="registro.php" style="color: #82e0cf; font-weight: bold; text-decoration: none;">Regístrate</a>
            </p>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>