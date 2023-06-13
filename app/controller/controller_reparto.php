<?php 
	require_once('app/model/pegaso.model.reparto.php');
	require_once('app/model/pegaso.model.php');
	require_once('app/model/pegaso.model.recoleccion.php');

class pegaso_reparto{
	
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

	function scaneaDocumentoRep($qr){		
		$data = new pegaso_rep;
		$datap = new pegaso;
		if(!empty($qr)){
		$codigo = $data->obtenerQR($qr);
		}
		$pagina =$this->load_template2('Pedidos');
		$ocp = $datap->ocPendientes();
 		$html=$this->load_page('app/views/modules/Logistica/m.IndexRec.php');
   		ob_start();
   		include 'app/views/modules/Logistica/m.IndexRec.php';
   		$table = ob_get_clean();
   		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   		$this->view_page($pagina);
	}

	function obtieneQR($oc){
		$data = new pegaso;
		$response = $data->obtieneQR($oc);
		return $response;
	}

	function buscaQR($qr){
		$data = new pegaso_rep;
		$response = $data->buscaQR($qr);
		return $response;
	}

	function buscaQR2($oc, $qr){
		$data = new pegaso_rec;
		$response = $data->buscarQR2($oc, $qr);
		return $response;
	}

	function procesarDoco($doco){
		//$data = new pegaso_rep;
		$data = new pegaso;
		$pagina=$this->load_template2('Pedidos');
		$html=$this->load_page('app/views/pages/Logistica_recoleccion/p.ordenDetalle.php');
		ob_start();
		$orden = $data->procesarDoco($doco);
		$detalle = $data->procesarDocoDetalle($doco);
		$table = ob_get_clean();
		$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
		include 'app/views/pages/Logistica_recoleccion/p.ordenDetalle.php';
		
		$this->view_page($pagina);
	}


	function finalizaoperador($oc){
		$data = new pegaso;
		$response = $data->finalizaoperador($oc);
		return $response;
	}

	function prerecep($doco, $cantr, $partida, $producto){
		$data=new pegaso;
		$qr=0;
		$a = $data->comprobacion($doco,$qr);
		if($a['status']== 0 or $a['status']==1){
			$response = $data->prerecep($doco, $cantr, $partida, $producto);	
		}else{
			$reposne  = array("validacion"=>1,"status"=>'Ya finalizada');
		}
		return $response;
	}

	function regDocOp($oc){
		$data = new pegaso;
		$response = $data->regDocOp($oc);
		return $response;
	}

}?>