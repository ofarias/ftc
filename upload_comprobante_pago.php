<?php
session_start();
require_once('app/controller/pegaso.controller.cobranza.php');
require_once('app/controller/pegaso.controller.php');
$controller_cxc = new pegaso_controller_cobranza;
$controller = new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\ComprobantesDePago\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$items=$_POST['items'];
$idp=$_POST['idp'];
$saldop= $_POST['saldop'];
$total=  $_POST['total'];
$retorno=$_POST['retorno'];

if ($_FILES["fileToUpload"]["size"] > ((1024*1024)*20)) {
    echo "El archivo dede medir menos de 20 MB.";
    $uploadOk = 0;
}else{
    if (file_exists($target_file)){
        echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
        echo "o el archivo no es valido; solo se pueden subir arvhivos PDF. <p>";
        $uploadOk = 0;
        $tipo = 'duplicado';
        $registro = $controller_cxc->guardaComprobante($target_file, $items, $idp);
        $aplicacion = $controller->aplicarPago2($idp, $saldop, $items, $total, $retorno);
    }elseif(strtoupper($fileType) == ("PDF") or strtoupper($fileType) == ("XLSX") OR strtoupper($fileType) == ("XLS") OR strtoupper($fileType) == ("PNG") OR strtoupper($fileType) == ("JPG") OR strtoupper($fileType) == ("DOC") OR strtoupper($fileType) == ("DOCX") ){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            $tipo = 'ok';
            $registro = $controller_cxc->guardaComprobante($target_file, $items, $idp);
            $aplicacion = $controller->aplicarPago2($idp, $saldop, $items, $total, $retorno);
        } else {
            echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
        }
            echo 'Archivo: '.$target_file;
    }
}
?>