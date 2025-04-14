<?php
include '../php/conexion.php'; // Incluye el archivo de conexión

// Función para obtener datos de una pregunta
function getData($conn, $pregunta, $opciones) {
    $sql = "SELECT $pregunta AS respuesta, COUNT(*) as count 
            FROM respuestas 
            WHERE $pregunta IN (" . implode(", ", array_map(function($opcion) use ($conn) {
                return "'" . $conn->real_escape_string($opcion) . "'";
            }, $opciones)) . ") 
            GROUP BY $pregunta";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = [$row['respuesta'], (int)$row['count']];
        }
    } else {
        $data = array_map(function($opcion) {
            return [$opcion, 0];
        }, $opciones);
    }

    return $data;
}

// Opciones para cada pregunta
$opNivelacademic= ['Primaria', 'Secundaria', 'Universidad', 'Técnico'];
$opciones_pregunta1 = ['Frecuentemente', 'Ocasionalmente', 'Rara vez', 'Nunca'];
$opciones_pregunta2 = ['Excelente', 'Buena', 'Regular', 'deficiente'];
$opciones_pregunta3 = ['Sí', 'No'];
$opciones_pregunta4 = ['Sí', 'No'];
$opciones_pregunta5 = ['Sí', 'No'];
$opciones_pregunta6 = ['Generalmente', 'A menudo', 'Casi nunca'];
$opciones_pregunta7 = ['Excelente', 'Buena', 'Regular', 'Deficiente']; // Nueva pregunta

// Obtener datos para cada pregunta
$data_nivelacademic = getData($conn, 'Nivelacademic', $opNivelacademic); 
$data_pregunta1 = getData($conn, 'pregunta1', $opciones_pregunta1);
$data_pregunta2 = getData($conn, 'pregunta2', $opciones_pregunta2);
$data_pregunta3 = getData($conn, 'pregunta3', $opciones_pregunta3);
$data_pregunta4 = getData($conn, 'pregunta4', $opciones_pregunta4);
$data_pregunta5 = getData($conn, 'pregunta5', $opciones_pregunta5);
$data_pregunta6 = getData($conn, 'pregunta6', $opciones_pregunta6);
$data_pregunta7 = getData($conn, 'pregunta7', $opciones_pregunta7);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart']});
      google.charts.setOnLoadCallback(drawCharts);

      function drawCharts() {
        // Datos generados por PHP
        var data_nivelacademic = google.visualization.arrayToDataTable([
          ['Nivelacademic', 'Cantidad'],
          <?php
          foreach ($data_nivelacademic as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta1 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta1 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta2 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta2 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta3 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta3 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta4 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta4 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta5 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta5 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta6 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta6 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);

        var data_pregunta7 = google.visualization.arrayToDataTable([
          ['Respuesta', 'Cantidad'],
          <?php
          foreach ($data_pregunta7 as $row) {
              echo "['" . $row[0] . "', " . $row[1] . "],";
          }
          ?>
        ]);


        // Opciones para gráficos
        var options = {
          pieHole: 0.4
        };

        // Crear y dibujar gráficos
        var chartnivel = new google.visualization.PieChart(document.getElementById('donutchartnivel'));
        chartnivel.draw(data_nivelacademic, { ...options, title: 'Distribución de Respuestas para NIvel academico' });

        var chart1 = new google.visualization.PieChart(document.getElementById('donutchart1'));
        chart1.draw(data_pregunta1, { ...options, title: '¿Con qué frecuencia lees libros o artículos?' });

        var chart2 = new google.visualization.PieChart(document.getElementById('donutchart2'));
        chart2.draw(data_pregunta2, { ...options, title: '¿Cómo calificarías tus habilidades de escritura?' });

        var chart3 = new google.visualization.PieChart(document.getElementById('donutchart3'));
        chart3.draw(data_pregunta3, { ...options, title: '¿Has participado en actividades extracurriculares?' });

        var chart4 = new google.visualization.PieChart(document.getElementById('donutchart4'));
        chart4.draw(data_pregunta4, { ...options, title: '¿Tienes acceso a un centro de educación a tu alcance?' });

        var chart5 = new google.visualization.PieChart(document.getElementById('donutchart5'));
        chart5.draw(data_pregunta5, { ...options, title: '¿Dispones de acceso a Internet?' });

        var chart6 = new google.visualization.PieChart(document.getElementById('donutchart6'));
        chart6.draw(data_pregunta6, { ...options, title: '¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?' });

        var chart7 = new google.visualization.PieChart(document.getElementById('donutchart7'));
        chart7.draw(data_pregunta7, { ...options, title: '¿Cómo calificarías tu habilidad para redactar un texto claro y coherente (por ejemplo, ensayos, cartas)?' });

        
      }
    </script>
    <link rel="stylesheet" href="../css/graficos.css">
    </head>
<body>
<br> <br> 
   <center> <h1>Resultados de la Encuesta</h1>
   <button onclick="window.location.href='indexr.php'">Inicio</button>
   <button onclick="window.location.href='datos.php'">Ver Datos</button>
  </center>
    <div class="chart-column">
    <div id="donutchartnivel" style="width: 900px; height: 500px;"></div>
    <div id="donutchart1" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    </div>
    <div class="chart-column">
    <div id="donutchart2" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    <div id="donutchart3" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    </div>
    <div class="chart-column">
    <div id="donutchart4" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    <div id="donutchart5" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    </div>
    <div class="chart-column">
    <div id="donutchart6" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    <div id="donutchart7" style="width: 900px; height: 500px; margin-bottom: 30px;"></div>
    </div>
</body>
</html>