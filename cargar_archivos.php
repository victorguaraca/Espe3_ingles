<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$tarea_id = intval($_GET['tarea_id']);
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 5; // Número de archivos a mostrar por solicitud

$sql = "SELECT * FROM archivos WHERE tarea_id = $tarea_id ORDER BY nombre ASC LIMIT $limit OFFSET $offset";
$resultado = $conexion->query($sql);

$archivos = [];
while ($archivo = $resultado->fetch_assoc()) {
    $archivos[] = $archivo;
}

$sqlTotal = "SELECT COUNT(*) AS total FROM archivos WHERE tarea_id = $tarea_id";
$resultadoTotal = $conexion->query($sqlTotal);
$totalArchivos = $resultadoTotal->fetch_assoc()['total'];

$hayMas = ($offset + $limit) < $totalArchivos;

header('Content-Type: application/json');
echo json_encode(['archivos' => $archivos, 'hayMas' => $hayMas]);

$conexion->close();
?>
