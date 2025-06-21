<?php 
session_start();
include 'extend/header.php'; ?>

<head>
    <title>Descargar Re∫olve_App - Calculadora de Integrales Premium</title>
    <link rel="stylesheet" href="css/estilos_DESCARGA.css">
    <meta name="description" content="Descarga la app Re∫olve para resolver integrales con explicaciones paso a paso. Disponible para Android, iOS y PC">
</head>

<main class="download-container">
    <section class="download-hero">
        <div class="hero-content">

                    <a href="pre.php" class="download-btn">
                        <span>OBTEN VERSION PREMIUM </span>
                        <small>Conoce nuestros planes</small>
                    </a>
                
            <h1 class="hero-title">Desbloquea el poder del <span>cálculo integral</span></h1>
            <p class="hero-subtitle">Descarga la herramienta definitiva para estudiantes y profesionales</p>
            
            <div class="download-platforms">
                <div class="platform-card">
                    <div class="platform-icon android">
                        <i class="fab fa-android"></i>
                    </div>
                    <h3>Android</h3>
                    <a href="app/ReSolve V1.06.apk" class="download-btn" download>
                        <span>Descargar APK</span>
                        <small>v2.3.1 (45 MB)</small>
                    </a>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon ios">
                        <i class="fab fa-apple"></i>
                    </div>
                    <h3>iOS</h3>
                    <a href="app/ReSolve V1.06.apk" class="download-btn" download>
                        <span>App Store</span>
                        <small>Requiere iOS 13+</small>
                    </a>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon windows">
                        <i class="fab fa-windows"></i>
                    </div>
                    <h3>Windows</h3>
                    <a href="#" class="download-btn" download>
                        <span>Instalador</span>
                        <small>v2.3.1 (78 MB)</small>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="hero-preview">
            <div class="phone-mockup">
                <div class="screen">
                    <img src="imagen/ftid.jpg" alt="Interfaz de Re∫olve_App">
                </div>
            </div>
            <div class="floating-math">
                <span>∫</span>
                <span>∑</span>
                <span>∞</span>
            </div>
        </div>
    </section>

    <section class="features-section">
        <h2 class="section-title"><i class="fas fa-star"></i> ¿Qué incluye la Aplicacion?</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                <h3>Resolución paso a paso</h3>
                <p>Explicaciones detalladas de cada paso en la resolución</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Juegos Interactivos </h3>
                <p>Aprende de manera didactica y divertida!</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-book"></i></div>
                <h3>Material de apoyo</h3>
                <p>Acceso a videos y material interactivo</p>
            </div>
        </div>
    </section>

    <section class="system-requirements">
        <h2 class="section-title"><i class="fas fa-laptop"></i> Requisitos del sistema</h2>
        
        <div class="requirements-grid">
            <div class="requirement-card">
                <h3><i class="fab fa-android"></i> Android</h3>
                <ul>
                    <li>Versión 8.0 o superior</li>
                    <li>2 GB de RAM mínimo</li>
                    <li>50 MB de espacio libre</li>
                </ul>
            </div>
            
            <div class="requirement-card">
                <h3><i class="fab fa-apple"></i> iOS</h3>
                <ul>
                    <li>iPhone 6s o posterior</li>
                    <li>iOS 13.0 o superior</li>
                    <li>60 MB de espacio libre</li>
                </ul>
            </div>
            
            <div class="requirement-card">
                <h3><i class="fab fa-windows"></i> Windows</h3>
                <ul>
                    <li>Windows 10/11</li>
                    <li>4 GB de RAM recomendado</li>
                    <li>100 MB de espacio en disco</li>
                </ul>
            </div>
        </div>
    </section>
</main>
<?php include 'chat_bubble.php'; ?>
<?php include 'extend/footer.php'; ?>