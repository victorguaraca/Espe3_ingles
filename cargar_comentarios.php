<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

$tarea_id = intval($_GET['tarea_id']);
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 5; // Número de comentarios a mostrar por solicitud

// Preparar y ejecutar la consulta para obtener los comentarios
$sql = "SELECT * FROM comentarios WHERE tarea_id = ? ORDER BY id ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $tarea_id, $limit, $offset);
$stmt->execute();
$resultado = $stmt->get_result();

$comentarios = [];
while ($comentario = $resultado->fetch_assoc()) {
    $comentarios[] = $comentario;
}

// Preparar y ejecutar la consulta para obtener el total de comentarios
$sqlTotal = "SELECT COUNT(*) AS total FROM comentarios WHERE tarea_id = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param('i', $tarea_id);
$stmtTotal->execute();
$resultadoTotal = $stmtTotal->get_result();
$totalComentarios = $resultadoTotal->fetch_assoc()['total'];

// Determinar si hay más comentarios para cargar
$hayMas = ($offset + $limit) < $totalComentarios;

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode(['comentarios' => $comentarios, 'hayMas' => $hayMas]);

// Cerrar la conexión
$conn->close();
?>
