<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

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

$conexion->close();
?>
