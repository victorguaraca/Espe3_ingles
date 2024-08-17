<?php
// Incluir la conexión a la base de datos
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y preparar los datos de entrada
    $mensaje = $conn->real_escape_string($_POST['mensaje']);
    $usuario_id = $conn->real_escape_string($_POST['usuario_id']);

    // Insertar el mensaje en la base de datos usando una consulta preparada
    $query = $conn->prepare("INSERT INTO mensajes (usuario_id, mensaje, fecha) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $query->bind_param('is', $usuario_id, $mensaje);

    if ($query->execute()) {
        echo "Message sent";
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
}

// Cerrar la conexión
$conn->close();
?>
