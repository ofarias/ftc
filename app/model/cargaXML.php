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
		while(!feof($fp)){
			$linea = fgets($fp);
			if($l > 0){
				$d=explode("~", utf8_encode($linea));
				//echo 'Valor de la linea '.count($d).'<br/>'; el valor de una linea normal 10 y 11 si esta cancelado
				if(count($d)>=10){
					if(strlen($d[11]) > 2){
						$fc = "'".trim($d[11])."'";
					}else{
						$fc = 'null';
					}
					$nombre_e=str_replace("'", "", $d[2]);
					$nombre_r=str_replace("'", "", $d[4]);
					$this->query="INSERT INTO FTC_META_DATOS (IDMD, UUID, RFCE, NOMBRE_EMISOR, RFCR, NOMBRE_RECEPTOR, RFCPAC, FECHA_EMISION, FECHA_CERTIFICACION, MONTO, EFECTO_COMPROBANTE, STATUS, FECHA_CANCELACION, ARCHIVO, FECHA_CARGA, USUARIO, PROCESADO, UUID_ORIGINAL) 
									VALUES (NULL, '$d[0]', '$d[1]', '$nombre_e', '$d[3]', '$nombre_r', '$d[5]', '$d[6]','$d[7]', $d[8], '$d[9]', $d[10], ".$fc.", '$archivo', current_timestamp, '$usuario', 0, (SELECT UUID FROM XML_DATA X WHERE X.UUID CONTAINING('$d[0]')))";
					$res=$this->grabaBD();
					/*
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
					*/
				}elseif(count($d)>2 and count($d)<10){/// esta linea esta incompleta y es caso de estudio.
					echo '<br/>Registro en 2 lineas: '.$l.'en el archivo '.$archivo.' valor de la linea: '.count($d);
				}
			}
			$l++;
		}
		fclose($fp);
		/*
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
		*/
		return array("status"=>'ok', "data"=>'0');
	}

	function nomMeta(){
		$path="C:\\xampp\\htdocs\\meta\\";
		foreach($_SESSION['coi'] as $emp){
			!empty($emp['rfc'])? $empr[]=$emp['rfc']:'';
		}
		if(file_exists($path)){
			$files=array_diff(scandir($path), array('.', '..'));
			$i=0;
			foreach($files as $file){
				$i++;
		    $data = explode(".", $file);
		    $fileName=$data[0];
		    @$fileExtension = $data[1];
		    	if($fileExtension=='txt'){
		    	    $f=fopen($path.$file,'r');
		    	    $l=1;
		    	     while(!feof($f)) {
						$linea=fgets($f);
						$lin=explode('~', $linea);
						$nf=$i.'_'.$lin[1]."_".$lin[3]."_".$fileName.".txt";
						if($l == 2); //echo $lin[1]."-".$lin[3]."<br />";
						$l++;
						if($l>2)break;
					}
					fclose($f);
					rename( $path.$file, $path.$nf);	

					if(in_array($lin[1], $empr)){
					//echo '<br/> Se encontro el rfc: '.$lin[1].' en el array de empresas';
						if(file_exists($path.$lin[1])){
							copy($path.$nf, $path.$lin[1].'\\'.$nf);
							unlink($path.$nf);
						}else{
							mkdir($path.$lin[1]);
							copy($path.$nf, $path.$lin[1].'\\'.$nf);
							unlink($path.$nf);
						}
					}else{
					//echo '<br/> No se encontro el rfc: '.$lin[1].' en el array de empresas';
						if(file_exists($path.$lin[3])){
							copy($path.$nf, $path.$lin[3].'\\'.$nf);
							unlink($path.$nf);
						}else{
							mkdir($path.$lin[3]);
							copy($path.$nf, $path.$lin[3].'\\'.$nf);
							unlink($path.$nf);
						}
					}
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

	function actTablas(){
		$ruta="c:\\xampp\\htdocs\\upd\\";
		$archivos=scandir($ruta);
		for ($i=2; $i < count($archivos); $i++) { 
			$info= new SplFileInfo($archivos[$i]);
			$ext=$info->getExtension();
			if(strtoupper($ext) == 'SQL'){
				$contenido = file_get_contents($ruta.$archivos[$i]);
				$cont = explode(";", $contenido);
				for ($i=0; $i < count($cont) ; $i++) { 
					$this->query=$cont[$i];
					@$res=$this->grabaBD();
				}
			}else{
				echo 'No se procesa el archivo'.$archivos[$i]; 
			}
			break;
		}
		//exit();
	}

	function p_c($anio, $mes){
		if($mes == 0){
			$data = array();
			$this->query="SELECT * FROM XML_DATA WHERE TIPO='I' and extract(year from fecha) = $anio";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}
	}

	function xls_diot($file, $x, $mes, $anio){
		$rfc = $_SESSION['rfc'];
		$usuario = $_SESSION['user']->NOMBRE;
		$inputFileType=PHPExcel_IOFactory::identify($file);
        $objReader=PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel=$objReader->load($file);
        $sheet=$objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        $ruta="C:\\xampp\\htdocs\\diot\\";
        if(!file_exists($ruta)){
        	mkdir($ruta);
        }
        $d=date('s');
        $diot = fopen($ruta.'diot_'.$rfc.'_'.$mes.'_'.$anio.'('.$usuario.')'.$d.'.txt', 'w');
        $diot_archivo = 'diot_'.$rfc.'_'.$mes.'_'.$anio.'('.$usuario.')'.$d.'.txt';
        for ($row=2; $row <= $highestRow; $row++){ //10
            $A = $sheet->getCell("A".$row)->getValue();//1
            $B = $sheet->getCell("B".$row)->getValue();//2
            $C = $sheet->getCell("C".$row)->getValue();//3
            $D = $sheet->getCell("D".$row)->getValue();//4
            $E = $sheet->getCell("E".$row)->getValue();//5
            $F = $sheet->getCell("F".$row)->getValue();//6
            $G = $sheet->getCell("G".$row)->getValue();//7
            $H = number_format($sheet->getCell("H".$row)->getValue(),0,'','' );//8 --> Monto sin decimales 
            $I = $sheet->getCell("I".$row)->getValue();//9
            $J = $sheet->getCell("J".$row)->getValue();//10
            $K = $sheet->getCell("K".$row)->getValue();//11
            $L = $sheet->getCell("L".$row)->getValue();//12
            $M = $sheet->getCell("M".$row)->getValue();//13
            $N = $sheet->getCell("N".$row)->getValue();//14
            $O = $sheet->getCell("O".$row)->getValue();//15
            $P = $sheet->getCell("P".$row)->getValue();//16
            $Q = $sheet->getCell("Q".$row)->getValue();//17
            $R = $sheet->getCell("R".$row)->getValue();//18
            $S = $sheet->getCell("S".$row)->getValue();//19
            $T = $sheet->getCell("T".$row)->getValue();//20
            $U = $sheet->getCell("U".$row)->getValue();//21
            $V = $sheet->getCell("V".$row)->getValue();//22
            $X = $sheet->getCell("X".$row)->getValue();//23
            $Y = $sheet->getCell("Y".$row)->getValue();//24
            $info = $A.'|'.$B.'|'.$C.'|'.$D.'|'.$E.'|'.$F.'|'.$G.'|'.$H.'|'.$I.'|'.$J.'|'.$K.'|'.$L.'|'.$M.'|'.$N.'|'.$O.'|'.$P.'|'.$Q.'|'.$R.'|'.$S.'|'.$T.'|'.$U.'|'.$V.'|'.$X.'|'.$Y.'|';
            fwrite($diot, $info.PHP_EOL);
        }
        fclose($diot);
        return array("status"=>'ok', "m"=>'Se ha creado el arvivo'.$diot_archivo, "a"=>$diot_archivo);
    }

    function cs(){
    	$data = array();
    	$data2 = array();
    	$this->query="SELECT f.*, c.nombre as cliente, c.rfc as rfc_clie FROM FACTF01 f left join clie01 c on c.clave = f.cve_clpv WHERE VALIDACION IS NULL";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		if(count($data) > 0 ){
			foreach($data as $d){
					$this->query="INSERT INTO FTC_SALDO (ID, FACTURA, FECHA, CLIENTE, IMPORTE, MONTO_PAGOS, MONTO_DESCUENTOS, MONTO_NC, MONTO_OTROS, MONTO_ND, SALDO, MONTO_CONCILIADO, PERIODO, EJERCICIO, STATUS, XML, rfc, clave_sae) 
					VALUES (NULL, '$d->CVE_DOC', '$d->FECHA_DOC', '$d->CLIENTE', $d->IMPORTE, 0, 0, 0, 0, 0, $d->IMPORTE, 0, 0, 0, 0, 0,'$d->RFC_CLIE', '$d->CVE_CLPV') RETURNING ID";
					$r = $this->grabaBD();
					$row = ibase_fetch_object($r);
					$this->query ="UPDATE FACTF01 SET VALIDACION = $row->ID WHERE CVE_DOC = '$d->CVE_DOC'";
					$this->queryActualiza();
			}
		}

		$this->query = "SELECT * FROM FTC_SALDO WHERE STATUS = 0";
		$result = $this->EjecutaQuerySimple();
		while ($tsarray = ibase_fetch_object($result)) {
			$data2[] =$tsarray; 
		}
		if(count($data2) >0 ){
			foreach ($data2 as $k) {
    			$data3 = array();
				$this->query="SELECT coalesce(sum(cd.importe),0) as aplicado, TIPO_FTC as tipo_ftc FROM CUEN_DET01 cd LEFT JOIN CONC01 C ON C.NUM_CPTO = cd.num_cpto WHERE REFER='$k->FACTURA' and fecha_apli < '01.10.2019'
					group by C.TIPO_FTC"; //and c.es_fma_pag = 'S'
				$rs=$this->EjecutaQuerySimple();
				
				while ($tsArray = ibase_fetch_object($rs)){
					$data3[]=$tsArray;
				}
					if(count($data3)> 0){
						foreach($data3 as $pp){
							if(!empty($pp->TIPO_FTC) ){
								$this->query="UPDATE FTC_SALDO SET  $pp->TIPO_FTC = $pp->APLICADO, STATUS = 1 where FACTURA = '$k->FACTURA'";
								$this->EjecutaQuerySimple();
							}else{
								echo 'El tipo esta vacio: '.$k->FACTURA.'<BR/>';
							}
						}	
					}else{
						$this->query="UPDATE FTC_SALDO SET  STATUS = 1 where FACTURA = '$k->FACTURA'";
						$this->EjecutaQuerySimple();
					}
				unset($data3);
			}
		}

		$this->concialicion();
    }

    function concialicion(){
    	$data = array();
    	$this->query="SELECT  * FROM FTC_SALDO WHERE STATUS = 1 and clave_sae = '         3'";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $k){
    		$doc = substr($k->FACTURA, 1);
    		//echo 'Valor del documento: '.$doc.'<br/>';
    		$d = (int)$doc;
    		$d1 = ' '.$d.' ';
    		$this->query="SELECT coalesce( sum(MONTOMOV),0 ) AS conciliado FROM WALMART WHERE CONCEP_PO containing('$d1') AND NOT CONCEP_PO CONTAINING ('FE') AND NOT CONCEP_PO CONTAINING ('NB') AND NOT CONCEP_PO CONTAINING ('NC')";
    		$res=$this->EjecutaQuerySimple();

    		$row = ibase_fetch_object($res);
    		if(isset($row->CONCILIADO)){
    			$this->query="UPDATE FTC_SALDO SET MONTO_CONCILIADO = $row->CONCILIADO WHERE FACTURA = '$k->FACTURA'";
    			$this->queryActualiza();
    		}
    		$this->query="UPDATE FTC_SALDO SET STATUS = 2 WHERE FACTURA = '$k->FACTURA'";
    		$this->queryActualiza();
    	}
    }
}