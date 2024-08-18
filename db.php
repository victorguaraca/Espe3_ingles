<?php
// Configuración de la conexión a la base de datos
$servername = "bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com";
$username = "ucawsdjlchtx5arx";
$password = "Ag0rV8TJrbk27aEhhErL";
$database = "bxnzjaabqzeawdtzzhsh";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// No se cierra la conexión aquí; solo la establecemos
?>
