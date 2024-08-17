<?php
// subir_tarea.php

// Incluir la conexión a la base de datos
require_once 'db.php';

// Recuperar datos del formulario
$descripcion = $_POST['descripcion'];

// Subir archivo
if (isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    $fileName = $archivo['name'];
    $fileTmpName = $archivo['tmp_name'];
    $filePath = "archivos/" . $fileName;

    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Insertar tarea en la base de datos
        $query = $conexion->prepare("INSERT INTO tareas (descripcion) VALUES (?)");
        $query->bind_param("s", $descripcion);
        $query->execute();
        $tarea_id = $query->insert_id;

        // Insertar archivo en la base de datos
        $query = $conexion->prepare("INSERT INTO archivos (nombre, tarea_id) VALUES (?, ?)");
        $query->bind_param("si", $fileName, $tarea_id);
        $query->execute();

        echo "Task added successfully";
    } else {
        echo "Error uploading the file.";
    }
} else {
    echo "No file has been uploaded.";
}

// Cerrar la conexión
$conexion->close();

// Redirigir de vuelta a panel_estudiante.php
header("Location: panel_estudiante.php");
exit();
?>
