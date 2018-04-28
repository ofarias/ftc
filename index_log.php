<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/controller_reparto.php');
require_once('app/controller/testsql.php');
$controller_reparto = new pegaso_reparto;
if(isset($_GET['action'])){
$action = $_GET['action'];
}else{
	$action = '';
}

if (isset($_POST['usuario'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif(isset($_POST['buscaQR'])){
	$qr=$_POST['buscaQR'];
	$response=$controller_reparto->buscaQR($qr);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['finalizaoperador'])){
	$oc = $_POST['oc'];
	$response=$controller_reparto->finalizaoperador($oc);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['buscaQR2'])){
	$oc = $_POST['oc'];
	$qr=$_POST['qr'];
	$response=$controller_reparto->buscaQR2($oc, $qr);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['prerecep'])) {
	$doco=$_POST['doco'];
	$cantr=$_POST['cantr'];
	$partida =$_POST['partida'];
	$producto = $_POST['producto'];
	$response=$controller_reparto->prerecep($doco, $cantr, $partida, $producto);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['regDocOp'])){
	$oc=$_POST['regDocOp'];
	$response=$controller_reparto->regDocOp($oc);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['obtieneQR'])) {
	$oc=$_POST['obtieneQR'];
	$response=$controller_reparto->obtieneQR($oc);
	echo json_encode($response);
	exit();
}
else{switch ($_GET['action']){
	case 'login':
		$controller_reparto->Login();
		break;
	case 'scaneaDocumentoRep':
		if(isset($_GET['qr'])){
			$qr=$_GET['qr'];
		}else{
			$qr='';
		}
		$controller_reparto->scaneaDocumentoRep($qr);
		break;
	case 'procesarDoco':
		$doco = $_GET['doco'];
		$controller_reparto->procesarDoco($doco);
		break;
	default:
	header('Location: index_log.php?action=scaneaDocumentoRep');
	break;
	}

}
?>