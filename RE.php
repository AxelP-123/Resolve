<!DOCTYPE html>
<html lang="es">
<link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/RE_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="background-animation"></div>
    <div class="container">
        <div class="register-header">
            <h1>Crear Cuenta</h1>
            <p>Únete a nuestra comunidad</p>
        </div>
        
        <form action="/registro" method="POST" class="register-form">
            <div class="input-group">
                <label for="nombre">Nombre completo</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" required>
                </div>
            </div>
            
            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                </div>
            </div>
            
            <div class="input-group">
                <label for="usuario">Nombre de usuario</label>
                <div class="input-with-icon">
                    <i class="fas fa-at"></i>
                    <input type="text" id="usuario" name="usuario" placeholder="Elige un nombre de usuario" required>
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Crea una contraseña segura" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                </div>
            </div>
            
            <div class="input-group">
                <label for="confirm-password">Confirmar contraseña</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Repite tu contraseña" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm-password')"></i>
                </div>
            </div>
            
            <div class="terms-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Acepto los <a href="terminos.php">términos y condiciones</a> 
            </div>
            <div>
             ¿Ya tienes una cuenta? <a href="IS.php">Inicia sesión</a>

            </div>
            <button type="submit" class="register-btn">Registrarse</button>
            

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = passwordField.nextElementSibling;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>