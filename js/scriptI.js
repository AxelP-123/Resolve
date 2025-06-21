// Variables
let lives = 3;
let correctAnswersCount = 0;

const questions = [
  { clue: "Integral de x^2 dx", answer: "X3/3", position: [1, 1], direction: "H" },
  { clue: "Integral de sen(x) dx", answer: "-COSX", position: [3, 2], direction: "V" },
  { clue: "Integral de e^x dx", answer: "EX", position: [5, 5], direction: "H" },
  { clue: "Integral de 1/x dx", answer: "LNX", position: [7, 3], direction: "V" },
  { clue: "Integral de cos(x) dx", answer: "SENX", position: [2, 6], direction: "H" },
  { clue: "Integral de tan(x) dx", answer: "LNSECX", position: [0, 0], direction: "H" },
  { clue: "Integral de sec^2(x) dx", answer: "TANX", position: [4, 0], direction: "H" },
  { clue: "Integral de 0 dx", answer: "C", position: [6, 0], direction: "H" },
  { clue: "Integral de a^x dx", answer: "A^X/LNA", position: [8, 1], direction: "H" },
  { clue: "Integral de 1/(1+x^2) dx", answer: "ARCTANX", position: [9, 0], direction: "H" }
];

const answers = questions.map(q => q.answer.toLowerCase());
let grid = Array(10).fill().map(() => Array(10).fill(''));

// Crear el crucigrama vacío
function createGrid() {
  const gridElement = document.getElementById('grid');
  gridElement.innerHTML = '';  // Limpiar el grid antes de crear uno nuevo
  for (let i = 0; i < 10; i++) {
    for (let j = 0; j < 10; j++) {
      const cell = document.createElement('div');
      cell.classList.add('cell');
      cell.dataset.row = i;
      cell.dataset.col = j;
      gridElement.appendChild(cell);
    }
  }
}

// Mostrar preguntas
function displayQuestions() {
  const questionsList = document.getElementById('questionsList');
  questionsList.innerHTML = '';  // Limpiar la lista de preguntas
  questions.forEach(q => {
    const listItem = document.createElement('li');
    listItem.textContent = q.clue;
    questionsList.appendChild(listItem);
  });
}

// Enviar respuesta
function submitAnswer() {
  const userInput = document.getElementById("answerInput").value.toLowerCase();
  let correct = false;

  answers.forEach((answer, index) => {
    if (userInput === answer) {
      correct = true;
      correctAnswersCount++;
      alert("¡Respuesta Correcta!");
      highlightCorrectCells(index);
      if (correctAnswersCount === answers.length) {
        endGame("¡Ganaste! Has respondido todas las preguntas correctamente.");
      }
    }
  });

  if (!correct) {
    lives--;
    document.getElementById("lives").textContent = `Vidas restantes: ${lives}`;
    if (lives === 0) {
      endGame("¡Perdiste! Has agotado todas tus vidas.");
    } else {
      alert("Respuesta Incorrecta, intenta de nuevo.");
    }
  }

  document.getElementById("answerInput").value = ''; // Limpiar el campo de respuesta
}

// Finalizar juego
function endGame(message) {
  alert(message);
  document.getElementById("answerInput").disabled = true; // Deshabilitar el input de respuesta
  document.querySelector(".btn").disabled = true; // Deshabilitar el botón de envío
}

// Resaltar celdas correctas
function highlightCorrectCells(index) {
  const { position, direction, answer } = questions[index];
  let row = position[0], col = position[1];

  for (let i = 0; i < answer.length; i++) {
    const cell = document.querySelector(`[data-row="${row}"][data-col="${col + i}"]`);
    if (direction === 'V') {
      row++;
    } else {
      col++;
    }
    cell.textContent = answer[i].toUpperCase();  // Mostrar la respuesta en la celda
    cell.classList.add('correct');
  }
}

// Reiniciar el juego
function resetGame() {
  lives = 3;
  correctAnswersCount = 0;
  document.getElementById("lives").textContent = `Vidas restantes: ${lives}`;
  document.getElementById("answerInput").disabled = false;
  document.querySelector(".btn").disabled = false;
  createGrid();  // Regenerar el grid vacío
  displayQuestions();  // Regenerar las preguntas
}

// Inicializar el juego
document.addEventListener("DOMContentLoaded", () => {
  createGrid();
  displayQuestions();
});
