<?php
session_start();

// Conectar a la base de datos  
$host = 'localhost';
$db = 'landsatBD'; 
$user = 'postgres'; 
$pass = 'minigamer123'; 

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

// Variables para los mensajes de error
$error = "";
$success = "";
$showRegisterLink = false;  // Variable para mostrar el enlace de registro

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos de email y contraseña están presentes
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Consultar la base de datos para obtener el usuario con el email ingresado
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar la contraseña
            if (password_verify($password, $user['pass_hash'])) {
                // Si la contraseña es correcta, iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $success = "Inicio de sesión exitoso. Redirigiendo...";
                header("refresh:2;url=principal.php");  // Redirigir después de 2 segundos
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No existe una cuenta con este correo.";
            $showRegisterLink = true;  // Mostrar el enlace de registro
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - LandSat Project</title>
    <link rel="stylesheet" href="/LANDSAT/css/sesion.css">
</head>
<body>

    <!-- Video de fondo -->
    <video autoplay muted loop class="video-background">
        <source src="/LANDSAT/Imagenes/215697_small.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>

    <h1>Inicio de Sesión</h1>

    <!-- Mostrar mensaje de error o éxito -->
    <?php if ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Si el correo no existe, mostrar el enlace para registrarse -->
    <?php if ($showRegisterLink): ?>
        <p class="error-message">No existe una cuenta con este correo. <a href="formregistro.php" class="register-link">Haz clic aquí para registrarte</a></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <!-- Email -->
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <!-- Botón para regresar al menú principal -->
    <a href="index.php" class="back-button">Regresar al menú principal</a>

</body>
</html>
