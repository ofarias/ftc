<?php
session_start();
//session_cache_limiter('private_no_expire');
require_once('app/controller/pegaso.controller.php');
$controller = new pegaso_controller;
$target_dir = "C:\\xampp\\htdocs\\uploads\\xls\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 0;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$pol = 0; $polDr = 0; $polIg= 0; $polEg = 0; $polCh = 0; $polF = 0; $polNc=0;
$idpol = $controller->idPol();
if ($_FILES["fileToUpload"]["size"] > 20000000 ){
    echo "El archivo dede medir menos de 4 MB, o no coinicide el tipo de archivo con el esperado, se esperaba EXP";
    $uploadOk = 0;
}else{
        if (file_exists($target_file)) {
            echo "El Archivo que intenta cargar, ya fue procesado con anterioridad, favor de revisar con Sistemas.<p>";
            $uploadOk = 0;
            //$retorno = $controller->verProveedores();
        }else{
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {                
                    $a= $target_file;
                    $inputFileType=PHPExcel_IOFactory::identify($a);
                    $objReader=PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel=$objReader->load($a);
                    $sheet=$objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow(); 
                    $highestColumn = $sheet->getHighestColumn();
                    $tp = array("Ingresos", "Egresos", "Diario", "Cheques", "Facturacion", "Nota Credito");
                    //echo 'Total Lineas '.$highestRow;
                    for ($row=7; $row <= $highestRow; $row++){
                        $ln = $row+1; 
                        $a=$sheet->getCell("A".$row)->getValue();
                        $b=trim($sheet->getCell("B".$row)->getValue());
                        $c=$sheet->getCell("C".$row)->getValue();
                        $d=$sheet->getCell("D".$row)->getValue();
                        if(substr_count($a, "/")==2){
                            //echo "<br/> Valor de A".$row.": ".$a." Valor de B".$row.": ".$b." Valor de C".$row.': '.$c;
                            $af = explode("/", $a);
                            switch ($af[1]) {
                                case 'Ene':
                                    $mes = 1;
                                    break;
                                case 'Feb':
                                    $mes = 2;
                                    break;
                                case 'Mar':
                                    $mes = 3;
                                    break;
                                case 'Abr':
                                    $mes = 4;
                                    break;
                                case 'May':
                                    $mes = 5;
                                    break;
                                case 'Jun':
                                    $mes = 6;
                                    break;
                                case 'Jul':
                                    $mes = 7;
                                    break;
                                case 'Ago':
                                    $mes = 8;
                                    break;
                                case 'Sep':
                                    $mes = 9;
                                    break;
                                case 'Oct':
                                    $mes = 10;
                                    break;
                                case 'Nov':
                                    $mes = 11;
                                    break;
                                case 'Dic':
                                    $mes = 12;
                                    break;
                                default:
                                    $mes = 0;
                                    break;
                            }
                            /*
                                if(checkdate( $mes, $af[0], $af[2])){
                                    echo '<br/> la linea '.$row. ' es fecha';
                                }else{
                                    echo '<br/> dia '.$af[0]. ' mes '.$mes. ' anio '.$af[2];
                                }

                                if(in_array($b, $tp)){
                                    echo '<br/> la linea '.$row. ' es de tipo '.$b;
                                }else{
                                    echo '<br/> NO se detecto el tipo: '.$b. ' en el array '.print_r($tp) ;
                                }

                                if(is_numeric($c)){
                                    echo '<br/> la linea '.$row. ' y '.$c. ' es un numero';
                                }                            
                            */
                            if(checkdate( $mes, $af[0], $af[2]) and in_array($b, $tp) and is_numeric($c)){
                                //echo '<br/> Esta Linea es el inicio de una poliza: '.$row;
                                $pol++;
                                if($b == 'Ingresos'){
                                    $polIg++;
                                }elseif($b == 'Egresos'){
                                    $polEg++;
                                }elseif($b == 'Diario'){
                                    $polDr++;
                                }elseif($b == 'Cheques'){
                                    $polCh++;
                                }elseif($b == 'Facturacion'){
                                    $polF++;
                                }elseif($b == 'Nota Credito'){
                                    $polNc++;
                                }

                                $idpol++;
                                $cabecera[]=array("id"=>$idpol,"numero"=>$c, "tipo"=>$b, "fecha"=>$af[0].'.'.$mes.'.'.$af[2], "periodo"=>$mes, "eje"=>$af[2], "concepto"=>$d);
                                for($i=$ln; $i <= $highestRow; $i++){
                                    $par = $sheet->getCell("A".$i)->getValue(); 
                                    $ref = $sheet->getCell("B".$i)->getValue();
                                    $cuenta = $sheet->getCell("C".$i)->getValue();
                                    $cargo = $sheet->getCell("G".$i)->getValue();
                                    $abono = $sheet->getCell("H".$i)->getValue();
                                    $fin  = trim($sheet->getCell("B".$i)->getValue());

                                    if($fin == 'Cifra de Control'){
                                        break;
                                    }
                                    if(is_numeric($par) and !empty($cuenta) and ($cargo > 0 or $abono >0 )){
                                        //echo '<br/>Esta linea es de partidas '.$i;
                                        $partidas[]=array("idpol"=>$idpol, "par"=>$par, "cuenta"=>$cuenta, "concepto"=>$d, "ref"=>$ref,"cargo"=>$cargo, "abono"=>$abono);
                                    }
                                }

                            }else{/// Cuando no cumple las 3 validaciones es que no es una poliza 
                                //echo '<br/> Revisar linea '.$row;
                            }    
                        }
                    
                    }
                /*
                    echo '<br/>Lineas leidas'.$row;
                    echo '<br/>Este Archivo tiene '.$pol.' polizas';
                    echo '<br/>Poliza Ig'.$polIg;
                    echo '<br/>Poliza Eg'.$polEg;
                    echo '<br/>Poliza Ch'.$polCh;
                    echo '<br/>Poliza Dr'.$polDr;
                    echo '<br/>Poliza F'.$polF;
                die();
                */
                $res = $controller->insertaPoliza($cabecera,$partidas);
            } else {
                echo "Ocurrio un problema al subir su archivo, favor de revisarlo.";
            }
        }
}

?>
