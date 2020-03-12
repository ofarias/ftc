
<?php
require_once('app/model/model.serv.php');
require_once('app/model/pegaso.model.ventas.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');

class ctrl_serv{
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

	function mServ(){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Tickets');
			$html=$this->load_page('app/views/modules/m.mSERV.php');
   			ob_start();
   			include 'app/views/modules/m.mSERV.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	
	function tickets($temp){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Tickets');
			$html=$this->load_page('app/views/pages/servicio/p.tickets.php');
			$tcks = $data->tickets($temp);
   			ob_start();
   			include 'app/views/pages/servicio/p.tickets.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		
		}
	}

	function nuevoTicket($clie){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template2('Tickets');
			$html=$this->load_page('app/views/pages/servicio/p.nuevoTicket.php');
			$cl = $data->traeClientes();
			$us = $data->traeUsuarios($clie);
			$eq = $data->traeEquipos($clie);
			$tp = $data->traeTipos();
			$so = $data->traeSistemas();
			$md = $data->traeModos();
   			ob_start();
   			include 'app/views/pages/servicio/p.nuevoTicket.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		
		}	
	}

	function invServ(){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Tickets');
			$html=$this->load_page('app/views/pages/servicio/p.invServ.php');
			$clie = '';
			$eq = $data->traeEquipos($clie);
			ob_start();
   			include 'app/views/pages/servicio/p.invServ.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}			
	}

	function usuarios(){
		if($_SESSION['user']){
			$data = new data_serv;
			$data_p = new pegaso_ventas;
			$pagina =$this->load_template('Alta de Usuarios');
			$html=$this->load_page('app/views/pages/servicio/p.usuarios.php');
			$clie= '';
			$us = $data->traeUsuarios($clie);
			ob_start();
   			include 'app/views/pages/servicio/p.usuarios.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function altaUsuario($clie){
		if($_SESSION['user']){
			$data = new data_serv;
			$data_p = new pegaso_ventas;
			$pagina =$this->load_template2('Alta de Usuarios');
			$html=$this->load_page('app/views/pages/servicio/p.altaUsuario.php');
			$cl = $data->traeClientes();
			ob_start();
   			include 'app/views/pages/servicio/p.altaUsuario.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function nuevoUsuario($cliente, $nombre, $segundo, $paterno, $materno, $correo, $telefono, $extension, $cargo){
		if($_SESSION['user']){
			$data = new data_serv;
			$nuevo = $data->nuevoUsuario($cliente, $nombre, $segundo, $paterno, $materno, $correo, $telefono, $extension, $cargo);
			$pagina =$this->load_template('Alta de Equipos');
			if($nuevo['status']== 'ok'){
				echo "<script>alert('Se ha creado el usuario')</script>";
			}else{
				echo "<script>alert('Encontramos un error al procesar el Alta, Favor de revisar la informacion')</script>";
			}
			ob_start();
			$redireccionar = "altaUsuario&cliente={$cliente}";
			$html = $this->load_page('app/views/pages/servicio/p.redirectform.serv.php');
			include 'app/views/pages/servicio/p.redirectform.serv.php';
			$this->view_page($pagina);
		}
		return;
	}

	function altaEquipo($clie){
		if($_SESSION['user']){
			$data = new data_serv;
			$data_p = new pegaso_ventas;
			$pagina =$this->load_template2('Alta Equipos');
			$html=$this->load_page('app/views/pages/servicio/p.altaEquipo.php');
			$cl = $data->traeClientes();
			$us = $data->traeUsuarios($clie);
			$mc = $data_p->traeMarcas();
			$pr = $data->traeProcesadores();
			$so = $data->traeSistemas();
			ob_start();
   			include 'app/views/pages/servicio/p.altaEquipo.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}			
	}

	function nuevoEquipo($cliente,$usuario,$equipo,$ad_name,$marca,$modelo,$procesador,$so,$dom,$senia,$hdd_inst,$dd_principal,$mem_inst,$mem_max,$t_memoria,$ns,$correo,$tv,$tvc,$t_ip,$ip,$mac,$rdp,$area,$anio,$eth,$obs){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Alta de Equipos');
			$alta=$data->nuevoEquipo($cliente,$usuario,$equipo,$ad_name,$marca,$modelo,$procesador,$so,$dom,$senia,$hdd_inst,$dd_principal,$mem_inst,$mem_max,$t_memoria,$ns,$correo,$tv,$tvc,$t_ip,$ip,$mac,$rdp,$area,$anio,$eth,$obs);
			ob_start();
			if($alta['status'] == 'ok'){
				echo "<script>alert('Se ha ingresado correctamente')</script>";
			}else{
				echo "<script>alert('Encontramos un error al procesar el Alta, Favor de revisar la informacion')</script>";
			}
			$redireccionar = "altaEquipo&cliente={$cliente}";
			$html = $this->load_page('app/views/pages/servicio/p.redirectform.serv.php');
			include 'app/views/pages/servicio/p.redirectform.serv.php';
			$this->view_page($pagina);
   			//echo "<script>alert('Se guardo la informacion')</script>";
   			//echo "<script>window.close()</script>";
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	

	}

	function creaTicket($cliente, $reporta, $usuario, $equipo, $fecha, $tipo, $sistema, $corta, $completa, $solucion, $modo, $cierre){
		if($_SESSION['user']){
			$data = new data_serv;
			$crea = $data->creaTicket($cliente, $reporta, $usuario, $equipo, $fecha, $tipo, $sistema, $corta, $completa, $solucion, $modo, $cierre);
			$x = $crea['mensaje'];
			if($crea['status']== 'ok'){
				echo "<script>alert('$x')</script>";
				$_SESSION['info'] = $crea['info'];
				include 'app/views/pages/servicio/send.aviso.php';
				$redireccionar = "nuevoTicket&cli={$cliente}";
				$pagina =$this->load_template('Alta de Equipos');
				$html = $this->load_page('app/views/pages/servicio/p.redirectform.serv.php');
				include 'app/views/pages/servicio/p.redirectform.serv.php';
				$this->view_page($pagina);
			}else{

			}
			return;
		}
	}

	function verDetalleTicket($id){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Detalle Ticket');
			$t=$data->verDetalleTicket($id);
			foreach ($t as $key) {
				$clie = $key->ID_CLIE;
			}
			$cl = $data->traeClientes();
			$us = $data->traeUsuarios($clie);
			$eq = $data->traeEquipos($clie);
			$tp = $data->traeTipos();
			$so = $data->traeSistemas();
			$md = $data->traeModos();
			ob_start();
			$html = $this->load_page('app/views/pages/servicio/p.verDetalleTicket.php');
			include 'app/views/pages/servicio/p.verDetalleTicket.php';
			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}		
	}

	function cargaArchivo($file, $servicio, $tipo, $origen, $ubicacion, $nombre, $tamano, $tipo_archivo, $obs, $emp, $tipo_Doc){
		if($_SESSION['user']){
			$data = new data_serv;
			$carga = $data->cargaArchivo($file, $servicio, $tipo, $origen, $ubicacion, $nombre, $tamano, $tipo_archivo, $obs, $emp, $tipo_Doc);
			$redireccionar = 'tickets';
			$pagina =$this->load_template('Alta de Equipos');
			$html = $this->load_page('app/views/pages/servicio/p.redirectform.serv.php');
			include 'app/views/pages/servicio/p.redirectform.serv.php';
			$this->view_page($pagina);
		}
	}

	function verArchivos($tipo, $ticket, $clie, $status){
		if($_SESSION['user']){
			$data = new data_serv;
			if(!empty($ticket)){
				$t=$data->verDetalleTicket($id=$ticket);
			}
			$a=$data->verArchivos($tipo, $id=$ticket, $clie, $status);
			ob_start();
			$pagina =$this->load_template2('Archivos del Ticket:');
			$html = $this->load_page('app/views/pages/servicio/p.verArchivos.php');
			include 'app/views/pages/servicio/p.verArchivos.php';
			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

	function bajaFile($idf){
		if ($_SESSION['user']) {
			$data = new data_serv;
			$baja = $data->bajaFile($idf);
			return $baja;
		}
	}

	function reporteServ($periodo, $tipo){
		if($_SESSION['user']){
			$data = new data_serv;
			$info = $data->reporteServ($periodo, $tipo);
			$this->generaReporteExcel($info['principal'], $info['primero'], $info['segundo'], $info['per'],$info['tip']);
			return $info;
		}
	}

	function generaReporteExcel($principal, $primero, $segundo, $per, $tip){
			$xls= new PHPExcel();
	        //// insertamos datos a al objeto excel.
	        // Fecha inicio y fecha fin
	        $usuario =$_SESSION['user']->NOMBRE;
	        $fecha = date('d-m-Y h:i:s');
	        $ln = 10;
	        
	       	$xls->getActiveSheet()
	            ->setCellValue('A9','Atiende')
	            ->setCellValue('B9','No de Servicios')
	        ;

	        foreach ($principal as $key) {
	            $rel = '';
	            $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,$key->ATIENDE)
	                ->setCellValue('B'.$ln,$key->SERVICIOS)
	            ;
	            $ln++;
	        }
	        $ln++;
	        $xls->getActiveSheet()
	            ->setCellValue('A'.$ln,'Atiende')
	            ->setCellValue('B'.$ln,'Cliente')
	            ->setCellValue('C'.$ln,'Servicios')
	        ;
	        $a='';
	        foreach ($primero as $pr) {
	        	$ln++;  		
	        		$b=$pr->ATIENDE; 
	        		if($a != $b){
			       		$xls->setActiveSheetIndex()
		        			->setCellValue('A'.$ln, $pr->ATIENDE)
		        		;
	        		}
	        		$xls->setActiveSheetIndex()
	        			->setCellValue('B'.$ln, $pr->NOMBRE_CLIENTE)
	        			->setCellValue('C'.$ln, $pr->SERVICIOS)
	        		;
	        		$a = $pr->ATIENDE;
	        }

	        $ln++;
	        $xls->getActiveSheet()
	        	->setCellValue('A'.$ln,'Ticket')
	        	->setCellValue('B'.$ln,'Modo de reporte')
	        	->setCellValue('C'.$ln,'Persona que Reporta')
	        	->setCellValue('D'.$ln,'Usuario del incidente')
	        	->setCellValue('E'.$ln,'Fecha')
	        	->setCellValue('F'.$ln,'Fecha del reporte')
	        	->setCellValue('G'.$ln,'Equipo')
	        	->setCellValue('H'.$ln,'Descripcion corta')
	        	->setCellValue('I'.$ln,'Descripcion completa')
	        	->setCellValue('J'.$ln,'Solucion o trabajo realizado')
	        	->setCellValue('K'.$ln,'Estado del ticket')
	        	->setCellValue('L'.$ln,'Fecha de Cierre')
	        	->setCellValue('M'.$ln,'Sistema afectado')
	        	->setCellValue('N'.$ln,'Tipo de Servicio')
	        	->setCellValue('O'.$ln,'Correo Reporta')
	        	->setCellValue('P'.$ln,'Correo Usuario')
	        	->setCellValue('Q'.$ln,'Nombre del Cliente')
	        	->setCellValue('R'.$ln,'Atiende')
	        ;

	        foreach ($segundo as $det) {
	        	$ln++;
	        	$xls->getActiveSheet()
	        		->setCellValue('A'.$ln,	$det->ID)
	        		->setCellValue('B'.$ln, $det->MODO)
	        		->setCellValue('C'.$ln, $det->REPORTA)
	        		->setCellValue('D'.$ln, $det->USUARIO)
	        		->setCellValue('E'.$ln, $det->FECHA)
	        		->setCellValue('F'.$ln, $det->FECHA_REPORTE)
	        		->setCellValue('G'.$ln, $det->EQUIPO)
	        		->setCellValue('H'.$ln, $det->CORTA)
	        		->setCellValue('I'.$ln, $det->COMPLETA)
	        		->setCellValue('J'.$ln, $det->SOLUCION)
	        		->setCellValue('K'.$ln, $det->STATUS)
	        		->setCellValue('L'.$ln, $det->CIERRE)
	        		->setCellValue('M'.$ln, $det->SISTEMA)
	        		->setCellValue('N'.$ln, $det->TIPO)
	        		->setCellValue('O'.$ln, $det->CORREO_REP)
	        		->setCellValue('P'.$ln, $det->CORREO_USU)
	        		->setCellValue('Q'.$ln, $det->NOMBRE_CLIENTE)
	        		->setCellValue('R'.$ln, $det->ATIENDE)
	        	;
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
	        //    $xls->getActiveSheet()
	        //        ->setCellValue('A1',$df->RAZON_SOCIAL);
	        /// CAMBIANDO EL TAMAÑO DE LA LINEA.

	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(80);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(80);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(80);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(80);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(80);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(30);


	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	       
	        //$nom_mes = $this->nombreMes($mes);

	        $xls->getActiveSheet()
	            ->setCellValue('A3','Servicios elaborados '.$per)
	            ->setCellValue('A4','Fecha de Emision del Reporte: '.date('d-m-Y H:i:s'))
	            ->setCellValue('A5','Total de Servicios: '.count($segundo))
	            //->setCellValue('A6','Importe Total de los Documentos: ')
	            ->setCellValue('A6','Usuario Elabora: '.$usuario)
	            ->setCellValue('A7','Tipo de reporte por '.$tip)
	            ;
	        $xls->getActiveSheet()
	            ->setCellValue('D3','')
	            ->setCellValue('D4','')
	            ->setCellValue('D5','')
	            ->setCellValue('D6','')
	            ->setCellValue('D7','')
	            ->setCellValue('D8','')
	            ;
	        /// Unir celdas
	        //$xls->getActiveSheet()->mergeCells('A1:O1');
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
	            if(!file_exists($ruta='C:\\xampp\\htdocs\\media\\reportes\\')){
	            	mkdir($ruta);
				}
	            $nom='Reporte de Servicio por atencion'.'.xlsx';
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

}?>

