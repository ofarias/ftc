<?php
require_once 'app/model/ftc_mobile.php';

class sync_mob_mysql extends ftcwsmob {

	function sync($info){
    $data = array();
    $i = 0;
    foreach ($info as $k){
      $fecha = substr($k->FECHA_DOC, 0, 10);
      $i++;
      $this->query="INSERT INTO kdem10t (id_doc, UUID, tipo_fiscal, RFC_CLIENTE, RFC_PROVEEDOR, NSS, CURP, SubTIPO, MONEDA, TC, IMPORTE, descuento, IVA016, IVA080, IVA_RET_004, ISR, IEPS_0265, IEPS_030, IEPS_053, IEPS_050, IEPS_160, IEPS_0304, IEPS_025, IEPS_090, IEPS_080, IEPS_070, IEPS_003, IEPS_000, IEPS_CUOTA, IMSS, OTROS_INGRESOS, TOTAL, STATUS, FECHA_DOC, status_fiscal, emisor, receptor, rfc_empresa, ejercicio, periodo, naturaleza, tipo_doc, saldo_doc, ide) 
        VALUES 
        ('$k->ID_DOC','$k->UUID','$k->TIPO_FISCAL','$k->RFC_CLIENTE','$k->RFC_PROVEEDOR','$k->NSS','$k->CURP','$k->SUBTIPO','$k->MONEDA',$k->TC,$k->IMPORTE,$k->DESCUENTO,$k->IVA016,$k->IVA080,$k->IVA_RET_004,$k->ISR,$k->IEPS_0265,$k->IEPS_030,$k->IEPS_053,$k->IEPS_050,$k->IEPS_160,$k->IEPS_0304,$k->IEPS_025,$k->IEPS_090,$k->IEPS_080,$k->IEPS_070,$k->IEPS_003,$k->IEPS_000,$k->IEPS_CUOTA,$k->IMSS,$k->OTROS_INGRESOS,$k->TOTAL,'F','$fecha','$k->STATUS_FISCAL', SUBSTRING('$k->EMISOR',0,99),SUBSTRING('$k->RECEPTOR',0,99),'$k->RFC_EMPRESA', $k->EJERCICIO, $k->PERIODO,'$k->NATURALEZA', '$k->TIPO_DOC', $k->SALDO_DOC, $k->IDE_)";
    
      if($rs=$this->grabaBD()){
      }else{
        echo 'No se inserto el registro '.$i.' el valor de la consulta es: <br/>'.$this->query.'<br/>';
        break;
      }
    }
    $data = $this->pendientes();
    return $data;
  }

  function pendientes(){
    $data=array();
    $this->query="SELECT UUID FROM kdem10t WHERE STATUS = 'F'";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray = mysqli_fetch_array($res)){
      $data[]=$tsArray;
    }
    return $data;
  }

  function cierre(){
    $this->query="UPDATE kdem10t SET STATUS = 'M' WHERE ID_DOC >0";
    $this->EjecutaQuerySimple();
    return;
  }

}
?> 