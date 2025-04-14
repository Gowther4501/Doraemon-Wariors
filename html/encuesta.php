<?php
session_start(); 
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); 
    exit(); 
}
$id_cliente = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="page active" id="page1">
        <h1 id="p1">Encuesta</h1>
        <form id="surveyForm" action="../php/procesar_encuesta.php" method="post">
            <!-- Página 1: Información Académica -->
            <fieldset>
                <legend>Información Académica</legend>
                <label id="lb2" for="nivel">¿Cuál es tu nivel académico?</label><br>
                <div class="radio-group">
                    <input type="radio" id="primaria" name="nivel" value="primaria" required>
                    <label for="primaria">Primaria</label>
                    <input type="radio" id="secundaria" name="nivel" value="secundaria" required>
                    <label for="secundaria">Secundaria</label>
                    <input type="radio" id="universidad" name="nivel" value="universidad" required>
                    <label for="universidad">Universidad</label>
                    <input type="radio" id="Tecnico" name="nivel" value="Educacion Tecnica" required>
                    <label for="Tecnico">Educación técnica</label><br><br>
                </div>
                <label id="lb2" for="centro">Ingrese su centro académico:</label><br>
                <input type="text" id="centro" name="centro" required><br><br>
            </fieldset>
            <button type="button" onclick="nextPage()">Siguiente</button>
        </div>

        <!-- Página 2: Evaluación de Habilidades de Lectura y Escritura -->
        <div class="page" id="page2">
            <fieldset>
                <legend>Habilidades de Lectura y Escritura</legend>
                <label id="lb2" for="pregunta1">¿Con qué frecuencia lees libros o artículos?</label><br>
                <div class="radio-group">
                    <input type="radio" id="frecuentemente" name="pregunta1" value="frecuentemente" required>
                    <label for="frecuentemente">Frecuentemente</label><br>
                    <input type="radio" id="ocasionalmente" name="pregunta1" value="ocasionalmente" required>
                    <label for="ocasionalmente">Ocasionalmente</label><br>
                    <input type="radio" id="rara_vez" name="pregunta1" value="rara vez" required>
                    <label for="rara_vez">Rara vez</label><br>
                    <input type="radio" id="nunca" name="pregunta1" value="nunca" required>
                    <label for="nunca">Nunca</label><br><br>
                </div>
                <label id="lb2" for="pregunta2">¿Cómo calificarías tus habilidades de escritura?</label><br>
                <div class="radio-group">
                    <input type="radio" id="excelente" name="pregunta2" value="excelente" required>
                    <label for="excelente">Excelente</label><br>
                    <input type="radio" id="buena" name="pregunta2" value="buena" required>
                    <label for="buena">Buena</label><br>
                    <input type="radio" id="regular" name="pregunta2" value="regular" required>
                    <label for="regular">Regular</label><br>
                    <input type="radio" id="deficiente" name="pregunta2" value="deficiente" required>
                    <label for="deficiente">Deficiente</label><br><br>
                </div>
                <button type="button" onclick="prevPage()">Anterior</button>
                <button type="button" onclick="nextPage()">Siguiente</button>
            </fieldset>
        </div>

        <!-- Página 3: Nuevas Preguntas -->
        <div class="page" id="page3">
            <fieldset>
                <legend>Habilidades de Lectura y Escritura</legend>
                <label id="lb2" for="pregunta3">¿Has participado en actividades extracurriculares?</label><br>
                <div class="radio-group">
                    <input type="radio" id="si" name="pregunta3" value="si" required>
                    <label for="si">Sí</label>
                    <input type="radio" id="no" name="pregunta3" value="no" required>
                    <label for="no">No</label><br><br>
                </div>
                <label id="lb2" for="pregunta4">¿Tienes acceso a un centro de educación a tu alcance?</label><br>
                <div class="radio-group">
                    <input type="radio" id="si" name="pregunta4" value="si" required>
                    <label for="si">Sí</label>
                    <input type="radio" id="no" name="pregunta4" value="no" required>
                    <label for="no">No</label><br><br>
                </div>
                <label id="lb2" for="pregunta5">¿Dispones de acceso a Internet?</label><br>
                <div class="radio-group">
                    <input type="radio" id="si_internet" name="pregunta5" value="si" required>
                    <label for="si_internet">Sí</label>
                    <input type="radio" id="no_internet" name="pregunta5" value="no" required>
                    <label for="no_internet">No</label><br><br>
                </div>
                <button type="button" onclick="prevPage()">Anterior</button>
                <button type="button" onclick="nextPage()">Siguiente</button>
            </fieldset>
        </div>

        <!-- Página 4: Nuevas Preguntas -->
        <div class="page" id="page4">
            <fieldset>
                <legend>Nuevas Preguntas</legend>
                <label id="lb4" for="pregunta6">¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?</label><br>
                <div class="radio-group">
                    <input type="radio" id="generalmente" name="pregunta6" value="generalmente" required>
                    <label for="generalmente">Generalmente</label><br>
                    <input type="radio" id="a_menudo" name="pregunta6" value="a menudo" required>
                    <label for="a_menudo">A menudo</label><br>
                    <input type="radio" id="casi_nunca" name="pregunta6" value="casi nunca" required>
                    <label for="casi_nunca">Casi nunca</label><br><br>
                </div>
                <label id="lb4" for="pregunta7">¿Cómo calificarías tu habilidad para redactar un texto claro y coherente (por ejemplo, ensayos, cartas)?</label><br>
                <div class="radio-group">
                    <input type="radio" id="excelente_redaccion" name="pregunta7" value="excelente" required>
                    <label for="excelente_redaccion">Excelente</label><br>
                    <input type="radio" id="buena_redaccion" name="pregunta7" value="buena" required>
                    <label for="buena_redaccion">Buena</label><br>
                    <input type="radio" id="regular_redaccion" name="pregunta7" value="regular" required>
                    <label for="regular_redaccion">Regular</label><br>
                    <input type="radio" id="deficiente_redaccion" name="pregunta7" value="deficiente" required>
                    <label for="deficiente_redaccion">Deficiente</label><br><br>
                </div>
                <label for="comentarios">Comentarios adicionales:</label><br>
                <textarea id="comentarios" name="comentarios" rows="2" cols="50"></textarea><br><br>
                <button type="button" onclick="prevPage()">Anterior</button>
                <input id="env" type="submit" value="Enviar">
            </fieldset>
        </div>
    </form>

    <script>
        let currentPage = 1;
        const totalPages = 4;

        function showPage(pageNumber) {
            document.querySelectorAll('.page').forEach((page, index) => {
                page.classList.toggle('active', index + 1 === pageNumber);
            });
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        }

        showPage(currentPage);  
    </script>
</body>
</html>
