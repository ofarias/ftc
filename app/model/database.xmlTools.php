<?php 
class sqlDataBase{
	//private $dsn = "Driver={SQL Server};Server=192.168.120.2\sqlexpress;Database=SMNOK;Integrated Security=SSPI;Persist Security Info=False;";
	
	/*Datos SQL [CADENA de CONEXION]
	 * */	
	private $dsn = "Driver={SQL Server};Server=192.168.1.183\sqlexpress;Database=FPE980326GH9;Integrated Security=SSPI;Persist Security Info=False;";
	/*Metodo para realizar consultas
	 * INPUT query con consulta
	 * OUTPUT result con arreglo de resultado*/				
	public function consulta($queryt){
		$usr = 'sa';
		$pwd =  '';
		try {
			  ini_set('max_execution_time', 600);  
		      $conexion = odbc_connect( $this->dsn, $usr, $pwd )or die(odbc_error());		
			  $result = odbc_exec($conexion, $queryt);
														
		}catch (exception $e) {
		    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		    exit;
		}
	return $result;
	odbc_close($conexion);
	}//Termina Método
	
	/*Funcion para afectar insert y update
	 * INPUT: query
	 * OUTPUT: filas afectadas*/
	public function executenonquery($queryto){
		$usr = 'sa';
		$pwd =  '';
		try {
			  ini_set('max_execution_time', 600);
			   
		      $conexion = odbc_connect( $this->dsn, $usr, $pwd )or die(odbc_error());							
			  $result = odbc_exec($conexion, $queryto);
			  
			  $rs = odbc_fetch_row($result);
		}catch (exception $e) {
		    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		    exit;
		}
	return count($rs);
	odbc_close($conexion);
	}
}
?>