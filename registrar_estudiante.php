<?php
// Incluir la conexión a la base de datos
require_once 'db.php';

// Obtener los datos del formulario
$cedula = $_POST['cedula'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$carrera = $_POST['carrera'];
$semestre = $_POST['semestre'];
$password = $_POST['password'];

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO estudiantes (Cedula, Nombres, Apellidos, Carrera, Semestre, password)
        VALUES ('$cedula', '$nombres', '$apellidos', '$carrera', $semestre, '$password')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Student registered successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
