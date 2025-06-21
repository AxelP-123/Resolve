<!DOCTYPE html>
<html>
<head>
  <title>Integral Builder</title>
  <link rel="stylesheet" href="css/styleB.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
    <span class="navbar-toggler-icon"></span>
</head>
<body>
  <div class="container">
    <h1>Integral Builder</h1>
    <div id="function-input">
      <label for="function">Función: </label>
      <input type="text" id="function" value="x^2">
      <label for="start">Inicio: </label>
      <input type="number" id="start" value="0">
      <label for="end">Fin: </label>
      <input type="number" id="end" value="5">
      <button id="plot-button">Graficar</button>
    </div>
    <div id="canvas-container">
      <canvas id="function-chart"></canvas>
    </div>
    <div id="controls">
      <label for="rectangles">Rectángulos: </label>
      <input type="number" id="rectangles" value="10">
      <button id="calculate-button">Calcular Área</button>
    </div>
    <div id="results">
      <p>Área (Riemann): <span id="riemann-area"></span></p>
      <p>Área (Integral): <span id="integral-area"></span></p>
      <p>Error: <span id="error"></span></p>
    </div>
  </div>
  <script src="js/scriptB.js"></script>
</body>
</html>