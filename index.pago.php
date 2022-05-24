<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/controller.pagos.php');
$controller = new ctrl_pago;

if(isset($_POST['detallePago'])){
	$res=$controller->detallePago($_POST['detallePago']); echo json_encode($res);exit;
}elseif (isset($_POST['xmlExcel'])){
	$res=$controller->xmlExcel($_POST['mes'], $_POST['anio'], $_POST['ide'], $_POST['doc'], $_POST['t']); echo json_encode($res); exit();
}
else{
	switch ($_GET['action']){
	//case 'inicio':
	//	$controller->Login();
	//	break;
	case 'login':
		$controller->Login();
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>