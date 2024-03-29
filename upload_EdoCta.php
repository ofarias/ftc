<?php
session_start();
//session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\uploads\\edocta\\";
$target_file = $target_dir . date('d_m_Y_Hiu').basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 0;
$nombre =  date('d_m_Y_Hiu').basename($_FILES["fileToUpload"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$datos = @explode(":",$_POST['datos']);
$o = $_POST['o'];

if(!file_exists($target_dir)){
    mkdir($target_dir, 0777, true);
}

if ($_FILES["fileToUpload"]["size"] > 5000000 ){
    echo "El archivo dede medir menos de 4 MB, o no coinicide el tipo de archivo con el esperado, se esperaba EXP";
    $uploadOk = 0;
}else{
        if( strtoupper($fileType) == 'XLSX' or  strtoupper($fileType) == 'CSV' or strtoupper($fileType== 'XLS') or strtoupper($fileType)=='PDF' ){
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $res=$controller->cargaEdoCtaXLS($target_file, $datos, $banco=$datos[0], $cuenta=$datos[1], $fileType, $nombre, $target_dir, $o);
                $retorno = $controller->estado_de_cuenta($banco=$datos[0], $cuenta=$datos[1]);
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
        }else{
            echo "El Archivo que intenta cargar no es un archivo valido, solo se admiten XLS, XLSX, CSV o PDF.<p>";
            $uploadOk = 0;
            $retorno = $controller->estado_de_cuenta($banco=$datos[0], $cuenta=$datos[1]);
            exit(strtoupper($fileType));
        }
}

?>
