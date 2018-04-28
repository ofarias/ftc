<?php

require_once 'app/model/database.coi.php';
/* Clase para hacer uso de database */
class CoiDAO extends DataBaseCOI {
    
    function consultarAlgo() {
        $TIME = time();
        $HOY = date("Y-m-d H:i:s", $TIME);
        $this->query = "SELECT * FROM ALGUIEN WHERE ALGO;";
        $resultSet = $this->QueryObtieneDatosN();
        if($this->NumRows($resultSet) > 0){
            while ( $tsArray = $this->FetchAs($resultSet)){ 
                $data[] = $tsArray;			
            }
            return $data;
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
        $rs=$this->EjecutaQuerySimple();

        if(count($aplicaciones) >= 1){
            foreach ($aplicaciones as $key){
                $ida= $key->ID;
                $idp = $key->IDPAGO;
                $montoAplicado = round($key->MONTO_APLICADO,2);
                $contabilizado = $key->CONTABILIZADO;
                $rfc =$key->RFC;
                $docf = $key->DOCUMENTO;
                //$rfc = str_replace(' ','',$rfc);
                $this->query="SELECT NUM_CTA FROM CUENTAS17 WHERE RFC = '$rfc'";
                $rs=$this->QueryObtieneDatosN();
                $row=ibase_fetch_object($rs);
                $cuenta = $row->NUM_CTA;
                $this->query="INSERT INTO TEMP_TABLE VALUES($ida, $idp, $montoAplicado, '$rfc', '$cuenta', 'No','$docf')";
                $res=$this->EjecutaQuerySimple();
                    if(empty($res)){
                        echo $this->query;
                        break;
                    }}}

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
            $rs=$this->QueryObtieneDatosN();
                if(isset($rs)){
                    while($tsArray = ibase_fetch_object($rs)){
                    $partida[]=$tsArray;
                    }
                }else{
                    echo 'Esta consulta no obtiene valor: '.'<p>';
                    echo $this->query.'<p>';
                }
            /// Obtenemos el ultimo folio de las polizas de Ingreso Ig con base al mes y al año.    
                ############# Algoritmo para calcular el Nuevo Folio.
                    $a="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Ig' AND PERIODO = $mes and Ejercicio = $anio";
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
            $this->query ="INSERT INTO POLIZAS17 VALUES ('Ig','$folioN', $mes, $anio, '$fechaR', substring('$concepto' from 1 for 119),0,'0','N',0,1,0,'Pegaso', '0', '0',0)";
            $rs=$this->EjecutaQuerySimple();
            if($rs == 0){
                /// arreglo para cachar los errores.

            }else{
                        /// Insertamos primer partida del Banco             
                        $this->query ="INSERT INTO AUXILIAR17 VALUES ('Ig','$folioN',1,$mes, $anio,'$cuentaBanco','$fechaR' ,substring('$concepto' from 1 for 119), 'D' ,$montoDoc,0,1,0,1,0,0,0,0 )";
                        $rs=$this->EjecutaQuerySimple();    
                        /// Insercion de partida de impuestos 
                        if($rs == false){
                            echo $this->query.'<p>';
                        }
                        $this->query ="INSERT INTO AUXILIAR17 VALUES ('Ig','$folioN',2,$mes, $anio, '218100100000000000002','$fechaR',substring('$concepto' from 1 for 119), 'D', $iva, 0,1,0,1,0,0,0,0)";
                        $rs=$this->EjecutaQuerySimple();
                        if($rs == false){
                            echo $this->query.'<p>';
                        }
                        $this->query ="INSERT INTO AUXILIAR17 VALUES ('Ig','$folioN',3,$mes, $anio, '218000100000000000002','$fechaR',substring('$concepto' from 1 for 119), 'H', $iva, 0,1,0,1,0,0,0,0)";
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
                                    $this->query ="INSERT INTO AUXILIAR17 VALUES('Ig','$folioN',$part, $mes, $anio,'$cuentaCliente','$fechaR', (substring('$concepto' from 1 for 80)||', '||'$ida'||', Fact:'||'$docf'), 'H' ,$monto, 0,1,0,1,0,0,0,0)";
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
                                            $this->query="INSERT INTO AUXILIAR17 VALUES('Ig','$folioN',$part, $mes, $anio,'720000500000000000002','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'H' ,$saldo, 0,1,0,1,0,0,0,0)";
                                            $res=$this->EjecutaQuerySimple();
                                            if($rs == false){
                            echo $this->query.'<p>';
                        }
                                            echo 'El Pago con el ID: '.$idp.' con el monto '.$montoDoc.', solo tienen aplicaciones por '.$totalPago.' con una diferencia de '.$saldo.'.<p>';
                                            /// gasto financiero cuando es menor la aplicacion 7200-005-000
                                    }else{
                                            $this->query="INSERT INTO AUXILIAR17 VALUES('Ig','$folioN',$part, $mes, $anio,'730000200000000000002','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'D' ,$saldo, 0,1,0,1,0,0,0,0)";
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
                                    $this->query="INSERT INTO AUXILIAR17 VALUES('Ig','$folioN',$part, $mes, $anio,'212000100200000000003','$fechaR', (substring('$concepto' from 1 for 100)||', '||'N/A'), 'H' ,$saldo, 0,1,0,1,0,0,0,0)";
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
            $rfc = $datosCliente->RFC;
            $fechadoc = $datosCliente->FECHA_DOC;
            $docf = $datosCliente->CVE_DOC;

                $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
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
            $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
            $insPol = $this->EjecutaQuerySimple();
            if($insPol==0){
                $errores[]=array('Pol', $folio, $mes, $anio, $docf);
            }else{
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',1, $mes, $anio, '410000100100000000003', '$fechaelab', ('Ventas Nacionales, '||'$datosCliente->CVE_DOC'), 'H', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
                $res=$this->EjecutaQuerySimple();
                if($res == 0){
                    $errores[]=array('AUX1', $folio, $mes, $anio, $docf);
                }
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100000000000002', '$fechaelab', ('Iva por Acreeditar, '||'$datosCliente->CVE_DOC '), 'H', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                $result=$this->EjecutaQuerySimple();
                if($result==0){
                    $errores[]=array('AUX2', $folio, $mes, $anio, $docf);
                }
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$datosCliente->NOMBRE'||', '||'$datosCliente->CVE_DOC'), 'D', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
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

                $this->query="SELECT iif(MAX(NUM_POLIZ) is null, 0 , MAX(NUM_POLIZ)) as FolioA FROM POLIZAS17 WHERE TIPO_POLI = 'Dr' AND PERIODO = $mes and Ejercicio = $anio";
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
            $this->query = "INSERT INTO POLIZAS17 VALUES ('Dr', '$folio', $mes, $anio, '$fechaelab', substring('$concepto' from 1 for 119), 0, '0', 'N',0,1,0,'Pegaso','0','0',0)";
            $insPol = $this->EjecutaQuerySimple();
            if($insPol==0){
                $errores[]=array('Pol', $folio, $mes, $anio, $docf);
            }else{
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',1, $mes, $anio, '420000100000000000002', '$fechaelab', ('Devolucion de Venta Nacional, '||'$datosCliente->CVE_DOC'), 'D', $subtotal, 0, 1, 0, 1, 0, 0, 0, 0) ";
                $res=$this->EjecutaQuerySimple();
                if($res == 0){
                    $errores[]=array('AUX1', $folio, $mes, $anio, $docf);
                }
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',2, $mes, $anio, '218100100000000000002', '$fechaelab', ('Iva por Acreeditar, '||'$datosCliente->CVE_DOC '), 'D', $iva, 0, 1, 0, 1, 0, 0, 0, 0) ";
                $result=$this->EjecutaQuerySimple();
                if($result==0){
                    $errores[]=array('AUX2', $folio, $mes, $anio, $docf);
                }
                $this->query = "INSERT INTO AUXILIAR17 VALUES ('Dr', '$folio',3, $mes, $anio, '$cuentaCliente', '$fechaelab', ('Clientes'||' - '||'$datosCliente->NOMBRE'||', '||'$datosCliente->CVE_DOC'), 'H', $importe, 0, 1, 0, 1, 0, 0, 0, 0) ";
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
        return $actualizacion;
    }

}      
?>
