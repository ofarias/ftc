<?php
require_once 'app/model/database.php';

class sync_mobile extends database {

	function info(){
    $data = array();
    $data2 = array();
    $this->query="UPDATE XML_DATA SET IVA080 = 0 WHERE IVA080 IS NULL";
    $this->queryActualiza();

    $ide = $_SESSION['empresa']['ide'];
    $this->query= "SELECT m.* FROM MOBILE M WHERE STATUS = 'N'";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray = ibase_fetch_object($res)) {
      $data[]=$tsArray;
    }
    $this->query= "SELECT m.* FROM XML_RECIBO_NOMINA m WHERE STATUS = 'N'";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray = ibase_fetch_object($res)) {
      $data[]=$tsArray;
    }
    foreach ($data as $k) {
      $this->query="INSERT INTO XML_MOB_STA (ID_MOB, STATUS, DOC_UUID, TIPO_CAMBIO, FECHA_CAMBIO, ID_DOC) VALUES (NULL, 'P', '$k->UUID', 'Ingreso',current_timestamp, $k->ID_DOC)";
      $this->grabaBD();
    } 
    $this->query="SELECT first 1000 m.*, '$ide' as ide_ FROM MOBILE m WHERE STATUS='P'";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray=ibase_fetch_object($res)) {
      $data2[]=$tsArray;
    }
    $this->query="SELECT first 1000 m.*, '$ide' as IDE_ FROM XML_RECIBO_NOMINA m WHERE STATUS='P'";
    $res=$this->EjecutaQuerySimple();
    while ($tsArray=ibase_fetch_object($res)) {
      $data2[]=$tsArray;
    }
    echo 'Total de documentos enviados: '.count($data2).'<br/>';
    return $data2;
  }

  function update($mySQL, $info){
      $i=0;
      $d=0;
      $a=count($mySQL);
      $b=count($info); 
      foreach($mySQL as $ms){
        $uuid =  $ms['UUID'];
        $this->query="UPDATE XML_MOB_STA SET STATUS = 'M' WHERE DOC_UUID='$uuid'";
        $res= $this->queryActualiza();
        if($res == 1){
          $i++;
        }elseif($res>1){
          $d++;
        }
      }
      if($a > $i ){
        return array("status"=>'No', "mensaje"=>'Se enviaron '.$b.'documentos, se insertaron '.$a.' y se actualizaron '.$i.' registros duplicados '. $d.', favor de verificar',"restantes"=>($a-$i));
      }elseif($a == $i){
        return array("status"=>'Ok', "mensaje"=>'Se enviaron '.$b.'documentos, se insertaron '.$a.' y se actualizaron '.$i.' registros duplicados '. $d.' ,favor de verificar',"restantes"=>($a-$i));
      }
  }

}
?> 