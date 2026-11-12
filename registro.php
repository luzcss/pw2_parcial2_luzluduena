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

    // Validaciones en servidor
    if (empty($nombre) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }

    if (empty($errores)) {
        // Consulta preparada para verificar si el correo ya existe
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
        // Encriptar contraseña e insertar
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

<main>
    <h2>Formulario de Registro</h2>

    <?php if (!empty($errores)): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="registro.php" method="POST">
        <div>
            <label for="nombre">Nombre completo:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>
        <br>
        <div>
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <br>
        <div>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>