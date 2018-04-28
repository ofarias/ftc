<?php 
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';
/*Clase para hacer uso de database*/
class pegaso_ventas extends database{

	function clientes(){
		$this->query="SELECT * FROM CLIE01 WHERE STATUS = 'A'";
		$rs=$this->QueryObtieneDatosN();

		while($tsarray = ibase_fetch_object($rs)){
			$data[]=$tsarray;
		}

		return $data;
	}


	/***
     * cfa: 210316
     * consulta todas las cotizaciones registradas en la aplicación. Esta consulta es preparada para mostrar el grid 
     * en la pantalla de p.cotizacion.php
    ***/

    function consultarCotizaciones($cerradas=false){
        $usuario = $_SESSION['user']->USER_LOGIN;
        $this->query = "SELECT A.CDFOLIO as folio, A.CVE_CLIENTE as cliente, B.NOMBRE, B.RFC, A.IDPEDIDO, A.INSTATUS as estatus, EXTRACT(DAY FROM A.DTFECREG) || '/' || EXTRACT(MONTH FROM A.DTFECREG) || '/' || EXTRACT(YEAR FROM A.DTFECREG) AS FECHA,
                                        A.SERIE AS SERIE, A.FOLIO AS FOLIOL, A.DBIMPTOT AS TOTAL , B.SALDO_CORRIENTE, B.SALDO_VENCIDO, A.URGENTE,
                    (SELECT iif(COUNT(ftcd.cdfolio) is null, 0, count(ftcd.cdfolio)) from FTC_COTIZACION_DETALLE ftcd where A.cdfolio = ftcd.cdfolio) as productos,
                    (SELECT iif(count(ftcd2.cdfolio) is null,0, count(ftcd2.cdfolio)) from FTC_COTIZACION_DETALLE ftcd2
            left join inve_clib01 clib on clib.cve_prod = ('PGS')||ftcd2.cve_art
            left join ftc_cotizacion ftc on ftc.cdfolio = ftcd2.cdfolio
            left join clie01 cl on trim(cl.clave) = trim(ftc.cve_cliente)
            where (cl.addendaf = 'Complemento_Liverpool_CFDI_5v3.xml' or cl.addendaf = 'Complemento_Suburbia_CFDI_v2.xml')
                    and ftcd2.cdfolio = A.cdfolio) as skus,
                    (SELECT iif(count(ftcd2.cdfolio) is null,0, count(ftcd2.cdfolio)) from FTC_COTIZACION_DETALLE ftcd2
            left join inve_clib01 clib on clib.cve_prod = ('PGS')||ftcd2.cve_art
            left join ftc_cotizacion ftc on ftc.cdfolio = ftcd2.cdfolio
            left join clie01 cl on trim(cl.clave) = trim(ftc.cve_cliente)
            where ((cl.addendaf = 'Complemento_Liverpool_CFDI_5v3.xml' or cl.addendaf = 'Complemento_Suburbia_CFDI_v2.xml') 
                    or cl.rfc = 'SUB910603SB3' 
                    or cl.rfc = 'DLI830517184'
                   )
                    and ftcd2.cdfolio = A.cdfolio
                    and clib.camplib2 is null) as Sinskus,
            B.addendaf as addenda 
            FROM FTC_COTIZACION A 
            INNER JOIN CLIE01 B ON TRIM(A.CVE_CLIENTE) = TRIM(B.CLAVE) 
            WHERE CDUSUARI = '$usuario'";        
        $cerradas?$this->query.=" AND upper(INSTATUS) <> upper('PENDIENTE') ":$this->query.=" AND (upper(INSTATUS) = upper('PENDIENTE') or  upper(INSTATUS) = upper('LIBERADO') or upper(INSTATUS)= upper('LIBERACION') or upper(instatus) = 'RECHAZADO')";
        $this->query.=" ORDER BY CDFOLIO";
        $result = $this->QueryObtieneDatosN();
        //echo $this->query;
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }    

    function cabeceraCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, CVE_CLIENTE, NOMBRE, RFC, INSTATUS, DSIDEDOC, IDPEDIDO, EXTRACT(DAY FROM DTFECREG) || '/' || EXTRACT(MONTH FROM DTFECREG) || '/' || EXTRACT(YEAR FROM DTFECREG) AS FECHA,
                                DSPLANTA, DSENTREG, DBIMPSUB, DBIMPIMP, DBIMPTOT 
                          FROM FTC_COTIZACION A INNER JOIN CLIE01 B 
                            ON TRIM(A.CVE_CLIENTE) = TRIM(B.CLAVE)
                        WHERE CDFOLIO = '$folio'";
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }

    function detalleCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, A.CVE_ART, (B.GENERICO || B.SINONIMO|| ', '||B.CALIFICATIVO||', '||B.MARCA||', Medida:'||B.MEDIDAS) AS  DESCR, FLCANTID, DBIMPCOS, DBIMPPRE, DBIMPDES, B.CLAVE_PROD 
                          FROM FTC_COTIZACION_DETALLE A 
                        INNER JOIN FTC_Articulos B
                          ON A.CVE_ART = B.ID
                        WHERE CDFOLIO = '$folio'";
                        
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }

    function listaArticulos($cliente, $articulo, $descripcion, $partida, $folio){

            $this->query="SELECT RFC, NOMBRE FROM CLIE01 WHERE trim(CLAVE) = trim('$cliente')";
            $rs=$this->EjecutaQuerySimple();
            $row = ibase_fetch_object($rs);
            if($row->RFC == 'DLI931201MI9'){
            }
            if(!empty($descripcion)){          
                    $val = strpos($descripcion,':');

                    if($val === false){
                            $this->query = "SELECT A.*, 0 AS MARGEN_MINIMO, '' AS MARGEN_BAJO, pftc.nombre as nombre
                              FROM FTC_Articulos A 
                              left join producto_ftc pftc on pftc.clave_ftc = A.id
                              left join inve_clib01 clib on clib.cve_prod = pftc.clave
                              where (upper(pftc.NOMBRE) containing trim((upper('$descripcion'))) or upper(clib.camplib2) = upper('$descripcion'))
                              and A.status = 'A'";                                     
                        }else{
                            $a= explode(':',$descripcion);    
                            $descripcion = $a[0];
                            $this->query = "SELECT A.*, 0 AS MARGEN_MINIMO, '' AS MARGEN_BAJO, pftc.nombre as nombre
                              FROM FTC_Articulos A 
                              left join producto_ftc pftc on pftc.clave_ftc = A.id
                              where trim(upper(clave))=trim((upper('$descripcion')))
                              and A.status = 'A'";    
                        }                          
                
                $result = $this->QueryObtieneDatosN();

                if(isset($result)){
                    while ($tsArray = ibase_fetch_object($result)){
                      $data[] = $tsArray;
                    }    
                }
            }elseif(!empty($articulo)){
                        $this->query = "SELECT A.*, 0 AS MARGEN_MINIMO, '' AS MARGEN_BAJO
                              FROM FTC_Articulos A 
                              left join producto_ftc pftc on pftc.clave_ftc = A.id
                              where (upper(pftc.clave) containing upper('$articulo') or 
                                     upper(pftc.cve_prod) containing upper('$articulo'))  
                              and status = 'A'";
                $result = $this->QueryObtieneDatosN();
                if(isset($result)){
                    while ($tsArray = ibase_fetch_object($result)){
                      $data[] = $tsArray;
                    }    
                }
            }elseif(!empty($partida)){
                        $this->query = "SELECT A.*, (A.PRECIO * 1.23) AS PRECIO, ftcc.* , p.nombre as nombre, ftcc.CDFOLIO AS PARTIDA
                                          FROM FTC_Articulos A 
                                            left join FTC_COTIZACION_DETALLE ftcc on ftcc.cdfolio = $folio and ftcc.cve_art = $partida
                                            left join producto_ftc p on p.clave_ftc = $partida
                                            where ID = $partida";        
                        //echo 'Consulta nueva'.$this->query.'<p>';
                        $result = $this->QueryObtieneDatosN();
                if(isset($result)){
                    while ($tsArray = ibase_fetch_object($result)){
                      $data[] = $tsArray;
                    }    
                }
            }
            if(!isset($data)){
                $data='Alta';
                return $data;
            }
        return $data;
    }

    function articuloXcliente($cliente){
        $data=array();
        $this->query="SELECT cve_art as id, max(p.nombre) AS NOMBRE, max(p.categoria) AS CATEGORIA, max(p.precio) AS PRECIO, max(p.MARCA) AS MARCA, max(p.medidas) as medidas, max(p.COSTO_VENTAS) as costo,  0 as MARGEN_MINIMO, '' as MARGEN_BAJO
             FROM FTC_COTIZACION c
             left join FTC_COTIZACION_DETALLE d on d.CDFOLIO = c.CDFOLIO
             left join producto_ftc p on p.clave_ftc = d.cve_art
             where trim(c.cve_cliente) = trim('$cliente') and p.status = 'A' group by d.cve_art";
                $rs=$this->EjecutaQuerySimple();
                //echo $this->query;
        while ($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;

    }

    function articuloXvendedor(){
        $data=array();
        $usuario = $_SESSION['user']->NOMBRE;
        $data=array();
        $this->query="SELECT idart as id , (p.nombre) AS NOMBRE, (p.categoria) AS CATEGORIA, (p.precio) AS PRECIO, (p.MARCA) AS MARCA, (p.medidas) as medidas, (p.COSTO_VENTAS) as costo,  0 as MARGEN_MINIMO, '' as MARGEN_BAJO, (SKU) as SKU
                    FROM FTC_ART_X_CLIE f
                    left join producto_ftc p on p.clave_ftc = f.idart
                    where usuario = '$usuario' and p.status = 'A'
                    ";
        $rs= $this->EjecutaQuerySimple();
        //echo $this->query;
        while ($tsarray= ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;
    }


    function articuloXrfc($cliente){
        $data=array();
        $this->query="SELECT RFC FROM CLIE01 WHERE trim(CLAVE) = trim('$cliente')";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);

        $this->query="SELECT  d.cve_art as id , f.cot_rfc, max(p.nombre) as nombre, max(p.categoria) AS CATEGORIA, max(p.precio) AS PRECIO, max(p.MARCA) AS MARCA, max(p.medidas) as medidas, max(p.COSTO_VENTAS) as costo,  0 as MARGEN_MINIMO, '' as MARGEN_BAJO,
                (select first 1 sku_cliente from lista_de_precios where trim(cliente) = '$cliente' and producto = MAX(p.clave)) as sku_cliente,
                 (select first 1 sku_otro from lista_de_precios where trim(cliente) = '$cliente' and producto = MAX(p.clave)) as sku_otro,
                 max(INVE.CAMPLIB2) as sku
                    from ftc_cotizacion_detalle d
                    left join ftc_cotizacion f on d.cdfolio = f.cdfolio
                    left join producto_ftc p on p.clave_ftc = d.cve_art
                    left join inve_clib01 inve on inve.cve_prod = p.clave
                    where cot_rfc = '$row->RFC'
                    and p.status = 'A'
                    group by d.cve_art, f.cot_rfc
                    order by f.cot_rfc";

    /*SELECT cve_art as id, max(p.nombre) AS NOMBRE, max(p.categoria) AS CATEGORIA, max(p.precio) AS PRECIO, max(p.MARCA) AS MARCA, max(p.medidas) as medidas, max(p.COSTO_VENTAS) as costo,  0 as MARGEN_MINIMO, '' as MARGEN_BAJO, 
                max(INVE.CAMPLIB2) as sku,
                (select first 1 sku_cliente from lista_de_precios where trim(cliente) = trim('$key->CLAVE') and producto = MAX(p.clave)) as sku_cliente,
                (select first 1 sku_otro from lista_de_precios where trim(cliente) = trim('$key->CLAVE') and producto = MAX(p.clave)) as sku_otro */
        $res=$this->EjecutaQuerySimple();

        while ($tsarray = ibase_fetch_object($res)){
            $data[]=$tsarray;
        }
        return $data;
    }

    function insertaCotizacion($cliente, $identificadorDocumento){

        $usuario = $_SESSION['user']->NOMBRE;

        $this->query = "SELECT iif(MAX(cdfolio) is null, 0, max(cdfolio)) as folio FROM FTC_COTIZACION";
        $result = $this->QueryObtieneDatosN();
        $row=ibase_fetch_object($result);
        $folio=$row->FOLIO + 1;

        $user = $_SESSION['user']->USER_LOGIN;
        $this->query = "SELECT LETRA_NUEVA FROM PG_USERS WHERE USER_LOGIN = '$user'";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $letra = $row->LETRA_NUEVA;

        $this->query="SELECT COALESCE(MAX(folio),0) as folio FROM  FTC_COTIZACION WHERE SERIE = '$letra'";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $foliol = $row->FOLIO +1;
        //echo $this->query;
        //echo 'Folio Letra:'.$foliol;
        //echo 'Folio:'.$folio;
        $usuario = $_SESSION['user']->USER_LOGIN;
        $this->query = "INSERT INTO FTC_COTIZACION (CDFOLIO, CVE_CLIENTE, DSIDEDOC, DTFECREG, INSTATUS, DBIMPSUB, DBIMPIMP, DBIMPTOT, DSPLANTA, DSENTREG, CDUSUARI, FOLIO, SERIE, cve_cotizacion, vendedor, cot_rfc ) "
                . "VALUES ($folio, TRIM('$cliente'), '$identificadorDocumento', CAST('Now' as date),'PENDIENTE',0,0,0,(SELECT COALESCE(substring(CAMPLIB7 from 1 for 90), '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente')),(SELECT COALESCE(substring(CAMPLIB8 from 1 for 90), '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente')),'$usuario', $foliol, '$letra', '$letra'||'$foliol', '$usuario', (SELECT RFC FROM CLIE01 WHERE trim(CLAVE) = '$cliente'))";        
        
        $rs = $this->EjecutaQuerySimple();
       
        return $rs;
        
    }
    
    function avanzaCotizacion($folio){

        $this->query ="SELECT INSTATUS FROM FTC_COTIZACION WHERE CDFOLIO = $folio";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        $sta = $row->INSTATUS;

        if($sta == 'PENDIENTE'){
            $this->generaDocumentoCotizacion($folio);
            $this->query = "UPDATE FTC_COTIZACION SET INSTATUS = 'CERRADA' WHERE CDFOLIO = $folio";
            //echo "<br />query: ".$this->query;
            $rs = $this->grabaBD();
            return $rs;            
        }else{
            echo 'La cotizacion ya habia sido previamente liberada.';
        }

        return;

    }
    
    function generaDocumentoCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, CVE_CLIENTE, DSIDEDOC, IDPEDIDO, DBIMPSUB, DBIMPIMP, DBIMPTOT, DBIMPDES, SERIE, FOLIO FROM FTC_COTIZACION WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $existeFolio = false;
        if(count($data)>0){  
            $existeFolio =true;
            foreach ($data as $row){
                $folio = $row->CDFOLIO;
                $cliente = $row->CVE_CLIENTE;
                $letra = $row->DSIDEDOC;
                $pedido = $row->IDPEDIDO;
                $subtotal = $row->DBIMPSUB;
                $impuesto = $row->DBIMPIMP;
                $total = $row->DBIMPTOT;
                $descuento = $row->DBIMPDES;
                $docp = $row->SERIE.$row->FOLIO;
                $serie_pegaso = $row->SERIE;
            }
        }
        $serie = 'P'.substr($letra,1);
        //echo "serie: $serie";
        if(!$existeFolio){
            return NULL;
        } else {
            $usuario = $_SESSION['user']->USER_LOGIN;
            $consecutivo = $this->obtieneConsecutivoClaveDocumento($serie);
            $cve_doc = $letra.$consecutivo;
        }

        $serie='A';
        $consecutivo = 6;
        $bitacora = 123125;
        
        $insert = "INSERT INTO FACTP01 ";
        $insert.="(TIP_DOC, CVE_DOC, CVE_CLPV, STATUS, DAT_MOSTR, CVE_VEND, CVE_PEDI, FECHA_DOC, FECHA_ENT, CAN_TOT, IMP_TOT1, IMP_TOT2, IMP_TOT3, IMP_TOT4, DES_TOT, DES_FIN, COM_TOT, CONDICION, IMPORTE, CVE_OBS, NUM_ALMA, ACT_CXC, ACT_COI, NUM_MONED, TIPCAMB, ENLAZADO, TIP_DOC_E, NUM_PAGOS, FECHAELAB, SERIE, FOLIO, CTLPOL, ESCFD, CONTADO, CVE_BITA, BLOQ, DES_FIN_PORC, DES_TOT_PORC, TIP_DOC_ANT, DOC_ANT, TIP_DOC_SIG, DOC_SIG, FORMAENVIO, REALIZA)";
        $insert.="VALUES";
        $insert.="('P' ,'$docp', (SELECT CLAVE FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')), 'O' ,0,'    1', '$pedido' , CAST('Now' as date), CAST('Now' as date), $subtotal, 0, 0, 0 , $impuesto, $descuento, 0,0,'', $total, 0, 99,'S','N', 1, 1, 'O', 'O',1, CAST('Now' as date),'$serie', $consecutivo, 0, 'N', 'N','$bitacora' ,'N', 0 , 0, '', '',  '', '', 'I', '$usuario')";
        //echo "insert: ".$insert;
        $this->query = $insert;
        $rs = $this->EjecutaQuerySimple();
         
        $this->query = "SELECT CVE_ART, DBIMPCOS, FLCANTID, DBIMPPRE, DBIMPDES FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        if(count($data)>0){            
            foreach ($data as $row){
                $cve_art = $row->CVE_ART;
                $costo = $row->DBIMPCOS;
                $cantidad = $row->FLCANTID;
                $precio = $row->DBIMPPRE;
                $descuentoPartida = $row->DBIMPDES;
                $subtotalPartida = round($cantidad * $precio, 2) - round($cantidad * $descuentoPartida, 2);
                $subtotal += $subtotalPartida;                
                $descuento+= $descuentoPartida;
                $cveprov = 'Pendiente';
                $nomprov = 'Pendiente';
                $this->query="SELECT iif(CLAVE_DISTRIBUIDOR is null or clave_distribuidor ='' , '0000:pendiente', clave_distribuidor) AS CD FROM FTC_Articulos WHERE ID = $cve_art";
                $rs = $this->QueryObtieneDatosN();
                $row=ibase_fetch_object($rs);
                $prove = $row->CD;
                $prov = explode(':', $prove);
                $cveprov = $prov[0];
                $nomprov = $prov[1];

                /// INSERTAMOS DIRECTO EN PREOC01 
                $this->query = "INSERT INTO PREOC01 (COTIZA, PROD, CANTI, CANT_ORIG, COSTO, IVA, TOTAL, PROVE, CLIEN, FECHASOL, STATUS, NOM_PROV, NOM_CLI, PAR, NOMPROD, REST, docorigen, urgente, fact_ant, pedido_clie, rec_faltante, ordenado, um, importe, letra_v, status_ventas, facturado, pendiente_facturar, remisionado, pendiente_remisionar, empacado, rev_dospasos, envio, utilidad_estimada,costo_maximo )
                 VALUES ( '$docp', 'PGS$cve_art', $cantidad, $cantidad, 
                        (SELECT COALESCE(COSTO,0) FROM FTC_Articulos WHERE ID = $cve_art),
                        $impuesto, $subtotalPartida, '$cveprov',
                        (SELECT CLAVE FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')), current_date, 'P','$nomprov', 
                        (SELECT NOMBRE FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')),
                        (SELECT COALESCE(MAX(NUM_PAR), 0) FROM PAR_FACTP01 where cve_doc = '$docp') + 1,
                        (SELECT substring((GENERICO||' '||SINONIMO||' '||CALIFICATIVO||' '||MEDIDAS||' '||UM||' '||MARCA) FROM 1 FOR 255) FROM FTC_Articulos WHERE ID = $cve_art),
                        $cantidad,'NA', '', null, '$pedido', $cantidad, 0,
                        (SELECT COALESCE(UNI_MED,'pz') FROM INVE01 WHERE CVE_ART = 'PGS$cve_art'), 
                        $total, '$serie', 'Pe', 0, $cantidad, 0, $cantidad, 0, 
                        (SELECT COALESCE(rev_dospasos, 'N') FROM CARTERA WHERE TRIM(idcliente) = TRIM('$cliente')),
                        (SELECT COALESCE(ENVIO, 'Local') FROM CARTERA WHERE TRIM(idcliente) = TRIM('$cliente')),
                         0, 
                        (SELECT COALESCE(COSTO,1) FROM FTC_Articulos WHERE ID = $cve_art) * 1.2)";
                $rs=$this->EjecutaQuerySimple();
                $this->query="SELECT MAX(ID) as idp FROM PREOC01";
                $rs=$this->QueryObtieneDatosN();
                $row=ibase_fetch_object($rs);
                $idpreoc = $row->IDP;

                $actualiza = "INSERT INTO PAR_FACTP01 
                (CVE_DOC, NUM_PAR, CVE_ART,CANT, PREC, COST, IMPU1,IMPU2, IMPU3, IMPU4, IMP1APLA, IMP2APLA, IMP3APLA, IMP4APLA,TOTIMP1, TOTIMP2,TOTIMP3,TOTIMP4,DESC1,ACT_INV, TIP_CAM, UNI_VENTA,TIPO_ELEM, TIPO_PROD, CVE_OBS, E_LTPD, NUM_ALM, NUM_MOV, TOT_PARTIDA, USUARIO_PHP, IMPRIMIR, id_preoc, desc2, desc3) 
                VALUES
                ('$docp',(SELECT COALESCE(MAX(NUM_PAR), 0) FROM PAR_FACTP01 where cve_doc = '$docp') + 1,'PGS$cve_art',$cantidad,$precio,$costo,0,0,0,16,0,0,0,0,0,0,0,$impuesto,$descuentoPartida,'N',1,
                (SELECT UNI_MED FROM INVE01 WHERE CVE_ART = 'PGS$cve_art'),
                'N','P',0,0,9,NULL,($subtotalPartida),'$usuario', 'S', $idpreoc,0,0)";
                $this->query = $actualiza;
                $rs = $this->EjecutaQuerySimple();


                ///echo 'Inserta en preoc01:'.$this->query.'<p>';
                // Inserta la nueva Liberacion de los productos.
            }


            $this->query="SELECT iif(MAX(CP_FOLIO) is null, 0, max(CP_FOLIO)) AS FOLIO FROM CAJAS_ALMACEN WHERE CP_SERIE = '$serie_pegaso'";
            $rs=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($rs);
            $folio_cp_folio= $row->FOLIO + 1; 
            $caja_pegaso = 'L'.$serie_pegaso.$folio_cp_folio;


            //break;
            $this->query= "INSERT INTO CAJAS_ALMACEN (IDCA, PEDIDO, COTIZACION, VENDEDOR, PRESUP_COMPRA, PRESUP_VENTA, NUM_PROD, STATUS, FECHA_VENTAS, CCC, MAESTRO, caja_pegaso, cp_folio, cp_serie) VALUES(NULL, '$docp', $folio, '$usuario', 
                    (select sum(DBIMPCOS) from FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio),
                    (select sum(DBIMPPRE) FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO =$folio),
                    (select count(cve_art) from FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio),
                    '0',
                    current_timestamp,
                    (SELECT CCC FROM CARTERA WHERE TRIM(idcliente) = TRIM('$cliente')),
                    (SELECT CVE_MAESTRO FROM CLIE01 WHERE TRIM(clave) = Trim('$cliente')),
                    null,
                    null,
                    null
                    )";
                $rs=$this->EjecutaQuerySimple();
                //echo $this->query;
        }
        //break;
        return $rs;
    }
        
        
    function obtieneConsecutivoClaveDocumento($letra){
        $this->query = "SELECT COALESCE(MAX(FOLIO), 1)+1 FOLIO FROM FACTC01 WHERE TIP_DOC = 'C' AND SERIE = '$letra'";        
        $result = $this->QueryObtieneDatosN();
        //echo "query: ".$this->query;
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $consecutivo = 1;
        if(count($data)>0){            
           foreach ($data as $row){
                $consecutivo = $row->FOLIO;
            } 
        }
        //echo "consecutivo : $consecutivo";
        return $consecutivo;
    }
    
    function actualizaPedidoCotizacion($folio, $pedido) {

        $this->query="SELECT IIF(idPEDIDO IS NULL OR idPEDIDO = '', 'ok', idPEDIDO) as val, f.cve_cliente, cl.nombre 
                        FROM FTC_COTIZACION f
                        left join clie01 cl on trim(cl.clave) = trim(f.cve_cliente)
                         WHERE idpedido = '$pedido'";
        $rs=$this->EjecutaQuerySimple();
        $row = ibase_fetch_object($rs);

        if($row){
            echo '<label> <font color="red"> El pedido '.$row->VAL.' ya existe, para el cliente ('.$row->CVE_CLIENTE.') '.$row->NOMBRE.' , NO se permite pedidos duplicados, aun que sea para diferente cliente; favor de verificarlo. </font></label>';
        }else{    
            $this->query = "UPDATE FTC_COTIZACION SET IDPEDIDO = '$pedido' WHERE CDFOLIO = $folio";
            $rs = $this->EjecutaQuerySimple();
        }
        return $rs;
    }
            
    function cancelaCotizacion($folio){
        $this->query = "UPDATE FTC_COTIZACION SET INSTATUS = 'CANCELADA' WHERE CDFOLIO = $folio";        
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
    
    function quitarCotizacionPartida($folio, $partida) {
        $this->query = "DELETE FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio AND CVE_ART = '$partida'";        
        $rs = $this->EjecutaQuerySimple();
        $this->actualizaTotales($folio);
        return $rs;
    }
    
    function actualizaCotizacion($folio, $partida, $articulo, $precio, $descuento, $cantidad, $ida){
        //echo 'Este es el valor de la partida: '.$partida;
        if($partida != ''){
            $this->query = "UPDATE FTC_COTIZACION_DETALLE SET "
                    . " CVE_ART = '$ida', FLCANTID = $cantidad, DBIMPCOS = (SELECT costo FROM FTC_Articulos A WHERE ID = '$ida'), DBIMPPRE = $precio, DBIMPDES = $descuento "
                    . " WHERE CDFOLIO = '$folio' AND CVE_ART = '$ida'";
        } else {
            $this->query = "INSERT INTO FTC_COTIZACION_DETALLE "
                    . "(CDFOLIO,CVE_ART,FLCANTID,DBIMPPRE,DBIMPCOS,DBIMPDES)"
                    . "VALUES ('$folio','$ida',$cantidad,$precio,(SELECT costo FROM FTC_Articulos A WHERE ID = '$ida'), $descuento)";
        }        

        $rs = $this->EjecutaQuerySimple();
        $this->actualizaTotales($folio);
        return $rs;        
    }

    function actualizaTotales($folio){
        $this->query = "SELECT FLCANTID, DBIMPPRE, DBIMPDES FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $subtotal = 0;
        $impuesto = 0;
        $descuento = 0;
        $total = 0;       
        if(count($data)>0){       
            foreach ($data as $row){
                $cantidad = $row->FLCANTID;
                $precio = $row->DBIMPPRE;
                $descuentoPartida = $row->DBIMPDES;
                $desImp = round(($cantidad * $precio),2) * round(($descuentoPartida/100),4);
                $subtotalPartida = round($cantidad * $precio, 2) - round(($cantidad * $precio) * ($descuentoPartida/100), 2);
                $subtotal += $subtotalPartida;                
                $descuento+= $desImp;             
            }
            $descuento = round($descuento, 2);
            $impuesto = round(($subtotal * 0.16), 2);
            $total = round(($subtotal + $impuesto), 2);
        } 
        $this->query = "UPDATE FTC_COTIZACION SET DBIMPSUB = $subtotal, DBIMPIMP = $impuesto, DBIMPTOT = $total, DBIMPDES = $descuento "
                . " WHERE CDFOLIO = $folio";
        
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
    
    function moverClienteCotizacion($folio, $cliente){
        $this->query = "UPDATE FTC_COTIZACION SET CVE_CLIENTE = TRIM('$cliente') WHERE CDFOLIO = $folio";
        $rs = $this->EjecutaQuerySimple();      
        return $rs;        
    }
    
    function autocompletaArticulo($descripcion) {
        $this->query="SELECT DESC FROM INVE01 WHERE DESC LIKE '$descripcion%'";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray->descripcion;
        }        
        $json = json_encode($data);
        return $json;
    }
    
    function listadoClientes($clave, $cliente){
        $data = array();
        $usuario = $_SESSION['user']->USER_LOGIN;
        $select_letras = ", (SELECT COALESCE(LETRA, '') || ',' || COALESCE(LETRA2, '') || ',' || COALESCE(LETRA3, '') || ',' || COALESCE(LETRA4, '') || ',' || COALESCE(LETRA5, '') LETRAS ";
        $select_letras.= " FROM PG_USERS ";
        $select_letras.= " WHERE USER_LOGIN = '$usuario') letras";

        if($clave!=''){
            $this->query = "SELECT TRIM(cl.CLAVE) CLAVE, cl.STATUS, cl.NOMBRE, cl.RFC, cl.SALDO_VENCIDO, cl.SALDO_CORRIENTE, cl.CVE_MAESTRO ".$select_letras.", ct.plazo, ct.linea_cred, CAST(substring(clb.CAMPLIB7 from 1 for 60) AS VARCHAR(60)) as dir
                            FROM CLIE01 cl
                            LEFT JOIN cartera ct on trim(ct.idcliente) = cl.clave
                            left join CLIE_CLIB01 clb on clb.cve_clie = cl.clave 
                            WHERE (STATUS <> 'S' and status <> 'B') AND TRIM(CLAVE) = '$clave'";
        } elseif($cliente!=''){
            $this->query = "SELECT TRIM(cl.CLAVE) CLAVE, cl.STATUS, cl.NOMBRE, cl.RFC, cl.SALDO_VENCIDO, cl.SALDO_CORRIENTE, cl.CVE_MAESTRO ".$select_letras.", ct.plazo, ct.linea_cred, CAST(substring(clb.CAMPLIB7 from 1 for 60) AS VARCHAR(60)) as dir
                            FROM CLIE01 cl
                            LEFT JOIN cartera ct on trim(ct.idcliente) = cl.clave
                            left join CLIE_CLIB01 clb on clb.cve_clie = cl.clave 
                            WHERE upper(NOMBRE) LIKE upper('%$cliente%') AND (STATUS <> 'S' and status <> 'B')";
        } else {
            return $data;
        }
        $result = $this->QueryObtieneDatosN();  
        //echo $this->query;
        //break;
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        return $data;
    }

    function listadoLetras() {
        $usuario = $_SESSION['user'];
        $this->query = "SELECT COALESCE(LETRA, '') || ',' || COALESCE(LETRA2, '') || ',' || COALESCE(LETRA3, '') || ',' || COALESCE(LETRA4, '') || ',' || COALESCE(LETRA5, '') LETRAS";
        $this->query .= " FROM PG_USERS ";
        $this->query .= " WHERE USER_LOGIN = '$usuario'";
        $data = array();
        $result = $this->QueryObtieneDatosN();        
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $letras = "";
        if(count($data)>0){            
            foreach ($data as $row){
                $letras = $row->LETRAS;
            }
        } 
        $myArray = explode(',', $letras);
        print_r($myArray);
        return $myArray;
    }
    
////// FINALIZA COTIZACION CFA- 
    
///// Modulo de productos almacen 10.
    function VerCat10($alm){
    	$prod="SELECT * from PRODUCTOS WHERE ACTIVO = 'S'";
    	$this->query=$prod;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
/*
    function EditProd($id){
    	$this->query="SELECT * from PRODUCTOS where id =$id";
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
*/

    function traeMarcas(){
        $this->query="SELECT * FROM MARCAS WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;
    }

    function traeMarcasT(){
        $this->query="SELECT * FROM MARCAS WHERE STATUS <> 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;
    }


    function traeProveedores(){
        $this->query="SELECT * FROM PROV01 WHERE STATUS = 'A'";
        $rs=$this->QueryDevuelveAutocomplete();          
        return @$rs;
    }
    function traeProductos(){
        $this->query="SELECT fart.*, ct.id as idc FROM FTC_Articulos fart
                    left join CATEGORIAS ct ON  ct.nombre_categoria = fart.categoria where fart.status = 'A'";
        $rs=$this->QueryObtieneDatosN();

        while($tsarray = ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;
    }

      function traeProductosFTC($descripcion){
        $COMPLETO = false;
        if(strpos($descripcion, ' ')){
            $desc2 = explode(' ', $descripcion);
            $contado  = count($desc2);
            for($i = 0; $i < $contado; $i++){
                $COMPLETO = $COMPLETO." AND nombre containing('".$desc2[$i]."') ";
            }
        }else{
            $COMPLETO = " and nombre containing ('".$descripcion."')";
        }
        //$this->query = "INSERT INTO DICCIONARIO (ID, PALABRA)"
        $this->query="SELECT pftc.* FROM producto_ftc pftc left join FTC_Articulos ftca on ftca.id = pftc.clave_ftc where ftca.status = 'A' $COMPLETO";
        //echo $this->query;
        $rs=$this->QueryDevuelveAutocompletePFTC();

        return @$rs;
    }

    function traeCategorias(){
        $this->query="SELECT * FROM CATEGORIAS WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;   
    }

    function traeCategoriasT(){
        $this->query="SELECT * FROM CATEGORIAS where (status = 'P' or status ='B')";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;   
    }

    function traeLineas(){
        $this->query="SELECT * FROM LINEAS WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;   
    }

    function traeUM(){
        $this->query="SELECT * FROM UM WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;   
    }

    function traeMarcasxCat(){
        $this->query="SELECT mxc.id, mxc.idmarca, mc.clave_marca as Marca, cat.id, cat.nombre_categoria as categoria from marcas_x_categoria mxc
                        left join marcas mc on mxc.idmarca = mc.id
                        left join categorias cat on mxc.idcat = cat.id
                        order by mc.clave_marca asc";
        $rs=$this->QueryObtieneDatosN();
        while ($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return @$data;
    }

    function traeProducto($ids){
        $this->query="SELECT * FROM FTC_Articulos  WHERE ID = $ids";
        $rs=$this->QueryObtieneDatosN();

        while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;
    }

   

    function traeCliente($aguja, $ids){
        $this->query="SELECT cl.clave, cl.nombre, cl.calle, cl.colonia, cl.numext, fac.*  
                        FROM CLIE01 cl 
                        left join FTC_ART_X_CLIE fac on fac.idclie = cl.clave and fac.idart = $ids 
                        WHERE (clave containing ('$aguja') or nombre containing ('$aguja'))";

        $res=$this->QueryObtieneDatosN();

            while($tsarray=ibase_fetch_object($res)){
            $data[]=$tsarray;
        }
        return @$data;
    }

    function traeProveedor($aguja, $ids){
        $this->query="SELECT p.CLAVE, p.NOMBRE, p.CALLE, p.NUMEXT, p.COLONIA, fap.*
                        FROM PROV01 p
                        left join FTC_ART_X_PROV fap on fap.idprov = p.clave and idart = $ids 
                        WHERE (clave containing ('$aguja') or nombre containing ('$aguja'))";
        $res=$this->QueryObtieneDatosN();

            while ($tsarray=ibase_fetch_object($res)){
                    $data[]=$tsarray;
                }
            return @$data;
    }


    function insertaSol($categoria, $descripcion, $marca, $cotizacion, $cliente, $unidadmedida,$empaque, $cantsol){
    //( $categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $cotizacion, $cliente){

        $user= $_SESSION['user']->NOMBRE;

        $this->query="SELECT mxc.id, mxc.idmarca, mc.clave_marca as Marca, cat.id, cat.nombre_categoria as categoria 
                      from marcas_x_categoria mxc
                      left join marcas mc on mxc.idmarca = mc.id
                      left join categorias cat on mxc.idcat = cat.id
                      where mxc.id = $categoria
                      order by mc.clave_marca asc";
        $res=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($res);
        $categoria = $row->CATEGORIA;
        $marca = $row->MARCA;

        $this->query="INSERT INTO FTC_Articulos (id,categoria, generico, marca, cotizacion, vendedor, STATUS, um, empaque, cantsol) VALUES(null,'$categoria', '$descripcion', '$marca', $cotizacion, '$user', 'P', '$unidadmedida', $empaque, $cantsol)";
        //(NULL, '$linea', '$categoria', '$generico', '$sinonimos', '$calificativo', '$medidas', Null, '$marca', '$unidadmedida', $empaque, '$prov1', '$codigo_prov1', '$sku', $costo_prov, 0, 0, 0,'P','$user',$cotizacion)
        $rs=$this->EjecutaQuerySimple();
        
        //echo $this->query;
        return;
    }


    function usuariosCompras(){
        $this->query="SELECT * FROM PG_USERS WHERE USER_ROL = 'compras'";
        $rs=$this->QueryObtieneDatosN();

        while ($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }

        return @$data;
    }


    function altaCategoria($nombreCategoria, $abreviatura, $responsable, $status){
        $this->query="INSERT INTO CATEGORIAS VALUES (NULL, '$nombreCategoria', '$abreviatura', '$responsable', 0, '$status' )";
        $rs=$this->EjecutaQuerySimple();
        //echo $this->query;
        return;
    }

    function editaCategoria($idcat){
        $this->query="SELECT * FROM CATEGORIAS WHERE ID =$idcat";
        $rs=$this->QueryObtieneDatosN();
        while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return @$data;
    }

    function editarCategoria($nombreCategoria, $abreviatura, $responsable, $status, $idcat){
        $this->query="UPDATE CATEGORIAS SET abreviatura ='$abreviatura', responsable='$responsable', status ='$status' where id = $idcat";
        $rs=$this->EjecutaQuerySimple();

        return;
    }

    function altaMarca($cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d){

        echo 'Valor de cm antes de entities: '.$cm.'<p>';
        $cm = htmlentities(strtoupper($cm),ENT_QUOTES);
        $nc = strtoupper($nc);
        $rz = strtoupper($rz);
        echo 'Valor de cm despues de entities:'.$cm.'<p>';


        $this->query="INSERT INTO MARCAS VALUES(NULL, '$cm', '$nc', '$rz', '$dir', '$tel', '$cont', '$s', $p, 'Nuevo', '$d')";
        $rs=$this->EjecutaQuerySimple();

        //echo $this->query;
        //break;
        return;
    }

    function editaMarca($idm){
        $this->query="SELECT * FROM MARCAS WHERE ID = $idm";
        $rs=$this->QueryObtieneDatosN();

        while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return @$data;
    }

    function editarMarca($idm, $cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d){
        $this->query="UPDATE MARCAS SET NOMBRE_COMERCIAL = '$nc', RAZON_SOCIAL = '$rz', DIRECCION = '$dir', TELEFONO='$tel', CONTACTO='$cont', status ='$s', revision = '$p', dia_rev = '$d'  WHERE ID = $idm";
        $rs=$this->EjecutaQuerySimple();
        return;
    }

    function categoriaxMarca($idcat){
        $this->query="SELECT m.* FROM MARCAS m
                      INNER JOIN MARCAS_X_CATEGORIA mxc on mxc.idmarca = m.id
                      WHERE mxc.idcat = $idcat";
        $rs=$this->QueryObtieneDatosN();
        //echo $this->query;

        if(isset($rs)){
            while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
            }    
        }else{
            $data='N';
        }
        return @$data;
    }

    function verCategoria($idcat){
        $this->query = "SELECT * FROM CATEGORIAS WHERE ID = $idcat";
        $rs=$this->QueryObtieneDatosN();
        while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;
    }

    function buscaMarca($marca, $idcat){
        $this->query="SELECT m.*, mxc.idcat FROM MARCAS m
                      left join MARCAS_X_CATEGORIA mxc on mxc.idmarca = m.id and (mxc.idcat = $idcat or mxc.idcat is null)
                      WHERE upper(m.CLAVE_MARCA) containing upper('$marca') or upper(m.NOMBRE_COMERCIAL) containing upper('$marca')
                      ";
        $rs =$this->QueryObtieneDatosN();

        while($tsarray = ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        //echo $this->query; 
        return @$data;
    }

    function asignarMarca($idcat, $idmca){
        $usuario =$_SESSION['user']->NOMBRE;
        $this->query = "INSERT INTO MARCAS_X_CATEGORIA VALUES(NULL, $idcat, $idmca, current_timestamp, '$usuario', null )";
        $rs=$this->EjecutaQuerySimple();
        echo $this->query;
        //break;
        return;
    }

    function desasignarMarca($idcat, $idmca){
        $usuario =$_SESSION['user']->NOMBRE;
        $this->query = "DELETE FROM MARCAS_X_CATEGORIA WHERE idcat = $idcat and idmarca = $idmca";
        $rs=$this->EjecutaQuerySimple();
        return;   
    }

    function proveedorXproducto($ids, $idprov, $pieza, $empaque, $pxp, $empaque2, $pxp2, $urgencia, $entrega, $recoleccion, $efectivo, $cheque, $credito, $costo, $costo2){
        $usuario=$_SESSION['user']->NOMBRE;

        $this->query = "SELECT ID FROM FTC_ART_X_PROV WHERE idart = $ids and idprov = '$idprov'";
        $res = $this->QueryObtieneDatosN();
        $row = ibase_fetch_object($res);


        if($row == true){
            $this->query="UPDATE FTC_ART_X_PROV SET pieza = '$pieza', empaque ='$empaque', pza_x_empaque= $pxp, empaque_2='$empaque2', pza_x_empaque2 = $pxp2, urgencia = '$urgencia', entrega = '$entrega', recoge = '$recoleccion', efectivo ='$efectivo', cheque='$cheque', credito = '$credito', costo = $costo, costo2=$costo2 where idart = $ids and idprov = '$idprov'";
        $rs=$this->EjecutaQuerySimple(); 
        echo 'Actualiza: '.$this->query;
        }else{
            $this->query="INSERT INTO FTC_ART_X_PROV (ID, IDART, IDPROV, FECHA_ASOC, USUARIO, PIEZA, PIEZAS, EMPAQUE, PZA_X_EMPAQUE, EMPAQUE_2, PZA_X_EMPAQUE2, URGENCIA, ENTREGA, RECOGE, EFECTIVO, CHEQUE, CREDITO, costo , costo2) 
                VALUES (NULL, $ids, '$idprov', current_timestamp, '$usuario', '$pieza', 0, '$empaque', $pxp, '$empaque2', $pxp2, '$urgencia', '$entrega', '$recoleccion', '$efectivo', '$cheque', '$credito', 0, 0)";
        $rs=$this->EjecutaQuerySimple();
        echo 'Inserta: '.$this->query;            
        }
       // break;

        return;    
    } 

    function clienteXproducto($idclie, $ids, $sku, $skuFact, $listaCliente, $correo, $precio){
        $usuario = $_SESSION['user']->NOMBRE;

        $this->query ="SELECT ID FROM FTC_ART_X_CLIE WHERE idart = $ids and idclie = '$idclie'";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);

        if($row == true){
            $this->query="UPDATE FTC_ART_X_CLIE SET sku = '$sku', sku_Factura = '$skuFact', lista_Cliente='$listaCliente', correo = '$correo', precio = $precio , ultima_modificacion = current_timestamp, usuario_modifica = '$usuario' where idclie = '$idclie' and idart = $ids ";
            $this->EjecutaQuerySimple();

        }else{
            $this->query="INSERT INTO FTC_ART_X_CLIE (ID, IDCLIE, IDART, SKU, SKU_FACTURA, CORREO, LISTA_CLIENTE, USUARIO, ASOCIACION, precio) 
                            VALUES (NULL, '$idclie', $ids, '$sku', '$skuFact',  '$correo', '$listaCliente', '$usuario', current_timestamp, $precio)";
            $rs=$this->EjecutaQuerySimple();
            //echo $this->query;
        }
        return; 
    }


    function parCotSMB($folio, $partida, $por2){
        $this->query="UPDATE FTC_COTIZACION_DETALLE SET MARGEN_BAJO = 'Si', MARGEN_MINIMO = 0, UTILIDAD = $por2 WHERE CDFOLIO = $folio and CVE_ART = $partida";
        $rs=$this->EjecutaQuerySimple();
        //echo $this->query;
        //break;
        return;
    }

    function verSMB(){
        $this->query="SELECT * 
                        FROM FTC_COTIZACION_DETALLE ftcc
                        LEFT JOIN FTC_COTIZACION ftc on ftc.CDFOLIO = ftcc.CDFOLIO
                        LEFT JOIN CLIE01 cl on trim(cl.clave) = trim(ftc.cve_cliente)
                        LEFT JOIN FTC_Articulos ftca on ftca.id = ftcc.cve_art
                        WHERE MARGEN_BAJO = 'Si' and MARGEN_MINIMO = 0";
        $rs=$this->QueryObtieneDatosN();

        while ($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return @$data;
    }

    function autMB($folio, $partida, $utilAuto, $precio){

        $this->query="UPDATE FTC_COTIZACION_DETALLE SET DBIMPPRE = $precio,  MARGEN_MINIMO = $utilAuto where CDFOLIO = $folio and CVE_ART = $partida";
        $rs=$this->EjecutaQuerySimple();

        echo $this->query;
        $this->query="SELECT * FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio";
        $rs=$this->EjecutaQuerySimple();
                while($tsarray=ibase_fetch_object($rs)){
                    $data[]=$tsarray;
                }
                $subtotal = 0;
                $iva = 0;
                $total = 0;
                $descuento = 0;
                $costo = 0;
                $i = 0;
                foreach ($data as $key) {
                    $i = $i +1;
                    $subtotal = $subtotal + ($key->DBIMPPRE * $key->FLCANTID);
                    $descuento = $descuento + ($key->DBIMPPRE * (($key->DBIMPDES/100) * $key->FLCANTID));
                    $costo = $costo + $key->DBIMPCOS;
                }
                $iva = ($subtotal - $descuento ) *.16 ; 
                $total = ($subtotal - $descuento ) * 1.16;
                $this->query="UPDATE FTC_COTIZACION SET DBIMPSUB = $subtotal, DBIMPDES = $descuento, DBIMPIMP = $iva, DBIMPTOT = $total where CDFOLIO = $folio";
                $this->EjecutaQuerySimple();

        //echo $this->query;
        return;
    }

    function marcarUrgente($folio){
        $this->query="UPDATE FTC_COTIZACION SET URGENTE = 'Si' where cdfolio = $folio ";
        $rs=$this->EjecutaQuerySimple();

        return;
    }

    function solLiberacion($folio, $cliente){
        $this->query="UPDATE FTC_COTIZACION SET INSTATUS='LIBERACION' WHERE CDFOLIO = $folio";
        $rs =$this->EjecutaQuerySimple();

        return;
    }

    function verSKUS($cliente, $cdfolio){
        $this->query="SELECT ftcd.cdfolio AS FOLIO, cl.nombre, pftc.nombre as descripcion, cl.clave as cliente, 
                iif(icl.camplib2 is null or icl.camplib2 = '', (select sku from lista_de_precios where trim(cliente) = '$cliente' and producto = ('PGS'||ftcd.cve_art)), icl.camplib2 ) AS SKU, 
                    ftcd.cve_art, (ftcc.serie||ftcc.folio) as cotiza,
                    (select first 1 sku_cliente from lista_de_precios where trim(cliente) = '$cliente' and producto = ('PGS'||ftcd.cve_art)) as SKU_CLIENTE, 
                    (select  first 1 sku_otro from lista_de_precios where trim(cliente) = '$cliente' and producto = ('PGS'||ftcd.cve_art)) as SKU_OTRO
                 FROM FTC_COTIZACION_DETALLE ftcd
                 left join inve_clib01 icl on icl.cve_prod = ('PGS'||ftcd.cve_art)
                 left join producto_ftc pftc on pftc.clave_ftc = ftcd.cve_art
                 left join ftc_cotizacion ftcc on ftcc.cdfolio = $cdfolio
                 left join clie01 cl on trim(cl.clave) = trim(ftcc.cve_cliente)
                  WHERE ftcd.CDFOLIO = $cdfolio";
        $rs=$this->EjecutaQuerySimple();

        //echo $this->query;
        while($tsarray=ibase_fetch_object($rs)){
            $data[]=$tsarray;
        }
        return $data;
    }

    function guardaSKU($producto, $sku, $cliente, $cdfolio, $nombre, $descripcion, $cotizacion, $sku_cliente, $sku_otro){
        
        $usuario=$_SESSION['user']->NOMBRE;

        $this->query="SELECT iif(count(cve_prod) =0 , 'No', 'Si') as VALIDACION from inve_clib01 where cve_prod = '$producto'";
        $rs=$this->EjecutaQuerySimple();
        $row = ibase_fetch_object($rs);
        $existe = $row->VALIDACION;

        if($existe == 'Si'){

            $this->query="SELECT ADDENDAF FROM CLIE01 WHERE CLAVE = '$cliente'";
            $rs=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($rs);

            
            if($row->ADDENDAF <> '' OR !empty($row->ADDENDAF)){     
                $this->query="UPDATE inve_clib01 SET camplib2='$sku' where cve_prod = '$producto'";
                $rs=$this->EjecutaQuerySimple();
            }

        }elseif($existe == 'No'){
            $this->query="INSERT INTO inve_clib01 (CVE_PROD, CAMPLIB2, CAMPLIB7) 
                                    VALUES('$producto', '$sku',substring((select nombre from producto_ftc where clave = '$producto') from 1 for 35))";
            $this->EjecutaQuerySimple();
            //echo $this->query;
        }

        $this->query="SELECT count(id) as actualiza from lista_de_precios where producto = '$producto' and cotizacion = '$cotizacion'";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);

            if($row->ACTUALIZA  == 0){    
                    $this->query="INSERT INTO LISTA_DE_PRECIOS (ID, CLIENTE, NOMBRE, PRODUCTO, DESCRIPCION, COTIZACION, USUARIO, FECHA, sku, sku_cliente, sku_otro)
                                        VALUES (NULL, '$cliente', '$nombre', '$producto', '$descripcion', '$cotizacion', '$usuario', current_timestamp, '$sku', '$sku_cliente', '$sku_otro' )";
                    $this->EjecutaQuerySimple();
            }else{
                    $this->query="UPDATE LISTA_DE_PRECIOS SET SKU = '$sku', SKU_CLIENTE='$sku_cliente', SKU_OTRO = '$sku_otro' where producto = '$producto' and cotizacion = '$cotizacion'";
                    $this->EjecutaQuerySimple();
            }

        return;
    }

    function copiarCotizacion($cotizacion){
        $serie = substr($cotizacion, 0,1);
        $folio = substr($cotizacion, 1,10);
        $response = array('status'=>'no','numeroCliente'=>'no','cliente'=>'no', 'monto'=>'no', 'fecha'=>'no');
        $this->query="SELECT ftc.*, cl.nombre as cliente FROM FTC_COTIZACION ftc left join clie01 cl on trim(cl.clave) = trim(ftc.cve_cliente) WHERE folio = $folio and serie = '$serie' ";
        $rs=$this->EjecutaQuerySimple();
        $row = ibase_fetch_object($rs);

        if(!empty($row)){
            $nro_cliente = $row->CVE_CLIENTE;
            $cliente = $row->CLIENTE;
            $fecha = $row->DTFECREG;
            $monto = $row->DBIMPTOT;
          $response = array('status'=>'ok', 'numeroCliente'=>$nro_cliente, 'cliente'=>$cliente, 'monto'=>$monto, 'fecha'=>$fecha);
        }
         return $response;
    }

    function copiar($cotizacion){

        $response= array('status'=>'error', 'nueva'=>'error', 'productos'=>0);

        $serie = substr($cotizacion, 0,1);
        $folio = substr($cotizacion, 1, 10);
        $usuario = $_SESSION['user']->NOMBRE;
        $cdusuari = $_SESSION['user']->USER_LOGIN;

        $this->query="SELECT * FROM FTC_COTIZACION WHERE FOLIO = $folio and serie = '$serie'";
        $rs=$this->EjecutaQuerySimple();
        $row = ibase_fetch_object($rs);
        
        //echo 'Seleccion de cotizacion'.$this->query.'<p>';

        $this->query="SELECT MAX(CDFOLIO) AS folioa FROM FTC_COTIZACION";
        $res=$this->EjecutaQuerySimple();
        $row2 = ibase_fetch_object($res);
        $folion = $row2->FOLIOA + 1;

        //echo 'Seleccion de nuevo folio'.$this->query.'<p>';

        $this->query="SELECT LETRA_NUEVA FROM PG_USERS WHERE NOMBRE = '$usuario'";
        $resp=$this->EjecutaQuerySimple();
        $row3 = ibase_fetch_object($resp);
        $serieletra = $row3->LETRA_NUEVA;

        //echo 'Seleccion de letra'.$this->query.'<p>';

        $this->query="SELECT MAX(FOLIO) AS FOLIO FROM FTC_COTIZACION WHERE SERIE = '$row3->LETRA_NUEVA'";
        $respuesta = $this->EjecutaQuerySimple();
        $row4 = ibase_fetch_object($respuesta);
        $folioletra = $row4->FOLIO + 1;

        //echo 'Seleccion de nuevo folio por letra'.$this->query.'<p>';

        if(empty($row->DBIMPDES)){
            $dbimpdes = 0;
        }else{
            $dbimpdes = $row->DBIMPDES;
        }

        $this->query="INSERT INTO FTC_COTIZACION VALUES($folion, '$row->CVE_CLIENTE', '$row->DSIDEDOC', '$row->IDPEDIDO', current_date, '$cdusuari', '$row->DSPLANTA', $dbimpdes,
        '$row->DSENTREG', 'PENDIENTE', $row->DBIMPSUB, $row->DBIMPIMP, $row->DBIMPTOT, ('$row->CVE_COTIZACION'||'-2'), null, $folioletra, '$serieletra', 'No', null, null)";
        $respuesta1=$this->grabaBD();

        //echo 'inserta cotizacion '.$this->query.'<p>';
        $i= 0;
        if($respuesta1){
                $this->query="SELECT * FROM FTC_COTIZACION_DETALLE WHERE cdfolio = $row->CDFOLIO";
                $result = $this->EjecutaQuerySimple();

            //echo 'Obtenemos las partidas'.$this->query.'<p>';

                while ($tsarray=ibase_fetch_object($result)){
                    $data[]=$tsarray;
                }

                foreach ($data as $key){
                    $i=$i+1;
                    $this->query="INSERT INTO FTC_COTIZACION_DETALLE VALUES($folion, '$key->CVE_ART', $key->FLCANTID, $key->DBIMPPRE, $key->DBIMPCOS, $key->DBIMPDES, null, null,null)";
                    $this->grabaBD();
                }
            $response=array('status'=>'ok', 'nueva'=>$serieletra.$folioletra, 'productos'=>$i);

        }
        return $response;
    }


    function guardaPartida($producto, $cotizacion, $tipo, $cantidad, $precio, $descuento, $mb, $mm, $costo){
        $response  = array('status'=>'no');

        if($tipo == 'g'){
            $this->query="SELECT * FROM producto_ftc WHERE CLAVE_FTC = '$producto' and status = 'A'";
            $rs=$this->EjecutaQuerySimple();
            $row= ibase_fetch_object($rs);

            if($row){
                $this->query="INSERT INTO FTC_COTIZACION_DETALLE VALUES($cotizacion, $producto, $cantidad, $precio, $costo, $descuento, $mb, $mm, 0  )";
                $this->EjecutaQuerySimple();
                //echo $this->query;
                $response=array('status'=>'ok');
            }    
        }elseif($tipo == 'e'){
            $this->query="DELETE FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $cotizacion and cve_art = $producto";
            $res=$this->EjecutaQuerySimple();
            //echo $this->query;
            if($res){
                $response=array('status'=>'ok');
            }
        }elseif ($tipo == 'gd'){

            $prod = explode(':', $producto);
            $producto = trim($prod[0]);
            $this->query="SELECT * FROM FTC_Articulos WHERE ('PGS'||ID) = '$producto'";    
            $rs=$this->EjecutaQuerySimple();
            $row = ibase_fetch_object($rs);
        
            $precio = $row->COSTO * 1.23;
            $costo = $row->COSTO;

            $this->query="INSERT INTO FTC_COTIZACION_DETALLE VALUES($cotizacion, substring('$producto' from 4 for 10 ) , 1, $precio, $costo, 0, 0, 0, 0)";
            $res=$this->EjecutaQuerySimple();

            if($res){
                $response = array('status'=>'ok');
            }
        }
        
        $this->query="SELECT * FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $cotizacion";
        $rs=$this->EjecutaQuerySimple();
                while($tsarray=ibase_fetch_object($rs)){
                    $data[]=$tsarray;
                }
                $subtotal = 0;
                $iva = 0;
                $total = 0;
                $descuento = 0;
                $costo = 0;
                $i = 0;
                foreach ($data as $key) {
                    $i = $i +1;
                    $subtotal = $subtotal + ($key->DBIMPPRE * $key->FLCANTID);
                    $descuento = $descuento + ($key->DBIMPPRE * (($key->DBIMPDES/100) * $key->FLCANTID));
                    $costo = $costo + $key->DBIMPCOS;
                }
                $iva = ($subtotal - $descuento ) *.16 ; 
                $total = ($subtotal - $descuento ) * 1.16;
                $this->query="UPDATE FTC_COTIZACION SET DBIMPSUB = $subtotal, DBIMPDES = $descuento, DBIMPIMP = $iva, DBIMPTOT = $total where CDFOLIO = $cotizacion";
                $this->EjecutaQuerySimple();
                //echo 'Partidas contabilizadas: '.$i.'<p> Consulra de Actualizacion: '.$this->query;
        return $response;
    }

    function solicitarMargenBajo($cotizacion, $partida){
        $this->query="SELECT F.*, pftc.nombre, ftcc.cve_cliente, ftcc.idpedido, cl.nombre as cliente, pftc.COSTO_VENTAS
                            FROM FTC_COTIZACION_DETALLE F
                            left join PRODUCTO_FTC pftc on pftc.clave_ftc = $partida 
                            left join FTC_COTIZACION ftcc on ftcc.CDFOLIO = $cotizacion
                            left join clie01 cl on cl.clave  = ftcc.cve_cliente
                            WHERE F.CDFOLIO = '$cotizacion' and F.cve_art = $partida";
        $rs=$this->EjecutaQuerySimple();
        //echo $this->query;
        while($tsArray = ibase_fetch_object($rs)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function cajas($tipo, $var, $mes, $anio){

        if($tipo == 1){
            $usuario=$_SESSION['user']->USER_LOGIN;
            $this->query="SELECT count(cotiza), extract(month from fechasol) as mes,
                        max(extract(year from fechasol)) as anio
                        from preoc01
                        where fechasol >= '01.08.2017'
                        and status <> 'P' 
                        and status <> 'R'
                        and cotiza starting 
                            with (select letra_nueva from pg_users where  USER_LOGIN='$usuario')
                        group by
                            extract(month from fechasol),
                            extract(year from fechasol)
                        order by
                             extract(year from fechasol) asc,
                            extract(month from fechasol) asc";
            $rs=$this->EjecutaQuerySimple();
            while ($tsarray=ibase_fetch_object($rs)) {
            $data[]=$tsarray;
            }

            foreach ($data as $key) {
                $this->query="SELECT cotiza
                            FROM PREOC01
                            WHERE
                            EXTRACT(MONTH FROM FECHASOL)= $key->MES
                            AND EXTRACT(YEAR FROM FECHASOL)= $key->ANIO
                            and cotiza starting with (select letra_nueva from pg_users where USER_LOGIN='$usuario')
                            and status <> 'P'
                            and status <> 'R'
                            group by cotiza";
                $rs=$this->EjecutaQuerySimple();
                while ($tsarray=ibase_fetch_object($rs)) {
                    $data2[]=$tsarray;
                }

            //// ananlisis de cajas inconclusas.
                     $this->query="SELECT cotiza, extract(month from fechasol) as mes
                        from preoc01
                        where extract(month from fechasol) = $key->MES
                        and extract(year from fechasol)=$key->ANIO
                        and cotiza starting with (select letra_nueva from pg_users where  USER_LOGIN='$usuario')
                        and status <> 'R'
                        and status <> 'P'
                        group by
                            cotiza,
                            extract(month from fechasol)
                        order by
                            extract(month from fechasol)";
                        $rs=$this->EjecutaQuerySimple();

                        while ($tsarray=ibase_fetch_object($rs)) {
                            $data3[]=$tsarray;
                        }
                        $pendiente = 0;
                        $subtotal = 0;
                        foreach ($data3 as $key2){
                                $cotizacion = $key2->COTIZA;
                                $this->query="SELECT sum(cant_orig) as Original, sum(recepcion) as recibido, sum(empacado) as empacado, datediff(day from max(fechasol) to current_date) as dias, max(par) as partidas, sum(total) as subtotal
                                    from preoc01  
                                    where cotiza ='$key2->COTIZA'";
                                    //echo $this->query.'<br/><br/>';
                                    $res=$this->EjecutaQuerySimple();
                                    $row3=ibase_fetch_object($res);

                                    $original = $row3->ORIGINAL;
                                    $recibido = $row3->RECIBIDO;
                                    $dias = $row3->DIAS;
                                    $st = $row3->SUBTOTAL;

                                    $subtotal = $subtotal + $st;
                                    //echo 'Original'.$original.' Recibido: '.$recibido.'<br/><br/>';
                                    if($original > $recibido){
                                        //echo 'Entro a la suma.<br/><br/>';
                                        $pendiente = $pendiente + 1;
                                    }
                                //echo 'Pendiente: '.$pendiente.'<br/><br/>';
                        }
                        
                $datos[]= array("mes"=>$key->MES, "anio"=>$key->ANIO, "cajas"=>count($data2), "pendientes"=>$pendiente, "subtotal"=>$subtotal);   
                unset($data2);
                unset($data3);
            }

            return $datos;   
        
        }elseif($tipo == 2){
        
        $usuario=$_SESSION['user']->USER_LOGIN;
        $this->query="SELECT cotiza, extract(month from fechasol) as mes
                        from preoc01
                        where extract(month from fechasol) = $mes
                        and extract(year from fechasol)=$anio
                        and cotiza starting with (select letra_nueva from pg_users where  USER_LOGIN='$usuario')
                        and status <> 'R'
                        and status <> 'P'
                        group by
                            cotiza,
                            extract(month from fechasol),
                            extract(day from fechasol)
                        order by
                            extract(day from fechasol)";
        $rs=$this->EjecutaQuerySimple();

            while ($tsarray=ibase_fetch_object($rs)) {
                $data[]=$tsarray;
            }
            foreach ($data as $key) {
                        $cotizacion = $key->COTIZA;
                        $this->query="SELECT sum(cant_orig) as Original, sum(recepcion) as recibido, sum(empacado) as empacado, datediff(day from max(fechasol) to current_date) as dias, max(par) as partidas, ('('||max(clien)||') '||max(nom_cli)) as cliente, 
                            (select fecha_almacen from CAJAS_ALMACEN where  pedido ='$key->COTIZA') AS fechalib,
                            (select NOMBRE_ARCHIVO from CAJAS_ALMACEN where  pedido ='$key->COTIZA') AS archivo
                            from preoc01  
                            where cotiza ='$key->COTIZA'";
                            
                        $res=$this->EjecutaQuerySimple();
                        $row=ibase_fetch_object($res);

                    $datos[] = array("cotizacion"=> $key->COTIZA,"original"=>$row->ORIGINAL,"recepcion"=>$row->RECIBIDO, "empacado"=>$row->EMPACADO, "dias"=>$row->DIAS, "partidas"=>$row->PARTIDAS, "cliente"=>$row->CLIENTE, "fechalib"=>$row->FECHALIB, "archivo"=>$row->ARCHIVO);
                    }
            return $datos;        
        }elseif ($tipo == 3 ) {
        }      
    }


    function detalleFaltante($docf){
        $this->query="SELECT * FROM PREOC01 WHERE cotiza = '$docf'";
        $rs=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($rs)) {
            $data[]=$tsarray;
        }
        return $data;
    }

    function recalcular($idpreoc, $tipo){
        $data= new idpegaso;
        $info = $data->revisaDuplicado($idpreoc);
        $usuario = $_SESSION['user']->NOMBRE;
        $nordenado = '';
        $nrecepcion= '';
        $nempacado = '';
        if( $info['ordenado'] > $info['original']){
            $nordenado = $info['original'];
        }
        if($info['recibido'] > $info['original']){
            $nrecepcion = $info['original'];
        }
        if($info['empacado'] > $info['original']){
            $nempacado = $info['original'];
        }
        if($tipo == 2 ){
                $id= $info['ID'];
                $ordenado =$info['ordenado'];
                $recepcion = $info['recibido'];
                $pendiente = $info['pendiente'];
                $empacado = $info['empacado'];
                $status = $info['status'];
                $empacado =$info['empacado'];

              $this->query="INSERT INTO FTC_ACT_PREOC (ID, IDPREOC, USUARIO, O_ORDENADO, N_ORDENADO, O_RECIBIDO, N_RECIBIDO, O_REST, N_REST,  O_EMPACADO, N_EMPACADO, FECHA_MOV, STATUS )
                                VALUES 
                                    ( null,
                                      $id,
                                      '$usuario',
                                      (SELECT ORDENADO FROM PREOC01 WHERE ID = $id),
                                      $ordenado,
                                      (SELECT RECEPCION FROM PREOC01 WHERE ID = $id),
                                      $recepcion,
                                      (SELECT REST FROM PREOC01 WHERE ID = $id),
                                      $pendiente,
                                      (SELECT EMPACADO FROM PREOC01 WHERE ID = $id),
                                      $empacado,
                                      current_timestamp,
                                      0
                                    )";
                                
              $ins= $this->grabaBD();
              if($ins){
                    $this->query="SELECT FECHASOL FROM PREOC01 WHERE ID = $id";
                    $rs=$this->EjecutaQuerySimple();
                    $row=ibase_fetch_object($rs);

                    if($row->FECHASOL >= '15.02.2018'){
                        $this->query="UPDATE PREOC01 SET ORDENADO = $ordenado, recepcion = $recepcion, rest = $pendiente, status='$status' where id = $id";
                        $rs=$this->queryActualiza();
                        if($rs == 1 ){
                            return $response=array("status"=>'Se Actualizo la informacion.');
                        }else{
                            return $response=array("status"=>'No se pudo actualizar, favor de intentarlo nuevamente.');
                        }    
                    }else{
                        $this->query="UPDATE PREOC01 SET ORDENADO = $ordenado, recepcion = $recepcion, rest = $pendiente, status='B' where id = $id";
                        $rs=$this->queryActualiza();
                        if($rs == 1 ){
                            return $response=array("status"=>'Se Actualizo la informacion, pero no se solicita nuevamente por fecha, si cree que es un error o requiere el material, revisarlo con Alejandro Perla');
                        }else{
                            return $response=array("status"=>'No se pudo actualizar, favor de intentarlo nuevamente.');
                        }
                    }          
              } 
        }


        return $response = array('ordenado'=>$info['ordenado'], 'recibido'=>$info['recibido'], 'pendiente'=>$info['pendiente'], 'status'=>$info['status'], 'empacado'=>$info['empacado']); 
        //$response = array('nordenado'=>$nordenado,'nrecepcion'=>$nrecepcion,'nempacado'=>$nempacado);
    }


}?>