<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/controller.serv.php');
$controller = new ctrl_serv;
if(isset($_GET['action'])){
$action = $_GET['action'];
}else{
	$action = '';
}
if(isset($_POST['UPLOAD_META_DATA'])){
	$tipo = $_POST['tipo'];
	$files2upload = $_POST['files2upload'];
	$controller->facturacionCargaXML($files2upload, $tipo);
}elseif (isset($_POST['xmlExcel'])){
	$res=$controller->xmlExcel($_POST['mes'], $_POST['anio'], $_POST['ide'], $_POST['doc'], $_POST['t']);
	echo json_encode($res);
	exit();
}
else{
	switch ($_GET['action']){
	//case 'inicio':
	//	$controller->Login();
	//	break;
	case 'login':
		$controller->Login();
		break;
	case 'mserv':
		$controller->mServ();
		break;
	case 'tickets':
		$controller->tickets();
		break;
	case 'nuevoTicket':
		$controller->nuevoTicket();
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>