<?php
session_start();
if (!isset($_SESSION['usuario_autenticado'])) {
    exit(json_encode([]));
}

$archivo_dudas = 'dudas.json';
$nombre_usuario = $_SESSION['nombre_usuario'];

$dudas = file_exists($archivo_dudas) ? json_decode(file_get_contents($archivo_dudas), true) : [];
$mis_dudas = array_filter($dudas, function($duda) use ($nombre_usuario) {
    return $duda['usuario'] === $nombre_usuario;
});

// Ordenar por fecha (más recientes primero)
usort($mis_dudas, function($a, $b) {
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});

header('Content-Type: application/json');
echo json_encode(array_values($mis_dudas));
?>