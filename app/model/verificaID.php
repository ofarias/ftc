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



} ?>

