<?php
session_start();

// Verificar suscripción activa
function tieneSuscripcionActiva() {
    return isset($_SESSION['plan_activo']) && $_SESSION['plan_activo'] !== 'básico';
}

// Redirigir si no tiene suscripción
if (!tieneSuscripcionActiva()) {
    header("Location: pre.php?error=Necesitas suscripción PRO para acceder");
    exit();
}
?>