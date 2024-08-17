<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

// Obtener el ID de tarea desde el formulario
$tarea_id = intval($_POST['tarea_id']);

// Validar la existencia de la tarea
$sql = "SELECT * FROM tareas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $tarea_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("La tarea con ID $tarea_id no existe.");
}

// Manejo del archivo subido
if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['archivo']['tmp_name'];
    $name = basename($_FILES['archivo']['name']);
    $upload_dir = 'uploads/'; // Directorio donde se guardarán los archivos

    // Crear el directorio si no existe
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Mover el archivo a la carpeta de subida
    if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
        echo "Archivo subido exitosamente.";
    } else {
        echo "Error al mover el archivo.";
    }
} else {
    echo "Error al subir el archivo.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
