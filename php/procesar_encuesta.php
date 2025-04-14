<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id'])) {
    die("No estás autorizado para acceder a esta página.");
}

$id = $_SESSION['id'];

// Obtener el rol del usuario
$rol = '';
$rolStmt = $conn->prepare("SELECT rol FROM login WHERE id_cliente = ?");
$rolStmt->bind_param("i", $id);
$rolStmt->execute();
$rolStmt->bind_result($rol);
$rolStmt->fetch();
$rolStmt->close();

// Obtener y sanitizar los datos del formulario
$nivel = isset($_POST['nivel']) ? htmlspecialchars($_POST['nivel']) : null;
$centro = isset($_POST['centro']) ? htmlspecialchars($_POST['centro']) : null;
$comentarios = isset($_POST['comentarios']) ? htmlspecialchars($_POST['comentarios']) : null;

// Obtener las respuestas de las preguntas
$preguntas = [];
for ($i = 1; $i <= 7; $i++) {
    $preguntas["pregunta$i"] = isset($_POST["pregunta$i"]) ? htmlspecialchars($_POST["pregunta$i"]) : null;
}
$fecha = date('Y-m-d');

// Preparar una consulta para verificar si el registro ya existe
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM respuestas WHERE id = ?");
$checkStmt->bind_param("i", $id);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    // El registro existe, realizar una actualización
    $stmt = $conn->prepare("
        UPDATE respuestas 
        SET 
            Nivelacademic = ?, 
            Centro_de_estudio = ?, 
            pregunta1 = ?, 
            pregunta2 = ?, 
            pregunta3 = ?, 
            pregunta4 = ?, 
            pregunta5 = ?, 
            pregunta6 = ?, 
            pregunta7 = ?, 
            comentario = ?,
            fecha =? 
        WHERE id = ?
    ");
    
    if ($stmt === false) {
        die("Error en la preparación de la declaración de actualización: " . $conn->error);
    }

    $stmt->bind_param(
        "sssssssssssi",
        $nivel,
        $centro,
        $preguntas['pregunta1'],
        $preguntas['pregunta2'],
        $preguntas['pregunta3'],
        $preguntas['pregunta4'],
        $preguntas['pregunta5'],
        $preguntas['pregunta6'],
        $preguntas['pregunta7'],
        $comentarios,
        $fecha,
        $id
    );

    if (!$stmt->execute()) {
        die("Error al actualizar las respuestas: " . $stmt->error);
    }

    $stmt->close();
    $message = "Respuestas actualizadas correctamente.";

} else {
    // El registro no existe, realizar una inserción
    $stmt = $conn->prepare("
        INSERT INTO respuestas (
            id,
            Nivelacademic,
            Centro_de_estudio,
            pregunta1,
            pregunta2,
            pregunta3,
            pregunta4,
            pregunta5,
            pregunta6,
            pregunta7,
            comentario,
            fecha
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt === false) {
        die("Error en la preparación de la declaración de inserción: " . $conn->error);
    }

    $stmt->bind_param(
        "isssssssssss",
        $id,
        $nivel,
        $centro,
        $preguntas['pregunta1'],
        $preguntas['pregunta2'],
        $preguntas['pregunta3'],
        $preguntas['pregunta4'],
        $preguntas['pregunta5'],
        $preguntas['pregunta6'],
        $preguntas['pregunta7'],
        $comentarios,
        $fecha
    );

    if (!$stmt->execute()) {
        die("Error al insertar las respuestas: " . $stmt->error);
    }

    $stmt->close();
    $message = "Respuestas guardadas correctamente.";
}

// Decidir la URL de redirección basada en el rol del usuario
$redirect_url = $rol === 'root' ? '../html/indexr.php' : '../html/indexu.php';

// Mensaje y redirección mediante JavaScript
echo "<script>
    alert('$message');
    window.location.href = '$redirect_url';
</script>";

// Cerrar conexión
$conn->close();
?>
