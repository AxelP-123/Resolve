<?php
session_start();

$archivo_comentarios = 'comentarios.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensaje'])) {
    // Obtener el nombre (admin o usuario normal)
    $nombre = isset($_SESSION['es_admin']) && $_SESSION['es_admin'] ? 'Admin' : 
             (isset($_POST['nombre']) && !empty($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : 'Anónimo');
    
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $asunto = isset($_POST['asunto']) ? htmlspecialchars(trim($_POST['asunto'])) : 'Sin asunto';
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    $nuevo_comentario = [
        'id' => uniqid(),
        'usuario' => $nombre,
        'email' => $email,
        'asunto' => $asunto,
        'texto' => $mensaje,
        'fecha' => date('Y-m-d H:i:s'),
        'es_admin' => isset($_SESSION['es_admin']) && $_SESSION['es_admin']
    ];

    $comentarios = file_exists($archivo_comentarios) ? json_decode(file_get_contents($archivo_comentarios), true) : [];
    $comentarios[] = $nuevo_comentario;
    file_put_contents($archivo_comentarios, json_encode($comentarios, JSON_PRETTY_PRINT));

    header("Location: ".strtok($_SERVER['REQUEST_URI'], '?')."?success=Mensaje+enviado+con+éxito");
    exit();
}

include 'extend/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Contáctanos</title>
    <link rel="stylesheet" href="css/estilos__CON.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <!-- Encabezado -->
    <header>
        <h1><i class="fa-solid fa-envelope-open-text"></i> Contáctanos</h1>
    </header>

    <!-- Contenedor Principal -->
    <main class="main-content">
        <div class="container">
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?= urldecode($_GET['success']) ?>
                </div>
            <?php endif; ?>
            
            <h2><i class="fa-solid fa-paper-plane"></i> Envíanos un mensaje</h2>
            <p class="sub">¿Tienes alguna pregunta, comentario o sugerencia? Completa el siguiente formulario.</p>
            
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <?php if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']): ?>
                    <label for="nombre"><i class="fa-solid fa-user"></i> Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Escribe tu nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>">
                <?php endif; ?>

                <label for="email"><i class="fa-solid fa-envelope"></i> Correo electrónico:</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

                <label for="asunto"><i class="fa-solid fa-pen"></i> Asunto:</label>
                <input type="text" id="asunto" name="asunto" placeholder="¿Sobre qué nos quieres hablar?" required value="<?= isset($_POST['asunto']) ? htmlspecialchars($_POST['asunto']) : '' ?>">

                <label for="mensaje"><i class="fa-solid fa-message"></i> Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="6" placeholder="Escribe tu mensaje aquí..." required><?= isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '' ?></textarea>

                <button type="submit"><i class="fa-solid fa-paper-plane"></i> Enviar mensaje</button>
            </form>
        </div>
    </main>

    <?php include 'chat_bubble.php'; ?>
    <?php include 'extend/footer.php'; ?>
</body>
</html>