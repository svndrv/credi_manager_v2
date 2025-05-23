<?php
$archivo = '../descargables/plantilla_excel.xlsx';

if (file_exists($archivo)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));
    readfile($archivo);
    exit;
} else {
    echo "El archivo no existe.";
}