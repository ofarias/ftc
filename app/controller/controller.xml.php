
<?php
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/model/database.xmlTools.php');
require_once('app/model/db.contabilidad.php');
require_once('app/model/cargaXML.php');
require_once('app/controller/controller.xml.php');

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
            $target_dir="C:/xampp/htdocs/uploads/xml/metaData/";
            if(!file_exists($target_dir)){
            	mkdir($target_dir);
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

	function xmlExcel($mes, $anio, $ide, $doc, $t){
		if($_SESSION['user']){
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
	            if($l_g < strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE)) ){
	            	$l_g = strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE));
	            }
	            if($l_h < strlen('('.$key->RFCE.')'.$key->EMISOR)){
	            	$l_h = strlen('('.$key->RFCE.')'.$key->EMISOR);
	            }
	            $rel = '';
	            if($doc == 'Pago'){
	            	$rel = $key->CEPA;
	            }else{
	            	$rel = $key->RELACIONES;
	            }
	            $status = $key->STATUS != 'C'? 'Vigente':'Cancelado';
	            $maestro=$key->UUID;
	            $totalSaldo += $key->IMPORTEXML;
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$i)
	                ->setCellValue('B'.$ln,$key->POLIZA)
	                ->setCellValue('C'.$ln,$key->UUID)
	                ->setCellValue('D'.$ln,$rel)
	                ->setCellValue('E'.$ln, $status)
	                ->setCellValue('F'.$ln,$doc)
	                ->setCellValue('G'.$ln,$key->SERIE.$key->FOLIO)
	                ->setCellValue('H'.$ln,$key->FECHA)
	                ->setCellValue('I'.$ln,$key->CLIENTE)
	                ->setCellValue('J'.$ln,utf8_encode($key->NOMBRE))
	                ->setCellValue('K'.$ln,$key->RFCE)
	                ->setCellValue('L'.$ln, utf8_encode($key->EMISOR))
	                ->setCellValue('M'.$ln, $key->CONCEPTO)
	                ->setCellValue('N'.$ln, $key->FORMAPAGO)
	                ->setCellValue('O'.$ln, $key->METODOPAGO)
	                ->setCellValue('P'.$ln, $key->CUENTA_CONTABLE)	                
	                ->setCellValue('Q'.$ln,$key->SUBTOTAL)//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue('R'.$ln,$key->IVA160)//number_format($key->IVA,2,".",""))
	                ->setCellValue('S'.$ln,$key->IVA_RET)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue('T'.$ln,$key->IEPS)//number_format($key->IEPS,2,".",""))
	                ->setCellValue('U'.$ln,$key->IEPS_RET)//number_format($key->IEPS_RET,2,".",""))
	                ->setCellValue('V'.$ln,$key->ISR_RET)//number_format($key->ISR_RET,2,".",""))
	                ->setCellValue('W'.$ln,$key->DESCUENTO)//number_format($key->DESCUENTO,2,".",""))
	                ->setCellValue('X'.$ln,$key->IMPORTEXML)//number_format($key->IMPORTEXML,2,".",""))
	                ->setCellValue('Y'.$ln,$key->SALDO_XML)
	                ->setCellValue('Z'.$ln,$key->MONEDA)//number_format($key->MONEDA),".","")
	                ->setCellValue('AA'.$ln,$key->TIPOCAMBIO)//number_format($key->TIPOCAMBIO),".","")
	                
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
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(45);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(17);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth($l_h);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('T')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('U')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('V')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('W')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('X')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('Z')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('AA')->setWidth(13);

	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','Sta')
	            ->setCellValue('C9','UUID')
	            ->setCellValue('D9','UUID RELACIONADOS')
	            ->setCellValue('E9','ESTATUS')
	            ->setCellValue('F9','TIPO')
	            ->setCellValue('G9','FOLIO')
	            ->setCellValue('H9','FECHA')
	            ->setCellValue('I9','RFC RECEPTOR')
	            ->setCellValue('J9','NOMBRE RECEPTOR')
	            ->setCellValue('K9','RFC EMISOR')
	            ->setCellValue('L9','NOMBRE EMISOR')
	            ->setCellValue('M9','CONCEPTO')
	            ->setCellValue('N9','FORMA DE PAGO')
	            ->setCellValue('O9','METODO DE PAGO')	            
	            ->setCellValue('P9','CUENTA CONTABLE')
	            ->setCellValue('Q9','SUBTOTAL')
	            ->setCellValue('R9','IVA')
	            ->setCellValue('S9','RETENCION')
	            ->setCellValue('T9','IEPS')
	            ->setCellValue('U9','RETENCION IEPS')
	            ->setCellValue('V9','RETENCION ISR')
	            ->setCellValue('W9','DESCUENTO')
	            ->setCellValue('X9','TOTAL')
	            ->setCellValue('Y9','SALDO')
	            ->setCellValue('Z9','MON')
	            ->setCellValue('AA9','TC')
	            
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
	        	}elseif($ide == 'Recibidos'){
					$proveedor='('.$key->RFCE.')'.utf8_encode($key->NOMBRE);
	        		$cliente='('.$key->CLIENTE.')'.utf8_encode($key->EMISOR);
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
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$i)
	                ->setCellValue('B'.$ln,$key->STATUS)
	                ->setCellValue('C'.$ln,$key->UUID)
	                ->setCellValue('D'.$ln,$key->TIPO)
	                ->setCellValue('E'.$ln,$key->SERIE.$key->FOLIO)
	                ->setCellValue('F'.$ln,$key->FECHA)
	                ->setCellValue('G'.$ln,$cliente)
	                ->setCellValue('H'.$ln,$proveedor)
	                ->setCellValue('I'.$ln,$key->PARTIDA)//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue('J'.$ln,utf8_encode($key->DESCRIPCION))//number_format($key->IVA,2,".",""))
	                ->setCellValue('K'.$ln,$key->UNIDAD_SAT)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue('L'.$ln,utf8_encode($key->DESC_UNIDAD))
	                ->setCellValue('M'.$ln,$key->CLAVE_SAT)//number_format($key->IEPS,2,".",""))
	                ->setCellValue('N'.$ln,utf8_encode($key->DESC_CLAVE))
	                ->setCellValue('O'.$ln,$key->CUENTA_CONTABLE)//number_format($key->IEPS_RET,2,".",""))
	                ->setCellValue('P'.$ln,$key->CANTIDAD)//number_format($key->ISR_RET,2,".",""))
	                ->setCellValue('Q'.$ln,$key->UNITARIO)//number_format($key->DESCUENTO,2,".",""))
	                ->setCellValue('R'.$ln,$key->PDESCUENTO)//number_format($key->IMPORTEXML,2,".",""))
	                ->setCellValue('S'.$ln,$key->MONEDA)//number_format($key->MONEDA),".","")
	                ->setCellValue('T'.$ln,$key->TIPOCAMBIO)//number_format($key->TIPOCAMBIO),".","")
	                ->setCellValue('U'.$ln,(($key->CANTIDAD*$key->UNITARIO) - ($key->PDESCUENTO)) )// Subtotal
	                ->setCellValue('V'.$ln,$key->PIVA) // Iva
	                ->setCellValue('W'.$ln,$key->PIEPS) // IEPS
	                ->setCellValue('X'.$ln,$key->PISR) // ISR
	                ->setCellValue('Y'.$ln,(($key->PIMPORTE - $key->PDESCUENTO) + $key->PIVA +$key->PIEPS + $key->PISR) ) // Total
	                ->setCellValue('Z'.$ln,'')
	                ->setCellValue('ZA'.$ln,'')
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
	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth($l_f);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth($l_h);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth($l_d);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth($l_us);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth($l_ds);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('T')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('U')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('V')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('W')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('X')->setWidth(8);
	        $xls->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('ZA')->setWidth(10);
	        $xls->getActiveSheet()->getColumnDimension('ZB')->setWidth(10);
	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','Sta')
	            ->setCellValue('C9','UUID')
	            ->setCellValue('D9','TIPO')
	            ->setCellValue('E9','FOLIO')
	            ->setCellValue('F9','FECHA')
	          	->setCellValue('G9','RECEPTOR')
	            ->setCellValue('H9','EMISOR')
	            ->setCellValue('I9','PARTIDA')
	            ->setCellValue('J9','DESCRIPCION')
	            ->setCellValue('K9','UNIDAD SAT')
	            ->setCellValue('L9','DESCRIPCION')
	            ->setCellValue('M9','CLAVE SAT')
	            ->setCellValue('N9','DESCRIPCION')
	            ->setCellValue('O9','CUENTA CONTABLE')
	            ->setCellValue('P9','CANTIDAD')
	            ->setCellValue('Q9','PRECIO')
	            ->setCellValue('R9','DESCUENTO')
	            ->setCellValue('S9','MONEDA')
	            ->setCellValue('T9','TIPO CAMBIO')
	            ->setCellValue('U9','SUBTOTAL')
	            ->setCellValue('V9','IVA')
	            ->setCellValue('W9','IEPS')
	            ->setCellValue('X9','ISR')
	            ->setCellValue('Y9','TOTAL')
	            ->setCellValue('Z9','')
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

	function nomXML($a, $m){
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
			$pagina=$this->load_template();
			$html=$this->load_page('app/views/pages/Nomina/m.nominasXML.php');
   			ob_start();
   			include 'app/views/pages/Nomina/m.nominasXML.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
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
				$res=$this->repNomina($fi, $ff, $columnas, $datos, $lineas);
				return $res;
				exit();
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

		for ($i=0; $i < 3; $i++){
			$xls->setActiveSheetIndex()
	            ->setCellValue($colc.$ln,$columnas[$i])
	        ;	
			++$colc;
		}

		for ($i=3; $i < count($columnas); $i++){
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
	    for ($i=3; $i < count($columnas); $i++){
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
	    for ($i=3; $i < count($columnas); $i++){
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

	        //// revisar hasta aqui las columnas de Totales 
	    $ln++;

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
                    	->setCellValue($col.$ln,$d->NOMBRE)
                    ;
                    break;
            	}
            }
            $h=3;
            $c=3;
            for($i=3;$i<count($columnas);$i++){
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
	        
            for($i=3;$i<count($columnas);$i++){
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
	        for($i=3;$i<count($columnas);$i++){
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
	            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
	            $nom='Reporte de Nomina '.$df->RAZON_SOCIAL.' '.$fi.'.xlsx';
	            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	            //header("Content-Disposition: attachment;filename=01simple.xlsx");
	            //header('Cache-Control: max-age=0');
	        /// escribimos el resultado en el archivo;
	            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
	        /// salida a descargar
	            $x->save($ruta.$nom);
	            ob_end_clean();
	            //echo 'Se crea el archivo: '.$ruta.$nom;
	        return array("status"=>'ok', "archivo"=>$nom, "ruta"=>"../EdoCtaXLS/".$nom);
	        //$x->save('php://output');
	        /// salida a ruta :
	}

}?>

