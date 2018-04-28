<?php
session_start();
session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\PegasoFTC\\app\\LayoutBBVA\\Alta\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 0;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES["fileToUpload"]["size"] > 500000 ){
    echo "El archivo dede medir menos de 4 MB, o no coinicide el tipo de archivo con el esperado, se esperaba EXP";
    $uploadOk = 0;
}else{
        if (file_exists($target_file)) {
            echo "El Archivo que intenta cargar, ya fue procesado con anterioridad, favor de revisar con Sistemas.<p>";
            $uploadOk = 0;
            $retorno = $controller->verProveedores();
        }else{
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {                
                $archivo = fopen($target_file, "r") or die ("Error al leer el archivo");
                    while (!feof($archivo)){
                        $linea=fgets($archivo);
                        $salto = nl2br($linea);
                        $cuenta = substr($salto, 0,18);
                        if(substr($cuenta,0,3) == '000'){
                            $proveedor = substr($salto,67,30);/// BBVA = 70  e Interbancarios es 68
                            $proveedor =split('_', $proveedor);
                            $proveedor = trim($proveedor[0]);
                            $banco = substr($cuenta, 0,3);
                            $res = substr($salto,187,20);//// BBVA = 192  e interbancarias es 187
                        }elseif(substr($cuenta,0,3) != '000'){
                            $proveedor = substr($salto,70,30);/// BBVA = 70  e Interbancarios es 80
                            $proveedor =split('_', $proveedor);
                            $proveedor = trim($proveedor[0]);
                            $banco =substr($cuenta, 0,3);
                            $res = substr($salto,192,20);//// BBVA = 192  e interbancarias es 187
                            $cuenta = substr($salto, 3,18);
                        }
                        //echo 'Cuenta: '.$cuenta.' Banco: '.$banco.' Resultado: '.$res.' Proveedor: '.$proveedor.'<p>';
                        $datos[]= array('CVE_PROV'=>$proveedor,'Resultado'=>$res,'Cuenta'=>$cuenta,'Banco'=>$banco );
                    }
                fclose($archivo);    
                $res = $controller->actualizaProveedorBBVA($datos);
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
        }
}

?>
