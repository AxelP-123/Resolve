<?php
session_start();

// Archivo donde se guardarán los usuarios
$archivo_usuarios = 'usuarios.json';

// Cargar usuarios existentes
$usuarios = [];
if (file_exists($archivo_usuarios)) {
    $usuarios = json_decode(file_get_contents($archivo_usuarios), true);
}

// Procesar inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // Verificar credenciales de admin
    if ($usuario === 'admin' && $contrasena === '135790') {
        $_SESSION['usuario_autenticado'] = true;
        $_SESSION['nombre_usuario'] = 'admin';
        $_SESSION['es_admin'] = true;
        header("Location: admin.php");
        exit();
    }

    // Verificar usuarios normales
    foreach ($usuarios as $u) {
        if ($u['usuario'] === $usuario && password_verify($contrasena, $u['contrasena'])) {
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['nombre_usuario'] = $usuario;
            header("Location: pre.php");
            exit();
        }
    }

    // Si no coincide
    header("Location: pre.php?error=Usuario o contraseña incorrectos");
    exit();
}

// Procesar registro (moverlo aquí desde pre.php)
if (isset($_POST['registrar'])) {
    $nuevoUsuario = trim($_POST['nuevo_usuario'] ?? '');
    $nuevaContrasena = trim($_POST['nueva_contrasena'] ?? '');
    
    if (strlen($nuevoUsuario) < 4 || strlen($nuevaContrasena) < 6) {
        header("Location: pre.php?error=Usuario (mín 4 caracteres) y contraseña (mín 6 caracteres) requeridos");
        exit();
    }

    // Verificar si el usuario ya existe
    foreach ($usuarios as $u) {
        if ($u['usuario'] === $nuevoUsuario) {
            header("Location: pre.php?error=El usuario ya existe");
            exit();
        }
    }

    // Añadir nuevo usuario
    $usuarios[] = [
        'usuario' => $nuevoUsuario,
        'contrasena' => password_hash($nuevaContrasena, PASSWORD_DEFAULT)
    ];

    file_put_contents($archivo_usuarios, json_encode($usuarios));

    $_SESSION['usuario_autenticado'] = true;
    $_SESSION['nombre_usuario'] = $nuevoUsuario;
    header("Location: pre.php");
    exit();
}

header("Location: pre.php");
exit();