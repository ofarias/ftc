<?php
require_once 'app/model/database.php';
require_once ('app/views/unit/commonts/numbertoletter.php');


class pagos extends database {

    function detallePago($uuid){
        $data=array();
        $this->query="SELECT * FROM XML_COMPROBANTE_PAGO_DETALLE WHERE UUID_PAGO= '$uuid'";
        $res=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return array("status"=>'ok', "datos"=>$data);
    }
}