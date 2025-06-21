<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_autenticado']) || !$_SESSION['usuario_autenticado']) {
    header("Location: pre.php?error=Acceso no autorizado");
    exit();
}

// Obtener datos del formulario
$nuevaContrasena = $_POST['nueva_contrasena'] ?? '';
$confirmarContrasena = $_POST['confirmar_contrasena'] ?? '';

// Validaciones básicas
if (empty($nuevaContrasena) || empty($confirmarContrasena)) {
    header("Location: cambiar_contrasena.php?error=Todos los campos son obligatorios");
    exit();
}

if (strlen($nuevaContrasena) < 6) {
    header("Location: cambiar_contrasena.php?error=La contraseña debe tener al menos 6 caracteres");
    exit();
}

if ($nuevaContrasena !== $confirmarContrasena) {
    header("Location: cambiar_contrasena.php?error=Las contraseñas no coinciden");
    exit();
}

// ==============================================
// EN UN SISTEMA REAL, AQUÍ IRÍA LA LÓGICA PARA:
// 1. Conectar a la base de datos (usando db.php)
// 2. Hashear la nueva contraseña: password_hash($nuevaContrasena, PASSWORD_DEFAULT)
// 3. Actualizar en la tabla de usuarios
// ==============================================

// Ejemplo simulado (para que funcione sin BD):
$_SESSION['contrasena_actualizada'] = true; // Solo para demostración

// Redirigir con mensaje de éxito
header("Location: cambiar_contrasena.php?success=¡Contraseña actualizada correctamente!");
exit();
?>