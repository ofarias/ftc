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

    function infoPagos($mes, $anio, $ide, $uuid=false, $doc){
        $data= array();
        if(!empty($uuid)){
    		$uuid = "and uuid = '".$uuid."'"; 
    	}elseif ($mes == 0 and $ide == 'Emitidos') {
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and x.cliente != '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif ($mes == 0 and $ide == 'Recibidos') {
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and cliente = '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif($ide == 'Emitidos'){
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and extract(month from cast(fechatimbrado as timestamp))=".$mes." and x.cliente != '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif($ide == 'Recibidos'){
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and extract(month from cast(fechatimbrado as timestamp))=".$mes." and cliente = '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}
        $this->query="SELECT x.*, xcp.*, xcp.moneda as moneda_pago, (SELECT COUNT(*) FROM XML_COMPROBANTE_PAGO_DETALLE CPD WHERE CPD.UUID_PAGO = xcp.UUID) AS DOCUMENTOS FROM XML_DATA x left join XML_COMPROBANTE_PAGO xcp on xcp.UUID = x.UUID WHERE x.id > 0 $uuid";
        $res=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function infoPagosDetalle($uuid){
        $data=array();
        $this->query="SELECT xcpd.*, x.fecha AS FECHA_DOC, x.serie as ser, x.folio as fol 
                FROM XML_COMPROBANTE_PAGO_DETALLE xcpd left join xml_data_upper x on x.uuid = xcpd.id_documento or x.uuid_upper = xcpd.id_documento WHERE xcpd.UUID_PAGO = '$uuid'";
        $res=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function partidasPagos($mes, $anio, $ide, $uuid=false, $doc){
        $data= array();
        if(!empty($uuid)){
    		$uuid = "and uuid = '".$uuid."'"; 
    	}elseif ($mes == 0 and $ide == 'Emitidos') {
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and x.cliente != '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif ($mes == 0 and $ide == 'Recibidos') {
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and cliente = '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif($ide == 'Emitidos'){
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and extract(month from cast(fechatimbrado as timestamp))=".$mes." and x.cliente != '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}elseif($ide == 'Recibidos'){
    		$uuid = "and extract(year from cast(fechatimbrado as timestamp)) = ".$anio." and extract(month from cast(fechatimbrado as timestamp))=".$mes." and cliente = '".$_SESSION['rfc']."' and x.TIPO = '".$doc."'";
    	}
        $this->query="SELECT * FROM XML_DATA X where id>0 $uuid";
        $res=$this->EjecutaQuerySimple();
        while($tsArray=ibase_fetch_object($res)){
            $data[]=$tsArray;
        }

        if(count($data)>0){
            $data2=array();
            foreach($data as $d){
                $this->query="SELECT cpd.id, 
                                (SELECT first 1 cp.serie||cp.folio FROM Xml_data_upper CP WHERE CP.uuid = cpd.uuid_pago or CP.uuid_upper = cpd.uuid_pago ) as comprobante ,
                                (SELECT first 1 FECHA FROM XML_COMPROBANTE_PAGO CP WHERE CP.uuid = cpd.uuid_pago) as FECHA,
                                (SELECT  sum(MONTO) FROM XML_COMPROBANTE_PAGO CP WHERE CP.uuid = cpd.uuid_pago) as MONTO,
                                (SELECT first 1 forma FROM XML_COMPROBANTE_PAGO CP WHERE CP.uuid = cpd.uuid_pago) as forma,
                                (SELECT first 1 status FROM XML_DATA_upper X  WHERE X.uuid = cpd.uuid_pago or x.uuid_upper = cpd.uuid_pago) as STATUS,
                                (SELECT first 1 version_cfdi FROM XML_DATA_upper X  WHERE X.uuid = cpd.uuid_pago or x.uuid_upper = cpd.uuid_pago) as version_cfdi,
                                (SELECT first 1 DOCUMENTO FROM XML_DATA_upper X  WHERE X.uuid = cpd.id_documento or x.uuid_upper = cpd.id_documento) as FACTURA,
                                (SELECT first 1 FECHA FROM XML_DATA_upper X  WHERE X.uuid = cpd.id_documento or x.uuid_upper = cpd.id_documento) as FECHA_FACT,
                                (SELECT first 1 IMPORTE FROM XML_DATA_upper X  WHERE X.uuid = cpd.id_documento or x.uuid_upper = cpd.id_documento) as IMPORTE,
                                (SELECT COUNT(*) FROM xml_comprobante_pago_detalle cpdd where cpdd.id_documento = cpd.id_documento) as pagos,
                            cpd.*
                            FROM XML_COMPROBANTE_PAGO_DETALLE cpd
                            where cpd.uuid_pago = '$d->UUID'";
                $res=$this->EjecutaQuerySimple();
                //echo '<br/>'.$this->query;
                while($tsArray=ibase_fetch_object($res)){
                    $data2[]=$tsArray;
                }
            }
        }
        return $data2;
    }

    function traeDF($ide){
		$this->query="SELECT e.*, d.* FROM FTC_EMPRESAS e left join ftc_empresas_dir d on d.ide = e.id WHERE e.ID = $ide";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
		return $row;
	}
}