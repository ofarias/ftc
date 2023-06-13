<?php
session_start();
require_once('app/controller/pegaso.controller.cobranza.php');
require_once('app/controller/pegaso.controller.php');
$controller_cxc = new pegaso_controller_cobranza;
$controller = new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\ComprobantesDePago\\";
if(!file_exists($target_dir)){
    mkdir($target_dir);
}
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$items=$_POST['items'];
$idp=$_POST['idp'];
$saldop= $_POST['saldop'];
$total=  $_POST['total'];
$retorno=$_POST['retorno'];
$items= explode(":", $items);
$itemsD= '';
for ($i=0; $i < count($items); $i++) { 
    $item= explode(" ", $items[$i]);
    $itemsD.= ','.$item[2].'-'.$item[6];
}
$items=substr($itemsD,1);
//exit('Revisar que la informacion que llega sea la correcta');
if ($_FILES["fileToUpload"]["size"] > ((1024*1024)*20)) {
    echo "<br/>El archivo dede medir menos de 20 MB.";
    $uploadOk = 0;
}else{
    if (file_exists($target_file) or strtoupper($fileType) != ("PDF")){
        echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
        echo "o el archivo no es valido; solo se pueden subir arvhivos PDF. <p>";
        $uploadOk = 0;
        $tipo = 'duplicado';
        $registro = $controller_cxc->guardaComprobante($target_file, $items, $idp); // Almacena el comprobande con los datos del pago y las facturas a aplicar. 
        $aplicacion = $controller->aplicarPago3($idp, $saldop, $items, $total, $retorno); /// Aqui se hace la aplicacion del pago. 
    }else{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            $tipo='ok';
            $registro=$controller_cxc->guardaComprobante($target_file, $items, $idp);
            $aplicacion=$controller->aplicarPago3($idp, $saldop, $items, $total, $retorno);
        } else {
            echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
        }
            echo 'Archivo: '.$target_file;
    }
return;
}
?>