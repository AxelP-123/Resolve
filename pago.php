<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_autenticado'])) {
    header("Location: pre.php?error=Debes iniciar sesión primero");
    exit();
}

// Verificar plan seleccionado
if (!isset($_GET['plan']) || !in_array($_GET['plan'], ['básico', 'estudiante'])) {
    header("Location: pre.php?error=Selecciona un plan válido");
    exit();
}

$plan = htmlspecialchars($_GET['plan']);
$_SESSION['plan_seleccionado'] = $plan;

// Obtener el año y mes actual para la validación de fecha
$currentYear = date('Y');
$currentMonth = date('m');
$minDate = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);

include 'extend/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pago - ReSolve Pro</title>
    <link rel="stylesheet" href="css/pago.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
    <meta name="description" content="Proceso de pago seguro para ReSolve Pro">

</head>
<body>
    <section class="contenedor-pago">
        <h2><i class="fas fa-credit-card"></i> Pago - Plan <?= ucfirst($plan) ?></h2>
        
        <div class="info-plan">
            <p><strong>Plan seleccionado:</strong> <?= ucfirst($plan) ?></p>
            <p><strong>Precio:</strong> <?= $plan === 'estudiante' ? 'MX$99.90/mes' : 'Gratis' ?></p>
        </div>
        
        <form id="formularioPago">
            <input type="hidden" name="plan" value="<?= $plan ?>">
            
            <label for="nombre"><i class="fas fa-user"></i> Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>
            <div id="nombre-error" class="error-message"></div>
            
            <label for="correo"><i class="fas fa-envelope"></i> Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <div id="correo-error" class="error-message"></div>
            
            <?php if ($plan === 'estudiante'): ?>
                <label for="tarjeta"><i class="fas fa-credit-card"></i> Número de tarjeta:</label>
                <input type="text" id="tarjeta" name="tarjeta" placeholder="1234 5678 9012 3456" required>
                <div id="tarjeta-error" class="error-message"></div>
                
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha de vencimiento:</label>
                        <input type="month" id="fecha" name="fecha" min="<?= $minDate ?>" required>
                        <div id="fecha-error" class="error-message"></div>
                    </div>
                    <div style="flex: 1;">
                        <label for="cvv"><i class="fas fa-lock"></i> CVV:</label>
                        <input type="text" id="cvv" name="cvv" maxlength="4" placeholder="123" required>
                        <div id="cvv-error" class="error-message"></div>
                    </div>
                </div>
            <?php endif; ?>
            
            <button type="button" class="btn-pagar" onclick="procesarPago()">
                <?= $plan === 'estudiante' ? 'Pagar ahora' : 'Activar plan gratuito' ?>
            </button>
        </form>
    </section>

    <script>
    function mostrarError(elementoId, mensaje) {
        const errorElement = document.getElementById(elementoId + '-error');
        errorElement.textContent = mensaje;
        errorElement.style.display = 'block';
        document.getElementById(elementoId).style.borderColor = '#dc3545';
    }

    function limpiarError(elementoId) {
        const errorElement = document.getElementById(elementoId + '-error');
        errorElement.textContent = '';
        errorElement.style.display = 'none';
        document.getElementById(elementoId).style.borderColor = '#ddd';
    }

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validarTarjeta(numero) {
        // Eliminar espacios y validar que sean solo números
        const cleaned = numero.replace(/\s+/g, '');
        if (!/^\d+$/.test(cleaned)) return false;
        
        // Validar longitud (16 dígitos para la mayoría de tarjetas)
        return cleaned.length === 16;
    }

    function validarCVV(cvv) {
        return cvv.length >= 3 && cvv.length <= 4 && /^\d+$/.test(cvv);
    }

    function validarFechaVencimiento(fecha) {
        if (!fecha) return false;
        
        const [year, month] = fecha.split('-');
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1;
        
        return parseInt(year) > currentYear || 
              (parseInt(year) === currentYear && parseInt(month) >= currentMonth);
    }

    function procesarPago() {
        let isValid = true;
        
        // Validar nombre
        const nombre = document.getElementById('nombre').value.trim();
        if (!nombre) {
            mostrarError('nombre', 'Por favor ingresa tu nombre completo');
            isValid = false;
        } else {
            limpiarError('nombre');
        }
        
        // Validar correo
        const correo = document.getElementById('correo').value.trim();
        if (!correo) {
            mostrarError('correo', 'Por favor ingresa tu correo electrónico');
            isValid = false;
        } else if (!validarEmail(correo)) {
            mostrarError('correo', 'Ingresa un correo electrónico válido');
            isValid = false;
        } else {
            limpiarError('correo');
        }
        
        <?php if ($plan === 'estudiante'): ?>
            // Validar tarjeta
            const tarjeta = document.getElementById('tarjeta').value.trim();
            if (!tarjeta) {
                mostrarError('tarjeta', 'Por favor ingresa el número de tarjeta');
                isValid = false;
            } else if (!validarTarjeta(tarjeta)) {
                mostrarError('tarjeta', 'Ingresa un número de tarjeta válido (16 dígitos)');
                isValid = false;
            } else {
                limpiarError('tarjeta');
            }
            
            // Validar CVV
            const cvv = document.getElementById('cvv').value.trim();
            if (!cvv) {
                mostrarError('cvv', 'Por favor ingresa el CVV');
                isValid = false;
            } else if (!validarCVV(cvv)) {
                mostrarError('cvv', 'Ingresa un CVV válido (3-4 dígitos)');
                isValid = false;
            } else {
                limpiarError('cvv');
            }
            
            // Validar fecha de vencimiento
            const fechaVencimiento = document.getElementById('fecha').value;
            if (!fechaVencimiento) {
                mostrarError('fecha', 'Por favor selecciona la fecha de vencimiento');
                isValid = false;
            } else if (!validarFechaVencimiento(fechaVencimiento)) {
                mostrarError('fecha', 'La fecha de vencimiento no puede ser anterior al mes actual');
                isValid = false;
            } else {
                limpiarError('fecha');
            }
        <?php endif; ?>
        
        if (!isValid) {
            return;
        }
        
        // Mostrar loader
        const btn = document.querySelector('.btn-pagar');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btn.disabled = true;
        
        // Enviar datos
        const formData = new FormData(document.getElementById('formularioPago'));
        
        fetch('pago_simulado.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'pago_exitoso.php?plan=' + encodeURIComponent('<?= $plan ?>');
            } else {
                alert('Error: ' + data.message);
                btn.innerHTML = '<?= $plan === 'estudiante' ? 'Pagar ahora' : 'Activar plan gratuito' ?>';
                btn.disabled = false;
            }
        })
        .catch(error => {
            alert('Error en la conexión');
            btn.innerHTML = '<?= $plan === 'estudiante' ? 'Pagar ahora' : 'Activar plan gratuito' ?>';
            btn.disabled = false;
        });
    }

    // Validación en tiempo real para mejor UX
    document.getElementById('nombre').addEventListener('input', function() {
        if (this.value.trim()) limpiarError('nombre');
    });

    document.getElementById('correo').addEventListener('input', function() {
        if (this.value.trim() && validarEmail(this.value.trim())) limpiarError('correo');
    });

    <?php if ($plan === 'estudiante'): ?>
        document.getElementById('tarjeta').addEventListener('input', function() {
            if (this.value.trim() && validarTarjeta(this.value.trim())) limpiarError('tarjeta');
        });

        document.getElementById('cvv').addEventListener('input', function() {
            if (this.value.trim() && validarCVV(this.value.trim())) limpiarError('cvv');
        });

        document.getElementById('fecha').addEventListener('change', function() {
            if (this.value && validarFechaVencimiento(this.value)) limpiarError('fecha');
        });
    <?php endif; ?>
    </script>

<?php include 'extend/footer.php'; ?>