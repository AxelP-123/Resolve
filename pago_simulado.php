<?php
session_start();

// Simulación de procesamiento de pago
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? '';
    
    // Validar datos (simulación)
    if (empty($_POST['nombre']) || empty($_POST['correo'])) {
        $response['message'] = 'Datos incompletos';
    } elseif ($plan === 'estudiante' && (empty($_POST['tarjeta']) || empty($_POST['fecha']) || empty($_POST['cvv']))) {
        $response['message'] = 'Datos de pago incompletos';
    } else {
        // Simular éxito en el pago
        $response['success'] = true;
        
        // Actualizar plan en usuarios.json
        $archivo_usuarios = 'usuarios.json';
        $usuarios = file_exists($archivo_usuarios) ? json_decode(file_get_contents($archivo_usuarios), true) : [];
        
        foreach ($usuarios as &$usuario) {
            if ($usuario['usuario'] === $_SESSION['nombre_usuario']) {
                $usuario['plan'] = $plan;
                break;
            }
        }
        
        file_put_contents($archivo_usuarios, json_encode($usuarios));
        
        // Actualizar sesión
        $_SESSION['plan_activo'] = $plan;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>