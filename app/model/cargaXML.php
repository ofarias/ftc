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

	function leeMetaDatos($archivo){
		$fp=fopen($archivo,'r');
		$l=0;
		$r=0;
		while(!feof($fp)) {
			$linea = fgets($fp);
			if($l > 0){
				$d=explode("~", utf8_encode($linea));
				$rfce=$d[1];
				$rfcr=$d[3];
				$rfc=$_SESSION['rfc'];
				if($rfce == $rfc or $rfcr == $rfc){
					return array("status"=>'ok', "lineas"=>$l,"mensaje"=>'Se encontro el rfc en la primer linea.',"rfce"=>$rfce, "rfcr"=>$rfcr);
				}else{
					return array("status"=>'No', "lineas"=>$l,"mensaje"=>'Al parecer el archivo no es de la empresa seleccionada',"rfce"=>$rfce, "rfcr"=>$rfcr);
				}
			}
			$l++;
		}
		fclose($fp);
	}

	function insertarMetaDatos($archivo){
		//echo $archivo;
		$usuario = $_SESSION['user']->NOMBRE;
		$fp=fopen($archivo,'r');
		$l=0;
		$r=0;
		$this->query="SELECT * FROM FTC_META_DATOS WHERE ARCHIVO='$archivo'";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		if(!empty($row)){
			echo 'El Archivo <b>'.$archivo.'</b> ya fue Cargado por <b>'.$row->USUARIO.'</b> el <b>'. $row->FECHA_CARGA.'</b><br/>';
			return;
		}							
		while(!feof($fp)) {
			$linea = fgets($fp);
			if($l > 0){
				$d=explode("~", utf8_encode($linea));
				//echo 'Valor de la linea '.count($d).'<br/>';
				if(count($d)>2){
					if(strlen($d[11]) > 2){
						$fc = "'".trim($d[11])."'";
					}else{
						$fc = 'null';
					}
					$this->query="INSERT INTO FTC_META_DATOS (IDMD, UUID, RFCE, NOMBRE_EMISOR, RFCR, NOMBRE_RECEPTOR, RFCPAC, FECHA_EMISION, FECHA_CERTIFICACION, MONTO, EFECTO_COMPROBANTE, STATUS, FECHA_CANCELACION, ARCHIVO, FECHA_CARGA, USUARIO, PROCESADO) 
									VALUES (NULL, '$d[0]', '$d[1]', '$d[2]', '$d[3]', '$d[4]', '$d[5]', '$d[6]','$d[7]', $d[8], '$d[9]', $d[10], ".$fc.", '$archivo', current_timestamp, '$usuario', 0)";
					$res=$this->grabaBD();
					if($res==1){
						$r+=$res;
						if(strlen($d[11]) > 2){
							$this->query="UPDATE XML_DATA SET STATUS = 'C' WHERE UPPER(UUID) = UPPER('$d[0]')";
							$r=$this->queryActualiza();
							if($r==1){
								$this->query="UPDATE FTC_META_DATOS SET PROCESADO = 1 WHERE UPPER(UUID) = UPPER('$d[0]') AND FECHA_CANCELACION IS NOT NULL";
								$this->queryActualiza();
							}
						}
					}else{
						echo '<br/>'.$this->query.'<br/>';
					}
				}
			}
			$l++;
		}
		fclose($fp);
		$borrados = array();
		$this->query="SELECT * FROM FTC_META_DATOS WHERE archivo = '$archivo' and FECHA_CANCELACION IS NOT NULL";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$borrados[] =$tsArray;
		}
		if(count($borrados) >0){
			//echo 'arma el correo';
			return array("status"=>'borrados', "data"=>$borrados);
		}
		return array("status"=>'ok', "data"=>'0');
	}

	function nomMeta(){
		$path="C:\\xampp\\htdocs\\meta\\";
		//exit();
		if(file_exists($path)){
			$files=array_diff(scandir($path), array('.', '..'));
			foreach($files as $file){
		    // Divides en dos el nombre de tu archivo utilizando el . 
		    $data = explode(".", $file);
		    // Nombre del archivo
		    $fileName = $data[0];
		    // Extensión del archivo 
		    @$fileExtension = $data[1];
		    if($fileExtension=='txt'){
		        //echo $file.'<br/>';
		        $f=fopen($path.$file, 'r');
		        $l=1;
		         while(!feof($f)) {
					$linea = fgets($f);
					$lin=explode('~', $linea);
					//echo $linea.'<br/>';
					$nf=$lin[1]."-".$lin[3].".txt";
					if($l == 2); //echo $lin[1]."-".$lin[3]."<br />";
					$l++;
					if($l>2)break;
				}
				fclose($f);
				rename( $path.$file, $path.$nf);
		        //echo 'Encontramos el archivo: '.$fileName.'.xml';
		        // Realizamos un break para que el ciclo se interrumpa		        
		    }
		}
		}
	}

	function zipXML($mes, $anio, $ide, $doc){
		$data=array();
		$rfc=$_SESSION['rfc'];
		$campo = ($ide=='Recibidos')? 'cliente':'rfce';
		$campof = ($mes ==0)? '':" and extract(month from fecha)=".$mes;
		$date=date("d-m-Y H_i_s");
		$this->query="SELECT * FROM XML_DATA WHERE $campo ='$rfc' and tipo = '$doc' and extract(year from fecha)=$anio $campof order by fecha";
		//echo $this->query;
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		$zip=new ZipArchive();
		$dir="C:\\xampp\\htdocs\\zipFiles\\";
		if(!file_exists($dir)){
			mkdir($dir,0777, true);
		}
		$zip->open($dir.$rfc."_".$mes."_".$anio."_".$ide."_".$doc."_".$date.".zip", ZipArchive::CREATE);
		$d="$rfc";
			foreach ($data as $k){
				$rf=($ide=='Recibidos')? $k->RFCE:$k->CLIENTE;
				$r="C:\\xampp\\htdocs\\uploads\\xml\\".$rfc."\\".$ide."\\".$rf."\\";
				$nameFile=$k->RFCE."-".$k->DOCUMENTO."-".$k->UUID.".xml";
				$archivo=$r.$nameFile;
				if(file_exists($archivo)){
					$zip->addFile($archivo, $nameFile);
				}else{
					echo 'No existe '.$archivo.'<br/>';
				}
			}
		$zip->close();
		$x=$rfc."_".$mes."_".$anio."_".$ide."_".$doc."_".$date.".zip";
		$x1=$rfc."_".$mes."_".$anio."_".$ide."_".$doc.".zip";
		header("Content-disposition: attachment; filename=".$x1);
		header("Content-type: application/octet-stream");
		readfile($dir.$x);
		//unlink('miarchivo.zip');//Destruye el archivo temporal
	}

	function verCEP($cep){
		$cep = explode("|", $cep);
		$this->query="SELECT X.*, cpd.serie||cpd.folio as doc, CP.MONTO, CP.FORMA, CP.CTA_BENEFICIARIO, CP.NUMOPERACION, CP.RFC_BANCO_ORDENANTE, CP.CTA_ORDENANTE, CP.RFC_BANCO_BENEFICIARIO, CPD.ID_DOCUMENTO, CPD.SALDO AS SALDO_ANTERIOR, CPD.PAGO AS APLICACION, CPD.SALDO_INSOLUTO,  (SELECT FECHA FROM XML_DATA X1 WHERE X1.UUID = CPD.ID_DOCUMENTO) AS FECHA_DOC FROM XML_DATA X LEFT JOIN XML_COMPROBANTE_PAGO CP ON CP.UUID = X.UUID LEFT JOIN XML_COMPROBANTE_PAGO_DETALLE CPD ON CPD.UUID_PAGO = CP.UUID where x.documento = '$cep[0]' and x.uuid = '$cep[2]'";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function verRelacion($uuid){
		$this->query="SELECT * FROM XML_DATA WHERE UUID= '$uuid'";
		$r=$this->EjecutaQuerySimple();
		$data=array();
		/// traemos Notas de credito, sustituciones etc....
		$this->query="SELECT * FROM XML_RELACIONES r LEFT JOIN XML_DATA x on x.uuid = r.uuid WHERE r.UUID_DOC_REL = '$uuid' AND x.STATUS != 'C'";
		$r=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($r)) {
			$data[]=$tsArray;
		}
		/// traemos pagos.
		$this->query="SELECT * FROM XML_COMPROBANTE_PAGO_DETALLE CPD LEFT JOIN XML_DATA X ON X.UUID = CPD.ID_DOCUMENTO WHERE CPD.ID_DOCUMENTO = '$uuid' AND X.STATUS != 'C'";
		$r=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($r)) {
			$data[]=$tsArray;
		}
		return $data;
	}
}