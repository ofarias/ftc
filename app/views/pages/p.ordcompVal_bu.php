<?php
//print_r($_POST); 
$PROVEEDOR  =   $_POST["PROVEEDOR"];
$CVE_DOC    =   $_POST["CVE_DOC"];
$TOTAL      =   $_POST["TOTAL"];
$TIME       =   time();
$HOY        =   date("Y-m-d H:i:s", $TIME);

$query      = " INSERT INTO PAGA_M01 (";
$query     .= " CVE_PROV, REFER, NUM_CARGO, NUM_CPTO, CVE_FOLIO, CVE_OBS, NO_FACTURA,";
$query     .= " DOCTO, IMPORTE, FECHA_APLI, FECHA_VENC, AFEC_COI, NUM_MONED, TCAMBIO,"; 
$query     .= " IMPMON_EXT, FECHAELAB, CTLPOL, TIPO_MOV, CVE_BITA, SIGNO, CVE_AUT, ";
$query     .= " USUARIO, ENTREGADA, FECHA_ENTREGA, REF_SIST, STATUS)";
$query     .= " VALUES (";
$query     .= " '".$PROVEEDOR."',";
$query     .= " '".$CVE_DOC."',";
$query     .= " 1,24,'',0,";
$query     .= " '".$CVE_DOC."',";
$query     .= " '".$CVE_DOC."',";
$query     .= " ".$TOTAL.",";
$query     .= " '".$HOY."',";
$query     .= " '".$HOY."', ";
$query     .= " '', 1, 1, ";
$query     .= " ".$TOTAL.",";
$query     .= " '".$HOY."',";
$query     .= " 0, 'C', 0, 1, 0, 0, '',";
$query     .= " '".$HOY."',";
$query     .= " '', 'A')";


//echo $query;


//if (isset($_POST['enviar'])) {

//print_r($_POST['seleccion']);

$posicion=$_POST['PROVEEDORCUENTA'];
//print_r($posicion);
    if (is_array($_POST['seleccion'])) {
        $selected = '';
        $num_seleccionados = count($_POST['seleccion']);
        $num_seleccionados;

       // $num_provedores = count($PROVEEDOR);
        //$array = array($PROVEEDOR);

//var_dump($array);
        //echo $PROV  =   $_POST["PROVEEDOR"];
        

        for ($i=0; $i<$num_seleccionados; $i++){
            //echo $posicion[$i].'-'.$PROVEEDOR;
            $array = array($PROVEEDOR);
            print_r($array);
            if($posicion[$num_seleccionados]===$PROVEEDOR){
                echo "sumaria";
            }else{
                echo "no";
            }
            //echo $posicion[$i];

            
          //  echo $query."<br/>";
        }


        $current = 0;
        foreach ($_POST['seleccion'] as $key => $value) {
            if ($current != $num_seleccionados-1)
                 $selected .= $value.', ';
            else
                $selected .= $value.'.';
            $current++;
        }
    }
    else {
        $selected = 'Debes seleccionar una orden de compra';
    }

   // echo '<div>Has seleccionado: '.$selected.'</div>';
//}

?>