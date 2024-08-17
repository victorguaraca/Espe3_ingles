<?php
// Incluir la conexión a la base de datos
require_once 'db.php';

// Consultar mensajes
$sql = "SELECT mensajes.id, mensajes.mensaje, mensajes.fecha, usuarios.Nombres
        FROM mensajes
        JOIN usuarios ON mensajes.usuario_id = usuarios.id
        ORDER BY mensajes.fecha ASC";
$resultado = $conexion->query($sql);

$mensajes = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $mensajes[] = $fila;
    }
}

// Devolver en formato JSON
header('Content-Type: application/json');
echo json_encode($mensajes);

// Cerrar la conexión
$conexion->close();
?>
