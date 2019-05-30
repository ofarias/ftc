<?php
require_once 'app/model/database.php';
require_once 'app/phpqrcode/qrlib.php';
require_once 'app/model/pegaso.model.reparto.php';

class qrpegaso extends database{
	function QRpreoc($Cabecera, $tipo){
		//var_dump($Cabecera);
		$usuario = $_SESSION['user']->NOMBRE;
			foreach($Cabecera as $key){
				$id  = $key->ID;
				$preoc = $key->CVE_DOC;
				$prov = $key->NOMBRE;
				$cve_prov =$key->CVE_PROV;
				$usuario = $key->USUARIO;
				$costo = $key->COSTO;
				$date = date("Y-m-d H:i:s");
				if($tipo == 1){
					$dir = 'C:\xampp\htdocs\Preordenes\QR\preoc';	
				}else{
					$dir = 'C:\xampp\htdocs\Ordenes\QR\oc';	
				}
				
				$filename = $dir.$id.'.png';
				$tamanio = 3;
				$level = 'M';
				$frameSize = 3;
				$contenido = $id.':'.$preoc.':'.$cve_prov.':'.$prov.':'.$usuario.':'.$costo;
				$contenido = 'http://ofa.dyndns.org:8888/pegasoFTC/index_log.php?action=procesarDoco&doco=';
				$QR=MD5($date.$contenido);
				//echo 'Imprime MD5:'.$QR;
				if(!file_exists($filename)){
					QRcode::png($contenido.$QR, $filename, $level, $tamanio, $frameSize);		
					$this->query="INSERT INTO FTC_CTR_QR (IDQR,IDDOC, TIPO, QR, FCH_CREA, USR_CREA, STATUS, USR_USA, FCH_USO) 
										VALUES (NULL,$id, $tipo, '$QR', current_timestamp, '$usuario', 0, null,null )";
					$this->grabaBD();
					$data = new pegaso_rep;
					$datos = $data->ingresaQR($this->query);
				}
			}
		return $filename;
	}

	function QRpreFact($Cabecera, $tipo){
		//var_dump($Cabecera);
		$usuario = $_SESSION['user']->NOMBRE;
			foreach($Cabecera as $key){
				$id  = $key->ID;
				$preoc = $key->CVE_FACT;
				$prov = $key->NOMBRE;
				$cve_prov =$key->CLAVE;
				$usuario = $key->USUARIO;
				$costo = 0;
				$date = date("Y-m-d H:i:s");
				$dir = 'C:\xampp\htdocs\Prefacturas\QR\prefact';
				$filename = $dir.$id.'.png';
				$tamanio = 2;
				$level = 'M';
				$frameSize = 3;
				$contenido = $id.':'.$preoc.':'.$cve_prov.':'.$prov.':'.$usuario.':'.$costo;
				$QR=MD5($date.$contenido);
				//echo 'Imprime MD5:'.$QR;
				if(!file_exists($filename)){
					QRcode::png($QR.':'.$contenido, $filename, $level, $tamanio, $frameSize);		
					$this->query="INSERT INTO FTC_CTR_QR (IDQR,IDDOC, TIPO, QR, FCH_CREA, USR_CREA, STATUS, USR_USA, FCH_USO) 
										VALUES (NULL,$id, $tipo, '$QR', current_timestamp, '$usuario', 0, null,null )";
					$this->grabaBD();
					$data = new pegaso_rep;
					$datos = $data->ingresaQR($this->query);	
				}
			}

		return $filename;
	}

	function QRFactura($Cabecera, $fiscal){
		$usuario =$_SESSION['user']->NOMBRE; 
		$dir='C:\xampp\htdocs\Facturas\facturaPegaso\qr\\';
		$tipo=4;
		$date = date("Y-m-d H:i:s");
			foreach ($Cabecera as $key) {
				$rfce = $_SESSION['rfc'];
				$rfcr = $key->RFC;
				$doc = $key->DOCUMENTO;
			}
			foreach($fiscal as $data){
				$uuid=$data->UUID;
				$monto=$data->IMPORTE;
				$sello = substr($data->SELLOCFD,-8);
			}
			
			if(substr($doc,0,3) == "RFP") {
			 	$folio = substr($doc,3,10);
			 	$tipo = 5;
			}elseif(substr($doc,0,3) == "NCR"){
			 	$folio = substr($doc,3,10);
			 	$tipo = 6;
			}elseif(substr($doc,0,3)== 'NCS'){
				$folio = substr($doc,3,10);
			 	$tipo = 7;
			}elseif(substr($doc,0,3) == 'NCD'){
				$folio = substr($doc,3,10);
			 	$tipo = 7;
			}else{
			 	$folio = substr($doc,2,10);
			}

		$archivo=$dir.$doc.'.png';
		$tamanio=2;
		$level='M';
		$frameSize=3;
		$liga="https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?&id=".$uuid."&re=".$rfce."&rr=".$rfcr."&tt=".$monto."&fe=".$sello;
		//echo $liga.'<br/>'; 
		$QR=MD5($date.$liga);
		if(!file_exists($archivo)){
			QRcode::png($liga,$archivo,$level,$tamanio,$frameSize);
			$this->query="INSERT INTO FTC_CTR_QR (IDQR,IDDOC, TIPO, QR, FCH_CREA, USR_CREA, STATUS, USR_USA, FCH_USO) 
										VALUES (NULL,$folio, $tipo, '$QR', current_timestamp, '$usuario', 0, null,null )";
					$this->grabaBD();
					$data = new pegaso_rep;
					$datos = $data->ingresaQR($this->query);
		}
		return $archivo;
	}
}	
?>