<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" type="image/x-icon" href="imagen/LogoA.ico">
    <link rel="stylesheet" href="css/IS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-header">
            <h1>Iniciar Sesión</h1>
            <p>Bienvenido de vuelta</p>
        </div>
        
        <form action="/login" method="POST" class="login-form">
            <div class="input-group">
                <label for="username">Usuario o Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Ingresa tu usuario o email" required>
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>
            
            <div class="options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Recordarme</label>
                </div>
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </div>
            
            <button type="submit" class="login-btn">Iniciar Sesión</button>
            
            <div class="social-login">
                <p>O inicia sesión con</p>
                <div class="social-icons">
                    <a href="#" class="social-icon google"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="register-link">
                ¿No tienes una cuenta? <a href="RE.php">Regístrate</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>