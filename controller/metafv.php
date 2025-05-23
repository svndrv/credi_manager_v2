<?php 

require "../config/conexion.php";
require "../model/metasfv.php";

$metasfv = new Metasfv();

$option = '';
$id = '';
$ld_cantidad = '';
$ld_monto = '';
$tc_cantidad = '';
$sede = '';
$mes = '';
$cumplido = '';

if(isset($_POST['option'])){ $option = $_POST['option']; }else{ $option = "";};
if(isset($_POST['id'])){ $id = $_POST['id']; }else{ $id = "";};
if(isset($_POST['ld_cantidad'])){ $ld_cantidad = $_POST['ld_cantidad']; }else{ $ld_cantidad = "";};
if(isset($_POST['ld_monto'])){ $ld_monto = $_POST['ld_monto']; }else{ $ld_monto = "";};
if(isset($_POST['tc_cantidad'])){ $tc_cantidad = $_POST['tc_cantidad']; }else{ $tc_cantidad = "";};
if(isset($_POST['sede'])){ $sede = $_POST['sede']; }else{ $sede = "";};
if(isset($_POST['mes'])){ $mes = $_POST['mes']; }else{ $mes = "";};
if(isset($_POST['cumplido'])){ $cumplido = $_POST['cumplido']; }else{ $cumplido = "";};

switch($option){
    case "eliminar_metafv":
        echo json_encode($metasfv->eliminar_metafv($id));
    break;
    case "actualizar_metafv":
        echo json_encode($metasfv->actualizar_metafv($id, $ld_cantidad, $tc_cantidad, $ld_monto, $sede,$mes, $cumplido));
    break;
    case "obtener_x_id":
        echo json_encode($metasfv->obtener_meta_x_id($id));
    break;
    case 'filtro_metasfv':
        echo json_encode($metasfv->obtener_metas_por_mes_y_cumplido($mes, $cumplido));
    break;
    case 'agregar_metafv':
        echo json_encode($metasfv->agregar_metafv($ld_cantidad, $ld_monto, $tc_cantidad, $sede, $mes, $cumplido));
    break;
    case 'ultima_meta':
        echo json_encode($metasfv->obtener_ultimo_registro());
    break;
    default:
        echo json_encode($metasfv->obtener_metasfv());
    break;
    
   
}
?>