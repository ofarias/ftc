<?php

session_start();

require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;

$target_dir = "C:\\xampp\\htdocs\\ComprobantesRecibo\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$cotizacion = $_POST['idc'];
$cl = $_POST['cl'];
$iddoc=$_POST['iddoc'];
$fecha = $_POST['fecha'];
$fecha = preg_split('/[\s,]+/', $fecha);
$mes=$fecha[1];
$dia=$fecha[0];
$anio=$fecha[2];
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "El archivo dede medir menos de 4 MB.";
    $uploadOk = 0;
}else{
        if (file_exists($target_file) or strtoupper($imageFileType) != ("PDF")) {
            echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
            echo "o el archivo no es valido; solo se pueden subir arvhivos PDF. <p>";
            $uploadOk = 0;
            $tipo = 'duplicado';
            $registro = $controller->guardaComprobante($target_file, $cotizacion, $mes, $anio, $dia, $tipo, $cl, $iddoc);
        }else{
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            } else {
                //echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
            //echo 'Archivo: '.$target_file;
            $tipo = 'ok';
            $respuesta = $controller->guardaComprobante($target_file, $cotizacion, $mes, $anio, $dia, $tipo, $cl, $iddoc);
        }
}
?>
