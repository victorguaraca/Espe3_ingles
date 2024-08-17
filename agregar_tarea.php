<?php
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tarea'];

    // Insertar la nueva tarea en la base de datos
    $query = "INSERT INTO tareas (descripcion) VALUES ('$tarea')";
    $conexion->query($query);

    // Redirigir de vuelta a la página principal
    header("Location: index.php");
}
?>
