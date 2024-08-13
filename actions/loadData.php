<?php
session_start();
require_once "../utils/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT nombre, apellido, telefono, direccion, email FROM usuarios WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $telefono, $direccion, $email);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

$mysqli->close();