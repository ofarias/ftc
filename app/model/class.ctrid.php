<?php 
require_once 'app/model/database.php';

/*Clase para hacer uso de database*/
class idpegaso extends database{
	
	function revisaDuplicado($idpreoc){
		$this->query="SELECT * FROM PREOC01 WHERE ID = $idpreoc";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$original = $row->CANT_ORIG;

		$this->query="SELECT sum(pxr) AS PXR FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc group by ID_PREOC";
		$rs1=$this->EjecutaQuerySimple();
		$parcomp = ibase_fetch_object($rs1);
		$ordenado = $parcomp->PXR; 
		
		$this->query="SELECT SUM(CANTIDAD_rec) as cantidad_rec FROM FTC_DETALLE_RECEPCIONES WHERE IDPREOC = $idpreoc group by idpreoc";
		$rs2=$this->EjecutaQuerySimple();
		$recibido = ibase_fetch_object($rs2);
		$recibo = $recibido->CANTIDAD_REC;

		$pxr = $original - $recibido;
		$pxo = $original - $recibido - $ordenado;

		// esta mal -.... solo sirve para saber lo ordenado y lo pendiente, pero no para validar la liberacion.
		
		if($pxo > $original){
			echo 'Envia un aviso, bloquea la linea y manda reporte ';
			$resultado= $pxo;
		}elseif ($pxr > $original) {
			echo 'Envia Aviso de mayor recibido, bloquea la linea';
			$resultado = $pxr;
		}

		echo 'Valor de Data'.var_dump($data).'<p>';
		
		//break;
		return $resultado;
	}

}

?>


