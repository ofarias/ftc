<?php 

require_once ('app/model/database.php');

class acomodoXML extends database{

	function acomodo($path){
		$destiny="\\\\192.168.100.33\\c$\\xampp\\htdocs\\ftc_admin\\app\\descargasat\\descargas\\";
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
} 



