<?php
session_start();
$archivo_usuarios = 'usuarios.json';

// Cargar usuarios existentes
$usuarios = file_exists($archivo_usuarios) ? json_decode(file_get_contents($archivo_usuarios), true) : [];

// 1. Procesar registro
if (isset($_POST['registrar'])) {
    $nuevoUsuario = trim($_POST['nuevo_usuario'] ?? '');
    $nuevaContrasena = trim($_POST['nueva_contrasena'] ?? '');
    
    if (strlen($nuevoUsuario) < 4 || strlen($nuevaContrasena) < 6) {
        $errorRegistro = "Usuario (mín 4 caracteres) y contraseña (mín 6 caracteres) requeridos";
    } else {
        foreach ($usuarios as $u) {
            if ($u['usuario'] === $nuevoUsuario) {
                $errorRegistro = "El usuario ya existe";
                break;
            }
        }
        
        if (!isset($errorRegistro)) {
            $usuarios[] = [
                'usuario' => $nuevoUsuario,
                'contrasena' => password_hash($nuevaContrasena, PASSWORD_DEFAULT),
                'plan' => 'básico',
                'email' => ''
            ];
            file_put_contents($archivo_usuarios, json_encode($usuarios));
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['nombre_usuario'] = $nuevoUsuario;
            $_SESSION['plan_activo'] = 'básico';
            header("Location: pre.php");
            exit();
        }
    }
}

// 2. Procesar login
if (isset($_POST['ingresar'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    
    // Credenciales de admin
    if ($usuario === 'admin' && $contrasena === '135790') {
        $_SESSION['usuario_autenticado'] = true;
        $_SESSION['nombre_usuario'] = 'admin';
        $_SESSION['es_admin'] = true;
        $_SESSION['plan_activo'] = 'admin';
        header("Location: admin.php");
        exit();
    }
    
    foreach ($usuarios as $u) {
        if ($u['usuario'] === $usuario && password_verify($contrasena, $u['contrasena'])) {
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['nombre_usuario'] = $usuario;
            $_SESSION['plan_activo'] = $u['plan'] ?? 'básico';
            header("Location: pre.php");
            exit();
        }
    }
    
    $errorLogin = "Usuario o contraseña incorrectos";
}

// 3. Procesar recuperación de contraseña
if (isset($_POST['recuperar_contrasena'])) {
    $usuarioRecuperar = trim($_POST['usuario_recuperar'] ?? '');
    $encontrado = false;
    
    foreach ($usuarios as $u) {
        if ($u['usuario'] === $usuarioRecuperar) {
            $encontrado = true;
            $token = bin2hex(random_bytes(32));
            $_SESSION['token_recuperacion'] = $token;
            $_SESSION['usuario_recuperacion'] = $usuarioRecuperar;
            $_SESSION['token_expiracion'] = time() + 3600;
            
            $mensaje = "Token de recuperación: $token (En producción se enviaría por email)";
            header("Location: pre.php?msg=".urlencode($mensaje));
            exit();
        }
    }
    
    if (!$encontrado) {
        $errorRecuperacion = "Usuario no encontrado";
    }
}

// 4. Procesar cambio de contraseña desde recuperación
if (isset($_POST['cambiar_contrasena_recuperacion'])) {
    if ($_SESSION['token_recuperacion'] === ($_POST['token'] ?? '') && time() < ($_SESSION['token_expiracion'] ?? 0)) {
        $nuevaContrasena = trim($_POST['nueva_contrasena'] ?? '');
        $confirmacion = trim($_POST['confirmar_contrasena'] ?? '');
        
        if (strlen($nuevaContrasena) < 6) {
            $errorContrasena = "La contraseña debe tener al menos 6 caracteres";
        } elseif ($nuevaContrasena !== $confirmacion) {
            $errorContrasena = "Las contraseñas no coinciden";
        } else {
            foreach ($usuarios as &$u) {
                if ($u['usuario'] === $_SESSION['usuario_recuperacion']) {
                    $u['contrasena'] = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
                    break;
                }
            }
            
            file_put_contents($archivo_usuarios, json_encode($usuarios));
            unset($_SESSION['token_recuperacion'], $_SESSION['usuario_recuperacion'], $_SESSION['token_expiracion']);
            header("Location: pre.php?success=Contraseña actualizada correctamente");
            exit();
        }
    } else {
        $errorContrasena = "Token inválido o expirado";
    }
}

// 5. Procesar cambio de plan
if (isset($_GET['plan_comprado'])) {
    $_SESSION['plan_activo'] = $_GET['plan_comprado'];
    foreach ($usuarios as &$u) {
        if ($u['usuario'] === $_SESSION['nombre_usuario']) {
            $u['plan'] = $_GET['plan_comprado'];
            break;
        }
    }
    file_put_contents($archivo_usuarios, json_encode($usuarios));
    header("Location: pre.php?success=Plan activado correctamente");
    exit();
}

// Mensajes del sistema
if (isset($_GET['msg'])) $mensaje = htmlspecialchars($_GET['msg']);
if (isset($_GET['success'])) $mensaje = htmlspecialchars($_GET['success']);

// Verificar plan activo
$juegos_desbloqueados = isset($_SESSION['plan_activo']) && $_SESSION['plan_activo'] !== 'básico';

include 'extend/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Obten ReSolve Pro</title>
  <link rel="stylesheet" href="css/Pre.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* ========== RESPONSIVE DESIGN ========== */
@media (max-width: 768px) {
  .header-container {
    flex-direction: column;
    padding: 1rem;
  }
  
  .logo {
    margin-bottom: 1rem;
  }
  
  .main-nav ul {
    flex-direction: column;
    gap: 0.5rem;
    text-align: center;
  }
  
  .footer-content {
    grid-template-columns: 1fr;
    padding: 0 1.5rem;
    gap: 1.5rem;
    text-align: center;
  }
  
  .footer-section h3::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .social-icons {
    justify-content: center;
  }
  
  .footer-section.contact p {
    justify-content: center;
  }
}

/* ========== ANIMATIONS ========== */
@keyframes slideInBounce {
  from { transform: translateY(-100%); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}


.contenedor-precios {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .contenedor-precios h2 {
      text-align: center;
      color: #4b0082;
      font-size: 28px;
      margin-bottom: 30px;
    }
    .planes {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }
    .plan {
      background-color: #f8e4ff;
      border: 2px solid #c77dff;
      border-radius: 16px;
      padding: 20px;
      width: 280px;
      text-align: center;
      transition: transform 0.3s;
    }
    .plan:hover {
      transform: scale(1.05);
    }
    .plan h3 {
      margin-top: 0;
      color: #8e24aa;
    }
    .plan p {
      font-size: 16px;
      margin: 10px 0;
    }
    .plan .precio {
      font-size: 24px;
      font-weight: bold;
      color: #6a1b9a;
    }
    .btn-comprar {
      margin-top: 15px;
      background-color: #ba68c8;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
    }
    .btn-comprar:hover {
      background-color: #9c27b0;
    }
    :root {
        --color-primario: #50008b;
        --color-secundario: #7a00cc;
        --color-texto: #ffffff;
        --color-fondo: #f8f9fa;
    }
    
    /* Estilos para el cuadro "Debes iniciar sesión" */
    .alerta-inicio-sesion {
        background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
        color: white;
        text-align: center;
        padding: 20px;
        margin: 30px auto;
        max-width: 800px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        border: 2px solid white;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255,255,255,0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255,255,255,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
    }
    
    .alerta-inicio-sesion h3 {
        margin-top: 0;
        font-size: 1.5em;
    }
    
    .alerta-inicio-sesion .botones {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
    }
    
    .alerta-inicio-sesion .btn {
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: bold;
        transition: all 0.3s;
    }
    
    .alerta-inicio-sesion .btn-iniciar {
        background: white;
        color: var(--color-primario);
        border: 2px solid white;
    }
    
    .alerta-inicio-sesion .btn-registrar {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .alerta-inicio-sesion .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    /* Estilos para modales y otros elementos */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
    }
    
    .modal-content {
        background-color: var(--color-primario);
        margin: 10% auto;
        padding: 25px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        color: var(--color-texto);
        border: 2px solid white;
    }
    
    .close-modal {
        color: var(--color-texto);
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .form-input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 2px solid var(--color-primario);
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    .btn {
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-block;
        text-align: center;
        margin: 5px;
        color: white;
    }
    
    .btn-primary {
        background-color: var(--color-primario);
        border: 2px solid white;
    }
    
    .btn-primary:hover {
        background-color: var(--color-secundario);
        transform: translateY(-2px);
    }
    
    .error-mensaje {
        background: #ff3860;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .mensaje-flotante {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--color-primario);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
    }
    
    .cerrar-mensaje {
        margin-left: 15px;
        cursor: pointer;
        font-weight: bold;
    }
    
    .contenedor-precios {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin: 20px auto;
        max-width: 900px;
        border: 2px solid var(--color-primario);
    }
    
    .planes {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .plan {
        background: white;
        border: 2px solid var(--color-primario);
        border-radius: 10px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .plan h3 {
        color: var(--color-primario);
        border-bottom: 2px solid var(--color-primario);
        padding-bottom: 10px;
    }
    
    .precio {
        font-size: 24px;
        font-weight: bold;
        color: var(--color-primario);
        margin: 15px 0;
    }
    
    .recuperacion-box {
        background: white;
        border: 2px solid var(--color-primario);
        border-radius: 10px;
        padding: 25px;
        max-width: 500px;
        margin: 30px auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .token-display {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 5px;
        font-family: monospace;
        word-break: break-all;
        border: 1px dashed #50008b;
        margin: 15px 0;
    }
</style>
</head>
<body>

<?php if (isset($mensaje)): ?>
    <div class="mensaje-flotante">
        <?= $mensaje ?>
        <span class="cerrar-mensaje" onclick="this.parentElement.style.display='none'">×</span>
    </div>
    <script>setTimeout(() => document.querySelector('.mensaje-flotante').style.display = 'none', 5000);</script>
<?php endif; ?>

<!-- ========== CUADRO "DEBES INICIAR SESIÓN" ========== -->
<?php if (!isset($_SESSION['usuario_autenticado'])): ?>
    <div class="alerta-inicio-sesion">
        <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 15px;"></i>
        <h3>¡DEBES INICIAR SESIÓN PARA CONTINUAR!</h3>
        <p>Regístrate o inicia sesión para acceder a todos los contenidos</p>
        
        <div class="botones">
            <button class="btn btn-iniciar" onclick="openModal('loginModal')">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
            <button class="btn btn-registrar" onclick="openModal('registerModal')">
                <i class="fas fa-user-plus"></i> Registrarse
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- ========== MODAL LOGIN ========== -->
<div id="loginModal" class="modal" style="<?= !isset($_SESSION['usuario_autenticado']) ? 'display:block;' : 'display:none;' ?>">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('loginModal')">&times;</span>
        <h2 style="text-align:center; margin-top:0; color:white;">🔐 Iniciar Sesión</h2>
        
        <?php if(isset($errorLogin)): ?>
            <div class="error-mensaje"><?= $errorLogin ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input type="text" name="usuario" class="form-input" placeholder="Usuario" required>
            <input type="password" name="contrasena" class="form-input" placeholder="Contraseña" required>
            <button type="submit" name="ingresar" class="btn btn-primary" style="width:100%;">Ingresar</button>
        </form>
        <p style="text-align:center; margin-top:15px; color:white;">
            ¿No tienes cuenta? 
            <a href="#" style="color:white; text-decoration:underline;" onclick="openModal('registerModal'); closeModal('loginModal')">Regístrate aquí</a>
        </p>
        <p style="text-align:center; margin-top:15px; color:white;">
            <a href="#" style="color:white; text-decoration:underline;" onclick="openModal('recuperarModal'); closeModal('loginModal')">¿Olvidaste tu contraseña?</a>
        </p>
    </div>
</div>

<!-- ========== MODAL REGISTRO ========== -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('registerModal')">&times;</span>
        <h2 style="text-align:center; margin-top:0; color:white;">📝 Crear Cuenta</h2>
        <?php if(isset($errorRegistro)): ?>
            <div class="error-mensaje"><?= $errorRegistro ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="nuevo_usuario" class="form-input" placeholder="Nuevo usuario (mín 4 caracteres)" required>
            <input type="password" name="nueva_contrasena" class="form-input" placeholder="Nueva contraseña (mín 6 caracteres)" required>
            <button type="submit" name="registrar" class="btn btn-primary" style="width:100%;">Registrarse</button>
        </form>
        <p style="text-align:center; margin-top:15px; color:white;">
            ¿Ya tienes cuenta? 
            <a href="#" style="color:white; text-decoration:underline;" onclick="openModal('loginModal'); closeModal('registerModal')">Inicia sesión</a>
        </p>
    </div>
</div>

<!-- ========== MODAL RECUPERACIÓN ========== -->
<div id="recuperarModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('recuperarModal')">&times;</span>
        <h2 style="text-align:center; margin-top:0; color:white;">🔓 Recuperar Contraseña</h2>
        
        <?php if(isset($errorRecuperacion)): ?>
            <div class="error-mensaje"><?= $errorRecuperacion ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input type="text" name="usuario_recuperar" class="form-input" placeholder="Ingresa tu usuario" required>
            <button type="submit" name="recuperar_contrasena" class="btn btn-primary" style="width:100%;">Enviar Instrucciones</button>
        </form>
        <p style="text-align:center; margin-top:15px; color:white;">
            <a href="#" style="color:white; text-decoration:underline;" onclick="openModal('loginModal'); closeModal('recuperarModal')">Volver a Iniciar Sesión</a>
        </p>
    </div>
</div>

<!-- ========== MODAL NUEVA CONTRASEÑA (RECUPERACIÓN) ========== -->
<?php if(isset($_SESSION['token_recuperacion'])): ?>
<div id="nuevaContrasenaModal" class="modal" style="display:block;">
    <div class="recuperacion-box">
        <h2 style="text-align:center; color:var(--color-primario);">🔒 Establecer Nueva Contraseña</h2>
        
        <?php if(isset($errorContrasena)): ?>
            <div class="error-mensaje"><?= $errorContrasena ?></div>
        <?php endif; ?>
        
        <p>Token de verificación:</p>
        <div class="token-display"><?= $_SESSION['token_recuperacion'] ?></div>
        
        <form method="post">
            <input type="hidden" name="token" value="<?= $_SESSION['token_recuperacion'] ?>">
            <input type="password" name="nueva_contrasena" class="form-input" placeholder="Nueva contraseña (mín 6 caracteres)" required>
            <input type="password" name="confirmar_contrasena" class="form-input" placeholder="Confirmar nueva contraseña" required>
            <button type="submit" name="cambiar_contrasena_recuperacion" class="btn btn-primary" style="width:100%;">Cambiar Contraseña</button>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- ========== CONTENIDO PARA USUARIOS LOGUEADOS ========== -->
<?php if (isset($_SESSION['usuario_autenticado'])): ?>
    <section class="contenedor-precios">
        <div style="text-align:right; margin-bottom:20px;">
            <span style="color:var(--color-primario); font-weight:bold;">
                <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>
                <?php if($juegos_desbloqueados): ?>
                    <span style="color:#ffc107;">(Premium)</span>
                <?php endif; ?>
            </span>
            <a href="logout.php" style="background:var(--color-primario); color:white; padding:5px 15px; border-radius:20px; margin-left:10px; text-decoration:none;">Cerrar Sesión</a>
        </div>
        
        <h2 style="text-align:center; color:var(--color-primario);">💸 Planes de suscripción</h2>
        
        <div class="planes">
            <div class="plan">
                <h3>Plan Básico</h3>
                <ul style="color: #333;">
                    <li>Aplicación móvil y de escritorio</li>
                    <li>Material de apoyo</li>
                    <li>Algunos Juegos</li>
                </ul>
                <p class="precio">Gratis</p>
                <?php if($_SESSION['plan_activo'] === 'básico'): ?>
                    <div style="background:#e0e0e0; padding:10px; border-radius:5px; text-align:center;">Plan Actual</div>
                <?php endif; ?>
            </div>
            
            <div class="plan">
                <h3>Plan Estudiante</h3>
                <p class="precio">MX$ 99.90 / mes</p>
                <ul style="color: #333;">
                    <li>Todo lo anterior +</li>
                    <li>Juegos Premium</li>
                    <li>Resolución de dudas</li>
                </ul>
                <form action="pago.php" method="get">
                    <input type="hidden" name="plan" value="estudiante">
                    <button type="submit" class="btn btn-primary">
                        <?= ($_SESSION['plan_activo'] === 'estudiante') ? 'Plan Actual' : 'Comprar Ahora' ?>
                    </button>
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
// Funciones para manejar modales
function openModal(id) {
    document.getElementById(id).style.display = 'block';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Cerrar modal al hacer clic fuera del contenido
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}

// Limpiar parámetros de URL
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.pathname);
}
</script>

<?php include 'extend/footer.php'; ?>
</body>
</html>