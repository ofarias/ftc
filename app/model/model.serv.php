<?php
require_once 'app/model/database.php';
require_once('app/views/unit/commonts/numbertoletter.php');

class data_serv extends database {

		function tickets(){
			$data= array();
			$actual = date("d.m.Y");
			$hoy = date("d.m.Y", strtotime($actual."- 7 days"));
			//echo 'Hoy menos 7 dias: '.$hoy;
			$this->query = "SELECT FS.*, CL.NOMBRE AS NOMBRE_CLIENTE, FU.NOMBRE||' '||FU.PATERNO AS NOMBRE_USUARIO_REP, 
							FE.NOMBRE_AD AS DESC_EQUIPO
							FROM FTC_SERVICIOS FS
								LEFT JOIN CLIE01 CL ON CL.CLAVE_TRIM = FS.CLIENTE
								LEFT JOIN FTC_SERV_USUARIOS FU ON FU.ID = FS.USUARIO
								LEFT JOIN FTC_SERV_EQUIPOS FE ON FE.ID = FS.EQUIPO
							WHERE FECHA between '$hoy' and current_date + 1";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray = ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}

		function traeClientes(){
			$data= array();
			$this->query="SELECT * FROM CLIE01";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}

		function traeModos(){
			$data= array();
			$this->query="SELECT * FROM FTC_SERV_MODOREP";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}

		function traeUsuarios($clie){
			$val = !empty($clie)? " AND U.EMPRESA = ".$clie:'';
			$data= array();
			$this->query="SELECT u.*, '('||cl.nombre||')' as cliente FROM FTC_SERV_USUARIOS u left join clie01 cl on cl.clave_trim = u.empresa where tipo = 'Cliente' $val";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;	
		}

		function nuevoUsuario($cliente, $nombre, $segundo, $paterno, $materno, $correo, $telefono, $extension, $cargo){
			$usuario = $_SESSION['user']->NOMBRE;
			$this->query = "INSERT INTO FTC_SERV_USUARIOS (ID, NOMBRE, SEGUNDO, PATERNO, MATERNO, EMPRESA, CARGO, TIPO, STATUS, CORREO, CELULAR, EXTENSION, FECHA_ALTA, USUARIO_ALTA) VALUES (NULL, '$nombre', '$segundo', '$paterno', '$materno', $cliente , '$cargo', 'Cliente', 'Alta', '$correo', '$telefono', '$extension', current_timestamp, '$usuario')";
			if($this->grabaBD()){
				return array("status"=>'ok', "mensaje"=>'Se ha creado el usuario');
			}else{
				return array("status"=>'no', "mensaje"=>'El usuario no se ha podido crear');
			}
		}

		function traeEquipos($clie){
			$val = !empty($clie)? " where FE.CLIENTE = ".$clie:'';
			$data= array();
			$this->query="SELECT FE.*, CL.NOMBRE AS NOMBRE_CLIENTE, (FU.NOMBRE||' '||FU.SEGUNDO||' '||FU.PATERNO||' '||FU.MATERNO) AS NOMBRE_USUARIO,
				P.NOMBRE_COMERCIAL AS NOMBRE_PROCESADOR, 
				M.NOMBRE_COMERCIAL AS NOMBRE_MARCA, 
				FS.NOMBRE_COMERCIAL AS NOMBRE_SO, 
				CAST(FE.OBS AS VARCHAR(3000)) AS OBSERVACIONES
				FROM FTC_SERV_EQUIPOS FE 
				LEFT JOIN CLIE01 CL ON CL.CLAVE_TRIM = FE.CLIENTE
				LEFT JOIN FTC_SERV_USUARIOS FU ON FU.ID = FE.USUARIO
				LEFT JOIN FTC_SERV_PROCESADORES P ON P.IDPRO = FE.PROCESADOR
				LEFT JOIN MARCAS M ON M.ID = FE.MARCA
				LEFT JOIN FTC_SERV_SISTEMA FS ON FS.IDSO = FE.SO $val";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}		

		function traeProcesadores(){
			$data= array();
			$this->query="SELECT * FROM FTC_SERV_PROCESADORES";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}

		function traeSistemas(){
			$data= array();
			$this->query="SELECT * FROM FTC_SERV_SISTEMA";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;	
		}

		function traeTipos(){
			$data= array();
			$this->query="SELECT * FROM FTC_SERV_TIPO";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;		
		}

		function nuevoEquipo($cliente,$usuario,$equipo,$ad_name,$marca,$modelo,$procesador,$so,$dom,$senia,$hdd_inst,$dd_principal,$mem_inst,$mem_max,$t_memoria,$ns,$correo,$tv,$tvc,$t_ip,$ip,$mac,$rdp,$area,$anio,$eth,$obs){

			$this->query = "SELECT * FROM FTC_SERV_EQUIPOS WHERE NS = '$ns'";
			$res = $this->EjecutaQuerySimple();
			$row = ibase_fetch_object($res);
			if(empty($row->NS)){
				$this->query = "INSERT INTO FTC_SERV_EQUIPOS (ID,CLIENTE,USUARIO,TIPO,NOMBRE_AD,MARCA,MODELO,PROCESADOR,SO,HDD_CAPACIDAD,TIPO_HDD,MEMORIA_TIPO,MEMORIA_C_I,MEMORIA_C_T, NS, CUENTA_CORREO, TEAMVIEWER, CONTRASENIA_TV, CONTRASENIA, DOMINIO, TIPO_IP, MAC_ADDRESS, PUERTO_RDP, IP, FECHA_ALTA, USUARIO_ALTA, AREA, ANIO, PUERTOS_ETH, OBS) 
						VALUES (null, '$cliente','$usuario','$equipo','$ad_name','$marca','$modelo',$procesador,$so,'$hdd_inst','$dd_principal','$t_memoria','$mem_inst','$mem_max', '$ns','$correo','$tv','$tvc','$senia', '$dom','$t_ip','$mac', '$rdp', '$ip',  current_timestamp, '$usuario', '$area', '$anio','$eth','$obs')";
				$this->grabaBD();	
				return array("status"=>'ok', "mensaje"=>'Se ha insertado el equipo correctamente');
			}else{
				return array('status' => 'no' , "mensaje"=>'El Numero de serie ya existe' );
			}
			return;
		}

		function creaTicket($cliente, $reporta, $usuario, $equipo, $fecha, $tipo, $sistema, $corta, $completa, $solucion, $modo, $cierre){
			$cierre = $cierre =='g'? "null":"current_timestamp";
			$status = $cierre =='g'? 1:2;
			$usr = $_SESSION['user']->NOMBRE;
			$this->query="INSERT INTO FTC_SERVICIOS (ID, CLIENTE, USUARIO_REPORTA, FECHA, DESC_CORTA, DESC_COMPLETA, SOLUCION, ESTIMADO, TERCERO, HORA_INICIAL, HORA_FINAL, EQUIPO, USUARIO, STATUS, FECHA_CIERRE, SISTEMA, TIPO, FECHA_REPORTE, MODO_REPORTE, ASISTENTES, USUARIO_REGISTRA) 
					VALUES (NULL, '$cliente', $reporta, current_timestamp, '$corta', '$completa', '$solucion', 0, 0, null, null, $equipo, $usuario, $status, $cierre, $sistema, $tipo, '$fecha', $modo, 0, '$usr') RETURNING ID";
			if($res=$this->grabaBD()){
				$row=ibase_fetch_object($res);
				$this->query = "SELECT * FROM ticket WHERE ID = $row->ID";
				$r = $this->EjecutaQuerySimple();
				$info=ibase_fetch_object($r);
				return array("status"=>'ok', "mensaje" => 'Se ha creado correctamente el Ticket No'.$row->ID, "info"=>$info);
			}else{
				return array("status"=>'no', "mensaje" => 'Ocurrio un mensaje al crear el Ticket, favor de revisar la informacion o reportarlo');
			}
		}

		function verDetalleTicket($id){
			$this->query="SELECT * FROM Ticket WHERE ID = $id";
			$rs=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($rs)) {
				$data[]=$tsArray;
			}
			return $data;
		}
}