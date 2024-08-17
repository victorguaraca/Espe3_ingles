<?php
$servername = "bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com";
$username = "ucawsdjlchtx5arx";
$password = "Ag0rV8TJrbk27aEhhErL";
$dbname = "bxnzjaabqzeawdtzzhsh";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
