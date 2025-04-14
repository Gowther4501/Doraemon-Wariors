<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link rel="stylesheet" href="../css/reportes.css"> <!-- Vincula tu archivo CSS externo -->
    <script>
        function handleReportTypeChange() {
            var reportType = document.querySelector('input[name="report_type"]:checked').value;
            var fechaFields = document.querySelector('#fecha_fields');
            var nivelField = document.querySelector('#nivel_field');

            if (reportType === 'fecha') {
                fechaFields.style.display = 'block';
                nivelField.style.display = 'none';
            } else if (reportType === 'nivel_academico') {
                fechaFields.style.display = 'none';
                nivelField.style.display = 'block';
            } else {
                fechaFields.style.display = 'none';
                nivelField.style.display = 'none';
            }
        }

        window.onload = function() {
            document.querySelectorAll('input[name="report_type"]').forEach(function(element) {
                element.addEventListener('change', handleReportTypeChange);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Botón Volver al Inicio -->
  
        
        <form action="../php/generar_reporte.php" method="post">
            <fieldset>
                <legend>Tipo de Reporte</legend>
                <input type="radio" id="report_fecha" name="report_type" value="fecha" required>
                <label for="report_fecha">Reporte por Fecha</label><br>
                <input type="radio" id="report_total" name="report_type" value="total" required>
                <label for="report_total">Reporte Total</label><br>
                <input type="radio" id="report_nivel_academico" name="report_type" value="nivel_academico" required>
                <label for="report_nivel_academico">Reporte por Nivel Académico</label>
            </fieldset>

            <div id="fecha_fields" style="display: none;">
                <fieldset>
                    <legend>Reporte por Fecha</legend>
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"><br>
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"><br>
                </fieldset>
            </div>

            <div id="nivel_field" style="display: none;">
                <fieldset>
                    <legend>Reporte por Nivel Académico</legend>
                    <label for="nivel_academico">Nivel Académico:</label>
                    <select id="nivel_academico" name="nivel_academico">
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                        <option value="universidad">Universidad</option>
                        <option value="educacion_tecnica">Educación Técnica</option>
                    </select><br>
                </fieldset>
            </div>

            <button type="submit">Crear</button>
        
            <a href="../html/indexr.php">
                <button type="button">Volver al Inicio</button>
            </a>
    
        </form>
    </div>
</body>
</html>
