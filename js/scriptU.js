const pairs = [
  { integral: '∫3x² dx', answer: 'x^3 + C' },
  { integral: '∫sin(x) dx', answer: '-cos(x) + C' },
  { integral: '∫1/x dx', answer: 'ln|x| + C' },
  { integral: '∫tan(x) dx', answer: '-ln|cos(x)| + C' },
  { integral: '∫[1,2] x² dx', answer: '7/3' },
  { integral: '∫[0,π/2] sin(x) dx', answer: '1' },
  { integral: '∫[0,1] e^x dx', answer: 'e - 1' },
  { integral: '∫[1,3] 2x dx', answer: '8' },
  { integral: '∫[0,2] 3x² dx', answer: '8' },
  { integral: '∫[0,π] cos(x) dx', answer: '0' },
];

const cards = [];
pairs.forEach(pair => {
  cards.push({ type: 'integral', content: pair.integral });
  cards.push({ type: 'answer', content: pair.answer });
});

const shuffledCards = shuffleArray(cards);

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

let flippedCards = [];
let matchedCards = [];
let attempts = 0;

const gameBoard = document.getElementById('game-board');
const attemptsDisplay = document.getElementById('attempts');
const resultMessage = document.getElementById('result-message');

function createBoard() {
  shuffledCards.forEach((card, index) => {
    const cardElement = document.createElement('div');
    cardElement.classList.add('card');
    cardElement.dataset.index = index;
    cardElement.textContent = card.content;
    cardElement.addEventListener('click', () => selectCard(index));
    gameBoard.appendChild(cardElement);
  });
}

function selectCard(index) {
  if (flippedCards.length < 2 && !flippedCards.includes(index) && !matchedCards.includes(index)) {
    flippedCards.push(index);

    // Agregar la clase 'selected' para indicar que la carta está seleccionada
    const cardElement = document.querySelector(`[data-index="${index}"]`);
    cardElement.classList.add('selected');

    if (flippedCards.length === 2) {
      attempts++;
      attemptsDisplay.textContent = attempts;
      const firstCard = shuffledCards[flippedCards[0]];
      const secondCard = shuffledCards[flippedCards[1]];
      if ((firstCard.type === 'integral' && secondCard.type === 'answer' &&
           pairs.some(pair => pair.integral === firstCard.content && pair.answer === secondCard.content)) ||
          (firstCard.type === 'answer' && secondCard.type === 'integral' &&
           pairs.some(pair => pair.integral === secondCard.content && pair.answer === firstCard.content))) {
        resultMessage.textContent = '¡Respuesta correcta!';
        resultMessage.classList.add('correct');
        setTimeout(() => {
          resultMessage.textContent = '';
          resultMessage.classList.remove('correct', 'incorrect');
          flippedCards.forEach(matchedIndex => {
            const matchedCard = document.querySelector(`[data-index="${matchedIndex}"]`);
            matchedCard.classList.remove('selected');
            matchedCard.classList.add('matched');
            matchedCards.push(matchedIndex);
          });
          flippedCards = [];
        }, 2000);
        if (matchedCards.length === shuffledCards.length) {
          endGame();
        }
      } else {
        resultMessage.textContent = 'Respuesta incorrecta. Intenta de nuevo.';
        resultMessage.classList.add('incorrect');
        setTimeout(() => {
          resultMessage.textContent = '';
          resultMessage.classList.remove('correct', 'incorrect');
          flippedCards.forEach(incorrectIndex => {
            const incorrectCard = document.querySelector(`[data-index="${incorrectIndex}"]`);
            incorrectCard.classList.remove('selected');
          });
          flippedCards = [];
        }, 2000);
      }
    }
  }
}

function endGame() {
  alert(`¡Has ganado en ${attempts} intentos!`);
}

createBoard();