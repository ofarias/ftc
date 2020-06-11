<?php
session_start();
require_once('app/controller/controller.xml.php');
$controller = new controller_xml;
$tipo = $_POST['tipo'];
$mes = $_POST['mes'];
$nmes = $_POST['nmes'];
$anio = $_POST['anio'];
$target_dir = "C:\\xampp\\htdocs\\media\\fiscal\\".$_SESSION['rfc']."\\".$tipo."\\".$mes."_".$anio."\\";
if(!file_exists($target_dir)){
    mkdir($target_dir, null, true);
}
$file = date("Y_m_d H_i_s"). basename($_FILES["fileToUpload"]["name"]);
$file2 = date("Y_m_d H_i_s").basename($_FILES["fileToUpload2"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($file,PATHINFO_EXTENSION);
$files = array($file, $file2);
if ($_FILES["fileToUpload"]["size"] > ((1024*1024)*20)) {
    echo "El archivo dede medir menos de 20 MB.";
    $uploadOk = 0;
}else{
    if (file_exists($file)){
        echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
        echo "o el archivo no es valido; solo se pueden subir arvhivos PDF. <p>";
        //$uploadOk = 0;
        //$tipo = 'duplicado';
        $registro = $controller->gCompISR($mes, $anio, $files, $target_dir, $nmes);
        return;
    }elseif(strtoupper($fileType) == ("PDF") or strtoupper($fileType) == ("XLSX") OR strtoupper($fileType) == ("XLS") OR strtoupper($fileType) == ("PNG") OR strtoupper($fileType) == ("JPG") OR strtoupper($fileType) == ("DOC") OR strtoupper($fileType) == ("DOCX") ){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$file) and move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_dir.$file2)){
            echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            $registro = $controller->gCompISR($mes, $anio, $files, $target_dir, $tipo, $nmes);
            return;
        } else {
            echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
        }
            echo 'Archivo: '.$file;
    }
}
?>