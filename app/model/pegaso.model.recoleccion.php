<?php 
    require_once('app/model/pegaso.model.php');
    require_once('app/model/database.mysql.rec.php');

class pegaso_rec extends databasemysqlrec{

    function genruta($Cabecera, $Detalle, $genqr){
        $data=array();
        $data2=array();
        //var_dump($Cabecera).'<br/>';
        //var_dump($Detalle).'<br/>';
        //var_dump($genqr).'<br/>'; 
        foreach ($Cabecera as $key) {
            $oc = $key->OC;
            $monto = $key->COSTO_TOTAL;
            $proveedor = $key->CVE_PROV;
            $nombre = $key->NOMBRE;
            $direccion = 'Calle: '.$key->CALLE.', Num Ext:'.$key->NUMEXT.', Colonia: '.$key->COLONIA.', Estado: '.$key->ESTADO.', CP: '.$key->CP;
            $this->query="SELECT * FROM ordenes where identificador = '$key->OC'";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray = mysqli_fetch_array($rs)) {
                $data[]=$tsArray;
            }
        }
        if (count($data)==0){
            $this->query="SELECT * FROM destinos where identificador = '$proveedor'";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray=mysqli_fetch_array($rs)){
                $data2[]=$tsArray; 
            }
            if(count($data2 == 0 )){
                $this->query="INSERT INTO destinos values('$proveedor','$nombre','Observaciones', '$direccion', 19.7093082,-99.1958805)";
                $this->grabaBD();
            }
            $this->query="SELECT if(max(identificador) is null, 0, max(identificador)) as ID from viajes";
            $res=$this->EjecutaQuerySimple();
            $row =mysqli_fetch_array($res);
            $viaje = $row['ID'] + 1;

            $this->query="INSERT INTO viajes values($viaje, 'Destino', 'Nuevo', current_timestamp, '$proveedor', '1929192190021')";
            $this->grabaBD();
            
            $this->query=" INSERT INTO ordenes values ('$oc', 'descripcion', $monto, 0,$viaje)";
            $rs=$this->grabaBD();

             foreach ($Detalle as $key3) {
                $identificador = $oc.'-'.$key3->PARTIDA;
                $descripcion = $key3->DESCRIPCION;
                $cantidad = $key3->CANTIDAD;
                $unidad = $key3->UM;
                $idpreoc = $key3->IDPREOC;
                $idorden = $oc;
                $partida = $key3->PARTIDA;
                $this->query="INSERT INTO productos VALUES('$identificador','$descripcion', $cantidad, '$unidad', 0,'$idpreoc', '$idorden',$partida)";
                $rs=$this->EjecutaQuerySimple();
            }
        }
        return;
    }

    function buscarQR2($oc,$qr){
        $data= new pegaso;
        $comprobacion = $data->comprobacion($oc, $qr);
        //var_dump($comprobacion);
        return $comprobacion;
    }       

   
}?>