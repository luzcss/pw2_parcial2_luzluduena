<?php
// 1. Iniciar sesión e incluir la conexión
session_start();
require_once 'includes/conexion.php';

$errores = [];

// Recuperar Cookie de "Recordarme" si existe
$correo_guardado = isset($_COOKIE['recordar_email']) ? $_COOKIE['recordar_email'] : '';

// 2. Procesar el formulario cuando el usuario presiona "Entrar"
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['correo'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $recordar = isset($_POST['recordar']);

    if (empty($correo) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
        // Consulta preparada para evitar Inyección SQL
        $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $correo);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($fila = mysqli_fetch_assoc($resultado)) {
                // Verificar la contraseña encriptada
                if (password_verify($password, $fila['password'])) {
                    
                    // Regenerar ID de sesión por seguridad
                    session_regenerate_id(true);
                    $_SESSION['usuario_id'] = $fila['id'];
                    $_SESSION['usuario_nombre'] = $fila['nombre'];

                    // Guardar o eliminar Cookie "Recordarme" por 30 días
                    if ($recordar) {
                        setcookie("recordar_email", $correo, time() + (86400 * 30), "/");
                    } else {
                        setcookie("recordar_email", "", time() - 3600, "/");
                    }

                    // Redirigir al panel privado
                    header("Location: panel.php");
                    exit();
                } else {
                    $errores[] = "La contraseña es incorrecta.";
                }
            } else {
                $errores[] = "No existe un usuario registrado con ese correo.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $errores[] = "Error al conectar con la base de datos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <main>
        <h2>Iniciar Sesión</h2>

        <!-- Mensaje de éxito si viene desde el registro -->
        <?php if (isset($_SESSION['flash_exito'])): ?>
            <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px;">
                <?php 
                    echo htmlspecialchars($_SESSION['flash_exito']); 
                    unset($_SESSION['flash_exito']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Listado de Errores -->
        <?php if (!empty($errores)): ?>
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div>
                <label for="correo">Correo Electrónico:</label><br>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo_guardado); ?>" required>
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

        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </main>
</body>
</html>