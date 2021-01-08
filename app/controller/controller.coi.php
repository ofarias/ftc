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
require_once ('app/Classes/PHPExcel.php');

class controller_coi{
	var $contexto_local = "http://SERVIDOR:8081/pegasoFTC/app/";
	var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	
	function nombreMes($mes){
		switch ($mes) {
			case 1:
				$nombre = 'Enero';
				break;
			case 2:
				$nombre = 'Febrero';
				break;
			case 3:
				$nombre = 'Marzo';
				break;
			case 4:
				$nombre = 'Abril';
				break;
			case 5:
				$nombre = 'Mayo';
				break;
			case 6:
				$nombre = 'Junio';
				break;
			case 7:
				$nombre = 'Julio';
				break;
			case 8:
				$nombre = 'Agosto';
				break;
			case 9:
				$nombre = 'Septiembre';
				break;
			case 10:
				$nombre = 'Octubre';
				break;
			case 11:
				$nombre = 'Noviembre';
				break;
			case 12:
				$nombre = 'Diciembre';
				break;
			default:
				$nombre ='Desconocido';
				break;
		}
		return $nombre;
	}

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
			//var_dump($impuestos);
			//exit();
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

	function traeCuentasContables($buscar, $anio){
		$data_coi= new CoiDAO;
		$exec=$data_coi->traeCuentasContables($buscar, $anio);
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

	function contabiliza($tipo , $idp, $z, $obs, $tp){
		if($_SESSION['user']){
			$data= new pegaso;
			$data_coi = new CoiDAO;
			$cabecera = $data->detalleGasto($idp, $tip='z', $obs);
			$detalle = $data->aplicacionesGasto($idp, $t='c');
			$impuestos2=$data->impuestosPolizaFinalDetImp($uuid=$detalle['uuid'], $por=$detalle['por']); // $impuestos= $data2->impuestosPolizaFinalDetImp($uuid, $por);
			$crear = $data_coi->creaPolizaGasto($cabecera , $detalle=$detalle['datos'], $tipo, $impuestos2, $z, $tp);
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

	function contabilizaIg($idp, $y, $tipo, $obs, $tp){
		if($_SESSION['user']){
			$data= new pegasoCobranza;
			$data2 = new pegaso;
			$data_coi = new CoiDAO;
			$pago = $data->traePago($idp, $obs);/// Pendiente
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
				$creaPoliza=$data_coi->creaPolizaIgDetImp($pago, $detalle, $tipo = 'Ingreso', $impuestos, $y, $tp);
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

	function acmd($mes, $anio){
		if($_SESSION['user']){
			$data_coi= new CoiDAO;
			$data= new pegaso;
			$acmd_coi=$data_coi->acmd($mes, $anio);
			$acmd_ftc=$data->acmd_xml($acmd_coi);
			return $acmd_ftc;
		}
	}

	function upl_param($file, $x, $eje){
		if($_SESSION['user']){
			$data= new CoiDAO;
			$act = $data->upl_param($file, $x, $eje);
			echo $act['m'];
			return $act;
			
		}
	}

	function validaPol($pol, $e, $per, $cta){
		if ($_SESSION['user']) {
			$data = new CoiDAO;
			$data_coi = new CoiDAO;
			$info = $data->traeinfo($pol, $e, $per, $cta);
		}
	}

	function tipoDoc($uuid, $tipo){
		if ($_SESSION['user']) {
			$data = new pegaso;
			$tipo = $data->tipoDoc($uuid, $tipo);
			return $tipo;
		}
	}

	function creaCC($uuid, $papa){
		if($_SESSION['user']){
			$data_coi = new CoiDAO;
			$data = new pegaso;
  			$info=$data->cabeceraDocumento($uuid);
  			$res=$data_coi->creaCC($info, $papa);
  			return $res;
		}
	}

	function edoXls($a, $m, $b, $c, $t, $v){
		if($_SESSION['user']){
			$data = new pegaso;
			$xls= new PHPExcel();
			$nom_mes = $this->nombreMes($m);
			$exec = $data->estado_de_cuenta_mes_docs($m, $b, $c, $a, $t);;
			$ln=9; 
			$i=0;
			$ta = 0; $tc = 0; $tp = 0; $pd=0; $mc=0; $dep=0; $cgs=0;
			foreach ($exec as $k){
				$cl = 'A';
				$i++;
				$ln++;
				$xls->setActiveSheetIndex()
	                ->setCellValue($cl.$ln,$i)
	                ->setCellValue(++$cl.$ln, $k->TIPO)
	                ->setCellValue(++$cl.$ln, $k->CONSECUTIVO)
	                ->setCellValue(++$cl.$ln, substr($k->FECHAMOV, 0 , 10 ))
	                ->setCellValue(++$cl.$ln, '$ '.number_format($k->ABONO))
	                ->setCellValue(++$cl.$ln, '$ '.number_format($k->CARGO))
	                ->setCellValue(++$cl.$ln, '$ '.number_format($k->SALDO))
	                ->setCellValue(++$cl.$ln, $k->USUARIO)
	                ->setCellValue(++$cl.$ln, $k->CONTABILIZADO)
	                ->setCellValue(++$cl.$ln, $k->CEP)
	        	;	
	        	$ta = $ta + $k->ABONO; $tc = $tc + $k->CARGO; $tp= $tp + $k->SALDO; 
	        	if(empty($k->CONTABILIZADO)){
	        		$pd++;
	        	}else{
	        		$mc++;
	        	}
	        	if($k->ABONO>0){$dep++;}
	        	if($k->CARGO>0){$cgs++;}
	       		
			}
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
			$col = 'A';
	        $xls->getActiveSheet()->getColumnDimension($col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);

	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $lin=9;
	        $col = 'A';
	        $xls->getActiveSheet()
	            ->setCellValue($col.$lin,'Ln')
	            ->setCellValue(++$col.$lin,'Tipo')
	            ->setCellValue(++$col.$lin,'Folio')
	            ->setCellValue(++$col.$lin,'Fecha de Registro')
	            ->setCellValue(++$col.$lin,'Deposito')
	            ->setCellValue(++$col.$lin,'Retiro')
	            ->setCellValue(++$col.$lin,'por conciliar / aplicar')
	            ->setCellValue(++$col.$lin,'Usuario Registra')
	            ->setCellValue(++$col.$lin,'Poliza')
	            ->setCellValue(++$col.$lin,'Comprobante')
	        ;

	        $df= $data->traeDF($idem = 1);
	        $xls->setActiveSheetIndex()
	        	->setCellValue('A1', $df->RAZON_SOCIAL)
	        	->setCellValue('A2', 'Banco: ')
	        	->setCellValue('C2', $b)
				->setCellValue('A3', 'Cuenta: ')
	        	->setCellValue('C3', $c)
	        	->setCellValue('A4', 'Periodo')
	        	->setCellValue('C4', $m.'/'.$a)
	        	->setCellValue('A5', 'Depositos ('.$dep.'): ')
	        	->setCellValue('C5', '$ '.number_format($ta,2))
	        	->setCellValue('A6', 'Retiros ('.$cgs.'): ')
	        	->setCellValue('C6', '$ '.number_format($tc,2))
	        	->setCellValue('A7', 'Total de Movimientos: ')
	        	->setCellValue('C7', $i)
	        	->setCellValue('D7', 'Movimientos Contabilizados: ')
	        	->setCellValue('E7', $mc)
	        	->setCellValue('F7', 'Movimientos Pendientes: ')
	        	->setCellValue('G7', $pd)
	        	->setCellValue('A8', 'Pendiente por Conciliar: ')
	        	->setCellValue('C8', '$ '.number_format($tp,2))
	        ;

	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:K1');
	        $xls->getActiveSheet()->mergeCells('A2:B2');
	        $xls->getActiveSheet()->mergeCells('A3:B3');
	        $xls->getActiveSheet()->mergeCells('A4:B4');
	        $xls->getActiveSheet()->mergeCells('A5:B5');
	        $xls->getActiveSheet()->mergeCells('A6:B6');
	        $xls->getActiveSheet()->mergeCells('A7:B7');
	        $xls->getActiveSheet()->mergeCells('A8:B8');


	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando

	        $xls->getActiveSheet()->getStyle('F10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	        //// Bordes
	        ///$xls->getActiveSheet()->getStyle('A3:D3')->applyFromArray(
	        ///    array(
	        ///        'font'=> array(
	        ///            'bold'=>true
	        ///        ),
	        ///        'borders'=>array(
	        ///            'allborders'=>array(
	        ///                'style'=>PHPExcel_Style_Border::BORDER_THIN
	        ///            )
	        ///        )
	        ///    )
	        ///);

	        /// Colores
			$a=10;
	        foreach ($exec as $kc){
	        	if(empty($kc->CONTABILIZADO)){
	        		$xls->getActiveSheet()->getStyle('A'.$a.':J'.$a)->getFill()->applyFromArray(
	            			array(
	                			'font'=> array(
	                			    'bold'=>true
	                			),
	                			'borders'=>array(
	                			    'allborders'=>array(
	                			        'style'=>PHPExcel_Style_Border::BORDER_THIN
	                			    )
	                			), 
	                			'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        					'startcolor' => array(
	        					     'rgb' => 'FFF7C6'
	        					)
	            			)
	        			);
	        	}	
	        	$a++;
	        }

	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            $nom='Estado de Cuenta '.$b.' de '.$c.' '.$nom_mes.'-'.$a.'_'.date('h_i_s').'.xlsx';
	            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	            //header("Content-Disposition: attachment;filename=01simple.xlsx");
	            //header('Cache-Control: max-age=0');
	        /// escribimos el resultado en el archivo;
	            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
	        /// salida a descargar
	            $x->save($ruta.$nom);
	            ob_end_clean();
	           // $x->save('php://output');
	        /// salida a ruta :
	        return array("status"=>'ok', "archivo"=>$nom, "ruta"=>$ruta.$nom);

		}

	}

	function tipoPoliza(){
		if($_SESSION['user']){
			$data_coi = new CoiDAO;
			$pagina = $this->load_template();
			$html=$this->load_page('app/views/pages/Contabilidad/p.tipoPoliza.php');
  			ob_start();
  			$info=$data_coi->tipoPoliza();
  			$admper=$data_coi->admPer($info);
			$user=$_SESSION['user']->NOMBRE;
  			include 'app/views/pages/Contabilidad/p.tipoPoliza.php';
  			$table = ob_get_clean();
  			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table, $pagina);
  			$this->view_page($pagina);		
		}
	}
}?>

