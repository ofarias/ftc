<?php
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';
require_once 'app/model/verificaID.php';
require_once 'app/model/pegaso.model.reparto.php';
require_once('app/views/unit/commonts/numbertoletter.php');

class factura extends database {

	function nuevaFactura($idc, $uso, $tpago, $mpago, $cp, $rel, $ocdet, $entdet){
		$usuario = $_SESSION['user']->NOMBRE;
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################

		//echo $idc.'<br/>';
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
		$this->query="SELECT C.*, 
			(SELECT DETALLISTA FROM CARTERA WHERE TRIM(IDCLIENTE) = (SELECT TRIM(CVE_CLPV) FROM FACTP01 WHERE CVE_DOC = C.CVE_FACT)) AS DET 
			FROM CAJAS C WHERE ID = $idc";
		$res = $this->EjecutaQuerySimple();
		$valRefacturacion=ibase_fetch_object($res);
		$validacion = $valRefacturacion->PAR_FACTURADAS; 
		$statusOriginal=$valRefacturacion->STATUS;
		if($validacion ==  0 and $valRefacturacion->STATUS !='CFDI' and $valRefacturacion->STATUS != 'PENDIENTE'){
			$this->query="UPDATE CAJAS SET STATUS = 'PENDIENTE' WHERE ID = $idc";
			$this->queryActualiza();

			$cliente = 'Liverpool';
			if($valRefacturacion->DET == 1){
				$det=$this->addendaLiverpool($idc, $uso, $tpago, $mpago, $cp, $rel, $ocdet, $entdet);
				return $det;
			}

			if($idc < 9999999){
			$this->query ="SELECT p.descripcion|| coalesce((select first 1 coalesce((select first 1 cast(ANEXO_DESCRIPCION as varchar(1000))
                      from FTC_ANEXO_DESCR
                      where CAJA = $idc and
                            PARTIDA = P.PARTIDA and
                            STATUS is null), '') as ANEXO from DETALLE_CAJA D
                        where D.IDCAJA = $idc and D.partida = p.partida
                        ),'') as descripcion, 
						P.*,
						(SELECT DBIMPPRE FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS PRECIO,
		                (SELECT DBIMPDES FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION= DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS DESCUENTO,
		                (SELECT CVE_CLIENTE FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO) AS CLIENTE 
		                FROM PAQUETES P WHERE IDCAJA = $idc and cantidad > devuelto";
		}else{
				$this->query="SELECT trim(f.CVE_CLPV) AS CLIENTE, 
							p.cant as cantidad, 
							p.prec as precio, 
							p.desc1 as descuento, 
							(select nombre from producto_ftc where clave = p.cve_art )as descripcion,
							p.cve_art as articulo, 
							p.id_Preoc, 
							99 as idcaja, 
							9 as id
							FROM PAR_FACTV01 p 
							left join factv01 f on f.cve_doc = p.cve_doc 
							WHERE f.CVE_DOC = '$cp'";
		}

		$rs=$this->EjecutaQuerySimple();
		while ($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		$totalDescuento= 0; 
		$subTotal= 0;
		$totalImp1=0;
		$IEPS=0;
		$desc2=0;
		$descf=0;
		$caja = $idc;
		foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
			$cliente=trim($key->CLIENTE);
			/// Bases
			$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
			$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
			$pC=$key->CANTIDAD-$key->DEVUELTO;
			$pDp=$key->DESCUENTO;/// Porcentaje de descuento por Partida.
			// Calcualos para las operaciones;
			$pS=$pP*$pC;
			$pDi=(($key->DESCUENTO/100 * ($pP*$pC)));/// Descuento por el precio por la cantidad
			$pImp1 = ($pS - $pDi)*$imp1; /// Importe del Impuesto1 imp1 
			/// Totales para DocumentoSS
			$totalDescuento =$totalDescuento + $pDi;
			$subTotal =$subTotal+$pS;
			$totalImp1=$totalImp1+$pImp1;
			$totalDoc= $subTotal - $totalDescuento + $totalImp1;
			/// Datos Sat
			$subSat = $this->truncarNumero($subTotal,$dec,$dect);
			//$totSat = $this->truncarNumero($totalDoc,$dec, $dect);
			$totImp1Sat=number_format($totalImp1,2,".","");
			//echo 'Descuento: '.$pDp.', Precio '.$pP.' Cantidad'.$pC.'<br/>';
			//echo('Precio Truncado a '.$dect.' decimales'.$pPt.', Precio redondeado a '.$dec.' decimales'.$pP).'<br/>';
		}			
		//echo 'SubTotal:'.$this->truncarNumero($subTotal, $dec, $dect).'<br/>';
		//echo 'Descuento:'.$this->truncarNumero($totalDescuento,$dec,$dect).'<br/>';
		//echo 'IVA:'.$this->truncarNumero($totalImp1,$dec, $dect).'<br/>';
		//echo 'Total:'.$this->truncarNumero($totalDoc,$dec,$dect).'<br/>';
			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$serie = $_SESSION['user']->CATEGORIA;
			$this->query="SELECT iif(MAX(FOLIO) is null, 0, max(folio)) AS FOLIO FROM FTC_CTRL_FACTURAS WHERE SERIE = '$serie'";
			$res=$this->EjecutaQuerySimple();
			$folio = ibase_fetch_object($res);
			$nf = $folio->FOLIO + 1;
			$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $nf where SERIE  ='$serie'";
			$rs = $this->queryActualiza();
			if($rs ==1 ){
					$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
					$res=$this->EjecutaQuerySimple();
					$cl=ibase_fetch_object($res);
					$this->query="INSERT INTO FTC_FACTURAS (IDF, DOCUMENTO, SERIE, FOLIO, FORMADEPAGOSAT, VERSION, TIPO_CAMBIO, METODO_PAGO, REGIMEN_FISCAL, LUGAR_EXPEDICION, MONEDA, TIPO_COMPROBANTE, CONDICIONES_PAGO, SUBTOTAL, IVA, IEPS, DESC1, DESC2, DESCF, TOTAL, SALDO_FINAL, ID_PAGOS, ID_APLICACIONES, NOTAS_CREDITO, MONTO_NC, MONTO_PAGOS, MONTO_APLICACIONES, CLIENTE, USO_CFDI, STATUS, USUARIO, FECHA_DOC, FECHAELAB, IDCAJA) 
					VALUES (NULL, ('$serie'||$nf), '$serie', $nf, '$tpago', '3.3', 1, '$mpago', '$rowDF->REGIMEN_FISCAL', '$rowDF->LUGAR_EXPEDICION', 'MXN', 'I', '$cp', $subTotal, $totalImp1, $IEPS, $totalDescuento, $desc2, $descf, $totalDoc, $totalDoc, '','', '', 0,0,0,'$cliente', '$uso', 0, '$usuario ', current_timestamp, current_timestamp, $caja)";
					$this->grabaBD();
					//exit($this->query);//// Insertamos la cabecera de la factura.	
					$datos = array($cliente,$row->UNIDAD, $cl->NOMBRE,$cl->CALLE.', '.$cl->NUMEXT,$cl->COLONIA, $cl->ESTADO,$cl->TELEFONO, $cl->EMAILPRED,$cl->REFERENCIA_ENVIO, $caja,$totalDoc,'$serie'.$nf);  
					$idviaje = $mysql->ingresaLogReparto($datos); /// Creamos el registro en la BD MySQL para el Rastreador.
					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD-$keyp->DEVUELTO;
						$pDp=$keyp->DESCUENTO;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format((($keyp->DESCUENTO/100 * ($pP*$pC))),2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
						/// Datos Fiscales
								//$pPt2=$this->truncarNumero($key->PRECIO, 6, 2);
								//$st2=$st2 + $pPt2;
								//$pPt3=$this->truncarNumero($key->PRECIO, 6, 3);
								//$st3=$st3 + $pPt3;
								//$pPt4=$this->truncarNumero($key->PRECIO, 6, 4);
								//$st4=$st4 + $pPt4;
						$base=number_format($psubTotal-$pDi,$dec,".","");	
						$bimp=number_format($base * 0.16,$dec,".","");
						$descr = $keyp->DESCRIPCION;
						$this->query="INSERT INTO FTC_FACTURAS_DETALLE (IDFP, IDF, DOCUMENTO, PARTIDA, CANTIDAD, ARTICULO, UM, DESCRIPCION, IMP1, IMP2, IMP3, IMP4, DESC1, DESC2, DESC3, DESCF, SUBTOTAL, TOTAL, CLAVE_SAT, MEDIDA_SAT, PEDIMENTOSAT, LOTE, USUARIO, FECHA, IDPREOC, IDPAQUETE, IDCAJA, PRECIO )
						VALUES(NULL, (SELECT IDF FROM FTC_FACTURAS WHERE DOCUMENTO = ('$serie'||$nf)), 
									 ('$serie'||$nf), 
									 $partida, $keyp->CANTIDAD-$keyp->DEVUELTO, '$keyp->ARTICULO', (SELECT UM FROM PREOC01 WHERE ID = $keyp->ID_PREOC), '$descr', 16, 0, 0, 0, $pDi, 0,0,0, $psubTotal, $pTotal, (SELECT coalesce(CVE_PRODSERV, '40141700') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), (SELECT coalesce(CVE_UNIDAD, 'H87') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), '', '', '$usuario', current_timestamp, $keyp->ID_PREOC, $keyp->ID, $keyp->IDCAJA, $pP)";	
						$this->grabaBD();
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $descr, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						$CANTIDADN=$keyp->CANTIDAD-$keyp->DEVUELTO;

						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$CANTIDADN",
									      "descripcion"=> "$descr",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{

									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$CANTIDADN",
									      "descripcion"=> "$descr",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					$partidas = $mysql->ingresaLogRepartoDetalle($datosp);/// ingresamos las partidas al rastreador.
					}
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;
					
					$relacion=$rel;
					if($relacion==1){
						$this->query="SELECT first 1 * FROM FTC_FACTURAS WHERE IDCAJA = $idc and status = 8 order by fecha_cancelacion desc";
						$res=$this->EjecutaQuerySimple();
						$row=ibase_fetch_object($res);
						if(isset($row)){
							$uuidr = $row->UUID;
							$cfdiRelacionado = array("UUID"=>$uuidr);
							$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
						}
					}

					if($totalDescuento >0){
						$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$nf",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);
					}else{
						$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$nf",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);					
					}

					if($relacion==1){
						$datos_factura["CfdiRelacionados"]=$cfdiRelacionados;
					}

					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$uso",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "id_transaccion"=>0,
					  			"cuenta"=>strtolower($rowDF->RFC),
					  			"user"=>'administrador',
					  			"password"=>$rowDF->CONTRASENIA,
					  			"getPdf"=>true,
					  			"conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$serie.'-'.$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
					$espera= 3;
					sleep(3);
					$fecha = date('d-m-Y');
					while ( $espera <= 15){	
						if(file_exists("C:\\xampp\\htdocs\\Facturas\\originales\\".$serie.'-'.$nf.".json")){
							$factura = 'ok';
							sleep(2);
							copy("C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".str_replace(" ","",trim($cl->RFC))."(".$serie.$nf.")".$fecha.".xml", "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$serie.$nf.".xml");
							$mensaje='Si la timbro';
							$espera = 15;
						}elseif(file_exists("C:\\xampp\\htdocs\\Facturas\\ErroresJson\\".$serie.'-'.$nf.".json")){
							$factura = 'error';
							$mensaje = 'Error la factura no se timbro';
							$espera = 15; 						

						}
						sleep(2);
						$espera = $espera+3;
					}

					if($factura){
						//// Codigo para cerrar la caja se actualiza lo facturado en la tabla de control facturas.
						$this->query="SELECT * FROM FTC_FACTURAS_DETALLE WHERE DOCUMENTO = '$serie'||$nf and (status= 0 or status is null)"; 
						$result=$this->EjecutaQuerySimple();
						while ($tsArray3=ibase_fetch_object($result)){
							$partidas[]=$tsArray3;
						}
						$i = 0;
						foreach ($partidas as $key) {
							$documento = $key->DOCUMENTO;
							$idcaja = $key->IDCAJA;
							$i++;
							$this->query="SELECT * FROM control_fact_rem where 
									caja = $idcaja 
									and idpreoc = $key->IDPREOC 
									and (status = 'Nuevo' or status= 'remisionado')";
							$result=$this->EjecutaQuerySimple();
							$tipoControl=ibase_fetch_object($result);
							$res = false;
							//echo 'Consulta Control Fact'.$this->query.'<br/>';
							if($tipoControl){
								if($tipoControl->STATUS == 'remisionado'){
									$this->query="UPDATE control_fact_rem set fact_rem = fact_rem - $key->CANTIDAD, FACTURAS = '$key->DOCUMENTO', STATUS = 'facturado', usuario_factura='$usuario', fecha_factura= current_timestamp
												WHERE caja = $idcaja and idpreoc = $key->IDPREOC and status= 'remisionado'";
									@$res=$this->queryActualiza();
								}elseif ($tipoControl->STATUS == 'Nuevo'){
									$this->query="UPDATE control_fact_rem set pxf = pxf - $key->CANTIDAD , USUARIO_FACTURA = '$usuario', FECHA_FACT_REM = current_timestamp, FECHA_FACTURA= CURRENT_TIMESTAMP,
												FACTURAS = '$key->DOCUMENTO', STATUS = 'facturado'
												WHERE caja = $idcaja and idpreoc = $key->IDPREOC and status = 'Nuevo'";
									@$res=$this->queryActualiza();
								}
								
								if($res==1){
									$this->query="UPDATE PREOC01 SET FACTURADO = FACTURADO + $key->CANTIDAD, 
																	 FACTURA = iif(factura is null,  '$serie'||$nf, factura||','||'$serie'||$nf),
																	 PENDIENTE_FACTURAR = PENDIENTE_FACTURAR - $key->CANTIDAD 
																	 where id = $key->IDPREOC";
									$this->EjecutaQuerySimple();
									$this->query="UPDATE CAJAS SET PAR_FACTURADAS = $i WHERE ID = $key->IDCAJA";
									$this->EjecutaQuerySimple();
									$this->query="UPDATE FTC_FACTURAS_DETALLE SET STATUS = 1 WHERE IDFP= $key->IDFP";
									$this->queryActualiza();
								}
							}		
						}
								
						$this->query="SELECT COUNT(IDFP) AS PARTIDAS FROM FTC_FACTURAS_DETALLE WHERE DOCUMENTO='$documento' and status = 1";
						$resultado= $this->EjecutaQuerySimple();
						$valfact=ibase_fetch_object($resultado);
						$partidasFacturadas = $valfact->PARTIDAS;
						//exit('Partidas afectadas '.$partidasFacturadas.' validacion:'.$i);
							if($partidasFacturadas == $i){
								$this->query="UPDATE FTC_FACTURAS SET STATUS = 1 WHERE DOCUMENTO='$documento'";
								$this->EjecutaQuerySimple();

								if($statusOriginal == 'cerrado'){
									$this->query="UPDATE CAJAS SET FACTURA='$documento' where id=$idcaja";
									$this->EjecutaQuerySimple();
								}else{
									$this->query="UPDATE CAJAS SET STATUS='cerrado', ruta='N', FACTURA='$documento', Docs='No' where id=$idcaja";
									$this->EjecutaQuerySimple();
								}

								if($factura == 'ok'){
									$mensaje = array("status"=>'ok', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja', "rfc"=>$cl->RFC, "fecha"=>$fecha);	
								}elseif($factura == 'error'){
									$mensaje = array("status"=>'No', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja', "rfc"=>$cl->RFC, "fecha"=>$fecha);
								}
							}else{
								$this->query="UPDATE CAJAS SET STATUS = 'cerrado' where id=$idcaja";
								$this->EjecutaQuerySimple();
								//$this->query="UPDATE FTC_FACTURAS SET STATUS = 8 WHERE DOCUMENTO='$documento'";
								//$this->EjecutaQuerySimple();
								//$avisoCorreo = $this->avisoCorreo($docuemnto);
									//if($avisoCorreo == 'ok'){
										$this->query="UPDATE FTC_FACTURAS SET STATUS = 9 WHERE DOCUMENTO = '$documento'";
										$this->EjecutaQuerySimple();
									//}
								$mensaje = array("status"=>'ok', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja y de Auditara la Mercancia', "rfc"=>$cl->RFC, "fecha"=>$fecha );
							}
					}else{
						//Echo "No Existe y no se creo la facura";
						$this->query="UPDATE CAJAS SET status='CFDI' where id = $idc";
						$this->queryActualiza();
						$mensaje = array("status"=>'No', "razon"=>'No se timbro la factura');
					}
				}else{
					$mensaje = array("status"=>'No', "razon"=>'No se creo el folio');
				}
		}else{
			if($valRefacturacion->STATUS == 'CFDI'){
				$mensaje = array("status"=>'No', "razon"=>'La Factura se encuentra el proceso de timbrado, favor de esperar');
			}elseif($valRefacturacion->STATUS == 'PENDIENTE'){
				$mensaje = array("status"=>'No', "razon"=>'La caja esta en proceso de facturacion');	
			}else{
				$mensaje = array("status"=>'No', "razon"=>'Ya se facturo la Caja');	
			}
		}
		//$this->query="UPDATE cajas set status= 'abierto', PAR_FACTURADAS= 0  where id = 41489";
		//$this->EjecutaQuerySimple();
		return $mensaje;//$mensaje = array("status"=>'ok',"factura"=>'$serie'.$nf);
	}

	function nuevaFactura_cfdi4($idc, $uso, $tpago, $mpago, $cp, $rel, $ocdet, $entdet){
		$usuario = $_SESSION['user']->NOMBRE;
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################

		//echo $idc.'<br/>';
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
		$this->query="SELECT C.*, 
			(SELECT DETALLISTA FROM CARTERA WHERE TRIM(IDCLIENTE) = (SELECT TRIM(CVE_CLPV) FROM FACTP01 WHERE CVE_DOC = C.CVE_FACT)) AS DET 
			FROM CAJAS C WHERE ID = $idc";
		$res = $this->EjecutaQuerySimple();
		$valRefacturacion=ibase_fetch_object($res);
		$validacion = $valRefacturacion->PAR_FACTURADAS; 
		$statusOriginal=$valRefacturacion->STATUS;
		if($validacion ==  0 and $valRefacturacion->STATUS !='CFDI' and $valRefacturacion->STATUS != 'PENDIENTE'){
			$this->query="UPDATE CAJAS SET STATUS = 'PENDIENTE' WHERE ID = $idc";
			$this->queryActualiza();

			$cliente = 'Liverpool';
			if($valRefacturacion->DET == 1){
				$det=$this->addendaLiverpool($idc, $uso, $tpago, $mpago, $cp, $rel, $ocdet, $entdet);
				return $det;
			}

			if($idc < 9999999){
			$this->query ="SELECT p.descripcion|| coalesce((select first 1 coalesce((select first 1 cast(ANEXO_DESCRIPCION as varchar(1000))
                      from FTC_ANEXO_DESCR
                      where CAJA = $idc and
                            PARTIDA = P.PARTIDA and
                            STATUS is null), '') as ANEXO from DETALLE_CAJA D
                        where D.IDCAJA = $idc and D.partida = p.partida
                        ),'') as descripcion, 
						P.*,
						(SELECT DBIMPPRE FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS PRECIO,
		                (SELECT DBIMPDES FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION= DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS DESCUENTO,
		                (SELECT CVE_CLIENTE FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO) AS CLIENTE 
		                FROM PAQUETES P WHERE IDCAJA = $idc and cantidad > devuelto";
		}else{
				$this->query="SELECT trim(f.CVE_CLPV) AS CLIENTE, 
							p.cant as cantidad, 
							p.prec as precio, 
							p.desc1 as descuento, 
							(select nombre from producto_ftc where clave = p.cve_art )as descripcion,
							p.cve_art as articulo, 
							p.id_Preoc, 
							99 as idcaja, 
							9 as id
							FROM PAR_FACTV01 p 
							left join factv01 f on f.cve_doc = p.cve_doc 
							WHERE f.CVE_DOC = '$cp'";
		}

		$rs=$this->EjecutaQuerySimple();
		while ($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		$totalDescuento= 0; 
		$subTotal= 0;
		$totalImp1=0;
		$IEPS=0;
		$desc2=0;
		$descf=0;
		$caja = $idc;
		foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
			$cliente=trim($key->CLIENTE);
			/// Bases
			$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
			$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
			$pC=$key->CANTIDAD-$key->DEVUELTO;
			$pDp=$key->DESCUENTO;/// Porcentaje de descuento por Partida.
			$pS=$pP*$pC;
			$pDi=(($key->DESCUENTO/100 * ($pP*$pC)));/// Descuento por el precio por la cantidad
			$pImp1 = ($pS - $pDi)*$imp1; /// Importe del Impuesto1 imp1 
			$totalDescuento =$totalDescuento + $pDi;
			$subTotal =$subTotal+$pS;
			$totalImp1=$totalImp1+$pImp1;
			$totalDoc= $subTotal - $totalDescuento + $totalImp1;
			$subSat = $this->truncarNumero($subTotal,$dec,$dect);
			$totImp1Sat=number_format($totalImp1,2,".","");
		}			
			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$serie = $_SESSION['user']->CATEGORIA;
			$this->query="SELECT iif(MAX(FOLIO) is null, 0, max(folio)) AS FOLIO FROM FTC_CTRL_FACTURAS WHERE SERIE = '$serie'";
			$res=$this->EjecutaQuerySimple();
			$folio = ibase_fetch_object($res);
			$nf = $folio->FOLIO + 1;
			$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $nf where SERIE  ='$serie'";
			$rs = $this->queryActualiza();
			if($rs ==1 ){
					$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
					$res=$this->EjecutaQuerySimple();
					$cl=ibase_fetch_object($res);
					$this->query="INSERT INTO FTC_FACTURAS (IDF, DOCUMENTO, SERIE, FOLIO, FORMADEPAGOSAT, VERSION, TIPO_CAMBIO, METODO_PAGO, REGIMEN_FISCAL, LUGAR_EXPEDICION, MONEDA, TIPO_COMPROBANTE, CONDICIONES_PAGO, SUBTOTAL, IVA, IEPS, DESC1, DESC2, DESCF, TOTAL, SALDO_FINAL, ID_PAGOS, ID_APLICACIONES, NOTAS_CREDITO, MONTO_NC, MONTO_PAGOS, MONTO_APLICACIONES, CLIENTE, USO_CFDI, STATUS, USUARIO, FECHA_DOC, FECHAELAB, IDCAJA) 
					VALUES (NULL, ('$serie'||$nf), '$serie', $nf, '$tpago', '3.3', 1, '$mpago', '$rowDF->REGIMEN_FISCAL', '$rowDF->LUGAR_EXPEDICION', 'MXN', 'I', '$cp', $subTotal, $totalImp1, $IEPS, $totalDescuento, $desc2, $descf, $totalDoc, $totalDoc, '','', '', 0,0,0,'$cliente', '$uso', 0, '$usuario ', current_timestamp, current_timestamp, $caja)";
					$this->grabaBD();
					//exit($this->query);//// Insertamos la cabecera de la factura.	
					$datos = array($cliente,$row->UNIDAD, $cl->NOMBRE,$cl->CALLE.', '.$cl->NUMEXT,$cl->COLONIA, $cl->ESTADO,$cl->TELEFONO, $cl->EMAILPRED,$cl->REFERENCIA_ENVIO, $caja,$totalDoc,'$serie'.$nf);  
					$idviaje = $mysql->ingresaLogReparto($datos); /// Creamos el registro en la BD MySQL para el Rastreador.
					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD-$keyp->DEVUELTO;
						$pDp=$keyp->DESCUENTO;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format((($keyp->DESCUENTO/100 * ($pP*$pC))),2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
						/// Datos Fiscales
								//$pPt2=$this->truncarNumero($key->PRECIO, 6, 2);
								//$st2=$st2 + $pPt2;
								//$pPt3=$this->truncarNumero($key->PRECIO, 6, 3);
								//$st3=$st3 + $pPt3;
								//$pPt4=$this->truncarNumero($key->PRECIO, 6, 4);
								//$st4=$st4 + $pPt4;
						$base=number_format($psubTotal-$pDi,$dec,".","");	
						$bimp=number_format($base * 0.16,$dec,".","");
						$descr = $keyp->DESCRIPCION;
						$this->query="INSERT INTO FTC_FACTURAS_DETALLE (IDFP, IDF, DOCUMENTO, PARTIDA, CANTIDAD, ARTICULO, UM, DESCRIPCION, IMP1, IMP2, IMP3, IMP4, DESC1, DESC2, DESC3, DESCF, SUBTOTAL, TOTAL, CLAVE_SAT, MEDIDA_SAT, PEDIMENTOSAT, LOTE, USUARIO, FECHA, IDPREOC, IDPAQUETE, IDCAJA, PRECIO )
						VALUES(NULL, (SELECT IDF FROM FTC_FACTURAS WHERE DOCUMENTO = ('$serie'||$nf)), 
									 ('$serie'||$nf), 
									 $partida, $keyp->CANTIDAD-$keyp->DEVUELTO, '$keyp->ARTICULO', (SELECT UM FROM PREOC01 WHERE ID = $keyp->ID_PREOC), '$descr', 16, 0, 0, 0, $pDi, 0,0,0, $psubTotal, $pTotal, (SELECT coalesce(CVE_PRODSERV, '40141700') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), (SELECT coalesce(CVE_UNIDAD, 'H87') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), '', '', '$usuario', current_timestamp, $keyp->ID_PREOC, $keyp->ID, $keyp->IDCAJA, $pP)";	
						$this->grabaBD();
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $descr, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						$CANTIDADN=$keyp->CANTIDAD-$keyp->DEVUELTO;

						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$CANTIDADN",
									      "descripcion"=> "$descr",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{

									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$CANTIDADN",
									      "descripcion"=> "$descr",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					$partidas = $mysql->ingresaLogRepartoDetalle($datosp);/// ingresamos las partidas al rastreador.
					}
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;
					
					$relacion=$rel;
					if($relacion==1){
						$this->query="SELECT first 1 * FROM FTC_FACTURAS WHERE IDCAJA = $idc and status = 8 order by fecha_cancelacion desc";
						$res=$this->EjecutaQuerySimple();
						$row=ibase_fetch_object($res);
						if(isset($row)){
							$uuidr = $row->UUID;
							$cfdiRelacionado = array("UUID"=>$uuidr);
							$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
						}
					}

					if($totalDescuento >0){
						$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$nf",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);
					}else{
						$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$nf",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);					
					}

					if($relacion==1){
						$datos_factura["CfdiRelacionados"]=$cfdiRelacionados;
					}

					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$uso",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "id_transaccion"=>0,
					  			"cuenta"=>strtolower($rowDF->RFC),
					  			"user"=>'administrador',
					  			"password"=>$rowDF->CONTRASENIA,
					  			"getPdf"=>true,
					  			"conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$serie.'-'.$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
					$espera= 3;
					sleep(3);
					$fecha = date('d-m-Y');
					while ( $espera <= 15){	
						if(file_exists("C:\\xampp\\htdocs\\Facturas\\originales\\".$serie.'-'.$nf.".json")){
							$factura = 'ok';
							sleep(2);
							copy("C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".str_replace(" ","",trim($cl->RFC))."(".$serie.$nf.")".$fecha.".xml", "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$serie.$nf.".xml");
							$mensaje='Si la timbro';
							$espera = 15;
						}elseif(file_exists("C:\\xampp\\htdocs\\Facturas\\ErroresJson\\".$serie.'-'.$nf.".json")){
							$factura = 'error';
							$mensaje = 'Error la factura no se timbro';
							$espera = 15; 						

						}
						sleep(2);
						$espera = $espera+3;
					}

					if($factura){
						//// Codigo para cerrar la caja se actualiza lo facturado en la tabla de control facturas.
						$this->query="SELECT * FROM FTC_FACTURAS_DETALLE WHERE DOCUMENTO = '$serie'||$nf and (status= 0 or status is null)"; 
						$result=$this->EjecutaQuerySimple();
						while ($tsArray3=ibase_fetch_object($result)){
							$partidas[]=$tsArray3;
						}
						$i = 0;
						foreach ($partidas as $key) {
							$documento = $key->DOCUMENTO;
							$idcaja = $key->IDCAJA;
							$i++;
							$this->query="SELECT * FROM control_fact_rem where 
									caja = $idcaja 
									and idpreoc = $key->IDPREOC 
									and (status = 'Nuevo' or status= 'remisionado')";
							$result=$this->EjecutaQuerySimple();
							$tipoControl=ibase_fetch_object($result);
							$res = false;
							//echo 'Consulta Control Fact'.$this->query.'<br/>';
							if($tipoControl){
								if($tipoControl->STATUS == 'remisionado'){
									$this->query="UPDATE control_fact_rem set fact_rem = fact_rem - $key->CANTIDAD, FACTURAS = '$key->DOCUMENTO', STATUS = 'facturado', usuario_factura='$usuario', fecha_factura= current_timestamp
												WHERE caja = $idcaja and idpreoc = $key->IDPREOC and status= 'remisionado'";
									@$res=$this->queryActualiza();
								}elseif ($tipoControl->STATUS == 'Nuevo'){
									$this->query="UPDATE control_fact_rem set pxf = pxf - $key->CANTIDAD , USUARIO_FACTURA = '$usuario', FECHA_FACT_REM = current_timestamp, FECHA_FACTURA= CURRENT_TIMESTAMP,
												FACTURAS = '$key->DOCUMENTO', STATUS = 'facturado'
												WHERE caja = $idcaja and idpreoc = $key->IDPREOC and status = 'Nuevo'";
									@$res=$this->queryActualiza();
								}
								
								if($res==1){
									$this->query="UPDATE PREOC01 SET FACTURADO = FACTURADO + $key->CANTIDAD, 
																	 FACTURA = iif(factura is null,  '$serie'||$nf, factura||','||'$serie'||$nf),
																	 PENDIENTE_FACTURAR = PENDIENTE_FACTURAR - $key->CANTIDAD 
																	 where id = $key->IDPREOC";
									$this->EjecutaQuerySimple();
									$this->query="UPDATE CAJAS SET PAR_FACTURADAS = $i WHERE ID = $key->IDCAJA";
									$this->EjecutaQuerySimple();
									$this->query="UPDATE FTC_FACTURAS_DETALLE SET STATUS = 1 WHERE IDFP= $key->IDFP";
									$this->queryActualiza();
								}
							}		
						}
								
						$this->query="SELECT COUNT(IDFP) AS PARTIDAS FROM FTC_FACTURAS_DETALLE WHERE DOCUMENTO='$documento' and status = 1";
						$resultado= $this->EjecutaQuerySimple();
						$valfact=ibase_fetch_object($resultado);
						$partidasFacturadas = $valfact->PARTIDAS;
						//exit('Partidas afectadas '.$partidasFacturadas.' validacion:'.$i);
							if($partidasFacturadas == $i){
								$this->query="UPDATE FTC_FACTURAS SET STATUS = 1 WHERE DOCUMENTO='$documento'";
								$this->EjecutaQuerySimple();

								if($statusOriginal == 'cerrado'){
									$this->query="UPDATE CAJAS SET FACTURA='$documento' where id=$idcaja";
									$this->EjecutaQuerySimple();
								}else{
									$this->query="UPDATE CAJAS SET STATUS='cerrado', ruta='N', FACTURA='$documento', Docs='No' where id=$idcaja";
									$this->EjecutaQuerySimple();
								}

								if($factura == 'ok'){
									$mensaje = array("status"=>'ok', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja', "rfc"=>$cl->RFC, "fecha"=>$fecha);	
								}elseif($factura == 'error'){
									$mensaje = array("status"=>'No', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja', "rfc"=>$cl->RFC, "fecha"=>$fecha);
								}
							}else{
								$this->query="UPDATE CAJAS SET STATUS = 'cerrado' where id=$idcaja";
								$this->EjecutaQuerySimple();
								//$this->query="UPDATE FTC_FACTURAS SET STATUS = 8 WHERE DOCUMENTO='$documento'";
								//$this->EjecutaQuerySimple();
								//$avisoCorreo = $this->avisoCorreo($docuemnto);
									//if($avisoCorreo == 'ok'){
										$this->query="UPDATE FTC_FACTURAS SET STATUS = 9 WHERE DOCUMENTO = '$documento'";
										$this->EjecutaQuerySimple();
									//}
								$mensaje = array("status"=>'ok', "factura"=>$serie.$nf,"razon"=>'Se ha cerrado la caja y de Auditara la Mercancia', "rfc"=>$cl->RFC, "fecha"=>$fecha );
							}
					}else{
						//Echo "No Existe y no se creo la facura";
						$this->query="UPDATE CAJAS SET status='CFDI' where id = $idc";
						$this->queryActualiza();
						$mensaje = array("status"=>'No', "razon"=>'No se timbro la factura');
					}
				}else{
					$mensaje = array("status"=>'No', "razon"=>'No se creo el folio');
				}
		}else{
			if($valRefacturacion->STATUS == 'CFDI'){
				$mensaje = array("status"=>'No', "razon"=>'La Factura se encuentra el proceso de timbrado, favor de esperar');
			}elseif($valRefacturacion->STATUS == 'PENDIENTE'){
				$mensaje = array("status"=>'No', "razon"=>'La caja esta en proceso de facturacion');	
			}else{
				$mensaje = array("status"=>'No', "razon"=>'Ya se facturo la Caja');	
			}
		}
		//$this->query="UPDATE cajas set status= 'abierto', PAR_FACTURADAS= 0  where id = 41489";
		//$this->EjecutaQuerySimple();
		return $mensaje;//$mensaje = array("status"=>'ok',"factura"=>'$serie'.$nf);
	}

	function addendaLiverpool($idc, $uso, $tpago, $mpago, $cp, $rel, $ocdet, $entdet){
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
		$usuario = $_SESSION['user']->NOMBRE;
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################
		$this->query="SELECT P.*,
						(SELECT DBIMPPRE FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS PRECIO,
		                (SELECT DBIMPDES FROM FTC_COTIZACION_DETALLE
		                WHERE cdfolio = (SELECT cdfolio FROM FTC_COTIZACION WHERE CVE_COTIZACION= DOCUMENTO)
		                AND ('PGS'||CVE_ART) = ARTICULO
		                ) AS DESCUENTO,
		                (SELECT CVE_CLIENTE FROM FTC_COTIZACION WHERE CVE_COTIZACION = DOCUMENTO) AS CLIENTE 
		                FROM PAQUETES P WHERE IDCAJA = $idc and cantidad > devuelto";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray = ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		//// Calculo de Totales
		$totalDescuento= 0; 
		$subTotal= 0;
		$totalImp1=0;
		$IEPS=0;
		$desc2=0;
		$descf=0;
		$caja = $idc;
		foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
			$cliente=trim($key->CLIENTE);
			/// Bases
			$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
			$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
			$pC=$key->CANTIDAD-$key->DEVUELTO;
			$pDp=$key->DESCUENTO;/// Porcentaje de descuento por Partida.
			// Calcualos para las operaciones;
			$pS=$pP*$pC;
			$pDi=(($key->DESCUENTO/100 * ($pP*$pC)));/// Descuento por el precio por la cantidad
			$pImp1 = ($pS - $pDi)*$imp1; /// Importe del Impuesto1 imp1 
			/// Totales para DocumentoSS
			$totalDescuento =$totalDescuento + $pDi;
			$subTotal =$subTotal+$pS;
			$totalImp1=$totalImp1+$pImp1;
			$totalDoc= $subTotal - $totalDescuento + $totalImp1;
			/// Datos Sat
			$subSat = $this->truncarNumero($subTotal,$dec,$dect);
			//$totSat = $this->truncarNumero($totalDoc,$dec, $dect);
			$totImp1Sat=number_format($totalImp1,2,".","");
			//echo 'Descuento: '.$pDp.', Precio '.$pP.' Cantidad'.$pC.'<br/>';
			//echo('Precio Truncado a '.$dect.' decimales'.$pPt.', Precio redondeado a '.$dec.' decimales'.$pP).'<br/>';
		}			
		/// Finaliza Totales.
			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			$cotizacion = $row->CVE_FACT;

			/// Creamos la factura:
			$this->query="SELECT iif(MAX(FOLIO) is null, 0, max(folio)) AS FOLIO FROM FTC_CTRL_FACTURAS WHERE SERIE = '$serie'";
				$res=$this->EjecutaQuerySimple();
				$folio = ibase_fetch_object($res);
				$nf = $folio->FOLIO + 1;
			$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $nf where SERIE  ='$serie'";
				$rs = $this->queryActualiza();

			if($rs ==1 ){
					$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
					$res=$this->EjecutaQuerySimple();
					$cl=ibase_fetch_object($res);
					$this->query="INSERT INTO FTC_FACTURAS (IDF, DOCUMENTO, SERIE, FOLIO, FORMADEPAGOSAT, VERSION, TIPO_CAMBIO, METODO_PAGO, REGIMEN_FISCAL, LUGAR_EXPEDICION, MONEDA, TIPO_COMPROBANTE, CONDICIONES_PAGO, SUBTOTAL, IVA, IEPS, DESC1, DESC2, DESCF, TOTAL, SALDO_FINAL, ID_PAGOS, ID_APLICACIONES, NOTAS_CREDITO, MONTO_NC, MONTO_PAGOS, MONTO_APLICACIONES, CLIENTE, USO_CFDI, STATUS, USUARIO, FECHA_DOC, FECHAELAB, IDCAJA) 
					VALUES (NULL, ('$serie'||$nf), '$serie', $nf, '$tpago', '3.3', 1, '$mpago', '$rowDF->REGIMEN_FISCAL', '$rowDF->LUGAR_EXPEDICION', 'MXN', 'I', '$cp', $subTotal, $totalImp1, $IEPS, $totalDescuento, $desc2, $descf, $totalDoc, $totalDoc, '','', '', 0,0,0,'$cliente', '$uso', 4, '$usuario ', current_timestamp, current_timestamp, $caja)";
					$this->grabaBD();

					$datos = array($cliente,$row->UNIDAD, $cl->NOMBRE,$cl->CALLE.', '.$cl->NUMEXT,$cl->COLONIA, $cl->ESTADO,$cl->TELEFONO, $cl->EMAILPRED,$cl->REFERENCIA_ENVIO, $caja,$totalDoc,'$serie'.$nf);  
					$idviaje = $mysql->ingresaLogReparto($datos); /// Creamos el registro en la BD MySQL para el Rastreador.
					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD-$keyp->DEVUELTO;
						$pDp=$keyp->DESCUENTO;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format((($keyp->DESCUENTO/100 * ($pP*$pC))),2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
						$base=number_format($psubTotal-$pDi,$dec,".","");	
						$bimp=number_format($base * 0.16,$dec,".","");

						$this->query="INSERT INTO FTC_FACTURAS_DETALLE (IDFP, IDF, DOCUMENTO, PARTIDA, CANTIDAD, ARTICULO, UM, DESCRIPCION, IMP1, IMP2, IMP3, IMP4, DESC1, DESC2, DESC3, DESCF, SUBTOTAL, TOTAL, CLAVE_SAT, MEDIDA_SAT, PEDIMENTOSAT, LOTE, USUARIO, FECHA, IDPREOC, IDPAQUETE, IDCAJA, PRECIO )
						VALUES(NULL, (SELECT IDF FROM FTC_FACTURAS WHERE DOCUMENTO = ('$serie'||$nf)), 
									 ('$serie'||$nf), 
									 $partida, $keyp->CANTIDAD-$keyp->DEVUELTO, '$keyp->ARTICULO', (SELECT UM FROM PREOC01 WHERE ID = $keyp->ID_PREOC), '$keyp->DESCRIPCION', 16, 0, 0, 0, $pDi, 0,0,0, $psubTotal, $pTotal, (SELECT coalesce(CVE_PRODSERV, '40141700') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), (SELECT coalesce(CVE_UNIDAD, 'H87') FROM INVE01 WHERE CVE_ART = '$keyp->ARTICULO'), '', '', '$usuario', current_timestamp, $keyp->ID_PREOC, $keyp->ID, $keyp->IDCAJA, $pP)";	
						$this->grabaBD();
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
					}
			}			
			//$fecha=date();
			$fechaAddenda=date("Y-m-d");
			//$rfe="REGIMEN GENERAL DE LEY PERSONAS MORALES";
			$xml = new DomDocument('1.0','UTF-8');
			$raiz=$xml->createElement('cfdi:Comprobante');
				$raiz->setAttribute("xmlns:cfdi","http://www.sat.gob.mx/cfd/3");
				$raiz->setAttribute("CondicionesDePago","Credito");
				$raiz->setAttribute("FormaPago","$mpago");
				$raiz->setAttribute("LugarExpedicion","$rowDF->LUGAR_EXPEDICION");
				$raiz->setAttribute("MetodoPago","$tpago");
				$raiz->setAttribute("Moneda","MXN");
				$raiz->setAttribute("Serie","FP");
				$raiz->setAttribute("Folio","$nf");
				$raiz->setAttribute("SubTotal","$subTotal");
				if($totalDescuento > 0){
					$raiz->setAttribute("Descuento","$totalDescuento");
				}
				$raiz->setAttribute("TipoCambio","1.000000");
				$raiz->setAttribute("TipoDeComprobante","I");
				$raiz->setAttribute("Total","$totalDoc");
				$raiz->setAttribute("Version","3.3");
				$raiz->setAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
				$raiz->setAttribute("xsi:schemaLocation","http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd");
			$raiz=$xml->appendChild($raiz);

			$emisor=$xml->createElement("cfdi:Emisor");
				$emisor->setAttribute("Nombre","FERRETERA PEGASO SA DE CVE");
				$emisor->setAttribute("RegimenFiscal","$rowDF->REGIMEN_FISCAL");
				$emisor->setAttribute("Rfc","FPE980326GH9");
			$emisor=$raiz->appendChild($emisor);
			$receptor=$xml->createElement("cfdi:Receptor");
				$receptor->setAttribute("Nombre","$cl->NOMBRE");
				$receptor->setAttribute("UsoCFDI","$uso");
				$receptor->setAttribute("Rfc",trim($cl->RFC));
			$receptor=$raiz->appendChild($receptor);

			$conceptos=$xml->createElement("cfdi:Conceptos");
			//// Codigo para recorrer los conceptos o partidas.
			$ln =0;
			$partida = 0;
			$totalImp1=0;
			foreach ($data as $key2 ) {
				$ln++;
				$partida++;
						$pPt = $this->truncarNumero($key2->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($key2->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$key2->CANTIDAD-$key2->DEVUELTO;
						$pDp=$key2->DESCUENTO;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC; /// Cantidad  * Precio
						$pDi=number_format((($key2->DESCUENTO/100 * ($pP*$pC))),2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento+= $pDi; /// Total del Descuento
						$psubTotal=number_format($pP*$pC,2,".",""); /// 
						$subTotal+= $pS;
						$pTotal= $psubTotal-$pDi+$pImp1;
						$base=number_format($psubTotal-$pDi,$dec,".","");	
						$bimp=number_format($base * 0.16,$dec,".","");
						$totalImp1+=number_format($base * 0.16,$dec,".","");
				$this->query="SELECT I.*, (SELECT UM FROM PREOC01 WHERE ID = $key2->ID_PREOC) as UMED FROM INVE01 I LEFT JOIN inve_clib01 icl on i.cve_art = icl.cve_prod where cve_art = '$key2->ARTICULO'";
				$rs=$this->EjecutaQuerySimple();
    			$row=ibase_fetch_object($rs);

				$partida=$xml->createElement("cfdi:Concepto");
					$partida->setAttribute("Cantidad",$key2->CANTIDAD);
					$partida->setAttribute("ClaveProdServ",trim($row->CVE_PRODSERV));
					$partida->setAttribute("ClaveUnidad",trim($row->CVE_UNIDAD));
					$partida->setAttribute("Descripcion",$key2->DESCRIPCION);
					$partida->setAttribute("Importe",$psubTotal);
					if($pDi > 0 ){
						$partida->setAttribute("Descuento",$pDi);
					}
					$partida->setAttribute("Unidad",$row->UMED);
					$partida->setAttribute("ValorUnitario",$key2->PRECIO);
					$impuesto=$xml->createElement("cfdi:Impuestos");
						$traslados=$xml->createElement("cfdi:Traslados");
							$Traslado=$xml->createElement("cfdi:Traslado");
								$Traslado->setAttribute("Base","$base");
								$Traslado->setAttribute("Importe","$bimp");
								$Traslado->setAttribute("Impuesto","002");
								$Traslado->setAttribute("TasaOCuota","0.160000");
								$Traslado->setAttribute("TipoFactor","Tasa");
							$Traslado=$traslados->appendChild($Traslado);
						$traslados=$impuesto->appendChild($traslados);
					$impuesto=$partida->appendChild($impuesto);
				$partida=$conceptos->appendChild($partida);
			}
			$conceptos=$raiz->appendChild($conceptos);

			$Impuestos=$xml->createElement("cfdi:Impuestos");
				$Impuestos->setAttribute("TotalImpuestosTrasladados","$totalImp1");
				$Traslados=$xml->createElement("cfdi:Traslados");
					$traslado=$xml->createElement("cfdi:Traslado");
						$traslado->setAttribute("Importe","$totalImp1");
						$traslado->setAttribute("Impuesto","002");
						$traslado->setAttribute("TasaOCuota","0.160000");
						$traslado->setAttribute("TipoFactor","Tasa");
					$traslado=$Traslados->appendChild($traslado);
				$Traslados=$Impuestos->appendChild($Traslados);
			$Impuestos=$raiz->appendChild($Impuestos);

			$complemento=$xml->createElement("cfdi:Complemento");
				$detallista=$xml->createElement("detallista:detallista");
					$detallista->setAttribute("xmlns:detallista","http://www.sat.gob.mx/detallista");
					$detallista->setAttribute("xsi:schemaLocation","http://www.sat.gob.mx/detallista http://www.sat.gob.mx/sitio_internet/cfd/detallista/detallista.xsd");
					$detallista->setAttribute("documentStructureVersion","AMC8.1");
					$detallista->setAttribute("documentStatus","ORIGINAL");
					$detallista->setAttribute("contentVersion","1.3.1");
					$detallista->setAttribute("xmlns","http://www.sat.gob.mx/detallista");

					$rfpi=$xml->createElement("detallista:requestForPaymentIdentification");
						$rfpiet=$xml->createElement("detallista:entityType","INVOICE");
						$rfpiet=$rfpi->appendChild($rfpiet);
					$rfpi=$detallista->appendChild($rfpi);

						$letras=new NumberToLetterConverter;
						$m = $totalDoc ;
						$Monto=number_format($m,0);
						$M1=number_format($m,2);
						$M4=substr($M1, 0,-2);
        				$centavos=substr($M1,-2);
   						$m5= $M4.'00';
   						$res=$letras->to_word($m5);
        				if ($centavos == 00){
        					$leyenda = 'PESOS CON 00/100 MN';
        				}else{
        					$leyenda = 'PESOS CON '.$centavos.'/100 MN';
        				}

					$si=$xml->createElement("detallista:specialInstruction");
						$si->setAttribute("code","ZZZ");
						$dtext=$xml->createElement("detallista:text","$res$leyenda");
						$dtext=$si->appendChild($dtext);
					$si=$detallista->appendChild($si);

					$oi=$xml->createElement("detallista:orderIdentification");
						$roi=$xml->createElement("detallista:referenceIdentification","$ocdet");
							$roi->setAttribute("type","ON");
						$roi=$oi->appendChild($roi);
					$oi=$detallista->appendChild($oi);

					$ai=$xml->createElement("detallista:AdditionalInformation");
						$rai=$xml->createElement("detallista:referenceIdentification", "FP$nf");
							$rai->setAttribute("type","IV");
						$rai=$ai->appendChild($rai);
					$ai=$detallista->appendChild($ai);

					$dn=$xml->createElement("detallista:DeliveryNote");
						$dri=$xml->createElement("detallista:referenceIdentification","$entdet");
						$dri=$dn->appendChild($dri);
					$dn=$detallista->appendChild($dn);

					$buy=$xml->createElement("detallista:buyer");
						$buyg=$xml->createElement("detallista:gln","7504000107903");
						$buyg=$buy->appendChild($buyg);
					$buy=$detallista->appendChild($buy);

					$sell=$xml->createElement("detallista:seller");
						$sellg=$xml->createElement("detallista:gln","0000000059137");
						$sellapi=$xml->createElement("detallista:alternatePartyIdentification","59137");
							$sellapi->setAttribute("type","SELLER_ASSIGNED_IDENTIFIER_FOR_A_PARTY");
						$sellg=$sell->appendChild($sellg);
						$sellapi=$sell->appendChild($sellapi);
					$sell=$detallista->appendChild($sell);

				$detallista=$complemento->appendChild($detallista);
			$complemento=$raiz->appendChild($complemento);

			$xml->formatOutput = true;
			$xml->saveXML();
			//$xml->save('/archivo.xml');
			$xml->save('C:\\xampp\\htdocs\\Facturas\\ComplementoDetallista\\FP'.$nf.'.xml');
			$descarga = "/Facturas/ComplementoDetallista/FP".$nf.".xml";
			$archivo="C:\\xampp\\htdocs\\Facturas\\ComplementoDetallista\\FP".$nf.".xml";
			$arc="C:\\xampp\\htdocs\\Facturas\\ComplementoDetallista\\FP".$nf."_D.xml";
			$t=file_get_contents($archivo);
			$xmlData=$t;
			$t=str_replace('"', '\\"', $t);
			$fp=fopen($arc, 'w');
			$fp=fwrite($fp, $t);
			
			
			$df=array(
					  "id_transaccion"=>0,
					  "cuenta"=>strtolower($rowDF->RFC),
					  "user"=>'administrador',
					  "password"=>$rowDF->CONTRASENIA,
					  "getPdf"=>true,
					  "client"=>"cfdfactura",
					  "include_stamps"=>"true",
					  "xml_version"=>"3.3",
					  "xml_data"=>$xmlData
						);

			$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\generaJson\\".'FP-'.$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
					$espera= 3;
					sleep(3);
					$fecha = date('d-m-Y');

			$this->query="UPDATE CAJAS SET STATUS = 'cerrado', factura = ('$serie'||$nf), PAR_FACTURADAS = $ln where id = $idc ";
			$this->queryActualiza();

			return array("status"=>'detallista', "archivo"=>$descarga);
	}

  function timbraFact($docf, $idc){
    	$usuario = $_SESSION['user']->NOMBRE;
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################
		if(gettype($idc) == 'array'){
    		$cfdiRelacionado = array("UUID"=>$idc["uuid_c"]);
			//$cfdiRelacionado = array("UUID"=>"C46B2089-99B3-174C-B164-804944240C64");
			$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			$doc=$idc['factCancel'];
			$this->query="UPDATE FTC_FACTURAS SET STATUS = 8 WHERE DOCUMENTO = '$doc'";
			$this->EjecutaQuerySimple();
    	}

    	$this->query="SELECT * FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$nf=$docf;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$serie =$row->SERIE;
			$folio = $row->FOLIO;
			$idc =empty($row->IDCAJA)? 0:$row->IDCAJA;
		
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
			
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_FACTURAS WHERE DOCUMENTO='$docf')";
    		$rs=$this->EjecutaQuerySimple();
    		$rowc=ibase_fetch_object($rs);
    		$cliente=$rowc->CLAVE_TRIM;
    		$nombre=$rowc->NOMBRE;
    		$rfc=$rowc->RFC;

			$this->query="SELECT fd.*, f.cliente FROM FTC_FACTURAS_DETALLE fd LEFT JOIN FTC_FACTURAS F ON F.documento = fd.documento WHERE fd.DOCUMENTO = '$docf' and (fd.status= 0 or fd.status is null) and cantidad > 0"; 
			$rs=$this->EjecutaQuerySimple();
			while ($tsArray = ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
				$totalDescuento= 0; 
				$subTotal= 0;
				$totalImp1=0;
				$IEPS=0;
				$desc2=0;
				$descf=0;
				$caja = $idc;
			foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
					$cliente=trim($key->CLIENTE);
					$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
					$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
					$pC=$key->CANTIDAD;
					//$pDp=$key->DESCUENTO;
					$pS=$pP*$pC;
					$pDi=number_format($key->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
					$pImp1 = ($pS - $pDi)*$imp1; 
					$totalDescuento =$totalDescuento + $pDi;
					$subTotal =$subTotal+$pS;
					$totalImp1=$totalImp1+$pImp1;
					$totalDoc= $subTotal - $totalDescuento + $totalImp1;
					$subSat = $this->truncarNumero($subTotal,$dec,$dect);
					$totImp1Sat=number_format($totalImp1,2,".","");
			}

			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			@$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
			$res=$this->EjecutaQuerySimple();
			$cl=ibase_fetch_object($res);
					//exit($this->query);//// Insertamos la cabecera de la factura.	

					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD;
						//$pDp=$keyp->DESC1;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format($keyp->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
							$base=number_format($psubTotal-$pDi,$dec,".","");	
							$bimp=number_format($base * 0.16,$dec,".","");
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						//$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA
						$bimp=number_format($bimp,2,".",""); 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					}
					
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;
					if($totalDescuento >0){
						if(isset($cfdiRelacionado)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);	
						}	
					}else{
						if(isset($cfdiRelacionados)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);					
						}
					}
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$uso",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					/*$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					*/
					$df =array( "id_transaccion"=>0,
					  			"cuenta"=>strtolower($rowDF->RFC),
					  			"user"=>'administrador',
					  			"password"=>$rowDF->CONTRASENIA,
					  			"getPdf"=>true,
					  			"conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
		return $cl->RFC;
    }


	function timbraFactV4($docf, $idc){
    	$usuario = $_SESSION['user']->NOMBRE;
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################
		if(gettype($idc) == 'array'){
    		$cfdiRelacionado = array("UUID"=>$idc["uuid_c"]);
			//$cfdiRelacionado = array("UUID"=>"C46B2089-99B3-174C-B164-804944240C64");
			$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			$doc=$idc['factCancel'];
			$this->query="UPDATE FTC_FACTURAS SET STATUS = 8 WHERE DOCUMENTO = '$doc'";
			$this->EjecutaQuerySimple();
    	}

    	$this->query="SELECT * FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$nf=$docf;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$serie =$row->SERIE;
			$folio = $row->FOLIO;
			$idc =empty($row->IDCAJA)? 0:$row->IDCAJA;
		
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
			
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_FACTURAS WHERE DOCUMENTO='$docf')";
    		$rs=$this->EjecutaQuerySimple();
    		$rowc=ibase_fetch_object($rs);
    		$cliente=$rowc->CLAVE_TRIM;
    		$nombre=$rowc->NOMBRE;
    		$rfc=$rowc->RFC;

			$this->query="SELECT fd.*, f.cliente FROM FTC_FACTURAS_DETALLE fd LEFT JOIN FTC_FACTURAS F ON F.documento = fd.documento WHERE fd.DOCUMENTO = '$docf' and (fd.status= 0 or fd.status is null) and cantidad > 0"; 
			$rs=$this->EjecutaQuerySimple();
			while ($tsArray = ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
				$totalDescuento= 0; 
				$subTotal= 0;
				$totalImp1=0;
				$IEPS=0;
				$desc2=0;
				$descf=0;
				$caja = $idc;
			foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
					$cliente=trim($key->CLIENTE);
					$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
					$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
					$pC=$key->CANTIDAD;
					//$pDp=$key->DESCUENTO;
					$pS=$pP*$pC;
					$pDi=number_format($key->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
					$pImp1 = ($pS - $pDi)*$imp1; 
					$totalDescuento =$totalDescuento + $pDi;
					$subTotal =$subTotal+$pS;
					$totalImp1=$totalImp1+$pImp1;
					$totalDoc= $subTotal - $totalDescuento + $totalImp1;
					$subSat = $this->truncarNumero($subTotal,$dec,$dect);
					$totImp1Sat=number_format($totalImp1,2,".","");
			}

			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			@$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
			$res=$this->EjecutaQuerySimple();
			$cl=ibase_fetch_object($res);
					//exit($this->query);//// Insertamos la cabecera de la factura.	

					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD;
						//$pDp=$keyp->DESC1;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format($keyp->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
							$base=number_format($psubTotal-$pDi,$dec,".","");	
							$bimp=number_format($base * 0.16,$dec,".","");
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						//$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA
						$bimp=number_format($bimp,2,".",""); 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> utf8_encode("$keyp->ARTICULO"),
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> utf8_encode("$keyp->ARTICULO"),
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					}
					
					$baseTimp = $subTotal-$totalDescuento;
					$impuesto1 = array(	"Impuesto"=> "002",
											"Base"=>"$baseTimp",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;
					if($totalDescuento >0){
						if(isset($cfdiRelacionado)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);	
						}	
					}else{
						if(isset($cfdiRelacionados)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$tpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$mpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$mpago",
											"Version"=>"4.0",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.00",
											"MetodoPago"=> "$tpago",
		    							"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										  "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										  "Moneda"=> "MXN",
										  "TipoDeComprobante"=> "I",
										  "Exportacion"=>"01",
										  "condicionesDePago"=> "$mpago",
										  "SubTotal"=>"$subSat",//"$ST",
										  "Total"=>"$totSat",
										  "Impuestos"=>$imp
										);					
						}
					}
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$usoCFDI = !empty($cl->USO_CFDI)? $cl->USO_CFDI:$uso;
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$usoCFDI",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"DomicilioFiscalReceptor"=>"$cl->CODIGO",
										"RegimenFiscalReceptor"=>"$cl->SAT_REGIMEN",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					/*$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					*/
					$df =array( "id_transaccion"=>0,
					  			"cuenta"=>strtolower($rowDF->RFC),
					  			"user"=>'administrador',
					  			"password"=>$rowDF->CONTRASENIA,
					  			"getPdf"=>true,
					  			"conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
		return $nf;
    }

    function timbraNC($docf, $idc){
    	$usuario = $_SESSION['user']->NOMBRE;
    	############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################
		echo 'Documento: '.$docf.' Caja: '.$idc.'<br/>';
		//exit();
		$this->query="SELECT * FROM FTC_NC WHERE DOCUMENTO = '$docf'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$nf=$docf;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$serie =$row->SERIE;
			$folio = $row->FOLIO;
	
		if(strlen($row->NOTAS_CREDITO)>0){
			$relacion = 'ok';
			$this->query="SELECT * FROM CFDI01 WHERE CVE_DOC = '$row->NOTAS_CREDITO'";
			$rs=$this->EjecutaQuerySimple();
			$rowRel= ibase_fetch_object($rs);
			if($rowRel){
				$uuidr=$rowRel->UUID;
				$cfdiRelacionado=array("UUID"=>$uuidr);
				$cfdiRelacionados=array("TipoRelacion"=>"01",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			}else{
				$this->query="SELECT FIRST 1 * FROM XML_DATA WHERE SERIE||FOLIO ='$row->NOTAS_CREDITO'";
                   	$a=$this->EjecutaQuerySimple();
                    $rxml=ibase_fetch_object($a);
                    $uuidr=$rxml->UUID;
					$cfdiRelacionado = array("UUID"=>$uuidr);
					$cfdiRelacionados=array("TipoRelacion"=>"01",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			}	
		}

		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
			
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_NC WHERE DOCUMENTO='$docf')";
    		$rs=$this->EjecutaQuerySimple();
    		$rowc=ibase_fetch_object($rs);
    		$cliente=$rowc->CLAVE_TRIM;
    		$nombre=$rowc->NOMBRE;
    		$rfc=$rowc->RFC;

			$this->query="SELECT fd.*, f.cliente FROM FTC_NC_DETALLE fd LEFT JOIN FTC_NC F ON F.documento = fd.documento WHERE fd.DOCUMENTO = '$docf' and (fd.status= 0 or fd.status is null or fd.status = 7)"; 
			$rs=$this->EjecutaQuerySimple();

			while ($tsArray = ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
				$totalDescuento= 0; 
				$subTotal= 0;
				$totalImp1=0;
				$IEPS=0;
				$desc2=0;
				$descf=0;
				$caja = $idc;
			foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
					$cliente=trim($key->CLIENTE);
					$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
					$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
					$pC=$key->CANTIDAD;
					//$pDp=$key->DESCUENTO;
					$pS=$pP*$pC;
					$pDi=number_format($key->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
					$pImp1 = ($pS - $pDi)*$imp1; 
					$totalDescuento =$totalDescuento + $pDi;
					$subTotal =$subTotal+$pS;
					$totalImp1=$totalImp1+$pImp1;
					$totalDoc= $subTotal - $totalDescuento + $totalImp1;
					$subSat = $this->truncarNumero($subTotal,$dec,$dect);
					$totImp1Sat=number_format($totalImp1,2,".","");
			}

			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			@$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
			$res=$this->EjecutaQuerySimple();
			$cl=ibase_fetch_object($res);
					//exit($this->query);//// Insertamos la cabecera de la factura.	

					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD;
						//$pDp=$keyp->DESC1;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pDi=number_format($keyp->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
							$base=number_format($psubTotal-$pDi,$dec,".","");	
							$bimp=number_format($base * 0.16,$dec,".","");
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						//$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					}
					
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;

					if($totalDescuento >0){
						if($relacion = 'ok'){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp, 
										    "CfdiRelacionados"=>$cfdiRelacionados
										);	
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);
						}
					}else{
						if($relacion = 'ok'){
								$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp,
										    "CfdiRelacionados"=>$cfdiRelacionados
										);
						}else{
								$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
								);
						}					
					}
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$uso",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
		return $cl->RFC;
    }

 	function timbraNCDescLogSub($docf){
    	$usuario = $_SESSION['user']->NOMBRE;
    	############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################
    	$this->query="SELECT * FROM FTC_NC WHERE NOTAS_CREDITO ='$docf'";
    	$res=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($res);
    	if($row){
    		return array("status"=>'no',"mensaje"=>'Ya hay una NC aplicada');
    	}
		$folio=$this->creaFolioNCSUB();
		$nf = $folio['docNCSUB'];
		$folioNC=$folio['folioNCSUB'];
		$serieNC=$folio['serieNCSUB'];
		$this->query="SELECT * FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$idc = $row->IDCAJA;
			$this->query="SELECT * FROM XML_DATA WHERE SERIE||FOLIO ='$docf'";
                   $a=$this->EjecutaQuerySimple();
                   $rxml=ibase_fetch_object($a);
                   $uuidr=$rxml->UUID;
			$cfdiRelacionado = array("UUID"=>$uuidr);
			$cfdiRelacionados=array("TipoRelacion"=>"01",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_FACTURAS WHERE DOCUMENTO='$docf')";
    		$rs=$this->EjecutaQuerySimple();
    		$cl=ibase_fetch_object($rs);
    		$cliente=$cl->CLAVE_TRIM;
    		$nombre=$cl->NOMBRE;
    		$rfc=$cl->RFC;
					$impConcepto=array(
										"Base"=>"200.00",
							            "Impuesto"=>"002",
							            "TipoFactor"=>"Tasa",
							            "TasaOCuota"=>"0.160000",
							            "Importe"=>"32.00"
										);
					$trasConceptos[]=$impConcepto;
					$trasConcepto=array("Traslados"=>$trasConceptos);
					unset($trasConceptos);
						
						$concepto = array(
							  "ClaveProdServ"=>"80141629",
						      "ClaveUnidad"=> "E48",
						      "noIdentificacion"=> "BONIF",
						      "unidad"=> "N/A",
						      "Cantidad"=>"1",
						      "descripcion"=> "DESCUENTO POR TRASLADO DE MERCACIA",
						      "ValorUnitario"=> "200.00",
						      "Importe"=> "200.00",
						      "Impuestos"=>$trasConcepto
								);
												
					$conceptos[]=$concepto;
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"32.00"
										);
					
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:"."32.00";//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"32.00",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					
					$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"99",
											"Version"=>"3.3",
											"Folio"=>"$folioNC",
											"Serie"=>$serieNC,
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "PUE",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "99",
										    "SubTotal"=>"200.00",//"$ST",
										    "Total"=>"232.00",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"G02",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
			$this->query="EXECUTE PROCEDURE SP_NCSUB('$docf', '$folioNC', 'SUB', '$usuario')";
			$res=$this->EjecutaQuerySimple();	
			$this->query="EXECUTE PROCEDURE SP_NCSUB_DET('$docf', '$folioNC', 'SUB', '$usuario')";	
			$res=$this->EjecutaQuerySimple();
			$this->moverNCSUB($nf, $rfc=$cl->RFC);		
		return array("status"=>'no',"mensaje"=>'Ya hay una NC aplicada');
    }

	function truncarNumero($numero, $dec, $dect){
		$dec=2;
		$numero = number_format($numero,$dec,".","");
		$numero = explode(".", $numero);
		$decimal = substr($numero[1],0,$dect);
		return $numero[0].".".$decimal; 
	}

	function insertaJson($json, $fh){
		$nf=$json['datos_factura']['Serie'].$json['datos_factura']['Folio'];
		$partida=0;
		foreach ($json['conceptos'] as $key ) {
			//echo 'Json Concepto: '.$key['ClaveProdServ'].'<br/>';
			$partida += 1;
			$cantidad = $key['Cantidad'];	
			$precio = $key['ValorUnitario'];
			$importe = $key['Importe'];
			$decimales = explode(".", $importe);
				$decimales = $decimales[1];
				//echo 'Decimales: '.$decimales.'<br/>'.substr($decimales, 3,1).'<br/>';
					if(substr($decimales, 3,1) <> 0){
						$decimales = 4;
					}elseif(substr($decimales, 2,1) <> 0){
						$decimales = 3;
					}elseif (substr($decimales, 1,1) <> 0) {
						$decimales = 2;
					}elseif (substr($decimales, 0,1) <> 0) {
						$decimales = 1;
					}
			$descuento= isset($key['Descuento'])?  $key['Descuento']:0;
				foreach ($key['Impuestos']['Traslados'] as $impuesto){
						$base = $impuesto['Base'];
						$iva = $impuesto['Importe'];
				}

			$this->query="INSERT INTO FTC_ERRORES_JSON (ID, FACTURA, ARCHIVO, PARTIDA, CANTIDAD, PRECIO, IMPORTE_CONCEPTO, DESCUENTO, BASE, IVA, DECIMALES, VALOR_FTC_FACT_DET, DIFERENCIA) VALUES (
			NULL, '$nf', '$fh', $partida, $cantidad, $precio, $importe, $base, $descuento,  $iva, $decimales, 0,0)";
			//echo $this->query;
			$this->EjecutaQuerySimple();

		}
	}

	function creaFolioNCSUB(){
		$this->query="SELECT FOLIO, SERIE FROM FTC_CTRL_FACTURAS WHERE IDFF = 4";
		$rs=$this->EjecutaQuerySimple();
		$row1=ibase_fetch_object($rs);
		$folioNC = $row1->FOLIO + 1; 
		$serieN =$row1->SERIE; 
		$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $folioNC where idff = 4";
		$this->grabaBD();
		$folioNCSUB = $row1->SERIE.$folioNC;
		return array("docNCSUB"=> $folioNCSUB,"serieNCSUB"=>$serieN, "folioNCSUB" => $folioNC);
    }

    function creaFolioNCD(){
		$this->query="SELECT FOLIO, SERIE FROM FTC_CTRL_FACTURAS WHERE IDFF = 5";
		$rs=$this->EjecutaQuerySimple();
		$row1=ibase_fetch_object($rs);
		$folioNC = $row1->FOLIO + 1; 
		$serieN =$row1->SERIE; 
		$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $folioNC where idff = 5";
		$this->grabaBD();
		$folioNCD = $row1->SERIE.$folioNC;
		return array("docNCD"=> $folioNCD,"serieNC"=>$serieN, "folioNC" => $folioNC);
    }

    function creaFolioNCI(){
		$this->query="SELECT FOLIO, SERIE FROM FTC_CTRL_FACTURAS WHERE IDFF = 6";
		$rs=$this->EjecutaQuerySimple();
		$row1=ibase_fetch_object($rs);
		$folioNC = $row1->FOLIO + 1; 
		$serieN =$row1->SERIE; 
		$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $folioNC where idff = 6";
		$this->grabaBD();
		$folioNCD = $row1->SERIE.$folioNC;
		return array("docNCD"=> $folioNCD,"serieNC"=>$serieN, "folioNC" => $folioNC);
    }

    function moverNCSUB($nc, $rfc){
    	$data = new pegaso;
    	$mensaje ='';
		$espera= 3;
		sleep(2);
		$fecha = date('d-m-Y');
		$docn = $nc;
			while ( $espera <= 15){	
				if(file_exists("C:\\xampp\\htdocs\\Facturas\\originales\\".$nc.".json")){
					$ncval = 'ok';
					sleep(2);
					copy("C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".str_replace(" ","",trim($rfc))."(".$nc.")".$fecha.".xml", "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$nc.".xml");
					$nc= "C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".str_replace(" ","",trim($rfc))."(".$nc.")".$fecha.".xml";
					$a = $data->leeXML($archivo=$nc);;
					$exe = $data->insertarArchivoXMLCargado($archivo=$nc, $tipo='F', $a);
					$espera = 15;
					$mensaje=array("rfc"=>$rfc,"fecha"=>$fecha,"factura"=>$docn);
				}elseif(file_exists("C:\\xampp\\htdocs\\Facturas\\ErroresJson\\".$nc.".json")){
					$factura = 'error';
					$mensaje = 'Error la factura no se timbro';
					$espera = 15; 
				}
				sleep(2);
				$espera = $espera+3;
			}
		return $mensaje; 
    }

    function moverFactv4($nc, $doc){
    	$data = new pegaso;
    	$mensaje ='';
			$espera= 3;
			sleep(3);
			$fecha = date('d-m-Y');
			$docn = $nc;
			while ( $espera <= 15){	
				if(file_exists("C:\\xampp\\htdocs\\Facturas\\originales\\".$nc.".json")){
					$ncval = 'ok';
					sleep(2);
					copy("C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".$doc.".xml", "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$doc.".xml");
					$nc= "C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".$doc.".xml";
					$a = $data->leeXML($archivo=$doc);;
					$exe = $data->insertarArchivoXMLCargado($archivo=$doc, $tipo='F', $a);
					$espera = 15;
					$mensaje=array("rfc"=>$doc,"fecha"=>$fecha,"factura"=>$docn);
				}elseif(file_exists("C:\\xampp\\htdocs\\Facturas\\ErroresJson\\".$doc.".json")){
					$factura = 'error';
					$mensaje = 'Error la factura no se timbro';
					$espera = 15; 
				}
				sleep(2);
				$espera = $espera+3;
			}
		return $mensaje; 
    }

	function cancelaFactura($docf){
		$this->query="SELECT * FROM XML_DATA WHERE SERIE||FOLIO = '$docf'";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$uuid=$row->UUID;
		$serie =$row->SERIE; 
		$folio =$row->FOLIO;
		$nf = $serie.$folio.'-C'; 
		$json_cancelaciones=array("uuid"=>$uuid, 
								  "serie"=>"$serie",
								  "folio"=>"$folio"
								);
		$df =array(	"method"=>'cancelarCFDI', 
					"cancelaciones"=>$json_cancelaciones
					);
		$cancelacion = json_encode($df,JSON_UNESCAPED_UNICODE);
		$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
		fwrite($fh, $cancelacion);
		fclose($fh);
		/// Falta el metodo para mover el acuse de cancelacion del SAT.
		return array("factCancel"=>$serie.$folio, "uuid_c"=>$uuid);
	}

	function crearFoliosFactura(){
		$this->query="SELECT FOLIO, SERIE FROM FTC_CTRL_FACTURAS WHERE IDFF = 1";
		$rs=$this->EjecutaQuerySimple();
		$row1=ibase_fetch_object($rs);
		$folioRFP = $row1->FOLIO + 1;
		$serieF =$row1->SERIE; 
		$this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $folioRFP where idff = 1";
		$this->grabaBD();
		$folioF = $row1->SERIE.$folioRFP;
		return $folioF;	
	}

	function copiaFactura($idsol, $folion, $folioo){
		$usuario=$_SESSION['user']->NOMBRE;
		$folio = substr($folion,2,10);
		
		$this->query="EXECUTE PROCEDURE SP_CREA_REFACTURACION('$folioo','$usuario','$folion')";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
		$idsol= $row->IDR;

		$this->query="execute PROCEDURE sp_copia_factura_pegaso($idsol,'$folion','$serie', $folio, '$usuario')";
		if($rs=$this->EjecutaQuerySimple()){
			$this->query="EXECUTE PROCEDURE SP_COPIA_DET_FACTURA_PEGASO($idsol, '$folion', '$usuario')";
			$this->EjecutaQuerySimple();
			$mensaje=array("status"=>"ok", "docf"=>$folion);	
		}else{
			$mensaje="Algo salio mal y no se pudo copiar la factura";
		}
		return $mensaje;
	}

	function unionCajas($idc){
		$usuario=$_SESSION['user']->NOMBRE;
		$idc=substr($idc, 1);
		$this->query="SELECT MAX(ID) AS ID FROM CAJAS WHERE ID IN ($idc)";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
		$cajaBase=$row->ID;
		$idcs = explode(",", $idc);

		$this->query="SELECT SUM(PAR_FACTURADAS) AS VAL FROM CAJAS WHERE ID IN ($idc)";
		$res=$this->EjecutaQuerySimple();
		$val0 = ibase_fetch_object($res);
		if($val0->VAL > 0){
			return 1;
		}

		for ($i=0; $i <count($idcs) ; $i++) { 
			$cajao=$idcs[$i];
			$this->query="UPDATE control_fact_rem SET CAJA = $cajaBase where caja = $cajao";
			$this->EjecutaQuerySimple();
			
			$this->query="UPDATE PAQUETES SET IDCAJA=$cajaBase where idcaja=$cajao";
			$res=$this->EjecutaQuerySimple();
			
			if($res >= 1){
				$this->query="INSERT INTO FTC_UNION_CAJAS (id, cajaOriginal, cajaResultante, usuario, fecha) 
				values(null, $cajao, $cajaBase, '$usuario', current_timestamp)";		
				$this->EjecutaQuerySimple();	
			}
		}
		return $cajaBase; 
	}

	function cerrarUnionCajas($idcc,$factura){
		$idcc = substr($idcc, 1);
		$idcs = explode(",", $idcc);
		for ($i=0; $i < count($idcs) ; $i++) {
			$idc = $idcs[$i];
			if($i < (count($idcs)-1)){
				$facturaU=$factura.' Union-'.$i;
			}else{
				$facturaU='';
				$facturaU=$factura;
			}
			$this->query="SELECT COUNT(PARTIDA) AS PAR FROM control_fact_rem WHERE CAJA_ORIGINAL = $idc";
			$res=$this->EjecutaQuerySimple();
			$row=ibase_fetch_object($res);
			$parFact=$row->PAR;
			//echo $this->query.'<br/>';
			$this->query="UPDATE CAJAS SET status = 'cerrado', factura = '$facturaU', PAR_FACTURADAS = $parFact where id = $idc";
			$this->EjecutaQuerySimple();
			//echo $this->query.'<br/>';
		}
		return;
	}

	function generaJson($docf, $idc){
		$usuario = $_SESSION['user']->NOMBRE;
		$tipo = 'p';
		if(gettype($idc) == 'array'){
    		$cfdiRelacionado = array("UUID"=>$idc["uuid_c"]);
			///$cfdiRelacionado = array("UUID"=>"140B3392-C8CB-4B0A-8161-D93205EB399C");
			$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
			$doc=$idc['factCancel'];
			$this->query="UPDATE FTC_FACTURAS SET STATUS = 8 WHERE DOCUMENTO = '$doc'";
			$this->EjecutaQuerySimple();
    	}elseif($idc == 'p' or $idc =='t'){
    		$tipo = $idc;
    		$this->query="SELECT IDCAJA FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
    		$res=$this->EjecutaQuerySimple();
    		$rowcaja = ibase_fetch_object($res);
    		$idc=$rowcaja->IDCAJA;
    	}

    	$this->query="SELECT * FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$nf=$docf;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$serie =$row->SERIE;
			$folio = $row->FOLIO;
			$idc =empty($row->IDCAJA)? 0:$row->IDCAJA;
		
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
			
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_FACTURAS WHERE DOCUMENTO='$docf')";
    		$rs=$this->EjecutaQuerySimple();
    		$rowc=ibase_fetch_object($rs);
    		$cliente=$rowc->CLAVE_TRIM;
    		$nombre=$rowc->NOMBRE;
    		$rfc=$rowc->RFC;

			$this->query="SELECT fd.*, f.cliente FROM FTC_FACTURAS_DETALLE fd LEFT JOIN FTC_FACTURAS F ON F.documento = fd.documento WHERE fd.DOCUMENTO = '$docf' and (fd.status= 0 or fd.status is null) and cantidad > 0"; 
			$rs=$this->EjecutaQuerySimple();
			while ($tsArray = ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
				$totalDescuento= 0; 
				$subTotal= 0;
				$totalImp1=0;
				$IEPS=0;
				$desc2=0;
				$descf=0;
				$caja = $idc;
			foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
					$cliente=trim($key->CLIENTE);
					$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
					$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
					$pC=$key->CANTIDAD;
					//$pDp=$key->DESCUENTO;
					$pS=$pP*$pC;
					$pDi=number_format($key->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
					$pImp1 = ($pS - $pDi)*$imp1; 
					$totalDescuento =$totalDescuento + $pDi;
					$subTotal =$subTotal+$pS;
					$totalImp1=$totalImp1+$pImp1;
					$totalDoc= $subTotal - $totalDescuento + $totalImp1;
					$subSat = $this->truncarNumero($subTotal,$dec,$dect);
					$totImp1Sat=number_format($totalImp1,2,".","");
			}

			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			@$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
			$res=$this->EjecutaQuerySimple();
			$cl=ibase_fetch_object($res);
					//exit($this->query);//// Insertamos la cabecera de la factura.	

					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD;
						//$pDp=$keyp->DESC1;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pS=number_format($pS, $dec,".","");
						$pDi=number_format($keyp->DESC1,2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
							$base=number_format($psubTotal-$pDi,$dec,".","");	
							$bimp=number_format($base * 0.16,$dec,".","");
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						//$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					}
					
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;

				    $this->query="SELECT * FROM CFDI01 WHERE CVE_DOC ='RF607'";
                    $a=$this->EjecutaQuerySimple();
                    $rxml=ibase_fetch_object($a);
                    $uuidr=$rxml->UUID;
					
					$cfdiRelacionado = array("UUID"=>$uuidr);
					$cfdiRelacionados=array("TipoRelacion"=>"04",
									"CfdiRelacionado"=>$cfdiRelacionado
									);
					//unset($cfdiRelacionado);/// quitar para la relacion 04;
					if($totalDescuento >0){
						if(isset($cfdiRelacionado)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    //"CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);	
						}	
					}else{
						if(isset($cfdiRelacionados)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    //"CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "I",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);					
						}
					}
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"$uso",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					//var_dump($df).'<br/>';
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);

					if($tipo == 't'){
						$ruta = "C:\\xampp\\htdocs\\Facturas\\generaJson\\";
					}else{
						$ruta = "C:\\xampp\\htdocs\\Facturas\\EntradaJson\\";
					}
					$fh = fopen($ruta.$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
					if($tipo == 'p'){
						$data = new pegaso;
						$res=$data->moverFactura($nf, $rfc=$cl->RFC);
					}
		return $cl->RFC;
    }

	function generaJsonNC($docn, $docf){
		$usuario = $_SESSION['user']->NOMBRE;

		$this->query="SELECT STATUS FROM FTC_NC WHERE DOCUMENTO = '$docn'";
		$rd=$this->EjecutaQuerySimple();
		$val0=ibase_fetch_object($rd);

		if($val0->STATUS == 7){
			$this->query="UPDATE FTC_NC SET STATUS = 1 WHERE DOCUMENTO = '$docn'";
			$this->queryActualiza();
		}else{
			return $mensaje='99';
		}
		
			$this->query="SELECT * FROM CFDI01 WHERE CVE_DOC='$docf'";
			$res=$this->EjecutaQuerySimple();
			$rowRel=ibase_fetch_object($res);

			if($rowRel){
				$uuid = $rowRel->UUID;
			}else{
				$this->query="SELECT * FROM XML_DATA WHERE SERIE||FOLIO='$docf'";
				$res=$this->EjecutaQuerySimple();
				$rowRel=ibase_fetch_object($res);
				$uuid = $rowRel->UUID;
			}

    		$cfdiRelacionado = array("UUID"=>$uuid);
			$cfdiRelacionados=array("TipoRelacion"=>"01",
									"CfdiRelacionado"=>$cfdiRelacionado
									);


    	$this->query="SELECT * FROM FTC_NC WHERE DOCUMENTO = '$docn'";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
			$mpago=$row->METODO_PAGO;
			$nf=$docn;
			$tpago = $row->FORMADEPAGOSAT;
			$uso =$row->USO_CFDI;
			$serie =$row->SERIE;
			$folio = $row->FOLIO;
			$idc =empty($row->IDCAJA)? 0:$row->IDCAJA;
		
		$mysql = new pegaso_rep;
		$dec=4; //decimales redondeados.
		$dect=2; //decimales Truncados.
		$imp1=0.16;
			
			$this->query="SELECT * FROM CLIE01 WHERE CLAVE_TRIM= (SELECT TRIM(CLIENTE) FROM FTC_NC WHERE DOCUMENTO='$docn')";
    		$rs=$this->EjecutaQuerySimple();
    		$rowc=ibase_fetch_object($rs);
    		$cliente=$rowc->CLAVE_TRIM;
    		$nombre=$rowc->NOMBRE;
    		$rfc=$rowc->RFC;

			$this->query="SELECT fd.*, f.cliente FROM FTC_NC_DETALLE fd LEFT JOIN FTC_NC F ON F.documento = fd.documento WHERE fd.DOCUMENTO = '$docn' and (fd.status= 0 or fd.status is null)"; 
			$rs=$this->EjecutaQuerySimple();
			while ($tsArray = ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
				$totalDescuento= 0; 
				$subTotal= 0;
				$totalImp1=0;
				$IEPS=0;
				$desc2=0;
				$descf=0;
				$caja = $idc;
			foreach ($data as $key) {  /// Calcula los totales pata pegarlos en la cabecera
					$cliente=trim($key->CLIENTE);
					$pPt = $this->truncarNumero($key->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
					$pP=number_format($key->PRECIO, $dec,".",""); /// Precio redondeado // $pP
					$pC=$key->CANTIDAD;
					//$pDp=$key->DESCUENTO;
					$pS=$pP*$pC;
					$pDi=number_format($key->DESC1,$dec,".","");/// Descuento por el precio por la cantidad
					$pImp1 = ($pS - $pDi)*$imp1; 
					$totalDescuento =$totalDescuento + $pDi;
					$subTotal =$subTotal+$pS;
					$totalImp1=$totalImp1+$pImp1;
					$totalDoc= $subTotal - $totalDescuento + $totalImp1;
					$subSat = $this->truncarNumero($subTotal,$dec,$dect);
					$totImp1Sat=number_format($totalImp1,2,".","");
			}

			$this->query="SELECT * FROM CAJAS WHERE ID = $idc";
			$res =$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			@$cotizacion = $row->CVE_FACT;
			//exit($this->query);//// Obtenemos los datos de la caja....
			$this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE)='$cliente'";
			$res=$this->EjecutaQuerySimple();
			$cl=ibase_fetch_object($res);
					//exit($this->query);//// Insertamos la cabecera de la factura.	

					$partida =0;
					$totalDescuento= 0; 
					$totalImp1=0;
					$IEPS=0;
					$desc2=0;
					$descf=0;
					$subTotal= 0;
					$st2=0;
					$st3=0;
					$st4=0;
					foreach ($data as $keyp ) {
						$partida += 1;
						$pPt = $this->truncarNumero($keyp->PRECIO, $dec, $dect); /// Precio Partida truncado; // $pPt
						$pP=number_format($keyp->PRECIO, $dec,".",""); /// Precio redondeado // $pP
						$pC=$keyp->CANTIDAD;
						//$pDp=$keyp->DESC1;/// Porcentaje de descuento por Partida.
						// Calculos
						$pS=$pP*$pC;
						$pS=number_format($pS, $dec,".","");
						$pDi=number_format($keyp->DESC1,2,".","");/// Descuento por el precio por la cantidad
						$pImp1 = ($pS-$pDi)*$imp1; /// Importe del Impuesto1 imp1 
						/// Totales
						$totalDescuento=$totalDescuento + $pDi;
						$psubTotal=number_format($pP*$pC,2,".","");
						$subTotal+= $pS;
						$totalImp1+=$pImp1;
						$pTotal= $psubTotal-$pDi+$pImp1;
							$base=number_format($psubTotal-$pDi,$dec,".","");	
							$bimp=number_format($base * 0.16,$dec,".","");
						$this->query="SELECT coalesce(CVE_UNIDAD, 'H87') AS CVE_UNIDAD, coalesce(CVE_PRODSERV, '40141700') AS CVE_PRODSERV,
							coalesce(UNI_MED, 'Pza') as UNI_MED  FROM INVE01 WHERE CVE_ART='$keyp->ARTICULO'";
						$resultado=$this->EjecutaQuerySimple();
						$infoprod=ibase_fetch_object($resultado);
						//$datosp = array($idviaje,'$serie'.$nf, $partida, $keyp->CANTIDAD, $keyp->DESCRIPCION, $keyp->PRECIO, $psubTotal);
						/// Base = importe para calcular el IVA 
						$impConcepto=array(
											"Base"=>"$base",
								            "Impuesto"=>"002",
								            "TipoFactor"=>"Tasa",
								            "TasaOCuota"=>"0.160000",
								            "Importe"=>"$bimp"
											);
						$trasConceptos[]=$impConcepto;
						$trasConcepto=array("Traslados"=>$trasConceptos);
						unset($trasConceptos);
						
						if($totalDescuento > 0){
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$pS",
									      "Descuento"=>"$pDi",
									      "Impuestos"=>$trasConcepto
											);
						}else{
									$concepto = array(
										  "ClaveProdServ"=> trim("$infoprod->CVE_PRODSERV"),
									      "ClaveUnidad"=> "$infoprod->CVE_UNIDAD",
									      "noIdentificacion"=> "$keyp->ARTICULO",
									      "unidad"=> "$infoprod->UNI_MED",
									      "Cantidad"=>"$keyp->CANTIDAD",
									      "descripcion"=> "$keyp->DESCRIPCION",
									      "ValorUnitario"=> "$pP",
									      "Importe"=> "$base",
									      "Impuestos"=>$trasConcepto
											);
						}
					$conceptos[]=$concepto;
					}
					$impuesto1 = array(	"Impuesto"=> "002",
									    "TipoFactor"=> "Tasa",
									    "TasaOCuota"=>"0.160000",
									    "Importe"=>"$totImp1Sat"
										);
					$Traslados=array($impuesto1);
					$imptrs="TotalImpuestosTrasladados:".$totImp1Sat;//.$IVA; 
					$imp = array(
							     "TotalImpuestosTrasladados"=>"$totImp1Sat",//"$IVA",
							 	 "Traslados"=>$Traslados);
					$impuestos = array("Impuestos"=>$imp,);
					$totSat= $subSat-$totalDescuento+$totImp1Sat;

				    if($totalDescuento >0){
						if(isset($cfdiRelacionado)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"$tpago",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "$mpago",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "$tpago",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"99",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "PUE",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "99",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Descuento"=>"$totalDescuento",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);	
						}	
					}else{
						if(isset($cfdiRelacionados)){
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"99",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "PUE",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "99",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "CfdiRelacionados"=>$cfdiRelacionados,
										    "Impuestos"=>$imp
										);
						}else{
							$datos_factura = array( 
											"Caja"=>"$idc",
											"FormaPago"=>"99",
											"Version"=>"3.3",
											"Folio"=>"$folio",
											"Serie"=>"$serie",
											"TipoCambio"=>"1.0",
											"MetodoPago"=> "PUE",
		    								"RegimenFiscal"=> "$rowDF->REGIMEN_FISCAL",
										    "LugarExpedicion"=> "$rowDF->LUGAR_EXPEDICION",
										    "Moneda"=> "MXN",
										    "TipoDeComprobante"=> "E",
										    "condicionesDePago"=> "99",
										    "SubTotal"=>"$subSat",//"$ST",
										    "Total"=>"$totSat",
										    "Impuestos"=>$imp
										);					
						}
					}
					//$nombre=utf8_encode($cl->NOMBRE);
					$nombre=utf8_decode($cl->NOMBRE);
					$json_cliente=array(
										"id"=>"$cl->CLAVE",
										"UsoCFDI"=>"G02",
										"nombre"=>"$nombre",
										"rfc"=>"$cl->RFC",
										"correo"=>"ofarias@ftcenlinea.com"
										);
					$df =array( "conceptos"=>$conceptos,
								"datos_factura"=>$datos_factura,
								"method"=>'nueva_factura', 
								"cliente"=>$json_cliente
								);
					$factura = json_encode($df,JSON_UNESCAPED_UNICODE);
					$fh = fopen("C:\\xampp\\htdocs\\Facturas\\EntradaJson\\".$nf.".json", 'w');
					fwrite($fh, $factura);
					fclose($fh);
		return $cl->RFC;
    }

	function generaCEPPago($pagos, $idCliente, $ctaO, $bancoO,$tipoO, $numope, $esPrueba=false) {
		//exit($pagos.'Cliente: '.$idCliente.' CuentaO: '.$ctaO.' Banco: '.$bancoO.',  tipo'.$tipoO);
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################

		$datosCEP = $this->obtienPagos($pagos, $idCliente, $ctaO, $bancoO, $tipoO, $numope);

		if (count($datosCEP) > 0){
			$folio = $this->generaFolioCEP();
			$conceptos = array(
                "ClaveProdServ"=>"84111506",
                "ClaveUnidad"=>"ACT",
                "Importe"=>"0",
                "Cantidad"=>"1",
                "descripcion"=>"Pago",
                "ValorUnitario"=>"0"
            );
            $datosFactura = array(
                "Serie"=>"P",
                "Folio"=>$folio,
                "Version"=>"3.3",
                "RegimenFiscal"=>"$rowDF->REGIMEN_FISCAL",
                "LugarExpedicion"=>"$rowDF->LUGAR_EXPEDICION",
                "Moneda"=>"XXX",
                "TipoDeComprobante"=>"P",
                "numero_de_pago"=>$datosCEP['aplicados'],
                "cantidad_de_pagos"=>"1"
            );
            if ($esPrueba) {
                $Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP['pagos'])); 
                $cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=>"faao790324e57",
                    "user"=>"administrador",
                    "password"=>"$9WZxo29",
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCEP['cliente'],
                    "Complementos"=>$Complementos
                  	);
            } else {
            	$totales = array(
            									"TotalTrasladosBaseIVA16"=>"0",
            									"TotalTrasladosImpuestoIVA16"=>"0",
            									"MontoTotalPagos"=>"0"
            									);
            	
            	$pagos = array("Version"=>"2.0", "Totales"=>$totales, "Pago"=>$datosCEP['pagos']);

            	//$Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP['pagos'])); 
              $Complementos[] = array("Pagos"=>$pagos); 
                $cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=>"faao790324e57",
                    "user"=>"administrador",
                    "password"=>"$9WZxo29",
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCEP['cliente'],
                    "Complementos"=>$Complementos
                );
            }
			$fileCEP = $this->generaJsonCEP($cep, $folio);	
			//$final=$this->procesaJsonCEP($fileCEP,$folio, $foliop=$pagos, $datosCEP);
			die();
		} else {
			echo "KO - Error a pantalla ...";
		}
		die();
		return $final;
	}

	function generaCEPPago_v4($pagos, $idCliente, $ctaO, $bancoO,$tipoO, $numope, $esPrueba=false) {
		//exit($pagos.'Cliente: '.$idCliente.' CuentaO: '.$ctaO.' Banco: '.$bancoO.',  tipo'.$tipoO);
		############### Traemos los datos Fiscales para la factura.##############
    	//$docu=$nfact['folioNC'];
    	$this->query="SELECT * FROM FTC_EMPRESAS WHERE ID = 1";
    	$r=$this->EjecutaQuerySimple();
    	$rowDF=ibase_fetch_object($r);
		#########################################################################

		$datosCEP = $this->obtienPagos($pagos, $idCliente, $ctaO, $bancoO, $tipoO, $numope);
		$baseT = $datosCEP['pagos'][0]['Monto'];
		$trasT = $baseT*0.16;
		if (count($datosCEP) > 0){
			$folio = $this->generaFolioCEP();
			$conceptos = array(
                "ClaveProdServ"=>"84111506",
                "ClaveUnidad"=>"ACT",
                "Importe"=>"0",
                "Cantidad"=>"1",
                "descripcion"=>"Pago",
                "ValorUnitario"=>"0",
                "ObjetoImp"=>"01"
            );

            $datosFactura = array(
                "Serie"=>"P",
                "Folio"=>$folio,
                "Version"=>"4.0",
                "RegimenFiscal"=>"$rowDF->REGIMEN_FISCAL",
                "LugarExpedicion"=>"$rowDF->LUGAR_EXPEDICION",
                "Moneda"=>"XXX",
                "TipoDeComprobante"=>"P",
                "numero_de_pago"=>$datosCEP['aplicados'],
                "cantidad_de_pagos"=>"1",
                "Exportacion"=>"01",
                "SubTotal"=>"0",
                "Total"=>"0"
            );

            if ($esPrueba) {
                $Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP['pagos'])); 
                $cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=>$row->RFC,
                    "user"=>"administrador",
                    "password"=>$rowDF->CONTRASENIA,
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCEP['cliente'],
                    "Complementos"=>$Complementos
                  	);
            } else {
            	
            	$totales = array(
            									"TotalTrasladosBaseIVA16"=>"$baseT",
            									"TotalTrasladosImpuestoIVA16"=>"$trasT",
            									"MontoTotalPagos"=>"$baseT"
            									);
            	


            	$pagos = array("Version"=>"2.0", "Totales"=>$totales, "Pago"=>$datosCEP['pagos']);

            	//$Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP['pagos']));
            	

              $Complementos[] = array("Pagos"=>$pagos ); 
            	
            	$cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=>$rowDF->RFC,//
                    "user"=>"administrador",
                    "password"=>$rowDF->CONTRASENIA,//
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCEP['cliente'],
                    "Complementos"=>$Complementos
                );
            }
			$fileCEP = $this->generaJsonCEP($cep, $folio);	
			//$final=$this->procesaJsonCEP($fileCEP,$folio, $foliop=$pagos, $datosCEP);
		} else {
			echo "KO - Error a pantalla ...";
		}
		die();
		return $final;
	}

	function obtienPagos($pagos, $idCliente, $ctaO, $bancoO, $tipoO, $numope) {
		$mysql = new pegaso;
		//$pagosId = implode(", ",$pagos);
		$pagosId = $pagos;
		if(substr($idCliente,0,1) != 'F'){
		$mysql->query  = "SELECT CP.ID, CP.CLIENTE, CP.FECHA, CP.STATUS,(SELECT C.NOMBRE FROM CLIE01 C WHERE C.CLAVE_TRIM =TRIM('$idCliente')), (SELECT C.RFC FROM clie01 C WHERE C.CLAVE_TRIM = TRIM('$idCliente')), (SELECT C.CODIGO FROM CLIE01 C WHERE C.CLAVE_TRIM =TRIM('$idCliente')), (SELECT C.SAT_REGIMEN FROM CLIE01 C WHERE C.CLAVE_TRIM =TRIM('$idCliente')) ";
		$mysql->query .= "  FROM CARGA_PAGOS CP ";		
		//$mysql->query .= " INNER JOIN CLIE01 C ";
		//$mysql->query .= "    ON CP.CLIENTE = C.CLAVE_TRIM";
		$mysql->query .= " WHERE CP.ID IN ($pagosId);";
		//echo "SQL= ".$mysql->query."\n";	
		}elseif(substr($idCliente,0,1) == 'F'){
			$ide = substr($idCliente,1);
		$mysql->query  = "SELECT * FROM FTC_ENTIDADES where id = $ide and status = 'A'";
		}
		$res = $mysql->EjecutaQuerySimple();
		$cuentaPagos = 0;		
		$cepPagos=[];
		$idPagos=[];
		while ($registro = ibase_fetch_object($res)) {
			$cuentaPagos += 1;
			$idPago = $registro->ID;
			//$cliente = $registro->CLIENTE;
			$cliente = $idCliente;
			if ($cliente==$idCliente){

				if(substr($idCliente,0,1) == 'F'){
				$idPago = $pagos;
				$nombre = $registro->NOMBRE;
				$rfc = $registro->RFC;
				$cepCliente = array(
					"id"=>$cliente,
					"UsoCFDI"=>'P01',
					"nombre"=>$nombre,
					"rfc"=>$rfc,
					"DomicilioFiscalReceptor"=>"$registro->CODIGO",
					"RegimenFiscalReceptor"=>"$registro->SAT_REGIMEN"
				);

				array_push($idPagos, $idPago);
				//echo "cliente.nombre/rfc: ".$nombre."/$rfc\n";		
				}else{
				$nombre = $registro->NOMBRE;
				$rfc = $registro->RFC;
				$cepCliente = array(
					"id"=>$cliente,
					"UsoCFDI"=>'P01',
					"nombre"=>$nombre,
					"rfc"=>$rfc,
					"DomicilioFiscalReceptor"=>"$registro->CODIGO",
					"RegimenFiscalReceptor"=>"$registro->SAT_REGIMEN"
				);
				array_push($idPagos, $idPago);
				//echo "cliente.nombre/rfc: ".$nombre."/$rfc\n";
				}	
			}
		}
		foreach($idPagos as $idPago){
			//echo "processing id: ".$idPago."\n";
			$pagosAplicados = $this->datosPago($idPago, $ctaO, $bancoO, $tipoO, $numope);
			foreach($pagosAplicados as $pa){
				array_push($cepPagos, $pa);
			}
			//array_push($cepPagos, $pagosAplicados);
			//echo "processed id: ".$idPago."\n";
		}
		$datosCEP = array (
			"cliente"=>$cepCliente,
			"pagos"=>$cepPagos,
			"aplicados"=>$cuentaPagos
		);
		return $datosCEP;
	 }

	function datosPago($pagoId, $ctaO, $bancoO, $tipoO, $numope){ 
		$mysql = new pegaso;	
			/// Validacion del Pago.
			/// Obtenemos los datos del banco ordenante
		//exit('Cuenta:'.$ctaO.' Banco: '.$bancoO.'Tipo'.$tipoO);
		$cuentaO = "";
		$rfcEmisor="";
		$bancoE="";

		if(!empty($ctaO)){
			$this->query="SELECT * FROM BANCOS_SAT WHERE clave = '$bancoO'";
			$res=$this->EjecutaQuerySimple();
			$row=ibase_fetch_object($res);
			$cuentaO=$ctaO;
			$rfcEmisor=$row->RFC;
			$bancoE=$row->BANCO;
		}
		//
		$datav=array();
		$this->query="SELECT * FROM CARGA_PAGOS WHERE ID IN ($pagoId)";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$datav[]=$tsArray;
		}		
		$v=0;
		foreach ($datav as $x) {
			$v+=$x->CEP;
			$montoPago=$x->MONTO;
			$this->query="UPDATE CARGA_PAGOS SET CEP = 999999 WHERE id IN ($x->ID)";
			$this->queryActualiza();

			$this->query="SELECT * FROM PG_BANCOS WHERE (BANCO||' - '||NUM_CUENTA) = '$x->BANCO'";
			$res=$this->EjecutaQuerySimple();
			$row1=ibase_fetch_object($res);
			$cuentaR= str_pad($row1->NUM_CUENTA,10,'0',STR_PAD_LEFT);
			$rfcBR = $row1->RFC;
		

			$mysql->query  = "SELECT A.ID, A.MONTO_APLICADO, A.FECHA, A.DOCUMENTO, A.SALDO_DOC  ";
			$mysql->query .= " FROM APLICACIONES A ";				
			$mysql->query .= " WHERE A.IDPAGO = $pagoId and A.status ='E' and (A.cancelado is null or A.cancelado =0);";
			$res = $mysql->EjecutaQuerySimple();
			
		while ($registro = ibase_fetch_object($res)){		
			$aplicaciones[]=$registro;
			
		}
		$base = 0;
		$importeP=0;
		foreach($aplicaciones as $pagoAplicado){
				$did = $pagoAplicado->DOCUMENTO;
				$montoAplicado=$pagoAplicado->MONTO_APLICADO;
				$montoSaldo=$pagoAplicado->SALDO_DOC;
				//echo "processing documento: ".$did."\n";
				$documentos = $this->datosDocumento($did, $montoAplicado, $montoSaldo, $ctaO, $bancoO, $tipoO);
				$DocsRelacionados[]=$documentos;
				$base += $montoAplicado;
				$base = number_format($base,2,".","");
				$importeP =number_format($base * 0.16,2,".","");
				
				$trasladoP=array();	

				$trasladoP[] = array(
														"BaseP"=>"$base",
														"ImpuestoP"=>'002',
														"TipoFactorP"=>'Tasa',
														"TasaOCuotaP"=>'0.160000',
														"ImporteP"=>"$importeP"
														); 
				$trasladosP = array("TrasladoP"=>$trasladoP);
				//$impuestosP = array("RetencionesP"=>$retencionesP, "TrasladosP"=>$trasladosP);
				$impuestosP = array("TrasladosP"=>$trasladosP);

				
				if($cuentaO == '' or $bancoE == '' or $rfcEmisor==''){
					$aplica= array(
						"FechaPago"=>substr($x->FECHA_RECEP,0,10).'T12:00:00',
						"FormaDePagoP"=>"$tipoO",
						"MonedaP"=>"MXN",
						"TipoCambioP"=>"1",
						"Monto"=>"$montoPago",
						"RfcEmisorCtaBen"=>"$rfcBR",
						"CtaBeneficiario"=>"$cuentaR",
						"NumOperacion"=>"1",
						"DoctoRelacionado"=>$DocsRelacionados,
						"ImpuestosP"=>$impuestosP
					);
				}else{

					if(strlen($numope) > 0){
						$aplica= array(
							"FechaPago"=>substr($x->FECHA_RECEP,0,10).'T12:00:00',
							"FormaDePagoP"=>"$tipoO",
							"MonedaP"=>"MXN",
							"TipoCambioP"=>"1",
							"Monto"=>"$montoPago",
							"RfcEmisorCtaOrd"=>"$rfcEmisor",
							"NomBancoOrdExt"=>"$bancoE",
							"CtaOrdenante"=>"$cuentaO",
							"RfcEmisorCtaBen"=>"$rfcBR",
							"CtaBeneficiario"=>"$cuentaR",
							"NumOperacion"=>"$numope",
							"DoctoRelacionado"=>$DocsRelacionados,
							"ImpuestosP"=>$impuestosP
						);
					}else{
						$aplica= array(
							"FechaPago"=>substr($x->FECHA_RECEP,0,10).'T12:00:00',
							"FormaDePagoP"=>"$tipoO",
							"MonedaP"=>"MXN",
							"TipoCambioP"=>"1",
							"Monto"=>"$montoPago",
							"RfcEmisorCtaOrd"=>"$rfcEmisor",
							"NomBancoOrdExt"=>"$bancoE",
							"CtaOrdenante"=>"$cuentaO",
							"RfcEmisorCtaBen"=>"$rfcBR",
							"CtaBeneficiario"=>"$cuentaR",
							"DoctoRelacionado"=>$DocsRelacionados,
							"ImpuestosP"=>$impuestosP
						);	
					}
					
				}
			}
			$pagos=array("Pago"=>$aplica);
		}
		if($v>0){
			//exit('Ya existe');
		}
		//exit(var_dump($datosPago));
		return $pagos;
	}

	function datosDocumento($documentoId, $montoAplicado,$montoSaldo, $ctaO, $bancoO, $tipoO){
		/*
			FOLIOS FAA y RF van sobre CFDI01 ->FACTF01  --> UUID, METODODEPAGO
			FOLIOS RFP y FP van sobre FTC_FACTURAS      --> UUID, MONEDA, FORMADEPAGOSAT
		*/
		$montoAplicado=number_format($montoAplicado,2,".","");
		$montoSaldo=number_format($montoSaldo,2,".","");
		$mysql = new pegaso;
			$mysql->query = "SELECT uuid AS UUID, metodo_pago AS METODO, moneda AS MONEDA, SERIE AS SERIE, FOLIO as folio, total as importe, subtotal, 0 as SALDOINS ";
			$mysql->query.= "  FROM ftc_facturas ";
			$mysql->query.= "  WHERE ftc_facturas.documento = '$documentoId';";
			$res = $mysql->EjecutaQuerySimple();
		
		while ($registro = ibase_fetch_object($res)){
			
			$saldoAnt=$registro->SALDOINS + $registro->IMPORTE;
      $si = number_format($registro->SALDOINS,2,".","");
      $saldoAnt=number_format($saldoAnt,2,".","");
      $imp=number_format($registro->IMPORTE,2,".","");
      /// el importe es del pago? o del documento?.
      $datosTrasDr = array();
			//$base = number_format($p->SUBTOTAL,2,".","");
			//$importeP =number_format($base * 0.16,2,".","");
			$base = number_format($imp,2,".","");
			$importeP =number_format($base * 0.16,2,".","");

			$datosTrasDr[] = array("BaseDR"=>"$base",
													"ImpuestoDR"=>'002',
													"TipoFactorDR"=>'Tasa',
													"TasaOCuotaDR"=>'0.160000',
													"ImporteDR"=>"$importeP"
													);
			$trasladoDr=array();
			$trasladoDr[] = array("TrasladoDR"=>$datosTrasDr);

			$datosRetDr=array();
			$datosRetDr[] = array("BaseDR"=>0,
													"ImpuestoDR"=>0,
													"TipoFactorDR"=>0,
													"TasaOCuotaDR"=>0,
													"ImporteDR"=>0
													);
			
			$retencionDr = array("RetencionDr"=>$datosRetDr);

			//$impDR = array("RetencionesDR"=>$retencionDr, "TrasladosDR"=>$trasladoDr);
			
			//$ImpuestosDR = array("RetencionesDR"=>$retencionDr, "TrasladosDR"=>$trasladoDr);
			$ImpuestosDR = array("TrasladosDR"=>$trasladoDr);
			$retencionP = array();
			$retencionP[] = array("ImpuestoP"=>"001",
													"ImporteP"=>"0"
													);
			$retencionesP = array("RetencionP"=>$retencionP);

			$documento = array (
				"Folio"=>"$registro->FOLIO",
				"Serie"=>"$registro->SERIE",
				"IdDocumento"=>$registro->UUID,
				"MonedaDR"=>$registro->MONEDA,
				"EquivalenciaDR"=>"1",
				"NumParcialidad"=>"1",
				"ImpSaldoAnt"=>"$montoAplicado",
				"ImpPagado"=>"$montoAplicado",
				"ImpSaldoInsoluto"=>"$montoSaldo", 
				"ObjetoImpDR"=>"02",
				"ImpuestosDR"=>$ImpuestosDR,
			);			
		}
		return $documento;
	}



	function generaJsonCEP ($datosCEP, $folio) {
		$location = "C:\\xampp\\htdocs\\Facturas\\EntradaJson\\";
		if(!file_exists($location)){
			mkdir($location,0777, true);
		}
		$json = json_encode($datosCEP, JSON_UNESCAPED_UNICODE);
		$mysql = new pegaso;
		$mysql->query = "INSERT INTO FTC_CEP VALUES (";
		$mysql->query.= "$folio, '$json', 'P');";
		$mysql->grabaBD();
		
		$nameFile = "P_".$folio;		
		$theFile = fopen($location.$nameFile.".json", 'w');
		fwrite($theFile, $json);
		fclose($theFile);
		return $nameFile;
	}

	function generaFolioCEP() {
		$mysql = new pegaso;
		$this->query = "SELECT COALESCE(MAX(COD_CEP), 0) + 1 AS FOLIO FROM FTC_CEP;";
		$res = $this->EjecutaQuerySimple();
		$record = ibase_fetch_object($res);
		return $record->FOLIO;
	}
	
	function procesaJsonCEP($nameFile, $folio, $foliop, $datosCEP) {
		$rfc=$datosCEP['cliente']['rfc'];
		$fecha = date('d-m-Y');
		$archivo=$rfc.'(P'.$folio.')'.$fecha; 
		$this->query="UPDATE CARGA_PAGOS SET CEP =$folio, ARCHIVO_CEP='$archivo' where id=$foliop";
		$this->EjecutaQuerySimple();
		
		$location = "C:\\xampp\\htdocs\\Facturas\\FacturasJson\\";
		$locationKO = "C:\\xampp\\htdocs\\Facturas\\ErroresJson\\";
		$locationOK = "C:\\xampp\\htdocs\\Facturas\\originales\\";
		$locationPegaso = "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\";		

		$espera= 3;
		sleep(3);
		$fecha = date('d-m-Y');
		while ( $espera <= 15){	
			if(file_exists($locationOK.$nameFile.".json")){   // si todo fue bien, o esta pendiente:
				$ncval = 'ok';
				sleep(2);
				copy($location.str_replace(" ","",trim($rfc))."(".$nameFile.")".$fecha.".xml", $locationPegaso.$nameFile.".xml");
				$nc= $location.str_replace(" ","",trim($rfc))."(".$nameFile.")".$fecha.".xml";
				/*
				TODO I guess you must to write here the code to invoke the other routine to create XML File
				*/
				$espera = 15;
			}elseif(file_exists($locationKO.$nameFile.".json")){
				$factura = 'error';
				$mensaje = 'Error la factura no se timbro';
				$espera = 15; 
			}
			sleep(2);
			$espera = $espera+3;
		}
		$mensaje =array("status"=>'ok',"archivo"=>$archivo);
		return $mensaje; 	
	}

	function actualizaJsonCEP($folio, $estado) {
		$mysql = new pegaso;
		$this->query = "UPDATE FTC_CEP SET cep_status = 'R' WHERE cod_cep = $folio);";		
		$this->grabaBD();
	}	

	function leeLog($fac){
		$info = array();
		$path = "C:\\xampp\\htdocs\\Facturas\\originales\\";
		$logTxt = date('Y-m-d').'-ic.log';
		$archivo = $path.$logTxt;
		$fp=fopen($archivo, "r");
		$ln=0;
		while (!feof($fp)) {
			$linea = fgets($fp);
			if(strpos($linea, "|")){
				$reg= explode("|", $linea);
				//print_r($reg);
				$ln++;
				$mensaje = str_replace("'","-", $reg[7]);
				if(strpos($mensaje, ":")){
					$mensaje = explode(":",$reg[7]);
					$mensaje = $mensaje[2];
				}
				$mensaje = str_replace("'"," ", $mensaje);
				$doc = substr($reg[3], 37);
				$doc = explode(".", $doc);
				$doc = $doc[0];
				$this->query="INSERT INTO FTC_LOG_TIMBRADO (LINEA, ID, FECHA_INICIAL, FECHA_FINAL, ORIGEN, DESTINO, XML, PDF, MENSAJE, STATUS, ARCHIVO, DOC)
												 VALUES ($ln, $reg[0], '$reg[1]', '$reg[2]', '$reg[3]', '$reg[4]', '$reg[5]', '$reg[6]', '$mensaje', 0, '$logTxt', '$doc' )";
				@$this->grabaBD();
			}
		}
		fclose($fp);
		if(!empty($fac)){
			$this->query="SELECT first 1 * FROM FTC_LOG_TIMBRADO WHERE DOC = '$fac' order by id_lt desc";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$info[] = $tsArray;
			}
			if(@count($info)>0 ){
				foreach ($info as $k){
					$msg = $k->MENSAJE;
				}
			}
		}
		return array("mensaje"=>$msg);
	}

}
