
<?php

session_start();
require_once('app/controller/pegaso.controller.php');
require_once('app/model/facturacion.php');
$controller = new pegaso_controller;
$dataf = new factura;
$target_dir = "C:\\xampp\\htdocs\\Facturas\\ErroresJson\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$nombre = basename($_FILES["fileToUpload"]["name"]);
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
//exit(var_dump($imageFileType).'Nombre'.$_FILES["fileToUpload"]["name"]);
    $nf="FP-10708";
    $fh="C:\\xampp\\htdocs\\Facturas\\ErroresJson\\".$nf.".json";
    $data = file_get_contents($fh);
    $json = json_decode($data, true);

    $insertaValores = $dataf->insertaJson($json,$fh);
    exit();

?>
