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
}
else{switch ($_GET['action']){
	case 'stat':
		$controller_stat->verEstadistica($_GET['mes'], $_GET['anio'], $_GET['tipo']);
		break;
	case 'detStat':
		$controller_stat->detStat($_GET['cliente'], $_GET['mes'], $_GET['anio'],$_GET['tipo']);
		break;
	default:
	header('Location: index_log.php?action=scaneaDocumentoRep');
	break;
	}

}
?>