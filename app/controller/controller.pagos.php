
<?php
require_once('app/model/model.pagos.php');
require_once('app/fpdf/fpdf.php');
require ('app/dompdf/autoload.inc.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/Classes/PHPExcel.php');

use Dompdf\Dompdf;

class ctrl_pago{
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
				$nombre ='';
				break;
		}
		return $nombre;
	}

	function detallePago($uuid){
		if($_SESSION['user']){
			$data = new pagos;
			$res=$data->detallePago($uuid);
			return $res;
		}else{

		}
	}

	function xmlExcel($mes, $anio, $ide, $doc, $t){
		if($_SESSION['user']){
				$res=$this->reporteXLS($mes, $anio, $ide, $doc, $t);
		}
		return $res;
	}

	function reporteXLS($mes, $anio, $ide, $doc, $t){
		$data = new pagos;
		$xls= new PHPExcel();
	        //// insertamos datos a al objeto excel.
	        // Fecha inicio y fecha fin
	        $df= $data->traeDF($idem = 1);
	        $usuario =$_SESSION['user']->NOMBRE;
	        $fecha = date('d-m-Y h:i:s');
	        $ln = 11;
	        $pagos=$data->infoPagos($mes, $anio, $ide, $uuid=false, $doc);
			$partidas = $data->partidasPagos($mes, $anio, $ide, $uuid=false, $doc);
			switch ($doc) {
	        	case 'I':
	        		$doc = 'Ingreso';
	        		break;
	        	case 'E':
	        		$doc = 'Egreso';
	        		break;
	        	case 'P':
	        		$doc = 'Pago';
	        		break;
	        	default:
	        		$doc = $doc;
	        		break;
	        }
	        //print_r($documentos);
	        $totalSaldo=0;
	        $i=0;
	        $l_g = 0;
	        $l_h = 0;
	        foreach ($pagos as $pago) {
	            $i++;
	            /*
				if($l_g < strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE)) ){
	            	$l_g = strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE));
	            }
	            if($l_h < strlen('('.$key->RFCE.')'.$key->EMISOR)){
	            	$l_h = strlen('('.$key->RFCE.')'.$key->EMISOR);
	            }
				*/
	            $status = $pago->STATUS != 'C'? 'Vigente':'Cancelado';
	            $Columna='A';
	            $xls->setActiveSheetIndex()
	                ->setCellValue($Columna.$ln,$i)
	                ->setCellValue(++$Columna.$ln,$pago->STATUS)
	                ->setCellValue(++$Columna.$ln, utf8_encode($pago->RFCE))
	                ->setCellValue(++$Columna.$ln, utf8_encode($pago->CLIENTE))
					->setCellValue(++$Columna.$ln,$pago->UUID)
	                ->setCellValue(++$Columna.$ln,$pago->VERSION_CFDI)
	                ->setCellValue(++$Columna.$ln,$pago->DOCUMENTO)
	                ->setCellValue(++$Columna.$ln,$pago->FECHA)
					->setCellValue(++$Columna.$ln,$pago->MONTO)
					->setCellValue(++$Columna.$ln,$pago->TIPO)
	                ->setCellValue(++$Columna.$ln,$pago->MONEDA_PAGO)
	                ->setCellValue(++$Columna.$ln,$pago->FORMA)
	                ->setCellValue(++$Columna.$ln,$pago->DOCUMENTOS)
	                ->setCellValue(++$Columna.$ln,$pago->NUMOPERACION)
	                ->setCellValue(++$Columna.$ln,$pago->RFC_BANCO_ORDENANTE)
	                ->setCellValue(++$Columna.$ln,$pago->CTA_ORDENANTE)
	                ->setCellValue(++$Columna.$ln,$pago->RFC_BANCO_BENEFICIARIO)
	                ->setCellValue(++$Columna.$ln,$pago->CTA_BENEFICIARIO)
	                ;
				$xls->getActiveSheet()->getStyle("A".$ln.":".$Columna.$ln)->applyFromArray(
					array(
							'font'=> array(
								'bold'=>true
							),
							'borders'=>array(
								'allborders'=>array(
									'style'=>PHPExcel_Style_Border::BORDER_THIN
								)
							),
							'fill'=>array( 
								'type' => PHPExcel_Style_Fill::FILL_SOLID,             
								'color'=> array('rgb' => 'c3faff')
							)   
						)	   
				);
	            $ln++;
				$detalles=$data->infoPagosDetalle($pago->UUID);
				$p=0;
					foreach($detalles as $detalle){
						$Columna = 'C'; $p++;
						$xls->setActiveSheetIndex()
							->setCellValue($Columna.$ln,$p)
							->setCellValue(++$Columna.$ln,$detalle->SER)
							->setCellValue(++$Columna.$ln, utf8_encode($detalle->FOL))
							->setCellValue(++$Columna.$ln, utf8_encode($detalle->MONEDA))
							->setCellValue(++$Columna.$ln,$detalle->METODO_PAGO)
							->setCellValue(++$Columna.$ln,$detalle->NUM_PARCIALIDAD)
							->setCellValue(++$Columna.$ln,$detalle->SALDO)
							->setCellValue(++$Columna.$ln,$detalle->PAGO)
							->setCellValue(++$Columna.$ln,$detalle->SALDO_INSOLUTO)
							->setCellValue(++$Columna.$ln,$detalle->ID_DOCUMENTO)
							->setCellValue(++$Columna.$ln,$detalle->TIPO_CAMBIO)
							->setCellValue(++$Columna.$ln,$detalle->FECHA_DOC)
							->setCellValue(++$Columna.$ln,$pago->FECHA)
						;
						$ln++;
						$xls->getActiveSheet()->getStyle("C".($ln-1).':'.$Columna.($ln-1))->applyFromArray(
							array(
									'font'=> array(
										'bold'=>true
									),
									'borders'=>array(
										'allborders'=>array(
											'style'=>PHPExcel_Style_Border::BORDER_THIN
										)
									), 
									'fill'=>array( 
											'type' => PHPExcel_Style_Fill::FILL_SOLID,             
											'color'=> array('rgb' => 'ffffc3')
									)   
								)
						);	
					}
					unset($detalle);

	        }
			$xls->getActiveSheet()->setTitle('Comprobantes');
	        $ln++;
	        $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,'Fin del resumen de documentos.');
	                //->setCellValue('B'.$ln,'')
	                //->setCellValue('C'.$ln,'$ '.number_format($key->SALDOFINAL-$key->IMP_TOT4,2))
	                //->setCellValue('D'.$ln,'$ '.number_format($key->IMP_TOT4,2))
	                //->setCellValue('E'.$ln,'$ '.number_format($key->IMPORTE,2))
	                //->setCellValue('F'.$ln,'$ '.number_format($key->SALDO,2))
	                //->setCellValue('G'.$ln,$key->FECHA_INI_COB)
	                //->setCellValue('H'.$ln,$key->CVE_PEDI)
	                //->setCellValue('I'.$ln,$key->OC);
	        /// 
	            $xls->getActiveSheet()
	                ->setCellValue('A1',$df->RAZON_SOCIAL);
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
			$Columna = 'A';
	        $xls->getActiveSheet()->getColumnDimension($Columna)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(45);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(45);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(7);
			$xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(19);
			$xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(17);
			$xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(17);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(17);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(7);
	        $xls->getActiveSheet()->getColumnDimension(++$Columna)->setWidth(7);

	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
			$Columna='A';
	        $xls->getActiveSheet()
	            ->setCellValue($Columna.'9','Ln')
	            ->setCellValue(++$Columna.'9','Estado')
	            ->setCellValue(++$Columna.'9','Emisor')
	            ->setCellValue(++$Columna.'9','Receptor')
	            ->setCellValue(++$Columna.'9','UUID')
	            ->setCellValue(++$Columna.'9','Version')
				->setCellValue(++$Columna.'9','Documento')
				->setCellValue(++$Columna.'9','Fecha Pago')
	            ->setCellValue(++$Columna.'9','Monto Pago')
	            ->setCellValue(++$Columna.'9','Tipo de cambio')
	            ->setCellValue(++$Columna.'9','Moneda')
				->setCellValue(++$Columna.'9','FORMA PAGO')
	            ->setCellValue(++$Columna.'9','Documentos')
	            ->setCellValue(++$Columna.'9','Numero de Operacion')
	            ->setCellValue(++$Columna.'9','RCF Banco Ordenante')
	            ->setCellValue(++$Columna.'9','Cuenta Ordenante')
	            ->setCellValue(++$Columna.'9','RFC Banco Beneficiario')
	            ->setCellValue(++$Columna.'9','Cuenta Beneficiario')
	        ;
			$xls->getActiveSheet()->getStyle("A9:".$Columna."9")->applyFromArray(
				array(
						'font'=> array(
							'bold'=>true
						),
						'borders'=>array(
							'allborders'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN
							)
						),
						'fill'=>array( 
							'type' => PHPExcel_Style_Fill::FILL_SOLID,             
							'color'=> array('rgb' => 'c3faff')
						)   
					)	   
			);

			$Columna = 'C';
			$xls->getActiveSheet()
	            ->setCellValue($Columna.'10','Partida')
	            ->setCellValue(++$Columna.'10','Serie')
	            ->setCellValue(++$Columna.'10','Folio')
	            ->setCellValue(++$Columna.'10','Moneda')
	            ->setCellValue(++$Columna.'10','Forma de Pago')
	            ->setCellValue(++$Columna.'10','Parcialidad')
				->setCellValue(++$Columna.'10','Saldo')
				->setCellValue(++$Columna.'10','Pago')
	            ->setCellValue(++$Columna.'10','Saldo Insoluto')
	            ->setCellValue(++$Columna.'10','UUID Documento')
	            ->setCellValue(++$Columna.'10','Tipo de Cambio')
	            ->setCellValue(++$Columna.'10','Fecha Documento')
	            ->setCellValue(++$Columna.'10','Fecha Pago')
	        ;	
			$xls->getActiveSheet()->getStyle("C10:".$Columna."10")->applyFromArray(
				array(
						'font'=> array(
							'bold'=>true
						),
						'borders'=>array(
							'allborders'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN
							)
						), 
						'fill'=>array( 
								'type' => PHPExcel_Style_Fill::FILL_SOLID,             
								'color'=> array('rgb' => 'ffffc3')
						)   
					)
			);

	        $nom_mes = $this->nombreMes($mes);
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Resumen de Documentos XML '.$doc.' '.$ide. ' del mes de '.$nom_mes.' del '. $anio)
	            ->setCellValue('A4','Fecha de Emision del Reporte: ')
	            ->setCellValue('A5','Total de Documentos: ')
	            ->setCellValue('A6','Importe Total de los Documentos: ')
	            ->setCellValue('A7','Usuario Elabora')
	            ->setCellValue('A8','')
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('D3','')
	            ->setCellValue('D4',$fecha)
	            ->setCellValue('D5',count($pagos))
	            ->setCellValue('D6','$ '.number_format($totalSaldo,2))
	            ->setCellValue('D7',$usuario)
	            ->setCellValue('D8','')
	            ;
	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:O1');
	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando
	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	        $xls->getActiveSheet()->getStyle('I10:I102')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	        $xls->getActiveSheet()->mergeCells('A3:F3');
	        $xls->getActiveSheet()->getStyle('D3')->applyFromArray(
	            array('font' => array(
	                    'size'=>15,
	                )
	            )
	        );

	        $xls->getActiveSheet()->getStyle('A3:D3')->applyFromArray(
	            array(
	                'font'=> array(
	                    'bold'=>true
	                ),
	                'borders'=>array(
	                    'allborders'=>array(
	                        'style'=>PHPExcel_Style_Border::BORDER_THIN
	                    )
	                )
	            )
	        );

			$xls->createSheet(1);
			$xls->setActiveSheetIndex(1);
			$xls->getActiveSheet()->setTitle('Partidas');
			$Columna = 'A';
			$lnp=1;
			$xls->getActiveSheet(1)
	            ->setCellValue($Columna.$lnp  ,'Ln')
	            ->setCellValue(++$Columna.$lnp  ,'Estado')
	            ->setCellValue(++$Columna.$lnp,'Comprobante de Pago')
	            ->setCellValue(++$Columna.$lnp,'UUID')
	            ->setCellValue(++$Columna.$lnp,'Monto Pago')
	            ->setCellValue(++$Columna.$lnp,'Monto Pago Partida')
	            ->setCellValue(++$Columna.$lnp,'Moneda')
	            ->setCellValue(++$Columna.$lnp,'Tipo Cambio')
				->setCellValue(++$Columna.$lnp,'Fecha Pago')
				->setCellValue(++$Columna.$lnp,'Factura')
	            ->setCellValue(++$Columna.$lnp,'UUID Factura')
	            ->setCellValue(++$Columna.$lnp,'Fecha Factura')
	            ->setCellValue(++$Columna.$lnp,'Importe Factura')
	            ->setCellValue(++$Columna.$lnp,'Saldo')
				->setCellValue(++$Columna.$lnp,'Pago')
	            ->setCellValue(++$Columna.$lnp,'Saldo Insoluto')
	            ->setCellValue(++$Columna.$lnp,'Metodo Pago')
	            ->setCellValue(++$Columna.$lnp,'Comprobantes de la factura')
	            ->setCellValue(++$Columna.$lnp,'')
	        ;
			$lnp=1;$i=0;
			foreach ($partidas as $partida){
				$Columna='A'; $lnp++;$i++;
	            $xls->getActiveSheet(1)
	                ->setCellValue($Columna.$lnp,$i)
	                ->setCellValue(++$Columna.$lnp,$partida->STATUS)
	                ->setCellValue(++$Columna.$lnp, utf8_encode($partida->COMPROBANTE))
	                ->setCellValue(++$Columna.$lnp, utf8_encode($partida->UUID_PAGO))
					->setCellValue(++$Columna.$lnp,$partida->MONTO)
					->setCellValue(++$Columna.$lnp,$partida->PAGO)
	                ->setCellValue(++$Columna.$lnp,$partida->MONEDA)
	                ->setCellValue(++$Columna.$lnp,$partida->TIPO_CAMBIO)
					->setCellValue(++$Columna.$lnp,$partida->FECHA)
					->setCellValue(++$Columna.$lnp,$partida->FACTURA)
	                ->setCellValue(++$Columna.$lnp,$partida->ID_DOCUMENTO)
	                ->setCellValue(++$Columna.$lnp,$partida->FECHA_FACT)
	                ->setCellValue(++$Columna.$lnp,$partida->IMPORTE)
	                ->setCellValue(++$Columna.$lnp,$partida->SALDO)
	                ->setCellValue(++$Columna.$lnp,$partida->PAGO)
	                ->setCellValue(++$Columna.$lnp,$partida->SALDO_INSOLUTO)
	                ->setCellValue(++$Columna.$lnp,$partida->METODO_PAGO)
	                ->setCellValue(++$Columna.$lnp,$partida->PAGOS)
	                ->setCellValue(++$Columna.$lnp,$partida->VERSION_CFDI)
	            ;
			}
			$xls->setActiveSheetIndex(0);
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            $nom='Comprobante de Pago  '.$ide.' de '.$df->RAZON_SOCIAL.' '.$nom_mes.'-'.$anio.'.xlsx';
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
			//echo 'Nombre del archivo:'.$nom;
			
	        return array("status"=>'ok', "archivo"=>$nom);
		
	}
}?>

