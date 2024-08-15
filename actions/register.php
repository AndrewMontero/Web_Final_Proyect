<?php
session_start(); // Iniciar la sesión

require_once "../utils/database.php"; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $apellido = $mysqli->real_escape_string($_POST['apellido']);
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $direccion = $mysqli->real_escape_string($_POST['direccion']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $contraseña = password_hash($mysqli->real_escape_string($_POST['contraseña']), PASSWORD_BCRYPT); // Encriptar la contraseña

    // Insertar el nuevo usuario en la base de datos
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
        echo "Error en la preparación de la consulta de inserción: " . $mysqli->error;
    }
    
    // Verificar si el correo electrónico ya está registrado
    $checkEmailQuery = "SELECT id FROM usuarios WHERE email = ?";
    if ($stmt = $mysqli->prepare($checkEmailQuery)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // El correo ya está registrado
            $_SESSION['error'] = 'El correo electrónico ya está registrado.';
            header("Location: ../pages/register.php");
            exit();
        }
        $stmt->close();
    } else {
        // Manejar el error de la preparación de la consulta
        echo "Error en la preparación de la consulta de verificación: " . $mysqli->error;
        exit();
    }

    
}

$mysqli->close();
