<?php
include '../php/conexion.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $query = "DELETE FROM respuestas WHERE id_respuesta=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: datos.php"); // Redirige a la página principal después de eliminar
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Respuesta</title>
</head>
<body>
    <h1>Eliminar Respuesta</h1>
    <p>¿Estás seguro de que deseas eliminar esta entrada?</p>
    <form action="eliminar.php?id=<?php echo htmlspecialchars($id); ?>" method="get">
        <input type="submit" value="Confirmar Eliminación">
    </form>
    <a href="datos.php">Cancelar</a>
</body>
</html>
