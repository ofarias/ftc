<?php 
require_once 'app/model/database.php';
/*Clase para hacer uso de database*/
class idpegaso extends database{
	
	function revisaDuplicado($idpreoc){
		$this->query="SELECT * FROM PREOC01 WHERE ID = $idpreoc";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$original = $row->CANT_ORIG;
		/*
		$this->query="SELECT sum(pxr) AS PXR FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc group by ID_PREOC";
		$rs1=$this->EjecutaQuerySimple();
		$parcomp = ibase_fetch_object($rs1);
		$ordenado = $parcomp->PXR; 
		*/
						$pendientesOC = 0;
						$pendientesFTC = 0;
						$canval = 0;
						$canvalFTC = 0;
						$cantAsigPend=0;
						$cantAsigDir = 0;
						$recibo = 0;
						$empacado = 0;

						/// Obtenemos los productos pedidos que estan pendientes de recibirce.
						$this->query="SELECT iif(sum(PXR) is null , 0, sum(PXR)) as pendientesOC FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc and pxr > 0 ";   //0
						$rs=$this->EjecutaQuerySimple();
						$rowp=ibase_fetch_object($rs);
						if(!empty($rowp->PENDIENTESOC)){
							$pendientesOC=$rowp->PENDIENTESOC;
						}

						//// Obtenemos los productos que estan pendientes en una Orden de Compra del sistema de Pegaso.   
						$this->query="SELECT iif(sum(PXR) is null, 0 , sum(PXR)) as pendientes from FTC_POC_DETALLE WHERE IDPREOC = $idpreoc and pxr > 0";
						$rs=$this->EjecutaQuerySimple();
						$rowf=ibase_fetch_object($rs);
						/// 2
						if(!empty($rowf->PENDIENTES)){
							$pendientesFTC = $rowf->PENDIENTES;		
						}    
						//// Obtenemps los productos que ya se han validado.
						$this->query="SELECT iif(max(CANT_ACUMULADA) is null, 0, max(CANT_ACUMULADA)) as CantVal FROM VALIDA_RECEPCION WHERE ID_PREOC = $idpreoc ";
						///0
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						if(!empty($row2->CANTVAL)){
							$canval = $row2->CANTVAL;	
						}
						/*
						$this->query="SELECT iif(max(CANTIDAD_REC) is null, 0, max(CANTIDAD_REC)) as CantVal FROM FTC_DETALLE_RECEPCIONES WHERE IDPREOC = $idpreoc ";
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						if(isset($row2)){
							$canvalFTC = $row2->CANTVAL;
						}
						*/
						$this->query="SELECT SUM(ASIGNADO) AS CANTASIGPEND from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 7";
						$rs = $this->EjecutaQuerySimple();
						$row3 = ibase_fetch_object($rs);
						if(!empty($row3->CANTASIGPEND)){
							$cantAsigPend =$row3->CANTASIGPEND;	
						}
						//$this->query="SELECT SUM(RECIBIDO) AS CANTASIGREC from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 2";
						//$rs = $this->EjecutaQuerySimple();
						//$row4 = ibase_fetch_object($rs);
						//$cantAsigRec =$row4->CANTASIGREC;

						$this->query="SELECT SUM(ASIGNADO) AS CANTASIGDIR from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 0";
						$rs = $this->EjecutaQuerySimple();
						$row5 = ibase_fetch_object($rs);
						if(!empty($row5->CANTASIGDIR)){
							$cantAsigDir =$row5->CANTASIGDIR;	
						}
						/// 3 > 4     -----   0 + 180 + 0  + 0

						//echo 'Recibo Antes de la consulta: '.$recibo.'<br/>';
						$this->query="SELECT SUM(CANTIDAD_rec) as CANTIDAD_REC FROM FTC_DETALLE_RECEPCIONES WHERE IDPREOC = $idpreoc ";
						$rs2=$this->EjecutaQuerySimple();
						$rec = ibase_fetch_object($rs2);
						//var_dump($rec).'<br/>';
						if(!empty($rec->CANTIDAD_REC)){
							$recibo = $rec->CANTIDAD_REC;	
						}

						$this->query="SELECT SUM(CANTIDAD) AS EMPACADO FROM PAQUETES WHERE ID_PREOC = $idpreoc";
						$result = $this->EjecutaQuerySimple();
						$emp = ibase_fetch_object($result);
						if(!empty($emp->EMPACADO)){
							$empacado = $emp->EMPACADO;	
						}
						//echo 'Consulta -->'.$this->query.'<br/>';
						//echo 'Recibo despues de la consulta: '.$recibo.'<br/>';

						//echo 'Pendientes en OC : -->'.$pendientesOC.'<br/>';
						//echo 'pendientesFTC : -->'.$pendientesFTC.'<br/>';
						//echo 'Cantidad Asignada: -->'.$cantAsigDir.'<br/>';
						//echo 'Cantidad Asignada pend-->'.$cantAsigPend.'<br/>';


				$recibido = $recibo;
				$ordenado = $pendientesOC + $pendientesFTC +  $cantAsigPend + $cantAsigDir;
				$pxr = $original - $recibo;
				$pxo = $original - ($recibido + $ordenado);
				$ordenado2 = ($recibido + $ordenado);	


						/// aqui podemos meter una funcion para colocar lo recibido y que no se haya registrado, ya que las unicas recepciones que debe de haber son desde FTC_DETALLE_RECEPCIONES y las ASIGNACION_BODEGA_PREOC.

						//$this->query="UPDATE PREOC01 SET RECEPCION = $recibido, rec_faltante = CANT_ORIG - $recibido where id = $idpreoc";
						//$this->grabaBD();

	
		// esta mal -.... solo sirve para saber lo ordenado y lo pendiente, pero no para validar la liberacion.

		/*
		if($pxo < 0){
			echo 'Envia un aviso, bloquea la linea y manda reporte ';
			$resultado= $pxo;
		}elseif ($recibido > $original) {
			echo 'Envia Aviso de mayor recibido, bloquea la linea';
			$resultado = $pxr;
		}
		*/
		/// Manejo de status para las Ordenes de compra.
		if($original == $ordenado2){
			$status = 'B';
		}elseif ($original > $ordenado2) {
			$status = 'N';
		}elseif ($original < $ordenado2) {
			$status = 'X';
		}
		//break;
		return array("ordenado"=>$ordenado2, "recibido"=>$recibido, "pendiente"=>$pxo, "original"=>$original, "status"=>$status, "ID"=>$idpreoc,"empacado"=>$empacado);
	}

}

?>