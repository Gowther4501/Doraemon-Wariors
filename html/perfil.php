<?php
include '../php/conexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['id'];

// Consulta de usuario
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

// Consulta de perfil
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

// Consulta de rol en la tabla login
$sql_login = "SELECT rol FROM login WHERE id_cliente = ?";
$stmt_login = $conn->prepare($sql_login);
$stmt_login->bind_param("i", $id_cliente);
$stmt_login->execute();
$result_login = $stmt_login->get_result();

if ($result_login->num_rows > 0) {
    $row_login = $result_login->fetch_assoc();
    $userRole = htmlspecialchars($row_login['rol']);
} else {
    $userRole = 'user'; // Valor por defecto en caso de que el rol no esté disponible
}

// Cierra las consultas y la conexión
$stmt_persona->close();
$stmt_perfil->close();
$stmt_login->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../css/perfil.css">
    <script>
        function redirectBasedOnRole(rol) {
            if (rol === 'root') {
                window.location.href = 'indexr.php';
            } else {
                window.location.href = 'indexu.php';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($row_perfil['foto'] ?? 'https://via.placeholder.com/120'); ?>" alt="Imagen de perfil">
            <div>
                <h1><?php echo htmlspecialchars($row_persona['Nombres'] ?? 'Nombre no disponible'); ?></h1>
                <h1><?php echo htmlspecialchars($row_persona['apellidos'] ?? 'Apellido no disponible'); ?></h1> 
                <p><strong>Sexo:</strong> <?php echo htmlspecialchars($row_persona['sexo'] ?? 'No disponible'); ?></p>
                <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($row_persona['fecha_nacimiento'] ?? 'No disponible'); ?></p>
            </div>
        </div>
        <div class="profile-info">
            <h2>Información Personal</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row_perfil['email'] ?? 'No disponible'); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($row_perfil['telefono'] ?? 'No disponible'); ?></p>
        </div>
        <div class="edit-form">
            <h2><a href="../php/editar_perfil.php">Editar Perfil</a></h2>
        </div>
        <div class="back-button">
            <button onclick="redirectBasedOnRole('<?php echo $userRole; ?>')">Regresar a la Página Principal</button>
        </div>
    </div>
</body>
</html>
