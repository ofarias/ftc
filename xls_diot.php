<?php
session_start();
//session_cache_limiter('private_no_expire');
require_once('app/controller/controller.xml.php');
require_once('app/controller/pegaso.controller.php');
$controller = new controller_xml;
$cp= new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\uploads\\diot\\";
$target_file = $target_dir.$_SESSION['user']->NOMBRE." ".date('d_m_Y_Hiu').basename($_FILES["fileToUpload"]["name"]);
$x = isset($_POST['x'])? $_POST['x']:'No';
$mes = isset($_POST['mes'])? $_POST['mes']:'0';
$anio = isset($_POST['anio'])? $_POST['anio']:date('Y');
$ide = isset($_POST['ide'])? $_POST['ide']:'Recibido';
$doc = isset($_POST['doc'])? $_POST['doc']:'I';
$uploadOk = 0;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
if(!file_exists($target_dir)){
    mkdir($target_dir);
}
if ($_FILES["fileToUpload"]["size"] > 1000000 ){
    echo "El archivo dede medir menos de 1 MB, o no coinicide el tipo de archivo con el esperado, se esperaba EXP";
    $uploadOk = 0;
}else{
        if ((strtoupper($fileType) != 'XLSX' or  strtoupper($fileType) == 'CSV' or strtoupper($fileType== 'XLS'))){
            exit(strtoupper($fileType));
            echo "El Archivo que intenta cargar no es un archivo valido, solo se admiten XLS, XLSX, CSV.<p>";
            $uploadOk = 0;
        }else{
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {                
                $diot=$controller->xls_diot($target_file, $x, $mes, $anio);
                $a = $diot['a'];
                //exit($a);
                echo "<script> window.open('../diot/".$a."', 'download')</script>";
                
                $retorno=$cp->verXMLSP($mes, $anio, $ide, $doc);
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
        }
}

?>
