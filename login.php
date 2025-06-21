<?php
session_start();

// Si ya está logueado, redirige
if (isset($_SESSION['usuario_autenticado']) && $_SESSION['usuario_autenticado']) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    
    // Ejemplo de autenticación - reemplaza con tu lógica real
    if ($usuario === 'admin' && $contrasena === '1234') {
        $_SESSION['usuario_autenticado'] = true;
        $_SESSION['nombre_usuario'] = $usuario;
        header('Location: index.php');
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Incluye tus estilos -->
</head>
<body>
    <form method="POST">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>