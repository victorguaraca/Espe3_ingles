<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y preparar los datos de entrada
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $tarea_id = intval($_POST['tarea_id']);

    // Insertar el comentario en la base de datos usando una consulta preparada
    $query = $conn->prepare("INSERT INTO comentarios (tarea_id, comentario) VALUES (?, ?)");
    $query->bind_param('is', $tarea_id, $comentario);

    if ($query->execute()) {
        // Redirigir de vuelta a la página principal
        header("Location: ./panel_estudiante.php");
        exit();
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
}

// Cerrar la conexión
$conn->close();
?>
