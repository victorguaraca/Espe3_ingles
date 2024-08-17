<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir la conexión a la base de datos
    require_once 'db.php';

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
