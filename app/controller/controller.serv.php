
<?php
require_once('app/model/model.serv.php');
require_once('app/model/pegaso.model.ventas.php');
require_once('app/fpdf/fpdf.php');
require ('app/dompdf/autoload.inc.php');
require_once('app/views/unit/commonts/numbertoletter.php');
use Dompdf\Dompdf;


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
	
	function tickets($t){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Tickets');
			$html=$this->load_page('app/views/pages/servicio/p.tickets.php');
			$tcks = $data->tickets($t);
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

	function invServ($clie, $t){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template('Tickets');
			$html=$this->load_page('app/views/pages/servicio/p.invServ.php');
			$cli=$data->traeClientes();
			$eq=$data->traeEquipos($clie);
			if($t == 'x'){
				$xls=$this->generaXLS($clie, $t, $c, $eq, $cli);
			}
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
			$a=$this->generaReporteExcel($info['principal'], $info['primero'], $info['segundo'], $info['per'],$info['tip']);
			return $a;
		}
	}

	function generaXLS($clie, $t, $c, $data, $data1){
		$xls = new PHPExcel();
		$usuario = $_SESSION['user']->NOMBRE; 
		$fecha = date('d-m-Y h:i:s');
		$ln = 10;

			//$xls->getActiveSheet()
	        //    ->setCellValue('A9','Atiende')
	        //    ->setCellValue('B9','No de Servicios')
	        //;

	        //foreach ($principal as $key) {
	        //    $rel = '';
	        //    $xls->setActiveSheetIndex()
	        //        ->setCellValue('A'.$ln,$key->ATIENDE)
	        //        ->setCellValue('B'.$ln,$key->SERVICIOS)
	        //    ;
	        //    $ln++;
	        //}
	        $ln++;
	        //$xls->getActiveSheet()
	        //    ->setCellValue('A'.$ln,'Atiende')
	        //    ->setCellValue('B'.$ln,'Cliente')
	        //    ->setCellValue('C'.$ln,'Servicios')
	        //;
	        /*
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
			*/
	        $ln++;
	        for ($i=0; $i < 19; $i++) { 
	        	$Col= 'A';
	        	$xls->getActiveSheet()
		        	->setCellValue($Col++.$ln,'Ln')
		        	->setCellValue($Col++.$ln,'Id')
		        	->setCellValue($Col++.$ln,'Cliente')
		        	->setCellValue($Col++.$ln,'Usuario')
		        	->setCellValue($Col++.$ln,'Tipo')
		        	->setCellValue($Col++.$ln,'Marca')
		        	->setCellValue($Col++.$ln,'Modelo')
		        	->setCellValue($Col++.$ln,'Sistema Operativo')
		        	->setCellValue($Col++.$ln,'HDD')
		        	->setCellValue($Col++.$ln,'Tipo de HDD')
		        	->setCellValue($Col++.$ln,'Memoria')
		        	->setCellValue($Col++.$ln,'Numero de Serie')
		        	->setCellValue($Col++.$ln,'Teamviewer')
		        	->setCellValue($Col++.$ln,'Año')
		        	->setCellValue($Col++.$ln,'Fecha Modelo')
		        	->setCellValue($Col++.$ln,'Observaciones')
		        	->setCellValue($Col++.$ln,'Cuenta Correo')
		        	->setCellValue($Col++.$ln,'Licencias')
		        	->setCellValue($Col++.$ln,'Adicionales')
		        ;
	        }
	        
	        foreach ($data as $d) {
	        	$Col= 'A';
	        	$ln++;
	        	$xls->getActiveSheet()
	        		->setCellValue($Col++.$ln, $ln)
	        		->setCellValue($Col++.$ln, $d->ID)
	        		->setCellValue($Col++.$ln, $d->NOMBRE_CLIENTE)
	        		->setCellValue($Col++.$ln, $d->NOMBRE_USUARIO)
	        		->setCellValue($Col++.$ln, $d->TIPO)
	        		->setCellValue($Col++.$ln, $d->NOMBRE_MARCA)
	        		->setCellValue($Col++.$ln, $d->MODELO)
	        		->setCellValue($Col++.$ln, $d->NOMBRE_SO)
	        		->setCellValue($Col++.$ln, $d->HDD_CAPACIDAD)
	        		->setCellValue($Col++.$ln, $d->TIPO_HDD)
	        		->setCellValue($Col++.$ln, $d->MEMORIA_C_I)
	        		->setCellValue($Col++.$ln, $d->NS)
	        		->setCellValue($Col++.$ln, $d->TEAMVIEWER)
	        		->setCellValue($Col++.$ln, $d->ANIO)
	        		->setCellValue($Col++.$ln, $d->FECHA_MODELO)
	        		->setCellValue($Col++.$ln, $d->OBSERVACIONES)
	        		->setCellValue($Col++.$ln, $d->CUENTA_CORREO)
	        	;
	        }
	        $ln++;
	        $xls->setActiveSheetIndex()
	                ->setCellValue('A'.$ln,'-----');
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

	        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('I')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('L')->setWidth(25);
	        $xls->getActiveSheet()->getColumnDimension('M')->setWidth(18);
	        $xls->getActiveSheet()->getColumnDimension('N')->setWidth(15);
	        $xls->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	        $xls->getActiveSheet()->getColumnDimension('P')->setWidth(35);
	        $xls->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
	        $xls->getActiveSheet()->getColumnDimension('R')->setWidth(30);
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(50);

	        // Hacer las cabeceras de las lineas;
	        //->setCellValue('9','')
	       
	        //$nom_mes = $this->nombreMes($mes);

	        $xls->getActiveSheet()
	            ->setCellValue('A3','Inventario de Equipos ')
	            ->setCellValue('A4','Fecha de Emision del Reporte: '.date('d-m-Y H:i:s'))
	            ->setCellValue('A5','Total de Equipos: '.count($data))
	            //->setCellValue('A6','Importe Total de los Documentos: ')
	            ->setCellValue('A6','Usuario Elabora: '.$usuario)
	            ->setCellValue('A7','Reporte de Inventario por Empresa')
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
	            if(!file_exists($ruta='C:\\xampp\\htdocs\\media\\reportes\\inventarios\\')){
	            	mkdir($ruta);
				}
	            $nom='Reporte de Inventario de equipos '.date("d-m-Y \Thms").'.xlsx';
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
	        for ($i=0; $i < 19; $i++) { 
	        	$Col= 'A';
	        	$xls->getActiveSheet()
		        	->setCellValue($Col++.$ln,'Ticket')
		        	->setCellValue($Col++.$ln,'Modo de reporte')
		        	->setCellValue($Col++.$ln,'Persona que Reporta')
		        	->setCellValue($Col++.$ln,'Usuario del incidente')
		        	->setCellValue($Col++.$ln,'Mes')
		        	->setCellValue($Col++.$ln,'Año')
		        	->setCellValue($Col++.$ln,'Fecha')
		        	->setCellValue($Col++.$ln,'Fecha del reporte')
		        	->setCellValue($Col++.$ln,'Equipo')
		        	->setCellValue($Col++.$ln,'Descripcion corta')
		        	->setCellValue($Col++.$ln,'Descripcion completa')
		        	->setCellValue($Col++.$ln,'Solucion o trabajo realizado')
		        	->setCellValue($Col++.$ln,'Estado del ticket')
		        	->setCellValue($Col++.$ln,'Fecha de Cierre')
		        	->setCellValue($Col++.$ln,'Sistema afectado')
		        	->setCellValue($Col++.$ln,'Tipo de Servicio')
		        	->setCellValue($Col++.$ln,'Correo Reporta')
		        	->setCellValue($Col++.$ln,'Correo Usuario')
		        	->setCellValue($Col++.$ln,'Nombre del Cliente')
		        	->setCellValue($Col++.$ln,'Atiende')
		        ;
	        }
	        
	        foreach ($segundo as $det) {
	        	$Col= 'A';
	        	$ln++;
	        	$xls->getActiveSheet()
	        		->setCellValue($Col++.$ln,	$det->ID)
	        		->setCellValue($Col++.$ln, $det->MODO)
	        		->setCellValue($Col++.$ln, $det->REPORTA)
	        		->setCellValue($Col++.$ln, $det->USUARIO)
	        		->setCellValue($Col++.$ln, date("n", strtotime($det->FECHA)))
	        		->setCellValue($Col++.$ln, date("Y", strtotime($det->FECHA)))
	        		->setCellValue($Col++.$ln, $det->FECHA)
	        		->setCellValue($Col++.$ln, $det->FECHA_REPORTE)
	        		->setCellValue($Col++.$ln, $det->EQUIPO)
	        		->setCellValue($Col++.$ln, $det->CORTA)
	        		->setCellValue($Col++.$ln, $det->COMPLETA)
	        		->setCellValue($Col++.$ln, $det->SOLUCION)
	        		->setCellValue($Col++.$ln, $det->STATUS)
	        		->setCellValue($Col++.$ln, $det->CIERRE)
	        		->setCellValue($Col++.$ln, $det->SISTEMA)
	        		->setCellValue($Col++.$ln, $det->TIPO)
	        		->setCellValue($Col++.$ln, $det->CORREO_REP)
	        		->setCellValue($Col++.$ln, $det->CORREO_USU)
	        		->setCellValue($Col++.$ln, $det->NOMBRE_CLIENTE)
	        		->setCellValue($Col++.$ln, $det->ATIENDE)
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
	        $xls->getActiveSheet()->getColumnDimension('S')->setWidth(5);

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
	            $nom='Reporte de Servicio por '.$tip.' de '.$per.'_'.date("d-m-Y \Thms").'.xlsx';
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

	function impTick($idt){
		if($_SESSION['user']){
			$data = new data_serv;
			$info = $data->infoTicket($idt);
			//echo $info->NOMBRE_CLIENTE;
			$files = $data->archivos($idt);
			/// inciamos la impresion;
			$dompdf = new Dompdf();
        	//$K=html_entity_decode($K, ENT_QUOTES, "UTF-8"); 
        	//$K = htmlentities($K, ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE );
	        
	        $html="<!DOCTYPE html>";
	        $html.="<html>";
	        
	        $html.="<style>";
	        $html.=".responsive {";
	        $html.="width: 100%;  ";
	        $html.="height: auto;";
	        $html.=" }";
	        $html.="</style>";

	        $html.="<head>";
	        $html.="<title>Reporte de Ticket</title>";
	        $html.="</head>";
	        $html.="<body>";
	        $html.="<img src='app/views/images/Logos/LogoFTC.jpg'><br>";
	        $html.="<ul style='font-family:verdana;font-size:4px'><font size='12pxs'>";

	        $html.="<br/><font size='12pxs'><b>Sistema de Tickets de servicio ".htmlentities('Versión', ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE).": 2.8</b></font>";
	        $html.="<br/><font size='12pxs'><b>".htmlentities('Fecha Elaboración:', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b>".$info->FECHA."</font>";
	        $html.="<br/><font size='12pxs'><b>".htmlentities('Fecha Atención:', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b>".$info->FECHA_REPORTE."</font>";
	        $html.="<br/><font size='12pxs'><b>".htmlentities('Duración del Evento:', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b>1 hora</font>";
	        //$html.="<br/><font size='12pxs'><b>".htmlentities('Hora de inicio: 11:20 am Hora de Finalización 12:10', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b></font>";	      
	        //$html.="<br/><font size='12pxs'><b>".htmlentities('Costo del Servicio $ 550.00 ', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b></font>";	      
	        $html.="<br/><font size='12pxs'><b>".htmlentities('Fecha impresión:', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b>".date("d-m-Y H:i:s")."</font>";
	        $html.="<br/><font size='12pxs'><b>".htmlentities('Atiende:', ENT_QUOTES | ENT_IGNORE, "UTF-8", FALSE)."</b>".$info->ATIENDE."</font>";


	        $html.="<br/>";
	        $html.="<br/><font size='12pxs'><b>Cliente: ".htmlentities($info->NOMBRE_CLIENTE, ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE).":</b></font>";
	        
	        $html.="<br/><font size='12pxs'><b>Usuario que reporta o solicita el servicio: </b>".$info->REPORTA."</font>";    
	        $html.="<br/><font size='12pxs'><b>Usuario que Recibe el Servicio: </b>".$info->USUARIO."</font>";    
	        $html.="<br/><font size='12pxs'><b>Forma de Contacto: </b>".$info->MODO."</font>";    
	        $html.="<br/><font size='12pxs'><b>Correo: </b>".$info->CORREO_USU."</font>";    
	        $html.="<br/>";
	        $html.="<br/><font size='12pxs'><b>Equipo Reportado:</b> ".$info->EQUIPO."</font>";    
	        $html.="<br/><font size='12pxs'><b>Descripcion Corta del servicio o indicente:</b> ".htmlentities($info->CORTA,ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE)."</font>";
	        $html.="<br/>";

	        $html.="</font></ul><br>";
	        $html.="<strong><p align='center'><font size='15pxs'>".htmlentities('Descripción Completa de la solicitud o el incidente', ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE)."</font></p></strong><br>";
	        $html.="<p><font size='12pxs'>".htmlentities($info->COMPLETA, ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE)."</font></p>";
	        $html.="<br/>";
	        $html.="<strong><p align='center'><font size='15pxs'>".htmlentities('Solución al indicente', ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE).".</font></p></strong><br>";
	        $html.="<p><font size='12pxs'>".htmlentities($info->SOLUCION, ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE)."</font></p>";

	        //// Area de imagenes
	        $html.="<strong><p align='center'><font size='15pxs'>".htmlentities('Imagenes del tikcet', ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE).".</font></p></strong><br>";
	        
	        if(count($files)>0){
		        $archivos = $this->limpiaArchivos($files);
		        for ($i=0; $i < count($archivos); $i++){
		        	if($this->esImagen($archivos[$i])){
			        	$html.="<img src='".$archivos[$i]."' width='500' height='400' class='responsive'><br>";
			        	$html.="<label>".substr($archivos[$i],16)."</label><br/>";
		        	} 
		        }
	        }
	        /// Finaliza la Area de imagenes.

	        $html.="<strong><p align='center'><font size='15pxs'>".htmlentities('FIN DEL TICKET'.$idt, ENT_QUOTES | ENT_IGNORE,"UTF-8", FALSE).".</font></p></strong><br>";
	        $html.="<ul style='font-family:verdana;font-size:4px'><font size='12pxs'>";
	        $html.="<br/>Para cualquier aclaracion o duda, ponemos a su disposicion los siguientes medios:";
	        $html.="<br/>Cel: 55-5055-3392";
	        $html.="<br/>Correo Electronico: ofarias@ftcenlinea.com";
	        $html.="<br/>Recuerde que pude consultar sus tickets en nuestro sitio http://ofa.dyndns.org/ftc";
			$html.="</ul>";
	        $html.="</body>";
	        $html.="</html>";
	        
	        $dompdf->loadHtml(utf8_decode($html));   
	        // (Optional) Setup the paper size and orientation
	        $dompdf->setPaper('letter', 'portrait');
	        // Render the HTML as PDF
	        $dompdf->render();
	        // Output the generated PDF to Browser
	        $tipo = '1';
	        if($tipo == '0'){
	            //$pdf->Output('Minuta_'.$ida.'.pdf','d');
	            $dompdf->stream('Ticket_.pdf');
	            //$dompdf->stream('C:\xampp\htdocs\archivos\Minutas\Minuta_'.$k->USUARIO.'_'.$k->FECHA.'_'.$k->NOMBRE.'.pdf');
	        }else{
	            $output=$dompdf->output();
	            file_put_contents('C:\xampp\htdocs\media\tickets\Ticket '.$idt.'.pdf', $output);
	            return array("archvio"=>'C:\\xampp\\htdocs\\media\\tickets\\Ticket '.$idt.'.pdf', "status"=>'S');
	        }
		}
	}

	function limpiaArchivos($files){
		$d=0;
		foreach ($files as $fl) {
			$d++;
			$archivo = $fl->UBICACION.$fl->NOMBRE.'.'.$fl->TIPO_ARCHIVO;
			if(strtoupper($fl->TIPO_ARCHIVO) == 'ZIP'){
				file_exists($fl->UBICACION.'\\'.$fl->NOMBRE.'\\')? '':mkdir($fl->UBICACION.'\\'.$fl->NOMBRE.'\\');
				$path = $fl->UBICACION.'\\'.$fl->NOMBRE.'\\';
				$zip = new ZipArchive;
				$origen = $zip->open($archivo);
				if($origen === TRUE){
					$zip->extractTo($path);
					$zip->close();
					$dc = scandir($path);
					for ($i=0; $i < count($dc); $i++){ 
						/*echo '<br/>Archivo: '.$dc[$i].'<br/>';
						if(strtoupper(substr($dc[$i], strlen($dc[$i])-3)) == 'PDF'){
							echo '<br/> El Archivo es '.substr($dc[$i], strlen($dc[$i])-3);
							$imagick = new Imagick();
							$imagick->readImage($path.'\\'.$dc[$i]);
							$imagick->writeImages($path.'\\'.'pdf-convetido.jpg', false);
						}*/
						$archivos[]=$path.$dc[$i];
					}
				}else{
					echo 'Error al descomprimir el archivo zip '.$archivo;
				}
			}
			$archivos[]=$archivo;
		}
		//print_r($archivos);
		//die();
		return $archivos; 
	}

	function esImagen($path){
            @$imageSizeArray = getimagesize($path);
            $imageTypeArray = $imageSizeArray[2];
            return (bool)(in_array($imageTypeArray , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)));
    }
}?>

