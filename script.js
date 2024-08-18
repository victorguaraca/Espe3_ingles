
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

