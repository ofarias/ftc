<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/pegaso.controller.php');
require_once('app/controller/pegaso.controller.cobranza.php');
require_once('app/controller/pegaso.controller.ventas.php');
require_once('app/controller/testsql.php');
require_once('app/controller/controller.coi.php');
$controller = new pegaso_controller;
$controller_cxc = new pegaso_controller_cobranza;
$controller_v = new pegaso_controller_ventas;
$controllerxml = new xml;
$controller_coi = new controller_coi;
if(isset($_GET['action'])){
$action = $_GET['action'];
}else{
	$action = '';
}
if (isset($_POST['usuario'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra'], $_POST['nombre'], $_POST['numletras']);
}elseif (isset($_POST['creaParam'])){
	$cliente=$_POST['cliente'];
	$partidas = $_POST['partidas'];
	$response=$controller_coi->creaParam($cliente, $partidas, $_POST['ide']);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['creaPoliza'])){
	$tipo = $_POST['creaPoliza'];
	$uuid = $_POST['uuid'];
	$response = $controller_coi->creaPoliza($tipo, $uuid, $_POST['ide']);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['editaBanco'])){
	$controller_coi->editaBanco($_POST['idb'], $_POST['si'], $_POST['cuenta'],$_POST['dia'], $_POST['cc'],$_POST['tipo']);
	exit();
}elseif (isset($_POST['insertaBanco'])) {
	$res=$controller_coi->insertaBanco($_POST['banco'],$_POST['cuenta'],$_POST['tipo'],$_POST['moneda'],$_POST['saldo'],$_POST['fecha'],$_POST['serie']);
	echo json_encode($res);
	exit();
}elseif(isset($_GET['term']) && isset($_GET['cuentas'])){
		$buscar = $_GET['term'];
		$nombres = $controller_coi->traeCuentasContables($buscar);
		echo json_encode($nombres);
		exit;
}elseif (isset($_POST['actCuentaImp'])) {
	$res=$controller_coi->actCuentaImp($_POST['idc'],$_POST['actCuentaImp']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['verBancos'])) {
	$res=$controller_coi->verBancos($t='pol');
	echo json_encode($res);
	exit();
}elseif(isset($_POST['polizaFinal'])){
	$res=$controller_coi->polizaFinal($_POST['uuid'], $_POST['tipo'], $_POST['idp'], $_POST['tipoxml']);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['sadPol'])){
	$res=$controller_coi->sadPol($_POST['uuid'], $_POST['sadPol']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['contabiliza'])) {
	$res=$controller_coi->contabiliza($_POST['tipo'], $_POST['idp'], $_POST['a']);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['borraCuenta'])){
	$res=$controller_coi->borraCuenta($_POST['idImp'], $_POST['opcion']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['grabaImp'])) {
	$res=$controller_coi->grabaImp($_POST['imp'],$_POST['cccoi'],$_POST['tipo'],$_POST['tasa'],$_POST['uso'], $_POST['nombre'], $_POST['factor'], $_POST['aplica'], $_POST['status']);
}elseif(isset($_POST['contabilizaIg'])){
	$res=$controller_coi->contabilizaIg($_POST['idp'],$_POST['y'],$_POST['tipo']);
	echo json_encode($res);
	exit();
}
else{switch ($_GET['action']){
	//case 'inicio':
	//	$controller->Login();
	//	break;
	case 'login':
		$controller->Login();
		break;
	case 'CambiarSenia':
		$controller->CambiarSenia();
		break;
	case 'verPolizas':
		$controller_coi->verPolizas($_GET['uuid']);
		break;
	case 'verBancos':
		$controller_coi->verBancos($t='cat');
		break;
	case 'editBanco':
		$controller_coi->editBanco($_GET['idb']);
		break;
	case 'cuentasImp':
		$controller_coi->cuentasImp();
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>