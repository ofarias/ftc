<?php
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/model/pegaso.model.ventas.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/controller/pegaso.controller.ventas.php');
require_once('app/model/database.xmlTools.php');
require_once('app/model/verificaID.php');
require_once('app/model/db.contabilidad.php');
require_once 'app/model/pegasoqr.php';
require_once('app/model/pegaso.model.recoleccion.php');
require_once('app/model/pegaso.model.cxc.php');
require_once('app/model/facturacion.php');

class controller_coi{
	var $contexto_local = "http://SERVIDOR:8081/pegasoFTC/app/";
	var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	function load_template2($title='Escaneo de Documentos Logistica'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header2.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
	private function load_page($page){
	return file_get_contents($page);
	}
	private function view_page($html){
	echo $html;
	}
	private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
	return preg_replace($in, $out, $pagina);	 	
	}

	function creaParam($cliente, $partidas, $ide){
		$data_coi = new CoiDAO;
		$data = new pegaso;
		if($_SESSION['user']){
			//$pagina =$this->load_template2('Pedidos');
			$crea=$data_coi->creaParam($cliente, $partidas);
			if($crea['status'] == 'ok'){
				$actualiza = $data->actualizaCuentaCliente($cliente, $partidas, $ide);	
			}
 			//$html=$this->load_page('app/views/modules/Logistica/m.IndexRec.php');
   			ob_start();
   			//include 'app/views/modules/Logistica/m.IndexRec.php';
   			//$table = ob_get_clean();
   			//$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			//$this->view_page($pagina);
   			return $crea;
		}
	}

	function creaPoliza($tipo, $uuid, $ide){
		$data_coi= new CoiDAO;
		$data = new pegaso;
		if($_SESSION['user']){
			$cabecera=$data->cabeceraPoliza($uuid, $ide);
			$detalle=$data->detallePoliza($uuid, $ide);
			$impuestos =$data->impuestosPoliza($uuid);
			//echo 'Cabecera: '.$cabecera.' Detalle: '.$detalle;
			if($cabecera == 'error' or $detalle == 'error'){
				if($cabecera == 'error'){
					$error = "Cabecera";	
				}elseif($detalle == 'error'){
					$error ='Detalle';
				}
				$crea=array("status"=>'no', "mensaje"=>'ocurrio un error al cargar el catalogo de cuentas en '.$error.' del documento, favor de revisar o reportar a sistemas');
			}else{
				$crea=$data_coi->creaPoliza($tipo, $uuid, $cabecera, $detalle, $impuestos);	
				if($crea['status']='ok'){
					$actXml=$data->actXml($uuid, $tipo, $crea);
				}
			}
			return $crea;
		}
	}

	function verPolizas($uuid){
		if($_SESSION['user']){
			$data_coi = new CoiDAO;
			$data = new pegaso;
			$pagina = $this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.verPolizas.php');
  			ob_start();
  			$cabecera=$data->cabeceraDocumento($uuid);
			$documento=$data->verPolizas($uuid);
			$polizas=$data_coi->traePoliza($documento);
			$param=$data_coi->traeParametros();
			$user=$_SESSION['user']->NOMBRE;
  			include 'app/views/pages/xml/p.verPolizas.php';
  			$table = ob_get_clean();
  			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table, $pagina);
  			$this->view_page($pagina);
		}
	}

	function verBancos($t){
		if($_SESSION['user']){
			$data_coi = new CoiDAO;
			$data = new pegaso;
			$pagina = $this->load_template();
			$html=$this->load_page('app/views/pages/Contabilidad/p.verBancos.php');
  			ob_start();
  			$info=$data->verBancos($idb=0);
			$user=$_SESSION['user']->NOMBRE;
  			$ban =$data->traeBancoSat();
  			if($t == 'pol'){
  				$bancos=array();
  				$ln=0;
  				foreach ($info as $k) {
  					$bancos[]=($k->ID.':'.$k->NUM_CUENTA.':'.$k->BANCO.':'.$k->RFC.':'.$k->MONEDA.':'.$k->TIPO.':'.$k->CTA_CONTAB);
  					$ln++;
  				}
  				return $bancos;
  			}
  			include 'app/views/pages/Contabilidad/p.verBancos.php';
  			$table = ob_get_clean();
  			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table, $pagina);
  			$this->view_page($pagina);	
		}
	}

	function editBanco($idb){
		if($_SESSION['user']){
			$data = new pegaso;
			$pagina = $this->load_template();
			$html=$this->load_page('app/views/pages/Contabilidad/p.editBanco.php');
  			ob_start();
  			$info=$data->verBancos($idb);
			$user=$_SESSION['user']->NOMBRE;
  			include 'app/views/pages/Contabilidad/p.editBanco.php';
  			$table = ob_get_clean();
  			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table, $pagina);
  			$this->view_page($pagina);		
		}
	}

	function editaBanco($idb, $si, $cuenta, $dia, $cc, $tipo){
		if($_SESSION['user']){
			$data=new pegaso;
			$exec=$data->editaBanco($idb, $si, $cuenta, $dia, $cc, $tipo);
			$this->editBanco($idb);
		}
	}

	function insertaBanco($banco, $cuenta, $tipo, $moneda, $saldo, $fecha, $observaciones){
		if($_SESSION['user']){
			$data= new pegaso;
			$exec=$data->insertaBanco($banco, $cuenta, $tipo, $moneda, $saldo, $fecha, $observaciones);
			return $exec;
		}
	}

	function traeCuentasContables($buscar){
		$data_coi= new CoiDAO;
        $exec = $data_coi->traeCuentasContables($buscar);
        return $exec;
	}

	function cuentasImp(){
		if($_SESSION['user']){
			$data = new CoiDAO;
			$pagina = $this->load_template();
			$html=$this->load_page('app/views/pages/Contabilidad/p.editCuentaImp.php');
  			ob_start();
  			$info=$data->verCuentasImp();
			$user=$_SESSION['user']->NOMBRE;
  			include 'app/views/pages/Contabilidad/p.editCuentaImp.php';
  			$table = ob_get_clean();
  			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table, $pagina);
  			$this->view_page($pagina);		
		}
	}

	function actCuentaImp($idc,$ncta){
		if($_SESSION['user']){
			$data=new CoiDAO;
			$res=$data->actCuentaImp($idc, $ncta);
			return $res;
		}
	}

	function polizaFinal($uuid, $tipo, $idp, $tipoXML){
		if($_SESSION['user']){
			$data = new pegaso;
			$data_coi= new CoiDAO;
			$u = "'".$uuid."'";
			$impuestos2=$data->impuestosPolizaFinal($u);
			$infoPoliza=$data->traePago($idp, $tipo);
			$pol = $data->cabeceraDocumento($uuid);
			$res=$data_coi->polizaFinal($uuid, $tipo, $idp, $infoPoliza, $impuestos2, $tipoXML, $pol);
			if($res['status'] == 'ok'){
				$xmlPol=$data->actXml($uuid, $tipo=$res['tipo'], $res);
			}
			return $res;
		}
	}

	function sadPol($uuid, $tipo){
		if($_SESSION['user']){
			$data= new CoiDAO;
			$res=$data->sadPol($uuid, $tipo);
			if($res['status']=='ok'){
				$data_p= new pegaso;
				$actUUID=$data_p->actualizaUUID($res);
			}
			return $res;
		}
	}

	function contabiliza($tipo , $idp, $z){
		if($_SESSION['user']){
			$data= new pegaso;
			$data_coi = new CoiDAO;
			$cabecera = $data->detalleGasto($idp, $tip='z');
			$detalle = $data->aplicacionesGasto($idp, $t='c');
			$impuestos2=$data->impuestosPolizaFinal($uuid=$detalle['uuid']);
			$crear = $data_coi->creaPolizaGasto($cabecera , $detalle=$detalle['datos'], $tipo, $impuestos2, $z);
			if($crear['status'] == 'ok' ){
				$act=$data->actGasto($crear, $detalle, $idp);
			}
		}
	}

	function consolidaPolizas($mes, $anio, $ide, $doc){
		if($_SESSION['user']){
			$data= new pegaso;
			$datacoi = new CoiDAO;
			$polizas=$datacoi->traePolizas($mes, $anio, $ide);
			$consolida = $data->consolidaPolizas($mes, $anio, $ide, $polizas);
			// Obtenermos la informacion de las polizas por fecha de la tabla de xml_polizas basados en la fecha y tipo
			//$this->query="SELECT * FROM XML_POLIZAS WHERE PERIODO = $mes and EJERCICIO = $anio and status = 'A'";
			return $consolida;
		}
	}

	function borraCuenta($idImp, $opcion){
		if($_SESSION['user']){
			$data = new CoiDAO;
			$res=$data->borraCuenta($idImp, $opcion);
			return $res;
		}
	}

	function grabaImp($imp, $cccoi, $tipo , $tasa, $uso, $nombre, $factor, $aplica, $status){
		if($_SESSION['user']){
			$data= new CoiDAO;
			$res=$data->grabaImp($imp, $cccoi, $tipo , $tasa, $uso, $nombre, $factor, $aplica, $status);
			$redireccionar = 'cuentasImp';			
			$html = $this->load_page('app/views/pages/Contabilidad/p.redirectform.php');
				ob_start();
				include 'app/views/pages/Contabilidad/p.redirectform.php';
			return ;
		}
	}

	function contabilizaIg($idp, $y, $tipo){
		if($_SESSION['user']){
			$data= new pegasoCobranza;
			$data2 = new pegaso;
			$data_coi = new CoiDAO;
			$pago = $data->traePago($idp);
			if(!empty($pago)){
				$detalle= $data->traeAplicaciones($idp);
				$uuid= '';
				$por = '';
			    foreach ($detalle as $u){
			        $uuid .= "'".$u->OBSERVACIONES."',";
			        $por .= $u->PORC.","; 
			    }
			    $uuid= substr($uuid,0,-1);
			    $por = substr($por, 0,-1);
				//$impuestos= $data2->impuestosPolizaFinal($uuid);
				$impuestos= $data2->impuestosPolizaFinalDetImp($uuid, $por);
				//$creaPoliza=$data_coi->creaPolizaIg($pago, $detalle, $tipo = 'Ingreso', $impuestos, $y);
				$creaPoliza=$data_coi->creaPolizaIgDetImp($pago, $detalle, $tipo = 'Ingreso', $impuestos, $y);
				if($creaPoliza['status']=='ok'){
					$actualiza=$data2->actXmlMtl($uuid, $tipo, $creaPoliza, $idp);
				}		
			}else{
				echo 'Ya se ha contabilizado este pago.';
			}
			//if($creaPoliza['status']=='ok'){
//
//			//}else{
//
			//}
		}
	}

}?>

