<?php
session_start(); // Iniciar la sesión

require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $apellido = $mysqli->real_escape_string($_POST['apellido']);
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $direccion = $mysqli->real_escape_string($_POST['direccion']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $contraseña = password_hash($mysqli->real_escape_string($_POST['contraseña']), PASSWORD_BCRYPT); // Encriptar la contraseña

    $sql = "INSERT INTO usuarios (nombre, apellido, telefono, direccion, email, contraseña) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssisss", $nombre, $apellido, $telefono, $direccion, $email, $contraseña);

        if ($stmt->execute()) {
            // Registro exitoso, redirigir a la página de login
            $_SESSION['message'] = 'Registro exitoso. Por favor, inicie sesión.';
            header("Location: ../pages/login.php");
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
    }
}

$mysqli->close();
