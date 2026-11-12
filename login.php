<?php
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
        // Consulta preparada para login
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

                // Gestión de la superglobal $_COOKIE
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

<main>
    <h2>Iniciar Sesión</h2>

    <!-- Mensaje Flash procedente de Registro -->
    <?php if (isset($_SESSION['flash_exito'])): ?>
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <?php 
                echo htmlspecialchars($_SESSION['flash_exito']); 
                unset($_SESSION['flash_exito']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($correo_guardado); ?>" required>
        </div>
        <br>
        <div>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <div>
            <input type="checkbox" id="recordar" name="recordar" <?php echo !empty($correo_guardado) ? 'checked' : ''; ?>>
            <label for="recordar">Recordar mi correo en este navegador</label>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>