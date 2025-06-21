<?php
session_start();
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: pre.php");
    exit();
}

$archivo_dudas = 'dudas.json';

// Procesar respuesta, edición o eliminación
if (isset($_POST['accion'])) {
    $dudas = file_exists($archivo_dudas) ? json_decode(file_get_contents($archivo_dudas), true) : [];
    
    if ($_POST['accion'] === 'eliminar') {
        // Eliminar duda
        $dudas = array_filter($dudas, function($duda) {
            return $duda['id'] !== $_POST['id'];
        });
        $mensaje = "Duda eliminada correctamente";
    }
    elseif ($_POST['accion'] === 'responder') {
        // Responder o editar respuesta
        foreach ($dudas as &$duda) {
            if ($duda['id'] === $_POST['id']) {
                if (isset($_POST['editar_respuesta'])) {
                    $duda['respuesta'] = $_POST['respuesta'];
                    $duda['fecha_respuesta'] = date('Y-m-d H:i:s');
                } else {
                    $duda['respuesta'] = $_POST['respuesta'];
                    $duda['fecha_respuesta'] = date('Y-m-d H:i:s');
                    $duda['estado'] = 'respondida';
                }
                break;
            }
        }
        $mensaje = "Respuesta enviada correctamente";
    }
    
    file_put_contents($archivo_dudas, json_encode($dudas));
    header("Location: admin.php?success=" . urlencode($mensaje));
    exit();
}

// Obtener dudas
$dudas = file_exists($archivo_dudas) ? json_decode(file_get_contents($archivo_dudas), true) : [];

// Filtrar por búsqueda si existe
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
if ($busqueda) {
    $busquedaLower = strtolower($busqueda);
    $dudas = array_filter($dudas, function($duda) use ($busquedaLower) {
        return strpos(strtolower($duda['mensaje']), $busquedaLower) !== false || 
               ($duda['respuesta'] && strpos(strtolower($duda['respuesta']), $busquedaLower) !== false) ||
               strpos(strtolower($duda['usuario']), $busquedaLower) !== false;
    });
}

include 'extend/header_admin.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Admin</title>
    <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
     <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>
        
        <!-- Buscador -->
        <form method="get" class="search-admin-container">
            <input type="text" name="busqueda" class="search-admin-input" placeholder="Buscar dudas por usuario, mensaje o respuesta..." value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="search-admin-button">
                <i class="fas fa-search"></i>
            </button>
            <?php if ($busqueda): ?>
                <a href="admin.php" class="btn-enviar" style="margin-top: 10px; display: inline-block;">
                    <i class="fas fa-times"></i> Limpiar búsqueda
                </a>
            <?php endif; ?>
        </form>
        
        <h2>Dudas de Usuarios</h2>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <?php if (empty($dudas)): ?>
            <div class="no-results">
                <?= $busqueda ? 'No se encontraron resultados para "' . htmlspecialchars($busqueda) . '"' : 'No hay dudas pendientes.' ?>
            </div>
        <?php else: ?>
            <?php foreach ($dudas as $duda): ?>
                <div class="duda-card">
                    <div class="duda-header">
                        <div>
                            <h3>Consulta de <?= htmlspecialchars($duda['usuario']) ?></h3>
                            <small><?= $duda['fecha'] ?></small>
                        </div>
                        <span class="badge <?= $duda['estado'] ?>"><?= $duda['estado'] ?></span>
                    </div>
                    
                    <div class="duda-text"><?= htmlspecialchars($duda['mensaje']) ?></div>
                    
                    <form class="delete-form" method="post">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $duda['id'] ?>">
                        <div class="actions-container">
                            <button type="submit" class="delete-btn" onclick="return confirm('¿Estás seguro de eliminar esta duda?')">
                                <i class="fas fa-trash"></i> Eliminar Duda
                            </button>
                        </div>
                    </form>
                    
                    <?php if ($duda['respuesta']): ?>
                        <div class="respuesta">
                            <h4>Respuesta:</h4>
                            <div class="respuesta-text"><?= htmlspecialchars($duda['respuesta']) ?></div>
                            <small><?= $duda['fecha_respuesta'] ?></small>
                        </div>
                        
                        <form class="respuesta-form" method="post" style="margin-top: 15px;">
                            <input type="hidden" name="accion" value="responder">
                            <input type="hidden" name="id" value="<?= $duda['id'] ?>">
                            <input type="hidden" name="editar_respuesta" value="1">
                            <textarea name="respuesta" rows="3" placeholder="Editar respuesta..." required><?= htmlspecialchars($duda['respuesta']) ?></textarea>
                            <button type="submit" class="btn-enviar">
                                <i class="fas fa-save"></i> Actualizar Respuesta
                            </button>
                        </form>
                    <?php else: ?>
                        <form class="respuesta-form" method="post">
                            <input type="hidden" name="accion" value="responder">
                            <input type="hidden" name="id" value="<?= $duda['id'] ?>">
                            <textarea name="respuesta" rows="3" placeholder="Escribe tu respuesta..." required></textarea>
                            <button type="submit" class="btn-enviar">
                                <i class="fas fa-paper-plane"></i> Enviar Respuesta
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
