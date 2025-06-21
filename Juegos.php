<?php 
session_start();
include 'extend/header.php';

// Verificar si el usuario tiene plan premium
$esPremium = isset($_SESSION['plan_activo']) && $_SESSION['plan_activo'] !== 'básico';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Juegos Matemáticos | Desafía tu Mente</title>
  <link rel="stylesheet" href="css/estilos_Juegos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <meta name="description" content="3 juegos gratuitos y contenido premium para aprender cálculo integral">
 <style>
     body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      position: relative;
      background: transparent;
    }
    
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 0;
    }
    
    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, #7a00cc, #50008b);
      color: white;
      padding: 80px 0;
      text-align: center;
      position: relative;
      z-index: 2;
    }
    
    .hero-content h1 {
      font-size: 2.5rem;
      margin-bottom: 15px;
    }
    
    .hero-subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
    }
    
    /* Catálogo de Juegos */
    .games-catalog {
      position: relative;
      z-index: 2;
      padding: 40px 0;
      background: rgba(255, 255, 255, 0.9);
    }
    
    .game-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      overflow: hidden;
      transition: transform 0.3s;
    }
    
    .game-card:hover {
      transform: translateY(-5px);
    }
    
    .game-header {
      padding: 20px;
      border-bottom: 1px solid #eee;
    }
    
    .game-header h3 {
      margin: 0;
      color: white; /* Cambiado a blanco */
    }
    
    .difficulty {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }
    
    .difficulty-level {
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: bold;
    }
    
    .difficulty-level.easy {
      background: #e6f7e6;
      color: #2e7d32;
    }
    
    .difficulty-level.medium {
      background: #fff8e1;
      color: #ff8f00;
    }
    
    .difficulty-level.hard {
      background: #ffebee;
      color: #c62828;
    }
    
    .game-time {
      margin-left: 15px;
      font-size: 0.8rem;
      color: #666;
    }
    
    .game-content {
      display: flex;
      flex-wrap: wrap;
    }
    
    .game-image {
      flex: 1;
      min-width: 300px;
      position: relative;
    }
    
    .game-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .game-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(122, 0, 204, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s;
    }
    
    .game-card:hover .game-overlay {
      opacity: 1;
    }
    
    .play-button {
      background: white;
      color: #7a00cc;
      padding: 12px 25px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s;
    }
    
    .play-button:hover {
      background: #f0f0f0;
      transform: scale(1.05);
    }
    
    .play-button.disabled {
      background: #ccc;
      color: #666;
      cursor: not-allowed;
    }
    
    .game-description {
      flex: 1;
      min-width: 300px;
      padding: 20px;
    }
    
    .game-features {
      list-style: none;
      padding: 0;
      margin-top: 20px;
    }
    
    .game-features li {
      margin-bottom: 8px;
      color: #555;
    }
    
    .game-features i {
      color: #7a00cc;
      margin-right: 8px;
    }
    
    /* Estilos para juegos bloqueados */
    .game-card.blocked {
      position: relative;
      opacity: 0.9;
    }
    
    .game-card.blocked::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255,255,255,0.8);
      z-index: 1;
    }
    
    .blocked-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      text-align: center;
      width: 100%;
      padding: 0 20px;
    }
    
    .premium-badge {
      background: linear-gradient(135deg, #7a00cc, #50008b);
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.9rem;
      display: inline-block;
      margin-bottom: 15px;
    }
    
    .upgrade-button {
      background: linear-gradient(135deg, #7a00cc, #50008b);
      color: white;
      padding: 10px 25px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      margin-top: 10px;
      transition: all 0.3s;
    }
    
    .upgrade-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(122, 0, 204, 0.4);
    }
    
    /* Juegos destacados */
    .featured-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #ffc107;
      color: #333;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: bold;
      z-index: 3;
    }
    
    /* Burbuja de asesoría */
    .chat-bubble {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #7a00cc, #50008b);
      border-radius: 50%;
      display: <?= $esPremium ? 'flex' : 'none' ?>;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(122, 0, 204, 0.4);
      z-index: 1000;
      animation: pulse 2s infinite;
    }
    
    .chat-bubble i {
      color: white;
      font-size: 1.5rem;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    
    /* Panel de asesoría */
    .chat-panel {
      position: fixed;
      bottom: 100px;
      right: 30px;
      width: 300px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      padding: 15px;
      display: none;
      z-index: 1000;
      border: 2px solid #7a00cc;
    }
    
    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, #7a00cc, #50008b);
      color: white;
      text-align: center;
      padding: 60px 0;
      position: relative;
      z-index: 2;
    }
    
    .cta-section h2 {
      margin-bottom: 15px;
    }
    
    .cta-button {
      background: white;
      color: #7a00cc;
      padding: 12px 30px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      margin-top: 20px;
      transition: all 0.3s;
    }
    
    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Contenedor de partículas solo para la sección hero */
    .particles-container {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 1;
      pointer-events: none;
    }
 </style>
</head>

<body>
<!-- Hero Section con partículas solo aquí -->
<section class="hero">
    <div class="particles-container" id="particles-js"></div>
    <div class="hero-content">
        <h1><i class="fas fa-gamepad"></i> Juegos Matemáticos</h1>
        <p class="hero-subtitle">3 juegos gratuitos y contenido premium exclusivo</p>
    </div>
</section>

<!-- Catálogo de Juegos -->
<section class="games-catalog">
    <div class="container">
        <!-- Juego 1 - GRATIS -->
        <div class="game-card">
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Carrera de Integrales</h3>
                <div class="difficulty">
                    <span class="difficulty-level medium">Intermedio</span>
                    <span class="game-time"><i class="far fa-clock"></i> 15-20 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J1.png" alt="Juego de Integrales">
                    <div class="game-overlay">
                        <a href="Carrera.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="game-description">
                    <p>Pon a prueba tus conocimientos con este increíble juego que evalúa tu dominio de las integrales básicas.</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> 50 niveles progresivos</li>
                        <li><i class="fas fa-trophy"></i> Sistema de logros</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Juego 2 - GRATIS -->
        <div class="game-card">
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Memoria Matemática</h3>
                <div class="difficulty">
                    <span class="difficulty-level easy">Principiante</span>
                    <span class="game-time"><i class="far fa-clock"></i> 10-15 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J2.png" alt="Juego de Memoria Matemática">
                    <div class="game-overlay">
                        <a href="memorama.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="game-description">
                    <p>Pon a prueba tus conocimientos y tu memoria con este juego que combina cálculo integral con habilidades de memorización.</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> 3 modos de dificultad</li>
                        <li><i class="fas fa-brain"></i> Entrena tu memoria</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Juego 3 - GRATIS -->
        <div class="game-card">
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Cálculo Rápido</h3>
                <div class="difficulty">
                    <span class="difficulty-level hard">Avanzado</span>
                    <span class="game-time"><i class="far fa-clock"></i> 5-10 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J4.png" alt="Juego de Cálculo Rápido">
                    <div class="game-overlay">
                        <a href="Integral Quest.HTML" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="game-description">
                    <p>¿Puedes resolver problemas de integrales bajo presión? Demuestra tus habilidades en este desafío contra reloj.</p>
                    <ul class="game-features">
                        <li><i class="fas fa-bolt"></i> Modo velocidad</li>
                        <li><i class="fas fa-medal"></i> Tabla de clasificación</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Juego 4 - Construcción con Integrales (PREMIUM) -->
        <div class="game-card <?= $esPremium ? '' : 'blocked' ?>">
            <?php if(!$esPremium): ?>
            <div class="blocked-content">
                <span class="premium-badge">PREMIUM</span>
                <h3>Contenido Exclusivo</h3>
                <p>Desbloquea este juego con una suscripción premium</p>
                <a href="pre.php" class="upgrade-button">¡Quiero Premium!</a>
            </div>
            <?php endif; ?>
            
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Construcción con Integrales</h3>
                <div class="difficulty">
                    <span class="difficulty-level medium">Intermedio</span>
                    <span class="game-time"><i class="far fa-clock"></i> 20-30 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J7.png" alt="Juego Construcción con Integrales">
                    <div class="game-overlay">
                        <?php if($esPremium): ?>
                            <a href="Juego de bloques.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <div class="play-button disabled">Premium <i class="fas fa-lock"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="game-description">
                    <p>El desafío perfecto para perfeccionar tus cálculos de integrales.</p>
                    <ul class="game-features">
                        <li><i class="fas fa-star"></i> Desafíos exclusivos</li>
                        <li><i class="fas fa-graduation-cap"></i> Certificado virtual</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Juego 5 - Integral Us (PREMIUM) -->
        <div class="game-card <?= $esPremium ? '' : 'blocked' ?> featured">
            <?php if(!$esPremium): ?>
            <div class="blocked-content">
                <span class="premium-badge">PREMIUM</span>
                <h3>Contenido Exclusivo</h3>
                <p>Desbloquea este juego con una suscripción premium</p>
                <a href="pre.php" class="upgrade-button">¡Quiero Premium!</a>
            </div>
            <?php else: ?>
            <div class="featured-badge">RECOMENDADO</div>
            <?php endif; ?>
            
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Integral Us</h3>
                <div class="difficulty">
                    <span class="difficulty-level easy">Principiante</span>
                    <span class="game-time"><i class="far fa-clock"></i> 10-15 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J8.png" alt="Juego Integral Us">
                    <div class="game-overlay">
                        <?php if($esPremium): ?>
                            <a href="Integral US.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <div class="play-button disabled">Premium <i class="fas fa-lock"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="game-description">
                    <p>Aprende con este divertido juego mientras te diviertes. ¿Podrás pasarlo?</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> Innovador modo de dificultad</li>
                        <li><i class="fas fa-brain"></i> Entrena tu memoria</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Juego 6 - MATH WIZARDS (PREMIUM) -->
        <div class="game-card <?= $esPremium ? '' : 'blocked' ?> featured">
            <?php if(!$esPremium): ?>
            <div class="blocked-content">
                <span class="premium-badge">PREMIUM</span>
                <h3>Contenido Exclusivo</h3>
                <p>Desbloquea este juego con una suscripción premium</p>
                <a href="pre.php" class="upgrade-button">¡Quiero Premium!</a>
            </div>
            <?php else: ?>
            <div class="featured-badge">RECOMENDADO</div>
            <?php endif; ?>
            
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>MATH WIZARDS</h3>
                <div class="difficulty">
                    <span class="difficulty-level easy">Principiante</span>
                    <span class="game-time"><i class="far fa-clock"></i> 10-15 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J9.png" alt="Juego MATH WIZARDS">
                    <div class="game-overlay">
                        <?php if($esPremium): ?>
                            <a href="Hechizados.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <div class="play-button disabled">Premium <i class="fas fa-lock"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="game-description">
                    <p>Aprende con este divertido juego mientras te diviertes. ¿Podrás pasarlo?</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> Innovador modo de dificultad</li>
                        <li><i class="fas fa-brain"></i> Entrena tu memoria</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Juego 7 - Integral Bros (PREMIUM) -->
        <div class="game-card <?= $esPremium ? '' : 'blocked' ?> featured">
            <?php if(!$esPremium): ?>
            <div class="blocked-content">
                <span class="premium-badge">PREMIUM</span>
                <h3>Contenido Exclusivo</h3>
                <p>Desbloquea este juego con una suscripción premium</p>
                <a href="pre.php" class="upgrade-button">¡Quiero Premium!</a>
            </div>
            <?php else: ?>
            <div class="featured-badge">RECOMENDADO</div>
            <?php endif; ?>
            
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Integral Bros</h3>
                <div class="difficulty">
                    <span class="difficulty-level easy">Principiante</span>
                    <span class="game-time"><i class="far fa-clock"></i> 10-15 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J6.png" alt="Juego Integral Bros">
                    <div class="game-overlay">
                        <?php if($esPremium): ?>
                            <a href="Integral Bros.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <div class="play-button disabled">Premium <i class="fas fa-lock"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="game-description">
                    <p>Aprende con este divertido juego mientras te diviertes. ¿Podrás pasarlo?</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> Innovador modo de dificultad</li>
                        <li><i class="fas fa-brain"></i> Entretenido Y divertido</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Juego 8 - Serpientes y Integrales (PREMIUM) -->
        <div class="game-card <?= $esPremium ? '' : 'blocked' ?> featured">
            <?php if(!$esPremium): ?>
            <div class="blocked-content">
                <span class="premium-badge">PREMIUM</span>
                <h3>Contenido Exclusivo</h3>
                <p>Desbloquea este juego con una suscripción premium</p>
                <a href="pre.php" class="upgrade-button">¡Quiero Premium!</a>
            </div>
            <?php else: ?>
            <div class="featured-badge">RECOMENDADO</div>
            <?php endif; ?>
            
            <div class="game-header" style="background: linear-gradient(135deg, #7a00cc, #50008b);">
                <h3>Serpientes y Integrales</h3>
                <div class="difficulty">
                    <span class="difficulty-level easy">Principiante</span>
                    <span class="game-time"><i class="far fa-clock"></i> 10-15 min</span>
                </div>
            </div>
            <div class="game-content">
                <div class="game-image">
                    <img src="imagen/J0.png" alt="Juego Integral Bros">
                    <div class="game-overlay">
                        <?php if($esPremium): ?>
                            <a href="Serpiente y integrales.html" class="play-button">Jugar Ahora <i class="fas fa-play"></i></a>
                        <?php else: ?>
                            <div class="play-button disabled">Premium <i class="fas fa-lock"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="game-description">
                    <p>Aprende con este divertido juego mientras te diviertes. ¿Podrás pasarlo?</p>
                    <ul class="game-features">
                        <li><i class="fas fa-check-circle"></i> Innovador modo de dificultad</li>
                        <li><i class="fas fa-brain"></i> Entretenido Y divertido</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Llamado a la acción -->
<section class="cta-section">
    <div class="container">
        <h2>¿Quieres saber que tanto avanze haz logrado?</h2>
        <p>Haz este test y descubrelo!!</p>
        <a href="The Master ∫ Test.html" class="cta-button">Realizar test  <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

<!-- Script para las partículas -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
// Inicializar partículas solo en el contenedor hero
function initParticles() {
    if(typeof particlesJS !== 'undefined') {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5 },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2 }
            },
            interactivity: {
                detect_on: "window",
                events: {
                    onhover: { enable: true, mode: "grab" },
                    onclick: { enable: true, mode: "push" }
                }
            }
        });
    } else {
        console.log('Cargando particles.js...');
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
        script.onload = function() {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 50 },
                    color: { value: "#ffffff" },
                    shape: { type: "circle" },
                    move: { enable: true, speed: 2 }
                }
            });
        };
        document.body.appendChild(script);
    }
}

// Intentar inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initParticles);

// Si aún no carga, intentar después de un retraso
setTimeout(function() {
    if(!document.getElementById('particles-js').hasChildNodes()) {
        console.log('Reintentando carga de particles.js...');
        initParticles();
    }
}, 1000);
</script>
<?php include 'chat_bubble.php'; ?>

<?php include 'extend/footer.php'; ?>
</body>
</html>