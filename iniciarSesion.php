<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Verificar usuario
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sesión y redirigir
            session_start();
            $_SESSION['username'] = $user['username']; // Puedes guardar más datos del usuario si es necesario
            header("Location: index.php");
            exit(); // Asegúrate de usar exit después de header
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="./css/sesion.css">
</head>
<body>

    

    <form action="iniciarSesion.php" method="POST">
    <h1>Bienvenido a Sublimart!</h1>
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>

    <div>
        <p>¿Aun no tienes cuenta?<a href="crearCuenta.php">crear cuenta</a></p>
    </div>
        
    </form>

    
</body>
</html>