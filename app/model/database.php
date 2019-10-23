<?php

/*Clase para acceder a datos*/
    abstract class database{
    	private static $usr = "SYSDBA";
		private static $pwd = "masterkey";
		private $cnx;
		protected $query;
		private $host = "C:\\ftcData\\PCF.FDB";
		#Abre la conexión a la base de datos
		private function AbreCnx(){
			$host = 'ofa.dyndns.org:'.$_SESSION['bd'];
			$this->cnx=ibase_connect($host, self::$usr, self::$pwd);
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

		protected function QueryDevuelveAutocompleteProd(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$iva = empty($row->IVA_V)? 0:$row->IVA_V;
				$row_set[] = utf8_encode($row->ID)." : ".utf8_encode($row->GENERICO.' '.$row->SINONIMO.' '.$row->CALIFICATIVO).":".$row->PRECIO_V.":".$row->DESC1.":".$row->DESC2.":".$iva.":".$row->EXISTENCIA;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}

		protected function QueryDevuelveAutocompletePFTC(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE = htmlentities(stripcslashes($row->CLAVE));
				$row->NOMBRE = htmlentities(stripcslashes($row->NOMBRE));
				$row->COSTO_VENTAS = htmlentities(stripcslashes($row->COSTO_VENTAS));
				$row->PROVEEDOR = htmlentities(stripcslashes($row->PROVEEDOR));
				//$row_set[] = $row->CLAVE;
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE." COSTO: ".$row->COSTO_VENTAS;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();	
		}

		protected function QueryDevuelveAutocompleteClie(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE =utf8_encode($row->CLAVE);
				$row->NOMBRE = utf8_encode(str_replace(",", " ", $row->NOMBRE));
				//$row->COSTO_VENTAS = htmlentities(stripcslashes($row->COSTO_VENTAS));
				//$row->PROVEEDOR = htmlentities(stripcslashes($row->PROVEEDOR));
				//$row_set[] = $row->CLAVE;
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();	
		}

		protected function QueryDevuelveAutocompleteClieNV(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CLAVE =utf8_encode($row->CLAVE);
				$row->NOMBRE = utf8_encode(str_replace(",", " ", $row->NOMBRE));
				$row_set[] = $row->CLAVE." : ".$row->NOMBRE.":".$row->DIRECCION.":".$row->INTERIOR.":".$row->COLONIA.":".$row->DELEGACION.":".$row->CODIGO.":".$row->PAIS;
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
				$row->DESCR = htmlentities(stripcslashes(utf8_decode($row->DESCR)));
				//$row_set[] = $row->CLAVE;
				$row_set[] = $row->CVE_ART." : ".$row->DESCR;
			}
			return $row_set;
			unset($this->query);	
			$this->CierraCnx();
		}
		
		protected function QueryDevuelveAutocompleteC(){
			$this->AbreCnx();
			$rs = ibase_query($this->cnx, $this->query);
			while($row = ibase_fetch_object($rs)){
				$row->CVE_PROD_SERV = htmlentities(stripcslashes($row->CVE_PROD_SERV));
				$row->DESCRIPCION = htmlentities(stripcslashes(utf8_decode($row->DESCRIPCION)));
				$row_set[] = $row->CVE_PROD_SERV." : ".$row->DESCRIPCION;
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
