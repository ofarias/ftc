<?php
require_once 'app/model/database.php';
require_once('app/views/unit/commonts/numbertoletter.php');

class data_serv extends database {

		function tickets(){
			$data= array();
			$actual = date("d-m-Y");
			$hoy = date("d-m-Y", strtotime($actual."- 7 days"));
			echo 'Hoy menos 7 dias: '.$hoy;
			$this->query = "SELECT * FROM FTC_SERVICIOS WHERE FECHA >= '$hoy'";
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

		function traeUsuarios(){
			$data= array();
			$this->query="SELECT u.*, '('||cl.nombre||')' as cliente FROM FTC_USUARIOS_SERV u left join clie01 cl on cl.clave_trim = u.empresa where tipo = 'Cliente'";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;	
		}

		function autoEquipos(){
			$data= array();
			$this->query="SELECT * FROM FTC_SER";
			$res=$this->EjecutaQuerySimple();
			while ($tsArray=ibase_fetch_object($res)) {
				$data[]=$tsArray;
			}
			return $data;
		}		

}