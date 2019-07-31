<?php
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';
require_once 'app/model/verificaID.php';
/*Clase para hacer uso de database*/
class contabilidad extends database{
	function crearSubMenuMesesConta(){
		$this->query="SELECT * FROM CIERRE_MENSUAL WHERE TIPO = 'Remisiones' or TIPO = 'PF' or TIPO= 'BF' order by anio asc, mes asc";
		$rs=$this->ejecutaQuerySimple();
		while($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}
}
?>