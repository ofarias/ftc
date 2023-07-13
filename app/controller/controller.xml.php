
<?php
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/model/database.xmlTools.php');
require_once('app/model/db.contabilidad.php');
require_once('app/model/cargaXML.php');
require_once('app/controller/controller.xml.php');
require_once('app/model/acomodoXml.php');

class controller_xml{
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
				$nombre ='Desconocido';
				break;
		}
		return $nombre;
	}

	function cargaMetaDatos(){
		if($_SESSION['user']){
			$data = new cargaXML;
			$pagina =$this->load_template('Carga Metadatos');
			$html=$this->load_page('app/views/pages/xml/p.cargaMetaDatos.php');
   			$nomMeta=$data->nomMeta();
   			ob_start();
   			include 'app/views/pages/xml/p.cargaMetaDatos.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function facturacionCargaXML($files2upload, $tipo){
		if (isset($_SESSION['user'])) {            
            $data = new cargaXML;
            $valid_formats = array("txt", "TXT");
            $max_file_size = 1024 * 10000; 
            if($_SESSION['servidor']!='Debian'){
            	$target_dir="C:/xampp/htdocs/uploads/xml/metaData/";
            }else{
            	$target_dir="/home/ofarias/xmls/uploads/metaData/";
            }
            if(!file_exists($target_dir)){
            	mkdir($target_dir, 0777, true);
            }
            $count = 0;
            $respuesta = 0;
            foreach ($_FILES['files']['name'] as $f => $name) {	
                if ($_FILES['files']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }
                if ($_FILES['files']['error'][$f] == 0) {
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $message[] = "$name es demasiado grande para subirlo.";
                        continue; // Skip large files
                    }elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                        $message[] = "$name no es un archivo permitido.";
                        continue; // Skip invalid file formats
                    } else { // No error found! Move uploaded files 
                        $leeMetadatos=$data->leeMetadatos($_FILES["files"]["tmp_name"][$f]);
                        // aqui cambiamos el nombre del archivo para poder guardarlo con el nombre correcto.
                        $name=$leeMetadatos['rfce'].'-'.$leeMetadatos['rfcr'].'-'.$leeMetadatos['status'].'-'.$name;
                        $archivo = $target_dir.$name;
                        if($leeMetadatos['status']== 'ok'){
                        	if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir . $name)){
                            	$count++;
								$resp=$data->insertarMetaDatos($archivo);
								//unlink($_FILES["files"]["tmp_name"][$f]);
								if($resp['status']== 'borrados'){
									$this->correoCancelados($resp['data']);
								}
                        	}	
                        }else{
                        	move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir . $name);
                        	echo $leeMetadatos['mensaje'].'<br/>';
                        }
                    }
                }
            }
            echo "Archivos cargados con exito: $count-$respuesta";
            $this->cargaMetaDatos();
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }	
	}

	function correoCancelados($data){
		$_SESSION['info']=$data;
		$_SESSION['titulo']='Envio de Reporte de Documentos Cancelados';   //// guardamos los datos en la variable global $_SESSION
        include 'app/mailer/documentosCancelados.php';   ///  se incluye la classe Contrarecibo     
        if($mensaje == ''){
            
        }else{
            echo '<script> alert("Se ha enviado el correo favor de confirmar con el remitente..."); </script>';
        }
        return;
	}

	function verMetaDatos(){
		if($_SESSION['user']){
			$data=new pegaso;
			$pagina =$this->load_template('Pedidos');
			$html=$this->load_page('app/views/pages/xml/p.verMetaDatos.php');
   			ob_start();
   			$md = $data->verMetaDatos();
   			include 'app/views/pages/xml/p.verMetaDatos.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
		//$res= $data->insertaLTPD();
	}

	function verMetaDatosDet($archivo){
		if($_SESSION['user']){
			$data=new pegaso;
			$pagina =$this->load_template2('Pedidos');
			$html=$this->load_page('app/views/pages/xml/p.verMetaDatosDet.php');
   			ob_start();   			
   			$md = $data->verMetaDatosDet($archivo);
   			include 'app/views/pages/xml/p.verMetaDatosDet.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}


	function ReporteRetenciones(){
			$xls= new PHPExcel();
			$data = new pegaso;
			$info=$data->traeRetenciones();

			$col = 'A'; $ln=9; $i = 0;
			foreach ($info as $r) {
				$i++;
				$ln++;
				$xls->setActiveSheetIndex()
		                ->setCellValue($col.$ln,$i)
		                ->setCellValue(++$col.$ln,$r->RFCE)
		                ->setCellValue(++$col.$ln,$r->EMISOR)
		                ->setCellValue(++$col.$ln,$r->RFCR)
		                ->setCellValue(++$col.$ln,$r->RECEPTOR)
		                ->setCellValue(++$col.$ln,$r->UUID)
		                ->setCellValue(++$col.$ln,$r->FECHA)
		                ->setCellValue(++$col.$ln,$r->DOCUMENTO)
		                ->setCellValue(++$col.$ln,$r->SUBTOTAL)
		                ->setCellValue(++$col.$ln,$r->IVA)
		                ->setCellValue(++$col.$ln,$r->RET_IVA)
		                ->setCellValue(++$col.$ln,$r->RET_ISR)
		                ->setCellValue(++$col.$ln,$r->DESCUENTO)
		                ->setCellValue(++$col.$ln,$r->IMPORTE)
		        ;
			}

			$xls->getActiveSheet()->getColumnDimension('B')->setWidth(20);
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
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            $nom='Documentos '.$ide.' de '.$df->RAZON_SOCIAL.' '.$nom_mes.'-'.$anio.'.xlsx';
	            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	            //header("Content-Disposition: attachment;filename=01simple.xlsx");
	            //header('Cache-Control: max-age=0');
	        /// escribimos el resultado en el archivo;
	            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
	        /// salida a descargar
	            $x->save($ruta.$nom);
	            ob_end_clean();

	}

	function xmlExcel($mes, $anio, $ide, $doc, $t){
		if($_SESSION['user']){
			$uuid = isset($uuid)? $uuid:null;
	        if($t == 'z'){
	        	$conta=$this->contabilizacion($mes, $anio, $ide, $doc, $t);
	        	return $conta;
	        }
	        if($t == 'c'){
				$controller = new controller_coi;
				$res = $controller->consolidaPolizas($mes, $anio, $ide, $doc);
				return $res;
			}elseif($t == 'pa'){
				$m = new pegaso;
				$res=$m->revisaParametros($uuid);
				return $res;
			}elseif($t== 'xp'){
				$res=$this->xmlExcelPar($mes, $anio, $ide, $doc, $t);
				return $res;
			}
			
			$data = new pegaso();
			$res=$data->verXMLSP_xls($mes, $anio, $ide, $uuid=false, $doc);
			$xls= new PHPExcel();
	        //// insertamos datos a al objeto excel.
	        // Fecha inicio y fecha fin
	        $df= $data->traeDF($idem = 1);
	        $usuario =$_SESSION['user']->NOMBRE;
	        $fecha = date('d-m-Y h:i:s');
	        $ln = 10;
	        
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
	        foreach ($res as $key) {
	            $i++;
	            /*
				if($l_g < strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE)) ){
	            	$l_g = strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE));
	            }
	            if($l_h < strlen('('.$key->RFCE.')'.$key->EMISOR)){
	            	$l_h = strlen('('.$key->RFCE.')'.$key->EMISOR);
	            }
				*/
	            $rel = '';
	            if($doc == 'Pago'){
	            	$rel = $key->CEPA;
	            }else{
	            	$rel = $key->RELACIONES;
	            }
	            $status = $key->STATUS != 'C'? 'Vigente':'Cancelado';
	            $maestro=$key->UUID;
	            $totalSaldo += $key->IMPORTEXML;
				$Columna='A';
	            $xls->setActiveSheetIndex()
	                ->setCellValue($Columna.$ln,$i)
	                ->setCellValue(++$Columna.$ln,$key->POLIZA)
	                ->setCellValue(++$Columna.$ln,$key->UUID)
	                ->setCellValue(++$Columna.$ln,$key->VERSION_CFDI)
	                ->setCellValue(++$Columna.$ln,$key->REG_FISC_RECEP)
	                ->setCellValue(++$Columna.$ln,$key->DOM_FISC_RECEP)
					->setCellValue(++$Columna.$ln,$key->CEPA)
					->setCellValue(++$Columna.$ln,$key->USO)
	                ->setCellValue(++$Columna.$ln,$rel)
	                ->setCellValue(++$Columna.$ln, $status)
	                ->setCellValue(++$Columna.$ln,$doc)
	                ->setCellValue(++$Columna.$ln,$key->SERIE.$key->FOLIO)
	                ->setCellValue(++$Columna.$ln,$key->FECHA)
	                ->setCellValue(++$Columna.$ln,$key->CLIENTE)
	                ->setCellValue(++$Columna.$ln,utf8_encode($key->NOMBRE))
	                ->setCellValue(++$Columna.$ln,$key->RFCE)
	                ->setCellValue(++$Columna.$ln, utf8_encode($key->EMISOR))
	                ->setCellValue(++$Columna.$ln, $key->CONCEPTO)
	                ->setCellValue(++$Columna.$ln, $key->FORMAPAGO)
	                ->setCellValue(++$Columna.$ln, $key->METODOPAGO)
	                ->setCellValue(++$Columna.$ln, $key->CUENTA_CONTABLE)	                
	                ->setCellValue(++$Columna.$ln,$key->SUBTOTAL)//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->IVA160)//number_format($key->IVA,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->IVA_RET)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->IEPS)//number_format($key->IEPS,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->IEPS_RET)//number_format($key->IEPS_RET,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->ISR_RET)//number_format($key->ISR_RET,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->DESCUENTO)//number_format($key->DESCUENTO,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->IMPORTEXML)//number_format($key->IMPORTEXML,2,".",""))
	                ->setCellValue(++$Columna.$ln,$key->SALDO_XML)
	                ->setCellValue(++$Columna.$ln,$key->MONEDA)//number_format($key->MONEDA),".","")
	                ->setCellValue(++$Columna.$ln,$key->TIPOCAMBIO)//number_format($key->TIPOCAMBIO),".","")
	                ;
	            $ln++;
	        }
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
	            ->setCellValue(++$Columna.'9','Sta')
	            ->setCellValue(++$Columna.'9','UUID')
	            ->setCellValue(++$Columna.'9','Version')
	            ->setCellValue(++$Columna.'9','Regimen Receptor')
	            ->setCellValue(++$Columna.'9','Ubicacion Receptor')
				->setCellValue(++$Columna.'9','COMPROBANTES DE PAGO')
				->setCellValue(++$Columna.'9','USO')
	            ->setCellValue(++$Columna.'9','UUID RELACIONADOS')
	            ->setCellValue(++$Columna.'9','ESTATUS')
	            ->setCellValue(++$Columna.'9','TIPO')
	            ->setCellValue(++$Columna.'9','FOLIO')
	            ->setCellValue(++$Columna.'9','FECHA')
	            ->setCellValue(++$Columna.'9','RFC RECEPTOR')
	            ->setCellValue(++$Columna.'9','NOMBRE RECEPTOR')
	            ->setCellValue(++$Columna.'9','RFC EMISOR')
	            ->setCellValue(++$Columna.'9','NOMBRE EMISOR')
	            ->setCellValue(++$Columna.'9','CONCEPTO')
	            ->setCellValue(++$Columna.'9','FORMA DE PAGO')
	            ->setCellValue(++$Columna.'9','METODO DE PAGO')	            
	            ->setCellValue(++$Columna.'9','CUENTA CONTABLE')
	            ->setCellValue(++$Columna.'9','SUBTOTAL')
	            ->setCellValue(++$Columna.'9','IVA')
	            ->setCellValue(++$Columna.'9','RETENCION')
	            ->setCellValue(++$Columna.'9','IEPS')
	            ->setCellValue(++$Columna.'9','RETENCION IEPS')
	            ->setCellValue(++$Columna.'9','RETENCION ISR')
	            ->setCellValue(++$Columna.'9','DESCUENTO')
	            ->setCellValue(++$Columna.'9','TOTAL')
	            ->setCellValue(++$Columna.'9','SALDO')
	            ->setCellValue(++$Columna.'9','MON')
	            ->setCellValue(++$Columna.'9','TC')
	            
	            ;

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
	            ->setCellValue('D5',count($res))
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
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            $nom='Documentos '.$ide.' de '.$df->RAZON_SOCIAL.' '.$nom_mes.'-'.$anio.'.xlsx';
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
	            return array("status"=>'ok', "archivo"=>$nom);
		}
	}

	function xmlExcelPar($mes, $anio, $ide, $doc, $t){
			$xls= new PHPExcel();
	        $data= new pegaso; 
	        $df= $data->traeDF($idem = 1);
	        $res=$data->verXMLPAR($mes, $anio, $ide, $uuid=false, $doc);
	        $usuario =$_SESSION['user']->NOMBRE;
	        $fecha = date('d-m-Y h:i:s');
	        $ln = 10;
	        $doc = $doc=='I'? 'Ingresos':'Egresos';
	        $totalSaldo=0;
	        $i=0;
	        $l_g = 0;
	        $l_h = 0;
	        $l_us= 0;
	        $l_ds= 0;
	        $l_d = 0;
	        foreach ($res as $key) {
	            $i++;
	            // Logica Cliente & Proveedor
	            if($ide == 'Emitidos'){
	        		$cliente='('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE);
	        		$proveedor = '('.$key->RFCE.')'.utf8_encode($key->EMISOR);
	        		$tipo = 'Cliente';
	        	}elseif($ide == 'Recibidos'){
					$proveedor='('.$key->RFCE.')'.utf8_encode($key->NOMBRE);
	        		$cliente='('.$key->CLIENTE.')'.utf8_encode($key->EMISOR);
	        		$tipo = 'Proveedor';
	        	}else{
	        		$proveedor='';
	        		$cliente='';
	        	}
	        	
	            if($l_g < strlen($cliente) ){
	            	$l_g = strlen($cliente);
	            }
	            if($l_h < strlen($proveedor)){
	            	$l_h = strlen($proveedor);
	            }
	            if($l_us < strlen($key->DESC_UNIDAD)){
	            	$l_us = strlen($key->DESC_UNIDAD);
	            }
	            if($l_ds < strlen($key->DESC_CLAVE)){
	            	$l_ds = strlen($key->DESC_CLAVE);
	            }
	            if($l_d < strlen($key->DESCRIPCION)){
	            	$l_d = strlen($key->DESCRIPCION);
	            	$l_d = $l_d>100? 100:$l_d;
	            }
	            if($l_f < strlen(trim($key->SERIE).trim($key->FOLIO))){
	            	$l_f = strlen(trim($key->SERIE).trim($key->FOLIO));
	            }
	            $maestro=$key->UUID;
	            $totalSaldo += ( ($key->PIMPORTE - $key->PDESCUENTO) + $key->PIVA + $key->PIEPS + $key->PISR);
	            $col= 'A';
	            $xls->setActiveSheetIndex()
	                ->setCellValue($col.$ln,$i)
	                ->setCellValue(++$col.$ln,$key->STATUS)
	                ->setCellValue(++$col.$ln,$key->UUID)
	                ->setCellValue(++$col.$ln,$key->TIPO)
	                ->setCellValue(++$col.$ln,$key->SERIE.$key->FOLIO)
	                ->setCellValue(++$col.$ln,$key->FECHA)
	                ->setCellValue(++$col.$ln,$cliente)
	                ->setCellValue(++$col.$ln,$proveedor)
	                ->setCellValue(++$col.$ln,$key->PARTIDA)//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue(++$col.$ln,utf8_encode($key->DESCRIPCION))//number_format($key->IVA,2,".",""))
	                ->setCellValue(++$col.$ln,$key->UNIDAD_SAT)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue(++$col.$ln,utf8_encode($key->DESC_UNIDAD))
	                ->setCellValue(++$col.$ln,$key->CLAVE_SAT)//number_format($key->IEPS,2,".",""))
	                ->setCellValue(++$col.$ln,utf8_encode($key->DESC_CLAVE))
	                ->setCellValue(++$col.$ln,$key->CUENTA_CONTABLE)//number_format($key->IEPS_RET,2,".",""))
	                ->setCellValue(++$col.$ln,$key->CANTIDAD)//number_format($key->ISR_RET,2,".",""))
	                ->setCellValue(++$col.$ln,$key->UNITARIO)//number_format($key->DESCUENTO,2,".",""))
	                ->setCellValue(++$col.$ln,$key->PDESCUENTO)//number_format($key->IMPORTEXML,2,".",""))
	                ->setCellValue(++$col.$ln,$key->MONEDA)//number_format($key->MONEDA),".","")
	                ->setCellValue(++$col.$ln,$key->TIPOCAMBIO)//number_format($key->TIPOCAMBIO),".","")
	                ->setCellValue(++$col.$ln,(($key->CANTIDAD*$key->UNITARIO) - ($key->PDESCUENTO)) )// Subtotal
	                ->setCellValue(++$col.$ln,$key->PIVA) // Iva
	                ->setCellValue(++$col.$ln,$key->RET_IVA) // Retencion IVA 
	                ->setCellValue(++$col.$ln,$key->RET_ISR) // Retencion IVA 
	                ->setCellValue(++$col.$ln,$key->PIEPS) // IEPS 
	                ->setCellValue(++$col.$ln,$key->PISR) // ISR
	                ->setCellValue(++$col.$ln,(($key->PIMPORTE - $key->PDESCUENTO) + $key->PIVA +$key->PIEPS + $key->PISR - $key->RET_IVA - $key->RET_ISR) ) // Total
	                ->setCellValue(++$col.$ln,$key->CUENTA_CAB)
	                ->setCellValue(++$col.$ln,'')
	            ;
	            $ln++;
	        }
	        $ln++;
	        $xls->setActiveSheetIndex()
	            ->setCellValue('A'.$ln,'Fin del resumen de las partidas de los documentos.');
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
	            ->setCellValue('A1',$df->RAZON_SOCIAL)
	        ;
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
	        $col='A';
	        $xls->getActiveSheet()->getColumnDimension($col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(40);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_f);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_h);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_d);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_us);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth($l_ds);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(30);
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $col = 'A';
	        $xls->getActiveSheet()
	            ->setCellValue($col.'9','Ln')
	            ->setCellValue(++$col.'9','Sta')
	            ->setCellValue(++$col.'9','UUID')
	            ->setCellValue(++$col.'9','TIPO')
	            ->setCellValue(++$col.'9','FOLIO')
	            ->setCellValue(++$col.'9','FECHA')
	          	->setCellValue(++$col.'9','RECEPTOR')
	            ->setCellValue(++$col.'9','EMISOR')
	            ->setCellValue(++$col.'9','PARTIDA')
	            ->setCellValue(++$col.'9','DESCRIPCION')
	            ->setCellValue(++$col.'9','UNIDAD SAT')
	            ->setCellValue(++$col.'9','DESCRIPCION')
	            ->setCellValue(++$col.'9','CLAVE SAT')
	            ->setCellValue(++$col.'9','DESCRIPCION')
	            ->setCellValue(++$col.'9','CUENTA PARTIDA')
	            ->setCellValue(++$col.'9','CANTIDAD')
	            ->setCellValue(++$col.'9','PRECIO')
	            ->setCellValue(++$col.'9','DESCUENTO')
	            ->setCellValue(++$col.'9','MONEDA')
	            ->setCellValue(++$col.'9','TIPO CAMBIO')
	            ->setCellValue(++$col.'9','SUBTOTAL')
	            ->setCellValue(++$col.'9','IVA')
	            ->setCellValue(++$col.'9','Ret IVA')
	            ->setCellValue(++$col.'9','Ret ISR')
	            ->setCellValue(++$col.'9','IEPS')
	            ->setCellValue(++$col.'9','ISR')
	            ->setCellValue(++$col.'9','TOTAL')
	            ->setCellValue(++$col.'9','CUENTA '.strtoupper($tipo))
	        ;

	        $nom_mes = $this->nombreMes($mes);
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Resumen de Documentos XML '.$doc.' '.$ide. ' del mes de '.$nom_mes.' del '. $anio)
	            ->setCellValue('A4','Fecha de Emision del Reporte: ')
	            ->setCellValue('A5','Total de Partidas: ')
	            ->setCellValue('A6','Importe Total de las Partidas: ')
	            ->setCellValue('A7','Usuario Elabora')
	            ->setCellValue('A8','')
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('D3','')
	            ->setCellValue('D4',$fecha)
	            ->setCellValue('D5',count($res))
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
	        //Nombre de la hoja
	        $xls->getActiveSheet()->setTitle($ide.'_'.$mes.'_'.$anio);

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
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	        $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	        if(!file_exists($ruta)){
	        	mkdir($ruta);
	        }
	        $nom='Detalle de Documentos '.$ide.' de '.$df->RAZON_SOCIAL.' '.$nom_mes.'-'.$anio.'.xlsx';
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
	        return array("status"=>'ok', "archivo"=>$nom);
	}

	function contabilizacion($mes, $anio, $ide, $doc, $t){
			$data = new CoiDAO();
			$data_p = new pegaso();
			$res=$data->traeAuxiliares($mes, $anio, $ide, $uuid=false, $doc);
			$xls= new PHPExcel();
	        //// insertamos datos a al objeto excel.
	        // Fecha inicio y fecha fin
	        $df= $data_p->traeDF($idem = 1);
	        $usuario =$_SESSION['user']->NOMBRE;
	        $fecha = date('d-m-Y h:i:s');
	        $ln = 10;
	        $doc = $doc=='I'? 'Ingresos':'Egresos';
	        //print_r($documentos);
	        $totalSaldo=0;
	        $i=0;
	        $l_g = 0;
	        $l_h = 0;
	        foreach ($res as $key) {
	            $i++;
	            $a= $data_p->traeUUID($key->TIPO_POLI, $key->NUM_POLIZ, $key->PERIODO, $key->EJERCICIO, $key->NUM_PART);

	            if($l_g < strlen($key->NOMBRE)){
	            	$l_g = strlen($key->NOMBRE);
	            }
	            $abono=$key->DEBE_HABER=='H'? $key->MONTOMOV:0;
	            $cargo=$key->DEBE_HABER=='D'? $key->MONTOMOV:0;
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$i)
	                ->setCellValue('B'.$ln,$a['uuid'])
	                ->setCellValue('C'.$ln,$key->TIPO_POLI)
	                ->setCellValue('D'.$ln,$key->NUM_POLIZ)
	                ->setCellValue('E'.$ln,$key->ORIGEN)
	                ->setCellValue('F'.$ln,$key->NUM_PART)
	                ->setCellValue('G'.$ln,$key->PERIODO)
	                ->setCellValue('H'.$ln,$key->FECHA_POL)
	                ->setCellValue('I'.$ln,$key->NUM_CTA)
	                ->setCellValue('J'.$ln,utf8_encode($key->NOMBRE))//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue('K'.$ln,$abono)//number_format($key->IVA,2,".",""))
	                ->setCellValue('L'.$ln,$cargo)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue('M'.$ln,$key->TIPCAMBIO)
	                ;
	            $ln++;
	        }
	        $ln++;
	        $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,'Fin del resumen de movimientos.');
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
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(13);

	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','UUID')
	            ->setCellValue('C9','Tipo')
	            ->setCellValue('D9','Numero')
	            ->setCellValue('E9','Origen')
	            ->setCellValue('F9','Partida')
	            ->setCellValue('G9','Periodo')
	            ->setCellValue('H9','Fecha Poliza')
	            ->setCellValue('I9','Cuenta')
	            ->setCellValue('J9','Nombre')
	            ->setCellValue('K9','Cargo')
	            ->setCellValue('L9','Abono')
	            ->setCellValue('M9','Tipo de Cambio')
	            ;

	        $nom_mes = $this->nombreMes($mes);
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Revision de Contabilizacion del periodo '.$mes.' del ejercicio '.$anio)
	            ->setCellValue('A4','Fecha de Emision del Reporte: ')
	            ->setCellValue('A5','Total de Movimientos: ')
	            ->setCellValue('A6','')
	            ->setCellValue('A7','Usuario Elabora')
	            ->setCellValue('A8','')
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('E3','')
	            ->setCellValue('E4',$fecha)
	            ->setCellValue('E5',count($res))
	            ->setCellValue('E6','')
	            ->setCellValue('E7',$usuario)
	            ->setCellValue('E8','')
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
	        $xls->getActiveSheet()->mergeCells('A3:H3');
	        $xls->getActiveSheet()->getStyle('D3')->applyFromArray(
	            array('font' => array(
	                    'size'=>15,
	                )
	            )
	        );
	        $a=10;
	        foreach ($res as $kc){
	        	if(empty($kc->NOMBRE) or $kc->NUM_CTA == 'Sin Cuenta Actual'){
	        		$xls->getActiveSheet()->getStyle('A'.$a.':K'.$a)->getFill()->applyFromArray(
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
	        					     'rgb' => 'F28A8C'
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
	            $nom='Revision Contabilizacion de '.$df->RAZON_SOCIAL.' '.$nom_mes.'-'.$anio.'.xlsx';
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
	            return array("status"=>'ok', "archivo"=>$nom);
	}
	
	function cellColor($cells,$color){
    	global $objPHPExcel;
	    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'startcolor' => array(
	             'rgb' => $color
	        )
	    ));
	}

	function zipXML($mes, $anio, $ide, $doc){
		if($_SESSION['user']){
			$data = new cargaXML;
			$zip = $data->zipXML($mes, $anio, $ide, $doc);
			return $zip;
		}
	}

	function verCEP($cep){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info=$data->verCEP($cep);
			$pagina =$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.verCEP.php');
   			ob_start();
   			include 'app/views/pages/xml/p.verCEP.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function verRelacion($uuid){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->verRelacion($uuid);
			$relaciones=$data->ver;
			$pagina =$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.verRelacion.php');
   			ob_start();
   			include 'app/views/pages/xml/p.verRelacion.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}	

	function actTablas(){
		if($_SESSION['user']->USER_LOGIN == 'ofarias'){
			$data = new cargaXML;
			$act = $data->actTablas();
			return;
		}
	}

	function p_c($anio, $mes){
		if($_SESSION['user']){
			$data=new cargaXML;
			$info=$data->p_c($anio, $mes);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.pagado_cobrado.php');
   			ob_start();
   			include 'app/views/pages/xml/p.pagado_cobrado.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function xls_diot($file, $x, $mes, $anio){
		$data = new cargaXML; 
		$genera = $data->xls_diot($file, $x, $mes, $anio);
		return $genera;
	}

	function cs(){
		$usuario = $_SESSION['user']->NOMBRE;
		$data = new cargaXML;
		$calculo = $data->cs();
		$datos = $data->creaExcel();
		$xls= new PHPExcel();
		$ln = 10;
		$i = 0;
		foreach ($datos as $key){
			$i++;
			if(!empty($key->CONTABILIDAD)){
				$dc=$data->traePolizas($key->CONTABILIDAD);
			}else{
				$dc='';
			}
			echo 'Linea: '.$i.'<br/>';
			$xls->setActiveSheetIndex()
		            ->setCellValue('A'.$ln,$i)
		            ->setCellValue('B'.$ln,$key->FACTURA)
		            ->setCellValue('C'.$ln,$key->FECHA)
		            ->setCellValue('D'.$ln,$key->CLIENTE)
		            ->setCellValue('E'.$ln,$key->IMPORTE)
		            ->setCellValue('F'.$ln,$key->SALDO)
		            ->setCellValue('G'.$ln,$key->MONTO_CONCILIADO)
		            ->setCellValue('H'.$ln,$dc)
		            ->setCellValue('I'.$ln,'')//number_format($key->SUBTOTAL,2,".",""))
		            ->setCellValue('J'.$ln,'')//number_format($key->IVA,2,".",""))
		            ->setCellValue('K'.$ln,'')//number_format($key->IVA_RET,2,".",""))
		            ->setCellValue('L'.$ln,'')
		            ;
		        $ln++;
		}

			$xls->getActiveSheet()
		        ->setCellValue('A1','Reporte de conciliacion Excel');
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(13);
	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','FACTURA')
	            ->setCellValue('C9','FECHA')
	            ->setCellValue('D9','CLIENTE')
	            ->setCellValue('E9','IMPORTE')
	            ->setCellValue('F9','SALDO')
	            ->setCellValue('G9','CONTABILIZADO')
	            ->setCellValue('H9','POLIZAS')
	            ->setCellValue('I9','')
	            ->setCellValue('J9','')
	            ->setCellValue('K9','')
	            ->setCellValue('L9','')
	            ;

	        $nom_mes = $this->nombreMes($mes);
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Conciliacion contable Walmart')
	            ->setCellValue('A4','Fecha de Emision del Reporte: ')
	            ->setCellValue('A5','Total de Movimientos: ')
	            ->setCellValue('A6','')
	            ->setCellValue('A7','Usuario Elabora')
	            ->setCellValue('A8','')
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('E3','')
	            ->setCellValue('E4',date('d-m-Y H:i:s'))
	            ->setCellValue('E5',count($datos))
	            ->setCellValue('E6','')
	            ->setCellValue('E7',$usuario)
	            ->setCellValue('E8','')
	            ;
	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:L1');
	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando
	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	        

		$ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	    $nom='Reporte de Conciliacion Walmart.xlsx';
	    $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
		$x->save($ruta.$nom);
	    ob_end_clean();
	}


	function cargaEFOS(){
		if($_SESSION['user']){
			$data = new cargaXML;
			//$carga = $data->cargaEFOS();
			$path = 'C:\\xampp\\htdocs\\biotecsa\\';
			//$this->showFiles($path);
			//$cf = $data->cf();
			$archivo = $data->creaPaquetes();
			die;
			return $carga;
		}
	}

	function showFiles($path){
    	$dir = opendir($path);
    	$files = array();
    	$data = new cargaXML();
    	while ($current = readdir($dir)){
    	    if( $current != "." && $current != "..") {
    	        if(is_dir($path.$current)) {
    	            $this->showFiles($path.$current.'/');
    	        }
    	        else {
    	            $files[] = $current;
    	        }
    	    }
    	}
    	echo '<h2>'.$path.'</h2>';
    	echo '<ul>';
    	for($i=0; $i<count( $files ); $i++){
    	    echo '<li>'.$files[$i]."</li>";
    	    $data->insertaFile($files[$i], $path);
    	    
    	}
    	echo '</ul>';
	}

	function nomXML($a, $m, $t){
		if($_SESSION['user']){
			$data=new cargaXML;
			$info= $data->nomXML($a, $m);
			$c = new pegaso_controller;
			if(count($info) == 0){
				echo '<script> alert("No se encontro informacion para el mes y el año") </script>';
				$c->xmlMenu();
				exit();
			}
			$per = $data->nomP($info);
			$ded = $data->nomD($info);
			$emp = $data->nomE($info);
			if($t == 'v'){
				$pagina=$this->load_template();
				$html=$this->load_page('app/views/pages/Nomina/m.nominasXML.php');
	   			ob_start();
	   			include 'app/views/pages/Nomina/m.nominasXML.php';
	   			$table = ob_get_clean();
	   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	   			$this->view_page($pagina);	
			}else{
				return $this->detNom($info, 'per', 'xls');
			}
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function detalleNomina($fi, $ff){
		if($_SESSION['user']){
			$data=new cargaXML;
			$rec = $data->detalleNomina($fi, $ff);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Nomina/p.detalleNom.php');
   			ob_start();
   			include 'app/views/pages/Nomina/p.detalleNom.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function infoPer($uuid){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->infoPer($uuid);
			return $info;
		}
	}

	function reciboNomina($uuid){
		if($_SESSION['user']){
			$data = new cargaXML;
			$res=$data->reciboNomina($uuid);
			return $res;
		}
	}

	function detNom($fi, $ff, $tipo){
		if($_SESSION['user']){
			$data=new cargaXML;
			$info=$data->detNom($fi, $ff);
			$columnas = $info['columnas'];
			$datos = $info['datos'];
			$lineas = $info['lineas'];
			if($tipo=='xls'){
				if($ff == 'per'){
					$res=$this->repNominaMensual($fi, $ff, $columnas, $datos, $lineas);	return $res;

				}else{
					$res=$this->repNomina($fi, $ff, $columnas, $datos, $lineas);	return $res;	exit();
				}
			}
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Nomina/p.detNom.php');
   			ob_start();
   			include 'app/views/pages/Nomina/p.detNom.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function verRecibo($uuid){
		if($_SESSION['user']){
			$data=new cargaXML;
			$rfcempresa = $_SESSION['rfc'];
			$info=$data->verRecibo($uuid);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Nomina/p.verRecibo.php');
   			ob_start();
   			include 'app/views/pages/Nomina/p.verRecibo.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function repNomina($fi, $ff, $columnas, $datos, $lineas){
		$data = new pegaso;
		$dataXML = new cargaXML;
		$xls = new PHPExcel();
		$usuario=$_SESSION['user']->NOMBRE;
		$ln = 10;
		$colc = 'A';
		$df = $data->traeDF($ide = 1);
		$perc = 0;

		for ($i=0; $i < 6; $i++){
			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        ;	
			++$colc;
		}

		for ($i=6; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'P'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		}

			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Percepciones')
	        ;
	        ++$colc;
	    for ($i=6; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'D'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		}
			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Deducciones')
	        ;
	        ++$colc;
	    for ($i=6; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'O'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		} 

			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Otras Percepciones')
	        ;
	        ++$colc;
	        $xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total a Pagar')
	        ;
	        ++$colc;
	        $xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'SAE trabajador')
	        ;
	        ++$colc;

	        //// revisar hasta aqui las columnas de Totales 
	    $ln++;
		$salario = 0;

	    foreach ($lineas as $key){
	    	$tp=0;
	    	$td=0;
	    	$to=0;
	    	$col = 'A';
	    	$xls->setActiveSheetIndex()
	    		->setCellValue($col.$ln,$key->UUID_NOMINA)
	    	;
	    	foreach($datos as $d){
            	if($d->UUID_NOMINA == $key->UUID_NOMINA){
            		$col = 'B';
            		$xls->setActiveSheetIndex()
            	    	->setCellValue($col.$ln,$d->NUMERO)
            	    ;
            	    break;
            	}
        	}

            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'C';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->DEPTO)
                    ;
                    break;
            	}
            }

            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'D';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->NOMBRE)
                    ;
                    break;
            	}
            }
            
            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'E';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->FECHAINGRESO)
                    ;
                    break;
            	}
            }
			
         
            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'F';
                	if ($d->SALARIO > 0 ){
                		$salario = $d->SALARIO;
                	}
                	$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,'$ '. number_format($salario,2))
                    ;
                    if ($d->SALARIO > 0 ){
                		break;
                	}
            	}
            }
			$salario = 0; 
            $h=3;
            $c=3;
           
            for($i=6;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'P'){
	                ++$col;
	                foreach ($datos as $d){
				        $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	if($d->UUID_NOMINA == $key->UUID_NOMINA AND (
	                		($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]
	                		)
	                		){
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln, '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2))
	                    	;
	                    	$tp += $d->IMP_EXENTO + $d->IMP_GRAVADO; 
	                    	break;
	                	}else{
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln,'$ '.number_format(0,2))
	                    	;
	                	}

	                }
				}
            }

	        ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($tp,2))
	        ;
	        //echo 'Columna '.$col.' Linea: '.$ln.' Valor de Total Percepciones: $ '.number_format($tp,2).'<br/>';
	        
            for($i=6;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'D'){
	                ++$col;
	                foreach ($datos as $d){
				        $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	if($d->UUID_NOMINA == $key->UUID_NOMINA AND (
	                		($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]
	                		)
	                		){
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln, '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2))
	                    	;
	                    	$td += $d->IMP_EXENTO + $d->IMP_GRAVADO; 
	                    	break;
	                	}else{
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln,'$ '.number_format(0,2))
	                    	;
	                	}
	                }
				}
            }
            ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($td,2))
	        ;
	        //echo 'Columna '.$col.' Linea: '.$ln.' Valor de Total deducciones: $ '.number_format($td,2).'<br/>';
	        //++$col;
	        //break;
	        for($i=6;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'O'){
	                ++$col;
	                foreach ($datos as $d){
				        $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	if($d->UUID_NOMINA == $key->UUID_NOMINA AND (
	                		($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]
	                		)
	                		){
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln, '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2))
	                    	;
	                    	$to += $d->IMP_EXENTO + $d->IMP_GRAVADO; 
	                    	break;
	                	}else{
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln,'$ '.number_format(0,2))
	                    	;
	                	}

	                }
				}
            }

            ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($to,2))
	        ;

	        ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
			$xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($tp-$td+$to,2))
	        ;

	        for($i=6;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'S'){
	                ++$col;
	                foreach ($datos as $d){
				        $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	if($d->UUID_NOMINA == $key->UUID_NOMINA AND (
	                		($d->DED_PER.':'.$d->TIPO.':'.$d->CLAVE.':'.$d->CONCEPTO) == $columnas[$i]
	                		)
	                		){
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln, '$ '.number_format($d->IMP_EXENTO + $d->IMP_GRAVADO,2))
	                    	;
	                    	$to += $d->IMP_EXENTO + $d->IMP_GRAVADO; 
	                    	break;
	                	}else{
	                		$xls->setActiveSheetIndex()
	                    		->setCellValue($col.$ln,'$ '.number_format(0,2))
	                    	;
	                	}

	                }
				}
            }
	        
	        $ln++;
	    }
	    //echo 'Columna: '.$col.' linea: '.$ln ;
	    //die;

	    $xls->setActiveSheetIndex()
	        ->setCellValue('A'.$ln,'Fin del resumen de documentos.');

	    /// Inicia los totales:
	         
	    $xls->getActiveSheet()
	        ->setCellValue('A1',$df->RAZON_SOCIAL);

	    /// CAMBIANDO EL TAMAÑO DE LA LINEA.
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(40);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('T')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('U')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('V')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('W')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('X')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Z')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('AA')->setWidth(13);

	   	
	   		$totales = $dataXML->totalNomina($fi, $ff);
	   		
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Resumen de Recibos de Nomina')
	            ->setCellValue('A4','Fecha Inicial: '.$fi)
	            ->setCellValue('A5','Fecha Final: '.$ff)
	            ;

	        $cc=0;
	        $coltot = 'A';
	        $lintot = 6;
	        $cc2 = 0;
	        $lin2= 6;
	        foreach ($totales as $t) {
	        	$cc2++;
	        	if($cc2 == 1){
	        		$colcab= $coltot;
	        		++$colcab;
	        		$lincab = $lin2-1;
	        		$xls->getActiveSheet()    
			            ->setCellValue($colcab.$lincab,'Gravado')
	    	        ;
			        	$xls->getActiveSheet()->getStyle($colcab.$lincab)->getAlignment()->setHorizontal('center');
	        		++$colcab;

	    	    	$xls->getActiveSheet()    
			            ->setCellValue($colcab.$lincab,'Exento')
	    	    	;	
			        	$xls->getActiveSheet()->getStyle($colcab.$lincab)->getAlignment()->setHorizontal('center');

	        	}

	        	if($cc == 4){
	        		++$coltot;
	        		++$coltot;
	        		++$coltot;
	        		$cc = 0;
	        		$lintot = 6;
	        		$cc2=0;
	        		$lin2=6;
	        	}
	        	$cc++;
	        	$coltdg= $coltot;
	        	++$coltdg;
	        	$coltde = $coltdg;
	        	++$coltde;
		   		$xls->getActiveSheet()    
		            ->setCellValue($coltot.$lintot,'Total '.$t->CONCEPTO.'('.$t->TIPO.'-'.$t->CLAVE.')')
		            ->setCellValue($coltdg.$lintot,'$ '.number_format($t->GRAVADO,2))
		            ->setCellValue($coltde.$lintot,'$ '.number_format($t->EXENTO,2))
	    	    ;
	    	    //$xls->getActiveSheet()->getStyle($coltot.$lintot)->getAlignment()->setHorizontal('right');
	    	    $xls->getActiveSheet()->getStyle($coltdg.$lintot)->getAlignment()->setHorizontal('right');
	    	    $xls->getActiveSheet()->getStyle($coltde.$lintot)->getAlignment()->setHorizontal('right');

	            $lintot++;
	   		}
	       
	        $xls->getActiveSheet()
	            ->setCellValue('C3','Fecha del Emisión: '.date("d-m-Y H:n:s"))
	            ->setCellValue('C4','Emite: '.$usuario)
	            ;
	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:'.$colc.'1');
	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando
	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	    /*
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
	    */
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	        	$rfc=$_SESSION['empresa']['rfc'];
	            if($_SESSION['servidor']!='Debian'){
	            	$ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            }else{
	            	//$ruta='/home/ofarias/xmls/nominas/'.$rfc.'/';
	            	$ruta= '/var/www/html/ftc/nominas/'.$rfc.'/';
	            }

	            if(!is_dir($ruta)){
	            	mkdir( $ruta,  0777, true );
	            }

	            $nom='Reporte de Nomina '.$df->RAZON_SOCIAL.' '.$fi.'.xlsx';
	            //$nom ='ReporteNomina.xlsx';
	            /// escribimos el resultado en el archivo;
	            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
	        	/// salida a descargar
	            $x->save($ruta.$nom);
	            ob_end_clean();
	            //echo 'Se crea el archivo: '.$ruta.$nom;
	            if($_SESSION['servidor']!='Debian'){
	        		return array("status"=>'ok', "archivo"=>$nom, "ruta"=>"../EdoCtaXLS/".$nom, "tipo"=>'windows');
	            }else{
	            	return array("status"=>'ok', "archivo"=>$nom, "ruta"=>'/ftc/nominas/'.$rfc.'/'.$nom, "tipo"=>'debian');
	            }
	        //$x->save('php://output');
	        /// salida a ruta :
	}

	function repNominaMensual($fi, $ff, $columnas, $datos, $lineas){
		$data = new pegaso;
		$dataXML = new cargaXML;
		$xls = new PHPExcel();
		$usuario=$_SESSION['user']->NOMBRE;
		$ln = 10;
		$colc = 'A';
		$df = $data->traeDF($ide = 1);
		$perc = 0;
		$datos_array= array();
		
		for ($i=0; $i < 7; $i++){
			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        ;	
			++$colc;
		}

		for ($i=7; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'P'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		}

			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Percepciones')
	        ;
	        ++$colc;
	    for ($i=7; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'D'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		}
			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Deducciones')
	        ;
	        ++$colc;
	    for ($i=7; $i < count($columnas); $i++){
			$column = explode(":", $columnas[$i]);
			if($column[0] == 'O'){
				$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        	;	
				++$colc;	
			}
		} 

			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total Otras Percepciones')
	        ;
	        ++$colc;
	        $xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'Total a Pagar')
	        ;
	        ++$colc;

	        $xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,'SAE trabajador')
	        ;
	        ++$colc;

	        //// revisar hasta aqui las columnas de Totales 
	    $ln++;
		$salario = 0;
		
		//echo 'Lineas: '.count($lineas). ' columnas '.count($columnas).' datos '.count($datos);
		//die();

	    foreach ($lineas as $key){
	    	$tp=0;
	    	$td=0;
	    	$to=0;
	    	$col = 'A';
	    	$xls->setActiveSheetIndex()
	    		->setCellValue($col.$ln,$key->UUID_NOMINA)
	    	;

	    	foreach($datos as $d){
            	if($d->UUID_NOMINA == $key->UUID_NOMINA){
            		$col = 'B';
            		$xls->setActiveSheetIndex()
            	    	->setCellValue($col.$ln,$d->NUMERO)
            	    ;
            	    break;
            	}
        	}

            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'C';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->DEPTO)
                    ;
                    break;
            	}
            }

            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'D';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->NOMBRE)
                    ;
                    break;
            	}
            }
            
            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'E';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$d->FECHAINGRESO)
                    ;
                    break;
            	}
            }
			
            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'F';
                	if ($d->SALARIO > 0 ){
                		$salario = $d->SALARIO;
                	}
                	$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,'$ '. number_format($salario,2))
                    ;
                    if ($d->SALARIO > 0 ){
                		break;
                	}
            	}
            }

            foreach($datos as $d){
                if($d->UUID_NOMINA == $key->UUID_NOMINA){
                	$col = 'G';
                	$xls->setActiveSheetIndex()
                    	->setCellValue($col.$ln,$key->FF)
                    ;
                    break;
            	}
            }
			$salario = 0; 
            $h=3;
            $c=3;
           	
			for($i=7;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'P'){
	                ++$col;
	                $val = $dataXML->getMovNom($key->UUID_NOMINA, $column[0], $column[1] , $column[2] , $column[3]);
	                    $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	$xls->setActiveSheetIndex()
	                    	->setCellValue($col.$ln, '$ '.number_format($val['valor'],2))
	                    	;
	                    $tp += $val['valor'];
				}
            }            
           
	        ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($tp,2))
	        ;

	        for($i=7;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'D'){
	                ++$col;
	                $val = $dataXML->getMovNom($d->UUID_NOMINA, $column[0], $column[1] , $column[2] , $column[3]);
	                    $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	$xls->setActiveSheetIndex()
	                    	->setCellValue($col.$ln, '$ '.number_format($val['valor'],2))
	                    	;
	                    $td += $val['valor'];
				}
            }   
            ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($td,2))
	        ;
			
			for($i=7;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'O'){
	                ++$col;
	                $val = $dataXML->getMovNom($d->UUID_NOMINA, $column[0], $column[1] , $column[2] , $column[3]);
	                    $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	$xls->setActiveSheetIndex()
	                    	->setCellValue($col.$ln, '$ '.number_format($val['valor'],2))
	                    	;
	                    $to += $val['valor'];
				}
            }   
	        
            ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
            $xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($to,2))
	        ;

	        ++$col;
			$xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
			$xls->setActiveSheetIndex()
	            ->setCellValue($col.$ln,'$ '.number_format($tp-$td+$to,2))
	        ;
	        
	        for($i=7;$i<count($columnas);$i++){
                $column = explode(":", $columnas[$i]);
				if($column[0] == 'S'){
	                ++$col;
	                $val = $dataXML->getMovNom($d->UUID_NOMINA, $column[0], $column[1] , $column[2] , $column[3]);
	                    $xls->getActiveSheet()->getStyle($col.$ln)->getAlignment()->setHorizontal('right');
	                	$h++;
	                	$xls->setActiveSheetIndex()
	                    	->setCellValue($col.$ln, '$ '.number_format($val['valor'],2))
	                    	;
	                    //$t += $val['valor'];
				}
            }   

	        $ln++;
	    }
	    
	    $xls->setActiveSheetIndex()
	        ->setCellValue('A'.$ln,'Fin del resumen de documentos.');

	    /// Inicia los totales:
	         
	    $xls->getActiveSheet()
	        ->setCellValue('A1',$df->RAZON_SOCIAL);

	    /// CAMBIANDO EL TAMAÑO DE LA LINEA.
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(40);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('T')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('U')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('V')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('W')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('X')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('Z')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('AA')->setWidth(13);
	   	
	   		$totales = $dataXML->totalNomina($fi, $ff);
	   		
	        $xls->getActiveSheet()
	            ->setCellValue('A3','Resumen de Recibos de Nomina')
	            ->setCellValue('A4','Fecha Inicial: '.$fi)
	            ->setCellValue('A5','Fecha Final: '.$ff)
	            ;

	        $cc=0;
	        $coltot = 'A';
	        $lintot = 6;
	        $cc2 = 0;
	        $lin2= 6;

	        foreach ($totales as $t) {
	        	$cc2++;
	        	if($cc2 == 1){
	        		$colcab= $coltot;
	        		++$colcab;
	        		$lincab = $lin2-1;
	        		$xls->getActiveSheet()    
			            ->setCellValue($colcab.$lincab,'Gravado')
	    	        ;
			        	$xls->getActiveSheet()->getStyle($colcab.$lincab)->getAlignment()->setHorizontal('center');
	        		++$colcab;

	    	    	$xls->getActiveSheet()    
			            ->setCellValue($colcab.$lincab,'Exento')
	    	    	;	
			        	$xls->getActiveSheet()->getStyle($colcab.$lincab)->getAlignment()->setHorizontal('center');

	        	}

	        	if($cc == 4){
	        		++$coltot;
	        		++$coltot;
	        		++$coltot;
	        		$cc = 0;
	        		$lintot = 6;
	        		$cc2=0;
	        		$lin2=6;
	        	}
	        	$cc++;
	        	$coltdg= $coltot;
	        	++$coltdg;
	        	$coltde = $coltdg;
	        	++$coltde;
		   		$xls->getActiveSheet()    
		            ->setCellValue($coltot.$lintot,'Total '.$t->CONCEPTO.'('.$t->TIPO.'-'.$t->CLAVE.')')
		            ->setCellValue($coltdg.$lintot,'$ '.number_format($t->GRAVADO,2))
		            ->setCellValue($coltde.$lintot,'$ '.number_format($t->EXENTO,2))
	    	    ;
	    	    //$xls->getActiveSheet()->getStyle($coltot.$lintot)->getAlignment()->setHorizontal('right');
	    	    $xls->getActiveSheet()->getStyle($coltdg.$lintot)->getAlignment()->setHorizontal('right');
	    	    $xls->getActiveSheet()->getStyle($coltde.$lintot)->getAlignment()->setHorizontal('right');

	            $lintot++;
	   		}
	       
	        $xls->getActiveSheet()
	            ->setCellValue('C3','Fecha del Emisión: '.date("d-m-Y H:n:s"))
	            ->setCellValue('C4','Emite: '.$usuario)
	            ;
	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:'.$colc.'1');
	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando
	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	    
	        //// Crear una nueva hoja 
	            //$xls->createSheet();
	        /// Crear una nueva hoja llamada Mis Datos
	        /// Descargar
	        	$rfc=$_SESSION['empresa']['rfc'];
	            if($_SESSION['servidor']!='Debian'){
	            	$ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            }else{
	            	//$ruta='/home/ofarias/xmls/nominas/'.$rfc.'/';
	            	$ruta= '/var/www/html/ftc/nominas/'.$rfc.'/';
	            }

	            if(!is_dir($ruta)){
	            	mkdir( $ruta,  0777, true );
	            }

	            $nom='Reporte de Nomina '.$df->RAZON_SOCIAL.' '.$ff.'.xlsx';
	            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
	        	$x->save($ruta.$nom);
	            ob_end_clean();
	            if($_SESSION['servidor']!='Debian'){
	        		return array("status"=>'ok', "archivo"=>$nom, "ruta"=>"../EdoCtaXLS/".$nom, "tipo"=>'windows');
	            }else{
	            	return array("status"=>'ok', "archivo"=>$nom, "ruta"=>'/ftc/nominas/'.$rfc.'/'.$nom, "tipo"=>'debian');
	            }
	}

	function calImp($mes, $anio ){
		if($_SESSION['user']){
			$data=new cargaXML;
			$datap = new pegaso;
			$rfcempresa = $_SESSION['rfc'];
			$info=$data->calImp($mes, $anio);
			$ventas = $data->traeVentas($anio, $mes, 'gen'); /// inicia la modificacion para filtrar meses.
			$ant = $data->traeAnticipos($anio, $mes, 'gen');
			$pfin = $data->traeProdFinan($anio, $mes, 'gen');
			$oIng = $data->traeOtrIng($anio);
			$isr = $data->traeIsr($anio);
			//$totMen = $data->totalMensual($anio, $)
			$info = $data->infoMesIsr($anio);
			$files = $data->ftc_files($tipo = 'IMPUESTO', $subtipo='ID_ISR', $anio);
			$meses = $datap->traeMeses();
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Impuestos/p.calImp.php');
   			ob_start();
   			include 'app/views/pages/Impuestos/p.calImp.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function setCU( $cu, $anio, $tipo){
		$data= new cargaXML;
		$res=$data->setCU($cu, $anio, $tipo);
		return $res;
	}

	function setISR($anio, $val, $tipo){
		if($_SESSION['user']){
			$data=new cargaXML;
			$res = $data->setISR($anio, $val, $tipo);
			return $res;
		}
	}

	function gIsr($mes, $anio, $datos){
		if ($_SESSION['user']) {
			$data = new cargaXML;
			$res = $data->gIsr($mes, $anio, $datos);
			return $res;
		}
	}

	function verProv($mes, $anio, $ide, $doc){
		if($_SESSION['user']){
			$data = new cargaXML;
			$data = new pegaso;
			
			$user=$_SESSION['user']->NOMBRE;
  			$cnxcoi=$_SESSION['cnxcoi'];
  			$uuid='D';
    		$info=$data->verXMLSP_Prov($mes, $anio, $ide, $uuid, $doc);
    		$tipoDOC = $data->traeTipo();

			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.verProv.php');
   			ob_start();
   			include 'app/views/pages/xml/p.verProv.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function polFred($datos, $cta, $tipo, $mes, $anio){
		if($_SESSION['user']){
			$data = new cargaXML;
			$data_coi = new CoiDAO;
			$documentos = $data->traeDocs($datos, $tipo);
			$impuestos2=$data->impuestosPolizaFred($documentos, $por='1');
			$crear = $data_coi->creaPolizaFred($cabecera = false , $detalle=$documentos, $tipo='gasto', $impuestos2, $z=$cta, $anio, $mes);
			exit();
		}
	}

	function gp($mes, $anio, $monto){
		if($_SESSION['user']){
			$data = new cargaXML;
			$res =$data->gp($mes, $anio, $monto);
			return $res;
		}
	}

	function gCompISR($mes, $anio, $files, $ruta, $tipo, $nmes){
		if($_SESSION['user']){
			$data = new cargaXML;
			$res = $data->gCompISR($mes, $anio, $files, $ruta, $tipo, $nmes);
			return $res;
		}
	}

	function calImpIva($mes, $anio){
		if($_SESSION['user']){
			$data = new cargaXML;
			$cargos = $data->docPg($mes, $anio);
			$abonos = $data->docCb($mes, $anio);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Impuestos/p.calImpIva.php');
   			ob_start();
   			include 'app/views/pages/Impuestos/p.calImpIva.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function calDiot($mes, $anio, $tipo){
		if($_SESSION['user']){
			$data = new cargaXML;
			$cargos = $data->docPg($mes, $anio, $tipo);
			$pagina=$this->load_template();
			if($tipo=='d'){
				$html=$this->load_page('app/views/pages/Impuestos/p.calDiotDet.php');
	   			ob_start();
	   			include 'app/views/pages/Impuestos/p.calDiotDet.php';   				
			}else{
				$html=$this->load_page('app/views/pages/Impuestos/p.calDiot.php');
	   			ob_start();
	   			include 'app/views/pages/Impuestos/p.calDiot.php';   				
			}
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function isrDet($mes, $anio, $tipo){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->isrDet($mes, $anio, $tipo);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Impuestos/p.isrDet.php');
   			ob_start();
   			include 'app/views/pages/Impuestos/p.isrDet.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;	
		}
	}

	function gpd($po, $pt, $rfc){
		if($_SESSION['user']){
			$data = new cargaXML;
			$res =$data->gpd($po, $pt, $rfc);
			return $res;
		}
	}

	function infoProv($rfc, $tipo){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->infoProv($rfc, $tipo);
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.infoProv.php');
   			ob_start();
   			include 'app/views/pages/xml/p.infoProv.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;	
		}
	}

	function setTD($rfc, $t, $t2, $t3){
		if($_SESSION['user']){
			$data = new cargaXML;
			$res=$data->setTD($rfc, $t, $t2, $t3);
			return $res;
		}
	}

	function gxf($a, $m, $i, $d){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->gxf($a, $m, $i, $d );
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/xml/p.gxf.php');
   			ob_start();
   			include 'app/views/pages/xml/p.gxf.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;	
		}
	}

	function rgxf($u){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->rgxf($u);
			$pagina = $this->load_template();
			$html = $this->load_page('app/views/pages/xml/p.rgxf.php');
   			ob_start();
   			include 'app/views/pages/xml/p.rgxf.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;	
		}	
	}

	function getDoc($doc){
		$data= new cargaXML;
		$exec=$data->getDoc($doc);
		return $exec;
	}

	function cancelados($opc){
		if($_SESSION['user']){
			$data = new cargaXML;
			$info = $data->cancelados($opc);
			$pagina = $this->load_template();
			$html = $this->load_page('app/views/pages/xml/p.cancelados.php');
   			ob_start();
   			include 'app/views/pages/xml/p.cancelados.php';   			
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;	
		}	
	}

	function buscaPol($uuid){
		$data = new cargaXML;
		$res = $data->buscaPol($uuid);
		return $res;
	}

	function repRet($fi, $ff){
		$data = new cargaXML;
		$data2 = new pegaso;
		$datos = $data->repRet($fi, $ff);
		$xls = new PHPExcel();
		$usuario=$_SESSION['user']->NOMBRE;
		$ln = 10;
		$df = $data2->traeDF($ide = 1);
		
		$col = 'A';
		$xls->getActiveSheet()
		        ->setCellValue('A1','Reporte de Retenciones en Excel');
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
	        $xls->getActiveSheet()->getColumnDimension($col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(40);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(30);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(55);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);

	        

	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	    $col = 'A';
	        $xls->getActiveSheet()
	            ->setCellValue($col.$ln,'Año')
	            ->setCellValue(++$col.$ln,'Mes')
	            ->setCellValue(++$col.$ln,'Nombre Impuesto')
	            ->setCellValue(++$col.$ln,'Impuesto ')
	            ->setCellValue(++$col.$ln,'Tasa')
	            ->setCellValue(++$col.$ln,'Monto')
	            ->setCellValue(++$col.$ln,'Partida')
	            ->setCellValue(++$col.$ln,'UUID')
	            ->setCellValue(++$col.$ln,'Factura')
	            ->setCellValue(++$col.$ln,'Tipo Factor')
	            ->setCellValue(++$col.$ln,'Base')
	            ->setCellValue(++$col.$ln,'Tipo')
	            ->setCellValue(++$col.$ln,'Status')
	            ->setCellValue(++$col.$ln,'RFCE')
	            ->setCellValue(++$col.$ln,'Nombre')
	            ->setCellValue(++$col.$ln,'Cliente')
	            ->setCellValue(++$col.$ln,'Documento')
	            ->setCellValue(++$col.$ln,'Fecha')
	            ->setCellValue(++$col.$ln,'Subtotal')
	            ->setCellValue(++$col.$ln,'Importe')
	        ;

	        $ln = 11;
	        foreach($datos as $row){
	        	$col='A';
	        	$xls->getActiveSheet()
	            	->setCellValue($col.$ln,$row->ANIO)
	            	->setCellValue(++$col.$ln, $row->MES)
	            	->setCellValue(++$col.$ln, $row->NOMBRE_IMPUESTO)
	            	->setCellValue(++$col.$ln, $row->IMPUESTO)
	            	->setCellValue(++$col.$ln, $row->TASA)
	            	->setCellValue(++$col.$ln, $row->MONTO)
	            	->setCellValue(++$col.$ln, $row->PARTIDA)
	            	->setCellValue(++$col.$ln, $row->UUID)
	            	->setCellValue(++$col.$ln, $row->FACTURA)
	            	->setCellValue(++$col.$ln, $row->TIPOFACTOR)
	            	->setCellValue(++$col.$ln, $row->BASE)
	            	->setCellValue(++$col.$ln, $row->TIPO)
	            	->setCellValue(++$col.$ln, $row->STATUS)
	            	->setCellValue(++$col.$ln, $row->RFCE)
	            	->setCellValue(++$col.$ln, $row->NOMBRE)
	            	->setCellValue(++$col.$ln, $row->CLIENTE)
	            	->setCellValue(++$col.$ln, $row->DOCUMENTO)
	            	->setCellValue(++$col.$ln, $row->FECHA)
	            	->setCellValue(++$col.$ln, $row->SUBTOTAL)
	            	->setCellValue(++$col.$ln, $row->IMPORTE)
	            ;
	            $ln++;
	        }

	        $xls->getActiveSheet()
	            ->setCellValue('A3','Reporte de Retenciones:')
	            ->setCellValue('A4','Fecha de Emision del Reporte: ')
	            ->setCellValue('A5','Total de Movimientos: ')
	            ->setCellValue('A6','')
	            ->setCellValue('A7','Usuario Elabora')
	            ->setCellValue('A8','')
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('E3','')
	            ->setCellValue('E4',date('d-m-Y H:i:s'))
	            ->setCellValue('E5',count($datos))
	            ->setCellValue('E6','')
	            ->setCellValue('E7',$usuario)
	            ->setCellValue('E8','')
	            ;
	        /// Unir celdas
	        $xls->getActiveSheet()->mergeCells('A1:L1');
	        // Alineando
	        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
	        /// Estilando
	        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
	            array('font' => array(
	                    'size'=>20,
	                )
	            )
	        );
	        
		$ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	    $nom='Reporte retenciones '.$fi.' al '.$ff.' '.date("s").'.xlsx';
	    //$nom='repRet.xlsx';
	    $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
		$x->save($ruta.$nom);
	    ob_end_clean();
	    $htmlPath= "..//EdoCtaXLS//".$nom;
	    return array("status"=>'ok',"archivo"=>$ruta.$nom, "htmlPath"=>$htmlPath);
	}

	function acomodoXml($t){
		if($_SESSION['user']){
			$data = new acomodoXML;
			if($t == 1){
				$path = "\\\\DORIS\\Emitidos";
				//$path = 'C:\\elcfdi\\DescargaMasiva\\Emitidos\\';
				$path = $data->mapeo();
				$info = $data->acomodo($path);
			}elseif($t==2){
				echo 'analiza XML';
				//$analisis = $data->analiza();
				$exec = $data->xmlDebian();
				$exec = $data->xmlDebianNom();
			}elseif($t == 3){
				$rutaImagenes = "C:\\Users\\Administrador\\Downloads\\portadas-paidotribo\\";
				$rutaXLS="C:\\Users\\Administrador\\Downloads\\portadas-paidotribo\\lista.xlsx";
				$info=$data->nombraImagenes($rutaImagenes, $rutaXLS);
			}elseif($t == 4){
				$exe =$data->revisaImagen(); 
			}
			return;
		}
	}

	function revisaCarga($uuid){
		$data = new cargaXML;
		$res = $data->revisaCarga($uuid);
		return $res;
	}

}?>

