<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $tipo_usuario = $_POST['tipo_usuario'];

    $sql = "INSERT INTO usuarios (nombre_usuario, correo, contraseña, tipo_usuario) VALUES ('$nombre_usuario', '$correo', '$contraseña', '$tipo_usuario')";

    if ($conn->query($sql) === TRUE) {
        echo "Successful registration.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
