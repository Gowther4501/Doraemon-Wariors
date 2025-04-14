<?php
include 'conexion.php'; 
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php");
    exit();
}

$id_cliente = $_SESSION['id'];

// Obtener datos del usuario
$sql_persona = "SELECT * FROM usuario WHERE id_cliente = ?";
$stmt_persona = $conn->prepare($sql_persona);
$stmt_persona->bind_param("i", $id_cliente);
$stmt_persona->execute();
$result_persona = $stmt_persona->get_result();

if ($result_persona->num_rows > 0) {
    $row_persona = $result_persona->fetch_assoc();
} else {
    $row_persona = null;
}

// Obtener datos del perfil
$sql_perfil = "SELECT * FROM perfil WHERE id = ?";
$stmt_perfil = $conn->prepare($sql_perfil);
$stmt_perfil->bind_param("i", $id_cliente);
$stmt_perfil->execute();
$result_perfil = $stmt_perfil->get_result();

if ($result_perfil->num_rows > 0) {
    $row_perfil = $result_perfil->fetch_assoc();
} else {
    $row_perfil = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nombres = $_POST['Nombres'];
    $apellidos = $_POST['apellidos']; // Asegúrate de que este campo se llama 'apellidos'
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $foto = $row_perfil['foto'] ?? '';

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_name = basename($_FILES['foto']['name']);
        $file_dest = '../img/' . $file_name; 

        // Verifica si el directorio 'img/' existe
        if (!is_dir('../img/')) {
            mkdir('../img/', 0777, true);
        }

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($file_tmp, $file_dest)) {
            $foto = $file_dest;
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    }

    // Actualizar la tabla usuario
    $sql_update_persona = "UPDATE usuario SET Nombres = ?, apellidos = ?, sexo = ?, fecha_nacimiento = ? WHERE id_cliente = ?";
    $stmt_update_persona = $conn->prepare($sql_update_persona);
    $stmt_update_persona->bind_param("ssssi", $Nombres, $apellidos, $sexo, $fecha_nacimiento, $id_cliente);
    
    if (!$stmt_update_persona->execute()) {
        echo "Error al actualizar datos del usuario: " . $stmt_update_persona->error;
        exit();
    }

    // Actualizar o insertar en la tabla perfil
    $sql_update_perfil = "INSERT INTO perfil (id, email, telefono, foto) 
                          VALUES (?, ?, ?, ?) 
                          ON DUPLICATE KEY UPDATE email = VALUES(email), telefono = VALUES(telefono), foto = VALUES(foto)";
    $stmt_update_perfil = $conn->prepare($sql_update_perfil);
    $stmt_update_perfil->bind_param("isss", $id_cliente, $email, $telefono, $foto);
    
    if (!$stmt_update_perfil->execute()) {
        echo "Error al actualizar perfil: " . $stmt_update_perfil->error;
        exit();
    }

    header("Location: ../html/perfil.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editarperfil.css"> 
    <title>Editar Perfil</title>

</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        <form action="editar_perfil.php" method="post" enctype="multipart/form-data">
            <label for="Nombres">Nombre Completo:</label>
            <input type="text" id="Nombres" name="Nombres" value="<?php echo htmlspecialchars($row_persona['Nombres'] ?? ''); ?>" required><br>
            <label for="apellidos">Apellido Completo:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($row_persona['apellidos'] ?? ''); ?>" required><br>
            <label for="sexo">Sexo:</label>
            <input type="text" id="sexo" name="sexo" value="<?php echo htmlspecialchars($row_persona['sexo'] ?? ''); ?>" required>
<br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row_persona['email'] ?? ''); ?>" required>
            <br>
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row_persona['telefono'] ?? ''); ?>" required>
            <br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($row_perfil['fecha_nacimiento'] ?? ''); ?>">
            <br>
            <label for="foto">Foto de Perfil (subir nueva imagen):</label>
            <input type="file" id="foto" name="foto">
            <br>
            <button type="submit">Actualizar Perfil</button>
        </form>
    </div>
</body>
</html>
