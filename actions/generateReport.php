<?php
session_start();
require_once "../utils/database.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('No estás autenticado.'); window.location.href='../pages/login.php';</script>";
    exit;
}

$sql = "SELECT compras.nombre AS producto, compras.marca, compras.presentacion, compras.cantidad, compras.precio, usuarios.nombre AS usuario 
FROM compras 
INNER JOIN usuarios ON compras.user_id = usuarios.id";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $mysqli->error);
}

$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

$stmt->close();
$mysqli->close();
