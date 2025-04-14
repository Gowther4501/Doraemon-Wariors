<?php
include '../php/conexion.php';

// Inicializar filtros
$usuarioFiltro = '';
$fechaInicioFiltro = '';
$fechaFinFiltro = '';

// Obtener filtros de la solicitud GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['usuario'])) {
        $usuarioFiltro = htmlspecialchars($_GET['usuario']);
    }
    if (isset($_GET['fecha_inicio'])) {
        $fechaInicioFiltro = htmlspecialchars($_GET['fecha_inicio']);
    }
    if (isset($_GET['fecha_fin'])) {
        $fechaFinFiltro = htmlspecialchars($_GET['fecha_fin']);
    }
}

// Preparar consulta
$query = "
    SELECT r.id_respuesta, l.Usuario, r.Nivelacademic, r.Centro_de_estudio, 
           r.pregunta1, r.pregunta2, r.pregunta3, r.pregunta4, r.pregunta5, 
           r.pregunta6, r.pregunta7, r.comentario, r.fecha
    FROM respuestas r
    JOIN login l ON r.id = l.id_cliente
    WHERE 1=1
";

if (!empty($usuarioFiltro)) {
    $query .= " AND l.Usuario LIKE '%" . $conn->real_escape_string($usuarioFiltro) . "%'";
}
if (!empty($fechaInicioFiltro) && !empty($fechaFinFiltro)) {
    $query .= " AND r.fecha BETWEEN '" . $conn->real_escape_string($fechaInicioFiltro) . "' AND '" . $conn->real_escape_string($fechaFinFiltro) . "'";
}

// Ejecutar la consulta y verificar si hubo éxito
$result = $conn->query($query);

if ($result === false) {
    // Mostrar error si la consulta falla
    die("Error en la consulta: " . $conn->error);
}

// Verificar si se obtuvieron resultados
$rowsExist = $result && $result->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Respuestas</title>
    <link rel="stylesheet" href="../css/datos.css"> <!-- Opcional: Puedes agregar tu propio CSS -->
</head>
<body>
    <h1>Respuestas de la encuesta</h1>
    <!-- Formulario de filtro -->
    <form action="" method="get">
        <fieldset>
            <legend>Filtros de búsqueda</legend>
            <label for="usuario">Buscar por usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuarioFiltro); ?>">
            <p> Filtrar por rango de fechas</p>
            <label for="fecha_inicio">Fecha de inicio (YYYY-MM-DD):</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($fechaInicioFiltro); ?>">
            <label for="fecha_fin">Fecha de fin (YYYY-MM-DD):</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($fechaFinFiltro); ?>">
            <input type="submit" value="Buscar">
        </fieldset>
    </form>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Respuesta</th>
                    <th>Usuario</th>
                    <th>Nivel Académico</th>
                    <th>Centro de Estudio</th>
                    <th>Frecuencia de lectura</th>
                    <th>Habilidades de lectura</th>
                    <th>Actividades extracurriculares</th>
                    <th>Acceso a Educación</th>
                    <th>Disponibilidad de internet</th>
                    <th>Frecuencia para releer textos</th>
                    <th>Habilidades de redacción</th>
                    <th>Comentario</th>
                    <th>Fecha de elaboración</th>
                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rowsExist) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_respuesta']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Usuario']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Nivelacademic']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Centro_de_estudio']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta1']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta2']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta3']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta4']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta5']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta6']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pregunta7']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['comentario']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                        echo "<td>
                                <form style='display:inline;' action='editar.php' method='get'>
                                    <input type='hidden' name='id' value='" . urlencode($row['id_respuesta']) . "'>
                                    <button type='submit' class='btn-edit'>Editar</button>
                                </form>
                                <form style='display:inline;' action='eliminar.php' method='get' onsubmit=\"return confirm('¿Estás seguro de que deseas eliminar esta entrada?');\">
                                    <input type='hidden' name='id' value='" . urlencode($row['id_respuesta']) . "'>
                                    <button type='submit' class='btn-delete'>Eliminar</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>No se encontraron resultados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="indexr.php" class="btn-home">Volver al Inicio</a>
    <a href="graficas.php" class="btn-home">Gráfico</a>
    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
