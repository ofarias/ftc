<?php
require_once 'app/model/database.php';

class statics extends database {

	function verEstadistica($mes, $anio, $tipo, $t){
        $data = array();
        $m = '';
        $rfce = $_SESSION['rfc'];        
        if($mes > 0){
            $m = " and extract(Month from fecha) = ".$mes." ";
        }

        if($t == 'Emitidos'){
            $this->query=" SELECT X.CLIENTE AS RFC,
                              (select max(NOMBRE) from XML_CLIENTES C where X.CLIENTE = C.RFC and TIPO = 'Cliente') as NOMBRE,
                              sum(X.IMPORTE) as FACTURADO,
                              (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.CLIENTE and STATUS = 'C') as CANCELADO,
                              (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.CLIENTE and TIPO = 'E') as NOTAS,

                              (
                                (coalesce(sum(X.IMPORTE),0)
                              -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.CLIENTE and TIPO = 'E')                                
                              -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.CLIENTE and STATUS = 'C')
                              )
                              /
                              (
                                (SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) 
                                -(SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m)
                                -(SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m)
                              )  
                              ) * 100 as PORcentaje,

                              (
                              sum(X.IMPORTE)  
                              -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.CLIENTE and TIPO = 'E')                                
                              -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.CLIENTE and STATUS = 'C')
                              ) as total_cliente,

                              (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) as total,
                              
                              COALESCE( 
                                (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m),
                                0)
                                 as total_dev,
                              
                              COALESCE(
                                (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m),
                                0)
                              as total_can,

                              ( (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) 
                                -(SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m)
                                -(SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE = '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m)
                              ) as grantotal, 
                              COUNT(*) AS DOCUMENTOS

                          from XML_DATA X
                          where X.rfce = '$rfce' and
                                X.TIPO = '$tipo' and
                                extract(year from x.FECHA) = $anio
                                $m
                          group by X.CLIENTE
                          order by (
                              sum(X.IMPORTE)  
                              -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.CLIENTE and TIPO = 'E')                                
                              -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.CLIENTE and STATUS = 'C')
                              ) desc
                                  "; 
        }else{
              $this->query=" SELECT X.rfce AS RFC,
                              (select max(NOMBRE) from XML_CLIENTES C where X.rfce = C.RFC and TIPO = 'Proveedor') as NOMBRE,
                              sum(X.IMPORTE) as FACTURADO,
                              (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.rfce and STATUS = 'C') as CANCELADO,
                              (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.rfce and TIPO = 'E') as NOTAS,

                              (
                                (coalesce(sum(X.IMPORTE),0)
                                -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.rfce and TIPO = 'E')                                
                                -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.rfce and STATUS = 'C')
                              )
                              /
                              (
                                (SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) 
                                -(SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m)
                                -(SELECT coalesce(SUM(xt.importe),2) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m)
                              )  
                              ) * 100 as PORcentaje,

                              (
                              sum(X.IMPORTE)  
                              -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.rfce and TIPO = 'E')                                
                              -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.rfce and STATUS = 'C')
                              ) as total_cliente,

                              (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) as total,
                              
                              COALESCE( 
                                (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m),
                                0)
                                 as total_dev,
                            
                              COALESCE(
                                (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m),
                                0)
                              as total_can,

                              ( (SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m) 
                                -(SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'E' and extract(year from xt.FECHA) = $anio $m)
                                -(SELECT coalesce(SUM(xt.importe),0) from xml_data xt where Xt.RFCE != '$rfce' and Xt.TIPO = 'C' and extract(year from xt.FECHA) = $anio $m)
                              ) as grantotal, 
                              COUNT(*) AS DOCUMENTOS

                          from XML_DATA X
                          where X.rfce != '$rfce' and
                                X.TIPO = '$tipo' and
                                extract(year from x.FECHA) = $anio
                                $m
                          group by X.rfce
                          order by (
                              sum(X.IMPORTE)  
                              -
                                (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.CLIENTE = X.rfce and TIPO = 'E')                                
                              -
                                (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.CLIENTE = X.rfce and STATUS = 'C')
                              ) desc
                                  "; 
                    //echo $this->query;

            /*
            $this->query=" SELECT X.rfce as RFC,
                              (select max(NOMBRE) from XML_CLIENTES C where X.rfce = C.RFC and TIPO = 'Proveedor') as NOMBRE,
                              sum(X.IMPORTE) as FACTURADO,
                              (select coalesce(sum(XC.IMPORTE), 0) from XML_DATA XC where XC.rfce = X.rfce and STATUS = 'C') as CANCELADO,
                              (select coalesce(sum(XNC.IMPORTE), 0) from XML_DATA XNC where XNC.rfce = X.rfce and TIPO = 'E') as NOTAS,
                              (sum(X.IMPORTE)/(SELECT SUM(xt.importe) from xml_data xt where Xt.CLIENTE = '$rfce' and Xt.TIPO = '$tipo' and extract(year from xt.FECHA) = $anio $m)) * 100 as PORcentaje
                          from XML_DATA X
                          where X.Cliente = '$rfce' and
                                X.TIPO = '$tipo' and
                                extract(year from x.FECHA) = $anio
                                $m
                          group by X.rfce
                          order by sum(X.IMPORTE) desc
                                  ";
            */
        }
                //echo $this->query;
                $rs=$this->EjecutaQuerySimple();
                while ($tsArray= ibase_fetch_object($rs)) {
                    $data[]=$tsArray;
                }

                return $data; 
    }

    function detStat($cliente, $mes, $anio, $tipo){
        $m = '';
        $data=array();
        if($mes > 0 ){
            $m = ' and extract(month from fecha ) ='.$mes.' ';
        }
        $campo = '';
        if($tipo == 'Recibidos'){
          $campo = 'RFCE';
          $tcp = 'Proveedor';
        }else{
          $campo = 'CLIENTE';
          $tcp = 'Cliente';
        }

        $this->query="SELECT x.*, (SELECT NOMBRE FROM XML_CLIENTES WHERE RFC = '$cliente' and tipo='$tcp') as NOMBRE 
                      FROM XML_DATA x 
                      WHERE  $campo = '$cliente' and extract(year from fecha ) = $anio $m AND  (TIPO = 'I' OR TIPO = 'E') order by fecha asc";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function updateInfo($eje){
      $data=array();
      $this->query="SELECT * FROM Mobile where extract(year FROM FECHA_DOC) = $eje";
      $res=$this->EjecutaQuerySimple();
      while ($tsArray=ibase_fetch_object($res)){
        $data[]=$tsArray;
      }
      echo 'Total de documento: '.count($data);
      die;

      return $data;
    }

    function repTipo($anio){
      $this->query="SELECT tipo_doc, tipo as tipo_fiscal, status, max(anio) as anio, sum(TOTAL) as total, sum(subtotal) as subtotal, sum(descuento) as descuento, sum(IVA) as iva  FROM INGRESOS_TIPO where anio = $anio group by tipo_doc, tipo, status order by total desc ";
      $res=$this->EjecutaQuerySimple();
      while ($tsArray=ibase_fetch_object($res)) {
        $data[]=$tsArray;
      }
      return $data;
    }

    function traeAnios(){
      $this->query="SELECT extract(year from fecha) as anio from xml_data group by extract(year from fecha)";
      $res=$this->EjecutaQuerySimple();
      while ($tsArray = ibase_fetch_object($res)) {
        $data[]=$tsArray;
      }
      return $data;
    }

    function periodos($gt, $anio, $cliente, $tipo){
      $d_s='';
      $this->query="SELECT FD.*, (SELECT TIPO FROM FTC_STA_PER WHERE LEYENDA='$gt') as NOMBRE FROM FTC_STA_PER_DET FD WHERE FD.TIPO = '$gt'";
      $res=$this->EjecutaQuerySimple();
      while ($tsArray=ibase_fetch_object($res)) {
        $p[]=$tsArray;
      }
      $campo = $tipo=='Recibidos'? 'rfce':'Cliente';
      $i=0;      
      foreach ($p as $per){
        $i++;
        $mi= $per->MES_INICIA; 
        $mf= $per->MES_FINALIZA;
        $this->query="SELECT sum(IMPORTE) AS TOTAL FROM XML_DATA X WHERE FECHA 
              between 
                (SELECT FECHA_INI FROM PERIODOS_2016 WHERE NUMERO = $mi and anhio = $anio) 
                and  
                (SELECT FECHA_FIN FROM PERIODOS_2016 WHERE NUMERO = $mf and anhio = $anio)
                and $campo = TRIM('$cliente') and x.tipo ='I' and status != 'C'
                ";
        $res=$this->EjecutaQuerySimple();
        $row=ibase_fetch_object($res);
        $d_s.=$gt.$i.':'.(empty($row->TOTAL)? 0:$row->TOTAL).',';
      }
      $d_s .= $per->NOMBRE;
      return $d_s;
    }

    function gfEst($info){
      $i= 0;
      $datos='';
      $tt = 0;
      $tp = 0;
      foreach($info as $inf){
        $i++;
        $tt =+ $inf->TOTAL_CLIENTE;
        if($i <=10){
          $datos .= $inf->NOMBRE.':'.$inf->TOTAL_CLIENTE.'|';
        }else{
          $tp=+ $inf->TOTAL_CLIENTE;
        }
      }
      $datos .= "Otros:".$tp;
      return $datos;
    }

}
?> 