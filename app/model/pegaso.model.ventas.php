<?php 
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';
require_once 'app/model/pegaso.model.php';
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
        $data=array();
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
                    or cl.rfc = 'SUB910603SB'  
                    or cl.rfc = 'DLI83051718'
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
            $this->query = "UPDATE FTC_COTIZACION SET INSTATUS = 'CERRADA' WHERE CDFOLIO = $folio";
            $rs = $this->grabaBD();
            $this->generaDocumentoCotizacion($folio);
            //echo "<br />query: ".$this->query;
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
        $usuario=$_SESSION['user']->USER_LOGIN;
        $this->query = "UPDATE FTC_COTIZACION SET CVE_CLIENTE = TRIM('$cliente'),
            DSPLANTA = (SELECT COALESCE(substring(CAMPLIB7 from 1 for 90), '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente')), 
            DSENTREG= (SELECT COALESCE(substring(CAMPLIB8 from 1 for 90), '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE)=TRIM('$cliente')),
            CDUSUARI='$usuario', 
            COT_RFC= (SELECT RFC FROM CLIE01 WHERE trim(CLAVE) = TRIM('$cliente')), 
            VENDEDOR = '$usuario' 
            WHERE CDFOLIO = $folio";
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
        $data=array();
        $this->query="SELECT * FROM MARCAS WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;
    }

    function traeMarcasT(){
        $data=array();
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
            $COMPLETO = " and nombre containing ('".$descripcion."') or clave=upper('".$descripcion."')";
        }
        //$this->query = "INSERT INTO DICCIONARIO (ID, PALABRA)"
        $this->query="SELECT pftc.* FROM producto_ftc pftc left join FTC_Articulos ftca on ftca.id = pftc.clave_ftc where ftca.status = 'A' $COMPLETO";
        //echo $this->query;
        $rs=$this->QueryDevuelveAutocompletePFTC();

        return @$rs;
    }

    function traeClientes($cliente){
        $COMPLETO = false;
        if(strpos($cliente, ' ')){
            $desc2 = explode(' ', $cliente);
            $contado  = count($desc2);
            for($i = 0; $i < $contado; $i++){
                $COMPLETO = $COMPLETO." AND nombre containing('".$desc2[$i]."') ";
            }
        }else{
            $COMPLETO = " and nombre containing ('".$cliente."') or clave=upper('".$cliente."')";
        }
        $this->query="SELECT c.* FROM clie01 c where c.status!='' $COMPLETO";
        //echo $this->query;
        $rs=$this->QueryDevuelveAutocompleteClie();
        return @$rs;    
    }

    function traeCategorias(){
        $data = array();
        $this->query="SELECT * FROM CATEGORIAS WHERE STATUS = 'A'";
        $rs=$this->QueryObtieneDatosN();
            while($tsarray = ibase_fetch_object($rs)){
                $data[]=$tsarray;
            }
        return @$data;   
    }

    function traeCategoriasT(){
        $data = array();
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
        $this->query="SELECT * FROM PG_USERS WHERE USER_ROL = 'costos' and user_status = 'alta'";
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
        '$row->DSENTREG', 'PENDIENTE', $row->DBIMPSUB, $row->DBIMPIMP, $row->DBIMPTOT, ('$serieletra'||$folioletra), null, $folioletra, '$serieletra', 'No', null, null, (select trim(rfc) from clie01 where trim(clave) = trim('$row->CVE_CLIENTE')))";
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
        //exit($tipo);
        $data=array();
        $datos = array();
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
        }elseif($tipo == 3){
        
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
        }elseif ($tipo == 2) {
            $usuario=$_SESSION['user']->USER_LOGIN;
            $this->query="SELECT cotiza--, extract(month from fechasol) as mes
                        from preoc01
                        where extract(month from fechasol) = $mes
                        and extract(year from fechasol)=$anio
                        --and cotiza starting with (select letra_nueva from pg_users where  USER_LOGIN='$usuario')
                        and status <> 'R'
                        and status <> 'P'
                        group by
                            cotiza,
                            --extract(month from fechasol),
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
                        if($row->ORIGINAL <> $row->RECIBIDO){
                            $datos[] = array("cotizacion"=> $key->COTIZA,"original"=>$row->ORIGINAL,"recepcion"=>$row->RECIBIDO, "empacado"=>$row->EMPACADO, "dias"=>$row->DIAS, "partidas"=>$row->PARTIDAS, "cliente"=>$row->CLIENTE, "fechalib"=>$row->FECHALIB, "archivo"=>$row->ARCHIVO);

                        }

                    }
            return $datos;      

        }      
    }


    function detalleFaltante($docf){
        $histcompra=array();

        $this->query="SELECT * FROM PREOC01 WHERE cotiza = '$docf'";
        $rs=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($rs)) {
            $data[]=$tsarray;
        }

        foreach ($data as $key) {
            $data2=array();
            $this->query="SELECT * FROM FTC_DETALLE_RECEPCIONES WHERE IDPREOC = $key->ID and cantidad_rec > 0";
            $res=$this->EjecutaQuerySimple();
            $prov=array();
            while ($tsArray2 =ibase_fetch_object($res)) {
                $data2[]=$tsArray2;
            }

                if(count($data2)){
                    foreach($data2 as $key2){
                    $prov[]=array("OC"=>$key2->ORDEN);
                    }    
                }
                
            unset($data2);
        }
        foreach ($data as $key2 ) {
            $data3=array();
            $this->query="SELECT first 3  o.oC, o.cve_prov,(select nombre from prov01 where clave = o.cve_prov), F.*, P.*  FROM FTC_DETALLE_RECEPCIONES F 
                            LEFT JOIN PREOC01 P ON P.ID = F.IDPREOC 
                            LEFT JOIN FTC_POC o on o.oc = F.ORDEN
                            WHERE P.PROD =  '$key2->PROD' and cantidad_rec > 0 
                            order by F.fecha asc";
            $res=$this->EjecutaQuerySimple();
            $prov2 = array();
            while($tsArray = ibase_fetch_object($res)){
                $data3[]=$tsArray;
            }
            foreach ($data3 as $key2 ) {
                echo "OC: ".$key2->ORDEN.' Proveedor ('.$key2->CVE_PROV.') '.$key2->NOMBRE.'  Producto: '.$key->PROD.' descripcion: '.$key2->NOMPROD.'<br/>';
                $histcompra[]=array("oc"=>$key2->ORDEN,"prod"=>$key->PROD,"descr"=>$key2->NOMPROD);
            }
            unset($data3);
            //echo $this->query.'<br/>';
        }
        //exit(var_dump($histcompra));
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


    function validacion($folio){
        $this->query="SELECT * FROM FTC_COTIZACION WHERE CDFOLIO = $folio";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        //$status2=$row->INSTATUS;
        return($row->INSTATUS);
    }

    function cancelar($docf, $uuid){
        $usuario= $_SESSION['user']->NOMBRE;
        $this->query = "SELECT X.*, iif(f.status is null, 5, f.status) as factstat FROM XML_DATA X 
                        left join ftc_facturas f on f.serie = X.serie and f.folio = X.folio 
                        WHERE X.UUID = '$uuid' and X.serie||X.folio='$docf'";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        if($row){
            if($row->FACTSTAT == 8 || $row->FACTSTAT==5){
                return array("status"=>"No","motivo"=>"La factura ya ha sido cancelada con anterioridad o esta intentando cancelar una Nota de Credito, favor de actualizar o revisar la informacion");
            }
            $csv=fopen('C:\\xampp\\htdocs\\facturas\\Cancelaciones\\'.$docf.'-C'.'.csv','w');
            $datos = array(
                array('uuid', 'serie', 'folio', 'esNomina'),
                array($uuid,$row->SERIE,$row->FOLIO,"")
                );
            if($csv){
                foreach ($datos as $ln ) {
                    fputcsv($csv, $ln);
                }
            }
            fclose($csv);
            $this->query="UPDATE FTC_FACTURAS SET STATUS = 8, SALDO_FINAL = 0, fecha_cancelacion = current_timestamp, usuario_cancelacion = '$usuario' WHERE DOCUMENTO = '$docf'";
            $rs=$this->EjecutaQuerySimple();
            $this->query="INSERT INTO XML_DATA_CANCELADOS (ID, SERIE, FOLIO, UUID, STATUS, TIPO, FECHA_CANCELACION, USUARIO_CANCELACION ) 
                                    VALUES (NULL,'$row->SERIE', '$row->FOLIO', '$uuid', 'C', 'C', current_timestamp, '$usuario')";
            $this->grabaBD();
            $this->query="UPDATE CAJAS SET status = 'cerrado',par_facturadas = 0, FACTURA='', REMISION=('PF'||id) where id = (SELECT IDCAJA FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf' )";
            $this->EjecutaQuerySimple();
            return array("status"=>'ok', 'motivo'=>'Se ha cancelado la Factura');
        }
        return array("status"=>'No', "motivo"=>"no se encontro la informacion"); 
    }

    function informacionFactura($docf){
        $this->query="SELECT * FROM FACTURAS_CANCELADAS_FP WHERE CVE_DOC = '$docf'";
        $rs=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($rs)) {
            $data[]=$tsarray;
        }
        return $data;
    }

    function procesaCancelado($docf, $uuid){
        sleep(3);
        if(file_exists("C:\\xampp\\htdocs\\Facturas\\originales\\".$docf."-C.csv")){
            //echo 'Se encontro el archivo';
            $factura = 'ok';
            $archivo = "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$docf."-C.xml";
            sleep(2);
            copy("C:\\xampp\\htdocs\\Facturas\\FacturasJson\\".'Acuse de Cancelacion ('.$docf."-C.csv).xml", "C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\".$docf."-C.xml");
            $mensaje='Si la timbro';
            $data = new pegaso;
            $exec=$data->insertarArchivoXMLCargado($archivo, $tipo='C');
        
        }else{
            echo 'No se encontro el archivo';
        }
        return; 
    }

    function traePendientes($prod){
        $data=array();
        $prod = explode(":", $prod);
        $producto = $prod[0];
        $this->query="SELECT * FROM PREOC01 WHERE STATUS ='N' AND rec_faltante > 0 AND PROD = trim(UPPER('$producto')) and rest >=1 ";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }
        if($data){
            foreach ($data as $key){
            $response[]=array("status"=>'ok',"cotizacion"=>$key->COTIZA, "id"=>$key->ID, "faltante"=>$key->REC_FALTANTE, "original"=>$key->CANT_ORIG, "cliente"=>utf8_encode($key->NOM_CLI));
            } 
        }else{
            $response = array("status"=>'no');
        }
        return $response;
    }

    function actPartida($docf, $cantidad, $precio, $descuento, $partida, $uso, $mp, $fp, $clie){
        $fiscales=$this->actualizaFiscalesDirecta($docf, $uso, $mp, $fp, $clie);
        if($precio == "" and $cantidad == "" and $descuento ==""){
            return array("status"=>'no', "mensaje"=>'No se detecto ningun cambio en la partida '.$partida);
        }else{
            if($cantidad != ""){
                $this->query="UPDATE FTC_FACTURAS_DETALLE SET cantidad = $cantidad where documento = '$docf' and partida = $partida";
                $this->queryActualiza();
            }
            if($precio != ""){
                $this->query="UPDATE FTC_FACTURAS_DETALLE SET precio = $precio where documento = '$docf' and partida = $partida";
                $this->queryActualiza(); 
            }
            if($descuento != "" ){
                $this->query="UPDATE FTC_FACTURAS_DETALLE SET desc1 = $descuento where documento = '$docf' and partida = $partida";
                $this->queryActualiza();    
            }
            $total=$this->actualizaTotalesDocf($docf);
            return array("status"=>"OK", "mensaje"=>"Se actualizo la partida".$partida);
        }
    }

    function actualizaTotalesDocf($docf){
        $sdesc = 0;
        $st = 0; 
        $this->query="SELECT * FROM FTC_FACTURAS_DETALLE WHERE DOCUMENTO ='$docf'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        foreach ($data as $key) {
            $partida = $key->PARTIDA;
            $cant= $key->CANTIDAD;
            $prec = $key->PRECIO;
            $desc = $key->DESC1;
            $subtotal = ($cant *  $prec) - $desc;
            $st += $subtotal;
            $sdesc += $desc;
            $this->query="UPDATE FTC_FACTURAS_DETALLE SET subtotal = $subtotal, imp1 = $subtotal*0.16, total= $subtotal*1.16 where documento ='$docf' and partida = $partida"; 
            $this->queryActualiza();
        }
        $this->query="UPDATE FTC_FACTURAS SET desc1 = $sdesc, SUBTOTAL = $st, iva =$st *0.16, total = $st*1.16, SALDO_FINAL=$st*1.16 where documento = '$docf'";
        $this->queryActualiza();
        return $st*1.16;
    }

    function actualizaFiscalesDirecta($docf, $uso, $mp, $fp, $clie){
        $this->query="UPDATE FTC_FACTURAS SET USO_CFDI = '$uso', METODO_PAGO = '$mp', FORMADEPAGOSAT = '$fp', CLIENTE = '$clie' where documento = '$docf'";
        $this->queryActualiza();
        return;
    }

    function verPagos(){
        $data=array();
        $this->query="SELECT C.*, CD.*, (SELECT IMPORTE FROM FACTF01 WHERE CVE_DOC = CD.NO_FACTURA) AS IMPORTE_DOC,
    (SELECT CPT.DESCR FROM conc01 CPT WHERE CPT.NUM_CPTO = CD.NUM_CPTO ) AS nom_cpto,
    (SELECT CPT.FORMADEPAGOSAT FROM conc01 CPT WHERE CPT.NUM_CPTO = CD.NUM_CPTO ) AS TIPO_SAT
FROM CUEN_DET01 CD LEFT JOIN CLIE01 C ON C.CLAVE = CD.CVE_CLIE
WHERE CVE_DOC_COMPPAGO IS NULL AND (NUM_CPTO = 22 OR NUM_CPTO = 11 OR NUM_CPTO =10)";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }

        /*
        foreach ($data as $d) {
            $folioBanco=0;
            $usuario=$_SESSION['user']->NOMBRE;
            $rfc = 'XXX000000XXX';
            $this->query="INSERT INTO CARGA_PAGOS (ID,CLIENTE,FECHA,MONTO,SALDO,USUARIO,BANCO,FECHA_APLI,FECHA_RECEP,FOLIO_X_BANCO,RFC,STATUS,CF,FOLIO_ACREEDOR,TIPO_PAGO,REGISTRO,CONTABILIZADO,POLIZA_INGRESO,APLICACIONES,MONTO_ACREEDOR,MONTO_CF,CVE_MAESTRO,CIERRE_CONTA,USUARIO_CONTA,FECHA_CONTA,SELECCIONADO,GUARDADO,ARCHIVO,CEP,ARCHIVO_CEP) VALUES (NULL, '$d->CVE_CLIE', '$d->FECHAELAB', '$d->IMPMON_EXT', '$d->IMPMON_EXT', '$usuario','banco','$d->FECHA_APLI','$d->FECHA_APLI', '$d->FECHA_APLI',1, )";
        }
        */
        return $data;
    }

    function realizaCEP($folios){
        $folios = explode(",", $folios);
        $docs= "";
        for ($i=0; $i < count($folios); $i++) { 
            $doc = $folios[$i];
            $docs = $docs.",'".$doc."'";
            //echo $doc.'<br/>';
        }
        $docs = substr($docs, 1);
        $this->query="SELECT cve_clie, refer, FECHAELAB as fecha_elab, max(FECHA_APLI) as fecha_apli, sum(IMPORTE) AS monto, NUM_CPTO FROM CUEN_DET01 WHERE NO_FACTURA IN ($docs) group by cve_clie, refer, FECHAELAB, NUM_CPTO";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }
        foreach ($data as $k) {
            $this->realizaJson($k);
        }
    }

    function realizaJson($k){
        echo('PRIMER CLIENTE: '.$k->CVE_CLIE.' REFERENCIA: '.$k->REFER.' MONTO: '.$k->MONTO.' fecha elab: '.$k->FECHA_ELAB.' FECHA APLI:'.$k->FECHA_APLI.'<br/>');
        /// Json
        $conceptos = array(
                "ClaveProdServ"=>"84111506",
                "ClaveUnidad"=>"ACT",
                "Importe"=>"0",
                "Cantidad"=>"1",
                "descripcion"=>"Pago",
                "ValorUnitario"=>"0"
            );

        $this->query="SELECT * FROM CONC01 WHERE NUM_CPTO = $k->NUM_CPTO"; /// revisado
        //echo '<br/>'.$this->query;
        $res=$this->EjecutaQuerySimple();
        $rowCpto=ibase_fetch_object($res);

        $DocsRelacionados=array();

        $this->query="SELECT CU.*, F.*,(SELECT IMPORTE FROM FACTF01 WHERE CVE_DOC = CU.NO_FACTURA) AS IMPFACT, (SELECT UUID FROM CFDI01 WHERE CVE_DOC = CU.NO_FACTURA) AS UUIDF 
                FROM CUEN_DET01 CU LEFT JOIN FACTF01 F ON CU.NO_FACTURA = F.CVE_DOC
                     WHERE TRIM(CU.CVE_CLIE) = TRIM('$k->CVE_CLIE') AND CU.REFER='$k->REFER' AND CU.FECHA_APLI= '$k->FECHA_APLI' AND CU.CVE_DOC_COMPPAGO IS NULL"; /// REVISADO
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $dataDocs[]=$tsarray;
        }

            foreach ($dataDocs as $docu) {
                $saldoInsoluto = $docu->IMPFACT-$docu->IMPORTE;
                $documento = array (
                        "IdDocumento"=>$docu->UUIDF,
                        "Serie"=>"$docu->SERIE",
                        "Folio"=>"$docu->FOLIO",
                        "MonedaDR"=>"MXN",
                        "MetodoDePagoDR"=>"PPD",
                        "NumParcialidad"=>"1",
                        "ImpSaldoAnt"=>"$docu->IMPORTE",
                        "ImpPagado"=>"$docu->IMPFACT",
                        "ImpSaldoInsoluto"=>"$saldoInsoluto"
                    );    
                $DocsRelacionados[]=$documento;
            }
                    
                $aplica= array(
                    "FechaPago"=>substr($k->FECHA_APLI,0,10).'T 12:00:00',
                    "FormaDePagoP"=>"$rowCpto->FORMADEPAGOSAT",
                    "MonedaP"=>"MXN",
                    "Monto"=>"$k->MONTO",
                    "NumOperacion"=>"$k->REFER",
                    "DoctoRelacionado"=>$DocsRelacionados
                );

            $datosCEP[] = $aplica;

        $this->query="SELECT max(folio) as folio FROM FTC_CTRL_FACTURAS WHERE IDFF= 7 AND STATUS =1 AND SERIE = 'CEP'";
        $res=$this->EjecutaQuerySimple();
        $rowfolio=ibase_fetch_object($res);
        $folio=$rowfolio->FOLIO +1;
        $this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = $folio WHERE IDFF = 7 AND STATUS =1 AND SERIE = 'CEP'";
        $this->queryActualiza();

        $datosFactura = array(
                "Serie"=>"CEP",
                "Folio"=>"$folio",
                "Version"=>"3.3",
                "RegimenFiscal"=>"601",
                "LugarExpedicion"=>"54080",
                "Moneda"=>"XXX",
                "TipoDeComprobante"=>"P",
                "numero_de_pago"=>"1",
                "cantidad_de_pagos"=>"1"
            );

        $this->query="SELECT * FROM CLIE01 WHERE TRIM(CLAVE) =  TRIM($k->CVE_CLIE)";
        $res=$this->EjecutaQuerySimple();
        $rowClie=ibase_fetch_object($res);

        $datosCliente = array(
                    "id"=>"$k->CVE_CLIE",
                    "nombre"=>$rowClie->NOMBRE,
                    "rfc"=>$rowClie->RFC,
                    "UsoCFDI"=>'P01'
                );

                $Complementos[] = array("Pagos"=>array("Pago"=>$datosCEP)); 
                $cep = array (
                    "id_transaccion"=>"0",
                    "cuenta"=>"faao790324e57",
                    "user"=>"administrador",
                    "password"=>"@1KRhz11",
                    "getPdf"=>true,
                    "conceptos"=>[$conceptos],
                    "datos_factura"=>$datosFactura,
                    "method"=>"nueva_factura",
                    "cliente"=>$datosCliente,
                    "Complementos"=>$Complementos
                );

            $location = "C:\\xampp\\htdocs\\Facturas\\generaJson\\";
            $json = json_encode($cep, JSON_UNESCAPED_UNICODE);
            $mysql = new pegaso;
            $mysql->query = "INSERT INTO FTC_CEP VALUES (";
            $mysql->query.= "$folio, '$json', 'P');";
            $mysql->grabaBD();
            $nameFile = "CEP_".$folio;      
            $theFile = fopen($location.$nameFile.".json", 'w');
            fwrite($theFile, $json);
            fclose($theFile);
    }

    function realizaNCBonificacion($docf, $monto, $concepto, $obs, $caja){
        $data=array();
        $folio = $this->creaFolioNCB();
        $docd = 'NCB'.$folio;
        $sub = $monto/1.16;
        $iva = $monto - ($monto /1.16);
        $imp = $monto;
        $usuario=$_SESSION['user']->NOMBRE;
        $caja = explode("-", $caja);
        $caja = $caja[0];
        $caja = strlen($caja)==0? 0:$caja;
        $this->query="EXECUTE PROCEDURE SP_NC_BONIFICACION ('$docd', '$folio', $sub, $iva, $imp, '$docf', '$usuario', $caja)";
        if($res=$this->EjecutaQuerySimple()){
            echo 'Revisa si hay una caja por liberar';
            $this->query="SELECT * FROM FTC_FACTURAS WHERE idcaja = $caja and SALDO_FINAL > 5";
            $result=$this->EjecutaQuerySimple();   
            while($tsArray=ibase_fetch_object($result)){
                   $data[]=$tsArray;
            }
            if(count($data)==0){
                $this->query="UPDATE CAJAS SET FACTURA = '', status='cerrado', remision = ('PF'||id) WHERE FACTURA ='$docf'";
                $this->EjecutaQuerySimple();
                $this->query="EXECUTE PROCEDURE SP_LIB_X_NC ($caja)";
                $res=$this->queryActualiza();    
            }
        }else{

            $this->query="UPDATE ftc_ctrl_facturas SET FOLIO = FOLIO -1 WHERE SERIE = 'NCB' AND STATUS = 1";
            $this->queryActualiza();
            return;
        }
        //echo $this->query;
        $fact = new factura;
        $json = $fact->timbraNC($docd, $caja);
        $moverNC = $fact->moverNCSUB($docd,$json);


        return;
    }

    function creaFolioNCB(){
        $this->query="SELECT FOLIO FROM FTC_CTRL_FACTURAS WHERE SERIE = 'NCB' AND STATUS = 1";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        $this->query="UPDATE FTC_CTRL_FACTURAS SET FOLIO = ($row->FOLIO +1) WHERE SERIE='NCB' AND STATUS = 1 ";
        $this->queryActualiza();
        return $row->FOLIO+1;
    }

    function conteoCopias($docf){
        
        $this->query="SELECT COUNT(IDF) as ID FROM FTC_FACTURAS WHERE DOCUMENTO = '$docf'";
        $res=$this->EjecutaQuerySimple();
        $row1=ibase_fetch_object($res);
        if($row1->ID == 0){
            return array("status"=>"noExiste","copias"=>"No existe la factura");
        }

        $this->query="SELECT count(id) as copias, cast(list(R_F) as varchar(100)) as facturas  FROM REFACTURACION WHERE FACT_ORIGINAL='$docf' and tipo_solicitud='copia'";
        $res= $this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        if($row->COPIAS > 0){
            return array("status"=>'ok', "copias"=>$row->COPIAS, 'facturas'=>$row->FACTURAS);    
        }else{
            return array("status"=>'no', "copias"=>'0','facturas'=>'');
        }
    }

    function copiaFP($docf){
        $fact= new factura;

        $nuevoFolio=$fact->crearFoliosFactura();
        $copiaFactura=$fact->copiaFactura($idsol=999999,$nuevoFolio, $docf);
        return $copiaFactura;    
    }

    function cajaNC($idc){
        $this->query="SELECT C.*,
                            COALESCE((select SALDO_FINAL FROM FTC_FACTURAS WHERE DOCUMENTO = FACTURA), 
                                     (select SALDOFINAL FROM FACTF01 WHERE CVE_DOC = FACTURA), 
                                     9999
                            ) AS SF
                            FROM CAJAS  C WHERE ID = $idc";
        $res=$this->EjecutaQuerySimple();  
        $row=ibase_fetch_object($res);
        $sf=$row->SF;
        if($sf > 5){
                //$this->query="UPDATE CAJAS SET STATUS_LOG = 'NC', status_recepcion = iif(status_recepcion >=5, status_recepcion, 5) WHERE ID = $idc";
                //        $res=$this->queryActualiza();
                $this->query="EXECUTE PROCEDURE SP_LIB_X_NC ($idc)";
                $res=$this->EjecutaQuerySimple();
                if($res == 1){
                    return array("status"=>'ok');
                }else{
                    return array("status"=>'ok');
                }            
        }else{
            return array("status"=>'no', "mensaje"=>'El Saldo de la Factura'.$row->FACTURA.' asociada a la caja '.$idc.', es de $ '.number_format($sf,2).' la cual es menor a $ 5.00 pesos' );
        }
    }

    function verNCC($serie){
        $data = array();
        $this->query="SELECT nc.*, f.DOCUMENTO AS FACTURA, f.SALDO_FINAL AS SALDO_FACT, f.total as totalFactura, f.notas_credito as facturaNC, 
            f.status as facturaStatus, f.monto_nc, f.monto_pagos as pagos FROM FTC_NC nc left join ftc_facturas f on f.documento = nc.notas_credito WHERE nc.SERIE = '$serie'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function aplicaNC($docn){
        $this->query="SELECT * FROM FTC_NC WHERE DOCUMENTO ='$docn'";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        if($row){
            $this->query="SELECT * FROM FTC_FACTURAS WHERE DOCUMENTO = '$row->NOTAS_CREDITO'";
            $res=$this->EjecutaQuerySimple();
            $rowFact=ibase_fetch_object($res);
            if(((int)$rowFact->SALDO_FINAL - (int)$row->TOTAL) >= 0 and strpos($rowFact->NOTAS_CREDITO, $row->DOCUMENTO) === false) {
               // echo 'No la encontro y el Saldo restante es igual o mayor a cero';
                $this->query="UPDATE FTC_FACTURAS SET SALDO_FINAL = SALDO_FINAL - $row->TOTAL, notas_credito = iif(notas_credito = '' or notas_credito is null, '$docn', notas_credito||', '||'$docn'), monto_nc=monto_nc + $row->TOTAL WHERE DOCUMENTO= '$rowFact->DOCUMENTO'";
                $this->queryActualiza();
                return array("status"=>'ok', "mensaje"=>'Se ha aplicado la NC correctamente');
            }elseif(strpos($rowFact->NOTAS_CREDITO, $row->DOCUMENTO)){
                return array("status"=>'ok', "mensaje"=>'Encontro'.$row->DOCUMENTO.' en '.$rowFact->NOTAS_CREDITO.' y la posicion es'.strpos($rowFact->NOTAS_CREDITO, $row->DOCUMENTO));
            }elseif(($rowFact->SALDO_FINAL - $row->TOTAL) < 0){
                return array("status"=>'ok', "mensaje"=>'La aplicacion de la '.$row->DOCUMENTO.', crearia un saldo negativo en la factura, favor de revisar la informacion');
            }else{
                return array("status"=>'no',"mensaje"=>'No se pudo procesar, se realizo un ticket para su revision, se encontro la nota de credito '.$row->DOCUMENTO.', pero no se pudo procesar');
            }   
        }else{
            return array("status"=>'no',"mensaje"=>'No se pudo procesar, se realizo un ticket para su revision, no existe la nota de credito '.$row->DOCUMENTO);
        }
    }

    function verPartidas($idc){
        $data=array();
        $this->query="SELECT D.*, COALESCE((SELECT CAST(ANEXO_DESCRIPCION AS VARCHAR(1000)) FROM FTC_ANEXO_DESCR WHERE CAJA = $idc and Partida = D.PARTIDA AND STATUS IS NULL), '') AS ANEXO FROM DETALLE_CAJA D WHERE D.IDCAJA = $idc";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function verCabecera($idc){
        $data=array();
        $this->query="SELECT * FROM CABECERA_CAJA WHERE ID = $idc";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function anexoDescr($tipo, $idc, $par, $descr){
        $data=array();
        $descr=htmlentities($descr,ENT_QUOTES);
        if($tipo == 'a'){
            $this->query="SELECT * FROM FTC_ANEXO_DESCR WHERE caja = $idc and partida = $par and status is null ";
            $res=$this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($res)) {
                $data[]=$tsArray;
            }
            if(count($data) > 0){
                $this->query="UPDATE FTC_ANEXO_DESCR SET ANEXO_DESCRIPCION = '$descr' where caja = $idc and partida = $par and status is null ";
                $this->queryActualiza();    
            }else{
                $this->query="INSERT INTO FTC_ANEXO_DESCR (ID , ANEXO_DESCRIPCION, PARTIDA, CAJA) VALUES (NULL, '$descr', $par, $idc)";
                $this->grabaBD();
            }    
        }else{
            $this->query="UPDATE FTC_ANEXO_DESCR SET STATUS= 9 WHERE caja = $idc and partida = $par and status is null";
            $this->queryActualiza();
            return array("status"=>'ok', "mensaje"=>'Se ha restaurado la descripción');
        }

        return array("status"=>'ok', "mensaje"=>'Se ha anexado Correctamente');
    }

    function repVentas($tipo, $clie, $inicio, $fin){
        $data = array();
        $fechas = '';
        if(!empty($inicio) and !empty($fin)){
            $fechas= " and fecha between ".$inicio." and ".$fin;
        }

        if($tipo == 'c'){
            $this->query="SELECT * FROM FTC_FACTURAS WHERE status != 9 $fechas ";
            $this->EjecutaQuerySimple();
        }
    }

    function cargaSae($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo){
        $ruta2= "C:\\xampp\\htdocs\\uploads\\xml\\IMI161007SY7\\Emitidos\\".$rfcr."\\IMI161007SY7-".$doc.'-'.$uuid.".xml";
        if($tipo != 'P'){
            $myFile = fopen("$ruta2", "r") or die("No se ha logrado abrir el archivo ($ruta2)!");
            $myXMLData = fread($myFile, filesize($ruta2));
            $doc = $serie.'0'.$folio;
            $this->query="EXECUTE PROCEDURE SP_CARGA_CFDI_SAE($folio,'$serie','$doc', '123', '$tipo')";
            $this->EjecutaQuerySimple();
            $this->query = "UPDATE CFDI01 SET XML_DOC = '$myXMLData' WHERE CVE_DOC = '$doc'";
            $this->EjecutaQuerySimple();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_FACTURA_SAE($folio,'$serie','$doc', '$tipo')";
                $this->EjecutaQuerySimple();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_PARTIDAS_SAE($folio,'$serie', '$doc', '$uuid', '$tipo')";
                $this->EjecutaQuerySimple();
                $this->query="EXECUTE PROCEDURE  SP_CARGA_CUENM_SAE ($folio, '$serie', '$doc', '$uuid', '$tipo')";
                $this->EjecutaQuerySimple();    
        }else{
            $res=$this->cargaCEP($doc, $ruta2, $rfcr, $serie, $folio);
        }   
        return $mensaje = array('status' => 'ok');
    }

    function InsertaCEPSAE($nameFile, $cve_clie, $rfc, $serie, $folio, $ven, $file, $fecha){
        $this->query="INSERT into factg01 (TIP_DOC, CVE_DOC, CVE_CLPV, STATUS, DAT_MOSTR, CVE_VEND, CVE_PEDI, FECHA_DOC, FECHA_ENT, FECHA_VEN, FECHA_CANCELA, CAN_TOT, IMP_TOT1, IMP_TOT2, IMP_TOT3, IMP_TOT4, DES_TOT, DES_FIN, COM_TOT, CONDICION, CVE_OBS, NUM_ALMA, ACT_CXC, ACT_COI, ENLAZADO, TIP_DOC_E, NUM_MONED, TIPCAMB, NUM_PAGOS, FECHAELAB, PRIMERPAGO, RFC, CTLPOL, ESCFD, AUTORIZA, SERIE, FOLIO, AUTOANIO, DAT_ENVIO, CONTADO, CVE_BITA, BLOQ, FORMAENVIO, DES_FIN_PORC, DES_TOT_PORC, IMPORTE, COM_TOT_PORC, METODODEPAGO, NUMCTAPAGO, TIP_DOC_ANT, DOC_ANT, TIP_DOC_SIG, DOC_SIG, UUID, VERSION_SINC, FORMADEPAGOSAT, USO_CFDI)
            values ('G', '$nameFile', (SELECT FIRST 1 c.CLAVE FROM CLIE01 c WHERE c.rfc = '$rfc' AND c.tipo_empresa = 'M' and c.Matriz = c.clave ), 'E', 0 , (SELECT FIRST 1 c.CVE_VEND FROM CLIE01 c WHERE c.rfc = '$rfc' AND c.tipo_empresa = 'M' and c.Matriz = c.clave ), '', CURRENT_DATE, CURRENT_DATE, CURRENT_DATE, NULL, 0,0,0,0,0,0,0,0,NULL, 0, 1, 'S','N','O','O',1,1,1,current_timestamp, 0, '$rfc', 0, 'T', 0,
            '$serie', $folio, '', 0, 'N', 0, 'N','A', 0, 0, 0, 0,null, NULL, '', '', null, NULL, '$file', current_timestamp, null,  'P01')";
            $this->grabaBD();

            $this->query="INSERT into FACTG_CLIB01 (CLAVE_DOC ) VALUES ( '$nameFile')";
            $this->grabaBD();

            $this->query="INSERT INTO PAR_FACTG01 (CVE_DOC, NUM_PAR, CVE_ART, CANT, PXS, PREC, COST, IMPU1, IMPU2, IMPU3, IMPU4, IMP1APLA, IMP2APLA, IMP3APLA, IMP4APLA, TOTIMP1, TOTIMP2, TOTIMP3, TOTIMP4, DESC1, DESC2, DESC3, COMI, APAR, ACT_INV, NUM_ALM, POLIT_APLI, TIP_CAM, UNI_VENTA, TIPO_PROD, CVE_OBS, REG_SERIE, E_LTPD, TIPO_ELEM, NUM_MOV, TOT_PARTIDA, IMPRIMIR, MAN_IEPS, APL_MAN_IMP, CUOTA_IEPS, APL_MAN_IEPS, MTO_PORC, MTO_CUOTA, CVE_ESQ, DESCR_ART, UUID, VERSION_SINC)
                         VALUES ('$nameFile', 1, 'SERV-PAGO', 1, 1, 0, 0, 0, 0, 0, 16, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'S', 1, NULL, 1, 'ACT', 'S', 0, 1, 1, 'N', 0, 0, 'S', 'N', 1, 0, 'C', 0, 0, 1, NULL, NULL, current_timestamp)";
            $this->grabaBD();
        return;
        //if(file_exists($file)){
        //    $xml_doc=fopen($file, "r");
        //    $r=$this->cargaCEP($folio);
        //}
    }

    function cargaCEP($cep, $ruta2, $rfcr, $serie, $folio){
        $path="C:\\xampp\\htdocs\\uploads\\xml\\IMI161007SY7\\Emitidos\\".$rfcr."\\";
        $files = array_diff(scandir($path), array('.', '..'));
        foreach($files as $file){
            $data = explode(".", $file);
            $fileName = $data[0];
            $fileExtension = $data[1];
            if(strtoupper($fileExtension) == 'XML' and strpos($fileName, 'CEP') !== false){
                if(strpos($fileName, $cep) !== false){
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
                        $doc = $serie.str_pad($folio,6,"0", STR_PAD_LEFT);
                            $this->query="INSERT INTO CFDI01 (TIPO_DOC, CVE_DOC, VERSION, UUID, NO_SERIE, FECHA_CERT, FECHA_CANCELA, XML_DOC, DESGLOCEIMP1, DESGLOCEIMP2, DESGLOCEIMP3, DESGLOCEIMP4, MSJ_CANC, PENDIENTE)
                            VALUES ('G', '$doc', '1.1', '$uuid', '$noNoCertificadoSAT', '$fecha', '', '$myXMLData','S', 'N', 'N', 'S', NULL, 'N')";
                            $this->grabaBD();
                            $this->InsertaCEPSAE($doc, $cve_clie = null, $rfcr, $serie, $folio, $ven=null,$file= $uuid, $fecha= null);
                    }

                }else{
                }
            }
        }
        return array("status"=>'ok', "mensaje"=>'Se inserto el documento');
        //return array("status"=>'no',"mensaje"=>'No se encontro el Archivo', "archivo"=>'no');
    }

    function repVenta($op1,$op2,$op3,$op4,$op5,$op6,$op7){
        $data=array();
        switch ($op6) {
            case 'Facturas':
                $tabla = "FTC_FACTURAS t1 ";
                $tabla2 = "FTC_FACTURAS_DETALLE t2 ";
                break;
            case 'Prefacturas':
                $tabla = " Cajas t1 ";
                $tabla2 = " preoc01 t2 ";
                break;
            case 'Cotizaciones':
                $tabla = "FACTP01 t1 ";
                $tabla2 = " PAR_FACTP01 t2 ";
                break;
            default:
            break;
        }
        $fecha='';
        $cls='';
        $detalle= '';
        $cd="";
        if($op4!='' and $op5!=''){
            // Quiere decir que se parametizan las fechas
            $fecha = " and fecha_doc >= '".$op4."' and fecha_doc <='".$op5."' ";    
        }elseif($op4 == '' and $op5 !=''){
            $fecha = " and fecha_doc <= '".$op5."' ";
        }elseif ($op4 != '' and $op5 == ''){
            $fecha = " and fecha_doc >= '".$op4."' ";
        }

        if($op7!= '' and strpos($op7, ":")){
            $clie=explode(",",$op7);
            for($i=0; $i < (count($clie)-1); $i++){
                $cli=explode(":", $clie[$i]);
                $cli[0]=str_replace("<p>","", trim($cli[0]));
                $cli[0]=str_replace("</p>", "", trim($cli[0]));
                $cls .= "trim('".$cli[0]."'),"; 
            }     
            $cls=" and trim(cliente) in (".substr($cls,0,-1).")";
        }
        if($op2 == 'Detallado'){
            $detalle = " left join ".$tabla2." on t2.documento = t1.documento ";
            $cd="*.t2, ";
        }

        if($op3 == 'Agrupado'){
            $this->query="SELECT t1.*, $cd (SELECT C.NOMBRE FROM CLIE01 C WHERE trim(C.CLAVE) = t1.cliente ) FROM $tabla $detalle where t1.status is not null  $fecha $cls order by cliente";
        }else{
            $this->query="SELECT t1.*, $cd (SELECT C.NOMBRE FROM CLIE01 C WHERE trim(C.CLAVE) = t1.cliente ) FROM $tabla $detalle where t1.status is not null  $fecha $cls";
        }
        $res=$this->EjecutaQuerySimple();
        while($tsarray=ibase_fetch_object($res)){
            $data[]=$tsarray;
        }
        return array("status"=>"ok", "datos"=>$data, "archivo"=>'');
    } 

    function prodVM($b){
        $this->query="SELECT A.*, (SELECT coalesce(SUM(b.RESTANTE), 0) FROM ingresobodega b where b.producto = 'PGS'||A.ID ) as Existencia  FROM FTC_Articulos A WHERE (A.GENERICO||' '||A.SINONIMO||' '|| A.CALIFICATIVO||' '||A.CLAVE_PROD||' '||A.SKU) CONTAINING('$b')";
        $r=$this->QueryDevuelveAutocompleteProd();
        return $r;
    }

    function clieVM($b){
        $this->query="SELECT A.*, A.CALLE||'-'||COALESCE(A.NUMEXT,'') AS DIRECCION, A.NUMINT AS INTERIOR, A.MUNICIPIO AS DELEGACION  FROM clie01 A WHERE A.NOMBRE CONTAINING('$b') OR a.rfc containing ('$b')";
        $r=$this->QueryDevuelveAutocompleteClieNV();
        return $r;
    }

    function docNV($clie, $prod, $cant, $prec, $desc, $iva, $ieps, $descf, $doc, $idf){
        //$folio = $this->creaFolioNV();
        $c=array(); 
        if($doc == 0 and $idf== 0){
            $c = $this->cabeceraNV($clie);
        }
        $d = $this->partidaNV($prod, $cant, $prec, $desc, $iva, $ieps, $c, $descf, $doc, $idf);
        return array("status"=>'ok',"doc"=>$d['doc'], "idf"=>$d['idf']);
    }

    function cabeceraNV($clie){
        $usuario=$_SESSION['user']->NOMBRE;
        $letra = $_SESSION['user']->LETRA_NUEVA;
        $clie = explode(":", $clie);
        $cliente = $clie[0];
        $cliente = !empty($cliente)? $cliente:'999999';
        $this->query="INSERT INTO FTC_NV 
            ( 
            IDF, DOCUMENTO, SERIE, FOLIO, FORMADEPAGOSAT, VERSION, TIPO_CAMBIO, METODO_PAGO, REGIMEN_FISCAL, LUGAR_EXPEDICION, MONEDA, TIPO_COMPROBANTE, CONDICIONES_PAGO, SUBTOTAL, IVA, IEPS, DESC1, DESC2, TOTAL, SALDO_FINAL, ID_PAGOS, ID_APLICACIONES, NOTAS_CREDITO, MONTO_NC, MONTO_PAGOS, MONTO_APLICACIONES, CLIENTE, USO_CFDI, STATUS, USUARIO, FECHA_DOC, FECHAELAB, IDIMP, UUID, DESCF, IDCAJA, CONTABILIZADO, POLIZA, FECHA_CANCELACION, USUARIO_CANCELACION
            ) 
            VALUES (null, '$letra'||(SELECT COALESCE(MAX(FOLIO), 0) + 1 FROM FTC_NV WHERE SERIE = '$letra'),'$letra', (SELECT COALESCE(MAX(FOLIO), 0) + 1 FROM FTC_NV WHERE SERIE = '$letra'), '', 1.1, 1, '', '', '', 1,'NV', 'Contado', 0,0,0,0,0,0,0,'','','',0,0,0,'$cliente', '', 'P', '$usuario', current_date, current_timestamp, 0, null, 0, null, 0, null, null, '' 
            ) RETURNING IDF, SERIE, FOLIO, DOCUMENTO";
        $res=$this->grabaBD();
        $row=ibase_fetch_object($res);
        return $row;
    }

    function partidaNV($prod, $cant, $prec, $desc, $iva, $ieps, $c, $descf, $doc, $idf){
        $usuario=$_SESSION['user']->NOMBRE;
        $st = $prec*$cant;
        $d = $cant*($prec * ($desc/100));
        $t = ($st-$d)*(1+($iva/100));
        if(!empty($c)){
            $idf = $c->IDF;
            $doc = $c->DOCUMENTO;
        }
        $this->query="INSERT INTO FTC_NV_DETALLE ( IDFP ,IDF ,DOCUMENTO ,PARTIDA ,CANTIDAD ,ARTICULO ,UM ,DESCRIPCION ,IMP1 ,IMP2 ,IMP3 ,IMP4 ,DESC1 ,DESC2 ,DESC3 ,DESCF ,SUBTOTAL ,TOTAL ,CLAVE_SAT ,MEDIDA_SAT ,PEDIMENTOSAT ,LOTE ,USUARIO ,FECHA ,IDPREOC ,IDCAJA ,IDPAQUETE ,PRECIO ,STATUS ,NUEVO_PRECIO ,NUEVA_CANTIDAD ,CAMBIO ) 
            VALUES (null, $idf, '$doc', (SELECT COALESCE(MAX(PARTIDA),0) + 1 FROM FTC_NV_DETALLE WHERE IDF = $idf), $cant, '$prod', (SELECT FIRST 1 UM FROM producto_ftc WHERE CLAVE_FTC=$prod), (SELECT FIRST 1 NOMBRE FROM producto_ftc WHERE CLAVE_FTC=$prod), $iva, $ieps, 0, 0, $desc, 0, 0, $descf, $st, $t, (SELECT CVE_PRODSERV FROM INVE01 I WHERE I.CVE_art = 'PGS'||$prod), (SELECT CVE_UNIDAD FROM INVE01 I WHERE I.CVE_ART = 'PGS'||$prod), '','','$usuario', current_date, 0, 0, 0, $prec, 0, 0, 0, 0  
        )";
        $this->grabaBD();

        $this->query="UPDATE FTC_NV F SET 
            F.SUBTOTAL = (SELECT SUM(SUBTOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf), 
            F.TOTAL = (SELECT SUM(TOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.IVA = (SELECT SUM((PRECIO * (IMP1/100))*CANTIDAD) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.DESC1 = (SELECT SUM((PRECIO * (DESC1/100))*CANTIDAD) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.SALDO_FINAL = (SELECT SUM(TOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.DESCF = $descf
            WHERE IDF = $idf";
        $this->queryActualiza();
        return array("doc"=>$doc, "idf"=>$idf);
    }


    function nvCabecera($docf){
        $data=array();
        $this->query="SELECT F.*, C.*, (SELECT FIRST 1 NOMBRE FROM PG_USERS P WHERE F.SERIE = P.LETRA_NUEVA) AS VENDEDOR FROM FTC_NV F left join CLIE01 C ON C.CLAVE = F.CLIENTE WHERE F.DOCUMENTO='$docf'";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }
        return $data;
    }

    function nvPartidas($docf){
        $data=array();
        $this->query="SELECT F.*,(SELECT SUM(RESTANTE) FROM ingresobodega I WHERE I.PRODUCTO='PGS'||F.ARTICULO) AS EXISTENCIA, (SELECT SKU FROM FTC_Articulos A WHERE A.ID = F.ARTICULO) FROM FTC_NV_DETALLE F WHERE IDF=(select idf from ftc_nv where documento='$docf')and Documento = '$docf'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function traeAplicaciones($doc, $cambio){
        $data = array();
        $this->query="SELECT A.*, $cambio as cambio FROM APLICACIONES A WHERE DOCUMENTO = '$doc' and cancelado = 0";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }
        return $data;
    }

    function pagaNV($tcc,$tcd,$efe,$tef,$val,$cupon,$doc,$cambio){
        $pagos = array($tcc,$tcd,$efe,$tef,$val,$cupon);
        $usuario = $_SESSION['user']->NOMBRE;
        for ($i=0; $i < count($pagos); $i++){ 
            switch ($i){
                case 0:
                    $tipo = 'TCC';
                    break;
                case 1:
                    $tipo = 'TCD';
                    break;
                case 2:
                    $tipo = 'EFE';
                    break;
                case 3:
                    $tipo = 'TEF';
                    break;
                case 4:
                    $tipo = 'VAL';
                    break;
                case 5:
                    $tipo = 'CUPON';
                    break;
                default:
                    break;
            }
            $monto = $pagos[$i];
            if($pagos[$i] > 0){
                if($tipo == 'EFE' and $cambio > 0){
                    $monto=$pagos[$i]-$cambio;
                }
                //echo 'El pago es: '.$tipo.' por un monto de: '.$pagos[$i].'<br/>';
                $this->query="INSERT INTO CARGA_PAGOS (ID, CLIENTE, FECHA, MONTO, SALDO, USUARIO, FECHA_APLI, FECHA_RECEP, FOLIO_X_BANCO, RFC, STATUS, TIPO_PAGO) values (NULL, (SELECT CLIENTE FROM FTC_NV WHERE DOCUMENTO = '$doc'), current_date, $monto, 0, '$usuario', current_timestamp, current_timestamp,'$tipo'||'-'||'$doc', (SELECT RFC FROM CLIE01 WHERE CLAVE = (SELECT CLIENTE FROM FTC_NV WHERE DOCUMENTO = '$doc')), 1, '$tipo') RETURNING ID";
                $res=$this->grabaBD();
                $row=ibase_fetch_object($res);
                if(!empty($row->ID)){
                    $this->query="INSERT INTO APLICACIONES (ID, FECHA, IDPAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, STATUS, RFC, FORMA_PAGO, CANCELADO, OBSERVACIONES) VALUES (NULL, current_timestamp, $row->ID, '$doc', $monto, (SELECT SALDO_FINAL FROM FTC_NV F WHERE F.DOCUMENTO = '$doc') - $monto, 0, '$usuario', 'E',  (SELECT RFC FROM CLIE01 WHERE CLAVE = (SELECT CLIENTE FROM FTC_NV WHERE DOCUMENTO = '$doc')), '$tipo', 0, 'Nota Venta: '||'$doc')";
                    $this->grabaBD();

                    $this->query="UPDATE FTC_NV SET SALDO_FINAL = SALDO_FINAL - $monto, status = 'E' where DOCUMENTO = '$doc'";
                    $this->queryActualiza();
                }
            }
        }
        return array("status"=>'ok');
    }

    function cancelaNV($doc){
        $this->query="UPDATE FTC_NV SET STATUS= 'C' WHERE DOCUMENTO = '$doc' and status='P'";
        $res=$this->queryActualiza();
        //echo $res;
        if($res == 1){
            return array("status"=>'ok', "mensaje"=>'Revise la informacion');
        }else{
            return array("status"=>'ok', "mensaje"=>'La Nota ya ha sido cancelada o facturada');
        }
    }

    function cambioCliente($clie, $doc){
        $cliente = explode(":", $clie);
        $cliente = $cliente[0];
        $this->query="UPDATE FTC_NV SET CLIENTE = (SELECT CLAVE FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')) where documento = '$doc'";
        $res=$this->queryActualiza();
        if($res == 1){
            return array("status"=>'ok', "mensaje"=>'Se ha efectuado el cambio de cliente');
        }else{
            return array("status"=>'no', "mensaje"=>'Ocurrio un error, favor de revisar la informacion');
        }
    }

    function dropP($doc, $idf, $p){
        $this->query="DELETE FROM FTC_NV_DETALLE WHERE DOCUMENTO = '$doc' and IDF=$idf and PARTIDA = $p ";
        $this->queryActualiza();
        $res=$this->acomodoPartidas($doc, $idf);
        return $res;
    }

    function acomodoPartidas($doc, $idf){
        $this->query="SELECT * FROM FTC_NV_DETALLE WHERE DOCUMENTO = '$doc' and idf=$idf  order by partida";
        $res=$this->EjecutaQuerySimple();
        while ($tsarray=ibase_fetch_object($res)) {
            $data[]=$tsarray;
        }
        $p=0;
        foreach ($data as $x){
            $p++;
            $this->query="UPDATE FTC_NV_DETALLE SET PARTIDA = $p where documento = '$doc' and idf=$idf and partida = $x->PARTIDA";
            $this->queryActualiza();
        }

        $this->query="UPDATE FTC_NV F SET 
            F.SUBTOTAL = (SELECT SUM(SUBTOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf), 
            F.TOTAL = (SELECT SUM(TOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.IVA = (SELECT SUM((PRECIO * (IMP1/100))*CANTIDAD) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.DESC1 = (SELECT SUM((PRECIO * (DESC1/100))*CANTIDAD) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf),
            F.SALDO_FINAL = (SELECT SUM(TOTAL) FROM FTC_NV_DETALLE FD WHERE FD.IDF = $idf)
            WHERE IDF = $idf";
        $this->queryActualiza();

        return array("status"=>'ok');
    }

    function chgTipo($tipo, $id){
        switch ($tipo) {
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;
            case 1:
                $tabla = '';
                $campo = '';
                $campo3 = '';
                $tipo2 = '';
                break;         
            default:
                break;
        }
        $this->query="UPDATE $tabla set $campo = '$tipo2' where $campo3 = $id";
        $res=$this->queryActualiza();
        if($res > 0){
            $m='Se ha realizado el cambio. :)';
        }else{
            $m='No se pudo realizar el cambio, actualice la pantalla antes de intentarlo nuevamente. :( ';
        }
        return $r=array("status"=>'ok', "mensaje"=>$m);
    }

}?>