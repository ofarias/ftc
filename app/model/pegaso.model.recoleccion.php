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
            $proveedor = trim($key->CVE_PROV);
            $nombre = $key->NOMBRE;
            $direccion = 'Calle: '.$key->CALLE.', Num Ext:'.$key->NUMEXT.', Colonia: '.$key->COLONIA.', Estado: '.$key->ESTADO.', CP: '.$key->CP;
            $this->query="SELECT * FROM ordenes where identificador = '$key->OC'";
            //echo 'Tabla Ordenes: '.$this->query.'<br/>';
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray = mysqli_fetch_array($rs)) {
                $data[]=$tsArray;
            }
        }
        if (count($data)==0){
            $this->query="SELECT * FROM destinos where identificador = trim('$proveedor')";
            $rs=$this->EjecutaQuerySimple();
            while ($tsArray=mysqli_fetch_array($rs)){
                $data2[]=$tsArray; 
            }
            if(count($data2) == 0){
                $this->query="INSERT INTO destinos values('$proveedor','$nombre','Observaciones', '$direccion', 19.7093082,-99.1958805)";
                $this->grabaBD();
            }    
                    /// Observaciones es para apollar al conducto.
                /// Uri es la URL de Google?  
                /// URI de google.   
                ///  Longitud y latitud <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.055377389989!2d-99.09291334848693!3d19.453179086808262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1fbe5fdeccb53%3A0x4ae592fc8a9b1386!2sAv+533+52%2C+San+Juan+de+Arag%C3%B3n+I+Secc%2C+07969+Ciudad+de+M%C3%A9xico%2C+CDMX!5e0!3m2!1ses!2smx!4v1529006495608" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                $direccion = 'https://goo.gl/maps/F9cWrLnd1n92';
                if(!empty($proveedor)){
                    $this->query="SELECT if(max( cast(identificador as unsigned)) is null, 0, max( cast(identificador as unsigned))) as ID from viajes";
                    $res=$this->EjecutaQuerySimple();
                    $row =mysqli_fetch_array($res);
                    $viaje = $row['ID'] + 1;
                    /// Destino = ejemplo Biotecsa Planta --- Biotecsa Dorado. Proveedor con la Sucursal.
                    /// Identificador_identidad  = identidades.identidicador --- md5 -- de la tabla de choferes.
                    $this->query="INSERT INTO viajes values($viaje, '$nombre', 'Nuevo', current_timestamp, '$proveedor', '866216030916402')";
                    $this->grabaBD();
                    // Descripcion (60):  Colocar quien confirmo con el proveedor, forma de pago y la persona de pegaso que confirmo. 25 para la persona que confirmo, Pago:5 forma de pagop y 25 para el nombre de confirmador pegaso (60 caracteres). Pedido de Rotomartillos. forma de identificar la Orden. puede ser para quien el pedido, 
                    
                    $this->query=" INSERT INTO ordenes values ('$oc', 'descripcion', $monto, 0,$viaje)";
                    $rs=$this->grabaBD();

                    //var_dump($Detalle);
                    foreach ($Detalle as $key3) {
                        $identificador = $oc.'-'.$key3->PARTIDA;
                        $descripcion = $key3->DESCRIPCION;
                        $cantidad = $key3->CANTIDAD;
                        $unidad = $key3->UM;
                        $idpreoc = $key3->IDPREOC;
                        $idorden = $oc;
                        $partida = $key3->PARTIDA;

                        $this->query="SELECT if(max(cast(identificador as unsigned)) is null, 0 ,max(cast(identificador as unsigned))) as id from productos";
                        $res=$this->EjecutaQuerySimple();
                        $row =mysqli_fetch_array($res);
                        $idprod = $row['id'] + 1;
                        $this->query="INSERT INTO productos (identificador, partida, descripcion, cantidad, unidad, estatus, idpreoc, identificador_orden ) 
                                            VALUES('$idprod',$partida, '$descripcion', $cantidad, '$unidad', 0,'$idpreoc', '$oc')";
                        $rs=$this->grabaBD();
                        
                    }    
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