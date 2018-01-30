<?php

/*Clase para acceder a datos*/
    abstract class DataBaseCOI {
    	private static $usr = "SYSDBA";
		private static $pwd = "masterkey";
		private $cnx;
		protected $query;
                // cfa --> cambia esta línea: C:\Program Files (x86)\Common Files\Aspel\Sistemas Aspel\COI7.00\Datos\Empresa02
		//private $host = "C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\COI7.00\\Datos\\Empresa02\\COI70EMPRE02.FDB";
		private $host = "C:\\Program Files (x86)\\Common Files\\Aspel\\Sistemas Aspel\\COI8.00\\Datos\\Empresa2\\COI80EMPRE2.FDB";
		//C:\Program Files (x86)\Common Files\Aspel\Sistemas Aspel\COI8.00\Datos\Empresa2
		#Abre la conexión a la base de datos
		private function AbreCnx(){
			$this->cnx = ibase_connect($this->host, self::$usr, self::$pwd);
		}
		
		#Cierra la conexion a la base de datos
		private function CierraCnx(){
			ibase_close($this->cnx);
		}
		
		#Ejecuta un query simple del tipo INSERT, DELETE, UPDATE
		protected function EjecutaQuerySimple(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			//print_r($rs);
			//echo $this->query;
			return $rs;
			unset($this->query);
			$this->CierraCnx();
		}
		
		#Ejecuta query de tipo SELECT
		protected function QueryObtieneDatos(){
			$this->AbreCnx();
			//echo $this->query;
			$rs = ibase_query($this->cnx, $this->query);
			return $this->FetchAs($rs);
			//var_dump($rs);	
			//echo $this->query;	
			unset($this->query);	
			$this->CierraCnx();
		}
		
		protected function QueryObtieneDatosN(){
			$this->AbreCnx();
			//echo $this->query;
			$rs = ibase_query($this->cnx, $this->query);
			return $rs;
			//var_dump($rs);	
			//echo $this->query;	
			unset($this->query);	
			$this->CierraCnx();
		}

		protected function QueryDevuelveAutocomplete(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE = htmlentities(stripcslashes($row->CLAVE));
				$row->NOMBRE = htmlentities(stripcslashes($row->NOMBRE));
				//$row_set[] = $row->CLAVE;
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}
		
		protected function QueryDevuelveAutocompleteP(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CVE_ART = htmlentities(stripcslashes($row->CVE_ART));
				$row->DESCR = htmlentities(stripcslashes($row->DESCR));
				//$row_set[] = $row->CLAVE;
				$row_set[] = $row->CVE_ART." : ".$row->DESCR;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}
				
		#Obtiene la cantidad de filas afectadas en BD
		function NumRows($result){
		if(!is_resource($result)) return false;
		return ibase_fetch_row($result);
		}
		#Regresa arreglo de datos asociativo, para mejor manejo de la informacion
		#Comprueba si es un recurso el cual se compone de 
		function FetchAs($result){
			if(!is_resource($result)) return false;
				return ibase_fetch_object($result); //cambio de fetch_assoc por fetch_row
		}

   }

?>