<?php
session_start(); // Iniciar la sesión

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Aquí debes realizar la validación del usuario, por ejemplo, consultando una base de datos.
    // Para este ejemplo, asumiremos que el usuario y contraseña son "admin" y "1234" respectivamente.
    if ($usuario === 'admin' && $contrasena === '1234') {
        $_SESSION['usuario'] = $usuario;
        header('Location: bienvenida.php');
        exit();
    } else {
        echo 'Usuario o contraseña incorrectos';
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
    <form action="iniciar_sesion.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
