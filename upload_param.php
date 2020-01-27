<?php
session_start();
//session_cache_limiter('private_no_expire');
require_once('app/controller/controller.coi.php');
$controller = new controller_coi;
$target_dir = "C:\\xampp\\htdocs\\uploads\\parametros\\";
$target_file = $target_dir.$_SESSION['user']->NOMBRE." ".date('d_m_Y_Hiu').basename($_FILES["fileToUpload"]["name"]);
$x = $_GET['x'];
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
            //$retorno = $controller->estado_de_cuenta($banco=$datos[0], $cuenta=$datos[1]);
        }else{
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {                
                //$res=$controller->cargaEdoCtaXLS($target_file, $datos, $banco=$datos[0], $cuenta=$datos[1]);
                $upl_param =$controller->upl_param($target_file, $x);
                $retorno = $controller->estado_de_cuenta($banco=$datos[0], $cuenta=$datos[1]);
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
        }
}

?>
