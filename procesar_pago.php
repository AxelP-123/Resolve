<?php
session_start();

if (!isset($_SESSION['usuario_autenticado'])) {
    header("Location: pre.php?error=Debes iniciar sesión");
    exit();
}

$plan = $_GET['plan'] ?? '';
$planes_validos = ['estudiante', 'premium'];

if (!in_array($plan, $planes_validos)) {
    header("Location: pre.php?error=Plan no válido");
    exit();
}

// GUARDAR DATOS TEMPORALES DEL PAGO SIMULADO (AÚN NO SE ACTIVA EL PLAN)
$_SESSION['pago_simulado'] = [
    'plan' => $plan,
    'tarjeta' => '1234', // Últimos 4 dígitos
    'fecha' => date('Y-m-d H:i:s'),
    'expira' => date('Y-m-d', strtotime('+1 month')),
];

// Redirigir a pantalla de éxito tipo ticket
header("Location: pago_exitoso.php");
exit();
?>
