<?php 

require "../config/conexion.php";
require "../model/base.php";

$base = new Base();

$option = '';
$id = '';
$dni = '';
$nombres = '';
$tipo_cliente = '';
$direccion = '';
$distrito = '';
$credito_max = '';
$linea_max = '';
$plazo_max = '';
$tem = '';
$celular_1 = '';
$celular_2 = '';
$celular_3 = '';
$combo = '';
$tipo_producto = '';
$combo = '';


if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['dni'])){ $dni = $_POST['dni']; }else{ $dni = "";};
if(isset($_POST['nombres'])){ $nombres = $_POST['nombres']; }else{ $nombres = "";};
if(isset($_POST['tipo_cliente'])){ $tipo_cliente = $_POST['tipo_cliente']; }else{ $tipo_cliente = "";};
if(isset($_POST['direccion'])){ $direccion = $_POST['direccion']; }else{ $direccion = "";};
if(isset($_POST['distrito'])){ $distrito = $_POST['distrito']; }else{ $distrito = "";};
if(isset($_POST['credito_max'])){ $credito_max = $_POST['credito_max']; }else{ $credito_max = "";};
if(isset($_POST['linea_max'])){ $linea_max = $_POST['linea_max']; }else{ $linea_max = "";};
if(isset($_POST['plazo_max'])){ $plazo_max = $_POST['plazo_max']; }else{ $plazo_max = "";};
if(isset($_POST['tem'])){ $tem = $_POST['tem']; }else{ $tem = "";};
if(isset($_POST['celular_1'])){ $celular_1 = $_POST['celular_1']; }else{ $celular_1 = "";};
if(isset($_POST['celular_2'])){ $celular_2 = $_POST['celular_2']; }else{ $celular_2 = "";};
if(isset($_POST['celular_3'])){ $celular_3 = $_POST['celular_3']; }else{ $celular_3 = "";};
if(isset($_POST['tipo_producto'])){ $tipo_producto = $_POST['tipo_producto']; }else{ $tipo_producto = "";};
if(isset($_POST['combo'])){ $combo = $_POST['combo']; }else{ $combo = "";};


switch ($option) {
    case 'listar':
        $por_pagina = 5; // Número de registros por página
        $offset = ($pagina - 1) * $por_pagina;
        $registros = $base->obtener_registros_paginados($por_pagina, $offset);
        echo json_encode($registros);
    break;

    case 'contar':
        $total_registros = $base->contar_registros();
        echo json_encode(['total' => $total_registros]);
    break;
    case 'base_x_dni':
        echo json_encode($base->obtener_base_x_dni($dni));
    break;
    case 'base_x_id':
        echo json_encode($base->obtener_base_x_id($id));
    break;
    case 'borrar_base':
        echo json_encode($base->borrar_base());
    break;
    default:
        echo json_encode(['error' => 'Opción no válida']);
    break;
}
   

?>