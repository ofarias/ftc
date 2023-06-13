<?php
session_start();
	date_default_timezone_set('America/Mexico_City');
	require_once('app/controller/controller_stat.php');
	$controller_stat = new statics_c;

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = '';
}

if (isset($_POST['e'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif(isset($_POST['buscaQR'])){
	$qr=$_POST['buscaQR'];
	$response=$controller_reparto->buscaQR($qr);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['updateInfo'])) {
	$controller_stat->updateInfo($_POST['eje']);
	exit();
}
else{switch ($_GET['action']){
	case 'stat':
		$controller_stat->verEstadistica($_GET['mes'], $_GET['anio'], $_GET['tipo'], $_GET['t']);
		break;
	case 'detStat':
		$gt = isset($_GET['gt'])? $_GET['gt']:'M';
		$vw = isset($_GET['view'])? $_GET['view']:'N';
		$controller_stat->detStat($_GET['cliente'], $_GET['mes'], $_GET['anio'],$_GET['tipo'], $gt, $vw);
		break;
	case 'updateInfo':
		$controller_stat->updateInfo($_GET['eje']);
		break;
	case 'repTipo':
		$controller_stat->repTipo($_GET['anio'], $_GET['tipo']);
		break;
	case 'verProy':
		$controller_stat->verProy($_GET['id']);
		break;
	default:
	header('Location: index_log.php?action=scaneaDocumentoRep');
	break;
	}

}
?>