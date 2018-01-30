<?php
session_start();
//echo $_SESSION["unimed"];
date_default_timezone_set('America/Mexico_City');
//session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
require_once('app/controller/pegaso.controller.cobranza.php');
require_once('app/controller/pegaso.controller.ventas.php');
require_once('app/controller/testsql.php');
$controller = new pegaso_controller;
$controller_cxc = new pegaso_controller_cobranza;
$controller_v = new pegaso_controller_ventas;
$controllerxml = new xml;

//echo $_POST['nombre'];
//echo $_POST['actualizausr'];


if(isset($_GET['action'])){
$action = $_GET['action'];

}else{
	$action = '';
}
if (isset($_POST['usuario'])){
	$controller->InsertaUsuarioN($_POST['usuario'], $_POST['contrasena'], $_POST['email'], $_POST['rol'], $_POST['letra']);	
}elseif (isset($_POST['cambioSenia'])){
	$nuevaSenia=$_POST['nuevaSenia'];
	$actual = $_POST['actualSenia'];
	$usuario=$_POST['u'];
	$controller->cambioSenia($nuevaSenia, $actual, $usuario );
}elseif(isset($_POST['faltaunidades'])){
	$numero = $_POST['numero'];
	$marca = $_POST['marca'];
	$modelo = $_POST['modelo'];
	$placas = $_POST['placas'];
	$operador = $_POST['operador'];
	$tipo = $_POST['tipo'];
	$tipo2 = $_POST['tipo2'];
	$coordinador = $_POST['coordinador'];
	$controller->AltaUnidadesF($numero, $marca, $modelo, $placas, $operador, $tipo, $tipo2, $coordinador);
}elseif(isset($_POST['actualizaUnidades'])){
	$numero = $_POST['numero'];
	$marca = $_POST['marca'];
	$modelo = $_POST['modelo'];
	$placas = $_POST['placas'];
	$operador = $_POST['operador'];
	$tipo = $_POST['tipo'];
	$tipo2 = $_POST['tipo2'];
	$coordinador = $_POST['coordinador'];
	$idu = $_POST['idu'];
	$controller->ActualizaUnidades($numero, $marca, $modelo, $placas, $operador, $tipo, $tipo2, $coordinador, $idu);
}elseif(isset($_POST['user']) && isset($_POST['contra'])){
	$controller->LoginA($_POST['user'], $_POST['contra']);
}elseif(isset($_POST['actualizausr'])){
	$controller->actualiza($_POST['mail'], $_POST['usuario1'], $_POST['contrasena1'], $_POST['email1'], $_POST['rol1'], $_POST['estatus']);
}elseif($action == 'modifica'){
	$controller->ModificaU($_GET['e']);
} elseif(isset($_POST['ccomp'])){	
	$controller->InsertaCcomp($_POST['nombre'], $_POST['duracion'], $_POST['tipo']);
}elseif(isset($_POST['nombreflujo'])){
	$componentes = $_POST["id"];
	$nombre = $_POST['nombreflujo'];	
	$desc = $_POST['desc'];
	$controller->AsignaComp($componentes, $nombre, $desc);
}	
elseif(isset($_POST['INSRTORCOM']) ){

if(!empty($_POST['tiempoEntrega'])){
	echo 'Lleva partida con tiempo de entrega';
}

if(!empty($_POST['seleccion'])) {
	$consecutivo2=0001;
	$proveedorPrevio = '';
	foreach($_POST['seleccion'] as $check) { 
    	$TIME       = time();
    	$HOY        = date("Y-m-d H:i:s", $TIME);
		//$HOY        = date("Y-m-d", $TIME);
        list($PROVEEDOR,$CVE_DOC,$TOTAL,$IdPreoco,$Consecutivo,$Doc,$Prod,$Costo,$Cantidad,$Rest,$fechaEntrega) = explode("|", $check);
        //verificaCveArt
        $controller->verificaArticulo($Prod);
		$unimed     = $_SESSION["unimed"];
    	$facconv	= $_SESSION["facconv"];        
    	$partida = array($PROVEEDOR, $CVE_DOC, $TOTAL, $Doc, $TIME, $HOY, $IdPreoco, $Rest, $Prod, $Cantidad, $Costo, $unimed, $facconv);
        $partidas[] = $partida;        	        
    	$consecutivo2=$consecutivo2+1;
    }
	$controller->OrdCompAlt($partidas);
}
}elseif(isset($_POST['preOrdenDeCompra'])){	
	$consecutivo2=0001;
	$proveedorPrevio = '';
	foreach($_POST['seleccion'] as $check) { 
    	$TIME       = time();
    	$HOY        = date("Y-m-d H:i:s", $TIME);
        list($prov,$idpreoc,$ftcart,$costo,$rest, $cantidad, $cotizacion, $descuento) = explode("|", $check);     
    	$partida = array($prov,$idpreoc,$ftcart,$costo,$rest, $cantidad, $cotizacion, $descuento);
        $partidas[] = $partida;        	        
    	$consecutivo2=$consecutivo2+1;
    }
	$controller->preOrdenDeCompra($partidas);
}elseif(isset($_POST['altaunidadf'])){
	$numero = $_POST['numero'];
	$marca = $_POST['marca'];
	$modelo = $_POST['modelo'];
	$placas = $_POST['placas'];
	$operador = $_POST['operador'];
	$controller->altaunidadesdata($numero, $marca, $modelo, $placas, $operador);
}elseif(isset($_POST['asignaruta'])){
	$docu = $_POST['docu'];
	$unidad = $_POST['unidad'];
	$edo = $_POST['edo'];
	$controller->AsignaRuta($docu, $unidad, $edo);	
}elseif(isset($_POST['asignacomposconfact'])){
	$factura = $_POST["factura"]; 
	$compo = $_POST["compo"]; 
	
	for ($i=0;$i<count($factura);$i++){     
		$fact = $factura[$i];    
		} 
	for ($i=0;$i<count($compo);$i++){
		$comp = $compo[$i];
	} 
	$controller->AsignaAFactf($fact, $comp);
}elseif(isset($_POST['FORM_NAME'])) {        
	$documento = $_POST['documento'];
//	$importe = $_POST['importe'];
//	$proveedor = $_POST['proveedor'];
	$claveProveedor = $_POST['claveProveedor'];
//	$fecha = $_POST['fecha'];       
    $controller->realizaPago($documento, $claveProveedor);
}elseif(isset($_POST['formpago'])){
	$cuentaban = $_POST['cuentabanco'];
	$docu = $_POST['docu'];
	$importe = $_POST['importe'];
	$tipop = $_POST['tipopago'];
	$monto = $_POST['monto'];
	$nomprov = $_POST['nomprov'];
	$cveclpv = $_POST['cveprov'];
	$fechadoc = $_POST['fechadoc'];
	//$entregadoa = $_POST['entregadoa'];
	//if($monto !== $importe){
	//	$controller->PagoW();
	//}else{
		$controller->PagoCorrecto($cuentaban, $docu, $tipop, $monto, $nomprov, $cveclpv, $fechadoc);
	//}
}elseif(isset($_POST['formpago_gasto'])){
	$cuentabanco = $_POST['cuentabanco'];
	$documento = $_POST['documento'];
	$importe = $_POST['importe'];
	$tipopago = $_POST['tipopago'];
	$monto = $_POST['monto'];
	$proveedor = $_POST['proveedor'];
	$claveProveedor = $_POST['claveProveedor'];
	$fechadocumento = $_POST['fechadocumento'];
    $controller->PagoGastoCorrecto($cuentabanco, $documento, $tipopago, $monto, $proveedor, $claveProveedor, $fechadocumento);
}elseif(isset($_POST['fomrpago_old'])){
	$docuOLD = $_POST['docuold'];
	$importeOLD = $_POST['importeold'];
	$tipopOLD = $_POST['tipopagoold'];
	$montoOLD = $_POST['montoold'];
	$nomprovOLD = $_POST['nomprovold'];
	$cveclpvOLD = $_POST['cveprovold'];

	$controller->PagoCorrectoOld($docuOLD, $tipopOLD, $montoOLD, $nomprovOLD, $cveclpvOLD);
}elseif(isset($_POST['ped'])){
	$ped = $_POST['ped'];
	$controller->MuestraPedidos($ped);
}elseif(isset($_POST['asignaSecuencia'])){
	$docu = $_POST['doc'];
	$secu = $_POST['secuencia'];
	$unidad = $_POST['uni'];
	$fechai = $_POST['fechai'];
	$fechaf = $_POST['fechaf'];

	$controller->asignaSec($docu, $secu, $unidad, $fechai, $fechaf);
}elseif(isset($_POST['SecUnidad2'])){
	$prove=$_POST['prov'];
	$secuencia=$_POST['secuencia'];
	$uni=$_POST['uni'];
	$fecha=$_POST['fecha'];
	$idu=$_POST['idu'];
	$doco = $_POST['doco'];
	$controller->SecuenciaUnidad($prove, $secuencia, $uni, $fecha, $idu, $doco);
}elseif(isset($_POST['defRuta'])){
	$doc=$_POST['doc'];
	$secuencia=$_POST['secuencia'];
	$uni=$_POST['uni'];
	$tipo=$_POST['tipo'];
	$idu=$_POST['idu'];
	$controller->DefRuta($doc, $secuencia, $uni, $tipo, $idu);
}elseif(isset($_POST['defRutaRep'])){
	$doc=$_POST['doc'];
	$secuencia=$_POST['secuencia'];
	$uni=$_POST['uni'];
	$tipo=$_POST['tipo'];
	$idu=$_POST['idu'];
	$controller->DefRutaRep($doc, $secuencia, $uni, $tipo, $idu);
}elseif(isset($_POST['defRutaForaneo'])){
	$doc=$_POST['doc'];
	$charnodeseados = array("-","/");
	//$uni=$_POST['uni'];
	//$tipo=$_POST['tipo'];
	$idu=$_POST['idu'];

	$guia = $_POST['guia'];
	$fletera = $_POST['fletera'];
	$cpdestino = $_POST['cpdestino'];
	$destino = $_POST['destino'];
	$fechaestimada = str_replace($charnodeseados,'.',$_POST['fechaestimada']);

	$controller->DefRutaForaneo($doc,$idu,$guia,$fletera,$cpdestino,$destino,$fechaestimada);
}elseif(isset($_POST['finalizaRuta'])){
	$doc=$_POST['doc'];
	$secuencia=$_POST['secuencia'];
	$uni=$_POST['uni'];
	$motivo=$_POST['motivo'];
	$idf=$_POST['idf'];
	$controller->FinalizaRuta($idf, $secuencia, $uni, $motivo, $doc);
}elseif(isset($_POST['finalizaReEnRuta'])){
	$doc=$_POST['doc'];
	$idf=$_POST['idu'];
	$motivo=$_POST['motivo'];
	$controller->FinalizaReEnRuta($idf, $motivo, $doc); ///////////
}elseif(isset($_POST['defineHoraInicio'])){
	$documento = $_POST['documento'];
	$controller->defineHoraInicio($documento);
}elseif(isset($_POST['defineHoraFin'])){
	$documento = $_POST['documento'];
	$controller->defineHoraFin($documento);	
}elseif(isset($_POST['imprimeRecepcion'])){
	$doc = $_POST['doc'];
	$controller->imprimeRecepcion($doc);
}elseif(isset($_POST['corregirRuta'])){		//22-03-2016 ICA
	$doc = $_POST['doc'];
	$tipo = $_POST['tipo'];
	$uni = $_POST['uni'];
	$tipoA = $_POST['tipoA'];
	$controller->CorregirRuta($doc, $tipo, $uni, $tipoA);
}elseif(isset($_POST['altaproductos'])){
	$clave = $_POST['clave'];
	$descripcion = $_POST['descripcion'];
	$marca1 = $_POST['marca1'];
	$categoria = $_POST['categoria'];
	$desc1 = $_POST['desc1'];
	$desc2 = $_POST['desc2'];
	$desc3 = $_POST['desc3'];
	$desc4 = $_POST['desc4'];
	$desc5 = $_POST['desc5'];
	$iva = $_POST['impuesto'];
	$costo_total = $_POST['costo_total'];
	$prov1 = explode(":",$_POST['prov1']);
	$clave_prov = $prov1[0];
	$codigo_prov1 = $_POST['codigo_prov1'];
	$costo_prov1 = $_POST['costo_prov1'];
	$prov2 = $_POST['prov2'];
	$codigo_prov2 = $_POST['codigo_prov2'];
	$costo_prov2 = $_POST['costo_prov2'];
	$unidadcompra = $_POST['unidadcompra'];
	$factorcompra= $_POST['factorcompra'];
	$unidadventa = $_POST['unidadventa'];
	$factorventa= $_POST['factorventa'];	
	$controller->AltaProductos($clave,$descripcion,$marca1,$categoria,$desc1,$desc2,$desc3,$desc4,$desc5,$iva,$costo_total,$clave_prov,$codigo_prov1,$costo_prov1,$prov2,$codigo_prov2,$costo_prov2,$unidadcompra,$factorcompra,$unidadventa,$factorventa);
}elseif(isset($_POST['editarproducto'])){ 
	$id = $_POST['id'];
	$clave = $_POST['clave'];
	$descripcion = $_POST['descripcion'];
	$marca1 = $_POST['marca1'];
	$categoria = $_POST['categoria'];
	$desc1 = $_POST['desc1'];
	$desc2 = $_POST['desc2'];
	$desc3 = $_POST['desc3'];
	$desc4 = $_POST['desc4'];
	$desc5 = $_POST['desc5'];
	$iva = $_POST['impuesto'];
	$costo_total = $_POST['costo_total'];
	$prov1 = explode(":",$_POST['prov1']);
	$clave_prov = $prov1[0];
	$codigo_prov1 = $_POST['codigo_prov1'];
	$costo_prov1 = $_POST['costo_prov1'];
	$prov2 = $_POST['prov2'];
	$codigo_prov2 = $_POST['codigo_prov2'];
	$costo_prov2 = $_POST['costo_prov2'];
	$unidadcompra = $_POST['unidadcompra'];
	$factorcompra= $_POST['factorcompra'];
	$unidadventa = $_POST['unidadventa'];
	$factorventa= $_POST['factorventa'];
        $activo = (!empty($_POST['activo'])) ? "S":"N";             //06/06/2016
	$controller->actualizarProducto($id,$clave,$descripcion,$marca1,$categoria,$desc1,$desc2,$desc3,$desc4,$desc5,$iva,$costo_total,$clave_prov,$codigo_prov1,$costo_prov1,$prov2,$codigo_prov2,$costo_prov2,$unidadcompra,$factorcompra,$unidadventa,$factorventa,$activo);
}elseif(isset($_POST['validar'])){
	$docr = $_POST['docr'];
	$doco = $_POST['doco'];
	$controller->ValidaRecepcion($docr, $doco);
}elseif(isset($_POST['ValParOk'])){
	$docr=$_POST['docr'];
	$doco=$_POST['doco'];
	$cantn=$_POST['cantn'];
	$coston=$_POST['coston'];
	$cantorig=$_POST['cantorig'];
	$costoorig=$_POST['costoorig'];
	$idpreoc=$_POST['idpreoc'];
	$idordencompra=$_POST['ordcomp'];
	$par=$_POST['par'];
	$fechadoco=$_POST['fechadoco'];
	$descripcion=$_POST['descripcion'];
	$cveart=$_POST['cveart'];
	$desc1 = $_POST['desc1'];
	$desc2 = $_POST['desc2'];
	$desc3 = $_POST['desc3'];
	$fval = $_POST['fval'];
	$controller->ValRecepOK($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc,$idordencompra,$par, $fechadoco, $descripcion,$cveart, $fval, $desc1, $desc2, $desc3);
}elseif(isset($_POST['ValParNo'])){
	$docr=$_POST['docr'];
	$doco=$_POST['doco'];
	$cantn=$_POST['cantn'];
	$coston=$_POST['coston'];
	$cantorig=$_POST['cantorig'];
	$costoorig=$_POST['costoorig'];
	$idpreoc=$_POST['idpreoc'];
	$controller->ValRecepNo($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc);
}elseif(isset($_POST['ValRecepOK'])){
	$docr=$_POST['docr'];
	$doco=$_POST['doco'];
	$cantn=$_POST['cantn'];
	$coston=$_POST['coston'];
	$cantorig=$_POST['cantorig'];
	$costoorig=$_POST['costoorig'];
	$idpreoc=$_POST['idpreoc'];
	$controller->valrecepok();
}elseif(isset($_GET['term']) && isset($_GET['proveedor'])){
		$buscar = $_GET['term'];
		$nombres = $controller->TraeProveedores($buscar);
		echo json_encode($nombres);
		exit;
}elseif(isset($_GET['term']) && isset($_GET['cliente'])){
		$buscar = $_GET['term'];
		$nombres = $controller->TraeClientes2($buscar);
		echo json_encode($nombres);
		exit;
}elseif(isset($_GET['term']) && isset($_GET['producto'])){
		$buscar = $_GET['term'];
		$nombres = $controller->TraeProductos($buscar);
		echo json_encode($nombres);
		exit;
}elseif(isset($_POST['motivonosuministra'])){
		$id=$_POST['idorden'];
		$motivo=$_POST['motivo'];
		$controller->MotivoNS($id,$motivo);
}elseif(isset($_POST['impSadoRec'])){
		$doco=$_POST['doco'];
		$doc=$_POST['docr'];
		$controller->ImprimirRecepcion($doco);
		//$controller->ImpSaldoRec($doc, $doco);
}elseif(isset ($_POST['buscarArticulo'])){
        $articulo = $_POST['articulo'];
        $descripcion = $_POST['descripcion'];
        $cliente = $_POST['clave'];
        $folio = $_POST['folio'];
        $partida = $_POST['partida'];
        $controller->consultarArticulo($cliente, $folio, $partida, $articulo, $descripcion);
} elseif(isset($_POST['actualizaCotizacionPartida'])){
        $folio = $_POST['cotizacion'];
        $partida = $_POST['partida'];
        $articulo = $_POST['articulo'];
        $precio = $_POST['precio'];
        $descuento = $_POST['descuento'];
        $cantidad = $_POST['cantidad'];        
        $controller->actualizaCotizacion($folio, $partida, $articulo, $precio, $descuento, $cantidad);
} elseif(isset($_POST['buscarCliente'])){
        $clave = '';
        $cliente = '';
        if(isset($_POST['clave'])){
            $clave = $_POST['clave'];
        }
        if(isset($_POST['cliente'])){
            $cliente = $_POST['cliente'];
        }  
        $controller->consultarClientes($clave, $cliente);
} elseif(isset($_POST['seleccionaCliente'])){
        $cliente = $_POST['clave'];
        if(isset($_SESSION['cotizacion_mover_cliente']) && $_SESSION['cotizacion_mover_cliente']==true){
            $folio = $_SESSION["cotizacion_folio"];
            $_SESSION['cotizacion_mover_cliente'] = false;
            $_SESSION["cotizacion_folio"] = '';
            $controller->moverClienteCotizacion($folio, $cliente);
        } else {
            if(isset($_POST['identificadorDocumento'])){
                $identificadorDocumento = $_POST['identificadorDocumento'];
            }
            $controller->insertaCotizacion($cliente, $identificadorDocumento);
        }
} elseif(isset($_POST['generaNuevaCotizacion'])){
        $controller->consultarClientes('', '');
} elseif(isset($_POST['actualizaPedido'])){
        $folio = $_POST['folio'];
        $pedido = $_POST['pedido'];
        $controller->actualizaPedidoCotizacion($folio, $pedido);
}elseif(isset($_POST['preparamaterial'])){
	    $docf=$_POST['doc'];
	    $controller->VerCajas($docf);
}elseif(isset($_POST['prepararmateriales'])){
	    $docf=$_POST['clavefact'];
	    $idcaja=$_POST['idcaja'];
	    $controller->PreparaMaterial($docf, $idcaja);
}elseif(isset($_POST['nuevacaja'])){
	$facturanuevacaja = $_POST['factucajanueva'];
	$controller->CrearNuevaCaja($facturanuevacaja);
}elseif(isset($_POST['modificapreorden'])){
	$id = $_POST['id'];
	$controller->ModificaPreOrden($id);	
}elseif(isset($_POST['formmodificapreorden'])){
	$idPreorden = $_POST['idpreorden'];
	$claveNombreProd = explode(" : ",$_POST['producto']);
	$claveproducto = $claveNombreProd[0];
	$nombreproducto = $claveNombreProd[1];
	$costo = $_POST['costo'];
	$precio = $_POST['precio'];
	$marca = $_POST['marca'];
	$claveNombreProv = explode(" : ",$_POST['proveedor']);
	$claveproveedor = $claveNombreProv[0];
	$nombreproveedor = $claveNombreProv[1];
	$cotizacion = $_POST['cotizacion'];
	$partida = $_POST['partida'];
	$motivo = $_POST['motivo'];
	$controller->AlteraPedidoCotizacion($idPreorden,$claveproducto,$nombreproducto,$costo,$precio,$marca,$claveproveedor,$nombreproveedor,$cotizacion,$partida,$motivo);
}elseif(isset($_POST['formcancelapreorden'])){
	$id = $_POST['id'];
	$controller->FormCancelaPreorden($id);
}elseif(isset($_POST['cancelapreorden'])){
	$id = $_POST['idpreorden'];
	$cotizacion = $_POST['cotizacion'];
	$partida = $_POST['partida'];
	$motivo = $_POST['motivo'];
	
	$controller->CancelaPreorden($id,$cotizacion,$partida,$motivo);
}elseif(isset($_POST['AsignaEmpaque'])){
		$docf=$_POST['docf'];
		$par=$_POST['par'];
		$canto=$_POST['canto'];
		$idpreoc=$_POST['idpreoc'];
		$cantn=$_POST['cantn'];
		$empaque=$_POST['empaque'];
		$art=$_POST['art'];
		$desc=$_POST['desc'];
		$idcaja=$_POST['idcaja'];
        $tipopaq = $_POST['tipopaq'];       //23062016
		$controller->AsignaEmpaque($docf, $par, $canto, $idpreoc, $cantn, $empaque, $art, $desc, $idcaja, $tipopaq);
}elseif(isset($_POST['embalaje'])){
		$docf=$_POST['docf'];
		$controller->embalaje($docf);
}elseif(isset($_POST['impcontenidocaja'])){
                $docf = $_POST['docf'];
                $caja = $_POST['caja'];
                $controller->ImpContenidoCaja($docf,$caja);
}elseif(isset($_POST['asignaembalaje'])){       //230602016
		$docf=$_POST['docf'];
		$paquete1=$_POST['paquete1'];
		$paquete2=$_POST['paquete2'];
		$tipo=$_POST['tipo'];
		$peso=$_POST['peso'];
		$alto=$_POST['alto'];
		$largo=$_POST['largo'];
		$ancho=$_POST['ancho'];
		$pesovol=$_POST['pesovol'];
		$idc=$_POST['idc'];
		$idemp=$_POST['idemp'];
		$controller->asignaembalaje($docf,$paquete1, $paquete2, $tipo, $peso, $alto, $largo, $ancho, $pesovol, $idc, $idemp);
}elseif(isset($_POST['buscaoperadores']) || isset($_GET['formro'])){
	isset($_POST['buscaoperadores']) ? $buscar = $_POST['buscar'] : $buscar = '@@@@';
	$controller->VerRegistroOperadores($buscar);
}elseif(isset($_POST['CancelarRecepcion'])){
	$orden = $_POST['orden'];
	$recepcion = $_POST['recepcion'];
	$controller->FormCR($orden, $recepcion);
}elseif(isset($_POST['CancelRecepQuery'])){
	$orden = $_POST['orden'];
	$recepcion = $_POST['recepcion'];
	$controller->CancelarRecepcion($orden, $recepcion);
}elseif(isset($_POST['cerrarcaja'])){
	$idcaja=$_POST['idcaja'];
	$docf=$_POST['docf'];
	$controller->cerrarCaja($idcaja, $docf);
}elseif(isset($_POST['unidadentrega'])){
	$idcaja=$_POST['idcaja'];
	$docf=$_POST['docu'];
	$estado=$_POST['edo'];
	$unidad=$_POST['unidad'];
	$controller->UnidadEntrega($idcaja, $docf, $estado, $unidad);
}elseif(isset($_POST['SecUnidadEntrega'])){
	$clie=$_POST['clie'];
	$unidad=$_POST['uni'];
	$idu=$_POST['idu'];
	$secuencia=$_POST['secuencia'];
	$docf=$_POST['docf'];
	$idcaja=$_POST['idcaja'];
	$controller->SecUnidadEntrega($idu, $clie, $unidad, $secuencia, $docf, $idcaja);
}elseif(isset($_POST['AvanzarOrden'])){					//orden AA
	$idorden = $_POST['orden'];
	$controller->FormAvanzarOrden($idorden);
}elseif(isset($_POST['avanzaroc'])){					//orden AA
	$idorden = $_POST['idorden'];
	$idpreoc = $_POST['idpreoc'];
	$partida = $_POST['partida'];
	$controller->AvanzarOC($idorden, $idpreoc, $partida);
}elseif(isset($_POST['VerProdRFC2'])){
	$rfc=$_POST['VerProdRFC2'];
	$controller->VerProdRFC2($rfc);
}elseif(isset($_POST['ImprimirSecuencia'])){
    $unidad = $_POST['unidad'];
    $controller->ImprimirSecuencia($unidad);
}elseif(isset($_POST['ImprimirSecuenciaEntrega'])){
    $unidad = $_POST['unidad'];
    $controller->ImprimirSecuenciaEnt($unidad);
}elseif(isset($_POST['ImpResultadosXDiaXunidad'])){
    $unidad = $_POST['unidad'];
    $controller->ImpResultadosXdiaXuni($unidad);
}elseif(isset($_POST['docs'])){
	$doc =$_POST['docu'];
	if(isset($_POST['docf'])){
		$docf =$_POST['docf'];	
	}else{
		$docf = '';
	}
	if(isset($_POST['docr'])){
		$docr = $_POST['docr'];	
	}else{
		$docr='';
	}
	$controller->RecibeDocs($doc, $docf, $docr);
}elseif(isset($_POST['actDocs'])){
	$doc =$_POST['doc'];
	$idr=$_POST['idu'];
	$docs=$_POST['docslog'];
	$controller->RecogeDocs($doc,$idr, $docs);
}elseif (isset($_POST['docsR'])) {
	$doc =$_POST['docu'];
	if(isset($_POST['docf'])){
		$docf =$_POST['docf'];	
	}else{
		$docf = '';
	}
	if(isset($_POST['docr'])){
		$docr = $_POST['docr'];	
	}else{
		$docr='';
	}
	$controller->RecibeDocsReparto($doc, $docf, $docr);
}elseif(isset($_POST['CerrarRuta'])){
	$doc=$_POST['doc'];
	$idr=$_POST['idu'];
	$tipo=$_POST['tipo'];
	$idc =$_POST['idc'];
	$controller->CerrarRuta($doc, $idr, $tipo, $idc);
}elseif(isset($_POST['CerrarRutaRep'])){
	$doc=$_POST['doc'];
	$idr=$_POST['idu'];
	$tipo=$_POST['tipo'];
	$idc =$_POST['idc'];
	$controller->CerrarRutaRep($doc, $idr, $tipo, $idc);
}elseif(isset($_POST['cerrargenrec'])){
    $docs = $_POST['documentos'];
    $documentos = unserialize($docs);
    $controller->CerrarRec($documentos);
}elseif(isset($_POST['ImpRecepVal'])){
    $orden = $_POST['docr'];
    $controller->ImprimirRecepcion($orden);
}elseif(isset($_POST['guardanuevacuenta'])){
    $concepto = $_POST['concepto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $cc = $_POST['centrocostos'];
    $cuenta = $_POST['cuentacontable'];
    $gasto = $_POST['gasto'];
    $presupuesto = $_POST['presupuesto'];
    @$retieneiva = $_POST['retieneiva'];
    @$retieneisr = $_POST['retieneisr'];
    @$retieneflete = $_POST['retieneflete'];
    
    $controller->GuardarNuevaCuenta($concepto, $descripcion, $iva, $cc, $cuenta, $gasto, $presupuesto, $retieneiva, $retieneisr, $retieneflete);
}elseif(isset($_POST['guardacambioscuenta'])){
	/*Agregar nuevo campo GDELEON*/
	$prov = $_POST['prov'];
    $concepto = $_POST['concepto'];
    $descripcion = $_POST['descripcion'];
    $iva = $_POST['iva'];
    $cc = $_POST['centrocostos'];
    $cuenta = $_POST['cuentacontable'];
    $gasto = $_POST['gasto'];
    $presupuesto = $_POST['presupuesto'];
    $id = $_POST['id'];
    $retieneiva = (!empty($_POST['retieneiva'])) ? $_POST['retieneiva'] : "0";
    $retieneisr = (!empty($_POST['retieneisr'])) ? $_POST['retieneisr'] : "0";
    $retieneflete = (!empty($_POST['retieneflete'])) ? $_POST['retieneflete'] : "0";
    $activo = (!empty($_POST['activo'])) ? $_POST['activo'] : "N";
    $cveprov = $_POST['proveedor'];
    
    $controller->GuardarCambiosCuenta($concepto, $descripcion, $iva, $cc, $cuenta, $gasto, $presupuesto, $id, $retieneiva, $retieneisr, $retieneflete, $activo, $cveprov);
}elseif(isset($_POST['editcuentagasto'])){
    $id = $_POST['id'];
    $controller->EditCuentaGasto($id);
}elseif(isset($_POST['delcuentagasto'])){
    $id = $_POST['id'];
    $controller->DelCuentaGasto($id);
}elseif(isset($_POST['liberaPendientes'])){
	$doco = $_POST['doco'];
	$id_preoc = $_POST['id_preoc'];
	$pxr =$_POST['pxr'];
	echo 'Pendiente:'.$pxr;
	$controller->liberaPendientes($doco, $id_preoc, $pxr); 
}elseif(isset($_POST['reEnrutar'])){
	$doco = $_POST['doco'];
	$id_preoc = $_POST['id_preoc'];
	$pxr =$_POST['pxr'];
	$controller->reEnrutar($doco, $id_preoc, $pxr);
}elseif(isset($_POST['guardanuevogasto'])){                ##### gastos
    $montoGasto = $_POST['monto'];
    $presupuesto = str_replace(",", "", $_POST['presupuesto']);
    $concepto = $_POST['concepto'];
    $proveedor = $_POST['proveedor'];
    $referencia = $_POST['referencia'];
    $autorizacion = ($montoGasto>$presupuesto);    
    $tipopago = $_POST['tipopago'];    
    $movpar = $_POST['movpar'];
    $numpar = $_POST['numpar'];
    $usuario = $_POST['usuariogastos'];
    $clasificacion = $_POST['clasificacion'];    
    $charnodeseados = array("-","/");
    $fechadoc = str_replace($charnodeseados,".",$_POST['fechadoc']);
    $fechaven = str_replace($charnodeseados,".",$_POST['fechaven']);    
    $controller->GuardarNuevoGasto($concepto,$proveedor,$referencia,$autorizacion,$presupuesto,$tipopago,$montoGasto,$movpar,$numpar,$usuario,$fechadoc,$fechaven,$clasificacion);   
}elseif(isset($_POST['editclasificaciongasto'])){
    $id = $_POST['id'];
    $controller->EditClaGasto($id);
}elseif(isset($_POST['guardacambiosclasifgasto'])){
    $id = $_POST['id'];
    $clasif = $_POST['clasificacion'];
    $descripcion = $_POST['descripcion'];
    $activo = (!empty($_POST['activo']))? $_POST['activo'] : "N";
            
    $controller->GuardaCambiosClasG($id,$clasif,$descripcion,$activo);
    
}elseif(isset($_POST['nuevaclasifgasto'])){
    $clasif = $_POST['clasificacion'];
    $descripcion = $_POST['descripcion'];
            
    $controller->GuardaNuevaClaGasto($clasif,$descripcion);

}elseif(isset($_POST['guardacr'])){
	$cr = $_POST['contra'];
	$idc = $_POST['idcaja'];
	$docf = $_POST['docf'];
	$controller->insContra($cr, $idc, $docf);
}elseif(isset($_POST['recDocFact'])){
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$idcaja = $_POST['idcaja'];
	$tipo = $_POST['tipo'];
	$controller->recDocFact($docf, $docp, $idcaja, $tipo);
}elseif(isset($_POST['recDocFactNC'])){
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$idcaja = $_POST['idcaja'];
	$tipo = $_POST['tipo'];
	$controller->recDocFactNC($docf, $docp, $idcaja, $tipo);
}elseif(isset($_POST['avanzaCobranza'])){
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$idcaja = $_POST['idcaja'];
	$tipo = $_POST['tipo'];
	$nstatus=$_POST['nstatus'];
	$controller->avanzaCobranza($docf, $docp, $idcaja, $tipo, $nstatus);
}elseif(isset($_POST['impCompFact'])){      //20062016
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$idcaja = $_POST['idcaja'];
	$tipo = $_POST['tipo'];
    $claveCli = $_POST['clavecli'];
	$controller->impCompFact($docf, $docp, $idcaja, $tipo,$claveCli);
}elseif(isset($_POST['delclasificaciongasto'])){
    $id = $_POST['id'];
    $controller->DelClaGasto($id);
}elseif(isset($_POST['recmercancia'])){
	$id = $_POST['idcaja'];
	$docf = $_POST['docf'];
	$tipo = $_POST['tipo'];
	if ($tipo == 'NC'){
	$controller->recmercancianc($id,$docf);
	}else{
	$controller->recmercancia($id,$docf);
	}
}elseif(isset($_POST['recibirCaja'])){
	$id = $_POST['id'];
	$docf = $_POST['docf'];
	$idc = $_POST['idc'];
	$controller->recibirCaja($id, $docf, $idc);
}elseif(isset($_POST['recibirCajaNC'])){
	$id = $_POST['id'];
	$docf = $_POST['docf'];
	$idc = $_POST['idc'];
	$idpreoc =$_POST['idpreoc'];
	$cantr = $_POST['cantr'];
	$motivo = $_POST['motivoDev'];
	$controller->recibirCajaNC($id, $docf, $idc, $idpreoc, $cantr, $motivo);
}elseif(isset($_POST['impRecMercancia'])){
	$id=$_POST['idcaja'];
	$docf=$_POST['docf'];
	$docr=$_POST['docr'];
	$fact = $_POST['fact'];
	$controller->impRecMercancia($id, $docf,$docr,$fact);
}elseif(isset($_POST['guardaNuevoDocumentoC'])){        //14062016
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $controller->GuardaNuevoDocC($nombre, $descripcion);
}elseif(isset($_POST['editadocumentoC'])){
    $id = $_POST['id'];
    $controller->FormEditaDocumentoC($id);
}elseif(isset($_POST['guardaCambiosDocumentoC'])){
    $activo = (empty($_POST['activo'])) ? "N" : $_POST['activo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'];
    $controller->EditaDocumentoC($activo,$nombre,$descripcion,$id);
}elseif(isset($_POST['AgregarDocumentoACliente'])){
    $clave = $_POST['clave_cliente'];
    $controller->formNuevoDocCliente($clave);
}elseif(isset($_POST['asignaDocumentoC'])){
    $cliente = $_POST['cliente'];
    $requerido = $_POST['requerido'];
    $copias = $_POST['copias'];
    $documento = $_POST['documento'];
    $controller->asignaNuevoDocCliente($cliente,$requerido,$copias,$documento);
}elseif(isset($_POST['contraReciboFact'])){     //22062016
    $contrarecibo = $_POST['contraRecibo'];
    $idcaja = $_POST['idcaja'];
    $controller->guardaContraRecibo($contrarecibo,$idcaja);
}elseif(isset($_POST['reenviarcaja'])){
	$factura = $_POST['factura'];
	$caja = $_POST['caja'];
	$controller->ReenviarCaja($factura,$caja);
}elseif(isset($_POST['datosCarteraCliente'])){      //24062016
    $idCliente = $_POST['idcliente'];
    $controller->formDataCobranzaC($idCliente);
}elseif(isset($_POST['salvarDatoCobranza'])){   //28062016
    $cliente = $_POST['cliente'];
    $carteraCob = $_POST['carteracobranza'];
    $carteraRev = $_POST['carterarevision'];
    for($i = 1; $i <= 7; $i++){
        if(count($_POST[('rev'.$i)])>0){
            $diasRevision[] = $_POST[('rev'.$i)];
        }
    }
    for($c = 1; $c <= 7; $c++){
        if(count($_POST[('pag'.$c)])>0){
            $diasPago[] = $_POST[('pag'.$c)];
        }
    }
    $dosPasos = $_POST['dospasos'];
    $plazo = $_POST['plazo'];
    $addenda = empty($_POST['addenda']) ? "N":"S";
    $portal = $_POST['portal'];
    $usuario = $_POST['add_usuario'];
    $contrasena = $_POST['contrasena'];
    $observaciones = $_POST['observaciones'];
    $envio = $_POST['envio'];
    $cp = $_POST['cp'];
    $maps = $_POST['maps'];
    $tipo = $_POST['tipo'];
    $ln = $_POST['lincred'];
    $pc = $_POST['portalcob'];
    $bancoDeposito = $_POST['bancoDeposito'];
    $bancoOrigen = $_POST['bancoOrigen'];
    $referEdo = $_POST['referEdo'];
    $metodoPago = $_POST['metodoPago'];
    $controller->salvaDatosCob($cliente,$carteraCob,$carteraRev,$diasRevision,$diasPago,$dosPasos,$plazo,$addenda,$portal,$usuario,$contrasena,$observaciones,$envio,$cp,$maps,$tipo,$ln,$pc, $bancoDeposito, $bancoOrigen, $referEdo, $metodoPago);
}elseif(isset($_POST['salvaCambiosDatoCobranza'])){     //28062016
    $cliente = $_POST['cliente'];
    $carteraCob = $_POST['carteracobranza'];
    $carteraRev = $_POST['carterarevision'];
    for($i = 1; $i <= 7; $i++){
        if(count($_POST[('rev'.$i)])>0){
            $diasRevision[] = $_POST[('rev'.$i)];
        }
    }
    for($c = 1; $c <= 7; $c++){
        if(count($_POST[('pag'.$c)])>0){
            $diasPago[] = $_POST[('pag'.$c)];
        }
    }
    $dosPasos = $_POST['dospasos'];
    $plazo = $_POST['plazo'];
    $addenda = empty($_POST['addenda']) ? "N":"S";
    $portal = $_POST['portal'];
    $usuario = $_POST['add_usuario'];
    $contrasena = $_POST['contrasena'];
    $observaciones = $_POST['observaciones'];
    $envio = $_POST['envio'];
    $cp = $_POST['cp'];
    $maps = $_POST['maps'];
    $tipo = $_POST['tipo'];
    $ln = $_POST['lincred'];
    $pc = $_POST['portalcob'];
    $bancoDeposito = $_POST['bancoDeposito'];
    $bancoOrigen = $_POST['bancoOrigen'];
    $referEdo = $_POST['referEdo'];
    $metodoPago = $_POST['metodoPago'];
    if(empty($_POST['cob'])){
    	$cob = '';
    }
    //var_dump($cob);
    //break;
    $controller->salvaCambiosDatosCob($cliente,$carteraCob,$carteraRev,$diasRevision,$diasPago,$dosPasos,$plazo,$addenda,$portal,$usuario,$contrasena,$observaciones,$envio,$cp,$maps,$tipo,$ln,$pc, $bancoDeposito, $bancoOrigen, $referEdo, $metodoPago);  
}elseif(isset($_POST['generarCierreEnt'])){ //27062016
    $controller->generarCierreEnt();
}elseif(isset($_POST['imprimeCierre'])){
	
	$idu = $_POST['idu'];
	$controller->imprimeCierre($idu);

}elseif(isset($_POST['salvaContrarecibo'])){    //3006
    $caja = $_POST['caja'];
    $cr = $_POST['cr'];
    $factura = $_POST['factura'];
    $remision = $_POST['remision'];
    $contraRecibo = $_POST['contraRecibo'];
    $status=$_POST['avanzarevision'];
    $controller->salvarContraRecibo($caja,$cr,$contraRecibo,$factura,$remision, $status);
}elseif(isset($_POST['imprimeContrarecibo'])){  //3006
     $caja = $_POST['caja'];
    $factura = $_POST['factura'];
    $remision = $_POST['remision'];
    $cr = $_POST['cr'];
    $controller->emitirContraRecibo($caja,$factura,$remision,$cr);
}elseif(isset($_POST['RechazarPedido'])){
	$docp=$_POST['docp'];
	$motivo=$_POST['motivoRechazo'];
	$controller->RechazarPedido($docp, $motivo);
}elseif(isset($_POST['liberarpedido'])){
	$pedido=$_POST['docp'];
	$controller->LiberaPedido($pedido);
}elseif(isset($_POST['salvarMotivoSinCR'])){        //06072016
    $motivo = $_POST['motivo'];
    $factura = $_POST['factura'];
    $remision = $_POST['remision'];
    $cr = $_POST['cr'];
    $controller->salvarMotivoSinCR($motivo,$factura,$remision,$cr);
}elseif(isset($_POST['GenerarCierreCarteraRevision'])){ //07072016
    $cr = $_POST['cr'];
    $controller->emitirCierreCR($cr);
}elseif (isset($_POST['info_foraneo'])){
	$caja=$_POST['caja'];
	$doccaja = $_POST['doccaja'];
	$guia=$_POST['guia'];
	$fletera=$_POST['fletera'];
	$controller->info_foraneo($caja, $doccaja, $guia, $fletera);
}elseif(isset($_POST['asociarFactura'])){
	$caja=$_POST['idcaja'];
	$docp=$_POST['docp'];
	$factura=$_POST['factura'];
	$controller->asociarFactura($caja, $docp, $factura);
}elseif(isset($_POST['asociarNC'])){
	$caja=$_POST['idcaja'];
	$docp=$_POST['docp'];
	$nc=$_POST['nc'];
	$controller->asociarNC($caja, $docp, $nc);
}elseif(isset($_POST['avanzarDeslinde'])){
	$caja = $_POST['idcaja'];
	$pedido = $_POST['docp'];
	$motivo = $_POST['motivodeslinde'];
	$controller->avanzaDeslinde($caja,$pedido,$motivo);
}elseif(isset($_POST['guardarAcuse'])){
	$caja = $_POST['idcaja'];
	$pedido = $_POST['docp'];
	$guia = $_POST['guia'];
	$fletera = $_POST['fletera'];
	$controller->GuardaAcuse($caja,$pedido,$guia,$fletera);
}elseif(isset($_POST['imprmirfacturasnc'])){
	$controller->imprimirFacturasNC();
}elseif(isset($_POST['imprmirfacturasdeslinde'])){
	$controller->imprimirFacturasDeslinde();
}elseif(isset($_POST['imprmirfacturasacuse'])){
	$controller->imprimirFacturasAcuse();
}elseif(isset($_POST['imprmirFacturasRemision'])){
	$controller->imprimirFacturasRemision();
}elseif(isset($_POST['DetalleCliente'])){
	if(isset($_POST['cliente'])){
		$cliente = $_POST['cliente'];
	}else{
		$cliente = $_POST['cveclie'];
	}
    $controller->SaldosxDocumento($cliente);
}elseif(isset($_POST['deslindearevision'])){
	$caja = $_POST['caja'];
	$docf = $_POST['factura'];
	$docr = $_POST['remision'];
	$sol = $_POST['sol'];
	$cr = $_POST['cr'];
	$controller->deslindearevision($caja, $docf, $docr, $sol, $cr);
}elseif(isset($_POST['deslindeConDosPasos'])){      //05082016
        $caja = $_POST['caja'];
        $cr = $_POST['cr'];
        $controller->DeslindeConDosPasos($caja,$cr);
}elseif(isset($_POST['deslindeSinDosPasos'])){      //05082016
        $cr = $_POST['cr'];
        $caja = $_POST['caja'];
        $numcr = $_POST['numcr'];
        $controller->DeslindeSinDosPasos($caja,$cr, $numcr);
}elseif(isset($_POST['salvaMotivoDeslindedp'])){    //05082016
    $cr = $_POST['cr'];
    $caja = $_POST['caja'];
    $motivo = $_POST['motivodelinde'];
    $controller->salvaMotivoDeslindeDP($caja,$motivo,$cr);
}elseif(isset($_POST['salvaMotivoDeslindeNodp'])){  //05082016
    $cr = $_POST['cr'];
    $caja = $_POST['caja'];
    $motivo = $_POST['motivodelinde'];
    $controller->salvaMotivoDeslindeNoDP($caja,$motivo,$cr);
}elseif(isset($_POST['avanzarCajaCobranza'])){
    $caja = $_POST['caja'];
    $revdp = $_POST['revdp'];
    $numcr = $_POST['numcr'];
    $controller->avanzarCajaCobranza($caja,$revdp, $numcr);
}elseif(isset($_POST['CajaCobranza'])){
	$caja=$_POST['caja'];
	$revdp = $_POST['revdp'];
    $numcr = $_POST['numcr'];
    $cr = $_POST['cr'];
    $controller->CajaCobranza($caja, $revdp, $numcr, $cr);
}elseif(isset($_POST['conceptoGasto'])){
	//Modificado por GDELEON 3/Ago/2016
	//echo "simona la mona";
	$concept = $_POST['conceptoGasto'];
	$presupGasto = $controller->TraePresupuestoConceptGasto($concept);
	if($presupGasto){
		echo $presupGasto;
	}
	exit;
}elseif(isset($_POST['DesaAdu'])){
	$caja=$_POST['idcaja'];
	$solucion=$_POST['soldesaduana'];
	$controller->DesaAdu($caja, $solucion);
}elseif(isset($_POST['MuestraCaja'])){
	$docp=$_POST['MuestraCaja'];
	$controller->MuestraCaja($docp);
}elseif(isset($_POST['recDocCob'])){
	$idc=$_POST['idcaja'];
	$docf =$_POST['docf'];
	$controller->recDocCob($idc, $docf);
}elseif(isset($_POST['desDocCob'])){
	$idc=$_POST['idcaja'];
	$controller->desDocCob($idc);
}elseif(isset($_POST['ImprimirDevolucion'])){
	$idc=$_POST['idc'];
	$docf=$_POST['docf'];
	$response=$controller->ImprimirDevolucion($idc, $docf);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['generaDevolucion'])) {
	$idc=$_POST['idc'];
	$docf = $_POST['docf'];
	$response=$controller->generaDevolucion($idc, $docf);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['generaPDFdev'])) {
	$idc=$_POST['idc'];
	$docf=$_POST['docf'];
	$controller->ImprimirDevolucion($idc, $docf);
	return;
	exit();
}elseif (isset($_POST['avisoDevMail'])) {
	$idc=$_POST['idc'];
	$docf=$_POST['docf'];
	$dev = $_POST['dev'];
	$controller->avisoDevMail($idc, $docf, $dev);
}elseif (isset($_POST['recibirMercancia'])) {
	$controller->recibirMercancia2();
}
elseif(isset($_POST['cambiarStatus'])){
	$idcaja = $_POST['idc'];
	$docp =$_POST['docp'];
	$secuencia = $_POST['secuencia'];
	$unidad =$_POST['uni'];
	$idu = $_POST['idu'];
	$ntipo = $_POST['tipo'];
	$tipoold =$_POST['tipoold'];
	$controller->cambiarStatus($idcaja, $docp, $secuencia, $unidad, $idu, $ntipo, $tipoold);
}elseif(isset($_POST['DesNC'])){
	$idc= $_POST['idcaja'];
	$controller->DesNC($idc);
}elseif(isset($_POST['entaduana'])){
	$idc = $_POST['idc'];
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$controller->entaduana($idc, $docf, $docp);
}elseif(isset($_POST['recbodega'])){
	$idc = $_POST['idc'];
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$controller->recbodega($idc, $docf, $docp);		
}elseif(isset($_POST['reclogistica'])){
	$idc = $_POST['idc'];
	$docf = $_POST['docf'];
	$docp = $_POST['docp'];
	$controller->reclogistica($idc, $docf, $docp);		
}elseif(isset($_POST['impLoteFact'])){
	$controller->impLoteFact();
}elseif(isset($_POST['docfact'])){
	$docfact = $_POST['docfact'];
	$idc = $_POST['idcaja'];
	$controller->docfact($docfact, $idc);
}elseif(isset($_POST['FORM_NAME_GASTO'])){
    $identificador = $_POST['documento'];
    $fecha = $_POST['fecha'];
    $controller->pagoGasto($identificador);
}elseif(isset($_POST['CancelaFactura'])){
	$docp=$_POST['factura'];
	$controller->CancelaFactura($docp);
}elseif (isset($_POST['CancelaF'])){
	$docf=$_POST['factura'];
	$idc=$_POST['idc'];
	$controller->CancelarF($docf, $idc);
}elseif (isset($_POST['solAutoUB'])){
	$docc=$_POST['cotizacion'];
	$par=$_POST['partida'];
	$controller->solAutoUB($docc,$par);
}elseif (isset($_POST['AutorizarUB'])) {
	$docc=$_POST['cotizacion'];
	$par =$_POST['partida'];
	$controller->AutorizarUB($docc, $par);
}elseif (isset($_POST['RechazoUB'])){
	$docc=$_POST['cotizacion'];
	$par =$_POST['partida'];
	$controller->RechazoUB($docc, $par);
}elseif(isset($_POST['FORM_ACTION_XDICTAMINAR'])){
    $identificador = $_POST['documento'];
    $tipo = $_POST['tipo'];
    $controller->xAutorizar($tipo, $identificador);
}elseif(isset($_POST['FORM_ACTION_DICTAMEN'])){
    $identificador = $_POST['documento'];
    $tipo = $_POST['tipo'];
    $dictamen = $_POST['dictamen'];
    $comentarios = $_POST['comentarios'];
    $controller->xAutorizarDictamen($tipo, $identificador, $dictamen, $comentarios);                
}elseif(isset($_POST['FORM_ACTION_IMPRIMIR'])){
	$identificador = $_POST['identificador'];
	$tipo = $_POST['tipo'];
	$controller->impComprobantePago($identificador, $tipo);
}elseif(isset($_POST['impCheque'])){
	$cheque = $_POST['cheque'];
	$banco = $_POST['banco'];
	$fecha = $_POST['fechapost'];
	$folio = $_POST['folion'];
	$banco = trim(substr($banco, 0 , 8));
	if($banco =='Bancomer'){
		$controller->ImpChBancomer($cheque,$fecha, $folio);	
	}elseif($banco == 'Banamex'){
		$controller->ImpChBanamex($cheque,$fecha,$folio);	
	}elseif(empty($banco)){
		$controller->ImpSinBanco($cheque, $fecha, $folio);
		}
}elseif(isset($_POST['cancelaPedido'])) {
	$pedido=$_POST['pedido'];
	$motivo =$_POST['razon'];
	$controller->cancelaPedido($pedido, $motivo);
}elseif(isset($_POST['cargarPago'])){
	$cliente=$_POST['cliente'];
	$controller->cargaPago($cliente);
} elseif(isset ($_POST['FORM_ACTION_EDOCTA_DETALLE'])){
  $identificador = $_POST['identificador'];
  $controller->estadoCuentaDetalle($identificador);
} elseif(isset ($_POST['FORM_ACTION_EDOCTA_REGISTRO'])){
    $identificador = $_POST['identificador'];
    $banco = $_POST['banco'];
    $cuenta = $_POST['numero_cuenta'];
    $dia = date("Y-m-d");
    $controller->estadoCuentaRegistro($identificador, $banco, $cuenta, $dia);  
 } elseif(isset ($_POST['FORM_ACTION_EDOCTA_REGISTRAR'])){
     $identificador = $_POST['idcuenta'];
    $banco = $_POST['banco'];
    $cuenta = $_POST['numero_cuenta'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $controller->estadoCuentaRegistrar($identificador, $banco, $cuenta, $fecha, $descripcion, $monto);    
}elseif(isset($_POST['FORM_ACTION_PAGOS_RECIBIR'])){
    $identificador = $_POST['identificador'];
    $tipo = $_POST['tipo'];
    $fecha=$_POST['fecha'];
    $banco=$_POST['banco'];
    $monto=$_POST['monto'];
    //echo 'Este es el monto en el Index: '.$monto;
    $controller->pagosRecepcion($tipo, $identificador, $fecha, $banco, $monto);                
 }elseif(isset($_POST['FORM_ACTION_PAGOS_CONCILIAR'])){
    $identificador = $_POST['identificador'];
    $tipo = $_POST['tipo'];
    $controller->pagoAConciliar($tipo, $identificador);                    
 }elseif(isset($_POST['FORM_ACTION_PAGOS_CONCILIA'])){
    $identificador = $_POST['identificador'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $controller->pagoConciliar($tipo, $identificador, $fecha);
}elseif(isset($_POST['guardaPago'])){
	$cliente = $_POST['cliente'];
	$monto = $_POST['monto'];
	$fechaA=$_POST['fechaA'];
	$fechaR=$_POST['fechaR'];
	$banco=$_POST['banco'];
	$controller->guardaPago($cliente, $monto, $fechaA, $fechaR, $banco);
}elseif(isset($_POST['aplicarPago'])){
	$cliente = $_POST['cliente'];
	$controller->aplicarPago($cliente);
}elseif (isset($_POST['ingresarPago'])){
	$banco=$_POST['banco'];
	$monto=$_POST['monto'];
	$fecha=$_POST['fecha'];
	$ref=$_POST['ref1'];
	$banco2=$_POST['banco2'];
	$cuenta=$_POST['cuenta'];
	$controller->ingresarPago($banco, $monto, $fecha, $ref, $banco2, $cuenta);
}elseif (isset($_POST['capturaPagosConta'])){
	$banco = $_POST['banco'];
	$cuenta = $_POST['numero_cuenta'];
	$controller->capturaPagosConta($banco, $cuenta);
}elseif (isset($_POST['ESTADO_DE_CUENTA'])){
	$banco = $_POST['banco'];
	$cuenta = $_POST['numero_cuenta'];
	$controller->estado_de_cuenta($banco, $cuenta);
}elseif (isset($_POST['ESTADO_DE_CUENTA_DOCS'])) {
	$banco = $_POST['banco'];
	$cuenta = $_POST['numero_cuenta'];
	$controller->estado_de_cuenta_docs($banco, $cuenta);
}elseif(isset($_POST['FiltrarEdoCta_v3'])){
	$mes=$_POST['mes'];
	$banco=$_POST['banco'];
	$cuenta=$_POST['cuenta'];
	$anio=$_POST['anio'];
	if(isset($_GET['nvaFechComp'])){
        		$nvaFechComp=$_GET['nvaFechComp'];
        	}else{
        		$nvaFechComp = '01.01.2016';
        	}
	$controller->estado_de_cuenta_mes_docs($mes,$banco,$cuenta, $anio, $nvaFechComp);
}elseif(isset($_POST['FiltrarEdoCta'])){
	$mes=$_POST['mes'];
	$banco=$_POST['banco'];
	$cuenta=$_POST['cuenta'];
	$anio=$_POST['anio'];
	if(isset($_GET['nvaFechComp'])){
        		$nvaFechComp=$_GET['nvaFechComp'];
        	}else{
        		$nvaFechComp = '01.01.2016';
        	}
	$controller->estado_de_cuenta_mes($mes,$banco,$cuenta, $anio, $nvaFechComp);
}elseif (isset($_POST['traeFactura'])) {
	$docf =$_POST['docf'];
	$controller->traeFactura($docf);
}elseif(isset($_POST['cambiarFactura'])){
	$docf1 = $_POST['docf1'];
	$tipo = $_POST['tipo'];
	$controller->cambiarFactura($docf1, $tipo);
}elseif(isset($_POST['cajaxembalar'])){
	$docp=$_POST['pedido'];
	$controller->porFacturarEmbalar($docp); 
}elseif (isset($_POST['comprasXmes'])) {
	$mes =$_POST['Mes'];
	$controller->comprasXmes($mes);
}elseif (isset($_POST['regCompEdoCta'])){
	$fecha =$_POST['fechaedo'];
	$docc = $_POST['docc'];
	$mes = $_POST['mes'];
	$pago = $_POST['pago'];
	$banco =$_POST['banco'];
	$tptes =$_POST['tptes'];
	$controller->regCompEdoCta($fecha, $docc, $mes, $pago,$banco, $tptes);
}elseif (isset ($_POST['FORM_ACTION_PAGO_CREDITO_CONTRARECIBO'])) {
      $identificador = $_POST['identificador'];
      $tipo = $_POST['tipo'];
      //echo "TIPO: -$tipo-";
     $controller->detallePagoCreditoContrarecibo($tipo, $identificador);
 } elseif (isset ($_POST['FORM_ACTION_PAGO_CREDITO_CONTRARECIBO_IMPRIMIR'])) {
     $identificador = $_POST['identificador'];
     $tipo = $_POST['tipo'];  
     $montor = $_POST['montor'];
     $facturap = $_POST['facturap'];
     $recepcion =$_POST['recepcion'];  
     $controller->detallePagoCreditoContrareciboImprime($tipo, $identificador, $montor, $facturap, $recepcion); 
}elseif(isset($_POST['FORM_ACTION_OC_ADUANA_LISTA'])){
     $mes = $_POST['mes'];
     $anio = $_POST['anio'];
     $controller->verListadoOCAduana($mes, $anio);    
 } elseif(isset($_POST['FORM_ACTION_OC_ADUANA_REGISTRO'])){
     $identificador = $_POST['identificador'];
     $aduana = $_POST['aduana'];
     $mes = $_POST['mes'];
     $anio = $_POST['anio'];
     $controller->registrarOCAduana($identificador, $aduana,$mes, $anio);
}elseif (isset($_POST['fallarOC'])) {
	$doco=$_POST['doco'];
	$controller->ImpresionFallido($doco);
}elseif(isset($_POST['FacturaPago'])){
	$cveclie=$_POST['cveclie'];
	$controller->FacturaPago($cveclie);
}elseif (isset($_POST['PagoxFactura'])){
	$docf=$_POST['docf'];
	$clie=$_POST['clie'];
	$rfc=$_POST['rfc'];
	$controller->PagoxFactura($docf, $clie, $rfc);
}elseif (isset($_POST['aplicaPagoxFactura'])){
	$docf=$_POST['docf'];
	$idpago=$_POST['idpago'];
	$monto=$_POST['monto'];
	$saldof=$_POST['saldof'];
	$clie =$_POST['clie'];
	$rfc=$_POST['rfc'];
	$controller->aplicarPagoxFactura($docf, $idpago, $monto, $saldof, $clie, $rfc);
}elseif (isset($_POST['PagoFactura'])){
	$clie =$_POST['cveclie'];
	$controller->PagoFactura($clie);
}elseif (isset($_POST['aplicaPago'])){
	$clie=$_POST['clie'];
	$id=$_POST['id'];
	$controller->aplicaPago($clie,$id);
}elseif(isset($_POST['guardaCompra'])){
	$fact=$_POST['fact'];
	$prov=$_POST['proveedor'];
	$monto=$_POST['monto'];
	$ref=$_POST['referencia'];
	$tipopago=$_POST['tipopago'];
	//$fechadoc=$_POST['fechadoc'];
	$fechadoc=$_POST['fechaEdoCta'];
	$fechaedocta=$_POST['fechaEdoCta'];
	$banco=$_POST['banco'];
	$tipo =$_POST['tipo'];
	$idg = $_POST['idg'];
	$controller->guardaCompra($fact, $prov, $monto, $ref, $tipopago, $fechadoc, $fechaedocta, $banco, $tipo, $idg);
}elseif (isset($_POST['aplicaPagoFactura'])) {
	$clie=$_POST['clie'];
	$id=$_POST['idpago'];
	$docf=$_POST['docf'];
	$monto=$_POST['monto'];
	$saldof=$_POST['saldof'];
	$rfc=$_POST['rfc'];
	$controller->aplicaPagoFactura($clie, $id, $docf, $monto, $saldof, $rfc);
}elseif(isset($_POST['impAplicacion'])){
	$ida= $_POST['ida'];
	$controller->impAplicacion($ida);
}elseif (isset($_POST['aplicaPagoDirecto'])){
	$idp =$_POST['idpago'];
	$tipo=$_POST['tipo'];
	$controller->aplicaPagoDirecto($idp, $tipo);
}elseif (isset($_POST['PagoDirecto'])) {
	$idp =$_POST['idpago'];
	$docf = $_POST['docf'];
	$rfc = $_POST['rfc'];
	$monto = $_POST['monto'];
	$saldof=$_POST['saldof'];
	$clie=$_POST['clie'];
	$tipo=$_POST['tipo'];
	$tipo2=$_POST['tipo2'];
	$controller->PagoDirecto($idp, $docf, $rfc, $monto, $saldof, $clie, $tipo, $tipo2);
}elseif (isset($_POST['traeFacturaPago'])) {
	$idp=$_POST['idpago'];
	$monto=$_POST['monto'];
	$docf = $_POST['docf'];
	$tipo = $_POST['tipo'];
	$tipo2 = '';
	$controller->traeFacturaPago($idp, $monto, $docf, $tipo, $tipo2);
}elseif (isset($_POST['traeValidacion'])) {
	$doco=$_POST['doco'];
	$controller->traeValidacion($doco);
}elseif (isset($_POST['verPagosActivos'])) {
	$monto=$_POST['monto'];
	$controller->verPagosActivos($monto);
}elseif (isset($_POST['imprimirComprobante'])) {
	$idp=$_POST['idpago'];
	$controller->imprimirComprobante($idp);
}elseif(isset($_POST["FORM_ACTION_CR_PAGO"])){
    $folios = $_POST["items"];
    $cantidad = $_POST["seleccion_cr"];
    $monto = $_POST["total"];
    $controller->pagarOCContrarecibos($cantidad, $folios, $monto);
} elseif(isset ($_POST['FORM_ACTION_CR_PAGO_APLICAR'])){
    $medio = $_POST['medio'];
    $cuentaBancaria = $_POST['cuentabanco'];
    $folios = $_POST['folios'];
    $monto = $_POST['monto'];
    $controller->pagarOCContrarecibosAplicar($folios, $cuentaBancaria, $medio, $monto);
}elseif (isset($_POST['IngresarBodega'])) {
	$desc = $_POST['descripcion'];
	$cant = $_POST['cant'];
	$marca = $_POST['marca'];
	$proveedor = $_POST['proveedor'];
	$costo = 0; // $_POST['costo'];
	$unidad =$_POST['unidad'];
	$controller->IngresarBodega($desc, $cant, $marca, $proveedor, $costo, $unidad);
}elseif (isset($_POST['guardaCargoFinanciero'])){
	$monto=$_POST['monto'];
	$fecha=$_POST['fecha'];
	$banco=$_POST['banco'];
	$controller->guardaCargoFinanciero($monto, $fecha, $banco);
}elseif (isset($_POST['aplicarPagoFactura'])){
	$caja = $_POST['caja'];
	$docf = $_POST['docf'];
	$controller->aplicarPagoFactura($caja, $docf);
}elseif (isset($_POST['impRecCobranza'])) {
	//$controller->impRecCobranza();
	$controller->impRecCobranza();
}elseif (isset($_POST['imprimeCierreEnt'])){
	$idr = $_POST['idr'];
	$controller->imprimeCierreEnt($idr);
}elseif (isset($_POST['guardaFacturaProv'])) {
	$docr=$_POST['docr'];
	$factura = $_POST['factura'];
	$controller->guardaFacturaProv($docr, $factura);
}elseif (isset($_POST['impCierreVal'])) {
	$controller->impCierreVal();
}elseif (isset($_POST['asociarCF'])) {
	$idcf =$_POST['idcf'];
	$rfc =$_POST['rfc'];
	$banco = $_POST['banco'];
	$cuenta =$_POST['cuenta'];
	$controller->asociarCF($idcf, $rfc, $banco, $cuenta);
}elseif (isset($_POST['traePagos'])) {
	$monto = $_POST['monto'];
	$idcf =$_POST['idcf'];
	$controller->traePagos($idcf, $monto);
}elseif (isset($_POST['cargaCF'])) {
	$idcf =$_POST['idcf'];
	$idp =$_POST['idp'];
	$montoc =$_POST['montoc'];
	$controller->cargaCF($idcf, $idp, $montoc);
}elseif (isset($_POST['enviaAcreedor'])){
	$idp =$_POST['idp'];
	$saldo=$_POST['saldo'];
	$rfc=$_POST['rfc'];
	$controller->enviaAcreedor($idp, $saldo, $rfc);
}elseif (isset($_POST['contabilizarAcreedor'])) {
	$ida=$_POST['ida'];
	$controller->contabilizarAcreedor($ida);
}elseif (isset($_POST['cancelaAplicacion'])){
	$idp=$_POST['idp'];
	$docf=$_POST['docf'];
	$idap=$_POST['idap'];
	$montoap=$_POST['montoap'];
	$tipo=$_POST['tipo'];
	$controller->cancelaAplicacion($idp, $docf, $idap, $montoap, $tipo);
}elseif (isset($_POST['procesarPago'])) {
	$idp=$_POST['idpago'];
	$saldop=$_POST['saldopago'];
	$montop=$_POST['montopago'];
	$tipo=$_POST['tipoPago'];
	if($saldop==$montop and $tipo != 'SS'){
		$controller->procesarPago($idp, $tipo);
	}else{
		$controller->errorPago($idp, $tipo);
	}
}elseif (isset($_POST['regEdoCta'])){
	$idtrans =$_POST['idtrans'];
	$monto = $_POST['idmonto'];
	$tipo = $_POST['tipo'];
	$mes = $_POST['mes'];
	$banco =$_POST['banco'];
	$cuenta = $_POST['cuenta'];
	$cargo = $_POST['montoCargo'];
	$anio = $_POST['anio'];
	$nvaFechComp=$_POST['nvaFechComp'];
	$nf='0';
	$controller->regEdoCta($idtrans, $monto, $tipo, $mes, $banco,  $cuenta, $cargo, $anio, $nvaFechComp, $nf);
}elseif (isset($_POST['regEdoCta1'])){
	$idtrans =$_POST['idtrans'];
	$monto = $_POST['idmonto'];
	$tipo = $_POST['tipo'];
	$mes = $_POST['mes'];
	$banco =$_POST['banco'];
	$cuenta = $_POST['cuenta'];
	$cargo = $_POST['montoCargo'];
	$anio = $_POST['anio'];
	$nvaFechComp=$_POST['nvaFechComp'];
	$nf='1';
	$controller->regEdoCta($idtrans, $monto, $tipo, $mes, $banco,  $cuenta, $cargo, $anio, $nvaFechComp, $nf);
}
elseif (isset($_POST['imprimeValidacion'])) {
	$idval = $_POST['idval'];
	$controller->imprimeValidacion($idval);
}elseif (isset($_POST['ImpSolicitud'])){
	$idsol = $_POST['idsol'];
	$controller->ImpSolicitud($idsol);
}elseif (isset($_POST['ImpSolPagada'])){
	$idsol=$_POST['idsol'];
	$controller->ImpSolPagada($idsol);
}elseif (isset($_POST['recConta'])) {
	$folio = $_POST['folio'];
	$controller->recConta($folio);
}elseif (isset($_POST['regCompraEdoCta'])){
	$folio =$_POST['folio'];
	$doc = $_POST['doc'];
	$fecha=$_POST['fecEdoCta'];
	$controller->regCompraEdoCta($folio, $doc, $fecha);
}elseif (isset($_POST['buscarPagos'])){
	$campo = $_POST['campo'];
	$controller->buscarPagos($campo);
}elseif (isset($_POST['cancelarPago'])){
	$idp =$_POST['idp'];
	$controller->cancelarPago($idp);
}elseif (isset($_POST['enviarConta'])){
	$medio = $_POST['medio'];
    $cuentaBancaria = $_POST['cuentabanco'];
    $folios = $_POST['folios'];
    $monto = $_POST['monto'];
    $controller->enviarConta($folios, $cuentaBancaria, $medio, $monto);
}elseif (isset($_POST['buscarContrarecibos'])){
	$campo =$_POST['campo'];
	$controller->buscarContrarecibos($campo);
}elseif (isset($_POST['impresionContrarecibo'])) {
	$tipo = $_POST['tipo'];
	$identificador=$_POST['identificador'];
	$controller->impresionContrarecibo($tipo,$identificador);
}elseif (isset($_POST['editIngresoBodega'])) {
	$idi = $_POST['idi'];
	$costo=$_POST['costo'];
	$proveedor = $_POST['proveedor'];
	$cant = $_POST['cantidad'];
	$unidad = $_POST['unidad'];
	$controller->editIngresoBodega($idi, $costo, $proveedor, $cant, $unidad);
}elseif (isset($_POST['filtroDirVerFacturas'])){
	$mes = $_POST['mes'];
	$vend =$_POST['vendedor'];
	$anio = $_POST['anio'];
	$controller->dirVerFacturas($mes, $vend, $anio);
}elseif (isset($_POST['traeOC'])){
	$campo = $_POST['campo'];
	$fechaedo = $_POST['fechaedo'];
	$controller->traeOC($campo, $fechaedo);
}elseif (isset($_POST['procesarOC'])){
	$fechaedo = $_POST['fechaedo'];
	$doco = $_POST['doco'];
	$montof =$_POST['montof'];
	$factura = $_POST['factura'];
	$idb = $_POST['banco'];
	$tpf =$_POST['tpf'];
	$controller->procesarOC($doco, $idb, $fechaedo, $montof, $factura, $tpf);
}elseif (isset($_POST['guardaDeudor'])){
	$fechaedo=$_POST['fechaedo'];
	$monto=$_POST['monto'];
	$proveedor=$_POST['proveedor'];
	$banco=$_POST['banco'];
	$tpf=$_POST['tpf'];
	$referencia=$_POST['referencia'];
	$destino=$_POST['destino'];
	$controller->guardaDeudor($fechaedo, $monto,$proveedor, $banco, $tpf, $referencia, $destino);
}elseif (isset($_POST['guardaTransPago'])){
	$fechaedo=$_POST['fechaedo'];
	$monto=$_POST['monto'];
	$bancoO = $_POST['bancoO'];
	$bancoD = $_POST['bancoD'];
	$tpf = $_POST['tpf'];
	$TT = $_POST['TT'];
	$referencia = $_POST['referencia'];
	$controller->guardaTransPago($fechaedo, $monto, $bancoO, $bancoD, $tpf, $TT, $referencia);
}elseif (isset($_POST['SaldosxDocumentoH'])){
	$cliente = $_POST['cveclie'];
	$controller->SaldosxDocumentoH($cliente);
}elseif(isset($_POST['facturapagomaestro'])){
	$maestro = $_POST['maestro'];
	$controller->facturapagomaestro($maestro);
}elseif (isset($_POST['pagoFacturaMaestro'])){
	$maestro=$_POST['maestro'];
	$docf =$_POST['docf'];
	if(!isset($_POST['tipo'])){
		$tipo = '';
	}else{
		$tipo = $_POST['tipo'];
	}
	$controller->pagoFacturaMaestro($maestro, $docf, $tipo);
}elseif (isset($_POST['calendarCxC'])){
	$cartera = $_POST['calendarCxC'];
	$controller->calendarCxC($cartera);
}elseif (isset($_POST['regnvafecha'])){
	$idtrans=$_POST['iden'];
	$monto = 0;
	$tipo = 'NA';
	$mes= 99;
	$banco = 'NA';
	$cuenta = 'NA';
	$cargo = 0;
	$anio = 2017;
	$nvaFechComp=$_POST['fecha'];
	$nf='1';
	$valor=$_POST['valor'];
	$controller->regEdoCta($idtrans, $monto, $tipo, $mes, $banco,  $cuenta, $cargo, $anio, $nvaFechComp, $nf, $valor);
}elseif (isset($_POST['editarMaestro'])) {
	$idm=$_POST['idm'];
	$controller->editarMaestro($idm);
}elseif(isset($_POST['editaMaestro'])){
	$idm=$_POST['idm'];
    for($i = 1; $i <= 4; $i++){
        if(count($_POST[('CC'.$i)])>0){
            $cc[] = $_POST[('CC'.$i)];
        }
    }
    for($c = 1; $c <= 4; $c++){
        if(count($_POST[('CR'.$c)])>0){
            $cr[] = $_POST[('CR'.$c)];
        }
    }
    $controller->editaMaestro($idm,$cc, $cr);
}elseif (isset($_POST['altaMaestro'])){
	$nombre = $_POST['nombre'];
	/*for($i = 1; $i <= 4; $i++){
        if(count($_POST[('CC'.$i)])>0){
            $cc[] = $_POST[('CC'.$i)];
        }
    }
    for($c = 1; $c <= 4; $c++){
        if(count($_POST[('CR'.$c)])>0){
            $cr[] = $_POST[('CR'.$c)];
        }
    }*/
    $controller->altaMaestro($nombre);		
}elseif (isset($_POST['rastreadorFacturas'])){
	$docf = $_POST['docf'];
	$controller->rastreadorFacturas($docf);
}elseif (isset($_POST['genCierreCobranza'])) {
	$cc = $_POST['cc'];
	$controller->genCierreCobranza($cc);
}elseif (isset($_POST['recDocCierreCob'])) {
	$idp = $_POST['idp'];
	$fecha = $_POST['fecha'];
	$controller->recDocCierreCob($idp, $fecha);
}elseif (isset($_POST['utilerias'])) {
	$opcion = $_POST['opcion'];
	if(isset($_POST['docp'])){
		$docp = $_POST['docp'];	
	}else{
		$docp='';	
	}
	if(isset($_POST['docf'])){
		$docf = $_POST['docf'];
	}else{
		$docf='';
	}
	if(isset($_POST['docd'])){
		$docd = $_POST['docd'];
	}else{
		$docd = '';
	}
	if(isset($_POST['fechaIni'])){
		$fechaIni = $_POST['fechaIni'];
	}else{
		$fechaIni = '';
	}
	if(isset($_POST['fechaFin'])){
		$fechaFin = $_POST['fechaFin'];
	}else{
		$fechaFin = '';
	}
	if(isset($_POST['maestro'])){
		$maestro =$_POST['maestro'];
	}else{
		$maestro = '';
	}
	$controller->utilerias($opcion, $docp, $docd, $docf, $fechaIni, $fechaFin, $maestro);
}elseif (isset($_POST['contVenta'])) {
	$ida = $_POST['ida'];
	$docf =$_POST['docf'];
	$idp =$_POST['idp'];
	$controller->contVenta($idp, $ida, $docf);
}elseif(isset($_POST['verInd'])){
	$maestro= $_POST['maestro'];
	$status = $_POST['status'];
	$controller->verInd($maestro, $status);
}elseif (isset($_POST['guardaSecuencia'])){
	$secuencia = $_POST['secuencia'];
	$idc = $_POST['idc'];
	$cc = $_POST['cc'];
	$controller_cxc->guardaSecuencia($idc,$secuencia, $cc);
}elseif (isset($_POST['impRutaCobranza'])){
	$cc=$_POST['cc'];
	$controller_cxc->impRutaCobranza($cc);
}elseif (isset($_POST['verPartidasRuta'])) {
	$idf= $_POST['idf'];
	if(!isset($_POST['cierre'])){
		$cierre = '';
	}else{
		$cierre =$_POST['cierre'];
	}
	$controller_cxc->verPartidasRuta($idf, $cierre);
}elseif(isset($_POST['cierreCC'])){
	$idr=$_POST['idf'];
	$controller_cxc->cierreCC($idr);
}elseif (isset($_POST['editaFTCART'])) {
	$ids = $_POST['ids'];
	$cotizacion=$_POST['cotizacion'];
	$vendedor = $_POST['vendedor'];
	$controller->editaFTCART($ids, $cotizacion, $vendedor);
}elseif (isset($_POST['guardaFTCART'])) {
		$ids = $_POST['ids'];
		$clave=$_POST['clave'];
		$categoria=$_POST['categoria'];	
		$linea=$_POST['linea'];
		$descripcion =$_POST['descripcion'];
		$marca=$_POST['marca'];
		$generico=$_POST['generico'];
		$sinonimos=$_POST['sinonimos'];
		$calificativo=$_POST['calificativo'];
		$medidas=$_POST['medidas'];
		$unidadmedida=$_POST['unidadmedida'];
		$empaque=$_POST['empaque'];
		$prov1=$_POST['prov1'];
		$codigo_prov1=$_POST['codigo_prov1'];
		$sku=$_POST['sku'];
		$costo_prov1=$_POST['costo_prov1'];
		if(isset($_POST['iva'])){
			$iva=$_POST['iva'];	
		}else{
			$iva='No';
		}
		if(empty($_POST['desc1'])){
			$desc1= 0;
		}else {
			$desc1=$_POST['desc1'];
		}
		if(empty($_POST['desc2'])){
			$desc2= 0;
		}else {
			$desc2=$_POST['desc2'];
		}
		if(empty($_POST['desc3'])){
			$desc3= 0;
		}else {
			$desc3=$_POST['desc3'];
		}
		if(empty($_POST['desc4'])){
			$desc4= 0;
		}else {
			$desc4=$_POST['desc4'];
		}
		if(empty($_POST['desc5'])){
			$desc5= 0;
		}else {
			$desc5=$_POST['desc5'];
		}
		if(empty($_POST['impuesto'])){
			$impuesto= 0;
		}else {
			$impuesto=$_POST['impuesto'];
		}
		if(!isset($_POST['costo_t'])){
			$costo_t= 0;
		}else {
			$costo_t=$_POST['costo_t'];
		}
		if(!isset($_POST['costo_oc'])){
			$costo_oc= 0;
		}else {
			$costo_oc=$_POST['costo_oc'];
		}
		$costo_total=$_POST['costo_total'];
		$cotizacion =$_POST['cotizacion'];
		$cliente=$_POST['cliente'];
		if(!isset($_POST['tipo'])){
			$tipo = '';
			$doco = '';
			$par ='';
		}else{
			$tipo = $_POST['tipo'];
			$doco = $_POST['doco'];
			$par =$_POST['par'];
		}
		$controller->guardaFTCART($ids, $clave, $categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov1, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $cotizacion, $cliente,  $costo_t, $costo_oc, $tipo, $doco, $par);	
}elseif (isset($_POST['produccionFTCART'])) {
	$ids=$_POST['ids'];
	$controller->produccionFTCART($ids);
}elseif (isset($_POST['cancelarCargaPago'])){
	$idtrans =$_POST['idtrans'];
	$monto = $_POST['idmonto'];
	$tipo = $_POST['tipo'];
	$mes = $_POST['mes'];
	$banco =$_POST['banco'];
	$cuenta = $_POST['cuenta'];
	$cargo = $_POST['montoCargo'];
	$anio = $_POST['anio'];
	if(!isset($_POST['nvaFechComp'])){
		$nvaFechComp='01.01.2017';
	}else{
		$nvaFechComp=$_POST['nvaFechComp'];
	}
	$nf='0';
	$controller->cancelarCargaPago($idtrans, $monto, $tipo, $mes, $banco,  $cuenta, $cargo, $anio, $nvaFechComp, $nf);
}elseif (isset($_POST['verPedido'])){
	//$idca=$_POST['idca'];
	$folio = $_POST['folio'];
	$controller->verPedido( $folio);
}elseif (isset($_POST['libPedidoFTC'])) {
	$folio=$_POST['folio'];
	$idp = $_POST['idp'];
	$idca = $_POST['idca'];
	$urgente = $_POST['urgente'];
	$controller->libPedidoFTC($folio, $idp, $idca, $urgente);
}elseif (isset($_POST['editarMXC'])) {
	$idcxm = $_POST['id'];
	$controller->editarMXC($idcxm);
}elseif (isset($_POST['editaMXC'])){
	$idmxc=$_POST['idmxc'];
	$auxiliar = $_POST['auxiliar'];
	$controller->editaMXC($idmxc, $auxiliar);
}elseif (isset($_POST['deslib'])) {
	$folio = $_POST['folio'];
	$respuesta = $_POST['respuesta'];
	$controller->deslib($folio, $respuesta);
}elseif (isset($_POST['editaProveedor'])){
	$idprov= $_POST['idprov'];
	$controller->editaProveedor($idprov);
}elseif (isset($_POST['editarProveedor'])){
	//echo 'Valor del beneficiario: antes'.$_POST['beneficiario'];
	if(isset($_POST['urgencia'])){
		$urgencia= $_POST['urgencia'];
	}else{
		$urgencia= 'No';
	}
	if(isset($_POST['envio'])){
		$envio = $_POST['envio'];
	}else{
		$envio = 'No';
	}
	if(isset($_POST['recoleccion'])){
		$recoleccion= $_POST['recoleccion'];	
	}else{
		$recoleccion='No';
	}
	if(isset($_POST['efectivo'])){
		$tp_efe = $_POST['efectivo'];
	}else{
		$tp_efe = 'No';
	}
	if(isset($_POST['cheque'])){
		$tp_ch = $_POST['cheque'];
	}else{
		$tp_ch = 'No';
	}
	if(isset($_POST['credito'])){
		$tp_cr = $_POST['credito'];
	}else{
		$tp_cr = 'No';
	}
	if(isset($_POST['transferencia'])){
		$tp_tr = $_POST['transferencia'];
	}else{
		$tp_tr= 'No';
	}
	if(isset($_POST['certificado'])){
		$certificado=$_POST['certificado'];	
	}else{
		$certificado='No';
	}
	if(!empty($_POST['banco'])){
		$banco = $_POST['banco'];	
	}else{
		$banco = '';
	}

	if(!empty($_POST['cuenta'])){
		$cuenta=$_POST['cuenta'];	
	}else{
		$cuenta='';
	}
	if(!empty($_POST['beneficiario'])){
		$beneficiario=$_POST['beneficiario'];	
	}else{
		$beneficiario='';
	}
	if(empty($_POST['plazo'])){
		$plazo=0;
	}else{
		$plazo =$_POST['plazo'];
	}

	$responsable = $_POST['responsable'];

	$idprov = $_POST['idprov'];
	$email1 = '';
	$email2 = '';
	$email3  = '';

	if(!empty($_POST['email1'])){
		$email1 = $_POST['email1'];
	}
	if(!empty($_POST['email2'])){
		$email2 = $_POST['email2'];
	}
	if(!empty($_POST['email3'])){
		$email3=$_POST['email3'];
	}
	//echo $tp_ch.'<p>';
	//echo $beneficiario.'<p>';
	//break;
	$controller->editarProveedor($idprov, $urgencia, $envio, $recoleccion, $tp_efe, $tp_ch, $tp_cr, $tp_tr, $certificado, $banco, $cuenta, $beneficiario, $responsable, $plazo, $email1, $email2, $email3);
}elseif (isset($_POST['bajaFTCArticualo'])){
	$ids = $_POST['ids'];
	$controller->bajaFTCArticualo($ids);
}elseif (isset($_POST['rechazaSol'])) {
	$ids = $_POST['ids'];
	$motivo = $_POST['motivo'];
	$vendedor =$_POST['vendedor'];
	$controller->rechazaSol($ids, $motivo, $vendedor);
}elseif (isset($_POST['enterado'])) {
	$idr = $_POST['idr'];
	$controller->enterado($idr);
}elseif (isset($_POST['verCCC'])) {
	$idm = $_POST['idm'];
	$cvem = $_POST['cvem'];
	$controller->verCCC($idm, $cvem);
}elseif (isset($_POST['creaCC'])) {
	$cvem=$_POST['cvem'];
	$nombre = $_POST['nombre'];
	$contacto =$_POST['contacto'];
	$telefono =$_POST['telefono'];
	$presup =$_POST['presup'];
	$idm = $_POST['idm'];
	//$cliente=$_POST['cliente'];
	$controller->creaCC($cvem,$nombre, $contacto, $telefono, $presup, $idm);
}elseif (isset($_POST['rechazarFTC'])) {
	$idca= $_POST['idca'];
	$idp = $_POST['idp'];
	$folio = $_POST['folio'];
	$urgente = $_POST['urgente'];
	$controller->rechazarFTC($idca, $idp, $folio, $urgente);
}elseif (isset($_POST['reasignaAcreedor'])) {
	$nclie = $_POST['clie1'];
	$ida = $_POST['ida'];
	$oldclie = $_POST['clie2'];
	$saldo = $_POST['saldo'];
	$controller->reasignaAcreedor($nclie, $ida, $oldclie, $saldo);
}elseif (isset($_POST['verAplicaciones2'])){
	$anio=$_POST['anio'];
	$tipo=$_POST['tipo'];
	$controller->verAplicaciones2($anio, $tipo);
}elseif (isset($_POST['asociaCC'])) {
	$cc = $_POST['cc'];
	$cliente = $_POST['cliente'];
	$cvem = $_POST['cvem'];
	$idm = $_POST['idm'];
	$controller->asociaCC($cc, $cliente, $cvem, $idm);
}elseif (isset($_POST['cancelaAsociaCC'])) {
	$cliente = $_POST['cliente'];
	$controller->cancelaAsociaCC($cliente);
}elseif (isset($_POST['detalleMaestro'])) {
	$idm = $_POST['idm'];
	$cvem = $_POST['cvem'];
	$controller->detalleMaestro($idm, $cvem);
}elseif (isset($_POST['FORM_ACTION_PAGO_FACTURAS'])) {
	$seleccion_cr =$_POST['seleccion_cr'];
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

	$controller->pagarFacturas($items, $seleccion_cr, $total, $pagos, $mes, $anio);
}elseif (isset($_POST['aplicarPago2'])) {
	$idp=$_POST['idp'];
	$saldop=$_POST['saldop'];
	$items =$_POST['items'];
	$total = $_POST['total'];
	$controller->aplicarPago2($idp, $saldop, $items, $total);
}elseif (isset($_POST['cerrarPago'])) {
	$idp =$_POST['idp'];
	$controller_cxc->cerrarPago($idp);
}elseif (isset($_POST['solAcreedor'])) {
	$idp =$_POST['idp'];
	$saldo=$_POST['saldo'];
	$controller_cxc->solAcreedor($idp, $saldo);
}elseif (isset($_POST['solRestriccion'])) {
	$cveclie=$_POST['cveclie'];
	$controller_cxc->solRestriccion($cveclie);
}elseif (isset($_POST['solCorte'])) {
	$cveclie=$_POST['cveclie'];
	$controller_cxc->solCorte($cveclie);
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
}elseif (isset($_POST['impPOC'])) {
	$idpoc = $_POST['idpoc'];
	$tipo = 'i';
	$controller->impPOC($idpoc,$tipo);
	
}elseif (isset($_POST['verValidaciones'])) {
	$doco=$_POST['doco'];
	$controller->verValidaciones($doco);
}elseif (isset($_POST['buscaOC2'])){
	$doco=$_POST['doco'];
	$liberadas = false;
	$recepcionadas = false;
	$validadas = false;
	$controller->buscaOC2($doco, $liberadas, $recepcionadas, $validadas);
}elseif (isset($_POST['confirmarPreOC'])) {
	$doco = $_POST['doco'];
	$controller->confirmarPreOC($doco);
}elseif (isset($_POST['eliminaPartidaPreoc'])){
	$idd = $_POST['idd'];
	$controller->eliminaPartidaPreoc($idd);
}elseif(isset($_POST['eliminaPreOC'])){
	$poc = $_POST['poc'];
	$controller->eliminaPreOC($poc);
}elseif (isset($_POST['editaPartidaPreOC'])) {
	$idd=$_POST['idd'];
	$newCant = $_POST['new_cant'];
	$newCost = $_POST['new_cost'];
	$controller->editaPartidaPreOC($idd, $newCant, $newCost);
}elseif (isset($_POST['ConfirmaPreOrden'])){
	$doco = $_POST['doco'];
	$te = $_POST['fechaEntrega'];
	$tptes = $_POST['tptes'];
	$tipo = $_POST['tipo'];
	$conf = $_POST['conf'];
	$controller->ConfirmaPreOrden($doco, $te, $tptes, $tipo, $conf);
}elseif (isset($_POST['recibirOC'])){
	$doco = $_POST['doco'];
	$tipo=$_POST['tipo'];
	$controller->recibirOC($doco, $tipo);
}elseif (isset($_POST['rechazarOC'])) {
	$doco = $_POST['doco'];
	$tipo='Inicial';
	$controller->rechazarOC($doco, $tipo);
}elseif(isset($_POST['recibeParOC'])){
	$idp =$_POST['idp'];
	$cantidad =$_POST['cantidad'];
	$doco = $_POST['doco'];
	$partida = $_POST['partida'];
	$controller->recibeParOC($cantidad, $idp, $doco, $partida);
}elseif (isset($_POST['recibirParOC'])) {
	$idp =$_POST['idp'];
	$cantidad =$_POST['cantidad'];
	$doco = $_POST['doco'];
	$partida = $_POST['partida'];
	$desc1 = $_POST['desc1'];
	$desc2 = $_POST['desc2'];
	$desc3 = $_POST['desc3'];
	$descf = $_POST['descf'];
	$desc1M = $_POST['desc1M'];
	$desc2M = $_POST['desc2M'];
	$desc3M = $_POST['desc3M'];
	$descfM = $_POST['descfM'];
	$precioLista =$_POST['precioLista'];
	$totalCosto = $_POST['totalCosto'];
	$totalPartida = $_POST['totalPartida'];
	$controller->recibirParOC($idp, $cantidad, $doco, $partida, $desc1, $desc2, $desc3, $descf, $desc1M, $desc2M, $desc3M, $descfM, $precioLista, $totalCosto, $totalPartida);
}elseif(isset($_POST['cancelaValidacionRecepcion'])){
	$doco = $_POST['doco'];
	$controller->cancelaValidacionRecepcion($doco);
}elseif (isset($_POST['cerrarRecepcion'])) {
	$doco=$_POST['doco'];
	$controller->cerrarRecepcion($doco);
}elseif (isset($_POST['cancelaRecepcion'])) {
	$doco=$_POST['doco'];
	$controller->cancelaRecepcion($doco);
}elseif (isset($_POST['impresionRecepcion'])) {
	$doco =$_POST['doco'];
	$controller->impresionRecepcion($doco);
}elseif (isset($_POST['imprimeRecep'])){
	$doco=$_POST['doco'];
	$docr=$_POST['docr'];
	$controller->imprimeRecep($doco, $docr);
}elseif(isset($_POST['valRecepcion'])){
	$doco=$_POST['doco'];
	$tipo = 'Inicial';
	$controller->valRecepcion($doco, $tipo);
}elseif (isset($_POST['ejecutaAcccion'])) {
	$docf = $_POST['id'];
	$nstatus = $_POST['nstatus'];
	$controller->ejecutaAcccion($docf, $nstatus);
}elseif (isset($_POST['cerrarValidacion'])) {
	$doco = $_POST['doco'];
	$controller->cerrarValidacion($doco);
}elseif (isset($_POST['formulario'])) {
	$doco = $_POST['doco'];
	$controller->formulario($doco);
}elseif (isset($_POST['solAutCostos'])) {
	$idp =$_POST['idp'];
	$cantidad =$_POST['cantidad'];
	$doco = $_POST['doco'];
	$partida = $_POST['partida'];
	$desc1 = $_POST['desc1'];
	$desc2 = $_POST['desc2'];
	$desc3 = $_POST['desc3'];
	$descf = $_POST['descf'];
	$desc1M = $_POST['desc1M'];
	$desc2M = $_POST['desc2M'];
	$desc3M = $_POST['desc3M'];
	$descfM = $_POST['descfM'];
	$precioLista =$_POST['precioLista'];
	$totalCosto = $_POST['totalCosto'];
	$totalPartida = $_POST['totalPartida'];
	$controller->solAutCostos($idp, $cantidad, $doco, $partida, $desc1, $desc2, $desc3, $descf, $desc1M, $desc2M, $desc3M, $descfM, $precioLista, $totalCosto, $totalPartida);
}elseif (isset($_POST['aceptarCosto'])) {
	$doco=$_POST['doco'];
	$par = $_POST['par'];
	$costo_o = $_POST['costo_o'];
	$costo_n = $_POST['costo_n'];
	$controller->aceptarCosto($doco, $par, $costo_o, $costo_n);
}elseif (isset($_POST['recibirValidacion'])) {
	$doco = $_POST['doco'];
	$folio = $_POST['folio'];
	$controller->recibirValidacion($doco, $folio);
}elseif(isset($_POST['buscarArticuloCatalogo'])){
	$descripcion=$_POST['descripcion'];
	$marca = '';
    $categoria='';
    $desc1 = '';
    $generico = '';
    $unidadmedida = '';
    $prov1 = '';
    $desc2 = '';
	$controller->catalogoProductosFTC($marca, $categoria, $desc1, $generico, $unidadmedida, $prov1, $desc2, $descripcion);
}elseif(isset($_POST['guardaOC'])){
	$doco = $_POST['doco'];
	$tipo = $_POST['tipo'];
	$tipo2 = $_POST['tipo2'];
	$controller->imprimeOC_v2($doco, $tipo, $tipo2);
}elseif(isset($_POST['cambiarProv'])){
	$ida=$_POST['ida'];
	$cant = $_POST['cant'];
	$origen = $_POST['origen'];
	$prov = $_POST['prov'];
	$tipo = $_POST['tipo'];
	$controller->cambiarProv($ida, $cant, $origen, $prov,$tipo);
}elseif(isset($_POST['cambioProveedor'])){
	$prov1 = $_POST['prov1'];
	$id = $_POST['id'];
	$idpreoc=$_POST['idpreoc'];
	$controller->cambioProveedor($prov1, $id, $idpreoc);
}elseif(isset($_POST['test9'])){
	$response = $controller->test9($_POST['test9']);
    echo json_encode($response);
    exit();
}elseif(isset($_POST['guardaEdoCta'])){
	$pagos = $_POST['abonos'];
	$compras = $_POST['compras'];
	$gastos = $_POST['gastos'];
	$mes = $_POST['mes'];
	$cuenta = $_POST['cuenta'];
	$banco =$_POST['banco'];
	$anio = $_POST['anio'];
	///var_dump($pagos).'<p>';
	///var_dump($compras).'<p>';
	///var_dump($gastos).'<p>';
	///break;
	$controller->guardaEdoCta($pagos, $compras, $gastos, $anio, $mes, $cuenta, $banco);
}elseif (isset($_POST['actFecha'])) {
	$tipo =$_POST['tipo'];
	$docu = $_POST['docu'];
	$fecha = $_POST['fecha'];
	$response = $controller->actFecha($tipo, $docu, $fecha);
    echo json_encode($response);
    exit();
}elseif (isset($_POST['cerrarEdoCtaMes'])) {
	$mes = $_POST['mes'];
	$anio = $_POST['anio'];
	$abonos = $_POST['abonosCierre'];
	$cargos = $_POST['cargosCierre'];
	$inicial = $_POST['inicialCierre'];
	$final = $_POST['finalCierre'];
	$cuenta = $_POST['cuenta'];
	$banco = $_POST['banco'];
	$controller->cerrarEdoCtaMes($mes, $anio, $abonos,$cargos, $inicial, $final, $cuenta, $banco);
}elseif (isset($_POST['recibeRec'])){
	$id = $_POST['id'];
	$tipo2 = $_POST['tipo'];
	$response = $controller->recibeRec($id, $tipo2);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['asignarProductoAlmacen'])) {
	$producto = $_POST['producto'];
	$cotizacion = $_POST['cotizacion'];
	$cantidad = $_POST['cantidad'];
	$cantidadAlmacen=$_POST['cantidadAlmacen'];
	$id = $_POST['id'];
	$controller->asignarProductoAlmacen($producto, $cotizacion, $cantidad, $cantidadAlmacen, $id);
}elseif (isset($_POST['layoutBBVA'])) {
	$docs = $_POST['pagoLayout'];
	$controller->layoutBBVA($docs);
}elseif (isset($_POST['calculoComisiones'])) {
	$mes=$_POST['mes'];
	$anio = $_POST['anio'];
	$vendedor =$_POST['vendedor'];
	$controller->calculoComisiones($anio, $mes, $vendedor);
}elseif (isset($_POST['buscaFacturaNC'])){
	if(isset($_POST['opcion'])){
		$opcion = $_POST['opcion'];
	}else{
		$opcion = 0;	
	}
	if(isset($_POST['docf'])){
		$docf = $_POST['docf'];
	}else{
		$docf = '';
	}
	$controller->buscaFacturaNC($opcion, $docf);
}elseif (isset($_POST['refacturarFecha'])) {
	$docf = $_POST['docf'];
	$nf = $_POST['nfecha'];
	$obs = $_POST['obs'];
	$opcion = $_POST['opcion'];
	$controller->refacturarFecha($docf, $nf, $obs, $opcion);
}elseif(isset($_POST['refacturarDireccion'])){
	$docf = $_POST['docf'];
	$calle=$_POST['calle'];
	$num_ext = $_POST['exterior'];
	$num_int = $_POST['interior'];
	$colonia = $_POST['colonia'];
	$municipio = $_POST['municipio'];
	$ciudad =$_POST['ciudad'];
	$referencia = $_POST['referencia'];
	$obs = $_POST['obs'];
	$opcion = $_POST['opcion'];
	$cp = $_POST['cp'];
	$controller->refacturarDireccion($docf, $calle, $num_ext, $num_int, $colonia, $municipio, $ciudad, $referencia, $obs, $opcion, $cp);
}elseif(isset($_POST['facturaProcesoCambioFecha'])){
	$docf = $_POST['docf'];
	$response = $controller->facturaProcesoCambioFecha($docf);
    echo json_encode($response);
    exit();
}elseif (isset($_POST['guardaPartida'])) {
	 $docf = $_POST['docf'];
	 $par = $_POST['partida'];
	 $precio = $_POST['precio'];
	 //echo 'Documento a Afectar: '.$docf.' precio: '.$precio.' partida: '.$par;
	 $response= $controller->guardaPartida($docf, $par, $precio);
	 echo json_encode($response);
	 exit();
}elseif (isset($_POST['solicitudPrecio'])) {
	$docf = $_POST['docf'];
	$response=$controller->solicitudPrecio($docf);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['asignar'])){
	$idp=$_POST['idpreoc'];
	$asignado=$_POST['asig'];
	$idingreso = $_POST['idi'];
	$response=$controller->asignar($idp, $asignado, $idingreso);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['ejecutarRecepcion'])) {
	$ida=$_POST['ida'];
	$cantRec = $_POST['cantRec'];
	$cantOr = $_POST['cantOr'];
	$response=$controller->ejecutarRecepcion($ida, $cantRec, $cantOr);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['procesarDev'])) {
	$idp = $_POST['idp'];
	$cantDev = $_POST['cantDev'];
	$tipo = $_POST['tipo'];
	$controller->procesarDev($idp, $cantDev, $tipo);
}elseif (isset($_POST['quitarSum'])) {
	$ida=$_POST['quitarSum'];
	$controller->quitarSum($ida);
	exit();
}elseif (isset($_POST['procesarAsigAuto'])) {
	$ida = $_POST['procesarAsigAuto'];
	$tipo = $_POST['tipo'];
	$response=$controller->procesarAsigAuto($ida, $tipo);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['cierreInvBodega'])) {
	$datos = $_POST['datos'];
	
	$controller->cierreInvBodega($datos);
}elseif (isset($_POST['quitarRecepDev'])) {
	$folio=$_POST['folio'];
	echo $folio;
	$response=$controller->quitarRecepDev($folio);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['cierreInvPatio'])) {
	$datos=$_POST['datos'];
	$controller->cierreInvPatio($datos);
}elseif (isset($_POST['provOI'])) {
	$clave=$_POST['provOI'];
	$response=$controller->provOI($clave);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['addOCI'])) {
	$prod = $_POST['clave'];
	$cant = $_POST['cant'];
	$prov = $_POST['prov'];
	$temp = $_POST['temp'];
	$response=$controller->addOCI($prod, $cant, $prov, $temp);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['delOCI'])) {
	$linea=$_POST['linea'];
	$temp=$_POST['temp'];
	$response=$controller->delOCI($linea, $temp);
	echo json_encode($response);
	exit();
}elseif (isset($_POST['cerrarOCI'])) {
	$temp = $_POST['cerrarOCI'];
	$controller->cerrarOCI($temp);
}elseif(isset($_POST['execOCI'])){
	$idoci=$_POST['idoci'];
	$tipo=$_POST['tipo'];
	$response=$controller->execOCI($idoci, $tipo);
	echo json_encode($response);
	exit();
}elseif(isset($_POST['imprimeOCI'])){
	$idoci =$_POST['oci'];
	$controller->imprimeOCI($idoci); 
}elseif (isset($_POST['ctrlinvPatio'])) {
	$idpreoc =$_POST['idpreoc'];
	$canto = $_POST['canto'];
	$cantf = $_POST['cantf'];
	$prod =$_POST['prod'];
	$response=$controller->ctrlinvPatio($idpreoc, $canto, $cantf, $prod);
	echo json_encode($response);
	exit();
}
else{switch ($_GET['action']){
	case 'login':
		$controller->Login();
		break;
	case 'CambiarSenia':
		$controller->CambiarSenia();
		break;
	case 'madmin':
		$controller->MenuAdmin();
		break;
	case 'ccp':
		$controller->Ccp();
		break;
	case 'ccm':
		$controller->Ccm();
		break;
	case 'facturas':
		$controller->Facturas();
		break;
		//ajax
	case 'autocomp':
		$controller->Autocomp();
		//echo "hola";
		break;
	case 'inicio':
		$controller->Inicio();
		break;
	case 'aflujo':
		$controller->AFlujo();
		break;
	case 'cflujo':
		$controller->CFlujo();
		break;
	case 'ccomp':
		$controller->CComp();
		break;
	case 'sfact':
		$controller->SFact();
		break;
	case 'ausers':
		$controller->AUsers();
		break;
	case 'perfil':
		$controller->Perfil();
		break;
	case 'salir':
		$controller->CSesion();
		break;
	case 'ausuario':
		$controller->AUsuarios();
		break;
	case 'pantalla1':
		$cat = $_GET['cat'];
		$controller->Pantalla1($cat);
		break;
	case 'lista_pedidos':
		$controller->Lista_Pedidos();
		break;
	case 'lista_t_pedidos':
		$controller->Lista_Pedidos_Todos();
		break;
	case 'documentodet':
		$doc = $_GET['doc'];
		$controller->DetalleDocumento($doc);
		break;
	case 'pedidodet':
		$doc = $_GET['doc'];
		$controller->DetallePedido($doc);
		break;
	case 'idDetalle':
		$idd = $GET_['idd'];
		$controller->DetalleId($idd);
		break;
	case 'pantalla2':
		$controller->Pantalla2();
		break;
	case 'imprimeTrans':
		$id = $_GET['id'];
		$doc = $_GET['doc'];
		$controller->ImprimeTrans($id, $doc);
		break;
	case 'pagos':
		$tipo = 'a';
		$controller->Pagos();
		break;
	case 'pendientes';
	    $controller->Pendientes();
	    break;
	case 'pedimento':
		$controller->Pedido();
		break;
	case 'eusuarios':
		$controller->EUsuarios();
		break;
	case 'pxr':
		$controller->Pxr();
		break;
	case 'aruta':
		$controller->ARuta();
		break;
	case 'arutaReparto':
		$controller->ARutaReparto();
		break;
	case 'arutaedomex':
		$controller->ARutaEdoMex();
		break;
	case 'ccompvent':
		$controller->CCompVent();
		break;
	case 'ordcomp':
		$controller->OrdComp();
		break;
	case 'preocAct':
		$costo=$_GET['costo'];
		$provedor=$_GET['provedor'];
		$provcostid=$_GET['provcostid'];
		$total=$_GET['total'];
		$nombreprovedor=$_GET['nombreprovedor'];
		$cantidad=$_GET['cantidad'];
		$rest=$_GET['rest'];
		$fe = $_GET['fe'];
		$controller->modificaPreOc($provcostid,$provedor,$costo,$total,$nombreprovedor,$cantidad,$rest,$fe);
		break;
	case 'actualizaCanti':
		$cantn=$_GET['cantnu'];
		$idpreoc=$_GET['idpreoc'];
		$idprov = $_GET['idprov'];
		$controller->actualizaCanti($cantn, $idpreoc, $idprov);
		break;
	case 'ordcompCat':
		$cat = $_GET['cat'];
		$controller->ordcomp1($cat);
	break;
	case 'preocVerificaProv':
		$provedor=$_GET['provedorr'];
		$controller->verificaPreOcProvedor($provedor);
		break;
	case 'verificaCveArt':
		$prod=$_GET['prod'];
		$controller->verificaArticulo($prod);
		break;
	case 'registrarPago':
        $controller->RegPago();
        break;	
    case 'verPago':
    	$controller->VerPago();
    	break;
	case 'altaunidades':
		$controller->altaunidades();
		break;
	case 'ordenes':
		$controller->ordenes();
		break;
	case 'detalleOC':
		$doco = $_GET['doco'];
		$controller->detalleOrdenCompra($doco);
		break;
	case 'IDPOR':
		$idd = $_GET['idd'];
		$controller->idpor($idd);
		break;
	case 'verpago':
		$controller->verpago1();
		break;
	case 'multipagos':
		$controller->Multipagos();
		break;
	case 'pxl': //ver pedidos por liberar
		$controller->PXL();
		break;
	case 'pagos_old':
		$controller->Pagos_OLD();
		break;
	case 'OCImp':
		$controller->OCIMP();
		break;
	case 'imprimeEfectivo':
		$id = $_GET['id'];
		$doc = $_GET['doc'];
		$controller->ImprimeEfectivo($id, $doc);
		break;
	case 'imprimeCheque':
		$id = $_GET['id'];
		$doc = $_GET['doc'];
		$controller->ImprimeCheque($id, $doc);
		break;
	case 'imprimeCredito':
		$id = $_GET['id'];
		$doc = $_GET['doc'];
		$controller->ImprimeCredito($id, $doc);
		break;
	case 'imprimeOC':
		$oc = $_GET['oc'];
		$controller->ImprimeOC($oc);
		break;
	case 'verRutaDF':
		$controller->verUniRuta();
		break;
	case 'verRutaEdoMex':
		$controller->verUniRutasEdoMex();
		break;
	case 'verUnidad':
		$unidad = $_GET['idu'];
		$controller->verUniRutas($unidad);
		break;
	case 'rutaunidad':
		$id = $_GET['id'];
		$controller->RutaUnidad();
		break;
	case 'funidades':
		$controller->FUnidades();
		break;
	case 'modificaUn':
		$unidad = $_GET['un'];
		$controller->ModificaUnidad($unidad);
		break;
	case 'adminruta':
		$controller->AdminRuta(); 
		break;
	case 'adminrutaRep':
		$controller->AdminRutaRep();
		break;
	case 'RutaUnidad':
		$idr = $_GET['idr'];
		if($idr == 23) $controller->AdmonUnidadForaneo($idr); // para mandar a llamar a las entregas foraneas, el parametro idr debe ser igual a 23 ya que esa es la unidad que tiene asignada la ruta 102, si el modulo falla es posible que sea por esa razón. 10.08.2016 ICA
			else $controller->AdmonUnidad($idr);
		break;
	case 'RutaUnidadRep':
		$idr = $_GET['idr'];
		if($idr == 23) $controller->AdmonUnidadForaneo($idr); // para mandar a llamar a las entregas foraneas, el parametro idr debe ser igual a 23 ya que esa es la unidad que tiene asignada la ruta 102, si el modulo falla es posible que sea por esa razón. 10.08.2016 ICA
			else $controller->AdmonUnidadRep($idr);
		break;
	case 'submenusec':
		$controller->SubMenuSecuencias();
		break;
	case 'submenusecRec':
		$controller->SubMenuSecuenciasRec();
		break;
	case 'SecUnidad':
		$unidad = $_GET['ids'];
		$controller->AsignaSecuencia($unidad);
		break;
	case 'SecUnidadRec':
		$unidad = $_GET['ids'];
		$controller->AsignaSecuenciaRec($unidad);
		break;
	case 'subfallidos':
		$controller->SubMenuFallidos();
		break;
	case 'fallido':
		$idf=$_GET['idf'];
		$controller->verFallidos($idf);
		break;
	case 'ocfallidas':
		$controller->ocFallidas();
		break;
	case 'verRutaDia':
		$controller->VerRutaDia();
		break;
	case 'subMenuRutaDia':
		$controller->SubMenuRutaDia();
		break;
	case 'rutaxUnidad':
		$idr=$_GET['idr'];
		$controller->RutaXUnidad($idr);
		break;
	case 'totales':						
		$controller->SubMenuTotales();
		break;
	case 'vertotales':
		$idf=$_GET['idf'];
		$controller->verTotales($idf);
		break;
	case 'pnoenrutar':						   
		$controller->SubMenuPnoenrutar();
		break;
	case 'verpnoenrutar':
		$idf=$_GET['idf'];
		$controller->verPnoEnrutar($idf);
		break;
	case 'reenrutar':							   
		$controller->SubMenuReEnrutar();
		break;
	case 'verreenrutar':
		$idf=$_GET['idf'];
		$controller->verReEnrutar($idf);
		break;
	case 'corrigeruta':
		$controller->CorrigeRuta();
		break;
	case 'consultarCotizacion':
            $cerradas =false;
            if(isset($_GET['cerradas'])){
                $cerradas = true;
            }
            $controller->consultarCotizaciones($cerradas);
            break;
    case 'consultaArticulo':
            $cliente = $_GET['clave'];
            $articulo = "";
            $descripcion = "";
            $folio = 0;
            $partida = "";
            if(isset($_GET['articulo'])){
                $articulo = $_GET['articulo'];
            } 
            if(isset($_GET['descripcion'])){
                $descripcion = $_GET['descripcion'];
            }
            if(isset($_GET['folio'])){
                $folio = $_GET['folio'];
            }
            if(isset($_GET['partida'])){
                $partida = $_GET['partida'];
            }
            $controller->consultarArticulo($cliente, $folio, $partida, $articulo, $descripcion);
            break;
    case 'verDetalleCotizacion':
    	$folio = $_GET['folio'];
    	$controller->verDetalleCotizacion($folio);
    	break;
    case 'quitarPartida':
        $folio = $_GET['folio'];
        $partida = $_GET['partida'];
        $controller->quitarPartida($folio, $partida);
        break;
    case 'cancelarCotizacion':
        $folio = $_GET['folio'];
        $controller->cancelaCotizacion($folio);                
        break;
    case 'cambiaCliente':
            $folio = $_GET['folio'];            
            $_SESSION['cotizacion_mover_cliente'] = true;
            $_SESSION['cotizacion_folio'] = $folio;
            $controller->consultarClientes('', '');
            break;
    case 'avanzaCotizacion':
            $folio = $_GET['folio'];
            $controller->avanzaCotizacion($folio);
            break;
    case 'verDetalleCotizacion':
    	$folio = $_GET['folio'];
    	$controller->verDetalleCotizacion($folio);
    	break;
    case 'recepciones':
    	$controller->verRecepciones();
    	break;
	case 'cmaestra':
    	$controller->ComprasMaestro();
    	break;
	case 'capturaproductos':
    	$controller->CapturaProductos();
    	break;	
	case 'nosuministrable':
		$id = $_GET['idpedido'];
		$controller->NoSuministrable($id);
		break;
	case 'VerNoSuministrableCompras':
		$controller->VerNoSuministrableCompras();
		break;
	case 'VerNoSuministrableVentas':
		$controller->VerNoSuministrableVentas();
	break;
	case 'modificarSuministrable':
		$status = $_GET['stat'];
		$id = $_GET['idpedido'];
		$controller->NoSuministrableV($id,$status);
		break;
	case 'imprecep':
	    $controller->ImprimeRecepV();
	    break;
	case 'Cat10':
	    $alm=$_GET['alm'];
		$controller->VerCat10($alm);
		break;
	case 'editProd':
		$id=$_GET['id'];
		$controller->editProd($id);
		break;
	case 'AMaterial':
		$controller->AsignaMaterial();
		break;
	case'embalar':
		$controller->Embalar();
		break;
	case 'RutasDelDia':
		$controller->VerRutasDelDia();
		break;
	case 'VerRecepcionesACancelar':
		$controller->VerRecepcionesAC();
		break;
	case 'OSRecepcion':
		$controller->VerOrdenesSR();
		break;
	case 'Cajas':
		$controller->Cajas();
                break; 
	case 'VerOrdenesAvanzar':
		$controller->VerOrdenesAA();  //orden AA
		break;
        case 'ProdRFC':
		$controller->VerProdRFC();
		break;
	case 'ResultDia':
		$controller->ResultDia();
		break;
	case 'cierreruta':
		$controller->CierreRuta();
		break;
	case 'cierrerutaRep':
		$controller->CierreRutaRep();
	case 'CierraRuta':
		$idr=$_GET['idr'];
		$controller->CierraRutaUnidad($idr);
		break;
	case 'CierraRutaRep':
		$idr=$_GET['idr'];
		$controller->CierraRutaUnidadRep($idr);
		break;
	case 'cierrerutagen':
		$controller->cierrerutagen();
		break;
    case 'ventVScobr':
        $charnodeseados = array("/","-");
        @$fechaini = str_replace($charnodeseados,".",$_GET['fechainicial']);
        @$fechafin = str_replace($charnodeseados,".",$_GET['fechafinal']);
        @$vend = $_GET['vendedor'];
        $controller->RVentasVsCobrado($fechaini, $fechafin, $vend);
        break;
    case 'Catalogo_Gastos':
        $controller->VerCatalogoGastos();
        break;
    case 'nuevogasto':
        $controller->NuevaCtaGasto();
        break;
    case 'imprimircatgastos':
        $controller->ImpCatalogoCuentas();
        break;
    case 'form_capturagastos':
        $controller->FormCapturaGasto();
        break;
    case 'verEntregas':
    	$controller->verEntregas();
            break;
    case'cierreReparto':
    	$controller->cierreReparto();
    	break;
    case'recibirMercancia':
    	$controller->recibirMercancia();
    	break;
    case 'verFacturas':
        	$controller->verFacturas();
        	break;
    case 'clasificacion_gastos':                #### Clasificación de gastos
        $controller->Clasificacion_gastos();
        break;
    case 'nuevaclagasto':
        $controller->NuevaClaGasto();
        break;
    case 'catalogo_documentos':
            $controller->CatalogoDocumentos();  //14062016
            break;
    case 'nuevo_documentoC':
            $controller->NuevoDocumentoC();
            break;
    case 'documentos_cliente':
            $controller->CatDocumentosXCliente();
            break;
    case 'documentosdelcliente':
            $clave = $_GET['clave'];
            $controller->VerDocumentosCliente($clave);
            break;  
    case'mercanciaRecibidaImp':                     //21062016
    	$controller->recibosMercanciaImp();
    	break;
    case 'subcartera_revision':             //2806
            $controller->SMCarteraRevision();
            break;
    case 'verCR':                           //2806
            $cr = $_GET['cr'];
            $controller->VarCartera($cr);
            break;
    case 'subcartera_revm10':   //3006  
            $controller->SMCarteraRev10();
            break;
    case 'verCR10':                           //3006
            $cr = $_GET['cr'];
            $controller->VarCartera10($cr);
            break;
        case 'ImprmirCarteraDia':
            $cr = $_GET['cr'];
            $controller->ImprimirCarteraDia($cr);
            break;
        case 'catCierreCr':      //07072016
            $cr=$_GET['cr'];
            $controller->catCierreCarteraR($cr);
            break;
        case 'SMCierreCartera':     //07072016
            $controller->SMCierreCartera();
            break;
        case 'SMCarteraCobranza':   //07072016
            $controller->SMCarteraCobranza();
            break;
        case 'catCobranza': //07072016
            $cc = $_GET['cc'];
            $controller->catCobranza($cc);
            break;
        case 'corteCredito':    //06072016
            $controller->catCorteCredito();
            break;
        case 'acuse_revision':
        	$controller->acuse_revision();
        	break;
        case 'FacturarRemision':
        	$controller->FacturarRemision();
        	break;
        case 'NCFactura':
        	$controller->NCFactura();
        	break;
       	case 'VerFacturasDeslinde':
       		$controller->VerFacturasDeslinde();
       	break;
       	case 'VerFacturasAcuse':
       		$controller->VerFacturasAcuse();
       	break;
        case 'CarteraCobranza':     //12062016
            $controller->verCarteraCobranza();
            break;
        case 'ContactosCliente':
            $cliente = $_GET['cliente'];
            $controller->ContactosCliente($cliente);
            break;
        case 'CarteraxCliente':
            $cve_maestro = $_GET['cve_maestro'];
            $controller->CarteraxCliente($cve_maestro);
            break;
        case 'PedidosAnticipados':
            $controller->PedidosAnticipados();
            break;
        case 'AnticipadosUrgencias':
            $controller->AnticipadosUrgencias();
            break;
        case 'submFacuracion':
        	$controller->SubMenuCxCC();
        	break;
        case 'facturashoy':
        	$controller->FacturacionDia();
        break;
        case 'facturasayer':
        	$controller->FacturacionAyer();
        break;
        case 'utilidadFacturas':
            $charnodeseados = array("-","/");
        	@$fechaini = str_replace($charnodeseados,".",$_GET['fechaini']);
        	@$fechafin = str_replace($charnodeseados,".",$_GET['fechafin']);
        	@$rango = $_GET['rangoutil'];
        	@$utilidad = $_GET['utilidad'];
            @$letras = $_GET['letras'];
            @$status = $_GET['status'];
        	$controller->utilidadFacturas($fechaini,$fechafin,$rango,$utilidad,$letras,$status);
        	break;
        case 'utilidadXfactura':
        	$fact = $_GET['fact'];
        	$controller->utilidadXFactura($fact);
        	break;
        case 'deslindecr':
        	$controller->deslindecr();
        	break;
        case 'RevConDosP':                      //05082016
                $cr=$_GET['cr'];
        	$controller->revConDosPasos($cr);
        	break;
        case 'RevSinDosP':                      //05082016
                $cr=$_GET['cr'];
        	$controller->revSinDosPasos($cr);
        	break;
        case 'DesRevConDosP':                   //05082016
                $cr=$_GET['cr'];            
            $controller->DeslindeRevConDosP($cr);
            break;
        case 'DesRevSinDosP':                   //05082016
                $cr=$_GET['cr'];
            $controller->DeslindeRevSinDosP($cr);
            break;
        case 'RevisionDosPasos':        //05082016
            $controller->SMRevisionDosPasos();
            break;
        case 'RevisionSinDosPasos':     //05082016
            $controller->SMSinRevisionDosPasos();
            break;
        case 'SMDesRevisionDosPasos':        //05082016
            $controller->SMDesRevisionDosPasos();
            break;
        case 'SMRevisionSinDosPasos':     //05082016
            $controller->SMDesSinRevisionDosPasos();
            break;
        case 'deslindeaduana':
        	$controller->deslindeaduana();
        	break;
        case 'BuscarCajasxPedido':
        	$controller->BuscarCajasxPedido();
        	break;
        case 'RecibirDocsRevision':
        	$controller->RecibirDocsRevision();
        	break;
        case 'CCobranza':
        	$controller->SMCCobranza();
        	break;
        case 'VerCobranza':
        	$cc=$_GET['cc'];
        	$controller->VerCobranza($cc);
        	break;
        case 'verCajasLogistica':
        	$controller->verCajasLogistica();
        	break;
        case 'VerLoteEnviar':
        	$controller->VerLoteEnviar();
        case 'VerInventarioEmpaque':
        	$controller->VerInventarioEmpaque();
        	break;
        case 'verPedidosPendientes':
        	$controller->verPedidosPendientes();
        	break;
        case 'pago_gastos':
            $controller->pagoGastos();
            break;
        case 'CancelarFactura':
        	$controller->CancelarFactura();
        	break;
        case 'UtilidadBaja':
        	$controller->UtilidadBaja();
        	break;
        case 'verSolicitudesUB':
        	$controller->verSolicitudesUB();
        	break;
         case 'verpago1':
        	$controller->verpago1();
        	break;
    	case 'listadoXautorizar':       	 
        	$controller->verXautorizar();
        	break;       	 
    	case 'listado_pagos_rechazados':
        	$controller->listadoRechazados();
        	break;
        case 'Cheques':
        	$controller->Cheques();
        	break;
		case 'pagos_ximprimir':
        	$controller->listadoPagosXImprimir();
        	break;
        case 'cancelarPedidos':
        	$controller->cancelarPedidos();
        	break;
        case 'listaClientes':
        	$controller->listaClientes();
        	break;
        case 'edocta_cuentasbancarias':
            $controller->listadoCuentasBancarias();
            break;
        case 'listadoXrecibir':       	 
        	$controller->verXrecibir();
        	break;       	             
    	case 'listadoXconciliar':       	 
        	$controller->verXconciliar();
        	break;
        case 'selectBanco':
        	$controller->selectBanco();
        	break;
        case 'edoCta':
        	$controller->listaCuentas();
        	break;
        case 'edoCta_docs':
        	$controller->listaCuentas_docs();
        	break;
        case 'buscaFactura':
        	$controller->buscaFactura();
        	break;
        case 'buscarCajaEmabalar':
        	$controller->buscarCajaEmabalar();
        	break;
        case 'filtrarCompras':
        	$controller->filtrarCompras();
        	break;
        case 'listadoCredito':
            $controller->verListadoPagosCredito();
            break;
        case 'listaOCAduana':
             $fecha = getdate();
             $mes = $fecha['mon'];
             $anio = $fecha['year'];
             $controller->verListadoOCAduana($mes, $anio);
             break;
        case 'verFallidas':
        	$controller->verFallidas();
        	break;
        case 'form_capruracrdirecto':
        	$controller->form_capruracrdirecto();
        	break;
        case 'verAplicaciones':
        	$controller->verAplicaciones();
        	break;
        case 'buscaPagosActivos':
        	$controller->buscaPagosActivos();
        	break;
        case 'IdvsComp':
        	$controller->IdvsComp();
        	break;
        case 'buscaValidacionOC':
        	$controller->buscaValidacionOC();
        	break;
        case 'verAplivsFact':
        	$controller->verAplivsFact();
        	break;
        case 'pagoContrarecibo':
             $controller->listarOCContrarecibos();
             break;
        case 'IngresoBodega':
        	if(isset($_GET['suministros'])){
        		//$suministros=base64_decode($_GET['suministros']);
        		$suministros= $_GET['suministros'];
        	}else{
        		$suministros = '0';
        	}
        	if(isset($_GET['ingresar'])){
        		$ingresar = $_GET['ingresar'];
        	}else{
        		$ingresar = 0;
        	}
        	if(isset($_GET['cantidad'])){
        		$cant = $_GET['cantidad'];
        	}else{
        		$cant = 0;
        	}

        	$controller->IngresoBodega($suministros, $ingresar, $cant);
        	break;
        case 'verIngresoBodega':
        	$controller->verIngresoBodega();
        	break;
       	case 'salidaAlmacen':
       		//$id = $_GET['id'];
       		$producto = $_GET['producto'];
       		$cantidad = $_GET['cant'];
       		$controller->salidaAlmacen($producto, $cantidad);
       		break;
        case 'regCargosFinancieros':
        	$controller->regCargosFinancieros();
        	break;
        case 'verCierreVal':
        	$controller->verCierreVal();
        	break;
        case 'asociaCF':
        	$controller->asociaCF();
        	break;
        case 'verPagosConSaldo':
        	$controller->verPagosConSaldo();
        	break;
        case 'verAcreedores':
        	$controller->verAcreedores();
        	break;
        case 'aplicaPagoDirecto':
        	$idp =$_GET['idp'];
        	$tipo =$_GET['tipo'];
        	$controller->aplicaPagoDirecto($idp, $tipo);
        	break;
        case 'estado_de_cuenta_mes':
        	$mes=$_GET['mes'];
        	$cuenta =$_GET['cuenta'];
        	$banco =$_GET['banco'];
        	$anio = $_GET['anio'];
        	$nvaFechComp=$_GET['nvaFechComp'];
        	//echo $mes;
        	//echo $cuenta;
        	//echo $banco; 
        	//echo $anio;
        	$controller->estado_de_cuenta_mes($mes, $banco, $cuenta, $anio, $nvaFechComp);
        	break;
        case 'ValidaRecepcionConFolio';
        	$docr = $_GET['docr'];
        	$doco = $_GET['doco'];
        	$fval = $_GET['fval'];
        	$controller->validaRecepcionConFolio($docr, $doco, $fval);
        break;
        case 'verValidaciones':
        	$doco = 'a';
        	$controller->verValidaciones($doco);
        break;
        case 'verSolicitudes':
        	$controller->verSolicitudes();
        break;
        case 'verPagoSolicitudes':
        	$controller->verPagoSolicitudes();
        break;
        case 'verCompras':
        	$controller->verCompras();
       	break;
        case 'verComprasRecibidas':
        	$controller->verComprasRecibidas();
       	break;
        case 'buscaPagos':
        	$controller->buscaPagos();
       	break;
        case 'pagoFacturas':
        	$idp = $_GET['idp'];
        	$controller->pagoFacturas($idp);
       	break;
       	case 'buscaContrarecibos':
       		$controller->buscaContrarecibos();
       	break;
       	case 'revAplicaciones':
       		$controller->revAplicaciones();
       		break;
       	case 'dirVerFacturas':
   			$mes = '';
   			$vend='';
   			$anio = '2016';
       		$controller->dirVerFacturas($mes, $vend, $anio);
       		break;
       	case 'buscaOC':
       		if(!isset($_GET['fechaedo'])){
       			$fechaedo = '01.01.2016';	
       		}else{
       			$fechaedo=$_GET['fechaedo'];	
       		}
       		$controller->buscaOC($fechaedo);
       		break;
       	case 'deudores':
       		$fechaedo = '01.01.2016';
       		$banco ='Bancomer';
       		$controller->deudores($fechaedo, $banco);
       		break;
       	case 'transfer':
       		$fechaedo ='01.01.2017';
       		$bancoO='Bancomer';
       		$controller->transfer($fechaedo, $bancoO);
       		break;
       	case 'facturapagomaestro':
       		$maestro=$_GET['maestro'];
       		$controller->facturapagomaestro($maestro);
       		break;
       	case 'verMaestros':
       		$controller->verMaestros();
       		break;
       	case 'nuevo_maestro':
       		$controller->nuevo_maestro();
       		break;
       	case 'buscaFacturas':
       		$controller->buscaFacturas();
       		break;
       	case 'recCierreCob':
       		$controller->recCierreCob();
       		break;
       	case 'utilerias':
       		$opcion = 0;
       		$docp = '';
       		$docf = '';
       		$docd = '';
       		$fechaIni='';
       		$fechaFin='';
       		$maestro = '';
       		$controller->utilerias($opcion, $docp, $docf, $docd, $fechaIni, $fechaFin, $maestro);
       		break;
       	case 'RecibirDocsRevision':
       		$contoller->RecibirDocsRevision();
       		break;
       	case 'SaldoVencido':
       		$controller->SaldoVencido();
       		break;
       	case 'verRecibidosCobranza':
       		$cc=$_GET['cc'];
       		$controller_cxc->verRecibidosCobranza($cc);
       		break;
       	case 'verRutasVigentes':
       		$controller_cxc->verRutasVigentes();
       		break;
       	case 'verPartidasRuta':
       		$idf=$_GET['folio'];
       		$controller_cxc->verPartidasRuta($idf);
       		break;
       	case 'verCxCRutas':
       		$controller_cxc->verCxCRutas();
       		break;
       	case 'verRutasFinalizadas':
       		$controller_cxc->verRutasFinalizadas();
       		break;
       	case 'verSolProdVentas':
       		$controller->verSolProdVentas();
       		break;
       	case 'verCategorias':
       		$controller->verCategorias();
       		break;
       	case 'verMarcas':
       		$controller_v->verMarcas();
       		break;
       	case 'catalogoProductosFTC':
       		$marca = '';
       		$categoria='';
       		$desc1 = '';
       		$generico = '';
       		$unidadmedida = '';
       		$prov1 = '';
       		$desc2 = '';
       		$descripcion = '';
       		if(!empty($_GET['marca'])){
       			$marca=$_GET['marca'];	
       		}
       		if(!empty($_GET['categoria'])){
       			$categoria=$_GET['categoria'];	
       		}
       		if(!empty($_GET['desc1'])){
       			$desc1=$_GET['desc1'];	
       		}
       		if(!empty($_GET['generico'])){
       			$generico=$_GET['generico'];	
       		}
       		if(!empty($_GET['prov1'])){
       			$prov1=$_GET['prov1'];	
       		}
       		if(!empty($_GET['desc2'])){
       			$desc2=$_GET['desc2'];	
       		}
       		if(!empty($_GET['unidadmedida'])){
       			$unidadmedida=$_GET['unidadmedida'];	
       		}
       		//$categoria=$_GET['categoria'];
       		//$desc1=$_GET['desc1'];
       		//$generico=$_GET['generico'];
       		//$um=$_GET['unidadmedida'];
       		//$prov1=$_GET['prov1'];
       		//$desc2=$_GET['desc2'];
       		echo 'Valor de la Marca : '.$marca.'<p>';
       		echo 'Valor prov1: '.$prov1.'<p>';
       		
       		$controller->catalogoProductosFTC($marca, $categoria, $desc1, $generico, $unidadmedida, $prov1, $desc2, $descripcion);
       		break;
       	case 'altaProductoFTC':
       		$marca = '';
       		$categoria='';
       		$desc1 = '';
       		$generico = '';
       		$unidadmedida = '';
       		$prov1 = '';
       		$desc2 = '';
       		if(!empty($_GET['marca'])){
       			$marca=$_GET['marca'];	
       		}
       		if(!empty($_GET['categoria'])){
       			$categoria=$_GET['categoria'];	
       		}
       		if(!empty($_GET['desc1'])){
       			$desc1=$_GET['desc1'];	
       		}
       		if(!empty($_GET['generico'])){
       			$generico=$_GET['generico'];	
       		}
       		if(!empty($_GET['prov1'])){
       			$prov1=$_GET['prov1'];	
       		}
       		if(!empty($_GET['desc2'])){
       			$desc2=$_GET['desc2'];	
       		}
       		if(!empty($_GET['unidadmedida'])){
       			$unidadmedida=$_GET['unidadmedida'];	
       		}
       		$controller->altaProductoFTC($marca, $categoria, $desc1, $generico, $unidadmedida, $prov1, $desc2);
       		break;
        case 'verCajasAlmacen':
        	$controller->verCajasAlmacen();
        	break;
        case 'verPedido':
        	$folio = $_GET['folio'];
        	$controller->verPedido($folio);
        	break;
        case 'verCatergoriasXMarcas':
        	$controller->verCatergoriasXMarcas();
        	break;
        case 'verCotPenLib':
		    	$controller->verCotPenLib();
		    	break;
		case 'verProveedores':
			$controller->verProveedores();
			break;
		case 'verOrdCompCesta':
			$controller->verOrdCompCesta();
			break;
		case 'verCestas':
			$controller->verCestas();
			break;
		case 'verCanasta':
			$idprov = $_GET['idprov'];
			$controller->verCanasta($idprov);
			break;
		case 'rechazarSol':
			$ids = $_GET['ids'];
			$controller->rechazarSol($ids);
			break;
		case 'verRechazos':
			$controller->verRechazos();
			break;
		case 'nuevo_cc':
			$cvem=$_GET['cvem'];
			$controller->nuevo_cc($cvem);
			break;
		case 'verCCC':
			$cvem=$_GET['cvem'];
			$idm=0;
			$controller->verCCC($idm, $cvem);
			break;
		case 'verDocumentosMaestro':
			$maestro=$_GET['maestro'];
			$controller->verDocumentosMaestro($maestro);
			break;
		case 'verDepositos':
			$controller->verDepositos();
			break;
		case 'verDepositos2':
			$banco = $_GET['banco'];
			$mes = '';
			$anio = '';
			$tipo = '';
			$controller->verDepositos2($banco, $mes, $anio, $tipo);
			break;
		case 'detalleMonto':
			$banco= $_GET['banco'];
			$mes = $_GET['mes'];
			$anio = $_GET['anio'];
			$tipo = $_GET['tipo'];
			$controller->verDepositos2($banco, $mes, $anio, $tipo);
			break;
		case 'verFolioFacturas':
			$mes='';
			$anio='';
			$tipo = '';
			$controller->verFolioFacturas($mes, $anio, $tipo);
			break;
		case 'detalleVenta':
			$tipo=$_GET['tipo'];
			$mes = $_GET['mes'];
			$anio = $_GET['anio'];
			$controller->verFolioFacturas($mes, $anio, $tipo);
			break;
		case 'verAcreedores2':
			$controller->verAcreedores2();
			break;
		case 'verFolio2015':
			$controller->verFolio2015();
			break;
		case 'verAplicaciones2':
			$anio='';
			$tipo='';
			$controller->verAplicaciones2($anio, $tipo);
			break;
		case 'editarMaestro':
			$idm =$_GET['idm'];
			$controller->editarMaestro($idm);
			break;
		case 'verAsociados':
			$cc = $_GET['cc'];
			if(isset($_GET['cliente'])){
				$clie=$_GET['cliente'];
			}else{
				$clie = '';
			}
			if(isset($_GET['cancela'])){
				$cancela =$_GET['cancela'];
			}else{
				$cancela = 0;
			}
			$controller->verAsociados($cc, $cancela, $clie);
			break;
		case 'detallePagoFactura':
			$docf=$_GET['docf'];
			$controller->detallePagoFactura($docf);
			break;
		case 'verHistorialPago':
			$ida =$_GET['ida'];
			$controller->verHistorialPago($ida);
			break;
		case 'verCPNoIdentificados':
			$controller->verCPNoIdentificados();
			break;
		case 'docsMaestro':
			$cvem = $_GET['cvem'];
			$controller->docsMaestro($cvem);
			break;
		case 'docsSucursal':
			$cvecl=$_GET['cvecl'];
			$controller->docsSucursal($cvecl);
			break;
		case 'capturaPagosConta':
			$banco = $_GET['banco'];
			$cuenta= $_GET['cuenta'];
			$controller->capturaPagosConta($banco, $cuenta);
			break;
		case 'verCargaPagosCXC':
			$controller_cxc->verCargaPagosCXC();
			break;
		case 'recCierreCob':
			$controller->recCierreCob();
			break;
		case 'SaldosxDocumento':
			$cliente = $_GET['cliente'];
			$controller->SaldosxDocumento($cliente);
			break;
		case 'verSolClientes':
			$controller->verSolClientes();
			break;
		case 'verClientesCorte':
			$controller->verClientesCorte();
			break;
		
		case 'datosCarteraCliente':
			$idCliente = $_GET['idcliente'];
    		$controller->formDataCobranzaC($idCliente);
			break;
		case 'verPreOC':
			$controller->verPreOC();
			break;
		case 'buscaOC2':
			$doco='a';
			$liberadas = false;
			$recepcionadas = false;
			$validadas = false;
			$controller->buscaOC2($doco, $liberadas, $recepcionadas, $validadas);
			break;
		case 'historiaIDPREOC':
			$id=$_GET['id'];
			$controller->historiaIDPREOC($id);
			break;
		case 'prepararmateriales':
			$docf =$_GET['docf'];
			$idcaja =$_GET['idcaja'];
			$controller->PreparaMaterial($docf, $idcaja);
			break;
		case 'editaPreoc':
			$idd=$_GET['idd'];
			$controller->editaPreoc($idd);
			break;
		case 'verFacturasCres':
			$controller->verFacturasCres();
			break;
		case 'verDeudores':
			$controller->verDeudores();
			break;
		case 'recepcionOC':
			$controller->recepcionOC();
			break;
		case 'recibirOC':
			$doco = $_GET['doco'];
			$tipo = $_GET['tipo'];
			$controller->recibirOC($doco, $tipo);
			break;
		case 'recepcionOCBdg':
			$controller->recepcionOCBdg();
			break;
		case 'impresionRecepcion':
			$doco  = 'a';
			$controller->impresionRecepcion($doco);
			break;
		case 'verRecepcionDeOrdenes':
			$controller->verRecepcionDeOrdenes();
			break;
		case 'valRecepcion':
			$doco =$_GET['doco'];
			$tipo = 'B';
			$controller->valRecepcion($doco,$tipo);
			break;
		case 'verRecepcionDeOrdenes':
			$controller->verRecepcionDeOrdenes();
			break;
		case 'liberaPendientes':
			$doco = $_GET['doco'];
			$id_preoc = $_GET['id_preoc'];
			$pxr =$_GET['pxr'];
			$par = $_GET['par'];
			$controller->liberaPendientes2($doco, $id_preoc, $pxr, $par); 
			break;
		case 'verSolCostos':
			$controller->verSolCostos();
			break;
		case 'ajustaPrecioLista':
			$ida=$_GET['ida'];
			$doco = $_GET['doco'];
			$par = $_GET['par'];
			$controller->ajustaPrecioLista($ida,$doco,$par);
			break;
		case 'recValConta':
			$controller->recValConta();
			break;
		case 'ImpValTes':
			$doco = $_GET['doco'];
			$folio= 24;
			$controller->ImpValTes($doco,$folio);
			break;
		case 'verHistorialSaldo':
			$prov = $_GET['prov'];
			$controller->verHistorialSaldo($prov);
			break;
		case 'editaFTCART':
			$ids = $_GET['ids'];
			@$cotizacion=$_GET['cotizacion'];
			@$vendedor = $_GET['vendedor'];
			$controller->editaFTCART($ids, $cotizacion, $vendedor);
			break;
		case 'guardaPOC':
			$idpoc = $_GET['idpoc'];
			$tipo = $_GET['tipo'];
			$controller->impPOC($idpoc,$tipo);
			break;
		case 'enviarPOCcorreo':
			$idpoc = $_GET['idpoc'];
			$correo = $_GET['correo'];
			$controller->enviarPOCcorreo($idpoc, $correo);
			break;
		case 'verOrdenesCompra':
			$controller->verOrdenesCompra();
			break;
		case 'guardaOC':
			$doco = $_GET['doco'];
			$tipo = $_GET['tipo'];
			$tipo2 = $_GET['tipo2'];
			$controller->imprimeOC_v2($doco, $tipo, $tipo2);
			break;
		case 'enviaCorreoOC':
			$doco = $_GET['doco'];
			$correo = $_GET['correo'];
			$controller->enviaCorreoOC($doco, $correo);
			break;
		case 'verSolProveedor':
			$controller->verSolProveedor();
			break;
		case 'verProductosLiberados':
			$controller->verProductosLiberados();
			break;
		case 'reporteRecibo':
			$controller->reporteRecibo();
			break;
		case 'verLayOut':
			$controller->verLayOut();
			break;
		case 'calculoComisiones':
			$anio = 0; 
			$mes = 0;
			$vendedor = 0;
			$controller->calculoComisiones($anio, $mes, $vendedor);
			break;
		case 'verRemisionesPendientes':
			$controller->verRemisionesPendientes();
			break;
		case 'detalleRemision':
			$docf=$_GET['docf'];
			$controller->detalleRemision($docf);
			break;
		case 'abrirCajaBodega':
			$controller->abrirCajaBodega();
			break;
		case 'verCajaAlmacen':
			$pedido = $_GET['pedido'];
			$controller->verCajaAlmacen($pedido);
			break;
		case 'buscaFacturaNC':
			if(isset($_GET['opcion'])){
				$opcion = $_GET['opcion'];
			}else{
				$opcion = 0;	
			}
			if(isset($_GET['docf'])){
				$docf = $_GET['docf'];
			}else{
				$docf = '';
			}
			$controller->buscaFacturaNC($opcion, $docf);
			break;
		case 'refacturaFecha':
			$docf=$_GET['docf'];
			$obs =$_GET['obs'];
			$tipo =$_GET['tipo'];
			echo 'Documento: '.$docf.' tipo: '.$tipo.' obs: '.$obs;
			$controller->refacturaFecha($docf);
		case 'verSolicitudesNC':
			$controller->verSolicitudesNC();
			break;
		case 'verDetSolNC':
			$id = $_GET['id'];
			$tipo = $_GET['tipo'];
			$factura = $_GET['factura'];
			$controller->verDetSolNC($id, $tipo, $factura);
			break;
		case 'asignacionesBodega':
			$controller->asignacionesBodega();
			break;
		case 'testsql':
				$controllerxml->testsql();
		break;
		case 'verMovInventario':
			$producto = $_GET['producto'];
			$controller->verMovInventario($producto);
			break;
		case 'recmercancianc':
			$id = $_GET['id'];
			$docf = $_GET['docf'];
			$controller->recmercancianc($id, $docf);
			break;
		case 'verRecepSinProcesar':
			$controller->verRecepSinProcesar();
			break;
		case 'verSolBodega':
			$controller->verSolBodega();
			break;
		case 'verValesBodega':
			$controller->verValesBodega();
			break;
		case 'verInventarioBodega':
			$controller->verInventarioBodega();
			break;
		case 'invPatio':
			$controller->invPatio();
			break;
		case 'verValesPatio':
			$controller->verValesPatio();
			break;
		case 'nuevaOrdenInterna':
			$controller->nuevaOrdenInterna();
			break;
		case 'verOCI':
			$controller->verOCI();
			break;
		case 'verRecepDev':
			$controller->verRecepDev();
			break;
		default:
		header('Location: index.php?action=login');
		break;
	}

}
?>