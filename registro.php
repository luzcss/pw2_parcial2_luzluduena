<?php
require_once 'includes/conexion.php';
require_once 'includes/header.php';
require_once 'includes/nav.php';

$errores = [];
$nombre = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if (empty($nombre) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }

    if (empty($errores)) {
       
        $sql_check = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);    
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errores[] = "El correo electrónico ya se encuentra registrado.";
        }
        mysqli_stmt_close($stmt_check);
    }

    if (empty($errores)) {
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "sss", $nombre, $email, $password_hash);

        if (mysqli_stmt_execute($stmt_insert)) {
            $_SESSION['flash_exito'] = "¡Registro exitoso! Ya puedes iniciar sesión.";
            header("Location: login.php");
            exit();
        } else {
            $errores[] = "Error al registrar el usuario en la base de datos.";
        }
        mysqli_stmt_close($stmt_insert);
    }
}
?>

<main style="display: flex; justify-content: center; padding: 40px 20px;">
    <div class="formularioConte">
        <h2>Crear Cuenta</h2>

        <?php if (!empty($errores)): ?>
            <div class="alerta-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="registro.php" method="POST" class="formuEstilo">
            <div class="grupo-input">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            
            <div class="grupo-input">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            
            <div class="grupo-input">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btnFormulario">Registrarse</button>
            
            <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
                ¿Ya tienes una cuenta? <a href="login.php" style="color: #82e0cf; font-weight: bold; text-decoration: none;">Inicia sesión</a>
            </p>
        </form>
    </div>
</main>