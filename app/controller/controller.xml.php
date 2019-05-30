<?php
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once('app/model/database.xmlTools.php');
require_once('app/model/db.contabilidad.php');
require_once('app/model/cargaXML.php');

class controller_xml{
	var $contexto_local = "http://SERVIDOR:8081/pegasoFTC/app/";
	var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	function load_template2($title='Escaneo de Documentos Logistica'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header2.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
	private function load_page($page){
	return file_get_contents($page);
	}
	private function view_page($html){
	echo $html;
	}
	private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
	return preg_replace($in, $out, $pagina);	 	
	}

	function cargaMetaDatos(){
		if($_SESSION['user']){
			$pagina =$this->load_template2('Pedidos');
			$html=$this->load_page('app/views/pages/xml/p.cargaMetaDatos.php');
   			ob_start();
   			include 'app/views/pages/xml/p.cargaMetaDatos.php';
   			$table = ob_get_clean();
   			$pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
   			$this->view_page($pagina);	
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	function facturacionCargaXML($files2upload, $tipo){
		if (isset($_SESSION['user'])) {            
            $data = new cargaXML;
            $valid_formats = array("txt", "TXT");
            $max_file_size = 1024 * 10000; //1000 kb
            //$target_dir = "C:\\Temp\\uploads\\xml\\";
            $target_dir="C:/xampp/htdocs/uploads/xml/metaData/";	
            $count = 0;
            $respuesta = 0;
			// Loop $_FILES to exeicute all files
			foreach ($_FILES['files']['name'] as $f => $name) {	
                if ($_FILES['files']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }
                if ($_FILES['files']['error'][$f] == 0) {
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $message[] = "$name es demasiado grande para subirlo.";
                        continue; // Skip large files
                    }elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                        $message[] = "$name no es un archivo permitido.";
                        continue; // Skip invalid file formats
                    } else { // No error found! Move uploaded files 
                        $archivo = $target_dir.$name;
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir . $name)){
                            $count++;// Number of successfully uploaded file
							$respuesta+=$data->insertarMetaDatos($archivo);
								//unlink($_FILES["files"]["tmp_name"][$f]);
                        }
                    }
                }
            }
            echo "Archivos cargados con exito: $count-$respuesta";
            $this->cargaMetaDatos();
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }	
	}

}?>

