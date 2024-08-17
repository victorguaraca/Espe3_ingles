<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = new mysqli('bxnzjaabqzeawdtzzhsh-mysql.services.clever-cloud.com', 'ucawsdjlchtx5arx', 'Ag0rV8TJrbk27aEhhErL', 'ucawsdjlchtx5arx";
$database = "bxnzjaabqzeawdtzzhsh');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Verificar si el campo tarea_id y archivo están presentes en la solicitud
    if (isset($_POST['tarea_id']) && isset($_FILES['archivo'])) {
        $tarea_id = $_POST['tarea_id'];

        // Validar el archivo
        $archivo = $_FILES['archivo']['name'];
        $archivo_tmp = $_FILES['archivo']['tmp_name'];
        $archivo_error = $_FILES['archivo']['error'];
        $archivo_tipo = $_FILES['archivo']['type'];

        // Verificar errores del archivo
        if ($archivo_error !== UPLOAD_ERR_OK) {
            echo "Error uploading the file. Error code " . $archivo_error;
            exit();
        }

        // Verificar tipo de archivo permitido
        $tipos_permitidos = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.text', 'application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($archivo_tipo, $tipos_permitidos)) {
            echo "File type not allowed.";
            exit();
        }

        // Definir el destino del archivo
        $destino = "archivos/" . basename($archivo);

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($archivo_tmp, $destino)) {
            // Insertar los datos en la base de datos
            $stmt = $conexion->prepare("INSERT INTO archivos (tarea_id, nombre) VALUES (?, ?)");
            $stmt->bind_param("is", $tarea_id, $archivo);

            if ($stmt->execute()) {
                echo "File uploaded and saved successfully.";
            } else {
                echo "Error saving data to the database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "There was an error moving the file.";
        }
    } else {
        echo "Missing data in the request.";
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
