const functionInput = document.getElementById('function');
const startInput = document.getElementById('start');
const endInput = document.getElementById('end');
const rectanglesInput = document.getElementById('rectangles');
const plotButton = document.getElementById('plot-button');
const calculateButton = document.getElementById('calculate-button');
const riemannAreaDisplay = document.getElementById('riemann-area');
const integralAreaDisplay = document.getElementById('integral-area');
const errorDisplay = document.getElementById('error');
const canvas = document.getElementById('function-chart').getContext('2d');
let chart;

function plotFunction() {
  const functionString = functionInput.value;
  const start = parseFloat(startInput.value);
  const end = parseFloat(endInput.value);
  const points = [];
  let maxY = -Infinity;
  let minY = Infinity;
  let maxX = -Infinity;
  let minX = Infinity;

  // Generar puntos para la gráfica
  for (let x = start; x <= end; x += 0.1) {
    const y = eval(functionString.replace('x', x));
    points.push({ x: x, y: y });
    maxY = Math.max(maxY, y);
    minY = Math.min(minY, y);
    maxX = Math.max(maxX, x);
    minX = Math.min(minX, x);
  }

  if (chart) {
    chart.destroy();
  }

  // Ajustar los límites de los ejes para mostrar negativos y positivos
  const xRange = Math.max(Math.abs(minX), Math.abs(maxX));
  const yRange = Math.max(Math.abs(minY), Math.abs(maxY));

  chart = new Chart(canvas, {
    type: 'line',
    data: {
      datasets: [{
        label: functionString,
        data: points,
        borderColor: '#4b1c71',
        fill: false,
      }],
    },
    options: {
      scales: {
        x: {
          type: 'linear',
          position: 'center',
          grid: {
            color: 'rgba(0, 0, 0, 0.1)',
          },
          ticks: {
            color: 'black',
            maxTicksLimit: 10,
            callback: function (value, index, values) {
              if (Number.isInteger(value)) {
                return value.toLocaleString();
              } else if (Math.abs(value) >= 1000) {
                return value.toLocaleString();
              } else if (Math.abs(value) <= 0.01) {
                return value.toFixed(3);
              } else {
                return value.toFixed(2);
              }
            },
          },
          min: -xRange * 1.2,
          max: xRange * 1.2,
        },
        y: {
          type: 'linear',
          position: 'center',
          grid: {
            color: 'rgba(0, 0, 0, 0.1)',
          },
          ticks: {
            color: 'black',
            maxTicksLimit: 10,
            callback: function (value, index, values) {
              if (Number.isInteger(value)) {
                return value.toLocaleString();
              } else if (Math.abs(value) >= 1000) {
                return value.toLocaleString();
              } else if (Math.abs(value) <= 0.01) {
                return value.toFixed(3);
              } else {
                return value.toFixed(2);
              }
            },
          },
          min: -yRange * 1.2,
          max: yRange * 1.2,
        },
      },
      plugins: {
        legend: {
          labels: {
            color: 'black',
          },
        },
      },
    },
  });
}

function calculateRiemannSum() {
  const functionString = functionInput.value;
  const start = parseFloat(startInput.value);
  const end = parseFloat(endInput.value);
  const numRectangles = parseInt(rectanglesInput.value);
  const width = (end - start) / numRectangles;
  let area = 0;
  for (let i = 0; i < numRectangles; i++) {
    const x = start + i * width;
    area += eval(functionString.replace('x', x)) * width;
  }
  riemannAreaDisplay.textContent = area.toFixed(2);
  return area;
}

function calculateIntegral() {
  const functionString = functionInput.value;
  const start = parseFloat(startInput.value);
  const end = parseFloat(endInput.value);
  let integral;
  if (functionString === 'x^2') {
    integral = (Math.pow(end, 3) - Math.pow(start, 3)) / 3;
  } else if (functionString === '2*x') {
    integral = Math.pow(end, 2) - Math.pow(start, 2);
  } else if (functionString === 'sin(x)') {
    integral = -Math.cos(end) + Math.cos(start);
  } else {
    integral = 0;
  }
  integralAreaDisplay.textContent = integral.toFixed(2);
  return integral;
}

function evaluatePrecision() {
  const riemannArea = calculateRiemannSum();
  const integralArea = calculateIntegral();
  const error = Math.abs(riemannArea - integralArea);
  errorDisplay.textContent = error.toFixed(2);
}

plotButton.addEventListener('click', plotFunction);
calculateButton.addEventListener('click', evaluatePrecision);

console.log(`
  Explicación de cómo se calcula el área:

  Área (Riemann):
  - Se aproxima el área bajo la curva dividiéndola en rectángulos.
  - Se suma el área de cada rectángulo para obtener una aproximación del área total.
  - La precisión depende del número de rectángulos (más rectángulos = más precisión).

  Área (Integral):
  - Se calcula el área exacta utilizando la integral definida.
  - La integral definida es un concepto del cálculo que da el área exacta bajo la curva.

  Error:
  - Es la diferencia entre el área aproximada (Riemann) y el área exacta (Integral).
  - Indica la precisión de la aproximación de la suma de Riemann.
`);