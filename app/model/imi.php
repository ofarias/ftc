<?php 

require_once 'app/model/database2.php';

class imi extends database2{

	function insertarArchivoXMLCargado($archivo, $tipo, $a){
        $TIME = time();
        $HOY = date("Y-m-d H:i:s", $TIME);
        $usuario = $_SESSION['user']->USER_LOGIN;
        $file=substr($archivo, 37,200);
        $file=str_replace(".xml", "", $file);
        $uuid=$a['uuid'];
        $tcf=$a['tcf'];
        $this->query="INSERT INTO XML_DATA_FILES (ID,NOMBRE,ARCHIVO,FECHA,USUARIO,TIPO, UUID, TIPO_FISCAL)VALUES(NULL,'$archivo','$file','$HOY','$usuario', '$tipo', '$uuid','$tcf')";
        $respuesta = $this->grabaBD();
        $this->insertaXMLData($archivo, $tipo, $uuid);
        $this->actParametros($uuid, $tipo);
        return $respuesta;
    }

    function actParametros($uuid, $tipo){
    	$data = array();
    	$this->query="SELECT XD.CLIENTE AS RFCR, XD.RFCE AS RFCE, XP.* FROM XML_PARTIDAS XP LEFT JOIN XML_DATA XD ON XD.UUID = XP.UUID WHERE xp.UUID = '$uuid'";
    	//echo '<br/>'.$this->query.'<br/>';
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	foreach($data as $pd){
    		$rfce = $pd->RFCE; /// Cuando el rfc emisor es de la empresa que se trabaja es una venta
    		$rfcr = $pd->RFCR; /// Cuando el rfc receptor es de la empresa que se trabaja es una compra 		
    		$this->query="SELECT MAX(CUENTA_CONTABLE) as CUENTA_CONTABLE from xml_partidas where rfc = '$rfcr' and CLAVE_SAT = '$pd->CLAVE_SAT' and UNIDAD_SAT = '$pd->UNIDAD_SAT'";
    		$r=$this->EjecutaQuerySimple();
    		//print '<br/>'.$this->query.'<br/>';
    		$row=ibase_fetch_object($r);
    		if(strlen($row->CUENTA_CONTABLE) > 0){
    			$this->query="UPDATE XML_PARTIDAS SET CUENTA_CONTABLE = '$row->CUENTA_CONTABLE' WHERE uuid='$uuid' and partida=$pd->PARTIDA";
    			//print '<br/>'.$this->query.'<br/>';
    			$this->queryActualiza();
    		}
    	}
    	return;
    }

	function seleccionarArchivoXMLCargado($archivo, $uuid){
		$this->query= "SELECT NOMBRE,ARCHIVO,FECHA,USUARIO,TIPO FROM XML_DATA_FILES WHERE UUID = '$uuid';";
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
      	return @$data;
    }


    function insertaXMLData($archivo, $tipo, $uuid){
    	$tipo2 = $tipo;
    	$data = $this->seleccionarArchivoXMLCargado($archivo,$uuid);
        if($data!=null and $tipo2 == 'F'){
            foreach ($data as $row):
                $file = $row->NOMBRE;
            endforeach;
            $myFile = fopen("$file", "r") or die("No se ha logrado abrir el archivo ($file)!");
            $myXMLData = fread($myFile, filesize($file));
            $xml = @simplexml_load_string($myXMLData) or die("Error: No se ha logrado crear el objeto XML ($file)");
            $ns = $xml->getNamespaces(true);
            $xml->registerXPathNamespace('c', $ns['cfdi']);
            $xml->registerXPathNamespace('t', $ns['tfd']);
            @$xml->registerXPathNamespace('impl', $ns['implocal']);
            @$xml->registerXPathNamespace('p10',$ns['pago10']);
            foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
            	  $version = $cfdiComprobante['version'];
				  if($version == ''){
				  	$version = $cfdiComprobante['Version'];
				  }
				  if($version == '3.2'){
				      $serie = $cfdiComprobante['serie'];                  
	                  $folio = $cfdiComprobante['folio'];
	                  $total = $cfdiComprobante['total'];
	                  $subtotal = $cfdiComprobante['subTotal'];
					  $descuento = $cfdiComprobante['descuento'];
					  $tipo = $cfdiComprobante['tipoDeComprobante'];
				  	  $condicion = $cfdiComprobante['condicionesDePago'];
					  $metodo = $cfdiComprobante['metodoDePago'];
       				  $moneda = $cfdiComprobante['Moneda'];
					  $lugar = $cfdiComprobante['LugarExpedicion'];
					  $tc = empty($cfdiComprobante['TipoCambio'])? 1:$cfdiComprobante['TipoCambio'];
					  $Certificado = $cfdiComprobante['certificado'];
					  $Sello = $cfdiComprobante['sello'];
					  $noCert = $cfdiComprobante['noCertificado'];
					  $formaPago = $cfdiComprobante['formaDePago'];
					  $LugarExpedicion = $cfdiComprobante['LugarExpedicion'];
					  $MetodoPago = $cfdiComprobante['metodoDePago'];
				  }elseif($version == '3.3'){
				      $serie = $cfdiComprobante['Serie'];                  
	                  $folio = $cfdiComprobante['Folio'];
	                  $total = $cfdiComprobante['Total'];
	                  $subtotal = $cfdiComprobante['SubTotal'];
					  $descuento = $cfdiComprobante['Descuento'];
					  $tipo = $cfdiComprobante['TipoDeComprobante'];
					  $condicion = $cfdiComprobante['CondicionesDePago'];
					  $metodo = $cfdiComprobante['MetodoPago'];
					  $moneda = $cfdiComprobante['Moneda'];
					  $lugar = $cfdiComprobante['LugarExpedicion'];
					  $tc = empty($cfdiComprobante['TipoCambio'])? 1:$cfdiComprobante['TipoCambio'];
					  $Certificado = $cfdiComprobante['Certificado'];
					  $Sello = $cfdiComprobante['Sello'];
					  $noCert = $cfdiComprobante['NoCertificado'];
					  $formaPago = $cfdiComprobante['FormaPago'];
					  $LugarExpedicion = $cfdiComprobante['LugarExpedicion'];
					  $MetodoPago = $cfdiComprobante['MetodoPago'];
				  }
			}
			
            if($tipo == 'P'){
            	$serieComp = $serie; 
            	$folioComp = $folio;

            }

            if(($tipo == 'I' or $tipo == 'E' or $tipo == 'ingreso' or $tipo == 'egreso' or $tipo== 'P') and $serie != 'NOMINA'){
            			$this->query="UPDATE XML_DATA_FILES SET TIPO = '$tipo' WHERE NOMBRE='$archivo'";
            			$this->EjecutaQuerySimple();

			        	foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
			            	if($version == '3.2'){
			            		$rfc= $Receptor['rfc'];
			           		 	$nombre_recep = utf8_encode($Receptor['nombre']);
			            		$usoCFDI = '';
			            	}elseif($version == '3.3'){
			            		$rfc= $Receptor['Rfc'];
			            		$nombre_recep=utf8_encode($Receptor['Nombre']);
			            		$usoCFDI =$Receptor['UsoCFDI'];
			            	 }
			            }
			            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){
			            	if($version == '3.2'){
			            		$rfce = $Emisor['rfc'];
			            		$nombreE = '';
			            		$regimen = '';	
			            	}elseif($version == '3.3'){
			            		$rfce = $Emisor['Rfc'];
			            		$nombreE = utf8_encode($Emisor['Nombre']);
			            		$regimen = $Emisor['RegimenFiscal'];
			            	}
			            }
			            		$recep_calle='';
				            	$recep_noExterior='';
				            	$recep_noInterior='';
				            	$recep_colonia='';
				            	$recep_municipio='';
				            	$recep_estado='';
				            	$recep_pais='';
				            	$recep_cp='';

			            foreach($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $Emisor_dir){
			            	if($version == '3.2'){
			            		$recep_calle=$Emisor_dir['calle'];
				            	$recep_noExterior=$Emisor_dir['noExterior'];
				            	$recep_noInterior=$Emisor_dir['noInterior'];
				            	$recep_colonia=$Emisor_dir['colonia'];
				            	$recep_municipio=$Emisor_dir['municipio'];
				            	$recep_estado=$Emisor_dir['estado'];
				            	$recep_pais=$Emisor_dir['pais'];
				            	$recep_cp=$Emisor_dir['codigoPostal'];
			            	}elseif($version == '3.3'){
			            		$recep_calle='';
				            	$recep_noExterior='';
				            	$recep_noInterior='';
				            	$recep_colonia='';
				            	$recep_municipio='';
				            	$recep_estado='';
				            	$recep_pais='';
				            	$recep_cp='';
			            	}
			            }
			            /// debemos traer el RFC de la empresa que se esta trabajando.
			            $rfcEmpresa = $_SESSION['rfc'];
			            //echo 'Este es el RFC: '.$rfc.'<br/>';

			            if($rfc == $rfcEmpresa){
			            	$tipoC = 'Proveedor';
							$this->query="SELECT * FROM XML_CLIENTES WHERE RFC = '$rfce' and tipo ='$tipoC'";
			            	$res=$this->EjecutaQuerySimple();
			            	$row=ibase_fetch_object($res);
			            	$nombreE=$nombreE;
			            	if(empty($row)){
			            		$this->query="INSERT INTO XML_CLIENTES (IDcliente, RFC, NOMBRE, CALLE, EXTERIOR, INTERIOR, COLONIA, MUNICIPIO, ESTADO, PAIS, CP, TIPO)
			            				  VALUES (NULL, '$rfce', '$nombreE', '$recep_calle', '$recep_noExterior', '$recep_noInterior', '$recep_colonia', '$recep_municipio', '$recep_estado', '$recep_pais', '$recep_cp', '$tipoC' )";
			            		if($this->grabaBD() === false){
			            			echo 'Error en la insercion de '.$tipoC.'<br/>';
			            			echo $this->query.'<br/>';
			            		}  	
			            	}			            	
			            }else{
			            	$tipoC = 'Cliente';
			            	$this->query="SELECT * FROM XML_CLIENTES WHERE RFC = '$rfc' and tipo ='$tipoC'";
			            	$res=$this->EjecutaQuerySimple();
			            	$row=ibase_fetch_object($res);
			            	$nombre_recep=$nombre_recep;
			            	if(empty($row)){
			            		$this->query="INSERT INTO XML_CLIENTES (IDcliente, RFC, NOMBRE, CALLE, EXTERIOR, INTERIOR, COLONIA, MUNICIPIO, ESTADO, PAIS, CP, TIPO)
			            					  VALUES (NULL, '$rfc', '$nombre_recep', '$recep_calle', '$recep_noExterior', '$recep_noInterior', '$recep_colonia', '$recep_municipio', '	$recep_estado', '$recep_pais', '$recep_cp', '$tipoC' )";	
			            		if($this->grabaBD() === false){  	
			            			echo 'Error en la insercion de '.$tipoC.'<br/>';
			            			echo $this->query.'<br/>';
			            		}
			            	}
			            }
			            //echo $this->query;			            
			            $parIT=0;
			            $partidaImp=array();
			          	$parte_partida=array();
			          	$parInfoAduana=array();
			           	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){
			            	$parIT++;
			            	if($version ==  '3.2'){
				            	$unidad = $Concepto['unidad'];
				            	$importe = $Concepto['importe'];
				            	$cantidad = $Concepto['cantidad'];
				            	$descripcion = htmlentities($Concepto['descripcion']);
				            	$valor = $Concepto['valorUnitario'];
				            	$claveSat='';
				            	$claveUni='';
				            	$partida[] =array($unidad, $importe, $cantidad, $descripcion, $valor,$claveSat, $claveUni); 
			            	}elseif($version =='3.3'){
			            		$unidad = $Concepto['Unidad'];
				            	$importe = $Concepto['Importe'];
				            	$cantidad = $Concepto['Cantidad'];
				            	$descripcion = htmlentities($Concepto['Descripcion']);
				            	$valor = $Concepto['ValorUnitario'];
				            	$claveSat=$Concepto['ClaveProdServ'];
				            	$claveUni=$Concepto['ClaveUnidad'];
				            	$descp = isset($Concepto['Descuento'])? $Concepto['Descuento']:0;
				            	$partida[]=array($unidad, $importe, $cantidad, $descripcion, $valor, $claveSat, $claveUni, $descp); 
			            	}
			            	//echo '<br/>Valor de parIT antes de los Impuestos: '.$parIT.'<br/>';
			           		if($Concepto->xpath('cfdi:Impuestos')){
			           			if($Concepto->xpath('cfdi:Impuestos//cfdi:Traslados')){
			           				//echo '<br/> La partida '.$parIT.' tiene Traslados';
									foreach ($Concepto->xpath('cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $TrasladoPartida) {
			           					if($version ==  '3.2'){
							            	$base='';
							            	$parImpuesto='';
							            	$parTipoFact='';
							            	$parTasaCuota='';
							            	$parImpImporte='';
							           		$partidaImp[]=array($base, $parImpuesto, $parTipoFact, $parTasaCuota, $parImpImporte); 
						            	}elseif($version =='3.3'){
						            		$base = $TrasladoPartida['Base'];
							            	$parImpuesto= $TrasladoPartida['Impuesto'];
							            	$parTipoFact = $TrasladoPartida['TipoFactor'];
							            	$parTasaCuota = $TrasladoPartida['TasaOCuota'];
							            	$parImpImporte = $TrasladoPartida['Importe'];
							            	$tipoImp = 'Traslado';
							            	$partidaImp[]=array($base, $parImpuesto, $parTipoFact, $parTasaCuota, $parImpImporte, $tipoImp, $parIT); 
						            	}
			           					//echo '<br/>Impuesto: '.$a.' base='.$b.' tipo: '.$tipo.' de la partida: '.$parIT.'<br/>';
			           				}
			           			}else{
			           				//echo '<br/> La partida '.$parIT.' No tiene Traslados<br/>';
			           			}
			           			if($Concepto->xpath('cfdi:Impuestos//cfdi:Retenciones')){
			           				//echo '<br/> La partida '.$parIT.' tiene Retenciones<br/>';
			           				foreach ($Concepto->xpath('cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $RetencionPartida) {
			           					if($version ==  '3.2'){
							            	$base='';
							            	$parImpuesto='';
							            	$parTipoFact='';
							            	$parTasaCuota='';
							            	$parImpImporte='';
							           		$partidaImp[]=array($base, $parImpuesto, $parTipoFact, $parTasaCuota, $parImpImporte); 
						            	}elseif($version =='3.3'){
						            		$base = $RetencionPartida['Base'];
							            	$parImpuesto= $RetencionPartida['Impuesto'];
							            	$parTipoFact = $RetencionPartida['TipoFactor'];
							            	$parTasaCuota = $RetencionPartida['TasaOCuota'];
							            	$parImpImporte = $RetencionPartida['Importe'];
							            	$tipoImp = 'Retencion';
							            	$partidaImp[]=array($base, $parImpuesto, $parTipoFact, $parTasaCuota, $parImpImporte, $tipoImp, $parIT); 
						            	}
			           					//echo '<br/>Impuesto: '.$a.' base='.$b.' tipo: '.$tipo.' de la partida: '.$parIT.'<br/>';
			           				}
			           			}else{
			           				//echo '<br/> La partida '.$parIT.' no tiene Retenciones<br/>';
			           			}
			           		}else{
			           			//echo 'La partida '.$parIT.' no Tiene impuestos<br/>';
			           		}
			            
			           		if($Concepto->xpath('cfdi:InformacionAduanera')){
			          			foreach ($Concepto->xpath('cfdi:InformacionAduanera') as $infoAdu) {
			          				if($version == '3.2'){
			          					$numPed = $infoAdu['NumeroPedimento'];
			          					$fechaPed = isset($infoAdu['fechaPedimento'])? $infoAdu['fechaPedimento']:'01.01.1909';
			          					$parInfoAduana[]=array($numPed, $parIT, $fechaPed, $cantiPed, $descripcion);
			          				}elseif($version == '3.3'){
			          					$numPed = $infoAdu['NumeroPedimento'];
			          					$fechaPed = isset($infoAdu['fechaPedimento'])? $infoAdu['fechaPedimento']:'01.01.1909';
			          					$cantiPed = isset($infoAdu['cantidad'])? $infoAdu['cantidad']:$cantidad; 
			          					$parInfoAduana[]=array($numPed, $parIT, $fechaPed, $cantiPed, $descripcion);
			          				}
			          			}
			          		}
			          		if($Concepto->xpath('cfdi:Parte')){
			          			foreach ($Concepto->xpath('cfdi:Parte') as $parte){
			          				if($version == '3.2'){
			          					$parte_unidad = $Concepto['unidad'];
				            			$parte_importe = $Concepto['importe'];
				            			$parte_cantidad = $Concepto['cantidad'];
				            			$parte_descripcion = htmlentities($Concepto['descripcion']);
				            			$parte_valor = $Concepto['valorUnitario'];
				            			$parte_claveSat='';
				            			$parte_claveUni='';
				            			$parte_partida[] =array($parte_unidad, $parte_importe, $parte_cantidad, $parte_descripcion, $parte_valor,$parte_claveSat, $parte_claveUni, $parIT);
			          				}elseif($version == '3.3'){
			          					$parte_unidad = $Concepto['Unidad'];
				            			$parte_importe = $Concepto['Importe'];
				            			$parte_cantidad = $Concepto['Cantidad'];
				            			$parte_descripcion = htmlentities($Concepto['Descripcion']);
				            			$parte_valor = $Concepto['ValorUnitario'];
				            			$parte_claveSat=$Concepto['ClaveProdServ'];
				            			$parte_claveUni=$Concepto['ClaveUnidad'];
				            			$parte_descp = isset($Concepto['Descuento'])? $Concepto['Descuento']:0;
				            			$parte_partida[]=array($parte_unidad, $parte_importe, $parte_cantidad, $parte_descripcion, $parte_valor, $parte_claveSat, $parte_claveUni, $parte_descp, $parIT); 
			            			}
			          			}
			          		}

			            }
			          	//// Revisamos si tiene el nodo Pago  $xml->xpath('//impl:ImpuestosLocales//impl:TrasladosLocales'
			          	$pago = array();
			          	$pagoDetalle=array();
			          	if($xml->xpath('//p10:Pagos')){
			          		foreach ($xml->xpath('//p10:Pagos') as $pg){
			          			foreach ($pg->xpath('//pago10:Pago') as $pggen){
			          				$fechaPago =isset($pggen['FechaPago'])? $pggen['FechaPago']:'01.01.1999';
			          				$formaPago =isset($pggen['FormaDePagoP'])? $pggen['FormaDePagoP']:'';
			          				$mondedaPago =isset($pggen['MonedaP'])? $pggen['MonedaP']:'';
			          				$monto =isset($pggen['Monto'])? $pggen['Monto']:0;
			          				$numOperacion =isset($pggen['NumOperacion'])? $pggen['NumOperacion']:'';
			          				$rfcEmisorCtaOrd =isset($pggen['rfcEmisorCtaOrd'])? $pggen['rfcEmisorCtaOrd']:'';
 			          				$ctaOrdenante =isset($pggen['CtaOrdenante'])? $pggen['CtaOrdenante']:'';
			          				$rfcEmisorCtaBen=isset($pggen['RfcEmisorCtaBen'])? $pggen['RfcEmisorCtaBen']:'';
			          				$ctaBeneficiario=isset($pggen['CtaBeneficiario'])? $pggen['CtaBeneficiario']:'';
			          				$pago[]=array("fechaPago"=>$fechaPago,"formaPago"=>$formaPago,"mondedaPago"=>$mondedaPago,"monto"=>$monto,"numOperacion"=>$numOperacion,"rfcEmisorCtaOrd"=>$rfcEmisorCtaOrd,"ctaOrdenante"=>$ctaOrdenante,"rfcEmisorCtaBen"=>$rfcEmisorCtaBen,"ctaBeneficiario"=>$ctaBeneficiario);
			          			}
			          			foreach ($pg->xpath('//pago10:DoctoRelacionado') as $pgdet){
			          				$idDocumento =isset($pgdet['IdDocumento'])? $pgdet['IdDocumento']:''; 
			          				$serie =isset($pgdet['Serie'])? $pgdet['Serie']:''; 
			          				$folio =isset($pgdet['Folio'])? $pgdet['Folio']:''; 
			          				$monedaDr =isset($pgdet['MonedaDR'])? $pgdet['MonedaDR']:''; 
			          				$metodoPago =isset($pgdet['MetodoDePagoDR'])? $pgdet['MetodoDePagoDR']:''; 
			          				$numParcialidad =isset($pgdet['NumParcialidad'])? $pgdet['NumParcialidad']:1; 
			          				$impSaldoAnt =isset($pgdet['ImpSaldoAnt'])? $pgdet['ImpSaldoAnt']:0; 
			          				$impPago =isset($pgdet['ImpPagado'])? $pgdet['ImpPagado']:0; 
			          				$impSaldoIns =isset($pgdet['ImpSaldoInsoluto'])? $pgdet['ImpSaldoInsoluto']:0; 
			          				$pagoDetalle[]=array('idDocumento'=>$idDocumento,'serie'=>$serie,'folio'=>$folio,'monedaDr'=>$monedaDr,'metodoPago'=>$metodoPago,'numParcialidad'=>$numParcialidad,'impSaldoAnt'=>$impSaldoAnt,'impPago'=>$impPago,'impSaldoIns'=>$impSaldoIns);
			          			}
			          		}
			          	}
			            //// Obtenemos las retenciones de los impuestos:
			            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Timp){	
			            	if($version == '3.2'){
				            	$titra=0.00;
					            $tiret=0.00;
				            }elseif($version == '3.3'){
				            	$titra= isset($Timp['TotalImpuestosTrasladados'])? $Timp['TotalImpuestosTrasladados']:0;
					            $tiret= isset($Timp['TotalImpuestosRetenidos'])? $Timp['TotalImpuestosRetenidos']:0;
				            }
				            //var_dump($Traslado);   	
			               //$impuesto = $Traslado['impuesto']; 
			            }

			            //HASTA AQUI TODA LA INFORMACION ES LEIDA E IMPRESA CORRECTAMENTE
			            //ESTA ULTIMA PARTE ES LA QUE GENERA ERROR, AL PARECER NO ENCUENTRA EL NODO
			            foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
			               if($version == '3.2'){
			               		$fecha = $tfd['FechaTimbrado']; 
			               		$fecha = str_replace("T", " ", $fecha); 
			               		$uuid = $tfd['UUID'];
			               		$noNoCertificadoSAT = $tfd['noCertificadoSAT'];
			               		$RfcProvCertif=$tfd['RfcProvCertif'];
			               		$SelloCFD=$tfd['selloCFD'];
			               		$SelloSAT=$tfd['selloSAT'];
			               		$version = $tfd['version'];
			               		$rfcprov = empty($tfd['RfcProvCertif'])? '':$tfd['RfcProvCertif'];
			               }else{
			               		$fecha = $tfd['FechaTimbrado']; 
			               		$fecha = str_replace("T", " ", $fecha); 
			               		$uuid = $tfd['UUID'];
			               		$noNoCertificadoSAT = $tfd['NoCertificadoSAT'];
			               		$RfcProvCertif=$tfd['RfcProvCertif'];
			               		$SelloCFD=$tfd['SelloCFD'];
			               		$SelloSAT=$tfd['SelloSAT'];
			               		$version = $tfd['Version'];
			               		$rfcprov = $tfd['RfcProvCertif'];
			               }
			            }
			            /*
			            foreach ($xml->xpath() as $key => $value) {
			            	# code...
			            }
			            */
			            if(empty($descuento)){
			            	$descuento = 0;
			            }
			            ///foreach($xml->xpath('//cfdi:Comprobante//cfdi:CfdiRelacionados//cfdi:CfdiRelacionado//') as $rel){
			            ///	if($version == '3.2'){
			            ///		$relacion= '';
			            ///	}elseif($version == '3.3'){
			            ///		$relacion= $rel['Rfc'];
			            ///		$nombre_recep=$Receptor['Nombre'];
			            ///		$usoCFDI =$Receptor['UsoCFDI'];
			            ///	 }
			            ///}
			            if($tipo2 == 'F'){
			            	$this->query = "INSERT INTO XML_DATA (UUID, CLIENTE, SUBTOTAL, IMPORTE, FOLIO, SERIE, FECHA, RFCE, DESCUENTO, STATUS, TIPO, NOCERTIFICADOSAT, SELLOCFD, SELLOSAT, FECHATIMBRADO, CERTIFICADO, SELLO, versionSAT, no_cert_contr, rfcprov,formaPago, LugarExpedicion, metodoPago, moneda, TipoCambio, FILE, USO, RELACION, ID_RELACION)";
				            $this->query.= "VALUES ('$uuid', '$rfc', '$subtotal', '$total', '$folio', '$serie', '$fecha', '$rfce', $descuento, 'S', '$tipo', '$noNoCertificadoSAT', '$SelloCFD', '$SelloSAT', '$fecha','$Certificado', '$Sello', '$version', '$noCert', '$rfcprov', '$formaPago', '$LugarExpedicion', '$MetodoPago', '$moneda', $tc, '$archivo','$usoCFDI', '',null )";
				            //echo "<p>query: ".$this->query."</p>";
							//$respuesta = $this->grabaDB();
							if($respuesta = @$this->grabaBD() === false){
								//echo 'error'.$archivo;
								$this->query="DELETE FROM XML_DATA_FILES WHERE nombre = '$archivo'";
								$this->grabaBD();

            					$this->query="INSERT INTO XML_EXCEPCION (ID, UUID, TIPO) VALUES (NULL, '$archivo', 'X')";
            					$this->grabaBD();

            					return;
							}
							/// creamos el folder para el movimiento de las facturas a nuestro sistema. 
				            if($rfce == 'FPE980326GH9'){
                                copy($archivo, "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$serie.$folio.".xml");    
                            }else{
                            	if($rfce == $rfcEmpresa){
                            		$carpeta = 'Emitidos';
                            		$carpeta2= $rfc;
                            	}else{
                            		$carpeta = 'Recibidos';
                            		$carpeta2= $rfce;
                            	}
                            	$path='C:\\xampp\\htdocs\\uploads\\xml\\'.$rfcEmpresa.'\\'.$carpeta.'\\'.$carpeta2;
                            	//echo '<br/>'.$path.'<br/>';
                            	if(is_dir($path)){
                            		//echo '<br/> El directorio existe<br/>';
                            	}else{
                            		//echo '<br/> El Direcotirio no existe y se debe de crear<br/>';
                            		mkdir($path,0777, true);
                            	}
                            	if($tipo=='P'){
                                   copy($archivo, $path.'\\'.$rfce.'-'.utf8_encode($serieComp).utf8_encode($folioComp).'-'.$uuid.".xml");
                            	}else{	
                                   copy($archivo, $path.'\\'.$rfce.'-'.utf8_encode($serie).utf8_encode($folio).'-'.$uuid.".xml");
                            	}
                            	
                            }

                            /// Insertamos en la tabla de CFIDsss
                            /*
                            $this->query="UPDATE FTC_FACTURAS SET UUID = '$uuid' WHERE SERIE='$serie' AND FOLIO='$folio'";
                            $this->EjecutaQuerySimple();*/
				            $i=1;
				            //echo 'Valor del arreglo'.var_dump($impuestos);
				            //echo '<br/>'.count($partidaImp).'<br/>';
							if(count($partidaImp)<0){
								//echo $uuid.' --- '.$tipo.'  ---<br/>';
							}else{
								foreach ($partidaImp as $key){
									$base = empty($key[0])? 0:$key[0];;
					            	$nombre = $key[1];
					            	$tasa = $key[3];
					            	$importe = empty($key[4])? 0:$key[4];
					            	$tipoFactor = $key[2];
					            	$tipoImp = $key[5];
					            	$pi = $key[6];
					            	//$partidaImp[]=array($base, $parImpuesto, $parTipoFact, $parTasaCuota, $parImpImporte); 
					            	$this->query = "INSERT INTO XML_IMPUESTOS values (null,'$nombre', '$tasa', $importe, $pi, '$uuid', ('$serie'||'-'||'$folio'), '$tipoFactor', $base, '$tipoImp')";
					            	if($rs=$this->grabaBD() === false){
					            		echo 'Fallo al insertar en la tabla de impuestos <br/>'; 
					            		echo $this->query.'<br/>';
					            	}          
					            	$i=$i+1;	
								//echo $this->query;
								}
							}

							if($xml->xpath('//impl:ImpuestosLocales//impl:TrasladosLocales')){
								foreach ($xml->xpath('//impl:ImpuestosLocales//impl:TrasladosLocales') as $il){
				            		//echo '<br/><br/>'.print_r($il).'<br/>'.$version;
				            		$iltrasN= isset($il['ImpLocTrasladado'])? $il['ImpLocTrasladado']:'';
						        	//$ilretImp= isset($il['Impuesto'])? $il['Impuesto']:'';
						        	$iltrasM= isset($il['Importe'])? $il['Importe']:0;
						        	$ilretM= isset($il['Importe'])? $il['Importe']:0;
						        	$iltrasF= isset($il['TipoFactor'])? $il['TipoFactor']:'';
						        	$ilretF= isset($il['TipoFactor'])? $il['TipoFactor']:'';
				            		$this->query="INSERT INTO XML_IMPUESTOS values (null,'$iltrasN', '', $iltrasM, $pi + 1, '$uuid', ('$serie'||'-'||'$folio'), '$iltrasF', 0, 'local')";
				            		if($rs=$this->grabaBD() === false){
					            		echo 'Fallo al insertar en la tabla de impuestos <br/>'; 
					            		echo $this->query.'<br/>';
					            	}
			            		}	
							}
				            //echo 'Valor del arrego partida'.var_dump($partida);
				            $i=1;
				            foreach ($partida as $data){
				            	$unidad = str_replace(array("'", "<code>"),' ',$data[0]);
				            	$importe = $data[1];
				            	$cantidad = $data[2];
				            	//$descripcion = str_replace(array("\\", "¨", "º", "-", "~",
								//             "#", "@", "|", "!", "\"",
								//             "·", "$", "%", "&", "/",
								//             "(", ")", "?", "'", "¡",
								//             "¿", "[", "^", "<code>", "]",
								//             "+", "}", "{", "¨", "´",
								//             ">", "< ", ";", ",", ":",
								//             ".", " "),' ',$data[3]);
				            	$descripcion = str_replace(array("'", "<code>"),' ',$data[3]);
				            	$unitario=$data[4];
				            	$cvesat = $data[5];
				            	$unisat = $data[6];
				            	$descp = empty($data[7])? 0:$data[7];
				            	$this->query = "INSERT INTO XML_PARTIDAS (id, unidad, importe, cantidad, partida, descripcion, unitario, uuid, documento, cliente_SAE, rfc, fecha, descuento, cve_art, cve_clpv, unitario_original, CLAVE_SAT, UNIDAD_SAT) values (null, '$unidad', $importe, $cantidad, $i, '$descripcion', $unitario, '$uuid', ('$serie'||'-'||'$folio'), '', '$rfc', '$fecha', $descp, '', '', $unitario, '$cvesat','$unisat')";
				            	if($rs=$this->grabaBD() === false){
				            		echo 'Falla al insertar la partida:<br/>';
				            		echo $this->query.'<br/>';
				            	}          
				            	$i=$i+1;
			            	}

			            	if(count($parte_partida) > 0){
			            		foreach ($parte_partida as $pp ){
			            			$parte_unidad = $pp[0];
					            	$parte_importe = $pp[1];
					            	$parte_cantidad = $pp[2];
					            	//$descripcion = str_replace(array("\\", "¨", "º", "-", "~",
									//             "#", "@", "|", "!", "\"",
									//             "·", "$", "%", "&", "/",
									//             "(", ")", "?", "'", "¡",
									//             "¿", "[", "^", "<code>", "]",
									//             "+", "}", "{", "¨", "´",
									//             ">", "< ", ";", ",", ":",
									//             ".", " "),' ',$pp[3]);
					            	$parte_descripcion = str_replace(array("'", "<code>"),' ',$pp[3]);
					            	$parte_unitario=$pp[4];
					            	$parte_cvesat = $pp[5];
					            	$parte_unisat = $pp[6];
					            	$parte_descp = empty($pp[7])? 0:$pp[7];
					            	$parte_pi= $pp[8];
					            	//var_dump($parte_partida);
					            	$this->query = "INSERT INTO XML_PARTIDAS_PARTE (id, unidad, importe, cantidad, partida, descripcion, unitario, uuid, documento, cliente_SAE, rfc, fecha, descuento, cve_art, cve_clpv, unitario_original, CLAVE_SAT, UNIDAD_SAT) values (null, '$parte_unidad', $parte_importe, $parte_cantidad, $parte_pi, '$parte_descripcion', $parte_unitario, '$uuid', ('$serie'||'-'||'$folio'), '', '$rfc', '$fecha', $parte_descp, '', '', $parte_unitario, '$parte_cvesat','$parte_unisat')";
					            	if($rs=$this->grabaBD() === false){
					            		echo 'Falla al insertar la partida informacion de parte:<br/>';
					            		echo $this->query.'<br/>';
					            	}   	
			            		}       
			            	}

			            	if(count($parInfoAduana)>0){
			            		foreach ($parInfoAduana as $pia){
			            			$pia_pedimento = $pia[0];
			            			$pia_par=$pia[1];
			            			$pia_fecha = $pia[2];
			            			$pia_cantidad = $pia[3];
			            			$pia_descripcion = str_replace(array("'", "<code>"),' ',$pia[4]);
			            			$this->query="INSERT INTO XML_PARTIDA_INFO_ADUANA (ID, UUID, PARTIDA, PEDIMENTO, FECHA_PEDIMENTO, LOTE, FECHA_LOTE, CANTIDAD, DESCRIPCION) VALUES (NULL, '$uuid', $pia_par, '$pia_pedimento','$pia_fecha', '', null, $pia_cantidad, '$pia_descripcion' )";
			            			if($rs=$this->grabaBD() === false){
					            		echo 'Falla al insertar la partida informacion Aduanera :<br/>';
					            		echo $this->query.'<br/>';
					            	}
			            		}
			            	}

			            	if(count($pago)>0){
			            		foreach ($pago as $keyPago){
			            			///$pago[]=array("fechaPago"=>$fechaPago,"formaPago"=>$formaPago,"mondedaPago"=>$mondedaPago,"monto"=>$monto,"numOperacion"=>$numOperacion,"rfcEmisorCtaOrd"=>$rfcEmisorCtaOrd,"ctaOrdenante"=>$ctaOrdenante,"rfcEmisorCtaBen"=>$rfcEmisorCtaBen,"ctaBeneficiario"=>$ctaBeneficiario);
			            			$fpa = $keyPago['fechaPago'];
			            			$fmpa = $keyPago['formaPago'];
			            			$monpa =$keyPago['mondedaPago'];
			            			$motpa = $keyPago['monto'];
			            			$numpa =$keyPago['numOperacion'];
			            			$rfcord =$keyPago['rfcEmisorCtaOrd'];
			            			$ctaord = $keyPago['ctaOrdenante'];
			            			$rfcben = $keyPago['rfcEmisorCtaBen'];
			            			$ctaben =$keyPago['ctaBeneficiario'];
			            			$this->query="INSERT INTO XML_COMPROBANTE_PAGO (ID, UUID, FECHA, FORMA, MONEDA, MONTO, NUMOPERACION, RFC_BANCO_ORDENANTE, CTA_ORDENANTE, RFC_BANCO_BENEFICIARIO, CTA_BENEFICIARIO, STATUS) VALUES (NULL,'$uuid', '$fpa', '$fmpa', '$monpa', $motpa, '$numpa', '$rfcord', '$ctaord', '$rfcben', '$ctaben', 'P')";
			            			$this->grabaBD();
			            		}
			            	}

			            	if(count($pagoDetalle)>0){
			            		//$pagoDetalle[]=array('idDocumento'=>$idDocumento,'serie'=>$serie,'folio'=>$folio,'monedaDr'=>$monedaDr,'metodoPago'=>$metodoPago,'numParcialidad'=>$numParcialidad,'impSaldoAnt'=>$impSaldoAnt,'impPago'=>$impPago,'impSaldoIns'=>$impSaldoIns);
								foreach ($pagoDetalle as $keyPD){
									$idDocumento = $keyPD['idDocumento'];
									$serie = $keyPD['serie'];
									$folio = $keyPD['folio'];
									$monedaDr = $keyPD['monedaDr'];
									$metodoPago = $keyPD['metodoPago'];
									$numParcialidad = $keyPD['numParcialidad'];
									$impSaldoAnt = $keyPD['impSaldoAnt'];
									$impPago = $keyPD['impPago'];
									$impSaldoIns = $keyPD['impSaldoIns'];
			            			$this->query="INSERT INTO XML_COMPROBANTE_PAGO_DETALLE (ID, ID_DOCUMENTO,SERIE,FOLIO,	MONEDA,METODO_PAGO,NUM_PARCIALIDAD,SALDO,PAGO,SALDO_INSOLUTO,STATUS, UUID_PAGO) VALUES ( null, '$idDocumento', '$serie', '$folio', '$monedaDr', '$metodoPago', $numParcialidad, $impSaldoAnt, $impPago, $impSaldoIns, 'P', '$uuid')";
			            			$this->grabaBD();
			            		}
								
			            	}

							if($xml->xpath('//cfdi:CfdiRelacionados')){
        	    				foreach ($xml->xpath('//cfdi:CfdiRelacionados') as $rel){
    	        					$tipoRelacion = isset($rel['TipoRelacion'])? $rel['TipoRelacion']:'';
    	        					foreach ($rel->xpath('//cfdi:CfdiRelacionado') as $docRel){
    	        						$docUUID = isset($docRel['UUID'])? $docRel['UUID']:'';
    	        						$this->query = "INSERT INTO XML_RELACIONES (ID, UUID, TIPO, UUID_DOC_REL) VALUES (NULL, '$uuid', '$tipoRelacion', '$docUUID')";
    	        						$this->grabaBD();
    	        					}
    	        				}
	            			}

	            			if($tipo == 'P'){
	            				$this->query="UPDATE XML_DATA SET SERIE='$serieComp', folio='$folioComp', documento= '$serieComp'||'$folioComp' where uuid='$uuid'";
	            				$this->queryActualiza();
	            			}
	
			            	$this->calcularImpuestos($uuid);
			            }elseif($tipo2 == 'C'){
			            	$this->query = "INSERT INTO XML_DATA_CANCELADOS (UUID, CLIENTE, SUBTOTAL, IMPORTE, FOLIO, SERIE, FECHA, RFCE, DESCUENTO, STATUS, TIPO, FILE )";
				            $this->query.= "VALUES ('$uuid', '$rfc', '$subtotal', '$total', '$folio', '$serie', '$fecha', '$rfce', $descuento, 'C', '$tipo2', '$archivo')";
				            //echo "<p>query: ".$this->query."</p>";
							//$respuesta = $this->grabaDB();
							$respuesta = $this->grabaBD();
			            }
			        }	
			        //return;// $respuesta;
    		}
    		
    		if($tipo == 'N'){
    			$this->query="UPDATE XML_DATA_FILES SET TIPO = 'N' WHERE nombre = '$archivo'";
    			$this->queryActualiza();

    			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){
    				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
			            	if($version == '3.2'){
			            		$rfc= $Receptor['rfc'];
			           		 	$nombre_recep = utf8_encode($Receptor['nombre']);
			            		$usoCFDI = '';
			            	}elseif($version == '3.3'){
			            		$rfc= $Receptor['Rfc'];
			            		$nombre_recep=utf8_encode($Receptor['Nombre']);
			            		$usoCFDI =$Receptor['UsoCFDI'];
			            	 }
			    			$this->query="INSERT INTO XML_EMPLEADOS (IDE, RFC, NOMBRE, USOCFDI ) VALUES (NULL, '$rfc', '$nombre_recep', '$usoCFDI')";
			    			$this->grabaBD();
			        }
			        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//nomina12:Receptor') as $Nomina12Receptor) {
			            	if($version == '3.2'){
			            		$rfc= $Nomina12Receptor['rfc'];
			           		 	$nombre_recep = $Nomina12Receptor['nombre'];
			            		$usoCFDI = '';
			            	}elseif($version == '3.3'){
			            		$curp= $Nomina12Receptor['Curp'];
			            		$numss=$Nomina12Receptor['NumSeguridadSocial'];
			            		$FechaInicioRelLaboral =$Nomina12Receptor['FechaInicioRelLaboral'];
			            		$Antiguedad=$Nomina12Receptor['Antigüedad']; 
								$TipoContrato=$Nomina12Receptor['TipoContrato'];
								$Sindicalizado=$Nomina12Receptor['Sindicalizado'];
								$TipoJornada=$Nomina12Receptor['TipoJornada'];
								$TipoRegimen=$Nomina12Receptor['TipoRegimen'];
								$NumEmpleado= $Nomina12Receptor['NumEmpleado'];
								$Departamento= $Nomina12Receptor['Departamento'];
								$Puesto= $Nomina12Receptor['Puesto'];
								$RiesgoPuesto= $Nomina12Receptor['RiesgoPuesto'];
								$PeriodicidadPago= $Nomina12Receptor['PeriodicidadPago'];
								$SalarioBaseCotApor= $Nomina12Receptor['SalarioBaseCotApor'];
								$SalarioDiarioIntegrado= $Nomina12Receptor['SalarioDiarioIntegrado'];
								$ClaveEntFed=$Nomina12Receptor['ClaveEntFed'];
			            	 }
			    			$this->query="INSERT INTO XML_NOMINA_RECEPTOR (ID, CURP, NumSeguridadSocial, 
			    										FechaInicioRelLaboral,
			    										Antiguedad, 
														TipoContrato, 
														Sindicalizado, 
														TipoJornada, 
														TipoRegimen, 
														NumEmpleado, 
														Departamento, 
														Puesto, 
														RiesgoPuesto, 
														PeriodicidadPago, 
														SalarioBaseCotApor, 
														SalarioDiarioIntegrado, 
														ClaveEntFed, 
														Archivo
			    										 ) 
			    					VALUES (NULL, '$curp', '$numss', '$FechaInicioRelLaboral',
			    								'$Antiguedad', 
												'$TipoContrato', 
												'$Sindicalizado', 
												'$TipoJornada', 
												'$TipoRegimen', 
												'$NumEmpleado', 
												'$Departamento', 
												'$Puesto', 
												'$RiesgoPuesto', 
												'$PeriodicidadPago', 
												'$SalarioBaseCotApor', 
												'$SalarioDiarioIntegrado', 
												'$ClaveEntFed',
												'$archivo'
												)";
			    			$this->grabaBD();
			        }

    			}
    		}

    		if($tipo2 == 'C'){
       
            	foreach ($data as $row):
            	    $file = $row->NOMBRE;
            	endforeach;
	
	            	$myFile = fopen("$file", "r") or die("No se ha logrado abrir el archivo ($file)!");
	            	$myXMLData = fread($myFile, filesize($file));
	            	//exit(print_r($file));
	            	$xml = simplexml_load_string($myXMLData) or die("Error: No se ha logrado crear el objeto XML ($file)");
	            	//$xml = simplexml_load_string($myFile) or die("Error: No se ha logrado crear el objeto XML ($file)");
	            	
	            	$ns = $xml->getNamespaces(true);
	            	foreach ($xml->xpath('//CancelaCFDResult') as $acuse){
	            	    $fecha = substr($acuse['Fecha'],0,19);    
	            	    $rfc = $acuse['RfcEmisor'];
	            	}
	            	
	            	foreach ($xml->Folios as $fol) {
	            	    $UUID= $fol->UUID;
	            	    $estadoUUID=$fol->EstatusUUID;
	            	}
	            	foreach ($xml->Signature as $signature) {
	            	    $signatureValue= $signature->SignatureValue;
	            	    $digestValue=$signature->SignedInfo->Reference->DigestValue;
	            	}
	            	$this->query="INSERT INTO XML_CANCEL_DET (ID, FECHA, RFCEMISOR, STATUS_UUID, UUID, SIGNATUREVALUE, DIGESTVALUE, EXPONENT) 
	            	        VALUES (NULL, '$fecha', '$rfc', '$estadoUUID', '$UUID', '$signatureValue', '$digestValue', '$exponent')";
            	$this->EjecutaQuerySimple();
	            //echo $this->query;
	            //$this->query="DELETE FROM XML_DATA_files WHERE NOMBRE = 'C:/xampp/htdocs/uploads/xml/cancelados/FPE980326GH9-CAN-FRF912.xml'";
	            //s$this->EjecutaQuerySimple();
            	exit($UUID);
        	}
        return;
     }

    function calcularImpuestos($uuid){
    	$data=array();
    	if(strlen($uuid)>=5){
    		$uuid = " and uuid ='".$uuid."'";
    	}else{
    		$uuid = '';
    	}	

    	$this->query="SELECT  *  FROM XML_DATA  WHERE STATUS = 'S' $uuid  ";
    	$rs=$this->EjecutaQuerySimple();
    	//echo $this->query;
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	foreach ($data as $key) {
    		$data2 = array();
    		$this->query="SELECT IMPUESTO, rpad(tasa, 8, '0') as TASA, SUM(MONTO) as monto, TIPOFACTOR,  tipo FROM XML_IMPUESTOS I WHERE I.UUID = '$key->UUID' group by IMPUESTO, TASA, TIPOFACTOR, tipo";
    		$res = $this->EjecutaQuerySimple();
    		//echo '<br/>'.$this->query.'<br/>';
    		while ($tsArray2 = ibase_fetch_object($res)) {
				$data2[]=$tsArray2;    			
    		}

    		if(count($data2) > 0){
    			foreach ($data2 as $row) {
    				$impuesto =$row->IMPUESTO;
    				$monto = $row->MONTO;
    				$tipo = $row->TIPOFACTOR;
    				$TASA = $row->TASA;
    				if($tipo == 'Tasa'){
    					//echo  '<br/>TASA: '.$TASA.'<br/>';
    					$tasa = $TASA == '0.000000'? '000':substr($TASA, 2, 3);
    				}elseif($tipo == 'Cuota'){
    					$tasa = 'C';
    				}elseif($tipo == 'Exento'){
    					$tasa = '000';
    				}
    				//echo  '<br/>tasa: '.$tasa.'<br/>';
    				
    			if($impuesto == '002' and $row->TIPO == 'Traslado'){/// IVA
    				$campo = 'IVA'.$tasa; /// Aqui debemos de diferenciar del trasladado al retenido.	
    			}elseif($impuesto == '003' and $row->TIPO == 'Traslado'){//// IEPS  Aqui debemos de diferenciar del trasladado al retenido.
    				$campo = 'IEPS'.$tasa;
    			}elseif($impuesto == '001' and $row->TIPO == 'Traslado'){/// ISR  Siempre es Retencion.
    				$campo = 'ISR'.$tasa;
    			}elseif($impuesto == '001' and $row->TIPO == 'Retencion'){
    				$campo = 'ISR_RET';
    			}elseif($impuesto == '002' and $row->TIPO == 'Retencion'){
    				$campo = 'IVA_RET';
    			}elseif($impuesto == '003' and $row->TIPO == 'Retencion'){
    				$campo = 'IEPS_RET';
    			}
    			//exit('Este es el campo donde se pretende al actualizacion'.$campo);
    			$this->query="UPDATE XML_DATA SET $campo = $monto where UUID = '$key->UUID'";
    			//echo '<br/>Error al guardar: <br/>'.$this->query;
    			$result=$this->queryActualiza();
    			//print_r($result);
    			if($result < 1){
    				echo '<br/>Error al guardar Impuesto: <br/>'.$this->query;
    				$this->query="INSERT INTO XML_EXCEPCION (ID, UUID, TIPO) VALUES (NULL, '$key->UUID', 'IMP')";
    				if($this->grabaBD()){
    	
    				}else{
    					echo '<br/>Error al guardar: <br/>'.$this->query;
    				}
    			}elseif($result >= 1){
    				$this->query="UPDATE XML_DATA SET STATUS = 'P'  WHERE UUID = '$key->UUID'";
	    			$this->queryActualiza();
    			}
    			unset($data2);
	    		}
    		}
    	}
    }

	function cargaSaeImi($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo){
        $ruta2= "C:\\xampp\\htdocs\\uploads\\xml\\IMI161007SY7\\Emitidos\\".$rfcr."\\IMI161007SY7-".$doc.'-'.$uuid.".xml";
        if($tipo != 'P'){
            $myFile = fopen("$ruta2", "r") or die("No se ha logrado abrir el archivo ($ruta2)!");
            $myXMLData = fread($myFile, filesize($ruta2));
            $doc = $serie.$folio;
            $this->query="EXECUTE PROCEDURE SP_CARGA_CFDI_SAE($folio,'$serie','$doc', '123', '$tipo')";
            $this->grabaBD();
            $this->query = "UPDATE CFDI01 SET XML_DOC = '$myXMLData' WHERE CVE_DOC = '$doc'";
            $this->grabaBD();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_FACTURA_SAE($folio,'$serie','$doc', '$tipo')";
                $this->grabaBD();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_PARTIDAS_SAE($folio,'$serie', '$doc', '$uuid', '$tipo')";
                $this->grabaBD();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_CUENM_SAE ($folio, '$serie', '$doc', '$uuid', '$tipo')";
                $this->grabaBD();    
            if($tipo == 'I'){
            	$this->query = "UPDATE CFDI01 SET XML_DOC = SUBSTRING(XML_DOC FROM 4), tipo_doc='F'  WHERE CVE_DOC = '$doc'";
            }else{
            	$this->query = "UPDATE CFDI01 SET XML_DOC = SUBSTRING(XML_DOC FROM 4), tipo_doc='D' WHERE CVE_DOC = '$doc'";
            }
            $this->queryActualiza();
        }else{
            $res=$this->cargaCEP($doc, $ruta2, $rfcr, $serie, $folio);
        }   
        return $mensaje = array('status' => 'ok');
    }



}