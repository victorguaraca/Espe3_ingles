<?php
include 'db.php';

$sql = "SELECT m.mensaje, u.Nombres, m.fecha 
        FROM mensajes m 
        JOIN usuarios u ON m.usuario_id = u.id 
        ORDER BY m.fecha DESC";

$result = $conn->query($sql);

$mensajes = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $mensajes[] = $row;
    }
}
$conn->close();

echo json_encode($mensajes);
?>
