<?php
session_start();

// Incluir el archivo db.php para la conexión a la base de datos
include 'db.php';

// Obtener los datos del formulario y sanitizarlos
$cedula = $_POST['cedula'];
$password = $_POST['password'];

// Validar datos
if (empty($cedula) || empty($password)) {
    die("ID and password are required.");
}

// Preparar la consulta SQL para verificar las credenciales del estudiante
$sql = "SELECT * FROM estudiantes WHERE Cedula = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparando la consulta: " . $conn->error);
}

// Vincular parámetros
$stmt->bind_param("s", $cedula);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$result = $stmt->get_result();

// Verificar si se encontró algún resultado
if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $user = $result->fetch_assoc();

    // Verificar la contraseña
    if (password_verify($password, $user['password'])) {
        // Configurar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['cedula'] = $cedula;
        $_SESSION['privilegio'] = $user['privilegio']; // Obtener privilegio del usuario
        header("Location: panel_estudiante.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "Incorrect ID or password.";
        header("Refresh: 3; URL=index.html"); // Redirigir al login después de 3 segundos
    }
} else {
    // Usuario no encontrado
    echo "Incorrect ID or password.";
    header("Refresh: 3; URL=index.html"); // Redirigir al login después de 3 segundos
}

// Cerrar la consulta y la conexión
$stmt->close();
close_db_connection($conn);
?>
