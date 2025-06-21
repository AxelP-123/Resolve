// Variables del juego
let currentLevel = 1;
let score = 0;
let lives = 3;
let questionIndex = 0;
const pointsPerQuestion = 10; // Puntos por pregunta
const timeLimit = 15; // Tiempo límite en segundos
let timer; // ID del temporizador

// Función para mezclar un array
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

// Preguntas (integrales) y respuestas con opciones múltiples
const questions = [
  // Indefinidas
  {
    integral: '∫x dx',
    options: ['x^2/2 + C', 'x^3 + C', '2x + C', '1/x + C'],
    correctAnswer: 'x^2/2 + C',
  },
  {
    integral: '∫2x dx',
    options: ['x^2 + C', '2x^2 + C', 'x + C', '1/x^2 + C'],
    correctAnswer: 'x^2 + C',
  },
  {
    integral: '∫cos(x) dx',
    options: ['sin(x) + C', '-sin(x) + C', 'cos(x) + C', '-cos(x) + C'],
    correctAnswer: 'sin(x) + C',
  },
  {
    integral: '∫e^x dx',
    options: ['e^x + C', 'x*e^x + C', 'e^(2x) + C', '1/e^x + C'],
    correctAnswer: 'e^x + C',
  },
  {
    integral: '∫3x² dx',
    options: ['x^3 + C', '6x + C', 'x^2 + C', 'x^4 + C'],
    correctAnswer: 'x^3 + C',
  },
  {
    integral: '∫sin(x) dx',
    options: ['-cos(x) + C', 'cos(x) + C', '-sin(x) + C', '1/cos(x) + C'],
    correctAnswer: '-cos(x) + C',
  },
  {
    integral: '∫1/x dx',
    options: ['ln|x| + C', '1/x^2 + C', 'x + C', 'e^x + C'],
    correctAnswer: 'ln|x| + C',
  },
  {
    integral: '∫tan(x) dx',
    options: ['-ln|cos(x)| + C', 'ln|sin(x)| + C', '1/cos(x) + C', '1/sin(x) + C'],
    correctAnswer: '-ln|cos(x)| + C',
  },
  // Definidas
  {
    integral: '∫[1,2] x² dx',
    options: ['7/3', '8/3', '9/3', '10/3'],
    correctAnswer: '7/3',
  },
  {
    integral: '∫[0,π/2] sin(x) dx',
    options: ['1', '0', '-1', '2'],
    correctAnswer: '1',
  },
  {
    integral: '∫[0,1] e^x dx',
    options: ['e - 1', 'e + 1', 'e', '1'],
    correctAnswer: 'e - 1',
  },
  {
    integral: '∫[1,3] 2x dx',
    options: ['8', '16', '4', '12'],
    correctAnswer: '8',
  },
  {
    integral: '∫[0,2] 3x² dx',
    options: ['8', '12', '4', '16'],
    correctAnswer: '8',
  },
  {
    integral: '∫[0,π] cos(x) dx',
    options: ['0', '1', '-1', '2'],
    correctAnswer: '0',
  },
  {
    integral: '∫[0,1] 1/x dx',
    options: ['∞', '1', '0', '-1'],
    correctAnswer: '∞',
  },
  {
    integral: '∫[0,π/4] tan(x) dx',
    options: ['ln(sqrt(2))', '1', '0', '2'],
    correctAnswer: 'ln(sqrt(2))',
  },
];

// Función para iniciar el juego
function startGame() {
  document.getElementById('start-screen').style.display = 'none';
  document.getElementById('game-screen').style.display = 'block';
  updateUI();
}

// Función para actualizar la interfaz
function updateUI() {
  const question = questions[questionIndex];
  const maxScore = questions.length * pointsPerQuestion;
  document.getElementById('integral-question').textContent = question.integral;
  document.getElementById('score').textContent = `${score}/${maxScore} puntos`;
  document.getElementById('lives').textContent = lives;
  document.getElementById('level-title').textContent = `Pregunta ${questionIndex + 1}/${questions.length}`;
  document.getElementById('result').textContent = ''; // Limpiar mensaje anterior

  // Mezclar las opciones de respuesta
  const shuffledOptions = shuffleArray([...question.options]);

  // Crear botones de opciones en lista vertical
  const optionsDiv = document.getElementById('options');
  optionsDiv.innerHTML = ''; // Limpiar opciones anteriores
  shuffledOptions.forEach((option) => {
    const optionDiv = document.createElement('div');
    const button = document.createElement('button');
    button.textContent = option;
    button.addEventListener('click', () => checkAnswer(option));
    optionDiv.appendChild(button);
    optionsDiv.appendChild(optionDiv);
  });

  // Iniciar el temporizador
  startTimer();
}

// Función para iniciar el temporizador
function startTimer() {
  let timeLeft = timeLimit;
  updateTimerDisplay(timeLeft); // Mostrar el tiempo inicial
  timer = setInterval(() => {
    timeLeft--;
    updateTimerDisplay(timeLeft); // Actualizar el tiempo mostrado
    if (timeLeft === 0) {
      clearInterval(timer);
      endQuestion();
    }
  }, 1000);
}

// Función para actualizar el tiempo mostrado
function updateTimerDisplay(timeLeft) {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
  const formattedSeconds = seconds < 10 ? `0${seconds}` : seconds;
  document.getElementById('timer').textContent = `Tiempo restante: ${formattedMinutes}:${formattedSeconds}`;
}

// Función para detener el temporizador
function clearTimer() {
  clearInterval(timer);
}

// Función para verificar la respuesta
function checkAnswer(selectedAnswer) {
  clearTimer(); // Detener el temporizador
  const maxScore = questions.length * pointsPerQuestion;
  if (selectedAnswer === questions[questionIndex].correctAnswer) {
    score += pointsPerQuestion;
    document.getElementById('result').textContent = '¡Correcto! Siguiente pregunta.';
    document.getElementById('result').style.color = 'green';
    setTimeout(nextLevel, 2000); // Esperar 2 segundos antes de pasar a la siguiente pregunta
  } else {
    lives--;
    document.getElementById('lives').textContent = lives;
    document.getElementById('result').textContent = 'Incorrecto. Inténtalo de nuevo.';
    document.getElementById('result').style.color = 'red';
    if (lives === 0) {
      endGame();
    }
  }
}

// Función para finalizar la pregunta por tiempo agotado
function endQuestion() {
  lives--;
  document.getElementById('lives').textContent = lives;
  document.getElementById('result').textContent = `¡Tiempo agotado! La respuesta correcta era: ${questions[questionIndex].correctAnswer}. Siguiente pregunta.`;
  document.getElementById('result').style.color = 'red';
  setTimeout(nextLevel, 2000); // Esperar 2 segundos antes de pasar a la siguiente pregunta
  if (lives === 0) {
    endGame();
  }
}

// Función para avanzar al siguiente nivel
function nextLevel() {
  if (lives > 0) { // Verificar si el juego ha terminado
    questionIndex++;
    if (questionIndex < questions.length) {
      updateUI();
    } else {
      document.getElementById('level-title').textContent = '¡Has completado el juego!';
      document.getElementById('options').classList.add('hidden');
      document.getElementById('next-level').classList.remove('hidden');
    }
  }
}

// Función para reiniciar el juego
function restartGame() {
  currentLevel = 1;
  score = 0;
  lives = 3;
  questionIndex = 0;
  updateUI();
  document.getElementById('options').classList.remove('hidden');
  document.getElementById('next-level').classList.add('hidden');
  document.getElementById('restart').classList.add('hidden');
}

// Función para finalizar el juego
function endGame() {
  clearTimer(); // Detener el temporizador
  updateTimerDisplay(0); // Mostrar "00:00" en el temporizador
  document.getElementById('result').textContent = 'Juego terminado. ¡Mejor suerte la próxima vez!';
  document.getElementById('options').classList.add('hidden');
  document.getElementById('restart').classList.remove('hidden');
}

// Eventos
document.getElementById('start-button').addEventListener('click', startGame);
document.getElementById('next-level').addEventListener('click', restartGame);
document.getElementById('restart').addEventListener('click', restartGame);