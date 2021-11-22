<?php
session_start();
require_once('app/controller/controller.serv.php');
$controller = new ctrl_serv;
$target_dir = "C:\\xampp\\htdocs\\media\\files\\";
if(!file_exists($target_dir)){
    echo 'El directorio: '.$target_dir.' no existe, se creara el nuevo directorio';
    mkdir($target_dir);
}
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$nombre = pathinfo($target_file, PATHINFO_FILENAME);
$extension = pathinfo($target_file,PATHINFO_EXTENSION);
$origen = $_POST['origen'];
$servicio = $_POST['servicio'];
$obs = isset($_POST['obs'])? $_POST['obs']:'';
$emp = isset($_POST['emp'])? $_POST['emp']:0;
$tipo_Doc = isset($_POST['tipoArchivo'])? $_POST['tipoArchivo']:'';

if ($_FILES["fileToUpload"]["size"] > ((1024*1024)*50)) {
    echo "El archivo dede medir menos de 20 MB.";
    $uploadOk = 0;
}else{
    if( strtoupper($extension) != ("PDF") and strtoupper($extension) != ("XLS")  and strtoupper($extension) != ("DOC")  and strtoupper($extension) != ("XLSX")  and strtoupper($extension) != ("DOCX")  and strtoupper($extension) != ("TXT")  and strtoupper($extension) != ("CSV")  and exif_imagetype($target_file) and strtoupper($extension) != ("RAR")  and strtoupper($extension) != ("ZIP") and strtoupper($extension) != 'JPG' and strtoupper($extension) != 'BMP' and strtoupper($extension) != 'PNG' and strtoupper($extension) != 'JPEG' and strtoupper($extension) != 'MOV' and strtoupper($extension) != 'MP4' 
        ){
        echo "El Archivo que intenta cargarno es valido, solo se permiten XLS, XLSX, DOC, DOCX, PDF, TXT, CSV e imagenes<p>";
        echo "favor de revisar que el archivo sea de este tipo: .<p>".strtoupper($extension);
        $uploadOk=0;
    }else{
        $tipo = file_exists($target_file)? 'Duplicado':'Original';
        if($tipo == 'Duplicado'){
            $nombre = $nombre.date('d_m_Y H_i_s').'.'.$extension;
            $target_file= $target_dir.$nombre;
        }
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
            $respuesta = $controller->cargaArchivo($target_file, $servicio, $tipo, $origen,$target_dir, $nombre, $_FILES["fileToUpload"]["size"], $extension, $obs, $emp, $tipo_Doc);
        }else{
            echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
        }
    }
}
?>