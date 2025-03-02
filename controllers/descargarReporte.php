<?php
require_once '../vendor/autoload.php'; // Asegúrate de tener las librerías necesarias instaladas

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['format'])) {
    $format = $_GET['format'];
    if ($format == 'pdf') {
        generarPDF();
    } elseif ($format == 'excel') {
        generarExcel();
    }
}

function generarPDF() {
    $dompdf = new Dompdf();
    $html = '<h1>Reporte de Productos</h1><p>Contenido del reporte...</p>'; // Genera el contenido del PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("reporte_productos.pdf", array("Attachment" => 1));
}

function generarExcel() {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Reporte de Productos');
    $sheet->setCellValue('A2', 'Contenido del reporte...'); // Genera el contenido del Excel

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="reporte_productos.xlsx"');
    $writer->save("php://output");
}
?>
