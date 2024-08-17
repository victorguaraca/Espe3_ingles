<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'db.php';

// Obtener los datos del formulario
$cedula = $_POST['cedula'];
$password = $_POST['password'];

// Consulta SQL para verificar las credenciales del docente
$sql = "SELECT * FROM docentes WHERE cedula='$cedula' AND password='$password'";
$result = $conn->query($sql);

// Verificar si se encontró algún resultado
if ($result->num_rows == 1) {
    // Iniciar sesión y redirigir al panel
    $_SESSION['loggedin'] = true;
    $_SESSION['cedula'] = $cedula;
    $_SESSION['privilegio'] = true;
    header("Location: panel_estudiante.php");
} else {
    // Si no se encontraron resultados, mostrar un mensaje de error y redirigir al login nuevamente
    echo "Incorrect ID or password.";
    header("Refresh: 3; URL=login.html"); // Redirigir al login después de 3 segundos
}

// Cerrar la conexión
$conn->close();
?>
