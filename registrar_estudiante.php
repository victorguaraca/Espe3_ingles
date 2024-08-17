<?php
// Incluir la conexión a la base de datos
require_once 'db.php'; // Asegúrate de que 'db.php' define la variable $conn

// Obtener los datos del formulario y sanitizarlos
$cedula = $_POST['cedula'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$carrera = $_POST['carrera'];
$semestre = $_POST['semestre'];
$password = $_POST['password'];
$privilegio = 0; // O el valor predeterminado que desees

// Validar datos (puedes añadir más validaciones según tus necesidades)

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO estudiantes (Cedula, Nombres, Apellidos, Carrera, Semestre, password, privilegio) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparando la consulta: " . $conn->error);
}

// Vincular parámetros
$stmt->bind_param("sssisis", $cedula, $nombres, $apellidos, $carrera, $semestre, $password, $privilegio);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Student registered successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
