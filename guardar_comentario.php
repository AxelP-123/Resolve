<?php
session_start();
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: pre.php");
    exit();
}

$archivo_comentarios = 'comentarios.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {
    $comentarios = file_exists($archivo_comentarios) ? json_decode(file_get_contents($archivo_comentarios), true) : [];
    
    $nuevo_comentario = [
        'id' => uniqid(),
        'texto' => $_POST['comentario'],
        'fecha' => date('Y-m-d H:i:s'),
        'es_admin' => isset($_POST['es_admin']) ? (bool)$_POST['es_admin'] : false
    ];
    
    array_push($comentarios, $nuevo_comentario);
    file_put_contents($archivo_comentarios, json_encode($comentarios));
    
    header("Location: comentarios.php?success=Comentario enviado correctamente");
    exit();
}

header("Location: comentarios.php");
exit();