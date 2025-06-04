<?php 

require "../config/conexion.php";
require "../model/consultas.php";
require "../model/base.php";

$consultas = new Consultas();
$base = new Base();

$id = '';
$dni = '';
$celular = '';
$descripcion = '';
$campana = '';

$option = isset($_POST['option']) ? $_POST['option'] : '';
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['dni'])){ $dni = $_POST['dni']; }else{ $dni = "";};
if(isset($_POST['celular'])){ $celular = $_POST['celular']; }else{ $celular = "";};
if(isset($_POST['descripcion'])){ $descripcion = $_POST['descripcion']; }else{ $descripcion = "";};
if(isset($_POST['campana'])){ $campana = $_POST['campana']; }else{ $campana = "";};

switch($option){

    case 'listar_consultas_pag':
        $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $consultas = $consultas->obtener_consultas_paginados($por_pagina, $offset);
        echo json_encode($consultas);
    break;
    case 'contar_consultas':
        $consultas = $consultas->contar_consultas();
        echo json_encode(['total' => $consultas]);
    break;
    case 'contar_consultas_filtro':
        $total = $consultas->contar_consultas_filtro($dni, $campana);
        echo json_encode(['total' => $total]);
    break;
    
    case "crear_consulta":
        $consultas->crear_consulta($dni,$celular,$descripcion,$campana);
    break;
    case "verificar_dni_base":
        $base->verificar_dni_base($dni);
    break;
    case "eliminar_consulta":
        echo json_encode($consultas->eliminar_consulta($id));
    break;
    case "filtro_consultas":
         $por_pagina = 7;
        $offset = ($pagina - 1) * $por_pagina;
        $consultas = $consultas->obtener_x_dni_campana($dni, $campana,$por_pagina, $offset);
        echo json_encode($consultas);
    break;
    case "obtener_x_id":
        echo json_encode($consultas->obtener_consulta_x_id($id));
    break;
    case "actualizar_consulta":
        $consultas->actualizar_consulta($id,$dni,$celular,$descripcion,$campana);
    break;  
    default:
        //echo json_encode($consultas->obtener_consultas());
        //echo json_encode(['error' => 'Opción no válida']);
$total = $consultas->contar_consultas_filtro($dni, $campana);
    echo json_encode(['total' => $total]);
    break;

}


   

?>