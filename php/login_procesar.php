<?php
session_start(); 
include 'conexion.php'; 
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';

    if (!empty($usuario) && !empty($contraseña)) {
        $stmt = $conn->prepare("SELECT id, Contraseña, rol FROM login WHERE Usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hash_almacenado, $rol);
            $stmt->fetch();

            if (password_verify($contraseña, $hash_almacenado)) {
                $_SESSION['id'] = $id;
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $rol; // Asignar el rol a la sesión
                
                // Redirigir según el rol del usuario
                if ($rol === 'root') {
                    header("Location:../html/indexr.php");
                } else {
                    header("Location: ../html/indexu.php");
                } 
                exit(); // Asegúrate de salir del script después de redirigir
            } else {
                $error = "Usuario o contraseña inválidos.";
            }
        } else {
            $error = "Usuario o contraseña inválidos.";
        }
        
        $stmt->close();
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
$conn->close();
header("Location: ../html/login.php?error=" . urlencode($error));
exit();
?>
