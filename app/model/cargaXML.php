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
		$cancelados[]=array();
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
					
					if($res==1){
						$r+=$res;
						if(strlen($d[11]) > 2){
							$this->query="UPDATE XML_DATA SET STATUS = 'C' WHERE UPPER(UUID) = UPPER('$d[0]')";
							$r=$this->queryActualiza();
							$cancelados[]=strtoupper($d[0]);
							if($r==1){
								$this->query="UPDATE FTC_META_DATOS SET PROCESADO = 1 WHERE UPPER(UUID) = UPPER('$d[0]') AND FECHA_CANCELACION IS NOT NULL";
								$this->queryActualiza();
							}
						}
					}else{
						echo '<br/>'.$this->query.'<br/>';
					}
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
        return array("status"=>'ok', "m"=>'Se ha creado el archivo'.$diot_archivo, "a"=>$diot_archivo);
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
    		$this->query="SELECT coalesce(sum(MONTOMOV),0 ) AS conciliado, count(TIPO_POLI) AS POL, 
    				cast(
    						coalesce(
    								list(idp), ''
    								)
    					 as varchar(50)
    					) as polizas
    				 FROM WALMART 
    				 WHERE CONCEP_PO containing('$d1') AND NOT CONCEP_PO CONTAINING ('FE') AND NOT CONCEP_PO CONTAINING ('NB') AND NOT CONCEP_PO CONTAINING ('NC') and FECHA_POL < '01.10.2019'";
    		$res=$this->EjecutaQuerySimple();

    		$row = ibase_fetch_object($res);
    		if(isset($row->CONCILIADO)){
    			$this->query="UPDATE FTC_SALDO SET MONTO_CONCILIADO = $row->CONCILIADO, PERIODO=$row->POL, CONTABILIDAD = '$row->POLIZAS' WHERE FACTURA = '$k->FACTURA'";
    			$this->queryActualiza();
    		}
    		$this->query="UPDATE FTC_SALDO SET STATUS = 2 WHERE FACTURA = '$k->FACTURA'";
    		$this->queryActualiza();
    	}
    	return;
    }

    function creaExcel(){
    	$data = array();
    	$this->query ="SELECT * FROM FTC_SALDO WHERE STATUS  = 2 ";
    	$res=$this->EjecutaQuerySimple();
    	while ($tsArray = ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traePolizas($ids){
    	$this->query = "SELECT CAST (list(TIPO_POLI||'|'||NUM_POLIZ||'|'||PERIODO||'|'||EJERCICIO||'|'||NUM_CTA||'|'||REPLACE(CONCEP_PO, ',',' ')||'|'||MONTOMOV) AS VARCHAR (2000)) AS POLIZAS from walmart where idp in ($ids)";
    	$res = $this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($res);
    	return $row->POLIZAS;
    }

    function cargaEFOS(){
    	$ruta="C:\\xampp\\htdocs\\media\\EFOS\\";
    	$usuario=$_SESSION['user']->NOMBRE;
    	if(!file_exists($ruta)){
    		mkdir($ruta);
    	}
   		if(!file_exists($ruta.'cargados\\')){
				mkdir($ruta.'cargados\\');
		}
    	$lista = scandir($ruta);
		$archivos = array();
		for ($i=0; $i <count($lista) ; $i++){
			if(is_file($ruta.$lista[$i])){
				array_push($archivos, $lista[$i]);
			}
		}
		if(count($archivos)<= 0){
			return array("status"=>'No', "mensaje"=>'No se econtro ningun archivo...');
		}
		for ($i=0; $i < count($archivos); $i++) { 
    		$archivo = $ruta.$archivos[$i];
    		$ar = $archivo;
			$archivoNuevo= $ruta.'cargados\\'.$archivos[$i];	
    		$archivo = fopen($archivo, "r");
    		$linea = 0;
    		while (($datos = fgetcsv($archivo, ",")) == true) {
			  	$num = count($datos);
			  	$linea++;
			  	if($linea < 3){
			  		for($columna = 0; $columna < $num; $columna++){
				        if($linea==1){
				        	$informacion = $datos[0];
				        }
				        if($linea==2){
				        	$titulo = $datos[0];
				        }
			    	}
			  	}   
			    if($linea == 3){
			    	$this->query = "SELECT COUNT(*) as axiste FROM XML_EFOS WHERE INFORMACION = '$informacion' and TITULO = '$titulo' and NOMBRE_ARCHIVO = '$ar'";
			    	$res=$this->EjecutaQuerySimple();
			    	$val = ibase_fetch_row($res);
			    	if($val[0] == 1){
			    		fclose($archivo);
						rename($ar, $archivoNuevo);
			    		return array("status"=>'no',"mensaje"=>'Al parecer el archivo ya existe');
			    	}
			    	$this->query= "INSERT INTO XML_EFOS (ID_EF, NOMBRE_ARCHIVO, USUARIO, FECHA_ALTA, STATUS, FECHA_BAJA, INFORMACION, TITULO) VALUES (NULL, '$ar', '$usuario', current_date, 1, null, '$informacion', '$titulo') RETURNING ID_EF";
			        $res=$this->grabaBD();    
			        $id_ef =ibase_fetch_row($res)[0];
			    }
			    if($linea>=4){ /// Insertamos 
			    	$f5 = empty($datos[5])? 'Null':str_replace("/", ".", "'$datos[5]'");
			    	$f7 = empty($datos[7])? 'Null':str_replace("/", ".", "'$datos[7]'");
			    	$f12 = empty($datos[12])? 'Null':str_replace("/", ".", "'$datos[12]'");
			    	$f13 = empty($datos[13])? 'Null':str_replace("/", ".", "'$datos[13]'");
			    	$f15 = empty($datos[15])? 'Null':str_replace("/", ".", "'$datos[15]'");
			    	$f17 = empty($datos[17])? 'Null':str_replace("/", ".", "'$datos[17]'");
			    	$this->query="INSERT INTO XML_EFOS_DETALLE (ID_EFD, ID_EF, NUMERO, RFC, NOMBRE, SITUACION, NUM_FECHA_PRES, SAT_PUB_PRES, NUM_FECHA_PRES_2, DOF_PUB_PRES, SAT_PUB_DESV, NUM_FECHA_DESV, DOF_PUB_DES, NUM_FECHA_DEF, SAT_PUB_DEF, DOF_PUB_DEF, NUM_FECHA_FAV, SAT_PUB_FAV, NUM_FECHA_FAV_2, DOF_PUB_FAV, STATUS )VALUES(null, $id_ef, '$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', $f5, '$datos[6]', $f7, '$datos[8]', '$datos[9]', '$datos[10]', '$datos[11]', $f12, $f13, '$datos[14]', $f15, '$datos[16]', $f17,0 )";
			    	$this->grabaBD();
			    }
			}
			fclose($archivo);
			rename($ar, $archivoNuevo);
		}
		return array("status"=>'ok', "mensaje"=>'Se ha cargado correctamente el archivo');
    }

    function nomXML($a, $m){
    	$data= array();
    	$mes = '';
    	if($m > 0 ){
    		$mes = ' and extract(month from fecha_inicial) = '.$m.' '; 
    	}
    	$this->query="SELECT COUNT(*) AS RECIBOS,fecha_inicial, fecha_final, extract(month from fecha_final) FROM XML_NOMINA_TRABAJADOR where extract(year from fecha_inicial) = $a $mes GROUP BY fecha_inicial, fecha_final ORDER BY FECHA_INICIAL";
    	$rs=$this->EjecutaQuerySimple();
    	while (@$tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function nomP($nomina){
    	$data=array();
    	$ln= 0;
    	foreach ($nomina as $nom){
    		$ln++;
	    	$this->query="SELECT '$nom->FECHA_INICIAL' as fi, '$nom->FECHA_FINAL' as ff, SUM(TOTAL_SUELDOS) AS SUELDOS, SUM(TOTAL_SEPARACION_INDEM) AS SEPARACIONES, SUM(TOTAL_JUBILACION_PENRET) AS JUBILACION, SUM(TOTAL_GRAVADO) AS GRAVADO, SUM(TOTAL_EXECTO) AS EXECTO FROM XML_NOMINA_PERCEPCIONES WHERE UUID_NOMINA IN (SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT WHERE XNT.FECHA_INICIAL = '$nom->FECHA_INICIAL' AND XNT.FECHA_FINAL = '$nom->FECHA_FINAL')";
	    	$res=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($res)) {
    			$data[]=$tsArray;
    		}
    	}
    	return $data;
    }

    function nomD($nomina){
    	$data=array();
    	$ln= 0;
    	foreach ($nomina as $nom){
    		$ln++;
	    	$this->query="SELECT '$nom->FECHA_INICIAL' as fi, '$nom->FECHA_FINAL' as ff, SUM(TOTAL_IMP_RET) AS RETENCIONES, SUM(TOTAL_OTRAS_DED) AS OTRAS_DEDUCCIONES FROM XML_NOMINA_DEDUCCIONES WHERE UUID_NOMINA IN (SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT WHERE XNT.FECHA_INICIAL = '$nom->FECHA_INICIAL' AND XNT.FECHA_FINAL = '$nom->FECHA_FINAL')";
	    $res=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($res)) {
    			$data[]=$tsArray;
    		}
    	}
    	return $data;	
    }

    function nomE($nomina){
    	$data=array();
    	$ln= 0;
    	foreach ($nomina as $nom){
    		$ln++;
	    	$this->query="SELECT '$nom->FECHA_INICIAL' as fi, '$nom->FECHA_FINAL' as ff, count(*) empleado, CURP, NUMSEGURIDADSOCIAL from xml_nomina_receptor nr where nr.uuid_nomina in (SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT WHERE XNT.FECHA_INICIAL = '$nom->FECHA_INICIAL' AND XNT.FECHA_FINAL = '$nom->FECHA_FINAL') group by CURP, NUMSEGURIDADSOCIAL";
	    	//echo '<br/> Periodo '.$ln.' del '.$nom->FECHA_INICIAL.' al '.$nom->FECHA_FINAL.' Consulta: '.$this->query;
		$res=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($res)) {
    			$data[]=$tsArray;
    		}
    	}
    	return $data;		
    }

    function detalleNomina($fi, $ff){
    	$data = array();
    	$fi = date("d.m.Y", strtotime($fi));
    	$ff = date("d.m.Y", strtotime($ff));
    	$this->query="SELECT (SELECT MAX(NOMBRE) FROM XML_NOMINA_EMPLEADOS XNE WHERE XNE.CURP = XNR.CURP AND XNE.NSS = XNR.NUMSEGURIDADSOCIAL) AS EMPLEADO, XNR.* , XNP.*, XND.*, (SELECT DESCRIPCION FROM C_TIPOCONTRATO CTC WHERE CTC.C_TIPOCONTRATO = XNR.TIPOCONTRATO AND STATUS = 'A') AS CONTRATO, (SELECT DESCRIPCION FROM C_TIPOJORNADA CTJ WHERE CTJ.CT_TIPOJORNANDA =  TIPOJORNADA) AS JORNADA, (SELECT DESCRIPCION FROM C_TIPOREGIMEN CTR WHERE CTR.C_TIPOREGIMEN = TIPOREGIMEN) AS REGIMEN, (SELECT DESCRIPCION FROM C_RIESGOPUESTO CRP WHERE CRP.C_RIESGOPUESTO = RIESGOPUESTO ) AS RIESGO, (SELECT DESCRIPCION FROM C_PERIODICIDADPAGO CPP WHERE CPP.C_PERIODICIDAD_PAGO = PERIODICIDADPAGO) AS PERIODO, 
    	(SELECT NOMBRE_ESTADO FROM C_ESTADO CE WHERE CE.C_ESTADO = CLAVEENTFED) AS ESTADO, (SELECT NOMBRE FROM BANCOS_SAT BS WHERE BS.CLAVE = XNR.BANCO ) AS BANCO_SAT,
    	(SELECT SUM(IMP_GRAVADO + IMP_EXENTO) FROM XML_NOMINA_DETALLE XND WHERE XND.UUID_NOMINA = XNR.UUID_NOMINA AND DED_PER = 'O') AS OTROS
    			FROM XML_NOMINA_RECEPTOR XNR 
    			LEFT JOIN XML_NOMINA_PERCEPCIONES XNP ON XNP.UUID_NOMINA = XNR.UUID_NOMINA 
    			LEFT JOIN XML_NOMINA_DEDUCCIONES XND ON XND.UUID_NOMINA = XNR.UUID_NOMINA
    			WHERE XNR.UUID_NOMINA IN (SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT where XNT.fecha_inicial = '$fi' and XNT.fecha_final = '$ff')";
    	$res=$this->EjecutaQuerySimple();
    	while ($tsArray= ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return $data;
   	}

   	function reciboNomina($uuid){
    	$data = array();
    	$filtro = '';
    	if(!empty($uuid)){
    		$filtro="where XNR.uuid_nomina='$uuid'";
    	}
    	$this->query="SELECT (SELECT MAX(NOMBRE) FROM XML_NOMINA_EMPLEADOS XNE WHERE XNE.CURP = XNR.CURP AND XNE.NSS = XNR.NUMSEGURIDADSOCIAL) AS EMPLEADO, XNR.* , XNP.*, XND.*
    			FROM XML_NOMINA_RECEPTOR XNR 
    			LEFT JOIN XML_NOMINA_PERCEPCIONES XNP ON XNP.UUID_NOMINA = XNR.UUID_NOMINA 
    			LEFT JOIN XML_NOMINA_DEDUCCIONES XND ON XND.UUID_NOMINA = XNR.UUID_NOMINA
    			WHERE $filtro)";
    	//echo $this->query;
    	$res=$this->EjecutaQuerySimple();
    	while ($tsArray= ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return $data;
   	}

   	function infoPer($uuid){
   		$data = array();
   		$this->query="SELECT * FROM XML_NOMINA_PERCEPCIONES WHERE UUID_NOMINA = '$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		return $data;
   	}

   	function infoDed($uuid){
   		$data = array();
   		$this->query="SELECT * FROM XML_NOMINA_DEDUCCIONES WHERE UUID_NOMINA = '$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		return $data;	
   	}

   	function infoDet($uuid){
   		$data = array();
   		$this->query="SELECT * FROM XML_NOMINA_DETALLE WHERE UUID_NOMINA = '$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		return $data;
   	}

   	function detNom($fi, $ff){
   		$data = array ();
   		$dataDet =array();
   		$columnas = array();
   		$fi = date('d.m.Y', strtotime($fi));
   		$ff = date('d.m.Y', strtotime($ff));
   		$this->query="SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT where XNT.fecha_inicial = '$fi' and XNT.fecha_final = '$ff' order by (SELECT COUNT(*) FROM XML_NOMINA_DETALLE ND WHERE ND.UUID_NOMINA = XNT.UUID_NOMINA) DESC";
   		//$this->query="SELECT XNT.UUID_NOMINA FROM XML_NOMINA_TRABAJADOR XNT left join XML_NOMINA_RECEPTOR XNR ON XNR.UUID_NOMINA = XNT.UUID_NOMINA where XNT.fecha_inicial = '$fi' and XNT.fecha_final = '$ff' order by XNR.NUMEMPLEADO ASC ";
   		
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		array_push($columnas, 'UUID');
   		array_push($columnas, 'numero');
   		array_push($columnas, 'nombre');
   		$a=0;
   		$emp=0;
   		foreach ($data as $k){
   			$emp++;
   			$uuid = $k->UUID_NOMINA;
   			$this->query="SELECT ND.* , NR.NUMEMPLEADO AS NUMERO, (SELECT MAX(NOMBRE) FROM XML_NOMINA_EMPLEADOS NE WHERE NE.CURP = NR.CURP) AS NOMBRE 
   				FROM XML_NOMINA_DETALLE ND
   				LEFT JOIN XML_NOMINA_RECEPTOR NR ON NR.UUID_NOMINA = ND.UUID_NOMINA
   				WHERE ND.UUID_NOMINA = '$uuid' order by  ded_per desc";
   				//echo $this->query;
   				//die;
   			$res=$this->EjecutaQuerySimple();
   			while ($tsArray=ibase_fetch_object($res)) {
   				$dataDet[]=$tsArray;
   			}
   			$z=0;
   			foreach ($dataDet as $col){
   				$z++;
   				$c=$col->DED_PER.':'.$col->TIPO.':'.$col->CLAVE.':'.$col->CONCEPTO;
   				if(!in_array($c, $columnas)){
   					array_push($columnas, $c);
   				}
   			}
   			$keys = array_fill_keys($columnas, '');	
   		}
   		return $info=array("columnas"=>$columnas, "datos"=>$dataDet, "lineas"=>$data);
   	}

   	function verRecibo($uuid){
   		$datos=array();
   		$this->query="SELECT * FROM XML_NOMINA_DETALLE where UUID_NOMINA = '$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$datos[]=$tsArray;
   		}
   		$this->query="SELECT * FROM XML_NOMINA_RECEPTOR WHERE UUID_NOMINA ='$uuid'";
   		$this->query="
   		SELECT XNR.* ,(SELECT DESCRIPCION FROM C_TIPOCONTRATO CTC WHERE CTC.C_TIPOCONTRATO = XNR.TIPOCONTRATO AND STATUS = 'A') AS CONTRATO, (SELECT DESCRIPCION FROM C_TIPOJORNADA CTJ WHERE CTJ.CT_TIPOJORNANDA =  TIPOJORNADA) AS JORNADA, (SELECT DESCRIPCION FROM C_TIPOREGIMEN CTR WHERE CTR.C_TIPOREGIMEN = TIPOREGIMEN) AS REGIMEN, (SELECT DESCRIPCION FROM C_RIESGOPUESTO CRP WHERE CRP.C_RIESGOPUESTO = RIESGOPUESTO ) AS RIESGO, (SELECT DESCRIPCION FROM C_PERIODICIDADPAGO CPP WHERE CPP.C_PERIODICIDAD_PAGO = PERIODICIDADPAGO) AS PERIODO, 
    	(SELECT NOMBRE_ESTADO FROM C_ESTADO CE WHERE CE.C_ESTADO = CLAVEENTFED) AS ESTADO, (SELECT NOMBRE FROM BANCOS_SAT BS WHERE BS.CLAVE = XNR.BANCO ) AS BANCO_SAT
    			FROM XML_NOMINA_RECEPTOR XNR 
    			WHERE XNR.UUID_NOMINA = '$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		$row =ibase_fetch_object($res);
   		$curp = $row->CURP;
   		$nss = $row->NUMSEGURIDADSOCIAL;
   		
   		$this->query="SELECT first 1 * FROM XML_NOMINA_EMPLEADOS WHERE CURP = '$curp' and NSS = '$nss'";
   		$res=$this->EjecutaQuerySimple();
   		$row2 = ibase_fetch_object($res);

   		$this->query="SELECT * FROM XML_NOMINA_TRABAJADOR WHERE UUID_NOMINA ='$uuid'";
   		$res=$this->EjecutaQuerySimple();
   		$row3 = ibase_fetch_object($res);
   		return array("datos"=>$datos, "emp"=>$row2, "nom_emp"=>$row,"nom"=>$row3);
   	}

   	function insertaFile($file, $path){
   		$this->query="INSERT INTO BIO_FILES (ID, ARCHIVO, RUTA, STATUS, NUEVA_RUTA, PEDIMENTO) values (NULL, '$file', '$path', 'nuevo', '', '')";
    	    $this->grabaBD();
    	return;
   	}

   	function cf(){
   		$data = array();
   		$this->query ="SELECT * FROM BIO_PEDIMENTOS WHERE STATUS = 'N'";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		if(count($data)>0){
   			foreach ($data as $p) {
   				$data2 = array();
   				$trim_pedimento = $p->TRIM_PEDIMENTO;
   				$pedimento = substr($trim_pedimento , 8);
   				$this->query="SELECT * FROM BIO_FILES bf where replace(bf.archivo, ' ','') containing('$pedimento') or replace (bf.ruta, ' ','') containing('$pedimento')";
   				$res=$this->EjecutaQuerySimple();
   				while ($tsArray=ibase_fetch_object($res)){
   					$data2[]=$tsArray;
   				}
   				if(count($data2)>0){
	   				foreach ($data2 as $pf) {
	   					$id = $pf->ID; 
	   					$this->query="UPDATE BIO_FILES SET PEDIMENTO = iif(PEDIMENTO = '', '$pedimento', PEDIMENTO||','||'$pedimento') where id = $id";
	   					$this->queryActualiza();
	   				}
   				}
   				echo 'Procesando pedimento: '.$pedimento.' Se encontraron '.count($data2).' archvivos<br/>';
   				unset($data2);
   			$this->query = "UPDATE BIO_PEDIMENTOS SET STATUS = 'P' WHERE trim_pedimento ='$trim_pedimento'";
   			$this->queryActualiza();
   			}
   		}
   	}

   	function creaPaquetes(){
   		$data = array();
   		$zip = new ZipArchive();
   		$rutaFinal = "C:\\xampp\\htdocs\\biotecsa\\zip\\";//ruta donde guardar los archivos zip, la creamos sino existe
		if(!file_exists($rutaFinal)){
		  mkdir($rutaFinal);
		}
   		$this->query="SELECT * FROM BIO_PEDIMENTOS WHERE STATUS = 'P' and files > 0";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)){
   			$data[]=$tsArray;
   		}
   		if(count($data) >0 ){
   			foreach ($data as $p) {
   				$data2=array();
		   		$trim_pedimento = $p->TRIM_PEDIMENTO;
		   		$pedimento = substr($trim_pedimento , 8);
		   		$this->query="SELECT * FROM BIO_FILES WHERE PEDIMENTO = '$pedimento' and status = 'nuevo'";
		   		$res=$this->EjecutaQuerySimple();
		   		while ($tsArray=ibase_fetch_object($res)){
		   			$data2[]=$tsArray;
		   		}
		   		if(count($data2)>0){			   		
					//Asignamos el nombre del archivo zip
					$archivoZip = $pedimento.'.zip'; 
					//Creamos y abrimos el archivo zip
					if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
						  //Agregamos los archivos uno a uno
						foreach ($data2 as $d){
							$ruta=str_replace("/", "\\", $d->RUTA);
							$archivo = $ruta.$d->ARCHIVO;
						  	$zip->addFile($archivo, $d->ARCHIVO);  
						}	
						//Cerramos el archivo zip	 
						$zip->close();
						//Muevo el archivo a una ruta
						//donde no se mezcle los zip con los demas archivos
						rename($archivoZip, "$rutaFinal/$archivoZip");
					  //imrimimos un enlace para descargar el archivo zip
					  echo "Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
					  //die;
					} else {
					  echo 'Error creando ' . $archivoZip;
					}   			
		   		}
   			}
   		}

   	}

   	function totalNomina($fi, $ff){
   		$data = array();
   		$this->query="SELECT TIPO, CLAVE, DED_PER, SUM(IMP_GRAVADO) AS GRAVADO, SUM(IMP_EXENTO) AS EXENTO, max(CONCEPTO) AS CONCEPTO FROM XML_NOMINA_DETALLE XND LEFT JOIN XML_NOMINA_TRABAJADOR XNT ON XNT.UUID_NOMINA = XND.UUID_NOMINA WHERE XNT.FECHA_INICIAL = '$fi' and XNT.FECHA_FINAL = '$ff' group by TIPO, CLAVE, DED_PER";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}

   		return $data;
   	}

   	function calImp($mes, $anio){
   		$filtroMesP="";
   		$filtroMesG="";
   		$data=array();
   		$data2 = array();
   		if($mes > 0){
   			$filtroMesP = ' and extract(month from CP.FECHA_RECEP) = '.$mes;
   			$filtroMesG = ' and extract(month from G.FECHA_EDO_CTA) = '.$mes;
   		}
   		$this->query="SELECT * FROM APLICACIONES A LEFT JOIN CARGA_PAGOS CP ON CP.ID = A.IDPAGO and guardado = 1 WHERE extract(year from CP.FECHA_RECEP) = $anio $filtroMesP";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}

   		$this->query="SELECT * FROM APLICACIONES_GASTOS A LEFT JOIN GASTOS G ON G.ID = A.IDG and guardado = 1 WHERE extract(year from G.FECHA_EDO_CTA) = $anio $filtroMesG";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data2[]=$tsArray;
   		}
   		return array("cobrado"=>$data,"pagado"=>$data2);
   	}

   	function traeVentas($anio, $mes, $tipo){
   		$data=array();
   		$rfce = $_SESSION['rfc'];
   		$m = ($mes==0)? '':' and extract(month from x.fecha) = '.$mes;
   		$d = ($tipo=='det')? ' ':' GROUP BY extract(month from X.fecha), extract(year from x.fecha)';
   		$c = ($tipo=='det')? "xp.*, x.IMPORTE , (SELECT ('('||xc.RFC||')'||NOMBRE) FROM XML_CLIENTES xc WHERE xc.RFC = x.CLIENTE AND TIPO = 'Cliente') as cliente, (SELECT MONTO FROM XML_IMPUESTOS XI WHERE XI.UUID = XP.UUID AND XI.PARTIDA = XP.PARTIDA AND STATUS = 0 AND IMPUESTO = '002') AS IVA160, x.fecha as fecha_doc, " :' SUM(UNITARIO*CANTIDAD) importe, MAX(X.RFCE), ';

   		$this->query ="SELECT $c extract(month from X.fecha) as mes, extract(year from x.fecha) as anio
    					from xml_partidas xp left join xml_data x on x.uuid = xp.uuid
    					where
    					extract(year from X.fecha) = $anio $m 
    					AND X.tipo = 'I'
    					and X.status != 'C'
    					AND X.RFCE = '$rfce'
    					AND (XP.CLAVE_SAT != '84111506' AND XP.unidad_sat != 'ACT')
    					$d ";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		return $data;
   	}

   	function traeAnticipos($anio, $mes, $tipo){
   		$data=array();
   		$rfce = $_SESSION['rfc'];
   		$m = ($mes==0)? '':' and extract(month from x.fecha) = '.$mes;
   		$d = ($tipo=='det')? ' ':' GROUP BY extract(month from X.fecha), extract(year from x.fecha)';
   		$c = ($tipo=='det')? "xp.*, x.IMPORTE , (SELECT ('('||xc.RFC||')'||NOMBRE) FROM XML_CLIENTES xc WHERE xc.RFC = x.CLIENTE AND TIPO = 'Cliente') as cliente, (SELECT MONTO FROM XML_IMPUESTOS XI WHERE XI.UUID = XP.UUID AND XI.PARTIDA = XP.PARTIDA AND STATUS = 0 AND IMPUESTO = '002') AS IVA160, x.fecha as fecha_doc, " :' SUM(UNITARIO*CANTIDAD) importe, MAX(X.RFCE), ';
   		$this->query ="SELECT $c extract(month from X.fecha) as mes, extract(year from x.fecha) as anio
    					from xml_partidas xp left join xml_data x on x.uuid = xp.uuid
    					where
    					extract(year from X.fecha) = $anio $m
    					AND X.tipo = 'I'
    					and X.status != 'C'
    					AND X.RFCE = '$rfce'
    					AND (XP.CLAVE_SAT = '84111506' AND XP.unidad_sat = 'ACT')
    					$d ";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		return $data;	
   	}

   	function traeProdFinan($anio, $mes, $tipo){
   		$data=array();
   		if($tipo == 'gen'){	
   			$this->query="SELECT coalesce(sum(MONTO), 0) as importe, extract(month from fecha_recep)as mes  FROM CARGA_PAGOS WHERE EXTRACT(YEAR FROM FECHA_RECEP)= $anio and guardado = 1 and (tipo_pago = 'intGan')  group by extract(month from fecha_recep)";
   		}elseif($tipo =='det'){
   			$this->query="SELECT cp.*, MONTO as importe, extract(month from fecha_recep) as mes, 'Intereses Ganados' as tipo
   							FROM CARGA_PAGOS cp 
   							WHERE EXTRACT(YEAR FROM FECHA_RECEP)= $anio and guardado = 1 and (tipo_pago = 'intGan')";
   		}
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		return $data;
   	}

   	function traeOtrIng($anio){
   		$data=array();
   		$this->query="SELECT coalesce(sum(MONTO), 0) as importe, extract(month from fecha_recep)as mes  FROM CARGA_PAGOS WHERE EXTRACT(YEAR FROM FECHA_RECEP)= $anio and guardado = 1 and (tipo_pago = 'oIng' or tipo_pago = 'DC' or tipo_pago = 'DG')  group by extract(month from fecha_recep)";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		return $data;	
   	}

   	function traeIsr($anio){
   		$data =array();
   		$this->query="SELECT f.* FROM FTC_IMP_ISR f WHERE f.anio = $anio and f.fecha_pago is not null";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray=ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		if(count($data)>0){   			
   			foreach($data as $isr){	
   			}
   			return array("tipo"=>'c', "cu"=>$isr->CU,"usuario"=>$isr->USUARIO,"fecha"=>$isr->FECHA,"pagos"=>count($data),"mensaje"=>'El coeficiente ha sido definido por '.$isr->USUARIO.' el dia '.$isr->FECHA, "factor"=>$isr->FACTOR,'cu_act'=>$isr->CU_ACT );
   		}else{
   			$this->query="SELECT f.* FROM FTC_IMP_ISR f WHERE f.anio = $anio";
   			$res=$this->EjecutaQuerySimple();
   			while ($tsArray=ibase_fetch_object($res)) {
   				$data[]=$tsArray;
   			}
   			if(count($data)>0){
   				foreach($data as $isr){	
   				}
   				return array("tipo"=>'u',"cu"=>$isr->CU,"usuario"=>$isr->USUARIO,"fecha"=>$isr->FECHA, "mensaje"=>'El coeficiente ha sido definido por '.$isr->USUARIO.' el dia '.$isr->FECHA, "factor"=>$isr->FACTOR, 'cu_act'=>$isr->CU_ACT );
   			}else{
   				return array("tipo"=>'i',"cu"=>'',"usuario"=>'',"fecha"=>'', "mensaje"=>'No existe coeficiente definido.');
   			}	
   		}	
   	}

   	function setCU($cu, $anio, $tipo){
   		$data = array();
   		$usuario=$_SESSION['user']->NOMBRE;
  		if($tipo == 'u'){
  			$this->query="UPDATE FTC_IMP_ISR SET CU = $cu, usuario='$usuario', fecha=current_date where anio = $anio and fecha_pago is null";
  			$this->queryActualiza();
  			return array("status"=>'Si',"mensaje"=>'Se ha actualizado el coeficiente de utilidad');	
  		}elseif ($tipo == 'i'){
  			$this->query="INSERT INTO FTC_IMP_ISR (ID_ISR, ANIO, MES, CALCULADO, PAGADO, CU, FACTOR, STATUS, USUARIO, FECHA) VALUES (NULL, $anio, 1, 0, 0, $cu, .30, 'A', '$usuario', current_date)";
   			$this->grabaBD();
   			return array("status"=>'Si', "mensaje"=>'Se ha establecido el coeficiente de utilidad correctamente');
  		}elseif($tipo == 'c'){
	   		$this->query="SELECT f.* FROM FTC_IMP_ISR f WHERE f.anio = $anio and f.fecha_pago is not null";
	   		$res=$this->EjecutaQuerySimple();
	   		while ($tsArray=ibase_fetch_object($res)) {
	   			$data[]=$tsArray;
	   		}
	   		foreach($data as $isr){	
   			}
   			return array("status"=>'Si', "mensaje"=>'Ya existen Pagos de ISR con un coeficiente diferente, si requiere cambiar el coeficiente lo debe de hacer desde la tabla de coeficientes.');
		}
   	}

   	function setISR($anio, $val, $tipo){
   		$val = $val / 100;
   		$campo = ($tipo == 'isr')?	'FACTOR':'CU_ACT';	
   		
   		$this->query="UPDATE FTC_IMP_ISR SET $campo=$val where anio = $anio";
   		if($this->queryActualiza() >= 1){
   			return array("status"=>'Si', "mensaje"=>'Se ha actualizado correctamente la tasa al '.($val*100).' %');
   		}else{
   			return array("status"=>'No', "mensaje"=>'No se ha podido actualizar la tasa del ISR al parecer ya existe un pago calculado con otra tasa...');
   		}
   	}

   	function gIsr($mes, $anio, $datos){
   		$data=array();
   		$usuario=$_SESSION['user']->NOMBRE;
   		$this->query="SELECT * FROM FTC_IMP_ISR WHERE ANIO = $anio and mes = $mes";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsArray = ibase_fetch_object($res)) {
   			$data[]=$tsArray;
   		}
   		$rep = array("$", ",");
   		$totpg = str_replace($rep, "", $datos['totpg']);
		$isrpg = !isset($datos['isrpg'])?  0:str_replace($rep, "", $datos['isrpg']);
		$cu = !isset($datos['cu'])? 0:str_replace($rep, "", $datos['cu']);
		$tisr_anual = !isset($datos['tisr_anual'])? 0:(str_replace($rep, "", $datos['tisr_anual']))/100;
		$fecha_pago = "null";
		$cu_act = !isset($datos['cu_act'])? 0:str_replace($rep, "", $datos['cu_act']);
		if(count($data)==1){ /// Si existe uno es lo normal, si no existe se guarda como nuevo, si existe mas de 1 es un error por que solo debe de haber un calculo por mes.
			foreach($data as $k){
   				if(!isset($k->FECHA_PAGO)){
   					$this->query="UPDATE FTC_IMP_ISR SET ANIO = $anio, mes = $mes, CALCULADO = $totpg, PAGADO = $isrpg, CU = $cu, FACTOR = $tisr_anual, FECHA_PAGO = $fecha_pago, cu_act = $cu_act, usuario='$usuario', fecha = current_date where anio = $anio and mes = $mes and fecha_pago is null";
   					$res=$this->queryActualiza();
   					if($res == 1){
   						//echo 'Si actualizo, iniciamos la insercion del detalle del calculo';
   						$this->detalleISR($datos, $k->ID_ISR, $rep, $anio, $mes, $usuario, $totpg);
   					}
   				}
   			}

   		}elseif(count($data)==0){
   			// No existe el mes registrado.
   			$this->query="INSERT INTO FTC_IMP_ISR (ID_ISR, ANIO, MES, CALCULADO, PAGADO, CU, FACTOR, STATUS, USUARIO, FECHA, CU_ACT) 
   				VALUES (NULL, $anio, $mes, $totpg, $isrpg, $cu, $tisr_anual, 'A', '$usuario', current_date, $cu_act) RETURNING ID_ISR";
   				echo $this->query;
   			$res=$this->grabaBD();
   			$row = ibase_fetch_object($res);
   			$this->detalleISR($datos, $id_isr = $row->ID_ISR, $rep, $anio, $mes, $usuario, $totpg);

   		}elseif(count($data)> 1){

   		}
   	}

   	function detalleISR($datos, $id_isr, $rep, $anio, $mes, $usuario, $totpg){
   			$this->query="SELECT * FROM FTC_IMP_ISR_DET WHERE ID_ISR = $id_isr";
   						$res = $this->EjecutaQuerySimple();
   						if(ibase_fetch_object($res)){
   							echo 'Si existe borramos el valor anterior';
   							$this->query="DELETE FROM FTC_IMP_ISR_DET WHERE ID_ISR = $id_isr";
   							$this->grabaBD();
   						}
   							//echo 'No existe Valor y se crea un nuevo registro';
   							$tvm = $datos['tvm']==''? 0:str_replace($rep, "", $datos['tvm']);
   							$antcl = $datos['antcl']==''? 0:str_replace($rep, "", $datos['antcl']);
   							$profin = $datos['profin']==''? 0:str_replace($rep, "", $datos['profin']);
   							$otrpro = $datos['otrpro']==''? 0:str_replace($rep, "", $datos['otrpro']);
   							$utlcam = $datos['utlcam']==''? 0:str_replace($rep, "", $datos['utlcam']);
   							$venact = $datos['venact']==''? 0:str_replace($rep, "", $datos['venact']);
   							$toting = $datos['toting']==''? 0:str_replace($rep, "", $datos['toting']);
   							$ingacu = $datos['ingacu']==''? 0:str_replace($rep, "", $datos['ingacu']);
   							$utlfis = $datos['utlfis']==''? 0:str_replace($rep, "", $datos['utlfis']);
   							$ppa = $datos['ppa']==''? 0:str_replace($rep, "", $datos['ppa']);
   							$bisr = $datos['bisr']==''? 0:str_replace($rep, "", $datos['bisr']);
   							$vtisr = $datos['vtisr']==''? 0:str_replace($rep, "", $datos['vtisr']);
   							$impmes = $datos['impmes']==''? 0:str_replace($rep, "", $datos['impmes']);
   							$pgpracval = $datos['pgpracval']==''? 0:str_replace($rep, "", $datos['pgpracval']);
   							$retbc = $datos['retbc']==''? 0:str_replace($rep, "", $datos['retbc']);
   							$isrpg = $datos['isrpg']==''? 0:str_replace($rep, "", $datos['isrpg']);

   							$this->query="INSERT INTO FTC_IMP_ISR_DET (ID, ID_ISR, VENTAS_FACTURADAS, ANTICIPO_CLIENTES, PRODUCTOS_FINANCIEROS, OTROS_PRODUCTOS, UTILIDAD_CAMBIARIA, VENTA_ACTIVOS, TOTAL_INGRESOS_MENSUALES, TOTAL_INGRESOS_ACUMULADOS, UTL_FISCAL, PERDIDAS_PENDIENTES, BASE_ISR, TASA_ISR, IMPUESTO_MES, PAGO_PROVISIONAL, ISR_RETENIDO, TOTAL_PAGAR_MES, TOTAL_PAGADO, TIPO_DECLARACION, EJERCICIO, PERIODO, USUARIO, FECHA, STATUS, COMPROBANTE, FECHA_BAJA, USUARIO_BAJA) 
   							VALUES (null, $id_isr, $tvm, $antcl, $profin, $otrpro, $utlcam, $venact, $toting, $ingacu, $utlfis, $ppa, $bisr, $vtisr, $impmes, $pgpracval, $retbc, $totpg , $isrpg, '', $anio, $mes , '$usuario', current_date, 'A', '', null, '' )";
   							echo $this->query;
   							$this->grabaBD();
   			return;
   	}

   	function traeDocs($datos, $tipo){
   		$data = array();
   		$uuid = '';
   		for ($i=0; $i < count($datos) ; $i++) { 
   			$uuid .= "'".$datos[$i]."',";
   		}
   		$uuid=substr($uuid, 0, -1);
   		$this->query="SELECT x.*, xc.cuenta_contable, xc.nombre FROM xml_data x left join xml_clientes xc on xc.rfc = x.rfce and xc.tipo='Proveedor' where x.uuid in ($uuid)";
   		$res=$this->EjecutaQuerySimple();
   		while ($tsarray=ibase_fetch_object($res)) {
   			$data[]=$tsarray;
   		}
   		return $data;
   	}

   	function impuestosPolizaFred($documentos, $por){
		$data = array();
		if(!empty($documentos)){
			$p = 1;
		 	foreach ($documentos as $u) {
		 		$uu=$u->UUID;
		 		$this->query="SELECT impuesto, tasa, tipofactor, tipo, sum(MONTO) * $por AS MONTO, SUM(BASE) AS BASE, $p as partida, MAX(UUID) AS UUID, (select max(RFCE) from xml_data xd where xd.UUID = '$uu') AS RFCE,  (select max(CLIENTE) from xml_data xd where xd.UUID = '$uu' ) AS CLIENTE 
		 			FROM XML_IMPUESTOS 
		 			WHERE UUID = '$uu' 
		 			and status= 0 
		 			group by impuesto, tasa, tipofactor, Tipo";
		 		$res=$this->EjecutaQuerySimple();
				while ($tsArray=ibase_fetch_object($res)){
					$data[]=$tsArray;
				}	
		 		$p++;
		 	}
		}	
	 	return $data;	
	}

	function infoMesIsr($anio){
		$data = array();
		$this->query="SELECT f.*, fd.*, (SELECT COUNT(*) FROM FTC_MEDIA_FILES WHERE f.ID_ISR = f.id_isr) as archivos FROM FTC_IMP_ISR f LEFT JOIN ftc_imp_isr_det FD ON F.id_isr = fd.id_isr where anio = $anio ";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function ftc_files($tipo, $subtipo, $anio){
		$data=array();
		$this->query="SELECT * FROM FTC_MEDIA_FILES fm left join FTC_IMP_ISR F on f.$subtipo = fm.ID_REF WHERE TIPO = '$tipo' and SUB_TIPO = '$subtipo' and fm.STATUS = 'A' and f.anio=$anio order by f.mes";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function gp($mes, $anio, $monto){
		$rep=array("$",",");
		$monto = str_replace($rep, "", $monto);
		$usuario = $_SESSION['user']->NOMBRE;
		$this->query="UPDATE FTC_IMP_ISR SET PAGADO = $monto, fecha_pago = current_timestamp, usuario_pago = '$usuario' where anio = $anio and mes = $mes and fecha_pago is null";
		if($this->queryActualiza() == 1){
			return array("statsu"=>'si', "mensaje"=>'Se guardo correctamente el monto, ya puede cargar los comprobantes');
		}else{
			$this->query="SELECT * FROM FTC_IMP_ISR WHERE anio = $anio and mes=$mes and fecha_pago is not null";
			$res=$this->EjecutaQuerySimple();
			$row  = ibase_fetch_object($res);
			if(isset($row->USUARIO_PAGO)){
				return array("status"=>'no', "mensaje"=>'El monto Pagado ya esta guardado desde el <b>'. $row->FECHA_PAGO .'</b> por el usuario <b>'. $row->USUARIO_PAGO. '</b> con un monto de $ <font color="green"> '.number_format($row->PAGADO,2).'</font>');
			}else{
				return array("statsu"=>'no', "mensaje"=>'No se encontro el calculo, primero debe de grabar el calculo antes de grabar el pago...');
			}
		}
	}

	function gCompISR($mes, $anio, $files, $ruta, $tipo, $nmes){
		$usuario=$_SESSION['user']->NOMBRE;
		for ($i=0; $i < count($files) ; $i++) { 
			$file = $files[$i];
			if($tipo == 'Compara'){
				$this->query="INSERT INTO FTC_MEDIA_FILES (TIPO, SUB_TIPO, ID_REF, NOMBRE, UBICACION, DESCRIPCION, FECHA_ALTA, USUARIO_ALTA, STATUS) VALUES ( '$tipo', 'XLS', 0, '$file', '$ruta', 'Compara la nomina del '||'$mes'||' al '||'$anio' , current_timestamp, '$usuario', 'A')";
				$this->grabaBD();
				$this->comparaFile($ruta, $file, $mes, $anio);
			}else{
				$this->query="INSERT INTO FTC_MEDIA_FILES (TIPO, SUB_TIPO, ID_REF, NOMBRE, UBICACION, DESCRIPCION, FECHA_ALTA, USUARIO_ALTA, STATUS) VALUES ( 'IMPUESTO', 'ID_'||'$tipo', (SELECT ID_$tipo FROM FTC_IMP_ISR WHERE ANIO=$anio and MES = $nmes), '$file', '$ruta', '', current_timestamp, '$usuario', 'A')";
				$this->grabaBD();
			}
		}
		return;
	}

	function comparaFile($ruta, $file, $mes, $anio){
		echo 'Abrimos el archivo y comenzamos la lectura'.$ruta.$file;
		$archivo = $ruta.$file;
		$rfc = $_SESSION['rfc'];
		$usuario = $_SESSION['user']->NOMBRE;
		$inputFileType=PHPExcel_IOFactory::identify($archivo);
        $objReader=PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel=$objReader->load($archivo);
        $sheet=$objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        ++$highestColumn;
        echo '<br/>Ultima columna con Valores:'.$highestColumn;
        echo '<br/>Ultima Fila con Valores:'.$highestRow;
        $errores=0;
        for ($row=4; $row <= $highestRow; $row++){ //10
     		$colum =  'A';
     		$no_emp = $sheet->getCell('A'.$row)->getCalculatedValue();//Numero de empleado
     		$nom_emp = $sheet->getCell('B'.$row)->getCalculatedValue();// Nombre del empleado
            for($col='C'; $col != $highestColumn; $col++){
            	$a = $sheet->getCell($col.$row)->getCalculatedValue();//  
	            $cve = $sheet->getCell($col.'2')->getCalculatedValue();// Clave SAT
	            $obs = $sheet->getCell($col.'3')->getCalculatedValue();// Descripcion
	            $mnto = $sheet->getCell($col.$row)->getCalculatedValue() == ''? 0:$sheet->getCell($col.$row)->getCalculatedValue();
	            $this->query = "INSERT INTO XML_NOMINA_XLS (NO_EMPLEADO, NOMBRE, CLAVE, MONTO, ARCHIVO, FECHA, USUARIO, FI_NOMINA, FF_NOMINA, STATUS, OBSERVACIONES ) VALUES ('$no_emp', '$nom_emp', '$cve', $mnto, '$file', current_timestamp, '$usuario', '$mes', '$anio', 'I', '$obs')";
	            if(!$this->grabaBD()){
	            	$errores++; 
	            }
	            ++$colum;
            }            
        }
        return;
        //fclose($diot);
        //return array("status"=>'ok', "m"=>'Se ha creado el arvivo'.$diot_archivo, "a"=>$diot_archivo);
	}

	function docPg($mes, $anio, $tipo){
		$data=array();
		if($mes == 0){
			$m = '';
		}else{
			$m = " and mes = ".$mes;
		}
		if($tipo == 'd'){
			$this->query="SELECT * FROM DOCUMENTOS_PAGADOS WHERE ANIO = $anio $m ";
		}else{
			$this->query="SELECT RFC, SUM(TOTAL_IVA) AS TOTAL_IVA, MAX(NOMBRE) AS NOMBRE, MAX(TIPO_TER) AS TIPO_TER, MAX(TIPO_OPE) AS TIPO_OPE, COUNT(DOCUMENTO) AS DOCUMENTOS, min(nat) as nat FROM DOCUMENTOS_PAGADOS WHERE ANIO = $anio $m group by RFC ";
		}
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function docCb($mes, $anio){
		$data=array();
		if($mes == 0){
			$m = '';
		}else{
			$m = " and mes = ".$mes;
		}
		$this->query="SELECT * FROM DOCUMENTOS_COBRADOS WHERE ANIO = $anio $m ";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function truncarNumero($numero, $dec, $dect){
		$numero = number_format($numero,$dec,".","");
		$numero = explode(".", $numero);
		$decimal = substr($numero[1],0,$dect);
		return $numero[0].".".$decimal;
	}

	function isrDet($mes, $anio, $tipo){
		if($tipo == 'vf'){
			return $this->traeVentas($anio, $mes, 'det');
		}elseif($tipo == 'ac'){
			return $this->traeAnticipos($anio, $mes, 'det');
		}elseif($tipo == 'pf'){
			return $this->traeProdFinan($anio, $mes, 'det');
		}
	}

	function gpd($po , $pt, $rfc){
		$po = substr($po, 0,2);
		$pt = substr($pt, 0,2);
		$this->query="SELECT * FROM XML_CLIENTES_DET WHERE ID_CL = (SELECT first 1 IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = 'Proveedor')";
		$res=$this->EjecutaQuerySimple();
		if($row=ibase_fetch_object($res)){
			$this->query="UPDATE XML_CLIENTES_DET SET TIPO_TERCERO_SAT = '$pt', TIPO_OPERACION_SAT = '$po' where ID_CL = (SELECT first 1 IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = 'Proveedor')";
			$this->queryActualiza();
			$mensaje= "Se ha Actualizado correctamente";
		}else{
			$this->query="INSERT INTO XML_CLIENTES_DET (ID_CL, TIPO_TERCERO_SAT, TIPO_OPERACION_SAT) VALUES ((SELECT first 1 IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = 'Proveedor'), '$pt', '$po')";
			$this->grabaBD();
			$mensaje = 'Se ha insertado correctamente';
		}
		return array("status"=>'ok', "mensaje"=>$mensaje);
	}

	function infoProv($rfc, $tipo){
		$data=array();$data2=array();$data3=array();$data4=array();
		if($tipo == 'Recibidos'){
			$this->query="SELECT x.*, c.* , cd.*, td.descripcion as tipo_doc, (SELECT SUM(X1.IMPORTE) FROM XML_DATA X1 WHERE X1.RFCE = '$rfc') as total_gral FROM XML_DATA x left join XML_CLIENTES c on c.rfc = x.rfce and c.tipo = 'Proveedor' left join XML_CLIENTES_DET cd on cd.id_cl = c.IDCLIENTE left join xml_tipo_doc td on td.id_tipo = x.id_relacion WHERE RFCE = '$rfc'";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data[]=$tsArray;
			}
			$this->query="SELECT extract(year from fecha) as ejercicio,  max(RFCE), sum(IMPORTE) AS IMPORTE FROM XML_DATA x where rfce='$rfc' and status!='C' group by extract(year from fecha)  
			";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data2[]=$tsArray;
			}
			$this->query="SELECT x.id_relacion, count(*) AS DOCUMENTOS, coalesce (max(td.descripcion), 'Sin Definir') as descripcion from xml_data x  left join xml_tipo_doc td on td.id_tipo = x.id_relacion where rfce='$rfc' group by x.id_relacion order by count(*) desc ";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data3[]=$tsArray;
			}
			$this->query="SELECT * FROM XML_TIPO_DOC WHERE ID_TIPO >= 2000 AND ID_TIPO < 3000";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data4[]=$tsArray;
			}	
		}else{
			$this->query="SELECT x.*, c.* , cd.*, td.descripcion as tipo_doc, (SELECT SUM(X1.IMPORTE) FROM XML_DATA X1 WHERE X1.CLIENTE = '$rfc') as total_gral FROM XML_DATA x left join XML_CLIENTES c on c.rfc = x.CLIENTE and c.tipo = 'Cliente' left join XML_CLIENTES_DET cd on cd.id_cl = c.IDCLIENTE left join xml_tipo_doc td on td.id_tipo = x.id_relacion WHERE CLIENTE = '$rfc'";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data[]=$tsArray;
			}
			$this->query="SELECT extract(year from fecha) as ejercicio,  max(CLIENTE), sum(IMPORTE) AS IMPORTE FROM XML_DATA x where CLIENTE='$rfc' and status!='C' group by extract(year from fecha)  
			";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data2[]=$tsArray;
			}
			$this->query="SELECT x.id_relacion, count(*) AS DOCUMENTOS, coalesce (max(td.descripcion), 'Sin Definir') as descripcion from xml_data x  left join xml_tipo_doc td on td.id_tipo = x.id_relacion where CLIENTE='$rfc' group by x.id_relacion order by count(*) desc ";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data3[]=$tsArray;
			}
			$this->query="SELECT * FROM XML_TIPO_DOC WHERE ID_TIPO >= 1000 AND ID_TIPO < 2000";
			$res =$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)){
				$data4[]=$tsArray;
			}
		}
		return array("detalle"=>$data, "tot_anl"=>$data2, "tipo_doc"=>$data3, "tipoDocs"=>$data4);
	}


	function setTD($rfc, $t, $t2, $t3){
		$m = $t2=='t'? ' ':' and (id_relacion is null or id_relacion = 0) ';
		$p = $t3=='Recibidos'? "Proveedor":"Cliente";
		$r = $t3=='Recibidos'? "rfce":"cliente";
		$this->query="UPDATE XML_DATA SET id_relacion = $t where $r = '$rfc' $m";
		$res = $this->queryActualiza();

		$this->query="SELECT * FROM XML_CLIENTES_DET WHERE id_cl = (SELECT IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = '$p')";
		$r = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($r);
		if(!isset($row)){
			$this->query="INSERT INTO XML_CLIENTES_DET (ID_CL, TIPO_DOCU) VALUES ( (SELECT IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = '$p'), $t)";
			echo $this->query;
			$re = $this->grabaBD();
		}else{
			$this->query="UPDATE XML_CLIENTES_DET SET TIPO_DOCU = $t where id_cl = (SELECT IDCLIENTE FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo = '$p')";
			$re = $this->queryActualiza();
		}
		return array("mensaje"=>'Se Actualizaron '.$res.' facturas.', "mensaje2"=>'Se actualizo el'.$p);
	}

	function gxf($a, $m, $i, $d){
		$this->query = "SELECT * FROM XML_docs WHERE RFC != (SELECT E.RFC FROM FTC_EMPRESAS E WHERE E.ID = 1) and mes = $m and anio = $a";
		echo $this->query;
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function rgxf($u){
		$this->query="SELECT * FROM XML_DOCS WHERE UUID = '$u'";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function getDoc($doc){
		$this->query="SELECT tipo, DOCUMENTO, CAST(DESCRIPCION AS VARCHAR(2000)) AS DESCRIPCION, CLIENTE, FI, FF, USUARIO, PRESUPUESTO, VALOR FROM XML_GET_DOCS WHERE DESCRIPCION CONTAINING('$doc') or documento containing ('$doc') or tipo containing ('$doc')";
		$rs=$this->QueryDevuelveAutocompletePro();
		return @$rs;
	}
	
	function cancelados($opc){
		$data=array();
		$this->query="SELECT * FROM FTC_META_DATOS where fecha_cancelacion is not null and rfce = (SELECT RFC FROM FTC_EMPRESAS WHERE ID = 1)";
		$res=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		return $data;
	}

}