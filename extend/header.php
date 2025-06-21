<?php
// Iniciar sesión si es necesario


// Aquí puedes incluir cualquier lógica PHP necesaria antes del HTML
// Por ejemplo: verificaciones de sesión, redirecciones, etc.

// Ejemplo de cómo debería usarse para redirecciones:
// if (!isset($_SESSION['usuario'])) {
//     header('Location: login.php');
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Re∫olve_App - La mejor aplicación para resolver integrales con explicaciones paso a paso">
  <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Estructura principal del header */
    .main-header {
      background: linear-gradient(135deg, #4e008c 0%, #3a0068 100%);
      color: #fff;
      padding: 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 2rem;
      flex-wrap: wrap;
      position: relative;
    }
    
    .logo a {
      color: #fff;
      font-size: 1.8rem;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 1rem 0;
    }
    
    .logo a:hover {
      color: #ffd700;
      transform: scale(1.02);
    }
    
    /* Menú principal */
    .main-nav ul {
      display: flex;
      list-style: none;
      gap: 0.5rem;
      margin: 0;
      padding: 0;
      align-items: center;
    }
    
    .main-nav a {
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 1rem 1.2rem;
      position: relative;
      border-radius: 5px;
      font-size: 0.95rem;
    }
    
    .main-nav a:hover {
      color: #ffd700;
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    .main-nav a.active {
      color: #ffd700;
      font-weight: 600;
    }
    
    .main-nav a.active::after {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60%;
      height: 2px;
      background-color: #ffd700;
    }
    
    /* Menú de usuario */
    .user-dropdown {
      position: relative;
      margin-left: 0.5rem;
    }
    
    .user-btn {
      background-color: #5a00a3;
      color: white;
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    
    .user-btn:hover {
      background-color: #7a00cc;
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .user-dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #5a00a3;
      min-width: 220px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      z-index: 100;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 5px;
      animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .user-dropdown:hover .user-dropdown-content,
    .user-dropdown:focus-within .user-dropdown-content {
      display: block;
    }
    
    .user-dropdown-content a {
      color: white;
      padding: 0.8rem 1.2rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      transition: all 0.2s ease;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .user-dropdown-content a:last-child {
      border-bottom: none;
    }
    
    .user-dropdown-content a:hover {
      background-color: #7a00cc;
      padding-left: 1.5rem;
    }
    
    .user-dropdown-content i {
      width: 20px;
      text-align: center;
    }
    
    /* Menú móvil */
    .mobile-menu-toggle {
      display: none;
      background: none;
      border: none;
      color: #fff;
      font-size: 1.8rem;
      cursor: pointer;
      padding: 0.5rem;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    
    .mobile-menu-toggle:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    /* Overlay para móvil */
    .mobile-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 900;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .mobile-overlay.active {
      opacity: 1;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
      .header-container {
        padding: 0 1.5rem;
      }
      
      .main-nav a {
        padding: 1rem 0.8rem;
        font-size: 0.9rem;
      }
    }
    
    @media (max-width: 992px) {
      .main-nav ul {
        gap: 0.3rem;
      }
      
      .main-nav a {
        padding: 1rem 0.6rem;
      }
      
      .user-btn {
        padding: 0.5rem 1rem;
      }
    }
    
    @media (max-width: 768px) {
      .header-container {
        padding: 0 1rem;
      }
      
      .logo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0.8rem 0;
      }
      
      .mobile-menu-toggle {
        display: block;
      }
      
      .main-nav {
        display: none;
        position: fixed;
        top: 0;
        right: -100%;
        width: 85%;
        max-width: 350px;
        height: 100vh;
        background: linear-gradient(135deg, #4e008c 0%, #3a0068 100%);
        z-index: 950;
        transition: right 0.4s ease;
        padding: 1.5rem;
        box-shadow: -5px 0 15px rgba(0,0,0,0.3);
        overflow-y: auto;
      }
      
      .main-nav.active {
        display: block;
        right: 0;
      }
      
      .main-nav ul {
        flex-direction: column;
        gap: 0;
        margin-top: 2rem;
      }
      
      .main-nav li {
        width: 100%;
        border-bottom: 1px solid rgba(255,255,255,0.1);
      }
      
      .main-nav a {
        padding: 1.2rem 1rem;
        border-radius: 0;
        justify-content: flex-start;
      }
      
      .main-nav a::after {
        display: none;
      }
      
      .main-nav a.active {
        background-color: rgba(255, 255, 255, 0.1);
      }
      
      .user-dropdown {
        margin-left: 0;
        width: 100%;
        margin-top: 1rem;
      }
      
      .user-btn {
        width: 100%;
        border-radius: 5px;
        justify-content: space-between;
        padding: 1rem;
      }
      
      .user-dropdown-content {
        position: static;
        width: 100%;
        box-shadow: none;
        border-radius: 0;
        background-color: rgba(0,0,0,0.2);
        margin-top: 0;
        animation: none;
      }
      
      .user-dropdown-content a {
        padding-left: 2rem;
      }
    }
    
    @media (max-width: 480px) {
      .logo a {
        font-size: 1.5rem;
      }
      
      .mobile-menu-toggle {
        font-size: 1.5rem;
      }
      
      .main-nav {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <header class="main-header">
    <div class="header-container">
      <div class="logo">
        <a href="index.php">
          <i class="fas fa-integral"></i>
          Re∫olve_App
        </a>
        <button class="mobile-menu-toggle" aria-label="Menú">
          <i class="fas fa-bars"></i>
        </button>
      </div>
      <div class="mobile-overlay" id="mobileOverlay"></div>
      <nav class="main-nav" id="mainNav">
        <ul>
          <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> Inicio</a></li>
          <li><a href="USO.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'USO.php' ? 'active' : '' ?>"><i class="fas fa-book-open"></i> ¿Cómo se usa?</a></li>
          <li><a href="DESCARGA.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'DESCARGA.php' ? 'active' : '' ?>"><i class="fas fa-download"></i> Descargar</a></li>
          <li><a href="MAT.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'MAT.php' ? 'active' : '' ?>"><i class="fas fa-book"></i> Material de apoyo</a></li>
          <li><a href="Juegos.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'Juegos.php' ? 'active' : '' ?>"><i class="fas fa-gamepad"></i> Juegos</a></li>
          <li><a href="_CON.php" class="<?php echo basename($_SERVER['PHP_SELF']) == '_CON.php' ? 'active' : '' ?>"><i class="fas fa-envelope"></i> Contacto</a></li>
          <li><a href="Quien.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'Quien.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> ¿Quiénes somos?</a></li>
          <li><a href="pre.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'pre.php' ? 'active' : '' ?>"><i class="fas fa-crown"></i> Pro</a></li>
          <?php if(isset($_SESSION['usuario_autenticado']) && $_SESSION['usuario_autenticado']): ?>
          <li class="user-dropdown">
            <button class="user-btn">
              <i class="fas fa-user-circle"></i>
              <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>
              <i class="fas fa-caret-down"></i>
            </button>
            <div class="user-dropdown-content">
              <a href="perfil.php"><i class="fas fa-user"></i> Mi perfil</a>
              <a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a>
              <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            </div>
          </li>
          <?php else: ?>
          <li><a href="login.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>
  <main>

  <script>
    // Menú móvil mejorado
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.getElementById('mainNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    
    // Alternar menú móvil
    menuToggle.addEventListener('click', function() {
      mainNav.classList.toggle('active');
      mobileOverlay.classList.toggle('active');
      document.body.style.overflow = mainNav.classList.contains('active') ? 'hidden' : '';
    });
    
    // Cerrar menú al hacer clic en el overlay
    mobileOverlay.addEventListener('click', function() {
      mainNav.classList.remove('active');
      mobileOverlay.classList.remove('active');
      document.body.style.overflow = '';
    });
    
    // Cerrar menú al hacer clic en un enlace (para móviles)
    document.querySelectorAll('.main-nav a').forEach(link => {
      link.addEventListener('click', function() {
        if(window.innerWidth <= 768) {
          mainNav.classList.remove('active');
          mobileOverlay.classList.remove('active');
          document.body.style.overflow = '';
        }
      });
    });
    
    // Cerrar menú al cambiar el tamaño de la pantalla
    window.addEventListener('resize', function() {
      if(window.innerWidth > 768) {
        mainNav.classList.remove('active');
        mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  </script>