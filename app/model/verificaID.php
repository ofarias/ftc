<?php 
require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';

class verificaIDs extends database{

	function verificarID($ids){
		$ctrid = new idpegaso;
		foreach ($ids as $data) {
			$rs=$ctrid->revisaDuplicado($data->ID);
			//var_dump($rs);
			$r_original = $rs['original'];
			$r_ordenado = $rs['ordenado'];
			$r_recibido = $rs['recibido'];
			$r_ordenadoPendiente = $r_ordenado - $r_recibido;
			$r_restante = $r_original - ($r_ordenadoPendiente + $r_recibido);
			$r_faltante = $r_original - $r_recibido;
			//echo '<br/>original: '.$r_original.' --> '.$data->CANT_ORIG.'<br/>';
			//echo 'ordenado: '.$r_ordenado.' --> '.$data->ORDENADO.'<br/>';
			//echo 'recibido: '.$r_recibido.' --> '.$data->RECEPCION.'<br/>';
			//echo 'restante: '.$r_restante.' --> '.$data->REST.'<br/>';
			//echo 'faltante: '.$r_faltante.' --> '.$data->REC_FALTANTE.'<br/>';
			if($r_original == $data->CANT_ORIG 
					AND $r_ordenado == $data->ORDENADO 
					AND $r_recibido == $data->RECEPCION 
					AND $r_restante == $data->REST and 
					$r_faltante == $data->REC_FALTANTE){
				$status = 'Ok';
			}else{
				$status = 'Revisar';
			}
			//echo '<font color:"red">'.$status.'</font><br/>';
			$this->query="INSERT INTO VERIFICACION (ID, IDPREOC, PR_ORIGINAL, PR_ORDENADO, PR_RESTANTE, PR_RECIBIDO, PR_FALTANTE, 
																	R_ORIGINAL, R_ORDENADO, R_RESTANTE, R_RECIBIDO, R_FALTANTE, STATUS)
								VALUES (null, $data->ID, $data->CANT_ORIG, $data->ORDENADO, $data->REST, $data->RECEPCION, $data->REC_FALTANTE,
																	$r_original, $r_ordenado, $r_restante, $r_recibido, $r_faltante, '$status')";
			$this->grabaBD();
			$this->query="UPDATE PREOC01 SET STATUS_VERIF = 0, FECHA_VERIF = CURRENt_timestamp where id = $data->ID";
		   $this->grabaBD();


		}
	}


	function revisionPOC($i, $f){
		$data=array();
		$verifica = array();
		$this->query = "SELECT * FROM PREOC01 WHERE ID BETWEEN $i and $f and status = 'X'";
		$res = $this->EjecutaQuerySimple();
		while ($tsArray = ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}
		//exit(var_dump($data));
		if(count($data)> 0){
			foreach ($data as $key) {
				$id = $key->ID; 
				$original = $key->CANT_ORIG;
				$ordenado = $key->ORDENADO;
				$recibido = $key->RECEPCION; 
				$restante = $key->REST;
				$canti = $key->CANTI;
				echo 'Se analiza el id: '.$id.' Original: '.$original.' ordenado: '.$ordenado.' recibido: '.$recibido.' restante: '.$restante.' canti '.$canti.'<br/>';
				
				$this->query = "SELECT sum(pxr) as preoc FROM FTC_POC_DETALLE WHERE IDPREOC = $id";
				$rs=$this->EjecutaQuerySimple();
				$row=ibase_fetch_object($rs);
				
				if($row->PREOC == 0 ){
					$this->query ="UPDATE PREOC01 SET STATUS = 'N' WHERE ID = $id";
					$this->queryActualiza();
					echo 'Error: '.$id.' Original: '.$original.' ordenado: '.$ordenado.' recibido: '.$recibido.' restante: '.$restante.' canti '.$canti.'<br/>';
				}else{
					$this->query="SELECT * FROM FTC_POC_DETALLE WHERE IDPREOC = $id and pxr > 0 ";
					$res=$this->EjecutaQuerySimple();
					while ($tsArray = ibase_fetch_object($res)) {
						$data3[]=$tsArray;
					}
					foreach ($data3 as $key2){
						echo 'Se encontraron Preordenes del id: '.$id.' en la Preorden: '.$key2->CVE_DOC.' pendientes'.$key2->PXR.'<br/>';
					}
					unset($data3);
				}	
			}	
		}
		return $verifica;
	}

} ?>

