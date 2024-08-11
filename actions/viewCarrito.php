<?php
require_once "../utils/database.php";
session_start(); // Asegúrate de que la sesión esté iniciada

// Obtén el ID del usuario logueado
$user_id = $_SESSION['user_id']; // Asegúrate de que esta variable contenga el ID correcto del usuario logueado

// Prepara y ejecuta la consulta
$sql = "SELECT nombre, marca, presentacion, cantidad, precio, imagen FROM compras WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Obtén los datos y guárdalos en un array
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Libera los recursos y cierra la conexión
$stmt->close();
$mysqli->close();

// Incluir la vista y pasar los datos
