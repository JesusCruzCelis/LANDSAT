<?php
// Iniciar sesión para almacenar el mensaje de error
session_start();

// Conexión a la base de datos
$host = 'localhost';
$db = 'landsatBD'; // Nombre de la base de datos
$user = 'postgres'; // Usuario de la base de datos
$pass = 'minigamer123'; // Contraseña de la base de datos

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si todos los campos requeridos están presentes
    if (isset($_POST['nombre'], $_POST['email'], $_POST['numero'], $_POST['password'], 
              $_POST['latitud'], $_POST['longitud'], $_POST['notificationTimeStart'], 
              $_POST['notificationTimeEnd'], $_POST['pref_noti'])) {
        
        // Capturar los valores del formulario
        $nombre = $_POST['nombre'];
        $email = $_POST['email']; // Captura el correo ingresado por el usuario
        $numero = $_POST['numero']; // Captura el número de teléfono ingresado por el usuario
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña
        $longitud = floatval($_POST['longitud']); // Convertir longitud a número flotante
        $latitud = floatval($_POST['latitud']);  // Convertir latitud a número flotante
        $hora_inicio = $_POST['notificationTimeStart'];
        $hora_fin = $_POST['notificationTimeEnd'];
        $pref_noti = $_POST['pref_noti']; // Capturar la preferencia de notificación

        // Validar que los valores de latitud y longitud son válidos
        if (!is_numeric($longitud) || !is_numeric($latitud)) {
            $_SESSION['error'] = "Error: Latitud o longitud no válidas.";
            header('Location: formregistro.php');
            exit;
        }

        // Insertar en la base de datos el correo y el número de teléfono en sus respectivos campos
        $sql = "INSERT INTO users (name, email, num, pass_hash, longitud, latitud, hora_inicio, hora_fin, pref_noti)
                VALUES (:name, :email, :num, :pass_hash, :longitud, :latitud, :hora_inicio, :hora_fin, :pref_noti)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); // Guardar el correo electrónico
            $stmt->bindParam(':num', $numero, PDO::PARAM_INT);  // Guardar el número de teléfono
            $stmt->bindParam(':pass_hash', $password, PDO::PARAM_STR);
            $stmt->bindParam(':longitud', $longitud, PDO::PARAM_STR);
            $stmt->bindParam(':latitud', $latitud, PDO::PARAM_STR);
            $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
            $stmt->bindParam(':hora_fin', $hora_fin, PDO::PARAM_STR);
            $stmt->bindParam(':pref_noti', $pref_noti, PDO::PARAM_STR); // Guardar la preferencia de notificación (email o teléfono)
            
            $stmt->execute();
            
            // Redirigir a principal.php después de un registro exitoso
            header('Location: principal.php');
            exit;
        } catch (PDOException $e) {
            // Verificar si el error es de violación de clave única (correo electrónico ya registrado)
            if ($e->getCode() == 23505) {
                $_SESSION['error'] = "Ya existe un usuario registrado con ese correo o número.";
                header('Location: formregistro.php'); // Redirigir de nuevo al formulario
                exit;
            } else {
                $_SESSION['error'] = "Error al insertar en la base de datos: " . $e->getMessage();
                header('Location: formregistro.php'); // Redirigir de nuevo al formulario con otro error
                exit;
            }
        }

    } else {
        $_SESSION['error'] = "Error: Todos los campos son obligatorios.";
        header('Location: formregistro.php');
        exit;
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
