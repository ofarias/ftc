<?php
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';
require_once 'app/model/verificaID.php';
require_once 'app/model/pegaso.model.reparto.php';
require_once('app/views/unit/commonts/numbertoletter.php');

class cargaXML extends database {

	function cargaCEP($cep){
		$path='C:\\xampp\\htdocs\\Facturas\\FacturasJson\\';
    	$files = array_diff(scandir($path), array('.', '..'));
    	foreach($files as $file){
		    $data = explode(".", $file);
		    $fileName = $data[0];
		    $fileExtension = $data[1];
		    if(strtoupper($fileExtension) == 'XML' and strpos($fileName, 'CEP') !== false){
		    	if(strpos($fileName, 'CEP'.$cep) !== false){
		    	    $file = $path.$fileName.'.'.$fileExtension;
		    	    $myFile = fopen($file, "r") or die("No se ha logrado abrir el archivo ($file)!");
	        	    $myXMLData = fread($myFile, filesize($file));
	        	    $xml = simplexml_load_string($myXMLData) or die("Error: No se ha logrado crear el objeto XML ($file)");
	        	    $ns = $xml->getNamespaces(true);
	        	    $xml->registerXPathNamespace('c', $ns['cfdi']);
	        	    $xml->registerXPathNamespace('t', $ns['tfd']);

	        	     foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
			               $fechaT = $tfd['FechaTimbrado']; 
			               $fechaT = str_replace("T", " ", $fechaT); 
			               $uuid = $tfd['UUID'];
			               $noNoCertificadoSAT = $tfd['NoCertificadoSAT'];
			               $RfcProvCertif=$tfd['RfcProvCertif'];
			               $SelloCFD=$tfd['SelloCFD'];
			               $SelloSAT=$tfd['SelloSAT'];
			               $versionT = $tfd['Version'];
			               $rfcprov = $tfd['RfcProvCertif'];
			        }
	        	    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
            		  	$version = $cfdiComprobante['version'];
					  	if($version == ''){
					  		$version = $cfdiComprobante['Version'];
					  	}
					  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$serie = $cfdiComprobante['Serie'];                  
	        	          	$folio = $cfdiComprobante['Folio'];
	        	          	$total = $cfdiComprobante['Total'];
	        	          	$tipo = $cfdiComprobante['TipoDeComprobante'];
						  	$moneda = $cfdiComprobante['Moneda'];
						  	$lugar = $cfdiComprobante['LugarExpedicion'];
						  	$Certificado = $cfdiComprobante['Certificado'];
						  	$Sello = $cfdiComprobante['Sello'];
						  	$noCert = $cfdiComprobante['NoCertificado'];
						  	$fecha = $cfdiComprobante['Fecha'];
						  	$fecha = str_replace("T", " ", $fecha);
						  	$subtotal = $cfdiComprobante['SubTotal'];
					  	}
					}

					foreach ($xml->xpath('//cfdi:Emisor') as $emi){
            		  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$rfce=$emi['Rfc'];
	        	        	$emisor=$emi['Nombre'];
	        	        	$rf = $emi['RegimenFiscal'];
	        	        }
					}

					foreach ($xml->xpath('//cfdi:Receptor') as $rec){
            		  	if($version == '3.2'){
					    }elseif($version == '3.3'){
					      	$rfcr=$rec['Rfc'];
	        	        	$recep=$rec['Nombre'];
	        	        	$UsoCFDI = $rec['UsoCFDI'];
	        	        }
					}
					if($tipo == 'P'){
						$this->query="INSERT INTO FTC_CEP_XML (UUID, VERSION, SERIE, FOLIO, FECHA, SUBTOTAL, MONEDA, TOTAL, TIPODECOMPROBANTE, LUGAREXPEDICION, VERSIONTIMBREFISCAL , FECHATIMBRADO, NOCERTIFICADOSAT, VERSIONPAGOS, SELLOCFD, SELLOSAT, RFCEMISOR, NOMBREEMISOR, RFCRECEPTOR, NOMBRERECEPTOR, USOCFDIRECEPTOR, RfcProvCertif, XMLNSPAGO10, REGIMENFISCALEMISOR ) 
			        		VALUES ('$uuid', '$version', '$serie', '$folio', '$fecha', $subtotal, '$moneda', $total , '$tipo', '$lugar', '$version', '$fechaT', '$noNoCertificadoSAT', '$versionT', '$SelloCFD', '$SelloSAT', '$rfce', '$emisor', '$rfcr', '$recep', '$UsoCFDI', '$rfcprov',  '', '$rf')";
				        $this->grabaBD();

						$this->query="INSERT INTO FTC_CEP_XML_DOCUMENTO (UUID, DOCUMENTORELACIONADO, NUMEROPAGO, FOLIO, SERIE, MONEDA, METODODEPAGO, NUMPARCIALIDAD, SALDOANT, PAGADO, SALDOINSOLUTO ) 
						  		VALUES ('$uuid', '', 1, '$folio', '$serie', '$moneda', 'PPD', 0, 0, 0, 0 )";
						$this->grabaBD();
					}
					
		    	}else{
		    	}
		    }
		}
		return array("status"=>'no',"mensaje"=>'No se encontro el Archivo', "archivo"=>'no');
	}

	function insertarMetaDatos($archivo){
		echo $archivo;
		$fp=fopen($archivo,'r');
		$l=0;
		$r=0;
		while(!feof($fp)) {
			$linea = fgets($fp);
			if($l > 0){
				$d=explode("~", utf8_encode($linea));
				$this->query="SELECT * FROM FTC_META_DATOS WHERE UUID = '$d[0]'";
				$rs=$this->EjecutaQuerySimple();
				$row=ibase_fetch_object($rs);
				if(empty($row)){
					if(strlen($d[11]) > 2){
						$fc = "'".trim($d[11])."'";
					}else{
						$fc = 'null';
					}
					$this->query="INSERT INTO FTC_META_DATOS (IDMD, UUID, RFCE, NOMBRE_EMISOR, RFCR, NOMBRE_RECEPTOR, RFCPAC, FECHA_EMISION, FECHA_CERTIFICACION, MONTO, EFECTO_COMPROBANTE, STATUS, FECHA_CANCELACION) 
								VALUES (NULL, '$d[0]', '$d[1]', '$d[2]', '$d[3]', '$d[4]', '$d[5]', '$d[6]','$d[7]', $d[8], '$d[9]', $d[10], ".$fc.")";
					$res=$this->grabaBD();
					if($res == 1){
						$r+=$res;	
					}else{
						echo '<br/>'.$this->query.'<br/>';
					}
				}
			}
			$l++;
		}
		fclose($fp);
	}

	
}