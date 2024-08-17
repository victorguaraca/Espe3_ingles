<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

$tarea_id = intval($_GET['tarea_id']);
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 5; // Número de archivos a mostrar por solicitud

// Preparar y ejecutar la consulta para obtener los archivos
$sql = "SELECT * FROM archivos WHERE tarea_id = ? ORDER BY nombre ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $tarea_id, $limit, $offset);
$stmt->execute();
$resultado = $stmt->get_result();

$archivos = [];
while ($archivo = $resultado->fetch_assoc()) {
    $archivos[] = $archivo;
}

// Preparar y ejecutar la consulta para obtener el total de archivos
$sqlTotal = "SELECT COUNT(*) AS total FROM archivos WHERE tarea_id = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param('i', $tarea_id);
$stmtTotal->execute();
$resultadoTotal = $stmtTotal->get_result();
$totalArchivos = $resultadoTotal->fetch_assoc()['total'];

// Determinar si hay más archivos para cargar
$hayMas = ($offset + $limit) < $totalArchivos;

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode(['archivos' => $archivos, 'hayMas' => $hayMas]);

// Cerrar la conexión
$conn->close();
?>
