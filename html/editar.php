<?php
include '../php/conexion.php';

// Asegúrate de que el ID esté presente en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}

$id = intval($_GET['id']); // Convierte a entero para mayor seguridad

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge y limpia los datos del formulario
    $nivel_academico = htmlspecialchars($_POST['nivel_academico']);
    $centro_de_estudio = htmlspecialchars($_POST['centro_de_estudio']);
    $pregunta1 = htmlspecialchars($_POST['pregunta1']);
    $pregunta2 = htmlspecialchars($_POST['pregunta2']);
    $pregunta3 = htmlspecialchars($_POST['pregunta3']);
    $pregunta4 = htmlspecialchars($_POST['pregunta4']);
    $pregunta5 = htmlspecialchars($_POST['pregunta5']);
    $pregunta6 = htmlspecialchars($_POST['pregunta6']);
    $pregunta7 = htmlspecialchars($_POST['pregunta7']);
    $comentario = htmlspecialchars($_POST['comentario']);
    $fecha = htmlspecialchars($_POST['fecha']);
    
    // Consulta de actualización
    $query = "UPDATE respuestas SET 
              Nivelacademic=?, Centro_de_estudio=?, pregunta1=?, pregunta2=?, 
              pregunta3=?, pregunta4=?, pregunta5=?, pregunta6=?, 
              pregunta7=?, comentario=?, fecha=?
              WHERE id_respuesta=?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssssssssssi", $nivel_academico, $centro_de_estudio, $pregunta1, $pregunta2, $pregunta3, 
                      $pregunta4, $pregunta5, $pregunta6, $pregunta7, $comentario, $fecha, $id);
    $stmt->execute();
    if ($stmt->error) {
        die("Error en la consulta: " . $stmt->error);
    }
    $stmt->close();
    
    header("Location: datos.php"); // Redirige a la página principal después de guardar
    exit;
}

// Consulta para obtener los datos actuales
$query = "SELECT * FROM respuestas WHERE id_respuesta=?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("No se encontraron datos para el ID proporcionado.");
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Respuesta</title>
    <link rel="stylesheet" href="../css/editar.css"> <!-- Enlaza el CSS -->
</head>
<body>
    <h1>Editar Respuesta</h1>
    <form action="editar.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
        <fieldset>
            <legend>Editar Datos</legend>
            <!-- Campo Nivel Académico -->
            <label for="nivel_academico">Nivel Académico:</label>
            <input type="text" id="nivel_academico" name="nivel_academico" value="<?php echo htmlspecialchars($data['Nivelacademic']); ?>" required>
            
            <!-- Campo Centro de Estudio -->
            <label for="centro_de_estudio">Centro de Estudio:</label>
            <input type="text" id="centro_de_estudio" name="centro_de_estudio" value="<?php echo htmlspecialchars($data['Centro_de_estudio']); ?>" required>
            
            <!-- Pregunta 1 -->
            <label for="pregunta1">Pregunta 1:</label>
            <input type="text" id="pregunta1" name="pregunta1" value="<?php echo htmlspecialchars($data['pregunta1']); ?>" required>
            
            <!-- Pregunta 2 -->
            <label for="pregunta2">Pregunta 2:</label>
            <input type="text" id="pregunta2" name="pregunta2" value="<?php echo htmlspecialchars($data['pregunta2']); ?>" required>
            
            <!-- Pregunta 3 -->
            <label for="pregunta3">Pregunta 3:</label>
            <input type="text" id="pregunta3" name="pregunta3" value="<?php echo htmlspecialchars($data['pregunta3']); ?>" required>
            
            <!-- Pregunta 4 -->
            <label for="pregunta4">Pregunta 4:</label>
            <input type="text" id="pregunta4" name="pregunta4" value="<?php echo htmlspecialchars($data['pregunta4']); ?>" required>
            
            <!-- Pregunta 5 -->
            <label for="pregunta5">Pregunta 5:</label>
            <input type="text" id="pregunta5" name="pregunta5" value="<?php echo htmlspecialchars($data['pregunta5']); ?>" required>
            
            <!-- Pregunta 6 -->
            <label for="pregunta6">Pregunta 6:</label>
            <input type="text" id="pregunta6" name="pregunta6" value="<?php echo htmlspecialchars($data['pregunta6']); ?>" required>
            
            <!-- Pregunta 7 -->
            <label for="pregunta7">Pregunta 7:</label>
            <input type="text" id="pregunta7" name="pregunta7" value="<?php echo htmlspecialchars($data['pregunta7']); ?>" required>
            
            <!-- Comentario -->
            <label for="comentario">Comentario:</label>
            <textarea id="comentario" name="comentario" required><?php echo htmlspecialchars($data['comentario']); ?></textarea>
            
            <!-- Fecha -->
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($data['fecha']); ?>" required>
            
            <input type="submit" value="Guardar Cambios">
        </fieldset>
    </form>
    <a href="datos.php">Volver a la Lista</a>
</body>
</html>
