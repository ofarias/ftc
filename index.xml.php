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
	$res = $controller->detNom($_POST['fi'], $_POST['ff'],$_POST['tipo']); echo json_encode($res); return $res;
}elseif(isset($_POST['setCU'])){
	$res=$controller->setCU($_POST['cu'],$_POST['anio'], $_POST['tipo']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['setISR'])) {
	$res = $controller->setISR($_POST['anio'], $_POST['val'], $_POST['tipo']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['gIsr'])) {
	$res = $controller->gIsr($_POST['gIsr'],$_POST['anio'], $_POST['datos']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['polFred'])) {
	$res = $controller->polFred($_POST['datos'],$_POST['cta'], $_POST['tipo'], $_POST['mes'], $_POST['anio']);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['gp'])){
	$res = $controller->gp($_POST['nmes'], $_POST['anio'], $_POST['monto']);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['gpd'])){
	$res=$controller->gpd($_POST['po'], $_POST['pt'], $_POST['rfc']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['setTD'])) {
	$res=$controller->setTD($_POST['rfc'], $_POST['t'],$_POST['t2'], $_POST['t3']);
	echo json_encode($res);
	exit();
}elseif(isset($_GET['term']) && isset($_GET['doc'])){
	$res=$controller->getDoc($_GET['term']); echo json_encode($res); exit();
}elseif(isset($_POST['buscaPol'])){
	$res=$controller->buscaPol($_POST['buscaPol']); echo json_encode($res); exit();
}elseif(isset($_POST['repRet'])){
	$res=$controller->repRet($_POST['fi'], $_POST['ff']); echo json_encode($res); exit();
}elseif(isset($_POST['revisaCarga'])){
	$res=$controller->revisaCarga($_POST['revisaCarga']); echo json_encode($res); exit();
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
		if($_GET['tipo']=='r'){
			$res=$controller->nomXML($_GET['anio'],$_GET['mes'], $_GET['tipo']);
			echo json_encode($res); exit(); 
		}else{
			$controller->nomXML($_GET['anio'],$_GET['mes'], $_GET['tipo']);
			break;
		}
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
	case 'verProv':
		$controller->verProv($_GET['mes'], $_GET['anio'], $_GET['ide'], $_GET['doc']);
		break;
	case 'calImpIva':
		$controller->calImpIva($_GET['mes'], $_GET['anio']);
		break;
	case 'calDiot':
		$tipo = isset($_GET['tipo'])? $_GET['tipo']:'';
		$controller->calDiot($_GET['mes'], $_GET['anio'], $tipo);
		break;
	case 'isrDet':
		$controller->isrDet($_GET['mes'], $_GET['anio'], $_GET['tipo']);
		break;
	case 'infoProv':
		$controller->infoProv($_GET['rfc'], $_GET['tipo']);
		break;
	case 'gxf':
		$controller->gxf($_GET['a'], $_GET['m'],$_GET['i'], $_GET['d']);
		break;
	case 'rgxf':
		$controller->rgxf($_GET['u']);
		break;
	case 'cancelados':
		$controller->cancelados($_GET['opc']);
		break;
	case 'acomoda':
		$controller->acomodoXml($_GET['opc']);
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>