<?php 

require_once ('app/model/database.php');
require_once 'app/Classes/PHPExcel.php';

class acomodoXML extends database{

	function acomodo($path){
		$destiny="\\\\serverHP30\\c$\\xampp\\htdocs\\ftc_admin\\app\\descargasat\\descargas\\";
		$all = scandir($path);
		$files=0;$dir=0; $file=array(); $d=array();
		for($i=0; $i<count($all); $i++){
			if(is_file($path."\\".$all[$i])){
				$files++;
				$file[]=$all[$i];
			}else{
				if($all[$i]!= '.' And $all[$i]!= '..'){
					$dir++;
					$d[]=$all[$i];
				}
			}
		}
		//echo '<br/>Son '.$files.' archivos y '.$dir.' directorios';
		if(count($file)>0){
			for($i=0;$i<count($file);$i++){
				$rfc = explode("\\",$path);
				//echo '<br/>'.$path."\\".$file[$i]. " el rfc es: ".$rfc[1];
				rename($path."\\".$file[$i], $destiny.$rfc[1]."\\".$file[$i]);
			}
		}
		if(count($d)>0){
			//echo 'Los directorios son:';
			for($i=0;$i<count($d);$i++){
				//echo "<br/>$i .- $d[$i]";
				if($d[$i]!= '.' And $d[$i]!= '..'){
					//echo '<br/>'.$path.'\\'.$d[$i];
					$this->acomodo($path.'\\'.$d[$i]);
				}
			}	
		}
		//$this->$cierra();
	}

	function mapeo(){
		$location = "\\\\DORIS\\Emitidos";
		$user = "Doris\\doris";
		$pass = "d0424";
		$letter = "W";
		system("net use /delete ".$letter.":");
		$param="net use ".$letter.": ".$location." ".$pass." /user:".$user." /persistent:no";
		//$param = "net use ".$letter.": \\\\DORIS\\Emitidos d0424 /user:Doris\\doris /persistent:no";
		//echo $param; 
		system($param);
		return $path=$letter.":";
	}


	function analiza(){
		$data=array(); $mdata=array();
		$this->query="SELECT UUID, min(STATUS) AS status FROM FTC_META_DATOS GROUP BY UUID";
		$res=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		count($data);
		echo 'Se encontraron '.count($data).' documentos';

		foreach ($data as $md) {
			//echo 'Buscamos la informacion correcta y mandamos a incidentes, EL STATUS 0 ES QUE ESTA CANCELADO';
			$this->query="SELECT * FROM XML_DATA WHERE UUUID = '$md->UUID'";
			$res=$this->EjecutaQuerySimple();

			while($tsArray=ibase_fetch_object($res)){
				$mdata[]=$tsArray;
			}
			if(count($mdata)==1){
				/// es unico hay que revisar el status
				foreach($mdata as $mdt){
					$status = $mdt->STATUS=='C'? 0:1;
					$statusMD = $md->STATUS;
					if($statusMD != $status){
						echo 'Error de coincidencia';
					}
				}
			}elseif(count($mdata>1)){
				/// hay mas de uno
			}else{
				/// no existe
			}

		}
		die();
	}

	function nombraImagenes($imagen, $lista){
		$inputFileType = PHPExcel_IOFactory::identify($lista);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel= $objReader->load($lista);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		for($row = 2; $row <= $highestRow; $row++){
			echo '<br/>Nombre imagen '.$sheet->getCell("A".$row)->getValue();
			$nom = $sheet->getCell("A".$row)->getValue();
			$isbn = trim($sheet->getCell("C".$row)->getValue());
			rename ($imagen.$nom.'.jpg', $imagen.$isbn.'.jpg');
			//rename($imagen.)		
		}
	}

	function revisaImagen(){
		$data=array();
		$this->query="SELECT * FROM ftc_articulos_img where status = 1";
		$res= $this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($res)){
			$data[]=$tsArray;
		}
		$n =0;
		foreach ($data as $d) {
			if(!file_exists($d->RUTA.$d->NOMBRE)){
				$n++;
				$this->query="UPDATE ftc_articulos_img set status = 9 where id_img = $d->ID_IMG";
				$this->queryActualiza();
			}
		}
		echo 'No existen '.$n. ' imagenes. ';
	}

	function xmlDebian(){
		//var_dump($_SESSION);
		$rfc = $_SESSION['empresa']['rfc']; 
		//echo '<br/>El RFC es: '.$rfc;
		$tipo = 'Recibidos';
		$path = '/home/ofarias/xmls/uploads/'.$rfc.'/'.$tipo;
		$archivos = scandir($path);
		$archivos = array_filter($archivos, function($archivo) use ($path){
    			return is_file($path . '/' . $archivo);
		});
		if (count($archivos)>0){
			foreach ($archivos as $archivo) {
				$dir = explode("\\", $archivo);
				//echo '<br/>'.$dir[0]. ' archivo: '. $dir[1];
				$destino = $path.'/'.$dir[0].'/';
				if(rename($path.'/'.$archivo, $destino.'/'.$archivo)){
					echo 'Se movio el archivo '.$archivo.'<br/>'; 
				}else{
					echo 'No se pudo mover el archivo '.$archivo.'<br/>'; 
				}
			}
		}
		$elementos = scandir($path);
		$directorios = array_filter($elementos, function($elemento) use ($path) {
    		return is_dir($path . '/' . $elemento) && $elemento != '.' && $elemento != '..';
		});
		foreach ($directorios as $directorio) {
    		//echo '<br/>'.$directorio . '<br>';
    		$newDirectorio = $path.'/'.$directorio;
    		$archivos = scandir($newDirectorio);

			$archivos = array_filter($archivos, function($archivo) use ($newDirectorio){
    			return is_file($newDirectorio . '/' . $archivo);
			});
			if (count($archivos)>0){
				foreach ($archivos as $archivo) {
					if(strpos($archivo, "//") ){
						$dir = explode("\\", $archivo);
						//echo '<br/>'.$dir[0]. ' archivo: '. $dir[1];
						//$destino = $newDirectorio.'/'.$dir[1];
						if(rename($newDirectorio.'/'.$archivo, $newDirectorio.'/'.$dir[1])){
							echo 'Se cambio el nombre '.$archivo.' a '.$dir[1].'<br/>'; 
						}else{
							echo 'No se Cambio el nombre '.$archivo.'<br/>'; 
						}
					}
				}
			}    		
		}

	}

	function xmlDebianNom(){
		$rfc = $_SESSION['empresa']['rfc']; 
		$path = '/home/ofarias/xmls/uploads/';
		$archivos = scandir($path);
		$archivos = array_filter($archivos, function($archivo) use ($path){
    			return is_file($path . '/' . $archivo);
		});
		if (count($archivos)>0){
			foreach ($archivos as $archivo) {
				$elemento = substr($archivo, 7);
				echo '<br/>'.$elemento;
				$destino = $path.'/'.$rfc.'/Nomina/';
				if(rename($path.'/'.$archivo, $destino.'/'.$elemento)){
					echo 'Se movio el archivo '.$archivo.'<br/>'; 
				}else{
					echo 'No se pudo mover el archivo '.$archivo.'<br/>'; 
				}
			}
		}

	}
} 



