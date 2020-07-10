<?php
	session_start();
	date_default_timezone_set('America/Mexico_City');
	require_once('app/controller/controller_mobile.php');
	$controller = new mobile_c;


if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = '';
}
if (isset($_POST['sync'])){
	$controller->sync();
	exit();	
}
else{switch ($_GET['action']){
	case 'stat':
		$controller_stat->verEstadistica($_GET['mes'], $_GET['anio'], $_GET['tipo'], $_GET['t']);
		break;
	default:
	header('Location: index_log.php?action=index.php');
	break;
	}

}
?>