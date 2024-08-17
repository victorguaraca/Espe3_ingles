<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y preparar los datos de entrada
    $mensaje = $conexion->real_escape_string($_POST['mensaje']);
    $usuario_id = $conexion->real_escape_string($_POST['usuario_id']);

    // Insertar el mensaje en la base de datos usando una consulta preparada
    $query = $conexion->prepare("INSERT INTO mensajes (usuario_id, mensaje, fecha) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $query->bind_param('is', $usuario_id, $mensaje);

    if ($query->execute()) {
        echo "Message sent";
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
}

$conexion->close();
?>
