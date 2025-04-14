<?php
include 'conexion.php'; 
session_start();

if (!isset($_SESSION['id'])) {
    die("No estás autorizado para acceder a esta página.");
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("
    SELECT 
        Nivelacademic, 
        Centro_de_estudio, 
        pregunta1, 
        pregunta2, 
        pregunta3, 
        pregunta4, 
        pregunta5, 
        pregunta6, 
        pregunta7, 
        comentario 
    FROM respuestas 
    WHERE id = ?
");

if ($stmt === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<div class='container'>";
    echo "<p class='no-result'>No se encontraron respuestas para mostrar.</p>";
    echo '<p><a class="back-link" href="../html/indexu.php">Volver al inicio</a></p>';
    echo "</div>";
    $stmt->close();
    $conn->close();
    exit();
}

$respuestas = $result->fetch_assoc();

$stmt->close();
$conn->close();


$preguntas = [
    1 => "¿Con qué frecuencia lees libros o artículos?",
    2 => "¿Cómo calificarías tus habilidades de escritura?",
    3 => "Has participado en actividades extracurriculares?",
    4 => "¿Tienes acceso a un centro de educación a tu alcance?",
    5 => "¿Dispones de acceso a Internet?",
    6 => "¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?",
    7 => "¿Cómo calificarías tus habilidades para redactar textos?"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/res.css">
    <title>Mostrar Respuestas</title>
 
</head>
<body>
    <div class="container">
        <h3>Datos del Formulario</h3>
        <p><strong>Nivel Academico:</strong> <?php echo htmlspecialchars($respuestas['Nivelacademic']); ?></p>
        <p><strong>Centro Academico:</strong> <?php echo htmlspecialchars($respuestas['Centro_de_estudio']); ?></p>
        <?php
        for ($i = 1; $i <= 7; $i++) {
            $pregunta_key = "pregunta$i";
            echo "<p><strong>{$preguntas[$i]}:</strong> " . htmlspecialchars($respuestas[$pregunta_key]) . "</p>";
        }
        ?>
        <p><strong>Comentarios:</strong> <?php echo htmlspecialchars($respuestas['comentario']); ?></p>
        <p><a class="back-link" href="../html/indexu.php">Volver al inicio</a></p>
    </div>
</body>
</html>