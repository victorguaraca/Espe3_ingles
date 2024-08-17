<?php
// Incluir el archivo db.php para la conexión a la base de datos
require_once 'db.php';

// Consulta para obtener los comentarios
$sql = "SELECT nombre_usuario, tipo_usuario, comentario, archivo, fecha FROM comentarios_foro ORDER BY fecha DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h4>" . htmlspecialchars($row['nombre_usuario']) . " (" . htmlspecialchars($row['tipo_usuario']) . ")</h4>";
        echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
        if ($row['archivo']) {
            echo "<a href='uploads/" . htmlspecialchars($row['archivo']) . "'>Download attached file.</a>";
        }
        echo "<p><small>Published on: " . htmlspecialchars($row['fecha']) . "</small></p>";
        echo "</div><hr>";
    }
} else {
    echo "There are no comments yet";
}

$conn->close();
?>
