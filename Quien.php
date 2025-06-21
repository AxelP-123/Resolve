<?php 
session_start();
include 'extend/header.php'; ?>
<title>💡 ¿Quiénes Somos?</title>
<head>
  <link rel="stylesheet" href="css/estilos_Quien.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Íconos -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<!-- Encabezado -->
<header>
  <h1><i class="fa-solid fa-lightbulb"></i> ¿Quiénes Somos?</h1>
</header>

<!-- Contenedor Principal -->
<main class="main-content">
  <div class="container">

    <section class="section">
      <h2><i class="fa-solid fa-rocket"></i> Nuestra Historia</h2>
      <p class="sub">Somos estudiantes de la carrera de Técnico en Informática. Este proyecto nació en el quinto semestre bajo el nombre: <em>Modelado de un Sistema para una Calculadora de Integrales Básicas</em>.</p>
      <p class="sub">Comenzamos en C++, pero evolucionamos a Java, logrando una interfaz más moderna. Hoy, nuestra calculadora está disponible tanto para escritorio como para dispositivos móviles.</p>
    </section>

    <section class="section">
      <h2><i class="fa-solid fa-bullseye"></i> Nuestro Objetivo</h2>
      <p class="sub">Facilitar el aprendizaje del cálculo integral a través de una herramienta educativa interactiva, explicando paso a paso cada operación y complementando con contenido en video.</p>
    </section>

    <section class="section">
      <h2><i class="fa-solid fa-eye"></i> Nuestra Visión</h2>
      <p class="sub">Convertirnos en la herramienta educativa líder para el aprendizaje del cálculo integral, ayudando a estudiantes de todo el mundo a dominar esta disciplina matemática.</p>
    </section>

    <section class="section">
      <h2><i class="fa-solid fa-flag-checkered"></i> Nuestra Misión</h2>
      <p class="sub">Ofrecer soluciones matemáticas confiables y detalladas, utilizando tecnología moderna para brindar una experiencia educativa clara, precisa y amigable.</p>
    </section>

    <section class="section">
      <h2><i class="fa-solid fa-users"></i> Nuestro Equipo</h2>
      <ul>
        
        <li><strong><i class="fa-solid fa-paint-brush"></i> Diseñadores Web:</strong> Equipo dedicado a interfaz de usuario (UI) y diseñadores de experiencia de usuario (UX).</li>
        <li><strong><i class="fa-solid fa-chalkboard-user"></i> Alejandro Coca Santillana:</strong> Experto en Matemáticas.</li>
      </ul>
    </section>

  </div>

  <!-- Llamado a la Acción -->
  <section class="cta">
    <h2><i class="fa-brands fa-firefox-browser"></i> Únete a Nuestra Comunidad</h2>
    <p>Síguenos en redes sociales y forma parte de nuestra misión educativa.</p>
  </section>
</main>
<?php include 'chat_bubble.php'; ?>
<?php include 'extend/footer.php'; ?>
