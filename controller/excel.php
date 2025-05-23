<?php

require "../config/conexion.php";
require '../model/base.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if ($_FILES['file']['name']) {
    $model = new Base();
    $file = $_FILES['file']['tmp_name'];
    $reader = new Xlsx();
    $spreadsheet = $reader->load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    // Elimina la primera fila si contiene encabezados
    array_shift($sheetData);

    $model->insertData($sheetData);
    echo "success";
}
?>