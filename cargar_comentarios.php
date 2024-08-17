<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$tarea_id = intval($_GET['tarea_id']);
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 5; // Número de comentarios a mostrar por solicitud

$sql = "SELECT * FROM comentarios WHERE tarea_id = $tarea_id ORDER BY id ASC LIMIT $limit OFFSET $offset";
$resultado = $conexion->query($sql);

$comentarios = [];
while ($comentario = $resultado->fetch_assoc()) {
    $comentarios[] = $comentario;
}

$sqlTotal = "SELECT COUNT(*) AS total FROM comentarios WHERE tarea_id = $tarea_id";
$resultadoTotal = $conexion->query($sqlTotal);
$totalComentarios = $resultadoTotal->fetch_assoc()['total'];

$hayMas = ($offset + $limit) < $totalComentarios;

header('Content-Type: application/json');
echo json_encode(['comentarios' => $comentarios, 'hayMas' => $hayMas]);

$conexion->close();
?>
