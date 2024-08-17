<?php
// Conexión a la base de datos (igual que antes)
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los comentarios
$sql = "SELECT nombre_usuario, tipo_usuario, comentario, archivo, fecha FROM comentarios_foro ORDER BY fecha DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h4>" . $row['nombre_usuario'] . " (" . $row['tipo_usuario'] . ")</h4>";
        echo "<p>" . $row['comentario'] . "</p>";
        if ($row['archivo']) {
            echo "<a href='uploads/" . $row['archivo'] . "'>Download attached file.</a>";
        }
        echo "<p><small>Published on: " . $row['fecha'] . "</small></p>";
        echo "</div><hr>";
    }
} else {
    echo "There are no comments yet";
}

$conn->close();
?>
