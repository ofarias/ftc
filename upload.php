<?php
session_start();
session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;

$target_dir = "C:\\Temp\\uploads\\";
@$target_file_xml = $target_dir . basename($_FILES["fileToUpload_XML"]["name"]);
@$target_file_pdf = $target_dir . basename($_FILES["fileToUpload_PDF"]["name"]);
//echo "XML: $target_file_xml y PDF: $target_file_pdf";
$uploadOk = 1;
$xmlFile = pathinfo($target_file_xml, PATHINFO_EXTENSION);
$pdfFile = pathinfo($target_file_pdf, PATHINFO_EXTENSION);

if (isset($_POST["submit"])) {
    $claveDocumento = $_POST["cve_doc"];
    if ($claveDocumento != "") {

        if (file_exists($target_file_xml)) {
            echo "El archivo ya existe.";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload_XML"]["size"] > 1000000) {
            echo "El archivo es mayor a 1MB no es posible cargarlo.";
            $uploadOk = 0;
        }
        if ($xmlFile != "XML" && $xmlFile != "xml") {
            echo "Solo archivos XML son validos.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Tu archivo no pudo ser cargado.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload_XML"]["tmp_name"], $target_file_xml)) {
                echo "El archivo " . basename($_FILES["fileToUpload_XML"]["name"]) . " ha sído cargado.";
                $xml = simplexml_load_file($target_file_xml) or die("Error: No se puede crear el objeto XML");
                $ns = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('c', $ns['cfdi']);
                $xml->registerXPathNamespace('t', $ns['tfd']);
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor) {
                    $Emisor_rfc = $Emisor['rfc'];
                    $Emisor_nombre = $Emisor['nombre'];
                }
                foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
                    $Receptor_rfc = $Receptor['rfc'];
                    $Receptor_nombre = $Receptor['nombre'];
                }
                foreach ($xml->xpath('//cfdi:Comprobante') as $Comprobante) {
                    $Importe = $Comprobante['total'];
                }

                foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
                    $fecha = $tfd['FechaTimbrado'];
                    $UUID = $tfd['UUID'];
                }
                print $Emisor_rfc . ": " . $Emisor_nombre . "\n";
                print $Receptor_rfc . ": " . $Receptor_nombre . "\n";
                print $fecha . ": " . $UUID . "\n";
                print $Importe . "\n";
                $retorno = $controller->insertaDocumento($claveDocumento, $target_file_xml, $target_file_pdf, $Emisor_rfc, $Emisor_nombre, $Receptor_rfc, $Receptor_nombre, $fecha, $UUID, $Importe);
                if ($retorno) {
                    echo "Se generó correctamente la referencia de la factura.";
                    if ($_FILES["fileToUpload_PDF"]["size"] > 2000000) {
                        echo "El archivo es mayor a 2MB no es posible cargarlo.";
                        $uploadOk = 0;
                    }
                    if ($pdfFile != "PDF" && $pdfFile != "pdf") {
                        echo "Solo archivos PDF son validos.";
                        $uploadOk = 0;
                    }
                    if ($uploadOk==0){
                        echo "Tu archivo PDF no pudo ser cargado.";
                    }else{
                        move_uploaded_file($_FILES["fileToUpload_PDF"]["tmp_name"], $target_file_pdf);
                        echo "El archivo " . basename($_FILES["fileToUpload_PDF"]["name"]) . " ha sído cargado.";
                    }
                } else {
                    echo "Algo ocurrió y no se logró generar el registro.";
                }
            } else {
                echo "Algo ocurrio y no se logro cargar el archivo.";
            }
        }
    } else {
        echo "Debe de existir un valor de clave documento valido.";
    }
}elseif(isset($_POST['comprobanteCaja'])){
    $target_dir_cc = "app/tmp/uploads/comprobantes_cajas/";
    $target_file_cc = $target_dir_cc . basename($_FILES["compToUpload"]["name"]);
    //$uploadOk // Aquí usare la veriable globlal declaraada al comienzo del archivo.
    $comprobanteFileType = pathinfo($target_file_cc,PATHINFO_EXTENSION);
    $caja = $_POST['caja'];
    $origen = $_POST['origen'];
    
    if(file_exists($target_file_cc)){
        echo "<div class='alert-info'><center><h2>Error: El archivo que esta tratando de guardar ya existe.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($_FILES["compToUpload"]["size"] > 1000000){
        echo"<div class='alert-info'><center><h2>Error: El archivo es demasiado grande, no puede ser guardado.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($comprobanteFileType != "pdf" && $comprobanteFileType != "jpg" && $comprobanteFileType != "jpeg" && $comprobanteFileType != "png"){
        echo "<div class='alert-info'><center><h2>Error: solamente archivos pdf, jpg y png son aceptados.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($uploadOk == 0){
        echo "<div class='alert-info'><center><h2>Lo sentimos el achivo no se ha guardado, vuelve a intentarlo siguiendo los parametros establecidos.</h2></center><br></div>";
    }else{
        if(move_uploaded_file($_FILES['compToUpload']['tmp_name'],$target_file_cc)){
            echo "<div class='alert-success'><center><h2>El archivo: ". basename($_FILES["compToUpload"]["name"]) ." se ha almacenado correctamente.</h2></center><br></div>";
            $salvar = $controller->GuardarComprobantesCaja($caja,$target_file_cc,$origen); 
                echo "<div class='alert-info'><center><h2>Registro guardado, sera redireccionado en breve.</h2></center><br></div>";
        }else{
            echo "<div class='alert-info'><center><h2>Lo sentimos hubo un error al guardar el archivo.</h2></center><br></div>";
        }
    }
    
}elseif(isset($_POST['xmlFactura'])){       // para guardar y validar XML 
    $target_dir_cc = "app/tmp/uploads/xml/";
    $target_file_cc = $target_dir_cc . basename($_FILES["xml"]["name"]);
    //$uploadOk // Aquí usare la veriable globlal declaraada al comienzo del archivo.
    $comprobanteFileType = pathinfo($target_file_cc,PATHINFO_EXTENSION);
    $factura = $_POST['factura'];
    $origen = $_POST['origen'];
    
    if(file_exists($target_file_cc)){
        echo "<div class='alert-info'><center><h2>Error: El archivo que esta tratando de guardar ya existe.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($_FILES["xml"]["size"] > 1000000){
        echo"<div class='alert-info'><center><h2>Error: El archivo es demasiado grande, no puede ser guardado.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($comprobanteFileType != "xml"){
        echo "<div class='alert-info'><center><h2>Error: solamente archivos xml son aceptados.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($uploadOk == 0){
        echo "<div class='alert-info'><center><h2>Lo sentimos el achivo no se ha guardado, vuelve a intentarlo siguiendo los parametros establecidos.</h2></center><br></div>";
    }else{
        if(move_uploaded_file($_FILES['xml']['tmp_name'],$target_file_cc)){
            echo "<div class='alert-success'><center><h2>El archivo: ". basename($_FILES["xml"]["name"]) ." se ha almacenado correctamente.</h2></center><br></div>";
                $xml = simplexml_load_file($target_file_cc) or die("Error: No se puede crear el objeto XML");
                $ns = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('c', $ns['cfdi']);
                $xml->registerXPathNamespace('t', $ns['tfd']);
                foreach ($xml->xpath('//cfdi:Comprobante') as $Comprobante) {
                    $serief = $Comprobante['serie'];
                    $foliof = $Comprobante['folio'];
                }
                
                $serie = substr($factura,0,3);
                $folio = substr($factura,3);
                
                if($serie == $serief && $folio == $foliof){
                    $salvar = $controller->GuardarXMLF($factura,$target_file_cc,$origen);  // registro en base de datos
                    echo "<div class='alert-info'><center><h2>Registro guardado, sera redireccionado en breve.</h2></center><br></div>";
                }else{
                    echo "<div class='alert-danger'><center><h2>XML Invalido</h2></center><br></div>";
                    unlink($target_file_cc);
                }
            
        }else{
            echo "<div class='alert-info'><center><h2>Lo sentimos hubo un error al guardar el archivo.</h2></center><br></div>";
        }
    }
}elseif(isset($_POST['xmlNc'])){       // para guardar y validar XML Nota de credito
    $target_dir_cc = "app/tmp/uploads/xml/";
    $target_file_cc = $target_dir_cc . basename($_FILES["xml"]["name"]);
    //$uploadOk // Aquí usare la veriable globlal declaraada al comienzo del archivo.
    $comprobanteFileType = pathinfo($target_file_cc,PATHINFO_EXTENSION);
    $factura = $_POST['nc'];
    $origen = $_POST['origen'];
    
    if(file_exists($target_file_cc)){
        echo "<div class='alert-info'><center><h2>Error: El archivo que esta tratando de guardar ya existe.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($_FILES["xml"]["size"] > 1000000){
        echo"<div class='alert-info'><center><h2>Error: El archivo es demasiado grande, no puede ser guardado.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($comprobanteFileType != "xml"){
        echo "<div class='alert-info'><center><h2>Error: solamente archivos xml son aceptados.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($uploadOk == 0){
        echo "<div class='alert-info'><center><h2>Lo sentimos el achivo no se ha guardado, vuelve a intentarlo siguiendo los parametros establecidos.</h2></center><br></div>";
    }else{
        if(move_uploaded_file($_FILES['xml']['tmp_name'],$target_file_cc)){
            echo "<div class='alert-success'><center><h2>El archivo: ". basename($_FILES["xml"]["name"]) ." se ha almacenado correctamente.</h2></center><br></div>";
                $xml = simplexml_load_file($target_file_cc) or die("Error: No se puede crear el objeto XML");
                $ns = $xml->getNamespaces(true);
                $xml->registerXPathNamespace('c', $ns['cfdi']);
                $xml->registerXPathNamespace('t', $ns['tfd']);
                foreach ($xml->xpath('//cfdi:Comprobante') as $Comprobante) {
                    $serief = $Comprobante['serie'];
                    $foliof = $Comprobante['folio'];
                }
                
                $serie = substr($factura,0,3);
                $folio = substr($factura,3);
                
                if($serie == $serief && $folio == $foliof){
                    $salvar = $controller->GuardarXMLD($factura,$target_file_cc,$origen);  // registro en base de datos
                    echo "<div class='alert-info'><center><h2>Registro guardado, sera redireccionado en breve.</h2></center><br></div>";
                }else{
                    echo "<div class='alert-danger'><center><h2>XML Invalido</h2></center><br></div>";
                    unlink($target_file_cc);
                }
            
        }else{
            echo "<div class='alert-info'><center><h2>Lo sentimos hubo un error al guardar el archivo.</h2></center><br></div>";
        }
    }
}elseif(isset($_POST['upComprobanteFletera'])){  ///////////////// Para validar y subir el comprobante de envió foraneo 
    $target_dir_cc = "app/tmp/uploads/guias_foraneos/";
    $target_file_cc = $target_dir_cc . basename($_FILES["comprobanteFletera"]["name"]);
    //$uploadOk // Aquí usare la veriable globlal declaraada al comienzo del archivo.
    $comprobanteFileType = pathinfo($target_file_cc,PATHINFO_EXTENSION);
    $ped = $_POST['ped'];
    $idr = $_POST['iduni'];
    
    if(file_exists($target_file_cc)){
        echo "<div class='alert-info'><center><h2>Error: El archivo que esta tratando de guardar ya existe.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($_FILES["comprobanteFletera"]["size"] > 1000000){
        echo"<div class='alert-info'><center><h2>Error: El archivo es demasiado grande, no puede ser guardado.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($comprobanteFileType != "pdf" && $comprobanteFileType != "jpg" && $comprobanteFileType != "jpeg" && $comprobanteFileType != "png"){
        echo "<div class='alert-info'><center><h2>Error: solamente archivos pdf, jpg y png son aceptados.</h2></center><br></div>";
        $uploadOk = 0;
    }
    
    if($uploadOk == 0){
        echo "<div class='alert-info'><center><h2>Lo sentimos el achivo no se ha guardado, vuelve a intentarlo siguiendo los parametros establecidos.</h2></center><br></div>";
    }else{
        if(move_uploaded_file($_FILES['comprobanteFletera']['tmp_name'],$target_file_cc)){
            echo "<div class='alert-success'><center><h2>El archivo: ". basename($_FILES["comprobanteFletera"]["name"]) ." se ha almacenado correctamente.</h2></center><br></div>";
            $salvar = $controller->GuardarGuiaForaneo($ped,$target_file_cc,$idr); 
                echo "<div class='alert-info'><center><h2>Registro guardado, sera redireccionado en breve.</h2></center><br></div>";
        }else{
            echo "<div class='alert-info'><center><h2>Lo sentimos hubo un error al guardar el archivo.</h2></center><br></div>";
        }
    }
    
}