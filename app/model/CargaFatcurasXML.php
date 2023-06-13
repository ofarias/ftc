 function insertaXMLData($archivo){
        $data = $this->seleccionarArchivoXMLCargado($archivo);
        if($data!=null){
            foreach ($data as $row):
                $file = $row->NOMBRE;
            endforeach;
            $myFile = fopen("$file", "r") or die("No se ha logrado abrir el archivo ($file)!");
            $myXMLData = fread($myFile, filesize($file));
            $xml = simplexml_load_string($myXMLData) or die("Error: No se ha logrado crear el objeto XML ($file)");
            $ns = $xml->getNamespaces(true);
            $xml->registerXPathNamespace('c', $ns['cfdi']);
            $xml->registerXPathNamespace('t', $ns['tfd']);

            foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
                  $serie = $cfdiComprobante['serie'];                  
                  $folio = $cfdiComprobante['folio'];
                  $total = $cfdiComprobante['total'];
                  $subtotal = $cfdiComprobante['subTotal'];
                  $descuento = $cfdiComprobante['descuento'];
            }
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){
               $rfc = $Receptor['rfc'];
               //$nombre = $Receptor['nombre'];
            }
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){
            	$rfce = $Emisor['rfc'];
            }
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){
               //$tasa $Traslado['tasa'];
               $iva = $Traslado['importe'];
               //$impuesto = $Traslado['impuesto'];
            }
            //HASTA AQUI TODA LA INFORMACION ES LEIDA E IMPRESA CORRECTAMENTE
            //ESTA ULTIMA PARTE ES LA QUE GENERA ERROR, AL PARECER NO ENCUENTRA EL NODO
            foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
               $fecha = $tfd['FechaTimbrado']; 
               $fecha = str_replace("T", " ", $fecha); 
               $uuid = $tfd['UUID']; 
            }
            if(empty($descuento)){
            	$descuento = 0;
            }
            
            $this->query = "INSERT INTO XML_DATA (UUID, CLIENTE, SUBTOTAL, IMPORTE, IVA, FOLIO, SERIE, FECHA, RFCE, DESCUENTO)";
            $this->query.= "VALUES ('$uuid', '$rfc', '$subtotal', '$total', '$iva', '$folio', '$serie', '$fecha', '$rfce', $descuento)";
            //echo "<p>query: ".$this->query."</p>";
            $respuesta = $this->EjecutaQuerySimple();
            return $respuesta;
      
        }
        echo "No se ha localizado el archivo especificado ($archivo).";
    }
    