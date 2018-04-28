
<?php

session_start();
session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;

$target_dir = "C:\\xampp\\htdocs\\PedidosVentas\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$cotizacion = $_POST["cotizacion"];

//echo 'El archivo es:'.$target_file.'Tipo de Archivo: '.$imageFileType;
echo 'cotizacion: '.$cotizacion.'<p>';
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "El archivo dede medir menos de 4 MB.";
    $uploadOk = 0;

}else{
        if (file_exists($target_file) or strtoupper($imageFileType) != ("PDF")) {
            echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
            echo "o el archivo no es valido; solo se pueden subir arvhivos PDF. <p>";
            $uploadOk = 0;
            //echo 'Existe y tipo es '.$imageFileType;
            $retorno = $controller->verLayOut();
        }else{
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }

            echo 'Archivo: '.$target_file;
            $respuesta = $controller->guardaPedido($target_file, $cotizacion);
        }

}

?>
