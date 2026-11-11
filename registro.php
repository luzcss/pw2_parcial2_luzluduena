<?php

session_start();


require_once 'includes/conexion.php';


$errores = [];
$nombre = "";
$correo = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    

    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Debes ingresar un correo electrónico válido.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }
    
   
    if (empty($errores)) {
       
        $sql_check = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);
        
        
        mysqli_stmt_bind_param($stmt_check, "s", $correo);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        
        
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $errores[] = "Este correo electrónico ya está registrado.";
        }
        mysqli_stmt_close($stmt_check);
    }
    
    
    if (empty($errores)) {
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        
        $sql_insert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);
        
        
        mysqli_stmt_bind_param($stmt_insert, "sss", $nombre, $correo, $password_hash);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            
            $_SESSION['flash_exito'] = "¡Registro exitoso! Por favor, inicia sesión.";
            header("Location: login.php");
            exit(); 
        } else {
            $errores[] = "Hubo un problema al crear la cuenta. Inténtalo más tarde.";
        }
        mysqli_stmt_close($stmt_insert);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <main>
        <h2>Crear una Cuenta Nueva</h2>
        
        
        <?php if (!empty($errores)): ?>
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
                <ul>
                    <?php foreach ($errores as $error): ?>
                       
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <form action="registro.php" method="POST">
            <div>
                <label for="nombre">Nombre Completo:</label>
                
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <br>
            <div>
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            </div>
            <br>
            <div>
                <label for="password">Contraseña (Mínimo 6 caracteres):</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <button type="submit">Registrarme</button>
        </form>
        
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </main>
</body>
</html>