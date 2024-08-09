<?php
require_once '../utils/database.php';

// Insertar usuario registro
function insert($conn, $user)
{
    $contraseña = password_hash($user['contraseña'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, telefono, direccion, email, contraseña) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Cambia el tipo de parámetro de 's' a 'i' para el teléfono
        $stmt->bind_param("ssisss", $user['nombre'], $user['apellido'], $user['telefono'], $user['direccion'], $user['email'], $contraseña);
        $result = $stmt->execute();

        if ($result) {
            $id = $conn->insert_id;
            $stmt->close();
            return $id;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        return false; // Retornar falso si no se pudo preparar la sentencia
    }
}
?>