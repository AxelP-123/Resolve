<?php
session_start();
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: pre.php");
    exit();
}

$archivo_comentarios = 'comentarios.json';

// Procesar eliminación
if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    $comentarios = file_exists($archivo_comentarios) ? json_decode(file_get_contents($archivo_comentarios), true) : [];
    
    $comentarios = array_filter($comentarios, function($comentario) {
        return $comentario['id'] !== $_POST['id'];
    });
    
    file_put_contents($archivo_comentarios, json_encode($comentarios));
    header("Location: comentarios.php?success=Comentario eliminado correctamente");
    exit();
}

// Obtener comentarios (más recientes primero)
$comentarios = file_exists($archivo_comentarios) ? array_reverse(json_decode(file_get_contents($archivo_comentarios), true)) : [];

include 'extend/header_admin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Comentarios Recibidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/comentarios.css">

</head>
<body>
    <div class="container-admin">
        <h1><i class="fas fa-comments"></i> Comentarios Recibidos</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($comentarios)): ?>
            <div class="no-comentarios">
                <i class="far fa-comment-dots"></i>
                <h3>No hay comentarios todavía</h3>
                <p>Aún no se han recibido comentarios de los usuarios.</p>
            </div>
        <?php else: ?>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario-card">
                    <div class="comentario-header">
                        <div class="usuario-info">
                            <span class="usuario-nombre">
                                <?= htmlspecialchars($comentario['usuario']) ?>
                                <?php if($comentario['es_admin']): ?>
                                    <span class="badge badge-admin">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge badge-anonimo">USUARIO</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <span class="fecha">
                            <i class="far fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($comentario['fecha'])) ?>
                        </span>
                    </div>
                    
                    <div class="comentario-contenido">
                        <?php if (!empty($comentario['asunto'])): ?>
                            <div class="comentario-asunto">
                                <strong>Asunto:</strong> <?= htmlspecialchars($comentario['asunto']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="comentario-texto">
                            <?= nl2br(htmlspecialchars($comentario['texto'])) ?>
                        </div>
                    </div>
                    
                    <form method="post" class="delete-form">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $comentario['id'] ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('¿Estás seguro de eliminar este comentario?')">
                            <i class="fas fa-trash"></i> Eliminar Comentario
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
