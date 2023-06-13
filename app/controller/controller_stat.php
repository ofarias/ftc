<?php 
	require_once('app/model/model.statics.php');

class statics_c{
	
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	function load_template2($title){
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

	
	function verEstadistica($mes, $anio, $tipo, $t){
		if($_SESSION['user']){
			$data = new statics;
			$info=$data->verEstadistica($mes, $anio, $tipo, $t);
			$gf=$data->gfEst($info);
			foreach ($info as $i){
				$total = $i->TOTAL;
				$total_dev = $i->TOTAL_DEV;
				$total_can = $i->TOTAL_CAN;
			}
			$pagina =$this->load_template2('Estadistica de '.$tipo);
			$html=$this->load_page('app/views/pages/Estadistica/p.verEstadistica.php');
	   		ob_start();
	   		include 'app/views/pages/Estadistica/p.verEstadistica.php';
	   		$table = ob_get_clean();
	   		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	   		$this->view_page($pagina);
		}else{

		}
	}

	function detStat($cliente, $mes, $anio, $tipo, $gt, $vw){
		if($_SESSION['user']){
			$data = new statics;
			$info = $data->detStat($cliente, $mes, $anio , $tipo);
			$per=$data->periodos($gt, $anio, $cliente, $tipo);
			$meses=array("Enero"=>1, "Febrero"=>2, "Marzo"=>3, "Abril"=>4, "Mayo"=>5, "Junio"=>6, "Julio"=>7,"Agosto"=>8,"Septiembre"=>9, "Octubre"=>10, "Noviembre"=>11,"Diciembre"=>12,);
			$_SESSION['sta']=105;
			$pagina =$this->load_template2('Estadistica de '.$cliente);
			$html=$this->load_page('app/views/pages/Estadistica/p.detalleEstadistica.php');
	   		ob_start();
	   		include 'app/views/pages/Estadistica/p.detalleEstadistica.php';
	   		$table = ob_get_clean();
	   		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	   		$this->view_page($pagina);
		}
	}

	function updateInfo($eje){
		if ($_SESSION['user']) {
			$data= new statics;
			$update = $data->updateInfo($eje);
			echo '<script language="javascript">alert("Correra para el ejercicio 2019") </script>';
		}
	}

	function repTipo($anio, $tipo){
		if($_SESSION['user']){
			$data = new statics;
			$per = '';
			
			$info = $data->repTipo($anio);
			$anios = $data->traeAnios();
			
			$comp = $data->compAnual($anio, $per);
			$periodo  = $data->compAnual($anio, $per='periodo');
			

			$pagina =$this->load_template2('Estadistica de '.$tipo);
			$html=$this->load_page('app/views/pages/Estadistica/p.repTipo.php');
	   		ob_start();
	   		include 'app/views/pages/Estadistica/p.repTipo.php';
	   		$table = ob_get_clean();
	   		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	   		$this->view_page($pagina);
		}
	}

	function verProy($id){
		if($_SESSION['user']){
			$data = new statics;
			$crea = $data->traePro($id);
			$pagina =$this->load_template('Ver presupuesto');
			$html=$this->load_page('app/views/pages/gastos/p.proyeccionMensual.php');
	   		ob_start();
	   		include 'app/views/pages/gastos/p.proyeccionMensual.php';
	   		$table = ob_get_clean();
	   		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	   		$this->view_page($pagina);	
		}
	}

}?>