<?php

/*Clase para acceder a datos*/
    abstract class DataBaseCOI {
    	private static $usr = "SYSDBA";
		private static $pwd = "masterkey";
		private $cnx;
		protected $query;
		private $host= 'C:\\ftc\\coi.fdb';
   		//private $host = "192.168.100.95/3050:C:\Program Files (x86)\Common Files\Aspel\Sistemas Aspel\COI8.00\Datos\Empresa13\COI80EMPRE13.FDB";
   		
   		protected function checkConnect(){
   			$host = $_SESSION['r_coi'];
			@$res=$this->cnx = ibase_connect($host, self::$usr, self::$pwd);
			return $res;
   		}

   		private function AbreCnx(){
			$host = $_SESSION['r_coi'];
			$this->cnx = ibase_connect($host, self::$usr, self::$pwd);
		}
		
			#Cierra la conexion a la base de datos
		private function CierraCnx(){
			ibase_close($this->cnx);
		}
			#Ejecuta un query simple del tipo INSERT, DELETE, UPDATE
		protected function EjecutaQuerySimple(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			return $rs;
			unset($this->query);
			$this->CierraCnx();
		}

		protected function queryActualiza(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			ibase_commit();
			$rows=ibase_affected_rows();
			unset($this->query);
			$this->CierraCnx();
			return $rows;
		}

		#Obtiene la cantidad de filas afectadas en BD
		function NumRows($result){
		if(!is_resource($result)) return false;
		return ibase_fetch_row($result);
		}


		protected function grabaBD(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			ibase_commit();
			return $rs;
			unset($this->query);
			$this->CierraCnx();
		}

		#Ejecuta query de tipo SELECT
		protected function QueryObtieneDatos(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			return $this->FetchAs($rs);
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

		protected function QueryDevuelveAutocompleteCuenta(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CUENTA = htmlentities(stripcslashes($row->CUENTA));
				$row->NOMBRE = utf8_encode($row->NOMBRE);
				$row->CUENTA_COI = htmlentities(stripcslashes($row->CUENTA_COI));
				$row->RFC = htmlentities(stripcslashes($row->RFC));
				$row->NIVEL = $row->NIVEL;
				//$row_set[] = $row->CLAVE;
				$row_set[]=$row->CUENTA." : ".$row->NOMBRE.": RFC : ".$row->RFC.": Nivel : ".$row->NIVEL." : COI :".$row->CUENTA_COI;
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
				
	
		#Regresa arreglo de datos asociativo, para mejor manejo de la informacion
		#Comprueba si es un recurso el cual se compone de 
		function FetchAs($result){
			if(!is_resource($result)) return false;
				return ibase_fetch_object($result); //cambio de fetch_assoc por fetch_row
		}
		
   }

?>