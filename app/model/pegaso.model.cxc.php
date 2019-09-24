<?php
require_once 'app/model/database.php';

class pegasoCobranza extends database {

	function cobranza(){
		$data=array();
		$data2= array();
		
        $this->query="execute procedure SALDO_COMPROMETIDO_MESTROS";
        $this->EjecutaQuerySimple();

        $this->query="SELECT M.*, (SELECT MAX(DIASCRED) FROM CLIE01 WHERE CVE_MAESTRO = M.CLAVE) AS PLAZO FROM MAESTROS M";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($res)) {
            $data2[]=$tsArray;
        }
		return $data2;
	}

    function actualizaComprometido(){

        $this->query="SELECT * FROM MAESTROS";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($res)) {
            $data2[]=$tsArray;
        }
        
        foreach ($data2 as $key2 ) {
            $this->query="SELECT --(select dbimptot from ftc_cotizacion f where p.cotiza = f.cve_cotizacion) as Valor,
                sum ((p.cant_orig - p.empacado) * p.costo) as comprometido
                --p.*
                from preoc01 p
                left join clie01 c on c.clave =  p.clien
                left join cajas_almacen  ca on ca.pedido = p.cotiza
                where ca.fecha_almacen >= '01.01.2018'
                --and p.cotiza = 'C3753'
                and ((p.cant_orig - p.empacado) * p.costo) > 0
                and c.cve_maestro ='$key2->CLAVE'";
            $rs = $this->EjecutaQuerySimple();
            $row= ibase_fetch_object($rs);
            $comprometido = $row->COMPROMETIDO; 
            if($comprometido  > 0){
                $this->query="UPDATE MAESTROS SET LOGISTICA = $row->COMPROMETIDO where clave  = '$key2->CLAVE'";
                $this->EjecutaQuerySimple(); 
                //echo $this->query.';<br/>';   
            }   
        }
    }



	function verDocumentosMaestro($maestro){
		$this->query="SELECT f.CVE_MAESTRO,f.CVE_CLPV as Clave, cl.nombre as Cliente, f.cve_doc, f.fecha_doc , f.saldofinal, f.importE, f.PAGOS, f.APLICADO, f.IMPORTE_NC,
					extract(year from f.fecha_doc)as anio, f.deuda2015, f.STATUS, f.ID_APLICACIONES, f.ID_PAGOS, f.nc_aplicadas
					, cp.banco, FOLIO_X_BANCO, FECHA_RECEP, cp.monto, (cp.monto - cp.aplicaciones) As SPago, ac.id as IdA,ac.monto as MA, ac.saldo as sa
					FROM factf01 f
					LEFT JOIN CLIE01 cl on cl.clave = f.cve_clpv
					left join carga_pagos cp on cast(cp.id as varchar(10)) = f.id_pagos
					LEFT JOIN ACREEDORES ac on ac.id = cp.folio_acreedor
					where f.cve_maestro = '$maestro' order by fecha_doc";
		$rs=$this->QueryObtieneDatosN();
		//echo $this->query;

		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		//sort($data);

		return $data;
	}

	function traeMaestro($idm, $cvem){
		$this->query="SELECT M.*, 
					(SELECT COUNT(ID) FROM MAESTROS_CCC WHERE CVE_MAESTRO = '$cvem') as CCs,
					(SELECT SUM(PRESUPUESTO_mensual) FROM MAESTROS_CCC WHERE CVE_MAESTRO = '$cvem') as totccs
					 FROM MAESTROS M WHERE CLAVE = '$cvem'";
		$rs=$this->QueryObtieneDatosN();

		//echo $this->query;
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	 function traeStatusClie($cliente){
    	$this->query="SELECT cl.*, m.id as idm
    					FROM CLIE01  cl
    					inner join maestros  m  on m.clave = cl.cve_maestro
    					WHERE trim(cl.CLAVE) = trim('$cliente')";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function traeSolicitudesR($cliente){
    	$this->query="SELECT COUNT(CVE_CLPV) FROM SOL_CLIENTES WHERE STATUS = 1 and cve_clpv = '$cliente'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$sol=$row->COUNT;
    	return $sol;
    }

    function traeSolicitudesC($cliente){
    	$this->query="SELECT COUNT(CVE_CLPV) FROM SOL_CLIENTES WHERE STATUS = 2 and cve_clpv = '$cliente' ";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$sol=$row->COUNT;
    	return $sol;	
    }

     function traeDatacliente($cliente){
        $this->query= "SELECT c.nombre, rfc, telefono, fax, emailpred,clave,lista_prec,v.nombre as vendedor,descuento, (iif(calle is null, '', calle ||', ')|| iif(numext is null, '',numext|| ', ') || iif(numint is null, '',numint||', ')|| iif(municipio is null, '', municipio||', ')|| iif(estado is null, '', estado||', ')||iif(pais is null, '',pais||', ')||iif(codigo is null, '', codigo) ) as direccion, c.diascred, 
            c.banco_deposito, c.banco_origen, c.refer_edo, c.metodo_pago
                FROM clie01 c left join vend01 v on c.cve_vend = v.cve_vend WHERE trim(c.clave) =trim('$cliente')";
                //echo $this->query;
        $resultado = $this->QueryObtieneDatosN();
        while($tsArray = ibase_fetch_object($resultado)){
            $data[] = $tsArray;
        }
        //var_dump($this->query);
        return $data;
    }

    function SaldosDelCliente($cliente){
        $this->query="SELECT ca.linea_cred,
                                ca.plazo,
                                c.limcred as linea_cred,
                            (select sum((p.cant_orig - p.empacado) * p.costo) from preoc01 p where clien = c.clave and (P.status = 'B' or p.status ='D' or p.status = 'X' or p.status = 'N') and fechasol > '01.10.2017') as comprometido,
                            (select sum (saldofinal) from facturas where cve_clpv = c.clave and vencimiento is null and saldofinal > 10) as comprometido2,
                            (select sum (saldofinal) from facturas where cve_clpv = c.clave and vencimiento < 0 and vencimiento is not null and saldofinal > 10) as Cobranza,
                            (select sum(saldofinal) from facturas where cve_clpv = c.clave and vencimiento > 0 and vencimiento < 29 and saldofinal > 10) as vencido,
                            (select sum(saldofinal) from facturas where cve_clpv = c.clave and vencimiento >= 29 and saldofinal > 10) as extraJudicial
                        FROM clie01 c 
                        left JOIN cartera ca on ca.idcliente = c.clave 
                        where trim(c.clave) = trim('$cliente')";
        //echo $this->query;
        $resultado = $this->QueryObtieneDatosN();
        while($tsArray = ibase_fetch_object($resultado)){
            $data[] = $tsArray;
        }
        return $data;
    }


    function saldoVencidoCliente($cliente){
        $this->query="SELECT SUM(SALDOFINAL) as saldovencido from factf01 WHERE trim(cve_clpv) = trim($cliente)";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $saldoVencido=$row->SALDOVENCIDO;
        return $saldoVencido;
    }

    function saldoComprometido($cliente){
        $this->query="SELECT SUM(IMPORTE) as Saldo 
                        FROM FACTP01 
                        WHERE trim(CVE_CLPV) = trim($cliente) 
                        and (doc_sig is null or doc_sig = '')";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $saldoSinSig= $row->SALDO;

        $this->query="SELECT SUM(p.IMPORTE) as saldo 
                        FROM FACTP01 p
                        inner join factf01 f on p.doc_sig = f.cve_doc and  
                        WHERE TRIM(CVE_CLPV) = TRIM($cliente)";
        return $saldoComprometido;
    }

    function saldoCliente($cliente){
        $this->query = "SELECT SUM(SALDOFINAL) as saldo FROM FACTF01 WHERE TRIM(CVE_CLPV) = TRIM($cliente)";
        $rs=$this->QueryObtieneDatosN();
        $row = ibase_fetch_object($rs);
        $saldo = $row->SALDO;
        return $saldo;
    }
    
    function ContactosDelCliente($cliente){     //12072016
        $this->query="SELECT ncontacto,nombre,direccion,telefono,email,tipocontac FROM contac01 WHERE cve_clie = '$cliente'";
        $resultado = $this->QueryObtieneDatosN();
        while($tsArray = ibase_fetch_object($resultado)){
            $data[] = $tsArray;
        }
        return $data;
    }

    function traeSaldosDoc($cliente, $historico){     //12072016 
        if($historico =='Si'){	
        $this->query="SELECT  f.cve_clpv,
                        f.cve_doc,
                        f.fechaelab,
                        f.fecha_cr,
                        f.fecha_vencimiento,
                        'Guia' as guia,
                        f.importe,
                        datediff(day, current_timestamp, f.fecha_vencimiento) as dias , 
                        f.contrarecibo_cr,
                        f.cve_pedi as pedido,
                        f.saldofinal,
                        f.aplicado,
                        f.importe_nc,
                        f.id_pagos,
                        f.nc_aplicadas,
                            iif(f.id_pagos = '' or f.id_pagos is null,0,
                        ((select (FOLIO_X_banco||' $ '||cast(monto as decimal(7,2)))
                        from carga_pagos where
                        id = iif( char_length(f.id_pagos) = 1,substring(f.id_pagos from 1 for 1),
                        iif(char_length(f.id_pagos) = 2,substring(f.id_pagos from 1 for 2),
                        iif(char_length(f.id_pagos) = 3,substring(f.id_pagos from 1 for 3),
                        iif(char_length(f.id_pagos) = 4, substring(f.id_pagos from 1 for 4),
                        iif(char_length(f.id_pagos) = 5, substring(f.id_pagos from 1 for 5),
                            '0')))))))) as info_pago
                        FROM  factf01 f
                        WHERE trim(f.cve_clpv) = trim('$cliente')
                        and f.status <> 'C'
                        and (deuda2015 = 1 or deuda2015 is null or deuda2015 = 0)
                        order by f.fecha_vencimiento asc";
                        //echo $this->query;
        }else{
            $this->query="SELECT  f.cve_clpv,
                        f.cve_doc,
                        f.fechaelab,
                        f.fecha_cr,
                        (select fecha_INI_COB from facturas fa where fa.cve_doc = f.cve_doc) as fecha_INI_COB,
                        'Guia' as guia,
                        f.importe,
                        (select vencimiento from facturas fa where fa.cve_doc = f.cve_doc) as dias, 
                        f.contrarecibo_cr,
                        f.cve_pedi as pedido,
                        f.saldofinal,
                        f.aplicado,
                        f.importe_nc,
                        f.id_pagos,
                        f.nc_aplicadas, 
                        iif(f.id_pagos = '' or f.id_pagos is null,0,
                        ((select (FOLIO_X_banco||' $ '||cast(monto as decimal(7,2)))
                        from carga_pagos where
                        id = iif( char_length(f.id_pagos) = 1,substring(f.id_pagos from 1 for 1),
                        iif(char_length(f.id_pagos) = 2,substring(f.id_pagos from 1 for 2),
                        iif(char_length(f.id_pagos) = 3,substring(f.id_pagos from 1 for 3),
                        iif(char_length(f.id_pagos) = 4, substring(f.id_pagos from 1 for 4),
                        iif(char_length(f.id_pagos) = 5, substring(f.id_pagos from 1 for 5),
                            '0')))))))) as info_pago
                        FROM  factf01 f
                        left join aplicaciones a on f.cve_doc = a.documento  and a.cancelado = 0 
                        WHERE trim(f.cve_clpv) = trim('$cliente') and saldoFinal > 2 
                        and f.status <> 'C' 
                        and (deuda2015 = 1 or deuda2015 is null or deuda2015 = 0)
                        and extract(year from f.fecha_doc) >= 2016
                        order by f.fecha_vencimiento asc";
                        //echo $this->query;
        }
        $resultado = $this->QueryObtieneDatosN();
        //echo $this->query;
        while($tsArray = ibase_fetch_object($resultado)){
            $data[] = $tsArray;
        }
        return $data;
    }

    function solCorte($cveclie){
        $usuario=$_SESSION['user']->NOMBRE;
        $this->query ="INSERT INTO SOL_CLIENTES (ID, CVE_CLPV, FECHA_SOL, USUARIO_SOL, FECHA_RES, USUARIO_RES, STATUS) 
                                VALUES (NULL, '$cveclie', current_timestamp, '$usuario', null, '', 2)";
        $rs=$this->EjecutaQuerySimple();

        return;
    }

    function solRestriccion($cveclie){
        $usuario=$_SESSION['user']->NOMBRE;
        $this->query ="INSERT INTO SOL_CLIENTES (ID, CVE_CLPV, FECHA_SOL, USUARIO_SOL, FECHA_RES, USUARIO_RES, STATUS) 
                              VALUES (NULL, '$cveclie', current_timestamp, '$usuario', null, '', 1)";
        $rs=$this->EjecutaQuerySimple();

        return;
    }
    function saldoIndividual($cve_maestro){
        //$this->query="SELECT sum(saldofinal) as s166,
        //            (max(c.nombre)||'( '||trim(max(c.clave))||' )') as nombre,
        //            c.clave as clave,
        //            max(c.identificador_maestro) as idm,
        //            max(c.clave) as cc, max(c.diascred) as plazo,
        //            max(c.limcred) as linea_cred,
        //            (select sum((p.cant_orig - p.empacado) * p.costo) from preoc01 p where clien = c.clave and (P.status = 'B' or p.status ='D' or p.status = 'X' or p.status = //'N') and fechasol > '01.10.2017') as comprometido,//
        //            //
        //            //coalesce ((select sum (saldofinal) from facturas where cve_clpv = c.clave and vencimiento is not null and saldofinal > 10), 0) +//
        //            //coalesce((select sum(saldofinal) from facturas_fp) where cve_clpv = c.clave and vencimiento is not null and saldofinal > 10), 0) //
        //            //as comprometido2,//
//
//        //            (select sum (saldofinal) from facturas where cve_clpv = c.clave and vencimiento < 0 and vencimiento is not null and saldofinal > 10) as Cobranza,
//        //            (select sum(saldofinal) from facturas where cve_clpv = c.clave and vencimiento > 0 and vencimiento < 29 and saldofinal > 10) as vencido,
//        //            (select sum(saldofinal) from facturas where cve_clpv = c.clave and vencimiento >= 29 and saldofinal > 10) as extraJudicial
//        //            FROM FACTF01 f left join clie01 c on c.clave= f.cve_clpv
//        //            WHERE c.cve_maestro = '$cve_maestro' and f.status <> 'C' group by c.clave";
        //    //echo $this->query;
        

        $this->query="SELECT c.* FROM clie01 c where c.cve_maestro = '$cve_maestro'";
        $rs = $this->QueryObtieneDatosN();
        while($tsArray=ibase_fetch_object($rs)){
            $data[]=$tsArray;
        }

        foreach ($data as $key ) {
            $cliente = $key->CLAVE_TRIM;
            $plazo =$key->DIASCRED;
            /// Comprometido
                $this->query ="SELECT sum((p.cant_orig - p.empacado) * p.costo) as saldofinal from preoc01 p where clien = '$cliente' and (P.status = 'B' or p.status ='D' or p.status = 'X' or p.status = 'N') and fechasol > '01.10.2017'";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $comprometido= $row->SALDOFINAL;
            //// Comprometido2
                $this->query ="SELECT coalesce(sum(saldofinal), 0) as saldofinal from facturas where cve_clpv = '$cliente' and vencimiento is not null and saldofinal > 10";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $compFact= $row->SALDOFINAL;
                $this->query ="SELECT coalesce(sum(saldofinal), 0) as saldofinal from facturas_fp where cve_clpv = '$cliente' and vencimiento is not null and saldofinal > 10";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $compFactFP= $row->SALDOFINAL;
            /// 
            ///Cobranza 
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldoFinal from facturas where cve_clpv = '$cliente' and vencimiento < 0 and vencimiento is not null and saldofinal > 10";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $cobFact= $row->SALDOFINAL;
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldofinal from facturas_fp where cve_clpv = '$cliente' and vencimiento < 0 and vencimiento is not null and saldofinal > 10";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $cobFactFP= $row->SALDOFINAL;
            ////
            ////Vencido
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldoFinal from facturas where cve_clpv = '$cliente' and vencimiento > 0 and vencimiento < 29 and saldofinal>5";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $vencidoFact= $row->SALDOFINAL;
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldofinal from facturas_fp where cve_clpv = '$cliente' and vencimiento > 0 and vencimiento < 29 and saldofinal>5";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $vencidoFactFP= $row->SALDOFINAL;
            /// extrajudicial
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldoFinal from facturas where cve_clpv = '$cliente' and vencimiento >= 29 and saldofinal > 5";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $judicialFact= $row->SALDOFINAL;
                $this->query ="SELECT coalesce(sum(saldofinal),0) as saldofinal from facturas_fp where cve_clpv = '$cliente' and vencimiento >= 29 and saldofinal > 5";
                $rs=$this->EjecutaQuerySimple();
                $row =ibase_fetch_object($rs);
                $judicialFactFP= $row->SALDOFINAL;

            //echo $cliente.'Comprometido facturas'.$compFact.' Comprometido Facturas Fp'.$compFactFP.' cobranza factutas'.number_format($cobFact,2,".","").' cobranza Facturas FP: '.number_format($cobFactFP,2,".","").', vencido: '.$vencidoFact.' vencido FP: '.$vencidoFactFP.' Judicial:'.$judicialFact.', Judicial FP: '.$judicialFactFP.'<br/>';
            $datos[]=array('CLIENTE'=>'('.$cliente.') '.$key->NOMBRE,'COMPROMETIDO'=>$comprometido,'PLAZO'=>$plazo, 'COMPROMETIDO2'=>$compFactFP + $compFact, 'VENCIDO'=>$vencidoFact+$vencidoFactFP, 'EXTRAJUDICIAL'=> $judicialFact+ $judicialFactFP, 'LINEA_CRED'=>$key->LIMCRED, 'CC'=>'', 'CLAVE'=>$key->CLAVE);
        }
       
        return $datos;   
    }

    function saldoIndMaestro($cve_maestro){
        $this->query = "SELECT * FROM MAESTROS WHERE CLAVE = '$cve_maestro'";
        $rs=$this->QueryObtieneDatosN();
        while($tsArray = ibase_fetch_object($rs)){
            $data[]=$tsArray;
        }
        return $data;       
    }

    function facturasMaestro($cve_maestro, $tipo){
        $data = array();
        $c='';
        if($tipo == 'v'){
            $c=" f.saldofinal > 3 and f.CLAVE_MAESTRO = '".$cve_maestro."' and f.vencimiento is not null ";
        }elseif($tipo == 'sv'){
            $c=" f.saldofinal > 3 and f.CLAVE_MAESTRO = '".$cve_maestro."' and f.vencimiento is null ";
        }elseif ($tipo == 'ccd') {
            $c = ' f.saldofinal > 3 and f.c_compras = '.$cve_maestro;
        }elseif($tipo == 't'){
            $c = " f.saldofinal > 3 and f.CLAVE_MAESTRO ='".$cve_maestro."'";
        }elseif($tipo == 'h'){
            $c=" f.CLAVE_MAESTRO = '".$cve_maestro."' ";
        }
        $this->query="SELECT * FROM FACTURAS f LEFT JOIN FTC_REGISTRO_COBRANZA RC ON RC.DOCUMENTO = f.cve_doc and rc.MARCA = 'S' 
                    WHERE $c
                      order by f.fechaelab, f.vencimiento";
        $rs = $this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
        $this->query="SELECT * FROM FACTURAS_FP f LEFT JOIN FTC_REGISTRO_COBRANZA RC ON RC.DOCUMENTO = f.cve_doc and rc.MARCA = 'S' 
                    WHERE $c
                      order by f.fechaelab, f.vencimiento";
        //echo $this->query;
        $rs = $this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
            
        return $data;
    }

    function factMaestro($cve_maestro){
        $data = array();
        $this->query="SELECT * FROM FACTURAS_FP f LEFT JOIN FTC_REGISTRO_COBRANZA RC ON RC.DOCUMENTO = f.cve_doc and rc.MARCA = 'S' 
                    WHERE f.CLAVE_MAESTRO = '$cve_maestro' order by f.vencimiento";
        $rs = $this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
        return $data;   
    }

    function detalleComprometidoCot($cliente){
        $data=array();
        $this->query="SELECT  P.*, (SELECT fecha_almacen FROM cajas_almacen WHERE COTIZACION = COTIZA) AS FECHA_LIB 
                FROM  preoc01 P 
                where P.clien = '$cliente' 
                and cant_orig > empacado 
                and (P.status = 'B' or p.status ='D' or p.status = 'X' or p.status = 'N')
                and fechasol > '01.10.2017'";
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function detalleComprometidoFac($cliente){
        $data=array();
        $this->query="SELECT * FROM FACTURAS WHERE cve_clpv = '$cliente' and vencimiento is null and saldofinal > 10";
        $rs = $this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }


    function detalleCobranzaCliente($cliente){
        $data=array();
        $this->query="SELECT * FROM FACTURAS WHERE cve_clpv = '$cliente' and vencimiento is not null and saldofinal > 10";
        $rs = $this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }
    function docsVencidosCartera(){
        //$usuario= $_SESSION['user']->NOMBRE;
        //$rol = $_SESSION['user']->LETRA;
        $this->query="SELECT SUM(SALDOFINAL) AS COBRANZA,
                      (SELECT SUM(SALDOFINAL)  FROM FACTURAS_PENDIENTES WHERE  VENCIMIENTO >= 0 AND VENCIMIENTO <= 7) AS SEMANA,
                      (SELECT SUM(SALDOFINAL)  FROM FACTURAS_PENDIENTES WHERE  VENCIMIENTO >= 8 AND VENCIMIENTO <= 28) AS MES,
                      (SELECT SUM(SALDOFINAL)  FROM FACTURAS_PENDIENTES WHERE  VENCIMIENTO >= 29 ) AS EJ,
                      (SELECT REMISIONES FROM TOTAL_REMISIONES ) AS REMISIONES
                      FROM FACTURAS f WHERE SALDOFINAL > 10 ";
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function detalleCobranza($maestro, $tipo){
        $usuario=$_SESSION['user']->NOMBRE;
        $tipoUsuario = $_SESSION['user']->LETRA;
        if($tipoUsuario != 'G' and substr($tipoUsuario, 0, 1) == 'R' ){
            $cartera = " where c_revision = '".$tipoUsuario."'";
            $carteraDetalle = " and c_revision = '".$tipoUsuario."'";
        }elseif($tipoUsuario != 'G' and substr($tipoUsuario, 0,1) == 'C'){
            $cartera = " where c_cobranza = '".$tipoUsuario."'";
            $carteraDetalle = " and c_cobranza = '".$tipoUsuario."'";
        }else{
            $cartera = '';
            $carteraDetalle='';
        }
        $this->query="SELECT clave_maestro, count(cve_doc) as documentos, (SELECT MAX(NOMBRE) FROM MAESTROS WHERE CLAVE = CLAVE_MAESTRO) AS NOMBRE
                      FROM FACTURAS_PENDIENTES $cartera GROUP BY CLAVE_MAESTRO";
        $rs=$this->EjecutaQuerySimple();  
            while ($tsArray=ibase_fetch_object($rs)){
                $data[]=$tsArray;        
            }
            foreach ($data as $key) {
                $maestro=$key->CLAVE_MAESTRO;
                $semanal = $key->DOCUMENTOS;
                $nombre = $key->NOMBRE;
                $this->query="SELECT COUNT(F.CVE_DOC) AS DOCUMENTOS, SUM(F.SALDOFINAL) AS MONTOTOT, 
                            (SELECT SUM(F1.SALDOFINAL) FROM FACTURAS_PENDIENTES F1 where F1.VENCIMIENTO >= 8 and F1.VENCIMIENTO <= 28 AND clave_maestro = '$maestro' $carteraDetalle) AS MONTOTOTAL,
                            (SELECT SUM(F2.SALDOFINAL) FROM FACTURAS_PENDIENTES F2 where F2.VENCIMIENTO >= 29 and clave_maestro = '$maestro' $carteraDetalle) AS ej,
                            (SELECT SUM(F3.SALDOFINAL) FROM FACTURAS_PENDIENTES F3 where F3.VENCIMIENTO >= 0 and F3.VENCIMIENTO <= 7 AND clave_maestro = '$maestro' $carteraDetalle) AS SEMANAL
                            FROM FACTURAS_PENDIENTES F WHERE CLAVE_MAESTRO = '$maestro' $carteraDetalle ";
                $res=$this->EjecutaQuerySimple();
                $row=ibase_fetch_object($res);
                $documentos = $row->DOCUMENTOS;
                $montoTotal = $row->MONTOTOTAL;
                $datos[]=array("maestro"=>$maestro, "semanal"=>$semanal, "nombre"=>$nombre, "documentos"=>$documentos, 'montoSemanal'=>$row->SEMANAL, "mensual"=>$montoTotal, "ej"=>$row->EJ);                
            }   
        return $datos;
    }

    function marcaDoc($doc, $tipo){
        $usuario=$_SESSION['user']->NOMBRE;
        if($tipo=='S'){
            $this->query="SELECT MARCA, USUARIO, FECHA FROM FTC_REGISTRO_COBRANZA WHERE DOCUMENTO = '$doc' AND MARCA = 'S'";
            $rs=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($rs);
            if(!empty($row)){
                return $mensaje=array("status"=>'no',"usuario"=>$row->USUARIO,"fecha"=>$row->FECHA);
            }else{
                $this->query="INSERT into FTC_REGISTRO_COBRANZA (id, usuario, fecha, documento, aplicacion, monto_aplicacion, marca) values (null, '$usuario', current_timestamp, '$doc', '',0,'S')";
                $this->grabaBD();
                return $mensaje=array("status"=>'ok',"usuario"=>$usuario, "fecha"=>'');
            }    
        }else{
            $this->query="UPDATE FTC_REGISTRO_COBRANZA SET MARCA ='B' WHERE DOCUMENTO = '$doc' and MARCA = 'S' and usuario = '$usuario'";
            $this->grabaBD();
            return $mensaje=array("status"=>'ok',"usuario"=>$usuario,"fecha"=>'BORRADO');
        }
        
    }

    function infoDocumentos($items){
        $data=array();
        $doc=explode(',', $items);
        for ($i=0; $i < count($doc); $i++) { 
            $docf = $doc[$i];
            $this->query="SELECT * from FACTURAS  where trim(cve_doc) = trim('$doc[$i]')";
            $rs=$this->EjecutaQuerySimple();
            while($tsArray=ibase_fetch_object($rs)){
                $data[]=$tsArray;
            }
            $this->query="SELECT * from FACTURAS_FP  where trim(cve_doc) = trim('$doc[$i]')";
            $rs=$this->EjecutaQuerySimple();
            while($tsArray=ibase_fetch_object($rs)){
                $data[]=$tsArray;
            }
        }
        //exit(var_dump($data));
        return $data;
    }

    function bancos(){
        $data=array();
        $this->query="SELECT * FROM PG_BANCOS";
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function verPagos3($pagos, $mes, $anio){
        if($mes != ''){
            $this->query="SELECT * FROM CARGA_PAGOS WHERE UPPER(BANCO) CONTAINING UPPER('$pagos') and extract(month from fecha_recep ) = $mes and extract(year from fecha_recep) = $anio and tipo_pago is null and status<>'C'";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
        }else{
            $this->query="SELECT * FROM CARGA_PAGOS WHERE MONTO CONTAINING ('$pagos')";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
            $this->query="SELECT * FROM CARGA_PAGOS WHERE UPPER(FOLIO_X_BANCO) CONTAINING UPPER('$pagos')";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($rs)) {
                $data[]=$tsArray;
            }
        }   

        return @$data;      
    }

    function guardaComprobante($target_file, $items, $idp){
        $documento = explode(",", $items);
        for ($i=0; $i < count($documento); $i++){ 
            $this->query="UPDATE CAJAS SET STATUS_RECEPCION = 77 WHERE FACTURA = '$documento[$i]' ";
            $rs=$this->EjecutaQuerySimple();
            $this->query="UPDATE carga_pagos set ARCHIVO = '$target_file' where id = $idp";
            $rs=$this->EjecutaQuerySimple();
            $this->query="UPDATE FTC_REGISTRO_COBRANZA SET MARCA = 'A' WHERE DOCUMENTO = '$documento[$i]' and MARCA = 'S'";
            $rs=$this->EjecutaQuerySimple();
        }
        return;
    }

    function verComprobantesPago($docf){
        $data=array();
        $this->query="SELECT * FROM APLICACIONES a left join CARGA_PAGOS cp ON cp.id = a.idpago WHERE DOCUMENTO = '$docf'";
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }

  function seguimientoCajasRecibir($tipo){
        $usuario=$_SESSION['user']->NOMBRE;
        $tipoUsuario= $_SESSION['user']->LETRA;
        $rojo = '<font color="red">';
        $frojo ='</font>';
        $azul = '<font color="blue">';
        $fazul = '</font>';

        $this->query="SELECT * FROM PG_USERS WHERE NOMBRE = '$usuario'";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        $cartera = $row->CC;
        $recibidos = '';
        $cr = '';
        $a = '';
        //exit('Tipo de Usuario'.$tipoUsuario);
        if(substr($tipoUsuario,0,1) == 'R'){
            $cr = ") and m.cartera_revision = '".$tipoUsuario."'";
            $a = '(';
            //ventasleon@biotecsa.com
        }elseif(substr($tipoUsuario,0,1) == 'C'){
            $cr = ") and m.cartera = '".$tipoUsuario."'";
            $a = '(';
        }
        
        if($tipo==6 or $tipo == 62){
            $recibidos = " or STATUS_RECEPCION = 61 or STATUS_RECEPCION = 5";
            //$tipo = "6 or STATUS_RECEPCION = 5 ";
            $campo = 'm.cartera_revision';

        }elseif($tipo==7 or $tipo == 72){
            $recibidos=" or STATUS_RECEPCION = 71";
            $campo = 'cartera';
           
        }

        if($tipo == 6 ){
          $this->query="SELECT count(ca.id) as documentos ,  max(c.cve_maestro), $campo as cartera, 
                        coalesce(sum(f.saldofinal), sum(fp.saldofinal)) as facturas, sum(r.importe) as remisiones
                        from cajas ca
                        left join factp01 p on p.cve_doc = ca.cve_fact
                        left join clie01 c on c.clave = p.cve_clpv
                        left join maestros m on c.cve_maestro = m.clave
                        left join facturas f on f.cve_doc = ca.factura
                        left join factr01 r on r.cve_doc = ca.remision --and r.enlazado != 'T' and r.status != 'C'
                        left join facturas_fp fp on fp.cve_doc = ca.factura
                        where STATUS_RECEPCION = $tipo $recibidos
                        group by $campo";
               //echo 'Tipo = 6 '.$this->query.' ---Finaliza';

        }elseif($tipo == 62){
            $tipo = 6;
            $this->query="SELECT F.*, C.*, CT.*, cl.*, iif(factura = '' or factura is null, remision, factura) as documento,
                (select count(id) from FTC_COMPROBANTES_RECIBO where idcaja = C.ID) as archivos, 
                datediff(day, C.fecha_rev, CURRENT_DATE) as dias, 
                coalesce((select FIRST 1 saldoFinal from facturas fa where fa.cve_doc = C.FACTURA),
                (select FIRST 1 ffp.saldoFinal from facturas_fp ffp where ffp.cve_doc = C.FACTURA)) AS SALDOFINAL,
                (SELECT FIRST 1 importe from factr01 r where r.cve_doc = C.REMISION ) AS IMPREM,
                (select sum((cantidad * precio) - ((cantidad * precio) * descuento / 100)) * 1.16 
                    from detalle_caja where idcaja = C.ID
                ) as imppf,

                M.CARTERA_REVISION AS C_REVISION,
               (SELECT ('('||ID||') Fecha: '||FECHA_SOLICITUD||' usuario: '||USUARIO_SOLICITUD||', status: <b>'||iif(STATUS_SOLICITUD= 0, 'Pendiente',
                            iif(STATUS_SOLICITUD = 1, 
                                    ('$azul'||'Autorizado'||'$fazul'),
                                    iif(STATUS_SOLICITUD =2,
                                        'Autorizado / Sin Nota de Credito',
                                            iif(STATUS_SOLICITUD = 3,
                                                ('$rojo'||'Rechazado'||'$frojo'),
                                                    iif(STATUS_SOLICITUD = 4,
                                                        'Autorizado / Ejecutado',
                                                         'Listo para Refactura')
                                                )
                                        )
                            )
                            ) ||'</b>) Fecha Ejecuta: '||iif(fecha_ejecuta is null, '', fecha_ejecuta)) FROM REFACTURACION WHERE FACT_ORIGINAL = c.factura) as INFOREFACT, 
                COALESCE(
                cast((SELECT list(NC.DOCUMENTO) FROM FTC_NC NC WHERE NC.IDCAJA = C.ID) as varchar(100)),
                cast((SELECT list(NCI.DOCUMENTO) FROM FTC_NCI NCI WHERE NCI.IDCAJA = C.ID) as varchar(100)
                    )
                    ) AS NCP 
                FROM CAJAS C 
                LEFT JOIN FACTP01 F  ON F.CVE_DOC = C.CVE_FACT 
                LEFT JOIN CARTERA CT ON CT.IDCLIENTE = F.CVE_CLPV
                left join clie01 cl on cl.clave = f.cve_clpv
                left join maestros m on m.clave = cl.cve_maestro
                WHERE $a STATUS_RECEPCION = $tipo $recibidos
                $cr";
                //echo 'Tipo = 62 '.$this->query;

        }elseif($tipo == 7){
                $this->query="SELECT F.*, C.*, CT.*, cl.*, iif(factura = '' or factura is null, remision, factura) as documento,
                (select count(id) from FTC_COMPROBANTES_RECIBO where idcaja = C.ID) as archivos, 
                datediff(day, C.fecha_rev, CURRENT_DATE) as dias, 
                (select FIRST 1 saldoFinal from facturas fa where fa.cve_doc = C.FACTURA) AS SALDOFINAL,
                (SELECT FIRST 1 importe from factr01 r where r.cve_doc = C.REMISION ) AS IMPREM,
                 M.CARTERA AS C_COBRANZA,
              (SELECT ('('||ID||') Fecha: '||FECHA_SOLICITUD||' usuario: '||USUARIO_SOLICITUD||', status: <b>'||iif(STATUS_SOLICITUD= 0, 'Pendiente',
                            iif(STATUS_SOLICITUD = 1, 
                                    ('$azul'||'Autorizado'||'$fazul'),
                                    iif(STATUS_SOLICITUD =2,
                                        'Autorizado / Sin Nota de Credito',
                                            iif(STATUS_SOLICITUD = 3,
                                                ('$rojo'||'Rechazado'||'$frojo'),
                                                    iif(STATUS_SOLICITUD = 4,
                                                        'Autorizado / Ejecutado',
                                                         'Listo para Refactura')
                                                )
                                        )
                            )
                            ) ||'</b>) Fecha Ejecuta: '||iif(fecha_ejecuta is null, '', fecha_ejecuta)) FROM REFACTURACION WHERE FACT_ORIGINAL = c.factura) as INFOREFACT
                        
                FROM CAJAS C 
                LEFT JOIN FACTP01 F  ON F.CVE_DOC = C.CVE_FACT 
                LEFT JOIN CARTERA CT ON CT.IDCLIENTE = F.CVE_CLPV
                left join clie01 cl on cl.clave = f.cve_clpv
                left join maestros m on m.clave = cl.cve_maestro
                WHERE $a STATUS_RECEPCION = $tipo $recibidos
                $cr";
        }
        //echo 'Tipo = '.$tipo.' --> '.$this->query.' Finaliza';
        $res=$this->EjecutaQuerySimple();

        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function saldosRevision(){
        $usuario=$_SESSION['user']->NOMBRE;
        $tipoUsuario= $_SESSION['user']->LETRA;
        $rojo = '<font color="red">';
        $frojo ='</font>';
        $azul = '<font color="blue">';
        $fazul = '</font>';

        $this->query="SELECT * FROM PG_USERS WHERE NOMBRE = '$usuario'";
            $res=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($res);
            $cartera = $row->CC;
            $recibidos = '';
            $cr = '';
            $a = '';
        //exit('Tipo de Usuario'.$tipoUsuario);
        if(substr($tipoUsuario,0,1) == 'R'){
            $cr = ") and m.cartera_revision = '".$tipoUsuario."'";
            $a = '(';
            //ventasleon@biotecsa.com
        }elseif(substr($tipoUsuario,0,1) == 'C'){
            $cr = ") and m.cartera = '".$tipoUsuario."'";
            $a = '(';
        }
        
        $this->query="SELECT F.*, C.*, CT.*, cl.*, iif(factura = '' or factura is null, remision, factura) as documento, (select count(id) from FTC_COMPROBANTES_RECIBO where idcaja = C.ID) as archivos, datediff(day, C.fecha_rev, CURRENT_DATE) as dias, coalesce((select FIRST 1 saldoFinal from facturas fa where fa.cve_doc = C.FACTURA), (select FIRST 1 ffp.saldoFinal from facturas_fp ffp where ffp.cve_doc = C.FACTURA)) AS SALDOFINAL, (SELECT FIRST 1 importe from factr01 r where r.cve_doc = C.REMISION ) AS IMPREM, 
            (select sum((cantidad * precio) - ((cantidad * precio) * descuento / 100)) * 1.16 from detalle_caja where idcaja = C.ID and c.remision starting with 'PF' and c.factura = ''  ) as imppf, 
            M.CARTERA_REVISION AS C_REVISION, 
            (SELECT ('('||ID||') Fecha: '||FECHA_SOLICITUD||' usuario: '||USUARIO_SOLICITUD||', status: '||iif(STATUS_SOLICITUD= 0, 'Pendiente', iif(STATUS_SOLICITUD = 1, (''||'Autorizado'||''), iif(STATUS_SOLICITUD =2, 'Autorizado / Sin Nota de Credito', iif(STATUS_SOLICITUD = 3, (''||'Rechazado'||''), iif(STATUS_SOLICITUD = 4, 'Autorizado / Ejecutado', 'Listo para Refactura') ) ) ) ) ||') Fecha Ejecuta: '||iif(fecha_ejecuta is null, '', fecha_ejecuta)) FROM REFACTURACION WHERE FACT_ORIGINAL = c.factura) as INFOREFACT FROM CAJAS C LEFT JOIN FACTP01 F ON F.CVE_DOC = C.CVE_FACT LEFT JOIN CARTERA CT ON CT.IDCLIENTE = F.CVE_CLPV left join clie01 cl on cl.clave = f.cve_clpv 
            left join maestros m on m.clave = cl.cve_maestro 
            WHERE $a STATUS_RECEPCION = 6 or STATUS_RECEPCION = 61 or STATUS_RECEPCION = 5 $cr";
            //echo '<br/>'.$this->query.'</br>';

        $res=$this->EjecutaQuerySimple();
        while ($tsArray= ibase_fetch_object($res)) {
            $data2[]=$tsArray;
        }
            $facturas = 0;
            $remisiones = 0;
            $prefacturas = 0;
        foreach ($data2 as $key) {
            $facturas += $key->SALDOFINAL;
            $remisiones += $key->IMPREM;
            $prefacturas += $key->IMPPF;
        }
        
        //echo '<br/>Facturas'.$facturas.'<br/>Remisiones'.$remisiones.'<br/>Prefacturas'.$prefacturas;
        return array("FACTURAS"=>$facturas,"REMISIONES"=>$remisiones,"PREFACTURAS"=>$prefacturas);
    }


    function pendientesAplicar(){
        $this->query="SELECT sum(saldo) as SALDO FROM Saldo_CARGA_PAGOS";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        $saldo = $row->SALDO;
        return $saldo;
    }

    function pendientesIdentificar(){
        $saldo = 0;
        $this->query="SELECT sum(saldo) as saldo from Saldo_CARGA_PAGOS where maestro not starting with 'Maestro'";
        $rs=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($rs);
        if($row){
            $saldo = $row->SALDO;
        }
        return $saldo;   
    }

   function verSaldosPagos($t){
        $data = array();
        if($t == 'a'){
            $this->query="SELECT * FROM Saldo_CARGA_PAGOS where saldo > 10 and Maestro starting with 'Maestro'";
        }else{
            $this->query="SELECT * FROM Saldo_CARGA_PAGOS where saldo > 10 and Maestro not starting with 'Maestro'";
        }
        $rs=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($rs)){
            $data[]=$tsArray;
        }
        return $data;
    }


    function creaSolRev($docf, $docp, $idc, $obs, $motivo){
        $usuario=$_SESSION['user']->NOMBRE;
        $this->query="SELECT count(STATUS_SOLICITUD) AS VALIDACION FROM REFACTURACION WHERE FACT_ORIGINAL = '$docf'";
        $res=$this->EjecutaQuerySimple();
        $row2=ibase_fetch_object($res);
        if($row2->VALIDACION == 0 ){
            $this->query="INSERT INTO REFACTURACION (ID, FACT_ORIGINAL, USUARIO_SOLICITUD, FECHA_SOLICITUD, STATUS_SOLICITUD, TIPO_SOLICITUD, NUEVA_FECHA, observaciones, CAJA ) VALUES (NULL, '$docf', '$usuario', current_timestamp, 0, '$motivo',current_timestamp, '$obs', $idc )";
            //echo 'Inserta refacturacion: '.$this->query.'<br/>';
            $this->grabaBD();
            $this->query="INSERT INTO REFACTURACION_DETALLE (ID_REFAC, NUEVA_FECHA, OBSERVACIONES) VALUES ( (SELECT MAX(ID) FROM REFACTURACION), current_timestamp, '$obs' )";
            //echo 'Inserta Partida: '.$this->query;
            $this->grabaBD();    
            $mensaje=array('status'=>'ok');
        }else{
            $this->query="SELECT * FROM REFACTURACION WHERE FACT_ORIGINAL ='$docf'";
            $rs=$this->EjecutaQuerySimple();
            $d = ibase_fetch_object($rs);
            $mensaje=array('status'=>'No',"texto"=>'Se encuentra en proceso de refacturacion, desde el '.$d->FECHA_SOLICITUD.', por el usuario '.$d->USUARIO_SOLICITUD);
        }
        return $mensaje;
    } 

    function acreedorMaestro($maestro){
        $data = array();
        $this->query="SELECT * FROM CARGA_PAGOS WHERE CLIENTE='$maestro' AND SALDO > 10 ";
        $rs =$this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function envFac($docf){
        $this->query="SELECT * FROM FACTURAS_FP WHERE CVE_DOC = '$docf'";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        return $row; 
    }   

    function traeMaestros(){
        $data= array();
        $this->query="SELECT m.* FROM MAESTROS m  WHERE status = 'A' ORDER BY ACREEDOR DESC, NOMBRE ASC ";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function valida($m, $monto, $idp){
        $this->query="SELECT coalesce(SUM(SALDOFINAL),0) as SALDO, coalesce((select sum(saldo) from carga_pagos where cliente = '$m'),0) as acreedores FROM FACTURAS_PENDIENTES WHERE CLAVE_MAESTRO = (SELECT CLAVE FROM MAESTROS WHERE ID = $m)";
        $res =$this->EjecutaQuerySimple();
        $valsaldo=ibase_fetch_object($res);
        $val = $valsaldo->SALDO;
        $acreedores = $valsaldo->ACREEDORES;
        $monto1=$monto + $acreedores;
                
        $this->query="SELECT coalesce(SUM(SALDOFINAL),0) as SALDO FROM FACTURAS_PENDIENTES_FP WHERE CLAVE_MAESTRO = (SELECT CLAVE FROM MAESTROS WHERE ID = $m)";
        $res2 =$this->EjecutaQuerySimple();
        $valsaldo2=ibase_fetch_object($res2);
        $val2 = $valsaldo2->SALDO;
        $val = $val + $val2;
        
        if($val > $monto1){
            $this->query="UPDATE MAESTROS SET ACREEDOR = ACREEDOR + $monto where id = $m";
            $res=$this->queryActualiza();
            if($res == 1){
                $this->query="UPDATE CARGA_PAGOS SET CLIENTE = $m where id = $idp";
                $this->queryActualiza();
                $mensaje= 'Se agrego correctamente el pago';
                return array("status"=>'ok', "mensaje"=>$mensaje);
            }else{
                $mensaje = 'No se actualizo el saldo del cliente, favor de reportar a sistemas';
                return array("status"=>'no', "mensaje"=>$mensaje);
            }    
        }else{
            return array("status"=>'No', "mensaje"=>'El Valor del saldo del cliente $ '.number_format($val,2).' es menor a la suma de los acreedores $ '.number_format($acreedores,2).' mas el pago seleccionado $ '.number_format($monto,2).'.' );
        }    
    }

    function cancelaAplicacion($ida, $doc, $idp){
        $usuario=$_SESSION['user']->NOMBRE;
        $this->query="UPDATE APLICACIONES SET STATUS = 'C', cancelado = 1  WHERE ID= $ida and documento = '$doc' and status != 'C' and cancelado = 0";
        $res=$this->queryActualiza();
        if($res == 1){
            $this->query="UPDATE CARGA_PAGOS SET SALDO = MONTO-coalesce((SELECT SUM(MONTO_APLICADO) FROM APLICACIONES 
                            WHERE IDPAGO=$idp and status!='C'),0), APLICACIONES=COALESCE((SELECT SUM(MONTO_APLICADO) FROM APLICACIONES 
                            WHERE IDPAGO=$idp and status!='C'),0) where id = $idp";
            $result=$this->queryActualiza();
            $this->desaplicarAplicacion($ida, $doc, $idp);
            if($result == 1){
                return array("status"=>'ok',"mensaje"=>'Se ha desaplicado la factura');
            }else{
                $this->query="INSERT INTO FTC_CANCELACIONES(ID, FACTURA_ORIGINAL, FECHA_CANCELA, USUARIO_CANCELA, FACTURA_NUEVA) 
                                    VALUES (NULL, '$idp',current_timestamp,'$usuario', 'Pago')";
                $this->grabaBD();
                return array("status"=>'No',"mensaje"=>'Existio un problema en la actualizacion del monto del pago se aviso a sistemas.');
            }
        }elseif($res == 0){
                $this->query="INSERT INTO FTC_CANCELACIONES(ID, FACTURA_ORIGINAL, FECHA_CANCELA, USUARIO_CANCELA, FACTURA_NUEVA) 
                                    VALUES (NULL, '$ida',current_timestamp,'$usuario', 'Aplicacion')";
                $this->grabaBD();
            return array("status"=>'No',"mensaje"=>'Al parecer esta aplicacion ya ha sido cancelada con anterioridad.');
        }
    }

    function traeDocumentos($sel, $maestro){
        $data = array();
        if($sel == 'Si'){
            $this->query="SELECT rc.*, f.*, (select nombre from maestros where id = $maestro) as nombre_maestro 
                                FROM FTC_REGISTRO_COBRANZA RC 
                                LEFT JOIN FACTURAS F ON F.CVE_DOC = RC.DOCUMENTO
                                WHERE clave_MAESTRO = '$maestro' and rc.MARCA= 'S' and f.cve_doc is not null";
            $res=$this->EjecutaQuerySimple();
            while ($tsArray= ibase_fetch_object($res)) {
                $data[]=$tsArray;
            }
            $this->query="SELECT rc.*, fp.*, (select nombre from maestros where id = $maestro) as nombre_maestro
                                FROM FTC_REGISTRO_COBRANZA RC 
                                LEFT JOIN FACTURAS_FP FP ON FP.CVE_DOC = RC.DOCUMENTO
                                WHERE MAESTRO = '$maestro' and rc.MARCA= 'S' and fp.cve_doc is not null";
            $res=$this->EjecutaQuerySimple();
            while ($tsArray= ibase_fetch_object($res)) {
                $data[]=$tsArray;
            }
            /// Obtenermos los documentos solo los seleccionados;
        }elseif($sel == 'No'){
            $this->query="SELECT * FROM MAESTROS WHERE ID = $maestro";
            $res=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($res);
            $cve_maestro= $row->CLAVE;
            $data = $this->facturasMaestro($cve_maestro, 't');
            /// Obetenemos todos los documentos finalizados del mestro;
        }
        return $data;
    }

    function actAcr(){
        $this->query="execute procedure SALDO_COMPROMETIDO_MESTROS";
        $this->EjecutaQuerySimple();
        $this->query="UPDATE MAESTROS M SET ACREEDOR = (SELECT COALESCE(SUM(CP.saldo),0) FROM CARGA_PAGOS CP WHERE CAST(M.ID AS VARCHAR(20)) = CP.CLIENTE  and guardado>0 and seleccionado >0)";
        $res=$this->queryActualiza();
        if($res >=1){
            return array("status"=>'ok', "mensaje"=>'Se ha Actualizado Correctamente');
        }else{
            return array("status"=>'No', "mensaje"=>'Hay un problema al actualizar, favor de intentar mas tarde. Gracias');
        }
    }

    function facturasCliente($cliente, $tipo){
        $data=array();
        $this->query="SELECT f.*, 'S' as Marca from FACTURAS_fp f where cve_clpv = $cliente order by f.fecha_doc";
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function aplicaInd($idp, $monto, $uuid){
        $usuario=$_SESSION['user']->NOMBRE;
        $this->query="SELECT x.*, (SELECT coalesce(sum(a.MONTO_APLICADO),0) from aplicaciones a where observaciones = '$uuid' or x.documento = a.documento) as Aplicado, x.importe - (SELECT coalesce(sum(a.MONTO_APLICADO),0) from aplicaciones a where observaciones = '$uuid' or x.documento = a.documento) as SaldoDOC,(SELECT coalesce(cp.MONTO,0) FROM CARGA_PAGOS cp WHERE cp.ID = $idp and status = '0')-(SELECT coalesce(sum(ac.monto_aplicado), 0) FROM APLICACIONES ac WHERE ac.IDPAGO = $idp and cancelado = 0) AS SALDOPAGO,
            ((SELECT coalesce(cp.MONTO,0) FROM CARGA_PAGOS cp WHERE cp.ID = $idp and status ='0')-(SELECT coalesce(sum(ac.monto_aplicado), 0) FROM APLICACIONES ac WHERE ac.IDPAGO = $idp and cancelado = 0))-(x.importe - (SELECT coalesce(sum(a.MONTO_APLICADO),0) from aplicaciones a where observaciones = '$uuid' or x.documento = a.documento)) as SaldoInsPago
            FROM XML_DATA x WHERE UUID = '$uuid'";
            
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);

        if($row->SALDODOC > 0 And $row->SALDOPAGO>0 AND ($row->SALDOPAGO - $monto) >= 0 and ($row->SALDODOC-$monto>=0)){
            $this->query="INSERT INTO APLICACIONES (ID, FECHA, IDPAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, STATUS, RFC, FORMA_PAGO, CANCELADO, PROCESADO, CIERRE_CC, REC_CONTA, FECHA_CIERRE_CC, USUARIO_CIERRE_CC, FECHA_REC_CONTA, FOLIO_REC_CONTA, USUARIO_REC_CONTA, OBSERVACIONES, CONTABILIZADO, TIPO, POLIZA_INGRESO) VALUES (null, current_timestamp, $idp, (SELECT DOCUMENTO FROM XML_DATA WHERE UUID = '$uuid'),$monto, $row->SALDODOC - $monto, $row->SALDOPAGO -$monto,'$usuario', 'E', (SELECT CLIENTE FROM XML_DATA WHERE UUID = '$uuid'), (SELECT CONTABILIZADO FROM CARGA_PAGOS WHERE ID=$idp), 0, 0, 0, 0, null, null, null, 0, null, '$uuid', null,null, null  )";
            if($res=$this->grabaBD()){
                $this->query="UPDATE CARGA_PAGOS SET SALDO = SALDO - $monto where id = $idp";
                $this->queryActualiza();
                $this->query="UPDATE XML_DATA SET IDPAGO = $idp where uuid = '$uuid'";
                $this->queryActualiza();
            }
            return array("status"=>'ok', "mensaje"=>$row->IMPORTE, "SaldoDoc"=>$row->SALDODOC, "SaldoPago"=>$row->SALDOPAGO);
        }else{
            return array("status"=>'no', "mensaje"=>'El pago ya ha sido aplicado anteriormente', "SaldoDoc"=>$row->SALDODOC, "SaldoPago"=>$row->SALDOPAGO);
        }
    }

    function traePago($idp){
            $row=array();
            $this->query="SELECT C.*, 
                            (select CTA_CONTAB from PG_BANCOS B where B.BANCO || ' - ' || B.NUM_CUENTA = C.BANCO) as CCOI,
                            (select BANCO from PG_BANCOS B where B.BANCO || ' - ' || B.NUM_CUENTA = C.BANCO) as BBANCO,
                             (select NUM_CUENTA from PG_BANCOS B where B.BANCO || ' - ' || B.NUM_CUENTA = C.BANCO) as CUENTA,
                            extract(month from C.FECHA_RECEP) as PERIODO,
                            extract(year from C.FECHA_RECEP) as EJERCICIO
                from CARGA_PAGOS c where C.ID = $idp and (poliza_ingreso = '' or poliza_ingreso is null)";
            $res=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($res);
            return $row;
            //return array("statsu"=>'ok', "info"=>"Banco: ".$row->BANCO." Cuenta: ".$row->CUENTA." Importe: ".$row->MONTO, "banco"=>$row->BANCO, "cuenta"=>$row->CUENTA, "cuentaCoi"=>$row->CCOI, "monto"=>"$ ".number_format($row->MONTO,2), "fecha_edo"=>$row->FECHA_RECEP, "conciliado"=>$row->GUARDADO, "perido"=>$row->PERIODO, "ejercicio"=>$row->EJERCICIO, "factura"=>$row->OBS, "importe"=>$row->MONTO, "obs"=>$row->OBS,"tipo_tes"=>$row->CONTABILIZADO);
    }

    function traeAplicaciones($idp){
        $data=array();
        $this->query="SELECT A.*, (SELECT NOMBRE FROM XML_CLIENTES WHERE RFC = A.RFC and tipo= 'Cliente'), (SELECT CUENTA_CONTABLE FROM XML_CLIENTES WHERE RFC = A.RFC and tipo = 'Cliente') FROM APLICACIONES A WHERE IDPAGO = $idp and cancelado=0 and status = 'E'";
        $r=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($r)){
            $data[]=$tsArray;
        }
        return $data;
    }

}
?> 