<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tarea'];

    // Sanitizar y preparar los datos de entrada
    $tarea = $conn->real_escape_string($tarea);

    // Insertar la nueva tarea en la base de datos usando una consulta preparada
    $query = "INSERT INTO tareas (descripcion) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $tarea);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página principal
        header("Location: index.php");
        exit(); // Asegúrate de que no se ejecute ningún código adicional después de redirigir
    } else {
        echo "Error al insertar la tarea: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
