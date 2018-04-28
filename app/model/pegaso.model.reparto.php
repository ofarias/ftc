<?php 
	require_once('app/model/database.mysql.php');
	require_once('app/model/pegaso.model.php');

class pegaso_rep extends databasemysql{

	function ingresaQR($datos){
		$this->query=$datos;
		$rs=$this->grabaBD();
		return;
	}

	function obtenerQR($qr){
		$usuario = $_SESSION['user']->NOMBRE;
		$this->query="SELECT * FROM FTC_CTR_QR where QR= '$qr'";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray = mysqli_fetch_array($rs)){
			$data[]=$tsArray;
		}
		/*
		$this->query="INSERT INTO FTC_CTR_QR (iddoc,tipo,qr, fch_crea, usr_crea, status)
							values (31325, 1, 'ASA', current_timestamp, '$usuario', 0)";
		$this->grabaBD();
		$this->query="UPDATE FTC_CTR_QR SET IDDOC = 99883 WHERE iddoc = 31325";
		$rs=$this->queryActualiza();
		*/
		return $data;
	}

	function buscaQR($qr){
		$row=array();
		/*$qr=explode("Ñ", strtoupper($qr));
		if(count($qr)<7){
			$qr=explode(':', $qr);
		}*/
		$codigo=strtolower(substr($qr, 80, 32));

		$this->query="SELECT * FROM FTC_CTR_QR WHERE QR = '$codigo'";
		$rs=$this->EjecutaQuerySimple();
		$row = mysqli_fetch_array($rs);
		
		$log = new pegaso;
		$datos = $log->ObtenerDatos($row);
		//echo $this->query;
		if(count($row)){
			$response=array("status"=>'ok', "documento"=>$datos['documento'],'documentos'=>$datos['documentos']);	
		}else{
			$response=array("status"=>'no', "documento"=>'0');
		}
		return $response;
	}

	function ingresaLogReparto($datos){

		$this->query="INSERT INTO Viajes (CLIENTE, UNIDAD, NOMBRE, CALLENOEXT, COLONIA, CIUDAD, TELEFONO, EMAIL, OBSERVACIONES, CAJA, MONTO, STATUS, STATUSAVISO,DOCUMENTO) VALUES ('$datos[0]', '$datos[1]','$datos[2]', '$datos[3]', '$datos[4]', '$datos[5]', '$datos[6]', '$datos[7]', '$datos[8]',$datos[9],0,0, $datos[10],'$datos[11]')";
		$this->grabaBD();
		//echo $this->query;
		$this->query="SELECT MAX(IDVIAJES) AS IDVIAJES FROM Viajes";
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=mysqli_fetch_array($res)) {
			$data=$tsArray;
		}
		$idviaje = $data[0];
		return $idviaje;

	}

	function ingresaLogRepartoDetalle($datos){
		$this->query="INSERT INTO detalle_documentos (IDVIAJE, DOCUMENTO, PARTIDA, CANTIDAD, DESCRIPCION, UNITARIO, SUBTOTAL, STATUSL)
							VALUES($datos[0], '$datos[1]', $datos[2], $datos[3], '$datos[4]', $datos[5], $datos[6], 0)";
		$this->grabaBD();
		return;
	}

	function asignaUnidad($datos){

		if($datos[0]=='admon'){
			$this->query="UPDATE Viajes set STATUS = 1 where CAJA = $datos[1]";
			$rs=$this->EjecutaQuerySimple();
		}else{
			$this->query="UPDATE Viajes set UNIDAD = '$datos[0]' where CAJA = $datos[1]";
			$rs=$this->EjecutaQuerySimple();
		}
		
		return;
	}


}?>