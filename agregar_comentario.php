<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y preparar los datos de entrada
    $comentario = $conexion->real_escape_string($_POST['comentario']);
    $tarea_id = $conexion->real_escape_string($_POST['tarea_id']);


    // Insertar el comentario en la base de datos usando una consulta preparada
    $query = $conexion->prepare("INSERT INTO comentarios (tarea_id, comentario) VALUES (?, ?)");
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

$conexion->close();
?>

