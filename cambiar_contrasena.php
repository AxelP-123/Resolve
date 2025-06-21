<?php
session_start();

if (!isset($_SESSION['usuario_autenticado'])) {
    header("Location: pre.php");
    exit();
}

include 'extend/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambiar Contraseña - Re∫olve_App</title>
    <link rel="stylesheet" href="css/cambiar_contraseña.css">

</head>
<body>
    <div class="contenedor-principal">
        <div class="contenedor-contrasena">
            <h2><i class="fas fa-key"></i> Cambiar Contraseña</h2>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="mensaje-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="mensaje-exito">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="procesar_cambio.php">
                <input type="password" name="nueva_contrasena" class="form-input" placeholder="Nueva contraseña" required minlength="6">
                <input type="password" name="confirmar_contrasena" class="form-input" placeholder="Confirmar contraseña" required minlength="6">
                <button type="submit" class="btn">Actualizar Contraseña</button>
            </form>
            
            <a href="pre.php" class="enlace-volver"><i class="fas fa-arrow-left"></i> Volver al inicio</a>
        </div>
    </div>

    <?php include 'extend/footer.php'; ?>
</body>
</html>