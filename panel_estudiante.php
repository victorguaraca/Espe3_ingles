<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

$privilegio = $_SESSION['privilegio'];
$cedula = $_SESSION['cedula'];

// Incluir la conexión a la base de datos
require_once 'db.php';

// Consulta SQL para obtener el nombre del estudiante
$sql = "SELECT Nombres FROM estudiantes WHERE Cedula = '$cedula'";
$result = $conn->query($sql);
$nombre = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['Nombres'];
} else {
    $nombre = 'Usuario no encontrado';
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student System    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .menu-container {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 60px;
            background-color: #2c3e50;
            transition: width 0.4s;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .menu-container:hover {
            width: 260px;
        }
        .menu-icon {
            color: #ecf0f1;
            font-size: 30px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .nav {
            width: 100%;
            transform: translateX(-200px);
            opacity: 0;
            transition: transform 0.4s, opacity 0.4s;
        }
        .menu-container:hover .nav {
            transform: translateX(0);
            opacity: 1;
        }
        .nav a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #ecf0f1;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, padding-left 0.3s;
        }
        .nav a:hover {
            background-color: #34495e;
            padding-left: 30px;
        }
        .nav a .icon {
            margin-right: 10px;
            font-size: 20px;
        }
        .nav a span {
            white-space: nowrap;
        }
        .content {
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.4s;
        }
        .menu-container:hover ~ .content {
            margin-left: 260px;
        }
        .header {
            background-color: #34495e;
            color: #ecf0f1;
            padding: 10px 20px;
            text-align: center;
            font-size: 24px;
        }
        h2 {
            color: #2c3e50;
        }
        section {
            margin-bottom: 40px;
        }
        section h3 {
            color: #2980b9;
            margin-bottom: 10px;
        }
        section ul {
            list-style-type: none;
            padding: 0;
        }
        section ul li a {
            color: #2980b9;
            text-decoration: none;
            transition: color 0.3s;
        }
        section ul li a:hover {
            color: #e74c3c;
        }
        .card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .card h4 {
            margin-top: 0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }
        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
        .carousel {
        position: relative;
        width: 100%;
        max-width: 800px; /* Aumenta el ancho máximo del contenedor */
        height: 500px; /* Aumenta la altura del contenedor */
        margin: 0 auto;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel img {
        width: 100%;
        height: 100%;
        display: none;
        object-fit: cover; /* Asegura que la imagen cubra todo el contenedor */
    }

    .carousel img.active {
        display: block;
    }
/* Estilos generales para la sección de tareas */
#tareas {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 30px;
    background-color: #f4f4f9;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

#tareas h3 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 600;
}

/* Estilo para el formulario de subida de archivos */
form {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
}

form input[type="file"] {
    display: block;
    margin-bottom: 15px;
}

form button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #0056b3;
}

/* Estilo para la lista de tareas */
/* General styles for the section */
#tareas {
    padding: 20px;
    background-color: #f9f9f9;
}

#lista-tareas {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.tarea-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.tarea-descripcion {
    font-size: 16px;
    margin-bottom: 10px;
}

.archivos-card, .comentarios-card {
    margin-top: 10px;
}

.archivos-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    background-color: #f1f1f1;
}

.archivo-link {
    display: block;
    margin-bottom: 5px;
    color: #007bff;
    text-decoration: none;
}

.archivo-link:hover {
    text-decoration: underline;
}

.comentarios-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    background-color: #f1f1f1;
}

.comentario-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px;
    margin-bottom: 10px;
    background-color: #fff;
}

.comentario-form, .archivo-form {
    margin-top: 10px;
}

textarea[name='comentario'] {
    width: 100%;
    height: 60px;
    border-radius: 4px;
    border: 1px solid #ddd;
    padding: 8px;
    box-sizing: border-box;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

/* Estilo para los botones de carga */
.load-more-files, .load-more-comments {
    display: block;
    margin: 10px auto;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.load-more-files:hover, .load-more-comments:hover {
    background-color: #0056b3;
}
/* Estilos generales para el modal */
.modal {
    display: none; /* Ocultado por defecto */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro para el overlay */
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 80%;
    max-width: 600px;
    position: relative;
}

/* Estilo para el botón de cerrar */
.modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    cursor: pointer;
}

/* Estilo para los enlaces dentro del modal */
.resource-links {
    list-style: none;
    padding: 0;
}

.resource-links li {
    margin-bottom: 10px;
}

.resource-links a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

.resource-links a:hover {
    text-decoration: underline;
}

body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .quiz-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #007bff;
        }
        .question {
            font-size: 1.2em;
            margin-bottom: 15px;
        }
        .options button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            max-width: 250px;
        }
        .options button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            font-size: 1.2em;
            color: green;
        }
        .incorrect {
            color: red;
        }
        #final-message {
            display: none;
            font-size: 1.5em;
            color: #28a745;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .chat-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .message-box {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 15px;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            text-align: left;
        }
        .message p {
            margin: 5px 0;
        }
        .send-box {
            display: flex;
            justify-content: space-between;
        }
        .send-box input {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .send-box button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .send-box button:hover {
            background-color: #0056b3;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #foro {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #foro h3 {
            margin-top: 0;
            color: #333;
        }

        #foro p {
            margin-bottom: 20px;
            color: #555;
        }

        #mensajes {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        #mensajes p {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        #mensajes strong {
            color: #007bff;
        }

        #mensaje {
            width: calc(100% - 100px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        #enviar {
            width: 80px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        #enviar:hover {
            background-color: #0056b3;
        }
        #foro {
    font-family: Arial, sans-serif;
}

#bienvenida {
    background-color: #f4f4f4;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

#bienvenida h2 {
    margin-top: 0;
}

#lista-tareas {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.chat-tarea-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #fff;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.chat-tarea-descripcion {
    margin-bottom: 20px;
}

.chat-archivos-card, .chat-comentarios-card {
    margin-bottom: 20px;
}

.archivo-list {
    list-style-type: none;
    padding: 0;
}

.archivo-list li {
    margin-bottom: 5px;
}

.archivo-link {
    text-decoration: none;
    color: #007bff;
}

.chat-comentarios-card {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.comentario-box {
    background: #e9ecef;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 10px;
}

.chat-formularios form {
    display: flex;
    flex-direction: column;
}

.comentario-form textarea, .archivo-form input[type='file'] {
    margin-bottom: 10px;
}

.comentario-form button, .archivo-form button {
    align-self: flex-end;
    padding: 10px 15px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.comentario-form button:hover, .archivo-form button:hover {
    background: #0056b3;
}
.chat-tarea-card {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.chat-tarea-descripcion {
    margin-bottom: 10px;
}

.chat-archivos-card {
    margin-bottom: 20px;
}

.chat-comentarios-card {
    margin-bottom: 20px;
}

.comentario-list {
    margin-bottom: 10px;
}

.comentario-box {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.chat-formularios form {
    margin-bottom: 20px;
}

.comentario-form textarea,
.archivo-form input[type="file"] {
    width: 100%;
    margin-bottom: 10px;
}

.comentario-form button,
.archivo-form button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

.archivo-list {
    list-style-type: none;
    padding: 0;
}

.archivo-link {
    color: #007bff;
    text-decoration: none;
}

.archivo-link:hover {
    text-decoration: underline;
}


</style>
    </style>
</head>
<body>
    <div class="menu-container">
        <div class="menu-icon">&#9776;</div> <!-- Icono de menú hamburguesa -->
        <nav class="nav">
            <a href="#inicio"><span class="icon">🏠</span><span>Start</span></a>
            <a href="#recursos"><span class="icon">📚</span><span>Resources</span></a>
            <a href="#tareas"><span class="icon">📝</span><span>Tasks</span></a>
            <a href="#foro"><span class="icon">💬</span><span>Forum</span></a>
            <a href="./logout.php"><span class="icon">🚪</span><span>Sign Out</span></a>
            <?php if ($privilegio): ?>
                <a href="./Registrar_Estudiantes.html"><span class="icon">👩‍🎓</span><span>Register Student</span></a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="content">
        <header class="header">
        Welcome to the Student System
        </header>
        <h2 id="inicio">Welcome, <?php echo $privilegio ? 'docente' : 'estudiante'; ?> <?php echo $nombre; ?></h2>
        <div class="quiz-container">
        <h2>Identify Learning Resources!
        </h2>
        <p>Select the correct option:</p>

        <div class="question" id="question"></div>

        <div class="options">
            <button id="option1" onclick="checkAnswer(0)"></button>
            <button id="option2" onclick="checkAnswer(1)"></button>
            <button id="option3" onclick="checkAnswer(2)"></button>
            <button id="option4" onclick="checkAnswer(3)"></button>
        </div>

        <div class="result" id="result"></div>
        <div id="final-message">Thanks for participating! 🎉</div>
    </div>

    <script>
    const quizData = [
        {
            question: "Which of the following is a human resource that can help you with your studies?",
            options: ["A textbook", "A computer", "A teacher", "Educational software"],
            correct: 2
        },
        {
            question: "Which is a material resource you can use to study?",
            options: ["A classmate", "A notebook", "A tutor", "A mentor"],
            correct: 1
        },
        {
            question: "What online tool is useful for academic research?",
            options: ["Google Scholar", "Facebook", "Instagram", "TikTok"],
            correct: 0
        },
        {
            question: "Which human resource can provide feedback on your essays?",
            options: ["A teacher", "A notebook", "A website", "A calculator"],
            correct: 0
        },
        {
            question: "What material is essential for taking notes in class?",
            options: ["A dictionary", "A pen", "A classmate", "A calculator"],
            correct: 1
        },
        {
            question: "What digital resource can help you organize your tasks?",
            options: ["An online calendar", "A printer", "A ruler", "A desk"],
            correct: 0
        },
        {
            question: "Who can guide you in planning your studies?",
            options: ["An academic advisor", "A sheet of paper", "A phone", "A computer mouse"],
            correct: 0
        },
        {
            question: "Which resource can you use to improve your reading comprehension?",
            options: ["A dictionary", "A printer", "A phone", "A notebook"],
            correct: 0
        },
        {
            question: "What place is ideal for focusing on your studies?",
            options: ["A library", "A park", "A party", "A restaurant"],
            correct: 0
        },
        {
            question: "What platform can help you connect with other students to study together?",
            options: ["Google Meet", "Netflix", "Spotify", "Amazon"],
            correct: 0
        }
    ];

        let currentQuestion = 0;

        function loadQuestion() {
            const questionElement = document.getElementById('question');
            const option1 = document.getElementById('option1');
            const option2 = document.getElementById('option2');
            const option3 = document.getElementById('option3');
            const option4 = document.getElementById('option4');
            const resultElement = document.getElementById('result');

            resultElement.textContent = '';
            questionElement.textContent = quizData[currentQuestion].question;
            option1.textContent = quizData[currentQuestion].options[0];
            option2.textContent = quizData[currentQuestion].options[1];
            option3.textContent = quizData[currentQuestion].options[2];
            option4.textContent = quizData[currentQuestion].options[3];
        }

        function checkAnswer(selectedOption) {
            const resultElement = document.getElementById('result');
            const finalMessage = document.getElementById('final-message');
            if (quizData[currentQuestion].correct === selectedOption) {
                resultElement.textContent = '¡Correcto!';
                resultElement.classList.remove('incorrect');
                resultElement.classList.add('correct');
            } else {
                resultElement.textContent = 'Incorrecto. Inténtalo de nuevo.';
                resultElement.classList.remove('correct');
                resultElement.classList.add('incorrect');
            }

            setTimeout(() => {
                currentQuestion++;
                if (currentQuestion < quizData.length) {
                    loadQuestion();
                } else {
                    finalMessage.style.display = 'block';
                    document.querySelector('.quiz-container').style.display = 'none';
                }
            }, 1000);
        }

        // Load the first question when the page loads
        loadQuestion();
    </script>
       <section id="resources">
    <h3>Interactive Resources</h3>
    <div class="card">
        <h4>Human Resources</h4>
        <p>Discover how human resources can help you achieve your goals. These can include mentors, study partners, or experts in the field.</p>
        <button class="modal-button" data-modal="human-resources-modal">See More</button>
    </div>

    <div class="card">
        <h4>Material Resources</h4>
        <p>Explore the material resources that can support your learning, such as books, tools, and technologies.</p>
        <button class="modal-button" data-modal="material-resources-modal">See More</button>
    </div>

    <div id="human-resources-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h4>Human Resources</h4>
            <p>Here you can find useful links to learn more about human resources:</p>
            <ul class="resource-links">
                <li><a href="https://www.linkedin.com/learning/" target="_blank">Offers online courses on interpersonal skills, leadership, and more, with interactive content.</a></li>
                <li><a href="https://www.coursera.org/courses?query=hr" target="_blank">An online course platform on human resources and professional development with interactive videos and exercises.</a></li>
                <li><a href="https://www.mindtools.com/" target="_blank">Provides tools and resources for developing management and leadership skills.</a></li>
            </ul>
        </div>
    </div>
</section>


<<div id="material-resources-modal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h4>Material Resources</h4>
        <p>Explore the following links to access useful material resources:</p>
        <ul class="resource-links">
            <li><a href="https://www.khanacademy.org/" target="_blank">Offers interactive educational resources in various subjects such as mathematics, science, and more.</a></li>
            <li><a href="https://www.coursera.org/courses?query=educational%20resources" target="_blank">Provides courses and interactive educational materials on a variety of topics.</a></li>
            <li><a href="https://www.gutenberg.org/" target="_blank">Offers free access to over 60,000 public domain eBooks, ideal for study and reference.</a></li>
        </ul>
    </div>
</div>



            <div class="carousel">
    <img src="./images//img01.png" alt="Recurso 1">
    <img src="./images//img2.jpg" alt="Recurso 2">
    <img src="./images/img3.jpg" alt="Recurso 3">
    <img src="./images/img4.jpg" alt="Recurso 4">
    <img src="./images/img5.jpg" alt="Recurso 5">
    <img src="./images//img6.jpg" alt="Recurso 6">
    <img src="./images/img7.jpg" alt="Recurso 7">
    <img src="./images/img8.png" alt="Recurso 8">
    <img src="./images/img99.jpg" alt="Recurso 9">
    <img src="./images/img10.jpg" alt="Recurso 10">
    
</div>
<section id="tareas">
    <!-- Mostrar las tareas existentes -->
    <div id="lista-tareas">
        <!-- Aquí se mostrarán las tareas que agregue el maestro -->
        <?php
        // Incluir la conexión a la base de datos
        require_once 'db.php';

        // Recuperar las tareas de la base de datos
        $resultado = $conn->query("SELECT * FROM tareas");

        while ($tarea = $resultado->fetch_assoc()) {
            echo "<div class='tarea-card bg-white p-4 rounded shadow-md mb-4'>";

            // Mostrar la descripción de la tarea
            switch ($tarea['descripcion']) {
                case 'deber':
                    echo "<p class='task-description'>- Research the different multimedia file formats and create a PDF document with a summary.</p>";
                    echo "<p class='task-description'>- Prepare and submit a tutorial video demonstrating the basic use of an image or video editing tool, highlighting its main features.</p>";
                    break;
                default:
                    echo "<p class='tarea-descripcion'>{$tarea['descripcion']}</p>";
                    break;
            }

            // Mostrar archivos asociados a la tarea
            echo "<div class='archivos-card'>";
            echo "<h4>Attachments:</h4>";

            // Recuperar archivos de la base de datos ordenados por nombre
            $tarea_id = $tarea['id'];
            $archivos = $conn->query("SELECT * FROM archivos WHERE tarea_id = $tarea_id ORDER BY nombre ASC");

            if ($archivos->num_rows > 0) {
                while ($archivo = $archivos->fetch_assoc()) {
                    $filePath = "archivos/" . $archivo['nombre'];
                    echo "<a href='$filePath' download class='archivo-link'>{$archivo['nombre']}</a><br>";
                }
            } else {
                echo "<p>There are no attachments</p>";
            }

            echo "</div>";

            // Sección de comentarios
            echo "<div class='comentarios-card'>";
            echo "<h4>Comments:</h4>";

            // Recuperar comentarios de la base de datos
            $comentarios = $conn->query("SELECT * FROM comentarios WHERE tarea_id = $tarea_id");

            if ($comentarios->num_rows > 0) {
                while ($comentario = $comentarios->fetch_assoc()) {
                    echo "<div class='comentario-box'><p>{$comentario['comentario']}</p></div>";
                }
            } else {
                echo "<p>No comments.</p>";
            }

            // Formulario para que los estudiantes agreguen comentarios
            echo "<form method='POST' action='agregar_comentario.php' class='comentario-form mt-4'>";
            echo "<input type='hidden' name='tarea_id' value='$tarea_id'>";
            echo "<textarea name='comentario' required placeholder='Write your comment here...' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'></textarea>";
            echo "<button type='submit' class='mt-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md'>Add Comment</button>";
            echo "</form>";

            // Formulario para que los estudiantes suban archivos
            echo "<form method='POST' action='subir_archivo.php' enctype='multipart/form-data' class='archivo-form mt-4'>";
            echo "<input type='hidden' name='tarea_id' value='$tarea_id'>";
            echo "<label for='archivo' class='block text-sm font-medium text-gray-700'>Upload file:</label>";
            echo "<input type='file' name='archivo' accept='.doc,.docx,.odt,.jpg,.jpeg,.png,.mp4,.mov' required class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>";
            echo "<button type='submit' class='mt-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md'>Upload File</button>";
            echo "</form>";

            echo "</div>"; // Fin de tarea
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</section>

<section id="forum">
    <!-- Welcome message -->
    <div id="welcome" class="p-4 mb-6 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold">Welcome to the Task Forum</h2>
        <p class="mt-2 text-gray-600">Here you can interact with the tasks posted by the teacher, add comments, and upload files. Share your ideas and help your classmates.</p>
    </div>
    
    <!-- Mostrar las tareas existentes -->
    <div id="lista-tareas">
        <!-- Aquí se mostrarán las tareas que agregue el maestro -->
        <?php
        // Incluir la conexión a la base de datos
        require_once 'db.php';

        // Recuperar las tareas de la base de datos
        $resultado = $conn->query("SELECT * FROM tareas");

        while ($tarea = $resultado->fetch_assoc()) {
            $tarea_id = $tarea['id'];
            echo "<div class='chat-tarea-card bg-white p-4 rounded shadow-md mb-4'>";

            // Mostrar archivos asociados a la tarea solo si se ha subido un archivo
            echo "<div class='chat-archivos-card mb-4'>";
            echo "<h4 class='text-lg font-semibold'>Attachments:</h4>";

            // Recuperar archivos de la base de datos ordenados por nombre
            $archivos = $conn->query("SELECT * FROM archivos WHERE tarea_id = $tarea_id ORDER BY nombre ASC");

            if ($archivos->num_rows > 0) {
                echo "<ul class='archivo-list list-disc pl-5'>";
                while ($archivo = $archivos->fetch_assoc()) {
                    $filePath = "archivos/" . $archivo['nombre'];
                    echo "<li><a href='$filePath' download class='archivo-link text-blue-500 hover:underline'>{$archivo['nombre']}</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No attachments available.</p>";
            }

            echo "</div>";

            // Sección de comentarios solo si hay comentarios
            echo "<div class='chat-comentarios-card mb-4'>";
            echo "<h4 class='text-lg font-semibold'>Comments:</h4>";

            // Recuperar comentarios de la base de datos
            $comentarios = $conn->query("SELECT * FROM comentarios WHERE tarea_id = $tarea_id");

            if ($comentarios->num_rows > 0) {
                echo "<div class='comentario-list'>";
                while ($comentario = $comentarios->fetch_assoc()) {
                    echo "<div class='comentario-box p-2 mb-2 border border-gray-300 rounded'>{$comentario['comentario']}</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No comments available.</p>";
            }

            // Formularios para enviar comentarios y subir archivos
            echo "<div class='chat-formularios'>";

            // Formulario para que los estudiantes agreguen comentarios
            echo "<form method='POST' action='agregar_comentario.php' class='comentario-form mb-4'>";
            echo "<input type='hidden' name='tarea_id' value='$tarea_id'>";
            echo "<textarea name='comentario' required placeholder='Write your message here...' class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'></textarea>";
            echo "<button type='submit' class='mt-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md'>Send Message</button>";
            echo "</form>";

            // Formulario para que los estudiantes suban archivos
            echo "<form method='POST' action='subir_archivo.php' enctype='multipart/form-data' class='archivo-form'>";
            echo "<input type='hidden' name='tarea_id' value='$tarea_id'>";
            echo "<label for='archivo' class='block text-sm font-medium text-gray-700'>Upload File:</label>";
            echo "<input type='file' name='archivo' accept='.doc,.docx,.odt,.jpg,.jpeg,.png,.mp4,.mov' required class='mt-1 block w-full border-gray-300 rounded-md shadow-sm'>";
            echo "<button type='submit' class='mt-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md'>Upload File</button>";
            echo "</form>";

            echo "</div>"; // Fin de formularios

            echo "</div>"; // Fin de chat-tarea-card
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</section>

    </div>

    <script>
        document.querySelectorAll('.modal-button').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById(button.dataset.modal).style.display = 'flex';
            });
        });

        document.querySelectorAll('.modal-close').forEach(close => {
            close.addEventListener('click', () => {
                close.parentElement.parentElement.style.display = 'none';
            });
        });

        const carousel = document.querySelector('.carousel');
        const slides = carousel.querySelectorAll('img');
        let currentSlide = 0;

        document.getElementById('next-slide').addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            updateCarousel();
        });

        document.getElementById('prev-slide').addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateCarousel();
        });

        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
    </script>
   <script>
    let currentIndex = 0;
    const images = document.querySelectorAll('.carousel img');
    const totalImages = images.length;

    function showSlide(index) {
        images.forEach((img, i) => {
            img.classList.remove('active');
            if (i === index) {
                img.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalImages;
        showSlide(currentIndex);
    }

    // Cambiar automáticamente cada 3 segundos
    setInterval(nextSlide, 3000);

    // Mostrar la primera imagen al cargar la página
    showSlide(currentIndex);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButtonsFiles = document.querySelectorAll('.load-more-files');
    const loadMoreButtonsComments = document.querySelectorAll('.load-more-comments');

    loadMoreButtonsFiles.forEach(button => {
        button.addEventListener('click', function () {
            const tareaId = this.getAttribute('data-tarea-id');
            const archivosList = document.getElementById(`archivos-${tareaId}`);
            const button = this;

            fetch(`cargar_archivos.php?tarea_id=${tareaId}`)
                .then(response => response.json())
                .then(data => {
                    data.archivos.forEach(archivo => {
                        const link = document.createElement('a');
                        link.href = `archivos/${archivo.nombre}`;
                        link.download = archivo.nombre;
                        link.textContent = archivo.nombre;
                        archivosList.appendChild(link);
                        archivosList.appendChild(document.createElement('br'));
                    });

                    if (!data.hayMas) {
                        button.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    loadMoreButtonsComments.forEach(button => {
        button.addEventListener('click', function () {
            const tareaId = this.getAttribute('data-tarea-id');
            const comentariosList = document.getElementById(`comentarios-${tareaId}`);
            const button = this;

            fetch(`cargar_comentarios.php?tarea_id=${tareaId}`)
                .then(response => response.json())
                .then(data => {
                    data.comentarios.forEach(comentario => {
                        const comentarioBox = document.createElement('div');
                        comentarioBox.classList.add('comentario-box');
                        comentarioBox.textContent = comentario.comentario;
                        comentariosList.appendChild(comentarioBox);
                    });

                    if (!data.hayMas) {
                        button.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
</script>
<script>
    document.querySelectorAll('.modal-button').forEach(button => {
    button.addEventListener('click', function() {
        const modalId = this.getAttribute('data-modal');
        document.getElementById(modalId).style.display = 'block';
    });
});

document.querySelectorAll('.modal-close').forEach(closeButton => {
    closeButton.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
    });
});

window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

</script>

</body>
</html>
