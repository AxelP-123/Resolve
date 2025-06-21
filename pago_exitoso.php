<?php
session_start();

// Validar que haya un pago pendiente
if(!isset($_SESSION['pago_simulado'])) {
    header("Location: pre.php");
    exit();
}

$pago = $_SESSION['pago_simulado'];

// ACTIVAR EL PLAN AQUÍ
$_SESSION['plan_activo'] = $pago['plan'];
$_SESSION['fecha_expiracion'] = $pago['expira'];

// Ya activado, podemos eliminar el temporal
unset($_SESSION['pago_simulado']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago Exitoso</title>
  <link rel="stylesheet" href="css/pago_exitoso.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
  <div class="ticket">
    <div class="check"><i class="fas fa-check-circle"></i></div>
    <h1>¡Pago Exitoso!</h1>
    <p>Tu suscripción ha sido activada.</p>
    <div class="info">
      <p><strong>Plan:</strong> <?= ucfirst($pago['plan']) ?></p>
      <p><strong>Tarjeta:</strong> **** **** **** <?= $pago['tarjeta'] ?></p>
      <p><strong>Fecha:</strong> <?= $pago['fecha'] ?></p>
      <p><strong>Vence:</strong> <?= $pago['expira'] ?></p>
    </div>
    <a class="btn" href="Juegos.php">Ir a Juegos PRO</a>
  </div>
</body>
</html>
