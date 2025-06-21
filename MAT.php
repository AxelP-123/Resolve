<?php 
session_start();
include 'extend/header.php';?>

<title>📚 Material de Apoyo</title>
<head>
  <link rel="stylesheet" href="css/estilos_MAT.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<!-- Contenedor Principal -->
<div class="container">
    <section class="hero-section">
        <div class="hero-content">
            <h2>🎥 Recursos y Videos <span class="highlight"></span></h2>
            <p class="subtitle">Descubre material exclusivo que transformará tu comprensión del cálculo integral</p>
        </div>
    </section>
    
    <div class="grid-layout">
        <!-- Video principal con efecto glassmorphism -->
        <div class="video-card glass-card">
            <div class="video-container">
                <video controls poster="img/video-poster.jpg">
                    <source src="video/CI.MP4" type="video/mp4">
                    Tu navegador no soporta la etiqueta de video.
                </video>
            </div>
            <div class="video-info">
                <h3>Masterclass Integrales</h3>
                <p>Explicación completa desde cero hasta nivel avanzado</p>
            </div>
        </div>
        
        <!-- Recursos adicionales en formato tarjetas premium -->
        <div class="resource-card">
            <div class="card-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="card-content">
                <h3>Introducción a las Integrales</h3>
                <p>Fundamentos teóricos y primeros pasos prácticos</p>
                <a href="https://youtu.be/YmDa_V4aUdA?si=Oiovv19XRGFRjsYH" target="_blank" class="premium-btn">
                    Ver Video <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-corner">
                <i class="fas fa-crown"></i>
            </div>
        </div>
        
        <div class="resource-card">
            <div class="card-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-content">
                <h3>Integrales Inmediatas</h3>
                <p>Técnicas avanzadas y resolución paso a paso</p>
                <a href="https://youtu.be/pahYiU72jsE?si=NtHVcsnabWIMXeCD" target="_blank" class="premium-btn">
                    Ver Video <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-corner">
                <i class="fas fa-star"></i>
            </div>
        </div>
        
        <div class="resource-card featured">
            <div class="card-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="card-content">
                <h3>Canal del Profesor</h3>
                <p>Accede a todo el contenido educativo disponible</p>
                <a href="https://youtube.com/@alejandrococa?si=opBpbQpj215ua2eZ" target="_blank" class="premium-btn">
                    Visitar Canal <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="card-corner">
                <i class="fas fa-rocket"></i>
            </div>
            <div class="featured-badge">RECOMENDADO</div>
        </div>
    </div>
</div>

<!-- Llamado a la Acción con efecto neón -->
<section class="cta-neon">
    <div class="neon-text">
        <h2>Domina las Integrales Hoy</h2>
        <p>Obten la version Pro AHORA </p>
    </div>
    <button onclick="window.location.href='pre.php'" class="neon-btn">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Obtener ahora 
    </button>
</section>
<?php include 'chat_bubble.php'; ?>
<?php include 'extend/footer.php';?>