<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/pegaso.controller.php');
require_once('app/controller/pegaso.controller.cobranza.php');
require_once('app/controller/pegaso.controller.ventas.php');
require_once('app/controller/testsql.php');
require_once('app/controller/controller.coi.php');
require_once('app/controller/controller.xml.php');
$controller = new controller_xml;
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
}elseif (isset($_POST['cargaEFOS'])) {
	$res = $controller->cargaEFOS();
	echo json_encode($res);
	exit();
}elseif (isset($_POST['infoPer'])) {
	$res = $controller->infoPer($_POST['uuid']);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['detNom'])){
	$res = $controller->detNom($_POST['fi'], $_POST['ff'],$_POST['tipo']);
	echo json_encode($res);
	return $res;
}
else{
	switch ($_GET['action']){
	//case 'inicio':
	//	$controller->Login();
	//	break;
	case 'login':
		$controller->Login();
		break;
	case 'cargaMetaDatos':
		$controller->cargaMetaDatos();
		break;
	case 'verMetaDatos':
		$controller->verMetaDatos();
		break;
	case 'verMetaDatosDet':
		$controller->verMetaDatosDet($_GET['archivo']);
		break;
	case 'zipXML':
		$controller->zipXML($_GET['mes'], $_GET['anio'], $_GET['ide'], $_GET['doc']);
		break;
	case 'verCEP':
		$controller->verCEP($_GET['cep']);
		break;
	case 'verRelacion':
		$controller->verRelacion($_GET['uuid']);
		break;
	case 'actTablas':
		$controller->actTablas();
		break;
	case 'p_c':
		$controller->p_c($_GET['anio'],$_GET['mes']);
		break;
	case 'calculaSaldo':
		$controller->cs();
		break;
	case 'nomXML':
		$controller->nomXML($_GET['anio'],$_GET['mes']);
		break;
	case 'detalleNomina':
		$controller->detalleNomina($_GET['fi'], $_GET['ff']);
		break;
	case 'reciboNomina':
		$controller->reciboNomina($_GET['uuid']);
		break;
	case 'detNom':
		$controller->detNom($_GET['fi'], $_GET['ff'], $_GET['tipo']);
		break;
	case 'verRecibo':
		$controller->verRecibo($_GET['uuid']);
		break;
	case 'calImp':
		$controller->calImp($_GET['mes'], $_GET['anio']);
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>