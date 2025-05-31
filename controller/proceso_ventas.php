<?php 
session_start();

require "../config/conexion.php";
require "../model/proceso_ventas.php";

$proceso_ventas = new ProcesoVentas();

$option = '';
$id = '';
$nombres = '';
$dni = '';
$celular = '';
$credito = '';
$linea = '';
$plazo = '';
$tem = '';
$id_usuario = '';
$tipo_producto = '';
$estado = '';
$documento = '';

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['nombres'])){ $nombres = $_POST['nombres']; }else{ $nombres = "";};
if(isset($_POST['dni'])){ $dni = $_POST['dni']; }else{ $dni = "";};
if(isset($_POST['celular'])){ $celular = $_POST['celular']; }else{ $celular = "";};
if(isset($_POST['credito'])){ $credito = $_POST['credito']; }else{ $credito = "";};
if(isset($_POST['linea'])){ $linea = $_POST['linea']; }else{ $linea = "";};
if(isset($_POST['plazo'])){ $plazo = $_POST['plazo']; }else{ $plazo = "";};
if(isset($_POST['tem'])){ $tem = $_POST['tem']; }else{ $tem = "";};
if(isset($_POST['id_usuario'])){ $id_usuario = $_POST['id_usuario']; }else{ $id_usuario = "";};
if(isset($_POST['tipo_producto'])){ $tipo_producto = $_POST['tipo_producto']; }else{ $tipo_producto = "";};
if(isset($_POST['estado'])){ $estado = $_POST['estado']; }else{ $estado = "";};
if (!empty($_FILES['documento']['name']))
    $documento = $_FILES['documento']['name'];



switch ($option) {

    case 'listar_pventas':
        $por_pagina = 7; // Número de registros por página
        $offset = ($pagina - 1) * $por_pagina;
        $pventas = $proceso_ventas->obtener_procesoventas_paginados($por_pagina, $offset);
        echo json_encode($pventas);
    break;

    case 'procesoventas_x_id':
        echo json_encode($proceso_ventas->obtener_procesoventas_x_id($id));
    break;

    case 'contar_pventas':
        $total_procesoventas = $proceso_ventas->contar_procesoventas();
        echo json_encode(['total' => $total_procesoventas]);
    break;

    case 'agregar_procesoventas':
        echo json_encode($proceso_ventas->agregar_procesoventas($nombres, $dni, $celular,$credito, $linea, $plazo,$tem,$id_usuario,$tipo_producto,$estado, $documento));
    break;

    default:
        echo json_encode(['error' => 'Opción no válida']);
        // echo json_encode($proceso_ventas->procesoventas_x_id($_SESSION['id']));  
    break;

    
}