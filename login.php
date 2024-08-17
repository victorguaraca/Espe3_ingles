<?php
session_start();

// Incluir el archivo db.php para la conexión a la base de datos
include 'db.php';

// Obtener los datos del formulario
$cedula = $_POST['cedula'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales del estudiante
$sql = "SELECT * FROM estudiantes WHERE Cedula='$cedula' AND password='$password'";
$result = $conn->query($sql);

// Verificar si se encontró algún resultado
if ($result->num_rows > 0) {
    // Obtener los datos del usuario (para obtener privilegio)
    $user = $result->fetch_assoc();
    $_SESSION['loggedin'] = true;
    $_SESSION['cedula'] = $cedula;
    $_SESSION['privilegio'] = $user['privilegio']; // Obtener privilegio del usuario
    header("Location: panel_estudiante.php");
} else {
    // Si no se encontraron resultados, mostrar un mensaje de error y redirigir al login nuevamente
    echo "Incorrect ID or password.";
    header("Refresh: 3; URL=login.html"); // Redirigir al login después de 3 segundos
}

// Cerrar la conexión
close_db_connection($conn);
?>
