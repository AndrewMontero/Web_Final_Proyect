<?php
session_start();
require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $apellido = $mysqli->real_escape_string($_POST['apellido']);
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $direccion = $mysqli->real_escape_string($_POST['direccion']);
    $email = $mysqli->real_escape_string($_POST['email']);

    // Si se ingresa una nueva contraseña, se encripta
    $contraseña = !empty($_POST['contraseña']) ? password_hash($mysqli->real_escape_string($_POST['contraseña']), PASSWORD_BCRYPT) : null;

    // Actualizar los datos del usuario en la base de datos
    if ($contraseña) {
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, direccion = ?, email = ?, contraseña = ? WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssisssi", $nombre, $apellido, $telefono, $direccion, $email, $contraseña, $userId);
        }
    } else {
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, direccion = ?, email = ? WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssissi", $nombre, $apellido, $telefono, $direccion, $email, $userId);
        }
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Perfil actualizado exitosamente.';
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
