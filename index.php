<?php
session_start();

// Incluir el archivo db.php para la conexión a la base de datos
include 'db.php';

// Variable para almacenar mensajes de error
$error_message = "";

// Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    // Validar datos
    if (empty($cedula) || empty($password)) {
        $error_message = "ID and password are required.";
    } else {
        // Preparar la consulta SQL para verificar las credenciales del estudiante
        $sql = "SELECT Cedula, password FROM estudiantes WHERE Cedula = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error_message = "Error preparando la consulta: " . $conn->error;
        } else {
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
                if ($password === $user['password']) {
                    // Configurar sesión
                    $_SESSION['loggedin'] = true;
                    $_SESSION['cedula'] = $cedula;
                    header("Location: panel_estudiante.php");
                    exit();
                } else {
                    // Contraseña incorrecta
                    $error_message = "Incorrect password.";
                }
            } else {
                // Usuario no encontrado
                $error_message = "User not found.";
            }

            // Cerrar la consulta
            $stmt->close();
        }

        // Cerrar la conexión
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
    <style>
        .show-password {
            cursor: pointer;
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.src = 'https://cdn-icons-png.flaticon.com/128/25/25231.png'; // Eye icon
            } else {
                passwordField.type = 'password';
                passwordIcon.src = 'https://cdn-icons-png.flaticon.com/128/2099/2099053.png'; // Eye slash icon
            }
        }
    </script>
</head>
<body>
<main>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="grid md:grid-cols-2 items-center gap-4 max-md:gap-8 max-w-6xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
                <div class="md:max-w-md w-full px-4 py-4">
                    <form action="index.php" method="POST">
                        <div class="mb-12">
                            <h3 class="text-gray-800 text-3xl font-extrabold">Login</h3>
                        </div>
                        <?php if (!empty($error_message)): ?>
                            <div class="mb-4 text-red-600">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <label class="text-gray-800 text-xs block mb-2" for="cedula">ID</label>
                            <div class="relative flex items-center">
                                <input type="text" id="cedula" name="cedula" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter your ID" />
                            </div>
                        </div>
                        <div class="mt-8">
                            <label class="text-gray-800 text-xs block mb-2" for="password">Password</label>
                            <div class="relative flex items-center">
                                <input type="password" id="password" name="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Password" />
                                <img id="password-icon" src="https://cdn-icons-png.flaticon.com/128/2099/2099053.png" alt="Toggle password visibility" class="w-[18px] h-[18px] absolute right-2 show-password" onclick="togglePassword()">
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <a href="./indexAdmin.html" class="text-blue-600 font-semibold text-sm hover:underline">Login as a Teacher</a>
                            </div>
                        </div>
                        <div class="mb-8 mt-6">
                            <a href="./registrar_estudiante.php" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none text-center block">Sign up</a>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Login</button>
                        </div>
                    </form>
                </div>
                <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
                    <img src="./images/espe.jpg" class="w-full h-full object-contain" alt="login-image" />
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
