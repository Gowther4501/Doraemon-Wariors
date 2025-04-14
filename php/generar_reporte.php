<?php
require '../vendor/autoload.php'; // Asegúrate de tener la autoload de Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Incluir el archivo de conexión a la base de datos
include '../php/conexion.php';

// Crear nuevo archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Obtener el tipo de reporte
$reportType = $_POST['report_type'];

if ($reportType == 'fecha') {
    // Reporte por fecha
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    
    if (empty($fecha_inicio) || empty($fecha_fin)) {
        die("Por favor, complete todas las fechas.");
    }
    
    $query = "SELECT * FROM respuestas WHERE fecha BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nivel Académico');
    $sheet->setCellValue('C1', 'Centro de Estudio');
    $sheet->setCellValue('D1', '¿Con qué frecuencia lees libros o artículos?');
    $sheet->setCellValue('E1', '¿Cómo calificarías tus habilidades de escritura?');
    $sheet->setCellValue('F1', 'Has participado en actividades extracurriculares?');
    $sheet->setCellValue('G1', '¿Tienes acceso a un centro de educación a tu alcance?');
    $sheet->setCellValue('H1', '¿Dispones de acceso a Internet?');
    $sheet->setCellValue('I1', '¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?');
    $sheet->setCellValue('J1', '¿Cómo calificarías tus habilidades para redactar textos?');
    $sheet->setCellValue('K1', 'Comentario');
    $sheet->setCellValue('L1', 'Fecha');
    
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id_respuesta']);
        $sheet->setCellValue('B' . $row, $data['Nivelacademic']);
        $sheet->setCellValue('C' . $row, $data['Centro_de_estudio']);
        $sheet->setCellValue('D' . $row, $data['pregunta1']);
        $sheet->setCellValue('E' . $row, $data['pregunta2']);
        $sheet->setCellValue('F' . $row, $data['pregunta3']);
        $sheet->setCellValue('G' . $row, $data['pregunta4']);
        $sheet->setCellValue('H' . $row, $data['pregunta5']);
        $sheet->setCellValue('I' . $row, $data['pregunta6']);
        $sheet->setCellValue('J' . $row, $data['pregunta7']);
        $sheet->setCellValue('K' . $row, $data['comentario']);
        $sheet->setCellValue('L' . $row, $data['fecha']);
        $row++;
    }
    
} elseif ($reportType == 'total') {
    // Reporte total
    $query = "SELECT * FROM respuestas";
    $result = $conn->query($query);
      
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nivel Académico');
    $sheet->setCellValue('C1', 'Centro de Estudio');
    $sheet->setCellValue('D1', '¿Con qué frecuencia lees libros o artículos?');
    $sheet->setCellValue('E1', '¿Cómo calificarías tus habilidades de escritura?');
    $sheet->setCellValue('F1', 'Has participado en actividades extracurriculares?');
    $sheet->setCellValue('G1', '¿Tienes acceso a un centro de educación a tu alcance?');
    $sheet->setCellValue('H1', '¿Dispones de acceso a Internet?');
    $sheet->setCellValue('I1', '¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?');
    $sheet->setCellValue('J1', '¿Cómo calificarías tus habilidades para redactar textos?');
    $sheet->setCellValue('K1', 'Comentario');
    $sheet->setCellValue('L1', 'Fecha');
    
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id_respuesta']);
        $sheet->setCellValue('B' . $row, $data['Nivelacademic']);
        $sheet->setCellValue('C' . $row, $data['Centro_de_estudio']);
        $sheet->setCellValue('D' . $row, $data['pregunta1']);
        $sheet->setCellValue('E' . $row, $data['pregunta2']);
        $sheet->setCellValue('F' . $row, $data['pregunta3']);
        $sheet->setCellValue('G' . $row, $data['pregunta4']);
        $sheet->setCellValue('H' . $row, $data['pregunta5']);
        $sheet->setCellValue('I' . $row, $data['pregunta6']);
        $sheet->setCellValue('J' . $row, $data['pregunta7']);
        $sheet->setCellValue('K' . $row, $data['comentario']);
        $sheet->setCellValue('L' . $row, $data['fecha']);
        $row++;
    }
    
} elseif ($reportType == 'nivel_academico') {
    // Reporte por nivel académico
    $nivel_academico = $_POST['nivel_academico'];
    
    if (empty($nivel_academico)) {
        die("Por favor, seleccione un nivel académico.");
    }
    
    $query = "SELECT * FROM respuestas WHERE Nivelacademic = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nivel_academico);
    $stmt->execute();
    $result = $stmt->get_result();
    
  
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nivel Académico');
    $sheet->setCellValue('C1', 'Centro de Estudio');
    $sheet->setCellValue('D1', '¿Con qué frecuencia lees libros o artículos?');
    $sheet->setCellValue('E1', '¿Cómo calificarías tus habilidades de escritura?');
    $sheet->setCellValue('F1', 'Has participado en actividades extracurriculares?');
    $sheet->setCellValue('G1', '¿Tienes acceso a un centro de educación a tu alcance?');
    $sheet->setCellValue('H1', '¿Dispones de acceso a Internet?');
    $sheet->setCellValue('I1', '¿Con qué frecuencia vuelves a releer los textos para lograr entenderlos?');
    $sheet->setCellValue('J1', '¿Cómo calificarías tus habilidades para redactar textos?');
    $sheet->setCellValue('K1', 'Comentario');
    $sheet->setCellValue('L1', 'Fecha');
    
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id_respuesta']);
        $sheet->setCellValue('B' . $row, $data['Nivelacademic']);
        $sheet->setCellValue('C' . $row, $data['Centro_de_estudio']);
        $sheet->setCellValue('D' . $row, $data['pregunta1']);
        $sheet->setCellValue('E' . $row, $data['pregunta2']);
        $sheet->setCellValue('F' . $row, $data['pregunta3']);
        $sheet->setCellValue('G' . $row, $data['pregunta4']);
        $sheet->setCellValue('H' . $row, $data['pregunta5']);
        $sheet->setCellValue('I' . $row, $data['pregunta6']);
        $sheet->setCellValue('J' . $row, $data['pregunta7']);
        $sheet->setCellValue('K' . $row, $data['comentario']);
        $sheet->setCellValue('L' . $row, $data['fecha']);
        $row++;
    }
}

$conn->close();

// Guardar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'reporte_' . date('YmdHis') . '.xlsx';
$writer->save($filename);

// Forzar descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
