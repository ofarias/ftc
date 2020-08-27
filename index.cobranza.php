<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once('app/controller/pegaso.controller.php');
require_once('app/controller/pegaso.controller.cobranza.php');

$controller_cxc = new pegaso_controller_cobranza;
$controller_v = new pegaso_controller_ventas;

//exit($_GET['action']);

if (isset($_POST['cobranza'])){
	$controller_cxc->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif(isset($_POST['cobranza'])){
	exit();
}elseif(isset($_POST['DetalleCliente'])){
	if(isset($_POST['cliente'])){
		$cliente = $_POST['cliente'];
	}else{
		$cliente = $_POST['cveclie'];
	}
    $controller_cxc->SaldosxDocumento($cliente);
}elseif (isset($_POST['solCorte'])) {
	$cveclie=$_POST['cveclie'];
	$idsolc = '';
	$controller_cxc->solCorte($cveclie, $idsolc);
}elseif (isset($_POST['cortarCredito'])) {
	$cveclie=$_POST['cveclie'];
	$idsolc = $_POST['idsolc'];
	$fecha =$_POST['fecha'];
	$monto = $_POST['monto'];
	$controller->cortarCredito($cveclie,$idsolc, $fecha, $monto);
}elseif (isset($_POST['liberarDeCorte'])) {
	$cveclie = $_POST['cveclie'];
	$monto = $_POST['monto'];
	$dias =$_POST['dias'];
	$controller->liberarDeCorte($cveclie, $monto, $dias);
}elseif(isset($_POST['marcaDoc'])){
	$doc = $_POST['marcaDoc'];
	$tipo=$_POST['tipo'];
	$response =$controller_cxc->marcaDoc($doc, $tipo);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['FORM_ACTION_PAGO_FACTURAS_NUEVO'])) {
	//$seleccion_cr =$_POST['seleccion_cr'];
	$items =$_POST['items'];
	$total = $_POST['total'];
	if(isset($_POST['pagos'])){
		$pagos = $_POST['pagos'];
	}else{
		$pagos = '0';
	}
	if(isset($_POST['mes'])){
		$mes =$_POST['mes'];
	}else{
		$mes = '';
	}
	if(isset($_POST['anio'])){
		$anio =$_POST['anio'];
	}else{
		$anio = '';
	}
	if(isset($_POST['retorno'])){
		$retorno =$_POST['retorno'];
	}else{
		$retorno = '';
	}
	$maestro = (isset($_POST['maestro']))? $_POST['maestro']:''; 
	$controller_cxc->pagarFacturas($items, $total,$pagos,$mes, $anio, $retorno,$maestro);
}elseif (isset($_POST['creaSolRev'])) {
	$docf = $_POST['creaSolRev'];
	$docp = $_POST['docp'];
	$idc = $_POST['idc'];
	$obs = $_POST['obs'];
	$motivo = $_POST['motivo'];
	$response=$controller_cxc->creaSolRev($docf, $docp, $idc, $obs, $motivo);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['generaCEPPago'])) {
	$pagos =$_POST['generaCEPPago'];
	$idCliente=$_POST['idCliente'];
	$ctaO =$_POST['ctao'];
	$bancoO=$_POST['bancoo'];
	$tipoO =$_POST['tipoO'];
	$numope = $_POST['numope'];
	$response=$controller_cxc->generaCEPPago($pagos, $idCliente, $ctaO, $bancoO,$tipoO,$numope);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['enviarFact'])) {
	$docf=$_POST['docf'];
	$correo=$_POST['correo'];
	$mensaje=$_POST['mensaje'];
	$controller_cxc->enviarFact($docf, $correo, $mensaje);
}elseif (isset($_POST['valida'])) {
	$m=$_POST['valida'];
	$monto=$_POST['monto'];
	$idp=$_POST['idp'];
	$res=$controller_cxc->valida($m, $monto, $idp);
	echo json_encode($res);
	exit();
}elseif(isset($_POST['cancelaAplicacion'])){
	$doc=$_POST['doc'];
	$ida=$_POST['cancelaAplicacion'];
	$idp=$_POST['idp'];
	$response=$controller_cxc->cancelaAplicacion($ida, $doc, $idp);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['utileriaCobranza'])){
	$metodo=$_POST['utileriaCobranza'];
	$maestro =$_POST['maestro'];
	$sel=$_POST['sel'];
	$response=$controller_cxc->utileriaCobranza($metodo, $maestro, $sel);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['actAcr'])){
	$res=$controller_cxc->actAcr();
	echo json_encode($res);
	exit();
}elseif(isset($_POST['aplicaInd'])){
	$res=$controller_cxc->aplicaInd($_POST['idp'],$_POST['monto'], $_POST['uuid']);
	echo json_encode($res);
	exit();
}elseif (isset($_POST['aplUUID'])) {
	$res=$controller_cxc->aplUUID($_POST['uuid']);
	echo json_encode($res);
	exit();
}
else{
	switch ($_GET['action']){
	case 'cobranza':
		$controller_cxc->cobranza();
		break;
	case 'verDocumentosMaestro':
		$maestro=$_GET['maestro'];
		$controller_cxc->verDocumentosMaestro($maestro);
		break;
	case 'CarteraxCliente':
        $cve_maestro = $_GET['cve_maestro'];
        $maestro = $_GET['maestro'];
        $tipo = isset($_GET['tipo'])? $_GET['tipo']:'v';
        $controller_cxc->CarteraxCliente($cve_maestro, $tipo, $maestro);
        break;
    case 'detalleComprometido':
    	$cliente = $_GET['cliente'];
    	$controller_cxc->detalleComprometido($cliente);
    	break;
   	case 'detalleCobranzaCliente':
    	$cliente = $_GET['cliente'];
    	$controller_cxc->detalleCobranzaCliente($cliente);
    	break;
    case 'detalleCobranza':
    	$tipo = $_GET['tipo'];
    	if(isset($_GET['maestro'])){
    		$maestro = $_GET['maestro'];	
    	}else{
    		$maestro = '';
    	}
    	$controller_cxc->detalleCobranza($maestro, $tipo);
    	break;
    case 'verComprobantesPago':
    	$docf=$_GET['docf'];
    	$controller_cxc->verComprobantesPago($docf);
    	break;
    case 'seguimientoCajasRecibir':
			$tipo=$_GET['tipo'];
			$controller_cxc->seguimientoCajasRecibir($tipo);
			break;
	case 'verSaldosPagos':
			$controller_cxc->verSaldosPagos($_GET['t']);
			break;
	case 'envFac':
			$controller_cxc->envFac($_GET['docf']);
			break;
	case 'edoCliente':
		$controller_cxc->edoCliente($_GET['cliente'], $_GET['tipo'],$_GET['nombre']);
		break;
   default:
		header('Location: index.php?action=login');
		break;
	}
}
?>