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

// Inicializar variables para mensajes
$message = $error = "";

// Si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $carrera = $_POST['carrera'];
    $semestre = $_POST['semestre'];
    $password = $_POST['password'];
    $privilegio = $_POST['privilegio']; // Nuevo campo para el privilegio

    // Validar datos
    if (empty($cedula) || empty($nombres) || empty($apellidos) || empty($carrera) || empty($semestre) || empty($password) || empty($privilegio)) {
        $error = "Todos los campos son requeridos.";
    } else {
        // Preparar y ejecutar la consulta
        $sql = "INSERT INTO estudiantes (Cedula, Nombres, Apellidos, Carrera, Semestre, password, privilegio) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $cedula, $nombres, $apellidos, $carrera, $semestre, $password, $privilegio);

        if ($stmt->execute()) {
            $message = "Estudiante registrado exitosamente.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        // Cerrar el prepared statement
        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Professor - Student Registration</title>
    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto mt-8">
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Student Registration</h2>

        <!-- Mensajes de éxito o error -->
        <?php if ($message): ?>
            <div class="mb-4 text-green-600"><?= htmlspecialchars($message); ?></div>
        <?php elseif ($error): ?>
            <div class="mb-4 text-red-600"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Formulario de Registro -->
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-4">
                <label for="cedula" class="block text-sm font-medium text-gray-700">ID</label>
                <input type="text" id="cedula" name="cedula" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="nombres" class="block text-sm font-medium text-gray-700">First names</label>
                <input type="text" id="nombres" name="nombres" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="apellidos" class="block text-sm font-medium text-gray-700">Last names</label>
                <input type="text" id="apellidos" name="apellidos" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="carrera" class="block text-sm font-medium text-gray-700">Degree program or Major</label>
                <input type="text" id="carrera" name="carrera" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="semestre" class="block text-sm font-medium text-gray-700">Semester</label>
                <input type="number" id="semestre" name="semestre" min="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="privilegio" class="block text-sm font-medium text-gray-700">Privilege Level</label>
                <input type="text" id="privilegio" name="privilegio" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Register</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
