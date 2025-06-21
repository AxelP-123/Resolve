<?php

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: pre.php");
    exit();
}

// Obtener número de comentarios para el badge
$archivo_comentarios = 'comentarios.json';
$total_comentarios = 0;
if (file_exists($archivo_comentarios)) {
    $comentarios = json_decode(file_get_contents($archivo_comentarios), true);
    $total_comentarios = is_array($comentarios) ? count($comentarios) : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos del header personalizado */
        .admin-header {
            background: linear-gradient(145deg, #4b1c71, #7f4ca5);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .admin-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .admin-logo i {
            margin-right: 10px;
            font-size: 1.8rem;
        }
        
        .admin-menu {
            display: flex;
            gap: 1.5rem;
        }
        
        .admin-menu a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .admin-menu a:hover, .admin-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .admin-menu a i {
            margin-right: 8px;
        }
        
        .admin-menu .active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .admin-badge {
            background: #ffd700;
            color: #4b1c71;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            margin-left: 5px;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .admin-nav {
                flex-wrap: wrap;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .admin-menu {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 0.5rem;
                margin-top: 1rem;
            }
            
            .admin-menu.active {
                display: flex;
            }
            
            .admin-menu a {
                padding: 0.8rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <nav class="admin-nav">
            <a href="admin.php" class="admin-logo">
                <i class="fas fa-shield-alt"></i>
                <span>Panel Admin</span>
            </a>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="admin-menu" id="adminMenu">
                <a href="admin.php" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i>
                    Dudas
                </a>
                <a href="comentarios.php" class="<?= basename($_SERVER['PHP_SELF']) == 'comentarios.php' ? 'active' : '' ?>">
                    <i class="fas fa-comments"></i>
                    Comentarios
                    <?php if ($total_comentarios > 0): ?>
                        <span class="admin-badge"><?= $total_comentarios ?></span>
                    <?php endif; ?>
                </a>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </a>
            </div>
        </nav>
    </header>

    <script>
        // Menú móvil
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const menu = document.getElementById('adminMenu');
            menu.classList.toggle('active');
            
            // Cambiar icono
            const icon = this.querySelector('i');
            if (menu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // Cerrar menú al hacer clic en un enlace (para móviles)
        document.querySelectorAll('#adminMenu a').forEach(link => {
            link.addEventListener('click', function() {
                const menu = document.getElementById('adminMenu');
                if (window.innerWidth <= 768) {
                    menu.classList.remove('active');
                    document.querySelector('#mobileMenuToggle i').classList.remove('fa-times');
                    document.querySelector('#mobileMenuToggle i').classList.add('fa-bars');
                }
            });
        });
    </script>