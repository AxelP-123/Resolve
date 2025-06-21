<?php 
session_start();
include 'extend/header.php'; ?>
<head>
    <link rel="stylesheet" href="css/estilos_USO.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Cómo usar Re∫olve_App - Calculadora de Integrales Avanzada</title>
    <link rel="stylesheet" href="css/estilos_USO.css">
    <meta name="description" content="Aprende a usar Re∫olve_App, la calculadora de integrales con explicaciones paso a paso y material de apoyo educativo">
</head>

<main class="uso-container">
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Domina el cálculo integral con <span>Re∫olve_App</span></h1>
            <p class="hero-subtitle">La herramienta definitiva para resolver integrales con explicaciones detalladas</p>
        </div>
        <div class="hero-decoration">
            <div class="math-symbol">∫</div>
            <div class="math-symbol">∑</div>
            <div class="math-symbol">∞</div>
        </div>
    </section>

    <section class="video-demo">
        <div class="section-header">
            <h2><i class="fas fa-play-circle"></i> Demostración en video</h2>
            <p>Mira cómo funciona nuestra calculadora de integrales en menos de 2 minutos</p>
        </div>
      <video controls poster="img/video-poster.jpg">
            <!-- controls: Es necesario para que el video tenga controles de reproducción (play, pausa, volumen, etc.). -->
            <source src="video/DE.mp4" type="video/mp4">
        </video>
    
    </section>

    <section class="steps-section">
        <div class="section-header">
            <h2><i class="fas fa-list-ol"></i> Proceso paso a paso</h2>
            <p>Así de fácil es resolver integrales con nuestra aplicación</p>
        </div>

        <div class="steps-timeline">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Ingreso de términos</h3>
                    <p>Especifica cuántos términos tiene tu expresión a integrar. La interfaz es intuitiva y guiada.</p>
                    <div class="step-image">
                        
                    </div>
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Variables y exponentes</h3>
                    <p>Ingresa los coeficientes, variables y exponentes de cada término. Soporte para múltiples variables.</p>
                    <div class="step-image">
                        
                    </div>
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Resolución detallada</h3>
                    <p>Obtén cada paso de la integración con explicaciones matemáticas precisas.</p>
                    <div class="step-image">
                        
                    </div>
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Validación automática</h3>
                    <p>El sistema detecta posibles errores y sugiere correcciones basadas en reglas matemáticas.</p>
                    <div class="step-image">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="resources-section">
        <div class="section-header">
            <h2><i class="fas fa-book-open"></i> Material de apoyo</h2>
            <p>Complementa tu aprendizaje con estos recursos educativos</p>
        </div>

        <div class="resources-grid">
            <div class="resource-card">
                <div class="resource-icon"><i class="fas fa-video"></i></div>
                <h3>Video tutoriales</h3>
                <p>Colección de videos explicativos del profesor Alejandro Coca Santillana</p>
                <a href="MAT.php" class="resource-link">Ver videos <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="resource-card">
                <div class="resource-icon"><i class="fas fa-file-pdf"></i></div>
                <h3>Aplicacion </h3>
                <p>Descarga la app y conoce los procedimientos de la integracion</p>
                <a href="DESCARGA.php" class="resource-link">Descargar <i class="fas fa-arrow-down"></i></a>
            </div>

            <div class="resource-card">
                <div class="resource-icon"><i class="fas fa-question-circle"></i></div>
                <h3>Centro de ayuda</h3>
                <p>Tienes una duda queja o sugerencia??</p>
                <a href="_CON.php" class="resource-link">compartenoslo<i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>¿Listo para dominar las integrales?</h2>
        <p>Descarga Re∫olve_App ahora y accede a todas estas funcionalidades</p>
        <div class="cta-buttons">
            <a href="DESCARGA.PHP" class="cta-button primary">
                <i class="fas fa-download"></i> Descargar ahora
            </a>
            <a href="MAT.php" class="cta-button secondary">
                <i class="fas fa-book"></i> Ver material educativo
            </a>
        </div>
    </section>
</main>
<?php include 'chat_bubble.php'; ?>
<?php include 'extend/footer.php'; ?>