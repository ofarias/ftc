<?php 
	require_once('app/model/model.mobile.php');
	require_once('app/model/sync.mobile.php');


class mobile_c{
	
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

	
	function sync(){
		if($_SESSION['user'] and $_SESSION['empresa']['mobile']==1){
			$this->leeempresa();
			die();
			$data = new sync_mobile;
			$data2 = new sync_mob_mysql;
			$info=array();
			$pendientes = $data2->pendientes();
			$update = $data->update($pendientes, $info);
			$info = $data->info();
			//echo 'info:'.count($info);
			//die;
			$mySQL = $data2->sync($info);

			$update = $data->update($mySQL, $info);
			if($update['status'] == 'Ok' ){
				$cierre =$data2->cierre();
			}
			echo $update['mensaje'];
		}else{
		
		}
	}

	function leeempresa(){
		$data = new sync_mobile;
		$info = $data->leeempresa();
		die;
	}

	function detStat($cliente, $mes, $anio, $tipo){
		if($_SESSION['user']){
			$data = new statics;
			$info = $data->detStat($cliente, $mes, $anio , $tipo);
			$meses=array("Enero"=>1, "Febrero"=>2, "Marzo"=>3, "Abril"=>4, "Mayo"=>5, "Junio"=>6, "Julio"=>7,"Agosto"=>8,"Septiembre"=>9, "Octubre"=>10, "Noviembre"=>11,"Diciembre"=>12,);

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


}?>