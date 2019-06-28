<?php 
require_once 'app/model/database.php';
/*Clase para hacer uso de database*/
class pegaso extends database {
	
	function testAjax(){
		if(isset($_POST["query"])){
			$query = $_POST["query"];
			$output = '';
			$this->query = "SELECT * FROM CLIE01 WHERE NOMBRE CONTAINING ('$query')";
			$rs=$this->Ejecutaquerysimple();
			$output='<ul class="list-unstyled">';
			if($rs){
				while($tsArray = ibase_fetch_object($rs)){
					$output .='<li>'.$tsArray["NOMBRE"].'</li>';
				}
			}else{
				$output .='<li>No se encontraron datos </li>';
			}
			$output .='</ul>';
			echo $output;
		}
	}
}
?>