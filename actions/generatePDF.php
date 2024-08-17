<?php
session_start();
require_once "../utils/database.php";
require_once "../fpdf186/fpdf.php"; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('No estás autenticado.'); window.location.href='../pages/login.php';</script>";
    exit;
}

// Consulta para obtener los datos
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

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del documento
$pdf->Cell(0, 10, 'Reporte de Compras', 0, 1, 'C');
$pdf->Ln(10);

// Encabezado de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Marca', 1);
$pdf->Cell(40, 10, 'Presentacion', 1);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(30, 10, 'Usuario', 1);
$pdf->Ln();

// Datos de la tabla
$pdf->SetFont('Arial', '', 10);
foreach ($productos as $producto) {
    $pdf->Cell(40, 10, $producto['producto'], 1);
    $pdf->Cell(30, 10, $producto['marca'], 1);
    $pdf->Cell(40, 10, $producto['presentacion'], 1);
    $pdf->Cell(20, 10, $producto['cantidad'], 1);
    $pdf->Cell(30, 10, $producto['precio'], 1);
    $pdf->Cell(30, 10, $producto['usuario'], 1);
    $pdf->Ln();
}

// Salida del PDF
$pdf->Output('D', 'Reporte_Compras.pdf');
?>
