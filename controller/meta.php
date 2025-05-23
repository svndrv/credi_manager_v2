<?php 

require "../config/conexion.php";
require "../model/metas.php";

$metas = new Metas();

$option = '';
$id = '';
$ld_cantidad = '';
$ld_monto = '';
$tc_cantidad = '';
$id_usuario = '';
$mes = '';
$cumplido = '';

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['ld_cantidad'])){ $ld_cantidad = $_POST['ld_cantidad']; }else{ $ld_cantidad = "";};
if(isset($_POST['ld_monto'])){ $ld_monto = $_POST['ld_monto']; }else{ $ld_monto = "";};
if(isset($_POST['tc_cantidad'])){ $tc_cantidad = $_POST['tc_cantidad']; }else{ $tc_cantidad = "";};
if(isset($_POST['id_usuario'])){ $id_usuario = $_POST['id_usuario']; }else{ $id_usuario = "";};
if(isset($_POST['mes'])){ $mes = $_POST['mes']; }else{ $mes = "";};
if(isset($_POST['cumplido'])){ $cumplido = $_POST['cumplido']; }else{ $cumplido = "";};

switch($option){
    case "obtener_metas_por_usuario":
        echo json_encode($metas->obtener_metas_por_usuario($id_usuario, $mes, $cumplido));
    break;
    case "eliminar_meta":
        echo json_encode($metas->eliminar_meta($id));
    break;
    case "actualizar_meta":
        echo json_encode($metas->actualizar_meta($id, $ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido));
    break;
    case "obtener_x_id":
        echo json_encode($metas->obtener_meta_x_id($id));
    break;
    case 'filtro_metas':
        echo json_encode($metas->metas_x_usuario_mes_cumplido($id_usuario, $mes, $cumplido));
    break;
    case 'agregar_meta':
        echo json_encode($metas->agregar_meta($ld_cantidad, $ld_monto, $tc_cantidad, $id_usuario, $mes, $cumplido));
    break;
    default:
        echo json_encode($metas->obtener_metas());
    break;
    
   
}
?>
