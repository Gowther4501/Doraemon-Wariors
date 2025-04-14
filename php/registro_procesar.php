<?php
include 'conexion.php'; 
$error = '';
$success = '';

// Capturar los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['Apellidos'];
$nacimiento = $_POST['nacimiento'];
$sexo = $_POST['sexo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['Contrasena'];
$contrasena2 = $_POST['Contrasena2'];

// Comprobar si el campo de rol está presente
$rol = isset($_POST['rol']) ? $_POST['rol'] : 'user'; // Valor por defecto si no está presente

// Verificar si las contraseñas coinciden
if ($contrasena != $contrasena2) {
    $error = "Las contraseñas no coinciden.";
} else {
    // Verificar si el usuario ya existe
    $sql_check_user = "SELECT COUNT(*) FROM login WHERE Usuario = ?";
    if ($stmt_check = $conn->prepare($sql_check_user)) {
        $stmt_check->bind_param("s", $usuario);
        $stmt_check->execute();
        $stmt_check->bind_result($user_count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($user_count > 0) {
            $error = "El usuario ya existe.";
        } else {
            // Encriptar la contraseña
            $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

            // Insertar datos en la tabla persona
            $sql_persona = "INSERT INTO usuario (Nombres, apellidos, fecha_nacimiento, sexo)
            VALUES (?, ?, ?, ?)";

            if ($stmt_persona = $conn->prepare($sql_persona)) {
                $stmt_persona->bind_param("ssss", $nombre, $apellido, $nacimiento, $sexo);
                if ($stmt_persona->execute()) {
                    // Obtener el ID del cliente insertado
                    $id_cliente = $conn->insert_id;
                    
                    // Insertar datos en la tabla login
                    $sql_login = "INSERT INTO login (id_cliente, Usuario, Contraseña, rol)
                    VALUES (?, ?, ?, ?)";

                    if ($stmt_login = $conn->prepare($sql_login)) {
                        $stmt_login->bind_param("isss", $id_cliente, $usuario, $contrasena_hash, $rol);
                        if ($stmt_login->execute()) {
                            $success = "Registro exitoso. Puedes iniciar sesión ahora.";
                        } else {
                            $error = "Error al registrar usuario: " . $stmt_login->error;
                        }
                        $stmt_login->close();
                    } else {
                        $error = "Error en la consulta de login: " . $conn->error;
                    }
                } else {
                    $error = "Error al registrar datos personales: " . $stmt_persona->error;
                }
                $stmt_persona->close();
            } else {
                $error = "Error en la consulta de persona: " . $conn->error;
            }
        }
    } else {
        $error = "Error en la consulta de verificación de usuario: " . $conn->error;
    }
}

$conn->close();

// Redirigir de vuelta al formulario con los mensajes de error o éxito
header("Location: ../html/login.php?error=" . urlencode($error) . "&success=" . urlencode($success));
exit();
?>
