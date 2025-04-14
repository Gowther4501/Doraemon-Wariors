<?php
// Suponiendo que has establecido una sesión para gestionar el estado de inicio de sesión
session_start();
include '../php/conexion.php';

// Verificar si el usuario actual es root
$is_root = false;
if (isset($_SESSION['usuario'])) {
    $usuario_actual = $_SESSION['usuario'];

    // Obtener el rol del usuario actual
    $sql_check_user_role = "SELECT rol FROM login WHERE Usuario = ?";
    if ($stmt_check_role = $conn->prepare($sql_check_user_role)) {
        $stmt_check_role->bind_param("s", $usuario_actual);
        $stmt_check_role->execute();
        $stmt_check_role->bind_result($rol_usuario);
        $stmt_check_role->fetch();
        $stmt_check_role->close();

        if ($rol_usuario === 'root') {
            $is_root = true;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/stylelogin.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="../php/registro_procesar.php" method="post">
                <h1>Crea una cuenta</h1>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <input type="text" id="Apellidos" name="Apellidos" placeholder="Apellidos" required>
                <input type="date" id="nacimiento" name="nacimiento" placeholder="Fecha de nacimiento" required>
               
                <div class="radio-group">
                    <input type="radio" id="Femenino" name="sexo" value="Femenino" required>
                    <label for="Femenino">Femenino</label>
                    
                    <input type="radio" id="Masculino" name="sexo" value="Masculino" required>
                    <label for="Masculino">Masculino</label>
                </div>

                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                <input type="password" id="contrasena" name="Contrasena" placeholder="Contraseña" required>
                <input type="password" id="contrasena2" name="Contrasena2" placeholder="Repita la Contraseña" required>
                <?php if ($is_root): ?>
                <label for="rol">Rol:</label>
                <select id="rol" name="rol">
                <option value="user">Usuario</option>
                <option value="root">Root</option>
                </select><br>
                <?php endif; ?>
                <button>Regístrarse</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="../php/login_procesar.php" method="post">
                <h1>Inicia sesión</h1>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                <button>Iniciar sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Para mantenerte conectado con nosotros, por favor inicia sesión con tu información personal</p>
                    <button class="ghost" id="signIn">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>¡Hola, Amigo!</h1>
                    <p>Ingresa tus datos personales y comienza un viaje con nosotros</p>
                    <button class="ghost" id="signUp">Regístrate</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>