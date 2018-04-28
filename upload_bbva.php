
<?php

session_start();
session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;

$target_dir = "C:\\Temp\\uploads\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

//echo 'Sube el Archivo'.$target_file;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //echo 'Paso la Validacion';
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "El Archivo es: .<p>";
        $uploadOk = 1;
    }
}

$archivo = fopen($_FILES["fileToUpload"]["tmp_name"], "r") or die ("Error al leer el archivo");
while (!feof($archivo)){
	$linea=fgets($archivo);
	$salto = nl2br($linea);
	//echo substr($salto,178,50).'<p>';
    $importe =substr($salto,75,16) *1;
    $oc = substr($salto,121, 16);
    $status = substr($salto, 178, 50); ///76  al 92
    $proveedor = substr($salto,91,30);
    $status1 = substr($salto,39,1);
    $numero = substr($salto,151,7)*1;
    $fechapago = substr($salto,40,20);
    $folioBBVA = substr($salto, 60,6);
    //echo 'Proveedor: '.$proveedor.' status1: '.$status1.' numero '.$numero.'<p>';
    $datos[]= array('OC'=>substr($oc,0,7),'IMPORTE'=>$importe,'STATUS'=>$status, 'PROVEEDOR'=>$proveedor, 'STATUS1'=>$status1, 'NUMERO'=>$numero, 'FECHAPAGO'=>$fechapago, 'FOLIOBBVA'=>$folioBBVA );
}
fclose($archivo);
if ($uploadOk == 0) {
    echo "No se logra subir el archivo.";
// if everything is ok, try to upload file
} else {

}
// Check if file already exists
echo 'El archivo es:'.$target_file.'Tipo de Archivo: '.$imageFileType;
if (file_exists($target_file) or $imageFileType != "exp") {
    echo "El Archivo que intenta cargar, ya existen en el Sistema, se intenta subir un duplicado <p>";
    echo "o el archivo no es valido; solo se pueden subir arvhivos exportados de BBVA. <p>";
    $uploadOk = 0;
    //echo 'Existe y tipo es '.$imageFileType;
    $retorno = $controller->verLayOut();
}else{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "El Archivo: ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado.<p>";
    } else {
        echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
    }
    //echo 'No existe  y es exp';
    $retorno = $controller->generaComprobantes($datos);
}


 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
} 

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
} 



?>
