<?php
require_once 'app/model/database.php';

class statics extends database {

	function verEstadistica($mes, $anio, $tipo){
        $data = array();
        $m = '';
        if($tipo == 'I'){
            $rfce = $_SESSION['rfc'];
            echo $rfce;
        }
        if($mes > 0){
            $m = " and extract(Month from fecha) = ".$mes." ";
        }
        $this->query="
            SELECT X.CLIENTE,
       (select max(NOMBRE) from XML_CLIENTES C    where X.CLIENTE = C.RFC and              TIPO = 'Cliente') as NOMBRE,
       sum(X.IMPORTE) as FACTURADO,
           (select coalesce(sum(XC.IMPORTE), 0)
        from XML_DATA XC
        where XC.CLIENTE = X.CLIENTE and
              STATUS = 'C') as CANCELADO,
       (select coalesce(sum(XNC.IMPORTE), 0)
        from XML_DATA XNC
        where XNC.CLIENTE = X.CLIENTE and
              TIPO = 'E') as NOTAS,
        (
           sum(X.IMPORTE)
            /
           (SELECT SUM(xt.importe) from xml_data xt where
            Xt.RFCE = '$rfce' and
            Xt.TIPO = '$tipo' and
            extract(year from xt.FECHA) = $anio
            $m
            )
        ) * 100 as PORcentaje
from XML_DATA X
where X.RFCE = '$rfce' and
      X.TIPO = '$tipo' and
      extract(year from x.FECHA) = $anio
      $m
group by X.CLIENTE
order by sum(X.IMPORTE) desc
        ";
        echo $this->query;
        $rs=$this->EjecutaQuerySimple();
        while ($tsArray= ibase_fetch_object($rs)) {
            $data[]=$tsArray;
        }
        return $data; 
    }

function detStat($cliente, $mes, $anio, $tipo){
    $m = '';
    if($mes > 0 ){
        $m = ' and extract(month from fecha ) ='.$mes.' ';
    }
    $this->query="SELECT * FROM XML_DATA WHERE CLIENTE = '$cliente' and extract(year from fecha ) = $anio $m order by fecha asc";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray=ibase_fetch_object($res)){
        $data[]=$tsArray;
    }
    return $data;
}

}
?> 