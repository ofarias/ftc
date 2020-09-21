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

  function leeempresa(){
    $bd_original = $_SESSION['bd'];
    $path = "C:\\users\\gense\\desktop\\Datos\\";
    $dir = scandir($path);
    for ($i=2; $i < count($dir) ; $i++){ 
      if(!is_file($dir[$i])){
        $files= scandir($path.$dir[$i]);
        for($j=0; $j < count($files); $j++){
          if(is_file($path.$dir[$i].'\\'.$files[$j])){
            $info = new SplFileInfo($path.$dir[$i].'\\'.$files[$j]);
            $ext = pathinfo($info->getFilename(), PATHINFO_EXTENSION);
            $name = pathinfo($info->getFilename(), PATHINFO_BASENAME);
            if(strtoupper($ext) == 'FDB'){
              $_SESSION['bd']= $name; $_SESSION['folder'] = $dir[$i];
              $this->query="SELECT * FROM PARAMEMP";
              $res = $this->EjecutaQuerySimple();
              $row = ibase_fetch_object($res);
              //print_r($row);
              echo '<br/>'.utf8_decode($row->NOMBRE).'<br/>';
            }
          }
        }
      }
    }
    $_SESSION['bd'] = $bd_original;
    die();
  }
}
?> 