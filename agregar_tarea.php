<?php
$conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'bxnzjaabqzeawdtzzhsh');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tarea'];

    // Insertar la nueva tarea en la base de datos
    $query = "INSERT INTO tareas (descripcion) VALUES ('$tarea')";
    $conexion->query($query);

    // Redirigir de vuelta a la página principal
    header("Location: index.php");
}
?>
