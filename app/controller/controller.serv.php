
<?php
require_once('app/model/model.serv.php');
//require_once('app/model/pegaso.model.ventas.php');
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

	function verArchivos($tipo, $ticket, $clie){
		if($_SESSION['user']){
			$data = new data_serv;
			$pagina =$this->load_template2('Archivos del Ticket:');
			if(!empty($ticket)){
				$t=$data->verDetalleTicket($id=$ticket);
			}
			$a=$data->verArchivos($tipo, $id=$ticket, $clie);
			ob_start();
			$html = $this->load_page('app/views/pages/servicio/p.verArchivos.php');
			include 'app/views/pages/servicio/p.verArchivos.php';
			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}	
	}

}?>

