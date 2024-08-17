<?php
// Configuración de la base de datos
$host = 'bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com';
$db = 'bxnzjaabqzeawdtzzhsh';  // Nombre de tu base de datos
$user = 'ucawsdjlchtx5arx';         // Nombre de usuario de MySQL
$pass = 'Ag0rV8TJrbk27aEhhErL';             // Contraseña para el usuario de MySQL, puede estar vacía por defecto

// Crear la conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de tarea desde el formulario
$tarea_id = $_POST['tarea_id'];

// Validar la existencia de la tarea
$sql = "SELECT * FROM tareas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $tarea_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("La tarea con ID $tarea_id no existe.");
}

// Manejo del archivo subido
if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['archivo']['tmp_name'];
    $name = basename($_FILES['archivo']['name']);
    $upload_dir = 'uploads/'; // Directorio donde se guardarán los archivos

    // Crear el directorio si no existe
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Mover el archivo a la carpeta de subida
    if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
        echo "File uploaded successfully.";
    } else {
        echo "Error moving the file.";
    }
} else {
    echo "Error uploading the file.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
