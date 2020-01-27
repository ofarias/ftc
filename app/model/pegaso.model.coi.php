<?php

require_once 'app/model/database.coi.php';
/* Clase para hacer uso de database */
class CoiDAO extends DataBaseCOI {

    function validaConexion(){
        $res=$this->checkConnect();
        empty($res)? $_SESSION['cnxcoi']='no':$_SESSION['cnxcoi']='si';
        return $res;
    }

    function traeParametros(){
        $this->query="SELECT * FROM PARAMEMP";
        $res = $this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        return $row;
    }

    function traeConfiguracion(){
        $data=array();
        $this->query="SELECT * FROM FTC_PARAM_COI";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)){
            $data=$tsArray;
        }
        return $data; 
    }

    function traeCuentaCliente($info, $ide){
        foreach ($info as $key) {
            if($ide == 'Emitidos'){
                $rfce=$key->CLIENTE;
            }else{
                $rfce=$key->RFCE;
            }
            $cuenta=$key->CUENTA_CONTABLE;       
        }
        $this->query="SELECT * FROM CUENTAS19 WHERE TRIM(NUM_CTA)=TRIM('$cuenta')";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        if($row){
            $cuenta = $row->NUM_CTA;
            $nombre = $row->NOMBRE;
            return trim($rfce).':'.$nombre.'->'.$cuenta;
        }else{
            return 'Sin Cuenta Actual';
        }
    }

    function traeCuentasSAT($info){
        $data=array();
        foreach ($info as $key) {
            $rfc=$key->RFC;       
            $cveSat=$key->CLAVE_SAT;
            $uniSat=$key->UNIDAD_SAT;
            $cuenta=$key->CUENTA_CONTABLE;
            $this->query="SELECT * FROM CUENTAS19 WHERE TRIM(NUM_CTA)=TRIM('$cuenta') ";
            $res=$this->EjecutaQuerySimple();
            while($tsArray=ibase_fetch_object($res)){
                $data[]=$tsArray;
            }
        }
        return $data;
    }

    function traeCatalogoCuentas($tipo, $ide){
        $data=array();
        $numcta="";
        if($tipo == 'V' and $ide == 'Recibidos'){
            $numcta = "where (cuenta starting with ('2') or cuenta starting with ('21') or cuenta starting with ('140')) and tipo = 'D' order by nombre";
        }elseif($tipo =='G'){
            $numcta = "where (cuenta starting with ('5') or cuenta starting with ('6') or cuenta starting with ('7')) and tipo = 'D' order by cuenta";
        }elseif($tipo =='V' and $ide == 'Emitidos'){
            $numcta = "where (cuenta starting with ('1') or cuenta starting with ('11') or cuenta starting with ('1150')) and tipo = 'D' order by nombre";
        }
        $this->query="SELECT C.* FROM CUENTAS_FTC C $numcta";
        //echo $this->query;
        $res=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function creaParam($cliente, $partidas){
        $usuario=$_SESSION['user']->NOMBRE;
        $cliente = explode(":", $cliente);
        $rfc = $cliente[0];
        $cuenta = $cliente[1];
        $uuid = $cliente[2];
        $rfc_e = $cliente[3];

        $this->query="SELECT COALESCE(MAX(ID), 0) + 1 AS FOLIO FROM FTC_PARAMETROS";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        $num_para = $row->FOLIO;

        $this->query="INSERT INTO FTC_PARAMETROS (ID, UUID, RFC_R, RFC_E, FECHA_ALTA, USUARIO, STATUS )
                            VALUES(NULL, '$uuid', '$rfc', '$rfc_e', current_timestamp,'$usuario', 1 )";
        $this->grabaBD();

        $this->query="INSERT INTO FTC_CUENTAS_SAT (ID, CLAVE_SAT, CUENTA_COI, STATUS, RFC_CLIENTE, RFC_PROVEEDOR, UNIDAD_SAT, FTC_NUM_PARAM) 
                        VALUES(null,'MXN','$cuenta',1,'$rfc','$rfc_e','MX', $num_para)";
        //echo '<br/>'.$this->query;
        if($this->grabaBD()){
            /// Debemos de asegurarnos que nuestro proveedor solo tenga una cuenta.
            //$this->query="UPDATE CUENTAS18 SET RFC = '' WHERE RFC = '$rfc_e' "
            $this->query="UPDATE CUENTAS19 SET RFC='$rfc_e' where num_cta = '$cuenta'";
            $this->grabaBD();
            $partidas=explode("###", $partidas);
            //var_dump($partidas);
            foreach ($partidas as $key) {
                //1:83111603:E48:640000400040000000003
                //echo 'Valor de partida: '.$key.'<br/>';
                $par=explode(":",$key);
                //var_dump($par);
                    $partida =$par[0];
                    $cve_sat =$par[1];
                    $uni_sat =$par[2];
                    $c_coi   =$par[3];
                    $rfc_e   =$par[4];
                 $this->query="INSERT INTO FTC_CUENTAS_SAT (ID, CLAVE_SAT, CUENTA_COI, STATUS, RFC_CLIENTE, RFC_PROVEEDOR, UNIDAD_SAT, FTC_NUM_PARAM)
                                values(null, '$cve_sat', '$c_coi', 1, '$rfc','$rfc_e', '$uni_sat', $num_para)";
                 //echo '<br/>'.$this->query.'<br/>';
                 $this->EjecutaQuerySimple();
            }
            return array("status"=>'ok',"mensaje"=>"Se inserto correctamente el parametro... del cliente");
        }else{
            $this->query="DELETE from FTC_PARAMETROS where id = $num_para";
            $this->grabaBD();

            return array("status"=>'no',"mensaje"=>"No se pudo guardar, favor de intentarlo nuevamente");
        }
    }

    function validaCuenta($datosCliente){
      
        $rfc = $datosCliente->RFC;
        $nombre = $datosCliente->NOMBRE;

        $this->query= "SELECT iif(MAX(NUM_CTA) is null, 0, max(NUM_CTA)) as valor FROM CUENTAS17 WHERE RFC = '$rfc'";
        $resultado = $this->QueryObtieneDatosN();
        $rowCuenta = ibase_fetch_object($resultado);
        $valCuenta = $rowCuenta->VALOR;
        //echo $valCuenta;
        //echo $this->query;
        //break;
            if($valCuenta ==  0 ){
                $this->query ="SELECT MIN(NUM_CTA) as papa, substring(MAX(num_cta) from 8 for 3) as hija FROM CUENTAS17 WHERE NUM_CTA STARTING WITH ('1150001')";
                $rs = $this->QueryObtieneDatosN();
                $rowCtaDet= ibase_fetch_object($rs);
                $ctaPapa = $rowCtaDet->PAPA;
                $ctaHija = $rowCtaDet->HIJA;
                $nueva = $ctaHija + 1;
                    if(strlen($nueva) == 1){
                        $nueva = '00'.$nueva;
                    }elseif (strlen($nueva) == 2){
                        $nueva = '0'.$nueva;
                    }elseif (strlen($nueva) == 3){
                        $nueva = $nueva;
                    }
                    $cuentaNueva = substr($ctaPapa, 0, 7).$nueva.'00000000003';
                $this->query = "INSERT INTO CUENTAS17 VALUES ('$cuentaNueva', 'A', 'D', substring('$datosCliente->NOMBRE' from 1 for 40), 'N', 1,'N','$ctaPapa', '115000000000000000001', 3, '', 0, '$rfc', '', 0,0, 0, '','N', 0, '', 0,'' )";
                $rs= $this->EjecutaQuerySimple();
                //echo $this->query;
                $this->query = "INSERT INTO SALDOS17 (num_cta, Ejercicio) VALUES ('$cuentaNueva', 2016)";
                $rs = $this->EjecutaQuerySimple();

                $valCuenta = $cuentaNueva;
                //echo $this->query;
                //break;
            }

            return $valCuenta;
        }

   
    function traePoliza($documento){
        $data=array();
        foreach ($documento as $key) {
            $eje=substr($key->EJERCICIO,2);
            $periodo = $key->PERIODO;
            $tipo = $key->TIPO; 
            $poliza = $key->POLIZA; 
            $this->query="SELECT * FROM AUXILIAR$eje where NUM_POLIZ = '$poliza' and periodo = $periodo and TIPO_POLI = '$tipo'";
            $res=$this->EjecutaQuerySimple();
            while($tsArray=ibase_fetch_object($res)){
                $data[]=$tsArray;
            }
        }
        return $data;
    }

    function insertaPoliza($datosCliente, $cuenta, $datosBanco, $datosCuenta){

        $mes = $datosCliente->MES;
        $anio = $datosCliente->ANIO;
        $fechaelab = $datosCliente->FECHAELAB;
        $concepto = $datosCliente->CVE_DOC.' - '.$datosCliente->CVE_CLPV.' - '.$datosCliente->NOMBRE.' - '.$datosCliente->FECHAELAB.' - '.$datosCliente->IMPORTE;
        $importe = $datosCliente->IMPORTE;
        $iva = $datosCliente->IMP_TOT4;
        $subtotal = $importe - $iva;
        $rfc = $datosCliente->RFC;
        $fechadoc = $datosCliente->FECHA_DOC;

        $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
        $res = $this->QueryObtieneDatosN();
        $rowPoliza = ibase_fetch_object($res);
        $folio=$rowPoliza->FOLIOA + 1;
            //echo $this->query;
            //echo 'Numero del folio: '.$rowPoliza->FOLIOA;
            //echo 'Tamaño del foliio: '.strlen($folio);
            //break;
            if(strlen($folio) == 1){
                $folio = '    '.$folio;
            }elseif (strlen($folio) == 2 ){
                $folio = '   '.$folio;
            }elseif (strlen($folio) == 3 ) {
                $folio = '  '.$folio;
            }elseif (strlen($folio) == 4) {
                $folio = ' '.$folio;
            }elseif (strlen($folio) == 5) {
                $folio = $folio;
            }

        $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', '$concepto', 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
        $insPol = $this->EjecutaQuerySimple();

        //echo $this->query;
        //break;
        /// Inserta poliza de Dr segun el mes de la venta.

        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',1, $mes, $anio, '410000100100000000003', '$fechaelab', ('Ventas Nacionales, '||'$datosCliente->CVE_DOC'), 'H', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();
        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100000000000002', '$fechaelab', ('Iva por Acreeditar, '||'$datosCliente->CVE_DOC '), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();
        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuenta', '$fechaelab', ('Clientes'||' - '||'$datosCliente->NOMBRE'||', '||'$datosCliente->CVE_DOC'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();

        //// Inserta la poliza de Ig segun el mes del Pago.
        ###########################################
        ################  Poliza de Ig ############
        ###########################################
        //averiguar ultimo folio de Ig 
        $fechaPago = $datosBanco->FECHA_RECEP;
        $mesPago = substr($fechaPago, 5,2);
        $anioPago = substr($fechaPago, 0,4);
        $mesPago = str_replace('0','',$mesPago);
        $concepto = $datosBanco->BANCO.', '.$concepto;

        //echo $concepto;

        $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioIg FROM POLIZAS17 WHERE TIPO_POLI = 'Ig' AND PERIODO = $mesPago and Ejercicio = $anioPago ";
        $res=$this->QueryObtieneDatosN();

        $rowIg = ibase_fetch_object($res);
        $folioIg = $rowIg->FOLIOIG + 1;

                if(strlen($folioIg) == 1){
                $folioIg = '    '.$folioIg;
                }elseif (strlen($folioIg) == 2 ){
                    $folioIg = '   '.$folioIg;
                }elseif (strlen($folioIg) == 3 ) {
                    $folioIg = '  '.$folioIg;
                }elseif (strlen($folioIg) == 4) {
                    $folioIg = ' '.$folioIg;
                }elseif (strlen($folioIg) == 5) {
                    $folioIg = $folioIg;
                }        
        
        $cuentaBanco = $datosCuenta->CTA_CONTAB;
        
        $this->query = "INSERT INTO POLIZAS17 VALUES ('Ig', '$folioIg', $mesPago, $anioPago, '$fechaPago', '$concepto', 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
        $insPol = $this->EjecutaQuerySimple();
        

        $this->query="INSERT INTO AUXILIAR17 VALUES ('Ig', '$folioIg',1, $mesPago, $anioPago, '$cuentaBanco', '$fechaelab', ('Ingreso a Banco Nacionales, '||'$datosCliente->CVE_DOC'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();
        ##echo 'Esta es la insecion a BAncos: '.$this->query;
        $this->query="INSERT INTO AUXILIAR17 VALUES ('Ig', '$folioIg',2, $mesPago, $anioPago, '218100100000000000002', '$fechaelab', ('Ingreso a Banco Nacionales, '||'$datosCliente->CVE_DOC'), 'D', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple(); 
        $this->query="INSERT INTO AUXILIAR17 VALUES ('Ig', '$folioIg',3, $mesPago, $anioPago, '218000100000000000002', '$fechaelab', ('Ingreso a Banco Nacionales, '||'$datosCliente->CVE_DOC'), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();
        $this->query="INSERT INTO AUXILIAR17 VALUES ('Ig', '$folioIg',4, $mesPago, $anioPago, '$cuenta', '$fechaelab', ('Abono a Clientes, '||'$datosCliente->CVE_DOC'), 'H', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
        $rs=$this->EjecutaQuerySimple();

        ###########################################
        ######  Fin Poliza de Ingresos ############
        ###########################################

        return $rs;

    }

    function insertarPolizas($datosPolizas){
        /// Obtenemos la cuenta del proveedor.
        if(!empty($datosPolizas)){
            foreach ($datosPolizas as $data){
                $rfc2= $data->RFC;
                $mes = $data->MES;
                $anio = $data->ANIO;
                $monto = $data->CARGO;
                $fecha = $data->FE;
                $id = $data->ID;
                $concepto = $data->TIPO_BASE_PROV.', '.$fecha.', '.$data->IDENTIFICADOR.', '.$rfc2.', '.$data->NOMBRE.', $ '.$monto;
                $subtotal = $monto / 1.16;
                $iva = $monto - $subtotal;
                $tipoEgreso = $data->TIPO_BASE_PROV;
                $cuenta = $data->CTA_CONT;
                $nombreProveedor = $data->NOMBRE;
                    if($rfc2 =='rfcgenerico'){
                        //$this->query="SELECT NUM_CTA as cuenta FROM CUENTAS1602 WHERE RFC = '$data->RFC'";
                        //$rs = $this->QueryObtieneDatosN();
                        //$row=ibase_fetch_object($rs);
                        //$cuenta=$row->CUENTA;
                        $cuenta='211000100200000000003';
                    }
                    //// Obtenemos el ultimo folio y creamos el nuevo Folio de Dr.
                    $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0, MAX(NUM_POLIZ)) as folioa FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' and periodo = $mes and  Ejercicio = $anio";
                    $res = $this->QueryObtieneDatosN();
                    $rowF = ibase_fetch_object($res);
                    $folioDrN = $rowF->FOLIOA + 1;
                                if(strlen($folioDrN) == 1){
                                    $folioDrN = '    '.$folioDrN;
                                }elseif (strlen($folioDrN) == 2 ){
                                    $folioDrN = '   '.$folioDrN;
                                }elseif (strlen($folioDrN) == 3 ) {
                                    $folioDrN = '  '.$folioDrN;
                                }elseif (strlen($folioDrN) == 4) {
                                    $folioDrN = ' '.$folioDrN;
                                }elseif (strlen($folioDrN) == 5) {
                                    $folioDrN = $folioDrN;
                                }
                    //// Obtenemos el ultimo folio de Egresos y creamos el nuevo folio.
                                $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0, MAX(NUM_POLIZ)) as folioEG FROM POLIZAS17 WHERE TIPO_POLI = 'Eg' and periodo = $mes and  Ejercicio = $anio";
                                $res = $this->QueryObtieneDatosN();
                                $rowF = ibase_fetch_object($res);
                                $folioEgN = $rowF->FOLIOEG + 1;
                                if(strlen($folioEgN) == 1){
                                    $folioEgN = '    '.$folioEgN;
                                }elseif (strlen($folioEgN) == 2 ){
                                    $folioEgN = '   '.$folioEgN;
                                }elseif (strlen($folioEgN) == 3 ) {
                                    $folioEgN = '  '.$folioEgN;
                                }elseif (strlen($folioEgN) == 4) {
                                    $folioEgN = ' '.$folioEgN;
                                }elseif (strlen($folioEgN) == 5) {
                                    $folioEgN = $folioEgN;
                                }

                    //// Obtenemos la cuenta del Banco
                                if($data->BANCO == 'Bancomer - 0156324495'){
                                    $cuentaBanco = '112000100600000000003';
                                }elseif ($data->BANCO == 'Banamex - 9318771457'){
                                    $cuentaBanco = '112000100100000000003';
                                }elseif ($data->BANCO == 'ScotiaBank - 044180001025870734') {
                                    $cuentaBanco = '112000100700000000003';
                                }

                ##########################################################
                ###### CREACION DE POLIZA PROVISION DE COMPRA ############
                ##########################################################
                ///// Insertamos Poliza de Dr.
                $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folioDrN', $mes, $anio, '$fecha', substring('$concepto' from 1 for 119), 0, 'N', 'N',0,1,0,'Pegaso','0','0',0)";
                $insPol = $this->EjecutaQuerySimple();

                if($insPol == 0){
                     $errores[]=array('Poldr', $folioDrN, $mes, $anio, $id);
                 }else{
                        if(substr($tipoEgreso, 0,1) == 'G'){
                        $cuentaEgreso = "620000100100000000003";
                    }else{
                        $cuentaEgreso = "119000100000000000002";
                    }
                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folioDrN',1, $mes, $anio, '$cuentaEgreso', '$fecha', ('Almacen, '||'$data->NOMBRE'), 'D', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();
                        // Partida Impuestos
                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folioDrN',2, $mes, $anio, '120100100000000000002', '$fecha', ('Iva por Pagar, '||'$data->NOMBRE'), 'D', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();
                        // Partida del proveedor
                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folioDrN',3, $mes, $anio, '$cuenta', '$fecha', ('Proveedor'||' - '||'$data->NOMBRE'||', '||'$data->PROVEEDOR'), 'H', $monto, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();
                 }
                
                ##########################################################
                ########### CREACION DE POLIZA PAGO A PROVEEDORES ########
                ##########################################################

                /// Insertamos la poliza de Eg.

                $this->query = "INSERT INTO POLIZAS17 VALUES ('Eg', '$folioEgN', $mes, $anio, '$fecha', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
                $insPoleg = $this->EjecutaQuerySimple();
                       if($insPoleg == 0){
                            $errores[]=array('Poleg', $folioEgN, $mes, $anio, $id);
                       }else{
                                // Partida Proveedor
                            $this->query="INSERT INTO AUXILIAR17 VALUES ('Eg', '$folioEgN',1, $mes, $anio, '$cuenta', '$fecha', ('Pago a Proveedores, '||'$data->IDENTIFICADOR'), 'D', $monto, 0, 1, 0, 1, 0, 0, 0, 0) ";
                            $rs=$this->EjecutaQuerySimple();
                            //Partida Impuestos
                            $this->query="INSERT INTO AUXILIAR17 VALUES ('Eg', '$folioEgN',2, $mes, $anio, '120100100000000000002', '$fecha', ('Egreso de Banco Nacionales, '||'$data->NOMBRE'||', '||'$rfc2'), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                            $rs=$this->EjecutaQuerySimple(); 
                            $this->query="INSERT INTO AUXILIAR17 VALUES ('Eg', '$folioEgN',3, $mes, $anio, '120000100000000000002', '$fecha', '$rfc2', 'D', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                            $rs=$this->EjecutaQuerySimple();
                            // Partida Banco
                            $this->query="INSERT INTO AUXILIAR17 VALUES ('Eg', '$folioEgN',4, $mes, $anio, '$cuentaBanco', '$fecha', ('Egreso de Banco Nacionales, '||'$data->NOMBRE'), 'H', $monto, 0, 1, 0, 1, 0, 0, 0, 0) ";
                            $rs=$this->EjecutaQuerySimple();
                       }
                ##echo 'Esta es la insecion a BAncos: '.$this->query 
                ###########################################
                ######  Fin Poliza de Ingresos ############
                ###########################################
                $folioEG = 'Eg'.$folioEgN;
                $folioDr = 'Dr'.$folioDrN;
                $polizas[]=array(1 => $id, 2 => $folioEG, 3 =>$folioDr);
            }
               // var_dump($polizas);
        }

            if(!empty($polizas)){
                        if(isset($errores)){
                            foreach ($errores as $key) {
                            echo $this->query.'<p>';
                            echo $key[0].', '.$key[1].', '.$key[2].', '.$key[3].', '.$key[4].'<p>';
                            }
                        } 
                return $polizas;    
            }
                return 'Nothing to do....';
    }

    function insertarPolizas_Dr_Ventas($datosPolizas){
                ##########################################################
                ##VALIDAMOS QUE EXISTA LA CUENTA, SI NO, LA CREAMOS ######
                ##########################################################

                foreach($datosPolizas as $dataC){
                $rfc = $dataC->RFC;
                $nombre = $dataC->NOMBRE;
                $this->query= "SELECT iif(MAX(NUM_CTA) is null, 0, max(NUM_CTA)) as valor FROM CUENTAS17 WHERE RFC = '$rfc'";
                $resultado = $this->QueryObtieneDatosN();
                $rowCuenta = ibase_fetch_object($resultado);
                $valCuenta = $rowCuenta->VALOR;
                //echo $valCuenta;
                //echo $this->query;
                //break;
                    if($valCuenta ==  0 ){
                        $this->query ="SELECT MIN(NUM_CTA) as papa, substring(MAX(num_cta) from 8 for 3) as hija FROM CUENTAS17 WHERE NUM_CTA STARTING WITH ('1150001')";
                        $rs = $this->QueryObtieneDatosN();
                        $rowCtaDet= ibase_fetch_object($rs);
                        $ctaPapa = $rowCtaDet->PAPA;
                        $ctaHija = $rowCtaDet->HIJA;
                        $nueva = $ctaHija + 1;
                            if(strlen($nueva) == 1){
                                $nueva = '00'.$nueva;
                            }elseif (strlen($nueva) == 2){
                                $nueva = '0'.$nueva;
                            }elseif (strlen($nueva) == 3){
                                $nueva = $nueva;
                            }
                            $cuentaNueva = substr($ctaPapa, 0, 7).$nueva.'00000000003';
                        $this->query = "INSERT INTO CUENTAS17 VALUES ('$cuentaNueva', 'A', 'D', substring('$nombre' from 1 for 40), 'N', 1,'N','$ctaPapa', '115000000000000000001', 3, '', 0, '$rfc', '', 0,0, 0, '','N', 0, '', 0,'' )";
                        $rs= $this->EjecutaQuerySimple();
                        //echo $this->query;
                        $this->query = "INSERT INTO SALDOS17 (num_cta, Ejercicio) VALUES ('$cuentaNueva', 2016)";
                        $rs = $this->EjecutaQuerySimple();

                        $valCuenta = $cuentaNueva;
                }
            }
                ##########################################################
                ############ FIN DE LA VALIDACION DE LA CUENTA ###########
                ##########################################################

                ##########################################################
                ############ INSERTAMOS LA POLIZA DE DR  #################
                ##########################################################

                 foreach($datosPolizas as $dataP){
                       $this->query = "SELECT NUM_CTA FROM CUENTAS17 WHERE rfc = '$dataP->RFC'";
                       $rs=$this->QueryObtieneDatosN();
                       $row=ibase_fetch_object($rs);

                       if(!empty($row)){
                            $cuentaCliente = $row->NUM_CTA;
                       }else{
                            $cuentaCliente = '115000100100000000003'; /// Cuenta de cliente generico.
                       }

                        $id = $dataP->ID;
                        $mes = $dataP->MES;
                        $anio = $dataP->ANIO;
                        $fechaelab = $dataP->FECHAELAB;
                        $concepto = $dataP->DOCUMENTO.' - '.$dataP->CVE_CLPV.' - '.$dataP->NOMBRE.' - '.$dataP->FECHAELAB.' - '.$dataP->IMPORTE.', '.$dataP->MONTO_APLICADO;
                        $importe = $dataP->IMPORTE;
                        $iva = $dataP->IMP_TOT4;
                        $subtotal = $importe - $iva;
                        $rfc = $dataP->RFC;
                        $fechadoc = $dataP->FECHA_DOC;

                        $a="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
                        //$res = $this->QueryObtieneDatosN();
                        $this->query=$a;
                        $res=$this->QueryObtieneDatosN();
                        $rowPoliza = ibase_fetch_object($res);
                        $folioA = (int)$rowPoliza->FOLIOA;
                        $folio = $folioA + 1;

                            if(strlen($folio) == 1){
                                $folio = '    '.$folio;
                            }elseif (strlen($folio) == 2 ){
                                $folio = '   '.$folio;
                            }elseif (strlen($folio) == 3 ) {
                                $folio = '  '.$folio;
                            }elseif (strlen($folio) == 4) {
                                $folio = ' '.$folio;
                            }elseif (strlen($folio) == 5) {
                                $folio = $folio;
                            }

                        $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
                        $insPol = $this->EjecutaQuerySimple();
                        if($insPol != 1){
                            echo 'Poliza: '.$this->query;
                            echo 'Valor del Folio A: '.$folioA;
                            echo 'Valor del Folio: '.$folio;
                            echo 'Error: '.$this->query;
                            echo $a;
                            break;
                        }
                        //break;
                        /// Inserta poliza de Dr segun el mes de la venta.
                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',1, $mes, $anio, '410000100100000000003', '$fechaelab', ('Ventas Nacionales, '||'$dataP->DOCUMENTO'), 'H', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();
                        if($rs != 1){
                            echo 'Valor del Folio A: '.$folioA;
                            echo 'Valor del Folio: '.$folio;
                            echo 'Error: '.$this->query;
                            echo $a;
                            break;
                        }

                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100000000000002', '$fechaelab', ('Iva por Acreeditar, '||'$dataP->DOCUMENTO'), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();

                        if($rs != 1){
                            echo 'Error: '.$this->query;
                        }

                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$dataP->NOMBRE'||', '||'$dataP->DOCUMENTO'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();


                        if($rs != 1){
                            echo 'Error: '.$this->query;
                        }

                        $polizasAplicaciones[]=array(0 => $id,1 => $folio);
                 }       

                return $polizasAplicaciones; 
    }

    function insertarPolizas_Ig_Ventas($datosPolizas){
                ##########################################################
                ##VALIDAMOS QUE EXISTA LA CUENTA, SI NO, LA CREAMOS ######
                ##########################################################
                foreach($datosPolizas as $dataC){
                $rfc = $dataC->RFC;
                $nombre = $dataC->NOMBRE;

                $this->query= "SELECT iif(MAX(NUM_CTA) is null, 0, max(NUM_CTA)) as valor FROM CUENTAS17 WHERE RFC = '$rfc'";
                $resultado = $this->QueryObtieneDatosN();
                $rowCuenta = ibase_fetch_object($resultado);
                $valCuenta = $rowCuenta->VALOR;
                //echo $valCuenta;
                //echo $this->query;
                //break;
                    if($valCuenta ==  0 ){
                        $this->query ="SELECT MIN(NUM_CTA) as papa, substring(MAX(num_cta) from 8 for 3) as hija FROM CUENTAS17 WHERE NUM_CTA STARTING WITH ('1150001')";
                        $rs = $this->QueryObtieneDatosN();
                        $rowCtaDet= ibase_fetch_object($rs);
                        $ctaPapa = $rowCtaDet->PAPA;
                        $ctaHija = $rowCtaDet->HIJA;
                        $nueva = $ctaHija + 1;
                            if(strlen($nueva) == 1){
                                $nueva = '00'.$nueva;
                            }elseif (strlen($nueva) == 2){
                                $nueva = '0'.$nueva;
                            }elseif (strlen($nueva) == 3){
                                $nueva = $nueva;
                            }
                            $cuentaNueva = substr($ctaPapa, 0, 7).$nueva.'00000000003';
                        $this->query = "INSERT INTO CUENTAS17 VALUES ('$cuentaNueva', 'A', 'D', substring('$nombre' from 1 for 40), 'N', 1,'N','$ctaPapa', '115000000000000000001', 3, '', 0, '$rfc', '', 0,0, 0, '','N', 0, '', 0,'' )";
                        $rs= $this->EjecutaQuerySimple();
                        //echo $this->query;
                        $this->query = "INSERT INTO SALDOS17 (num_cta, Ejercicio) VALUES ('$cuentaNueva', 2016)";
                        $rs = $this->EjecutaQuerySimple();

                        $valCuenta = $cuentaNueva;
                }
            }
                ##########################################################
                ############ FIN DE LA VALIDACION DE LA CUENTA ###########
                ##########################################################


                ##########################################################
                ############ INSERTAMOS LA POLIZA DE DR  #################
                ##########################################################

                 foreach($datosPolizas as $dataP){
                       $this->query = "SELECT NUM_CTA FROM CUENTAS17 WHERE rfc = '$dataP->RFC'";
                       $rs=$this->QueryObtieneDatosN();
                       $row=ibase_fetch_object($rs);

                       if(!empty($row)){
                            $cuentaCliente = $row->NUM_CTA;
                       }else{
                            $cuentaCliente = '115000100100000000003'; /// Cuenta de cliente generico.
                       }

                        $id = $dataP->ID;
                        $mes = $dataP->MES;
                        $anio = $dataP->ANIO;
                        $fechaelab = $dataP->FECHAELAB;
                        $concepto = $dataP->DOCUMENTO.' - '.$dataP->CVE_CLPV.' - '.$dataP->NOMBRE.' - '.$dataP->FECHAELAB.' - '.$dataP->IMPORTE.', '.$dataP->MONTO_APLICADO;
                        $importe = $dataP->IMPORTE;
                        $iva = $dataP->IMP_TOT4;
                        $subtotal = $importe - $iva;
                        $rfc = $dataP->RFC;
                        $fechadoc = $dataP->FECHA_DOC;

                        $a="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
                        //$res = $this->QueryObtieneDatosN();
                        $this->query=$a;
                        $res=$this->QueryObtieneDatosN();
                        $rowPoliza = ibase_fetch_object($res);
                        $folioA = (int)$rowPoliza->FOLIOA;
                        $folio = $folioA + 1;

                            if(strlen($folio) == 1){
                                $folio = '    '.$folio;
                            }elseif (strlen($folio) == 2 ){
                                $folio = '   '.$folio;
                            }elseif (strlen($folio) == 3 ) {
                                $folio = '  '.$folio;
                            }elseif (strlen($folio) == 4) {
                                $folio = ' '.$folio;
                            }elseif (strlen($folio) == 5) {
                                $folio = $folio;
                            }

                        $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
                        $insPol = $this->EjecutaQuerySimple();
                        if($insPol != 1){
                            echo 'Poliza: '.$this->query;
                            echo 'Valor del Folio A: '.$folioA;
                            echo 'Valor del Folio: '.$folio;
                            echo 'Error: '.$this->query;
                            echo $a;
                            break;
                        }
                        //break;
                        /// Inserta poliza de Dr segun el mes de la venta.
                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',1, $mes, $anio, '410000100100000000003', '$fechaelab', ('Ventas Nacionales, '||'$dataP->DOCUMENTO'), 'H', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();
                        if($rs != 1){
                            echo 'Valor del Folio A: '.$folioA;
                            echo 'Valor del Folio: '.$folio;
                            echo 'Error: '.$this->query;
                            echo $a;
                            break;
                        }

                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100000000000002', '$fechaelab', ('Iva por Acreeditar, '||'$dataP->DOCUMENTO'), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();

                        if($rs != 1){
                            echo 'Error: '.$this->query;
                        }

                        $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$dataP->NOMBRE'||', '||'$dataP->DOCUMENTO'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
                        $rs=$this->EjecutaQuerySimple();


                        if($rs != 1){
                            echo 'Error: '.$this->query;
                        }

                        $polizasAplicaciones[]=array(0 => $id,1 => $folio);
                 }       

                return $polizasAplicaciones; 
    }

    function tabla_temp_aplicaciones($aplicaciones, $pagos){
        $this->query="DELETE from temp_table";
        $rs=$this->grabaBD();

        if(count($aplicaciones) > 0){
             $rfcs= 0;
            foreach ($aplicaciones as $key){
                $ida= $key->ID;
                $idp = $key->IDPAGO;
                $montoAplicado = round($key->MONTO_APLICADO,2);
                $contabilizado = $key->CONTABILIZADO;
                $rfc =trim($key->RFC);
                $docf = $key->DOCUMENTO;
                //$rfc = str_replace(' ','',$rfc);
                $this->query="SELECT NUM_CTA FROM CUENTAS18 WHERE trim(RFC) =trim('$rfc')";
                $rs=$this->EjecutaQuerySimple();
                $row=ibase_fetch_object($rs);
               
                if($row){
                    $cuenta = $row->NUM_CTA;    
                        $rfcs=$rfcs + 1;
                }else{
                    echo $rfc.'<br/>';
                    //echo $this->query.'<br/>';
                }
                $this->query="INSERT INTO TEMP_TABLE VALUES($ida, $idp, $montoAplicado, '$rfc', '$cuenta', 'No','$docf')";
                //$res=$this->EjecutaQuerySimple();
                    if($this->EjecutaQuerySimple()==false){
                        echo $this->query.'<br/>';
                    }
                }
        }
        //exit('Aplicaciones: '.count($aplicaciones).' rfcs: '. $rfcs);

        foreach($pagos as $data){
            $idp = $data->ID;
            $cuentaBanco = $data->CTA_CONTAB;
            $montoDoc = round($data->MONTO,2);
            $mes = $data->MES;
            $anio = $data->ANIO;
            $concepto = 'Ingreso a Bancos '.$data->BANCO.', folio: '.$idp.', Monto: '.$montoDoc;
            $subtotal = round($montoDoc / 1.16,2);
            $iva = round($montoDoc - $subtotal,2);
            $fechaR = $data->FECHA_RECEP;
            
            $this->query= "SELECT * from TEMP_TABLE WHERE IDP = $idp";
            $rs=$this->EjecutaQuerySimple();
            while($tsArray = ibase_fetch_object($rs)){
                  $partida[]=$tsArray;
            }

            /// Obtenemos el ultimo folio de las polizas de Ingreso Ig con base al mes y al año.    
                ############# Algoritmo para calcular el Nuevo Folio.
                    $a="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS18 WHERE TIPO_POLI = 'Ig' AND PERIODO = $mes and Ejercicio = $anio";
                        //$res = $this->QueryObtieneDatosN();
                        $this->query=$a;
                        $res=$this->QueryObtieneDatosN();
                        $rowPoliza = ibase_fetch_object($res);
                        $folioA = (int)$rowPoliza->FOLIOA;
                        $folioN = $folioA + 1;
                            if(strlen($folioN) == 1){
                                $folioN = '    '.$folioN;
                            }elseif (strlen($folioN) == 2 ){
                                $folioN = '   '.$folioN;
                            }elseif (strlen($folioN) == 3 ) {
                                $folioN = '  '.$folioN;
                            }elseif (strlen($folioN) == 4) {
                                $folioN = ' '.$folioN;
                            }elseif (strlen($folioN) == 5) {
                                $folioN = $folioN;
                            }
            /// Insercion de la poliza 
            $this->query ="INSERT INTO POLIZAS18 VALUES ('Ig','$folioN', $mes, $anio, '$fechaR', substring('$concepto' from 1 for 119),0,'0','N',0,1,0,'Pegaso', '0', '0',0)";
            $rs=$this->EjecutaQuerySimple();
            if($rs == 0){
                /// arreglo para cachar los errores.

            }else{
                        /// Insertamos primer partida del Banco             
                        $this->query ="INSERT INTO AUXILIAR18 VALUES ('Ig','$folioN',1,$mes, $anio,'$cuentaBanco','$fechaR' ,substring('$concepto' from 1 for 119), 'D' ,$montoDoc,0,1,0,1,0,0,0,0, 'Pegaso' )";
                        $rs=$this->EjecutaQuerySimple();    
                        /// Insercion de partida de impuestos 
                        if($rs == false){
                            echo $this->query.'<p>';
                        }
                        $this->query ="INSERT INTO AUXILIAR18 VALUES ('Ig','$folioN',2,$mes, $anio, '218100100010000000003','$fechaR',substring('$concepto' from 1 for 119), 'D', $iva, 0,1,0,1,0,0,0,0, 'Pegaso')";
                        $rs=$this->EjecutaQuerySimple();
                        if($rs == false){
                            echo $this->query.'<p>';
                        }
                        $this->query ="INSERT INTO AUXILIAR18 VALUES ('Ig','$folioN',3,$mes, $anio, '218000100010000000003','$fechaR',substring('$concepto' from 1 for 119), 'H', $iva, 0,1,0,1,0,0,0,0, 'Pegaso')";
                        $rs=$this->EjecutaQuerySimple();
                        }
                        if($rs == false){
                            echo $this->query.'<p>';
                        }
                        /// insertamos partidas de los clientes-
                        $part = 4;
                        $totalPago = 0;
                        if($rs == 1 ){
                            if(isset($partida)){
                                foreach ($partida as $key2){
                                    $ida = $key2->IDA;
                                    $cuentaCliente = $key2->CUENTA_CONTABLE;
                                    $monto = $key2->MONTO_APLICADO;
                                    $docf = $key2->DOCUMENTO;
                                    /// Insercion de la poliza;
                                    $this->query ="INSERT INTO AUXILIAR18 VALUES('Ig','$folioN',$part, $mes, $anio,'$cuentaCliente','$fechaR', (substring('$concepto' from 1 for 80)||', '||'$ida'||', Fact:'||'$docf'), 'H' ,$monto, 0,1,0,1,0,0,0,0, 'Pegaso')";
                                    $res=$this->EjecutaQuerySimple();
                                    if($rs == false){
                                       echo $this->query.'<p>';
                                    }
                                    $part = $part + 1;
                                    $totalPago = $totalPago + $monto;
                                    $actualizacion[] = array(0,$ida,$folioN);
                                }
                                if($totalPago != $montoDoc){
                                    $saldo = $montoDoc - $totalPago;
                                    if($saldo > 0){
                                            $this->query="INSERT INTO AUXILIAR18 VALUES('Ig','$folioN',$part, $mes, $anio,'720000600030000000003','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'H' ,$saldo, 0,1,0,1,0,0,0,0, 'Pegaso')";
                                            $res=$this->EjecutaQuerySimple();
                                            if($rs == false){
                            echo $this->query.'<p>';
                        }
                                            echo 'El Pago con el ID: '.$idp.' con el monto '.$montoDoc.', solo tienen aplicaciones por '.$totalPago.' con una diferencia de '.$saldo.'.<p>';
                                            /// gasto financiero cuando es menor la aplicacion 7200-005-000
                                    }else{
                                            $this->query="INSERT INTO AUXILIAR18 VALUES('Ig','$folioN',$part, $mes, $anio,'730000100020000000003','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'D' ,$saldo, 0,1,0,1,0,0,0,0, 'Pegaso')";
                                            $res=$this->EjecutaQuerySimple();
                         if($rs == false){
                            echo $this->query.'<p>';
                        }
                                            echo 'El Pago con el ID: '.$idp.' con el monto '.$montoDoc.', solo tienen aplicaciones por '.$totalPago.' con una diferencia de '.$saldo.'.<p>';
                                            ////  a la 7300-0002-000    
                                    }
                                }
                                unset($partida);
                            }else{
                                    $saldo = $montoDoc - $totalPago;
                                    $this->query="INSERT INTO AUXILIAR18 VALUES('Ig','$folioN',$part, $mes, $anio,'115000200010000000003','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'H' ,$saldo, 0,1,0,1,0,0,0,0, 'Pegaso')";
                                    $res=$this->EjecutaQuerySimple();
                         if($rs == false){
                            echo $this->query.'<p>';
                        }
                                    echo 'El Pago con el ID: '.$idp.' con el monto '.$montoDoc.', solo tienen aplicaciones por '.$totalPago.' con una diferencia de '.$saldo.'.<p>';
                                            /// gasto financiero cuando es menor la aplicacion 7200-005-000
                            }              
            }
            
            $actualizacion[]=array($idp,0,$folioN);
        }
          foreach ($actualizacion as $key){
              $idp=$key[0];
              $ida=$key[1];
              $poliza = $key[2];
              echo 'Afectacion de poliza: '.$poliza.', pago: '.$idp.', aplicacion: '.$ida.'<p>';
          }
         //exit(print_r($actualizacion));
        return $actualizacion;
    }


    function crear_cuentas_clientes($rfc){

        var_dump($rfc);
        foreach ($rfc as $datosCliente) {
             $rfc = $datosCliente->RFC;
             $nombre = $datosCliente->NOMBRE;
             $cuentaCliente = $datosCliente->CTA_CONT;

                if($cuentaCliente == '0'){
            
                        $this->query= "SELECT iif(MAX(NUM_CTA) is null, 0, max(NUM_CTA)) as valor FROM CUENTAS17 WHERE RFC = '$rfc'";
                        $resultado = $this->QueryObtieneDatosN();
                        $rowCuenta = ibase_fetch_object($resultado);
                        $valCuenta = $rowCuenta->VALOR;
                        $cuentaCliente=$valCuenta;
                    
                        if($valCuenta ==  0 ){
                            $this->query ="SELECT MIN(NUM_CTA) as papa, substring(MAX(num_cta) from 8 for 3) as hija FROM CUENTAS17 WHERE NUM_CTA STARTING WITH ('1150001')";
                            $rs = $this->QueryObtieneDatosN();
                            $rowCtaDet= ibase_fetch_object($rs);
                            $ctaPapa = $rowCtaDet->PAPA;
                            $ctaHija = $rowCtaDet->HIJA;
                            $nueva = $ctaHija + 1;
                                if(strlen($nueva) == 1){
                                    $nueva = '00'.$nueva;
                                }elseif (strlen($nueva) == 2){
                                    $nueva = '0'.$nueva;
                                }elseif (strlen($nueva) == 3){
                                    $nueva = $nueva;
                                }
                                $cuentaNueva = substr($ctaPapa, 0, 7).$nueva.'00000000003';

                            $this->query = "INSERT INTO CUENTAS17 VALUES ('$cuentaNueva', 'A', 'D', substring('$datosCliente->NOMBRE' from 1 for 40), 'N', 1,'N','$ctaPapa', '115000000000000000001', 3, '', 0, '$rfc', '', 0,0, 0, '','N', 0, '', 0,'' )";
                            $rs= $this->EjecutaQuerySimple();
                            //echo $this->query;
                            $this->query = "INSERT INTO SALDOS17 (num_cta, Ejercicio) VALUES ('$cuentaNueva', 2016)";
                            $rs = $this->EjecutaQuerySimple();
                            $valCuenta = $cuentaNueva;
                            $cuentaCliente =$valCuenta;
                            $actualiza[]=array($rfc, $cuentaCliente);
                        }
                        $actualiza[]=array($rfc, $cuentaCliente);
                    }       
            }
            return $actualiza;
    }


    function crea_cuentas_proveedores($rfc){
        foreach ($rfc as $datosProveedor) {
             $rfc = $datosProveedor->RFC;
             $nombre = $datosProveedor->NOMBRE;
             $cuentaProveedor = $datosProveedor->CTA_CONT;
                if($cuentaProveedor == '0'){
                        $this->query= "SELECT iif(MAX(NUM_CTA) is null, 0, max(NUM_CTA)) as valor FROM CUENTAS17 WHERE RFC = '$rfc'";
                        $resultado = $this->QueryObtieneDatosN();
                        $rowCuenta = ibase_fetch_object($resultado);
                        $valCuenta = $rowCuenta->VALOR;
                        $cuentaProveedor=$valCuenta;
                            if($valCuenta == 0 ){
                                $this->query ="SELECT MIN(NUM_CTA) as papa, substring(MAX(num_cta) from 8 for 3) as hija FROM CUENTAS17 WHERE NUM_CTA STARTING WITH ('2110002')";
                                $rs = $this->QueryObtieneDatosN();
                                $rowCtaDet= ibase_fetch_object($rs);
                                $ctaPapa = $rowCtaDet->PAPA;
                                $ctaHija = $rowCtaDet->HIJA;
                                $nueva = $ctaHija + 1;
                                    if(strlen($nueva) == 1){
                                        $nueva = '00'.$nueva;
                                    }elseif (strlen($nueva) == 2){
                                        $nueva = '0'.$nueva;
                                    }elseif (strlen($nueva) == 3){
                                        $nueva = $nueva;
                                    }
                                    $cuentaNueva = substr($ctaPapa, 0, 7).$nueva.'00000000003';

                                $this->query = "INSERT INTO CUENTAS17 VALUES ('$cuentaNueva', 'A', 'D', substring('$datosProveedor->NOMBRE' from 1 for 40), 'N', 1,'N','$ctaPapa', '211000000000000000001', 3, '', 0, '$rfc', '', 0,0, 0, '','N', 0, '', 0,'' )";
                                $rs= $this->EjecutaQuerySimple();
                                //echo $this->query.'<p>';
                                $this->query = "INSERT INTO SALDOS17 (num_cta, Ejercicio) VALUES ('$cuentaNueva', 2017)";
                                $rs = $this->EjecutaQuerySimple();
                                $valCuenta = $cuentaNueva;
                                $cuentaCliente =$valCuenta;
                                $actualiza[]=array($rfc, $cuentaNueva);
                            }
                        $actualiza[]=array($rfc, $cuentaProveedor);
                    }       
            }
            return $actualiza;
    }

    function contabiliza_ventas($ventas){

        foreach ($ventas as $datosCliente){
            $cuentaCliente =$datosCliente->CTA_CONT;
            $mes = $datosCliente->MES;
            $anio = $datosCliente->ANIO;
            $fechaelab = $datosCliente->FECHAELAB;
            $concepto = $datosCliente->CVE_DOC.' - '.$datosCliente->CVE_CLPV.' - '.$datosCliente->NOMBRE.' - '.$datosCliente->FECHAELAB.' - '.$datosCliente->IMPORTE;
            $importe = $datosCliente->IMPORTE;
            $iva = $datosCliente->IMP_TOT4;
            $subtotal = $importe - $iva;
            $rfc = trim($datosCliente->RFC);
            $fechadoc = $datosCliente->FECHA_DOC;
            $docf = $datosCliente->CVE_DOC;
            $rfcs= 0;
            $cuentaCliente='';

            $this->query="SELECT NUM_CTA FROM CUENTAS18 WHERE trim(RFC) =trim('$rfc') and NUM_CTA STARTING WITH ('1150001')";
            $rs=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($rs);
            
            if($row){
                $cuentaCliente = $row->NUM_CTA;    
                $rfcs=$rfcs + 1;
            }else{
                echo $rfc.'<br/>';
            }
            //exit(print_r('--'.$cuentaCliente.'--'));
            if($cuentaCliente  != ''){
                    $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS18 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
                    $res = $this->QueryObtieneDatosN();
                    $rowPoliza = ibase_fetch_object($res);
                    $folio=$rowPoliza->FOLIOA + 1;
                        if(strlen($folio) == 1){
                            $folio = '    '.$folio;
                        }elseif (strlen($folio) == 2 ){
                            $folio = '   '.$folio;
                        }elseif (strlen($folio) == 3 ) {
                            $folio = '  '.$folio;
                        }elseif (strlen($folio) == 4) {
                            $folio = ' '.$folio;
                        }elseif (strlen($folio) == 5) {
                            $folio = $folio;
                        }
                    $this->query = "INSERT INTO POLIZAS18 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
                    $insPol = $this->EjecutaQuerySimple();
                    if($insPol==0){
                        $errores[]=array('Pol', $folio, $mes, $anio, $docf);
                    }else{
                        $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',1, $mes, $anio, '410000100010000000003', '$fechaelab', ('Ventas Nacionales, '||'$datosCliente->CVE_DOC'), 'H', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                        $res=$this->EjecutaQuerySimple();
                        if($res == 0){
                            $errores[]=array('AUX1', $folio, $mes, $anio, $docf);
                        }
                        $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100010000000003', '$fechaelab', ('Iva por Acreeditar, '||'$datosCliente->CVE_DOC '), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                        $result=$this->EjecutaQuerySimple();
                        if($result==0){
                            $errores[]=array('AUX2', $folio, $mes, $anio, $docf);
                        }
                        $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$datosCliente->NOMBRE'||', '||'$datosCliente->CVE_DOC'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                        $resultado=$this->EjecutaQuerySimple();
                        if($resultado == 0){
                            $errores[]=array('AUX3', $folio, $mes, $anio, $docf);
                        }
                         $actualizacion[]=array($folio, $docf, $rfc, $cuentaCliente);
                         //// ACTUALIZAMOS LA TABLA DE LOS FOLIO 
                        if($mes < 10 ){
                            $mes = '0'.$mes;
                        }
                        $campo = "FOLIO".$mes;
                        $this->query="UPDATE FOLIOS SET $campo = $folio where TIPPOL = 'Dr' and Ejercicio = $anio";
                        $this->EjecutaQuerySimple();
                    }
            }  
                
            if(isset($errores)){
                foreach ($errores as $key) {
                    echo $this->query.'<p>';
                    echo $key[0].', '.$key[1].', '.$key[2].', '.$key[3].', '.$key[4].'<p>';
                }
            }
        }        
                      
        return $actualizacion;
    }

    function contabiliza_NC($NC){
        foreach ($NC as $datosCliente){
            $cuentaCliente =$datosCliente->CTA_CONT;
            $mes = $datosCliente->MES;
            $anio = $datosCliente->ANIO;
            $fechaelab = $datosCliente->FECHAELAB;
            $concepto = $datosCliente->CVE_DOC.' - '.$datosCliente->CVE_CLPV.' - '.$datosCliente->NOMBRE.' - '.$datosCliente->FECHAELAB.' - '.$datosCliente->IMPORTE;
            $importe = $datosCliente->IMPORTE;
            $iva = $datosCliente->IMP_TOT4;
            $subtotal = $importe - $iva;
            $rfc = $datosCliente->RFC;
            $fechadoc = $datosCliente->FECHA_DOC;
            $docf = $datosCliente->CVE_DOC;
            $rfcs= 0;
            $cuentaCliente='';
            $this->query="SELECT NUM_CTA FROM CUENTAS18 WHERE trim(RFC) =trim('$rfc') and NUM_CTA STARTING WITH ('1150001')";
            $rs=$this->EjecutaQuerySimple();
            $row=ibase_fetch_object($rs);
            if($row){
                $cuentaCliente = $row->NUM_CTA;    
                $rfcs=$rfcs + 1;
            }else{
                echo $rfc.'<br/>';
            }
            if($cuentaCliente  != ''){
                $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS18 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
                $res = $this->QueryObtieneDatosN();
                $rowPoliza = ibase_fetch_object($res);
                $folio=$rowPoliza->FOLIOA + 1;
            
                    if(strlen($folio) == 1){
                        $folio = '    '.$folio;
                    }elseif (strlen($folio) == 2 ){
                        $folio = '   '.$folio;
                    }elseif (strlen($folio) == 3 ) {
                        $folio = '  '.$folio;
                    }elseif (strlen($folio) == 4) {
                        $folio = ' '.$folio;
                    }elseif (strlen($folio) == 5) {
                        $folio = $folio;
                    }
                $this->query = "INSERT INTO POLIZAS18 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
                $insPol = $this->EjecutaQuerySimple();
                if($insPol==0){
                    $errores[]=array('Pol', $folio, $mes, $anio, $docf);
                }else{
                    $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',1, $mes, $anio, '420000100010000000003', '$fechaelab', ('Devolucion de Venta Nacional, '||'$datosCliente->CVE_DOC'), 'D', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                    $res=$this->EjecutaQuerySimple();
                    if($res == 0){
                        $errores[]=array('AUX1', $folio, $mes, $anio, $docf);
                    }
                    $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100010000000003', '$fechaelab', ('Iva por Acreeditar, '||'$datosCliente->CVE_DOC '), 'D', $iva, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                    $result=$this->EjecutaQuerySimple();
                    if($result==0){
                        $errores[]=array('AUX2', $folio, $mes, $anio, $docf);
                    }
                    $this->query = "INSERT INTO AUXILIAR18 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$datosCliente->NOMBRE'||', '||'$datosCliente->CVE_DOC'), 'H', $importe, 0, 1, 0, 1, 0, 0, 0, 0, 'Pegaso') ";
                    $resultado=$this->EjecutaQuerySimple();
                    if($resultado == 0){
                        $errores[]=array('AUX3', $folio, $mes, $anio, $docf);
                    }
                    $actualizacion[]=array($folio, $docf, $rfc, $cuentaCliente);    
                }       
            }  
            if(isset($errores)){
                foreach ($errores as $key) {
                    echo $this->query.'<p>';
                    echo $key[0].', '.$key[1].', '.$key[2].', '.$key[3].', '.$key[4].'<p>';
                }
            }
        }    
        return $actualizacion;
    }

    function traeCuentasContables($buscar){
        $this->query="SELECT * FROM cuentas_FTC where UPPER(cuenta) containing(UPPER('$buscar')) or UPPER(nombre) containing(UPPER('$buscar')) or UPPER(cuenta_coi) containing(UPPER('$buscar')) and tipo = 'D'";
        $rs=$this->QueryDevuelveAutocompleteCuenta();
        return @$rs;
    }

    function verCuentasImp(){
        $data=array();
        $this->query="SELECT F.*, (SELECT C.NOMBRE FROM CUENTAS_FTC C WHERE C.CUENTA_COI = F.CUENTA_CONTABLE) AS NOMBRE_CUENTA FROM FTC_PARAM_COI F WHERE F.TIPO ='Traslado' or F.TIPO ='Retencion' or F.TIPO ='Exento'";
        $r=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($r)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function actCuentaImp($idc, $ncta){
        $this->query="UPDATE FTC_PARAM_COI SET CUENTA_COI = (SELECT F.CUENTA FROM CUENTAS_FTC F WHERE F.CUENTA_COI = '$ncta' ), CUENTA_CONTABLE = '$ncta' WHERE ID = $idc";
        $rs=$this->queryActualiza();
        if($rs==1 ){
            return array("mensaje"=>'Se Actualio la informacion', "status"=>'ok');
        }else{
            return array("mensaje"=>'Ocurrio un error, favor de verificar la informacion', "status"=>'no');
        }
    }


    function calculaFolio($mes, $anio, $tipo){
        $a = substr($anio, 2,2);
        $this->query="SELECT coalesce(max(num_poliz), 0) as poliza FROM POLIZAS$a where ejercicio= $anio and periodo = $mes and tipo_poli = '$tipo'";
        $res=$this->EjecutaQuerySimple();
        $row= ibase_fetch_object($res);
        $poliza = trim($row->POLIZA);
        $campo = 'FOLIO'.str_pad($mes, 2, '0', STR_PAD_LEFT);
        $this->query="UPDATE FOLIOS SET $campo = $poliza where ejercicio = $anio AND tipPoL = '$tipo'"; 
        $this->queryActualiza();
        return;
    }

    function creaPoliza($tipo, $uuid, $cabecera, $detalle, $impuestos){
        /// Obtenemos la fecha del documento
        $usuario=$_SESSION['user']->USER_LOGIN;

        foreach($cabecera as $cb){
            $periodo=$cb->PERIODO;
            $ejercicio=$cb->EJERCICIO;
            $eje=substr($ejercicio,2);
            $fecha=$cb->FECHA; 
            $nombre = $cb->NOMBRE;
            $tc = $cb->TIPOCAMBIO;
            $tbPol= 'POLIZAS'.$eje; 
            $tbAux= 'AUXILIAR'.$eje;
            $campo = 'FOLIO'.str_pad($periodo, 2, '0', STR_PAD_LEFT);
            $rfc= $cb->RFC;
            $doc = $cb->DOCUMENTO;
            $ie=$cb->TIPO;
        }
        $this->calculaFolio($acf = $periodo, $bcf= $ejercicio, $ccf= 'Dr');
        ///creamos el nuevo folio de la poliza y actualizamos para apartarlo
        $this->query="SELECT $campo FROM FOLIOS where tippol='$tipo' and Ejercicio=$ejercicio";
        $res=$this->EjecutaQuerySimple();
        $row= ibase_fetch_object($res);
        $folion = $row->$campo + 1; 
        $folio =str_pad($folion, 5, ' ', STR_PAD_LEFT);

        $this->query="UPDATE FOLIOS SET $campo = $folion where tippol='$tipo' and Ejercicio=$ejercicio";
        $this->queryActualiza();

        if($cb->CLIENTE == $_SESSION['rfc']){    
            $nat0= $ie=='I'? 'H':'D';
            $nat1=$ie=='I'? 'D':'H';
            $con = '';
            $tipoXML='Recibido';
        }else{
            $nat0=$ie=='I'? 'D':'H';
            $nat1=$ie=='I'? 'H':'D';
            $con = 'Venta ';
            $tipoXML='Emitido';
        }
        if($rfc=='XAXX010101000'){
            $z=$_SESSION['rfc'];
            $file="C:\\xampp\\htdocs\\uploads\\xml\\".$z."\\Emitidos\\XAXX010101000\\".$_SESSION['rfc'].'-'.$doc.'-'.$uuid.'.xml';
            //echo 'El rfc es generico debemos de obtener el nombre desde el xml: '.$uuid;
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
            }
            if($tipoXML == 'Emitido'){
                $nombre = $nombre_recep;
            }else{
                $nombre = $nombreE;
            }
        }
        
        foreach($cabecera as $pol){
            $TC =$pol->TIPOCAMBIO;
            $concepto = substr($con.', '.$pol->DOCUMENTO.', '.$nombre, 0, 110);
            $cuenta = $pol->CUENTA_CONTABLE;
            $this->query="INSERT INTO $tbPol(TIPO_POLI, NUM_POLIZ, PERIODO, EJERCICIO, FECHA_POL, CONCEP_PO, NUM_PART, LOGAUDITA, CONTABILIZ, NUMPARCUA, TIENEDOCUMENTOS, PROCCONTAB, ORIGEN, UUID, ESPOLIZAPRIVADA, UUIDOP) 
                                values ('$tipo','$folio', $periodo, $ejercicio, '$pol->FECHA', '$concepto', 0, '', 'N', 0, 1, 0, substring('PHP $usuario' from 1 for 15),'$uuid', 0, '')";
            $this->grabaBD();
            //echo '<br/>Inserta Poliza:'.$this->query.'<br/>';
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', 1, $periodo, $ejercicio, '$cuenta', '$pol->FECHA', '$concepto', '$nat0' , $pol->IMPORTE * $TC, 0, $tc, 0, 1, 0, 0, NULL,NULL)";
            $this->grabaBD();  
            //echo '<br/> Inserta Primer Partida'.$this->query.'<br/>';
            /// Validacion para la insercion de UUID.
        }
        $partida = 1;
        foreach ($detalle as $aux) {
            if($partida == 1){
                if($cb->CLIENTE == $_SESSION['rfc']){
                    if(substr($aux->CUENTA_CONTABLE, 0,1) == '6'){
                        $con = 'Gasto';
                    }else{
                        $con = 'Compra';
                    }    
                }else{
                    $con = '';
                }
                
                $this->query="UPDATE $tbAux SET CONCEP_PO = '$con'||' '||CONCEP_PO where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
                $this->query="UPDATE $tbPol SET CONCEP_PO = '$con'||' '||CONCEP_PO where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
            }
            $cuenta = '';
            $partida++;
            $partAux=$aux->PARTIDA;
            $cuenta = $aux->CUENTA_CONTABLE;
            $documento = $aux->DOCUMENTO;
            $concepto = substr($aux->DESCRIPCION.', '.$documento.', '.$nombre, 0, 120);
                $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$nat1', ($aux->IMPORTE - $aux->DESCUENTO) * $TC, 0, $tc, 0, $partida, 0,0, null, null)";
                $this->EjecutaQuerySimple();   
                //echo $this->query;
                foreach ($impuestos as $imp){
                    //echo '<br/>'.print_r($imp).'<br/>';
                    $impuesto=$imp->IMPUESTO;
                    $tasa = (float)$imp->TASA;
                    $mImp = $imp->MONTO * $TC; 
                    $par = $imp->PARTIDA; 
                    $factor =$imp->TIPOFACTOR;
                    $tf = $imp->TIPO;
                    $nom_1 = $aux->DESCRIPCION;
                    if($partAux == $par){
                        $cuenta = '';
                        $parImp = $partida + 1;
                        if($tf=='Retencion'){
                            $this->query="SELECT * FROM FTC_PARAM_COI WHERE impuesto = '$impuesto' and status= 1 and factor = '$factor' and tipo = '$tf' and poliza ='$tipo' and round(tasa,3) = round($tasa,3) and tipo_xml = '$tipoXML' and (CUENTA_CONTABLE != '' and CUENTA_CONTABLE is not null)";
                            //echo 'Consulta si existe Retencion: '.$this->query;
                        }else{
                            $this->query="SELECT * FROM FTC_PARAM_COI WHERE impuesto = '$impuesto' and status= 1 and factor = '$factor'and tipo = '$tf' and poliza ='$tipo' and round(tasa,3) = round($tasa,3) and tipo_xml = '$tipoXML' and (CUENTA_CONTABLE != '' and CUENTA_CONTABLE is not null)";
                            //echo 'Consulta si NO existe Retencion: '.$this->query;
                        }
                        //echo 'Busqueda de la cuenta de impuestos: '.$this->query;
                        $res=$this->EjecutaQuerySimple();
                        $rowImp=ibase_fetch_object($res);
                        if(!empty($rowImp)){
                            //echo 'Encontro impuesto'.$par;
                            $cuenta = $rowImp->CUENTA_CONTABLE;
                            $nom_1 = $rowImp->NOMBRE; 
                            $n= $rowImp->NAT==1? 'H':$nat1;
                                $concepto = substr($nom_1.' de la partida '.$partAux,0,120);
                                $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                                values ('$tipo', '$folio', $parImp, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$n', $mImp, 0, $tc, 0, $parImp, 0,0, null, null)";
                                //echo '<br/>'.$this->query.'<br/>';
                                $this->EjecutaQuerySimple();   
                                $partida++;
                        }else{
                            //echo 'La definicion del impueso no existe: '.$this->query;
                            $cuenta=$aux->CUENTA_CONTABLE;
                            $nom_1=$aux->DESCRIPCION;
                            $cuenta = $aux->CUENTA_CONTABLE;
                            $concepto = substr($nom_1.' de la partida '.$partAux,0,120);
                            $this->query="UPDATE $tbAux SET montomov = montomov + ($imp->MONTO * $TC) WHERE NUM_CTA = '$cuenta' and NUM_POLIZ = '$folio' and TIPO_POLI = '$tipo' and periodo = $periodo and ejercicio = $ejercicio";
                            /*
                            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                            values ('$tipo', '$folio', $parImp, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$nat1', $mImp, 0, $tc, 0, $parImp, 0,0, null, null)";
                            */
                            //echo '<br/>'.$this->query.'<br/>';
                            $this->EjecutaQuerySimple();   
                            //$partida++;
                        }
                    }
                    //echo '<br/> Tipo de impuesto: '.$tf.' <br/>';
                    if($tf=='local'){
                        //$parImp = $partida + 1;
                        $cuenta = $aux->CUENTA_CONTABLE;
                        //$concepto = substr($nom_1.' de la partida '.$partAux,0,120);
                        $this->query="UPDATE $tbAux SET montomov = montomov + ($imp->MONTO*$TC) WHERE NUM_CTA = '$cuenta' and NUM_POLIZ = '$folio' and TIPO_POLI = '$tipo' and periodo=$periodo and ejercicio=$ejercicio and num_part = ($parImp -1)";
                        $this->EjecutaQuerySimple();   
                        /*
                        $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                        values ('$tipo', '$folio', $parImp, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$nat1', $mImp, 0, $tc, 0, $parImp, 0,0, null, null)";
                        */
                        //echo '<br/>'.$this->query.'<br/>';
                        //$partida++;
                    }   
                }
        }
        $this->insertaUUID($tipo, $uuid, $pol, $folio, $ejercicio, $periodo);
        #### Revisa Cuadre de la poliza ####
        $this->revisaCuadre($pol, $folio, $ejercicio, $periodo, $tipo, $tbAux, $x='I',$tbPol);
        return $mensaje= array("status"=>'ok', "mensaje"=>'Se ha creado la poliza', "poliza"=>'Dr'.$folio,"numero"=>$folio,"ejercicio"=>$ejercicio, "periodo"=>$periodo);
    }

    function insertaUUID($tipo, $uuid, $pol, $folio, $ejercicio, $periodo){
        $data=array();
        $eje= substr($ejercicio,-2);
        $this->query="SELECT * FROM AUXILIAR$eje a left join cuentas$eje c on c.num_cta = a.num_cta where c.capturauuid = 1 and a.NUM_POLIZ='$folio' and a.periodo = $periodo and ejercicio = $ejercicio and TIPO_POLI = '$tipo'"; /// Anexar al ultima condicion.
        $res=$this->EjecutaQuerySimple();
        //echo $this->query;
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        //echo 'Valor del count de data: '.count($data);
        if(count($data) > 0){
            //echo '<br/> Encontro Datos e intenta la insercion:<br/>';
            foreach ($data as $a) {
                $this->query="INSERT INTO UUIDTIMBRES (NUMREG, UUIDTIMBRE, MONTO, SERIE, FOLIO, RFCEMISOR, RFCRECEPTOR, ORDEN, FECHA, TIPOCOMPROBANTE, TIPOCAMBIO, VERSIONCFDI, MONEDA)
                             VALUES ( (SELECT CTUUIDCOMP FROM CONTROL) + 1 , '$uuid', $pol->IMPORTE, '$pol->SERIE', '$pol->FOLIO', '$pol->RFCE', '$pol->CLIENTE', $a->NUM_PART, '$pol->FECHA', 1,  $pol->TIPOCAMBIO, '3.3', '$pol->MONEDA')";       
                $r=$this->grabaBD();
                if($r == 1 ){
                    $this->query="UPDATE CONTROL SET CTUUIDCOMP = CTUUIDCOMP + 1";
                    $this->queryActualiza();
                    $this->query="UPDATE AUXILIAR$eje a set a.IDUUID = (SELECT CTUUIDCOMP FROM CONTROL) where a.NUM_POLIZ='$folio' and a.periodo = $periodo and a.ejercicio = $ejercicio and a.NUM_PART = $a->NUM_PART";
                    $this->queryActualiza();
                }
            }
        }
       return;
    }

    function revisaCuadre($pol, $folio, $ejercicio, $periodo, $tipo, $tbAux, $x, $tbPol){
        if($x=='I'){
            $this->query="UPDATE $tbPol P SET  P.NUMPARCUA = 1 WHERE (select SUM(CASE WHEN A.DEBE_HABER = 'H' THEN A.MONTOMOV ELSE 0 END) - SUM(CASE WHEN A.DEBE_HABER = 'D' THEN A.MONTOMOV ELSE 0 END) FROM $tbAux A WHERE A.NUM_POLIZ = P.NUM_POLIZ AND A.PERIODO = P.PERIODO AND A.ejercicio = P.EJERCICIO AND A.tipo_poli = P.tipo_poli)  <> 0  
                and P.TIPO_POLI = '$tipo'
                and P.NUM_POLIZ = '$folio'
                and P.EJERCICIO = $ejercicio
                and P.periodo = $periodo";
        }else{
           $this->query="UPDATE $tbPol P SET  P.NUMPARCUA = 1 WHERE  (select SUM(CASE WHEN A.DEBE_HABER = 'H' THEN A.MONTOMOV ELSE 0 END) - SUM(CASE WHEN A.DEBE_HABER = 'D' THEN A.MONTOMOV ELSE 0 END) FROM $tbAux A WHERE A.NUM_POLIZ = P.NUM_POLIZ AND A.PERIODO = P.PERIODO AND A.ejercicio = P.EJERCICIO AND A.tipo_poli = P.tipo_poli)  <> 0";
        }
            //echo $this->query;
            $this->EjecutaQuerySimple();
        return;
    }

    function polizaFinal($uuid, $tipo, $idp, $infoPoliza, $impuestos2, $tipoXML, $cabecera){
        /// Insertamos la poliza de egreso nuevo sistema.
        $usuario=$_SESSION['user']->USER_LOGIN;
        $ejercicio = $infoPoliza['ejercicio'];
        $eje = substr($ejercicio, -2);
        $periodo = $infoPoliza['perido'];
        $periodo2 = str_pad($periodo, 2,'0',STR_PAD_LEFT);
        $fecha = $infoPoliza['fecha_edo'];
        $fac=' ';
        if(strpos($infoPoliza["obs"], "--")){
            $obs=explode("--",$infoPoliza["obs"]);
            @$fac=$obs[1];
            $obs=$obs[0];
        }else{
            $obs=$infoPoliza["obs"];
            $fac = $infoPoliza["factura"];
        }
        $concepto = substr($obs." ".$tipo." ".$infoPoliza['banco'].", pago factura ".$fac.", ".$infoPoliza['proveedor'].$infoPoliza['monto'], 0, 120);
        if($tipo == 'Egreso'){
            $subTipo = 'Eg';
            $dhc = 'D';
            $dhb = 'H';
            $dhimppc = 'D';
            $dhimppe = 'H';
        }elseif($tipo == 'Ingreso'){
            $subTipo = 'Ig';
            $dhc = 'H';
            $dhb = 'D';
            $dhimppc = 'H';
            $dhimppe = 'D';
        }
        $this->query="INSERT INTO POLIZAS$eje (TIPO_POLI, NUM_POLIZ, PERIODO, EJERCICIO, FECHA_POL, CONCEP_PO, NUM_PART, LOGAUDITA, CONTABILIZ, NUMPARCUA, TIENEDOCUMENTOS, PROCCONTAB, ORIGEN, UUID, ESPOLIZAPRIVADA, UUIDOP) 
                    VALUES ('$subTipo', lpad( cast((SELECT FOLIO$periodo2 FROM FOLIOS where TIPPOL='$subTipo' AND Ejercicio = $ejercicio ) as int) + 1, 5), $periodo, $ejercicio, '$fecha', '$concepto', 4, '','N', 0, 1, 0, substring('PHP $usuario' from 1 for 15), '$uuid', 0,'') returning NUM_POLIZ";
            //echo $this->query;
        $res=$this->grabaBD();
        $row=ibase_fetch_object($res);
        $par = 0;
        if(isset($row->NUM_POLIZ)){
            //echo 'Se grabo la poliza: '.$row->NUM_POLIZ;
            $this->query="UPDATE FOLIOS SET FOLIO$periodo2 = trim('$row->NUM_POLIZ') WHERE TIPPOL='$subTipo' AND Ejercicio = $ejercicio";
            $this->EjecutaQuerySimple();
            $par++;
            $ctaProv = $infoPoliza['ctaProvCoi'];
            $montoP = $infoPoliza['importe'];
            
            $montoI = ($infoPoliza['importe']/1.16)*.16;/// Aqui esta mal por que tenemos que tener el total del iva desde la misma factura o su desgloce de impuestos. 

            $ctaBanco = $infoPoliza['cuentaCoi'];
            $montoB = $infoPoliza['importe'];
            $conceptoA1 = substr($obs." ".'Pago Factura '.$fac.', '.$infoPoliza['proveedor'], 0,120);
            $conceptoA2 = substr($obs." ".$tipo.' '.$infoPoliza['banco'].' '.$infoPoliza['monto'], 0,120);
            $conceptoIA = substr($obs." ".'IVA Acreditable pagado de la factura '.$fac, 0,120);
            $conceptoIP = substr($obs." ".'IVA Pendiente de pago de la factura '.$fac, 0,120);
            if($tipoXML == 'Emitido'){
                $conceptoIA = substr($obs." ".'IVA Acreditable cobrado de la factura '.$fac, 0,120);
                $conceptoIP = substr($obs." ".'IVA Pendiente de cobro de la factura '.$fac, 0,120);
            }
            /// Proveedor 2001-001-031  Debe
            $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                        VALUES ('$subTipo', '$row->NUM_POLIZ', $par, $periodo, $ejercicio, '$ctaProv', '$fecha', '$conceptoA1', '$dhc', $montoP, 0, 1, 0, $par, 0,0, null , null)";
            $this->grabaBD();
            /// Banco 1002-001-001 Haber
            $par++;
            $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                        VALUES ('$subTipo', '$row->NUM_POLIZ', $par, $periodo, $ejercicio, '$ctaBanco', '$fecha', '$conceptoA2', '$dhb', $montoB, 0, 1, 0, $par, 0,0, null , null)";
            $this->grabaBD();
            
            //// aqui debemos de hacer la validacion de los impuestos. 

            // 1.- validamos que tenga impuestos, 
            if(count($impuestos2) > 0 ){
            /// 2.- Busca los parametros en la table de los parametros de impuestos FTC_param_coi
                foreach ($impuestos2 as $impt) {
                    $this->query="SELECT * FROM FTC_PARAM_COI WHERE status = 1 and IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = $impt->TASA AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = '$subTipo' and tipo_xml='$tipoXML' and (CUENTA_CONTABLE != '' and CUENTA_CONTABLE is not null) ";
                    $rs=$this->EjecutaQuerySimple();
                    //echo $this->query;
                    $rimp = ibase_fetch_object($rs);
                    if(!empty($rimp->CUENTA_CONTABLE )){ /// Si existe informacion de la cuenta de este impuesto, entonces insertamos la partida 2 partidas la contraparte de diario y la efectiva de Eg/Ig. 
                         /// IVA Acreditable pagado 1180-001-000 Debe
                        $ctaIVAap =$rimp->CUENTA_CONTABLE;
                        $par++;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                    VALUES ('$subTipo', '$row->NUM_POLIZ', $par, $periodo, $ejercicio, '$ctaIVAap', '$fecha', '$conceptoIA', '$dhimppc', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        //echo $this->query;
                        $this->grabaBD();

                        /// Buscamos la cuenta de Dr para la contrapartida.
                        $this->query="SELECT * FROM FTC_PARAM_COI WHERE status = 1 and IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = $impt->TASA AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = 'Dr' and tipo_xml='$tipoXML' and (CUENTA_CONTABLE != '' and CUENTA_CONTABLE is not null)";
                        $rs=$this->EjecutaQuerySimple();
                        $rimpCP = ibase_fetch_object($rs);
                        //// IVA pendiente de pago  1190-001-000 haber 
                        $ctaIVApp =$rimpCP->CUENTA_CONTABLE;//'119000100000000000002';
                        $par++;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                        VALUES ('$subTipo', '$row->NUM_POLIZ', $par, $periodo, $ejercicio, '$ctaIVApp', '$fecha', '$conceptoIP', '$dhimppe', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        $this->grabaBD();
                    }else{ // Si no, no hacemos nada.
                    }
                }
            }else{
            // Si no hay impuestos, no hace nada. 
            }   
        }
        //$pol=array("importe"=>$montoP, "serie"=>$serie, "folio"=>$folio, "rfce"=>$rfce, "cliente"=>$cliente, "fecha"=>$fecha, "tc"=>$tc, "moneda"=>$moneda);
        $this->insertaUUIDFinal($tipo=$subTipo, $uuid, $cabecera , $folio=$row->NUM_POLIZ, $ejercicio, $periodo, $infoPoliza);
        $this->insIntAdiPar($tipo=$subTipo,$uuid, $cabecera, $folio=$row->NUM_POLIZ, $ejercicio, $periodo, $infoPoliza);
        return array("status"=>'ok', "mensaje"=>'Se genero la poliza: '.$row->NUM_POLIZ, "tipo"=>$subTipo, "numero"=>$row->NUM_POLIZ, "periodo"=>$periodo, "ejercicio"=>$ejercicio);
    }

    function insertaUUIDFinal($tipo, $uuid, $pol, $folio, $ejercicio, $periodo, $infoPoliza){
        $data=array();
        $eje= substr($ejercicio,-2);
        //echo 'Insertar Informacion del UUID: ';
        //print_r($pol);
        $folio= str_pad(trim($folio),5," ",STR_PAD_LEFT);
        $this->query="SELECT * FROM AUXILIAR$eje a left join cuentas$eje c on c.num_cta = a.num_cta where c.capturauuid = 1 and a.NUM_POLIZ='$folio' and a.periodo = $periodo and ejercicio = $ejercicio and TIPO_POLI = '$tipo'"; /// Anexar al ultima condicion.
        $res=$this->EjecutaQuerySimple();
        //echo $this->query.'<br/>';
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        //echo 'Valor del count de data: '.count($data);
        if(count($data) > 0){
            //echo '<br/> Encontro Datos e intenta la insercion:<br/>';
            foreach ($data as $a) {
                $seried =$pol[0]->SERIE;
                $foliod =$pol[0]->FOLIO;
                $cliente = $pol[0]->CLIENTE;
                $monto = $pol[0]->IMPORTE;
                $tc = $pol[0]->TIPOCAMBIO;
                $moneda = $pol[0]->MONEDA;
                $rfce = $pol[0]->RFCE;
                $fecha = $pol[0]->FECHA;
                $this->query="INSERT INTO UUIDTIMBRES (NUMREG, UUIDTIMBRE, MONTO, SERIE, FOLIO, RFCEMISOR, RFCRECEPTOR, ORDEN, FECHA, TIPOCOMPROBANTE, TIPOCAMBIO, VERSIONCFDI, MONEDA)
                             VALUES ( (SELECT CTUUIDCOMP FROM CONTROL) + 1 , '$uuid', $monto, '$seried', '$foliod', '$rfce', '$cliente', $a->NUM_PART, '$fecha', 1,  $tc, '3.3', '$moneda')";       
                //echo $this->query;
                $r=$this->grabaBD();
                if($r == 1 ){
                    $this->query="UPDATE CONTROL SET CTUUIDCOMP = CTUUIDCOMP + 1";
                    $this->queryActualiza();
                    $this->query="UPDATE AUXILIAR$eje a set a.IDUUID = (SELECT CTUUIDCOMP FROM CONTROL) where a.NUM_POLIZ='$folio' and a.periodo = $periodo and a.ejercicio = $ejercicio and a.NUM_PART = $a->NUM_PART";
                    $this->queryActualiza();
                }
            }
        }
       return;
    }

    function insIntAdiPar($tipo,$uuid, $pol, $folio, $ejercicio, $periodo, $infoPoliza){
        $data=array();
        $eje= substr($ejercicio,-2);
        //print_r($infoPoliza); // Info Poliza es la informacion de la cuenta de Banco, monto de deposito etc..
        $this->query="SELECT * FROM AUXILIAR$eje a left join cuentas$eje c on c.num_cta = a.num_cta where c.CAPTURACHEQUE=1 and a.NUM_POLIZ='$folio' and a.periodo = $periodo and ejercicio = $ejercicio and TIPO_POLI = '$tipo'"; /// Anexar al ultima condicion.
        $res=$this->EjecutaQuerySimple();
        //echo $this->query;
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        //echo 'Valor del count de data: '.count($data);
        if(count($data) > 0){
            //echo '<br/> Encontro Datos e intenta la insercion:<br/>';
            foreach ($data as $a) {
                $seried =$pol[0]->SERIE;
                $foliod =$pol[0]->FOLIO;
                $cliente = $pol[0]->CLIENTE;
                $monto = $pol[0]->IMPORTE;
                $tc = $pol[0]->TIPOCAMBIO;
                $moneda = $pol[0]->MONEDA;
                $rfce = $pol[0]->RFCE;
                $fecha = $pol[0]->FECHA;
            $this->query="INSERT INTO INFADIPAR (NUMREG, FRMPAGO, NUMCHEQUE, BANCO, CTAORIG, FECHA, MONTO, BENEF, RFC, BANCODEST, CTADEST, BANCOORIGEXT, BANCODESTEXT, IDFISCAL) VALUES ( (SELECT CTINFADIPAR FROM CONTROL) + 1,'', '', 0, '', current_timestamp, 0, '','', 0,'','','','')";
            $r=$this->grabaBD();
                if($r == 1 ){
                    $this->query="UPDATE CONTROL SET CTINFADIPAR = CTINFADIPAR + 1";
                    $this->queryActualiza();
                    $this->query="UPDATE AUXILIAR$eje a set a.IDUUID = (SELECT CTINFADIPAR FROM CONTROL) where a.NUM_POLIZ='$folio' and a.periodo = $periodo and a.ejercicio = $ejercicio and a.NUM_PART = $a->NUM_PART";
                    $this->queryActualiza();
                }
            }
        }
        return;
    } 

    function sadPol($uuid, $tipo){
        $this->query="SELECT * FROM POLIZAS19 WHERE UUID ='$uuid' and origen containing('PHP')";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        if(!empty($row->NUM_POLIZ)){
            $pol=$row->NUM_POLIZ;
            $per = $row->PERIODO;
            $tipo = $row->TIPO_POLI;
            $eje = $row->EJERCICIO;
            $this->query="execute procedure BORRA_POLIZA_INDIVIDUAL('$pol', '$per', '$tipo', $eje)";
            $this->EjecutaQuerySimple();
            return array('status'=>'ok', 'Poliza'=>$tipo.$pol, "uuid"=>$uuid, 'numpoliza'=>$pol, 'tipopoliza'=>$tipo, 'periodo'=>$per, 'ejercicio'=>$eje);
        } 
    }

    function creaPolizaGasto($cabecera, $detalle, $tipo, $impuestos2, $z){
        $tipo = $tipo == 'gasto'? 'Eg':'Ig';
        $usuario=$_SESSION['user']->USER_LOGIN;
        $i=0;
        foreach($cabecera as $cb){
            $fecha = strtotime($cb->FECHA_EDO_CTA);
            $periodo= date("m", $fecha);
            $ejercicio=date("Y", $fecha);
            $eje=substr($ejercicio,2);
            $fecha=$cb->FECHA_EDO_CTA; 
            $proveedor=$cb->PROV;
            $saldo = $cb->SALDO;
            $tc = 1;
            $tbPol= 'POLIZAS'.$eje; 
            $tbAux= 'AUXILIAR'.$eje;
            $campo = 'FOLIO'.str_pad($periodo, 2, '0', STR_PAD_LEFT);
            $ie=$tipo;  
        }
        foreach($detalle as $dc){
            $rfcf= '';
            $proveedorf='';
            //print_r($dc);
            if($i>0){
                if($rfcf==''){
                    if($rfce != $dc->RFCE){
                        $rfcf='Multi Proveedor';
                        $proveedorf='Multi Proveedor';
                        break;
                    }else{
                        $rfcf=$dc->RFCE;
                        $proveedorf=$dc->PROV;
                    }
                }
            }else{
                $rfce=$dc->RFCE;
                $proveedor=$dc->PROV;
            }
            $i++;
        }

        $rfcf=($rfcf=='')? $rfce:$rfcf;
        $proveedorf=($proveedorf=='')? $proveedor:$proveedorf;
        ///creamos el nuevo folio de la poliza y actualizamos para apartarlo
        $this->query="SELECT $campo FROM FOLIOS where tippol='$tipo' and Ejercicio=$ejercicio";
        $res=$this->EjecutaQuerySimple();
        $row= ibase_fetch_object($res);
        $folion = $row->$campo + 1; 
        $folio =str_pad($folion, 5, ' ', STR_PAD_LEFT);

        $this->query="UPDATE FOLIOS SET $campo = $folion where tippol='$tipo' and Ejercicio=$ejercicio";
        $this->queryActualiza();

        foreach($cabecera as $pol){
            $con='Egreso '.$pol->CUENTA_BANCARIA;
            $concepto = substr($con.', '.$proveedorf.' -- '.$pol->REFERENCIA.', pago factura '.$pol->FACTURA, 0, 110);
            $cuenta = $pol->CTA_BANCO;
            if($tipo=='Eg'){
                $nat0 = 'H';
            }else{
                $nat0 = 'D';
            }

            $this->query="INSERT INTO $tbPol(TIPO_POLI, NUM_POLIZ, PERIODO, EJERCICIO, FECHA_POL, CONCEP_PO, NUM_PART, LOGAUDITA, CONTABILIZ, NUMPARCUA, TIENEDOCUMENTOS, PROCCONTAB, ORIGEN, UUID, ESPOLIZAPRIVADA, UUIDOP) 
                                values ('$tipo','$folio', $periodo, $ejercicio, '$pol->FECHA_EDO_CTA', substring( ('$pol->DOC'||' $concepto') from 1 for 120), 0, '', 'N', 0, 1, 0, substring('PHP $usuario' from 1 for 15),'', 0, '')";
            $this->grabaBD();
            //echo '<br/>Inserta Poliza:'.$this->query.'<br/>';
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', 1, $periodo, $ejercicio, '$cuenta', '$pol->FECHA_EDO_CTA', substring( ('$pol->DOC'||'  $concepto') from 1 for 120), '$nat0' , $pol->MONTO_PAGO, 0, $tc, 0, 1, 0, 0, NULL,NULL)";
            $this->grabaBD();  
            //echo '<br/> Inserta Primer Partida'.$this->query.'<br/>';
            /// Validacion para la insercion de UUID.
        }
        $partida = 1;
        if($tipo == 'Eg'){
            $subTipo = 'Eg';
            $dhc = 'D';
            $dhb = 'H';
            $dhimppc = 'D';
            $dhimppe = 'H';
        }
        $nat1=($nat0=='H')? 'D':'H';
        foreach ($detalle as $aux) {
            /*if($partida == 1){
                if( substr($aux->CUENTA_CONTABLE, 0,1) == '6'){
                    $con = 'Gasto';
                }else{
                    $con = 'Compra';
                }
                $this->query="UPDATE $tbAux SET CONCEP_PO = substring('$pol->DOC'||' $con'||' '||CONCEP_PO from 1 for 120) where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
                $this->query="UPDATE $tbPol SET CONCEP_PO = substring('$pol->DOC'||' $con'||' '||CONCEP_PO from 1 for 120) where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
            }*/
            $cuenta = '';
            $partida++;
            $partAux=$partida;//$aux->PARTIDA;
            $cuenta = $aux->CUENTA_CONTABLE;
            $documento = $aux->DOCUMENTO;
            $proveedor = $aux->PROV;
            $concepto = substr($pol->DOC.' '.$aux->DESCRIPCION.', '.$documento.', '.$proveedor, 0, 120);
                $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto', '$nat1', $aux->APLICADO, 0, $tc, 0, $partida, 0,0, null, null)";
                $this->grabaBD();   
                //echo '<br/>'.$aux->UUID.'<br/>';
                if(count($impuestos2) > 0){
                    foreach ($impuestos2 as $impInd){
                        if($aux->UUID == $impInd->UUID){
                            echo '<br/>No.-'.$partida.' del UUID: '.$impInd->UUID.' El impueso de esta partida es:  '.$impInd->MONTO;
                            //$partida ++;
                            //print_r($impt);
                            $tipoXML='Recibido';
                            $tasa=(empty($impInd->TASA))? 0:$impInd->TASA;  
                            $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impInd->IMPUESTO' AND round(TASA,3) = round($tasa,3) AND FACTOR = '$impInd->TIPOFACTOR' AND TIPO = '$impInd->TIPO' AND POLIZA  = '$subTipo' and tipo_xml='$tipoXML'";
                            $rs=$this->EjecutaQuerySimple();
                            //echo $this->query;
                            $rimp = ibase_fetch_object($rs);
                            if(!empty($rimp->CUENTA_CONTABLE )){ /// Si existe informacion de la cuenta de este impuesto, entonces insertamos la partida 2 partidas la contraparte de diario y la efectiva de Eg/Ig. 
                                 /// IVA Acreditable pagado 1180-001-000 Debe
                                $ctaIVAap =$rimp->CUENTA_CONTABLE;
                                $partida++;
                                $conceptoIA = $impInd->RFCE.', '.$rimp->NOMBRE;
                                $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                            VALUES ('$subTipo', '$folio', $partida, $periodo, $ejercicio, '$ctaIVAap', '$fecha', '$conceptoIA', '$dhimppc', $impInd->MONTO, 0, 1, 0, $partida, 0,0, null , null)";
                                //echo $this->query;
                                $this->grabaBD();
                                /// Buscamos la cuenta de Dr para la contrapartida.
                                $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impInd->IMPUESTO' AND round(TASA,3) = round($impInd->TASA,3) AND FACTOR = '$impInd->TIPOFACTOR' AND TIPO = '$impInd->TIPO' AND POLIZA  = 'Dr' and tipo_xml='$tipoXML'";
                                $rs=$this->EjecutaQuerySimple();
                                $rimpCP = ibase_fetch_object($rs);

                                //// IVA pendiente de pago  1190-001-000 haber 
                                $ctaIVApp =$rimpCP->CUENTA_CONTABLE;//'119000100000000000002';
                                $partida++;
                                $conceptoIP=$impInd->RFCE.', '.$rimpCP->NOMBRE;
                                $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                VALUES ('$subTipo', '$folio', $partida, $periodo, $ejercicio, '$ctaIVApp', '$fecha', '$conceptoIP', '$dhimppe', $impInd->MONTO, 0, 1, 0, $partida, 0,0, null , null)";
                                $this->grabaBD();
                            }else{ // Si no, no hacemos nada.
                            }
                           
                        }
                    }
                }
                //echo $this->query; 
            ### Inclusion de Impuestos por Partida ###
                /// Traemos el arreglo con los impuestos.
                /// 
        }

        $a=1;
        if($saldo > 0.001){  
            //print_r($detalle);
            $z=explode(":", $z);
            if(count($z)>0){
                print_r($z);
                $cuentaProv=$z[7];
            }else{
                $cuentaProv='';
            }
            echo 'Se crea una partida a la cuenta seleccionada por el saldo del documento, se suguiere la cuenta de proveedores diversos'.$saldo;
            $partida ++; 
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuentaProv','$fecha','Pago a: '||coalesce((SELECT NOMBRE FROM CUENTAS$eje where num_cta = '$cuentaProv'), 'Sin Proveedor,')||', el $fecha', '$nat1', $saldo, 0, $tc, 0, $partida, 0,0, null, null)";
            //echo $this->query;
            $this->EjecutaQuerySimple();   
            $a++; 
        }
        /* Se reemplaza por el sistema de Impuestos de forma individual.
        $par=count($detalle)+$a;
        if(count($impuestos2) > 0){
            /// 2.- Busca los parametros en la table de los parametros de impuestos FTC_param_coi
                foreach ($impuestos2 as $impt) {
                    //print_r($impt);
                    $tipoXML='Recibido';
                    $tasa=(empty($impt->TASA))? 0:$impt->TASA;  
                    $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($tasa,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = '$subTipo' and tipo_xml='$tipoXML'";
                    $rs=$this->EjecutaQuerySimple();
                    //echo $this->query;
                    $rimp = ibase_fetch_object($rs);
                    if(!empty($rimp->CUENTA_CONTABLE )){ /// Si existe informacion de la cuenta de este impuesto, entonces insertamos la partida 2 partidas la contraparte de diario y la efectiva de Eg/Ig. 
                         /// IVA Acreditable pagado 1180-001-000 Debe
                        $ctaIVAap =$rimp->CUENTA_CONTABLE;
                        $par++;
                        $conceptoIA = $pol->DOC.' '.$rimp->NOMBRE;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                    VALUES ('$subTipo', '$folio', $par, $periodo, $ejercicio, '$ctaIVAap', '$fecha', '$conceptoIA', '$dhimppc', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        //echo $this->query;
                        //$this->grabaBD();
                        /// Buscamos la cuenta de Dr para la contrapartida.
                        $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($impt->TASA,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = 'Dr' and tipo_xml='$tipoXML'";
                        $rs=$this->EjecutaQuerySimple();
                        $rimpCP = ibase_fetch_object($rs);

                        //// IVA pendiente de pago  1190-001-000 haber 
                        $ctaIVApp =$rimpCP->CUENTA_CONTABLE;//'119000100000000000002';
                        $par++;
                        $conceptoIP=$pol->DOC.' '.$rimpCP->NOMBRE;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                        VALUES ('$subTipo', '$folio', $par, $periodo, $ejercicio, '$ctaIVApp', '$fecha', '$conceptoIP', '$dhimppe', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        //$this->grabaBD();
                    }else{ // Si no, no hacemos nada.
                    }
                }
            }else{
            // Si no hay impuestos, no hace nada. 
            }
        */
        // Pendiente $this->insertaUUID($tipo, $uuid, $pol, $folio, $ejercicio, $periodo);
        //exit();
        return $mensaje= array("status"=>'ok', "mensaje"=>'Se ha creado la poliza', "poliza"=>'Eg'.$folio,"numero"=>$folio,"ejercicio"=>$ejercicio, "periodo"=>$periodo);
    }

    function creaPolizaIg($cabecera, $detalle, $tipo, $impuestos, $z){
        $tipo='Ig';
        $usuario=$_SESSION['user']->USER_LOGIN;
        $i=0;
        $fecha = strtotime($cabecera->FECHA_RECEP);
        $periodo= date("m", $fecha);
        $ejercicio=date("Y", $fecha);
        $eje=substr($ejercicio,2);
        $fecha=$cabecera->FECHA_RECEP; 
        $saldo = $cabecera->SALDO;
        $tc=1;
        $tbPol= 'POLIZAS'.$eje; 
        $tbAux= 'AUXILIAR'.$eje;
        $campo= 'FOLIO'.str_pad($periodo, 2, '0', STR_PAD_LEFT);
        $ie=$tipo;  
        foreach($detalle as $dc){
            $rfcf= '';
            $clientef='';
            if($i>0){
                if($rfcf==''){
                    if($rfce != $dc->RFC){
                        $rfcf='Multi Cliente';
                        $clientef='Multi Cliente';
                        break;
                    }else{
                        $rfcf=$dc->RFC;
                        $clientef=$dc->NOMBRE;
                    }
                }
            }else{
                $rfce=$dc->RFC;
                $cliente=$dc->NOMBRE;
            }
            $i++;
        }
        $rfcf=($rfcf=='')? $rfce:$rfcf;
        $clientef=($clientef=='')? $cliente:$clientef;
        ///creamos el nuevo folio de la poliza y actualizamos para apartarlo
        $this->query="SELECT $campo FROM FOLIOS where tippol='$tipo' and Ejercicio=$ejercicio";
        $res=$this->EjecutaQuerySimple();
        $row= ibase_fetch_object($res);
        $folion = $row->$campo + 1; 
        $folio =str_pad($folion, 5, ' ', STR_PAD_LEFT);
        $this->query="UPDATE FOLIOS SET $campo = $folion where tippol='$tipo' and Ejercicio=$ejercicio";
        $this->queryActualiza();
            $con= $cabecera->BANCO;
            $concepto = substr($con.', '.$cabecera->CONTABILIZADO.', '.$clientef.' -- '.$cabecera->OBS.' $'.number_format($cabecera->MONTO,2), 0, 110);
            $cuenta = $cabecera->CCOI;
            if($tipo=='gasto'){
                $nat0='H';
            }else{
                $nat0='D';
            }
            $this->query="INSERT INTO $tbPol(TIPO_POLI, NUM_POLIZ, PERIODO, EJERCICIO, FECHA_POL, CONCEP_PO, NUM_PART, LOGAUDITA, CONTABILIZ, NUMPARCUA, TIENEDOCUMENTOS, PROCCONTAB, ORIGEN, UUID, ESPOLIZAPRIVADA, UUIDOP) 
                                values ('$tipo','$folio', $periodo, $ejercicio, '$cabecera->FECHA_RECEP', '$concepto', 0, '', 'N', 0, 1, 0, substring('PHP $usuario' from 1 for 15),'', 0, '')";
            $this->grabaBD();
            //echo '<br/>Inserta Poliza:'.$this->query.'<br/>';
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', 1, $periodo, $ejercicio, '$cuenta', '$cabecera->FECHA_RECEP', '$concepto', '$nat0' , $cabecera->MONTO, 0, $tc, 0, 1, 0, 0, NULL,NULL)";
            $this->grabaBD();  
        $partida = 1;
        if($tipo == 'Ig'){
            $subTipo = 'Ig';
            $dhc = 'H';
            $dhb = 'D';
            $dhimppc = 'H';
            $dhimppe = 'D';
        }
        foreach ($detalle as $aux){
            if($partida == 1){
                $con = 'Ingreso ';
                $this->query="UPDATE $tbAux SET CONCEP_PO = '$con'||' '||CONCEP_PO where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
                $this->query="UPDATE $tbPol SET CONCEP_PO = '$con'||' '||CONCEP_PO where TIPO_POLI = '$tipo' and NUM_POLIZ = '$folio' and PERIODO = $periodo and EJERCICIO = $ejercicio";
                $this->queryActualiza();
            }
            $nat1=($nat0=='H')? 'D':'H';
            $cuenta = '';
            $partida++;
            $partAux=$partida;//$aux->PARTIDA;
            $cuenta = $aux->CUENTA_CONTABLE;
            $documento = $aux->DOCUMENTO;
            $cliente = $aux->NOMBRE;
            $concepto = substr($con.'--'.$documento.', '.$aux->FORMA_PAGO.'--'.$cliente, 0, 120);
                $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$nat1', $aux->MONTO_APLICADO, 0, $tc, 0, $partida, 0,0, null, null)";
                $this->EjecutaQuerySimple();   
        }
        $a=1;
        if($saldo > 0.001){  
            $z=explode(":", $z);
            if(count($z)>0){
                $cuentaProv=$z[7];
            }else{
                $cuentaProv='';
            }
            //secho 'Se crea una partida a la cuenta seleccionada por el saldo del documento';
            $partida ++; 
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuentaProv','$fecha', coalesce((SELECT NOMBRE FROM CUENTAS$eje where num_cta = '$cuentaProv'), 'Sin Proveedor') ,'$nat1', $saldo, 0, $tc, 0, $partida, 0,0, null, null)";
            $this->EjecutaQuerySimple();   
            $a++; 
        }
        $par=count($detalle)+$a;
        if(count($impuestos) > 0){
            /// 2.- Busca los parametros en la table de los parametros de impuestos FTC_param_coi
                foreach ($impuestos as $impt) {
                    //print_r($impt);
                    $tipoXML='Emitido';
                    $tasa=(empty($impt->TASA))? 0:$impt->TASA;  
                    $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($tasa,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA='Ig' and tipo_xml='$tipoXML'";
                    $rs=$this->EjecutaQuerySimple();
                    //echo $this->query;
                    $rimp = ibase_fetch_object($rs);
                    if(!empty($rimp->CUENTA_CONTABLE )){ /// Si existe informacion de la cuenta de este impuesto, entonces insertamos la partida 2 partidas la contraparte de diario y la efectiva de Eg/Ig. 
                         /// IVA Acreditable pagado 1180-001-000 Debe
                        $ctaIVAap =$rimp->CUENTA_CONTABLE;
                        $par++;
                        $conceptoIA = $rimp->NOMBRE;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                    VALUES ('$subTipo', '$folio', $par, $periodo, $ejercicio, '$ctaIVAap', '$fecha', '$conceptoIA', '$dhimppc', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        //echo $this->query;
                        $this->grabaBD();
                        /// Buscamos la cuenta de Dr para la contrapartida.
                        $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($impt->TASA,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = 'Dr' and tipo_xml='$tipoXML'";
                        $rs=$this->EjecutaQuerySimple();
                        $rimpCP = ibase_fetch_object($rs);

                        //// IVA pendiente de pago  1190-001-000 haber 
                        $ctaIVApp =$rimpCP->CUENTA_CONTABLE;//'119000100000000000002';
                        $par++;
                        $conceptoIP=$rimpCP->NOMBRE;
                        $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                        VALUES ('$subTipo', '$folio', $par, $periodo, $ejercicio, '$ctaIVApp', '$fecha', '$conceptoIP', '$dhimppe', $impt->MONTO, 0, 1, 0, $par, 0,0, null , null)";
                        $this->grabaBD();
                    }else{ // Si no, no hacemos nada.
                    }
                }
            }else{
            // Si no hay impuestos, no hace nada. 
            }
        // insercion del registro del uuid en la poliza de Ig.    
        foreach ($detalle as $idet){
            $seried = explode("-", $idet->DOCUMENTO);
            $rfce=$_SESSION['rfc'];
            $pol=array("SERIE"=>$seried[0] , "FOLIO"=>$seried[1], "CLIENTE"=>$idet->RFC, "IMPORTE"=>$idet->MONTO_APLICADO, "TIPOCAMBIO"=>1, "MONEDA"=>'MNX', "RFCE"=>$rfce, "FECHA"=>$idet->FECHA, "CC"=>$idet->CUENTA_CONTABLE);
            $this->insertaUUIDFinalIg('Ig', $idet->OBSERVACIONES, $pol, $folio, $ejercicio, $periodo, false );
            unset($pol);
        }
        return $mensaje= array("status"=>'ok', "mensaje"=>'Se ha creado la poliza', "poliza"=>'Ig'.$folio,"numero"=>$folio,"ejercicio"=>$ejercicio, "periodo"=>$periodo);
    }


    function creaPolizaIgDetImp($cabecera, $detalle, $tipo, $impuestos, $z){
        $tipo='Ig';
        $usuario=$_SESSION['user']->USER_LOGIN;
        $i=0;
        $fecha = strtotime($cabecera->FECHA_RECEP);
        $periodo= date("m", $fecha);
        $ejercicio=date("Y", $fecha);
        $eje=substr($ejercicio,2);
        $fecha=$cabecera->FECHA_RECEP; 
        $saldo = $cabecera->SALDO;
        $tc=1;
        $tbPol= 'POLIZAS'.$eje; 
        $tbAux= 'AUXILIAR'.$eje;
        $campo= 'FOLIO'.str_pad($periodo, 2, '0', STR_PAD_LEFT);
        $ie=$tipo;  
        $fac=' ';
        if(strpos($cabecera->OBS, "--")){
            $obs=explode("--",$cabecera->OBS);
            @$fac=$obs[1];
            $obs=$obs[0];
        }else{
            $obs=$cabecera->OBS;
        }
        foreach($detalle as $dc){
            $rfcf= '';
            $clientef='';
            $por=$dc->PORC;
            if($i>0){
                if($rfcf==''){
                    if($rfce != $dc->RFC){
                        $rfcf='Multi Cliente';
                        $clientef='Multi Cliente';
                        break;
                    }else{
                        $rfcf=$dc->RFC;
                        $clientef=$dc->NOMBRE;
                    }
                }
            }else{
                $rfce=$dc->RFC;
                $cliente=$dc->NOMBRE;
            }
            $i++;
        }
        $rfcf=($rfcf=='')? $rfce:$rfcf;
        $clientef=($clientef=='')? $cliente:$clientef;
        ///creamos el nuevo folio de la poliza y actualizamos para apartarlo
        $this->query="SELECT $campo FROM FOLIOS where tippol='$tipo' and Ejercicio=$ejercicio";
        $res=$this->EjecutaQuerySimple();
        $row= ibase_fetch_object($res);
        $folion = $row->$campo + 1; 
        $folio =str_pad($folion, 5, ' ', STR_PAD_LEFT);
        $this->query="UPDATE FOLIOS SET $campo = $folion where tippol='$tipo' and Ejercicio=$ejercicio";
        $this->queryActualiza();
            $con= $cabecera->BANCO;
            $concepto = substr($obs.' Ingreso '.$con.', '.$cabecera->CONTABILIZADO.', pago de factura(s) '.$fac.' '.$clientef.' $'.number_format($cabecera->MONTO,2), 0, 110);
            $cuenta = $cabecera->CCOI;
            if($tipo=='gasto'){
                $nat0='H';
            }else{
                $nat0='D';
            }
            $this->query="INSERT INTO $tbPol(TIPO_POLI, NUM_POLIZ, PERIODO, EJERCICIO, FECHA_POL, CONCEP_PO, NUM_PART, LOGAUDITA, CONTABILIZ, NUMPARCUA, TIENEDOCUMENTOS, PROCCONTAB, ORIGEN, UUID, ESPOLIZAPRIVADA, UUIDOP) 
                                values ('$tipo','$folio', $periodo, $ejercicio, '$cabecera->FECHA_RECEP', '$concepto', 0, '', 'N', 0, 1, 0, substring('PHP $usuario' from 1 for 15),'', 0, '')";
            $this->grabaBD();
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', 1, $periodo, $ejercicio, '$cuenta', '$cabecera->FECHA_RECEP', '$concepto', '$nat0' , $cabecera->MONTO, 0, $tc, 0, 1, 0, 0, NULL,NULL)";
            $this->grabaBD();  
        $partida = 1;
        if($tipo == 'Ig'){
            $subTipo = 'Ig';
            $dhc = 'H';
            $dhb = 'D';
            $dhimppc = 'H';
            $dhimppe = 'D';
        }
        $partAux=0;//$aux->PARTIDA;

        foreach ($detalle as $aux){
            $nat1=($nat0=='H')? 'D':'H';
            $cuenta = '';
            $partida++;
            $partAux++;
            $cuenta = $aux->CUENTA_CONTABLE;
            $documento = $aux->DOCUMENTO;
            $cliente = $aux->NOMBRE;
            $concepto = substr($con.'--'.$documento.', '.$aux->FORMA_PAGO.'--'.$cliente, 0, 120);
                $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuenta','$fecha', '$concepto','$nat1', $aux->MONTO_APLICADO, 0, $tc, 0, $partida, 0,0, null, null)";
                $this->EjecutaQuerySimple();   
            ######### Insercion de los impuestos por partida:
            if(count($impuestos) > 0){
                /// 2.- Busca los parametros en la table de los parametros de impuestos FTC_param_coi
                  //$par=count($detalle)+$a;
                    foreach ($impuestos as $impt) {
                        //print_r($impt);
                        if($impt->PARTIDA == $partAux){
                            $tipoXML='Emitido';
                            $tasa=(empty($impt->TASA))? 0:$impt->TASA;  
                            $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($tasa,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA='Ig' and tipo_xml='$tipoXML'";
                            $rs=$this->EjecutaQuerySimple();
                            //echo $this->query;
                            $rimp = ibase_fetch_object($rs);
                            if(!empty($rimp->CUENTA_CONTABLE )){ /// Si existe informacion de la cuenta de este impuesto, entonces insertamos la partida 2 partidas la contraparte de diario y la efectiva de Eg/Ig. 
                                 /// IVA Acreditable pagado 1180-001-000 Debe
                                $ctaIVAap =$rimp->CUENTA_CONTABLE;
                                $partida++;
                                $conceptoIA = $rimp->NOMBRE."  ".$aux->RFC;
                                $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                            VALUES ('$subTipo', '$folio', $partida, $periodo, $ejercicio, '$ctaIVAap', '$fecha', '$conceptoIA', '$dhimppc', $impt->MONTO, 0, 1, 0, $partida, 0,0, null , null)";
                                //echo $this->query;
                                $this->grabaBD();
                                /// Buscamos la cuenta de Dr para la contrapartida.
                                $this->query="SELECT * FROM FTC_PARAM_COI WHERE IMPUESTO = '$impt->IMPUESTO' AND round(TASA,3) = round($impt->TASA,3) AND FACTOR = '$impt->TIPOFACTOR' AND TIPO = '$impt->TIPO' AND POLIZA  = 'Dr' and tipo_xml='$tipoXML'";
                                $rs=$this->EjecutaQuerySimple();
                                $rimpCP = ibase_fetch_object($rs);

                                //// IVA pendiente de pago  1190-001-000 haber 
                                $ctaIVApp =$rimpCP->CUENTA_CONTABLE;//'119000100000000000002';
                                $partida++;
                                $conceptoIP=$rimpCP->NOMBRE."  ".$aux->RFC;
                                $this->query="INSERT INTO AUXILIAR$eje (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                VALUES ('$subTipo', '$folio', $partida, $periodo, $ejercicio, '$ctaIVApp', '$fecha', '$conceptoIP', '$dhimppe', $impt->MONTO, 0, 1, 0, $partida, 0,0, null , null)";
                                $this->grabaBD();
                            }else{ // Si no, no hacemos nada.
                            }    
                        }
                        
                    }
            }else{
                // Si no hay impuestos, no hace nada. 
            }
        }#### Finaliza la insercion de las partidas con sus impuestos.
        $a=1;
        if($saldo > 0.001){  
            $z=explode(":", $z);
            if(count($z)>0){
                $cuentaProv=$z[7];
            }else{
                $cuentaProv='';
            }
            //secho 'Se crea una partida a la cuenta seleccionada por el saldo del documento';
            $partida ++; 
            $this->query="INSERT INTO $tbAux (TIPO_POLI, NUM_POLIZ, NUM_PART, PERIODO, EJERCICIO, NUM_CTA, FECHA_POL, CONCEP_PO, DEBE_HABER, MONTOMOV, NUMDEPTO, TIPCAMBIO, CONTRAPAR, ORDEN, CCOSTOS, CGRUPOS, IDINFADIPAR, IDUUID) 
                                values ('$tipo', '$folio', $partida, $periodo, $ejercicio, '$cuentaProv','$fecha', coalesce((SELECT NOMBRE FROM CUENTAS$eje where num_cta = '$cuentaProv'), 'Sin Proveedor') ,'$nat1', $saldo, 0, $tc, 0, $partida, 0,0, null, null)";
            $this->EjecutaQuerySimple();   
            $a++; 
        }


        
        // insercion del registro del uuid en la poliza de Ig.    
        foreach ($detalle as $idet){
            $seried = explode("-", $idet->DOCUMENTO);
            $rfce=$_SESSION['rfc'];
            $pol=array("SERIE"=>$seried[0] , "FOLIO"=>$seried[1], "CLIENTE"=>$idet->RFC, "IMPORTE"=>$idet->MONTO_APLICADO, "TIPOCAMBIO"=>1, "MONEDA"=>'MNX', "RFCE"=>$rfce, "FECHA"=>$idet->FECHA, "CC"=>$idet->CUENTA_CONTABLE);
            $this->insertaUUIDFinalIg('Ig', $idet->OBSERVACIONES, $pol, $folio, $ejercicio, $periodo, false );
            unset($pol);
        }
        return $mensaje= array("status"=>'ok', "mensaje"=>'Se ha creado la poliza', "poliza"=>'Ig'.$folio,"numero"=>$folio,"ejercicio"=>$ejercicio, "periodo"=>$periodo);
    }

    function insertaUUIDFinalIg($tipo, $uuid, $pol, $folio, $ejercicio, $periodo, $infoPoliza){
        $data=array();
        $eje= substr($ejercicio,-2);
        //echo 'Insertar Informacion del UUID: ';
        //print_r($pol);
        $folio= str_pad(trim($folio),5," ",STR_PAD_LEFT);
        $cc= $pol['CC'];
        $this->query="SELECT * FROM AUXILIAR$eje a left join cuentas$eje c on c.num_cta = a.num_cta where c.capturauuid = 1 and a.NUM_POLIZ='$folio' and a.periodo = $periodo and ejercicio = $ejercicio and TIPO_POLI = '$tipo' AND a.num_cta= '$cc'"; /// Anexar al ultima condicion.
        $res=$this->EjecutaQuerySimple();
        //echo $this->query.'<br/>';
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        //echo 'Valor del count de data: '.count($data);
        if(count($data) > 0){
            //echo '<br/> Encontro Datos e intenta la insercion:<br/>';
            foreach ($data as $a) {
                $seried =$pol['SERIE'];
                $foliod =$pol['FOLIO'];
                $cliente = $pol['CLIENTE'];
                $monto = $pol['IMPORTE'];
                $tc = $pol['TIPOCAMBIO'];
                $moneda = $pol['MONEDA'];
                $rfce = $pol['RFCE'];
                $fecha = $pol['FECHA'];
                $this->query="INSERT INTO UUIDTIMBRES (NUMREG, UUIDTIMBRE, MONTO, SERIE, FOLIO, RFCEMISOR, RFCRECEPTOR, ORDEN, FECHA, TIPOCOMPROBANTE, TIPOCAMBIO, VERSIONCFDI, MONEDA)
                             VALUES ( (SELECT CTUUIDCOMP FROM CONTROL) + 1 , '$uuid', $monto, '$seried', '$foliod', '$rfce', '$cliente', $a->NUM_PART, '$fecha', 1,  $tc, '3.3', '$moneda')";       
                $r=$this->grabaBD();
                if($r == 1 ){
                    $this->query="UPDATE CONTROL SET CTUUIDCOMP = CTUUIDCOMP + 1";
                    $this->queryActualiza();
                    $this->query="UPDATE AUXILIAR$eje a set a.IDUUID = (SELECT CTUUIDCOMP FROM CONTROL) where a.NUM_POLIZ='$folio' and a.periodo = $periodo and a.ejercicio = $ejercicio and a.NUM_PART = $a->NUM_PART";
                    $this->queryActualiza();
                }
            }
        }
       return;
    }

    function traePolizas($mes, $anio, $ide){
        $this->query="SELECT * FROM POLIZAS19 WHERE EJERCICIO = $anio and periodo=$mes";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function traeAuxiliares($mes, $anio, $ide, $uuid=false, $doc){
        $data= array();
        $eje = substr($anio, 2,2);
        $periodo = $mes==0?  '':' and periodo ='.$mes;
         $this->query="SELECT a.debe_haber, a.tipo_poli, a.num_poliz, (select origen from polizas$eje p where p.tipo_poli = a.tipo_poli and p.num_poliz = a.num_poliz and p.periodo = a.periodo and p.ejercicio = a.ejercicio ) as Origen, a.num_part, a.periodo, a.fecha_pol, (select c.cuenta from cuentas_ftc c where a.num_cta = c.cuenta_coi) as num_cta, c.nombre, a.montomov, a.tipcambio  from auxiliar$eje a left join cuentas$eje c on c.num_cta = a.num_cta where  ejercicio = $anio $periodo order by  a.periodo, a.tipo_poli, a.num_poliz ";
        $res=$this->EjecutaQuerySimple();
        //echo $this->query;
        //exit();
        while ($tsArray=ibase_fetch_object($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function borraCuenta($idImp, $opcion){
        if($opcion == 'Eliminar'){
            $this->query="UPDATE FTC_PARAM_COI SET CUENTA_CONTABLE = '', cuenta_coi = '' WHERE ID = $idImp";
        }else{
            $opcion=$opcion=='Activar'? 1:0;
            $this->query="UPDATE FTC_PARAM_COI SET status = $opcion WHERE ID = $idImp";
        }
        $this->EjecutaQuerySimple();
        return array("status"=>'ok');
    }

    function grabaImp($imp, $cccoi, $tipo , $tasa, $uso, $nombre, $factor, $aplica, $status){
        $status = $status=='Activo'? 1:0;
        $cuenta = array();
        $cc = '';
        $coi = '';
        if(strlen($cccoi) > 0 ){
            $cuenta = explode(":", $cccoi);
            @$coi = $cuenta[0];
            @$cc = $cuenta[7];
            if(count($cuenta)<8){
            echo '<script type="text/javascript">alert("No se encontro la cuenta -->'.$cccoi.'<-- en el Catalogo de cuentas, favor de seleccionarla correctamente")</script>';
            return;
            }
        }
        if((float)$tasa and (float)$tasa < 1 and $factor=='Tasa'){
            $tasa = (float)$tasa;
            $this->query = "INSERT INTO FTC_PARAM_COI (ID, IMPUESTO, CUENTA_CONTABLE, TIPO, TASA, STATUS, NOMBRE, POLIZA, FACTOR, CUENTA_COI, NAT, TIPO_XML) VALUES (NULL, '$imp', '$cc', '$tipo', $tasa, $status, '$nombre', '$uso', '$factor', '$coi', (SELECT NATURALEZA FROM CUENTAS19 WHERE NUM_CTA = '$cc'), '$aplica')";
            if(@$res=$this->grabaBD()){
                echo '<script type="text/javascript">alert("Se ha insertado correctamente el impuesto")</script>';
            }else{
                echo '<script type="text/javascript">alert("Lo sentimos al parecer ya existe un impuesto con esa informacion, favor de verificarla")</script>';
            }
            return;
        }else{
            echo '<script type="text/javascript">alert("El valor del Factor debe de ser menor a 1 cuando el fator es tasa ya que significaria que es el 100%")</script>';
        }
    }

    function acmd($mes, $anio){
        $eje=substr($anio, 2);
        //$tipos= array("Dr", "Ig", "Eg");
        $tipos= array("Dr");
        for ($i=0; $i <count($tipos) ; $i++) { 
            $this->query="SELECT * FROM POLIZAS$eje where ejercicio =$anio and periodo = $mes and tipo_poli = '$tipos[$i]' order by fecha_pol";
            $res=$this->EjecutaQuerySimple();
            while ($tsArray=ibase_fetch_object($res)){
                $data[]=$tsArray;
            }
            $num = 0;
            if(count($data)>0){
                $this->query="UPDATE POLIZAS$eje set num_poliz = 'a'||trim(num_poliz) where  ejercicio =$anio and periodo = $mes and tipo_poli = '$tipos[$i]'";
                $this->queryActualiza();
                $this->query="UPDATE AUXILIAR$eje set num_poliz = 'a'||trim(num_poliz) where  ejercicio =$anio and  periodo = $mes and tipo_poli = '$tipos[$i]'";
                $this->queryActualiza();
                foreach ($data as $k){
                    $num++;
                    $this->query="UPDATE POLIZAS$eje set num_poliz=lpad('$num',5) where num_poliz= 'a'||trim('$k->NUM_POLIZ') and tipo_poli = '$tipos[$i]'";
                    $this->queryActualiza();
                    $this->query="UPDATE AUXILIAR$eje set num_poliz=lpad('$num',5) where num_poliz= 'a'||trim('$k->NUM_POLIZ') and tipo_poli = '$tipos[$i]'";
                    $this->queryActualiza();
                }
            }
            unset($data);
        }
        $this->query="SELECT * FROM POLIZAS$eje where ejercicio =$anio and periodo = $mes order by fecha_pol";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function upl_param($file, $x){
        $d = new pegaso;
        $inputFileType=PHPExcel_IOFactory::identify($file);
        $objReader=PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel=$objReader->load($file);
        $sheet=$objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        for ($row=12; $row <= $highestRow; $row++){ //10
            $par = $sheet->getCell("I".$row)->getValue();
            $ctaPar=$sheet->getCell("O".$row)->getValue();
            $ctaCab=$sheet->getCell("Z".$row)->getValue();
            $uuid = $sheet->getCell("C".$row)->getValue();
            echo $sheet->getCell("A".$row)->getValue()." - ";
            echo $sheet->getCell("B".$row)->getValue()." - ";
            echo $sheet->getCell("C".$row)->getValue()." - ";
            echo $sheet->getCell("I".$row)->getValue()." - ";
            echo $sheet->getCell("O".$row)->getValue()." - ";
            echo $sheet->getCell("Z".$row)->getValue()." - ";
            echo "<br>";
            for ($i=0; $i <= 1; $i++) {
                if($i == 0){
                    $cta = $ctaPar;
                }elseif($i == 1 ){
                    $cta = $ctaCab;
                }
                $this->query="SELECT * FROM CUENTAS_FTC WHERE CUENTA = '$cta'";
                $res=$this->EjecutaQuerySimple();
                $lin=ibase_fetch_object($res);
                if(isset($lin)){
                    if($i == 0){
                        $cuentaPartida=$lin->CUENTA_COI;                
                        $a=$d->actCtaPar($cuentaPartida, $uuid, $par, $x);
                    }elseif($i == 1){
                        $cuentaCabecera=$lin->CUENTA_COI;
                        $b=$d->actCtacab($cuentaCabecera, $uuid, $par, $x);
                    }

                }else{
                    echo 'No tiene Valor y sigue con la siguiente Linea, podria poner un reporte por correo con los resultados';
                }
            }
        }
        return;
    }



}      
?>
