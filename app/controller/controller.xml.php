
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
			$res=$data->verXMLSP($mes, $anio, $ide, $uuid=false, $doc);
			$xls= new PHPExcel();
	        //// insertamos datos a al objeto excel.
	        // Fecha inicio y fecha fin
	        $df= $data->traeDF($idem = 1);
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
	            if($l_g < strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE)) ){
	            	$l_g = strlen('('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE));
	            }
	            if($l_h < strlen('('.$key->RFCE.')'.$key->EMISOR)){
	            	$l_h = strlen('('.$key->RFCE.')'.$key->EMISOR);
	            }
	            $maestro=$key->UUID;
	            $totalSaldo += $key->IMPORTEXML;
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$i)
	                ->setCellValue('B'.$ln,$key->POLIZA)
	                ->setCellValue('C'.$ln,$key->UUID)
	                ->setCellValue('D'.$ln,'Ingreso')
	                ->setCellValue('E'.$ln,$key->SERIE.$key->FOLIO)
	                ->setCellValue('F'.$ln,$key->FECHA)
	                ->setCellValue('G'.$ln,'('.$key->CLIENTE.')'.utf8_encode($key->NOMBRE))
	                ->setCellValue('H'.$ln,'('.$key->RFCE.')'.$key->EMISOR)
	                ->setCellValue('I'.$ln,$key->SUBTOTAL)//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue('J'.$ln,$key->IVA160)//number_format($key->IVA,2,".",""))
	                ->setCellValue('K'.$ln,$key->IVA_RET)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue('L'.$ln,$key->IEPS)//number_format($key->IEPS,2,".",""))
	                ->setCellValue('M'.$ln,$key->IEPS_RET)//number_format($key->IEPS_RET,2,".",""))
	                ->setCellValue('N'.$ln,$key->ISR_RET)//number_format($key->ISR_RET,2,".",""))
	                ->setCellValue('O'.$ln,$key->DESCUENTO)//number_format($key->DESCUENTO,2,".",""))
	                ->setCellValue('P'.$ln,$key->IMPORTEXML)//number_format($key->IMPORTEXML,2,".",""))
	                ->setCellValue('Q'.$ln,$key->MONEDA)//number_format($key->MONEDA),".","")
	                ->setCellValue('R'.$ln,$key->TIPOCAMBIO)//number_format($key->TIPOCAMBIO),".","")
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
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth($l_h);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(5);
	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','Sta')
	            ->setCellValue('C9','UUID')
	            ->setCellValue('D9','TIPO')
	            ->setCellValue('E9','FOLIO')
	            ->setCellValue('F9','FECHA')
	            ->setCellValue('G9','RFC RECEPTOR')
	            ->setCellValue('H9','RFC EMISOR')
	            ->setCellValue('I9','SUBTOTAL')
	            ->setCellValue('J9','IVA')
	            ->setCellValue('K9','RETENCION IVA')
	            ->setCellValue('L9','IEPS')
	            ->setCellValue('M9','RETENCION IEPS')
	            ->setCellValue('N9','RETENCION ISR')
	            ->setCellValue('O9','DESCUENTO')
	            ->setCellValue('P9','TOTAL')
	            ->setCellValue('Q9','MON')
	            ->setCellValue('R9','TC')
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
	            if($l_g < strlen($key->NOMBRE)){
	            	$l_g = strlen($key->NOMBRE);
	            }
	            $abono=$key->DEBE_HABER=='H'? $key->MONTOMOV:0;
	            $cargo=$key->DEBE_HABER=='D'? $key->MONTOMOV:0;
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$i)
	                ->setCellValue('B'.$ln,$key->TIPO_POLI)
	                ->setCellValue('C'.$ln,$key->NUM_POLIZ)
	                ->setCellValue('D'.$ln,$key->ORIGEN)
	                ->setCellValue('E'.$ln,$key->NUM_PART)
	                ->setCellValue('F'.$ln,$key->PERIODO)
	                ->setCellValue('G'.$ln,$key->FECHA_POL)
	                ->setCellValue('H'.$ln,$key->NUM_CTA)
	                ->setCellValue('I'.$ln,utf8_encode($key->NOMBRE))//number_format($key->SUBTOTAL,2,".",""))
	                ->setCellValue('J'.$ln,$abono)//number_format($key->IVA,2,".",""))
	                ->setCellValue('K'.$ln,$cargo)//number_format($key->IVA_RET,2,".",""))
	                ->setCellValue('L'.$ln,$key->TIPCAMBIO)
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
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth($l_g);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(13);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(13);
	        
	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	        $xls->getActiveSheet()
	            ->setCellValue('A9','Ln')
	            ->setCellValue('B9','Tipo')
	            ->setCellValue('C9','Numero')
	            ->setCellValue('D9','Origen')
	            ->setCellValue('E9','Partida')
	            ->setCellValue('F9','Periodo')
	            ->setCellValue('G9','Fecha Poliza')
	            ->setCellValue('H9','Cuenta')
	            ->setCellValue('I9','Nombre')
	            ->setCellValue('J9','Cargo')
	            ->setCellValue('K9','Abono')
	            ->setCellValue('L9','Tipo de Cambio')
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
}?>

