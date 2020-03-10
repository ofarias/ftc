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
}elseif (isset($_POST['nuevoEquipo'] )) {
	$controller->nuevoEquipo($_POST['cliente'], $_POST['usuario'], $_POST['equipo'], $_POST['ad_name'], $_POST['marca'], $_POST['modelo'], $_POST['procesador'],$_POST['so'],$_POST['dom'], $_POST['senia'], $_POST['hdd_inst'], $_POST['dd_principal'], $_POST['mem_inst'], $_POST['mem_max'], $_POST['t_memoria'], $_POST['ns'], $_POST['correo'], $_POST['tv'], $_POST['tvc'], $_POST['t_ip'], $_POST['ip'], $_POST['mac'], $_POST['rdp'], $_POST['area'], $_POST['anio'], $_POST['eth'], $_POST['obs']);
	exit();
}elseif(isset($_POST['nuevoUsuario'])){
	$controller->nuevoUsuario($_POST['cliente'], $_POST['nombre'], $_POST['segundo'], $_POST['paterno'], $_POST['materno'], $_POST['correo'], $_POST['telefono'], $_POST['extension'], $_POST['cargo']);
	exit();
}elseif (isset($_POST['creaTicket'])){
	$controller->creaTicket($_POST['cliente'], $_POST['reporta'], $_POST['usuario'], $_POST['equipo'], $_POST['fecha'], $_POST['tipo'], $_POST['sistema'], $_POST['corta'], $_POST['completa'], $_POST['solucion'], $_POST['modo'], $_POST['creaTicket']);
	exit();
}elseif (isset($_POST['bajaFile'])){
	$res=$controller->bajaFile($_POST['idf']);
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
		$temp = isset($_GET['temp'])? $_GET['temp']:0;
		$controller->tickets($temp);
		break;
	case 'nuevoTicket':
		$clie = isset($_GET['cli'])? $_GET['cli']:'';
		$controller->nuevoTicket($clie);
		break;
	case 'usuarios':
		$controller->usuarios();
		break;
	case 'altaUsuario':
		$clie = isset($_GET['cliente'])? $_GET['cliente']:'';
		$controller->altaUsuario($clie);
		break;
	case 'invServ':
		$controller->invServ();
		break;
	case 'altaEquipo':
		$clie= isset($_GET['cliente'])? $_GET['cliente']:'';
		$controller->altaEquipo($clie);
		break;
	case 'verDetalleTicket':
		$controller->verDetalleTicket($_GET['id']);
		break;
	case 'verArchivos':
		$clie = isset($_GET['clie'])? $_GET['clie']:null;
		$ticket = isset($_GET['ticket'])? $_GET['ticket']:null;
		$status = isset($_GET['status'])? $_GET['status']:1;
		$controller->verArchivos($_GET['tipo'], $ticket, $clie, $status);
		break;
	default: 
		header('Location: index.php?action=login');
		break;
	}

}
?>