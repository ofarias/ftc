<?php

require_once 'app/model/database.php';
require_once 'app/model/class.ctrid.php';

/*Clase para hacer uso de database*/
class pegaso extends database{
	/*Comprueba datos de login*/
	function AccesoLogin($user, $pass){
		$u = $user;
			$this->query = "SELECT USER_LOGIN, USER_PASS, USER_ROL, LETRA, LETRA2, LETRA3, LETRA4, LETRA5, LETRA6, NUMERO_LETRAS, NOMBRE, CC, CR, aux_comp, COORDINADOR_COMP
						FROM PG_USERS 
						WHERE USER_LOGIN = '$u' and USER_PASS = '$pass' and user_status = 'alta'"; /*Contraseña va encriptada con MD5*/
		 	$log = $this->QueryObtieneDatos();
			if(count($log) > 0){
				/*Creamos variable de sesion*/
					$_SESSION['user'] = $log;
					//var_dump($_SESSION['user']);
					return $_SESSION['user'];				
			}else{
				return 0;
			}
	}

	function cambioSenia($nuevaSenia, $actual, $usuario){
		$this->query="SELECT IIF(USER_PASS IS NULL, 0, USER_PASS) AS PASSWORD, IIF(ID IS NULL, 0 , ID) AS ID FROM PG_USERS WHERE USER_LOGIN = '$usuario'";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$pass = $row->PASSWORD;
		$id=$row->ID;
		if( $pass == $actual){
			$this->query="UPDATE PG_USERS SET user_pass = '$nuevaSenia' where id = $id";
			$this->EjecutaQuerySimple();
		}
		return;
	}
///// Lista los pedidos PENDIENTES.
	function LPedidos(){
		$l = $_SESSION['user']->LETRA;
		$l2 = $_SESSION['user']->LETRA2;
		$l3 = $_SESSION['user']->LETRA3;
		$l4 = $_SESSION['user']->LETRA4;
		$l5 = $_SESSION['user']->LETRA5;
		$l6 = $_SESSION['user']->LETRA6;
		$n = $_SESSION['user']->NUMERO_LETRAS;
		if ($n==1){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where status_ventas = 'Pe' and (letra_v = '$l') group by cotiza";  
        }elseif($n==2){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where  status_ventas = 'Pe' and (letra_v = '$l' or letra_v = '$l2')
                          group by cotiza";
        }elseif($n==3){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where  status_ventas = 'Pe' and (letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3)' 
                          group by cotiza";

        }elseif($n==5){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where status_ventas = 'Pe' AND (letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5') 
                          group by cotiza";

        }elseif($n==6){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where status_ventas = 'Pe' AND (letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5' or letra_v = '$l6') 
                          group by cotiza";

        }elseif($n==99){
        $this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where status_ventas = 'Pe'
                          group by cotiza";
	
        }
                          //status_ventas is null or (status_ventas ='') and '
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result)>0){
			while ( $tsArray = $this->FetchAs($result))
				$data[]=$tsArray;
		
				return $data;
		}	
	return 0;
	}



	/// LISTA TODOS LOS PEDIDOS.

	function LPedidosTodos(){
		
		$l = $_SESSION['user']->LETRA;
		$l2 = $_SESSION['user']->LETRA2;
		$l3 = $_SESSION['user']->LETRA3;
		$l4 = $_SESSION['user']->LETRA4;
		$l5 = $_SESSION['user']->LETRA5;
		$n = $_SESSION['user']->NUMERO_LETRAS;

		if ($n == 1){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where letra_v = '$l' 
                          group by cotiza";
                          echo $l." ".$n;
        }elseif($n == 2){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where letra_v = '$l' or letra_v = '$l2' 
                          group by cotiza";
                          echo $l;
        
        }elseif($n == 3){
		$this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' 
                          group by cotiza";
                          echo $l;
        }elseif($n==5){
        $this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5' 
                          group by cotiza";      
        }elseif($n==6){
        $this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5' or letra_v = '$l6' 
                          group by cotiza";      
        }elseif($n==99){ $this ->query = " SELECT cotiza, max(nom_cli) as cliente,max (urgente) as urgente, max(fechasol) as fecha, sum (cant_orig) as piezas, sum(ordenado) as Ordenado, count (prod) as productos, MAX(current_timestamp) as HOY, MAX(datediff(day, fechasol, current_date )) as Dias, MAX(FACTURA) as factura, max (importe) as importe
                          from preoc01 a
                          group by cotiza";      
        }
                          //status_ventas is null or (status_ventas ='') and '
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result)>0){
			while ( $tsArray = $this->FetchAs($result))
				$data[]=$tsArray;
		
				return $data;
		}	
	return 0;	
	}
	/*consulta para mostrar los componentes dados de alta*/
	function MuestraComp(){
		$this->query = "SELECT a.ID, a.SEG_NOMBRE, a.SEG_DURACION, a.SEG_TIPO, a.USUARIO, a.FECHAR_CREACION, a.FECHA_MODIFICACION, a.STATUS
						FROM PG_SEGCOMP a 
						WHERE status = 'alta' ORDER BY a.SEG_NOMBRE ASC";
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
		}
		
		return 0;
	}

	//// Inicia el Detalle del Pedido.

	function CabeceraPedidoDoc($doc){

		$this->query = "SELECT a.CVE_DOC, b.nombre, a.fechaelab, a.can_tot, a.importe, current_timestamp as Hoy, datediff(day,a.fecha_doc, current_date ) as Dias
						from factp01 a left join clie01 b on a.cve_clpv = b.clave where cve_doc = '$doc'";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}


	function LoginA($user, $pass){
		session_cache_limiter('private_no_expire');
		$data = new pegaso;
			$rs = $data->AccesoLogin($user, $pass);
			//var_dump($rs);
				if(count($rs) > 0){					
					$r = $data->CompruebaRol($user);
					//var_dump($r);
					switch ($r->USER_ROL){
						case 'administrador':
						$this->MenuAdmin();
						break;
						case 'administracion':
						$this->MenuAd();
						break;
						case 'usuario':
						$this->MenuUsuario();
						break;
						case 'ventas':
						$this->MenuVentas();
						break;
						case 'compras':
						$this->MenuCompras();
						break;
						case 'recepcion':
						$this->MenuRecep();
						break;
						default:
						$e = "Error en acceso 1, favor de revisar usuario y/o contraseña";
						header('Location: index.php?action=login&e='.urlencode($e)); exit;
						break;
						}
					/*if($r->USER_ROL == 'administrador'){ /*Cambio el fetch_assoc cambia la forma en acceder al dato
						$this->MenuAdmin();
					}elseif($r->USER_ROL == 'administracion'){
						$this->MenuAd();
					}elseif($r->USER_ROL == 'usuario'){
						$this->MenuUsuario();
					}else{
						
						
					}*/
				}else{
					$e = "Error en acceso 2, favor de revisar usuario y/o contraseña";
						header('Location: index.php?action=login&e='.urlencode($e)); exit;
				}
	}

	function DetallePedidoDoc($doc){

			$this->query = "SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc as factura, d.fechaelab as fecha_fac, d.importe, e.cve_doc as remision, e.fechaelab as Fecha_rem, f.tp_tes, f.ruta, f.unidad
                from preoc01 a
                left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
                left join compo01 f on b.cve_doc = f.cve_doc
                left join par_compr01 c on b.cve_doc = c.doc_ant and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                left join factr01 e on a.cotiza = e.doc_ant and e.status <> 'C'
                where cotiza = '$doc'";
		$result = $this->QueryObtieneDatosN();

		$result = $this->QueryObtieneDatosN();
			
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}


	/// INICIA la Orden de compra, Cabecera y Detalles.
	function CabeceraDoc($doc){
		$this->query = "select a.CVE_DOC, b.nombre, a.fechaelab, a.can_tot, a.importe, current_timestamp as Hoy, datediff(day,a.fecha_doc, current_date ) as Dias
						from compo01 a left join PROV01 b on a.cve_clpv = b.clave where cve_doc =  '$doc'";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}

	/// Detalles del documento

	function DetalleDoc($doc){
		$this->query = "SELECT a.cve_art, b.descr, a.num_par, a.cant, a.pxr, a.cost, a.uni_venta, a.num_alm, a.tot_partida, a.doc_recep, a.doc_recep_status, a.fecha_doc_recep
						from par_compo01 a 
						left join inve01 b on a.cve_art = b.cve_art 
						where cve_doc = '$doc'";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}


	

	/// Asigna la Unidad o Asigna Ruta.
		
	function ARuta(){
		$this->query="SELECT iif(a.docs is null, 'No', a.docs) as DOCS, a.cve_doc, b.nombre, a.fecha_pago, a.pago_tes, a.tp_tes, a.pago_entregado, c.camplib2 , a.unidad, a.estado, a.fechaelab, (datediff(day, a.fechaelab, current_date )) as Dias, a.urgencia, b.codigo, b.estado as estadoprov, a.vueltas
					    from compo01 a
						left join prov01 b on a.cve_clpv = b.clave
						left join compo_clib01 c on a.cve_doc = c.clave_doc
						where a.status <> 'C' AND status_log = 'Nuevo' and tp_tes is not Null ";

		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
		/// Codigo para anexar las nuevas Ordenes de Compra:
		$this->query="SELECT iif(ftc.docs is null, 'No', ftc.docs) as DOCS, ftc.OC AS cve_doc, p.nombre, ftc.fecha_pago, ftc.pago_tes, ftc.tp_tes, '' as pago_entregado, ftc.tipo as camplib2, ftc.unidad, '' as estado, ftc.fecha_oc as fechaelab, datediff(day, ftc.fecha_oc, current_date) as dias, '' as urgencia, p.codigo, p.estado as estadoprov, ftc.vueltas 
			from ftc_poc ftc
			left join prov01 p on ftc.cve_prov = p.clave 
			where (ftc.status ='PAGADA' or ftc.status = 'LOGISTICA') 
			and ftc.status_log = 'Nuevo' and tp_tes is not null   and fecha_entrega <= current_date";
  
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}



		return $data;
	}

         
    function InsertaNUnidad($numero, $marca, $modelo, $placas, $operador, $tipo, $tipo2, $coordinador){
                //$idu = $this->obtieneidu();
		//$iduf = $idu + 1;
		$this->query = "INSERT INTO unidades (NUMERO, MARCA, MODELO, PLACAS, OPERADOR, TIPO, TIPO2, COORDINADOR)
                                VALUES ('$numero', '$marca', '$modelo', '$placas', '$operador','$tipo', '$tipo2', '$coordinador')";
		$rs = $this->EjecutaQuerySimple();
		//echo $rs;
		//unset($iduf);
		return $rs;
    }     
	function altaunidades1($numero, $marca, $modelo, $placas, $operador, $tipo){
		$idu = $this->obtieneidu();
		$iduf = $idu + 1;
		$this->query = "INSERT INTO unidades (IDU, NUMERO, MARCA, MODELO, PLACAS, OPERADO, TIPO) 					VALUES ($idu, '$numero', '$marca', '$modelo', '$placas', '$operador','$tipo')";
				$rs = $this->EjecutaQuerySimple();
		//echo $rs;
		unset($iduf);
		return $rs;
	}

	function EliminaUnidad($idu){
		$this->query = "DELETE FROM unidades WHERE IDU = $idu";
				$rs = $this->EjecutaQuerySimple();
		//echo $rs;
		unset($iduf);
		return $rs;
	}

	function obtieneidu(){
		$this->query="SELECT count(*) FROM unidades";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					return $tsArray->COUNT;		
			}
				
	}
	
	function GuardaPagoCorrecto($cuentaban, $docu, $tipop, $monto, $nomprov, $cveclpv, $fechadoc){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$usuario= $_SESSION['user']->NOMBRE;
		if(substr($docu, 0,1) == 'O' and strlen($docu)>=7){
			$this->query="UPDATE compo01
					  SET TP_TES = '$tipop', PAGO_TES = $monto, FECHA_PAGO = '$HOY', STATUS_PAGO = 'PP'
					  WHERE Trim(CVE_DOC) = trim('$docu')";
		}elseif(substr($docu, 0,1) == 'O' and strlen($docu)<7){

			$this->query="UPDATE FTC_POC_DETALLE set status_real = 'LOGISTICA 1' where OC = '$docu'";
			$this->EjecutaQuerySimple();

			$this->query="UPDATE ftc_poc
					  SET TP_TES = '$tipop', PAGO_TES = $monto, FECHA_PAGO = '$HOY', STATUS = 'PAGADA'
					  WHERE Trim(OC) = trim('$docu')";

		}elseif(substr($docu, 0,1 !='O')){
			echo 'El pago es de una solicitud';
			$this->query="UPDATE SOLICITUD_PAGO
						SET TP_TES_FINAL='$tipop' , MONTO_FINAL=$monto, BANCO_FINAL = '$cuentaban', fecha_reg_pago_final = current_date, fecha_pago = current_timestamp, status = 'Pagado', usuario_pago = '$usuario'
						where idsol =$docu";
			$rs = $this->EjecutaQuerySimple();
			$this->query="SELECT MAX(FOLIO) as FOLIO FROM SOLICITUD_PAGO WHERE TP_TES_FINAL ='$tipop'";
			$res=$this->QueryObtieneDatosN();
			$row = ibase_fetch_object($res);
			$folioNuevo = $row->FOLIO + 1;
			$this->query = "UPDATE SOLICITUD_PAGO SET FOLIO = $folioNuevo where idsol = $docu";
			$result = $this->EjecutaQuerySimple();
			return $rs;
		}else{
				$this->query="UPDATE compR01
					  SET TP_TES = '$tipop', PAGO_TES = $monto, FECHA_PAGO = '$HOY', STATUS_PAGO = 'PP'
					  WHERE Trim(CVE_DOC) = trim('$docu')";
		}
		$rs = $this->EjecutaQuerySimple();
		
		$rs+= $this->ActPagoParOC($docu, $tipop, $monto, $nomprov, $cveclpv, $fechadoc, $cuentaban);
		
		$rs += $this->GuardaCuentaBan($docu, $cuentaban);
		
		return $rs;
	}

	function GuardaCuentaBan($docu, $cuentaban){
		$this->query = "INSERT INTO 
							pg_pagoBanco
							(documento, cuenta, Banco)
						VALUES
							('$docu', '$cuentaban',TRIM(SUBSTRING('$cuentaban' from 1 for 8)))";
		$rs = $this->EjecutaQuerySimple();
	}
	/// Insertar Pagos a tablas P_CHEQUES
	function ActPagoParOC($docu, $tipop, $monto, $nomprov, $cveclpv, $fechadoc, $cuentaban){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$iva = $monto - ($monto / 1.16);
		$usuario = $_SESSION['user']->NOMBRE;

		//echo 'Tipo: '.$tipop.'<p>';
		if($tipop == 'ch'){
		$query="INSERT INTO P_CHEQUES (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, CHEQUE, USUARIO_PAGO, BANCO) VALUES (";
		$query .=" '".$tipop."',";
		$query .=" '".$fechadoc."',";
		$query .=" '".$monto."',";
		$query .=" '".$nomprov."',";
		$query .=" '".$iva."',";
		$query .=" '".$docu."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpv."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0',";
		$query .=" '$usuario',";
		$query .=" '$cuentaban'";
		$query .=")"; 
		//echo $query;
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();

		}elseif ($tipop == 'tr') {
		
		//echo 'Es de transfer: <p>';

		$query="INSERT INTO P_TRANS (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, TRANS, USUARIO_PAGO, BANCO) VALUES (";
		$query .=" '".$tipop."',";
		$query .=" '".$fechadoc."',";
		$query .=" '".$monto."',";
		$query .=" '".$nomprov."',";
		$query .=" '".$iva."',";
		$query .=" '".$docu."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpv."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0',";
		$query .=" '$usuario',";
		$query .=" '$cuentaban'";
		$query .=")";
		//echo $query; 
		$this->query =$query;
		//echo 'Consulta para ingresar la nueva transfer:'.$this->query.'<p>';
		//break;
		$rs = $this->EjecutaQuerySimple();	
		}elseif($tipop == 'cr'){
		$query="INSERT INTO P_CREDITO (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, CREDITO) VALUES (";
		$query .=" '".$tipop."',";
		$query .=" '".$fechadoc."',";
		$query .=" '".$monto."',";
		$query .=" '".$nomprov."',";
		$query .=" '".$iva."',";
		$query .=" '".$docu."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpv."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0'";
		$query .=")";
		//echo $query; 
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();
		}elseif($tipop == 'e'){
		$query="INSERT INTO P_EFECTIVO (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, EFECTIVO, USUARIO_PAGO, BANCO) VALUES (";
		$query .=" '".$tipop."',";
		$query .=" '".$fechadoc."',";
		$query .=" '".$monto."',";
		$query .=" '".$nomprov."',";
		$query .=" '".$iva."',";
		$query .=" '".$docu."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpv."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0',";
		$query .=" '$usuario',";
		$query .=" '$cuentaban'";
		$query .=")";
		//Secho $query; 
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();
		}
	}

  


	function TraeUnidades(){
		$this->query="SELECT numero 
						FROM unidades";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}
	
	
	function detallePago($documento){
		$data=array();	

		
		if(substr($documento, 0,1) != 'O'){
				$this->query=" SELECT s.idsol as cve_doc, p.nombre, s.monto as importe, s.fechaelab, s.fecha as fecha_doc, 'Contrarecibos' as Recepcion, 'NA' as enlazado, s.tipo as TipoPagoR, 'NA' as FER, 'NA' as TE, usuario as Confirmado, s.tipo as PagoTesoreria, 'NA' as pago_tes
								from SOLICITUD_PAGO s
								left join prov01 p on s.proveedor = p.clave
								where idsol = $documento";
		}elseif(substr($documento, 0,1) == 'O' and strlen($documento) >= 7 ){
			echo 'Entro a COMPO01';
				$this->query="	SELECT a.cve_doc, b.nombre, a.importe, a.fechaelab, a.fecha_doc, doc_sig as Recepcion, a.enlazado, c.camplib1 as TipoPagoR, c.camplib3 as FER,c.camplib2 as TE, c.camplib4 as Confirmado, a.tp_tes as PagoTesoreria, a.pago_tes, pago_entregado, c.camplib6, a.cve_clpv, a.URGENTE, datediff(day, a.fechaelab, current_date ) as Dias 
						from compo01 a
						left join Prov01 b on a.cve_clpv = b.clave
						LEFT JOIN compo_clib01 c on a.cve_doc = c.clave_doc
						where cve_doc = '$documento'";
		}else{
				$this->query="SELECT ftcpoc.OC AS CVE_DOC, p.nombre, ftcpoc.costo_total as importe, ftcpoc.fecha_oc as fechaelab, 'Ver Documentos' as Recepcion, 'NA' as enlazado, 'p.tipo_pago' as tipopagoR, 'NA' as fer, 'NA' as TE, ftcpoc.usuario_oc as confirmado, 'Tipo' as PagoTesoreria, 'NA' as pago_entregado, 'NA' as camplib6, ftcpoc.cve_prov as cve_clpv, 'NA' as urgente, 'NA' as DIAS, 
		        	(select iif(sum(lp.cantidad * poc.cost )is null, 0 , sum(lp.cantidad * poc.cost)) FROM LIB_PARTIDAS lp left join par_compo01 poc on poc.cve_doc = lp.oc and poc.num_par = lp.partida_oc WHERE PROVEEDOR = p.clave group by Proveedor) as saldoprov    	
        			from FTC_POC ftcpoc 
   				    left join prov01 p on p.clave = ftcpoc.cve_prov
    			    where oc='$documento'";
        			//echo $this->query;
		}

		
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;				
			}
				

		
		return $data;

	}

	function CompruebaRol($user){
		$this->query = "SELECT USER_ROL FROM PG_USERS WHERE USER_LOGIN = '$user'";/*Falta Tabla*/
		 $log = $this->QueryObtieneDatos();
			if(count($log) > 0){
				return $log;
			}else{
				return 0;
			}
			
	}
		
	function ObtieneReg(){
		$this->query = "SELECT COUNT(*)
  						FROM PG_USERS";
						
		$r = $this->QueryObtieneDatos();
		
		return	$r;
	}
	
	function ObtieneRegSC(){
		$this->query = "SELECT COUNT(*)
  						FROM PG_SEGCOMP";
						
		$r = $this->QueryObtieneDatos();
		
		return	$r;
	}
	
	function AsignadosComp(){
		$this->query = "SELECT CVE_DOC, CVE_CLPV, IMPORTE, ID_SEG, STATUS_FACT 
						FROM FACTF01
						WHERE STATUS_FACT = 'a'";
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
		}
		
		return 0;
	}
	
	function NuevoUser($usuario, $contra, $email, $rol, $letra){
		//$fecha = date('m-d-Y'); /*Fechas en firebird siempre comienzan con MM/DD/AAAA*/
		$u = strtolower($usuario);
		$e = strtolower($email);
		//echo $fecha;
		$this->query = "INSERT INTO PG_USERS (user_login, user_pass, user_email, user_registro, user_status, user_rol, letra) VALUES ('$u', '$contra', '$e', current_date, 'alta', '$rol', '$letra')";
		$rs = $this->EjecutaQuerySimple();
		echo $this->query;
		//break;
		return $rs;
	}		
	
	/*###################################Cambios de OFA###################################*/
	
	// INSERTA LAS PARTIDAS DE LA ORDEN DE COMPRA
	function NuevaPartidaOrdenCompra($Doc, $IdPreoco, $Rest, $Prod, $Cantidad, $Costo, $unimed, $facconv, $cveuser) {
		//echo $partida ="<br/>".$CVE_DOC."<br/>".$TOTAL."<br/>".$TIME."<br/>HOY=".$HOY."<br/>".$IdPreoco."<br/>".$Consecutivo."<br/>".$Doc."<br/>".$Prod."<br/>".$Costo."<br/>".$unimed."<br/>".$facconv."<br/>".$Cantidad."<br/>".$Rest."<br/>".$consecutivo2;		
		$Costoa = $Costo;
		$nuevoRest=$Rest-$Cantidad;		
		if($nuevoRest<=0){ 
			$status='B';
		}else{ 
			$status='N';
		}
		$totalPartida = $Cantidad * $Costo;	
		if($Rest==NULL || $Rest==''){ 
			$Rest=0; 
		}
	    
		$a =" UPDATE PREOC01 set status='".$status."', rest='".$nuevoRest."'  WHERE ID= $IdPreoco ";
		//echo "Actualiza Pre Orden de compra: $a";
		
		$this->query = $a;
		$rs = $this->EjecutaQuerySimple();

		$consultPartMAX  =" SELECT COUNT(NUM_PAR) as FOLIO FROM PAR_COMPO01 WHERE CVE_DOC_REAL='".$Doc."'";
              // echo "sql: $consultPartMAX";
		$this->query = $consultPartMAX;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
               //echo "row: ".$row->FOLIO;
               $COD = $row->FOLIO;
               $COD = $COD+1;
		$CVEDOCCOMPUESTO=$Doc.'000'.$COD;
		
		$partida =" INSERT INTO PAR_COMPO01 (CVE_DOC, NUM_PAR, CVE_ART,CANT, PXR, PREC, COST, IMPU1,IMPU2, IMPU3, IMPU4, IMP1APLA,";
		$partida .=" IMP2APLA, IMP3APLA, IMP4APLA,TOTIMP1, TOTIMP2, TOTIMP3, TOTIMP4,DESCU, ACT_INV, TIP_CAM, UNI_VENTA,TIPO_ELEM, TIPO_PROD, CVE_OBS, E_LTPD,";
		$partida .=" REG_SERIE, FACTCONV, COST_DEV, NUM_ALM,MINDIRECTO, NUM_MOV, TOT_PARTIDA,CVE_DOC_REAL, ID_PREOC, USUARIO_PHP) VALUES (";
		$partida .=" '".$Doc."',"; 
		$partida .=" ".$COD.", ";
		$partida .=" '".$Prod."',";
		$partida .=" ".$Cantidad." ,";
		$partida .=" ".$Cantidad." ,";
		$partida .=" 99, ";
		$partida .=" ".$Costoa.", ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 16, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 'N', ";
		$partida .=" 1, ";
		$partida .=" '".$unimed."', ";
		$partida .=" 'N', ";
		$partida .=" 'P', ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" 0, ";
		$partida .=" ".$facconv.", ";
		$partida .=" NULL, ";
		$partida .=" 95, ";
		$partida .=" NULL,"; 
		$partida .=" NULL, ";
		$partida .=" '".$totalPartida."',";
		$partida .=" '".$Doc."',";
		$partida .=" '".$IdPreoco."',"; 
		$partida .=" '".$cveuser."')";
		
		$this->query = $partida;
		$s = $this->EjecutaQuerySimple();
			
		//echo $this->query;
		//break;

		$consultPart  =" SELECT SUM(TOT_PARTIDA) TOT FROM PAR_COMPO01 WHERE CVE_DOC_REAL='".$Doc."' ";
		$this->query = $consultPart;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
    	$SUMATOTALPARTIDAS= $row->TOT;

    	$urgente = "SELECT URGENTE from PREOC01 where id = '".$IdPreoco."'";
    	$this->query = $urgente;
    	$result = $this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($result);
    	$urgentes = $row->URGENTE;

    	if ($urgentes == 'U'){
			$esurgente = "UPDATE COMPO01 SET URGENTE = 'U' WHERE CVE_DOC ='".$Doc."'";
    		$this->query = $esurgente;
    		$result = $this->EjecutaQuerySimple();    		
    	}

	}	
	
	//INSERTA ORDEN DE COMPRA
	//function NuevoOrdComp($PROVEEDOR,$CVE_DOC,$TOTAL,$TIME,$HOY,$IdPreoco,$Consecutivo,$Doc,$Prod,$Costo,$unimed,$facconv,$Cantidad,$Rest){
	function NuevoOrdComp($PROVEEDOR,$CVE_DOC,$TOTAL,$TIME,$HOY,$Doc){
	
		$Control=$PROVEEDOR.'A';

		$consultFOLIO  =" SELECT MAX(folio) FOLIO  FROM COMPO01";
		$this->query = $consultFOLIO;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
    	$FOLIO= $row->FOLIO;
    	$FOL=$FOLIO+1;
  		//echo "folio=".$FOL;
  		//echo "CVE_DOC=".$CVE_DOC;
    	$cveuser= $_SESSION['user']->USER_LOGIN;
        $nombre = "SELECT NOMBRE FROM PG_USERS WHERE User_login = '$cveuser'";
        $this->query=$nombre;
        $result = $this->EjecutaQuerySimple();
        $row=ibase_fetch_object($result);
        $NOM_USUARIO = $row->NOMBRE;

    	$PEDID=substr($CVE_DOC,0,2);
        //echo "PEDIDO=".$PEDID;

        $NUEVACVEDOC = $PEDID.$FOL;    		
    	$HOYY        = date("Y-m-d");
    	//list($day,$mon,$year) = explode('-',$HOYY);
    	//$oldDate =date('d-m-Y',mktime(0,0,0,$mon,$day+30,$year));
		//$arr = explode('-', $oldDate);
		//$newDate30 = $arr[2].'-'.$arr[1].'-'.$arr[0];
    	$PROVV=trim($PROVEEDOR);
		$pp=str_pad($PROVV, 10, " ", STR_PAD_LEFT);

		$cabecera  =" INSERT INTO COMPO01 (";
		$cabecera  .="	 TIP_DOC, CVE_DOC, CVE_CLPV, STATUS,";
		$cabecera  .="	 SU_REFER, FECHA_DOC, FECHA_REC, FECHA_PAG,";
		$cabecera  .="	 FECHA_CANCELA, CAN_TOT,";
		$cabecera  .="	 IMP_TOT1, IMP_TOT2, IMP_TOT3, IMP_TOT4,";
		$cabecera  .="	 DES_TOT, DES_FIN, TOT_IND,";
		$cabecera  .="	 OBS_COND, CVE_OBS, NUM_ALMA, ACT_CXP, ACT_COI,";
		$cabecera  .="	 NUM_MONED, TIPCAMB, ENLAZADO, TIP_DOC_E, NUM_PAGOS,";
		$cabecera  .="	 FECHAELAB, SERIE, FOLIO, CTLPOL, ESCFD, CONTADO, BLOQ,";
		$cabecera  .="	 DES_FIN_PORC, DES_TOT_PORC, IMPORTE, TIP_DOC_ANT,";
		$cabecera  .="	 DOC_ANT, TIP_DOC_SIG, DOC_SIG, FORMAENVIO,CONTROL, STATUS_LOG, REALIZA)";
	 	$cabecera  .="	VALUES ( ";
		$cabecera  .="	'o', ";
		$cabecera  .="	'".$NUEVACVEDOC."', ";
		$cabecera  .="	'".$pp."',"; 
		$cabecera  .="	'O', ";
		$cabecera  .="	'', ";
		$cabecera  .="	'".$HOYY."', ";
		$cabecera  .="	'".$HOYY."', ";
		$cabecera  .="	'".$HOYY."', "; //mas 30 dias $nuevafecha = strtotime ( '+1 day' , strtotime ($fechaFFase ) ) ;
		$cabecera  .="	NULL, ";
		//$cabecera  .="	".$SUMATOTALPARTIDAS.", "; //cantidad total suma
		$cabecera  .="	'22', "; //cantidad total suma
		$cabecera  .="	0, ";
		$cabecera  .="	0, ";
		$cabecera  .="	0, ";
		$cabecera  .="	2, "; //totaliva
		$cabecera  .="	0, ";
		$cabecera  .="	0, ";
		$cabecera  .="	0, ";
		$cabecera  .="	'', ";
		$cabecera  .="	0, ";
		$cabecera  .="	95, ";
		$cabecera  .="	'S', ";
		$cabecera  .="	'N', ";
		$cabecera  .="	1, ";
		$cabecera  .="	1, ";
		$cabecera  .="	'O',"; 
		$cabecera  .="	'O', ";
		$cabecera  .="	NULL,"; 
		$cabecera  .="	'".$HOY."', ";
		$cabecera  .="	'OZ', "; //rest 
		//$cabecera  .="	'".$Consecutivo."', ";
		$cabecera  .="	'".$FOL."', ";
		$cabecera  .="	0, ";
		$cabecera  .="	'N', ";
		$cabecera  .="	'N', ";
		$cabecera  .="	'N', ";
		$cabecera  .="	0, ";
		$cabecera  .="	0, ";
		$cabecera  .="	0, "; //suma total
		$cabecera  .="	'', ";
		$cabecera  .="	'', ";
		$cabecera  .="	NULL, ";
		$cabecera  .="	NULL, ";
		$cabecera  .="	NULL, ";
		$cabecera  .="	'".$Control."',";
		$cabecera  .="  'Nuevo',";
		$cabecera  .="	'".$NOM_USUARIO."'";
		$cabecera  .="	) ";
		//echo $cabecera;
		$this->query = $cabecera;
		$rs = $this->EjecutaQuerySimple();		

		$paga      = " INSERT INTO PAGA_M01 (";
		$paga     .= " CVE_PROV, REFER, NUM_CARGO, NUM_CPTO, CVE_FOLIO, CVE_OBS, NO_FACTURA,";
		$paga     .= " DOCTO, IMPORTE, FECHA_APLI, FECHA_VENC, AFEC_COI, NUM_MONED, TCAMBIO,"; 
		$paga     .= " IMPMON_EXT, FECHAELAB, CTLPOL, TIPO_MOV, CVE_BITA, SIGNO, CVE_AUT, ";
		$paga     .= " USUARIO, ENTREGADA, FECHA_ENTREGA, REF_SIST, STATUS)";
		$paga     .= " VALUES (";
		$paga     .= " '".$PROVEEDOR."',";
		$paga     .= " '".$NUEVACVEDOC."',";
		$paga     .= " 1,24,'',0,";
		$paga     .= " '".$NUEVACVEDOC."',";
		$paga     .= " '".$NUEVACVEDOC."',";
		$paga     .= " ".$TOTAL.",";
		$paga     .= " '".$HOYY."',";
		$paga     .= " '".$HOYY."', ";
		$paga     .= " '', 1, 1, ";
		$paga     .= " ".$TOTAL.",";
		$paga     .= " '".$HOYY."',";
		$paga     .= " 0, 'C', 0, 1, 0, 0, '',";
		$paga     .= " '".$HOYY."',";
		$paga     .= " '', 'A')";
		$this->query = $paga;
		$s = $this->EjecutaQuerySimple();

        //$a=" UPDATE PREOC01 set status=Ω".$status."', rest='".$nuevoRest."'  WHERE ID= $IdPreoco ";
		//$this->query = $a;
		//$rs = $this->EjecutaQuerySimple();

		return $NUEVACVEDOC;

	}	
	// actualiza totales en orden de compra
       function actualizaTotalPaga($proveedor, $documento, $importe){
           
           $query = "UPDATE PAGA_M01 SET IMPORTE = $importe WHERE DOCTO = '$documento' AND CVE_PROV = '$proveedor';";
           //echo "query: $query";
           $this->query = $query;
           $result = $this->EjecutaQuerySimple();
           if(count($result) > 0){
               return 1;
           }else{
               return 0;
           }
           
       }
	// actualiza totales en orden de compra
       function actualizaTotalOrdenCompra($documento, $cantidad, $impuesto, $importe){

       		$cantidad = $importe;
       		$importe = $impuesto + $importe;
           
           $query = "UPDATE COMPO01 SET CAN_TOT = $cantidad, IMP_TOT4 = $impuesto, IMPORTE = $importe WHERE CVE_DOC = '$documento'";
           //echo "query: $query";
           $this->query = $query;
           $result = $this->EjecutaQuerySimple();
           if(count($result) > 0){
               return 1;
           }else{
               return 0;
           }
           
       }
	
	//ORDEN DE COMPRA
	function ConsultaOrdenComp($id){
		
		$this->query = "SELECT p.id, p.fechasol, p.fecha_auto, p.cotiza, p.par, p.status, p.prod, p.nomprod, p.canti, p.cant_orig, p.costo, p.prove, p.nom_prov, p.total, p.rest, p.docorigen, p.urgente, p.um, datediff(day, p.fechasol,current_date) as DIAS, p.costo_maximo, iif(fecharec is null, current_date, fecharec) as fecharec,
							  (select count(id) from LIB_PARTIDAS where idpreoc = p.id) as Liberaciones
							  from preoc01 p
							  WHERE status='N' and rest > 0 and rec_faltante > 0 ORDER BY  nom_prov  ASC ";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
			return $data;
		}
	

	// Listar partidas no recibidad

	function ListaPartidasNoRecibidas (){
		
		$this->query = "SELECT a.ID_PREOC, a.cve_doc, a.cve_art, ftc.nombre as camplib7, a.cant, a.pxr, c.nombre, a.fecha_doc_recep, a.doc_recep, a.DOC_RECEP_STATUS, a.vuelta, a.num_par, b.fechaelab
			from par_compo01 a
			left join compo01 b on a.cve_doc = b.cve_doc and b.status <> 'C'
			left join prov01 c on b.cve_clpv = c.clave
			left join PRODUCTO_FTC ftc on ftc.clave = a.cve_art 
			where pxr > 0 and a.status_log2 = 'Tesoreria'";

		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
		}
				return $data;
	}

	//ACTUALIZA actualizaPreOc
	function actualizaPreOc($provcostid,$provedor,$costo,$total,$nombreprovedor,$cantidad,$rest, $fe){

		$query = " UPDATE PREOC01 SET"; 
		$query .= " prove=$provedor,";
		$query .= " costo=$costo,"; 
		$query .= " total=$total,";
		$query .= " canti=$cantidad,";
		$query .= " nom_prov='$nombreprovedor',";
		$query .= " fecharec = '$fe'";
		$query .= " WHERE id=$provcostid ";
		$this->query = $query;

		print_r($this->query);
		//break;
		$result = $this->EjecutaQuerySimple();
			if(count($result) > 0){
			return 1;
		}else{
			return 0;
		}
	}
	//SABER SI EL PROVEEDOR EXISTE
	function valorPreOcProvedor($provedor){
		$query = " SELECT NOMBRE FROM PROV01 WHERE"; 
		$query .= " CLAVE=$provedor ";
		$query .= " AND STATUS='A' ";
		$this->query = $query;
		$result = $this->EjecutaQuerySimple();
			while ($row = ibase_fetch_object($result)) {
    				$nom= $row->NOMBRE;
    			return $nom;
			}
	}
 
	//SABER SI EL UNI_MED DEL ARTICULO EXISTE
	function valorArticulo($Prod){
		//unset($$_SESSION["unimed"]);
		$query = " SELECT uni_med,fac_conv FROM INVE01 WHERE"; 
		$query .= " cve_art='".$Prod."' ";
		$query .= " AND STATUS='A' ";

		$this->query = $query;
		$result = $this->EjecutaQuerySimple();
			while ($row = ibase_fetch_object($result)) {
    				$nom= $row->UNI_MED;
    				$fac= $row->FAC_CONV;
    			return $nom.'|'.$fac;
			}
	}	
	/*############################Cambios de OFA####################################*/	
	

	//// Consulta donde muesta la informacion de los pedidos, desde la pagina de Buscar Pedidos, primer parte es la cabecera
	function ConsultaPreoc($pre){
		$l = $_SESSION['user']->LETRA;
		$u = $_SESSION['user']->USER_LOGIN;
		$n = $_SESSION['user']->NUMERO_LETRAS;

		if($n<99){
		$this->query = "SELECT a.*, FACTURAS as factura, b.fechaelab as fecha_fac, c.cve_doc as remision, c.fechaelab as fecha_rem
						FROM preoc01 a
						left join factf01 b on a.cotiza = b.doc_ant
						left join factp01 c on a.cotiza = c.doc_ant
						WHERE cotiza = '".strtoupper($pre)."'";
		}elseif($n==99){
		$this->query = "SELECT a.*, Facturas as factura, b.fechaelab as fecha_fac, c.cve_doc as remision, c.fechaelab as fecha_rem
						FROM preoc01 a
						left join factf01 b on a.cotiza = b.doc_ant
						left join factp01 c on a.cotiza = c.doc_ant
						WHERE cotiza = '".strtoupper($pre)."'";			
		}		
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}
	
	/// Segunda parte de Buscar Pedidos Detalle del pedido.
	function ConsultaMov($mov){
		$l = $_SESSION['user']->LETRA;
		$u = $_SESSION['user']->USER_LOGIN;
		$n = $_SESSION['user']->NUMERO_LETRAS;
		if($n==1){
		$this->query = "SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, 
						b.cve_doc as Orden_de_Compra, b.CANT as CANT_SOLICITADA, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, 
						c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe, e.fechaelab as fecha_oc, f.fechaelab as fecha_r, 
						e.tp_tes, e.ruta, e.unidad, e.fecha_secuencia, e.status_log, e.cant_rec
            	from preoc01 a
            	left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            	left join compo01 e on b.cve_doc = e.cve_doc
            	left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
            	left join compr01 f on c.cve_doc = f.cve_doc
            	left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C' 
				WHERE COTIZA = ('".strtoupper($mov)."')";
				//var_dump($this->query);
		}elseif($n>1){
		$this->query = "SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, 
						b.cve_doc as Orden_de_Compra, b.CANT as CANT_SOLICITADA, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, 
						c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe, e.fechaelab as fecha_oc, f.fechaelab as fecha_r,
						e.tp_tes, e.ruta, e.unidad, e.fecha_secuencia, e.status_log, e.cant_rec
            	from preoc01 a
            	left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            	left join compo01 e on b.cve_doc = e.cve_doc
            	left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
            	left join compr01 f on c.cve_doc = f.cve_doc
            	left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C' 
				WHERE COTIZA ='".strtoupper($mov)."'";	
		}
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
			}
				return $data;
	}


	function InsertaCompo($nombre, $duracion, $tipo, $usuario){
		//$usuario = $_SESSION['user']; antes de insertar tomar el ultimo valor de id sumarle 1 e insertar
		$user = $_SESSION['user']["USER_LOGIN"];
		//print_r($user);
		$fecha = date('d-m-Y');
		$rs = $this->ObtieneRegSC();
		$id = (int) $rs["COUNT"] + 1;
		$this->query = "INSERT INTO PG_SEGCOMP VALUES ($id, '$nombre', '$duracion', '$tipo', '$user', '$fecha', '$fecha', 'alta')";
		$result = $this->EjecutaQuerySimple();
		//print_r($result);
		return $result;
	}
	
	function ConsultaProd(){
		$this->query ="SELECT a.cve_art, e.clave ,e.nombre as Proveedor, c.exist, d.costo, b.camplib7 as Nombre, b.camplib1 as Marca, c.cve_alm as Almacen, b.camplib8 as Categoria, 
						b.camplib2 as modelo, b.camplib3 as division, b.camplib4 as piezas, b.camplib9 as subcategoria, b.camplib10 as Codigo_Fabricante, b.camplib11 as Proveedor_Empaque, 
						b.camplib12 as Costo_x_Empaque, b.camplib13 as Unidad_de_Empaque, b.camplib14 as Piezas_por_empaque
						from inve01  a 
						left join inve_clib01 b on a.cve_art = b.cve_prod 
						left join mult01 c on a.cve_art = c.cve_art 
						left join prvprod01 d on a.cve_art = d.cve_art 
						left join prov01 e on d.cve_prov = e.clave 
						where c.cve_alm = '9'";
		
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
		}	
		return 0;
	}

	
    
    function VerPagadas(){
    	$this->query="SELECT * FROM compo01 where status_compra = 'Co'";
    	$result = $this->QueryObtieneDatosN();
    	while ($tsArray = ibase_fetch_object($result)){
    		$data[] = $tsArray;
    	}
    		return $data;
    }
	function Idproducto($id){

			$l = $_SESSION['user']->LETRA;
			$l2 = $_SESSION['user']->LETRA2;
			$l3 = $_SESSION['user']->LETRA3;
			$l4 = $_SESSION['user']->LETRA4;
			$l5 = $_SESSION['user']->LETRA5;
			$l6 = $_SESSION['user']->LETRA6;
			$n = $_SESSION['user']->NUMERO_LETRAS;
			switch ($id){
				case '1':
				echo $l;	
				echo $n;
				if ($n==1){

				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
            		from preoc01 a
            		left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            		 left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C
            		where letra_v = '$l'";            	
				}elseif($n==5){
					$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
            		from preoc01 a
            		left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            		 left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C
            		where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5'"; 

				}elseif($n==3){
					$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
            		from preoc01 a
            		left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            		 left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C
            		where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3'";
				}elseif($n==6){	
					$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
            		from preoc01 a
            		left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            		 left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C
            		where letra_v = '$l' or letra_v = '$l2' or letra_v = '$l3' or letra_v = '$l4' or letra_v = '$l5' or letra_v = '$l6";
				}elseif($n==2){
					$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
            		from preoc01 a
            		left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
            		left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                	left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
            		where letra_v = '$l' or letra_v = '$l2'";
			
				}

				break;


		  		case '19':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
                from preoc01 a
                left join par_compo01 b on a.id = b.id_preoc  and b.status <> 'C'
                left join par_compr01 c on b.doc_recep = c.cve_doc and a.id = c.id_preoc and c.status <> 'C'
                left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where a.status <> 'C'";
            	break;

		  		case '2':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PA'))) and a.status <> 'C'";
            	break;

		  		case '3':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PB'))) and a.status <> 'C'";

		  		case '4':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PC'))) and a.status <> 'C'";
            	break;

   		  		case '5':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PD'))) and a.status <> 'C'";
            	break;
            	

            	case '6':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PE')) OR (UPPER(COTIZA) CONTAINING UPPER('PS'))) and a.status <> 'C'";
            	break;

            	case '7':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PF'))) and a.status <> 'C'";
				break;
            	
            	case '8':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PG'))) and a.status <> 'C'";
            	break;
            	
            	case '9':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PH'))) and a.status <> 'C'";
            	break;

            	case '10':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PI'))) and a.status <> 'C'";
            	break;
            	
            	case '11':
		  		$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PJ'))) and a.status <> 'C'";
            	break;

            	case '12':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PK'))) and a.status <> 'C'";
            	break;

            	case '13':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PL'))) and a.status <> 'C'";
            	break;

            	case '14':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PM'))) and a.status <> 'C'";
            	break;

            	case '15':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
					where ((UPPER(COTIZA) CONTAINING UPPER('PN'))) and a.status <> 'C'";
            	break;

            	case '16':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PO'))) and a.status <> 'C'";
            	break;

            	case '17':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PQ'))) and a.status <> 'C'";
            	break;

            	case '18':
				$this->query ="SELECT a.id, a.cotiza as pedido, a.nom_cli, a.urgente, a.fact_ant, a.fechasol, a.prod, a.nomprod,  a.cant_orig , a.status, b.cve_doc as Orden_de_Compra, b.CANT as Cant_Solicitada, b.status, a.rest as Falta_Solicitar, c.cve_doc as Recepcion, c.cant as Cant_Recibida, a.REC_faltante, c.status , d.cve_doc, d.fechaelab, d.importe
					from preoc01 a
					left join par_compo01 b on a.id = b.id_preoc and b.status <> 'C'
					left join par_compr01 c on b.cve_doc = c.doc_ant and b.id_preoc = c.id_preoc and c.status <> 'C'
					left join factf01 d on  a.cotiza = d.doc_ant and d.status <> 'C'
                where ((UPPER(COTIZA) CONTAINING UPPER('PR'))) and a.status <> 'C'";
            	break;
}
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result)> 0){
				while ($tsArray = $this->FetchAs($result))
						$data[] = $tsArray;
					return $data;
		}
		return 0;
	}

	function PorFacturar(){	
        $this->query= "SELECT a.*, a.cve_fact as cotiza, cl.nombre as cliente, a.fecha_creacion, pe.fechaelab, datediff(day, a.fecha_creacion, current_date) as dias
        			   FROM CAJAS a 
        			   left join factp01 pe on pe.cve_doc = a.cve_fact
        			   left join clie01 cl on pe.cve_clpv = cl.clave 
        			   WHERE a.STATUS = 'cerrado' and a.factura ='' and a.remision =''";			
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result)> 0){
				while ($tsArray = $this->FetchAs($result))
						$data[] = $tsArray;
					return $data;
		}
		return 0;
	}

		function PorFacturarEntrega(){		//01072016

		$this->query="SELECT a.cotiza, 
		sum(rec_faltante) as Faltante, 
		MAX(NOM_CLI) AS NOM_CLI, 
		MAX (CLIEN) AS CLIEN, 
		max(c.codigo) as CODIGO, 
        MAX(b.doc_sig) as FACTURA, 
        max (a.fechasol) as FECHASOL, 
        max(b.importe) as IMPORTE, 
        max(datediff(day,b.FECHAELAB,current_date)) as DIAS,
        MAX(b.CITA) as CITA, 
        max(factura) as factura, 
        max(fecha_fact) as fecha_factu, 
        sum(a.recepcion) as recibido,  
        sum(a.empacado) as empacado, 
        max(f.fechaelab) as fecha_fact,
        sum(a.facturado) as facturado, 
        sum(a.remisionado) as remisionado, 
        sum(pendiente_facturar) as penfact, 
        sum(pendiente_remisionar) as penrem
                FROM preoc01 a
                LEFT JOIN FACTP01 b on a.cotiza = b.cve_doc
                LEFT JOIN CLIE01 c on b.cve_clpv = c.Clave
                left join factf01 f on f.cve_doc = a.factura 
                left join factr01 r on r.cve_doc = a.remision 
                where fechasol >= '01.08.2016'
                group by cotiza
                HAVING (SUM(REC_FALTANTE) = 0 
                and (sum(a.empacado) < sum(a.recepcion))  
                AND (sum(a.recepcion) = sum(a.cant_orig)))";
               /* and (max(f.fechaelab) > '01.08.2016' or max(r.fechaelab) > '01.07.2016')"; /*PENDIENTE*/
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
						$data[] = $tsArray;
				
		}
			return $data;
	}


	
	
	function ConsultaUsur(){		
		$this->query ="SELECT *
						FROM PG_USERS ";
		$result = $this->QueryObtieneDatosN();
			
		while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;			
		}
			return $data;
	}
	
	function ConsultaUsurEmail($email){
			$this->query ="SELECT a.ID, a.USER_LOGIN, a.USER_EMAIL, a.USER_STATUS, a.USER_ROL
							FROM PG_USERS a WHERE a.USER_EMAIL = '$email'";
		
		//unset($data);
		$result = $this->QueryObtieneDatos();
		//var_dump($result);
		//if($this->NumRows($result) > 0){			
			//while ( $tsArray = $result) {
				//echo "dentro del while";
				$data[] = $result;
			//}
			//var_dump($data);
				return $data;
				//unset($data1);
		//}
		
		return 0;
		}
	
	function ActualizaStatusSegdoc($compo){
		$this->query = "UPDATE PG_SEGDOC
						SET ESTATUS = 1
						WHERE ID = $compo";
		$result = $this->EjecutaQuerySimple();
		if(count($result) > 0){		
		$d = $this->ConsultaUsur();
		return $d;
	}else{
		return 0;
	}
		
	}
	
	function ActualizaFactf($factura, $compo){
		$this->query = "UPDATE FACTF01 
						SET STATUS_FACT = 'a', ID_SEG = '$compo'
						WHERE CVE_DOC = '$factura'";
		$result = $this->EjecutaQuerySimple();
		if(count($result) > 0){		
		$this->ActualizaStatusSegdoc($compo);
		return $result;
	}else{
		return 0;
	}
		
	}
	
	function ActualizaUsr($mail, $usuario, $contrasena, $email, $rol, $estatus){
	$this->query = "UPDATE PG_USERS 
						SET USER_LOGIN = '$usuario', USER_PASS = '$contrasena', USER_EMAIL = '$email', USER_ROL = '$rol', USER_STATUS = '$estatus'
						WHERE USER_EMAIL = '$mail'"; /*actualizamos datos y retornamos ConsultaUsur()*/
		
	$result = $this->EjecutaQuerySimple();
	//var_dump($result);
	if(count($result) > 0){		
		$d = $this->ConsultaUsur();
		return $d;
	}else{
		return 0;
	}
	}
	
	function ObtieneRegIC(){
		$this->query = "SELECT COUNT(*)
  						FROM PG_SEGDOC";
						
		$r = $this->QueryObtieneDatos();
		
		return	$r;
	}
	
	function InsertaComp($comp, $nombre, $desc){
		$rs = $this->ObtieneRegIC();
		$id = (int) $rs["COUNT"] + 1;
		//$i = 0;
		
		/*for($i = 0; $i = count($comp);$i++){
			if(isset($comp[$i])){$_ . $i = $comp[$i];}else{$_ . $i =  0;}
		}*/
		
		if(isset($comp[0])){$_1 = $comp[0];}else{$_1 =  0;}
		if(isset($comp[1])){$_2 = $comp[1];}else{$_2 =  0;}
		if(isset($comp[2])){$_3 = $comp[2];}else{$_3 =  0;}
		if(isset($comp[3])){$_4 = $comp[3];}else{$_4 =  0;}
		if(isset($comp[4])){$_5 = $comp[4];}else{$_5 =  0;}
		if(isset($comp[5])){$_6 = $comp[5];}else{$_6 =  0;}
		if(isset($comp[6])){$_7 = $comp[6];}else{$_7 =  0;}
		if(isset($comp[7])){$_8 = $comp[7];}else{$_8 =  0;}
		if(isset($comp[8])){$_9 = $comp[8];}else{$_9 =  0;}
		if(isset($comp[9])){$_10 = $comp[9];}else{$_10 =  0;}
		if(isset($comp[10])){$_11 = $comp[10];}else{$_11 =  0;}
		if(isset($comp[11])){$_12 = $comp[11];}else{$_12 =  0;}
		if(isset($comp[12])){$_13 = $comp[12];}else{$_13 =  0;}
		if(isset($comp[13])){$_14 = $comp[13];}else{$_14 =  0;}
		if(isset($comp[14])){$_15 = $comp[14];}else{$_15 =  0;}
		if(isset($comp[15])){$_16 = $comp[15];}else{$_16 =  0;}
		if(isset($comp[16])){$_17 = $comp[16];}else{$_17 =  0;}
		if(isset($comp[17])){$_18 = $comp[17];}else{$_18 =  0;}
		if(isset($comp[18])){$_19 = $comp[18];}else{$_19 =  0;}
		if(isset($comp[19])){$_20 = $comp[19];}else{$_20 =  0;}
		
		echo $this->query = "INSERT INTO PG_SEGDOC 
					VALUES ($id, '$nombre', '$desc', '$_1', '$_2', '$_3', '$_4', '$_5', 
					'$_6', '$_7', '$_8', '$_9', '$_10', '$_11', '$_12', '$_13', '$_14', '$_15', '$_16', '$_17', '$_18', 
					'$_19', '$_20')";
		//echo $this->query;
		//$result = $this->EjecutaQuerySimple();
		
		/*Cambia el status de los componentes*/
		//$cambia = 1;
		for($i = 1; $i <= 20; $i++){
			if($_ . $i != 0){
				$this->CambiaStatus($_ . $i);
			} 			
		}
		
		return $result;
			
	}

	function CambiaStatus($comp){
		$this->query = "UPDATE PG_SEGCOMP
						SET STATUS = 'baja''
						WHERE SEG_NOMBRE = '$comp'"; 
						
		//$result = $this->EjecutaQuerySimple();						
	}

	function CompruebaComp($nombre){
		$this->query = "SELECT SEG_NOMBRE FROM PG_SEGCOMP WHERE SEG_NOMBRE = '$nombre'";
		$result = $this->QueryObtieneDatos();
		return $result;
	}
	
	/*Funcion que obtiene los componentes existentes*/
	function ConsultaComp(){
		$this->query = "SELECT ID, SEG_NOMBRE 
						FROM PG_SEGCOMP 
						WHERE status = 'alta'";
						
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
				unset($data);
		}
		
		return 0;
				
	}
	
	/*metodo para mostrar facturas sin asignar*/
	function MuestraFact(){
		$this->query = "SELECT CVE_DOC, TIP_DOC, CVE_CLPV, STATUS, ID_SEG, STATUS_FACT
						FROM FACTF01 
						WHERE status != 'C' and STATUS_FACT is null";
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;
				return $data;
				unset($data);
		}
		
		return 0;
	}
	
	/*metodo para mostrar componentes disponibles para asignar*/
	function MuestraDisp(){
		$this->query = "SELECT a.ID, a.NOMBRE, a.DESCRIPCION, a.ESTATUS
						FROM PG_SEGDOC a
						WHERE a.ESTATUS is null";
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;
				return $data;
				unset($data);
		}
		
		return 0;
	}
	/*Consulta para mostrar los componentes asignados a una factura*/
	function ConsultaFac(){
		$this->query = "SELECT CVE_DOC, TIP_DOC, CVE_CLPV, STATUS, ID_SEG, STATUS_FACT
						FROM FACTF01 
						WHERE status != 'C' and STATUS_FACT = 'a'";
										
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;
				return $data;
				unset($data);
		}
		
		return 0;
	}

	function ConsultaFlu(){
		$this->query = "SELECT ID, NOMBRE FROM PG_SEGDOC
						WHERE ESTATUS != 1";
										
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
				unset($data);
		}
		
		return 0;
	}
    
    function insertaDocumentoXML($documento, $archivo, $archivoPDF, $emisorRFC, $emisorNombre, $receptorRFC, $receptorNombre, $fecha, $uuid, $importe) {
        $this->query = "INSERT INTO COMP_XML (RFC_E, NOMBRE_E, RFC_R, NOMBRE_R, FECHA_TIM, UUIDC, IMPORTE, ARCHIVO, PDF, OC)
                        VALUES ('$emisorRFC', '$emisorNombre', '$receptorRFC', '$receptorNombre', '$fecha', '$uuid', $importe, '$archivo', '$archivoPDF', '$documento')";
        $result = $this->EjecutaQuerySimple();


        $result+= $this->actualizaComprobado($documento, $importe);
        return $result>0;
    }

    function actualizaComprobado($documento, $total) {
        $porComprobar = 0;
        $this->query = "SELECT POR_COMPROBAR, COMPROBADO FROM compo01 WHERE CVE_DOC = '$documento'";
        $result = $this->EjecutaQuerySimple();
        while ($row =ibase_fetch_object($result)){
            $porComprobar = $row->POR_COMPROBAR;
            $comprobado = $row->COMPROBADO;
        }
        if ($porComprobar > $total) {
            $Comprobado = $comprobado + $total;
            $por_comprobar = $porComprobar - $total;
            $this->query = "UPDATE compo01 SET status_compra = 'Co', comprobado = $Comprobado, por_comprobar = $por_comprobar WHERE cve_doc = '$documento'";
        } elseif($porComprobar == $total){
            $comprobado = $porComprobar + $total;
            $this->query = "UPDATE compo01 SET status_compra = 'CC', comprobado = $comprobado, por_comprobar = $por_comprobar WHERE cve_doc = '$documento'";
        } else {
            return false;
        }
        echo $por_comprobar;
        $updated = $this->EjecutaQuerySimple();        
        $vuelta = count($updated);
        return $vuelta>0;
    }

	function validaEmisor($documento, $emisorRFC){
        $this->query = "SELECT a.cve_doc, b.nombre, b.rfc FROM compo01 a LEFT JOIN prov01 b on a.cve_clpv = b.clave WHERE cve_doc = '$documento' AND b.rfc = '$emisorRFC'";
        $result = $this->EjecutaQuerySimple();
        if ($this->NumRows($result) > 0) {            
            return true;
        }
        return false;
    }

    function verOrdenes(){
        $this->query = "SELECT a.cve_doc, a.enlazado, a.folio, a.status, a.fechaelab, datediff(day, a.fechaelab, current_date ) as Dias, can_tot, cve_clpv, Nombre, a.TP_TES, a.fecha_pago
						from compo01 a
						left join Prov01 b on a.cve_clpv = b.clave
						where a.enlazado <> 'T' and a.status <>'C'";
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] =$tsArray;
        }
        return $data;
    }

	function OC($doco){

		if(substr($doco,0,2 ) == 'OP'){	
			$this->query="SELECT ftcoc.oc as cve_doc, '' as enlazado, '' as folio, ftcoc.status, ftcoc.fecha_oc as fechaelab, datediff(day, ftcoc.fecha_oc, CURRENT_DATE) as dias, ftcoc.costo_total as can_tot, ftcoc.cve_prov  as cve_clpv, p.nombre, ftcoc.tp_tes_req as camplib2, ftcoc.tp_tes, ftcoc.pago_tes 
				from ftc_poc ftcoc 
				left join prov01 p on p.clave = ftcoc.cve_prov
				where oc = '$doco'";
		}else{
			$this->query = "SELECT a.cve_doc, a.enlazado, a.folio, a.status, a.fechaelab, datediff(day, a.fechaelab, current_date ) as Dias, can_tot, cve_clpv, Nombre, c.CAMPLIB2, a.tp_tes, a.pago_tes
						from 
						(compo01 a
						LEFT JOIN compo_clib01 c
						ON a.cve_doc = c.clave_doc)
						left join Prov01 b on a.cve_clpv = b.clave
						where a.cve_doc = '$doco'";
        	}
        	$result = $this->EjecutaQuerySimple();
		
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] =$tsArray;
        }
        return $data;
    }


     function detalleOC($doco){

     	if(strlen($doco)>= 7){
     		$this->query = "SELECT 1 as id, a.id_preoc, a.cve_doc, a.num_par, a.cve_art, b.descr,  a.cant, a.pxr, a.TOT_PARTIDA, a.status, a.recep, a.fecha_doc_recep, c.cotiza, a.num_par as partida, a.cve_art as art,
         	(select NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = a.CVE_ART) as descripcion,
          a.cant as cantidad, a.cost as costo, (a.cost * a.cant) as costo_total, b.uni_med as um, 'n/a' as CVE_PROD, a.id_preoc as idpreoc, c.nom_cli as cliente, c.cotiza as cotizacion, c.fechasol, c.cant_orig, a.CANT_RECIBIDA, a.status_val 
						from par_compo01 a
						left join inve01 b on a.cve_art = b.cve_art
						left join preoc01 c on a.id_preoc = c.id
						left join compo01 oc on oc.cve_doc = a.cve_doc
						where a.cve_doc = '$doco' and oc.status_recepcion <> 2";  	
     	}elseif(strlen($doco)<7){
     		$this->query = "SELECT 1 as id, a.idpreoc as id_Preoc, ftcpoc.oc as cve_doc, a.partida as num_par, a.partida, a.art as cve_art, a.art, a.idpreoc, b.descr,  a.cantidad as cant, a.pxr as pxr, a.COSTO_TOTAL, a.status, 'recepcion' as recep, ftcpoc.fecha_oc as fecha_doc_recep, c.cotiza,	(select NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = a.ART) as descripcion,
          a.cantidad as cantidad, a.costo as costo, (a.costo * a.cantidad) as costo_total, b.uni_med as um, 'n/a' as CVE_PROD, c.nom_cli as cliente, c.cotiza as cotizacion, c.fechasol, c.cant_orig, a.Cant_Recibida as CANT_RECIBIDA, a.status_val as status_val, a.costo_total as tot_partida 
						from FTC_POC_DETALLE a
						left join ftc_poc ftcpoc on ftcpoc.cve_doc = a.cve_doc
						left join inve01 b on a.art = b.cve_art
						left join preoc01 c on a.idpreoc = c.id
						left join ftc_poc o on o.cve_doc = a.cve_doc
						where ftcpoc.oc = '$doco' and o.status_recepcion <> 2";
				//echo $this->query;
     	}
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] =$tsArray;
        }
        return $data;
    }


    function OCL($doco){


    	if(strlen($doco)>=7){
    		$this->query = "SELECT a.cve_doc, a.enlazado, a.folio, a.status, a.fechaelab, datediff(day, a.fechaelab, current_date ) as Dias, can_tot, cve_clpv as cve_prov, Nombre, b.calle, b.numext, b.numint, b.colonia, b.codigo, b.municipio, b.telefono, c.camplib4, c.camplib2,  a.realiza, c.camplib3, d.str_obs, a.tp_tes, a.pago_tes, b.rfc, a.can_tot as costo, (a.can_tot * .16) as total_iva, (a.can_tot *1.16) as costo_total, b.diascred, b.codigo as cp, b.tp_efectivo, b.tp_cheque, b.tp_transferencia, b.tp_credito, b.cuenta, b.nom_banco
						from compo01 a
						left join Prov01 b on a.cve_clpv = b.clave
						left join COMPO_CLIB01 c on a.cve_doc = c.clave_doc
						left join  obs_docc01 d on a.cve_obs = d.cve_obs  
						where cve_doc = '$doco'";
    	}elseif(strlen($doco)<7){
			$this->query = "SELECT a.OC as cve_doc, 'NA' AS enlazado, a.oc as folio, a.status, a.fecha_oc as fechaelab, datediff(day, a.fecha_oc, current_date ) as Dias, a.costo_total as can_tot, a.cve_prov as cve_prov, Nombre, b.calle, b.numext, b.numint, b.colonia, b.codigo, b.municipio, b.telefono, c.camplib4, c.camplib2,  a.usuario_oc, c.camplib3, a.tp_tes, a.pago_tes, b.rfc, a.costo, a.total_iva, a.costo_total, b.diascred, b.codigo as cp, b.tp_efectivo, b.tp_cheque, b.tp_transferencia, b.tp_credito, b.cuenta, b.nom_banco, 'observaciones' as STR_OBS, a.usuario_oc as realiza
						from FTC_POC a
						left join Prov01 b on a.cve_prov = b.clave
						left join COMPO_CLIB01 c on a.cve_doc = c.clave_doc
						where OC = '$doco'";    		
    	}
    	//echo $this->query;
        
    	$result = $this->QueryObtieneDatosN();
    	while ($tsArray = ibase_fetch_object($result)){
    		$data[] = $tsArray;
    	}
    		return $data;
    }


    function detalleOC_Imp($doco){
    	if(strlen($doco)>= 7){
     		$this->query = "SELECT 1 as id, a.id_preoc, a.cve_doc, a.num_par, a.cve_art, b.descr,  a.cant, a.pxr, a.TOT_PARTIDA, a.status, a.recep, a.fecha_doc_recep, c.cotiza, a.num_par as partida, a.cve_art as art,
         	(select NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = a.CVE_ART) as descripcion,
          a.cant as cantidad, a.cost as costo, (a.cost * a.cant) as costo_total, b.uni_med as um, 'n/a' as CVE_PROD, a.id_preoc as idpreoc, c.nom_cli as cliente, c.cotiza as cotizacion, c.fechasol, c.cant_orig, a.CANT_RECIBIDA, a.status_val 
						from par_compo01 a
						left join inve01 b on a.cve_art = b.cve_art
						left join preoc01 c on a.id_preoc = c.id
						left join compo01 oc on oc.cve_doc = a.cve_doc
						where a.cve_doc = '$doco' ";  	
     	}elseif(strlen($doco)<7){
     		$this->query = "SELECT 1 as id, a.idpreoc as id_Preoc, ftcpoc.oc as cve_doc, a.partida as num_par, a.partida, a.art as cve_art, a.art, a.idpreoc, b.descr,  a.cantidad as cant, a.pxr as pxr, a.COSTO_TOTAL, a.status, 'recepcion' as recep, ftcpoc.fecha_oc as fecha_doc_recep, c.cotiza,	(select NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = a.ART) as descripcion,
          a.cantidad as cantidad, a.costo as costo, (a.costo * a.cantidad) as costo_total, b.uni_med as um, 'n/a' as CVE_PROD, c.nom_cli as cliente, c.cotiza as cotizacion, c.fechasol, c.cant_orig, a.Cant_Recibida as CANT_RECIBIDA, a.status_val as status_val, a.costo_total as tot_partida 
						from FTC_POC_DETALLE a
						left join ftc_poc ftcpoc on ftcpoc.cve_doc = a.cve_doc
						left join inve01 b on a.art = b.cve_art
						left join preoc01 c on a.idpreoc = c.id
						left join ftc_poc o on o.cve_doc = a.cve_doc
						where ftcpoc.oc = '$doco' ";
				//echo $this->query;
     	}
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] =$tsArray;
        }
        return $data;	
    }


    function idPreoc($idd){
    	$this->query = "SELECT id, COTIZA, prod, STATUS, cant_orig, ordenado, rest, recepcion, REC_faltante,status_ventas
    					FROM preoc01
    					where id = $idd";
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] = $tsArray;
        }
        return $data;
    }

    function idCompo($idd){
    	$this->query = "SELECT id_preoc, cve_doc, cve_art, cant, pxr, tot_partida, num_par
    					FROM par_compo01
    					where id_preoc = $idd";
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] = $tsArray;
        }
        return $data;
    }

    function idCompr($idd){
    	$this->query = "SELECT a.id_preoc, a.cve_art, a.cant, a.CVE_DOC, a.TOT_PARTIDA, a.NUM_PAR, b.DESCR, a.status, a.fecha_doc
    					FROM par_compr01 a
    					left join inve01 b on a.cve_art = b.cve_art
    					where id_preoc = $idd";
        $result = $this->EjecutaQuerySimple();
        while ($tsArray = ibase_fetch_object($result)){
        	$data[] = $tsArray;
        }
        return $data;
    }

    	///// BOTON  VER / IMPRIMIR COMPROBANTES.

	function verPagos(){
		$this->query="SELECT a.cve_doc, a.cve_clpv, b.nombre, a.importe, a.fechaelab, a.fecha_doc, doc_sig as Recepcion, a.enlazado,c.camplib1 as TipoPagoR, c.camplib3 as FER, c.camplib2 as TE, c.camplib4 as Confirmado, a.tp_tes as PagoTesoreria, a.pago_tes, pago_entregado, c.camplib6 
					from compo01 a 
					left join Prov01 b on a.cve_clpv = b.clave
					left join compo_clib01 c on a.cve_doc = c.clave_doc
					where a.status <> 'C' and TP_TES <> ''";
					$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;				
			}
				return $data;
	}

	function verEfectivos(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_EFECTIVO a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'N'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}


	function verCheques(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_CHEQUES a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'N'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}

	function verTrans(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_TRANS a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'N'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}

	function verCreditos(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_CREDITO a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'N'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}

	function verPXL(){
		$this->query="SELECT a.*, b.*, c.*
					  FROM factp01 a
					  LEFT JOIN clie01 b on a.cve_clpv = b.clave 
					  left join factp_clib01 c on a.cve_doc = c.clave_doc
					  where status2 is null and a.status <> 'C' ";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}
		return $data;
	}

	function liberaPedido($pedido){
		$this->query="UPDATE Preoc01 set Status = 'N', fecha_auto = current_timestamp where cotiza = '$pedido'";
		$result = $this->EjecutaQuerySimple();
		$result+= $this->actPedido($pedido);
			if (count($result) > 0){
				return 1;
			}else{
				return 0;
			}
	}

	function actPedido($pedido){
		$this->query="UPDATE factp01 set STATUS2 = 'L' where cve_doc = '$pedido'";
		$result = $this->EjecutaQuerySimple();
		if (count($result) > 0){
	   		return 1;   	
	   		}else{
	   			return 0;
	   		}
	}

	function GuardaPagoCorrectoOLD($docuOLD, $tipopOLD, $montoOLD, $nomprovOLD, $cveclpvOLD){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);


		$this->query="UPDATE compo01
					  SET TP_TES = '$tipopOLD', PAGO_TES = $montoOLD, FECHA_PAGO = '$HOY', STATUS_PAGO = 'PP'
					  WHERE CVE_DOC = '$docuOLD'";
		$rs = $this->EjecutaQuerySimple();
		$rs+= $this->ActPagoParOCOLD($docuOLD, $tipopOLD, $montoOLD, $nomprovOLD, $cveclpvOLD);
		echo $rs;
		return $rs;
	}

		function Pagos_OLD(){
		$this->query="	SELECT a.cve_doc, b.nombre, a.importe, a.fechaelab, a.fecha_doc, doc_sig as Recepcion, a.enlazado, c.camplib1 as TipoPagoR, c.camplib3 as FER,c.camplib2 as TE, c.camplib4 as Confirmado, a.tp_tes as PagoTesoreria, a.pago_tes, pago_entregado, c.camplib6, a.cve_clpv from compo01 a
						left join Prov01 b on a.cve_clpv = b.clave
						LEFT JOIN compo_clib01 c on a.cve_doc = c.clave_doc
						where a.fechaelab < '02/22/2016' and a.status <> 'C' and  TP_TES is null and (STATUS_PAGO = 'Ch' or STATUS_PAGO = 'CH')";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;				
			}
				return $data;
	}

	//// Insertar Pagos OLD

	function ActPagoParOCOLD($docuOLD, $tipopOLD, $montoOLD, $nomprovOLD, $cveclpvOLD){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$iva = $montoOLD - ($montoOLD / 1.16);

		if($tipopOLD == 'ch'){
		$query="INSERT INTO P_CHEQUES (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, CHEQUE) VALUES (";
		$query .=" '".$tipopOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$montoOLD."',";
		$query .=" '".$nomprovOLD."',";
		$query .=" '".$iva."',";
		$query .=" '".$docuOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpvOLD."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0'";
		$query .=")"; 
		//echo $query;		
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();
		

		}elseif ($tipopOLD == 'tr') {
		
		$query="INSERT INTO P_TRANS (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, TRANS) VALUES (";
		$query .=" '".$tipopOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$montoOLD."',";
		$query .=" '".$nomprovOLD."',";
		$query .=" '".$iva."',";
		$query .=" '".$docuOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpvOLD."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0'";
		$query .=")"; 
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();	
		}elseif($tipopOLD == 'cr'){
		$query="INSERT INTO P_CREDITO (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, CREDITO) VALUES (";
		$query .=" '".$tipopOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$montoOLD."',";
		$query .=" '".$nomprovOLD."',";
		$query .=" '".$iva."',";
		$query .=" '".$docuOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpvOLD."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0'";
		$query .=")"; 
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();
		}elseif($tipopOLD == 'e'){
		$query="INSERT INTO P_EFECTIVO (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, EFECTIVO) VALUES (";
		$query .=" '".$tipopOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$montoOLD."',";
		$query .=" '".$nomprovOLD."',";
		$query .=" '".$iva."',";
		$query .=" '".$docuOLD."',";
		$query .=" '".$HOY."',";
		$query .=" '".$cveclpvOLD."',";
		$query .=" 'N',";
		$query .=" '".$HOY."',";
		$query .=" '".$HOY."',";
		$query .=" '0'";
		$query .=")"; 
		$this->query =$query;
		$rs = $this->EjecutaQuerySimple();
		}
	}

		/*obtiene datos para imprimir*/
	function ObtieneDatosTrans($id){
		$this->query="SELECT a.*, b.CLABE, b.BANCO
					  FROM p_trans a
					  left join Prov01 b on a.cve_prov = b.clave
					  WHERE id = $id";
		$res = $this->QueryObtieneDatos();
		if(count($res) > 0){
				return $res;
		}
		return 0;
	}

	function ObtieneDatosOc($oc){
		$this->query="SELECT a.*, b.CLABE, b.BANCO
					  FROM p_trans a
					  left join Prov01 b on a.cve_prov = b.clave
					  WHERE id = $id";
		$res = $this->QueryObtieneDatos();
		if(count($res) > 0){
				return $res;
		}
		return 0;
	}

	function ActStatusImpresoTrans($id){
		$this->query= "UPDATE P_TRANS 
					   set STATUS = 'I' 
					   where id = '$id'";
		$res = $this->EjecutaQuerySimple();		
	}

	function ActRuta($id, $doc){
		
		if(strlen($doc) >=7){
			$this->query="UPDATE COMPO01 set RUTA = 'N'  where cve_doc = '$doc'";	
		}else{
			$this->query="UPDATE FTC_POC SET RUTA = 'N' where cve_doc = '$doc'";
		}
		$res = $this->EjecutaQuerySimple();
	}

	function ObtieneDatosEfectivo($id){
		$this->query="SELECT * 
					  FROM P_EFECTIVO 
					  WHERE id = $id";
		$res = $this->QueryObtieneDatos();
		if(count($res) > 0){
				return $res;
		}
		return 0;
	}

	function ActStatusImpresoEfectivo($id){
		$this->query= "UPDATE P_efectivo 
					   set STATUS = 'I' 
					   where id = '$id'";
		$res = $this->EjecutaQuerySimple();		
	}

	function ObtieneDatosCheque($id){
		$this->query="SELECT * 
					  FROM P_Cheques 
					  WHERE id = $id";
		$res = $this->QueryObtieneDatos();
		if(count($res) > 0){
				return $res;
		}
		return 0;
	}

	function ActStatusImpresoCheque($id){
		$this->query= "UPDATE P_Cheques 
					   set STATUS = 'I' 
					   where id = '$id'";
		$res = $this->EjecutaQuerySimple();		
	}

		function ObtieneDatosCredito($id){
		$this->query="SELECT * 
					  FROM P_CREDITO
					  WHERE id = $id";
		$res = $this->QueryObtieneDatos();
		if(count($res) > 0){
				return $res;
		}
		return 0;
	}

	function ActStatusImpresoCredito($id){
		$this->query= "UPDATE P_Credito 
					   set STATUS = 'I' 
					   where id = '$id'";
		$res = $this->EjecutaQuerySimple();		
	}
	function verEfectivosImp(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_EFECTIVO a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'I'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}


	function verChequesImp(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_CHEQUES a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'I'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}
			return $data;
	}

	function verTransImp(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_TRANS a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'I'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}

	function verCreditosImp(){
		$this->query="SELECT a.*, b.CON_CREDITO, b.diascred, b.clabe, b.BENEFICIARIO as Benef, b.telefono FROM P_CREDITO a
					  left join Prov01 b on a.cve_prov = b.clave 
					  where a.status = 'I'";
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;
		}

			return $data;
	}

   	function ActualizaRuta($docu, $unidad){
   		#echo "Este es el valor de unidad: ".$unidad;
		$TIME = time();
		$HOY = date("Y-m-d");
		$date=DateTime::createFromFormat('Y-m-d',$HOY);
		$formatdate=$date->format('m-d-Y');
		$idunidad = "SELECT IDU FROM UNIDADES WHERE NUMERO = '$unidad'";
		$this->query = $idunidad;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$idunidad=$row->IDU;

		if(substr($docu,0 ,2) =='OP'){
			$this->query="UPDATE FTC_POC_DETALLE SET STATUS_REAL = 'LOGISTICA 3' WHERE OC ='$docu'";
			$this->EjecutaQuerySimple();

			$this->query="UPDATE FTC_POC SET UNIDAD = '$unidad', RUTA='A', IDU = $idunidad, status_log='secuencia', status='LOGISTICA' where oc = '$docu'";
			$rs=$this->EjecutaQuerySimple();
			//echo $this->query;
		}else{
			$this->query="UPDATE compo01
					  SET UNIDAD = '$unidad', RUTA = 'A', idu= '$idunidad', STATUS_LOG = 'secuencia'
					  WHERE CVE_DOC = '$docu'";
			$rs = $this->EjecutaQuerySimple();
		}
		return $rs;
	}

	function ActualizaRutaEdoMex($docu, $unidad){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$this->query="UPDATE compo01
					  SET UNIDAD = '$unidad', RUTA = 'A'
					  WHERE CVE_DOC = '$docu'";
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}

	function verUnidades(){
		$this->query = "SELECT * FROM UNIDADES";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}
     		return $data;
	}

	function verUnidad($unidad){

		$uni = "SELECT NUMERO FROM UNIDADES WHERE IDU = '$unidad'";
		$this->query = $uni;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$uni = $row->NUMERO;
		
     	$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo 
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$uni'";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}
     		return $data; 

     	} 

     function verUnidadesRutas($unidad){
     	$uni = "SELECT * FROM UNIDADES WHERE idu = '$unidad'";
		$this->query = $uni;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$uni = $row->NUMERO;

     	$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$uni' and secuencia is null 
     				  order by b.clave asc";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}

     		return $data;  		
     }

         function verUnidadesRuta(){
     	$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where secuencia is null and unidad <> '' 
     				  order by b.clave asc";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}

     		return $data;  		
     }

    function verUnidadesRutas2($unidad){

     	$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$unidad'  and secuencia is null 
     				  order by b.clave asc";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  		
     }

 	function verUnidadesRuta3(){

     	$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where unidad <> '' and secuencia is null 
     				  order by b.clave asc";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  		
     }

	function asignaSecu($docu, $secu, $unidad, $fechai, $fechaf){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$this->query="UPDATE COMPO01 
					  SET SECUENCIA = '$secu', fecha_secuencia = '$HOY', fecha_log_i = '$fechai', fecha_log_f = '$fechaf'
					  where cve_doc = '$docu'";
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}     	

	function ConsultaUnidad($unidad){
		$this->query="SELECT a.IDU, a.NUMERO, a.MARCA, a.MODELO, a.PLACAS, a.OPERADOR, a.TIPO, a.TIPO2, a.COORDINADOR FROM UNIDADES a WHERE a.IDU = '$unidad'";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  
	}

	function ActualizaNUnidad($numero, $marca, $modelo, $placas, $operador, $tipo, $tipo2, 
		$coordinador, $idu){
		$this->query="UPDATE UNIDADES 
					  SET NUMERO = '$numero', MARCA = '$marca', MODELO = '$modelo', PLACAS = '$placas', OPERADOR = '$operador', TIPO = '$tipo', TIPO2 = '$tipo2', 
					  COORDINADOR = $coordinador 
					  where IDU = '$idu'";
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}

	function verRutasxUnidad($id){
		$uni = "SELECT * FROM UNIDADES WHERE idu = '$id'";
		$this->query = $uni;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$uni = $row->NUMERO;

		$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$uni' and secuencia is null 
     				  order by b.clave asc";
     	$result = $this->QueryObtieneDatosN();

     	//echo $this->query;

     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}



     	$this->query="SELECT ";

     		return $data;  	
	}


	function AdmonRutasxUnidad($idr){
		$uni = "SELECT * FROM UNIDADES WHERE idu = '$idr'";
		$this->query = $uni;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$uni = $row->NUMERO;

		
			$this->query = "SELECT a.CVE_DOC, a.FECHA_DOC,a.CVE_CLPV, datediff(day, a.fechaelab, current_date) AS DIAS, b.nombre, a.vueltas, 
            				b.estado, b.estado , b.codigo, a.fechaelab, a.unidad, a.fecha_pago, a.tp_tes, a.pago_tes, A.IMPORTE, a.idu, b.clave as prov, a.secuencia, a.fecha_secuencia, horai, horaf, b.estado as estadoprov, current_date as hoy
                            from compo01 a
                            left join PROV01 b on a.cve_clpv = b.clave
                            where IDU = $idr and status_log ='admon'";
            $resultado = $this->QueryObtieneDatosN();
            //echo $this->query;
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }

            $this->query="SELECT ftc.oc as cve_doc, ftc.fecha_oc as fecha_doc, ftc.cve_prov as cve_clpv, datediff(day, ftc.fecha_oc, current_date) as dias, p.nombre, ftc.vueltas, 
            				p.estado, p.codigo, ftc.fecha_oc as fechaelab, ftc.unidad, ftc.fecha_pago, ftc.tp_tes, ftc.pago_tes, ftc.costo_total as importe, ftc.idu, p.clave as prov, p.estado as estadoprov, ftc.secuencia, current_date as hoy, ftc.horai, ftc.horaf 
            				from ftc_poc ftc 
            				left join prov01 p on p.clave = ftc.cve_prov
            				where ftc.idu = '$idr' and ftc.status = 'LOGISTICA' and ftc.status_log = 'admon'";
		
        /*
		$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV,
					  b.codigo, a.secuencia, (current_date) as HOY, a.IDU
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$uni' and a.status_log = 'admon' AND a.STATUS != 'C'
     				  order by a.secuencia asc ";
     	*/
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	} 	// and a.status_log = 'Nuevo' 
     		return $data;  	
	}


	function AdmonRutasxUnidad2($doc, $secuencia, $uni, $tipo){
		$this->query="SELECT  a.*, b.NOMBRE, (datediff(day, a.fechaelab, current_date )) as Dias, b.codigo, b.estado as ESTADOPROV, b.codigo, a.secuencia, (current_date) as HOY
     				  from compo01 a
     				  left join PROV01 b on a.cve_clpv = b.clave 
     				  where UNIDAD = '$uni' and secuencia is not null and a.status_log = 'admon'
     				  order by a.secuencia asc ";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     	 $this->query="SELECT ftc.oc as cve_doc, ftc.fecha_oc as fecha_doc, ftc.cve_prov as cve_clpv, datediff(day, ftc.fecha_oc, current_date) as dias, p.nombre, ftc.vueltas, 
            				p.estado, p.codigo, ftc.fecha_oc as fechaelab, ftc.unidad, ftc.fecha_pago, ftc.tp_tes, ftc.pago_tes, ftc.costo_total as importe, ftc.idu, p.clave as prov, p.estado as estadoprov, ftc.secuencia, current_date as hoy, ftc.horai, ftc.horaf 
            				from ftc_poc ftc 
            				left join prov01 p on p.clave = ftc.cve_prov
            				where ftc.unidad = '$uni' and ftc.status_log = 'admon'";
        $result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	} 	// and a.status_log = 'Nuevo' 
     		return $data;  	
	}
        
function AdmonRutasxUnidadEntrega($idr){
		$a="SELECT a.*, c.NOMBRE, c.estado, c.codigo, b.fechaelab, d.fechaelab as fechfact, d.cve_doc as FACTURA, (datediff(day, a.FECHA_CREACION,current_date)) as DIAS, iif(a.factura is null or a.factura ='', a.remision, a.factura) as documento 
			FROM CAJAS a 
			LEFT JOIN FACTP01 b ON a.CVE_FACT = b.cve_doc
			LEFT JOIN CLIE01 c ON c.clave = b.cve_clpv
			LEFT JOIN FACTF01 d ON b.doc_sig = d.cve_doc
			WHERE idu = $idr and a.status_log = 'admon'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function AdmonRutasxUnidadEntregaForaneo($idr){		// para las entregas foraneas 
		$a="SELECT a.*, c.NOMBRE, c.estado, c.codigo, b.fechaelab, d.fechaelab as fechfact, d.cve_doc as FACTURA, (datediff(day, a.FECHA_CREACION,current_date)) as DIAS, cast(cl.CAMPLIB7 as char(255)) as destino_predeterminado
			FROM CAJAS a 
			LEFT JOIN FACTP01 b ON a.CVE_FACT = b.cve_doc
			LEFT JOIN CLIE01 c ON c.clave = b.cve_clpv
			LEFT JOIN FACTF01 d ON b.doc_sig = d.cve_doc
			LEFT JOIN CLIE_CLIB01 cl on cl.cve_clie = c.clave
			WHERE idu = $idr and a.status_log = 'admon'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}
        
	function AdmonRutasxUnidadEntrega2($idr){
		$a="SELECT a.*, c.NOMBRE, c.estado, c.codigo, b.fechaelab, d.fechaelab as fechfact, d.cve_doc as FACTURA, (datediff(day, a.FECHA_CREACION,current_date)) as DIAS, iif(a.factura is null or a.factura ='', a.remision, a.factura) as documento 
			FROM CAJAS a 
			LEFT JOIN FACTP01 b ON a.CVE_FACT = b.cve_doc
			LEFT JOIN CLIE01 c ON c.clave = b.cve_clpv
			LEFT JOIN FACTF01 d ON b.doc_sig = d.cve_doc
			WHERE unidad = '$idr' and a.status_log = 'admon'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}
	function AsignaSec($unidad){
		$uni = "SELECT * FROM UNIDADES WHERE idu = '$unidad'";
		$this->query = $uni;
		$result = $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$uni = $row->NUMERO;
		$this->query="SELECT  b.NOMBRE, count (a.cve_doc) as cve_doc, MAX(current_date ) as Fecha, MAX (b.codigo) as codigo, 
                                      MAX (b.estado) as ESTADOPROV, MAX (b.codigo) as codigo, MAX(unidad) as unidad, 
                                      MAX (datediff(day, a.fechaelab, current_date )) as Dias, max(a.cve_clpv) as prov, a.IDU
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where idu = '$unidad' and secuencia is null and status_log = 'secuencia'
                       group by b.nombre, a.idu";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}


	function AsignaSec2($prove, $secuencia, $uni, $fecha){
		$this->query="SELECT  b.NOMBRE, count (a.cve_doc) as cve_doc, MAX(current_date ) as Fecha, MAX (b.codigo) as codigo, MAX (b.estado) as ESTADOPROV, MAX (b.codigo) as codigo, MAX(unidad) as unidad, MAX (datediff(day, a.fechaelab, current_date )) as Dias, max(a.cve_clpv) as prov, max(idu) as IDU
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where a.UNIDAD = '$uni' and secuencia is null AND status_log = 'secuencia'
                        group by b.nombre ";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}

	function SecUni($prove, $secuencia, $uni, $fecha, $doco){
		$sec ="UPDATE compo01 
				        set secuencia ='$secuencia', status_log = 'admon', fecha_secuencia = current_date, vueltas = vueltas + 1
				        where cve_doc = '$doco'";
		$this->query = $sec;	      
		$rs = $this->EjecutaQuerySimple();

		$this->query="UPDATE FTC_POC_DETALLE SET STATUS_REAL = 'LOGISTICA 4' WHERE OC = '$doco'";
		$this->EjecutaQuerySimple();

		$this->query="UPDATE FTC_POC SET secuencia = $secuencia, status_log = 'admon', fecha_secuencia = current_timestamp, vueltas = vueltas + 1 where OC = '$doco'";
		$this->EjecutaQuerySimple();
		//echo $this->query;
		//break;
		return $rs;
		}		
		
	function ObiteneDataSecRO($prove, $uni){
		$sec ="SELECT CVE_DOC FROM COMPO01 where cve_clpv = '$prove' and unidad = '$uni' and secuencia is null and status_log = 'secuencia' ";
		$this->query = $sec;	      
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray; 	
		}
		return @$data;
	}
	
	function SecRo($doco,$secuencia){
			$this->query = "UPDATE REGISTRO_OPERADORES SET SECUENCIA = '$secuencia', RESULTADO ='admon' WHERE DOCUMENTO = '$doco' AND (SECUENCIA IS NULL OR (SECUENCIA IS NOT NULL AND MOTIVO IS NOT NULL)) ";
			$resultado = $this->EjecutaQuerySimple();
		return @$resultado;
	}
			

	function DefineRuta($doc, $secuencia, $uni, $tipo){
		$tabla = 'compo01';
		$docu = 'CVE_DOC';
		if (substr($doc,0,1) != 'O'){
			$tabla = 'CAJAS';
			$docu = 'CVE_FACT';		
		}

		if($tipo == 'Fallido'){
			$sec ="UPDATE $tabla set status_log = '$tipo', MOTIVO = NULL, doc_sig = null
					where $docu = '$doc'";
			$this->query = $sec;		        
			$rs = $this->EjecutaQuerySimple();
			//echo $this->query;
		}else{
			$sec ="UPDATE $tabla 				
				set status_log = '$tipo', MOTIVO = NULL, status_recepcion = null
					where $docu = '$doc'";
			$this->query = $sec;		        
			$rs = $this->EjecutaQuerySimple();
			//echo $this->query;
		}
		
		if($tabla == 'CAJAS' ){
			$b = "UPDATE CAJAS SET ADUANA = NULL, docs = 'Si' WHERE 	$docu = '$doc'";
			$this->query=$b;
			$result= $this->EjecutaQuerySimple();
		}

		$this->query = "UPDATE FTC_POC_DETALLE SET STATUS_REAL = 'LOGISTICA 5' WHERE CVE_DOC = '$doc'";
		$this->EjecutaQuerySimple();


		$this->query="UPDATE FTC_POC SET status_log = '$tipo', motivo = null, status_recepcion = null, status= 'RECEPCION' where oc = '$doc'";
		$this->EjecutaQuerySimple();
		//echo $this->query;
		//break;
		return $rs;
		}


	function defineRutaForaneo($doc,$guia,$fletera,$cpdestino,$destino,$fechaestimada){
		$this->query = "UPDATE cajas SET status_log = 'Envio', guia_fletera = '$guia', fletera = '$fletera', fecha_guia = current_timestamp, fecha_entrega = '$fechaestimada', destino = '$destino', cp_destino = $cpdestino WHERE cve_fact = '$doc'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}

	function guardaGuiaForaneo($ped,$target_file_cc){ //guarda la ruta de la guia foranea en la bd
		$this->query="UPDATE cajas SET f_guia_fletera = '$target_file_cc' WHERE cve_fact = '$ped'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}
		
	function DefineResultadoFinRO($doc,$tipo){
		$this->query = "UPDATE REGISTRO_OPERADORES SET RESULTADO = '$tipo' WHERE DOCUMENTO = '$doc'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}

	function VerFallidos($idf){
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where a.idu = '$idf' and status_log = 'Fallido' and Motivo is null";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}


	function VerOCFallidas(){
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu, motivo
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where (status_log = 'Fallido') and motivo is not null";              
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}


	function FinalizaRuta($idf, $secuencia, $uni, $motivo, $doc){
		$sec ="UPDATE compo01 
				set Motivo ='$motivo' 
				where cve_doc = '$doc'";
		$this->query = $sec;		        
		$rs = $this->EjecutaQuerySimple();
	
		return $rs;
		}
		
	function FinalizaReEnRuta($idf, $motivo, $doc){					//FINALIZA RE ENRUTA
		$sec ="UPDATE compo01 
				set Motivo ='$motivo', STATUS_LOG = 'Nuevo',  UNIDAD = NULL,SECUENCIA = NULL, 
				FECHA_SECUENCIA = NULL, IDU = NULL, RUTA = 'N', HORAI = NULL, HORAF = NULL
				where cve_doc = '$doc'";
		$this->query = $sec;		        
		$rs = $this->EjecutaQuerySimple();
		return $rs;
		}

	function VerRutaDia(){

		//$TIME = time();
		$HOY = date("Y-m-d"); 
		$date=DateTime::createFromFormat("Y-m-d",$HOY);
		$formatdate=$date->format("m-d-Y");
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu, motivo
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where fecha_secuencia >= '$formatdate'";              
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}

	function VerRutaXDia($idr){

		$HOY = date("Y-m-d"); 
		$date=DateTime::createFromFormat("Y-m-d",$HOY);
		$formatdate=$date->format("m-d-Y");
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, 
                              (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, 
                              secuencia, (current_date) as HOY, idu, motivo, LEFT(c.camplib3,10) AS CITA, a.urgente
                       from (compo01 a
                       LEFT JOIN COMPO_CLIB01 c
                       ON  a.cve_doc = c.clave_doc)
                       left join PROV01 b on a.cve_clpv = b.clave
                       where fecha_secuencia >= '$formatdate' and idu = '$idr'";              
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

            return $data;  	
	}

	function asignaHoraInicio($documento) {
		$pedido=substr($documento, 0,1);
		$tabla= 'COMPO01';
		$campo= 'CVE_DOC';
		if($pedido <> 'O'){
			$tabla= 'CAJAS';
			$campo= 'CVE_FACT';
		}
		$ahora = date("H:i:s");
		$sec = "UPDATE $tabla SET HORAI = '$ahora' WHERE $campo = '$documento'";
		$this->query = $sec;
		$rs = $this->EjecutaQuerySimple();

		$this->query="UPDATE ftc_poc set horai = '$ahora' where oc = '$documento'";
		$this->EjecutaQuerySimple();

		return $rs;
	}

	function asignaHoraFin($documento) {
		$pedido=substr($documento, 0, 1);
		$tabla= 'COMPO01';
		$campo= 'CVE_DOC';
		if($pedido <> 'O'){
			$tabla= 'CAJAS';
			$campo= 'CVE_FACT';
		}
		$ahora = date("H:i:s");
		$sec = "UPDATE $tabla SET HORAF = '$ahora' WHERE $campo = '$documento'";
		$this->query = $sec;
		$rs = $this->EjecutaQuerySimple();
		
		$this->query="UPDATE FTC_POC SET HORAF = '$ahora' where oc = '$documento'";
		$this->EjecutaQuerySimple();

		return $rs;
	}
	
	
	function asignaHoraInicioRO($documento) {
		$ahora = date("H:i:s");
		$sec = "UPDATE REGISTRO_OPERADORES SET HORAINI = '$ahora' WHERE DOCUMENTO = '$documento'";
		$this->query = $sec;
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}

	function asignaHoraFinRO($documento) {
		$ahora = date("H:i:s");
		$sec = "UPDATE REGISTRO_OPERADORES SET HORAFIN = '$ahora' WHERE DOCUMENTO = '$documento'";
		$this->query = $sec;
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}
	
	
	function VerTotales($idf){
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where a.idu = '$idf' and status_log = 'Total'";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}
	
	function VerPnoEnrutar($idf){
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where a.idu = '$idf' and status_log = 'PNR' and MOTIVO is null";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}
	
	function VerReEnrutar($idf){
		$this->query="SELECT  b.NOMBRE, a.cve_doc, (current_date ) as Fecha, (b.codigo) as codigo, (b.estado) as ESTADOPROV, (unidad) as unidad, (datediff(day, a.fechaelab, current_date )) as Dias, (a.cve_clpv) as prov, status_log, fechaelab, pago_tes, fecha_pago, secuencia, (current_date) as HOY, idu
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where  a.idu = '$idf' AND (status_log = 'Parcial' OR status_log = 'Tiempo') and a.MOTIVO is null";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}

	function CreaSubMenu(){
		$this->query="SELECT * FROM unidades
						ORDER BY IDU ASC";
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}
     		return $data;  
	}
	
	
	
	// Ver Todos los registros de logistica que Tengan un status asignado.
	function Logistica(){
		$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
		$logistica="SELECT a.*, b.*,p.NOMBRE , (datediff(day, a.fechaelab, current_date )) as Dias, '$HOY' AS HOY
		FROM
        (COMPO01 a LEFT JOIN prov01 p ON a.cve_clpv = p.clave)
        left join UNIDADES b on a.idu = b.idu 
        where status_log is not null and a.fechaelab >= '04/01/2016' and a.status != 'C' and a.ENLAZADO != 'T'";
		$this->query=$logistica;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
		$data[] =$tsArray;
	}
		return$data;
	}
	
	/*
	 	function Logistica(){
		$logistica="SELECT a.*, b.*  FROM COMPO01 a 
					left join UNIDADES b on a.idu = b.idu
					where status_log is not null";
		$this->query=$logistica;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
		$data[] =$tsArray;
	}
		return$data;
	}*/


	/// Modificar los Status de Logistica.

	function LinUniOC($doc, $tipo, $uni, $tipoA){		//22-03-2016 ICA
		$Statusi=$tipoA;
		$Statusn=$tipo;
		
		if($Statusi != 'Nuevo')
		{
			if($Statusn=='Total'){
			$rs="UPDATE compo01
				set status_log = 'Total',
				hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								END
			where cve_doc='$doc'";
			}elseif($Statusn=='Parcial'){
			$rs="UPDATE compo01 
				set status_log = 'Parcial', 
				motivo = null,
				hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								END
			where cve_doc='$doc'";
			}elseif ($Statusn=='PNR'){
			$rs="UPDATE compo01 
				set status_log = 'PNR', 
				motivo = null, 
				hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								END
			 where cve_doc='$doc'";
			}elseif ($Statusn=='Tiempo'){
			$rs="UPDATE compo01 
			set status_log='Tiempo', 
			motivo = null, 
			hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								END
			where cve_doc='$doc'";
			}elseif ($Statusn=='Fallido'){
				$rs="UPDATE compo01 
				set status_log='Fallido',
				motivo = null, 
				hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								END
				where cve_doc='$doc'";
			}elseif ($Statusn=='AsignaU' || $Statusn=='Nuevo'){
				$rs="UPDATE compo01 
				set motivo = null, 
				STATUS_LOG = 'Nuevo',  
				UNIDAD = NULL,
				SECUENCIA = NULL, 
				FECHA_SECUENCIA = NULL, 
				IDU = NULL, 
				RUTA = 'N', 
				HORAI = NULL, 
				HORAF = NULL, 
				DOC_SIG = NULL, 
				hist_logistica = CASE
								WHEN hist_logistica IS NULL THEN '$Statusn' || '/'
								WHEN hist_logistica IS NOT NULL THEN hist_logistica || '$Statusn' || '/'
								ELSE hist_logistica
								end
					where cve_doc='$doc'";
			}
		$this->query=$rs;
		$result=$this->EjecutaQuerySimple();
		}
	}

		/*
		$urgente = "SELECT URGENTE from PREOC01 where id = '".$IdPreoco."'";
    	$this->query = $urgente;
    	$result = $this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($result);
    	$urgentes = $row->URGENTE;

    	if ($urgentes == 'U'){
			$esurgente = "UPDATE COMPO01 SET URGENTE = 'U' WHERE CVE_DOC ='".$Doc."'";
    		$this->query = $esurgente;
    		$result = $this->EjecutaQuerySimple(); 
		*/


    function TraeProveedores($prov){
    	$this->query = "SELECT CLAVE, NOMBRE FROM prov01 
    					WHERE nombre CONTAINING '$prov'";
    	$result = $this->QueryDevuelveAutocomplete();
        return $result;
    }

    function TraeClientes2($clie){
    	$this->query = "SELECT CLAVE, NOMBRE FROM clie01 
    					where nombre containing '$clie'";
    	$rs = $this->QueryDevuelveAutocomplete();
    	return $rs;
    }
    
	function TraeProductos($prod){
    	$this->query = "SELECT CVE_ART, DESCR FROM inve01 
    					WHERE DESCR CONTAINING '$prod'";
    	$result = $this->QueryDevuelveAutocompleteP();
        return $result;
    }
    
	function verRecepciones(){
   	$this->query="SELECT a.*, b.NOMBRE, c.OPERADOR, iif(d.cve_doc is null, a.doc_sig, d.cve_doc) as Recepcion
   				  from compo01 a
   				  left join prov01 b on a.cve_clpv = b.clave
   				  left join unidades c on a.unidad = c.numero  
   				  left join compr01 d on a.doc_sig = d.cve_doc
   				  where (a.status_rec is null or a.status_rec = 'par') 
   				  and (Status_log = 'Total' or Status_log = 'Parcial' or Status_log = 'PNR' or Status_log = 'Fallido' or Status_log = 'fallido') 
   				  and a.fechaelab >= '04/01/2016' 
   				  AND a.STATUS != 'C' 
   				  and (a.status_log2 is null or a.status_log2 = 'R' or a.status_log2  like '%Nuevo/')";
   				  //// modificcion el 22 de Julio "and (a.status_log2 is null or a.status_log2 = 'R' or a.status_log2 ='Nuevo/' )""
   	//echo $this->query;

   	$result=$this->QueryObtieneDatosN();
   	while ($tsArray=ibase_fetch_object($result)){
   		$data[]=$tsArray;
   	}
   	return @$data;
   }

   	/*function verRecepciones(){

   		// VALIDACION INICIAL = 0, VALIDACION INCOMPLETA = 1 VALIDACION COMPLETA = 2
   		$this->query="SELECT r.*, p.nombre
   				from compr01 r
   				left join prov01 p on p.clave = r.cve_clpv 
   				where cve_doc in (SELECT CVE_DOC FROM DOCTOSIGC01  GROUP BY CVE_DOC having max(tip_doc) = 'r' and (min(VALIDACION) = 0 OR min(VALIDACION) = 1) and min(ubica) = 0)";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   		return $data;
   	}*/


	function RECEP($doc){
		$test="SELECT a.*, b.CAMPLIB2, b.camplib4, c.codigo, c.municipio, c.telefono, c.nombre, d.fechaelab as fechaoc, d.cve_doc as OC
					  FROM COMPR01 a
					  left join compo_clib01 b on a.doc_ant = b.CLAVE_doc
					  left join prov01 c on a.cve_clpv = c.clave
					  left join  compo01 d on a.doc_ant = d.cve_doc
					  where trim(a.cve_doc) = trim('$doc')";
		$this->query=$test;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function detalleRECEP($doc){
		$test2="SELECT a.*, b.descr, c.cotiza
					  FROM PAR_COMPR01 a
					  left join inve01 b on a.cve_art = b.cve_art
					  left join preoc01 c on a.id_preoc = c.id
					  where trim(cve_doc) = trim('$doc')";
		
		$this->query=$test2;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}
	
	function CotizacionSinCompra(){
		//$hoy = date("d.m.y");
		$this->query="select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS 
					from preoc01 WHERE status='N' and rest > 0 and rec_faltante > 0 AND fechasol > '29.02.2016' ORDER BY  nom_prov  ASC ";
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}
	
	function OCSinPago(){
		$hoy = date("d.m.y");
		$this->query= "	SELECT a.cve_doc, b.nombre, a.importe, a.fechaelab, a.fecha_doc, doc_sig as Recepcion, a.enlazado, c.camplib1 as TipoPagoR, c.camplib3 as FER,c.camplib2 as TE, c.camplib4 as Confirmado, a.tp_tes as PagoTesoreria, a.pago_tes, pago_entregado, c.camplib6, a.cve_clpv, a.URGENTE, datediff(day, a.fechaelab, current_date ) as Dias 
						from compo01 a
						left join Prov01 b on a.cve_clpv = b.clave
						LEFT JOIN compo_clib01 c on a.cve_doc = c.clave_doc
						where a.status <> 'C' and  TP_TES is null and fechaelab > '03/14/2016' order by a.fechaelab asc";
		/*"SELECT cve_doc, datediff(day, fecha_doc, date '$hoy') AS dias
						FROM compo01
						WHERE status_pago = 'PP' AND fecha_doc > '15.03.2016'";*/
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}
	
	function OCSinRuta(){
		//$hoy = date("d.m.y");
		$this->query="SELECT a.cve_doc, b.nombre, a.fecha_pago, a.pago_tes, a.tp_tes, a.pago_entregado, c.camplib2 , a.unidad, a.estado, a.fechaelab, (datediff(day, a.fechaelab, current_date )) as Dias, a.urgencia, b.codigo, b.estado as estadoprov 
					    from compo01 a
						left join prov01 b on a.cve_clpv = b.clave
						left join compo_clib01 c on a.cve_doc = c.clave_doc
						where a.ruta = 'N' and a.doc_sig is null";
		/*"SELECT a.cve_doc, b.nombre, b.estado, b.codigo, a.fecha_doc, datediff(day, a.fecha_doc, date '$hoy') AS dias,
					  a.pago_tes, a.fecha_pago
					  FROM 
					  	compo01 a 
					  	INNER JOIN prov01 b
					  	ON a.cve_clpv = b.clave
					  WHERE a.status_log = 'Nuevo' AND a.fecha_doc > '15.03.2016'";*/
		$result=$this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}
	
	function OCSinRecepcion(){
		$hoy = date("d.m.y");
		$this->query="SELECT a.cve_doc, b.nombre, b.estado, b.codigo, a.fecha_doc, datediff(day, a.fecha_doc, date '$hoy') AS dias,
							  a.UNIDAD, a.RUTA, c.OPERADOR
							  FROM 
							  	(compo01 a
							  	LEFT JOIN UNIDADES c
								ON a.idu = c.idu) 
							  	LEFT JOIN prov01 b
							  	ON a.cve_clpv = b.clave
							  	WHERE DOC_SIG IS NULL AND fecha_doc > '15.03.2016'";
		$result=$this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;	
		}
		return $data;
	}

	function ValidarRecepcion($docr){

		$this->query="SELECT a.*, a.cve_doc as RECEPCION, a.doc_ant as OC, b.nombre, c.unidad, d.operador, c.status_log
					  FROM COMPR01 a
					  left join prov01 b on a.cve_clpv = b.clave
					  left join compo01 c on a.cve_doc = c.doc_sig
					  left join unidades d on c.unidad = d.numero
					  where a.cve_doc = '$docr'";
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function PartidasRecep($docr, $doco){
		$tipo = substr($docr, 0,1);
		//echo 'Valor del Tipo: '.$tipo;
		if($tipo == 'F'){
			$a="SELECT a.*, b.descr, a.cant as Cant_oc, b.uni_alt, a.pxr as PXR_OC, 'F' as DOCO, c.cant as CANT
					, a.id_preoc as ID_PREOC, e.fechaelab as fecha_doco, b.cve_art 
				      from par_compo01 a
				      left join Inve01 b on a.cve_art = b.cve_art
				      left join compr01 d on a.cve_doc = d.doc_ant
				      left join par_compr01 c on c.id_preoc = a.id_preoc AND c.cve_doc = d.cve_doc
				      left join compo01 e on a.cve_doc = e.cve_doc
				      where a.cve_doc = '$doco' 
				      and a.status != 'c' 
				      and (a.status_rec is null or a.status_rec = 'f' or a.status_rec = 'p' or a.status_rec = 'par') 
				      and (a.status_log2 ='R' or a.status_log2 is null)";	
		}else{
			$a="SELECT poc.num_par,pr.tot_partida, pr.cant as Cant_oc, i.uni_alt, pr.pxr as PXR_OC, r.cve_doc as DOCO, pr.cant as CANT,
			 			  r.fechaelab, pr.id_preoc as ID_PREOC, r.fechaelab as fecha_doco, i.cve_art, i.descr, oc.cve_doc, pr.pxr, pr.cost
						  FROM par_compr01 pr
						  left join inve01 i on pr.cve_art = i.cve_art 
						  left join compr01 r on r.cve_doc = pr.cve_doc
						  left join compo01 oc on r.doc_ant = oc.cve_doc
						  left join par_compo01 poc on poc.cve_doc = r.doc_ant and poc.id_Preoc = pr.id_Preoc 
						  where trim(pr.cve_doc) = trim('$docr') 
						  and (poc.status_log2 is null or poc.status_log2 = 'R')";
		}
		$this->query=$a;

		//echo $this->query;
		
	    $result=$this->QueryObtieneDatosN();
	    while ($tsArray=ibase_fetch_object($result)){
	    	$data[]=$tsArray;
	    }
	    return @$data;
	}
 

	function PartidasNoRecep($docr, $doco){
		$c="SELECT a.*, b.descr, b.uni_alt, e.cant_rec as L, e.cost_rec as J, d.doc_sig, iif(a.saldo is null, 0, a.saldo) as SALDO
				      from par_compo01 a
				      left join Inve01 b on a.cve_art = b.cve_art
				      left join compo01 d on a.cve_doc = d.cve_doc
				      left join compr01 c on d.cve_doc = c.doc_ant 
				      left join par_compr01 e on c.cve_doc = e.cve_doc and a.id_preoc = e.id_preoc
				      where a.cve_doc = '$doco' and (a.status_rec is not null)";
				      //echo $this->query;
	    $this->query=$c;
	    $result=$this->QueryObtieneDatosN();
	    while ($tsArray=ibase_fetch_object($result)){
	    	$data[]=$tsArray;
	    }
	    return @$data;
	}

	function ActCantParRecep($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){
		$actcant = "UPDATE par_compr01 set cant = $cantn where cve_doc = '$docr'  and id_preoc = '$idpreoc'";
		$this->query=$actcant;
		$result = $this->EjecutaQuerySimple();
	}
//// Revisarar para que sirve esta funcion y de donde viene.

	function ActPXR($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){
		$pxr = "SELECT pxr from par_compo01 where cve_doc = '$doco' and id_preoc = idpreoc";
		$this->query=$pxr;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$pxroc = $row->$PXR; 

		if ($cantn > $cantorig){
			$cantfinal = $cantn - $cantorig;
			$pxrfinal = $pxroc - $cantfinal;
			$actpxr="UPDATE par_comoo01 set pxr = '$pxrfinal' where cve_doc = '$doco' and id_preoc = $idPreoc";	
		}else{
			$cantfinal = $cantorig - $cantn;
			$pxrfinal = $pxroc + $cantfinal;
			$actpxr="UPDATE par_compo01 set pxr = $pxrfinal where cve_doc = '$doco' and id_preoc = $idpreoc";
		}
		$this->query=$actpxr;
		$result=$this->EjecutaQuerySimple();
	}

	
	function VerNoSuministrableC(){
		$hoy = date("d.m.y");
			$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti, cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,date '$hoy') as DIAS 
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NULL ";
		$result = $this->QueryObtieneDatosN();
			while ($tsArray = ibase_fetch_object($result)){ 
					$data[] = $tsArray;		
		}
		return $data;
	}
	
	function VerNoSuministrableCMotivo(){
		$hoy = date("d.m.y");
			$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,date '$hoy') as DIAS, obs
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL ORDER BY  nom_prov  ASC ";
		$result = $this->EjecutaQuerySimple();
		if($this->NumRows($result) > 0){
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
				return $data;
		}
		
		return $result;
		
	}
	
	
	
	function MotivoNoSuministrable($id,$motivo){
		$this->query = "UPDATE PREOC01 SET OBS = '$motivo' WHERE id = '$id'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}
		
	function VerNoSuministrableV(){
		$numeroletras = $_SESSION['user']->NUMERO_LETRAS;
		$letra1 = $_SESSION['user']->LETRA;
		$letra2 = $_SESSION['user']->LETRA2;
		$letra3 = $_SESSION['user']->LETRA3;
		$letra4 = $_SESSION['user']->LETRA4;
		$letra5 = $_SESSION['user']->LETRA5;
		switch ($numeroletras){
			
			case 1:
					 $this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL AND LETRA_V IN ('$letra1') ORDER BY  nom_prov  ASC ";
				break;
				
			case 2:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL 
								AND LETRA_V IN ('$letra1','$letra2') ORDER BY  nom_prov  ASC ";
				break;
						
			case 3:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL 
								AND LETRA_V IN ('$letra1','$letra2','$letra3') ORDER BY  nom_prov  ASC ";
				break;
			
			case 4:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL 
								AND LETRA_V IN ('$letra1','$letra2','$letra3','$letra4') ORDER BY  nom_prov  ASC ";
				break;	

			case 5:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL 
								AND LETRA_V IN ('$letra1','$letra2','$letra3','$letra4','$letra5') ORDER BY  nom_prov  ASC ";
				break;
			
			case 6:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL 
								AND LETRA_V IN ('$letra1','$letra2','$letra3','$letra4','$letra5','$letra6') ORDER BY  nom_prov  ASC ";
				break;
				
			case 99:
					$this->query = "select id, fechasol, cotiza, par, status, prod, nomprod, canti,cant_orig, costo, prove, nom_prov, total,rest,docorigen, urgente, um, datediff(day,fechasol,current_date) as DIAS, OBS
								from preoc01 WHERE status='S' and rest > 0 and rec_faltante > 0 AND OBS IS NOT NULL ORDER BY  nom_prov  ASC ";
				break;
				
			default:
				berak;
		}
		$result=$this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;	
		}
		return $data;
	}
	
	function StatusNoSuministrableV($id,$status){
		$this->query = "UPDATE PREOC01 SET status = '$status' WHERE id = '$id'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}
	

	///// Cuando se actuliza el Costo pero la cantidad es la misma.

	function ActRecCosto($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){
		$subtot="SELECT sum(tot_partida) as TOTAL, sum(totimp4) as TOTALIVA from par_compr01 where trim(cve_doc) = trim('".$docr."')";
		//echo $subtot;
		$this->query=$subtot;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_row($result);
		//print $row[0];
		//print $row[1];
		$t=$row[0];
		$TotalIVA=$row[1];
		$SubTotal = $t - $TotalIVA; 
		return $result;
	}


	function ActStatusParRec($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){
		$actpar= "UPDATE par_compr01 set status_rec = 'CCo' where cve_doc = '$docr' and Id_Preoc = '$idpreoc'";
		$this->query=$actpar;
		$result=$this->EjecutaQuerySimple();
		return $result;
	}

	function ActCostoPar($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){

		$consulta= "UPDATE PAR_COMPR01 SET cost = ('$coston'*'$cantn'), TOTIMP4 = (('$coston'*'$cantn') * 0.16), TOT_PARTIDA = (('$coston'*'$cantn') * 1.16)

					WHERE ID_PREOC = '$IDPREOC'";	

		$this->query = $consulta;

		$result=$this->EjecutaQuerySimple();

	}



//// Cuando Atualiza Cantidad y Costo

	function ActRecCCx($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){
		$subtot="SELECT sum(tot_part) as TOTAL , sum(tot_imp4) as TOTALIVA from par_compr01 where cve_doc = '".$docr."'";
		$this->query=$subtot;
		$result-> $this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$Total= $row-> $TOTAL;
		$TotalIVA=$row->$TOTALIVA;
		$SubTotal = $TOTALIVA - $TOTAL; 

		/*$ActDoc= "UPDATE compr01 set CAN_TOT = $SubTotal, IMPORTE = $Total, IMP_TOT4 = $TotalIVA where CVE_DOC = '$docr'";
		$this->query=$ActDoc;
		$result=$this->EjecutaQuerySimple();
		return $result;*/
	}

    

/// actuaiza es estatus de recepcion.


	function ActRecepOk($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc,$idordencompra,$par, $fechadoco, $descripcion,$cveart, $fval, $desc1, $desc2, $desc3){
		$usuario=$_SESSION['user']->NOMBRE;
				
		$a="INSERT INTO VALIDA_RECEPCION (DOCUMENTO, ID_PREOC, PRODUCTO, DESCRIPCION, PARTIDA, FECHA_DOC,FECHA_VAL, CANT_ORIGINAL, CANT_VALIDADA, CANT_ACUMULADA, COSTO_ORIGINAL, COSTO_VALIDADO, SERIE, APLICADO, IMPRESO, USUARIO, FOLIO_VAL, DESC1 ,DESC2, DESC3)
			VALUES ('$doco',$idpreoc,'$cveart',
					iif('$cveart' starting with ('PGS'), (select nombre from producto_ftc where clave = '$cveart'), (select camplib7 from inve_clib01 where cve_prod = '$cveart')),
					$par,'$fechadoco', current_timestamp, '$cantorig', '$cantn', 0, $costoorig, $coston, 'RV', 'No', 'No', '$usuario', $fval, $desc1 , $desc2, $desc3)";	

					//echo $a;
					//break;
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		//echo $a;
		//break;
		$b="SELECT SUM(CANT_VALIDADA) AS ACUMULADO, MAX(ID) AS MID FROM VALIDA_RECEPCION WHERE id_preoc = $idpreoc group by id_preoc";
		$this->query=$b;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$acumulado = $row->ACUMULADO;
		$id = $row->MID;
		//echo $id;
		//break;
		$c="UPDATE VALIDA_RECEPCION SET CANT_ACUMULADA = $acumulado where id = $id";
		$this->query=$c;
		$result = $this->EjecutaQuerySimple();

		$d="UPDATE PREOC01 SET RECEPCION = iif(recepcion = 0, $acumulado, recepcion + $cantn), rec_faltante = cant_orig - iif(recepcion = 0, $acumulado, recepcion + $cantn) where id = $idpreoc";

		$this->query=$d;
		$result=$this->EjecutaQuerySimple();

		$e="UPDATE VALIDA_RECEPCION SET APLICADO = 'Si' WHERE id = $id";
		$this->query=$e;
		$result=$this->EjecutaQuerySimple();

		$f="SELECT DOCUMENTO, SUM(CANT_VALIDADA) as cantval, MAX(PARTIDA) AS PARTIDA, MAX(ID_PREOC) AS ID_PREOC  FROM VALIDA_RECEPCION  WHERE documento = '$doco' and PARTIDA = $par and id_preoc= $idpreoc GROUP BY DOCUMENTO";
		$this->query=$f;
	
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$oc=$row->DOCUMENTO;
		$cantval=$row->CANTVAL;
		$partida=$row->PARTIDA;
		$idpreoc=$row->ID_PREOC;

		$g="UPDATE par_compo01 set pxr = cant - $cantval, status_rec = iif((cant - $cantval)= 0, 'ok', 'par' ), doc_recep = iif(doc_recep is null, 'f', doc_recep), doc_recep_status = iif(doc_recep_status is null, 'f', doc_recep_status), cant_rec = iif(cant_rec is null, $cantn, cant_rec + $cantn),status_log2 = iif((cant - $cantval) = 0, 'T', 'Suministros'), cost_rec = $coston, saldo =tot_partida - ($coston * $cantn), folio_falso = 'No' where cve_doc = '$oc' and num_par = $partida and id_preoc = $idpreoc";
		//echo $g;
		//break;
		$this->query = $g;
		$result=$this->EjecutaQuerySimple();


		$partidas="SELECT count(num_par) as PARTIDAS from par_compo01 where cve_doc = '$doco' and status_rec = 'ok'";
		$this->query=$partidas;
		$rspoc=$this->EjecutaQuerySimple();
		$row=ibase_fetch_row($rspoc);
		$paroc=$row[0];
		//echo $partidas;
		//echo "Este es el total de partidad comprobadas: ".$paroc;

		$part="SELECT count(num_par) as PARTOT FROM PAR_COMPO01 WHERE CVE_DOC = '$doco'";
		$this->query=$part;
		$rspocr=$this->EjecutaQuerySimple();
		$row2=ibase_fetch_object($rspocr);
		$partot= $row2->PARTOT;
		//echo " Total de las partidas del Documento: ".$partot;

		if ($partot == $paroc){
			$actrecep_status = "UPDATE compo01 set status_rec = 'OK' where cve_doc = '$doco'";
		}else{
			$actrecep_status = "UPDATE compo01 set status_rec = 'par', status_log2 = 'Suministros' where cve_doc = '$doco'";
		}
			$this->query=$actrecep_status;
			$result=$this->EjecutaQuerySimple();
		//	echo $actrecep_status;
		///// hasta aqui es codigo nuevo.
		///Se define si se visualiza en el area de imprimir comprbante.
		$partidasrec="SELECT count(num_par) as PARTIDAS from par_compr01 where trim(cve_doc) = trim('$docr') and status_rec is not null";
		$this->query=$partidasrec;
		$rsprec=$this->EjecutaQuerySimple();
		$row5=ibase_fetch_row($rsprec);
		$parrec=$row5[0];
		//echo $partidasrec;
		//echo "Este es el total de partidad comprobadas: ".$parrec;
		$partrec="SELECT max(num_par) as PARTOT FROM PAR_COMPR01 WHERE Trim(CVE_DOC) = Trim('$docr')";
		$this->query=$partrec;
		$rsprecr=$this->EjecutaQuerySimple();
		$row6=ibase_fetch_object($rsprecr);
		$partotrec= $row6->PARTOT;
		//echo " Total de las partidas del Documento: ".$partotrec;

		if ($partotrec == $parrec){
			$actrecep_status_rec = "UPDATE compr01 set status_rec = 'ok' where trim(cve_doc) = trim('$docr')";
			$this->query=$actrecep_status_rec;
			$result=$this->EjecutaQuerySimple();
		//	echo $actrecep_status_rec;
		}	

			/*
			//// Inicia la actualizacion del Pedido para validar si se puede preparar.

				$b="SELECT max(par) as PAR from preoc01 where cotiza = '$doc' group by cotiza";
				$this->query=$b;
				$result=$this->QueryObtieneDatosN();
				$row = ibase_fetch_object($result);
				$partidas=$row->PAR;

				$c="SELECT iif(count(id)= 0, 0,count(id)) as PARPEND from preoc01 where emp_status = 'pendiente' and cotiza = '$doc' group by cotiza";
				$this->query= $c;
				$result = $this->QueryObtieneDatosN();
				$row = ibase_fetch_object($result);
				@$parpen = $row->PARPEND;


				$d="SELECT iif(count(id) is null, 0, count(id)) as PARPAR from preoc01 where emp_status = 'parcial' and cotiza = '$doc' group by cotiza";
				$this->query= $d;
				$result = $this->QueryObtieneDatosN();
				$row = ibase_fetch_object($result);
				@$parpar = $row->PARPAR;

				if ($parpen == $partidas){
					$update= "UPDATE FACTP01 SET EMP_STATUS='pendiente' where cve_doc = '$doc'";
				}elseif ($partidas == $parcom){
					$update= "UPDATE FACTP01 SET EMP_STATUS='completo' where cve_doc = '$doc'";
				}elseif($partidas == $parpar){
					$update= "UPDATE FACTP01 SET EMP_STATUS='parcial' where cve_doc = '$doc'";	
				}else{
					$update= "UPDATE FACTP01 SET EMP_STATUS='eparcial' where cve_doc = '$doc'";
				}
				$this->query=$update;
				$result = $this->EjecutaQuerySimple();

		*/
		return $result;


	}


	function verRecepcion(){
    	$this->query="SELECT a.*, b.NOMBRE, c.OPERADOR, d.cve_doc as Recepcion
    				  from compo01 a
    				  left join prov01 b on a.cve_clpv = b.clave
    				  left join unidades c on a.unidad = c.numero  
    				  left join compr01 d on a.doc_sig = d.cve_doc
    				  where (Status_log = 'Total' or Status_log = 'Parcial' or Status_log = 'PNR') and a.status_rec is null ";

    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
	
	function StatusNoSuministrable($id){
		$this->query = "UPDATE PREOC01 
						SET 
							status = 'S', 
							MOTIVOS_NOSUMINISTRABLE = IIF(MOTIVOS_NOSUMINISTRABLE IS NULL, OBS, MOTIVOS_NOSUMINISTRABLE || '/' || OBS),
							OBS = NULL
						 WHERE id = '$id'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}


	function verRecepV(){
    	$recepv="SELECT a.*, b.nombre, c.cve_doc as OC, d.numero, c.unidad, d.operador
    	         from compr01 a
    	         left join prov01 b on a.cve_clpv = b.clave
    	         left join compo01 c on a.doc_ant = c.cve_doc
    	         left join unidades d on c.unidad = d.numero 
    	         where a.status_rec is not null";
    	$this->query=$recepv;
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray;	
		}
		return $data;
    }

    function ConsultaPagadas(){
        /*$this->query ="SELECT recepciones.CVE_DOC AS recepcion,ordenes.CVE_DOC AS orden, proveedor.nombre AS proveedor,
    					recepciones.importe,recepciones.folio,ordenes.STATUS_PAGO
    					FROM
        					(compr01 recepciones
       						 INNER JOIN prov01 proveedor
       						 ON proveedor.clave = recepciones.cve_clpv)
     					   	INNER JOIN compo01 ordenes
        					ON recepciones.doc_ant = ordenes.cve_doc
    						WHERE ordenes.status_pago = 'PP'";
		*/
    	$this->query ="SELECT recepciones.CVE_DOC AS recepcion,ordenes.CVE_DOC AS orden, proveedor.nombre AS proveedor,
    					recepciones.importe,recepciones.folio,ordenes.STATUS_PAGO
    					FROM
        					(compr01 recepciones
       						 INNER JOIN prov01 proveedor
       						 ON proveedor.clave = recepciones.cve_clpv)
     					   	INNER JOIN compo01 ordenes
        					ON recepciones.doc_ant = ordenes.cve_doc
    						WHERE recepciones.status_rec is not null";
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
            return $data;
    }

    function ActRecepNo($docr, $doco, $cantn, $coston, $cantorig, $costoorig, $idpreoc){

        $dif = $cantorig;
		//echo "Esta es la diferencia : ".$dif;
			/// Obtener los pendientes por recibir actuales:
		$pxra="SELECT pxr from par_compo01 where cve_doc = '$doco' and id_preoc = '$idpreoc'";
		$this->query=$pxra;
		$respxr=$this->EjecutaQuerySimple();
		$row4= ibase_fetch_object($respxr);
		$pxrnow=$row4->PXR;
		$npxr = $pxrnow + $dif;
		//echo "Obtener el pendiente por recibir actual: ".$pxra;
		//echo "Esta es la diferecia : ".$dif;
		//echo "Este es el nuevo pendiente por recibir : ".$npxr;
		$actdif="UPDATE par_compo01 set pxr = $npxr where trim(cve_doc) = trim('$doco') and id_preoc = '$idpreoc'";
		$this->query=$actdif;
		$result=$this->EjecutaQuerySimple();
		//echo "Cosnulta para actualizar el PXR : ".$actdif;
		//// Actualiza los estatus de recepcion de partidas. 
		$recepo="UPDATE par_compo01 set status_rec = 'ko' where cve_doc = '$doco' and id_preoc = $idpreoc";
		$recepr="UPDATE par_compr01 set status_rec = 'ko' where cve_doc = '$docr' and id_preoc = $idpreoc";
		$this->query=$recepo;
		$result=$this->EjecutaQuerySimple();
		$this->query=$recepr;
		$result=$this->EjecutaQuerySimple();
        //// Actualiza las cantidades recibidas y los costos recibidos.
        $costtp=$cantn * $coston;
        $actparr="UPDATE par_compr01 set cant_rec = 0, cost_rec = 0 where cve_doc = '$docr' and id_preoc = $idpreoc";
        $this->query=$actparr;
        $result=$this->EjecutaQuerySimple();
        /// ACTUALIZA NUEVOS TOTALES 
            /// Obtenemos el costo todal del documento a la fecha.
        $costotot = "SELECT SUM(iif(cost_rec is null, 0, cost_rec)) FROM PAR_COMPR01 WHERE TRIM(CVE_DOC) = TRIM('$docr') and status_rec is not null";
        $this->query=$costotot;
        $rct=$this->EjecutaQuerySimple();
        $row3=ibase_fetch_row($rct);
        $nct=$row3[0];
        //echo "Este es el nuevo costo: ".$nct;
        $actcostdoc="UPDATE compr01 set Cost_rec = $nct where TRIM(cve_doc) = Trim('$docr')";
        $this->query=$actcostdoc;
		$result=$this->EjecutaQuerySimple();
		//echo "Actualiza Totales : ".$actcostdoc;
		////Se define si el documento de Orde de compra se vuelve a mostrar para su validacion de partidas restantes.
		$partidas="SELECT count(num_par) as PARTIDAS from par_compo01 where cve_doc = '$doco' and status_rec is not null";
		$this->query=$partidas;
		$rspoc=$this->EjecutaQuerySimple();
		$row=ibase_fetch_row($rspoc);
		$paroc=$row[0];
		//echo $partidas;
		//echo "Este es el total de partidad comprobadas: ".$paroc;
		$part="SELECT max(num_par) as PARTOT FROM PAR_COMPO01 WHERE CVE_DOC = '$doco'";
		$this->query=$part;
		$rspocr=$this->EjecutaQuerySimple();
		$row2=ibase_fetch_object($rspocr);
		$partot= $row2->PARTOT;
		//echo " Total de las partidas del Documento: ".$partot;
		if ($partot == $paroc){
			$actrecep_status = "UPDATE compo01 set status_rec = 'OK' where cve_doc = '$doco'";
			$this->query=$actrecep_status;
			$result=$this->EjecutaQuerySimple();
		//	echo $actrecep_status;
		}

		///Se define si se visualiza en el area de imprimir comprbante.

		$partidasrec="SELECT count(num_par) as PARTIDAS from par_compr01 where trim(cve_doc) = trim('$docr') and status_rec is not null";
		$this->query=$partidasrec;
		$rsprec=$this->EjecutaQuerySimple();
		$row5=ibase_fetch_row($rsprec);
		$parrec=$row5[0];
		//echo $partidasrec;
		//echo "Este es el total de partidad comprobadas: ".$parrec;

		$partrec="SELECT max(num_par) as PARTOT FROM PAR_COMPR01 WHERE Trim(CVE_DOC) = Trim('$docr')";
		$this->query=$partrec;
		$rsprecr=$this->EjecutaQuerySimple();
		$row6=ibase_fetch_object($rsprecr);
		$partotrec= $row6->PARTOT;
		//echo " Total de las partidas del Documento: ".$partotrec;

		if ($partotrec == $parrec){
			$actrecep_status_rec = "UPDATE compr01 set status_rec = 'ok' where trim(cve_doc) = trim('$docr')";
			$this->query=$actrecep_status_rec;
			$result=$this->EjecutaQuerySimple();
		//	echo $actrecep_status_rec;
		}


	}
  

/***
     * cfa: 210316
     * consulta todas las cotizaciones registradas en la aplicación. Esta consulta es preparada para mostrar el grid 
     * en la pantalla de p.cotizacion.php
    ***/

    function consultarCotizaciones($cerradas=false){
        $usuario = $_SESSION['user']->USER_LOGIN;
        $this->query = "SELECT CDFOLIO as folio, CVE_CLIENTE as cliente, NOMBRE, RFC, IDPEDIDO, INSTATUS as estatus, EXTRACT(DAY FROM DTFECREG) || '/' || EXTRACT(MONTH FROM DTFECREG) || '/' || EXTRACT(YEAR FROM DTFECREG) AS FECHA 
            FROM FTC_COTIZACION A INNER JOIN CLIE01 B 
              ON TRIM(A.CVE_CLIENTE) = TRIM(B.CLAVE) 
            WHERE CDUSUARI = '$usuario'";        
        $cerradas?$this->query.=" AND upper(INSTATUS) <> upper('PENDIENTE') ":$this->query.=" AND upper(INSTATUS) = upper('PENDIENTE') ";
        $this->query.=" ORDER BY CDFOLIO";
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }    

    function cabeceraCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, CVE_CLIENTE, NOMBRE, RFC, INSTATUS, DSIDEDOC, IDPEDIDO, EXTRACT(DAY FROM DTFECREG) || '/' || EXTRACT(MONTH FROM DTFECREG) || '/' || EXTRACT(YEAR FROM DTFECREG) AS FECHA,
                                DSPLANTA, DSENTREG, DBIMPSUB, DBIMPIMP, DBIMPTOT 
                          FROM FTC_COTIZACION A INNER JOIN CLIE01 B 
                            ON TRIM(A.CVE_CLIENTE) = TRIM(B.CLAVE)
                        WHERE CDFOLIO = '$folio'";
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }

    function detalleCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, A.CVE_ART, DESCR, FLCANTID, DBIMPCOS, DBIMPPRE, DBIMPDES  
                          FROM FTC_COTIZACION_DETALLE A 
                        INNER JOIN INVE01 B
                          ON A.CVE_ART = B.CVE_ART
                        WHERE CDFOLIO = '$folio'";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }

    function listaArticulos($cliente, $articulo, $descripcion){
        $data = array();        
        if($articulo!=''){
            $this->query = "SELECT A.CVE_ART, DESCRIPCION, COSTO, PRECIO 
                              FROM FTC_Articulos A INNER JOIN PRECIO_X_PROD01 B
                                ON A.CVE_ART = B.CVE_ART 
                                AND A.CVE_ART = '".$articulo."'
                                AND CVE_PRECIO = (SELECT LISTA_PREC FROM CLIE01 WHERE TRIM(CLAVE) = '".$cliente."')";        
        } elseif($descripcion!=''){
            $this->query = "SELECT A.CVE_ART, DESCRIPCION, COSTO, PRECIO 
                              FROM FTC_Articulos A INNER JOIN PRECIO_X_PROD01 B
                                ON A.CVE_ART = B.CVE_ART 
                                AND upper(DESCRIPCION) LIKE upper('%".$descripcion."%')
                                AND CVE_PRECIO = (SELECT LISTA_PREC FROM CLIE01 WHERE TRIM(CLAVE) = '".$cliente."')";        
        } else {
            return $data;
        }
        
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
        }
        return $data;
    }
    
    function actualizaTotales($folio){
        $this->query = "SELECT FLCANTID, DBIMPPRE, DBIMPDES FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $subtotal = 0;
        $impuesto = 0;
        $descuento = 0;
        $total = 0;        
        if(count($data)>0){            
            foreach ($data as $row){
                $cantidad = $row->FLCANTID;
                $precio = $row->DBIMPPRE;
                $descuentoPartida = $row->DBIMPDES;
                $subtotalPartida = round($cantidad * $precio, 2) - round($cantidad * $descuentoPartida, 2);
                //echo "Subtotal Partida: $subtotalPartida <br />";
                $subtotal += $subtotalPartida;                
                $descuento+= $descuentoPartida;
                //echo "Subtotal: $subtotal <br />";
            }
            $descuento = round($descuento, 2);
            $impuesto = round(($subtotal * 0.16), 2);
            //echo "Impuesto: $impuesto <br />";
            $total = round(($subtotal + $impuesto), 2);                    
            //echo "Total: $total <br />";
        } 
        $this->query = "UPDATE FTC_COTIZACION SET DBIMPSUB = $subtotal, DBIMPIMP = $impuesto, DBIMPTOT = $total, DBIMPDES = $descuento "
                . " WHERE CDFOLIO = $folio";
        
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
    
    function insertaCotizacion($cliente, $identificadorDocumento){
        $folio = 1;
        $this->query = "SELECT MAX(cdfolio)+1 folio FROM FTC_COTIZACION";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        if(count($data)>0){            
            foreach ($data as $row){
                $folio = $row->FOLIO;
            }
        }        
        $usuario = $_SESSION['user']->USER_LOGIN;
        $this->query = "INSERT INTO FTC_COTIZACION (CDFOLIO, CVE_CLIENTE, DSIDEDOC, DTFECREG, INSTATUS, DBIMPSUB, DBIMPIMP, DBIMPTOT, DSPLANTA, DSENTREG, CDUSUARI) "
                . "VALUES ($folio, TRIM('$cliente'), '$identificadorDocumento', CAST('Now' as date),'PENDIENTE',0,0,0,(SELECT COALESCE(CAMPLIB7, '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente')),(SELECT COALESCE(CAMPLIB8, '') FROM CLIE_CLIB01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente')),'$usuario')";        
        
        $rs = $this->EjecutaQuerySimple();
        return $rs;
        
    }
    
    function avanzaCotizacion($folio){
        $this->generaDocumentoCotizacion($folio);
        
        $this->query = "UPDATE FTC_COTIZACION SET INSTATUS = 'CERRADA' WHERE CDFOLIO = $folio";
        //echo "<br />query: ".$this->query;
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
    
    function generaDocumentoCotizacion($folio) {
        $this->query = "SELECT CDFOLIO, CVE_CLIENTE, DSIDEDOC, IDPEDIDO, DBIMPSUB, DBIMPIMP, DBIMPTOT, DBIMPDES FROM FTC_COTIZACION WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $existeFolio = false;
        if(count($data)>0){  
            $existeFolio =true;
            foreach ($data as $row){
                $folio = $row->CDFOLIO;
                $cliente = $row->CVE_CLIENTE;
                $letra = $row->DSIDEDOC;
                $pedido = $row->IDPEDIDO;
                $subtotal = $row->DBIMPSUB;
                $impuesto = $row->DBIMPIMP;
                $total = $row->DBIMPTOT;
                $descuento = $row->DBIMPDES;
            }
        }
        $serie = 'C'.substr($letra,1);
        //echo "serie: $serie";
        if(!$existeFolio){
            return NULL;
        } else {
            $usuario = $_SESSION['user']->USER_LOGIN;
            $consecutivo = $this->obtieneConsecutivoClaveDocumento($serie);
            $cve_doc = $letra.$consecutivo;
        }
        
        $insert = "INSERT INTO FACTC01 ";
        $insert.="(TIP_DOC, CVE_DOC, CVE_CLPV, STATUS, CVE_PEDI, FECHA_DOC, FECHA_ENT, CAN_TOT, IMP_TOT1, IMP_TOT2, IMP_TOT3, IMP_TOT4, DES_TOT, DES_FIN, IMPORTE, CVE_OBS, NUM_ALMA, ACT_COI, NUM_MONED, TIPCAMB, ENLAZADO, TIP_DOC_E, NUM_PAGOS, FECHAELAB, SERIE, FOLIO, CTLPOL, ESCFD, CONTADO, BLOQ, DES_FIN_PORC, DES_TOT_PORC, TIP_DOC_ANT, DOC_ANT, TIP_DOC_SIG, DOC_SIG, FORMAENVIO, REALIZA)";
        $insert.="VALUES";
        $insert.="('C' ,'$cve_doc', (SELECT CLAVE FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')), 'O' , '$pedido' , CAST('Now' as date), CAST('Now' as date), $subtotal, 0, 0, 0 , $impuesto, $descuento, 0, $total, 0, 9, 'N', 1, 1, 'O', 'O',NULL, CAST('Now' as date),'$serie', $consecutivo, 0, 'N', 'N', 'N', 0 , 0, '', '',  '', '', '', '$usuario')";
         //echo "insert: ".$insert;
        $this->query = $insert;
        $rs = $this->EjecutaQuerySimple();
         
        $this->query = "SELECT CVE_ART, DBIMPCOS, FLCANTID, DBIMPPRE, DBIMPDES FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        if(count($data)>0){            
            foreach ($data as $row){
                $cve_art = $row->CVE_ART;
                $costo = $row->DBIMPCOS;
                $cantidad = $row->FLCANTID;
                $precio = $row->DBIMPPRE;
                $descuentoPartida = $row->DBIMPDES;
                $subtotalPartida = round($cantidad * $precio, 2) - round($cantidad * $descuentoPartida, 2);
                //echo "Subtotal Partida: $subtotalPartida <br />";
                $subtotal += $subtotalPartida;                
                $descuento+= $descuentoPartida;
                //echo "Subtotal: $subtotal <br />";
                $actualiza = "INSERT INTO PAR_FACTC01 
                (CVE_DOC, NUM_PAR, CVE_ART,CANT, PREC, COST, IMPU1,IMPU2, IMPU3, IMPU4, IMP1APLA, IMP2APLA, IMP3APLA, IMP4APLA,TOTIMP1, TOTIMP2,TOTIMP3,TOTIMP4,DESC1,ACT_INV, TIP_CAM, UNI_VENTA,TIPO_ELEM, TIPO_PROD, CVE_OBS, E_LTPD, NUM_ALM, NUM_MOV, TOT_PARTIDA, USUARIO_PHP) 
                VALUES
                ('$cve_doc',(SELECT COALESCE(MAX(NUM_PAR), 0) FROM PAR_FACTC01) + 1,'$cve_art',$cantidad,$precio,$costo,0,0,0,16,0,0,0,0,0,0,0,$impuesto,$descuento,'N',1,(SELECT UNI_MED FROM INVE01 WHERE CVE_ART = '$cve_art'),'P','P',0,0,9,NULL,($subtotalPartida),'$usuario')";
                //echo "<br />UPDATE: ".$actualiza;
                $this->query = $actualiza;
                $rs = $this->EjecutaQuerySimple();
            }
        }
        return $rs;
         
    }
        
    function obtieneConsecutivoClaveDocumento($letra){
        $this->query = "SELECT COALESCE(MAX(FOLIO), 1)+1 FOLIO FROM FACTC01 WHERE TIP_DOC = 'C' AND SERIE = '$letra'";        
        $result = $this->QueryObtieneDatosN();
        //echo "query: ".$this->query;
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $consecutivo = 1;
        if(count($data)>0){            
           foreach ($data as $row){
                $consecutivo = $row->FOLIO;
            } 
        }
        //echo "consecutivo : $consecutivo";
        return $consecutivo;
    }
    
    function actualizaPedidoCotizacion($folio, $pedido) {
        $this->query = "UPDATE FTC_COTIZACION SET IDPEDIDO = '$pedido' WHERE CDFOLIO = $folio";
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
            
    function cancelaCotizacion($folio){
        $this->query = "UPDATE FTC_COTIZACION SET INSTATUS = 'CANCELADA' WHERE CDFOLIO = $folio";        
        $rs = $this->EjecutaQuerySimple();
        return $rs;
    }
    
    function quitarCotizacionPartida($folio, $partida) {
        $this->query = "DELETE FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $folio AND CVE_ART = '$partida'";        
        $rs = $this->EjecutaQuerySimple();
        $this->actualizaTotales($folio);
        return $rs;
    }
    
    function actualizaCotizacion($folio, $partida, $articulo, $precio, $descuento, $cantidad){
        if($partida!=''){
            $this->query = "UPDATE FTC_COTIZACION_DETALLE SET "
                    . " CVE_ART = '$articulo', FLCANTID = $cantidad, DBIMPCOS = (SELECT MAX(costo) FROM PRVPROD01 A WHERE A.CVE_ART = '$articulo' GROUP BY cve_art), DBIMPPRE = $precio, DBIMPDES = $descuento "
                    . " WHERE CDFOLIO = '$folio' AND CVE_ART = '$partida'";
        } else {
            $this->query = "INSERT INTO FTC_COTIZACION_DETALLE "
                    . "(CDFOLIO,CVE_ART,FLCANTID,DBIMPPRE,DBIMPCOS,DBIMPDES)"
                    . "VALUES ('$folio','$articulo',$cantidad,$precio,(SELECT MAX(costo) FROM PRVPROD01 A WHERE A.CVE_ART = '$articulo' GROUP BY cve_art), $descuento)";
        }        
        $rs = $this->EjecutaQuerySimple();
        $this->actualizaTotales($folio);
        return $rs;        
    }
    
    function moverClienteCotizacion($folio, $cliente){
        $this->query = "UPDATE FTC_COTIZACION SET CVE_CLIENTE = TRIM('$cliente') WHERE CDFOLIO = $folio";
        $rs = $this->EjecutaQuerySimple();      
        return $rs;        
    }
    
    function autocompletaArticulo($descripcion) {
        $this->query="SELECT DESC FROM INVE01 WHERE DESC LIKE '$descripcion%'";
        $result = $this->QueryObtieneDatosN();
        $data = array();
        while ($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray->descripcion;
        }        
        $json = json_encode($data);
        return $json;
    }
    
    function listadoClientes($clave, $cliente){
        $data = array();
        $usuario = $_SESSION['user']->USER_LOGIN;
        $select_letras = ", (SELECT COALESCE(LETRA, '') || ',' || COALESCE(LETRA2, '') || ',' || COALESCE(LETRA3, '') || ',' || COALESCE(LETRA4, '') || ',' || COALESCE(LETRA5, '') LETRAS ";
        $select_letras.= " FROM PG_USERS ";
        $select_letras.= " WHERE USER_LOGIN = '$usuario') letras";
        if($clave!=''){
            $this->query = "SELECT TRIM(CLAVE) CLAVE, STATUS, NOMBRE, RFC ".$select_letras." FROM CLIE01 WHERE STATUS <> 'S' AND TRIM(CLAVE) = '$clave'";
        } elseif($cliente!=''){
            $this->query = "SELECT TRIM(CLAVE) CLAVE, STATUS, NOMBRE, RFC ".$select_letras." FROM CLIE01 WHERE upper(NOMBRE) LIKE upper('%$cliente%') AND STATUS <> 'S'";
        } else {
            return $data;
        }
        $result = $this->QueryObtieneDatosN();  
        
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        return $data;
    }

    function listadoLetras() {
        $usuario = $_SESSION['user'];
        $this->query = "SELECT COALESCE(LETRA, '') || ',' || COALESCE(LETRA2, '') || ',' || COALESCE(LETRA3, '') || ',' || COALESCE(LETRA4, '') || ',' || COALESCE(LETRA5, '') LETRAS";
        $this->query .= " FROM PG_USERS ";
        $this->query .= " WHERE USER_LOGIN = '$usuario'";
        $data = array();
        $result = $this->QueryObtieneDatosN();        
        while ($tsArray = ibase_fetch_object($result)){
            $data[] = $tsArray;
        }
        $letras = "";
        if(count($data)>0){            
            foreach ($data as $row){
                $letras = $row->LETRAS;
            }
        } 
        $myArray = explode(',', $letras);
        print_r($myArray);
        return $myArray;
    }
    
////// FINALIZA COTIZACION CFA- 
    
///// Modulo de productos almacen 10.
    function VerCat10($alm){
    	$prod="SELECT * from PRODUCTOS WHERE ACTIVO = 'S'";
    	$this->query=$prod;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
/*
    function EditProd($id){
    	$this->query="SELECT * from PRODUCTOS where id =$id";
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
*/

    //// CAMBIOS OFA 25 04 2016
    function ARutaEntrega(){
		$entrega="SELECT iif(a.docs is null, 'No', a.docs) as DOCS, a.*, c.nombre, c.estado, c.codigo, b.fechaelab, (datediff(day, a.fecha_creacion, current_date)) as DIAS, a.Factura as Factura, e.cve_doc as remisiondoc 
		          from CAJAS a
		          LEFT JOIN FACTP01 d ON a.cve_fact = d.cve_doc
		          LEFT JOIN FACTF01 b ON a.factura = b.cve_doc
		          LEFT JOIN CLIE01 c ON d.cve_clpv = c.clave
		          LEFT JOIN FACTR01 e on a.remision = e.cve_doc 
		          where a.ruta = 'N' AND a.STATUS = 'cerrado' and fecha_creacion >='08.08.2016' and (factura is not null or remision is not null)"; // Material completo.   and (b.fechaelab >= '06/30/2016' or d.fechaelab >= '06/30/2016')
		$this->query=$entrega;
		$result = $this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function FacturaSinMaterial(){
		$SinMaterial="SELECT a.*, (datediff(day, fechaelab, current_date )) as Dias, b.*
					  FROM FACTF01 a
					  left join CLIE01 b on a.cve_clpv = b.clave
				      WHERE STATUS_MAT IS NULL";
	    $this->query=$SinMaterial;
	    $result = $this->QueryObtieneDatosN();
	    while ($tsArray=ibase_fetch_object($result)){
	    	$data[]=$tsArray;
	    }
	    return $data;
	}

	function FacturasSinMat($docf){
		$SinMaterial="SELECT a.*, (datediff(day, fechaelab, current_date )) as Dias, b.*
					  FROM FACTP01 a
					  left join CLIE01 b on a.cve_clpv = b.clave
				      WHERE cve_doc = '$docf'";
				      //echo $SinMaterial;
	    $this->query=$SinMaterial;
	    $result = $this->QueryObtieneDatosN();
	    while ($tsArray=ibase_fetch_object($result)){
	    	$data[]=$tsArray;
	    }			
	    return $data;
	}

	function ParFactMaterial($docf){
		$parmat="SELECT a.*, iif(pftc.nombre is null,c.descr, pftc.nombre) as CAMPLIB7, c.uni_med, d.recepcion, d.rec_faltante
		         FROM PAR_FACTP01 a
		         left join inve01 c on a.cve_art = c.cve_art
		         left join producto_ftc pftc on pftc.clave = a.cve_art
		         left join preoc01 d on a.id_preoc = d.id
		         WHERE (STATUS_MAT <> 'OK' OR STATUS_MAT IS NULL) AND CVE_DOC = '$docf'";

		$this->query=$parmat;
		//echo $parmat;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
	
		return @$data;
	}
    
	function EditProd($id){
    $this->query="SELECT a.*, b.NOMBRE AS proveedor from PRODUCTOS a LEFT JOIN Prov01 b ON a.PROV1 = b.CLAVE where a.id =$id";
    $result=$this->QueryObtieneDatosN();
    while ($tsArray=ibase_fetch_object($result)){
    $data[]=$tsArray;
    }
    return $data;
    }

    function AltaProductos($clave,$descripcion,$marca1,$categoria,$desc1,$desc2,$desc3,$desc4,$desc5,$iva,$costo_total,$clave_prov,$codigo_prov1,$costo_prov1,$prov2,$codigo_prov2,$costo_prov2,$unidadcompra,$factorcompra,$unidadventa,$factorventa){
		$this->query="EXECUTE PROCEDURE sp_producto_nuevo
                        ('$clave','$descripcion','$marca1','$categoria','$desc1','$desc2','$desc3','$desc4','$desc5','$iva','$costo_total','".rtrim($clave_prov)."','$codigo_prov1','$costo_prov1','$prov2','$codigo_prov2','$costo_prov2','$unidadcompra','$factorcompra','$unidadventa','$factorventa')";
                
		$rs = $this->EjecutaQuerySimple();
		return $rs;	
	}

	function ActualizaProductos($id,$clave,$descripcion,$marca1,$categoria,$desc1,$desc2,$desc3,$desc4,$desc5,$iva,$costo_total,$clave_prov,$codigo_prov1,$costo_prov1,$prov2,$codigo_prov2,$costo_prov2,$unidadcompra,$factorcompra,$unidadventa,$factorventa,$activo){
				$this->query=" EXECUTE PROCEDURE sp_modifica_producto
                                             ('$id','$clave','$descripcion','$marca1','$categoria',$desc1,$desc2,$desc3,$desc4,$desc5,$iva,$costo_total,'".rtrim($clave_prov)."','$codigo_prov1',$costo_prov1,'$prov2','$codigo_prov2',$costo_prov2,'$unidadcompra',$factorcompra,'$unidadventa',$factorventa,'$activo')"; 
		$rs = $this->EjecutaQuerySimple();
		return $rs;	
	}
	
	
	function DatosPreorden($id){
		$this->query = "SELECT a.ID, a.PROD, a.COTIZA, a.PAR, a.NOMPROD, a.CANTI, a.COSTO,a.PROVE, a.NOM_PROV, a.OBS, a.MOTIVOS_NOSUMINISTRABLE, b.CAMPLIB1 AS MARCA, c.PREC AS PRECIO
						FROM (PREOC01 a
						LEFT JOIN par_factp01 c 
						ON c.CVE_DOC = a.COTIZA AND c.NUM_PAR = a.PAR)
						LEFT JOIN INVE_CLIB01 b
						ON a.PROD = b.CVE_PROD
						WHERE ID = '$id'";
		
		$result = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($result)){
			$data[] = $tsArray; 
		}
		return $data;
	}
	
/*	function UpdateParFactP($cotizacion,$partida){
		$this->query = "UPDATE PAR_FACTP01 SET PXS = 0, STATUS_PRE = 'M' WHERE  CVE_DOC = '$cotizacion' AND NUM_PAR = '$partida'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	} */
	
	function UpdatePreoc($idPreorden,$motivo,$costo,$claveproveedor,$nombreproveedor){
		$prove = rtrim($claveproveedor);
		$nomprov = trim($nombreproveedor);
		$this->query = "UPDATE PREOC01 
						SET STATUS = 'N', 
							OBS = 'Ventas Modifica: ' || '$motivo',
							COSTO = '$costo',
							TOTAL = (CANTI * $costo),
							PROVE = '$prove',
							NOM_PROV = '$nomprov'
						 WHERE  ID = '$idPreorden'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}
	
	
	 function RegistroOperadores($docu,$unidad){
		$this->query = "SELECT a.FECHA_DOC, a.URGENCIA, b.CAMPLIB3, a.TIP_DOC, b.CAMPLIB1, b.CAMPLIB5
						FROM compo01 a LEFT JOIN COMPO_CLIB01 b 
						ON a.CVE_DOC = b.CLAVE_DOC
						WHERE a.CVE_DOC = '$docu'";
						
		$result = $this->QueryObtieneDatosN();
		$compo;
		while($tsArray = ibase_fetch_row($result)){
			$compo=$tsArray;
		}
		
		$this->query = "SELECT OPERADOR FROM UNIDADES WHERE NUMERO = '$unidad'";				
		$resultado = $this->QueryObtieneDatosN();
		$uni;
		while($TsArray = ibase_fetch_row($resultado)){
			$uni=$TsArray;
		}
		//var_dump($compo); echo "\n";
		$this->query = "
			INSERT INTO REGISTRO_OPERADORES(OPERADOR,FECHAASIG,UNIDAD,DOCUMENTO,FECHADOC,URGENCIA,CITA,TIPO,FORMAPAGO,FOLIO_FP,RESULTADO)
			VALUES('$uni[0]',CURRENT_DATE,'$unidad','$docu',LEFT('$compo[0]',10),'$compo[1]',LEFT('$compo[2]',10),'$compo[3]','$compo[4]','$compo[5]','secuencia')";
			
		$rs = $this->EjecutaQuerySimple();
		//var_dump($this->query);
		return $rs;	
	} 
	 
	function ActRecepRO($idordencompra,$congruencia){
		$this->query ="UPDATE REGISTRO_OPERADORES SET ESTVSREAL = '$congruencia' WHERE DOCUMENTO = '$idordencompra'";
		$resultado = $this->EjecutaQuerySimple();
		return $resultado;
	}	


	function ActEmpaque($docf, $par, $canto, $idpreoc, $cantn, $empaque, $art, $desc, $idcaja){
		$doc=$docf;
		$tabla='PAR_FACTP01';
	
		$cantval="SELECT CANT_VAL, CANT FROM $tabla WHERE CVE_DOC = '$docf' and NUM_PAR = $par";
		$this->query=$cantval;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$cantact=$row->CANT_VAL;
		$cantot=$cantact + $cantn;
		$cantidad=$row->CANT;
		//echo "Estas es el resultado de la cantidad actual y la nueva cantidad: ".$cantot;

		$usuario=$_SESSION['user']->NOMBRE;

		$this->query = "INSERT INTO CONTROL_FACT_REM (ID, COTIZACION, PARTIDA, CANTIDAD, PRODUCTO, CAJA, IDPREOC, STATUS, PXF, USUARIO , FECHA, FECHA_FACT_REM, FACTURAS, REMISIONES)
							values (null, '$docf', $par, $cantn, '$art', $idcaja, $idpreoc, 'Nuevo', $cantn, '$usuario', CURRENT_TIMESTAMP, NULL, NULL, NULL)";
		$this->EjecutaQuerySimple();


		if ($canto == $cantot){
		$act="UPDATE $tabla SET CANT_VAL = iif(cant_val is null, $cantn, cant_val + $cantn), pxs= (pxs + $cantn), NUM_EMPAQUE = $empaque, STATUS_MAT = 'OK' where cve_doc = '$docf' and num_par = $par";
		
		$act2="UPDATE FACTP01 SET ENLAZADO ='O' WHERE CVE_DOC = '$docf'";
		}elseif($canto > $cantidad){
		$act="UPDATE $tabla SET CANT_VAL = iif(cant_val is null, $cantn, cant_val + $cantn), pxs=($cantn), NUM_EMPAQUE = $empaque, STATUS_MAT = 'OK', cant_error=($canto - $cantidad) where cve_doc = '$docf' and num_par = $par";
		$act2="UPDATE FACTP01 SET ENLAZADO ='O' WHERE CVE_DOC = '$docf'";
		}elseif($canto <> $cantot){
		$act="UPDATE $tabla SET CANT_VAL = iif(cant_val is null, $cantn, cant_val + $cantn), pxs=(pxs + $cantn), NUM_EMPAQUE = $empaque, STATUS_MAT = 'PAR' where cve_doc = '$docf' and num_par = $par";
		$act2="UPDATE FACTP01 SET ENLAZADO ='O' WHERE CVE_DOC = '$docf'";
		}
		$this->query = $act;
		$result=$this->EjecutaQuerySimple();
		$this->query = $act2;
		$rs = $this->EjecutaQuerySimple();

		$this->query="SELECT PXS, CANT FROM PAR_FACTP01 WHERE cve_doc = '$docf' and num_par = $par";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$pxs = $row->PXS;
		$cantidad = $row->CANT;

		if($pxs > $cantidad){
			$this->query="SELECT REMISIONADO, FACTURADO FROM PREOC01 WHERE COTIZA='$docf' and par = $par";
			$rs=$this->EjecutaQuerySimple();
			$row=ibase_fetch_object($rs);
			$rem = $row->REMISIONADO;
			$fac = $row->FACTURADO;

			if ($rem == 0 and $fac == 0){
				$this->query="UPDATE PAR_FACTP01 SET PXS=$cantidad where CVE_DOC ='$docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}elseif($rem != 0 and $fac == 0){
				$this->query="UPDATE PAR_FACTP01 SET PXS=($cantidad - $rem) where cve_doc = '$docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}elseif ($rem == 0 and $fac != 0){
				$this->query="UPDATE PAR_FACTP01 SET PXS=($cantidad - $fac) where cve_doc = '$docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}elseif ($fac > $rem){
				$this->query="UPDATE PAR_FACTP01 SET PXS=($cantidad - $rem) where cve_doc = '$docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}elseif ($fac < $ren){
				$this->query="UPDATE PAR_FACTP01 SET PXS=($cantidad - $rem) where cve_doc = '$docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}elseif ($fac == $rem) {
				$this->query="UPDATE PAR_FACTP01 SET PXS=($cantidad - $rem) where cve_doc = 'docf' and num_par = $par";
				$rs=$this->EjecutaQuerySimple();
			}

		}


		$result+=$this->ActEmpacado($docf, $par, $canto, $idpreoc, $cantn, $empaque, $art, $desc, $idcaja);
		return $result;
	}



	function ActEmpacado($docf, $par, $canto, $idpreoc, $cantn, $empaque, $art, $desc, $idcaja){
		$a="UPDATE preoc01 set empacado = empacado + $cantn where id = $idpreoc";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		return $result;
	}


	function InsPaquete($docf, $par, $canto, $idpreoc, $cantn, $empaque, $art, $desc, $idcaja,$tipopaq){        //23062016

		//$valpaq="SELECT iif(max(FECHA_PAQUETE) is null, current_date, max(FECHA_PAQUETE)) as Fechaact FROM PAQUETES WHERE DOCUMENTO = '$docf'"; 
		$valpaq="SELECT iif(count(DOCUMENTO) IS NULL, 0, COUNT(DOCUMENTO)) AS DOCU FROM PAQUETES WHERE DOCUMENTO ='$docf'";
		//echo $valpaq;
		$this->query=$valpaq;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$doc=$row->DOCU;
		///echo "Valor de DOCUMENTO: ".$doc;

		if($doc == 0){
			//// inserta cuando el documento es nuevo.
			$p = 1;
			$emp="INSERT INTO PAQUETES (DOCUMENTO, ARTICULO, PARTIDA, DESCRIPCION, CANTIDAD, FECHA_PAQUETE, EMPAQUE,  STATUS_LOG, ID_PREOC, TIPO_EMPAQUE, BASE_TIPO, CONSECUTIVO_TIPO, PAQUETE, FECHA_EMPAQUE, IDCAJA) 
		      VALUES ('$docf', '$art', $par, '$desc', $cantn, current_date, $empaque, 'nuevo', $idpreoc, '$tipopaq', 0, 0, $p, current_timestamp, $idcaja)";
		//7echo $emp;
		$this->query=$emp;
		$result=$this->EjecutaQuerySimple();
		return $result;
	}else{
            /// inserta cuando no es nuevo y la fecha es diferente a la original.
			$f="SELECT MAX(FECHA_PAQUETE) as fechau, MAX(PAQUETE) AS PAQUETE FROM PAQUETES WHERE DOCUMENTO = '$docf'";
			$this->query=$f;
			$result=$this->QueryObtieneDatosN();
			$row=ibase_fetch_object($result);
			$fech=$row->FECHAU;
			$pa = $row->PAQUETE;

			if($fech != date("Y-m-d")){
				$p= $pa + 1;
				$emp="INSERT INTO PAQUETES (DOCUMENTO, ARTICULO, PARTIDA, DESCRIPCION, CANTIDAD, FECHA_PAQUETE, EMPAQUE,  STATUS_LOG, ID_PREOC, TIPO_EMPAQUE, BASE_TIPO, CONSECUTIVO_TIPO, PAQUETE, FECHA_EMPAQUE, IDCAJA) 
                                                    VALUES ('$docf', '$art', $par, '$desc', $cantn, current_date, $empaque, 'nuevo', $idpreoc, '$tipopaq', 0, 0, $p, current_timestamp, $idcaja)";
		      		$this->query=$emp;
					$result=$this->EjecutaQuerySimple();
					return $result;
				//echo $emp;
			}else{
				$t="SELECT MAX(PAQUETE) as PAQ FROM PAQUETES WHERE DOCUMENTO = '$docf' AND FECHA_PAQUETE = current_date";
				$this->query=$t;
				$result=$this->QueryObtieneDatosN();
				$row=ibase_fetch_object($result);
				$pa=$row->PAQ;
				//echo $pa; 
				$emp="INSERT INTO PAQUETES (DOCUMENTO, ARTICULO, PARTIDA, DESCRIPCION, CANTIDAD, FECHA_PAQUETE, EMPAQUE,  STATUS_LOG, ID_PREOC, TIPO_EMPAQUE, BASE_TIPO, CONSECUTIVO_TIPO, PAQUETE, FECHA_EMPAQUE, IDCAJA) 
                                                    VALUES ('$docf', '$art', $par, '$desc', $cantn, current_date, $empaque, 'nuevo', $idpreoc, '$tipopaq', 0, 0, $pa, current_timestamp, $idcaja)";
		      		$this->query=$emp;
					$result=$this->EjecutaQuerySimple();
					return $result;
			}
		}}
//// Tiene que actualizar el dumento para que ya no se muestre en la pantalla para actualizar empaque
	function ActEmpaqueDoc($docf, $par, $canto, $idpreoc, $cantn, $empaque){
		//$pedido=strpos($docf, 'P');
		//$tabla= 'PAR_FACTP01';
		//$tabla2= 'FACTF01';
		//if($pedido !== false){ 
			$tabla='PAR_FACTP01';
			$tabla2='FACTP01';
		//}		
		$part = "SELECT MAX (NUM_PAR) as PARTIDAS FROM $tabla WHERE CVE_DOC = '$docf'";
		$this->query=$part;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$partmax=$row->PARTIDAS;

		$partok = "SELECT COUNT(cve_doc) as PARTOK FROM $tabla WHERE CVE_DOC = '$docf' and STATUS_MAT = 'OK'";
		$this->query=$partok;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$partidasok=$row->PARTOK;

		if ($partidasok == $partmax){
			$actdoc="UPDATE $tabla2 SET STATUS_MAT = 'COM' WHERE CVE_DOC = '$docf'";
			$this->query=$actdoc;
			$result=$this->EjecutaQuerySimple();
			return $result;
		}
	}

	function verPaquetes(){
		$paq="SELECT DOCUMENTO, MAX(EMPAQUE) AS PAQUETE, MAX(FECHA_PAQUETE) AS FECHA FROM PAQUETES WHERE STATUS_LOG='nuevo' group by DOCUMENTO";
		$this->query=$paq;
		$result=$this->QueryObtieneDatosN();
		//echo $paq;
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function verPaquetesEmb($docf){     //23062016
		//$paq="SELECT * from PAQUETES WHERE embalado is null and DOCUMENTO = '$docf' ";
		$this->query="SELECT TIPO_ENVIO,DOCUMENTO, IDCAJA, FECHA_PAQUETE, EMPAQUE, TIPO_EMPAQUE
                                from PAQUETES WHERE embalado is null and DOCUMENTO = '$docf'
                                group by  TIPO_ENVIO,DOCUMENTO, IDCAJA, FECHA_PAQUETE, EMPAQUE, TIPO_EMPAQUE";
		$result=$this->QueryObtieneDatosN();
		//echo $this->query;
		//break;
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function verDetallePaq($docf){      //23062016
            		$this->query="SELECT ID_PREOC, TIPO_ENVIO,DOCUMENTO, IDCAJA, FECHA_PAQUETE, EMPAQUE,ARTICULO,DESCRIPCION, CANTIDAD
                                        from PAQUETES WHERE embalado is null and DOCUMENTO = '$docf'";
		$result=$this->QueryObtieneDatosN();
		//echo $this->query;
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
    }
        
	function verCajasAbiertas(){
		$a="SELECT a.id, max(CVE_FACT) as CVE_FACT, max(c.nombre) as NOMBRE, max(empaque) as PAQUETE, max(fecha_creacion) as FECHA_CREACION, max (b.doc_sig) as FACTURA, max(e.fechaelab) as FECHA_FACT
			FROM CAJAS a
			LEFT JOIN FACTP01 b on a.cve_fact = b.cve_doc
			LEFT JOIN CLIE01 c on b.cve_clpv = c.clave
			LEFT JOIN PAQUETES d on a.id = d.idcaja and d.embalado is null
			LEFT JOIN FACTF01 e on b.doc_sig = e.doc_ant or a.cve_fact = e.doc_ant 
			WHERE a.STATUS = 'abierto' and (a.embalaje != 'TOTAL' or a.embalaje is null)
					 group by a.id
					 having max(empaque) > 0";
		$this->query=$a;

		$result=$this->QueryObtieneDatosN();
		//echo $paq;
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function AsignaEmbalaje($docf,$paquete1, $paquete2, $tipo, $peso, $alto, $largo, $ancho, $pesovol, $idc, $idemp){       //23062016
		$a="UPDATE PAQUETES SET PAQUETE1=$paquete1, PAQUETE2 = $paquete2, PESO= $peso, LARGO=$largo, ANCHO=$ancho, ALTO=$alto, PESO_VOLUMETRICO=$pesovol, embalado = 'S', fecha_embalaje = current_timestamp where documento = '$docf' and idcaja = $idc and tipo_empaque = '$tipo' AND EMPAQUE = $idemp ";
		//echo $a;
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		$c="SELECT DOCUMENTO, COUNT(PARTIDA) PARTOT, SUM(PESO) AS PESO FROM PAQUETES WHERE documento = '$docf' AND EMBALADO = 'S' GROUP BY DOCUMENTO";
		$this->query=$c;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$parf=$row->PARTOT;
		$peso=$row->PESO;
		$d="SELECT COUNT(PARTIDA) PARTOTP FROM PAQUETES WHERE documento = '$docf'";
		$this->query=$d;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$parr=$row->PARTOTP;

		if($parr == $parf){
			$e="UPDATE cajas set EMBALAJE = 'TOTAL', peso = $peso where cve_fact='$docf' AND ID = $idc";
			#echo 'Actualiza Caja:'.$e;
			$this->query=$e;
			$result=$this->EjecutaQuerySimple();
			return $result;
		}

		return $result;
	}

	function embalados($docf){
		$b="SELECT * FROM PAQUETES WHERE DOCUMENTO = '$docf' and EMBALADO='S'";
		$this->query=$b;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function DataCaja($caja){
		$c="SELECT * FROM Cajas WHERE ID = '$caja'";
	    $this->query=$c;
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}

	function embaladosTotales($docf, $caja){
		$d="SELECT documento, count(partida) as partidas, sum(cantidad) as cantidades, sum (peso) as PESO 
		 from paquetes 
		 where documento = '$doc' and idcaja = $caja group by documento";
		 echo $d;
		$this->query=$d;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data; 
	}


	function CajasXFactura($docf){
		$this->query="SELECT * FROM Cajas WHERE CVE_FACT = '$docf'";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}
        

	function DataFactCaja($docf){
			$a="SELECT CVE_DOC FROM FACTP01 WHERE CVE_DOC = '$docf' GROUP BY CVE_DOC";
			$this->query=$a;
			$result=$this->QueryObtieneDatosN();
			while($tsArray=ibase_fetch_object($result)){
				$data[]=$tsArray;
			}
		return @$data;
	}

	function NuevaCaja($facturanuevacaja){

		$usuario = $_SESSION['user']->USER_LOGIN;
		$a="SELECT MAX(ENVIO) as envio , MAX(REV_DOSPASOS) as rev_dospasos, MAX(CLIEN) AS CLIEN FROM preoc01 where cotiza = '$facturanuevacaja'";
		//echo $a;
		$this->query = $a;
		$result=$this->EjecutaQuerySimple();
		$row = ibase_fetch_object($result);
		$envio =$row->ENVIO;
		$revdp =$row->REV_DOSPASOS;
		$cliente=$row->CLIEN;

		$b="SELECT CARTERA_REVISION, CARTERA_COBRANZA, dias_revision, DIAS_PAGO FROM CARTERA WHERE TRIM(IDCLIENTE) = TRIM($cliente)";
		$this->query=$b;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$cr = $row->CARTERA_REVISION;
		$cc = $row->CARTERA_COBRANZA;
		$dr = $row->DIAS_REVISION;
		$dp = $row->DIAS_PAGO;

		$c="SELECT iif(max(CVE_DOC) is null, '',max(CVE_DOC)) AS FACTURA FROM FACTF01 WHERE DOC_ANT = '$facturanuevacaja' and idc is null ";
		$this->query = $c;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$factura=$row->FACTURA;
		$d="SELECT iif(max(CVE_DOC) is null, '',max(CVE_DOC)) AS REMISION FROM FACTR01 WHERE DOC_ANT = '$facturanuevacaja' and idc is null";
		$this->query=$d;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$remision=$row->REMISION;

		$vcaja="SELECT COUNT(STATUS) as STATUS
					FROM CAJAS
    				WHERE (STATUS = 'abierto' or ( STATUS='cerrado' and  FACTURA= '' and REMISION= '')) 
    				AND CVE_FACT = '$facturanuevacaja'";
    	$this->query=$vcaja;
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$val=$row->STATUS;
    	if($val== 0){
		$this->query="INSERT INTO CAJAS (FECHA_CREACION,STATUS,CVE_FACT, FACTURA, REMISION, envio, rev_dospasos, usuario_caja, cr, dias_revision, cc, dias_pago, IMP_COMP_REENRUTAR)
					  VALUES(current_timestamp,'abierto','$facturanuevacaja', '$factura','$remision', '$envio', '$revdp', '$usuario','$cr', '$dr', '$cc','$dp', 'Nu')";
		$resultado = $this->EjecutaQuerySimple();

		}

		return $resultado;

	}

	function ValidaCajasAbiertas($facturanuevacaja){
		$this->query = "SELECT COUNT(STATUS) AS CAJAS FROM CAJAS
    				WHERE (STATUS = 'abierto' or ( STATUS='cerrado' and  FACTURA= '' and REMISION= '')) 
    				AND CVE_FACT='$facturanuevacaja'";
   		$resultado = $this->QueryObtieneDatosN();
		$row=ibase_fetch_object($resultado);
		$cajas = $row->CAJAS;
		
		return $cajas;
	}

	function ConsultaRO($buscar){
		//var_dump($buscar);
		$this->query = "SELECT a.*, c.nombre AS PROVEEDOR
						FROM REGISTRO_OPERADORES a 
						LEFT JOIN (COMPO01 b
						LEFT JOIN PROV01 c ON b.cve_clpv = c.CLAVE) 
						ON a.documento = b.CVE_DOC 
						WHERE 
						 a.DOCUMENTO = '$buscar' OR a.OPERADOR CONTAINING '$buscar' OR a.UNIDAD = '$buscar' ";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		//var_dump($data);
		return @$data;
	}
	
	function CabeceraConsultaRO($buscar){
		$this->query = "SELECT FIRST 1 ID, OPERADOR, UNIDAD FROM REGISTRO_OPERADORES WHERE DOCUMENTO = '$buscar' OR OPERADOR CONTAINING '$buscar' OR UNIDAD = '$buscar'
						GROUP BY ID,OPERADOR,UNIDAD ORDER BY ID ASC";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_row($resultado)){
			$data[] = $tsArray;
		}
		//var_dump($data);
		return @$data;
	}

	function RutasDelDia(){
		$this->query="SELECT a.cve_doc, b.nombre, a.fecha_pago, a.pago_tes, a.tp_tes, a.pago_entregado, c.camplib2 , a.unidad, a.estado, a.fechaelab, (datediff(day, a.fechaelab, current_date )) as Dias, a.urgencia, b.codigo, b.estado as estadoprov, a.unidad
					    from compo01 a
						left join prov01 b on a.cve_clpv = b.clave
						left join compo_clib01 c on a.cve_doc = c.clave_doc
						where a.ruta = 'A' AND idu IS NOT NULL AND STATUS_LOG = 'secuencia' 
						AND  FECHA_SECUENCIA >= dateadd(-1 day to current_date)";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}

	function RutasDelDiaEntrega(){
		$a="SELECT a.*, c.nombre, c.estado, c.codigo, b.fechaelab, b.cita, b.importe, (datediff(day,b.fechaelab,CURRENT_DATE)) as Dias 
		    FROM CAJAS a
			LEFT JOIN FACTF01 b on a.cve_fact = b.cve_doc
			LEFT JOIN CLIE01 c on b.cve_clpv = c.clave
			where UNIDAD is not null  ";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}


	function DataRecepcionesAC(){
    	$this->query="SELECT a.*, b.NOMBRE AS PROVEEDOR, c.OPERADOR, c.NUMERO AS UNIDAD, d.FECHA_SECUENCIA, d.STATUS_LOG
    				  from compr01 a
    				  left join prov01 b on a.cve_clpv = b.clave 
    				  left join compo01 d on a.doc_ant = d.cve_doc
    				  left join unidades c on d.unidad = c.numero 
    				  where a.status <> 'C' AND  (a.status_rec <> 'ok' OR a.status_rec is null)";

    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

	 function DataRecepcionAC($recepcion){
    	$this->query="SELECT a.CVE_DOC,a.DOC_ANT,a.FECHAELAB, a.ENLAZADO, b.NOMBRE AS PROVEEDOR, c.OPERADOR, c.NUMERO AS UNIDAD, d.FECHA_SECUENCIA, d.STATUS_LOG
    				  from compr01 a
    				  left join prov01 b on a.cve_clpv = b.clave 
    				  left join compo01 d on a.doc_ant = d.cve_doc
    				  left join unidades c on d.unidad = c.numero 
    				  where a.CVE_DOC = '$recepcion'
    				  GROUP BY a.CVE_DOC,a.DOC_ANT,a.FECHAELAB, a.ENLAZADO, b.NOMBRE, c.OPERADOR, c.NUMERO, d.FECHA_SECUENCIA, d.STATUS_LOG";
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
	function PartidasRecepcionAC($recepcion){
    		$this->query="SELECT a.NUM_PAR, b.DESCR, a.CANT, a.COST, a.TOTIMP4 , a.TOT_PARTIDA
    				  FROM PAR_COMPR01 a 
    				  LEFT JOIN  inve01 b 
    				  ON b.CVE_ART = a.CVE_ART 
    				  WHERE CVE_DOC = '$recepcion'";
    		$result=$this->QueryObtieneDatosN();
    		while ($tsArray=ibase_fetch_object($result)){
    			$data[]=$tsArray;
    		}
    		return $data;
	    }

	function OrdenSinRecepcion(){
		$this->query="SELECT a.cve_doc, b.nombre, a.fecha_pago, a.pago_tes, a.tp_tes, a.pago_entregado, c.camplib2 , a.unidad, a.estado, a.fechaelab, (datediff(day, a.fechaelab, current_date )) as Dias, a.urgencia, b.codigo, b.estado as estadoprov, a.unidad
					    from compo01 a
						left join prov01 b on a.cve_clpv = b.clave
						left join compo_clib01 c on a.cve_doc = c.clave_doc
						where STATUS_LOG != 'Nuevo' AND DOC_SIG IS NULL";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}


	function Cajas(){
		  $a="SELECT a.*, c.NOMBRE, d.CAMPLIB7, c.CODIGO, b.FECHAELAB, b.importe, b.cita, (datediff(day, b.fechaelab, current_date)) as DIAS, b.DOC_SIG
		    FROM CAJAS a
		    left join factP01 b on b.cve_doc = a.cve_fact
		    left join clie01 c on b.cve_clpv = c.clave
		    left join CLIE_CLIB01 d on d.cve_clie = c.clave
		    WHERE a.STATUS='abierto'";  
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function CerrarCaja($idcaja, $docf){
		

		$this->query="SELECT iif(sum(pxf) is null, 0, sum(pxf)) as pxf from CONTROL_FACT_REM where caja = $idcaja";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$pxf = $row->PXF;
		
		if($pxf==0){
			$a="UPDATE CAJAS SET STATUS = 'cerrado', ruta = 'N', Docs = 'No' where id = $idcaja and CVE_FACT = '$docf'";
			$this->query=$a;
			$result=$this->EjecutaQuerySimple();
		}else{
			echo 'Se debe de facturar lo embalado!!!!!';
		}
		
		
		return;
	}

	/* QUITAR FUNCION YA QUE NO TIENE CASO SOLO BORRARLOS  PENDIENTE

	function cierraPar($idcaja, $docf){
		$b="UPDATE PAQUETES SET IDCAJA=NULL, PESO= NULL, LARGO=NULL, ANCHO=NULL, ALTO=NULL WHERE IDCAJA=$idcaja and DOCUMENTO='$docf' AND EMBALADO IS NULL";
		$this->query=$b;
		$result=$this->EjecutaQuerySimple();
		return $result; 
	}
*/
	function RutaEntregaSecuencia($idcaja, $docf,  $estado, $unidad){
   		#echo "Este es el valor de unidad: ".$unidad;
		$TIME = time();
		$HOY = date("Y-m-d");
		$date=DateTime::createFromFormat('Y-m-d',$HOY);
		$formatdate=$date->format('m-d-Y');
		$idunidad = "SELECT IDU FROM UNIDADES WHERE NUMERO = '$unidad'";
		$this->query = $idunidad;
		$result=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($result);
		$idunidad=$row->IDU;

		$this->query="UPDATE cajas
					  SET UNIDAD = '$unidad', RUTA = 'A', fecha_secuencia = current_timestamp, idu= '$idunidad', STATUS_LOG = 'secuencia', STATUS_MER = '', DOCS = 'No'
					  WHERE CVE_FACT = '$docf'";
		$rs = $this->EjecutaQuerySimple();
		return $rs;
	}

	function AsignaSecEntrega($unidad){
		$a="SELECT a.*, c.nombre, c.estado, c.codigo, b.fechaelab, (datediff(day,b.fechaelab,current_date)) as dias, 
			b.cve_doc as FACTURA, iif(a.factura is null or a.factura = '', r.importe, b.importe) as importe
		    FROM CAJAS a
		    LEFT JOIN FACTP01 d ON a.cve_fact = d.cve_doc
		    LEFT JOIN FACTF01 b on d.cve_doc = b.doc_ant 
		    left join factr01 r on a.remision = r.cve_doc
		    LEFT JOIN CLIE01 c on d.cve_clpv = c.clave
		    where idu = '$unidad' and a.secuencia is null and a.status_log = 'secuencia' ";
		 $this->query=$a;
		 $result=$this->QueryObtieneDatosN();
		 while($tsArray=ibase_fetch_object($result)){
		 	$data[]=$tsArray;
		 }
		 return @$data;
	}
 	
 	function AsignaSecEntrega2($prove, $secuencia, $uni, $fecha, $idu){
		$a="SELECT a.*, c.nombre, c.estado, c.codigo, b.fechaelab, (datediff(day,b.fechaelab,current_date)) as dias, 
			b.cve_doc as FACTURA, iif(a.factura is null or a.factura = '', r.importe, b.importe) as importe
		    FROM CAJAS a
		    LEFT JOIN FACTP01 d ON a.cve_fact = d.cve_doc
		    LEFT JOIN FACTF01 b on d.cve_doc = b.doc_ant 
		    left join factr01 r on a.remision = r.cve_doc
		    LEFT JOIN CLIE01 c on d.cve_clpv = c.clave 
		    where idu = $idu";
		 $this->query=$a;
		 $result=$this->QueryObtieneDatosN();
		 while($tsArray=ibase_fetch_object($result)){
		 	$data[]=$tsArray;
		 }
		 return $data;
	}

	function AsignaSecuenciaEntrega($idu, $clie, $unidad, $secuencia, $docf, $idcaja){
		$a="UPDATE CAJAS 
		    SET SECUENCIA = $secuencia, status_log = 'admon', fecha_secuencia = current_timestamp, STATUS_MER ='', vueltas=vueltas + 1
		    where id = $idcaja";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		return $result;
	}

	function buscaOC2($doco){

		if(substr($doco,0,2) <> 'OP'){
			$this->query="SELECT OC.CVE_DOC, oc.fecha_doc, OC.FECHAELAB, OC.IMPORTE, OC.STATUS_LOG, OC.STATUS_REC, OC.STATUS_LOG2, OC.UNIDAD, OC.TP_TES, OC.PAGO_TES, P.NOMBRE, '' as status FROM COMPO01 OC LEFT JOIN PROV01 P ON P.CLAVE = OC.CVE_CLPV WHERE upper(CVE_DOC) =upper('$doco')";
		}else{
			$this->query="SELECT  ftc.oc as cve_doc, ftc.fecha_oc as fecha_doc, ftc.fecha_oc as fechaelab, ftc.costo_total as importe, ftc.status_log, ftc.status_recepcion as status_rec, ftc.status_log2, ftc.unidad, ftc.tp_tes, ftc.pago_tes, p.nombre, ftc.status 
			from ftc_poc ftc
			left join prov01 p on p.clave = ftc.cve_prov
			where upper(ftc.oc) = upper('$doco')";	
		}

		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}


	
	function partidasLiberadas($doco){
		$this->query="SELECT p.*, 
						(select i.descr from inve01 i where i.cve_art = p.cve_art) as nombreinve,
						(select pf.nombre from producto_ftc pf where pf.clave = p.cve_art) as nombreftc
						FROM PAR_COMPO01 p
						 WHERE CVE_DOC = '$doco' and (status = 'L' or status = 'D')";
						 //echo $this->query;
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}

	function partidasValidadas($doco){
		$this->query="SELECT vr.*, 
						(select i.descr from inve01 i where i.cve_art = vr.producto) as nombreinve,
						(select pf.nombre from producto_ftc pf where pf.clave = vr.producto) as nombreftc,
						(select pc.cant from par_compo01 pc where pc.cve_art = vr.producto and pc.num_par = vr.partida and pc.cve_doc = '$doco') as cant_oc,
						(select max(CANT_ACUMULADA) from VALIDA_RECEPCION vr1 where vr1.id_Preoc = vr.id_Preoc) as totalValidaciones
						FROM VALIDA_RECEPCION vr
						WHERE DOCUMENTO = '$doco'";
						//echo $this->query;
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}

	function recepcionDeOrdenes($doco){
		$this->query="SELECT pr.*,
		 				(select i.descr from inve01 i where i.cve_art = pr.cve_art) as nombreinve,
						(select pf.nombre from producto_ftc pf where pf.clave = pr.cve_art) as nombreftc
						from compr01 r 
						left join compo01 oc on oc.cve_doc = r.doc_ant
						left join par_compr01 pr on pr.cve_doc = r.cve_doc
				where oc.cve_doc  = '$doco'";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}


	function historiaIDPREOC($id){
		$this->query="SELECT p.*, 
							(select iif(sum(cantidad) is null, 0, sum(cantidad)) from ftc_poc_detalle where idPreoc = p.id and oc is null ) as cant_preoc,
							(select sum(pxr) from par_compo01 where id_preoc = p.id) as enordenes, 
							(select sum(pxr) from FTC_POC_DETALLE where idpreoc = p.id and oc is not null) as enordenesn,
							(select sum(cantidad_rec) from ftc_detalle_recepciones where idpreoc = p.id) as recibidon
							FROM PREOC01 p 
							WHERE p.ID = $id";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function ordenesIDPREOC($id){

		$data=array();
		$this->query="SELECT 'N/A' AS CVE_FTCPOC, poc.status_log2, poc.pxr, poc.id_preoc, oc.realiza, poc.cant, poc.cve_doc, poc.num_par, 
						oc.tp_tes, oc.fecha_pago, oc.status_log as status_orden, oc.unidad, oc.fecha_secuencia,
						(select nombre from producto_ftc pftc where poc.cve_art = pftc.clave) as nombreftc,
						(select camplib7 from inve_clib01 i where i.cve_prod = poc.cve_art) as nombreinve,
						(select sum(cantidad_rec) from FTC_DETALLE_RECEPCIONES WHERE ORDEN = oc.cve_doc and partida = poc.num_par) as cantidad_rec,
						'' as status_real 
						from par_compo01 poc 
						left join compo01 oc on oc.cve_doc = poc.cve_doc 
						where poc.id_preoc = $id";
		$rs=$this->EjecutaQuerySimple();
		//echo $this->query.'<p>';
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
			}	
		
		

		$this->query="SELECT ftcpocd.cve_doc as cve_ftcpoc,ftcpocd.status_log2, ftcpocd.pxr, ftcpocd.idpreoc as id_preoc, ftcpoc.usuario_oc as realiza,ftcpocd.cantidad as cant, ftcpocd.oc as cve_doc, ftcpocd.partida as num_par, 
						ftcpoc.tp_tes, ftcpoc.fecha_pago, ftcpoc.status as status_orden, ftcpoc.unidad, ftcpoc.fecha_secuencia,
                        (select nombre from producto_ftc ftcp where ftcpocd.art = ftcp.clave) as nombreftc,
                        (select sum(cantidad_rec) from ftc_detalle_recepciones where orden = ftcpocd.oc and partida = ftcpocd.partida) as cantidad_rec,
                      	status_real
                      from FTC_POC_DETALLE ftcpocd
                      left join ftc_poc ftcpoc on ftcpoc.oc = ftcpocd.oc
                       where idpreoc = $id";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		//echo $this->query.'<p>';

		return @$data;
	}

	function validacionesIDPREOC($id){
		$this->query="SELECT vr.*, 
						(select i.descr from inve01 i where i.cve_art = vr.producto) as nombreinve,
						(select pf.nombre from producto_ftc pf where pf.clave = vr.producto) as nombreftc,
						(select max(CANT_ACUMULADA) from VALIDA_RECEPCION vr1 where vr1.id_Preoc = vr.id_Preoc) as totalValidaciones
						FROM VALIDA_RECEPCION vr
						WHERE id_preoc = $id";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function recepcionesIDPREOC($id){
		$data=array();
		$this->query="SELECT pr.*, 
							(select nombre from producto_ftc pftc where pr.cve_art = pftc.clave) as nombreftc,
						(select camplib7 from inve_clib01 i where i.cve_prod = pr.cve_art) as nombreinve  
						FROM PAR_COMPR01 pr
						left join compr01 r on r.cve_doc = pr.cve_doc
						WHERE ID_PREOC = $id";
		$rs=$this->EjecutaQuerySimple();
			while($tsArray=ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}
		return @$data;
	}


	function recepcionesNuevasIDPREOC($id){
		$this->query="SELECT * FROM FTC_DETALLE_RECEPCIONES ftcr left join preoc01 poc on poc.id = ftcr.idpreoc left join producto_ftc pftc on pftc.clave = poc.prod WHERE IDPREOC = $id";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		
		return @$data;
	}

		function AsignaSec3($idu){
		$this->query="SELECT  b.NOMBRE, count (a.cve_doc) as cve_doc, MAX(current_date ) as Fecha, MAX (b.codigo) as codigo, MAX (b.estado) as ESTADOPROV, MAX (b.codigo) as codigo, MAX(unidad) as unidad, MAX (datediff(day, a.fechaelab, current_date )) as Dias, max(a.cve_clpv) as prov, max(idu) as IDU
                       from compo01 a
                       left join PROV01 b on a.cve_clpv = b.clave
                       where a.idu = $idu and secuencia is null
                        group by b.nombre ";

     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;

     	}

     		return $data;  	
	}
		
//################# Ordenes de compra a avanzar #################
	function DataOrdenesAA(){
		$this->query = "SELECT a.CVE_DOC, b.NOMBRE AS PROVEEDOR, a.FECHAELAB, a.IMPORTE, a.STATUS, datediff(day FROM FECHAELAB TO current_date) AS DIAS
						FROM COMPO01 a INNER JOIN PROV01 b
						ON a.CVE_CLPV = b.CLAVE 
						WHERE DOC_SIG IS NULL AND STATUS_LOG != 'Falso' AND a.STATUS != 'C'
						ORDER BY DIAS";	
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}
		
	function DataOrdenAA($idorden){
		$this->query = "SELECT a.CVE_DOC, b.NOMBRE AS PROVEEDOR, a.FECHAELAB, a.IMPORTE, a.STATUS, datediff(day FROM FECHAELAB TO current_date) AS DIAS
						FROM COMPO01 a INNER JOIN PROV01 b
						ON a.CVE_CLPV = b.CLAVE 
						WHERE a.CVE_DOC = '$idorden' ";
		
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}
	
	function PartidasOrdenAA($idorden){
		$this->query = "SELECT a.CVE_DOC,a.NUM_PAR, a.ID_PREOC, a.CVE_ART, b.DESCR, a.CANT, a.PXR, a.TOT_PARTIDA, a.FECHA_DOC_RECEP
						FROM PAR_COMPO01 a INNER JOIN INVE01 b ON a.CVE_ART = b.CVE_ART
						WHERE a.CVE_DOC = '$idorden' AND PXR > 0  AND FOLIO_FALSO IS NULL";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
	}
	
	function ObtienFolioFalso(){
		$this->query = "SELECT COUNT(FOLIO_FALSO) FROM COMPO01 WHERE FOLIO_FALSO IS NOT NULL ";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_row($resultado)){
			$data[] = $tsArray;			
		}
		return $data;
	}

	function AvanzaCompo($idorden, $folio){
		$this->query = "UPDATE COMPO01 SET STATUS_LOG = 'Falso', FOLIO_FALSO = 'F-'||'$folio'   WHERE CVE_DOC = '$idorden'";
		$resultado = $this->EjecutaQuerySimple();
		
		return $resultado;
	}	

	function ObtienFolioFalsoPar(){
		$this->query = "SELECT COUNT(FOLIO_FALSO) FROM PAR_COMPO01 WHERE FOLIO_FALSO IS NOT NULL ";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_row($resultado)){
			$data[] = $tsArray;			
		}
		return $data;
	}
	
	function AvanzaParCompo($idorden, $partida, $folio){
		$this->query = "UPDATE PAR_COMPO01 SET PXR = 0.00, FOLIO_FALSO = 'F-'||'$folio' WHERE CVE_DOC = '$idorden' AND NUM_PAR = '$partida' ";
		$resultado = $this->EjecutaQuerySimple();
		//var_dump($partida);
		return $resultado;
	}
	
	function ValidarPartidas($idorden){
		$this->query = "SELECT COUNT(NUM_PAR) FROM PAR_COMPO01 WHERE CVE_DOC = '$idorden' AND FOLIO_FALSO IS NULL";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_row($resultado)){
			$data[] = $tsArray;			
		}
		return $data;
	}
		
//################# Finaliza orden de compra a avanzar #################
//// Produntos por RFC

	function prodxrfc($rfc){
		$a="SELECT a.clave 
				from clie01 a 
				where RFC = '$rfc'";
			$this->query=$a;
			$result=$this->QueryObtieneDatosN();
			while($tsArray=ibase_fetch_object($result)){
				$data2[]="'".$tsArray->CLAVE."'";
				$claves=implode(",",$data2);
		}

		//$b="SELECT A.PROD, max(ID) as ID, max(COTIZA) AS COTIZA, MAX(NOMPROD) AS NOMPROD, SUM(CANTI) AS CANTI, AVG(b.prec) AS PREC, SUM(CANT_ORIG) AS CANT_ORIG, MAX(NOM_CLI) AS NOM_CLI, MAX(CLIEN) AS CLIEN, MAX(FECHASOL) AS FECHASOL, AVG(PREC) AS PREC
		//		FROM PREOC01 a
		//		left join par_factp01 b on a.cotiza = b.cve_doc and a.par = b.num_par
		//		WHERE CLIEN in ($claves) group by PROD";

		$b="SELECT P.*, par.prec FROM PREOC01 P left join par_factp01 par on par.cve_doc = P.cotiza and par.num_par = P.par WHERE CLIEN IN ($claves)";				
			$this->query=$b;
			$result=$this->QueryObtieneDatosN();
			while($tsArray=ibase_fetch_object($result)){
				$data[]=$tsArray;
			}
		return $data;
	
		}
                
           function DatosUnidad($unidad){
               $this->query = "SELECT numero, marca, modelo, placas, operador, coordinador FROM unidades WHERE idu = $unidad";
               $resultado = $this->QueryObtieneDatosN();
               while($tsArray = ibase_fetch_row($resultado)){
                $data[] = $tsArray;
               }
               return $data;
               
           }

        function recibirDoc($doc, $docf, $docr){
        	$tabla='COMPO01';
        	$campo='cve_doc';
        	
        	if(substr($doc, 0, 1) != 'O'){
        	$tabla='CAJAS';
        	$campo='CVE_FACT';        		
        	}elseif(substr($doc,0, 2) == 'OP'){
        		$tabla = 'FTC_POC';
        		$campo = 'OC';
        	}
        	if($tabla == 'COMPO01'){
        		$a="UPDATE $tabla set docs = 'S',  RUTA = 'A' where $campo = '$doc'";
        	}elseif($tabla == 'CAJAS'){
        		$a="UPDATE $tabla set docs = 'S',  RUTA = 'N' where $campo = '$doc'";
        	}elseif($tabla == 'FTC_POC'){
        		$this->query="UPDATE FTC_POC_DETALLE SET STATUS_REAL = 'LOGISTICA 2' WHERE OC = '$doc'";
        		$this->EjecutaQuerySimple();

        		$a="UPDATE $tabla set docs = 'S', RUTA = 'A' where $campo = '$doc'";

        	}
        	//echo $a;
        	$this->query=$a;
        	$result=$this->EjecutaQuerySimple();


        	if(!empty($docf)){$this->query="UPDATE factf01 set status_fact = 'Logistica' where cve_doc = '$docf'";        	
        	$rs = $this->EjecutaQuerySimple();}

        	if(!empty($docr)){$this->query="UPDATE FACTR01 SET status_rem = 'Logistica' where cve_doc = '$docr'"; 
        	$rs=$this->EjecutaQuerySimple();}


        	return $result;
        }

   function AsignaSecDetalle($unidad){
            $this->query = "SELECT a.CVE_DOC, a.FECHA_DOC,a.CVE_CLPV, datediff(day, a.fechaelab, current_date) AS DIAS, b.nombre, a.vueltas, 
            				b.estado, b.estado , b.codigo, a.fechaelab, a.unidad, a.fecha_pago, a.tp_tes, a.pago_tes, A.IMPORTE, a.idu, b.clave as prov
                            from compo01 a
                            left join PROV01 b on a.cve_clpv = b.clave
                            where IDU = '$unidad' and secuencia is null";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }

            $this->query="SELECT ftc.oc as cve_doc, ftc.fecha_oc as fecha_doc, ftc.cve_prov as cve_clpv, datediff(day, ftc.fecha_oc, current_date) as dias, p.nombre, ftc.vueltas, 
            				p.estado, p.codigo, ftc.fecha_oc as fechaelab, ftc.unidad, ftc.fecha_pago, ftc.tp_tes, ftc.pago_tes, ftc.costo_total as importe, ftc.idu, p.clave as prov 
            				from ftc_poc ftc 
            				left join prov01 p on p.clave = ftc.cve_prov
            				where ftc.idu = $unidad and ftc.status = 'LOGISTICA' and status_log = 'secuencia'";

            //echo $this->query;
			$resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }            
            return $data;
        }

        function RutaUnidadRec($idr){
        	$HOY = date("Y-m-d");
        	$today = getdate();
			if($today['wday'] == 1){
				$a="SELECT iif(a.doc_sig is null,'No', a.doc_sig) as DOC_SIG,
                         a.*,
                         b.nombre,
                         b.ESTADO,
                         b.codigo,
                         datediff(day,a.fechaelab, current_date) as DIAS,
                         current_date as HOY,
                         a.cierre_uni as cierre
                         FROM COMPO01 a
                         LEFT JOIN PROV01 b on a.cve_clpv = b.clave
                         WHERE IDU = $idr AND (FECHA_SECUENCIA between DATEADD(DAY,-4,current_date)
                         and cast('TOMORROW' AS DATE))
                         and
                         (cierre_uni is null or cierre_uni != 'impreso') and (status_log != 'admon' and Status_log != 'Nuevo' and status_log != 'secuencia')";
        		///echo $a;
			}else{
        	$a="SELECT iif(a.doc_sig is null,'No', a.doc_sig) as DOC_SIG, a.*, b.nombre, b.ESTADO, b.codigo, datediff(day,a.fechaelab, current_date) as DIAS, current_date as HOY, a.cierre_uni as cierre 
        		FROM COMPO01 a 
        		LEFT JOIN PROV01 b on a.cve_clpv = b.clave
        		WHERE IDU = $idr AND (FECHA_SECUENCIA between CAST('YESTERDAY'AS date)  and cast('TODAY' AS DATE)) and (cierre_uni is null or cierre_uni != 'impreso') and (status_log != 'admon' and Status_log != 'Nuevo' and status_log != 'secuencia')";
        		//echo $a; (fecha_rev between CAST('TODAY' AS DATE) AND CAST('TOMORROW' AS DATE)  
        	}

        	$this->query=$a;
        	$result=$this->QueryObtieneDatosN();
        	while($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}  

        	return @$data;
        }

       function RutaUnidadEnt($idr){
       		$HOY = date("Y-m-d");
        	$today = getdate();
			if($today['wday'] == 1){
			$b="SELECT a.*, d.nombre, d.estado, d.codigo, b.fechaelab, c.fechaelab as fechfact, c.cve_doc as factura, datediff(day, c.fechaelab, current_date) as Dias, a.Docs, a.idu, a.val_aduana as aduana, iif(a.factura is null or a.factura = '', a.remision, a.factura) as documento
        		FROM CAJAS a
        		left join factp01 b on a.cve_fact = b.cve_doc
        		left join factf01 c on b.cve_doc = c.doc_ant
        		left join Clie01 d on d.clave = b.cve_clpv
        		WHERE IDU = $idr and (cierre_uni is null or cierre_uni != 'impreso') 
        		AND FECHA_SECUENCIA >= DATEADD(DAY, -4 , current_date) 
        		AND (a.STATUS_LOG = 'Entregado' or a.status_log = 'NC' or a.status_log = 'Reenviar' or a.status_log = 'Recibido')";
        	
			}else{
        	$b="SELECT a.*, d.nombre, d.estado, d.codigo, b.fechaelab, c.fechaelab as fechfact, c.cve_doc as factura, datediff(day, c.fechaelab, current_date) as Dias, a.Docs, a.idu, a.val_aduana as aduana, iif(a.factura is null or a.factura = '', a.remision, a.factura) as documento
        		FROM CAJAS a
        		left join factp01 b on a.cve_fact = b.cve_doc
        		left join factf01 c on b.cve_doc = c.doc_ant
        		left join Clie01 d on d.clave = b.cve_clpv
        		WHERE IDU = $idr and (cierre_uni is null or cierre_uni != 'impreso') AND FECHA_SECUENCIA >= cast('YESTERDAY' as date) AND (a.STATUS_LOG = 'Entregado' or a.status_log = 'NC' or a.status_log = 'Reenviar' or a.status_log = 'Recibido')";
        	}
        	$this->query=$b;
        	$result=$this->QueryObtieneDatosN();
        	while($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}  
        	return $data;
        }

      

      
     function RegresaDocs($doc, $idr, $docs){

        	$pedido=strrpos($doc,'P');
    			$tabla = 'COMPO01';
        		$campo = 'CVE_DOC';
    		if ($pedido !== false){
    			$tabla='CAJAS';
    			$campo='CVE_FACT';
    		}

    		//echo $docs;
    		if($docs == 'No'){
    			$b="UPDATE $tabla set docs = 'Si' where $campo = '$doc'";
    		//	echo $b;
        		$this->query=$b;
        		$result=$this->EjecutaQuerySimple();
        		return $result;
    		}

        	$b="UPDATE $tabla set docs = 'N' where $campo = '$doc'";
        	$this->query=$b;
        	$result=$this->EjecutaQuerySimple();
        	return $result;
        }

      function CerrarOC($doc,$idr,$tipo,$idc){
        	$pedido=substr($doc, 0, 1);        	
        	$tabla='COMPO01';
        	$campo='CVE_DOC';
        	if($pedido <> 'O'){
        		$tabla='CAJAS';
        		$campo='ID';
        	};
        	if ($tipo == 'Parcial'){
        		$valor = 'Parcial';
 	       	}elseif($tipo =='Tiempo'){
 	       		$valor ='Tiempo';
        	}else{
        		$valor='ok';
        	};
        	if ($campo == 'ID'){
        		$c="UPDATE $tabla set cierre_uni = '$valor' where $campo=$idc";
        	}else{
        		$c="UPDATE $tabla set cierre_uni = '$valor' where $campo='$doc'";
        	}
           	//echo "Valor de la consulta: ".$c;
        	$this->query=$c;
        	$result=$this->EjecutaQuerySimple();
        	return $result;
        }



        function RutaUnidadRecGen(){
        	$a="SELECT a.*, b.nombre, CURRENT_DATE as HOY, datediff(day,a.fechaelab, current_date) as DIAS 
        		FROM COMPO01 a 
        		LEFT JOIN prov01 b on a.cve_clpv = b.clave
        		WHERE (FECHA_SECUENCIA between CAST('TODAY'AS date)  and cast('YESTERDAY' AS DATE)) 
        		AND CIERRE_TOT IS NULL";
        	$this->query=$a;
        	$result=$this->QueryObtieneDatosN();
        	while($tsArray=ibase_fetch_object($result)){

        		$data[]=$tsArray;
        	}
        	return $data;
        }

        function CerrarGen(){
        	$b="SELECT fecha_secuencia, count(a.cve_doc) as Documentos, count (a.cierre_uni) as DOCS
                FROM COMPO01 a 
                LEFT JOIN prov01 b on a.cve_clpv = b.clave
                WHERE FECHA_SECUENCIA = current_date AND CIERRE_TOT IS NULL
                group by fecha_secuencia";
             $this->query=$b;
             $result=$this->QueryObtieneDatosN();
             $row=ibase_fetch_object($result);
             $Docs=$row->DOCUMENTOS;
             $Cerrados=$row->DOCS;
             if ($Docs == $Cerrados){
             	$var= true;
             }else{
             	$var=false;
             }
             return $var;
        }

		function CerrarRutasRecoleccion($documentos){
            $arrayLength = count($documentos);
            for($contador = 0; $contador < $arrayLength; $contador++){
                if((substr($documentos[$contador][0],0,1)) == 'P'){
                    $tabla = 'CAJAS';
                    $campo = 'CVE_FACT';
                } else{
                    $tabla = 'COMPO01';
                    $campo = 'CVE_DOC';
                }

                $doc = $documentos[$contador][0];
                $vueltas = (int)$documentos[$contador][2];
               // var_dump($vueltas);
                if($vueltas >= 5){
                    $this->query = "UPDATE $tabla SET STATUS_LOG = 'Fallido' WHERE $campo = '$doc'";
                    }else{
                        switch ($documentos[$contador][1]) {
                                case 'Total':
                                    $this->query = "UPDATE $tabla SET CIERRE_TOT = 'OK', VUELTAS = VUELTAS + 1 WHERE $campo = '$doc' ";
                                    break;
                                case 'Parcial':
                                    $this->query = "UPDATE $tabla SET STATUS_LOG = 'Parcial', RUTA = 'N', SECUENCIA = NULL, UNIDAD = NULL, idu = NULL, VUELTAS = VUELTAS + 1, CIERRE_TOT = 'R' WHERE $campo = '$doc'";
                                    break;
                                case 'Tiempo':
                                    $this->query = "UPDATE $tabla SET STATUS_LOG = 'Nuevo', RUTA = 'N', SECUENCIA = NULL, UNIDAD = NULL, idu = NULL, VUELTAS = VUELTAS + 1 WHERE $campo = '$doc'";
                                    break;
                                case 'PNR':
                                    $this->query = "UPDATE $tabla SET CIERRE_TOT = 'OK', VUELTAS = VUELTAS + 1 WHERE $campo = '$doc' ";
                                    break;
                                case 'Fallido':
                                    $this->query = "UPDATE $tabla SET CIERRE_TOT = 'OK', VUELTAS = VUELTAS + 1 WHERE $campo = '$doc' ";
                                    break;
                                case 'Reenvio':
                                    $this->query = "UPDATE $tabla SET CIERRE_TOT = 'OK', VUELTAS = VUELTAS + 1 WHERE $campo = '$doc' ";
                                    break;
                                case 'Tiempo2':
                                	 $this->query = "UPDATE $tabla SET STATUS_LOG = 'FalloProv', RUTA = 'N', SECUENCIA = NULL, UNIDAD = NULL, idu = NULL, VUELTAS = VUELTAS + 1, CIERRE_TOT = 'R' WHERE $campo = '$doc'";
                                    break;
                                default:
                                    break;
                            }
                    }
                $resultado = $this->EjecutaQuerySimple();
            }
         return $resultado;
        }


        function VentasVsCobrado($fechaini, $fechafin, $vend){
            if(!empty($vend))
                $filtrovend = "and v.nombre LIKE '($vend%'";
                else
                    $filtrovend = " ";


           	$this->query="SELECT f.*, iif(substring(trim(fa.doc_ant) from 1 for 1) = '0',
						(select fr.doc_ant from factr01 fr where fr.cve_doc = fa.doc_ant) , fa.doc_ant) as doc_ant, u.NOMBRE AS NOMBREVENDEDOR
						FROM FACTURAS f 
						left join factf01 fa on fa.cve_doc = f.cve_doc 
						left join PG_USERS u on u.letra_nueva = substring(iif(substring(trim(fa.doc_ant) from 1 for 1) = '0',
						(select fr.doc_ant from factr01 fr where fr.cve_doc = fa.doc_ant) , fa.doc_ant) from 1 for  1) and (u.sub_letra is null or u.sub_letra = '')
						where UPPER(f.vendedor) containing UPPER('')
						AND f.fecha_doc BETWEEN '$fechaini' AND '$fechafin' order by u.nombre";
            
           /* $this->query = "SELECT
                                cm.CVE_CLIE AS CLIENTE,
                                cm.REFER AS REFERENCIA,
                                iif(fd.CVE_DOC IS NULL, '',fd.CVE_DOC) AS NC_ASOCIADA,
                                cm.FECHAELAB AS FECHA_ELABORACION,
                                cd.FECHA_APLI AS FECHA_APLICACION,
                                cm.IMPORTE AS IMPORTE_VENDIDO,
                                SUM(iif(cd.IMPORTE IS null, 0, cd.IMPORTE)) AS IMPORTE_COBRADO,
                                iif(fd.IMPORTE IS NULL, 0, fd.IMPORTE) AS IMPORTE_NC,
                                round(cm.IMPORTE,2) - round((iif(fd.IMPORTE IS NULL, 0, fd.IMPORTE)),2) AS VENTA_REAL,
                                round(cm.IMPORTE,2) - round(SUM(iif(cd.IMPORTE IS null, 0, cd.IMPORTE)),2) AS SALDO,
                                iif(v.nombre IS NULL, '', v.nombre) AS VENDEDOR,
                                (cm.IMPORTE - (iif(fd.IMPORTE IS NULL, 0, fd.IMPORTE))) - (cm.IMPORTE - SUM(iif(cd.IMPORTE IS null, 0, cd.IMPORTE))) AS VENTA_SALDO,
                                (((cm.IMPORTE - (iif(fd.IMPORTE IS NULL, 0, fd.IMPORTE))) - (cm.IMPORTE - SUM(iif(cd.IMPORTE IS null, 0, cd.IMPORTE)))) / 1.16) * 0.01 AS COMISION
                                FROM
                                    ((cuen_m01 cm
                                    LEFT JOIN factd01 as fd
                                    ON fd.doc_ant = cm.refer)
                                    LEFT JOIN vend01 v
                                    ON v.CVE_VEND = cm.strcvevend)
                                    INNER JOIN cuen_det01 cd
                                    ON cm.refer = cd.refer
								WHERE
								cm.tipo_mov = 'C'
                                GROUP BY
                                cm.CVE_CLIE,
                                cm.REFER ,
                                fd.CVE_DOC,
                                cm.FECHAELAB,
                                cd.FECHA_APLI,
                                cm.IMPORTE,
                                fd.IMPORTE,
                                cm.IMPORTE,
                                v.nombre
								HAVING
								cd.FECHA_APLI BETWEEN '$fechaini' AND '$fechafin'
								$filtrovend
								ORDER BY REFERENCIA";
			*/
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            //var_dump($this->query);
            return $data;
        }
        
        function VerCatGastos(){
            $this->query = "SELECT * FROM CAT_GASTOS WHERE ACTIVO = 'S' ORDER BY ID ASC";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function guardarNuevaCuenta($concepto, $descripcion, $iva, $cc, $cuenta, $gasto, $presupuesto, $retieneiva, $retieneisr, $retieneflete){
            $viva = (!empty($retieneiva) ? $retieneiva : 0);
            $visr = (!empty($retieneisr) ? $retieneisr : 0);
            $vflete = (!empty($retieneflete) ? $retieneflete : 0);
            $this->query= "INSERT INTO CAT_GASTOS (CONCEPTO,DESCRIPCION,CAUSA_IVA,CENTRO_COSTOS,CUENTA_CONTABLE,GASTO,PRESUPUESTO,IVA,ISR,FLETE)
                           VALUES ('$concepto', '$descripcion', '$iva', '$cc', '$cuenta', '$gasto', $presupuesto, $viva, $visr, $vflete)";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        function editCuentaGasto($id){
            $this->query = "SELECT * FROM CAT_GASTOS WHERE ID = $id";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function guardarCambiosCuenta($concepto, $descripcion, $iva, $cc, $cuenta, $gasto, $presupuesto, $id, $retieneiva, $retieneisr, $retieneflete, $activo, $cveprov){
        	if (empty($presupuesto)){
        		$presupuesto = 0;
        	}

        	if (empty($cveprov)){
        		$cveprov ='No';
        		$Nombre = 'No';
        	}else{
        	$a="SELECT NOMBRE FROM PROV01 WHERE CLAVE = '$cveprov'";
        	$this->query=$a;
        	$result=$this->QueryObtieneDatosN();
        	$row=ibase_fetch_object($result);
        	$Nombre=$row->NOMBRE;
        	}

            $this->query= "UPDATE CAT_GASTOS SET CONCEPTO = '$concepto',DESCRIPCION = '$descripcion',CAUSA_IVA = '$iva',
                           CENTRO_COSTOS = '$cc',CUENTA_CONTABLE = '$cuenta',GASTO = '$gasto',PRESUPUESTO = iif($presupuesto=0,presupuesto,$presupuesto), IVA = $retieneiva, ISR = $retieneisr, FLETE = $retieneflete, ACTIVO = '$activo', cve_prov = iif('$cveprov' = 'No',cve_prov, '$cveprov'), proveedor=iif('$Nombre'= 'No', proveedor,'$Nombre')
                           WHERE ID = $id";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        /*editado por GDELEON 3/Ago/2016*/
        function delCuentaGasto($id){
        	/*no eliminar solo cambiar ACTIVO N*/
            //$this->query = "DELETE FROM CAT_GASTOS WHERE ID = $id";
            $this->query = "UPDATE CAT_GASTOS 
            				SET ACTIVO = 'N'
            				WHERE ID = $id";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
		
		/*Modificado por GDELEON 3/Ago/2016*/
        function traeProveedoresGastos(){
            $this->query = "SELECT p.CLAVE, p.NOMBRE
                            FROM PROV01 p 
                            LEFT JOIN PROV_CLIB01 pcl 
                            	ON p.CLAVE = pcl.CVE_PROV
                            WHERE (UPPER(pcl.CAMPLIB2) starting with UPPER('G'))";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

      function LiberarPartidasNoRecibidas($doco, $id_preoc, $pxr, $par){
      		/// cancelacion de Partida
      			if(substr($doco,0,3) == 'AAA'){
      				$doco = substr($doco,3,10);
      				echo 'Se ha Cancelado el ID: '.$id_preoc;
      					$this->query="SELECT * FROM PREOC01 WHERE ID = $id_preoc";
				        	$rs=$this->QueryObtieneDatosN();
				        	//echo $this->query.'<p>';
				        	$row= ibase_fetch_object($rs);
				        	$co= $row->CANT_ORIG;
				        	$cs= $row->CANTI;

				        	if ($cs > $co){
				        		$this->query = "SELECT iif(sum(cant) is null, 0, sum(cant)) as cantpedida FROM FTC_POC_DETALLE WHERE IDPREOC = $id_preoc and status = '2'";
				        		$rs=$this->QueryObtieneDatosN();
				        		$row=ibase_fetch_object($rs);
				        		$cp = $row->CANTPEDIDA;
				        		$this->query="UPDATE preoc01 set canti= ($co-$cp), rest=($co-$cp), ordenado=$cp, status = 'F' where id=$id_preoc";
				        		$rs= $this->EjecutaQuerySimple();
				        		$this->query="UPDATE FTC_POC_DETALLE set pxr = 0, status = 4, status_real = 'Cancelada' where idpreoc = $id_preoc and oc = '$doco'";
				        		$rs=$this->EjecutaQuerySimple();
				        		throw new Exception("Se esta tratando de solicitar mas de lo debido, se reporta a Direccion");
				        		return $rs;
				        	}
				        	echo 'Cantidad de los pendientes pxr: '.$pxr.' valor de Cantidad Original: '.$co.'<p>';
				        	if ($pxr <= $co){
				        		$query = "UPDATE FTC_POC_DETALLE SET";
					    		$query .= " pxr= (pxr - $pxr) ,";
					    		$query .= " status = 5, ";
					    		$query .= " status_log2 = 'Cancelado'";
					    		$query .= " WHERE idpreoc = $id_preoc and oc = '$doco'";
					    		$this->query = $query;
					    		$result = $this->EjecutaQuerySimple();
					    		echo $this->query.'<p>';


				        		$query = "UPDATE PREOC01 SET";
								$query .= " rest= 0,";
								$query .= " canti= 0,";
								$query .= " ordenado= ordenado,";
								$query .= " status='C'";
								$query .= " WHERE id=$id_preoc";
								$this->query = $query;
								$this->EjecutaQuerySimple();

								echo $this->query.'<p>';
								$this->libSaldo($id_preoc, $pxr, $doco);
						
						$this->query="SELECT sum(cantidad_REC) as cantidad FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco'";
		        		$rs=$this->EjecutaQuerySimple();
		        		$row=ibase_fetch_object($rs);


		        		if($row->CANTIDAD > 0){
		        			$this->query="UPDATE FTC_POC SET STATUS = 'CANCELADA_PAR' WHERE OC = '$doco'";
		        			$rs=$this->EjecutaQuerySimple();
		        		}else{
		        			$this->query="UPDATE FTC_POC SET STATUS = 'CANCELADA_TOT' where OC = '$doco'";
		        			$rs=$this->EjecutaQuerySimple();	
		        		}		        
      			}
      			echo 'valor del documento'.$doco;
      				return;	
      		}
      		
      		if(substr($doco,0, 2) == 'OP' or substr($doco,0,3) =='AAA'){
      			$this->query="SELECT STATUS_LOG2 as status from FTC_POC_DETALLE where oc = '$doco' and partida = $par";
      			$rs=$this->EjecutaQuerySimple();
      			$row=ibase_fetch_object($rs);
      			$status =$row->STATUS;
      		}else{
      			$this->query="SELECT STATUS_LOG2 as status FROM PAR_COMPO01 WHERE CVE_DOC = '$doco' and num_par = '$par'"; 
    	  		$rs=$this->EjecutaQuerySimple();
	      		$row=ibase_fetch_object($rs);
      			$status = $row->STATUS;
      		}




      		echo 'Valor de status'.$status;
      		if($status == 'Tesoreria' and substr($doco, 0,2) <> 'OP'){
      				$usuario =$_SESSION['user']->NOMBRE;
					$this->query="SELECT p.clave, p.nombre, oc.fechaelab FROM COMPO01 oc left join prov01 p on p.clave=oc.cve_clpv WHERE CVE_DOC = '$doco'";
					$rs=$this->EjecutaQuerySimple();
					$row=ibase_fetch_object($rs);
					$cveprov=$row->CLAVE;
					$nomprov = $row->NOMBRE;
					$fecha = $row->FECHAELAB;

					$this->query="INSERT INTO LIB_PARTIDAS (ID, IDPREOC, CANTIDAD, PROVEEDOR, NOMBRE_PROVEEDOR, OC, FECHA_OC, PARTIDA_OC, USUARIO, FECHA ) 
									VALUES (NULL, $id_preoc, $pxr,'$cveprov', '$nomprov', '$doco', '$fecha', $par, '$usuario', current_timestamp )";
					$rs=$this->EjecutaQuerySimple();

					if($rs){
						echo 'Entro a la liberacion';
				        	$this->query="SELECT * FROM PREOC01 WHERE ID = $id_preoc";
				        	$rs=$this->QueryObtieneDatosN();
				        	//echo $this->query.'<p>';
				        	$row= ibase_fetch_object($rs);
				        	$co= $row->CANT_ORIG;
				        	$cs= $row->CANTI;

				        	if ($cs > $co){
				        		$this->query = "SELECT iif(sum(cant) is null, 0, sum(cant)) as cantpedida FROM PAR_COMPO01 WHERE ID_PREOC = $id_preoc and status = 'E'";
				        		$rs=$this->QueryObtieneDatosN();
				        		$row=ibase_fetch_object($rs);
				        		$cp = $row->CANTPEDIDA;
				        		$this->query="UPDATE preoc01 set canti= ($co-$cp), rest=($co-$cp), ordenado=$cp, status ='F' where id=$id_preoc";
				        		$rs= $this->EjecutaQuerySimple();
				        		$this->query="UPDATE par_compo01 set pxr = 0, status = 'D' where id_preoc = $id_preoc and cve_doc = '$doco'";
				        		$rs=$this->EjecutaQuerySimple();
				        		throw new Exception("Se esta tratando de solicitar mas de lo debido, se reporta a Direccion");
				        		return $rs;
				        	}
				        	echo 'Cantidad de los pendientes pxr: '.$pxr.' valor de Cantidad Original: '.$co.'<p>';
				        	if ($pxr <= $co){
				        		$query = "UPDATE PAR_COMPO01 SET";
					    		$query .= " pxr= (pxr - $pxr) ,";
					    		$query .= " status = 'L', ";
					    		$query .= " status_log2 = 'Cancelado'";
					    		$query .= " WHERE id_preoc = $id_preoc and cve_doc = '$doco'";
					    		$this->query = $query;
					    		$result = $this->EjecutaQuerySimple();

				        		$query = "UPDATE PREOC01 SET";
								$query .= " rest= (rest + $pxr),";
								$query .= " canti= (rest + $pxr),";
								$query .= " ordenado= ordenado - $pxr,";
								$query .= " status='F'";
								$query .= " WHERE id=$id_preoc";
								$this->query = $query;
								$this->EjecutaQuerySimple();
								$this->libSaldo($id_preoc, $pxr, $doco);
								echo 'Se ha liberado y registrado;'.'<p>';
							}
	        		} 
        	}elseif($status =='Tesoreria' and substr($doco,0,2)=='OP'){
        			$usuario =$_SESSION['user']->NOMBRE;
					$this->query="SELECT p.clave, p.nombre, oc.fecha_elab FROM FTC_POC oc left join prov01 p on p.clave=oc.cve_prov WHERE OC = '$doco'";
					$rs=$this->EjecutaQuerySimple();
					$row=ibase_fetch_object($rs);
					$cveprov=$row->CLAVE;
					$nomprov = $row->NOMBRE;
					$fecha = $row->FECHA_ELAB;

					$this->query="INSERT INTO LIB_PARTIDAS (ID, IDPREOC, CANTIDAD, PROVEEDOR, NOMBRE_PROVEEDOR, OC, FECHA_OC, PARTIDA_OC, USUARIO, FECHA ) 
									VALUES (NULL, $id_preoc, $pxr,'$cveprov', '$nomprov', '$doco', '$fecha', $par, '$usuario', current_timestamp )";
					$rs=$this->EjecutaQuerySimple();

					if($rs){
						echo 'Entro a la liberacion';
				        	$this->query="SELECT * FROM PREOC01 WHERE ID = $id_preoc";
				        	$rs=$this->QueryObtieneDatosN();
				        	//echo $this->query.'<p>';
				        	$row= ibase_fetch_object($rs);
				        	$co= $row->CANT_ORIG;
				        	$cs= $row->CANTI;

				        	if ($cs > $co){
				        		$this->query = "SELECT iif(sum(cant) is null, 0, sum(cant)) as cantpedida FROM FTC_POC_DETALLE WHERE IDPREOC = $id_preoc and status = '2'";
				        		$rs=$this->QueryObtieneDatosN();
				        		$row=ibase_fetch_object($rs);
				        		$cp = $row->CANTPEDIDA;
				        		$this->query="UPDATE preoc01 set canti= ($co-$cp), rest=($co-$cp), ordenado=$cp, status = 'F' where id=$id_preoc";
				        		$rs= $this->EjecutaQuerySimple();
				        		$this->query="UPDATE FTC_POC_DETALLE set pxr = 0, status = 4, status_real = 'Cancelada' where idpreoc = $id_preoc and oc = '$doco'";
				        		$rs=$this->EjecutaQuerySimple();
				        		throw new Exception("Se esta tratando de solicitar mas de lo debido, se reporta a Direccion");
				        		return $rs;
				        	}
				        	echo 'Cantidad de los pendientes pxr: '.$pxr.' valor de Cantidad Original: '.$co.'<p>';
				        	if ($pxr <= $co){
				        		$query = "UPDATE FTC_POC_DETALLE SET";
					    		$query .= " pxr= (pxr - $pxr) ,";
					    		$query .= " status = 3, ";
					    		$query .= " status_log2 = 'Cancelado'";
					    		$query .= " WHERE idpreoc = $id_preoc and oc = '$doco'";
					    		$this->query = $query;
					    		$result = $this->EjecutaQuerySimple();

				        		$query = "UPDATE PREOC01 SET";
								$query .= " rest= (rest + $pxr),";
								$query .= " canti= (rest + $pxr),";
								$query .= " ordenado= ordenado - $pxr,";
								$query .= " status='F'";
								$query .= " WHERE id=$id_preoc";
								$this->query = $query;
								$this->EjecutaQuerySimple();
								$this->libSaldo($id_preoc, $pxr, $doco);
								echo 'Se ha liberado y registrado;'.'<p>';
							}
	        		} 

        		$this->query="SELECT sum(cantidad_REC) as cantidad FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco'";
        		$rs=$this->EjecutaQuerySimple();
        		$row=ibase_fetch_object($rs);
        		if($row->CANTIDAD > 0){
        			$this->query="UPDATE FTC_POC SET STATUS = 'CANCELADA_PAR' WHERE OC = '$doco'";
        			$rs=$this->EjecutaQuerySimple();
        		}else{
        			$this->query="UPDATE FTC_POC SET STATUS = 'CANCELADA_TOT' where OC = '$doco'";
        			$rs=$this->EjecutaQuerySimple();	
        		}

        	}
        	//break;
			return;
	}


	function libSaldo($id_preoc, $pxr, $doco){
		$usuario = $_SESSION['user']->NOMBRE;

		if(substr($doco,0,2) == 'OP'){
			$b="SELECT a.costo, b.cve_prov
				from FTC_POC_DETALLE a 
				left join ftc_poc b on a.oc = b.oc
				where a.oc = '$doco' and a.idpreoc = $id_preoc";
			$this->query=$b;
			$result=$this->EjecutaQuerySimple();
			$row=ibase_fetch_object($result);
			$costo = $row->COSTO;
			$prov = $row->CVE_PROV;
		}else{
			$b="SELECT a.cost, b.cve_clpv
			from par_compo01 a 
			left join compo01 b on b.cve_doc = a.cve_doc
			where a.cve_doc = '$doco' and a.id_preoc = $id_preoc";
			$this->query=$b;
			$result=$this->QueryObtieneDatosN();
			$row=ibase_fetch_object($result);
			$costo=$row->COST;
			$prov=$row->CVE_CLPV;
		}
		
		$a="UPDATE PROV01 SET SALDO_LIBERADO = SALDO_LIBERADO + ($costo * $pxr) where clave = '$prov'";
		$this->query=$a;
		$this->EjecutaQuerySimple();

		$this->query="INSERT INTO LIBERACIONES (ID, ORDEN, ID_PREOC, CANTIDAD, COSTO, COSTO_TOTAL, IVA,  PROVEEDOR,  USUARIO, FECHA ) VALUES (NULL, '$doco', $id_preoc,  $pxr, $costo, ($pxr * $costo) * 1.16, ($pxr * $costo) *.16, '$prov', '$usuario', current_timestamp )";
		$this->EjecutaQuerySimple();
		//echo $this->query;
		//break;
		return;
	}

function ReEnrutar($id_preoc, $pxr, $doco){
		$usuario = $_SESSION['user']->USER_LOGIN;
		
		if(substr($doco, 0, 2) == 'OP' ){
			$this->query="SELECT * FROM FTC_POC WHERE OC = '$doco'";
			$rs=$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($rs);
			$fecha = $row->FECHA_OC;
			$unidad = $row->UNIDAD;
			$s_log = $row->STATUS_LOG;
			$idu = $row->IDU;
			$vuelta = $row->VUELTAS;
			$secuencia = $row->SECUENCIA;
			$fechas = $row->FECHA_SECUENCIA;
			$s_log2 = $row->STATUS_LOG2;

		}else{
			$getData="SELECT * FROM COMPO01 WHERE CVE_DOC = '$doco'";
			$this->query = $getData;
			$result=$this->QueryObtieneDatosN();
			$row=ibase_fetch_object($result);
			$fecha=$row->FECHAELAB;
			$unidad=$row->UNIDAD;
			$s_log=$row->STATUS_LOG;
			$idu=$row->IDU;
			$vuelta=$row->VUELTAS;
			$secuencia=$row->SECUENCIA;
			$fechas=$row->FECHA_SECUENCIA;
			$s_log2=$row->STATUS_LOG2;
		}

		if(empty($idu)){
			$idu = 0;
		}
		if(empty($secuecia)){
			$secuencia = 0;
		}
		if(empty($fechas)){
			$fechas='01.01.2017';
		}

		$b="INSERT INTO LOG_REENRUTAR (DOCUMENTO, FECHA_DOC, FECHA, USUARIO, UNIDAD, STATUS_LOG, IDU, VUELTAS, SECUENCIA, FECHA_SECUENCIA, STATUS_LOG2)
			VALUES ('$doco', '$fecha', current_timestamp, '$usuario', '$unidad', '$s_log', $idu, $vuelta, $secuencia, '$fechas', '$s_log2')";
		$this->query=$b;

		$result=$this->EjecutaQuerySimple();
		
		if(substr($doco,0,2) == 'OP'){

			$this->query="UPDATE FTC_POC_DETALLE SET STATUS_REAL = 'LOGISTICA 2' WHERE OC = '$doco'";
			$this->EjecutaQuerySimple();


			$a="UPDATE ftc_poc set unidad = null, ruta = 'N', status_log ='Nuevo', idu = null, vueltas = vueltas + 1, secuencia = null, fecha_secuencia = null, status_log2 = 'R', status_recepcion = null, status = 'LOGISTICA' where oc = '$doco'";
		}else{
			$a="UPDATE compo01 set unidad = null, ruta = 'N', status_log ='Nuevo', idu = null, vueltas = vueltas + 1, secuencia = null, fecha_secuencia = null, status_log2 = 'R', status_recepcion = null where cve_doc = '$doco'";
		}
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();

		$result+=$this->VueltaPartida($id_preoc, $pxr, $doco);
		return $result;
	}



	function VueltaPartida($id_preoc, $pxr, $doco){
		
		if(substr($doco,0,2) == 'OP'){
			$this->query="UPDATE FTC_POC_DETALLE SET STATUS_LOG2 = NULL, vuelta = vuelta +1 where oc = '$doco' and pxr !=0";
			$this->EjecutaQuerySimple();

		}else{
			$this->query="UPDATE PAR_COMPO01 SET STATUS_LOG2 = null, vuelta = vuelta + 1 where cve_doc  = '$doco' and pxr != 0";
			$this->EjecutaQuerySimple();
		}

		return;
	}

       function traeConceptoGastos() {
        $this->query = "SELECT ID, CONCEPTO, PRESUPUESTO FROM CAT_GASTOS WHERE ACTIVO = 'S'";
        $resultado = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($resultado)) {
            $data[] = $tsArray;
        }
        return $data;
    }
        
        function traeImpuestoGasto($concepto){
            $this->query = "SELECT CAUSA_IVA,IVA,ISR,FLETE FROM CAT_GASTOS WHERE ID = $concepto";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function traeClasificacionGastos(){
            $this->query = "SELECT * FROM CLA_GASTOS WHERE ACTIVO = 'S'";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function dataClasificacion($id){
            $this->query = "SELECT * FROM CLA_GASTOS WHERE ID = $id";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_assoc($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
     
         function guardaCambiosCG($id,$clasif,$descripcion,$activo){
            $this->query="UPDATE CLA_GASTOS SET CLASIFICACION = '$clasif', DESCRIPCION = '$descripcion', ACTIVO = '$activo' WHERE ID = $id";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        function guardaNuevaClaGasto($clasif,$descripcion){
            $this->query="INSERT INTO CLA_GASTOS (CLASIFICACION, DESCRIPCION) VALUES ('$clasif','$descripcion')";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
    
	function verEntregas(){
		$a="SELECT a.*,  e.nombre, c.CVE_DOC as Remision, d.cve_doc as FACTURA, c.fechaelab as FECHAREM, d.FECHAELAB as FECHAFAC
			FROM CAJAS a 
			left join FACTP01 b ON a.cve_fact = b.cve_doc
			left join FACTR01 c on a.cve_fact = c.doc_ant
			left join FACTF01 d on a.cve_fact = d.doc_ant
			left join clie01 e on b.cve_clpv = e.clave
			WHERE a.STATUS_LOG = 'Entregado' and CONTRARECIBO IS NULL";
		$this->query=$a;
		$result = $this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}  
        return $data;
	}

	function verNoEntregas(){   //21
		$a="SELECT a.*,  e.nombre, a.remision as Remisiondoc, 
			a.factura as FACTURADOC,
			(select fr.fechaelab from factr01 fr where fr.cve_doc = a.remision) as fecharem,
			(select ff.fechaelab from factf01 ff where ff.cve_doc = a.factura) as fechafac
			FROM CAJAS a 
			left join FACTP01 b ON a.cve_fact = b.cve_doc
			left join clie01 e on b.cve_clpv = e.clave
			WHERE a.STATUS_LOG = 'NC' 
			and a.fecha_secuencia >= '15.01.2018'";
			//or a.status_log = 'Reenviar' or a.status_log = 'recibido'
		$this->query=$a;
		$result = $this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}  
        return $data;
	}

	function insContra($cr, $idc, $docf){
		$a="UPDATE CAJAS SET CONTRARECIBO = '$cr' 
			where CVE_FACT = '$docf' and id = $idc";
		$this->query=$a;
		$result = $this->EjecutaQuerySimple();
		return $result;
	}

	function verFacturas(){        //26072016 Aduana  debe mostrar aquí tambien regresan los facturados y devueltos
            $a="SELECT c.*, FOLIO_RECMCIA as folio_rm, c.status_log as resultado, cl.nombre, f.cve_doc, f.impreso, iif(f.cve_doc is null, r.cve_doc, f.cve_doc) as doc, iif(f.fechaelab is null, r.fechaelab, f.fechaelab) as fechaelab, c.cve_fact as pedido,datediff(day, c.fecha_secuencia, current_timestamp) as dias, sol_des_aduana as Solucion
            	from cajas c
				left join factp01 p on p.cve_doc = c.cve_fact 
 				left join factf01 f on f.cve_doc = c.factura
				left join factr01 r on r.cve_doc = c.remision
				left join clie01 cl on p.cve_clpv = cl.clave
				where (c.status_log = 'Entregado' or c.status_log = 'Bodega' or c.status_log = 'Reenviar' or c.status_log = 'NC' or c.status_log='BodegaNC' or c.status_log ='Deslinde' or c.status_log = 'Envio' or c.status_log = 'Facturado' or c.status_log = 'Devuelto' or c.status_log = 'Recibido') 
					and f.impreso is null
					and c.fecha_creacion >= '09.07.2016'
					and (aduana = 'Facturado' or aduana = 'Devuelto' or aduana = 'Acuse' or aduana is null or aduana = '' or aduana = 'Deslinde Cobranza' or aduana ='Solucion Deslinde' or aduana = 'Solucion Deslinde 2p' or aduana = 'Solucion Deslinde NC')"; 
         $this->query= $a;
         $result=$this->EjecutaQuerySimple();
         while($tsArray=ibase_fetch_object($result)){
         	$data[]=$tsArray;
         }
			return $data;
	}
        
        function verFacturasCompF($docf, $docp, $idcaja){        //20062016
            $this->query="SELECT   a.CVE_DOC AS FACTURA, a.FECHAELAB AS FECHA_FACTURA, b.nombre AS CLIENTE,
                                    p.cve_fact as pedido, p.unidad AS UNIDAD, p.idu,
                                    p.status_log, p.docs, p.CIERRE_TOT, p.motivo,
                                    p.id AS CAJA, a.impreso, a.status_log as Resultado
                           FROM FACTF01 a
                           INNER JOIN CLIE01 b ON a.cve_clpv = b.clave
                           INNER JOIN cajas p on a.doc_ant = p.cve_fact
                           WHERE  a.CVE_DOC = '$docf' AND p.CVE_FACT = '$docp' AND p.id =  $idcaja";
            	$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return $data;  
        }
        
        function insertaRevFact($docf, $docp, $idcaja, $tipo){
            $this->query="EXECUTE PROCEDURE insert_revfact('$docf','$docp',$idcaja,'$tipo')";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
           // var_dump($data);
            return $data;
        }

    function actualizaStatusCaja($idcaja){      //21
            $this->query="UPDATE CAJAS SET status_log = 'Recibido' WHERE id = $idcaja";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
    }
        //fin 20062016

	function recDocFact($docf, $docp, $idcaja){
		$b="UPDATE CAJAS SET DOCS = 'No' where id = $idcaja";
		$this->query=$b;
		$result=$this->EjecutaQuerySimple();
		return $result; 
	}

	function recDocFactNC($docf, $docp, $idcaja){
		$b="UPDATE CAJAS SET DOCS = 'No' where id = $idcaja";
		$this->query=$b;
		$result=$this->EjecutaQuerySimple();
		return $result; 
	}

	function imprimeReciboFact($docf, $docp, $idcaja){
		$a="SELECT * 
			FROM FACTF01 
			WHERE CVE_DOC='$docf'";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		$result+=$this->infoPedido();
		$result+=$this->infolog();
		$result+=$this->infoCom();
		$result+=$this->infoPreOC();
		return $result;
	}

	function verembalaje($id, $docf){
		$a="SELECT * FROM PAQUETES WHERE IDCAJA = $id and documento = '$docf' and devuelto < cantidad ";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}

    function recibeCaja($id, $docf, $idc){    //21
		$a="UPDATE CAJAS set status_mer = 'recibido' where id = $idc and cve_fact = '$docf'";
		$this->query =$a;
		$result=$this->EjecutaQuerySimple();
		$result+=$this->InsertaFolio($id, $docf, $idc); 
		return $result;

	}

	function InsertaFolio($id,$docf, $idc){
		$usuario = $_SESSION['user']->USER_LOGIN;
		$z="SELECT max(f.cve_doc) as FACT, max(f.fechaelab) as FECHAFACT, max(p.cve_doc) as remi, max(p.fechaelab) as fecharemi 
			FROM factp01 a
			left join factf01 f on f.doc_ant= '$docf'  
			left join factr01 p on p.doc_ant= '$docf'
 			WHERE a.cve_doc = '$docf'
 			group by a.cve_doc";
 		$this->query=$z;
 		$result=$this->QueryObtieneDatosN();
 		$row=ibase_fetch_object($result);
 		$factura=$row->FACT;
 		$remision = $row->REMI;
 		$ffact=$row->FECHAFACT;
 		$fremi=$row->FECHAREMI;

 		if(is_null($ffact)){
 			$ffact = '01/01/2016';
 		}elseif(is_null($fremi) ){
 			$fremi = '01/01/2016';
 		}

		$a="INSERT INTO RECMCIA (IDCAJA, IDU, PEDIDO, FACTURA, REMISION, FECHA_RECEP, USUARIO, SERIE, FECHA_FACT, FECHA_PEDI, RECIBIDO)
			VALUES ($idc, $idc ,'$docf', '$factura', '$remision', current_timestamp ,'$usuario','R','$ffact','$fremi', 'No')";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();

		$b="SELECT ID as FOLIO FROM RECMCIA WHERE IDCAJA = $idc and RECIBIDO = 'No'";
		$this->query=$b;
		$result=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		$folio=$row->FOLIO;

		$c="UPDATE CAJAS SET FOLIO_RECMCIA = $folio, aduana = null WHERE ID = $idc";
		$this->query = $c;
		$result = $this->EjecutaQuerySimple();
		return $result;

	}

    function statusImpresoCaja($id){ //21        
            $this->query = "EXECUTE PROCEDURE SP_Status_Bodega($id)";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        //14062016
        
        function traeDocumentosxCliente(){
           $this->query="SELECT * FROM CATALOGO_DOCUMENTOS";
           $resultado = $this->QueryObtieneDatosN();
           while($tsArray = ibase_fetch_object($resultado)){
               $data[] = $tsArray;
           }
           return $data;
        }
        
        function guardaNuevoDocC($nombre, $descripcion){
            $this->query="EXECUTE PROCEDURE SP_DOCUMENTOC_NUEVO('$nombre', '$descripcion')";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        function  traeDocumentoC($id){
            $this->query="SELECT * FROM CATALOGO_DOCUMENTOS WHERE ID = $id";
           $resultado = $this->QueryObtieneDatosN();
           while($tsArray = ibase_fetch_object($resultado)){
               $data[] = $tsArray;
           }
           return $data;
        }

        function guardaCambiosDocC($activo,$nombre,$descripcion,$id){
            $this->query = "EXECUTE PROCEDURE SP_MODIFICA_DOCUMENTOC('$activo','$nombre','$descripcion',$id)";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        function traeClientesParaDocs(){
            $this->query = "SELECT * FROM CATALOGO_CLIENTES_DOCS";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function traeDocumentosCliente($clave){
            $this->query = "SELECT * FROM SP_DOCUMENTOS_CLIENTE('$clave')";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            //var_dump($data);
            return $data;
        }
        
        function NuevoDocCliente($cliente,$requerido,$copias,$documento){
            $this->query="EXECUTE PROCEDURE SP_ASIGNA_DOCUMENTOC('$cliente',$documento,'$requerido',$copias)";
            $resultado = $this->EjecutaQuerySimple();
            //var_dump($cliente);
            //var_dump($this->query);
            return $resultado;
        }

		function FolioRecMcia($id, $docf, $docr, $fact){
        	$this->query = "SELECT idu, max(id) as id, max(usuario) as usuario, max(fecha_recep) as fecha_recep, max(factura) as factura, max(remision) as remision
        					FROM RECMCIA 
        					WHERE idcaja=$id group by idu";
        	$resultado = $this->QueryObtieneDatosN();
        	while($tsArray=ibase_fetch_object($resultado)){
        		$data[]=$tsArray;
        	}
        	return $data;
        }

	function verNoEntregasImpresas(){       //22062016
		$a="SELECT a.*,  e.nombre, c.CVE_DOC as Remision, d.cve_doc as FACTURA, c.fechaelab as FECHAREM, d.FECHAELAB as FECHAFAC
			FROM CAJAS a 
			left join FACTP01 b ON a.cve_fact = b.cve_doc
			left join FACTR01 c on a.cve_fact = c.doc_ant
			left join FACTF01 d on a.cve_fact = d.doc_ant
			left join clie01 e on b.cve_clpv = e.clave
			WHERE a.STATUS_LOG = 'Recibido' AND  CONTRARECIBO IS NULL";
		$this->query=$a;
		$result = $this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}  
        return $data;
	}

	function recibirCajaNC($id, $docf, $idc, $idpreoc, $cantr, $motivo){

		#$a="UPDATE CAJAS SET STATUS='NC', STATUS_LOG='BodegaNC' WHERE ID=$idc and cve_fact='$docf'";
		#$b="UPDATE FACTF01 set STATUS_LOG='BodegaNC' where cve_doc='$docf'";
		$usuario=$_SESSION['user']->NOMBRE;
		if($id == 'T'){

				echo 'Entro a la devolucion Total de la factura: '.$docf.' con la caja '.$idc;

				$this->query="SELECT * FROM PAQUETES WHERE IDCAJA = $idc and documento = '$docf' and devuelto != cantidad";
				$rs=$this->EjecutaQuerySimple();

				while ($tsArray=ibase_fetch_object($rs)) {
					$data[]=$tsArray;
				}

				foreach($data as $key){
						$cantr = $key->CANTIDAD;
						$id = $key->ID;
						$idpreoc = $key->ID_PREOC;

						$c="UPDATE preoc01 set devuelto = $cantr where id =$idpreoc";
						$this->query=$c;
						$result=$this->EjecutaQuerySimple();
						$d="UPDATE PAQUETES SET Devuelto =  $cantr, motivo = '$motivo', usuario_dev = '$usuario', fecha_ultima_dev = current_timestamp, status = 'DEVOLUCION' where id = $id";
						$this->query = $d;
						$result=$this->EjecutaQuerySimple();
				}				
		}else{
			$c="UPDATE preoc01 set devuelto = iif(devuelto is null, $cantr, devuelto + $cantr) where id =$idpreoc";
			$this->query=$c;
			$result=$this->EjecutaQuerySimple();
			$d="UPDATE PAQUETES SET Devuelto = (devuelto + $cantr), motivo = '$motivo', usuario_dev = '$usuario', fecha_ultima_dev=current_timestamp, status = 'DEVOLUCION' where id = $id";
			$this->query = $d;
			$result=$this->EjecutaQuerySimple();
		}
		//// aqui va el codigo para liberar el pedido.
		return $result;
	}

	function devueltoNC($id, $docf){
		$a="SELECT * FROM PAQUETES WHERE idcaja = $id and devuelto > 0";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		} 
		return @$data;
	}

	function verRecepSinProcesar(){
		$this->query="SELECT p.id, p.DOCUMENTO, PRE.NOM_PROV, p.CANTIDAD, p.DEVUELTO, p.ARTICULO, p.DESCRIPCION, P.fecha_ultima_dev, P.FOLIO_DEV, P.MOTIVO FROM PAQUETES P LEFT JOIN PREOC01 PRE ON PRE.ID = P.ID_PREOC  WHERE p.STATUS = 'DEVOLUCION' ";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		$this->query="SELECT ib.DOCUMENTO, P.NOMBRE AS NOM_PROV, ib.CANT AS CANTIDAD, ib.CANT AS DEVUELTO, ib.PRODUCTO AS ARTICULO, (SELECT NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = ib.producto) as descripcion, ib.fecha as fecha_ultima_dev, 'N/A' as folio_dev, 'Orden Interna' as Motivo FROM INGRESOBODEGA ib left join prov01 p on p.clave = ib.proveedor where ib.origen = 'Orden Interna' and ib.status = 0";
		//echo $this->query;
		$res=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($res)) {
			$data[]=$tsArray;
		}

		return $data;
	}

	function guardaContraRecibo($contrarecibo,$idcaja){         //22062016
            $this->query="EXECUTE PROCEDURE sp_nuevo_contrarecibo ('$contrarecibo',$idcaja)";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }


	function avanzaCobranza($docf, $docp, $idcaja, $tipo, $nstatus){      //21
            $usuario = $_SESSION['user']->USER_LOGIN;
            switch(trim($nstatus)){
            	case 'Reenviar': /// la inicializa para que aparezca en Asignar unidad y cuenta + 1 en vueltas.
            		$status='Reenviar';
            		$getData="SELECT id, vueltas, status_log, unidad, idu, iif(cierre_uni is null, 'Sin Cierre', cierre_uni) as cierreu, iif(cierre_tot is null, 'Sin Cierre', cierre_tot) as cierret, iif(fletera is null, 'Sin Fletera',fletera) as fletera, iif(guia_fletera is null, 'Sin guia', guia_fletera) as guia, FECHA_SECUENCIA, iif(usuario_log is null, 'ninguno', usuario_log) as usuario_log  from CAJAS where id= $idcaja";
            		$this->query = $getData;
            		$result=$this->EjecutaQuerySimple();
            		$row=ibase_fetch_object($result);
            		$vueltas=$row->VUELTAS;
            		$sl = $row->STATUS_LOG;
            		$unidad = $row->UNIDAD;
            		$idu=$row->IDU;
            		$cierreu=$row->CIERREU;
            		$cierret=$row->CIERRET;
            		$fletera=$row->FLETERA;
            		$guia=$row->GUIA;
            		$fecha_sec=$row->FECHA_SECUENCIA;
            		$usu_log=$row->USUARIO_LOG;
            		$h="INSERT INTO HISTORIA_CAJA (IDCAJA, FECHA_MOV, H_STATUS, H_VUELTAS, H_STATUS_LOG, H_UNIDAD, H_IDU, H_CIERRE_UNI, H_CIERRE_TOT, H_FLETERA, H_GUIA, H_FECHA_SECUENCIA, H_USUARIO_LOG, H_USUARIO_ADUANA) 
            			values ($idcaja, current_timestamp, '$tipo', $vueltas , '$sl', '$unidad', $idu, '$cierreu', '$cierret', '$fletera', '$guia', '$fecha_sec', '$usu_log', '$usuario')";
            			//echo $h;
            		$this->query=$h;
            		$result=$this->EjecutaQuerySimple();

            		$a="UPDATE CAJAS SET
            			aduana = null, 
            			ruta = 'N', 
            			status='cerrado', 
            			vueltas = vueltas + 1, 
            			logistica = iif(logistica is null, '$tipo',(logistica||'-'||'$tipo')), 
            			unidad = null, 
            			fecha_secuencia = null, 
            			idu = null,
            			DOCS = 'No',
            			cierre_uni = null,
            			cierre_tot = null, 
            			fletera = null, 
            			guia_fletera = null, 
            			status_log = 'nuevo', 
            			secuencia = null, 
            			fecha_aduana = current_timestamp, 
            			usuario_aduana ='$usuario', 
            			reenvio = 'Si',
            			IMP_COMP_REENRUTAR = 'No',
            			status_mer = null 
            			where id = $idcaja";
            			//echo $a;
            		$this->query=$a;
            		$result=$this->EjecutaQuerySimple();

            		$b="UPDATE RECMCIA SET RECIBIDO = 'Si', fecha_recibo = current_date, usuario_recibo = '$usuario' where idcaja = $idcaja and recibido = 'No'";
            		$this->query=$b;
            		$result=$this->EjecutaQuerySimple();

            	break;
            	case 'Facturar':////La manda a la pantalla de Factuar Remisiones.
            		$status='Facturar';
            		$a="UPDATE CAJAS SET aduana = '$nstatus' , fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";
            	break;
            	case 'NC': //// La manda a la pantalla de Realizar Nota de Credito.
            		$status='NC';
            		$a="UPDATE CAJAS SET aduana ='$nstatus', fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";
            	break;
            	case 'Deslinde': /// La manda a la pantalla para que revisen el documento,
            		$status='Deslinde';
            		$a="UPDATE CAJAS SET ADUANA = '$nstatus', fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";
            	/*case 'Revision':
            		$status='Revision';
            		$a="UPDATE CAJAS SET ADUANA = '$nstatus', fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";*/
            	case 'Acuse':
            		$status='Acuse';
            		$a="UPDATE CAJAS SET ADUANA = '$nstatus', fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";
            	break;
            	case 'Revision':
            		$status='Revision';
            		
            		$this->query="UPDATE FACTF01 SET STATUS_FACT = 'Revision', status_log = '$status' where cve_doc = '$docf'";
            		$rs=$this->EjecutaQuerySimple();
            		
            		$a="UPDATE CAJAS SET ADUANA = '$nstatus', status_log='Recibido', fecha_aduana = current_timestamp, usuario_aduana ='$usuario'  where id = $idcaja";

            	break;
            	case 'Revision2p':
            		$status='Revision2p ';

            		$this->query="UPDATE FACTF01 SET STATUS_FACT = 'Revision', status_log = '$status' where cve_doc = '$docf'";
            		$rs=$this->EjecutaQuerySimple();
            		

            		$a="UPDATE CAJAS SET ADUANA = '$nstatus', status_log='Revision', fecha_aduana = current_timestamp, usuario_aduana ='$usuario' 
            		 where id = $idcaja";
            	break;
            	default:
            		$status='Errorparam';
            	break;
            }

		////$a="UPDATE FACTF01 SET STATUS_LOG = '$status' where cve_doc = '$docf'";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();

		//$b="UPDATE CAJAS SET status = 'Recibido' where id = $idcaja and cve_fact = '$docp'";
		//$this->query=$b;
        //        $result=$this->EjecutaQuerySimple();		        
		//$result=$this->EjecutaQuerySimple();		
		return $result;
	}



        function PendientesGenNC(){     //2306-
            $this->query="SELECT f.cve_doc AS FACTURA, f.doc_ant AS PEDIDO FROM factf01 f INNER JOIN CAJAS c on f.doc_ant = c.cve_fact
                            WHERE f.status_log = 'GenerarNC' AND c.status_log = 'Recibido' AND doc_sig IS NULL";            
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return @$data;
        }
        
        function PendientesGenRee(){     //2306-
            $this->query="SELECT f.cve_doc AS FACTURA, f.doc_ant AS PEDIDO,c.ID AS CAJA FROM factf01 f 
            				INNER JOIN CAJAS c on f.doc_ant = c.cve_fact
                            WHERE f.status_log = 'Reenviar' AND c.status_log = 'Recibido'";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function reenviaCaja($factura,$caja){
        	$this->query="UPDATE cajas SET ruta = 'N', STATUS = 'cerrado',fecha_cierre = null, completa = null, idu = null, secuencia = null, horai = null, horaf = null, cierre_uni = null, cierre_tot = null, caja = null, contrarecibo = null, motivo = null WHERE id = $caja ";
            $result=$this->EjecutaQuerySimple();		
			return $result;
        }

        function datosCobranzaC($idCliente){    //28062016
            $this->query = "SELECT ca.*, c.cve_maestro as clave_m, m.nombre as nombre_maestro, c.nombre, c.banco_deposito, c.banco_origen, c.metodo_pago, c.refer_Edo
            				FROM cartera ca 
            				left join clie01 c on trim(c.clave) = trim(ca.idCliente)
            				left join maestros m on c.cve_maestro= m.clave 
            				WHERE trim(ca.idcliente) = trim('$idCliente')";
            				//echo $this->query;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
 
            return $data;
        }
        
        //28062016
        function salvarDatosCobranza($cliente,$carteraCob,$carteraRev,$diasRevision,$diasPago,$dosPasos,$plazo,$addenda,$portal,$usuario,$contrasena,$observaciones,$envio,$cp,$maps,$tipo,$ln,$pc, $bancoDeposito, $bancoOrigen, $referEdo, $metodoPago){
            $revision = implode(",",$diasRevision);
            $pago = implode(",",$diasPago);
            $this->query="EXECUTE PROCEDURE sp_inserta_datacobranza('$cliente','$carteraCob','$carteraRev','$revision','$pago','$dosPasos',$plazo,'$addenda','$portal','$usuario','$contrasena','$observaciones','$envio',$cp,'$maps','$tipo',$ln,'$pc')";
            $result=$this->EjecutaQuerySimple();
            
            $this->query="UPDATE CLIE01 SET CVE_MAESTRO = '$tipo', limcred = $ln, banco_deposito = '$bancoDeposito', banco_origen= '$bancoOrigen', refer_Edo = '$referEdo', metodo_pago = '$metodoPago' where trim(clave) = trim('$cliente')";
            $rs=$this->EjecutaQuerySimple();

            return $result;
        }
        
        //28062016
        function salvarCambiosCobranza($cliente,$carteraCob,$carteraRev,$diasRevision,$diasPago,$dosPasos,$plazo,$addenda,$portal,$usuario,$contrasena,$observaciones,$envio,$cp,$maps,$tipo,$ln,$pc, $bancoDeposito, $bancoOrigen, $referEdo, $metodoPago){
            $revision = implode(",",$diasRevision);
            $pago = implode(",",$diasPago);
            $this->query="EXECUTE PROCEDURE sp_actualiza_datacobranza('$cliente','$carteraCob','$carteraRev','$revision','$pago','$dosPasos',$plazo,'$addenda','$portal','$usuario','$contrasena','$observaciones','$envio',$cp,'$maps','$tipo',$ln,'$pc')";
            $result=$this->EjecutaQuerySimple();
            //e-cho $this->query;
            //break; 
            $this->query="SELECT IIF(CVE_MAESTRO IS NULL, '0', CVE_MAESTRO) as Valida FROM CLIE01 WHERE TRIM(CLAVE) = TRIM('$cliente')";
            $rs=$this->QueryObtieneDatosN();
            $row=ibase_fetch_object($rs);
            $valida = $row->VALIDA;
            //echo $this->query;
            //echo 'valor de cliente: '.$cliente;

           		$this->query="UPDATE CLIE01 SET CVE_MAESTRO = '$tipo', limcred = $ln, banco_deposito = '$bancoDeposito', banco_origen= '$bancoOrigen', refer_Edo = '$referEdo', metodo_pago = '$metodoPago', diascred = $plazo  where trim(clave) = trim('$cliente')";
            	$rs=$this->EjecutaQuerySimple();
            //echo $this->query;
            //break;
            	$this->query="UPDATE FACTF01 SET CVE_MAESTRO = '$tipo' where trim(cve_clpv) = trim('$cliente')";
            	$rs =$this->EjecutaQuerySimple();
            //echo $this->query;
            	$this->query = "SELECT iif(SUM(SALDOFINAL) is null, 0, sum(saldofinal)) AS S15 FROM FACTF01 WHERE TRIM(CVE_CLPV) = TRIM('$cliente') and extract(year from fechaelab) = 2015";
            	$rs=$this->EjecutaQuerySimple();
            	$row=ibase_fetch_object($rs);
            	$s15=$row->S15;
            //echo $this->query;
            	$this->query="SELECT iif(SUM(SALDOFINAL) is null, 0, sum(saldofinal)) as S16 from factf01 where trim(cve_clpv) = Trim('$cliente') and extract(year from fechaelab) = 2016";
            	$rs=$this->QueryObtieneDatosN();
            	$row=ibase_fetch_object($rs);
            	$s16=$row->S16;

            	$this->query="SELECT iif(SUM(SALDOFINAL) is null, 0, sum(saldofinal)) as S17 from factf01 where trim(cve_clpv) = Trim('$cliente') and extract(year from fechaelab) = 2017";
            	$rs=$this->EjecutaQuerySimple();
            	$row=ibase_fetch_object($rs);
            	$s17=$row->S17;

            	$this->query="UPDATE MAESTROS SET SALDO_2015 = (saldo_2015 + $s15), SALDO_2016 = (saldo_2016 + $s16), SALDO_2017= (saldo_2017 + $s17) where clave = '$tipo'";
            	$rs=$this->EjecutaQuerySimple();

            if($valida != '0'){
            	
				$this->query="UPDATE MAESTROS SET SALDO_2015 = (saldo_2015 - $s15), SALDO_2016 = (saldo_2016 - $s16), SALDO_2017= (saldo_2017 - $s17) where clave = '$valida'";
            	$rs=$this->EjecutaQuerySimple();
            }
            
            return $result;
        }

    	function verCierreDiaEntregas(){         //27062016
            $this->query="SELECT a.*,  e.nombre, c.CVE_DOC as Remision, d.cve_doc as FACTURA, c.fechaelab as FECHAREM, d.FECHAELAB as FECHAFAC
                	FROM CAJAS a 
			left join FACTP01 b ON a.cve_fact = b.cve_doc
			left join FACTR01 c on a.cve_fact = c.doc_ant
			left join FACTF01 d on a.cve_fact = d.doc_ant
			left join clie01 e on b.cve_clpv = e.clave
					WHERE (a.STATUS_LOG = 'NC' or a.status_log = 'Reenviar' or a.status_log = 'recibido') AND a.cierre_tot is null ";
			$result = $this->QueryObtieneDatosN();
		        while($tsArray=ibase_fetch_object($result)){
		            $data[]=$tsArray;
		        }  
		        return $data;
        }
        
        
        function insertCierreDiaEntregas(){      //27062016
            $usuario = $_SESSION['user']->USER_LOGIN;
            $this->query="EXECUTE PROCEDURE SP_CIERRE_ENT('$usuario')";
            $result = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($result)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function insCierreRutaRecoleccion(){    //27062016
            $usuario = $_SESSION['user']->USER_LOGIN;
            $this->query="EXECUTE PROCEDURE SP_CIERRE_REC('$usuario')";
            $result=$this->QueryObtieneDatosN();
            while($tsArray=ibase_fetch_object($result)){
                $data[]=$tsArray;
            }
            return $data;
        }

        function imprimeCierre($idu){
        	$a="SELECT c.*, p.nombre FROM COMPO01 c
        		left join prov01 p on p.clave = c.cve_clpv WHERE c.IDU = $idu and c.fecha_secuencia = current_date";
        	$this->query=$a;
        	$result=$this->QueryObtieneDatosN();
        	while ($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}
        	return $data;
        }

        function imprimeCierreCab($idu){
        	$a="SELECT max(UNIDAD) as unidad, max(fecha_secuencia) as fecha_secuencia FROM COMPO01 WHERE IDU = $idu and fecha_secuencia = current_date";
        	$this->query=$a;
        	$result=$this->QueryObtieneDatosN();
        	while ($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}
        	return $data;
        }

        function actCierreUni($idu){
        	$a="UPDATE COMPO01 SET CIERRE_UNI ='impreso' where idu = $idu and fecha_secuencia = current_date";
      		$this->query=$a;
      		$result =$this->EjecutaQuerySimple();
      		return $result;
        }

    function habilitaImpresionCierre($idr){
	    	$c="SELECT COUNT(CVE_DOC) as documentos FROM COMPO01 WHERE idu = $idr and fecha_secuencia = CURRENT_DATE ";
	    	$this->query = $c;
	    	////echo $c;

	    	$result=$this->EjecutaQuerySimple();
	    	$row= ibase_fetch_object($result);
	    	$TotalOC= $row->DOCUMENTOS;
	    	
	    	$d="SELECT COUNT(CVE_DOC) AS docc from compo01 where idu=$idr and fecha_secuencia = current_date and (cierre_uni is not null)";
	    	///echo $d;
	    	$this->query =$d;
	    	$result=$this->EjecutaQuerySimple();
	    	$row=ibase_fetch_object($result);
	    	$TotalOCC= $row->DOCC;
	    
	    	$cierre = 'No';
	    	if($TotalOC == $TotalOCC){
	    		$cierre = 'Si';
	    	}

	    	return $cierre;

	    }

        function traeCarteras(){        //2806
            $this->query="SELECT * FROM CARTERAS_REVISION";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function verCartera($cr){       //02082016 
            $this->query=
                    "SELECT id,clave,nombre,cve_fact,status_log,remision,importe_remision,FACTURA,importe_factura,fechaelab,-- inicia consulta
                    cr,dias,contrarecibo_cr,sol_deslinde,FECHAFAC,FECHAREM
                    FROM(
                    SELECT a.id,cl.clave,cl.nombre,a.cve_fact,a.status_log, -- Consulta que trae las cajas
                    a.remision,r.importe as importe_remision,
                    a.FACTURA,f.importe as importe_factura,
                    p.fechaelab,
                    a.cr,datediff(day,a.fecha_secuencia,current_date) AS dias,a.contrarecibo_cr,a.sol_deslinde,f.fecha_doc as FECHAFAC,r.fecha_doc as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N'
                    UNION
                    SELECT 'Total Cliente' as id,cl.clave,cl.nombre,'Total Cliente' as cve_fact, null as status_log, -- consulta que totaliza por cliente
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,null as FECHAFAC,null as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N'
                    GROUP BY cl.clave,cl.nombre
                    UNION
                    SELECT 'Total General' as id,'Total General' as clave,null as nombre,'Total General' as cve_fact, null as status_log, -- consulta de total general
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,null as FECHAFAC,null as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N'
                    )ORDER BY clave,nombre,id  -- Fin de la consulta";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function sinCartera(){       //2906
            $this->query="SELECT * FROM SP_MOSTRAR_SINCARTERA_REVISION";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function salvarContraRecibo($contraRecibo,$caja){     //02082016

        	$this->query = "SELECT FACTURA FROM CAJAS WHERE ID = $caja";
        	$rs=$this->QueryObtieneDatosN();
        	$row=ibase_fetch_object($rs);

        	if(isset($row)){

        		$docf = $row->FACTURA;

        		$this->query="UPDATE CAJAS SET contrarecibo_cr = '$contraRecibo' WHERE ID = $caja, iif(CR is null or CR ='', CR='CR1', CR=CR)";
            	$resultado = $this->EjecutaQuerySimple();

            	$this->query="UPDATE FACTF01 SET contrarecibo_cr = '$contraRecibo' where cve_doc = '$docf'";
            	$res=$this->EjecutaQuerySimple();

            	echo $this->query;
            	//break;
            	return $resultado;
        	}

        	//break;
            
        }  
             
        function salvarStatusECR($caja){     //02082016
            $this->query="UPDATE CAJAS SET statuscr_cr = 'E' WHERE id = $caja";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
        
        function traeDataContraRecibo($caja){       //02082016
            $this->query="  SELECT a.id,a.cve_fact,a.status_log,c.nombre, r.CVE_DOC as Remision, f.cve_doc as FACTURA,
                            r.fechaelab as FECHAREM, f.FECHAELAB as FECHAFAC, a.cr,
                            datediff(day,a.fecha_secuencia,current_date) AS dias,a.contrarecibo_cr
                            FROM (CAJAS a
                            INNER join (FACTP01 p
                            INNER JOIN clie01 c on c.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc)
                            left join FACTR01 r on a.remision = r.cve_doc
                            left join FACTF01 f on a.factura = f.cve_doc
                            WHERE a.STATUS_LOG = 'Recibido'  AND a.ID = $caja";    
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;  
        }
        
        function verCarteraDia($cr){       //02082016 Modificación cartera revisión
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
            
            $this->query=
                    "SELECT id,clave,nombre,cve_fact,status_log,remision,importe_remision,FACTURA,importe_factura,fechaelab,-- inicia consulta
                    cr,dias,contrarecibo_cr,sol_deslinde,FECHAFAC,FECHAREM
                    FROM(
                    SELECT a.id,cl.clave,cl.nombre,a.cve_fact,a.status_log, -- Consulta que trae las cajas
                    a.remision,r.importe as importe_remision,
                    a.FACTURA,f.importe as importe_factura,
                    p.fechaelab,
                    a.cr,datediff(day,a.fecha_secuencia,current_date) AS dias,a.contrarecibo_cr,a.sol_deslinde,f.fecha_doc as FECHAFAC,r.fecha_doc as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N'
                    UNION
                    SELECT 'Total Cliente' as id,cl.clave,cl.nombre,'Total Cliente' as cve_fact, null as status_log, -- consulta que totaliza por cliente
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,NULL as FECHAFAC,NULL as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N'
                    GROUP BY cl.clave,cl.nombre
                    UNION
                    SELECT 'Total General' as id,'Total General' as clave,null as nombre,'Total General' as cve_fact, null as status_log, -- consulta de total general
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,NULL as FECHAFAC,NULL as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N'
                    )ORDER BY clave,nombre,id  -- Fin de la consulta";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }


        function verCarteraDia10($cr){       //3006
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
            $this->query="SELECT id,clave,nombre,cve_fact,status_log,remision,importe_remision,FACTURA,importe_factura,fechaelab,-- inicia consulta
                    cr,dias,contrarecibo_cr,sol_deslinde,FECHAFAC,FECHAREM
                    FROM(
                    SELECT a.id,cl.clave,cl.nombre,a.cve_fact,a.status_log, -- Consulta que trae las cajas
                    a.remision,r.importe as importe_remision,
                    a.FACTURA,f.importe as importe_factura,
                    p.fechaelab,
                    a.cr,datediff(day,a.fecha_secuencia,current_date) AS dias,a.contrarecibo_cr,a.sol_deslinde,f.fecha_doc as FECHAFAC,r.fecha_doc as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date) > 10
                    UNION
                    SELECT 'Total Cliente' as id,cl.clave,cl.nombre,'Total Cliente' as cve_fact, null as status_log, -- consulta que totaliza por cliente
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,NULL as FECHAFAC,NULL as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date) > 10
                    GROUP BY cl.clave,cl.nombre
                    UNION
                    SELECT 'Total General' as id,'Total General' as clave,null as nombre,'Total General' as cve_fact, null as status_log, -- consulta de total general
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,NULL as FECHAFAC,NULL as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.dias_revision CONTAINING '$dia' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date) > 10
                    )ORDER BY clave,nombre,id  -- Fin de la consulta";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function verCartera10($cr){       //3006
            $this->query="SELECT id,clave,nombre,cve_fact,status_log,remision,importe_remision,FACTURA,importe_factura,fechaelab,-- inicia consulta
                    cr,dias,contrarecibo_cr,sol_deslinde,FECHAFAC,FECHAREM
                    FROM(
                    SELECT a.id,cl.clave,cl.nombre,a.cve_fact,a.status_log, -- Consulta que trae las cajas
                    a.remision,r.importe as importe_remision,
                    a.FACTURA,f.importe as importe_factura,
                    p.fechaelab,
                    a.cr,datediff(day,a.fecha_secuencia,current_date) AS dias,a.contrarecibo_cr,a.sol_deslinde,f.fecha_doc as FECHAFAC,r.fecha_doc as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date) > 10
                    UNION
                    SELECT 'Total Cliente' as id,cl.clave,cl.nombre,'Total Cliente' as cve_fact, null as status_log, -- consulta que totaliza por cliente
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,null as FECHAFAC,null as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date) > 10
                    GROUP BY cl.clave,cl.nombre
                    UNION
                    SELECT 'Total General' as id,'Total General' as clave,null as nombre,'Total General' as cve_fact, null as status_log, -- consulta de total general
                    null as remision,sum(r.importe) as importe_remision,
                    null as FACTURA, sum(f.importe) as importe_factura,
                    null as fechaelab,null as cr,null AS dias,null as contrarecibo_cr,null as sol_deslinde,null as FECHAFAC,null as FECHAREM
                    FROM ((CAJAS a
                    LEFT JOIN factr01 r on a.remision = r.cve_doc)
                    LEFT JOIN factf01 f on a.factura = f.cve_doc)
                    INNER JOIN (FACTP01 p
                    INNER JOIN clie01 cl ON cl.clave = p.cve_clpv) ON a.cve_fact = p.cve_doc
                    WHERE a.STATUS_LOG = 'Recibido' AND a.cr = '$cr' AND a.statuscr_cr = 'N' AND datediff(day,a.fecha_secuencia,current_date)  > 10
                    )ORDER BY clave,nombre,id  -- Fin de la consulta";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function sinCartera10(){       //3006
            $this->query="SELECT * FROM SP_MOSTRAR_SINCARTERA_REV10";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function RechazarPedido($docp, $motivo){
        	$a="UPDATE PREOC01 SET STATUS = 'RE', MOTIVO_RECHAZO = '$motivo', fecha_rechazo = current_timestamp WHERE COTIZA = '$docp'";
        	$this->query=$a;
        	$result=$this->EjecutaQuerySimple();
        	$b="UPDATE FACTP01 SET STATUS2 = 'RE' WHERE CVE_DOC = '$docp'";
        	$this->query=$b;
        	$result = $this->EjecutaQuerySimple();
        	return $result;
        }

        function traeDataContraReciboSCR($factura,$remision){       //3006
            if(!empty($factura))
                $documento = $factura;
                else 
                    $documento = $remision;
            $this->query="SELECT * FROM SP_DATOSDELCONTRARECIBO_SINCR('$documento')";    
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;  
        }

 
        function verCarteraCierreDia($cr){     //07072016
            /*switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }*/
            $this->query="SELECT a.id, a.aduana , a.cve_fact,a.status_log, a.Remision,
    			c.importe as ImpRem,  a.FACTURA, d.importe as ImpFac,
    			c.fechaelab as FECHAREM, d.FECHAELAB as FECHAFAC, a.cr,
    			datediff(day,a.fecha_secuencia,current_date) AS dias,
    			a.CONTRARECIBO_CR , cl.nombre as CLIENTE, a.cr as CARTERA_REV
    			FROM CAJAS a
    			left join FACTR01 c on c.cve_doc = a.remision
    			left join FACTF01 d on d.cve_doc = a.factura
    			left join factp01 p on p.cve_doc = a.cve_fact
    			left join clie01 cl on p.cve_clpv = cl.clave
    			WHERE a.aduana = 'Cobranza'
    			and (a.CR = '$cr')
    			and a.contrarecibo_cr is not null
    			and a.imp_cierre = 0";
    		//echo $this->query;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return @$data;
        }

        function verCarteraCierreDiaSinCR($cr){     //07072016
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }

            $a="SELECT a.*, c.nombre as cliente, f.importe as ImpFac, r.importe as ImpRem, f.fechaelab as fechafac, r.fechaelab as fecharem, datediff(day, fecha_aduana, current_date) as dias, a.cr as CARTERA_REV, a.CONTRARECIBO_CR, m.motivo as mot
            	FROM CAJAS a
            	left join factp01 p on a.cve_fact = p.cve_doc
            	left join clie01 c on c.clave = p.cve_clpv
            	left join factf01 f on f.cve_doc = a.factura
            	left join factr01 r on r.cve_doc = a.remision 
            	left join motivos_nocr m on (m.cve_doc = a.factura or m.cve_doc = a.remision) AND m.fecha = current_date
            	WHERE a.aduana='Revision' 
            	and a.dias_revision CONTAINING('$dia') 
            	and a.cr = '$cr' 
            	and a.imp_cierre = 0";
            #$this->query="SELECT * FROM SP_CRCIERRESINCR('$dia','$cr')";
            	//echo $this->query;
            $this->query=$a;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return @$data;
        }

 		function salvarMotivoSinContraR($motivo,$factura,$remision){        //06072016
            $documento = (!empty($factura))?$factura:$remision;
            $this->query="INSERT INTO motivos_nocr (cve_doc,motivo) VALUES ('$documento','$motivo')";
            $resultado = $this->EjecutaQuerySimple();

            $this->query= "UPDATE CAJAS SET MOTIVO = (cast('now' as date)||' - '||'$motivo'), fecha_ultimo_motivo = (cast('Now' as date )) where factura = '$factura'";
            $rs=$this->EjecutaQuerySimple();

            return $rs;
        }
        
         function GenerarCierreCR($cr){     //07072016
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
            $this->query="EXECUTE PROCEDURE SP_GENERARCIERRE_CR('$dia','$cr')";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }


  		function CobranzaSinCierre($cc){  //07072016
        		// Cobranza sin Cierrre.
  			if($cc =='CCA'){
  				$this->query = "SELECT c.cc, f.fechaelab, a.fecha, a.id as aplicacion, a.idpago as pagos, a.documento, f.importe, a.monto_aplicado, f.saldofinal, f.cve_clpv, f.id_aplicaciones, f.aplicado
			    , f.fecha_vencimiento, datediff(day, f.fechaelab, a.fecha) as dias, ca.plazo, c.contraRecibo_cr, cl.nombre, f.fecha_vencimiento as vencimiento, datediff(day, f.fecha_vencimiento, current_date) - 7 as diasgc 
			    from aplicaciones a
			    left join factf01 f on f.cve_doc = a.documento
			    left join cajas c on c.factura = a.documento
			    left join cartera ca on trim(ca.idcliente) = trim(f.cve_clpv)
			    left join clie01 cl on cl.clave = f.cve_clpv
			    where a.fecha BETWEEN (select max(inicio) from semanas) and (select max(fin) from semanas)
			    and cierre_cc = 0
			    and (c.cc = '$cc' or c.cc is null)
			    order by (a.fecha)";
			   // echo $this->query;            	
  			}else{
  				$this->query = "SELECT c.cc, f.fechaelab, a.fecha, a.id as aplicacion, a.idpago as pagos, a.documento, f.importe, a.monto_aplicado, f.saldofinal, f.cve_clpv, f.id_aplicaciones, f.aplicado
			    , f.fecha_vencimiento, datediff(day, f.fechaelab, a.fecha) as dias, ca.plazo, c.contraRecibo_cr, cl.nombre, f.fecha_vencimiento as vencimiento, datediff(day, f.fecha_vencimiento, current_date) - 7 as diasgc 
			    from aplicaciones a
			    left join factf01 f on f.cve_doc = a.documento
			    left join cajas c on c.factura = a.documento
			    left join cartera ca on trim(ca.idcliente) = trim(f.cve_clpv)
			    left join clie01 cl on cl.clave = f.cve_clpv
			    where a.fecha BETWEEN (select max(inicio) from semanas) and (select max(fin) from semanas)
			    and cierre_cc = 0
			    and c.cc = '$cc' 
			    order by (a.fecha)";
			    //echo $this->query;
  			}
            $resultado = $this->QueryObtieneDatosN();

            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return @$data;
        }  


        function genCierreCobranza($cc){

        	$usuario =$_SESSION['user']->NOMBRE;

        	$this->query="SELECT MAX(CIERRE_CC) AS cierrec FROM  APLICACIONES ";
        	$rs=$this->QueryObtieneDatosN();
        	$row=ibase_fetch_object($rs);
        	$folio= $row->CIERREC + 1;
        	
        	if($cc = 'CCA'){
        			$this->query = "SELECT a.documento as DOCUMENTO
			    		from aplicaciones a
					    left join factf01 f on f.cve_doc = a.documento
					    left join cajas c on c.factura = a.documento
					    left join cartera ca on trim(ca.idcliente) = trim(f.cve_clpv)
					    left join clie01 cl on cl.clave = f.cve_clpv
					    where a.fecha BETWEEN (select max(inicio) from semanas) and (select max(fin) from semanas)
					    and cierre_cc = 0
					    and c.cc = '$cc' order by (a.fecha)";
					  echo $this->query;
					$rs=$this->QueryObtieneDatosN();
					//break;
					while($tsArray=ibase_fetch_object($rs)){
						$data[]= $tsArray;
					}
					
					foreach ($data as $key ){
						$this->query="UPDATE APLICACIONES a SET a.CIERRE_CC = $folio, FECHA_CIERRE_CC = current_timestamp,
						USUARIO_CIERRE_CC = '$usuario'
	        			where documento= '$key->DOCUMENTO'";
	        			$result=$this->EjecutaQuerySimple();	
					}
        	}else{
        			$this->query = "SELECT a.documento as DOCUMENTO
			    		from aplicaciones a
					    left join factf01 f on f.cve_doc = a.documento
					    left join cajas c on c.factura = a.documento
					    left join cartera ca on trim(ca.idcliente) = trim(f.cve_clpv)
					    left join clie01 cl on cl.clave = f.cve_clpv
					    where a.fecha BETWEEN (select max(inicio) from semanas) and (select max(fin) from semanas)
					    and cierre_cc = 0
					    and c.cc = '$cc' order by (a.fecha)";
					$rs=$this->QueryObtieneDatosN();
					while($tsArray = ibase_fetch_object($rs)){
						$data[]=$tsArray;
					}
					foreach ($data as $key){
						$this->query="UPDATE APLICACIONES a SET a.CIERRE_CC = $folio, FECHA_CIERRE_CC = current_timestamp,
						USUARIO_CIERRE_CC = '$usuario'
	        			where documento= '$key->DOCUMENTO'";
	        			$result=$this->EjecutaQuerySimple();
					}

        	}

        	$res = 'falso';
        	if($result){
        		$res = $folio;
        	}
        	return $res;
        }


        function traeAplicaciones($folio){
        	$this->query="SELECT f.cve_doc, cl.nombre, f.fechaelab, a.id, a.idpago, a.monto_Aplicado, f.saldofinal, a.fecha, f.importe, cp.monto, cp.banco 
        				from APLICACIONES a
        				left join factf01 f on f.cve_doc = a.documento
        				left join clie01 cl on cl.clave = f.cve_clpv
        				left join carga_pagos cp on cp.id = a.idpago 
        				WHERE CIERRE_CC = $folio";

        	$rs=$this->QueryObtieneDatosN();
        	echo $this->query;
        	while($tsArray=ibase_fetch_object($rs)){
        		$data[]=$tsArray;
        	}

        	return @$data;

        }
        
        function verNoCobradosDia($cc){  //07072016
            //$this->query = "SELECT * FROM SP_VERCOBRANZA('$cc')";
             switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }

            if($cc == 'CCA'){
            		$this->query="SELECT f.cve_doc, f.saldofinal, m.cartera , m.cc_dp, f.fecha_vencimiento as vencimiento, datediff(day, fecha_vencimiento, current_date) as DiasVencido, datediff(day, current_date, date '02.03.2017') as diasgc, cl.nombre,f.importe, f.aplicado, f.id_aplicaciones, f.aplicado,
            			(select max(c.contraRecibo_cr) from cajas c where f.cve_doc = factura) as CR, f.fechaelab as fecha 
            from factf01 f
            left join maestros m on f.cve_maestro = m.clave
            left join clie01 cl on cl.clave = f.cve_clpv
            where fecha_vencimiento <= cast('TODAY' as date)
            and f.saldofinal >= 2
            and (m.cc_dp containing '$dia' or m.cc_dp is null or m.cc_dp = '')
            and (m.cartera = '$cc' or m.cartera is null or m.cartera = '')
            order by m.cartera, f.fechaelab";	
            }else{
            	$this->query="SELECT f.cve_doc, f.saldofinal, m.cartera , m.cc_dp, f.fecha_vencimiento as vencimiento, datediff(day, fecha_vencimiento, current_date) as DiasVencido, datediff(day, current_date, date '02.03.2017') as diasgc, cl.nombre,f.importe, f.aplicado, f.id_aplicaciones, f.aplicado,
            			(select max(c.contraRecibo_cr) from cajas c where f.cve_doc = factura) as CR, f.fechaelab as fecha 
            from factf01 f
            left join maestros m on f.cve_maestro = m.clave
            left join clie01 cl on cl.clave = f.cve_clpv
            where fecha_vencimiento <= cast('TODAY' as date)
            and f.saldofinal >= 2
            and m.cc_dp containing '$dia'
            and (m.cartera = '$cc' or m.cartera is null or m.cartera = '')
            order by m.cartera, f.fechaelab";
            
            }
            //echo $this->query;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return @$data;
        }
        
      

        function verCatCobranza10d(){  //06072016
            $this->query = "SELECT * FROM SP_VERCOBRANZA_10D";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function traeCarterasCobranza(){        //07072016
            $this->query="SELECT * FROM CARTERAS_COBRANZA";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

        function acuse_revision(){
        	$a="SELECT a.cve_fact, id as caja, c.nombre as Cliente, f.cve_doc as FACTURA, f.importe as IMPFAC, f.fechaelab as FECHAFAC, r.cve_doc as remision, r.importe as IMPREM, r.fechaelab as FECHAREM, a.status_log, cr.CARTERA_REVISION as CARTERA_REV, datediff(day, a.fecha_secuencia, current_date ) as Dias  FROM CAJAS a 
        	left join factp01 p on a.cve_fact = p.cve_doc
        	left join factr01 r on p.cve_doc = r.doc_ant 
        	left join factf01 f on p.cve_doc = f.doc_ant 
        	left join clie01 c on p.cve_clpv = c.clave
        	left join cartera cr on c.clave = cr.idcliente
        	WHERE a.status_log = 'Entregado' and a.envio = 'foraneo' and cr.CARTERA_REVISION ='CR1' and (guia_fletera is null or fletera is null)";
        	$this->query = $a;
        	$result=$this->QueryObtieneDatosN();
        	while($tsArray = ibase_fetch_object($result)){
        		$data[] =$tsArray;
        	}
        	return $data;
        }

        function info_foraneo($caja, $doccaja, $guia, $fletera){
        	$a="UPDATE cajas set guia_fletera = '$guia', fletera ='$fletera' where id = $caja and CVE_FACT = '$doccaja'";
        	$this->query=$a;
        	$result=$this->EjecutaQuerySimple();

        	return $result;
        }

        function VerRemisiones(){       //20072016
        	$a="SELECT a.*, r.fechaelab, c.nombre, iif(a.remision is null, r.cve_doc, a.remision) as REM,comp.archivo as archivo,r.doc_sig,x.archivo as xmlfile, fecha_aduana as fecha, datediff(day, fecha_aduana, current_date) as DIAS
                FROM CAJAS a
                left join factr01 r on a.cve_fact = r.doc_ant and r.tip_doc_sig = 'F'
                left join factp01 p on p.cve_doc = a.cve_fact
                left join clie01 c on p.cve_clpv = c.clave
                left join comprobantes_caja comp on comp.idcaja = a.id
                left join xmldocven x on x.cve_doc = r.doc_sig
                WHERE ADUANA = 'Facturar'";

        	$this->query=$a;
        	
        	$result=$this->QueryObtieneDatosN();
        	while ($tsArray=ibase_fetch_object($result)){
        		$data[]=$tsArray;
        	}
        	return $data;
        }





        function asociarFactura($caja, $docp, $factura){    //03082016 
        	$a="UPDATE CAJAS set FACTURA = '$factura' ,ADUANA = 'Facturado', STATUS_LOG = 'Facturado' where id = $caja";
        	$this->query=$a;
        	$result = $this->EjecutaQuerySimple();
        	return $result;
        }		////////////// Se modifica el status_log = Facturado para que el documento regrese a Aduana y desde aduana
        		///////////// se mande a revisión o revisión dos pasos el formulario de aduana manda a llamar a otro metodo 
        		///////////// que actualiza aduana a Revision2p y Revision y status_log a recibido
     
     	function verNCFactura(){ //20072016
     		$a="SELECT a.*, f.fechaelab, c.nombre, f.cve_doc as docfactura,comp.archivo as archivo, f.doc_sig,x.archivo as xmlfile
     			from cajas a 
     			left join factp01 p on p.cve_doc = a.cve_fact
     			left join factf01 f on f.cve_doc = a.factura
     			left join clie01 c on p.cve_clpv = c.clave
                left join comprobantes_caja comp on comp.idcaja = a.id
                left join xmldocven x on x.cve_doc = f.doc_sig
     			where aduana = 'NC'";
     		$this->query=$a;
     		$result=$this->QueryObtieneDatosN();
     		while($tsArray=ibase_fetch_object($result)){
     			$data[]=$tsArray;
     		}

     		return $data;
     	}

     	function asociarNC($caja, $docp, $nc){      //03082016
     		$a="UPDATE CAJAS set NC = '$nc', ADUANA = 'Devuelto', STATUS_LOG = 'Devuelto' where id = $caja";
     		$this->query=$a;
     		$result=$this->EjecutaQuerySimple();

     		return $result; 

     	} ////////////// Se modifica el status_log = Devuelto para que el documento regrese a Aduana y desde aduana
        		///////////// se mande a revisión o revisión dos pasos el formulario de aduana manda a llamar a otro metodo 
        		///////////// que actualiza aduana a Revision2p y Revision y status_log a recibido


     	function VerFacturasDeslinde(){ //20072016
     		$a="SELECT a.*, f.fechaelab, c.nombre, f.cve_doc as docfactura,md.motivo AS motivodes,comp.archivo as archivo
                 from cajas a 
                 left join factp01 p on p.cve_doc = a.cve_fact
                 left join factf01 f on a.cve_fact = f.doc_ant
                 left join clie01 c on p.cve_clpv = c.clave
                 left join motivos_deslinde md on md.idcaja = a.id and md.fecha = current_date
                 left join comprobantes_caja comp on comp.idcaja = a.id
                 where aduana = 'Deslinde' ";
     		$this->query=$a;
     		$result=$this->QueryObtieneDatosN();
     		while($tsArray=ibase_fetch_object($result)){
     			$data[]=$tsArray;
     		}

     		return $data;
     	}

     	function AvanzaDeslinde($caja,$pedido,$motivo){
     		//$this->query="UPDATE cajas SET aduana = null WHERE id = '$caja'";
     		//$resultado = $this->EjecutaQuerySimple();
     		$this->query="INSERT INTO motivos_deslinde(idcaja,pedido,motivo,fecha) VALUES($caja,'$pedido','$motivo',current_timestamp)";
     		$resultado = $this->EjecutaQuerySimple();
     		var_dump($this->query);
     		return $resultado;
     	}

     	function VerFacturasAcuse(){ //20072016
     		$a="SELECT a.*, f.fechaelab, c.nombre, f.cve_doc as docfactura ,comp.archivo as archivo
     			from cajas a 
     			left join factp01 p on p.cve_doc = a.cve_fact
     			left join factf01 f on a.cve_fact = f.doc_ant
     			left join clie01 c on p.cve_clpv = c.clave
                        left join comprobantes_caja comp on comp.idcaja = a.id
     			where aduana = 'Acuse'";
     		$this->query=$a;
     		$result=$this->QueryObtieneDatosN();
     		while($tsArray=ibase_fetch_object($result)){
     			$data[]=$tsArray;
     		}

     		return $data;
     	}

     	function GuardaAcuse($caja,$pedido,$guia,$fletera){
     		$this->query="UPDATE cajas SET guia_fletera = '$guia',fletera = '$fletera' WHERE id = '$caja'";
     		$resultado = $this->EjecutaQuerySimple();
     		return $resultado;
     	}


     	function CierreNcFactura(){
     		$this->query="EXECUTE BLOCK
			     			AS
			     				declare variable caja int;
			     			BEGIN
				     			FOR SELECT a.id 
				     			from cajas a 
				     			left join factp01 p on p.cve_doc = a.cve_fact
				     			left join factf01 f on a.cve_fact = f.doc_ant
				     			left join clie01 c on p.cve_clpv = c.clave
				     			where aduana = 'NC' INTO :caja DO
				     			begin
				     				UPDATE cajas SET aduana = 'CierreNC' WHERE id = :caja;
				     			end
			     			END";
     		$resultado = $this->EjecutaQuerySimple();
     		return $resultado;
     	}

     	function CierreFacturaDeslinde(){
     		$this->query="EXECUTE BLOCK
			     			AS
			     				declare variable caja int;
			     			BEGIN
				     			FOR SELECT a.id
				                 from cajas a 
				                 left join factp01 p on p.cve_doc = a.cve_fact
				                 left join factf01 f on a.cve_fact = f.doc_ant
				                 left join clie01 c on p.cve_clpv = c.clave
				                 left join motivos_deslinde md on md.idcaja = a.id and md.fecha = current_date
				                 where aduana = 'Deslinde' INTO :caja DO
				     			begin
				     				UPDATE cajas SET aduana = null WHERE id = :caja;
				     			end
			     			END";
     		$resultado = $this->EjecutaQuerySimple();
     		return $resultado;
     	}

     	function CierreFacturaAcuse(){
     		$this->query="EXECUTE BLOCK
			     			AS
			     				declare variable caja int;
			     			BEGIN
				     			FOR SELECT a.id
					     			from cajas a 
					     			left join factp01 p on p.cve_doc = a.cve_fact
					     			left join factf01 f on a.cve_fact = f.doc_ant
					     			left join clie01 c on p.cve_clpv = c.clave
					     			where aduana = 'Acuse' INTO :caja DO
				     			begin
				     				UPDATE cajas SET aduana = NULL WHERE id = :caja;
				     			end
			     			END";
     		$resultado = $this->EjecutaQuerySimple();
     		return $resultado;
     	}

     	function CierrePendienteFacturar(){
     		$this->query="EXECUTE BLOCK
			     			AS
			     				declare variable caja int;
			     			BEGIN
				     			FOR SELECT a.id
					        		FROM CAJAS a
					        		left join factr01 r on a.cve_fact = r.doc_ant and r.doc_sig is null
					        		left join factp01 p on p.cve_doc = a.cve_fact
					        		left join clie01 c on p.cve_clpv = c.clave
					        		WHERE ADUANA = 'Facturar' INTO :caja DO
				     			begin
				     				UPDATE cajas SET aduana = null WHERE id = :caja;
				     			end
			     			END";
     		$resultado = $this->EjecutaQuerySimple();
     		return $resultado;
     	}

        function traeSaldosMaestro(){     //12072016
            $this->query="SELECT * FROM saldosmaestro";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function actualizaSaldoVencido(){       //19072016
            $this->query=" EXECUTE PROCEDURE SP_ACTUALIZAR_SALDOS_VENCIDOS";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }

        function saldoMaestro($cartera){


        	$this->query="UPDATE MAESTROS SET saldo_2016 = 0, saldo_2017= 0";
    		$rs=$this->EjecutaQuerySimple();


        	$this->query="SELECT clave_maestro as clave, anio, sum(saldofinal) as saldo from facturas group by clave_maestro, anio";
        	$rs=$this->EjecutaQuerySimple();

        	while($tsArray=ibase_fetch_object($rs)){
        		$data[]=$tsArray;
        	}

        	foreach ($data as $key) {
        		$maestro = $key->CLAVE;
        		$anio = $key->ANIO;
        		$campo = 'saldo_'.$anio; 
        		$saldo = $key->SALDO;

        		$this->query="UPDATE MAESTROS SET $campo= $saldo where clave = '$maestro'";
        		$rs=$this->EjecutaQuerySimple();
        		
        	}
        
			switch (date('w')){
                                    case '0':
                                        $dia = 'D';
                                        break;
                                    case '1':
                                        $dia = 'L';
                                        break;
                                    case '2':
                                        $dia = 'MA';
                                        break;
                                    case '3':
                                        $dia = 'MI';
                                        break;
                                    case '4':
                                        $dia = 'J';
                                        break;
                                    case '5':
                                        $dia = 'V';
                                        break;
                                    case '6':
                                        $dia = 'S';
                                        break;
                                    default:
                                        break;                  
                                }               

			if ($cartera == '99'){
				$this->query="SELECT clave as maestro, nombre as NOM_MAESTRO, sucursales, saldo_2015 as S15 , saldo_2016 as saldo2016, saldo_2017 as S17, acreedor, CARTERA as cartera_cobranza, CC_DP, limite_global as CREDITOXMAESTRO  
				FROM MAESTROS 
				where clave <> '' 
				and clave is not null 
				and (saldo_2015 > 0 or saldo_2016 > 0 or saldo_2017 > 0)
				and (not CC_DP containing ('$dia') or cc_dp is null)";
				$rs=$this->QueryObtieneDatosN();
				while($tsArray=ibase_fetch_object($rs)){
					$data1[]=$tsArray;

				}	
			}else{
				$this->query="SELECT clave as maestro, nombre as NOM_MAESTRO, sucursales, saldo_2015 as S15 , saldo_2016 as saldo2016, saldo_2017 as S17, acreedor, CARTERA as cartera_cobranza, CC_DP, limite_global as CREDITOXMAESTRO  
				FROM MAESTROS 
				where clave <> '' 
				and clave is not null 
				and (saldo_2015 > 0 or saldo_2016 > 0 or saldo_2017 > 0) 
				and cartera  = '$cartera' ";
				$rs=$this->QueryObtieneDatosN();
				while($tsArray=ibase_fetch_object($rs)){
					$data1[]=$tsArray;
				}	
			}
			//echo $this->query;
        	return $data1;
        }

        function saldoMaestrodia($cartera){
        	switch (date('w')){
                                    case '0':
                                        $dia = 'D';
                                        break;
                                    case '1':
                                        $dia = 'L';
                                        break;
                                    case '2':
                                        $dia = 'MA';
                                        break;
                                    case '3':
                                        $dia = 'MI';
                                        break;
                                    case '4':
                                        $dia = 'J';
                                        break;
                                    case '5':
                                        $dia = 'V';
                                        break;
                                    case '6':
                                        $dia = 'S';
                                        break;
                                    default:
                                        break;                  
                                }               

			if ($cartera == '99'){
				$this->query="SELECT clave as maestro, nombre as NOM_MAESTRO, sucursales, saldo_2015 as S15 , saldo_2016 as saldo2016, saldo_2017 as S17, acreedor, CARTERA as cartera_cobranza, CC_DP, limite_global as CREDITOXMAESTRO  
				FROM MAESTROS 
				where clave <> '' 
				and clave is not null 
				and (saldo_2015 > 0 or saldo_2016 > 0 or saldo_2017 > 0)
				and CC_DP containing ('$dia')";
				$rs=$this->QueryObtieneDatosN();
				while($tsArray=ibase_fetch_object($rs)){
					$data1[]=$tsArray;

				}	
			}else{
				$this->query="SELECT clave as maestro, nombre as NOM_MAESTRO, sucursales, saldo_2015 as S15 , saldo_2016 as saldo2016, saldo_2017 as S17, acreedor, CARTERA as cartera_cobranza, CC_DP, limite_global as CREDITOXMAESTRO  
				FROM MAESTROS 
				where clave <> '' 
				and clave is not null 
				and (saldo_2015 > 0 or saldo_2016 > 0 or saldo_2017 > 0) 
				and cartera  = '$cartera'
				and CC_DP containing ('$dia')";
				$rs=$this->QueryObtieneDatosN();
				while($tsArray=ibase_fetch_object($rs)){
					$data1[]=$tsArray;
				}	
			}
			//echo $this->query;
        	return @$data1;
        }        

        function saldoAcumulado(){
        	$this->query="SELECT 
        						SUM(SALDOFINAL) AS SA15,
        						(SELECT SUM(SALDOFINAL) FROM FACTF01 WHERE EXTRACT(YEAR FROM FECHAELAB) = 2016 ) AS SA16,
        						(SELECT SUM(SALDOFINAL) FROM FACTF01 WHERE EXTRACT(YEAR FROM FECHAELAB) = 2017 ) AS SA17,
        						 (select sum(SALDO) from acreedores where status != 99) as SAC,
        						 (select sum(saldo) from carga_pagos where tipo_pago is null and status <> 'C' and CVE_MAESTRO is not null) as Identificado,
        						 (select sum(saldo) from carga_pagos where tipo_pago is null and status <> 'C' and CVE_MAESTRO is null) as NoIdentificado,
        						 (select sum(saldo) from carga_pagos where tipo_pago is null and status <>'C') as porAplicar
        						 FROM FACTF01 WHERE EXTRACT(YEAR FROM FECHAELAB)= 2015 and saldofinal > 5";
	        	$rs=$this->QueryObtieneDatosN();
	        	while($tsArray=ibase_fetch_object($rs)){
	        		$data[]=$tsArray;
	        	}
        	return $data;
        }

        function saldoIndividual($cve_maestro){
        	$this->query="SELECT sum(saldofinal) as s166, (max(c.nombre)||'( '||trim(max(c.clave))||' )') as nombre, c.clave as clave,
							max(c.identificador_maestro) as idm, max(c.clave) as cc, max(c.diascred) as plazo, max(c.limcred) as linea_cred,
							(select sum(saldofinal) from factf01 fa where trim(fa.cve_clpv) = trim(c.clave ) and extract(year from fa.fechaelab) = 2015 and (deuda2015 = 1 or deuda2015 is null)) as s15,
							(select sum(saldofinal) from factf01 fe where c.clave = fe.cve_clpv and extract(year from fe.fechaelab) = 2017) as s17,
							(select sum (saldo) from acreedores ac where c.clave = ac.cliente ) as acreedor,
							(select sum(saldofinal) from factf01 fe where c.clave = fe.cve_clpv and extract(year from fe.fechaelab) = 2016) as s16
							FROM FACTF01 f left join clie01 c on c.clave= f.cve_clpv
							WHERE c.cve_maestro = '$cve_maestro'
							and f.status <> 'C' group by c.clave";
        	//echo $this->query;
        	$rs = $this->QueryObtieneDatosN();
        	while($tsArray=ibase_fetch_object($rs)){
        		$data[]=$tsArray;
        	}
        	return $data;
        	
        }

        
        function traeSaldosCliente($rfc){     //19072016
            $this->query="SELECT clave,nombre,rfc,ca.linea_cred,ca.plazo, saldo,saldo_vencido,saldo_corriente
                            FROM clie01 c
                            INNER JOIN cartera ca on ca.idcliente = c.clave
                            WHERE rfc = '$rfc'";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function traeSaldosDoc($cliente, $historico){     //12072016
            
            if($historico =='Si'){	
            $this->query="SELECT  f.cve_clpv,
            				f.cve_doc,
            				f.fechaelab,
            				f.fecha_cr,
            				f.fecha_vencimiento,
            				'Guia' as guia,
            				f.importe,
                            datediff(day, current_timestamp, f.fecha_vencimiento) as dias , 
                            f.contrarecibo_cr,
                            f.cve_pedi as pedido,
                            f.saldofinal,
                            f.aplicado,
                            f.importe_nc,
                            f.id_pagos,
                            f.nc_aplicadas,
                             iif(f.id_pagos = '' or f.id_pagos is null,0,
						    ((select (FOLIO_X_banco||' $ '||cast(monto as decimal(7,2)))
						    from carga_pagos where
						    id = iif( char_length(f.id_pagos) = 1,substring(f.id_pagos from 1 for 1),
						    iif(char_length(f.id_pagos) = 2,substring(f.id_pagos from 1 for 2),
						    iif(char_length(f.id_pagos) = 3,substring(f.id_pagos from 1 for 3),
						    iif(char_length(f.id_pagos) = 4, substring(f.id_pagos from 1 for 4),
						    iif(char_length(f.id_pagos) = 5, substring(f.id_pagos from 1 for 5),
						     '0')))))))) as info_pago
                            FROM  factf01 f
                            WHERE trim(f.cve_clpv) = trim('$cliente')
                            and f.status <> 'C'
                            and (deuda2015 = 1 or deuda2015 is null or deuda2015 = 0)
                            order by f.fecha_vencimiento asc";
                            //echo $this->query;

            }else{
            $this->query="SELECT  f.cve_clpv,
            				f.cve_doc,
            				f.fechaelab,
            				f.fecha_cr,
            				f.fecha_vencimiento,
            				'Guia' as guia,
            				f.importe,
                            datediff(day, current_timestamp, f.fecha_vencimiento) as dias, 
                            f.contrarecibo_cr,
                            f.cve_pedi as pedido,
                            f.saldofinal,
                            f.aplicado,
                            f.importe_nc,
                            f.id_pagos,
                            f.nc_aplicadas, 
                            iif(f.id_pagos = '' or f.id_pagos is null,0,
						    ((select (FOLIO_X_banco||' $ '||cast(monto as decimal(7,2)))
						    from carga_pagos where
						    id = iif( char_length(f.id_pagos) = 1,substring(f.id_pagos from 1 for 1),
						    iif(char_length(f.id_pagos) = 2,substring(f.id_pagos from 1 for 2),
						    iif(char_length(f.id_pagos) = 3,substring(f.id_pagos from 1 for 3),
						    iif(char_length(f.id_pagos) = 4, substring(f.id_pagos from 1 for 4),
						    iif(char_length(f.id_pagos) = 5, substring(f.id_pagos from 1 for 5),
						     '0')))))))) as info_pago
                            FROM  factf01 f
                            left join aplicaciones a on f.cve_doc = a.documento  and a.cancelado = 0 
                            WHERE trim(f.cve_clpv) = trim('$cliente') and saldoFinal > 2 
                            and f.status <> 'C' 
                            and (deuda2015 = 1 or deuda2015 is null or deuda2015 = 0)
                            and extract(year from f.fecha_doc) >= 2016
                            order by f.fecha_vencimiento asc";
                            //echo $this->query;
            }
            $resultado = $this->QueryObtieneDatosN();
            //echo $this->query;
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }
        
        function traeDatacliente($cliente){
            $this->query= "SELECT c.nombre, rfc, telefono, fax, emailpred,clave,lista_prec,v.nombre as vendedor,descuento, (iif(calle is null, '', calle ||', ')|| iif(numext is null, '',numext|| ', ') || iif(numint is null, '',numint||', ')|| iif(municipio is null, '', municipio||', ')|| iif(estado is null, '', estado||', ')||iif(pais is null, '',pais||', ')||iif(codigo is null, '', codigo) ) as direccion, c.diascred, 
            	c.banco_deposito, c.banco_origen, c.refer_edo, c.metodo_pago
            	 FROM clie01 c left join vend01 v on c.cve_vend = v.cve_vend WHERE trim(c.clave) =trim('$cliente')";
                    //echo $this->query;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            //var_dump($this->query);
            return $data;
        }
        
        function SaldosDelCliente($cliente){
            $this->query="SELECT ca.linea_cred,
            					 ca.plazo,
            					 (select sum(importe) from factp01 where doc_sig is null and status <> 'C' and trim(cve_clpv) = trim($cliente)) as pedidos,
            					 (select sum(saldofinal) from factf01 where trim(cve_clpv) = trim('$cliente') and status <> 'C' and extract(year from fecha_doc) >=2016 ) as facturas,
            					 (select sum(saldofinal) from factf01 where trim(cve_clpv) = trim('$cliente') and datediff(day, CURRENT_DATE, fecha_vencimiento) <= 0 and status <> 'C' and extract(year from fecha_doc) >= 2016 ) as saldo_vencido,
            					 (select sum(saldofinal) from factf01 where trim(cve_clpv) = trim('$cliente') and datediff(day, CURRENT_DATE, fecha_vencimiento) > 0 and status <> 'C' and extract(year from fecha_doc) >= 2016 ) as saldo_corriente,
            					 (select sum(monto) from acreedores where trim(cliente) = trim('$cliente')) as acreedores
                          FROM clie01 c 
                          left JOIN cartera ca on ca.idcliente = c.clave 
                          where trim(c.clave) = trim('$cliente')";
            //echo $this->query;
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }


        function saldoVencidoCliente($cliente){
        	$this->query="SELECT SUM(SALDOFINAL) as saldovencido from factf01 WHERE trim(cve_clpv) = trim($cliente)";
        	$rs=$this->QueryObtieneDatosN();
        	$row=ibase_fetch_object($rs);
        	$saldoVencido=$row->SALDOVENCIDO;
        	return $saldoVencido;
        }

        function saldoComprometido($cliente){
        	$this->query="SELECT SUM(IMPORTE) as Saldo 
        					FROM FACTP01 
        					WHERE trim(CVE_CLPV) = trim($cliente) 
        					and (doc_sig is null or doc_sig = '')";
        	$rs=$this->QueryObtieneDatosN();
        	$row=ibase_fetch_object($rs);
        	$saldoSinSig= $row->SALDO;

        	$this->query="SELECT SUM(p.IMPORTE) as saldo 
        					FROM FACTP01 p
        					inner join factf01 f on p.doc_sig = f.cve_doc and  
        					WHERE TRIM(CVE_CLPV) = TRIM($cliente)";
        	return $saldoComprometido;
        }

        function saldoCliente($cliente){
        	$this->query = "SELECT SUM(SALDO) as saldo FROM FACTF01 WHERE TRIM(CVE_CLPV) = TRIM($cliente)";
        	$rs=$this->QueryObtieneDatosN();
        	$row = ibase_fetch_object($rs);
        	$saldo = $row->SALDO;
        	return $saldo;
        }
       
        function ContactosDelCliente($cliente){     //12072016
            $this->query="SELECT ncontacto,nombre,direccion,telefono,email,tipocontac FROM contac01 WHERE cve_clie = '$cliente'";
            $resultado = $this->QueryObtieneDatosN();
            while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
            }
            return $data;
        }

         function guardaCompCaja($caja,$ruta){
            $this->query="INSERT INTO comprobantes_caja(idcaja,archivo) VALUES($caja,'$ruta')";
            $resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }

       function  pedidosAnticipados(){
           $this->query="SELECT a.cotiza, 
           				SUM(a.rec_faltante) AS FALTANTE,
    					max(a.NOM_CLI) as nom_cli,
    					max(a.CLIEN) as clien,
    					max(c.codigo) as codigo,
    					max(b.doc_sig) as doc_sig,
    					max(a.FECHASOL) as fechasol,
    					max(b.IMPORTE) as importe,
    					datediff(day,max(b.FECHAELAB),current_date) AS DIAS,
    					max(b.CITA) as cita,
    					iif(max(a.factura) IS NOT NULL, max(a.factura), max(a.remision)) AS documento,
    					iif(max(fecha_fact) is not null, max(fecha_fact), max(fecha_rem)) as fecha_fact,
    					sum(a.recepcion) as recibido,
    					sum(a.empacado) as empacado
              		FROM preoc01 a
              		LEFT JOIN FACTP01 b on a.cotiza = b.cve_doc
              		LEFT JOIN CLIE01 c on b.cve_clpv = c.Clave
              		where fechasol > '15.05.2016' /*AND (b.STATUS_MAT <> 'OK' OR b.STATUS_MAT IS NULL)*/
              		group by a.cotiza
              		HAVING SUM(REC_FALTANTE) >= 0
                		and sum(recepcion) > 0
                		AND max(a.REMISION) IS NULL
                		and max(a.FACTURA) IS NULL";
            /*  HAVING SUM(REC_FALTANTE) > 0 and  ((sum(a.empacado) < sum(a.FACTURADO)) OR (sum(a.empacado) < sum(a.REMISIONADO))) AND (a.REMISION IS NOT NULL OR a.FACTURA IS NOT NULL)"   Condicion original*/
           $resultado = $this->QueryObtieneDatosN();
           while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
           }
           return $data;
       }

	function ParFactMaterialPar($docf){     //26072016 correccion a la consulta
		$parfact="SELECT * FROM PAQUETES WHERE (EMBALADO IS NULL OR EMBALADO ='S') AND DOCUMENTO = '$docf'";
		$this->query=$parfact;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}
       
    function  anticipadosUrgencias(){
           /*$a="SELECT a.cotiza, SUM(a.rec_faltante) AS FALTANTE,a.NOM_CLI,a.CLIEN, c.codigo, b.doc_sig, a.FECHASOL, b.IMPORTE, datediff(day,
           				b.FECHAELAB,current_date) AS DIAS, b.CITA, iif(a.factura IS NOT NULL, a.factura, a.remision) AS documento, iif(fecha_fact is not null, 
           				fecha_fact,fecha_rem) as fecha_fact, sum(a.recepcion) as recibido,  sum(a.empacado) as empacado
                        FROM preoc01 a
                        LEFT JOIN FACTP01 b on a.cotiza = b.cve_doc
                        LEFT JOIN CLIE01 c on b.cve_clpv = c.Clave
                        where fechasol > '15.05.2016'  AND urgente = 'U'
                        group by a.cotiza
                        HAVING SUM(REC_FALTANTE) > 0 and  ((sum(a.empacado) = 0) OR (sum(a.empacado) = 0)) AND (a.REMISION IS NOT NULL OR a.FACTURA IS NOT NULL)   AND sum(a.recepcion) = 0";*/
           $b = "SELECT * FROM PEDIDO";
           $this->query=$b;
           $resultado = $this->QueryObtieneDatosN();
           while($tsArray = ibase_fetch_object($resultado)){
                $data[] = $tsArray;
           }
           return @$data;
       }


    function facturasDelDia(){
		$a= date("N");
		if($a== 1){
			$this->query="SELECT f.cve_doc,iif(f.status='E', 'Emitida','Cancelado') as STATUS, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.importe, fechaelab as dia, iif(ca.status_log is null, 'En Bodega', ca.status_log) as Logistica,  iif(ca.aduana is null, 'Sin Aduana', ca.aduana) as aduana, datediff(day, f.fechaelab, CURRENT_DATE) as DIAS
                FROM factf01 f 
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and (ca.status_log='Entregado' or ca.status_log='admon' or ca.status_log='secuencia' or ca.status_log ='nueva' or ca.status_log is null) and Aduana is null order by f.cve_doc asc ";	
		}else{$this->query="SELECT f.cve_doc,iif(f.status='E', 'Emitida','Cancelado') as STATUS, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.importe, fechaelab as dia, iif(ca.status_log is null, 'En Bodega', ca.status_log) as Logistica,  iif(ca.aduana is null, 'Sin Aduana', ca.aduana) as aduana, datediff(day, f.fechaelab, CURRENT_DATE) as DIAS
                FROM factf01 f 
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and (ca.status_log != 'Total' or ca.status_log = 'admon' or ca.status_log = 'secuencia' or ca.status_log ='nueva' or ca.status_log is null) order by f.cve_doc";
		}

		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

    function resumenFacturasDelDia(){
    	$b = date("N");
    	if($b==1){
    		$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' ";
                $this->query =$a;
        }else{
        	$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' ";
                $this->query =$a;
        }
                $result = $this->EjecutaQuerySimple();
                $row=ibase_fetch_object($result);
                $totfact = $row->FACTOT;
        return $totfact;
    }

    function resumenFacturasDelDiaAduana(){

		$b=date("N");
		if($b==1){
			$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and aduana is not null";
                $this->query =$a;

		}else{
			$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and aduana is not null";
                $this->query =$a;
		}    	
                $result = $this->EjecutaQuerySimple();
                $row=ibase_fetch_object($result);
                $totaduana = $row->FACTOT;
        return $totaduana;
    }

    function resumenFacturasDelDiaLogistica(){
    	$b=date("N");
    	if($b==1){
    		$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and (ca.status_log = 'admon' or ca.status_log = 'secuencia' or ca.status_log is null)";
                $this->query =$a;
        }else{
        	$a="SELECT count(CVE_DOC) as factot FROM factf01 f
                INNER JOIN clie01 c on f.cve_clpv = c.clave
                left join cajas ca on ca.factura = f.cve_doc
                WHERE f.fechaelab >= '01.08.2016' and  (ca.status_log = 'admon' or ca.status_log = 'secuencia' or ca.status_log is null)";
                $this->query =$a;
        }
                $result = $this->EjecutaQuerySimple();
                $row=ibase_fetch_object($result);
                $totlog = $row->FACTOT;
        return $totlog;
    }

    function facturasAyer(){
    	$this->query="SELECT f.cve_doc,f.status, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.importe
						FROM factf01 f INNER JOIN clie01 c on f.cve_clpv = c.clave
						WHERE cast(f.fecha_doc as date) = dateadd(-1 day to current_date)";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

    function UtilidadFacturas($fechaini,$fechafin,$rango,$utilidad,$letras,$status){        //01082016
      
        $filtroLetras = (empty($letras)?"":"WHERE substring(f.doc_ant FROM 2 FOR 1) IN({$letras}) ");
        
       $filtroStatus = (empty($status)?"":"AND f.status IN({$status})");
        
    	$this->query="SELECT f.cve_doc,iif(f.tip_doc_ant = 'P',f.doc_ant,'') as pedido,f.doc_sig as nc,f.status, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.can_tot,round(sum(pf.cost * pf.cant),2) as costo,
					round(((f.can_tot - sum(pf.cost * pf.cant)) * 100)/f.can_tot,2) AS utilidad, 
                                        (f.can_tot - sum(pf.cost * pf.cant)) as monto_utilidad,
					iif(sum(d.importe)/10 is null, 0,sum(d.importe)/10) as cobrado ,
					f.importe as importe_Total, f.fecha_vencimiento,
					f.importe - iif(sum(d.importe)/10 is null, 0,sum(d.importe)/10) as saldo
					FROM ((factf01 f 
                                        left join cuen_det01 d on f.cve_doc = d.refer)
					INNER JOIN clie01 c on c.clave = f.cve_clpv)
					INNER JOIN par_factf01 pf ON f.cve_doc = pf.cve_doc
                                        {$filtroLetras}
					GROUP BY f.cve_doc,f.status, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.can_tot,f.importe,f.fecha_vencimiento,iif(f.tip_doc_ant = 'P',f.doc_ant,''),f.doc_sig
					HAVING f.fecha_doc BETWEEN '$fechaini' AND '$fechafin' AND (((f.can_tot - sum(pf.cost * pf.cant)) * 100)/f.can_tot) {$rango} {$utilidad} {$filtroStatus} ";


		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		//var_dump($this->query);
		return $data;
    }

    function UtilidadFacturasTot($fechaini,$fechafin,$rango,$utilidad,$letras,$status){ //01082016
    	$filtroLetras = (empty($letras)?"":"AND substring(f.doc_ant FROM 2 FOR 1) IN({$letras}) ");
       $filtroStatus = (empty($status)?"":"AND f.status IN({$status})");
    	$this->query=
                    "SELECT SUM(pf.tot_partida) as IMPORTE, SUM(pf.cost * pf.cant) AS COSTO,
					(SUM(pf.tot_partida) - SUM(pf.cost * pf.cant)) * 100 / SUM(pf.tot_partida) AS utilidadp,
					(SUM(pf.tot_partida) - SUM(pf.cost * pf.cant)) AS utilidad_monto,
					SUM(pf.tot_partida + pf.totimp4) as Importe_Total,
					SUM(iif(d.importe is null,0,d.importe)) AS COBRADO,
					SUM(pf.tot_partida + pf.totimp4) - SUM(iif(d.importe is null,0,d.importe)) AS SALDO
                    FROM ((factf01 f left join cuen_det01 d on f.cve_doc = d.refer)
                    INNER JOIN clie01 c on c.clave = f.cve_clpv)
                    INNER JOIN par_factf01 pf ON f.cve_doc = pf.cve_doc
                    WHERE f.status != 'C' AND f.fecha_doc BETWEEN '$fechaini' AND '$fechafin'  {$filtroLetras}  {$filtroStatus}
                    HAVING (SUM(f.can_tot) - SUM(pf.cost * pf.cant)) * 100 / SUM(f.can_tot) {$rango} {$utilidad}";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		//var_dump($this->query);
		return $data;
    }

    function UtilidadXFacturaHead($fact){
        if(substr($fact,0,1) == 'N'){
            $tabla = "factd01"; 
            $tabla2 = "par_factd01";
        }elseif(substr($fact,0,1) == 'F'){
            $tabla = "factf01";
            $tabla2 = "par_factf01";
        }
		$this->query="SELECT f.cve_doc,f.status, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.can_tot,round(sum(pf.cost * pf.cant),2) as costo,  round(((f.can_tot - sum(pf.cost * pf.cant)) * 100)/f.can_tot,2) AS utilidad, (f.can_tot - sum(pf.cost * pf.cant)) as monto_utilidad
						FROM ({$tabla} f
						LEFT JOIN clie01 c on c.clave = f.cve_clpv)
						INNER JOIN {$tabla2} pf ON f.cve_doc = pf.cve_doc
						WHERE f.status != 'C'
						GROUP BY f.cve_doc,f.status, f.cve_clpv,c.nombre,c.rfc,f.fecha_doc,f.imp_tot4,f.can_tot
						HAVING f.cve_doc = '$fact' ";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

    function UtilidadXFactura($fact){
            if(substr($fact,0,1) == 'N'){
            $tabla = "factd01"; 
            $tabla2 = "par_factd01";
        }elseif(substr($fact,0,1) == 'F'){
            $tabla = "factf01";
            $tabla2 = "par_factf01";
        }
		$this->query="SELECT pf.cve_doc, pf.cve_art, i.descr, pf.cant, pf.prec, pf.cost, pf.tot_partida, pf.cost * pf.cant as tot_costo, ((tot_partida-(pf.cost*pf.cant)) * 100) /pf.tot_partida AS utilidad,(tot_partida-(pf.cost*pf.cant)) as monto_utilidad
						FROM {$tabla2} pf
						INNER JOIN inve01 i on pf.cve_art = i.cve_art
						WHERE pf.cve_doc = '$fact' ";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

    function TotalesUtilidadxFactura($fact){
        if(substr($fact,0,1) == 'N'){
            $tabla = "factd01"; 
            $tabla2 = "par_factd01";
        }elseif(substr($fact,0,1) == 'F'){
            $tabla = "factf01";
            $tabla2 = "par_factf01";
        }
    	$this->query = "
					SELECT
					sum(pf.cant) as cantidad_total,
					sum(pf.tot_partida) as partida_total,
					sum(pf.cost * pf.cant) as tot_costo,
					sum((tot_partida-(pf.cost*pf.cant))) as monto_utilidad_total,
					sum(    iif((((tot_partida-(pf.cost*pf.cant)) * 100) /pf.tot_partida)=100, 25,(((tot_partida-(pf.cost*pf.cant)) * 100) /pf.tot_partida)     ))/count(pf.cve_doc)  AS utilidad_total_ponderada,
					iif(sum(((tot_partida-(pf.cost*pf.cant)) * 100) /pf.tot_partida   )/count(pf.cve_doc) = 100,'si','no' ) as oro
					FROM {$tabla2} pf
					INNER JOIN inve01 i on pf.cve_art = i.cve_art
					WHERE pf.cve_doc = '$fact'";
		$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

    function deslindecr(){
    	$a="SELECT a.*, a.id as caja, c.nombre as cliente, cr.CARTERA_REVISION, datediff(day,a.fecha_deslinde_revision,current_date) AS DIAS, f.importe as fimporte, p.importe as rimporte, f.fechaelab as fechafac, r.fechaelab as fecharem
    		from cajas a
    		left join factp01 p on p.cve_doc = a.cve_fact 
    		left join clie01 c on c.clave = p.cve_clpv
    		left join CARTERA cr on cr.idcliente = p.cve_clpv
    		left join factf01 f on f.cve_doc = a.factura
    		left join factr01 r on r.cve_doc = a.remision
    		where a.STATUSCR_CR = 'D' and a.contrarecibo_cr is not null";
    	$this->query=$a;
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function deslindearevision($caja, $docf, $docr, $sol, $cr){
    	$a="UPDATE CAJAS SET sol_deslinde = '$sol', statuscr_cr = 'N', fecha_sol = current_timestamp where id = $caja";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

	function guardarXmlDocF($doc,$archivo){  //03082016
    	$this->query="INSERT INTO xmldocven(cve_doc,archivo,tip_doc) VALUES('$doc','$archivo','F')";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
	}

	function guardarXmlDocD($doc,$archivo){   //03082016
    	$this->query="INSERT INTO xmldocven(cve_doc,archivo,tip_doc) VALUES('$doc','$archivo','D')";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
	}

    function revConDosPasos($cr){  //11082016
   $this->query="SELECT
            caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
            factura,impfact, remision,imprec,cr
            FROM
            (SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
            c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
            c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND c.CR = '$cr'
            UNION
            SELECT
            'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            where c.ADUANA = 'Revision2p'
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            AND c.CR = '$cr'
            GROUP BY cl.nombre
            UNION
            SELECT
            'Total general' as caja,null as pedido, null as resultado,null as aduana, 'Total General' as nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            where c.ADUANA = 'Revision2p'
            --where (c.ADUANA = 'Revision2' or c.ADUANA = 'Facturado')
            AND c.CR = '$cr')
            ORDER BY
            nombre,caja";

    /*	$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision,c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado' or c.ADUANA = 'Devuelto') AND c.status_log='Recibido'  AND c.rev_dospasos = 'S' AND c.CR = '$cr'"; */
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
        function revConDosPasosNoCr(){  //05082016
    $this->query="SELECT
            caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
            factura,impfact, remision,imprec,cr
            FROM
            (SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
            c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
            c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND (c.CR is null or c.CR = '')

            UNION
            SELECT
            'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND (c.CR is null or c.CR = '')
            GROUP BY cl.nombre
            UNION
            SELECT
            'Total general' as caja,null as pedido, null as resultado,null as aduana, 'Total General' as nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND (c.CR is null or c.CR = '') )
            ORDER BY
            nombre,caja";
    	/*$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision,c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado' or c.ADUANA = 'Devuelto') AND c.status_log='Recibido'  AND c.rev_dospasos = 'S' AND c.CR is null";*/
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
 
    function revConDosPasosDia($cr){  //05082016        documentos de revision dos pasos del día 
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }

         $this->query ="SELECT
            caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
            factura,impfact, remision,imprec,cr
            FROM
            (SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
            c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
            c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
           -- where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia')

            UNION
            SELECT
            'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia')
            GROUP BY cl.nombre
            UNION
            SELECT
            'Total general' as caja,null as pedido, null as resultado,null as aduana, 'Total General' as nombre,
            null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
            null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
            from cajas c
            left join factp01 p on c.cve_fact = p.cve_doc
            left join clie01 cl on p.cve_clpv = cl.clave
            left join factf01 f on f.cve_doc = c.factura
            left join factr01 r on r.cve_doc = c.remision
            --where (c.ADUANA = 'Revision2p' or c.ADUANA = 'Facturado')
            where c.ADUANA = 'Revision2p'
            AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia'))
            ORDER BY
            nombre,caja";


    	/*$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision,c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado' or c.ADUANA = 'Devuelto') AND c.status_log='Recibido'  AND c.rev_dospasos = 'S' AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia')";*/
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function revSinDosPasosDia($cr){      //05082016
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cr
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, (cl.nombre||'( '||cl.clave||' )') as nombre,
			c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia')

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia')
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'Total General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr' AND c.dias_revision CONTAINING('$dia'))
			ORDER BY
			nombre,caja";

    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function revSinDosPasos($cr){      //05082016
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cr
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
			c.fecha_secuencia, c.docs,c.rev_dospasos, datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr'

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr'
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'zTotal General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND c.CR = '$cr')
			ORDER BY
			nombre,caja";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function revSinDosPasosNoCr(){      //05082016
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cr
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
			c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND (c.CR is null or c.Cr ='')

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND (c.CR is null or c.Cr ='')
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'zTotal General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cr
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Revision'
			AND (c.CR is null or c.CR =''))
			ORDER BY
			nombre,caja";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function statusDeslindeConDP($caja, $numcr){
        $this->query="UPDATE cajas SET ADUANA='Deslinde2P', fecha_deslinde_revision = current_timestamp WHERE ID = $caja";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }
    
    function statusDeslindeSinDP($caja, $numcr){
        $this->query="UPDATE cajas SET ADUANA='Deslinde', DESLINDE_REVISION = '$numcr', fecha_deslinde_revision = current_timestamp WHERE ID = $caja";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }
    
    function DeslindeDosPasos($cr){     //05082016      Trae las cajas enviadas a delinde dos pasos donde su cartera revisión coincide con $cr
    	$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision, c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where c.ADUANA = 'Deslinde2P' AND c.cr = '$cr'";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function DeslindeDosPasosDia($cr){     //05082016      Trae las cajas enviadas a delinde dos pasos donde su cartera revisión coincide con $cr del día
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision, c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where c.ADUANA = 'Deslinde2P' AND c.cr = '$cr' AND c.dias_revision CONTAINING('$dia')";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function DeslindeNoDosPasos($cr){   //05082016      Trae las cajas enviadas a delinde que no son dos pasos donde su cartera revisión  coincide con $cr
    	$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision, c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where c.ADUANA = 'Deslinde' AND c.cr = '$cr'";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function DeslindeNoDosPasosDia($cr){   //05082016      Trae las cajas enviadas a delinde que no son dos pasos donde su cartera revisión  coincide con $cr
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
                        c.factura,c.remision, c.cr
                        from cajas c
                        left join factp01 p on c.cve_fact = p.cve_doc
                        left join clie01 cl on p.cve_clpv = cl.clave
                        where c.ADUANA = 'Deslinde' AND c.cr = '$cr' AND c.dias_revision CONTAINING('$dia')";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function salvaMotivoDesDP($caja,$motivo){
        $this->query="UPDATE cajas SET ADUANA = 'Solucion Deslinde 2p', SOL_DESLINDE = '$motivo', FECHA_SOL= current_timestamp WHERE ID = $caja";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }
    
    function salvaMotivoDesNoDP($caja,$motivo){
        $this->query="UPDATE cajas SET ADUANA = 'Solucion Deslinde', SOL_DESLINDE = '$motivo', FECHA_SOL= current_timestamp WHERE ID = $caja";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

    function avanzarCajaCobranza($caja, $numcr){
    	$usuario = $_SESSION['user']->USER_LOGIN;
        $this->query="UPDATE cajas SET ADUANA = 'Revision', USUARIO_REVDP = '$usuario', FECHA_REVDP = current_timestamp WHERE ID = $caja";
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

    function CajaCobranza($caja, $revdp, $numcr){
    	$usuario =$_SESSION['user']->USER_LOGIN;

    	$this->query="SELECT FACTURA FROM CAJAS WHERE ID = $caja";
    	$res=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($res);
    	if(isset($row)){
    		$docf= $row->FACTURA;
    		$a="UPDATE CAJAS SET ADUANA = 'Cobranza', usuario_rev = '$usuario', fecha_rev = current_timestamp, contraRecibo_cr = '$numcr', CR=iif(CR is null or CR= '', 'CR1', CR) where id = $caja";
	    	$this->query=$a;
	    	$result = $this->EjecutaQuerySimple();
	    	$this->query ="UPDATE FACTF01 SET CONTRARECIBO_CR = '$numcr', fecha_rev = current_timestamp where cve_doc = '$docf'";
	    	$res=$this->EjecutaQuerySimple();	
	    	return $result;	
    	}
    	
    
    }
	
	/*creado por GDELEON 3/Ago/2016*/
        function delClaGasto($id){
        	$this->query = "UPDATE CLA_GASTOS
        					SET ACTIVO = 'N'
        					WHERE ID = $id";
        	$resultado = $this->EjecutaQuerySimple();
            return $resultado;
        }
		
		/*function created by GDELEON 3/Ago/2016*/
		function TraePresupuestoConceptGasto($concept){
			$this->query = "SELECT 
								presupuesto
							FROM CAT_GASTOS
							WHERE ID = $concept";
			$resultado = $this->QueryObtieneDatosN();
			while($tsArray = ibase_fetch_object($resultado)){
				$data[] = $tsArray;
			}
			return $data;
		}
		
		/*functoin created by GDELEON 3/Ago/2016*/
    function CuentasBancos(){
    	$this->query = "SELECT id, 
    						banco || ' - ' || NUM_CUENTA as banco
    					FROM pg_bancos";
    	$resultado = $this->QueryObtieneDatosN();
		while($tsArray = ibase_fetch_object($resultado)){
			$data[] = $tsArray;
		}
		return $data;
    }

	function deslindeaduana(){
    	$a="SELECT c.*, datediff(day, c.fecha_aduana, current_timestamp) as dias FROM CAJAS c WHERE ADUANA = 'Deslinde' or aduana = 'DeslindeNC'";
    	$this->query = $a;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray =ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function DesaAdu($caja, $solucion){
    	$usuario = $_SESSION['user']->USER_LOGIN;
    	$datos="SELECT * FROM CAJAS WHERE ID = $caja";
    	$this->query=$datos;
    	$result=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($result);
    	$pedido=$row->CVE_FACT;
    	$factura=$row->FACTURA;
    	$status_log=$row->STATUS_LOG;
    	
    	$l="INSERT INTO DESLINDES_ADUANA (IDCAJA, FECHA_DESLINDE, PEDIDO, FACTURA, USUARIO, STATUS_LOG, SOLUCION)
    		values ($caja, current_timestamp, '$pedido', '$factura', '$usuario', '$status_log', '$solucion')";
    	$this->query=$l;
    	$result=$this->EjecutaQuerySimple();

    	$a="UPDATE CAJAS SET STATUS_LOG = 'Deslinde', ADUANA= NULL, sol_des_aduana = '$solucion', fecha_sol_desadu = current_timestamp, usuario_des_adu = '$usuario' where id = $caja";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

    function traeCajasxPedido($docp){
    	$this->query="SELECT a.*, f.importe as impfac,f.fecha_doc as fechafac, r.importe as imprec, r.fecha_doc as fecharec, fecha_aduana as fechaa
    	FROM cajas a
    	left join factf01 f on a.factura = f.cve_doc
    	left join factr01 r on a.remision = r.cve_doc
    	WHERE a.cve_fact = upper('$docp')";
    	$resultado=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($resultado)){
    		$data[] = $tsArray;
    	}

    	return @$data;
    }

    function RecibirDocsRevision(){
    	$a="SELECT a.*, f.fechaelab, c.nombre, datediff(day, fecha_ini_cob, current_timestamp) as dias, iif(docs_cobranza is null, 'No', docs_cobranza) as EnCobranza
    		from cajas a 
    		left join factf01 f on f.cve_doc = a.factura
    		left join clie01 c on f.cve_clpv = c.clave
    		where ADUANA = 'Cobranza' and (docs_cobranza = 'No' or docs_cobranza is null or docs_cobranza = 'S') and imp_cierre = 1 ORDER BY c.nombre asc";
    	$this->query=$a;
    	$resultado = $this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($resultado)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function recDocCob($idc, $docf){
    	$usuario = $_SESSION['user']->USER_LOGIN;
    	$a="UPDATE cajas set docs_cobranza = 'S', usuario_rec_cobranza = '$usuario', fecha_rec_cobranza = current_timestamp where id = $idc";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();

    	$this->query="SELECT cl.diascred as plazoClie, ct.plazo as plazoCart, f.cve_clpv FROM factf01 f 
    		left join clie01 cl on f.cve_clpv = cl.clave
    		left join cartera ct on trim(ct.idCliente) = trim(cl.clave)
    		WHERE cve_doc = '$docf'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$plazoCL = $row->PLAZOCLIE;
    	$plazoCT = $row->PLAZOCART;
    	$cliente = $row->CVE_CLPV;

    	if(empty($plazoCT) and empty($plazoCL)){
    		$plazo = 0;
    	}elseif(!empty($plazoCT)){
    		$plazo = $plazoCT;
    		
    	}else{
    		$plazo = $plazoCL;
    	
    	}

    	$this->query="UPDATE FACTF01 SET STATUS_FACT = 'Cobranza', fecha_vencimiento = dateadd(day, $plazo ,current_date)  where cve_doc = '$docf'";
    	echo $this->query;
    	$rs=$this->EjecutaQuerySimple();

    	return $result; 

    }

    function desDocCob($idc){
    	$usuario =$_SESSION['user']->USER_LOGIN;
    	$a="UPDATE CAJAS SET aduana = 'Deslinde Cobranza', usuario_rec_cobranza = 'usuario', fecha_rec_cobranza = current_timestamp where id = $idc";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();
    	return $result; 
    }


       function VerCobranza(){      //05082016
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cc
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
			c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND (c.CC is null or c.CC ='')

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND (c.CC is null or c.CC ='')
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'zTotal General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND (c.CC is null or c.CC =''))
			ORDER BY
			nombre,caja";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
 function VerCobranzaDia($cc){      
            switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cc
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
			c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND c.Cc = '$cc' AND c.dias_pago CONTAINING( iif(dias_pago is null, 'L, Ma, Mi, J,  V, S, D', dias_pago))

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND c.Cc = '$cc' AND c.dias_pago CONTAINING( iif(dias_pago is null, 'L, Ma, Mi, J,  V, S, D', dias_pago))
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'Total General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza' and imp_cierre = 1 and docs_cobranza = 'Si'
			AND c.Cc = '$cc' AND c.dias_pago CONTAINING( iif(dias_pago is null, 'L, Ma, Mi, J,  V, S, D', dias_pago)))
			ORDER BY
			nombre,caja";

    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

function VerCobranzaC($cc){ 
    	$this->query="
         SELECT
			caja,pedido,resultado,aduana, nombre,fecha_secuencia,docs,rev_dospasos,dias,
			factura,impfact, remision,imprec,cc
			FROM
			(SELECT c.id as caja,c.cve_fact as pedido, c.status_log as resultado,c.aduana, cl.nombre,
			c.fecha_secuencia,c.docs,c.rev_dospasos,datediff(day, c.fecha_secuencia, current_timestamp) as dias,
			c.factura,f.importe as impfact,c.remision,r.importe as imprec,c.cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza'
			AND c.CC = '$cc'

			UNION
			SELECT
			'Total cliente' as caja,null as pedido, null as resultado,null as aduana, cl.nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza'
			AND c.CC = '$cc'
			GROUP BY cl.nombre
			UNION
			SELECT
			'Total general' as caja,null as pedido, null as resultado,null as aduana, 'zTotal General' as nombre,
			null as fecha_secuencia, null as docs,null as rev_dospasos,null as dias,
			null as factura,sum(f.importe) as impfact, null as remision,sum(r.importe) as imprec,null as cc
			from cajas c
			left join factp01 p on c.cve_fact = p.cve_doc
			left join clie01 cl on p.cve_clpv = cl.clave
			left join factf01 f on f.cve_doc = c.factura
			left join factr01 r on r.cve_doc = c.remision
			--where (c.ADUANA = 'Revision' or c.ADUANA = 'Facturado')
			where c.ADUANA = 'Cobranza'
			AND c.CC = '$cc')
			ORDER BY
			nombre,caja";
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traeProveedoresGasto(){
    	$a="SELECT * FROM PROV01
    		INNER JOIN PROV_CLIB01 ON CLAVE = CVE_PROV 
    		WHERE (UPPER(CAMPLIB2) STARTING WITH UPPER('G'))";
    		$this->query=$a;
    		$result=$this->QueryObtieneDatosN();
    		while ($tsArray=ibase_fetch_object($result)){
    			$data[]=$tsArray;
    		}
    		return $data;
    }

    function cajabodeganc($idc, $docf){
    	$a="UPDATE CAJAS SET STATUS='NC', STATUS_LOG='BodegaNC' WHERE ID=$idc and cve_fact='$docf'";
    	$this->query=$a;
    	$result= $this->EjecutaQuerySimple();
    	return $result;
    }

    function paquetedevolucion($idc, $docf){
    	$folio="SELECT MAX(FOLIO_DEV) as folio FROM PAQUETES";
    	$this->query =$folio;
    	$result=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($result);
    	$folact=$row->FOLIO;
    	$folsig=$folact + 1;

    	$a="UPDATE PAQUETES SET IMPRESION_DEV = 'Si', FOLIO_DEV = $folsig, fecha_ultima_dev = current_date WHERE IDCAJA = $idc and documento = '$docf'";
    	$this->query=$a;
    	$result=$this->grabaBD();
#### PENDIENTE colocar la diferencia entre factura y remision.
    	$folsigstr=(string)$folsig;

    	$c="UPDATE CAJAS SET FOLIO_DEV = ('DNC'||'$folsigstr') where id =$idc and cve_fact = '$docf'";
    	$this->query=$c;
    	$result=$this->grabaBD();
    	//echo $folsig;
    	return array("status"=>"ok","devolucion"=>$folsig, "idcaja"=>$idc, "docf"=>$docf);
    }

    function verRecepDev(){
    	$this->query="SELECT idcaja, max(fecha_empaque) as fechaEmpaque, documento, folio_dev, max(impresion_dev) as impresion_dev, max(usuario_dev) as usuario_dev, max(motivo) as motivo, max(fecha_ultima_dev) as fecha_ultima_dev,
    (SELECT CL.NOMBRE FROM FACTP01 FP LEFT JOIN CLIE01 CL on CL.CLAVE= FP.CVE_CLPV WHERE CVE_DOC = DOCUMENTO) as nombre
  from paquetes where folio_dev > 0 and impresion_dev = 'Si'
group by folio_dev, documento, idcaja";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function quitarRecepDev($folio){
    	$this->query="UPDATE PAQUETES SET IMPRESION_DEV='ou' where folio_dev = $folio ";
    	$this->EjecutaQuerySimple();
    	echo $this->query;
    	return array("status"=>'ok');
    }


    function cabeceraDevolucion($idc, $docf){
    	$b="SELECT iif(factura is null, remision, factura) as factura, c.nombre as cliente, iif(f.fechaelab is null, r.fechaelab, f.fechaelab) as fecha_factura, a.cve_fact as pedido, id as caja, a.unidad, a.status_log, (select vendedor from FTC_COTIZACION WHERE (SERIE||FOLIO) = '$docf') as vendedor
    		FROM CAJAS a
    		left join factf01 f on f.cve_doc = a.factura
    		left join factr01 r on trim(r.cve_doc)  = trim(a.remision) 
    		left join clie01 c on c.clave = f.cve_clpv
    	    WHERE ID = $idc";
    	$this->query=$b;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }


    function ImprimirDevolucion($idc, $docf){
    	$a="SELECT * FROM PAQUETES WHERE IDCAJA =$idc AND DOCUMENTO = '$docf' and DEVUELTO > 0 ";
    	$this->query=$a;
    	echo $a;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }
    
    function ImprimirDevolucionEntrega($idc, $docf){
    	$a="SELECT * FROM PAQUETES WHERE IDCAJA =$idc AND DOCUMENTO = '$docf' and DEVUELTO = 0 ";
    	$this->query=$a;
    	echo $a;
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function verCajasLogistica(){
    	$a="SELECT a.*, c.nombre, c.estado, c.codigo, p.fechaelab, f.fechaelab as fechfact, datediff(day, a.fecha_creacion, current_date) as dias
    		from cajas a 
    		left join factp01 p on a.cve_fact = p.cve_doc
    		left join clie01 c on c.clave = p.cve_clpv
    		left join factf01 f on f.cve_doc = a.factura 
    		where a.fecha_creacion >= '01.07.2016' and ADUANA IS NULL AND a.status_log != 'nuevo' and a.status_log != 'Depurado' order by a.fecha_creacion asc";
    	$this->query=$a;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray = ibase_fetch_object($result)){
    		$data[]= $tsArray;
    	}
    	return $data;
    }

    function cambiarStatus($idcaja, $docp, $secuencia, $unidad, $idu, $ntipo){

    	switch ($ntipo) {
    		case 'nuevo':
    				$getlog="SELECT * FROM CAJAS WHERE ID = $idcaja";
    				$this->query = $getlog;
    				$result = $this->QueryObtieneDatosN();
    				$row = ibase_fetch_object($result);
    				$hstatus= $row->STATUS;
    				$hvueltas = $row->VUELTAS;
    				$hstatuslog = $row->STATUS_LOG;
    				$hunidad = $row->UNIDAD;
    				$hidu = $row->IDU;
    				$hfechasecuencia= $row->FECHA_SECUENCIA;
    				$husuariolog = $row->USUARIO_LOG;
    				if (empty($hidu)){
    					$hidu = '0';	
    				}
    				if(empty($hfechasecuencia)){
    					$hfechasecuencia = '01.01.2016';
    				}

    				$log = "INSERT INTO HISTORIA_CAJA(IDCAJA, FECHA_MOV, H_STATUS, H_VUELTAS, H_STATUS_LOG, H_UNIDAD, H_IDU, H_FECHA_SECUENCIA, H_USUARIO_LOG, MOVIMIENTO)
    						VALUES 
    						($idcaja, current_timestamp,'$hstatus',$hvueltas, '$hstatuslog', '$hunidad', $hidu, '$hfechasecuencia', '$husuariolog','Cambio')";
    				$this->query=$log;
    				$result= $this->EjecutaQuerySimple();
    				$a="UPDATE CAJAS SET STATUS_LOG = 'nuevo', unidad = null, fecha_secuencia = null, idu = null, horai = null, horaf = null, secuencia = null, vueltas = (iif(vueltas is null, 0, vueltas) +  1),  ruta = 'N' where id = $idcaja";
    				
    			break;
    		case 'sec':
    				$a="UPDATE CAJAS SET STATUS_LOG = 'sec' where id = $idcaja";
    		case 'admin':
    				$a="UPDATE CAJAS SET STATUS_LOG = 'admon' where id = $idcaja";
    		default:
    			# code...
    			break;
    	
    	}
    		$this->query =$a;
    		$result=$this->EjecutaQuerySimple();
    		return $result;
    }

    function DesNC($idc){
    	$a="UPDATE CAJAS SET ADUANA = 'DeslindeNC' where id = $idc";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

    function verLoteEnviar(){
    $a="SELECT a.* , c.nombre, c.estado, c.codigo, f.fechaelab, datediff(day,f.fechaelab, current_date) as dias, a.remision as remisiondoc
    	FROM CAJAS a 
    	left join factp01 p on p.cve_doc = a.cve_fact
    	left join clie01 c on c.clave = p.cve_clpv 
    	left join factf01 f on f.cve_doc = a.factura
    	left join factr01 r on r.cve_doc = a.remision
    	WHERE a.ruta = 'N' and fecha_creacion >='08.08.2016' and  (IMP_COMP_REENRUTAR = 'No')
    	order by factura asc";
    $this->query=$a;
    $result=$this->QueryObtieneDatosN();
    while ($tsArray=ibase_fetch_object($result)){
    	$data[]=$tsArray;
    	}
    	return $data;
	}

	function verLoteEnviarReenrutar(){
	 /*$a="SELECT a.* , c.nombre, c.estado, c.codigo, f.fechaelab, datediff(day,f.fechaelab, current_date) as dias, a.remision as remisiondoc
    	FROM CAJAS a 
    	left join factp01 p on p.cve_doc = a.cve_fact
    	left join clie01 c on c.clave = p.cve_clpv 
    	left join factf01 f on f.cve_doc = a.factura
    	left join factr01 r on r.cve_doc = a.remision
    	WHERE a.ruta = 'N' and fecha_creacion >='08.08.2016' and reenvio = 'Si'";*/

    	$a="SELECT a.*, c.nombre, c.estado, c.codigo, datediff(day, a.fechaelab, current_date) as dias, idc as id, DOC_ANT AS CVE_FACT, ca.DOCS, a.cve_doc as FACTURA, ca.remision as remisiondoc, ca.U_bodega, ca.u_logistica, ca.status_ctrl_doc_entrega
    		FROM FACTF01 a
    		LEFT JOIN CLIE01 c ON c.clave = a.cve_clpv
    		LEFT JOIN CAJAS ca on ca.id = a.idc 
    		WHERE fechaelab > '01.08.2016' and Lote='Faltante'
    		ORDER BY a.cve_doc";

    $this->query=$a;
    $result=$this->QueryObtieneDatosN();
    while ($tsArray=ibase_fetch_object($result)){
    	$data[]=$tsArray;
    }
    	return $data;	
	}

	function entaduana($idc, $docf, $docp){
		$usuario=$_SESSION['user']->USER_LOGIN;
		$a="UPDATE FACTF01 SET ENTREGA_BODEGA = 'Si', U_ENTREGA = '$usuario', fecha_entrega = current_timestamp where cve_doc = '$docf'";
		$this->query=$a;
		$result = $this->EjecutaQuerySimple();
		return $result;
	}

	function recbodega($idc, $docf, $docp){
		$usuario=$_SESSION['user']->USER_LOGIN;
		$a="UPDATE FACTF01 SET ENTREGA_BODEGA = 'Bd', U_RECIBE = '$usuario', FECHA_RECIBE=current_timestamp where cve_doc = '$docf'";
		$this->query=$a;
		$result = $this->EjecutaQuerySimple();
		return $result;
	}

	function reclogistica($idc, $docf, $docp){
		$usuario=$_SESSION['user']->USER_LOGIN;
		$a="UPDATE CAJAS SET 
		U_ENTREGA = (select U_ENTREGA FROM FACTF01 WHERE idc = $idc),
		FECHA_U_ENTREGA = (SELECT FECHA_ENTREGA FROM FACTF01 WHERE idc = $idc),
		U_BODEGA = (select U_RECIBE from factf01 where idc = $idc), 
		FECHA_U_BODEGA =(SELECT FECHA_RECIBE FROM FACTF01 WHERE IDC= $idc),
		U_LOGISTICA = '$usuario',
		FECHA_U_LOGISTICA = current_timestamp where id = $idc";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		return $result; 
	}

	function impLoteDia(){
		$a="SELECT * FROM CAJAS WHERE IMP_COMP_REENRUTAR = 'Nu'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray = (ibase_fetch_object($result))){
			$data[]=$tsArray;
		}
		return $data;
	}

	function impLoteReeenrutar(){
		$a="SELECT * FROM CAJAS WHERE IMP_COMP_REENRUTAR = 'No'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while ($tsArray=(ibase_fetch_object($result))){
			$data[]=$tsArray;
			}
			return $data;
		}

	function totfactn(){
		$a="SELECT COUNT(id) AS TOTFACT FROM CAJAS WHERE IMP_COMP_REENRUTAR = 'Nu'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		$row= ibase_fetch_object($result);
		$total=$row->TOTFACT;
		return $total; 
	}

	function totfactr(){
		$a="SELECT COUNT(id) AS TOTFACT FROM CAJAS WHERE IMP_COMP_REENRUTAR = 'No'";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		$row= ibase_fetch_object($result);
		$total=$row->TOTFACT;
		return $total; 
	}

	function actimpcajas(){
		$a="UPDATE CAJAS SET IMP_COMP_REENRUTAR = 'Si' WHERE (IMP_COMP_REENRUTAR = 'No' and IMP_COMP_REENRUTAR = 'Nu')";
		$this->query=$a;
		$result=$this->EjecutaQuerySimple();
		return $result;
	}

	function VerInventarioEmpaque(){
		$a="SELECT p.status,
        p.id,
        fechasol,
        cotiza,
        par,
        prod,
        nomprod,
        UM,
        CANT_ORIG,
        REST,
        (cant_orig - recepcion) as Restante,
        RECEPCION,
        EMPACADO,
        (recepcion - empacado) as BODEGA,
        FACTURADO,
        REMISIONADO,
        FACTURAS,
        (p.costo * p.cant_orig) as ppto_compra,
        pe.tot_partida AS ppto_venta,
        f.fechaelab as ffac,
        trim(iif(REMISIONES is null, p.remision, remisiones)) as remisiones,
        r.fechaelab as frem ,
        c.status_log,
        ca.caja_pegaso,
        ca.fecha_liberacion,
          iif( (select sum(tot_partida) from par_compo01 where id_preoc = p.id group by id_preoc) is null, (select sum(costo) from ftc_poc_detalle where idpreoc = p.id group by idpreoc) , (select sum(tot_partida) from par_compo01 where id_preoc = p.id group by id_preoc)) as costo_real,
          ((p.costo * p.cant_orig) - (select sum(tot_partida) from par_compo01 where id_preoc = p.id group by id_preoc))AS DIFERENCIA
            from CAJAS_ALMACEN ca
            left join preoc01 p on ca.pedido = p.cotiza
            left join cajas c on c.factura = p.factura
            left join par_factp01 pe on pe.id_preoc = p.id
            left join factf01 f on p.factura = f.cve_doc
            left join factr01 r on p.remision = r.cve_doc
            where
                --recepcion > 0 and 
                fechasol > '01.01.2017'
                --and (recepcion - empacado)> 0
                and facturas is null 
                and (p.factura is null or p.facturado > p.recepcion)
                and (p.remision is null or p.remisionado > p.recepcion)
                and remisiones is null 
                and ca.status = 1
                and upper(p.status) <> 'Z'
                and upper(p.status) <> 'E'
                and upper(p.status) <> 'F'
                and upper(p.status) <> 'S'
                and upper (p.status) <> 'X'
                order by ca.fecha_liberacion, cotiza, fechasol";
        $this->query=$a;
        $result=$this->QueryObtieneDatosN();
        while ($tsArray=ibase_fetch_object($result)){
        	$data[]=$tsArray;
        }
        return $data;
	}

	

	function verPedidosPendientes(){
		$a="SELECT * FROM PEDIDO ";
		$this->query=$a;
		$result=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($result)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function docfact($docfact, $idc){
		$this->query="UPDATE CAJAS SET DOCFACT = 'si' where id = $idc";
		$result = $this->EjecutaQuerySimple();
		return $result;
	}

	 function listadoGastos(){
        $this->query = " SELECT A.ID,
        A.STATUS,
        A.CVE_CATGASTOS,
        B.CONCEPTO,
        A.CVE_PROV,
        B.PROVEEDOR,
        A.MONTO_PAGO,
        A.TIPO_PAGO,
        B.PRESUPUESTO,
        A.FECHA_CREACION,
        A.CLASIFICACION,
        C.DESCRIPCION
        FROM GASTOS A
        left JOIN CAT_GASTOS B ON A.CVE_CATGASTOS = B.ID
        left JOIN CLA_GASTOS C ON C.ID = A.CLASIFICACION
        WHERE A.STATUS = 'E'
        and (AUTORIZACION ='' or AUTORIZACION = '1')";
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)) {
            $data[] = $tsArray;
        }
        return @$data;
    }
    
	function PagosGastos($identificador) {
        $this->query = "SELECT a.ID, d.CONCEPTO, d.PROVEEDOR, a.MONTO_PAGO, a.FECHA_CREACION, a.SALDO, a.TIPO_PAGO, a.CLASIFICACION, c.DESCRIPCION 
                        from GASTOS a 
                        left JOIN CLA_GASTOS c ON a.clasificacion = c.id
                        left JOIN CAT_GASTOS d ON a.CVE_CATGASTOS = d.ID 
                        where a.status <> 'C' and FECHA_CREACION > '03/14/2016' AND d.ACTIVO = 'S' AND AUTORIZACION = '1' 
                        AND a.ID = '$identificador'
                        ORDER BY a.FECHA_CREACION asc ";
        //echo 'Esta es la consulta:'.var_dump($this);
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)) {
            $data[] = $tsArray;
            return @$data;
        }
        return;
    }

   function traeFacturaxCancelar($docp){
    	$this->query="SELECT f.*, c.nombre, ca.id, ca.status_log, ca.aduana, ca.factura, ca.unidad, ca.fecha_secuencia, ca.fecha_creacion, ca.remision, r.importe as IMPREC ,  r.fechaelab as FECHAREC, ca.fecha_aduana as FECHAA, ca.cr , ca.cc
    				  from factf01 f
    				  left join clie01 c on f.cve_clpv = c.clave
    				  left join cajas ca on ca.factura = f.cve_doc
    				  left join factr01 r on ca.remision = r.cve_doc
    				  where f.cve_doc = '$docp'";
    	$resultado=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($resultado)){
    		$data[] = $tsArray;
    	}
    	return @$data;
    }

    function CancelaF($docf, $idc){
    	$a="UPDATE CAJAS set status = 'cancelada' where factura = '$docf' and id = $idc";
    	$this->query=$a;
    	$result = $this->EjecutaQuerySimple();

    	$b="UPDATE PAQUETES set  status= 'cancelado' where idcaja = $idc";
    	$this->query=$b;
    	$result = $this->EjecutaQuerySimple();
    	return $result;
    }

    function UtilidadBaja(){
    	$a="SELECT co.cve_doc, coti.fechaelab, c.nombre, cl.num_part, iif(co.prec = 0, 1, co.prec) * co.cant as PrecioVenta, (iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant) as Costo, (((iif(co.prec = 0, 1, co.prec) * co.cant)/(iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant)-1)*100) as UtilidadCalculada, co.cant as cantidad, co.cve_art as clave_prod, i.descr as Producto
    			from par_factc_clib01 cl
    			left join par_factc01 co on cl.clave_doc = co.cve_doc and cl.num_part = co.num_par
    			left join factc01 coti on co.cve_doc = coti.cve_doc
    			left join clie01 c on c.clave = coti.cve_clpv
    			left join inve01 i on co.cve_art = i.cve_art 
    			WHERE (((iif(co.prec = 0, 1, co.prec) * co.cant)/(iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant)-1)*100)<23 
    			and coti.fechaelab >= '01.08.2016'
    			and co.autoriza = 'No'
    			and coti.doc_sig is null
    			and SOLICITA_AUTORIZACION = 'No'";
    	$this->query=$a;
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function solAutoUB($docc, $par){
    	$user = $_SESSION['user']->USER_LOGIN;
    	$a="UPDATE PAR_FACTC01 SET SOLICITA_AUTORIZACION='Si', FECHA_SOLICITUD = current_timestamp, USUARIO_SOLICITUD = '$user' where cve_doc = '$docc' and num_par = $par";
    	$this->query=$a;
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }

    function verSolicitudesUB(){
    	$a="SELECT co.cve_doc, coti.fechaelab, c.nombre, cl.num_part, iif(co.prec = 0, 1, co.prec) * co.cant as PrecioVenta, (iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant) as Costo, (((iif(co.prec = 0, 1, co.prec) * co.cant)/(iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant)-1)*100) as UtilidadCalculada, co.cant as cantidad, co.cve_art as clave_prod, i.descr as Producto
    			from par_factc_clib01 cl
    			left join par_factc01 co on cl.clave_doc = co.cve_doc and cl.num_part = co.num_par
    			left join factc01 coti on co.cve_doc = coti.cve_doc
    			left join clie01 c on c.clave = coti.cve_clpv
    			left join inve01 i on co.cve_art = i.cve_art 
    			WHERE (((iif(co.prec = 0, 1, co.prec) * co.cant)/(iif((cl.camplib3 is null or cl.camplib3 = 0), 1, cl.camplib3) * co.cant)-1)*100)<23 
    			and coti.fechaelab >= '01.08.2016'
    			and co.autoriza = 'No'
    			and coti.doc_sig is null
    			and SOLICITA_AUTORIZACION = 'Si'";
    	$this->query=$a;
    	$result=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function AutorizarUB($docc, $par){
    	$user = $_SESSION['user']->USER_LOGIN;
    	$a="UPDATE PAR_FACTC01 SET AUTORIZA = 'Si', fecha_autorizacion = current_timestamp, usuario_autoriza = '$user' where cve_doc = '$docc' and num_par = $par
    	 ";
    	 $this->query=$a;
    	 $result =$this->EjecutaQuerySimple();
    	 return $result;
    }

    function RechazoUB($docc, $par){
    	$user = $_SESSION['user']->USER_LOGIN;
    	$a="UPDATE PAR_FACTC01 SET AUTORIZA = 'Ne', fecha_autorizacion= current_timestamp, usuario_autoriza = '$user' where cve_doc = '$docc' and num_par = $par";
    	$this->query = $a;
    	$result=$this->EjecutaQuerySimple();
    	return $result;
    }


	function guardarNuevoGasto($concepto, $proveedor, $referencia, $autorizacion, $presupuesto, $tipopago, $monto, $movpar, $numpar, $usuario, $fechadoc, $fechaven, $exec, $clasificacion) {
    	foreach ($exec AS $impu) {
        	if ($impu->CAUSA_IVA == 'SI')
            	$ivacausado = 0.16;
        	else
            	$ivacausado = 0;
        	$iva_generado = $ivacausado * $monto;
        	$iva_retenido = ($impu->IVA / 100) * $monto;
        	$isr_retenido = ($impu->ISR / 100) * $monto;
        	$flete_retenido = ($impu->FLETE / 100) * $monto;
    	}
    	$total = $monto + $iva_generado + $iva_retenido + $isr_retenido + $flete_retenido;
    	echo "monto = $monto, presupuesto = ($presupuesto+20)";
    	if($monto > ($presupuesto+20)){
        	$autorizacion = 'X';
        	$estatus = 'X';
    	} else {
        	$autorizacion = '1';
        	$estatus = 'P';
    	}
    	$this->query = "INSERT INTO GASTOS(STATUS, CVE_CATGASTOS, CVE_PROV, REFERENCIA, AUTORIZACION, PRESUPUESTO, TIPO_PAGO, MONTO_PAGO, MOV_PAR, NUM_PAR, USUARIO, IVA_GEN, IVA_RET, ISR_RET, FLETE_RET, FECHA_DOC, VENCIMIENTO,TOTAL,SALDO,CLASIFICACION)
                        	VALUES ('$estatus',$concepto,'$proveedor','$referencia','$autorizacion',$presupuesto,'$tipopago',$monto,'$movpar',$numpar,'$usuario',$iva_generado,$iva_retenido,$isr_retenido,$flete_retenido,'$fechadoc','$fechaven',$total,$monto,$clasificacion);";
    	$resultado = $this->EjecutaQuerySimple();
    	var_dump($this->query);
    	return $resultado;
	}
 
	function GuardaPagoGastoCorrecto($cuentaBancaria, $documento, $tipopago, $monto, $proveedor, $claveProveedor, $fechadocumento) {
    	//$TIME = time();
    	$HOY = date("Y-m-d"); // H:i:s", $TIME);
    	$res = $this->guardarPagoGasto($documento, $cuentaBancaria, $monto, $fechadocumento,$tipopago);
    	//echo "res = $res";
    	if($res){
        	$this->query = "UPDATE GASTOS
                            	SET FECHA_APLICACION = '$HOY', STATUS = 'P', SALDO = (MONTO_PAGO - $monto)
                        	WHERE ID = '$documento'";
        	$rs = $this->EjecutaQuerySimple();
        	//$rs+= $this->ActPagoParOC($documento, $tipopago, $monto, $proveedor, $clavePago, $fechadocumento);
        	$rs += $this->GuardaCuentaBan($documento, $cuentaBancaria);
        	return $rs;
    	} else {
        	return -1;
    	}
	}

	function generaFolio($medioPago){
//    	$medioPago = "SELECT TIPO_PAGO FROM GASTOS WHERE ID = '$documento'";
    	$folio = "SELECT coalesce(MAX(IDSECUENCIA), 1) FROM PAGO_GASTO_FOLIOS WHERE MEDIO_PAGO = upper('$medioPago')";
    	$this->query = "UPDATE PAGO_GASTO_FOLIOS SET IDSECUENCIA = ($folio)+1 WHERE MEDIO_PAGO = upper('$medioPago');";
    	//echo $this->query;
    	$rs = $this->EjecutaQuerySimple();
    	$this->query = "SELECT 'G' || upper('$medioPago') || IDSECUENCIA AS FOLIO
        	FROM PAGO_GASTO_FOLIOS WHERE MEDIO_PAGO = upper('$medioPago');";
    	//echo $this->query;
    	$result = $this->QueryObtieneDatosN();
    	while ($tsArray = (ibase_fetch_object($result))) {
        	$data[] = $tsArray;
    	}
    	return $data;   	 
	}
    
	function guardarPagoGasto($documento, $cuentaBancaria, $monto, $fecha,$tipopago) {
    	$TIME = time();
    	$HOY = date("Y-m-d H:i:s", $TIME);
    	$folioPago = $this->generaFolio($tipopago);
    	$folio = '';
    	foreach ($folioPago as $data):
        	$folio = $data->FOLIO;
        	//echo "folioPago = $folio -- ";
    	endforeach;
    	if($folioPago!=null){
        	$AUTOINCREMENT = "SELECT coalesce(MAX(ID), 0) FROM PAGO_GASTO";
        	$this->query = "INSERT INTO PAGO_GASTO (ID, IDGASTO, CUENTA_BANCARIA,MONTO, FECHA_REGISTRO,USUARIO_REGISTRA,FECHA_PAGO,CONCILIADO, FOLIO_PAGO) "
                	. "VALUES (($AUTOINCREMENT)+1, '$documento','$cuentaBancaria',$monto,'$HOY','" . $_SESSION['user']->USER_LOGIN . "','$fecha','N','$folio')";
        	//echo $this->query;
        	$rs = $this->EjecutaQuerySimple();
        	//echo "rs = $rs";
    	} else {
        	echo "Fallo al obtener el folio de pago.";
        	return null;
    	}
    	return $rs;
	}

	function listadoXautorizar(){
    	$this->query = "SELECT 'ORDEN DE COMPRA' AS TIPO, CVE_DOC AS IDENTIFICADOR, FECHA_PAGO, CVE_CLPV AS CLAVE_PROVEEDOR, NOMBRE, PAGO_TES AS MONTO, (PAGO_TES - IMPORTE) AS DIFERENCIA  "
                     . "FROM COMPO01 A INNER JOIN  PROV01 B "
                     . "ON A.CVE_CLPV = B.CLAVE WHERE STATUS_PAGO = 'XP' AND TP_TES <> '' AND PAGO_TES > 0 ORDER BY FECHA_PAGO; ";
    		$result = $this->QueryObtieneDatosN();
           	$data = null;
            	 while ($tsArray = (ibase_fetch_object($result))) {
                	     $data[] = $tsArray;
             }
            // (SELECT FIRST 1 cuenta FROM pg_pagoBanco WHERE documento = IDGASTO) AS CUENTA,
        $this->query ="SELECT 'GASTO' AS TIPO, ID AS IDENTIFICADOR, FECHA_CREACION AS FECHA_PAGO, A.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO_PAGO AS MONTO, (A.MONTO_PAGO-PRESUPUESTO) AS DIFERENCIA
                     FROM GASTOS A INNER JOIN PROV01 B ON A.CVE_PROV = B.CLAVE WHERE A.AUTORIZACION = 'X' ORDER BY FECHA_CREACION;";
 
        $result = $this->QueryObtieneDatosN();
             while ($tsArray = (ibase_fetch_object($result))) {
                     $data[] = $tsArray;
             }
             return $data;
    }
    
	function xAutorizar($tipo, $identificador){
    	$data = null;
    	if($tipo=="GASTO"){
        	// (SELECT FIRST 1 cuenta FROM pg_pagoBanco WHERE documento = IDGASTO) AS CUENTA,
        	$this->query = "SELECT 'GASTO' AS TIPO, ID AS IDENTIFICADOR, FECHA_CREACION AS FECHA_PAGO, A.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO_PAGO AS MONTO, (A.MONTO_PAGO-PRESUPUESTO) AS DIFERENCIA
        	FROM GASTOS A INNER JOIN PROV01 B ON A.CVE_PROV = B.CLAVE WHERE A.AUTORIZACION = 'X' AND ID = '$identificador';";
       	 
        	$result = $this->QueryObtieneDatosN();
        	while ($tsArray = (ibase_fetch_object($result))) {
            	$data[] = $tsArray;
        	}
    	} else {
        	$this->query = "SELECT 'ORDEN DE COMPRA' AS TIPO, CVE_DOC AS IDENTIFICADOR, FECHA_PAGO, CVE_CLPV AS CLAVE_PROVEEDOR, NOMBRE, PAGO_TES AS MONTO "
                	. "FROM COMPO01 A INNER JOIN  PROV01 B "
                	. "ON A.CVE_CLPV = B.CLAVE WHERE STATUS_PAGO = 'XP' AND TP_TES <> '' AND PAGO_TES > 0 WHERE CVE_DOC = '$identificador'; ";

        	$result = $this->QueryObtieneDatosN();
        	while ($tsArray = (ibase_fetch_object($result))) {
            	$data[] = $tsArray;
        	}
    	}
    	return $data;
	}
    


function Pagos() {
        $this->query = "SELECT a.cve_doc, b.nombre, a.importe, a.fechaelab, a.fecha_doc, doc_sig as Recepcion, a.enlazado, c.camplib1 as TipoPagoR, c.camplib3 as FER,c.camplib2 as TE, c.camplib4 as Confirmado, a.tp_tes as PagoTesoreria, a.pago_tes, pago_entregado, c.camplib6, a.cve_clpv, a.URGENTE, datediff(day, a.fechaelab, current_date ) as Dias, 
        				(select iif(sum(lp.cantidad * poc.cost )is null, 0 , sum(lp.cantidad * poc.cost)) FROM LIB_PARTIDAS lp left join par_compo01 poc on poc.cve_doc = lp.oc and poc.num_par = lp.partida_oc WHERE PROVEEDOR = b.clave group by Proveedor) as saldoprov,
        				b.BBVA_ALTA as BBVA 
                        from compo01 a
                        left join Prov01 b on a.cve_clpv = b.clave
                        LEFT JOIN compo_clib01 c on a.cve_doc = c.clave_doc
                        where a.status <> 'C' and TP_TES is null and fechaelab > '03/14/2016' order by a.fechaelab asc";
        ///echo $this->query;
        $result = $this->QueryObtieneDatosN();
        while ($tsArray = ibase_fetch_object($result)) {
            $data[] = $tsArray;
        }

        $this->query = "SELECT s.idsol as cve_doc, p.nombre, s.monto as importe, s.fecha as fechaelab, 'Ver Documentos' as Recepcion, 'NA' as enlazado, tipo as tipopagoR, 'NA' as fer, 'NA' as TE, usuario as CONFIRMADO, TIPO AS PagoTesoreria, 'NA' as pago_entregado, 'NA' as camplib6, s.proveedor as CVE_CLPV, 'NA' as urgente, 'NA' as Dias,
        	(select iif(sum(lp.cantidad * poc.cost )is null, 0 , sum(lp.cantidad * poc.cost)) FROM LIB_PARTIDAS lp left join par_compo01 poc on poc.cve_doc = lp.oc and poc.num_par = lp.partida_oc WHERE PROVEEDOR = p.clave group by Proveedor) as saldoprov, 
        	p.BBVA_ALTA as BBVA, s.usuario_pago, s.STATUSTR 
        		from SOLICITUD_PAGO s
        		inner join prov01 p on p.clave = s.proveedor
        		where s.status = '0' ";
        $rs = $this->QueryObtieneDatosN();
        while($tsArray = ibase_fetch_object($rs)){
        	$data[]=$tsArray;
        }

        $this->query="SELECT ftcpoc.OC AS CVE_DOC, p.nombre, ftcpoc.costo_total as importe, ftcpoc.fecha_oc as fechaelab, 'Ver Documentos' as Recepcion, 'NA' as enlazado, ftcpoc.tp_tes_req as tipopagoR, 'NA' as fer, 'NA' as TE, ftcpoc.usuario_oc as confirmado, 'Tipo' as PagoTesoreria, 'NA' as pago_entregado, 'NA' as camplib6, ftcpoc.cve_prov as cve_clpv, 'NA' as urgente, 'NA' as DIAS, 
        	(select iif(sum(lp.cantidad * poc.cost )is null, 0 , sum(lp.cantidad * poc.cost)) FROM LIB_PARTIDAS lp left join par_compo01 poc on poc.cve_doc = lp.oc and poc.num_par = lp.partida_oc WHERE PROVEEDOR = p.clave group by Proveedor) as saldoprov, 
        	p.BBVA_ALTA as BBVA, ftcpoc.usuario_pago, ftcpoc.statustr
        from FTC_POC ftcpoc 
        left join prov01 p on p.clave = ftcpoc.cve_prov
        where ftcpoc.status = 'ORDEN' and TP_TES is null ";
        $rs=$this->EjecutaQuerySimple();

        while ($tsArray = ibase_fetch_object($rs)){
        	$data[]=$tsArray;
        }

        return $data;
    	}


    function Cheques(){
    	$a="SELECT P.*, B.BANCO 
    		FROM P_CHEQUES P
    		LEFT JOIN PG_PAGOBANCO B ON B.folio_pegaso = P.cheque
      		WHERE FOLIO_REAL is null and p.id > 1842 ";
    	$this->query=$a;
    	$result=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($result)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function folioReal(){
    	$a="SELECT max(folio_real) as FOLIO_REAL 
    			FROM P_CHEQUES";
		$this->query=$a;
		$rs=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($rs);
		$folio=$row->FOLIO_REAL;
		$folion=$folio+1;

		return $folion;		
    }

    function DatosCheque($cheque){
    	$a="SELECT * 
    		FROM P_CHEQUES 
    		WHERE CHEQUE='$cheque'";
    	$this->query=$a;
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);

    	return $row;
    }

    function impChBanamex($cheque, $fecha, $folio){
        $f=split('-', $fecha);
        
    	$fech= $f[0].'.'.$f[1].'.'.$f[2];
    	
    	$this->query="UPDATE P_CHEQUES SET FOLIO_REAL = $folio, FECHA_APLI='$fech' WHERE CHEQUE='$cheque'";
    
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }


    function listadoPagosImpresion() {
    	$data = null;
    	$this->query="SELECT 'GASTO' AS TIPO, IDGASTO AS IDENTIFICADOR, FECHA_PAGO, B.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO "
            	. "FROM PAGO_GASTO A INNER JOIN GASTOS B "
            	. "ON A.IDGASTO = B.ID INNER JOIN PROV01 C ON B.CVE_PROV = C.CLAVE "
            	. "WHERE B.STATUS = 'P' ORDER BY FECHA_PAGO;";
    	$result = $this->QueryObtieneDatosN();
    	while ($tsArray = (ibase_fetch_object($result))) {
        	$data[] = $tsArray;
    	}
    	return $data;
	}

	function DatosPago($identificador){
		$a="SELECT g.*, p.nombre, pg.*  
			from GASTOS g
			INNER JOIN PROV01 p ON p.clave = g.cve_prov
			INNER JOIN PAGO_GASTO pg on pg.idgasto = g.id  
			WHERE g.ID = $identificador";
		$this->query=$a;
		$result = $this->QueryObtieneDatosN();
		$row=ibase_fetch_object($result);
		return $row;
	}

	function cancelarPedidos(){
		$a="SELECT p.*, pr.nombre 
			from FACTP01 p
			left join prov01 pr on pr.clave = p.cve_clpv 
			WHERE ENLAZADO = 'T' AND FECHA_CANCELA IS NULL  AND DOC_SIG IS NULL";
		$this->query= $a;
		$rs = $this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function cancelaPedido($pedido, $motivo){
		$usuario = $_SESSION['user']->USER_LOGIN;
		$a="UPDATE FACTP01 SET ENLAZADO = 'O', MOTIVO_CANCELACION = ('$usuario'||' : '||'$motivo') WHERE CVE_DOC = '$pedido'";
		$this->query=$a;
		$rs = $this->EjecutaQuerySimple();

		$b="UPDATE PAR_FACTP01 SET PXS = CANT WHERE CVE_DOC = '$pedido'";
		$this->query=$b;
		$rs = $this->EjecutaQuerySimple();

		return $rs; 
	}

	function listaClientes(){
		$a="SELECT C.*, (select sum(SALDO) from carga_pagos CPA WHERE C.CLAVE = CPA.cliente group BY CPA.CLIENTE) AS saldoxa FROM CLIE01 C ;";
		$this->query=$a;
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function cargaPago($cliente){
		$a="SELECT cl.* 
			from clie01 cl
			where 	TRIM(clave) = TRIM('$cliente')";
		$this->query=$a;
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

       function listarCuentasBancarias(){
            $this->query = "SELECT ID, BANCO, NUM_CUENTA, B.DESCR FROM PG_BANCOS A INNER JOIN MONED01 B ON A.MONEDA = B.NUM_MONED;";
            $result = $this->QueryObtieneDatosN();
            $data = null;
            while ($tsArray = (ibase_fetch_object($result))) {
                    $data[] = $tsArray;
            }
            //echo $this->query;
            return $data;            
        }
        
        function obtenerEdoCtaDetalle($identificador){
            $this->query = "SELECT FIRST 20 B.ID AS IDREGISTRO, A.ID AS IDENTIFICADOR, A.BANCO, A.NUM_CUENTA, B.FEREGISTRO, B.DSREGISTRO, B.DCREGISTRO 
                    FROM ESTADOCUENTA_REGISTRO B INNER JOIN PG_BANCOS A ON A.ID = B.IDCTABAN 
                    WHERE B.IDCTABAN = '$identificador' ORDER BY FEREGISTRO DESC;";
            $result = $this->QueryObtieneDatosN();
            $data = null;
            while ($tsArray = (ibase_fetch_object($result))) {
                    $data[] = $tsArray;
            }
            return $data;            
        }

        function estadoCuentaRegistrar($idcuenta, $fecha, $descripcion, $monto){
            $TIME = time();
            $HOY = date("Y-m-d H:i:s", $TIME);
            $USUARIO = $_SESSION['user']->USER_LOGIN;
            $AUTOINCREMENT = "SELECT coalesce(MAX(ID), 0) FROM ESTADOCUENTA_REGISTRO";
            $this->query = "INSERT INTO ESTADOCUENTA_REGISTRO VALUES (";
            $this->query.= "($AUTOINCREMENT)+1, $idcuenta, '$fecha', '$descripcion',$monto,'$HOY','$USUARIO');";
            //echo "query: ".$this->query;
            $result=$this->EjecutaQuerySimple();
            return $result;
        }
        
        function obtenerEdoCtaDetalleDia($identificador, $dia){
            //$TIME = time();
            //$HOY = date("Y-m-d H:i:s", $TIME);
            $this->query = "SELECT FIRST 20 B.ID AS IDREGISTRO, A.ID AS IDENTIFICADOR, A.BANCO, A.NUM_CUENTA, B.FEREGISTRO, B.DSREGISTRO, B.DCREGISTRO 
                    FROM ESTADOCUENTA_REGISTRO B INNER JOIN PG_BANCOS A ON A.ID = B.IDCTABAN 
                    WHERE B.IDCTABAN = '$identificador' AND B.FEREGISTRO = CAST('$dia' AS TIMESTAMP) ORDER BY FEREGISTRO DESC;";
            
            $result = $this->QueryObtieneDatosN();
            //$data[] = null;
            while ($tsArray = (ibase_fetch_object($result))) {
                    $data[] = $tsArray;
            }
            return @$data;            
        }

        function listadoXrecibir(){
           $this->query = "SELECT ('Gasto'||'-'||cat.gasto) AS TIPO, A.ID AS IDENTIFICADOR, FECHA_DOC AS FECHA_PAGO, A.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO_PAGO AS MONTO, (A.MONTO_PAGO-A.PRESUPUESTO) AS DIFERENCIA, P.CUENTA_BANCARIA AS BANCO
                   FROM GASTOS A INNER JOIN PROV01 B ON A.CVE_PROV = B.CLAVE 
                   				INNER JOIN PAGO_GASTO P ON A.ID = P.IDGASTO  
                   				INNER JOIN CAT_GASTOS cat ON cat.id = A.CVE_CATGASTOS
                   				WHERE A.STATUS = 'I';";
           $result = $this->QueryObtieneDatosN();
           while ($tsArray = (ibase_fetch_object($result))) {
               $data[] = $tsArray;
           }
           $this->query = "SELECT 'ORDEN DE COMPRA' AS TIPO, CVE_DOC AS IDENTIFICADOR, FECHA_PAGO, CVE_CLPV AS CLAVE_PROVEEDOR, NOMBRE, PAGO_TES AS MONTO, A.BANCO AS BANCO "
                   . "FROM COMPO01 A INNER JOIN  PROV01 B "
                   . "ON A.CVE_CLPV = B.CLAVE WHERE STATUS_PAGO = 'I'";
           $result = $this->QueryObtieneDatosN();
           while ($tsArray = (ibase_fetch_object($result))) {
               $data[] = $tsArray;
           }                    
           return @$data;            
       }
       
       function marcarRecibido($tipo, $identificador, $fecha, $banco, $monto){
       	//	echo $tipo;
       		$tipo = strtoupper(substr($tipo, 0, 5));
       	//	echo $tipo;
       	//	break;
           if($tipo=="GASTO"){
               $this->query = "UPDATE GASTOS SET STATUS = 'V' WHERE ID = '$identificador';";
        //       echo $this->query;
        //       break;
           }else{
               $this->query = "UPDATE COMPO01 SET STATUS_PAGO = 'V' WHERE CVE_DOC = '$identificador';";
           }
           $result = $this->EjecutaQuerySimple();
           /// Actualizacion para el control del saldo del estado de cuenta desde PG_Bancos
           	$campo='MOVR'.substr($fecha, 5,2);
			$camposf='SALDOF'.substr($fecha, 5,2);
			//echo 'Asi llega el Banco'.$banco;
			if($banco !=''){
				$cuenta=split('-',$banco);
			}
			$cuenta2=trim($cuenta[1]);

				/// Actualizamos los movimientos de cargo mensual segun el mes:
           		$this->query="UPDATE PG_BANCOS SET $campo= ($campo + $monto), $camposf=($camposf + $monto) where trim(NUM_CUENTA) = trim('$cuenta2')";
           		$rs=$this->EjecutaQuerySimple();
           		/// Actualizamos el saldo: de la cuenta:
           		$this->query="UPDATE PG_BANCOS SET SALDO= (SALDOF01 + SALDOF02 + SALDOF03 + SALDOF04 + SALDOF05 + SALDOF07 + SALDOF08 + SALDOF09 + SALDOF10 + SALDOF11 + SALDOF12 + SALDOI)";
           		$rs=$this->EjecutaQuerySimple();


           return $result;
       }
       
       function listadoXconciliar(){
           $this->query = "SELECT 'GASTO' AS TIPO, ID AS IDENTIFICADOR, FECHA_CREACION AS FECHA_PAGO, A.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO_PAGO AS MONTO, (A.MONTO_PAGO-PRESUPUESTO) AS DIFERENCIA
                   FROM GASTOS A INNER JOIN PROV01 B ON A.CVE_PROV = B.CLAVE WHERE A.STATUS = 'V';";
           $result = $this->QueryObtieneDatosN();
           while ($tsArray = (ibase_fetch_object($result))) {
               $data[] = $tsArray;
           }
           $this->query = "SELECT 'ORDEN DE COMPRA' AS TIPO, CVE_DOC AS IDENTIFICADOR, FECHA_PAGO, CVE_CLPV AS CLAVE_PROVEEDOR, NOMBRE, PAGO_TES AS MONTO "
                   . "FROM COMPO01 A INNER JOIN  PROV01 B "
                   . "ON A.CVE_CLPV = B.CLAVE WHERE STATUS_PAGO = 'V'";
           $result = $this->QueryObtieneDatosN();
           while ($tsArray = (ibase_fetch_object($result))) {
               $data[] = $tsArray;
           }                    
           return @$data;            
       }
       
       function pagoAconciliar($tipo, $identificador){
           if($tipo=="GASTO"){
               $this->query = "SELECT 'GASTO' AS TIPO, ID AS IDENTIFICADOR, FECHA_CREACION AS FECHA_PAGO, A.CVE_PROV AS CLAVE_PROVEEDOR, NOMBRE, MONTO_PAGO AS MONTO, (A.MONTO_PAGO-PRESUPUESTO) AS DIFERENCIA
                       FROM GASTOS A INNER JOIN PROV01 B ON A.CVE_PROV = B.CLAVE WHERE A.STATUS = 'V' AND A.ID = '$identificador';";
               $result = $this->QueryObtieneDatosN();
               while ($tsArray = (ibase_fetch_object($result))) {
                   $data[] = $tsArray;
               }
           } else {
               $this->query = "SELECT 'ORDEN DE COMPRA' AS TIPO, CVE_DOC AS IDENTIFICADOR, FECHA_PAGO, CVE_CLPV AS CLAVE_PROVEEDOR, NOMBRE, PAGO_TES AS MONTO "
                       . "FROM COMPO01 A INNER JOIN  PROV01 B "
                       . "ON A.CVE_CLPV = B.CLAVE WHERE STATUS_PAGO = 'V' AND CVE_DOC = '$identificador';";
               $result = $this->QueryObtieneDatosN();
               while ($tsArray = (ibase_fetch_object($result))) {
                   $data[] = $tsArray;
               }       
           }
           return @$data;            
       }
       
       function pagoConciliar($tipo, $identificador, $fecha){
           $TIME = time();
           $HOY = date("Y-m-d H:i:s", $TIME);
           $rs = $this->xAutorizarDictamen($tipo, $identificador, "Z", "Pago conciliado: $HOY", $fecha);
           return $rs;
       }
       
 	function xAutorizarDictamen($tipo, $identificador, $dictamen, $comentarios){
           if($tipo == "GASTO") {       	 
                   $dictamen = $dictamen=='A'?'E':'R';
                  $this->query = "UPDATE GASTOS
                            SET STATUS = '$dictamen', Autorizacion = '1'
                        WHERE ID = '$identificador'";
                   $rs = $this->EjecutaQuerySimple();
           } else {
                   //$dictamen = $dictamen=='A'?'PP':'PR';
                   $this->query = "UPDATE compo01
                            SET STATUS_PAGO = '$dictamen'
                        WHERE CVE_DOC = '$identificador'";
                   $rs = $this->EjecutaQuerySimple();
           }
           $AUTOINCREMENT = "SELECT coalesce(MAX(ID), 0) FROM PAGO_AUTORIZACION";
           $this->query = "INSERT INTO PAGO_AUTORIZACION (ID, IDPAGO, TXCOMENTARIO, FECHA_DICTAMEN,USUARIO_REGISTRA) "
                   . "VALUES (($AUTOINCREMENT)+1, '$identificador','$comentarios',current_timestamp ,'" . $_SESSION['user']->USER_LOGIN . "')";
           $rs+=$this->EjecutaQuerySimple();
           return $rs;
  	}

  	function ActStatusImp($identificador){
  		$a="UPDATE GASTOS SET STATUS = 'I' WHERE ID = $identificador";
  		$this->query=$a;
  		$rs=$this->EjecutaQuerySimple();
  		return @$rs;
  	}  	

  	function guardaPago($cliente, $monto, $fechaA, $fechaR, $banco){
  		$usuario=$_SESSION['user']->USER_LOGIN;
  		$a="INSERT INTO CARGA_PAGOS (CLIENTE, FECHA, MONTO, SALDO, USUARIO, BANCO, Fecha_Apli, Fecha_Recep,  )
  					VALUES ('$cliente',current_timestamp, $monto, $monto, '$usuario', '$banco','$fechaA', '$fechaR')";
  		$this->query = $a;
  		$rs=$this->EjecutaQuerySimple();
  		return $rs; 
  	}

  	function regPagos($cliente){
  		$a="SELECT * from CARGA_PAGOS where TRIM(cliente) = TRIM('$cliente')";
  		$this->query=$a;
  		$rs=$this->QueryObtieneDatosN();
  		while ($tsArray=ibase_fetch_object($rs)){
  			$data[]=$tsArray;
  		}
  		return @$data;
  	}

  	function saldoXaplicar(){
  		$a="SELECT cliente, sum(SALDO) from carga_pagos group by cliente;";
  		$this->query=$a;
  		$rs=$this->QueryObtieneDatosN();
  		while($tsArray=ibase_fetch_object($rs)){
  			$data[]=$tsArray;
  		}
  		return @$data;
  	}

  	function aplicarPago($cliente){
    	$a="SELECT c.*,
     	(select SUM(s.SALDO) from carga_pagos s where trim(c.clave) = trim(s.cliente)) as sxa,
     	ca.*,
     	(SELECT SUM(IMPORTE) FROM FACTP01 WHERE DOC_ANT = '' AND TRIM(CVE_CLPV) = TRIM('$cliente')) as MONTO_PEDIDOS,
     	((SELECT SUM(IMPORTE) FROM factf01 WHERE TRIM(CVE_CLPV) = TRIM('$cliente')) -
     	(SELECT SUM(IMPORTE) FROM CUEN_DET01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente') AND SIGNO = -1 )) AS MONTO_FACTURADO,
     	(SELECT SUM(IMPORTE) FROM FACTF01 WHERE FECHA_VEN > current_date AND TRIM(CVE_CLPV) = TRIM('$cliente')) AS VENCIDO,
     	ca.LINEA_CRED -(((SELECT SUM(IMPORTE) FROM FACTP01 WHERE DOC_ANT = '' AND TRIM(CVE_CLPV) = TRIM('$cliente'))+((SELECT SUM(IMPORTE) FROM factf01 WHERE TRIM(CVE_CLPV) = TRIM('$cliente')))) -
     	(SELECT SUM(IMPORTE) FROM CUEN_DET01 WHERE TRIM(CVE_CLIE) = TRIM('$cliente') AND SIGNO = -1 ))  AS DISPONIBLE
            FROM CLIE01 c
            left join cartera ca on trim(ca.idcliente) = trim(c.clave)
            WHERE TRIM(CLAVE)=TRIM('$cliente')";
    	$this->query = $a;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function traeFacturas($cliente){
    	$a="SELECT FIRST 100 f.*, c.fecha_rec_cobranza, c.contrarecibo_cr, datediff(day, c.fecha_rec_cobranza,current_timestamp ) as dias
    		from FACTF01 f 
    		left join CAJAS c on f.cve_doc = c.factura
    		where trim(cve_clpv) = trim('$cliente')
    		order by f.fechaelab desc";
    	$this->query=$a;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function CuentasBancarias($banco, $cuenta){
    	$this->query="SELECT b.*, 
        	(SELECT SUM(MONTO) FROM CARGA_PAGOS p
            where extract(month from fecha_recep) = extract(month from current_date)
            and (b.banco||' - '||b.num_cuenta) = p.banco
            GROUP BY BANCO) as ABONOS_ACTUAL,
            (SELECT SUM(MONTO) FROM CARGA_PAGOS p
            where extract(month from fecha_recep)-1 = extract(month from current_date)-1
            and (b.banco||' - '||b.num_cuenta) = p.banco
            GROUP BY BANCO) as ABONOS_ANTERIOR,
            (SELECT SUM(SALDO) FROM CARGA_PAGOS p
            where extract(month from fecha_recep)-1 = extract(month from current_date)-1
            and (b.banco||' - '||b.num_cuenta) = p.banco
            GROUP BY BANCO) as MOV_X_REL_AC,
            (SELECT SUM(SALDO) FROM CARGA_PAGOS p
            where extract(month from fecha_recep)-1 = extract(month from current_date)-1
            and (b.banco||' - '||b.num_cuenta) = p.banco
            GROUP BY BANCO) as MOV_X_REL_AN
            FROM PG_BANCOS b 
           	where b.banco = '$banco' and b.num_cuenta='$cuenta'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function pagosTotalMensual($banco, $cuenta){
    	$this->query="SELECT SUM(MONTO), BANCO FROM CARGA_PAGOS where extract(month from fecha_recep) = extraxt(month from current_date) GROUP BY BANCO";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function traePagosActual($banco, $cuenta ){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE extract(MONTH from FECHA_RECEP) = extract(MONTH from CURRENT_DATE) and banco = ('$banco'||' - '||'$cuenta') AND STATUS <> 'C'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function traePagosAnterior($banco, $cuenta){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE extract(month from FECHA_RECEP)-1 = extract(month from current_date)-1";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    } 

    function ingresarPago($banco, $monto, $fecha, $ref){
    	$usuario=$_SESSION['user']->USER_LOGIN;
    	if(trim(substr($banco, 0,8))=='Banamex'){
    		$folio_1 = 'BNMX';
    	}elseif (trim(substr($banco, 0,8))=='Bancomer'){
    		$folio_1='BBVA';
    	}elseif (trim(substr($banco, 0,8))=='Multiva'){
    		$folio_1='MTVA';
    	}elseif (trim(substr($banco, 0,8))=='Inbursa'){
    		$folio_1='INBU';
    	}elseif(trim(substr($banco, 0,8))=='Banco Az'){
    		$folio_1='BAZT';
    	}
    	$this->query="SELECT MAX(cast(substring(FOLIO_X_BANCO from 6 for 6) as int)) as ULTIMO
    			FROM CARGA_PAGOS
    			WHERE FOLIO_X_BANCO STARTING WITH '$folio_1'";
    	$rs=$this->	QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	if(empty($row)){
    		$folio = 1;
    	}else{
    		$folio = $row->ULTIMO + 1;
    	}

    	$this->query="INSERT INTO CARGA_PAGOS (FECHA, MONTO, SALDO, USUARIO, BANCO, FECHA_RECEP, FOLIO_X_BANCO)
    					VALUES (current_timestamp, $monto, $monto, '$usuario', '$banco', '$fecha', '$folio_1'||'-'||'$folio')";
    					//var_dump($this);
    	$rs=$this->EjecutaQuerySimple();
	
		$campo='MOVR'.substr($fecha, 3,2);
		//echo 'valor del campo.'.$campo;
		$campoA='MOVS'.substr($fecha, 3,2);
		$camposf='SALDOF'.substr($fecha, 3,2);
		if($banco !=''){
			$cuenta=split('-',$banco);

		$this->query="UPDATE PG_BANCOS SET $campoA = iif($campoA is null,0,$campoA) + $monto where NUM_CUENTA=trim('$cuenta[1]') ";
		$rs=$this->EjecutaQuerySimple();
		}

		$this->query="UPDATE PG_BANCOS SET $camposf= ($camposf + $monto)
	    where num_cuenta = trim('$cuenta[1]')";
		$rs=$this->EjecutaQuerySimple();

		$this->query="UPDATE PG_BANCOS SET SALDO = (SALDOF01 + SALDOF02 + SALDOF03 + SALDOF04 + SALDOF05 + SALDOF07 + SALDOF08 + SALDOF09 + SALDOF10 + SALDOF11 + SALDOF12 + SALDOI)";
		$rs=$this->EjecutaQuerySimple();
		
    	return $rs;
    }

    function estado_de_cuenta($banco, $cuenta){
    	$data[]=null;
    	$this->query="SELECT 'Venta' AS TIPO, FOLIO_X_BANCO AS CONSECUTIVO, FECHA_RECEP AS FECHAMOV, MONTO AS MONTO, SALDO AS SALDO, BANCO AS BANCO, USUARIO AS USUARIO, tipo_pago as TP, ID as IDENTIFICADOR
    		   from carga_pagos where BANCO = ('$banco'||' - '||'$cuenta')";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	//$this->query="SELECT 'Gasto' AS TIPO, FOLIO_PAGO AS CONSECUTIVO, FECHA AS FECHAMOV, MONTO AS MONTO, 0 AS SALDO, TRIM(SUBSTRING(CUENTA_BANCARIA FROM 1 FOR 9)) AS BANCO, USUARIO_REGISTRA AS USUARIO 
    	//		FROM PAGO_GASTO WHERE CUENTA_BANCARIA = ('$banco'||' - '||'$cuenta') and status = 'V'";
    	//$rs=$this->QueryObtieneDatosN();
    	//while ($tsArray=ibase_fetch_object($rs)){
    	//	$data[]=$tsArray;
    	//}
    	$this->query="SELECT 'Compra' AS TIPO, CVE_DOC AS CONSECUTIVO, FECHAELAB AS FECHAMOV, IMPORTE AS MONTO, 0 AS SALDO, BANCO AS BANCO, '' AS USUARIO, 'tipoCompra' as TP, CVE_DOC as IDENTIFICADOR FROM COMPR01 WHERE BANCO = ('$banco'||' - '||'$cuenta')";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

	function estado_de_cuenta_mes($mes, $banco, $cuenta, $anio){

	   	 /// Pendientes edo de cuenta 
    	 /// Ordenar por fecha.
    	 /// cambiar el formato de los numero 


		echo 'Banco'.$banco.' Cuenta: '.$cuenta.'<p>'; 

    	$this->query="SELECT 1 as s, FECHA_RECEP AS sort, 'Venta' AS TIPO,  iif(FOLIO_X_BANCO = 'TR', (FOLIO_X_BANCO||id), FOLIO_X_BANCO) AS CONSECUTIVO, FECHA_RECEP AS FECHAMOV, MONTO AS ABONO, 0 AS CARGO, SALDO AS SALDO, BANCO AS BANCO, USUARIO AS USUARIO, tipo_pago as TP, id as identificador, registro as registro, folio_acreedor as FA , fecha_recep as fe, '' as comprobado, contabilizado, seleccionado, '' as tp_tes 
    		   from carga_pagos 
    		   where BANCO = ('$banco'||' - '||'$cuenta') and extract(month from fecha_recep) = $mes and extract(year from fecha_recep) = $anio AND STATUS <> 'C' and (seleccionado = 1 or seleccionado = 0 or seleccionado is null)  order by fecha_recep asc";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	
    	$this->query="SELECT  4 as s, iif(fecha_EDO_CTA is null, fecha_doc, fecha_EDO_CTA) as sort, 'Gasto' AS TIPO, pg.IDGASTO AS CONSECUTIVO, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta) AS FECHAMOV, 0 AS ABONO, g.MONTO_PAGO AS CARGO, 0 AS SALDO, pg.CUENTA_BANCARIA AS BANCO, pg.USUARIO_REGISTRA AS USUARIO, pg.FOLIO_PAGO as TP, ('GTR'||g.id) as identificador, '' as registro, '' as FA, iif(g.fecha_edo_cta is null, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta), g.fecha_edo_cta) as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado , SELECCIONADO, TIPO_PAGO as tp_tes 
    			FROM GASTOS g
    			left join pago_gasto pg on pg.idgasto = g.id
    			WHERE pg.CUENTA_BANCARIA = ('$banco'||' - '||'$cuenta') and iif(fecha_edo_cta is null,extract(month from g.FECHA_DOC), extract(month from fecha_edo_cta)) = $mes and iif(fecha_edo_cta is null, extract(year from g.FECHA_DOC), extract(year from fecha_edo_cta)) = $anio and g.status = 'V'  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null)  ";
    		//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    		
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT 2 as s, iif(edocta_fecha is null, fecha_doc, edocta_fecha) AS sort, 'Compra' AS TIPO, CVE_DOC AS CONSECUTIVO, iif(edocta_fecha is null, fecha_doc, edocta_fecha) AS FECHAMOV, 0 AS ABONO, IMPORTE AS CARGO, 0 AS SALDO, BANCO AS BANCO, '' AS USUARIO, 'Compra' as TP, cve_doc as identificador, registro as registro, 'FA' as FA, edocta_fecha as fe, fecha_edo_cta_ok as comprobado, contabilizado , SELECCIONADO, tp_tes 
    			FROM COMPO01 
    			WHERE BANCO = ('$banco'||' - '||'$cuenta') and extract(month from edocta_fecha) = $mes and extract(year from edocta_fecha) = $anio  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null) order by edocta_fecha asc";
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}



    	$this->query="SELECT 8 as s, iif(edocta_fecha is null, fecha_oc, edocta_fecha) AS sort, 'Compra' AS TIPO, OC AS CONSECUTIVO, iif(edocta_fecha is null, fecha_oc, edocta_fecha) AS FECHAMOV, 0 AS ABONO, PAGO_TES AS CARGO, 0 AS SALDO, BANCO AS BANCO, usuario_conta AS USUARIO, 'Compra' as TP, oc as identificador, registro as registro, 'FA' as FA, edocta_fecha as fe, fecha_edo_cta_ok as comprobado, contabilizado , SELECCIONADO, tp_tes 
    			FROM FTC_POC 
    			WHERE BANCO = ('$banco'||' - '||'$cuenta') and extract(month from edocta_fecha) = $mes and extract(year from edocta_fecha) = $anio  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null) order by edocta_fecha asc";
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	/*
			gastos     ---> tipo_pago
			compo01     ---> tp_tes
			cr_directo  ----> tp_tes sin folio.
			deudores    --->   tipo
			solicitud_pago ---> tp_tes_final
    	*/


    	$this->query="SELECT 3 as s, fecha_edo_cta as sort, 'Compra' as TIPO, (id||'-'||factura) as consecutivo, fecha_edo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo,  ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Compra' as TP, ('CD-'||id) as identificador,registro as registro, 'FA' as FA , fecha_edo_cta as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado, seleccionado, tp_tes
    		FROM CR_DIRECTO
    		where BANCO = '$banco' and cuenta = '$cuenta' and extract(month from fecha_EDO_CTA) = $mes and extract(year from fecha_edo_cta) = $anio and tipo = 'compra'  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null)  order by fecha_edo_cta asc ";
    	//echo 'Esta es de tipo compra(CR): '.$this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
       	$this->query="SELECT 5 as s, fecha_edo_cta as sort, 'Gasto Directo' as TIPO, (id||'-'||factura) as consecutivo, fecha_edo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo,  ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Compra' as TP, ('CD-'||id) as identificador,registro as registro, 'FA' as FA, fecha_edo_cta as fe , FECHA_EDO_CTA_OK as comprobado, contabilizado, SELECCIONADO, tp_tes
       		FROM CR_DIRECTO
    		where BANCO = '$banco' and cuenta = '$cuenta' and extract(month from fecha_EDO_CTA) = $mes and extract(year from fecha_EDO_CTA) = $anio and tipo = 'gasto'  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null)  order by fecha_edo_cta asc ";
    	//echo 'Esta es de tipo Gasto Directo(CR): '.$this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	$this->query="SELECT 6 as s, fechaedo_cta as sort, 'Deudor' as TIPO, ('D'||iddeudor) as consecutivo, fechaedo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo, ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Deudor' as TP, ('D'||iddeudor) as identificador, 'registro' as registro, 'FA' as FA, fechaedo_cta as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado, SELECCIONADO, tipo as tp_tes
    		from deudores 
    		where extract(month from fechaedo_cta) = $mes and extract(year from fechaedo_cta) = $anio and banco = ('$banco'||' - '||'$cuenta')  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null)  order by fechaedo_cta asc";
    		//echo $this->query;

    	$rs= $this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
		$this->query="SELECT 7 as s, fecha_edo_cta as sort , 'Compra a Credito' as TIPO, ('SOL-'||idsol) as consecutivo, fecha_edo_cta as fechamov, 0 as abono, monto_final as cargo, 0 as saldo, '$banco' as BANCO, usuario_pago as usuario, 'Compra' as TP, ('SOL-'||idsol) as identificador, registro as registro, 'FA' as FA, fecha_edo_cta as fe, FECHA_EDO_CTA_OK as comprobado , contabilizado, SELECCIONADO, (tp_tes_final || folio) as tp_tes
			FROM SOLICITUD_PAGO
			WHERE iif(fecha_edo_cta is null, extract(month from fecha),  EXTRACT(month from fecha_edo_cta)) = $mes and iif(fecha_edo_cta is null, extract(year from fecha),  EXTRACT(year from fecha_edo_cta)) = $anio and banco_final=('$banco'||' - '||'$cuenta')  and (seleccionado = 1 or seleccionado = 0 or seleccionado is null) order by fecha_edo_cta asc";
    	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="DELETE from CARGOS_MENSUALES";
    		$rs=$this->EjecutaQuerySimple();
    	/*
    	foreach ($data as $key) {

    		$this->query ="INSERT INTO CARGOS_MENSUALES(TIPO, CONSECUTIVO, FECHAMOV, ABONO, CARGO, SALDO, BANCO, USUARIO, TP, IDENTIFICADOR, REGISTRO, FA, FE, COMPROBADO, MES, ANIO)
    						VALUES('$key->TIPO', '$key->CONSECUTIVO', '$key->FECHAMOV', $key->ABONO, $key->CARGO,$key->SALDO, '$key->BANCO', '$key->USUARIO', '$key->TP', '$key->IDENTIFICADOR', '$key->REGISTRO', '$key->FA', '$key->FE', '$key->COMPROBADO', $mes,$anio)"; 
    		$rs=$this->EjecutaQuerySimple();	
    	}*/

    	sort($data);
    	return @$data;
    }

    function estado_de_cuenta_mes_docs($mes, $banco, $cuenta, $anio){

	   	 /// Pendientes edo de cuenta 
    	 /// Ordenar por fecha.
    	 /// cambiar el formato de los numero 

    	$this->query="SELECT 1 as s, FECHA_RECEP AS sort, 'Venta' AS TIPO,  iif(FOLIO_X_BANCO = 'TR', (FOLIO_X_BANCO||id), FOLIO_X_BANCO) AS CONSECUTIVO, FECHA_RECEP AS FECHAMOV, MONTO AS ABONO, 0 AS CARGO, SALDO AS SALDO, BANCO AS BANCO, USUARIO AS USUARIO, tipo_pago as TP, id as identificador, registro as registro, folio_acreedor as FA , fecha_recep as fe, '' as comprobado, contabilizado, seleccionado, '' as TP_TES
    		   from carga_pagos 
    		   where BANCO = ('$banco'||' - '||'$cuenta') and extract(month from fecha_recep) = $mes and extract(year from fecha_recep) = $anio AND STATUS <> 'C' and (seleccionado = 2 )  order by fecha_recep asc";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	
    	$this->query="SELECT  4 as s, iif(fecha_EDO_CTA is null, fecha_doc, fecha_EDO_CTA) as sort, 'Gasto' AS TIPO, pg.ID AS CONSECUTIVO, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta) AS FECHAMOV, 0 AS ABONO, g.MONTO_PAGO AS CARGO, 0 AS SALDO, pg.CUENTA_BANCARIA AS BANCO, pg.USUARIO_REGISTRA AS USUARIO, pg.FOLIO_PAGO as TP, ('GTR'||g.id) as identificador, '' as registro, '' as FA, iif(g.fecha_edo_cta is null, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta), g.fecha_edo_cta) as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado , SELECCIONADO
    			FROM GASTOS g
    			left join pago_gasto pg on pg.idgasto = g.id
    			WHERE pg.CUENTA_BANCARIA = ('$banco'||' - '||'$cuenta') and iif(fecha_edo_cta is null,extract(month from g.FECHA_DOC), extract(month from fecha_edo_cta)) = $mes and iif(fecha_edo_cta is null, extract(year from g.FECHA_DOC), extract(year from fecha_edo_cta)) = $anio and g.status = 'V'  and (seleccionado = 2 ) ";
    		//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    		
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	$this->query="SELECT 2 as s, iif(edocta_fecha is null, fecha_doc, edocta_fecha) AS sort, 'Compra' AS TIPO, CVE_DOC AS CONSECUTIVO, iif(edocta_fecha is null, fecha_doc, edocta_fecha) AS FECHAMOV, 0 AS ABONO, IMPORTE AS CARGO, 0 AS SALDO, BANCO AS BANCO, '' AS USUARIO, 'Compra' as TP, cve_doc as identificador, registro as registro, 'FA' as FA, edocta_fecha as fe, fecha_edo_cta_ok as comprobado, contabilizado , SELECCIONADO 
    			FROM COMPO01 
    			WHERE BANCO = ('$banco'||' - '||'$cuenta') and extract(month from edocta_fecha) = $mes and extract(year from edocta_fecha) = $anio  and (seleccionado = 2 ) order by edocta_fecha asc";
    	$rs=$this->QueryObtieneDatosN();
    	///echo $this->query;
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

		$this->query="SELECT 8 as s, iif(edocta_fecha is null, fecha_oc, edocta_fecha) AS sort, 'Compra' AS TIPO, OC AS CONSECUTIVO, iif(edocta_fecha is null, fecha_oc, edocta_fecha) AS FECHAMOV, 0 AS ABONO, PAGO_TES AS CARGO, 0 AS SALDO, BANCO AS BANCO, usuario_conta AS USUARIO, 'Compra' as TP, oc as identificador, registro as registro, 'FA' as FA, edocta_fecha as fe, fecha_edo_cta_ok as comprobado, contabilizado , SELECCIONADO, tp_tes 
    			FROM FTC_POC 
    			WHERE BANCO = ('$banco'||' - '||'$cuenta') and extract(month from edocta_fecha) = $mes and extract(year from edocta_fecha) = $anio  and seleccionado = 2 order by edocta_fecha asc";
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}



    	$this->query="SELECT 3 as s, fecha_edo_cta as sort, 'Compra' as TIPO, (id||'-'||factura) as consecutivo, fecha_edo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo,  ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Compra' as TP, ('CD-'||id) as identificador,registro as registro, 'FA' as FA , fecha_edo_cta as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado, seleccionado
    		FROM CR_DIRECTO
    		where BANCO = '$banco' and cuenta = '$cuenta' and extract(month from fecha_EDO_CTA) = $mes and extract(year from fecha_edo_cta) = $anio and tipo = 'compra'  and (seleccionado = 2 ) order by fecha_edo_cta asc ";
    	//echo 'Esta es de tipo compra(CR): '.$this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
       	$this->query="SELECT 5 as s, fecha_edo_cta as sort, 'Gasto Directo' as TIPO, factura as consecutivo, fecha_edo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo,  ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Compra' as TP, ('CD-'||id) as identificador,registro as registro, 'FA' as FA, fecha_edo_cta as fe , FECHA_EDO_CTA_OK as comprobado, contabilizado, SELECCIONADO
       		FROM CR_DIRECTO
    		where BANCO = '$banco' and cuenta = '$cuenta' and extract(month from fecha_EDO_CTA) = $mes and extract(year from fecha_EDO_CTA) = $anio and tipo = 'gasto'  and (seleccionado = 2 )  order by fecha_edo_cta asc ";
    	//echo 'Esta es de tipo Gasto Directo(CR): '.$this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	$this->query="SELECT 6 as s, fechaedo_cta as sort, 'Deudor' as TIPO, ('D'||iddeudor) as consecutivo, fechaedo_cta as fechamov, 0 as abono, importe as CARGO, 0 as saldo, ('$banco'||' - '||'$cuenta') as BANCO, usuario as usuario, 'Deudor' as TP, ('D'||iddeudor) as identificador, 'registro' as registro, 'FA' as FA, fechaedo_cta as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado, SELECCIONADO
    		from deudores 
    		where extract(month from fechaedo_cta) = $mes and extract(year from fechaedo_cta) = $anio and banco = ('$banco'||' - '||'$cuenta')  and (seleccionado = 2 )  order by fechaedo_cta asc";
    		//echo $this->query;

    	$rs= $this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
		$this->query="SELECT 7 as s, fecha_edo_cta as sort , 'Compra a Credito' as TIPO, ('SOL-'||idsol) as consecutivo, fecha_edo_cta as fechamov, 0 as abono, monto_final as cargo, 0 as saldo, '$banco' as BANCO, usuario_pago as usuario, 'Compra' as TP, ('SOL-'||idsol) as identificador, registro as registro, 'FA' as FA, fecha_edo_cta as fe, FECHA_EDO_CTA_OK as comprobado , contabilizado, SELECCIONADO
			FROM SOLICITUD_PAGO
			WHERE EXTRACT(month from fecha_edo_cta) = $mes and extract(year from fecha_edo_cta) = $anio and banco_final=('$banco'||' - '||'$cuenta')  and (seleccionado = 2 ) order by fecha_edo_cta asc";
    	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="DELETE from CARGOS_MENSUALES";
    		$rs=$this->EjecutaQuerySimple();
    	
    	foreach ($data as $key) {

    		$this->query ="INSERT INTO CARGOS_MENSUALES(TIPO, CONSECUTIVO, FECHAMOV, ABONO, CARGO, SALDO, BANCO, USUARIO, TP, IDENTIFICADOR, REGISTRO, FA, FE, COMPROBADO, MES, ANIO)
    						VALUES('$key->TIPO', '$key->CONSECUTIVO', '$key->FECHAMOV', $key->ABONO, $key->CARGO,$key->SALDO, '$key->BANCO', '$key->USUARIO', '$key->TP', '$key->IDENTIFICADOR', '$key->REGISTRO', '$key->FA', '$key->FE', '$key->COMPROBADO', $mes,$anio)"; 
    		$rs=$this->EjecutaQuerySimple();	
    	}
    	sort($data);
    	return @$data;
    }

    function saldosBancos($mes, $banco , $cuenta, $anio){
    	$this->query="SELECT * FROM PG_BANCOS WHERE BANCO = '$banco' and NUM_CUENTA = '$cuenta'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	//echo $this->query;
    	return $data;
    }

    function traeMeses(){
    	$this->query="SELECT NOMBRE, NUMERO, ANHIO FROM PERIODOS_2016 where anhio = 2016 order by anhio, numero";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traeNombreMes($mes){
    	$this->query="SELECT NOMBRE, NUMERO FROM PERIODOS_2016 where numero = $mes";
    	$rs=$this->QueryObtieneDatosN();
    	while ($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;

    }

    function traeMes($mes){
    	$this->query="SELECT NOMBRE, FECHA_INI, FECHA_FIN, NUMERO FROM PERIODOS_2016 WHERE NUMERO = $mes";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	return $row;

    }


    function traeFactura($docf){
    	$this->query="SELECT f.* , c.nombre, c.clave, ca.status_log , ca.aduana
    		FROM FACTF01 f
    		left join clie01 c on c.clave = f.cve_clpv 
    		left join cajas ca on ca.factura = f.cve_doc
    		WHERE f.STATUS <> 'C' and cve_doc CONTAINING('$docf')";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function cambiarFactura($docf1, $tipo){

    	$usuario=$_SESSION['user']->USER_LOGIN;
    	$this->query="SELECT COUNT(ID) AS CAJA FROM CAJAS WHERE FACTURA = '$docf1'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$caja = $row->CAJA;

    	if( $caja == 0 ){
    		$this->query="SELECT DOC_ANT, CVE_CLPV AS CLIENTE from factf01 where cve_doc = '$docf1'";
    		$rs=$this->QueryObtieneDatosN();
    		$row=ibase_fetch_object($rs);
    		$docp = $row->DOC_ANT; 
    		$cvecli=$row->CLIENTE;

    			$this->query="SELECT CARTERA_COBRANZA AS CC, CARTERA_REVISION AS CR, DIAS_REVISION AS DR, DIAS_PAGO AS DP, REV_DOSPASOS AS RDP, ENVIO FROM CARTERA WHERE TRIM(IDCLIENTE) = TRIM('$cvecli')";
    			$rs=$this->EjecutaQuerySimple();
    			$row=ibase_fetch_object($rs);
    			if (empty($row)){
    					$carteraR= 's/i';
    					$carteraC= 's/i';
    					$dr = 's/i';
    					$dp = 's/i';
    					$envio='S/i';
    					$rev2='N';
    				}else{
    					$carteraR= $row->CR;
    					$carteraC= $row->CC;
    					$dr = $row->DR;
    					$dp = $row->DP;
    					$envio=$row->ENVIO;
    					$rev2=$row->RDP;
    				}
    				if(empty($docp) or substr($docp, 0,1)== 'C'){
    					$docp='directa';
    				}
    			
    		if(substr($docp, 0,1) == 'P'){
    			$this->query="INSERT INTO CAJAS (FECHA_CREACION, FECHA_CIERRE, STATUS, CVE_FACT, REMISION, FACTURA, NC, UNIDAD, STATUS_LOG, COMPLETA, RUTA, FECHA_SECUENCIA, IDU, PESO, SECUENCIA, HORAI, HORAF, DOCS, CIERRE_UNI, CIERRE_TOT, CAJAS, EMBALAJE, MOTIVO, STATUS_MER, CONTRARECIBO, VAL_ADUANA, CONTRARECIBO_CR, STATUSCR_CR, ENVIO, REV_DOSPASOS, GUIA_FLETERA, FLETERA, LOGISTICA, ADUANA, VUELTAS, USUARIO_LOG, USUARIO_CAJA, FECHA_DESLINDE_REVISION, SOL_DESLINDE, FECHA_SOL, CR, DIAS_REVISION, CC, DIAS_PAGO, USUARIO_ADUANA, FECHA_ADUANA, SOL_DES_ADUANA, FECHA_SOL_DESADU, USUARIO_DES_ADU, FECHA_GUIA, FECHA_ENTREGA, FECHA_U_LOGISTICA, FECHA_U_BODEGA, STATUS_CTRL_DOC_ENTREGA, IMP_COMP_REENRUTAR, FOLIO_DEV, FOLIO_RECMCIA, DOCFACT)
            		VALUES( current_timestamp, current_timestamp, 'cerrado','$docp','directa','$docf1','', '99', 'Entregado', '1', 'A', current_timestamp,99, 9.99,1,current_time, current_time, 'No','ok','ok', 1, 'Total', '','Total', 'Directo', null,null,  'N', '$envio' ,'$rev2',null,null, 'Total', 'Cobranza',0,'$usuario', '$usuario',null, null, null, iif('$carteraR' is null, 'n/C','$carteraR'), '$dr', '$carteraC', '$dp', '$usuario',current_timestamp, null, null, '$usuario', null, null, null, null, 'Nu', null, null, 'no','')";

            		$rs=$this->EjecutaQuerySimple();
    		}elseif($docp == 'directa'){
    			echo 'vale';
    			 $this->query="INSERT INTO CAJAS (FECHA_CREACION, FECHA_CIERRE, STATUS, CVE_FACT, REMISION, FACTURA, NC, UNIDAD, STATUS_LOG, COMPLETA, RUTA, FECHA_SECUENCIA, IDU, PESO, SECUENCIA,HORAI, HORAF, DOCS, CIERRE_UNI, CIERRE_TOT, CAJAS, EMBALAJE, MOTIVO, STATUS_MER, CONTRARECIBO, VAL_ADUANA, CONTRARECIBO_CR, STATUSCR_CR, ENVIO, REV_DOSPASOS, GUIA_FLETERA, FLETERA, LOGISTICA, ADUANA, VUELTAS, USUARIO_LOG, USUARIO_CAJA, FECHA_DESLINDE_REVISION, SOL_DESLINDE, FECHA_SOL, CR, DIAS_REVISION, CC, DIAS_PAGO, USUARIO_ADUANA, FECHA_ADUANA, SOL_DES_ADUANA, FECHA_SOL_DESADU, USUARIO_DES_ADU, FECHA_GUIA, FECHA_ENTREGA, FECHA_U_LOGISTICA, FECHA_U_BODEGA, STATUS_CTRL_DOC_ENTREGA, IMP_COMP_REENRUTAR, FOLIO_DEV, FOLIO_RECMCIA, DOCFACT )
            		 VALUES( current_timestamp, current_timestamp, 'cerrado','directa','directa','$docf1','', '99', 'Entregado', '1', 'A', current_timestamp,99, 9.99,1,current_time, current_time,  'No',
                    'ok','ok', 1, 'Total', '','Total', 'Directo', null,null,  'N', '$envio' ,'$rev2',null,null, 'TOtal', 'Cobranza',
                    0,'$usuario', '$usuario',null, null, null, '$carteraR', '$dr', '$carteraC', '$dp', '$usuario',current_timestamp, null, null, '$usuario',
                    null, null, null, null, 'Nu', null, null, 'no','')";

                    $rs = $this->EjecutaQuerySimple();
    		}elseif(trim(substr($docp, 10,1)) ==  0){

    			$this->query="SELECT DOC_ANT from factr01 where cve_doc = '$docp'";

	    		$rs=$this->EjecutaQuerySimple();
    			$row=ibase_fetch_object($rs);
    			$docp = $row->DOC_ANT;

    			 $this->query="INSERT INTO CAJAS (FECHA_CREACION, FECHA_CIERRE, STATUS, CVE_FACT, REMISION, FACTURA, NC, UNIDAD, STATUS_LOG, COMPLETA, RUTA, FECHA_SECUENCIA, IDU, PESO, SECUENCIA,HORAI, HORAF, DOCS, CIERRE_UNI, CIERRE_TOT, CAJAS, EMBALAJE, MOTIVO, STATUS_MER, CONTRARECIBO, VAL_ADUANA, CONTRARECIBO_CR, STATUSCR_CR, ENVIO, REV_DOSPASOS, GUIA_FLETERA, FLETERA, LOGISTICA, ADUANA, VUELTAS, USUARIO_LOG, USUARIO_CAJA, FECHA_DESLINDE_REVISION, SOL_DESLINDE, FECHA_SOL, CR, DIAS_REVISION, CC, DIAS_PAGO, USUARIO_ADUANA, FECHA_ADUANA, SOL_DES_ADUANA, FECHA_SOL_DESADU, USUARIO_DES_ADU, FECHA_GUIA, FECHA_ENTREGA, FECHA_U_LOGISTICA, FECHA_U_BODEGA, STATUS_CTRL_DOC_ENTREGA, IMP_COMP_REENRUTAR, FOLIO_DEV, FOLIO_RECMCIA, DOCFACT )
            		 VALUES(current_timestamp, current_timestamp, 'cerrado','$docp','directa','$docf1','', '99', 'Entregado', '1', 'A', current_timestamp,99, 9.99,1,current_time, current_time,  'No','ok','ok', 1, 'Total', '','Total', 'Directo', null,null, 'N', '$envio' ,'$rev2',null,null, 'Total', 'Cobranza', 0,'$usuario', '$usuario',null, null, null, iif('$carteraR' is null, 'n/C','$carteraR'), '$dr', '$carteraC', '$dp', '$usuario',current_timestamp, null, null, '$usuario',null, null, null, null, 'Nu', null, null, 'no','')";

                    $rs=$this->EjecutaQuerySimple();

                }
    		
    	}else{

    		if($tipo == 'C'){
    			$this->query="UPDATE CAJAS SET ADUANA = 'Cobranza', fecha_rec_cobranza = current_timestamp where factura = '$docf1'";
    			$rs=$this->EjecutaQuerySimple();
    			return $rs;	
    		}elseif($tipo=='R') {
    			$this->query="UPDATE Cajas SET STATUS_LOG = 'Entregado', Aduana = null where factura = '$docf1'";
    			$rs=$this->EjecutaQuerySimple();
    			return $rs;
    		}	
    	}


    	return $rs;
	}

	function porFacturarEmbalar($docp){		//01072016

		$this->query="SELECT a.cotiza, sum(rec_faltante) as Faltante, MAX(NOM_CLI) AS NOM_CLI, MAX (CLIEN) AS CLIEN, max(c.codigo) as CODIGO, 
                MAX(b.doc_sig) as FACTURA, max (a.fechasol) as FECHASOL, max(b.importe) as IMPORTE, max(datediff(day,b.FECHAELAB,current_date)) as DIAS,
                MAX(b.CITA) as CITA, max(factura) as factura, max(fecha_fact) as fecha_factu, sum(a.recepcion) as recibido,  sum(a.empacado) as empacado, max(f.fechaelab) as fecha_fact,
                sum(a.facturado) as facturado, sum(a.remisionado) as remisionado, sum(pendiente_facturar) as penfact, sum(pendiente_remisionar) as penrem
                FROM preoc01 a
                LEFT JOIN FACTP01 b on a.cotiza = b.cve_doc
                LEFT JOIN CLIE01 c on b.cve_clpv = c.Clave
                left join factf01 f on f.cve_doc = a.factura 
                left join factr01 r on r.cve_doc = a.remision 
                group by cotiza
                HAVING cotiza = '$docp'";
               /* and (max(f.fechaelab) > '01.08.2016' or max(r.fechaelab) > '01.07.2016')"; /*PENDIENTE*/
		$result = $this->QueryObtieneDatosN();
		while ($tsArray = ibase_fetch_object($result)){
						$data[] = $tsArray;
				
		}
			return $data;
	}

	function regCompras($mes){
		$this->query="SELECT c.*, p.nombre 
					FROM COMPO01 c
					LEFT JOIN PROV01 p ON c.cve_clpv = p.clave 
					WHERE c.status != 'C'and edocta_fecha is null and extract(month from fechaelab) = $mes";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function regCompEdoCta($fecha, $docc, $mes, $pago, $banco,$tptes){
		$this->query="UPDATE COMPO01 SET EDOCTA_FECHA = '$fecha', edocta_reg = current_timestamp, edocta_status = 'I' where cve_doc='$docc'";
		$rs=$this->EjecutaQuerySimple();

		$campo='MOVR'.substr($fecha, 0,2);
		$campoA='MOVS'.substr($fecha, 0,2);
		$camposf='SALDOF'.substr($fecha, 0,2);
		if($banco !=''){
			$cuenta=split('-',$banco);

		$this->query="UPDATE PG_BANCOS SET $campo = iif($campo is null,0,$campo) + iif($pago IS NULL,0,$pago) where NUM_CUENTA=trim('$cuenta[1]') ";
		$rs=$this->EjecutaQuerySimple();
		}

		$this->query="UPDATE PG_BANCOS SET $camposf= ($camposf - iif($pago IS NULL,0,$pago))
	    where num_cuenta = trim('$cuenta[1]')";
		$rs=$this->EjecutaQuerySimple();

		$this->query="UPDATE PG_BANCOS SET SALDO = (SALDOF01 + SALDOF02 + SALDOF03 + SALDOF04 + SALDOF05 + SALDOF07 + SALDOF08 + SALDOF09 + SALDOF10 + SALDOF11 + SALDOF12 + SALDOI)";
		$rs=$this->EjecutaQuerySimple();
		
		return $rs;

	}

	function listarPagosCredito(){
       //SELECT ID, BENEFICIARIO, MONTO, DOCUMENTO, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM GASTOS_PAGOS_CREDITO;
       //SELECT ID, BENEFICIARIO, MONTO, DOCUMENTO, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM OC_PAGOS_CREDITO;
       $this->query = "SELECT 'RECEPCION' AS TIPO, ID, BENEFICIARIO, MONTO, OC, RECEPCION, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM OC_PAGOS_CREDITO where STATUS_CREDITO = 1 ";
       //$this->query.= " UNION ";
      // $this->query.= "SELECT 'GASTO' AS TIPO, ID, BENEFICIARIO, MONTO, DOCUMENTO, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM GASTOS_PAGOS_CREDITO;";
       
       $result = $this->QueryObtieneDatosN();
       while ($tsArray = (ibase_fetch_object($result))) {
           $data[] = $tsArray;
       }

       $this->query="SELECT 'RECEPCION_PEGASO' AS TIPO, ID, BENEFICIARIO, MONTO, OC, RECEPCION, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM OC_PAGOS_CREDITO_RECIBO where status_credito is null";

       $result = $this->QueryObtieneDatosN();
       while ($tsArray = (ibase_fetch_object($result))) {
           $data[] = $tsArray;
       }
       //echo 'Esta es la consulta';
 //        $this->query = "SELECT 'GASTO' AS TIPO, ID, BENEFICIARIO, MONTO, DOCUMENTO, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM GASTOS_PAGOS_CREDITO ORDER BY PROMESA_PAGO;";
 //        $result = $this->QueryObtieneDatosN();
 //        while ($tsArray = (ibase_fetch_object($result))) {
 //            $data[] = $tsArray;
 //        }
       return @$data;     
   }


  function detallePagoCredito($tipo, $identificador){        
         if($tipo=="GASTO"){            
             $this->query = "SELECT 'GASTO' AS TIPO, ID, BENEFICIARIO, MONTO, MAIL, DOCUMENTO, FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO FROM GASTOS_PAGOS_CREDITO WHERE ID = $identificador;";
         } elseif($tipo=="RECEPCION") {
             $this->query = "SELECT 'RECEPCION' AS TIPO, ID, BENEFICIARIO, MONTO, MAIL, OC, RECEPCION , FECHA_DOC, DIASCRED, VENCIMIENTO, PROMESA_PAGO, FACTURA, MONTOR, recepcion as documento  FROM OC_PAGOS_CREDITO WHERE ID = '$identificador';";
         } elseif ($tipo == "RECEPCION_PEGASO") {
         	$this->query="SELECT 'RECEPCION_PEGASO' AS TIPO, ID, BENEFICIARIO, MONTO, MAIL, OC, RECEPCION, FECHA_DOC, DIASCRED, VENCIMIENTO, 
         		PROMESA_PAGO, FACTURA, MONTOR, recepcion as documento from OC_PAGOS_CREDITO_RECIBO where id = '$identificador'";
         }       

         $result = $this->QueryObtieneDatosN();
         while ($tsArray = (ibase_fetch_object($result))){
             $data[] = $tsArray;
         }
         return @$data;              
   }

   
    function actualizarRecepcion($identificador){
    	
    	//echo 'identificador: '.$identificador.'<p>';
    	//break;
    	if(substr($identificador, 10,1 == 0)){
    		$this->query="UPDATE COMPR01 SET STATUS_CREDITO = 2 WHERE TRIM(CVE_DOC) = TRIM('$identificador')";
        }else{
        	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET STATUS_CREDITO = 2 WHERE TRIM(orden ) = TRIM('$identificador')";
        }
        $act=$this->EjecutaQuerySimple();
        //echo 'Actualiza Recepcion: '.$this->query.'<p>';
        return $act;
    }
 


   function actualizaPagoCreditoContrarecibo($tipo, $identificador){
        if($tipo == "GASTO"){
            $this->query = "UPDATE GASTOS SET STATUS = 'I' WHERE ID = $identificador;";
        }  elseif($tipo =="RECEPCION") {
            $this->query = "UPDATE P_CREDITO SET STATUS = 'I' WHERE ID = $identificador;";
        }elseif ($tipo =="RECEPCION_PEGASO") {
        	 $this->query = "UPDATE P_CREDITO SET STATUS = 'I' WHERE DOCUMENTO = '$identificador';";
        }
        //echo "Actualiza pago credito contraRecibo: ".$this->query.'<p>';
        $respuesta = $this->EjecutaQuerySimple();
        return $respuesta;     
    }

     function listarOCAduana($mes, $anio){
         //status_log debe de ser Total, Fallido o PNR. 
         $this->query = "SELECT CVE_DOC AS IDENTIFICADOR,FECHA_DOC AS FECHA_DOCUMENTO, IMPORTE AS MONTO, NOMBRE FROM COMPO01 A INNER JOIN PROV01 B ON A.CVE_CLPV = B.CLAVE WHERE STATUS_LOG IN ('Total','Fallido','PNR') AND CVE_DOC NOT IN (SELECT CVE_DOC FROM OC_ADUANA)";
         if($mes!='' && $anio!=''){
             $this->query.= " AND EXTRACT(MONTH FROM FECHA_DOC) = $mes AND EXTRACT(YEAR FROM FECHA_DOC) = $anio;"; 
         }
         //echo "query = ".$this->query;
         $result = $this->QueryObtieneDatosN();
         while ($tsArray = (ibase_fetch_object($result))) {
             $data[] = $tsArray;
         }
         return @$data;
     }

     function registrarOCAduana($identificador, $aduana){
         $TIME = time();
     	 $HOY = date("Y-m-d H:i:s", $TIME);
         $usuario = $_SESSION['user']->USER_LOGIN;
         $this->query = "INSERT INTO OC_ADUANA VALUES ('$identificador','A','$HOY','$usuario','$aduana')";
         $respuesta = $this->EjecutaQuerySimple();
         return $respuesta;
      }

      function traeTipoGasto(){
      	$this->query="SELECT * FROM CLA_GASTOS";
      	$rs=$this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
      	return $data;
       }

              function verFallidas(){
   	$this->query="SELECT a.*, b.NOMBRE, c.OPERADOR, d.cve_doc as Recepcion
   				  from compo01 a
   				  left join prov01 b on a.cve_clpv = b.clave
   				  left join unidades c on a.unidad = c.numero  
   				  left join compr01 d on a.doc_sig = d.cve_doc
   				  where (a.doc_sig is null or status_log = 'Fallido') AND a.FECHAELAB > '01.09.2016'";
   	$result=$this->QueryObtieneDatosN();
   	while ($tsArray=ibase_fetch_object($result)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

    function fallarOC($doco){
   		$usuario=$_SESSION['user']->USER_LOGIN;

   		$this->query="SELECT MAX(FOLIO_FALSO) as fs from COMPO01 WHERE DOC_SIG STARTING WITH ('F')";
   		$rs=$this->EjecutaQuerySimple();
   		$row=ibase_fetch_object($rs);
   		$f=$row->FS;
   		$folio= $f +1;

   		$this->query ="UPDATE COMPO01 SET DOC_SIG = ('F'||$folio), FOLIO_FALSO=$folio, usuario_recibe= '$usuario', status_log = 'fallido' where cve_doc = '$doco'";
   		$rs=$this->EjecutaQuerySimple();
   		
   		$this->query="UPDATE PAR_COMPO01 SET STATUS_LOG2 = 'R' WHERE CVE_DOC = '$doco' and status_log2 = 'Suministros'";
   		$rs=$this->EjecutaQuerySimple();

   		return $rs;
   }


   function impFallido($doco){
   	$this->query="SELECT c.*, p.nombre
   				from compo01 c
   				left join prov01 p on p.clave = c.cve_clpv
   				where cve_doc ='$doco'";
   		$rs=$this->EjecutaQuerySimple();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function impFallidoPar($doco){
   	$this->query="SELECT c.*, i.descr
   				from par_compo01 c
   				left join inve01 i on c.cve_art = i.cve_art 
   				where cve_doc ='$doco'";
   		$rs=$this->EjecutaQuerySimple();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function verSaldoFacturas($cveclie){
   	$this->query="SELECT f.*, c.*, cl.RFC
   				FROM factf01 f
   				left join clie01 cl on cl.clave =  f.cve_clpv
   				LEFT JOIN cajas c on f.cve_doc = c.factura 
   				where trim(f.cve_clpv)=trim('$cveclie') and f.saldo > 0 ";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function verPagos2($clie, $docf, $rfc){
   	$this->query="SELECT * from carga_pagos where (cliente is null or trim(rfc)=trim('$rfc')) and saldo > 0";
   	//var_dump($this);
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function treaSaldoFacturas($docf, $clie){
   	$this->query="SELECT f.*, c.* , cl.nombre as cliente, cl.RFC as rfc
   				FROM factf01 f
   				LEFT JOIN cajas c on f.cve_doc = c.factura 
   				left join clie01 cl on cl.clave= f.cve_clpv
   				where trim(f.cve_clpv)=trim('$clie') and f.cve_doc='$docf'";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function aplicarPagoxFactura($docf, $idpago, $monto, $saldof, $clie, $rfc){
   		$usuario=$_SESSION['user']->USER_LOGIN;
   		if($monto > $saldof){
   			$saldodoc = 0;
   			$pago = $saldof;
   			$saldopago=$monto - $saldof;
   		}else{
   			$saldodoc = $saldof - $monto;
   			$pago = $monto;
   			$saldopago=0;
   		}
   		$this->query="UPDATE FACTF01 SET SALDO=$saldodoc, pagos=(pagos+$pago) where CVE_DOC ='$docf'";
   		$rs=$this->EjecutaQuerySimple();
   		
   		$this->query="UPDATE CARGA_PAGOS SET SALDO=$saldopago, cliente = $clie where ID=$idpago";
   		$rs=$this->EjecutaQuerySimple();
   	
   		$this->query="INSERT INTO APLICACIONES (FECHA, IDPAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, RFC)
   					  VALUES (current_timestamp, $idpago, '$docf', $pago, $saldodoc, $saldopago, '$usuario', '$rfc')";
   		$rs=$this->EjecutaQuerySimple();

   		$this->query="SELECT SALDO FROM FACTF01 WHERE CVE_DOC ='$docf'";
   		$rs=$this->QueryObtieneDatosN();
   		$row=ibase_fetch_object($rs);
   		$data=$row->SALDO;
 
   		return $data;
   }

   function verFacturas2($clie,$id){
   	$this->query="SELECT * FROM FACTF01 WHERE SALDO > 0 AND trim(CVE_CLPV)=trim('$clie') and status != 'C'";
   	//var_dump($this);
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function verPagoaAplicar($clie,$id){
   	$this->query="SELECT * FROM CARGA_PAGOS WHERE ID = $id";
   	//var_dump($this);
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

  function aplicaPagoFactura($clie, $id, $docf, $monto, $saldof, $rfc, $tipo){
   	$usuario=$_SESSION['user']->USER_LOGIN;
   	// calculo de aplicacion.
	   	if($monto >= $saldof){
	   		//echo 'El monto: '.$monto.' es mayor al saldo del documento: '.$saldof;
	   		$saldoD = 0; // Saldo Documento
	   		$saldoP = $monto - $saldof;
	   		$aplicar = $saldof;
	   	}elseif($saldof > $monto){
	   		//echo 'El monto: '.$monto.' es menor al saldo del documento: '.$saldof;
	   		$saldoP = 0;
	   		$saldoD = $saldof - $monto;
	   		$aplicar = $monto;
	   	}
	   		if($monto == 0){
		   		echo 'Ya no hay saldo para aplicar a esta factura... Favor de revisar los datos.';
		   		return $monto;
			}

	   		$this->query="SELECT extract(month from fechaelab) as mes, extract(year from fechaelab) as anio, cve_maestro as maestro from factf01 where cve_doc = '$docf'";
	   		$result=$this->QueryObtieneDatosN();
	   		$row=ibase_fetch_object($result);
	   		$mes =$row->MES;
	   		$anio = $row->ANIO;
	   		$maestro = $row->MAESTRO;
	   		$campo='SALDO_'.$anio;

				   	if(substr($id, 0,1) == 'N'){
				   		$this->query="INSERT INTO APLICACIONES (FECHA, FORMA_PAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, RFC)
				   						VALUES (current_timestamp, '$id', '$docf', $aplicar, $saldoD, $saldoP, '$usuario', '$rfc')";
				    	$rs=$this->EjecutaQuerySimple();

				   	}elseif (substr($id, 0,1) == 'A') {
				   		$idac = substr($id, 2,6);
				   		$this->query = "SELECT ID FROM CARGA_PAGOS WHERE FOLIO_ACREEDOR = $idac";
				   		$rs=$this->QueryObtieneDatosN();
				   		$row=ibase_fetch_object($rs);
				   		$idpag= $row->ID;
				   		$this->query="INSERT INTO APLICACIONES (FECHA, IDPAGO, FORMA_PAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, RFC)
				   						VALUES (current_timestamp, $idpag, '$id', '$docf', $aplicar, $saldoD, $saldoP, '$usuario', '$rfc')";
				    	$rs=$this->EjecutaQuerySimple();

		   			}else{
				   		$this->query="INSERT INTO APLICACIONES (FECHA, IDPAGO, DOCUMENTO, MONTO_APLICADO, SALDO_DOC, SALDO_PAGO, USUARIO, RFC, FORMA_PAGO)
				   						VALUES (current_timestamp, $id, '$docf', $aplicar, $saldoD, $saldoP, '$usuario', '$rfc', '$tipo')";
				    	$rs=$this->EjecutaQuerySimple();   		
		   			}
		    		//echo $tipo;
		    $this->query ="SELECT max(id) as ida from aplicaciones";
		    $rs=$this->QueryObtieneDatosN();
		    $row=ibase_fetch_object($rs);
		    $ida = $row->IDA;

		    $this->query = "SELECT idpago from aplicaciones where id = $ida";
		    $rs = $this->QueryObtieneDatosN();
		    $row=ibase_fetch_object($rs);
		    $idp =$row->IDPAGO;
		    
				    if($rs and substr($id, 0,1) == 'N'){    	
				    	echo 'Actualizando Saldos ';
				    	$this->query="UPDATE FACTF01 SET SALDOFINAL = $saldoD, PAGOS = (PAGOS + $aplicar) WHERE CVE_DOC = '$docf'";
				   		$rs=$this->EjecutaQuerySimple();

				   		$this->query="UPDATE FACTD01 SET SALDO = $saldoP where CVE_DOC = '$id'";
				   		$rs=$this->EjecutaQuerySimple();
				   		
				   		$this->query="SELECT SALDO FROM FACTD01 WHERE CVE_DOC = '$id'";
				  		$rs=$this->EjecutaQuerySimple();
				  		
				  		$row=ibase_fetch_object($rs);
				  		$rs=$row->SALDO;

					}elseif ($rs and substr($id, 0, 1) == 'A' ){
							echo 'Actualizando Saldos ';
							$idac = substr($id, 2,5);

					    	$this->query="UPDATE FACTF01 SET SALDOFINAL = $saldoD, PAGOS = (PAGOS + $aplicar), aplicado = (aplicado + $aplicar), id_aplicaciones = iif(id_aplicaciones='', $ida,(id_aplicaciones ||' , ' ||$ida)), id_pagos= iif(id_pagos = '', $idp, (id_pagos ||' , '||$idp) )  WHERE CVE_DOC = '$docf'";
					   		$rs=$this->EjecutaQuerySimple();
					   		echo $this->query;
					   		$this->query="UPDATE ACREEDORES SET SALDO = $saldoP where id = CAST(SUBSTRING('$id' FROM 3 FOR 6) AS iNT)";
					   		$rs=$this->EjecutaQuerySimple();

					  		$this->query="UPDATE MAESTROS SET ACREEDOR = ACREEDOR - $aplicar where clave = '$maestro'";
					  		$res=$this->EjecutaQuerySimple();


					   		$this->query="SELECT SALDO FROM ACREEDORES WHERE ID = CAST(SUBSTRING('$id' FROM 3 FOR 6) AS iNT)";
					  		$rs=$this->EjecutaQuerySimple();
					  		$row=ibase_fetch_object($rs);
					  		$rs=$row->SALDO;

				    }elseif($rs){


					   		$this->query="UPDATE FACTF01 SET SALDOFINAL = $saldoD, PAGOS = (PAGOS + $aplicar), aplicado =(aplicado + $aplicar), id_aplicaciones = iif(id_aplicaciones is null, $ida,(id_aplicaciones ||' , ' ||$ida)), id_pagos= iif(id_pagos is null, $idp, (id_pagos ||' , '||$idp) ) WHERE CVE_DOC = '$docf'";
					   		$rs=$this->EjecutaQuerySimple();

						   		if($rs){
						   			$this->query="UPDATE APLICACIONES SET PROCESADO = PROCESADO + 1 WHERE ID = $ida";
						   			$rs=$this->EjecutaQuerySimple();
			   					}

							$this->query="UPDATE CARGA_PAGOS SET SALDO = $saldoP, aplicaciones = iif(aplicaciones is null, 0, aplicaciones) + $aplicar  where ID = $id";
					   		$rs=$this->EjecutaQuerySimple();

					   		$this->query="SELECT SALDO FROM CARGA_PAGOS WHERE ID = $id";
					  		$rs=$this->EjecutaQuerySimple();
					  		$row=ibase_fetch_object($rs);
					  		$rs=$row->SALDO;
				  	}

			$this->query = "UPDATE MAESTROS SET $campo = $campo - $aplicar where clave = '$maestro'";
	   		$rs=$this->EjecutaQuerySimple();
		    //echo $this->query;

	   		$this->query="SELECT MAX(FOLIO) AS FOLIO FROM PAR_RUTA_COBRANZA WHERE DOCUMENTO = '$docf'";
	   		$result=$this->QueryObtieneDatosN();
	   		$row=ibase_fetch_object($result);
	   		
			   		if(isset($row)){
		   			$folioR= $row->FOLIO;
		   			$this->query="UPDATE FOLIOS_RUTA_COBRANZA SET VALOR_CUMPLIDO = VALOR_CUMPLIDO + $aplicar where FOLIO = $folioR";
		   			$rs=$this->EjecutaQuerySimple();
		   			echo $this->query;
		   			}


		/// Analizamos la situacion del cliente
		   	$this->query="SELECT * FROM CLIE01 WHERE trim(CLAVE) = trim('$clie')";
			echo 'Traemos al cliente'.$this->query.'<p>';

 			$res4=$this->EjecutaQuerySimple();
			$row4 = ibase_fetch_object($res4);
		
		if(!empty($row4->STATUS_COBRANZA)){
		    echo 'El cliente esta suspendido'.'<p>';
			$this->query="SELECT min(datediff(day from current_date to fecha_vencimiento)) as dias, COUNT(CVE_DOC) AS DOCS 
								from factf01
							    where trim(cve_clpv) = trim('$row4->CLAVE')
						        and status_fact = 'Cobranza'
						        and extract(year from fecha_doc) >= 2016
						        and saldofinal >= 5 ";
				$rs5 = $this->EjecutaQuerySimple();
				$row5 = ibase_fetch_object($rs5);

			echo 'Traemos los documentos : '.$this->query.'<p>';

			if ($row5->DIAS > -7 or $row5->DOCS == 0){
				echo 'Ya no tiene documentos';
			$this->query="UPDATE CLIE01 SET STATUS_COBRANZA = NULL, inicio_corte = null, finaliza_corte= null, monto_cobranza= 0 , saldo_monto_cobranza = 0 where trim(clave) =trim('$row4->CLAVE')";
			$rs6=$this->EjecutaQuerySimple();
			echo 'Libera el Cliente'.$this->query.'<p>';
			}
		}

 	return $rs;
   }


   function crImpreso($tipo, $identificador){
   	$this->query="UPDATE P_CREDITO SET STATUS = 'A', fecha_aceptacion = current_timestamp WHERE ID = $identificador";
   	$rs=$this->EjecutaQuerySimple();
   	return $rs;
   }

   function traeProv(){
   	$this->query="SELECT * FROM PROV01";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function guardaCompra($fact, $prov, $monto, $ref, $tipopago, $fechadoc, $fechaedocta, $banco, $tipo, $idg){
   		if($banco !=''){
				$cuenta=split('-',$banco);
			}
		$bank=trim($cuenta[0]);
		$cuenta=trim($cuenta[1]);

		$usuario = $_SESSION['user']->NOMBRE;

   		$this->query="INSERT INTO CR_DIRECTO( FACTURA, FECHA_FACTURA, FECHA_MOV, PROVEEDOR, IMPORTE, FECHA_EDO_CTA, TP_TES, REFERENCIA, BANCO, CUENTA, TIPO, idgasto, usuario)
   							VALUES ('$fact', '$fechadoc', current_timestamp, '$prov', $monto, '$fechaedocta', '$tipopago', '$ref', '$bank', '$cuenta', '$tipo', $idg, '$usuario')";
   		//echo $this->query;
   		//break;
   		$rs=$this->EjecutaQuerySimple();
   		//echo'Esta es la consulta: '.var_dump($this);
/*
   		if($rs){
   			echo 'Esto se ejecuta si se insterta : ';
   			$campo='MOVR'.substr($fechaedocta, 3,2);
			$campoA='MOVS'.substr($fechaedocta, 3,2);
			$camposf='SALDOF'.substr($fechaedocta, 3,2);
			
		$this->query="UPDATE PG_BANCOS SET $campo = iif($campo is null,0,$campo) + iif($monto IS NULL,0,$monto) where NUM_CUENTA=trim('$cuenta') ";
		$rs=$this->EjecutaQuerySimple();
		//echo 'Este es el update de Saldo:'.var_dump($this);
		

		$this->query="UPDATE PG_BANCOS SET $camposf= ($camposf - iif($monto IS NULL,0,$monto))
	    where num_cuenta = trim('$cuenta')";
		$rs=$this->EjecutaQuerySimple();
		//echo 'Este es el update de Saldo Final: '.var_dump($this);

		$this->query="UPDATE PG_BANCOS SET SALDO = (SALDOF01 + SALDOF02 + SALDOF03 + SALDOF04 + SALDOF05 + SALDOF07 + SALDOF08 + SALDOF09 + SALDOF10 + SALDOF11 + SALDOF12 + SALDOI)";

		//echo 'Este es el update del saldo: '.var_dump($this);
		$rs=$this->EjecutaQuerySimple();
   		}
*/

   		return $rs;
   }

   function verAplicaciones(){

   		$this->query="SELECT a.*,f.cve_clpv as clave,  c.nombre as cliente, f.importe
   						FROM APLICACIONES a
   						left join factf01 f on a.documento = f.cve_doc
   						left join clie01 c on f.cve_clpv = c.clave
   						where a.status = 'E'";
   		$rs=$this->QueryObtieneDatosN();
   		while ($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}

   		return @$data;
   }

   function impAplicacion($ida){
    $this->query="UPDATE APLICACIONES SET STATUS = 'I' WHERE ID = $ida";
    $rs=$this->EjecutaQuerySimple();


   	$this->query="SELECT a.*,f.cve_clpv as clave,  c.nombre as cliente, f.importe
   						FROM APLICACIONES a
   						left join factf01 f on a.documento = f.cve_doc
   						left join clie01 c on f.cve_clpv = c.clave
   						where  ID = $ida";
   	$rs=$this->QueryObtieneDatosN();
   	while ($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return @$data;
   }

 	function verPagosActivos($monto){
 	/*	
   	$this->query="SELECT * FROM CARGA_PAGOS c WHERE SALDO > 2 and monto containing('$monto') and tipo_pago is null and status <> 'C'";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}

   	$this->query="SELECT ('A-'||id) as id, 
   		(SELECT cp.FOLIO_X_BANCO FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as FOLIO_X_BANCO, 
   		'N/A' as CLIENTE,
   		(SELECT cp.FECHA_RECEP FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as FECHA_RECEP, 
   		MONTO,
   		SALDO,
   		'' AS RFC,
   		(SELECT cp.BANCO FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as BANCO 
   		FROM ACREEDORES a WHERE SALDO > 2 and monto containing('$monto') and status = 0";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}

	*/

	$this->query="SELECT * FROM CARGA_PAGOS c WHERE  monto containing('$monto') and tipo_pago is null and status <> 'C'";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}

	$this->query="SELECT ('A-'||id) as id, 
   		(SELECT cp.FOLIO_X_BANCO FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as FOLIO_X_BANCO, 
   		'N/A' as CLIENTE,
   		(SELECT cp.FECHA_RECEP FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as FECHA_RECEP, 
   		MONTO,
   		SALDO,
   		'' AS RFC,
   		(SELECT cp.BANCO FROM CARGA_PAGOS cp WHERE a.id_pago = cp.ID) as BANCO 
   		FROM ACREEDORES a WHERE monto containing('$monto') and status = 0";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}

   	/*
    $this->query="SELECT cve_doc as ID,'N/A' as FOLIO_X_BANCO, CVE_CLPV as cliente, fechaelab as FECHA_RECEP, importe as Monto, 'N/A' as BANCO, RFC as RFC, saldo FROM FACTD01 WHERE SALDO > 2 AND (cve_doc containing('$monto') or importe containing('$monto'))";
   	$rs=$this->QueryObtieneDatosN();
   	//echo $this->query;
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	*/
   	return @$data;
   }


    function verPagoActivo($idp, $tipo){
    
    	if(substr($tipo, 0,1)=='A'){
    		$idp = $tipo;
    	}

    if(substr($idp, 0,2) == 'NR'){
   		$this->query="SELECT cve_doc as ID, CVE_CLPV as cliente, fechaelab as FECHA_RECEP, importe as Monto, 'N/A' as BANCO, RFC as RFC, saldo FROM FACTD01 WHERE SALDO > 0 AND cve_doc = '$idp'";
   		$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   		}
   	}elseif(substr($idp, 0,1)== 'A'){
   		$idp = substr($idp, 2,5);
   		$this->query="SELECT ('A-'||id) as id, 
   		(SELECT cp.FOLIO_X_BANCO FROM CARGA_PAGOS cp WHERE cp.id = $idp) as FOLIO_X_BANCO, 
   		'N/A' as CLIENTE,
   		(SELECT cp.FECHA_RECEP FROM CARGA_PAGOS cp WHERE cp.id = $idp) as FECHA_RECEP, 
   		MONTO,
   		SALDO,
   		'' AS RFC,
   		(SELECT cp.BANCO FROM CARGA_PAGOS cp WHERE cp.id = $idp) as BANCO 
   		FROM ACREEDORES a WHERE id = $idp";
   		
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   	}else{
   		$this->query="SELECT * FROM CARGA_PAGOS WHERE ID=$idp";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   	}
   		return $data;
   }

   function listaFacturas(){
   		$this->query="SELECT f.*--, c.NOMBRE 
   					FROM FACTF01 f
   					--inner join clie01 c on f.cve_clpv=c.clave  
   					WHERE f.SALDO > 2
   					and f.status != 'C'
   					and f.fechaelab > '10.10.2015' 
   					and f.fechaelab <= '01.02.2016'
   					";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   		return @$data;
   	}

   	function IdvsComp(){
   		$this->query="SELECT p.id, p.cotiza,pe.cve_pedi, p.prod, p.nomprod, pr.nombre, pr.clave, poc.cost, p.cant_orig, oc.fecha_doc, pv.prec
 ,(((iif(pv.prec=0,1,pv.prec)/iif(poc.cost=0, 1, poc.cost))-1)*100) as utilidad
        from preoc01 p
        inner join par_compo01 poc on p.id = poc.id_preoc
        inner join compo01 oc on oc.cve_doc = poc.cve_doc
        inner join prov01 pr on pr.clave = oc.cve_clpv
        inner join par_factp01 pv on pv.id_preoc = p.id
        inner join factp01 pe on pe.cve_doc = pv.cve_doc
        where p.NOM_CLI containing ('LIVERPOOL')
        ORDER BY P.PROD ASC";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}

   		return $data;
   	}

   	function listaFacturasOK($docf){
   		$this->query="SELECT f.*, c.NOMBRE 
   					FROM FACTF01 f
   					left join clie01 c on f.cve_clpv=c.clave  
   					WHERE f.SALDOFINAL > 2
   					and cve_doc = '$docf'";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   		return @$data;
   	}

   	function traeValidacion($doco){
   		$this->query="SELECT * FROM VALIDA_RECEPCION WHERE DOCUMENTO ='$doco'";
   		$rs=$this->QueryObtieneDatosN($doco);
   		while ($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}

   		return $data;
   	}

   	function verAplivsFact(){
   		$this->query="SELECT * FROM carga_pagos WHERE saldo <> monto and (status is null or status = '')";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   		return @$data;
   	}

  	function infoPago($idp){
  		$this->query="SELECT * FROM carga_pagos where id = $idp";
  		$rs = $this->QueryObtieneDatosN();
  		while($tsArray=ibase_fetch_object($rs)){
  			$data[]=$tsArray;
  		}
  		return @$data;
	}  	

	function movimientosPago($idp){
		$this->query="SELECT a.*, f.*, c.* 
					from aplicaciones a
					left join factf01 f on f.cve_doc = a.documento
					inner join clie01 c on c.clave = f.cve_clpv
					where a.idpago = $idp and cancelado = 0";
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		$this->query="UPDATE CARGA_PAGOS SET STATUS = 'I' WHERE ID = $idp";
		$result=$this->EjecutaQuerySimple();


		return @$data;

	}

	function almacenarFolioContrarecibo($tipo, $identificador, $montor, $facturap, $recepcion){
        $TIME = time();
        $HOY = date("Y-m-d H:i:s", $TIME);
        $usuario = $_SESSION['user']->USER_LOGIN;
        $AUTOINCREMENT = "SELECT coalesce(MAX(FOLIO), 0) AS FOLIO FROM OC_CREDITO_CONTRARECIBO";
        $this->query = $AUTOINCREMENT;
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
        $folio = 1;
      	foreach($data as $row):
            $folio = $row->FOLIO+1;
        endforeach;

        if($tipo=="GASTO"){
            $id = $identificador;
        } elseif($tipo=="RECEPCION") {
            $id = "(SELECT RECEPCION FROM OC_PAGOS_CREDITO WHERE ID = '$identificador')";
        }elseif($tipo=='RECEPCION_PEGASO'){
       		$id = "(SELECT RECEPCION FROM OC_PAGOS_CREDITO_RECIBO WHERE ID = '$identificador')";  	
        }

        $this->query = "INSERT INTO OC_CREDITO_CONTRARECIBO VALUES ($folio,'$HOY','$tipo',$recepcion,'$usuario','PD');";        
        $respuesta = $this->EjecutaQuerySimple();
        //echo 'Valor de respuesta:'.$respuesta.'<p>';
        
        if($tipo =='RECEPCION'){
        	$this->query= "UPDATE COMPR01 SET MONTO_REAL = $montor, FACT_PROV = '$facturap' where TRIM(CVE_DOC) = TRIM('$identificador')";	
        }elseif($tipo =='RECEPCION_PEGASO'){
        	$this->query= "UPDATE  ftc_detalle_recepciones SET MONTO_REAL = $montor, FACT_PROV = '$facturap' where TRIM(orden) = TRIM('$identificador') and id_recepcion = $recepcion";
        }

        //echo $this->query;
        //break;

        $rs=$this->EjecutaQuerySimple();
        return $respuesta>=1?$folio:-1;
    }


    function actualizarFolioContrarecibo($folio){
        $this->query = "UPDATE OC_CREDITO_CONTRARECIBO SET STATUS = 'IM' WHERE FOLIO = $folio";
        $respuesta = $this->EjecutaQuerySimple();
        return $respuesta;
    }
 
    function listarOCContrarecibos(){
        $data = array();
        $this->query = "SELECT A.FOLIO, A.FECHA_IMPRESION, B.PROMESA_PAGO, A.TIPO, A.IDENTIFICADOR, A.USUARIO, B.RECEPCION, B.OC, B.FACTURA, B.MONTOR, B.BENEFICIARIO 
                          FROM OC_CREDITO_CONTRARECIBO A 
                          INNER JOIN OC_PAGOS_CREDITO B ON TRIM(A.IDENTIFICADOR) = TRIM(B.RECEPCION)
                          INNER JOIN COMPR01 C ON A.IDENTIFICADOR = C.CVE_DOC
                         WHERE A.STATUS = 'IM' AND (C.STATUS_PAGO <> 'PP' or C.STATUS_PAGO IS NULL)
                         ORDER BY B.BENEFICIARIO ASC";
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}

      	$this->query="SELECT A.FOLIO, A.FECHA_IMPRESION, B.PROMESA_PAGO, A.TIPO, A.IDENTIFICADOR, A.USUARIO, B.RECEPCION, B.OC, B.FACTURA, B.MONTOR, B.BENEFICIARIO 
                          FROM OC_CREDITO_CONTRARECIBO A 
                          INNER JOIN OC_PAGOS_CREDITO_RECIBO B ON TRIM(A.IDENTIFICADOR) = TRIM(B.RECEPCION)
                          where A.STATUS = 'IM' AND 
                          B.STATUS_PAGO is null
                          ORDER BY B.BENEFICIARIO ASC";
                          //echo 'Lista de OC Contrarecibos: '.$this->query;
 		$rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}

        return $data;
    }

     function pagarOCContrarecibos($folios){
		$data = array();
        
        $this->query = "SELECT A.FOLIO, A.FECHA_IMPRESION, B.PROMESA_PAGO, A.TIPO, B.RECEPCION, B.OC, B.FACTURA , B.MONTOR, B.BENEFICIARIO 
                          FROM OC_CREDITO_CONTRARECIBO A INNER JOIN OC_PAGOS_CREDITO B ON A.IDENTIFICADOR = B.RECEPCION 
                         WHERE STATUS = 'IM' AND A.FOLIO IN ($folios)
                         ORDER BY B.PROMESA_PAGO;";
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}


        $this->query = "SELECT A.FOLIO, A.FECHA_IMPRESION, B.PROMESA_PAGO, A.TIPO, B.RECEPCION, B.OC, B.FACTURA , B.MONTOR, B.BENEFICIARIO 
                          FROM OC_CREDITO_CONTRARECIBO A INNER JOIN OC_PAGOS_CREDITO_RECIBO B ON A.IDENTIFICADOR = B.RECEPCION 
                         WHERE STATUS = 'IM' AND A.FOLIO IN ($folios)
                         ORDER BY B.PROMESA_PAGO;";
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}

        return $data;
    }
    
    
    function encontrarInformacionFolioOCC($folio){
        $this->query = "SELECT A.FOLIO, A.IDENTIFICADOR, B.FECHA_DOC, B.RECEPCION , B.BENEFICIARIO, B.MONTO
    					FROM OC_CREDITO_CONTRARECIBO A
    					INNER JOIN OC_PAGOS_CREDITO B ON A.IDENTIFICADOR = B.RECEPCION
    					WHERE A.FOLIO = $folio";
                        //echo $this->query;
        $rs = $this->QueryObtieneDatosN();
        $data = array();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
        return $data;        
    }
    
 	function registrarPagoCreditoOC($monto, $cuentaBanco, $medio){
        $AUTOINCREMENT = "SELECT coalesce(MAX(IDENTIFICADOR), 0) AS IDENTIFICADOR FROM PAGO_CREDITOS_OC;";
        $this->query = $AUTOINCREMENT;
        $rs = $this->QueryObtieneDatosN();
      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
        $identificador = 1;
      	foreach($data as $row):
            $identificador = $row->IDENTIFICADOR+1;
        endforeach;
        //echo "El identificador dado es: $identificador";
        $TIME = time();
        $HOY = date("Y-m-d H:i:s", $TIME);
        $usuario = $_SESSION['user']->USER_LOGIN;
        $this->query = "INSERT INTO PAGO_CREDITOS_OC (IDENTIFICADOR,FECHA_PAGO,CUENTA_BANCO,MEDIO_PAGO,MONTO_PAGO,USUARIO,STATUS)";
        $this->query.= "VALUES";
        $this->query.= "($identificador, '$HOY', '$cuentaBanco', '$medio', $monto, '$usuario', 'PD')";
        //echo $this->query;
        //echo "SQL PAGO_CREDITO_OC: ".$this->query;
        $respuesta = $this->EjecutaQuerySimple();
        if($respuesta>0){
            return $identificador;
        } else {
            return $respuesta;
        }
    }
    
    function actualizarPagoCreditoOCAplicado($identificador){
        $this->query = "UPDATE PAGO_CREDITOS_OC SET STATUS = 'AP' WHERE IDENTIFICADOR = $identificador";
        $respuesta = $this->EjecutaQuerySimple();
        return $respuesta>0;
    }
    
    function pagarOCContrarecibosAplicar($identificador, $folio, $cuentaBancaria, $documento, $medio, $monto, $proveedor, $claveProveedor, $fechaDocumento){        
        //echo "por ir a GuardaPagoCorrecto";
        $respuesta = $this->GuardaPagoCorrecto($cuentaBancaria, $documento, $medio, $monto, $proveedor, $claveProveedor, $fechaDocumento);
        //echo "respuesta al registro de pago: $respuesta";
        if($respuesta >0){
            $this->query = "INSERT INTO PAGO_CREDITOS_OC_DETALLE (IDENTIFICADOR, FOLIO, DOCUMENTO, MONTO_PAGO, FECHA_DOCUMENTO, CLV_PROV)";
            $this->query.= "VALUES";
            $this->query.= "($identificador, $folio, '$documento',$monto,'$fechaDocumento','$claveProveedor');";
            //echo "sql: ".$this->query;
            $respuesta = $this->EjecutaQuerySimple();            
            return $respuesta;
        }
        return 0;
    }

    function IngresarBodega($desc, $cant, $marca, $proveedor, $costo, $unidad){
    	$desc = split(":", $desc);
    	$prod = trim($desc[0]);
    	$descripcion = $desc[1];
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="INSERT INTO INGRESOBODEGA (PRODUCTO, DESCRIPCION, CANT, FECHA, MARCA, Proveedor, Costo, unidad, restante, usuario, origen) 
    	VALUES ('$prod',(select nombre from producto_ftc where clave = '$prod'), $cant, current_timestamp, '$marca', '$proveedor', (select costo_ventas from producto_ftc where clave = '$prod'), '$unidad', $cant,'$usuario', 'Directo')";
    	$rs =  $this->EjecutaQuerySimple();
    	
    	$this->query="SELECT MAX(ID) AS FOLIO FROM INGRESOBODEGA";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$folio=$row->FOLIO;
    	return $folio;
    }


   function asignar($idp, $asignado, $idingreso){
    	//sph150766
    	$usuario = $_SESSION['user']->NOMBRE;

    	if(substr($idingreso,0,3) =='PGS' ){
    		$this->query="SELECT ID, RESTANTE FROM INGRESOBODEGA WHERE PRODUCTO = '$idingreso' and restante > 0 ";
    		$result=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($result)) {
    			$lineas[]=$tsArray;
    		}
    		// Revisamos cuantas lineas tiene el resultado:
    		if(count($lineas)==1){  /// Si solo hay una linea obtenemos ese restante.
    			foreach ($lineas as $key) {
	    			$res = $key->RESTANTE;
	    			$idingreso = $key->ID; 
    			}
    		}else{ /// En caso se que haya 2 o mas lineas.
    			foreach ($lineas as $key){
    				$this->query="SELECT RESTANTE FROM INGRESOBODEGA WHERE ID = $key->ID";
    				$rs=$this->EjecutaQuerySimple();
    				$row=ibase_fetch_object($rs);
    				$res = $row->RESTANTE;

	    				if (($res-$asignado)< 0){   /// SI REQUERIMOS MAS DE LO QUE HAY EN LA LINEA 1 ENTONCES OBTENEMOS LO QUE TIENE LA LINEA 1 Y LA DEJAMOS EN 0.
	    					$this->query="UPDATE INGRESOBODEGA SET restante= 0, asignado = iif(asignado is null,0 + $res, asignado + $res) where id =$key->ID";
				    		$this->grabaBD();
				    		$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, PREOC, COTIZA, status )
				    			values(NULL, $key->ID, $res, $res, 0, current_timestamp, '$usuario', $idp, (SELECT COTIZA FROM PREOC01 WHERE ID = $idp), 0)";
				    		$this->grabaBD();

				    		$this->query="UPDATE PREOC01 SET ORDENADO = iif(ORDENADO is null, 0 + $res, ordenado + $res), ASIGNADO = iif(ASIGNADO is null, 0+$res, asignado + $res), rest = (rest - $asignado), recepcion = recepcion + $asignado    where id = $idp";
				    		$this->grabaBD();

				    		$response = array("status"=>"ok","tipo"=>"multiple","res"=>$res,"asignado"=>$res);
				    		$asignado = $asignado - $res; 
				    	}else{
				    		$this->query="UPDATE INGRESOBODEGA SET restante= $res-$asignado, asignado = iif(asignado is null,0 + $asignado, asignado + $asignado) where id =$key->ID";
				    		$this->grabaBD();

				    		$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, PREOC, COTIZA, status )
				    			values(NULL, $key->ID, $res, $asignado, $res-$asignado, current_timestamp, '$usuario', $idp, (SELECT COTIZA FROM PREOC01 WHERE ID = $idp), 0)";
				    		$this->grabaBD();
				    		

				    		$this->query="UPDATE PREOC01 SET ORDENADO = iif(ORDENADO is null, 0 + $asignado, ordenado + $asignado), ASIGNADO = iif(ASIGNADO is null, 0+$asignado, asignado + $asignado), rest = (rest - $asignado)  where id = $idp";
				    		$this->grabaBD();

				    		$response=array("status"=>"ok", "tipo"=>"Ingreso");
				    	} 
    			}

				return $response;
    		}

    	}else{

    		$this->query="SELECT RESTANTE FROM INGRESOBODEGA WHERE ID = $idingreso";
    		$rs=$this->EjecutaQuerySimple();
    		$row=ibase_fetch_object($rs);
    		$res = $row->RESTANTE;	
    	}
    	

    	if (($res-$asignado)< 0){
    		$response = array("status"=>"error","tipo"=>"diferencia","res"=>$res,"asignado"=>$asignado);
    		return $response;
    	}else{
    		$this->query="UPDATE INGRESOBODEGA SET restante= $res-$asignado, asignado = iif(asignado is null,0 + $asignado, asignado + $asignado) where id =$idingreso";
    		$this->grabaBD();

    		$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, PREOC, COTIZA, status )
    			values(NULL, $idingreso, $res, $asignado, $res-$asignado, current_timestamp, '$usuario', $idp, (SELECT COTIZA FROM PREOC01 WHERE ID = $idp), 0)";
    		$this->grabaBD();

    		$this->query="UPDATE PREOC01 SET ORDENADO = iif(ORDENADO is null, 0 + $asignado, ordenado + $asignado), ASIGNADO = iif(ASIGNADO is null, 0+$asignado, asignado + $asignado), rec_faltante = rec_faltante - $asignado , rest = (rest - $asignado) where id = $idp";
    		$this->grabaBD();

    		$response=array("status"=>"ok", "tipo"=>"Ingreso");
    		return $response;
    	}
    }

    function asignacionBodega(){
    	$this->query="SELECT * FROM ASIGNACION_BODEGA_PREOC A LEFT JOIN INGRESOBODEGA I ON I.ID = A.IDINGRESO where A.status = 0";
    	$rs=$this->EjecutaQuerySimple();
	    	while ($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}
    	return @$data;
    }

    function revisarNuevoIngreso($desc){
    	$desc = split(":", $desc);
    	$prod = trim($desc[0]);
    	$descripcion = $desc[1];
    	$this->query="SELECT * FROM PREOC01 WHERE PROD = '$prod' and rest >= 1 and STATUS = 'N' and rec_faltante >= 1";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function editIngresoBodega($idi, $costo, $proveedor, $cant, $unidad){
    	$this->query="UPDATE INGRESOBODEGA SET PROVEEDOR = '$proveedor', costo = $costo, cant = $cant, unidad = '$unidad' where id = $idi";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }
    
    function verIngresoBodega(){
    	$this->query="SELECT producto, sum(restante) as cant,
    					max(costo) as costo, max(descripcion) as descripcion, max(unidad) as unidad, max(fecha) as fecha, max(proveedor) as proveedor 
    					FROM INGRESOBODEGA 
    					where restante > 0 
    					group by producto ";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function salidaAlmacen ($producto, $cantidad){
    	$this->query="SELECT sum(restante) as cant, producto , max(descripcion) as descripcion, max(costo ) as costo 
    	FROM INGRESOBODEGA WHERE producto = '$producto' group by producto";
    	$rs=$this->EjecutaQuerySimple();
    	//echo $this->query;
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}

    	return $data;
    }


    function pendientePorRecibir($producto){
    	$data=array();
    	$this->query="SELECT * FROM PREOC01 WHERE PROD = '$producto' and rec_faltante  >= 1 and ordenado < cant_orig and (status = 'N' or status = 'B') and fechasol >= '01.12.2017' ";
    	$rs=$this->EjecutaQuerySimple();
    	//echo $this->query;
    	while ($tsArray=ibase_fetch_object($rs)) {
    	 	$data[]=$tsArray;
    	 } 

    	 return $data;
    }


    function asignarProductoAlmacen($producto, $cotizacion, $cantidad, $cantidadAlmacen, $id){

    	$usuario = $_SESSION['user']->NOMBRE;

    	$this->query="UPDATE PREOC01 SET status= iif(rest - $cantidad <= 0, 'B', 'N'),  rest = rest - $cantidad,  RECEPCION = RECEPCION + $cantidad, REC_FALTANTE = REC_FALTANTE - $cantidad where cotiza = '$cotizacion' and prod ='$producto' ";
    	$this->EjecutaQuerySimple();
    	
    	$this->query="UPDATE INGRESOBODEGA SET CANT = CANT - $cantidad where id = $id";
    	$this->EjecutaQuerySimple();
    	
    	$this->query="INSERT INTO SALIDASBODEGA (ID, IDINGRESO, COTIZACION, CANTIDAD, FECHA , USUARIO, TIPO) VALUES (NULL, $id, '$cotizacion', $cantidad, current_timestamp, '$usuario', 'Salida') ";
    	$this->EjecutaQuerySimple();
    	
    	//break;
    	return;

    }


     function emitirCierreCR($cr){
     	switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="SELECT MAX(FOLIO_CIERRE) AS FC FROM CAJAS WHERE  upper(cr) = upper('$cr')";
    	$rs = $this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$fn=$row->FC;
    	$fn=$fn + 1;
 
        $this->query="SELECT a.id, a.aduana , a.cve_fact,a.status_log, a.Remision,
    			c.importe as ImpRem,  a.FACTURA, d.importe as ImpFac,
    			c.fechaelab as FECHAREM, d.FECHAELAB as FECHAFAC, a.cr,
    			datediff(day,a.fecha_secuencia,current_date) AS dias,
    			a.CONTRARECIBO_CR , cl.nombre as CLIENTE, a.cr as CARTERA_REV
    			FROM CAJAS a
    			left join FACTR01 c on c.cve_doc = a.remision
    			left join FACTF01 d on d.cve_doc = a.factura
    			left join factp01 p on p.cve_doc = a.cve_fact
    			left join clie01 cl on p.cve_clpv = cl.clave
    			WHERE
        			a.aduana = 'Cobranza'
    			and a.CR = '$cr'
    			and a.contrarecibo_cr is not null
    			and a.imp_cierre = 0";

    	/*"SELECT * FROM CAJAS 	
    			where upper(cr) = upper('$cr') 
    			and (fecha_rev between CAST('TODAY' AS DATE) AND CAST('TOMORROW' AS DATE))
    			and  contraRecibo_cr is not null";*/
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	foreach ($data as $key) {
    		$caja = $key->ID;
    		$this->query="UPDATE cajas set imp_cierre = 1, folio_cierre = $fn  
    			where id = $caja";
    		//echo $this->query;
    	$rs = $this->EjecutaQuerySimple();
    	}

    	//$this->query="UPDATE CAJAS SET IMP_CIERRE = 1 WHERE upper(cr) = upper('$cr') and fecha_ultimo_motivo = cast('now' as date)";
   		//echo $this->query;
    	//$rs = $this->EjecutaQuerySimple();
    	return $rs;
    }

    function nomames(){
    	return;
    }

      function docCobRecibidos(){
      	$this->query="SELECT COUNT(ID) as ID FROM CAJAS WHERE docs_cobranza = 'S' and fecha_rec_cobranza >= 'Today'";
      	$rs=$this->QueryObtieneDatosN();
      	$row=ibase_fetch_object($rs);
      	$valida = $row->ID;
      	return $valida;
      }

      function impRecCobranza(){
		############### Obtenemos el folio siguiente #################
    	$this->query = "SELECT max(folio_rec_cobranza) as FM from cajas";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$fn = $row->FM + 1;    	

      	############# Primero validamos que todos los datos vengan limpios  ##############
      	$this->query="SELECT ID, factura FROM CAJAS WHERE docs_cobranza = 'S'";
      	$rs=$this->QueryObtieneDatosN();

      		while ($tsArray=ibase_fetch_object($rs)){
      			$data[]=$tsArray;
      		}
      		$i=0;
      		//var_dump($data);
      		//break;
      		foreach ($data as $key) {
      			
      			$id = $key->ID;
      			$this->query="SELECT * FROM CAJAS WHERE ID = $id";
      			$res=$this->QueryObtieneDatosN();
      			$row=ibase_fetch_object($res);
      			$docf = $row->FACTURA;

		      		if(isset($docf)){ // Con esto solo actualizamos las cajas y facturas que existan.
		      				//// OBTENEMOS LOS DATOS DEL CLIENTE (PLAZO Y CREDITO ACTUAL) Y LOS DATOS DE LA FACTURA (CLAVE CLIENTE).
		      			$this->query = "SELECT ct.plazo as plazo, ct.idCliente as cliente FROM FACTF01 f left join cartera ct on trim(ct.idCliente) = trim(f.cve_clpv) WHERE CVE_DOC = '$docf'";
		      			$result=$this->QueryObtieneDatosN();
		      			$rowct=ibase_fetch_object($result);
		      			$plazo = $rowct->PLAZO;
		      			$cliente = $rowct->CLIENTE;
		      			if(isset($plazo)){ /// Con esto solo actualizamos lo que tenga un plazo. 
		      				$this->query="UPDATE FACTF01 SET fecha_vencimiento = DATEADD(DAY, $plazo, current_date) where cve_doc = '$docf'";
		      				$resultado=$this->EjecutaQuerySimple();
		      				//echo 'Consulta Actualiza Vencimiento: '.$this->query.'<p>';
		      				/// actualiza la caja para la impresion.
		      				$this->query="UPDATE CAJAS SET docs_cobranza = 'Si', folio_rec_cobranza = $fn, imp_rec_cobranza = 1 where id = $id";
		    				$rs=$this->EjecutaQuerySimple();	
		      			}else{
		      				$this->query="UPDATE CAJAS SET OBSERVACIONES=iif(observaciones is null or observaciones = '',', Cliente Sin Plazo', (observaciones ||', Cliente Sin Plazo') where id = $id";
		      				$rs=$this->EjecutaQuerySimple();
      					}
		      		}
		      	$info[]=array($i,$id, $docf,$cliente,$plazo);		
		      	$i=$i+1;	
      		}

    	/*
    	$this->query="UPDATE CAJAS SET docs_cobranza = 'Si', folio_rec_cobranza = $fn, imp_rec_cobranza = 1 where docs_cobranza = 'S'";
    	$rs=$this->EjecutaQuerySimple();
    	echo $this->query;
		*/
		//break;
    	return $fn;
    }

    function recepcionCobranza($folio){
    	$this->query="SELECT c.*, cl.nombre, f.fechaelab, f.importe   
    				  FROM CAJAS c 
    				  left join factf01 f on f.cve_doc = c.factura
    				  left join CLIE01 cl on cl.clave = f.cve_clpv
    				  where docs_cobranza = 'Si'
    				  and imp_rec_cobranza = 1 
    				  and folio_rec_cobranza = $folio 
    				  ";
    	$rs=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function impresionCierre(){
    	$this->query="SELECT iif(COUNT(ID) is null, 0, COUNT(ID)) as VAL FROM CAJAS WHERE docs_cobranza = 'S' and imp_rec_cobranza = 0";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$result = $row->VAL;
    	return $result;

    }

        function habilitaImpresionCierreEnt($idr){
    	$this->query="SELECT COUNT(ID) FROM CAJAS WHERE DOCS = ";

    }

    function imprimeCierreEnt($idr){
    	$this->query="SELECT iif(Max(FOLIO_CIERRE_LOGISTICA) is null, 0, max(FOLIO_CIERRE_LOGISTICA)) as FA from cajas";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$fn = $row->FA + 1 ;

    	$this->query="UPDATE CAJAS SET FOLIO_CIERRE_LOGISTICA = $fn, cierre_uni='impreso' where cierre_uni = 'ok' and FOLIO_CIERRE_LOGISTICA=0 and idu = $idr";
    	$rs=$this->EjecutaQuerySimple();
    	return $fn; 

    }

    function cierre_uni_ent($folio){
    	$this->query="SELECT c.*, cl.nombre, 
    				  iif(c.factura is null or c.factura = '', c.remision, c.factura) as Documento, 
    				  iif(c.factura is null or c.factura = '', r.importe, f.importe) as importe,
    				  iif(c.factura is null or c.factura = '', r.fechaelab, f.fechaelab) as fechaelab  
    				  From cajas c
    				  left join factp01 p on c.cve_fact = p.cve_doc
    				  left join factf01 f on c.factura = f.cve_doc
    				  left join factr01 r on c.remision = r.cve_doc
    				  left join clie01 cl on cl.clave = p.cve_clpv
    				  where FOLIO_CIERRE_LOGISTICA = $folio";
    	$rs=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]= $tsArray;
    	}
    	return @$data;
    }


        function verCierreVal(){
    	$this->query="SELECT first 100 c.*, p.nombre , o.cve_doc as OC, o.fechaelab as OC_FECHAELAB, o.importe as OC_IMPORTE, o.STATUS_REC as OC_STATUS_VAL,  o.usuario_recibe AS OC_USUARIO_VAL
    			from compr01 c 
    			left join prov01 p on c.cve_clpv = p.clave
    			left join compo01 o on o.cve_doc = c.doc_ant
    			where (c.status_rec = 'Ok' 
    			or c.status_rec = 'par') 
    			and c.Rec_Contabilidad = 'No' 
    			and c.imp_cierre = 'No'
    			and c.fechaelab >= '01.08.2016'";
    	$rs = $this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function guardaFacturaProv($docr, $factura){
    	$this->query="UPDATE COMPR01 SET FACTURA_PROV = '$factura' where cve_doc  = '$docr' ";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }

    function impCierreVal(){
    	$this->query="SELECT max(FOLIO_IMP_CIERRE_VAL) as FA from compr01";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$fn = $row->FA + 1 ;

    	echo "Este es el folio '$fn'";

    	$this->query="UPDATE COMPR01 SET FOLIO_IMP_CIERRE_VAL = $fn, IMP_CIERRE = 'Si' where imp_cierre = 'No' and factura_prov != 'Pendiente'";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="SELECT c.*, p.nombre , o.cve_doc as OC, o.fechaelab as OC_FECHAELAB, o.importe as OC_IMPORTE, o.STATUS_REC as OC_STATUS_VAL,  o.usuario_recibe AS OC_USUARIO_VAL
    			from compr01 c 
    			left join prov01 p on c.cve_clpv = p.clave
    			left join compo01 o on o.cve_doc = c.doc_ant
    			where FOLIO_IMP_CIERRE_VAL = $fn";

    	$rs = $this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
   	}

   	function guardaCargoFinanciero($monto, $fecha, $banco){

   		$this->query="SELECT BANCO, NUM_CUENTA FROM PG_BANCOS WHERE ID = $banco";
   		$rs=$this->QueryObtieneDatosN();
   		$row=ibase_fetch_object($rs);
   		$cuenta = $row->NUM_CUENTA;
   		$bank = $row->BANCO;

   		$this->query="INSERT INTO CARGO_FINANCIERO (FECHA_RECEP, MONTO, BANCO, CUENTA, SALDO) VALUES ('$fecha', $monto, '$bank','$cuenta',$monto )";
   		$rs=$this->EjecutaQuerySimple();
   		echo $this->query;
   		return $rs;

   	}

   	function asociaCF(){
   		$this->query="SELECT cf.*, (select max(nombre) from clie01 c where c.rfc = cf.rfc) as cliente 
   						from CARGO_FINANCIERO cf 
   						where cf.saldo > 0";
   		$rs=$this->QueryObtieneDatosN();

   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}

   		return @$data;
   	}

   	function traeCF($idcf){
   		$this->query="SELECT cf.*, (select max(nombre) from clie01 c where c.rfc = cf.rfc) as cliente 
   						FROM CARGO_FINANCIERO cf
   						where ID = $idcf";
   		$rs=$this->QueryObtieneDatosN();
   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}

   		return @$data;
   	}

   	function traePagos($monto){
   		$this->query ="SELECT * FROM CARGA_PAGOS WHERE MONTO CONTAINING('$monto') and status <> 'C'";
   		$rs=$this->EjecutaQuerySimple();

   		while($tsArray=ibase_fetch_object($rs)){
   			$data[]=$tsArray;
   		}
   		return @$data;
   	}

    function cargaCF($idcf, $idp, $monto){
    	$this->query="UPDATE CARGA_PAGOS SET CF= (iif(CF is null, '$idcf', CF||'-'||'$idcf')), saldo = saldo + $monto where id = $idp";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="UPDATE CARGO_FINANCIERO SET SALDO = 0 WHERE ID = $idcf";
    	$rs=$this->EjecutaQuerySimple();

    	return $rs;
    }

    function verPagosConSaldo(){
    $this->query="SELECT * FROM CARGA_PAGOS WHERE SALDO > 0 and status <> 'C' ";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return @$data;
   }

   function enviaAcreedor($idp, $saldo, $rfc){
   	if($rfc=='XXX-AAA-XXX'){
   		$cliente = 'XXX-AAA-XXX';
   	}else{
   		$this->query="SELECT iif(MAX(CLAVE) is null, 0, max(clave)) AS CLAVE FROM CLIE01 WHERE upper(RFC) = upper('$rfc')";
   		$rs=$this->QueryObtieneDatosN();
   		$row= ibase_fetch_object($rs);
   		$cliente = $row->CLAVE;	
   	}
   
   	if($cliente != 0 or $cliente == 'XXX-AAA-XXX' ){
   		$usuario=$_SESSION['user']->USER_LOGIN;
   		$this->query="INSERT INTO ACREEDORES (ID_PAGO, MONTO, CLIENTE, FECHA, FECHA_TS, usuario_in, saldo, aplicado) VALUES ($idp, $saldo, '$cliente', current_date, current_timestamp, '$usuario',$saldo,  0)";
   		$rs=$this->EjecutaQuerySimple();
   		$this->query="SELECT MAX(ID) AS FOLIO FROM ACREEDORES";
   		$rs=$this->QueryObtieneDatosN();
   		$row=ibase_fetch_object($rs);
   		$folioA = $row->FOLIO;
   		$this->query="UPDATE CARGA_PAGOS SET FOLIO_ACREEDOR = $folioA, saldo = 0 where id = $idp";
   		$rs=$this->EjecutaQuerySimple();
   		return 0;
   	}else{

   		echo 'No se econtro el cliente';
   		return 1;
   	}


   }

   function traeClientes(){
   	$this->query="SELECT RFC, max(NOMBRE) AS NOMBRE FROM CLIE01 WHERE UPPER(STATUS) != UPPER('S') GROUP BY RFC ";
   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return $data;
   }

   function verAcreedores(){
   	$this->query="SELECT ac.*, (c.nombre ||' ( '|| c.clave||' )') as CL, cp.banco as BANCO, cp.fecha_recep, cp.id as Pago, cp.FOLIO_X_BANCO 
   				from Acreedores ac
   				left join clie01 c on c.clave = ac.cliente
   				left join carga_pagos cp on cp.id = ac.id_pago
   				where ac.contabilizado = 0";

   	$rs=$this->QueryObtieneDatosN();
   	while($tsArray=ibase_fetch_object($rs)){
   		$data[]=$tsArray;
   	}
   	return @$data;
   }


   function verAcreedorActivo($idp){
   	$idp = substr($idp, 2, 5);
   	//echo 'Este es el id del pago: '.$idp;
   	$this->query= "SELECT * FROM ACREEDORES WHERE ID = $idp";
   	$rs=$this->QueryObtieneDatosN();
   	$row = ibase_fetch_object($rs);

   	return $row;

   }

   function contabilizarAcreedor($ida){
   	$this->query="UPDATE ACREEDORES SET contabilizado = 1 where id= $ida";
   	$rs = $this->EjecutaQuerySimple();
   	return $rs;

   }

    function facturasxaplicar($idp){
    	if(substr($idp, 0,1)=='A'){
    		$idp = substr($idp, 2,5);
    		$this->query ="SELECT a.id 
    				from CARGA_PAGOS a
    				where a.folio_acreedor = $idp";
    		//echo $this->query;
    		$rs = $this->QueryObtieneDatosN();
    		$row=ibase_fetch_object($rs);
    		$idp = $row->ID;
    		}

    	$this->query ="SELECT a.*, cl.nombre as cliente, f.fechaelab, f.importe  
    				from APLICACIONES a
    				left join factf01 f on f.cve_doc = a.documento  
    				left join clie01 cl on f.cve_clpv = cl.clave
    				where idpago = $idp and a.cancelado = 0";
    	
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

   function cancelaAplicacion($idp, $docf, $idap, $montoap, $tipo){
   		$usuario=$_SESSION['user']->USER_LOGIN;

   		###### Meter Validacion Contable #############

   		$this->query="UPDATE APLICACIONES SET CANCELADO = 1 WHERE id=$idap";
   		$rs=$this->EjecutaQuerySimple();

   		if(substr($tipo, 0,1) == 'A'){
   		
   			$this->query="UPDATE ACREEDORES SET SALDO = SALDO + $montoap where id = substring('$tipo' from 3 for 10)";
   			$rs=$this->EjecutaQuerySimple();
   		}else{
   			$this->query="UPDATE CARGA_PAGOS SET SALDO = SALDO + $montoap where id = $idp";
   			$rs=$this->EjecutaQuerySimple();
   		}
   		
   		$this->query="UPDATE factf01 set saldofinal = saldofinal + $montoap, pagos = pagos - $montoap, aplicado = aplicado - $montoap where cve_doc = '$docf'";
   		$rs=$this->EjecutaQuerySimple();

   		$this->query="SELECT extract(month from fechaelab) as mes, extract(year from fechaelab) as anio, cve_maestro as maestro from factf01 where cve_doc = '$docf'";
   		$result=$this->QueryObtieneDatosN();
   		$row=ibase_fetch_object($result);
   		$mes =$row->MES;
   		$anio = $row->ANIO;
   		$maestro = $row->MAESTRO;
   		$campo='SALDO_'.$anio;

   		$this->query = "UPDATE MAESTROS SET $campo = $campo + $montoap where clave = '$maestro'";
   		$rs=$this->EjecutaQuerySimple();

   		if(substr($tipo,0,1) == 'A'){
   			$campo = 'Acreedor';
   			$this->query = "UPDATE MAESTROS SET $campo = $campo + $montoap where clave = '$maestro'";
   			$rs=$this->EjecutaQuerySimple();
   		}
   		return $rs;
   }

      function procesarPago($idp, $tipo){

   		$this->query="UPDATE CARGA_PAGOS SET TIPO_PAGO ='$tipo' where id = $idp";
   		$rs=$this->EjecutaQuerySimple();

   		return $rs;
   }

      function regEdoCta($idtrans, $monto, $tipo, $cargo,$anio, $nvaFechComp, $nf, $valor ){
   		$usuario=$_SESSION['user']->USER_LOGIN;
   		$nombre= $_SESSION['user']->NOMBRE;
   		echo $idtrans;
   		echo $tipo;

    	if($tipo == 'Venta'){
    		$this->query ="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $monto, 1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();
    		
    		$this->query ="UPDATE CARGA_PAGOS SET REGISTRO = 1 WHERE ID = $idtrans";
    		$rs=$this->EjecutaQuerySimple();
    		return $rs;
    	}elseif(substr($idtrans, 0, 1) =='O'){
    		$this->query ="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $cargo, -1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();	
    		if($nf == '1' and $valor == '1'){
    			$this->query="UPDATE COMPO01 SET edocta_fecha = '$nvaFechComp', fecha_edo_cta_ok = $valor WHERE CVE_DOC = '$idtrans'";
    			$rs=$this->EjecutaQuerySimple();
    			echo $this->query;
    			//break;
    			return $rs;    		 	
    		}elseif($nf == '1' and $valor == '0'){
    			$this->query="UPDATE COMPO01 SET fecha_edo_cta_ok = $valor WHERE CVE_DOC = '$idtrans'";
    			$rs=$this->EjecutaQuerySimple();
    			return $rs;
    		}else{
    			$this->query="UPDATE COMPO01 SET REGISTRO = 1 WHERE CVE_DOC = '$idtrans'";
    			$rs=$this->EjecutaQuerySimple();
    			return $rs;
    		}	
    	}elseif(substr($idtrans, 0 , 3)=='CD-'){
    		$this->query ="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $cargo, -1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();

    		if($nf=='1' and $valor == '1'){
    			$this->query="UPDATE CR_DIRECTO SET fecha_edo_cta = '$nvaFechComp', fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6) ";
	    		$rs=$this->EjecutaQuerySimple();

    		}elseif($nf == '1' and $valor == '0'){
    			$this->query="UPDATE CR_DIRECTO SET  fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6) ";
	    		$rs=$this->EjecutaQuerySimple();
    		}else{
    			$this->query="UPDATE CR_DIRECTO SET REGISTRO = 1 WHERE id = substring('$idtrans' from 4 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}
    	}elseif (substr($idtrans,0,3)=='SOL'){
    		$this->query="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $cargo, -1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();
    		if($nf=='1' and $valor == '1'){
    			$this->query="UPDATE SOLICITUD_PAGO SET fecha_edo_cta = '$nvaFechComp', fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6) ";

    			$rs=$this->EjecutaQuerySimple();
    		
    		}elseif($nf == '1' and $valor == '0'){
    			$this->query="UPDATE SOLICITUD_PAGO SET  fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}else{
    			$this->query="UPDATE SOLICITUD_PAGO SET registro=1 WHERE id = substring('$idtrans' from 4 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}
    	}elseif (substr($idtrans,0,3)=='GTR'){
    		$this->query="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $cargo, -1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();
    		if($nf=='1' and $valor == '1'){
    			$this->query="UPDATE GASTOS SET fecha_edo_cta = '$nvaFechComp', fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6)";
    			$rs=$this->EjecutaQuerySimple();
    		
    		}elseif($nf=='1' and $valor =='0'){
    			$this->query="UPDATE GASTOS SET fecha_edo_cta_ok = $valor WHERE id = substring('$idtrans' from 4 for 6)";
    			$rs=$this->EjecutaQuerySimple();
    		}else{
    			$this->query="UPDATE GASTOS SET registro=1 WHERE id = substring('$idtrans' from 4 for 6)";
    			$rs=$this->EjecutaQuerySimple();
    		}
    	}elseif(substr($idtrans, 0,1) == 'D'){
    		$this->query="INSERT INTO REG_EDOCTA (TRANSACCION, MONTO, SIGNO, FECHAELAB, FECHA_TRANSACCION, FECHA_APLICACION, USUARIO)
    					VALUES ('$idtrans', $cargo, -1, current_timestamp, current_date, current_date, '$nombre')";
    		$rs=$this->EjecutaQuerySimple();
    		if($nf=='1' and $valor == '1'){
    			$this->query="UPDATE DEUDORES SET fechaedo_cta = '$nvaFechComp', fecha_edo_cta_ok = $valor WHERE iddeudor = substring('$idtrans' from 2 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}elseif($nf == '1' and $valor == '0'){
    			$this->query="UPDATE DEUDORES SET  fecha_edo_cta_ok = $valor WHERE iddeudor = substring('$idtrans' from 2 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}else{
    			$this->query="UPDATE DEUDORES SET registro=1 WHERE iddeudor = substring('$idtrans' from 2 for 6) ";
    			$rs=$this->EjecutaQuerySimple();
    		}
    	}

    	return $rs;
    }
  function NewSolicitudPago($cuentaBancaria, $medio, $importe, $misFolios){
    	$usuario=$_SESSION['user']->NOMBRE;
    	$folios=implode(",",$misFolios);
    	$this->query= "SELECT CVE_CLPV as CLAVE
    				   FROM COMPR01 
    					WHERE TRIM(CVE_DOC) IN (SELECT TRIM(IDENTIFICADOR) FROM OC_CREDITO_CONTRARECIBO WHERE FOLIO IN ($folios)) group by cve_clpv";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT cve_prov as clave 
    							FROM OC_PAGOS_CREDITO_RECIBO ocp
    							where ocp.recepcion in (SELECT identificador FROM OC_CREDITO_CONTRARECIBO WHERE folio IN ($folios)) group by cve_prov";
    							//echo $this->query;
    			$result = $this->EjecutaQuerySimple();
    			while ($tsArray = ibase_fetch_object($result)){
    				$data[]=$tsArray;
    			}

    	$prov = count($data);
    		
    	echo 'Proveedores: '.$prov.'<p>';
    	//break;
    	if(count($data)>1){
    		$rs=2;
    		return $rs;
       	}else{
    	$cveclpv=$data[0]->CLAVE;
    	$this->query="INSERT INTO SOLICITUD_PAGO(MONTO, FECHA, USUARIO, TIPO, FECHAELAB, BANCO, PROVEEDOR)
    				  VALUES ($importe, current_date, '$usuario', '$medio', current_timestamp, '$cuentaBancaria', '$cveclpv')";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="SELECT MAX(IDSOL) as id FROM SOLICITUD_PAGO";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$folio=$row->ID;
    	return $folio;	
    	}
    	
    }

    function asignaFolioDocumento($folio, $creaSP){

    	$this->query="SELECT IDENTIFICADOR as DOCU FROM OC_CREDITO_CONTRARECIBO WHERE folio = $folio";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$docu=$row->DOCU;

    	$this->query="UPDATE compr01 set id_solicitud = $creaSP, STATUS_PAGO = 'PP' where trim(cve_doc) = trim('$docu')";
    	$rs=$this->EjecutaQuerySimple();


    	$this->query = "UPDATE FTC_DETALLE_RECEPCIONES set id_solicitud = $creaSP, STATUS_PAGO = 'PP'  WHERE trim(ID_RECEPCION) = trim($docu)";
    	$rs=$this->EjecutaQuerySimple();
    	//echo 'Folio: '.$folio.'<p>';
    	//echo 'CreaSP'.$creaSP.'<p>';
    	//echo 'asignaFolio Documento'.$this->query.'<p>';
    	//echo $this->query;
  		return $rs;

    }


    function FolioValidaRecepcion($docr, $doco){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="SELECT IMPORTE FROM COMPO01 WHERE Trim(CVE_DOC) = trim('$doco')";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$importeoc = $row->IMPORTE;

    	if(substr(trim($docr),0,1) == 'F'){
    			$importer = 0;
    		
    	}else{
    			$this->query="SELECT IMPORTE FROM COMPR01 WHERE TRIM(CVE_DOC) = TRIM('$docr')";
    			$rs=$this->QueryObtieneDatosN();
    			$row=ibase_fetch_object($rs);
    			$importer=$row->IMPORTE;
    	}
    	$this->query="INSERT INTO VALIDACIONES (OC, RECEPCION, IMPORTE_OC, IMPORTE_RECEP, FECHA_VALIDACION, USUARIO)
    					VALUES ('$doco', '$docr', $importeoc, $importer, current_timestamp, '$usuario')";
    	$rs=$this->EjecutaQuerySimple();
    	$this->query="SELECT MAX(IDVAL) AS FOLIO FROM VALIDACIONES";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$folio=$row->FOLIO;

    	return $folio;
    }

    function verValidaciones($doco){
    	$this->query="SELECT v.*, p.nombre as proveedor, r.importe as importe_val,'NA' as RESULTADO
    				FROM VALIDACIONES v
    				left join compr01 r on r.cve_doc = v.recepcion 
    				left join prov01 p on p.clave = r.cve_clpv
    				WHERE IMPRESO = 0 and (upper(oc) = upper('$doco') or upper(oc) containing upper('$doco'))";
    				//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function datosValidacion($idval){
    	$this->query="SELECT v.*, p.nombre as Proveedor, 'NA' AS RESULTADO
    					FROM VALIDACIONES v
    					left join compo01 oc on oc.cve_doc = v.oc
    					left join prov01 p on oc.cve_clpv = p.clave 
    					WHERE IDVAL = $idval";
    		//			echo $this->query;
    	$rs=$this->QueryObtieneDatosN();


    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function ValidacionPartidad($idval){
    	$this->query="SELECT v.idval as FOLIO_VALIDACION, poc.*, oc.DOC_SIG,  i.descr, i.UNI_ALT
    					FROM PAR_COMPO01 poc
    					left join validaciones v on v.oc = poc.cve_doc
    					left join compo01 oc on oc.cve_doc = poc.cve_doc
    					LEFT JOIN PROV01 p ON p.clave = oc.cve_clpv
    					left join compr01 r on oc.doc_sig = r.cve_doc
    					left join inve01 i on poc.cve_art = i.cve_art
    					where v.idval = $idval";
    		//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	
    	return @$data;
    }

    function verSolicitudes(){
    	$this->query="SELECT s.*, p.nombre as NOM_PROV FROM 
    				SOLICITUD_PAGO s 
    				left join prov01 p on s.proveedor = p.clave
    				WHERE IMPRESO = 0 ";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function datosSolicitud($idsol){
    	$this->query="SELECT s.*, p.nombre as NOM_PROV FROM 
    				SOLICITUD_PAGO s 
    				left join prov01 p on s.proveedor = p.clave
    				WHERE IDSOL = $idsol ";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	} 
    	return $data;
        }

    function crSolicitud($idsol){
    	$this->query="SELECT r.*, iif(r.monto_real = 0, r.importe, r.monto_real) as importe_REAL , p.NOMBRE AS NOM_PROV, o.cve_doc as CVE_DOC_OC, o.importe as IMPORTE_OC, o.fechaelab as FECHAELAB_OC 
    					FROM COMPR01 r 
    					left join prov01 p on r.cve_clpv = p.clave 
    					LEFT JOIN COMPO01 o on o.cve_doc = r.doc_ant
    				    WHERE id_solicitud = $idsol";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT ocpr.*, recepcion as cve_doc, current_date as fechaelab, ocpr.monto_real as importe_real, ocpr.beneficiario as nom_prov, ocpr.id as cve_doc_oc, fecha_doc as fechaelab_oc,
    					(select importe from compo01 where cve_doc = ocpr.OC) as importe_oc
    					FROM OC_PAGOS_CREDITO_RECIBO ocpr WHERE id_solicitud = '$idsol' ";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	
    	return $data;
    }

    function ctrlImpresiones($idsol){
    	$this->query ="UPDATE SOLICITUD_PAGO SET IMPRESO = IMPRESO + 1 WHERE IDSOL = $idsol";
    	$rs=$this->EjecutaQuerySimple();
    	$this->query = "SELECT IMPRESO FROM SOLICITUD_PAGO WHERE IDSOL = $idsol";
    	$res = $this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($res);
    	$num_impresiones = $row->IMPRESO;
    	return $num_impresiones;
    }

    function Solicitudes($doc){
    	$this->query ="SELECT r.*, p.nombre, datediff(day, fechaelab, current_date) as DIAS, current_date as HOY
    					from COMPR01 r
    					left join prov01 p on r.cve_clpv = p.clave  
    					where id_solicitud = $doc";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verSol($doc){
    	$this->query = "SELECT s.*, p.nombre 
    					from SOLICITUD_PAGO s 
    					left join prov01 p on p.clave = s.proveedor
    					where s.idsol = $doc";
    	$rs= $this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verPagoSolicitudes(){
    	$this->query = "SELECT s.*, p.nombre as nom_prov 
    				FROM SOLICITUD_PAGO s
    				left join prov01 p on p.clave = s.proveedor
    				WHERE s.STATUS = 'Pagado'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verCompras(){
    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHAELAB, BANCO, USUARIO_PAGO, CHEQUE AS FOLIO FROM p_cheques p where fecha >= '01.11.2016' and STATUS_CONTABILIDAD = 0";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHAELAB, BANCO, USUARIO_PAGO, TRANS AS FOLIO FROM p_TRANS p where fecha >='01.11.2016' and STATUS_CONTABILIDAD = 0";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHAELAB, BANCO, USUARIO_PAGO, EFECTIVO AS FOLIO FROM P_EFECTIVO p where fecha >='01.11.2016' and STATUS_CONTABILIDAD = 0";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT p.nombre as BENEFICIARIO, s.MONTO_FINAL AS MONTO, ('SOL'||'-'||s.IDSOL) AS DOCUMENTO, s.STATUS, s.fecha_reg_pago_final AS FECHAELAB, s.BANCO_FINAL, s.USUARIO_PAGO, ('CR'||'-'||UPPER(s.TP_TES_FINAL)||'-'||s.FOLIO) AS FOLIO, s.banco_final as BANCO 
    				 FROM SOLICITUD_PAGO s
    				 left join prov01 p on p.clave = s.proveedor
    				 WHERE s.STATUS = 'Pagado'";
    	$rs = $this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function recConta($folio){
    	$usuario = $_SESSION['user']->NOMBRE;
    	//echo $folio;
    	//break;

    	if(substr($folio, 0,2) == 'ch'){
    		$tabla = 'P_CHEQUES';
    		$campo = 'CHEQUE';
    	}elseif (substr($folio,0,2) == 'tr' ){
    		$tabla = 'P_TRANS';
    		$campo = 'TRANS';
    	}elseif (substr($folio, 0,1) == 'e'){
    		$tabla = 'P_EFECTIVO';
    		$campo = 'EFECTIVO';
      	}elseif (substr($folio, 0,3) == 'CR-'){
    		$tabla = 'SOLICITUD_PAGO';
    		$campo = 'IDSOL';
    		//$vttf = substr($folio,3,2);
    		//$vf = substr($folio,6,6);
    		$doc = split('-', $folio);
    		$tipo = $doc[0];
    		$vttf = $doc[1];
    		$vf = $doc[2];
    	$this->query = "UPDATE $tabla set status = 'Recibido', fecha_rec_conta = current_timestamp, usuario_recibe = '$usuario' where upper(TP_TES_FINAL) = upper('$vttf') and folio = $vf";
    	$rs = $this->EjecutaQuerySimple();
    	echo $this->query;
    	return;
    	}

    	$this->query="SELECT DOCUMENTO, BANCO FROM $tabla where $campo = '$folio'";
		$res=$this->EjecutaQuerySimple();
		$row = ibase_fetch_object($res);
		$doc = $row->DOCUMENTO;
		$banco = $row->BANCO;

		echo 'Obtener el documento: '.$this->query.'<p>';
    	$this->query="UPDATE FTC_POC SET edocta_fecha = CURRENT_TIMESTAMP, USUARIO_CONTA = '$usuario', banco = '$banco', TP_TES = '$folio' where oc = upper('$doc')";
    	$rs = $this->EjecutaQuerySimple();
		echo 'Actualiza el documento: '.$this->query.'<p>';
    	$this->query="UPDATE $tabla SET STATUS_CONTABILIDAD = 1, fecha_rec_conta = current_timestamp, usuario_recibe = '$usuario' where $campo = '$folio'";
    	$rs= $this->EjecutaQuerySimple();
		echo 'Actualiza el pago: '.$this->query.'<p>';

    	//break;
    	return $rs;
    }

    function verComprasRecibidas(){
    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHA_REC_CONTA, BANCO, USUARIO_RECIBE, CHEQUE AS FOLIO FROM p_cheques p where fecha >= '01.01.2017' and STATUS_CONTABILIDAD = 1";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHA_REC_CONTA, BANCO, USUARIO_RECIBE, TRANS AS FOLIO FROM p_TRANS p where fecha >='01.01.2017' and STATUS_CONTABILIDAD = 1";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT BENEFICIARIO, MONTO, DOCUMENTO, STATUS, FECHA_REC_CONTA, BANCO, USUARIO_RECIBE, EFECTIVO AS FOLIO FROM P_EFECTIVO p where fecha >='01.01.2017' and STATUS_CONTABILIDAD = 1";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT p.nombre as BENEFICIARIO, s.MONTO_FINAL AS MONTO, ('SOL'||'-'||s.IDSOL) AS DOCUMENTO, s.STATUS, s.FECHA_REC_CONTA, s.BANCO_FINAL, s.USUARIO_RECIBE, ('CR'||'-'||UPPER(s.TP_TES_FINAL)||'-'||s.FOLIO) AS FOLIO, s.BANCO 
    				 FROM SOLICITUD_PAGO s
    				 left join prov01 p on p.clave = s.proveedor
    				 WHERE s.STATUS = 'Recibido'";
    	$rs = $this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function regCompraEdoCta($folio, $doc, $fecha){
    	$usuario =$_SESSION['user']->NOMBRE;

    	if(substr($doc,0,3)=='SOL'){
    		$this->query="UPDATE SOLICITUD_PAGO SET FECHA_EDO_CTA = '$fecha', usuario_edo_cta = '$usuario', status = 'Registrado'
    				where idsol = (substring('$doc' from 5 for 6))";
    		$rs= $this->EjecutaQuerySimple();
    		return $rs;
    	}elseif(substr($folio, 0,2) == 'ch'){
    		$tabla = 'P_CHEQUES';
    		$campo  = 'CHEQUE';
    	}elseif (substr($folio,0,2) == 'tr' ){
    		$tabla = 'P_TRANS';
    		$campo = 'TRANS';
    	}elseif (substr($folio, 0,1) == 'e'){
    		$tabla = 'P_EFECTIVO';
    		$campo = 'EFECTIVO';
    	}
    	$this->query = "UPDATE $tabla set FECHA_EDO_CTA = '$fecha', usuario_edo_cta = '$usuario', status_contabilidad = 2 where $campo = '$folio'";
    	$rs=$this->EjecutaQuerySimple();

    	
    	$this->query = "SELECT BANCO FROM $tabla where $campo = '$folio '";
    	$rs=$this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$banco = $row->BANCO;
    	if (empty($banco)){
    		$banco = 'Sin Banco';
    	}

    	$this->query = "UPDATE COMPO01 SET EDOCTA_FECHA= '$fecha', edocta_reg = current_timestamp, usuario_recibe='$usuario', fecha_edo_cta_ok = '1', banco = '$banco' 
    	where cve_doc ='$doc' ";
    	$rs=$this->EjecutaQuerySimple();

    	//echo $this->query;

    	return $rs;    	
    }

    function buscarPagos($campo){

    	$this->query="SELECT ID , 'NA' AS DOCUMENTO, BANCO, monto, saldo, FOLIO_X_BANCO, USUARIO, FOLIO_ACREEDOR, fecha_recep from CARGA_PAGOS WHERE (MONTO CONTAINING('$campo') OR upper(FOLIO_X_BANCO) CONTAINING (upper('$campo'))) AND STATUS = ''";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	/*if(!empty($data)){
    		$this->query="SELECT cp.ID, DOCUMENTO, cp.BANCO, cp.FOLIO_X_BANCO, cp.folio_acreedor, cp.monto, cp.saldo , a.USUARIO 
    				FROM APLICACIONES a
    				left join CARGA_PAGOS cp on cp.id = a.idpago
    				WHERE UPPER(DOCUMENTO) = UPPER('$campo') AND CANCELADO = 0";
    		$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[] = $tsArray;
    		}
    	}*/
    	return @$data; 
    }

    function cancelarPago($idp){
    	$this->query ="UPDATE CARGA_PAGOS SET STATUS = 'C' WHERE ID = $idp";
    	$rs = $this->EjecutaQuerySimple();
    	return $rs;
    	
    }

    function enviarConta($creaSP){

    	$this->query="UPDATE SOLICITUD_PAGO set MONTO_FINAL = MONTO, BANCO_FINAL = BANCO, fecha_reg_pago_final = FECHA, FECHA_PAGO = FECHAELAB, STATUS = 'Pagado', usuario_pago=(USUARIO||'- Directo'), TP_TES_FINAL =tipo WHERE IDSOL = $creaSP";
    	$rs = $this->EjecutaQuerySimple();

    	$this->query="SELECT TP_TES_FINAL AS TIPO FROM SOLICITUD_PAGO WHERE IDSOL = $creaSP";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$tipop =$row->TIPO; 

    	$this->query="SELECT MAX(FOLIO) as FOLIO FROM SOLICITUD_PAGO WHERE TP_TES_FINAL ='$tipop'";
			$res=$this->QueryObtieneDatosN();
			$row = ibase_fetch_object($res);
			$folioNuevo = $row->FOLIO + 1;
			$this->query = "UPDATE SOLICITUD_PAGO SET FOLIO = $folioNuevo where idsol = $creaSP";
			$result = $this->EjecutaQuerySimple();

    	echo 'El pago se ha enviado a contabilidad, no se encontrara en la Area de Pagos...';
    	return $rs; 
    }

    function totalMensual($mes, $banco, $cuenta, $anio){
    	$this->query="SELECT SUM(MONTO) AS MONTO FROM CARGA_PAGOS 
    				WHERE EXTRACT(MONTH FROM FECHA_RECEP) = $mes and Banco = (trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' 
    				and extract(year from fecha_recep) = $anio";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data = $row->MONTO;
    	return @$data;
    }

    function ventasMensual($mes, $banco, $cuenta, $anio){
    	$this->query="SELECT iif(SUM(MONTO) is null, 0, sum(monto)) AS MONTO FROM CARGA_PAGOS WHERE EXTRACT(MONTH FROM FECHA_RECEP) = $mes and extract(year from fecha_recep) = $anio and Banco = (trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' and tipo_pago is null and (seleccionado >= 1 or seleccionado = 2) and guardado = 1" ;
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data=$row->MONTO;
    	return @$data; 
    }

    function transfer($mes, $banco, $cuenta, $anio){
    	$this->query="SELECT iif(SUM(MONTO) is null, 0, SUM(MONTO)) AS MONTO FROM CARGA_PAGOS WHERE extract(year from fecha_recep)=$anio and EXTRACT(MONTH FROM FECHA_RECEP) = $mes and Banco =(trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' and tipo_pago = 'oTEC' and (seleccionado >= 1 or seleccionado = 2) and guardado = 1";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data=$row->MONTO;
    	return @$data;
    }

    function devCompra($mes, $banco, $cuenta, $anio){
    	$this->query="SELECT iif(SUM(MONTO) is null, 0, SUM(MONTO)) AS MONTO FROM CARGA_PAGOS 
    	WHERE extract(year from fecha_recep)=$anio and  EXTRACT(MONTH FROM FECHA_RECEP) = $mes and Banco =(trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' and tipo_pago = 'DC' and (seleccionado >= 1 or seleccionado = 2) and guardado = 1 ";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data=$row->MONTO;
    	return @$data;
    }

    function devGasto($mes, $banco, $cuenta, $anio){
    	$this->query="SELECT iif(SUM(MONTO) is null, 0, SUM(MONTO)) AS MONTO FROM CARGA_PAGOS 
    	WHERE extract(year from fecha_recep)=$anio and EXTRACT(MONTH FROM FECHA_RECEP) = $mes and Banco =(trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' and tipo_pago = 'DG' and (seleccionado >= 1 or seleccionado = 2) and guardado = 1 ";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data=$row->MONTO;
    	return @$data;
    }

    function pcc($mes, $banco, $cuenta, $anio){
    	$this->query = "SELECT iif(SUM(MONTO) is null, 0, SUM(MONTO)) AS MONTO FROM CARGA_PAGOS WHERE extract(year from fecha_recep) = $anio and  EXTRACT(MONTH FROM FECHA_RECEP) = $mes and Banco =(trim('$banco')||' - '||trim('$cuenta')) and status <> 'C' and tipo_pago = 'oPCC' and (seleccionado >= 1 or seleccionado = 2) and guardado = 1 ";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$data=$row->MONTO;
    	return @$data;
    }

    function pagosAplicados($mes,$banco,$anio,$cuenta){

    	$this->query="SELECT sum(monto) as Total, sum(saldo) as Faltante 
    				from carga_pagos 
    				WHERE extract(month from fecha_recep) = $mes
    				and extract(year from fecha_recep) = $anio 
    				and banco  = '$banco'||' - '||'$cuenta'
    				and status <>'C'
    				and (tipo_pago is null or tipo_pago = '')
    				and seleccionado = 2
    				";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

	function pagosAcreedores($mes,$banco,$anio,$cuenta){
    	$this->query="SELECT sum(a.monto) as ACREEDORES, sum(cp.saldo) as Faltante 
    				from acreedores a
    				left join carga_pagos cp on cp.id = a.id_pago
    				WHERE extract(month from cp.fecha_recep) = $mes
    				and extract(year from cp.fecha_recep) = $anio
    				and cp.banco  = '$banco'||' - '||'$cuenta'
    				and cp.status <>'C'
    				and (cp.tipo_pago is null or tipo_pago = '')
    				and a.status <> 99
    				and seleccionado = 2
    				";
    	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function infoPagos($idp){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE ID = $idp";
    	$rs=$this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    	}
    	return $data;
    }

    function pagoFacturas($idp){
    	$this->query="SELECT a.*, c.nombre AS CLIENTE, c.clave, f.importe
    					FROM APLICACIONES a
    					left join factf01 f on a.documento = f.cve_doc
    					left join clie01 c on c.clave = f.cve_clpv
    					WHERE IDPAGO = $idp 
    					and cancelado = 0
    					order by SALDO_PAGO DESC ";
    	$rs= $this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    	}
    	return $data;
    }

    function montoAplicado($idp){
    	$this->query="SELECT SUM(MONTO_APLICADO) as MONTO FROM APLICACIONES WHERE IDPAGO = $idp and cancelado = 0";
    	$rs=$this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$totalAplicado = $row->MONTO;

    	return $totalAplicado;
    }


   
     function totalCompras($mes, $banco, $anio, $cuenta){
    	$this->query = "SELECT iif(SUM(iif(monto_final = 0, importe, monto_final)) is null, 0, SUM(iif(monto_final = 0, importe, monto_final))) as totCompras from compo01 
    		where 
    		--fecha_edo_cta_ok = '1' and 
    		extract(month from edocta_fecha) = $mes 
    		and extract(year from edocta_fecha) = $anio
    		and banco = ('$banco'||' - ' ||'$cuenta')
    		and (seleccionado = 1 or seleccionado = 2) ";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
   		$totc=$row->TOTCOMPRAS;
   		//var_dump($data);

   		$this->query = "SELECT sum(pago_tes) as totCompras from ftc_poc 
    		where 
    		extract(month from edocta_fecha) = $mes 
    		and extract(year from edocta_fecha) = $anio
    		and banco = ('$banco'||' - ' ||'$cuenta')
    		and (seleccionado = 1 or seleccionado = 2) ";
    	$rs=$this->QueryObtieneDatosN();
    	$row2=ibase_fetch_object($rs);
   		$totcn=$row2->TOTCOMPRAS;
   		
   		$totc = $totc + $totcn;

   		return $totc;
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
    function totalGasto($mes, $banco, $anio, $cuenta){
    	$this->query = "SELECT SUM(g.monto_pago) AS TOTGASTO 
    					FROM GASTOS g 
    					left join PAGO_GASTO pg on pg.idgasto = g.id and pg.cuenta_bancaria =('$banco'||' - '||'$cuenta')
    					where 
    					pg.CUENTA_BANCARIA = ('$banco'||' - '||'$cuenta') and iif(fecha_edo_cta is null,extract(month from g.FECHA_DOC), extract(month from fecha_edo_cta)) = $mes and iif(fecha_edo_cta is null, extract(year from g.FECHA_DOC), extract(year from fecha_edo_cta)) = $anio and g.status = 'V'  and (seleccionado = 1 or seleccionado = 2) and guardado = 1";

    					/*
    					iif(fecha_edo_cta is null,extract(month from g.FECHA_DOC), extract(month from fecha_edo_cta)) = $mes
					    and iif(fecha_edo_cta is null, extract(year from g.FECHA_DOC), extract(year from fecha_edo_cta)) = $anio
					    and g.status = 'V'
					    and (seleccionado = 1 or seleccionado = 2) and guardado = 1
    					--and fecha_edo_cta_ok = '1'
    					";*/
    					/*
							SELECT  4 as s, iif(fecha_EDO_CTA is null, fecha_doc, fecha_EDO_CTA) as sort, 'Gasto' AS TIPO, pg.ID AS CONSECUTIVO, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta) AS FECHAMOV, 0 AS ABONO, g.MONTO_PAGO AS CARGO, 0 AS SALDO, pg.CUENTA_BANCARIA AS BANCO, pg.USUARIO_REGISTRA AS USUARIO, pg.FOLIO_PAGO as TP, ('GTR'||g.id) as identificador, '' as registro, '' as FA, iif(g.fecha_edo_cta is null, iif(fecha_edo_cta is null, FECHA_DOC, fecha_edo_cta), g.fecha_edo_cta) as fe, FECHA_EDO_CTA_OK as comprobado, contabilizado , SELECCIONADO
    			FROM GASTOS g
    			left join pago_gasto pg on pg.idgasto = g.id
    			WHERE pg.CUENTA_BANCARIA = ('$banco'||' - '||'$cuenta') and iif(fecha_edo_cta is null,extract(month from g.FECHA_DOC), extract(month from fecha_edo_cta)) = $mes and iif(fecha_edo_cta is null, extract(year from g.FECHA_DOC), extract(year from fecha_edo_cta)) = $anio and g.status = 'V'  and (seleccionado = 2 )
    					*/
    		//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$totg=$row->TOTGASTO;
    	//echo $this->query;
    	$this->query="SELECT iif(SUM(IMPORTE) IS NULL, 0 , SUM(IMPORTE)) as GastoDirecto
    				  FROM CR_DIRECTO 
    				  WHERE extract(month from fecha_edo_cta) = $mes
    				  and extract(year from fecha_edo_cta) = $anio
    				  and banco = '$banco' 
    				  and (seleccionado = 1 or seleccionado = 2) and guardado = 1
    				  --and fecha_edo_cta_ok='1'
    				  ";
		$rs= $this->QueryObtieneDatosN();
		//echo $this->query;
		$row=ibase_fetch_object($rs);
		$totgd = $row->GASTODIRECTO;
		$totg =$totg + $totgd; 
    	return $totg;
    }


    function totalDeudores($mes, $banco, $anio, $cuenta){
    	$this->query="SELECT iif(SUM(importe)is null, 0, Sum(importe)) as TOTALDEUDORES 
    			FROM DEUDORES 
    			WHERE extract(month from FECHAEDO_CTA)= $mes and extract(year from fechaedo_cta)= $anio 
    			--and fecha_edo_cta_ok ='1'
    			and banco = ('$banco'||' - '||'$cuenta')
    			and (seleccionado = 1 or seleccionado = 2)  and guardado = 1";
    	$rs=$this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$totg= $row->TOTALDEUDORES;
    	return $totg;
    }

    function totalCredito($mes, $banco, $anio, $cuenta){
    	$this->query="SELECT iif(sum(monto_final) is null,0, sum(monto_final)) as totalcredito from SOLICITUD_PAGO 
    				where extract(month from fecha_edo_cta) = $mes 
    				and extract(year from fecha_edo_cta) = $anio
    				--and fecha_edo_cta_ok = '1'
    				and banco_final = ('$banco'||' - '||'$cuenta')
    				and (seleccionado = 1 or seleccionado = 2) and guardado = 1";
    	$rs=$this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$totCr = $row->TOTALCREDITO;

    	return $totCr; 
    }

    function buscarContrarecibos($campo){
    	$this->query="SELECT cr.*, r.fechaelab, p.nombre , r.monto_real
    				FROM OC_CREDITO_CONTRARECIBO cr
    				left join compr01 r on r.cve_doc = cr.identificador 
    				left join prov01 p on r.cve_clpv = p.clave 
    				where trim(identificador) containing (trim($campo))";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;

    }

    function obtenerFolio($identificador){
    	$this->query="SELECT folio AS FOLIO FROM OC_CREDITO_CONTRARECIBO WHERE IDENTIFICADOR ='$identificador'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$folio = $row->FOLIO;
    	return $folio;
    }

    function traeGasto(){
    	$this->query="SELECT ID AS IDG, CONCEPTO AS NOMBRE FROM CAT_GASTOS WHERE ACTIVO = 'S'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function procesoAplicaciones(){
    	$this->query="SELECT ID AS IDA, IDPAGO AS IDP, documento as Documento, monto_aplicado as monto FROM APLICACIONES where cancelado = 0 and id >= 1 and id < 5000";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	//var_dump($data);
    	//break;
    	$i = 0;
    	foreach ($data as $key ){
    		$i = $i+1;
    		$ida=$key->IDA;
    		$idp=$key->IDP;
    		$documento=$key->DOCUMENTO;
    		$monto = $key->MONTO;
    		$this->query = "UPDATE FACTF01 set Aplicado = (Aplicado + $monto), saldoFinal = Importe - (Aplicado + $monto) where trim(cve_doc) = trim('$documento')";
    		$rs=$this->EjecutaQuerySimple();
    		//echo 'Actualiza Factura'.$this->query;
    		$this->query ="UPDATE APLICACIONES SET PROCESADO = 1 WHERE ID = $ida";
    		$rs=$this->EjecutaQuerySimple();
    		
    		//echo 'Actualiza Aplicaciones'.$this->query;
    		//echo $i;
    	}
    	echo 'Proceso Terminado, se procesaron : '.$i.' registros.';
    	//break;
    }

#################### TOTALES DE FACTURACION 


    // COLOCAR PAGOS // 
    function dirVerFacturas($mes, $vend, $anio){
    	if($anio == 99){
    		$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, f.status, f.id_pagos, f.id_aplicaciones 
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					deuda2015 = 1
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal, '' as  status, '' as id_pagos, '' as id_aplicaciones  
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    				    deuda2015 = 1";
	    					//echo $this->query;
	    	$rs = $this->QueryObtieneDatosN();
	    	while($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}

	    	$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, f.status, f.id_pagos, f.id_aplicaciones  
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					f.serie = 'G'  and deuda2015 = 1
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal, '' as status, '' as id_pagos, '' as id_aplicaciones  
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					f.serie = 'G'  and deuda2015 = 1";
	    					//echo $this->query;

	    	$rs = $this->QueryObtieneDatosN();
	    	while($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}

	    	$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, f.status, f.id_pagos, f.id_aplicaciones  
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					f.serie = 'E'  and deuda2015 = 1
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal, '' as status, '' as id_pagos, '' as id_aplicaciones  
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE  
	    				    f.serie = 'E'  and deuda2015 = 1";
	    	$rs = $this->QueryObtieneDatosN();
 		   	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    		}
    	}else{
	    	$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, f.id_pagos, f.id_aplicaciones, f.status
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and f.serie = 'FAA'
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal , '' as id_pagos, '' as id_aplicaciones, '' as status
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and f.serie = 'FAA'";
	    					//echo $this->query;
	    	$rs = $this->QueryObtieneDatosN();
	    	while($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}

	    	$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, id_pagos , f.id_aplicaciones, f.status 
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and  f.serie = 'G'
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal , '' as id_pagos, '' as id_aplicaciones, '' as status 
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE  
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and f.serie = 'G'";
	    					//echo $this->query;

	    	$rs = $this->QueryObtieneDatosN();
	    	while($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}

	    	$this->query="SELECT f.CVE_DOC, f.CVE_CLPV, f.importe, f.fechaelab, f.can_tot, f.imp_tot4, f.saldo, f.doc_sig, f.cve_vend, d.importe, f.importe - d.importe as SALDONC, d.importe as importenc, d.fechaelab as fechaelabnc, c.nombre, f.aplicado , f.saldofinal, id_pagos , id_aplicaciones, f.status 
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and f.serie = 'E'
	    					UNION 
	    					SELECT 'TOTAL' as CVE_DOC, '' as CVE_CLPV, sum(f.importe), '' as fechaelab, sum(f.can_tot), sum(f.imp_tot4), sum(f.saldo), '' as doc_sig, '' as cve_vend, sum(d.importe), sum(f.importe - d.importe) as SALDONC, sum(d.importe) as importenc, '' as fechaelabnc, '' as nombre, sum(f.aplicado) as aplicado, sum(saldofinal) as saldofinal, '' as id_pagos, '' as id_aplicaciones, '' as status
	    					FROM FACTF01 f 
	    					left join factd01 d on d.cve_doc = f.doc_sig and d.status <> 'C'
	    					left join clie01 c on f.cve_clpv = c.clave
	    					WHERE 
	    					extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and  f.serie = 'E'";
    	
    		$rs = $this->QueryObtieneDatosN();
    		while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    		}
				//echo $this->query;
	    }
	    	
    	
    	return $data;
    }

    function ventasMes($mes, $vend, $anio){

    	if($anio == 99){
    		//echo 'entro al 2015';
    		$this->query="SELECT SUM(IMPORTE) as TOTAL, sum(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA 
    				  FROM FACTF01 
    				  WHERE deuda2015 = 1 and status <>'C'";
    	//echo $this->query;
    		$rs=$this->QueryObtieneDatosN();
    		while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	}else{
    		$this->query="SELECT SUM(IMPORTE) as TOTAL, sum(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA 
    				  FROM FACTF01 
    				  WHERE extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
    	//echo $this->query;
    		$rs=$this->QueryObtieneDatosN();
    		while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	//var_dump($data);	
    	}
    	return $data;
    }

    function saldoFacturas($mes, $vend, $anio){
    	if($anio == 99){
    			$this->query="SELECT SUM(SALDOFINAL) as total, (SUM(SALDOFINAL) / 1.16) as subtotal , (sum(SALDOFINAL)*.16) as iva 
    				  FROM FACTF01 
    				  WHERE deuda2015 =1 and status <>'C'";
    	//echo $this->query;
		    	$rs=$this->QueryObtieneDatosN();
		    	while($tsArray=ibase_fetch_object($rs)){
		    		$data[]=$tsArray;
		    	}
    	}else{
    			$this->query="SELECT SUM(SALDOFINAL) as total, (SUM(SALDOFINAL) / 1.16) as subtotal , (sum(SALDOFINAL)*.16) as iva 
    				  FROM FACTF01 
    				  WHERE extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
    	//echo $this->query;
		    	$rs=$this->QueryObtieneDatosN();
		    	while($tsArray=ibase_fetch_object($rs)){
		    		$data[]=$tsArray;
		    	}	
    	}
    	return $data;
    }

    function NotasCreditoMes($mes, $vend, $anio){

    	if($anio == 99){
    		$this->query="SELECT iif(SUM(IMPORTE) is null or sum(IMPORTE) = 0,0,0) as total, iif(SUM(CAN_TOT) is null or SUM(CAN_TOT) =0, 0,0) AS SUBTOTAL, iif(SUM(IMP_TOT4) is null or sum(IMP_TOT4) = 0, 0,0) AS IVA
    				  FROM FACTD01 
    				  WHERE extract(year from fechaelab) = 2000 and status <>'C'";
    	//echo $this->query;
		    	$rs=$this->QueryObtieneDatosN();
		    	while($tsArray = ibase_fetch_object($rs)){
		    		$data[]=$tsArray;
		    	}	
    	}else{
    		$this->query="SELECT SUM(IMPORTE) as total, SUM(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA
    				  FROM FACTD01 
    				  WHERE extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
    	//echo $this->query;
		    	$rs=$this->QueryObtieneDatosN();
		    	while($tsArray = ibase_fetch_object($rs)){
		    		$data[]=$tsArray;
		    	}	
    	}
    	//var_dump($data);
    	return $data;
    }

    function NCaplicadas($mes, $vend, $anio){
    	if($anio ==99){
    				$this->query="SELECT sum(importe_nc) as Importe_NC 
    					FROM FACTF01 f 
    					WHERE
    				 	deuda2015 = 1 and f.status <>'C' and f.serie = 'FAA'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	}else{
    			$this->query="SELECT sum(importe_nc) as Importe_NC 
    					FROM FACTF01 f 
    					WHERE
    				 	extract(month from f.fechaelab)= $mes and extract(year from f.fechaelab) = $anio and f.status <>'C' and f.serie = 'FAA'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}	
    	}
    	
    	return $data;
    }


    function facturasPagadasMes($mes, $vend, $anio){

    	if ($anio ==99){
	    			$this->query="SELECT SUM(APLICADO) AS TOTAL, SUM(APLICADO) / 1.16 AS SUBTOTAL, SUM(APLICADO) *.16 AS IVA
    					FROM FACTF01 
    					WHERE  deuda2015 = 1 and status <>'C'";
       	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	}else{
    			$this->query="SELECT SUM(APLICADO) AS TOTAL, SUM(APLICADO) / 1.16 AS SUBTOTAL, SUM(APLICADO) *.16 AS IVA
    					FROM FACTF01 
    					WHERE  extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
       	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
		
    	}
    
    	return $data;
    }

    function ventaTotalMes($mes, $vend, $anio){

    	if($anio == 99 ){
    			$this->query="SELECT SUM(IMPORTE) as TOTAL, sum(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA 
    				  FROM FACTF01 
    				  WHERE deuda2015 = 1 and status <>'C'";
    	$rs = $this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$ftotal = $row->TOTAL;
    	$fsubTotal= $row->SUBTOTAL;
    	$fiva = $row->IVA;

    	$ventaTotal= $ftotal;
    	}else{
    		$this->query="SELECT SUM(IMPORTE) as TOTAL, sum(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA 
    				  FROM FACTF01 
    				  WHERE extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
    	$rs = $this->QueryObtieneDatosN();
    	$row = ibase_fetch_object($rs);
    	$ftotal = $row->TOTAL;
    	$fsubTotal= $row->SUBTOTAL;
    	$fiva = $row->IVA;

    	$this->query="SELECT SUM(IMPORTE) as total, SUM(CAN_TOT) AS SUBTOTAL, SUM(IMP_TOT4) AS IVA
    				  FROM FACTD01 
    				  WHERE extract(month from fechaelab) = $mes and extract(year from fechaelab) = $anio and status <>'C'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$nctotal = $row->TOTAL;
    	$ncsubtotal = $row->SUBTOTAL;
    	$nciva=$row->IVA;

    	$ventaTotal= $ftotal - $nctotal;	
    	}
    	
    	//echo '---'.number_format($ftotal,2);
    	//echo '---'.number_format($nctotal,2);
    	//echo '---'.number_format($ventaTotal,2);
    	//break;
    	return $ventaTotal;
    }

    function serieFAA($mes, $vend, $anio){

    	if($anio == 99){
    		$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE deuda2015 = 1 and status <>'C' and serie = 'A'";
	    	$rs=$this->QueryObtieneDatosN();
	    	while($tsArray= ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}
    	}else{
	    	$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE EXTRACT(MONTH FROM FECHAELAB) = $mes  and extract(year from fechaelab) = $anio and status <>'C' and serie = 'FAA'";
	    	$rs=$this->QueryObtieneDatosN();
	    	while($tsArray= ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}	
    	}
    	
    	return @$data;
    }

	function serieG($mes, $vend, $anio){

		if($anio == 99){
				$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE deuda2015=1 and status <>'C' and serie = 'G'";
	    	$rs=$this->QueryObtieneDatosN();
	    	while($tsArray= ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}
		}else{
				$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE EXTRACT(MONTH FROM FECHAELAB) = $mes  and extract(year from fechaelab) = $anio and status <>'C' and serie = 'G'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray= ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}	
		}
    	
    	return @$data;
    }

	function serieE($mes, $vend, $anio){

		if($anio == 99){
			$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE deuda2015 = 1 and status <>'C' and serie = 'E'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray= ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
		}else{
			$this->query = "SELECT sum(CAN_TOT) AS SUBTOTAL, sum(IMP_TOT4) AS  iva , sum(IMPORTE) AS TOTAL FROM FACTF01 WHERE EXTRACT(MONTH FROM FECHAELAB) = $mes  and extract(year from fechaelab) = $anio and status <>'C' and serie = 'E'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray= ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}	
		}
    	
    	return @$data;
    }

    function traeVendedores(){
    	$this->query ="SELECT * FROM vend01";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function traeOC($campo){
    	$this->query ="SELECT oc.*, p.nombre 
    					FROM COMPO01 oc
    					left join prov01 p on oc.cve_clpv = p.clave
    					WHERE upper(oc.CVE_DOC) CONTAINING upper('$campo')";
    	//echo $this->query ;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function procesarOC($doco, $idb, $fechaedo, $montof, $factura, $tpf){

    	$usuario = $_SESSION['user']->NOMBRE;

    	$this->query="UPDATE COMPO01 SET 
    		BANCO = '$idb', 
    		edocta_fecha = '$fechaedo', 
    		edocta_reg = current_timestamp, 
    		usuario_recibe = '$usuario', 
    		edocta_status = 'I',
    		monto_final = $montof,
    		factura_proveedor = '$factura'
    		where CVE_DOC = '$doco'";

    		echo $this->query;
       	$rs = $this->EjecutaQuerySimple();
    	return $rs;  
    }

    function deudores(){
    	$this->query = "SELECT D.*, iif(P.NOMBRE is null, 'NO IDENTIFICDO', P.NOMBRE) AS NOMBRE 
    						FROM DEUDORES D
    						LEFT JOIN PROV01 P ON P.CLAVE = D.PROVEEDOR 
    						WHERE APLICADO = 0";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

     function verProveedores(){
    	$this->query="SELECT p.*, b.banco as bancosat FROM PROV01 p left join bancos_sat b on b.clave = p.banco where STATUS = 'A'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }


    function LayOutCargaProv(){
    	$this->query="SELECT * FROM PROV01 where STATUS = 'A'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	$i=0;
    	$e=0;
    	$b=0;
    	foreach ($data as $key) {
    	
    		if(empty($key->BBVA_ALTA) or $key->BBVA_ALTA == 0){
	    		$cuenta=$key->CUENTA_BANCO;
	    		$banco = $key->BANCO;
	    		$clabe = $key->CLABE;
	    		$cuentaOK = 0;
	    		$cve_prov =$key->CLAVE;
	    		$correo = $key->PAG_WEB;
	    		if(empty($correo)){
	    			$correo='ferreterapegaso@hotmail.com';
	    		}
	    		if($banco == 12 and strlen($cuenta) == 10 ){
	    			$cuentaOK=$cuenta;
	    		}elseif($banco<>12 and strlen($clabe) > 10 ){
	    			$cuentaOK=$clabe;
	    		}

	    		if(strlen($cuentaOK) > 12){
	    			$i++;
	    			$nombre=str_pad(substr($key->NOMBRE,0,30),30," ");
	    			$ctabbva = str_pad($cuentaOK, 18, 0, STR_PAD_LEFT);
	    			$alias = str_pad(substr(trim($cve_prov).'_'.$nombre,0,30),30," ");
	    			$correo = str_pad(trim($correo),80," ");
	    			$file = fopen("app/LayoutBBVA/Alta/archivo_clabe.txt", "a");
					fwrite($file, substr($ctabbva,0,3).$ctabbva."MXP"."0000004999999.00".$nombre.$alias.'40'.$correo.PHP_EOL);
					fclose($file);
					$this->query="UPDATE PROV01 SET BBVA_ALTA = 1 WHERE CLAVE = $cve_prov";
					$this->EjecutaQuerySimple();
	    		}elseif(strlen($cuentaOK) == 10 ){
	    			$b++;
	    			$nombre=str_pad(substr($key->NOMBRE,0,30),30," ");
	    			$ctabbva = str_pad($cuentaOK, 18, 0, STR_PAD_LEFT);
	    			$alias = str_pad(substr(trim($cve_prov).'_'.$nombre,0,30),30," ");
	    			$correo = str_pad(trim($correo),80," ");
	    			$file = fopen("app/LayoutBBVA/Alta/archivo_bbva.txt", "a");
					fwrite($file, $ctabbva."MXP"."0000004999999.00".$nombre.$alias.$correo.PHP_EOL);
					fclose($file);
					$this->query="UPDATE PROV01 SET BBVA_ALTA = 1 WHERE CLAVE = $cve_prov";
					$this->EjecutaQuerySimple();
	    		}else{
	    			$e++;
					$this->query="UPDATE PROV01 SET BBVA_ALTA = 0 WHERE CLAVE = $cve_prov";
					$this->EjecutaQuerySimple();
	    		}
    		}
    	}

    	echo 'Se creo un nuevo Archivo para alta de proveedores, cuenta BBVA con '.$b.' proveedores y con Clabe Interbancaria '.$i.' proveedores, hay '.$e.' Proveedores con error en las cuentas.';
    	return $layout = array('BBVA'=>$b, 'Clabe'=>$i, 'Faltante'=>$e);
    }

    function guardaDeudor($fechaedo, $monto,$proveedor, $banco, $tpf, $referencia, $destino){

    	$usuario=$_SESSION['user']->NOMBRE;
    	$this->query="INSERT INTO DEUDORES (PROVEEDOR, FECHAEDO_CTA, FECHAELAB, IMPORTE, BANCO, TIPO, REFERENCIA, CUENTA_DESTINO, USUARIO)
    				VALUES ('$proveedor', '$fechaedo', current_timestamp, $monto, '$banco', '$tpf', '$referencia', '$destino','$usuario')";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }

    function transferyprestamo($fechaedo, $bancoO){
    	$this->query = "SELECT * FROM DEUDORES WHERE tipo_deudor = 'Transferencia' or tipo_deudor = 'Prestamo'";
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function guardaTransPago($fechaedo, $monto, $bancoO, $bancoD, $tpf, $TT, $referencia){

    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query = "INSERT INTO DEUDORES (FECHAEDO_CTA, FECHAELAB, IMPORTE, BANCO, TIPO, REFERENCIA, CUENTA_DESTINO, USUARIO, TIPO_DEUDOR)
    					VALUES('$fechaedo', current_timestamp, $monto, '$bancoO', '$tpf', '$referencia', '$bancoD', '$usuario', '$TT')";
    	//echo $this->query;
    	$rs=$this->EjecutaQuerySimple();

    	$user = $_SESSION['user']->NOMBRE;

    	$this->query = "INSERT INTO CARGA_PAGOS (ID, CLIENTE, FECHA, MONTO, SALDO, USUARIO, BANCO, FECHA_APLI,FECHA_RECEP, FOLIO_X_BANCO, STATUS, CF, FOLIO_ACREEDOR, TIPO_PAGO, REGISTRO, poliza_ingreso, APLICACIONES)values(null, 'N/A', current_timestamp, $monto, 0, '$user', '$bancoD', current_timestamp, '$fechaedo', 'TR', '','',0, 'oTEC',0,'',0)";

    	//echo $this->query;
    	//break;

   		$rs= $this->EjecutaQuerySimple();


    	return $rs;
    }

    function facturapagomaestro($maestro){
    	$this->query="SELECT f.cve_doc, cl.nombre, f.fechaelab, f.importe, f.aplicado, f.saldofinal as saldo, f.id_pagos, f.id_aplicaciones, f.importe_nc, f.nc_aplicadas , f.FECHA_VENCIMIENTO, datediff(day, f.FECHA_VENCIMIENTO, current_date) as dias
    			from factf01 f 
    			left join clie01 cl on cl.clave = f.cve_clpv 
    			where f.cve_maestro = '$maestro' 
    			and (deuda2015 <> 99 or deuda2015 is null)
    			and saldofinal > 3
    			order by datediff(day, f.FECHA_VENCIMIENTO, current_date) desc";
    	//echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function factura($docf){
    	$this->query="SELECT f.*, cl.nombre, cl.rfc 
    				FROM FACTF01 f 
    				left join clie01 cl on f.cve_clpv = cl.clave 
    				WHERE CVE_DOC = '$docf'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traePagoMaestro($maestro){
    	$this->query="SELECT ID, FOLIO_X_BANCO, monto, saldo, fecha_recep, banco, usuario, fecha  FROM CARGA_PAGOS WHERE SALDO > 3 and Status <> 'C' and tipo_pago is null";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traeMaestros(){
    	$this->query="SELECT * FROM MAESTROS";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }


    function calendarioCxC($cartera){
    	 
    	 switch (date('w')){
                case '0':
                    $dia = 'D';
                    break;
                case '1':
                    $dia = 'L';
                    break;
                case '2':
                    $dia = 'MA';
                    break;
                case '3':
                    $dia = 'MI';
                    break;
                case '4':
                    $dia = 'J';
                    break;
                case '5':
                    $dia = 'V';
                    break;
                case '6':
                    $dia = 'S';
                    break;
                default:
                    break;                  
            }
    	$this->query="SELECT c.id, c.cc, f.cve_doc, f.saldofinal, f.fecha_vencimiento, c.contrarecibo, c.contrarecibo_cr, c.factura, f.fecha_vencimiento, cl.nombre as cliente, f.importe
		        from cajas c
		        left join factf01 f on f.cve_doc = c.factura
		        left join clie01 cl on cl.clave = f.cve_clpv
		        where cc= 'CCA'
		            and c.factura is not null
		            and factura != ''
		            and c.contrarecibo_cr is not null
		            and f.saldofinal > 5
		            and c.dias_pago containing('$dia')";
		$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}	
    	return $data;
    }

    function totalSemanaCalendar($cartera){
    	$this->query="SELECT sum(f.saldofinal) as totalsemana
                        from cajas c
                        left join factf01 f on f.cve_doc = c.factura  
                        where c.cc = '$cartera'
                        and f.saldofinal > 5
                        and f.fecha_vencimiento >= current_date
                        and (c.docs_cobranza = 'Si')";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $totsemana = $row->TOTALSEMANA;
        return $totsemana;
    }

    function totalesCanlendar($cartera){
    	$this->query="SELECT sum(f.saldofinal) as total
                        from cajas c
                        left join factf01 f on f.cve_doc = c.factura  
                        where c.cc = '$cartera'
                        and f.saldofinal > 5
                        and c.docs_cobranza = 'Si'";
        $rs=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($rs);
        $totcartera = $row->TOTAL;

        return $totcartera;
    }

    function saldoIndMaestro($cve_maestro){
    	$this->query = "SELECT * FROM MAESTROS WHERE CLAVE = '$cve_maestro'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
		return $data;    	
    }

    function obtieneMaestro($docf){
    	$this->query="SELECT CVE_MAESTRO FROM FACTF01 WHERE CVE_DOC = '$docf'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$maestro =$row->CVE_MAESTRO;

    	return $maestro;
    }

    function saldoVCD(){
    	$this->query="SELECT ca.CC,ca.dias_pago, iif(SUM(f.SALDOFINAL) is null, 0, sum(f.saldofinal)) as total
    				FROM CAJAS ca
    				LEFT JOIN FACTF01 f ON ca.factura = f.cve_doc
    				where f.fecha_vencimiento >= current_date
    				GROUP BY ca.CC, ca.dias_pago";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function saldoCD(){
    	$this->query="SELECT ca.CC,ca.dias_pago, iif(SUM(f.SALDOFINAL) is null, 0, sum(f.saldoFinal)) as total
    				FROM CAJAS ca
    				LEFT JOIN FACTF01 f ON ca.factura = f.cve_doc
    				where f.saldofinal > 5 and f.fecha_vencimiento is not null
    				GROUP BY ca.CC, ca.dias_pago";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function saldoVCDMultiple(){
    	$this->query="SELECT ca.cc, sum(saldofinal) as sm from cajas ca left join factf01 f on ca.factura = f.cve_doc 
    		where f.saldofinal > 5 and char_length(dias_pago) > 3 and f.fecha_vencimiento >= current_date group by ca.cc";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function saldoCDMultiple(){
    	$this->query="SELECT ca.cc, sum(saldofinal) as sm from cajas ca left join factf01 f on ca.factura = f.cve_doc 
    		where f.saldofinal > 5 and char_length(dias_pago) > 3 and f.fecha_vencimiento is not null group by ca.cc";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;	
    }

    function actStatusVencimiento(){
    	$this->query="SELECT CVE_DOC, datediff(DAY, FECHA_VENCIMIENTO, CURRENT_DATE) as dias_vencido FROM FACTF01 WHERE SALDOFINAL > 5 AND DATEDIFF(DAY, FECHA_VENCIMIENTO, CURRENT_DATE) >=1 AND ACT_DIA is null";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	if(isset($data)){
    		foreach ($data as $key) {
    		$docf = $key->CVE_DOC;
    		$dv = $key->DIAS_VENCIDO;
    		if($dv >= 1 and $dv <= 7){
    			$valor = 1;
    		}elseif ($dv >=8 and $dv <= 14){
    			$valor = 2;
    		}elseif ($dv >=15 and $dv <= 21){
    			$valor = 3;
    		}elseif ($dv >=22 and $dv <= 28){
    			$valor = 4;
    		}elseif ($dv >=29 and $dv <= 35){
    			$valor = 5;
    		}elseif ($dv >=36 and $dv <= 42){
    			$valor = 6;
    		}elseif ($dv >=43 and $dv <= 49){
    			$valor = 7;
    		}elseif ($dv >=50 and $dv <= 56){
    			$valor = 8;
    		}elseif ($dv >=57 and $dv <= 63){
    			$valor = 9;
    		}else{
    			$valor = 10;
    		}

    		$this->query="UPDATE factf01 set act_dia = 1, STATUS_VENCIMIENTO = $valor where cve_doc = '$docf'";
    		$rs=$this->EjecutaQuerySimple();
    		}	
    	}
    }

    function verMaestros($cartera){

    	/// Actualizamos la informacion antes de presentarla

    		$this->query="UPDATE MAESTROS SET  sucursales = 0 , limite_global = 0, saldo_2016 = 0, saldo_2017= 0, CANCELADA=0, COBRANZA=0, LOGISTICA=0 , REVISION=0 , PAGADA=0, acreedor = 0";
    		$rs=$this->EjecutaQuerySimple();
    			$this->query="SELECT clave from maestros";
    			$rs=$this->EjecutaQuerySimple();
    			while($tsArray=ibase_fetch_object($rs)){
    				$datos[] = $tsArray;
    			}
    			foreach ($datos as $d) {
    				$this->query="SELECT COUNT(CLAVE) as SUC, SUM(limcred) as Limite FROM CLIE01 WHERE CVE_MAESTRO = '$d->CLAVE' and status <> 'S' and status <> 'B'";
    				$rs=$this->EjecutaQuerySimple();
    				$row = ibase_fetch_object($rs);
    				$suc = $row->SUC;
    				$limite =$row->LIMITE;

    				if(empty($suc)){
    					$suc = 0;
    				}
    				if(empty($limite)){
    					$limite = 0;
    				}

    				$this->query="UPDATE MAESTROS SET SUCURSALES = $suc, limite_global = $limite where clave = '$d->CLAVE'";
    				$rs=$this->EjecutaQuerySimple();

    			}

/// Se cambia a la tabla de control de Facturas /// 
    	   	$this->query=" SELECT cve_maestro, status_fact, sum(saldofinal) as monto
        	from factf01
        	where extract(year from fecha_doc) >= 2016
        	group by cve_maestro, status_fact";
        	$rs=$this->EjecutaQuerySimple();
		        	while($tsArray=ibase_fetch_object($rs)){
		        		$data2[]=$tsArray;
		        	}
		        	foreach ($data2 as $key) {
		        		$campo = $key->STATUS_FACT;
		        		$maestro = $key->CVE_MAESTRO;
		        		$monto = $key->MONTO;
		        		if(empty($campo)){
		        			$campo = 'No_Identificadas';
		        		}elseif ($campo == 'nuevo') {
		        			$campo = 'Logistica';
		        		}
		        		$this->query="UPDATE MAESTROS SET $campo = $monto where clave = '$maestro'";
		        		$rds=$this->EjecutaQuerySimple();
		        		//echo 'Consulta :'.$this->query.'<p>';
		        	}

		    ///// Actualiza Acreedor /// 
        	$this->query="SELECT cve_maestro, sum(saldo) as monto FROM CARGA_PAGOS WHERE STATUS <> 'C' AND TIPO_PAGO IS 
        		NULL group by cve_maestro";
        	$rs = $this->EjecutaQuerySimple();

        	while($tsArray=ibase_fetch_object($rs)){
        		$data3[]=$tsArray;
        	}
        	foreach ($data3 as $key2) {
        		$montoa = round($key2->MONTO,2);
        		$this->query="UPDATE MAESTROS SET ACREEDOR = $montoa where clave = '$key2->CVE_MAESTRO'";        		
        		//echo 'Maestro, '.$key2->CVE_MAESTRO.', MONTO ,'.$montoa.'<P>';
        		$rs=$this->EjecutaQuerySimple();
        	}
        	///// Actualizamos los saldos por año
        			/// Modificacion de consulta
		        	// Original:  $this->query="SELECT clave_maestro as clave, anio, sum(saldofinal) as saldo from facturas group by clave_maestro, anio";
		        
        			$this->query="SELECT cve_maestro as clave, extract(year from fecha_doc ) as anio, sum(saldofinal) as saldo
							    from factf01
							    where extract(year from fecha_doc) >= 2016
							    group by cve_maestro, extract(year from fecha_doc)";
		        	$rs=$this->EjecutaQuerySimple();

		        	while($tsArray=ibase_fetch_object($rs)){
		        		$data4[]=$tsArray;
		        	}

		        	foreach ($data4 as $key) {
		        		$maestro = $key->CLAVE;
		        		$anio = $key->ANIO;
		        		$campo = 'saldo_'.$anio; 
		        		$saldo = $key->SALDO;

		        		$this->query="UPDATE MAESTROS SET $campo= $saldo where clave = '$maestro'";
		        		$rs=$this->EjecutaQuerySimple();	
		        	}
        	//// Finalizamos la actualizacion. 
    	if($cartera = 99){
    		$this->query="SELECT M.*, 
    						(select count(cm.id) from maestros_ccc cm where cm.CVE_MAESTRO = m.clave) as CCS,
    						(select sum(PRESUPUESTO_mensual) from maestros_ccc cm where cm.CVE_MAESTRO = m.clave ) as TOTCCS
    						FROM MAESTROS M";
    	$rs=$this->QueryObtieneDatosN();
    	}else{
    		$this->query="SELECT * FROM MAESTROS where cartera in ('$cartera')";
    	$rs=$this->QueryObtieneDatosN();	
    	}

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	
    	return $data;
    }


    function editarMaestro($idm){
    	$this->query="SELECT * FROM MAESTROS WHERE ID = $idm";
    	$rs=$this->QueryObtieneDatosN();
    	$data[]=ibase_fetch_object($rs);
    	//var_dump($data);
    	return $data;
    }

    function traeCCC($idm){
    	$this->query="SELECT * FROM MAESTROS_CCC WHERE ID_MAESTRO = $idm";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function editaMaestro($idm, $cr, $cc){
    	if(count($cr)){
    		$cr = implode(",", $cr);	
    	}
    	if(count($cc)){
    		$cc = implode(",",$cc);	
    	}
    	$this->query="UPDATE MAESTROS SET CARTERA ='$cr', CARTERA_REVISION = '$cc' where id=$idm";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }

    function altaMaestro($nombre){
    	/*if(count($cr)){
    		$cr = implode(",", $cr);	
    	}
    	if(count($cc)){
    		$cc = implode(",",$cc);	
    	}*/

    	$this->query ="SELECT max(CLAVE) as CLAVE FROM MAESTROS WHERE upper(SUBSTRING(CLAVE FROM 1 FOR 3)) = upper(SUBSTRING('$nombre' from 1 for 3))";
    	echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	$row= ibase_fetch_object($rs);

    	if(empty($row->CLAVE)){
    		$clave=substr($nombre, 0,3);
    		$clave= $clave.'1';
    	}else{	
    		$consecutivo=substr($row->CLAVE, 3,5);
    		$clave=substr($nombre, 0,3);
    		$consecutivo = $consecutivo + 1;
    		$clave = $clave.'-'.$consecutivo;
    	}

    	$this->query="INSERT INTO MAESTROS (clave,nombre) VALUES (UPPER('$clave'),'$nombre')";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;	
    } 


    function rastreadorFacturas($docf){
    	$this->query="SELECT f.cve_doc, cl.nombre, f.fechaelab, f.importe, f.saldofinal, f.status, iif(c.fecha_secuencia is null, 'Sin Fecha',c.fecha_secuencia) as fecha_secuencia, iif(c.fecha_rev is null, 'Sin Fecha', c.fecha_rev) as fecha_rev, iif(c.fecha_rec_cobranza is null, 'Sin Fecha', c.fecha_rec_cobranza) as fecha_rec_cobranza
    				  from factf01 f
    				  left join cajas c on c.factura = f.cve_doc
    				  left join clie01 cl on cl.clave = f.cve_clpv
    				  where f.cve_doc containing ('$docf') ";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    } 


    function verCierreCob(){
    	$this->query="SELECT a.documento, a.idpago, a.monto_aplicado, a.fecha, f.importe, round(f.saldofinal,2) as saldoFinal, f.fechaelab, cp.banco, cp.fecha_recep, cp.FOLIO_X_BANCO, cl.nombre, a.id 
    				 from aplicaciones a 
    				 left join factf01 f on f.cve_doc = a.documento
    				 left join clie01 cl on cl.clave = f.cve_clpv
    				 left join carga_pagos cp on cp.id = a.idpago 
    				 where a.folio_rec_conta = 0 and cierre_cc != 0";
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function recDocCierreCob($idp, $fecha){
    	$usuario = $_SESSION['user']->NOMBRE;

    	/*$this->query="SELECT max(folio_rec_conta) as FOLIO from aplicaciones";
    	$result=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($result);
    	$folio = $row->FOLIO + 1;
    	//echo $folio;

    	$this->query = "UPDATE APLICACIONES SET usuario_rec_conta = '$usuario', fecha_rec_conta = current_timestamp, folio_rec_conta = $folio, cierre_cc = 1 where id =$ida";
    	$rs=$this->EjecutaQuerySimple();
    	//echo $this->query;
    	*/

    	$this->query="UPDATE CARGA_PAGOS SET CIERRE_CONTA = 2, fecha_conta = current_timestamp, fecha_recep = '$fecha', usuario_conta = '$usuario', MONTO_ACREEDOR = saldo, saldo = 0 WHERE ID = $idp";
    	$rs=$this->EjecutaQuerySimple();
    	return $rs;
    }

    function saldoCartera(){
    	$this->query="SELECT min(c.factura), sum(f.saldofinal) as valor , min(f.cve_maestro), m.cartera_revision
		    from cajas c
		    left join factf01 f on f.cve_doc = c.factura
		    left join maestros m on m.clave = f.cve_maestro
		    where c.fecha_rev is null
		    and factura is not null
		    and factura != ''
		    and f.saldofinal > 2
		    group by m.cartera_revision";

    $rs=$this->QueryObtieneDatosN();

	    while($tsArray=ibase_fetch_object($rs)){
	    	$data[]=$tsArray;
	    }

    return @$data;
    
    }


    function revisaNegativos(){
    	$this->query="SELECT cve_doc as docf from factf01 where saldofinal < -1";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key) {
    		$this->query="SELECT SUM(MONTO_APLICADO) as monto FROM APLICACIONES WHERE DOCUMENTO = '$key->DOCF' and cancelado = 0 ";
    		$rs=$this->QueryObtieneDatosN();
    		$row=ibase_fetch_object($rs);
    		$aplicado = $row->MONTO;

    		$this->query = "UPDATE FACTF01 SET APLICADO = $aplicado where cve_doc = '$key->DOCF'";
    		$rs=$this->EjecutaQuerySimple();

    	echo 'Se acutlizo el monto aplicado de la factura: ,'.$key->DOCF." ,con un importe de : ,".$aplicado.", ;";
    	}

    	return "ok";
    }
    
    function aplicaNC(){
    	$this->query="SELECT cve_doc AS docf, nc_aplicadas as docd from factf01 where saldofinal < -1 and importe_nc > 0";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key){
    		$this->query="SELECT importe as monto from factd01 where cve_doc  = '$key->DOCD' and status <> 'C'";
    		$rs=$this->QueryObtieneDatosN();
    		$row=ibase_fetch_object($rs);
    		$ncaplicado = $row->MONTO;
    		//echo $ncaplicado;
    		//echo $this->query;
    		$this->query="UPDATE factf01 set importe_nc = $ncaplicado where cve_doc = '$key->DOCF'";
    		$rs=$this->EjecutaQuerySimple();
    		//echo $this->query;
    		echo "--- Se Actualizo el monto de la factuta: ".$key->DOCF." , El nuevo importe de la NC es de: , ".$ncaplicado.", ;";
    		//break;
    	}
    }

    function cancelarAplicacion(){
    	$this->query = "SELECT ID_APLICACIONES AS IDA, cve_doc as docf, nc_aplicadas as NC FROM FACTF01 WHERE SALDOFINAL < -1 AND IMPORTE_NC > 0 
    	and not id_aplicaciones containing (',')
    	and id_aplicaciones != ''";
    	$rs = $this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    		# code...
    	}

    	foreach ($data as $key) {    		
    		$this->query="UPDATE aplicaciones set cancelado = 1, observaciones = 'Cancelado por NC: '||'$key->NC' where id = $key->IDA";
    		$r=$this->EjecutaQuerySimple();
    		if($rs){
    			/// Desaplicamos el pago de la factura
    			$this->query="UPDATE FACTF01 SET ID_APLICACIONES='', APLICADO = 0, saldofinal = importe - importe_nc WHERE CVE_DOC = '$key->DOCF'";
    			$res = $this->EjecutaQuerySimple();
    			if($res){
    				echo '-> Se cancelo la aplicacion: '.$key->IDA.' por la Nota de Credito : '.$key->NC.' de la factura: '.$key->DOCF; 
    			}else{
    				echo '<--> Problema al desaplicar la aplicacion: '.$key->IDA.' por la Nota de Credito : '.$key->NC.' de la factura: '.$key->DOCF;
    			}	

    		}
    	}
    }

  function liberarPedido($docd){
    	$this->query="SELECT TRIM(DOC_ANT) as doc_ant, PEDIDO_LIBERADO FROM FACTD01 WHERE CVE_DOC = '$docd' and liberada is null";
    	$rs=$this->QueryObtieneDatosN();
    	$val = ibase_fetch_object($rs);
    	$p = 'A';
    	//break;
    	if(!empty($val)){
    		//echo 'entro a cambiar la variable';
    		$p = $val->PEDIDO_LIBERADO;
    	}
	
		if(!empty($val) and substr($p,0,1) == 'P'){
    		return 'Ya liberado desde la facturacion';
    	}elseif(!empty($val) and substr($p, 0,1) == 0){
			$docant = $val->DOC_ANT;    		
    		$this->query="SELECT DOC_ANT as pedido, DOC_SIG as factura FROM FACTR01 WHERE CVE_DOC = '$val->PEDIDO_LIBERADO'";
    		$rs=$this->QueryObtieneDatosN();
    		$row=ibase_fetch_object($rs);
    		$docp = $row->PEDIDO;
    		$docf = $row->FACTURA;
    	}else{
    		//echo '<label> La Nota de Credito: '.$docd.', Ya fue liberada con Anterioridad o no Existe, favor de revisar la informacion.</label>';
    		return '<label style="color: red; font-weight: bold; font-size:30px;"> La Nota de Credito: '.$docd.', Ya fue liberada con Anterioridad o no Existe, favor de revisar la informacion.</label>';
    	}

    		if(substr($docant, 0, 3) == 'FAA'){
    			$this->query="SELECT trim(DOC_ANT) as pedido FROM FACTF01 WHERE CVE_DOC ='$docant'";
    			$rs=$this->QueryObtieneDatosN(); 
    			$row=ibase_fetch_object($rs);

    			if($row == true){
    				$docp = $row->PEDIDO;
    				
    				if(substr($docp, 0,1) =='P'){
	    				$this->query="UPDATE FACTP01 SET doc_sig = null, tip_doc_sig = null, tip_doc_e = null, enlazado = null, nc_aplicada = iif(nc_aplicada is null, '$docd', (nc_aplicada||'$docd')) where cve_doc = '$docp'";
	    				$rs=$this->EjecutaQuerySimple();	

	    				$this->query = "SELECT CANT, NUM_PAR, CVE_ART FROM PAR_FACTD01 WHERE CVE_DOC ='$docd'";
	    				$rs = $this->QueryObtieneDatosN();

	    				$this->query = "UPDATE PAR_FACTP01 SET PARTIDA_NC=NULL WHERE CVE_DOC = '$docp' ";
	    				$result = $this->EjecutaQuerySimple();

		    				while($tsArray=ibase_fetch_object($rs)){
		    					$data[]=$tsArray;
		    				}
		    				foreach ($data as $key) {
		    					$this->query="UPDATE par_factp01 set pxs = pxs + $key->CANT, partida_nc= $key->NUM_PAR where cve_doc = '$docp'
		                    		and cve_art = '$key->CVE_ART'
		                    		and partida_nc is null";
		                    	$rs=$this->EjecutaQuerySimple();
		    					}
		    				$this->query="UPDATE FACTD01 SET PEDIDO_LIBERADO = '$docp', LIBERADA = 'Si' where cve_doc = '$docd' ";
		    				$rs=$this->EjecutaQuerySimple();

    				}elseif(substr($docp, 0,1) == 0){  /// AQUI ENTRA SI ES UNA REMISION.

    					$this->query="SELECT DOC_ANT as pedido, DOC_SIG AS FACT FROM FACTR01 WHERE trim(CVE_DOC) ='$docp'";
    				    $rs=$this->QueryObtieneDatosN();
    				    $rowp=ibase_fetch_object($rs);
		    		//echo 'Esto es una remision'.'<p>';	 
    				//echo $this->query;
		    				if($rowp == true){
			    				$docpo = $rowp->PEDIDO;
			    				$docant = $rowp->FACT;
			    				//echo $docp;
			    				//break;
			    				$this->query="UPDATE FACTP01 SET doc_sig = null, tip_doc_sig = null, tip_doc_e = null, enlazado = null, nc_aplicada = iif(nc_aplicada is null, '$docd', (nc_aplicada||','||'$docd')) where cve_doc = '$docpo'";
			    				$rs=$this->EjecutaQuerySimple();	
			    				//echo $this->query;
			    				$this->query = "SELECT CANT, NUM_PAR, CVE_ART FROM PAR_FACTD01 WHERE CVE_DOC ='$docd'";
			    				$rs = $this->QueryObtieneDatosN();

			    				//echo $this->query;
				    				while($tsArray=ibase_fetch_object($rs)){
				    					$data[]=$tsArray;
				    					}

				    				foreach ($data as $key) {
				    					$this->query="UPDATE par_factp01 set pxs = pxs + $key->CANT, partida_nc= $key->NUM_PAR where cve_doc = '$docpo'
				                    		and cve_art = '$key->CVE_ART'";
				                    		//echo $this->query;
				                    	$rs=$this->EjecutaQuerySimple();
		    							}
		    				$this->query="UPDATE FACTD01 SET PEDIDO_LIBERADO = iif(pedido_liberado is null or pedido_liberado = '', '$docpo', (pedido_liberado ||', '||'$docpo')), LIBERADA = 'Si' where cve_doc = '$docd' ";
		    				$rs=$this->EjecutaQuerySimple();

		    				$this->query="UPDATE CAJAS SET OBSERVACIONES = iif(observaciones is null or observaciones = '', '$docant', observaciones||', '||'$docant'), factura = '', cve_fact = '$docpo', remision='$docp' where factura = '$docant' or (cve_fact = '$docpo' and trim(remision) = '$docp')";
		    				$rs =$this->EjecutaQuerySimple();

		    				//echo 'ACTUALIZA PARA EVITAR DOBLE DESBLOQUE:'.'<p>';
		    				//echo $this->query;

    						}
    				}
		    	}
		    }
		    return	'<label style="color: blue; font-weight: bold; font-size:30px;"> La Nota de Credito: '.$docd.', Ha liberado al pedido '.$docpo.' y la factura '.$docant.'</label>';
    	//return 'hecho --'.$docd.' --- '.$docp.' --- '.$docant;
    }


    function actualizaCanti($cantn, $idpreoc){
    	$this->query="UPDATE PREOC01 SET CANTI = $cantn, obs = '$idpreoc' where id = $idpreoc";
    	$rs=$this->EjecutaQuerySimple();
    	
    	echo $this->query;
    	//break;
    	return 1;
    }

    function colocarUrgencia($docp){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="UPDATE preoc01 SET urgente = 'U' where cotiza = '$docp'";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query ="UPDATE FACTP01 SET URGENCIA = 'U' WHERE CVE_DOC = '$docp'";
    	$res= $this->EjecutaQuerySimple();
    	if($rs and $res){
    		$this->query="INSERT INTO LOG_PEDIDOS_URGENTES (USUARIO, FECHA, PEDIDO, PROCESADO) VALUES ('$usuario', current_timestamp, '$docp', 'ok')";
    		$result=$this->EjecutaQuerySimple();	
    	}
    	return 'Se coloco como urgencia el pedido: '.$docp.'.'; 
    }

    function reEnrutarCaja($docp, $docf){
    	$usuario = $_SESSION['user']->NOMBRE ;
    	$this->query=" UPDATE CAJAS SET aduana = null, ruta = 'N', status='cerrado', vueltas = vueltas + 1, logistica = iif(logistica is null, 'Utilerias',(logistica||'-'||'Utilerias'				)), unidad = null, fecha_secuencia = null, idu = null, DOCS = 'N', cierre_uni = null, cierre_tot = null, fletera = null, guia_fletera = null, status_log = 'nuevo', secuencia = null, fecha_aduana = current_timestamp, usuario_aduana ='$usuario', reenvio = 'Si', IMP_COMP_REENRUTAR = 'No' 
                        where
                        cve_fact = ('$docp')
                        AND FACTURA = ('$docf')";
        $rs=$this->EjecutaQuerySimple();

        $this->query = "SELECT VUELTAS FROM CAJAS WHERE CVE_FACT ='$docp' and factura='$docf'";
        $result=$this->QueryObtieneDatosN();
        $row=ibase_fetch_object($result);
        $vueltas = $row->VUELTAS;


        if($rs){
        	$this->query = "INSERT into LOG_REENRUTAR_FACTURAS (USUARIO, FECHA, PEDIDO, FACTURA, VUELTAS, PROCESADO) VALUES ('$usuario', current_timestamp, '$docp', '$docf', $vueltas, 'ok')";
        	$res = $this->EjecutaQuerySimple();
        } 

        if($rs and $res){
        	return 'Se ha re-enrutado el pedido '.$docp.' con el numero de factura '.$docf.', con un numero total de vueltas de '.$vueltas.' Favor de Verificar los datos con Logistica.';
        }else{
        	return 'No se ha podido re-enrutar el pedido '.$docp.' con el numero de factura '.$docf.', favor de revisar los datos y volver a intentar';	
        }   
        	
    }

    function datosPreoc($docp,$docf){
    	$cveart = $docf;

    	$this->query = "SELECT first 1 id, prod, nomprod, cotiza  FROM PREOC01 WHERE COTIZA = '$docp' and  prod = '$cveart'";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }
    function datosInv($docp, $docf){
    	$cveart = $docf;
    	$this->query="SELECT CAMPLIB7 FROM INVE_CLIB01 WHERE CVE_PROD = '$cveart'";
    	$rs = $this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	
    	return @$data;
    }


    function rfcCliente($idp, $ida, $docf){
    	$this->query="SELECT f.*, cl.nombre, cl.rfc, extract(month from fecha_doc) as mes, extract(year from fecha_doc) as anio FROM FACTF01 f left join clie01 cl on cl.clave = f.cve_clpv WHERE CVE_DOC = '$docf'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);  	
    	return $row;

    }

    function actSAEVenta($idp, $ida, $docf){

    	$this->query= "UPDATE APLICACIONES SET CONTABILIZADO = 'OK' WHERE ID = $ida";
    	$rs = $this->EjecutaQuerySimple();

    	$this->query="UPDATE FACTF01 set contabilizado = 'OK' where cve_doc = '$docf'";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="SELECT COUNT(id) as contabilizados FROM APLICACIONES where contabilizado = 'OK' and idpago =$idp and  cancelado = 0  and procesado = 1 ";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$contabilizados = $row->CONTABILIZADOS;

    	$this->query="SELECT COUNT(id) as porContabilizar from aplicaciones where idpago = $idp and cancelado = 0 and procesado = 1 " ;
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$porContabilizar = $row->PORCONTABILIZAR;

    	/// Actualizamos carga pagos:
    	if($contabilizados == $porContabilizar){
    		$this->query="UPDATE CARGA_PAGOS SET CONTABILIZADO = 'Total' WHERE ID = $idp";
    		$rs=$this->EjecutaQuerySimple();

    	}elseif ($contabilizados > 0 ){
    		$this->query="UPDATE CARGA_PAGOS SET CONTABILIZADO = 'Parcial' where id = $idp";
    		$rs = $this->EjecutaQuerySimple(); 
    	}
    	//break;
    	return $rs;
    }


    function datosBancos($idp){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE ID = $idp";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);

    	return $row;
    }

    function datosCuentas($datosBanco){
    	$dbanco = $datosBanco->BANCO;
    	$banco = explode(' - ', $dbanco);
    	
    	echo 'Este es el banco: '.$banco[0];
    	echo 'Esta es la cuenta: '.$banco[1];

    	$this->query="SELECT CTA_CONTAB FROM PG_BANCOS WHERE BANCO = '$banco[0]' and num_cuenta =$banco[1]";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);

    	return $row;	
    }

    function datos_SAE_Polizas(){
    	$this->query="SELECT first 2500 ca.*, iif(p.rfc is null, 'rfcgenerico', p.rfc) as rfc,
            iif(p.nombre is null, 'ProveedorGenerico', p.nombre) as nombre ,
            iif(p.cta_cont is null, 'CUENTAPROVGENERICO', p.cta_cont) as cta_cont
                        FROM CARGO_ANUAL_17 ca 
                        left join prov01 p on p.clave = ca.proveedor 
                        WHERE CONTABILIZADO = 0 ";
    	$res=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function datos_SAE_Proveedores(){
    	$this->query="SELECT first 500 p.rfc, max(p.nombre) as nombre 
    					FROM CARGO_ANUAL_17 ca 
    					left join prov01 p on p.clave = ca.proveedor 
    					WHERE CONTABILIZADO = 0
    					group by p.rfc";
    	$res=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($res)){
    		$data[]=$tsArray;
    	}
    	return $data;	
    }

    function actContabilidad($insertaPoliza){
    //echo 'Longitud del arreglo'.count($polizas);
    	if(count($insertaPoliza)>=1){
    		foreach ($insertaPoliza as $data){
    		$polEg = $data[2];
    		$polDr = $data[3];
    		$id = $data[1];
    		$this->query="UPDATE CARGO_ANUAL_17 SET CONTABILIZADO = 1, NUMERO_POLIZA='$polEg', NUMERO_POLIZA_DR = '$polDr' where id = $id";
    		$rs=$this->EjecutaQuerySimple();
    		}	
    	}
    	//var_dump($insertaPoliza);
    	echo 'polizas insertadas: '.count($insertaPoliza);
    	//break;
    	return;
    }


    function datos_SAE_Polizas_Dr_Venta(){
    	$this->query="SELECT first 500 A.*, C.NOMBRE, C.CLAVE, iif(EXTRACT(MONTH FROM CP.FECHA_RECEP) is null, 1,EXTRACT(MONTH FROM CP.FECHA_RECEP)) AS MES,
				        iif(EXTRACT(YEAR FROM CP.FECHA_RECEP) is null, 2015, EXTRACT(YEAR FROM CP.FECHA_RECEP))  AS ANIO,
				        F.FECHAELAB,
				        F.CVE_CLPV, F.IMPORTE, A.monto_aplicado,
				        F.IMP_TOT4,
				        F.fecha_doc
                      FROM APLICACIONES A
                      LEFT JOIN FACTF01 F ON F.CVE_DOC = A.DOCUMENTO
                      LEFT JOIN CLIE01 C ON F.CVE_CLPV = C.CLAVE
                      left join carga_pagos CP on A.idpago = CP.ID
                      WHERE A.CONTABILIZADO IS NULL
                      AND A.CANCELADO = 0
                      AND A.PROCESADO = 1";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}


    	return @$data;
    }

    function actCont_Aplicaciones($insertaPoliza){

    	foreach ($insertaPoliza as $data){
    		$poliza = 'Dr'.$data[1];
    		$id = $data[0];
    		$this->query = "UPDATE APLICACIONES SET CONTABILIZADO = 'OK', POLIZA_DIARIO ='$poliza' where id = $id ";
    		$rs=$this->EjecutaQuerySimple();
    		//echo $this->query;
    	}
    	return;
    }

    function datos_SAE_Polizas_Ig_Venta(){
    	$this->query="SELECT first 1000 cp.*,b.CTA_CONTAB, extract(month from fecha_recep) as mes, extract(year from fecha_recep) as anio 
    	from carga_pagos cp 
    	left join pg_bancos b on b.banco containing (trim(substring(cp.banco from 1 for 8)))
    	where contabilizado is null and status <> 'C' and tipo_pago is null AND EXTRACT(YEAR FROM FECHA_RECEP) = 2017";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    	}
    	return @$data;
    }

   	function sae_partidas_CargaPagos($pagos){
   		foreach ($pagos as $key) {
   			$this->query="SELECT * from aplicaciones where cancelado = 0 and contabilizado is null and idpago = $key->ID";
		   	$rs=$this->QueryObtieneDatosN();
		   		while($tsArray = ibase_fetch_object($rs)){
		   			$data[]=$tsArray;
		   		}
   		}
   		return @$data;
   	}

   	function act_Contabilidad_Carga_Pagos_Aplicaciones($insertaPoliza){	
   		foreach($insertaPoliza as $data){
   			$idp = $data[0];
   			$ida = $data[1];
   			$poliza = $data[2];
   			if($idp != 0){
   				$this->query="UPDATE carga_pagos set contabilizado = '1', poliza_ingreso='$poliza' where id = $idp";
   				$rs=$this->EjecutaQuerySimple();
   			}else{
   				$this->query="UPDATE aplicaciones set poliza_ingreso = '$poliza' where id = $ida";
   				$rs=$this->EjecutaQuerySimple();
   			}
   		}
   		return;
	}


	function contabiliza_ventas(){
		$this->query="SELECT first 10000 CVE_DOC, IMPORTE, CVE_PEDI, fechaelab, IMP_TOT4, DES_TOT, f.RFC, DOC_ANT , cl.nombre, extract(month from fecha_doc) as mes, f.cve_clpv, extract(year from fecha_doc) as anio, iif(cta_cont = '', 0,cta_cont) as cta_cont, fecha_doc
                    FROM FACTF01  f
                    left join clie01 cl on f.cve_clpv = cl.clave
                    WHERE f.STATUS <> 'C' AND EXTRACT(YEAR FROM FECHA_DOC) = 2017 AND f.CONTABILIZADO IS NULL";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function act_ventas($insertaPoliza){
		foreach ($insertaPoliza as $key){
			$poliza = 'Dr'.$key[0];
			$docf = $key[1];

			$this->query="UPDATE FACTF01 SET CONTABILIZADO = '1', POLIZA = '$poliza' WHERE cve_doc = '$docf'";
			$rs=$this->EjecutaQuerySimple();
		}
		return;
	}


	function contabiliza_NC(){
		$this->query="SELECT first 5000 CVE_DOC, IMPORTE, CVE_PEDI, fechaelab, IMP_TOT4, DES_TOT, f.RFC, DOC_ANT , cl.nombre, extract(month from fecha_doc) as mes, f.cve_clpv, extract(year from fecha_doc) as anio, iif(cta_cont = '', 0,cta_cont) as cta_cont, fecha_doc
                    FROM FACTD01 f
                    left join clie01 cl on f.cve_clpv = cl.clave
                    WHERE f.STATUS <> 'C' AND EXTRACT(YEAR FROM FECHA_DOC) = 2017 AND f.CONTABILIZADO IS NULL";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;	
	}

	function act_NC($insertaPoliza){
		foreach ($insertaPoliza as $key){
			$poliza = 'Dr'.$key[0];
			$docf = $key[1];
			$this->query="UPDATE FACTD01 SET CONTABILIZADO = '1', POLIZA = '$poliza' WHERE cve_doc = '$docf'";
			$rs=$this->EjecutaQuerySimple();
		}
		return;
	}

	function crea_cuenta_clientes(){
		$this->query="SELECT rfc, max(nombre) as nombre, 0 as cta_cont from clie01 where (cta_cont = '' or cta_cont is null or cta_cont = '00100000000003') and rfc is not null group by RFC";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
	    return $data;	
	}

	function act_cuenta($crea_cuenta){
		foreach ($crea_cuenta as $key){
			$rfc = $key[0];
			$cuenta = $key[1];
			$this->query = "UPDATE CLIE01 SET CTA_CONT = '$cuenta' where RFC = '$rfc'";
			$rs=$this->EjecutaQuerySimple();
			echo 'Se actualizo el RFC: '.$rfc.' Con la cuenta: '.$cuenta.'.<p>';

		}

		return;
	}

	function crea_cuentas_proveedores(){
		$this->query="SELECT RFC, max(nombre) as nombre, '0' as cta_cont FROM PROV01 WHERE (RFC IS NOT NULL OR RFC <> '') AND (CTA_CONT = '' or cta_cont = '0') GROUP BY RFC ";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function act_cuenta_proveedor($crea_cuenta){
		foreach ($crea_cuenta as $key){
			$rfc = $key[0];
			$cuenta = $key[1];
			$this->query = "UPDATE PROV01 SET CTA_CONT = '$cuenta' where RFC = '$rfc'";
			$rs=$this->EjecutaQuerySimple();
			echo 'Se actualizo el RFC: '.$rfc.' Con la cuenta: '.$cuenta.'.<p>';
		}

		return;
	}


	function vencSemanal(){
		$this->query="SELECT F.CVE_MAESTRO, SUM(F.SALDOFINAL) AS SALDO, MAX(M.NOMBRE) as NOMBRE_MAESTRO, MAX(M.CARTERA) AS CARTERA
		 FROM FACTF01 F
		 LEFT JOIN MAESTROS M ON M.CLAVE = F.CVE_MAESTRO 
		 WHERE STATUS_VENCIMIENTO = 1 GROUP BY CVE_MAESTRO";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function vencRestriccion(){
		$this->query="SELECT F.CVE_MAESTRO, SUM(F.SALDOFINAL) AS SALDO, MAX(M.NOMBRE) as NOMBRE_MAESTRO, MAX(M.CARTERA) AS CARTERA
		 FROM FACTF01 F
		 LEFT JOIN MAESTROS M ON M.CLAVE = F.CVE_MAESTRO 
		 WHERE STATUS_VENCIMIENTO >= 2 and status_vencimiento <= 3 
		 GROUP BY CVE_MAESTRO";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;	
	}

	function vencExtrajudicial(){
		$this->query="SELECT F.CVE_MAESTRO, SUM(F.SALDOFINAL) AS SALDO, MAX(M.NOMBRE) as NOMBRE_MAESTRO, MAX(M.CARTERA) AS CARTERA
		 FROM FACTF01 F
		 LEFT JOIN MAESTROS M ON M.CLAVE = F.CVE_MAESTRO 
		 WHERE STATUS_VENCIMIENTO >= 4 and status_vencimiento <= 8 
		 GROUP BY CVE_MAESTRO";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;	
	}	

	function vencJudicial(){
		$this->query="SELECT F.CVE_MAESTRO, SUM(F.SALDOFINAL) AS SALDO, MAX(M.NOMBRE) as NOMBRE_MAESTRO, MAX(M.CARTERA) AS CARTERA
		 FROM FACTF01 F
		 LEFT JOIN MAESTROS M ON M.CLAVE = F.CVE_MAESTRO 
		 WHERE STATUS_VENCIMIENTO >= 9
		 GROUP BY CVE_MAESTRO";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;	
	}	

	function verInd($maestro, $status){

		if($status == 4){
			$this->query="SELECT f.CVE_CLPV, sum(f.saldofinal) as saldo, max(cl.nombre) as nombre, max(ct.cartera_cobranza) as cartera  
					  FROM FACTF01 f
					  left join cartera ct on trim(ct.idcliente) = trim(f.cve_clpv) 
					  left join clie01 cl on cl.clave = f.cve_clpv
					  WHERE f.CVE_MAESTRO = '$maestro' and f.status_vencimiento >= 4 and status_vencimiento <= 8 
					  group by f.CVE_CLPV";
			
		}elseif ($status == 5) {
			$this->query="SELECT f.CVE_CLPV, sum(f.saldofinal) as saldo, max(cl.nombre) as nombre, max(ct.cartera_cobranza) as cartera  
					  FROM FACTF01 f
					  left join cartera ct on trim(ct.idcliente) = trim(f.cve_clpv) 
					  left join clie01 cl on cl.clave = f.cve_clpv
					  WHERE f.CVE_MAESTRO = '$maestro' and f.status_vencimiento >= 9
					  group by f.CVE_CLPV";
		
		}elseif($status == 2){
			$this->query="SELECT f.CVE_CLPV, sum(f.saldofinal) as saldo, max(cl.nombre) as nombre, max(ct.cartera_cobranza) as cartera  
					  FROM FACTF01 f
					  left join cartera ct on trim(ct.idcliente) = trim(f.cve_clpv) 
					  left join clie01 cl on cl.clave = f.cve_clpv
					  WHERE f.CVE_MAESTRO = '$maestro' and f.status_vencimiento >= 2 and status_vencimiento <= 3
					  group by f.CVE_CLPV";
		}else{
			$this->query="SELECT f.CVE_CLPV, sum(f.saldofinal) as saldo, max(cl.nombre) as nombre, max(ct.cartera_cobranza) as cartera  
					  FROM FACTF01 f
					  left join cartera ct on trim(ct.idcliente) = trim(f.cve_clpv) 
					  left join clie01 cl on cl.clave = f.cve_clpv
					  WHERE f.CVE_MAESTRO = '$maestro' and f.status_vencimiento = $status
					  group by f.CVE_CLPV";	
		}

		$rs=$this->QueryObtieneDatosN();

		//echo $this->query;

		while ($tsArray=ibase_fetch_object($rs)){
				$data[]=$tsArray;
			}	

		return $data;
	}


	function verRecibidosCobranza($cc){
		$this->query="SELECT * FROM VIEW_CAJAS where cc ='$cc'";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		
		return @$data;
	}

	function guardaSecuencia($idc, $secuencia){
		$this->query="UPDATE CAJAS SET SECUENCIA_RUTA = $secuencia where id = $idc";
		$rs=$this->EjecutaQuerySimple();
		return;
	}

	function creaFolioRutaCobranza($cc){

		$usuario=$_SESSION['user']->NOMBRE;
		$this->query="SELECT iif(MAX(FOLIO) is null, 0, max(folio)) as folio FROM FOLIOS_RUTA_COBRANZA";
		$res=$this->QueryObtieneDatosN();
		$row=ibase_fetch_object($res);
		$folioN = $row->FOLIO + 1;

		$this->query="SELECT * FROM VIEW_CAJAS where cc='$cc'";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

			$i=0;
			$total=0;
			foreach ($data as $dato){

				$this->query="SELECT iif(max(SECUENCIA_RUTA) is null, 0, max(secuencia_ruta)) as sec FROM CAJAS WHERE FACTURA = '$dato->FACTURA'";
				$rs=$this->EjecutaQuerySimple();
				$row=ibase_fetch_object($rs);
				$sec=$row->SEC;

				$this->query="UPDATE FACTF01 SET FOLIO_RUTA_COBRANZA = $folioN where cve_doc = '$dato->FACTURA'";
				$rs=$this->EjecutaQuerySimple();

				$this->query="INSERT INTO PAR_RUTA_COBRANZA VALUES(NULL, '$dato->FACTURA', $dato->SALDOFINAL,$folioN, $sec)";
				$rs=$this->EjecutaQuerySimple();
				$i=$i+1;
				$total = $total +$dato->SALDOFINAL;
			}

		$this->query="INSERT INTO FOLIOS_RUTA_COBRANZA VALUES (NULL, $folioN, current_timestamp, DATEADD(day, 7, current_timestamp), $total, 0, null,'$usuario', $i, '$cc' )";
		$this->EjecutaQuerySimple();
		return $folioN;
	}


	function datosRutaC($folio){
		$this->query="SELECT * FROM FOLIOS_RUTA_COBRANZA WHERE FOLIO = $folio";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function datosRutaP($folio){
		$this->query="SELECT pr.*, cl.nombre, f.fechaelab, iif(f.prorroga is null, 0, f.prorroga) as prorroga, c.secuencia_ruta, f.saldofinal   
						FROM PAR_RUTA_COBRANZA pr
						left join factf01 f on f.cve_doc = pr.documento
						left join clie01 cl on cl.clave = f.cve_clpv
						left join cajas c on c.factura = f.cve_doc
						WHERE pr.FOLIO = $folio";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function verRutasVigentes(){
		$this->query="SELECT * FROM FOLIOS_RUTA_COBRANZA WHERE FECHA_FIN > CURRENT_DATE AND FECHA_CIERRE IS NULL";
		$rs= $this->QueryObtieneDatosN();

		while($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	    function verPartidasRuta($idf){
    	$this->query="SELECT pr.*, cl.nombre, f.fechaelab, iif(f.prorroga is null, 0, f.prorroga) as prorroga, pr.secuencia,
    					f.saldofinal, f.aplicado, f.contrarecibo_cr, f.CVE_MAESTRO AS MAESTRO
                        FROM PAR_RUTA_COBRANZA pr
                        left join factf01 f on f.cve_doc = pr.documento
                        left join clie01 cl on cl.clave = f.cve_clpv
                        WHERE pr.FOLIO = $idf 
                        and f.saldofinal >= 10	
                        order by f.cve_maestro asc, cl.nombre asc";
        $rs=$this->QueryObtieneDatosN();
        while ($tsArray=ibase_fetch_object($rs)){
        	$data[]=$tsArray;
        }
        return $data;
    }

    function verPartidasPagadas($idf){
    	$this->query="SELECT pr.*, cl.nombre, f.fechaelab, iif(f.prorroga is null, 0, f.prorroga) as prorroga, pr.secuencia,
    					f.saldofinal, f.aplicado, f.contrarecibo_cr, f.CVE_MAESTRO AS MAESTRO
                        FROM PAR_RUTA_COBRANZA pr
                        left join factf01 f on f.cve_doc = pr.documento
                        left join clie01 cl on cl.clave = f.cve_clpv
                        WHERE pr.FOLIO = $idf 
                        and f.saldofinal <= 10	
                        order by f.cve_maestro asc, cl.nombre asc";
        $rs=$this->QueryObtieneDatosN();
        while ($tsArray=ibase_fetch_object($rs)){
        	$data[]=$tsArray;
        }
        return $data;
    }


    function obtieneFolio($docf){
    	$this->query="SELECT MAX(FOLIO) AS FOLIO FROM PAR_RUTA_COBRANZA WHERE DOCUMENTO = '$docf'";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$folio = $row->FOLIO;

    	return $folio;
    }	

    function verRutasFinalizadas(){
    	$this->query="SELECT * FROM FOLIOS_RUTA_COBRANZA WHERE FECHA_FIN < CURRENT_DATE and FECHA_CIERRE IS NOT NULL";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function cerrarRuta($idr){
    	$this->query="UPDATE FOLIOS_RUTA_COBRANZA SET FECHA_CIERRE = CURRENT_DATE WHERE FOLIO = $idr";
    	$rs=$this->EjecutaQuerySimple();
    }


      function verSolProdVentas(){
    	$user=$_SESSION['user']->NOMBRE;
    	$aux =$_SESSION['user']->AUX_COMP;
    	//echo 'Valida si es auxiliar o no: '.$aux;
    	if($aux == 'Si'){
			$this->query="SELECT * FROM FTC_Articulos ftcart
						    left join CATEGORIAS ctg on ctg.NOMBRE_CATEGORIA = ftcart.Categoria
						    left join marcas m on m.clave_marca = ftcart.marca
						    left join MARCAS_X_CATEGORIA mxc on mxc.idcat = ctg.id  and m.id = mxc.idmarca
						    WHERE ftcart.STATUS = 'P'
						    and mxc.auxiliar= '$user'";
    	}elseif($aux == 'No' and $user != 'Gerencia de Compras'){
			$this->query="SELECT * FROM FTC_Articulos ftcart
						    left join CATEGORIAS ctg on ctg.NOMBRE_CATEGORIA = ftcart.Categoria
						    left join marcas m on m.clave_marca = ftcart.marca
						    left join MARCAS_X_CATEGORIA mxc on mxc.idcat = ctg.id  and m.id = mxc.idmarca
						    WHERE ftcart.STATUS = 'P'
						    and ctg.responsable = '$user'";    		
    	}else{
			$this->query="SELECT * FROM FTC_Articulos ftcart
						    left join CATEGORIAS ctg on ctg.NOMBRE_CATEGORIA = ftcart.Categoria
						    left join marcas m on m.clave_marca = ftcart.marca
						    left join MARCAS_X_CATEGORIA mxc on mxc.idcat = ctg.id  and m.id = mxc.idmarca
						    WHERE ftcart.STATUS = 'P'";
    	}
    	$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	//break;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verProducto($ids){
    	$this->query="SELECT first 100 * FROM FTC_Articulos WHERE ID = $ids";
    	$rs = $this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function guardaFTCART($ids, $clave, $categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov1, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $cotizacion, $cliente, $costo_t, $costo_oc, $tipo, $doco, $par){

    	$usuario = $_SESSION['user']->NOMBRE;

    	$this->query="SELECT ftca.*, ftcp.nombre, ftcp.clave as cveart FROM FTC_Articulos ftca left join PRODUCTO_FTC ftcp on ftcp.clave_ftc = ftca.id  WHERE ftca.ID = $ids";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$nomprod = $row->NOMBRE;
    	$cveart = $row->CVEART; 

    	if($doco <> ''){
    		$this->query="SELECT oc.cve_doc, oc.cve_clpv, p.nombre, poc.cve_art, poc.cost
    						from compo01 oc 
    						left join par_compo01 poc on poc.cve_doc = oc.cve_doc and poc.num_par = $par 
    						left join prov01 p on p.clave = oc.cve_clpv
    						where poc.cve_doc = '$doco' and poc.num_par = $par";
    		$rs2=$this->EjecutaQuerySimple();
    		$row2=ibase_fetch_object($rs2);
    		$nombre = $row2->NOMBRE;
    		$cveclpv = $row2->CVE_CLPV;
    		$cveart = $row2->CVE_ART;
    	}else{
    		$cveclpv = '';	
    		$nombre = '';
    	}
    	
    	$this->query="INSERT INTO REG_COSTOS (ID, CLAVE_PROV, NOMBRE_PROV, CLAVE_PROD, NOMBRE_PROD, COSTO_O, COSTO_N, DIF, TIPO, FECHA, USUARIO)
    							  VALUES (NULL, '$cveclpv', '$nombre', '$cveart', '$nomprod', $row->COSTO_T, $costo_prov1, ($row->COSTO_T - $costo_prov1), '$tipo', current_timestamp, '$usuario')";
    	$this->EjecutaQuerySimple();


    	if($descripcion == $generico or $generico == ''){
    		$desc = $descripcion;
    	}else{
    		$desc = $descripcion.' - '.$generico;
    	}
    	if(empty($costo_total)){
    		$costo_total = 0;
    	}
    	if(empty($costo_prov1)){
    		$costo_prov1 = 0;
    	}
    	if(empty($desc1)){
    		$desc1 = 0;
    	}
    	if(empty($desc2)){
    		$desc2 = 0;
    	}
    	if(empty($desc3)){
    		$desc3 = 0;
    	}
    	if(empty($desc4)){
    		$desc4 = 0;
    	}
    	if(empty($desc5)){
    		$desc5 = 0;
    	}
    	if(empty($costo_t)){
    		$costo_t = 0;
    	}
    	if(empty($costo_oc)){
    		$costo_oc=0;
    	}
       	$this->query="UPDATE FTC_ARTICULOS SET
    			CLAVE_PROD = '$clave',
    			CATEGORIA = '$categoria',
    			LINEA = '$linea',
    			GENERICO = '$generico',
    			SINONIMO = '$sinonimos',
    			CALIFICATIVO = '$calificativo',
    			MEDIDAS = '$medidas',
    			MARCA = '$marca',
    			UM = '$unidadmedida',
    			EMPAQUE = '$empaque',
    			CLAVE_DISTRIBUIDOR = '$prov1',
    			CLAVE_FABRICANTE = '$codigo_prov1',
    			SKU_CLIENTE = '',
    			SKU = '$sku',
    			COSTO = $costo_total,
    			PRECIO = $costo_prov1,
    			UTILIDAD_MININA = 0,
    			impuesto = $impuesto,
    			costo_t = $costo_t,
    			costo_oc = $costo_oc,
    			desc1 = $desc1,
    			desc2 = $desc2,
    			desc3 = $desc3,
    			desc4 = $desc4,
    			descf = $desc5
    			where id = $ids
    			";
    	//echo $this->query;
    	//break;
    	$rs=$this->EjecutaQuerySimple();
    	
    	return $tipo;
    }



    function produccionFTCART($ids){
    	$this->query="UPDATE FTC_Articulos SET STATUS = 'A', fecha_alta = current_timestamp WHERE ID = $ids";
    	$rs=$this->EjecutaQuerySimple();

    	// Inserta en Inventario

    	$this->query = "INSERT into inve01 (CVE_ART, DESCR, UNI_MED, UNI_ALT,CON_SERIE, TIP_COSTEO, NUM_MON, CON_LOTE, CON_PEDIMENTO, CVE_ESQIMPU, STATUS, MAN_IEPS, APL_MAN_IEPS, TIPO_ELE, fac_conv) 
    						values ('PGS$ids',
    		(SELECT substring( 
            (GENERICO
            ||iif(SINONIMO = '' or SINONIMO is null,'',(', '||SINONIMO))
            ||iif(CALIFICATIVO = '' OR CALIFICATIVO IS NULL, '',(', '||CALIFICATIVO))
            ||iif(MEDIDAS = '' OR MEDIDAS IS NULL,'',(', '||MEDIDAS))
            ||iif(CLAVE_PROD = '' OR CLAVE_PROD IS NULL, '', (', '||CLAVE_PROD))
            ||iif(MARCA = '' OR MARCA IS NULL, '', (', '||MARCA))
            ||iif(UM = '' OR UM IS NULL,'',(', '||UM))
            )
            from 1 for 40) FROM FTC_Articulos WHERE ID = $ids),
    		(SELECT iif(UM is null or UM = '', 'pza', UM ) from FTC_Articulos WHERE ID = $ids),
    		(SELECT iif(UM is null or UM = '', 'pza', UM) from FTC_Articulos where id = $ids),
    		'N', 'P', 1, 'N', 'N','1', 'A', 'N', 1, 'P', 1)";
    	$rs=$this->EjecutaQuerySimple();

    	//echo 'Inserta en el Inventario: '.$this->query.'<p>';
    	//break;
    	/// Inserta en los campos libres

    	$this->query="INSERT INTO INVE_CLIB01 (CVE_PROD, CAMPLIB7) VALUES ( 'PGS$ids', 
    	(SELECT substring(
            (GENERICO
            ||iif(SINONIMO = '' OR SINONIMO IS NULL ,'',(', '||SINONIMO))
            ||iif(CALIFICATIVO = '' OR CALIFICATIVO IS NULL , '',(', '||CALIFICATIVO))
            ||iif(MEDIDAS = '' OR MEDIDAS IS NULL,'',(', '||MEDIDAS))
            ||iif(CLAVE_PROD = '' OR CLAVE_PROD IS NULL , '', (', '||CLAVE_PROD))
            ||iif(MARCA = '' OR MARCA IS NULL , '', (', '||MARCA))
            ||iif(UM = '' OR UM IS NULL,'',(', '||UM))
            )
            from 1 for 255 FROM FTC_Articulos WHERE ID = '$ids')
    	)";
    	$rs=$this->EjecutaQuerySimple();

    	///echo 'Inserta en los campos libres'.$this->query.'<p>';

    	/// inserta en multialmacenes;

    	$this->query="INSERT INTO MULT01 VALUES('PGS$ids', 95, 'A','', 0, 0, 0, 0 , null, null)";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="INSERT INTO MULT01 VALUES('PGS$ids', 1, 'A','', 0, 0, 0, 0 , null, null)";
    	$rs=$this->EjecutaQuerySimple();
    	//echo 'Inserta Campos libres: '.$this->query;
    	/// Inserta en los precios
    	
    	$this->query="SELECT MAX(CVE_PRECIO) as precios FROM PRECIOS01";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$p = $row->PRECIOS;

    	for ($i=1; $i <= $p; $i++) { 
   		
   			$this->query="INSERT INTO PRECIO_X_PROD01 (CVE_ART, CVE_PRECIO, PRECIO) VALUES ('PGS$ids', $i,
    		(SELECT COALESCE(COSTO, 1)* 1.2 
    		FROM FTC_Articulos WHERE ID = $ids));";
    		$rs=$this->EjecutaQuerySimple();

    		//echo 'Inserta en la lista de precios: '.$this->query.'<p>';
   		}

   		 /// fija el minimo en 0 pesos....
   		$this->query="UPDATE PRECIO_X_PROD01 SET PRECIO = 0 WHERE CVE_ART = 'PGS$ids' and cve_precio = 2";
   		$rs=$this->EjecutaQuerySimple();

   		/// Lo ingresamos a la cotizacion que pertenece

   			/// obtenemos los datos del producto y de la cotizacion para poder obtener los datos.
	   		$this->query="SELECT * from FTC_Articulos WHERE ID = $ids";
	   		$rs=$this->QueryObtieneDatosN();
	   		$row=ibase_fetch_object($rs);
	   		$folio = $row->COTIZACION;

	   		$precSug= ($row->COSTO * .23) + $row->COSTO; 

	   		$this->query="INSERT INTO FTC_COTIZACION_DETALLE (CDFOLIO, CVE_ART, FLCANTID, DBIMPPRE,DBIMPCOS, DBIMPDES ) VALUES($row->COTIZACION, $row->ID, $row->CANTSOL, $precSug, $row->COSTO_T, 0)";
	   		$res=$this->EjecutaQuerySimple();

	   		//// echo $this->query;
	   	//break;
    	return $folio;
    }



    function catalogoProductosFTC($descripcion){

    	if(!empty($descripcion)){
    		$id= strpos($descripcion,':');
    		if($id === false){
    				$this->query="SELECT fart.*, ct.id as idc 
    				FROM FTC_Articulos fart
    				left join producto_ftc pftc on pftc.clave_ftc = fart.id
    				left join CATEGORIAS ct ON  ct.nombre_categoria = fart.categoria
    				where  fart.status='A' AND upper(pftc.nombre) containing(upper('$descripcion'))";
    				
    		}else{
    			$a= split(':',$descripcion);    
                            $descripcion = $a[0];
                          	$this->query="SELECT fart.*, ct.id as idc 
    						FROM FTC_Articulos fart
    						left join producto_ftc pftc on pftc.clave_ftc = fart.id
    						left join CATEGORIAS ct ON  ct.nombre_categoria = fart.categoria
    						where  fart.status='A' AND upper(pftc.clave)= upper('$descripcion')";
    						///echo $this->query;
    		}
    	}else{
    			$this->query="SELECT first 100 fart.*, ct.id as idc 
    			FROM FTC_Articulos fart
    			left join CATEGORIAS ct ON  ct.nombre_categoria = fart.categoria
    			where  fart.status='A'";
		}    		
    	
    		$rs=$this->QueryObtieneDatosN();
    	//echo $this->query;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function creaProductoFTC($categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov1, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $clave, $costo_t, $costo_oc){

    	$this->query="INSERT INTO FTC_ARTICULOS VALUES(
    			NULL,
    			'$linea',
				'$categoria',
    			'$generico',
    			'$sinonimos',
    			'$calificativo',
    			'$medidas',
    			'$clave',
    			'$marca',
    			'$unidadmedida',
    			$empaque,
    			'$prov1',
    			'$codigo_prov1',
    			'',
    			'$sku',
    			$costo_total,
    			$costo_prov1,
    			0,
    			'A',
    			'DIRECTO COMPRAS',
    			0, 
    			$desc1,
    			$desc2,
    			$desc3,
    			$desc4,
    			$desc5,
    			'$descripcion',
    			'$iva',
    			current_date,
    			$impuesto,
    			$costo_t,
    			$costo_oc,
    			0,
    			NULL, 
    			NULL)
    			";
    		echo 'Inserta producto: '.$this->query.'<p>';
    		//break;
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="SELECT MAX(ID) AS ID FROM FTC_Articulos";
    	$res=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($res);
    	$ids = $row->ID;

    	$res+=$this->produccionFTCART($ids);

    	return;
    	/// enviamos a produccion:
    }

    function cancelarCargaPago($idtrans){
    	$this->query = "UPDATE CARGA_PAGOS SET STATUS = 'C' WHERE ID = $idtrans";
    	echo $this->query;
    	//break;
    	$rs=$this->EjecutaQuerySimple();
    	return;
    }

    function verCajasAlmacen(){

    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query = "SELECT * FROM PG_USERS WHERE NOMBRE = '$usuario'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);

    	$this->query="SELECT ca.*, ftcc.urgente, ftcc.cve_cliente, iif(cl.status_cobranza is null, 0 , cl.status_cobranza) as status_cobranza, 	ftcc.dbimptot, cl.saldo_monto_cobranza from cajas_almacen ca left join FTC_COTIZACION ftcc on ftcc.CDfolio = ca.cotizacion 
    				left join clie01 cl on trim(cl.clave) = trim(ftcc.cve_cliente) where PEDIDO Starting with('$row->LETRA_NUEVA') AND (ca.status  = 0 or datediff(day from fecha_ventas to current_timestamp) < 15) order by ca.fecha_ventas desc";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function datosCotizacionFTC($folio){
    	$this->query="SELECT * from ftc_cotizacion ftcc
        left join cartera ct on trim(ct.idcliente) = trim(ftcc.cve_cliente)
        left join clie01 cl on trim(cl.clave) = trim(ftcc.cve_cliente)
        where cdfolio = $folio";
        $rs=$this->QueryObtieneDatosN();

        while($tsArray=ibase_fetch_object($rs)){
        	$data[]=$tsArray;
        }
        return $data;
    }

    function detalleCotizacionFTC( $folio){
    	$this->query="SELECT *
        FROM  FTC_COTIZACION_DETALLE ftcd
        left join ftc_articulos ftca on ftca.id = ftcd.cve_art
        left join producto_ftc pftc on pftc.clave_ftc = ftca.id
        where cdfolio = $folio";
        $rs=$this->QueryObtieneDatosN();

      	while($tsArray=ibase_fetch_object($rs)){
      		$data[]=$tsArray;
      	}
      	return $data;
    }

 function libPedidoFTC($folio, $idp, $idca, $urgente){
    	$mensaje = '';
    	$TIME = time();
		$HOY = date("Y-m-d H:i:s", $TIME);
    	if($urgente == 'Si'){
    		$u = 'U';
    	}else{
    		$u = '';
    	}
    	$usuario=$_SESSION['user']->NOMBRE;
    
    	$this->query="SELECT p.CVE_CLPV, limcred, diascred, iif(status_cobranza is null, 0, status_cobranza) as status_cobranza,
 						iif(finaliza_corte is null, current_timestamp, finaliza_corte) as finaliza_corte,
                    	iif(saldo_monto_cobranza is null, 0, saldo_monto_cobranza) as saldo_monto_cobranza, 
                    	p.importe
                        FROM FACTP01 p 
                        left join clie01 cl on cl.clave = p.cve_clpv 
                        WHERE CVE_DOC = '$idp'";

    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$cveclie = $row->CVE_CLPV;
    	$limite = $row->LIMCRED;
    	$plazo = $row->DIASCRED;
    	$status = $row->STATUS_COBRANZA;
    	$finalizaCorte = $row->FINALIZA_CORTE;
    	$saldoCobranza =$row->SALDO_MONTO_COBRANZA;
    	$importe = $row->IMPORTE;
    	/// traemos el saldo de facturas pendientes de pago del cliente
    	$this->query="SELECT iif(SUM(SALDOFINAL) is null, 0 , sum(saldofinal)) as SF FROM FACTURAS WHERE CVE_CLPV = '$cveclie'";
    	$rs=$this->EjecutaQuerySimple();
    	$row2=ibase_fetch_object($rs);
    	$saldofact=$row2->SF;
    	//// traemos el saldo de las remisiones pendientes de facturar del cliente.
    	$this->query="SELECT iif(SUM(IMPORTE) is null,0,sum(importe)) AS SR FROM factr01 WHERE CVE_CLPV ='$cveclie' AND STATUS <> 'C' AND (DOC_SIG = '' OR DOC_SIG IS NULL)";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$saldorem= $row->SR;
    
    	if($finalizaCorte >= $HOY){
    		$saldoCobranza = 0;
    	}
    	$saldotot = $saldorem + $saldofact + $importe - $saldoCobranza;
    	echo 'El Cliente: '.$cveclie.' tiene un saldo deudor de $ '.number_format($saldotot,2).', y su Limite es de  $ '.number_format($limite,2).'<p>';
    	// Si la suma de los documentos + el pedido a liberar es mayor a la linea de credito establecida, manda error, de lo contrario deja generar el pedido. 
    	if($saldotot > $limite){
    		echo 'Entra al sobregiro con el status del cliente'.$status.' favor de revisar con Cuentas x Cobrar'.'<p>';
				if($status == 0){
					$this->query = "UPDATE CLIE01 SET STATUS_COBRANZA = 1 where clave = '$cveclie'";
					$rs=$this->EjecutaQuerySimple();
					$mensaje = 'El cliente esta suspendido por que supera su linea de credito, favor de solicitar desbloqueo con Cuentas x Cobrar';
				}else{

					echo 'define el mensaje';
					$mensaje = 'El cliente ya supero su limite de credito o no se ha establecido su limite de credito, favor de solicitar aumento de linea de credito con Cobranza';
				}	

    	}else{
			    	$this->query="UPDATE PREOC01 SET STATUS = 'N', urgente = '$u' WHERE COTIZA = '$idp'";
			    	$rs=$this->EjecutaQuerySimple();
    				$this->query="UPDATE cajas_almacen SET STATUS = 1, FECHA_ALMACEN=current_timestamp, fecha_liberacion = current_timestamp, usuario_libera = '$usuario' WHERE IDCA = $idca";
    				$rs= $this->EjecutaQuerySimple();

    				$serie_pegaso = substr($idp,0,1);

    				$this->query="SELECT iif(MAX(CP_FOLIO) is null, 0, max(CP_FOLIO)) AS FOLIO FROM CAJAS_ALMACEN WHERE CP_SERIE = '$serie_pegaso'";
		            $rs=$this->EjecutaQuerySimple();
		            $row=ibase_fetch_object($rs);
		            $folio_cp_folio= $row->FOLIO + 1; 
		            $caja_pegaso = 'L'.$serie_pegaso.$folio_cp_folio;

		            $this->query="UPDATE CAJAS_ALMACEN SET caja_pegaso = '$caja_pegaso' , cp_folio = $folio_cp_folio , cp_serie= '$serie_pegaso' where idca =$idca";
		            $this->EjecutaQuerySimple();
    				$mensaje = 'ok';
    	}
   		return $mensaje;
    }

    function verCatergoriasXMarcas(){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="SELECT mxc.*, m.*, c.*,
		            (SELECT COUNT(id) FROM FTC_Articulos WHERE CATEGORIA = c.nombre_categoria AND MARCA = m.clave_marca) as prodxmarca
		            FROM MARCAS_X_CATEGORIA mxc left join marcas m on m.id = mxc.idmarca left join categorias c on c.id = mxc.idcat
		            WHERE c.responsable = '$usuario'
		            order by  c.NOMBRE_CATEGORIA";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	//echo 'Consulta: '.$this->query;
    	return $data;
    }

    function traeMXC($idcxm){
    	$this->query="SELECT mxc.*, m.*, c.*,
		            (SELECT COUNT(id) FROM FTC_Articulos WHERE CATEGORIA = c.nombre_categoria AND MARCA = m.clave_marca) as prodxmarca
		            FROM MARCAS_X_CATEGORIA mxc 
		            left join marcas m on m.id = mxc.idmarca 
		            left join categorias c on c.id = mxc.idcat
		            WHERE mxc.id = $idcxm";
		        $rs=$this->QueryObtieneDatosN();

		        while($tsArray=ibase_fetch_object($rs)){
		        	$data[]=$tsArray;
		        }
		    return $data;
    }

    function usuariosAuxiliarCompras(){
    	$user=$_SESSION['user']->NOMBRE;
    	echo 'Nombre: '.$user;
    	$this->query="SELECT * FROM PG_USERS WHERE AUX_COMP = 'Si' and COORDINADOR_COMP = '$user'";
    	$rs=$this->QueryObtieneDatosN();

	    	while($tsArray=ibase_fetch_object($rs )){
	    		$data[]=$tsArray;
	    	}
    	return @$data;
    }

    function editaMXC($idmxc, $auxiliar){
    	$this->query="UPDATE MARCAS_X_CATEGORIA SET AUXILIAR ='$auxiliar' where id = $idmxc";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }

    function verCotPenLib(){
    	$this->query="SELECT ftcc.*, cl.nombre, cl.saldo_corriente, cl.saldo_vencido,
    					(select sum(DBIMPCOS) from FTC_COTIZACION_DETALLE ftccd WHERE ftcc.cdfolio = ftccd.cdfolio) as costo 
    				  FROM FTC_COTIZACION ftcc 
    				  left join clie01 cl on trim(ftcc.cve_cliente) = trim(cl.clave)
    				  where ftcc.INSTATUS = 'LIBERACION'";
    	$rs=$this->EjecutaQuerySimple();
    	//echo $this->query;
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function desLib($folio, $respuesta){
    	$this->query="UPDATE FTC_COTIZACION SET INSTATUS='$respuesta' where cdfolio = $folio";
    	$rs=$this->EjecutaQuerySimple();
    	return;	
    }


    function verOrdCompCesta(){

    	$user=$_SESSION['user']->NOMBRE;
    	$this->query="SELECT *
		            FROM PREOC01 p
		            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
		            left join prov01 pv on pv.clave = substring(ftca.clave_distribuidor from 1 for 10) and p.prod starting with ('PGS')
		            WHERE p.rest > 0  and p.id > 80000
		            and pv.resp_compra = '$user'";
    	echo $this->query;
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function editaProveedor($idprov){
    	$this->query="SELECT * FROM PROV01 WHERE CLAVE = '$idprov'";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traeResponsablesProve(){
    	$this->query="SELECT * FROM PG_USERS WHERE USER_ROL = 'suministros'";
    	$rs=$this->QueryObtieneDatosN();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function editarProveedor($idprov, $urgencia, $envio, $recoleccion, $tp_efe, $tp_ch, $tp_cr, $tp_tr, $certificado, $banco, $cuenta, $beneficiario, $responsable, $plazo, $email1, $email2, $email3){
    	
    	$user=$_SESSION['user']->NOMBRE;
    	$this->query="SELECT * FROM PROV01 WHERE trim(CLAVE) = TRIM('$idprov')";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$cer = $row->CERTIFICADO;

    	if($cer == 'Si' and $certificado == 'Si'){
    		$this->query="UPDATE PROV01 SET urgencia ='$urgencia', envio= '$envio', recoleccion='$recoleccion', tp_efectivo = '$tp_efe', tp_credito = '$tp_cr', tp_transferencia= '$tp_tr', tp_cheque='$tp_ch', certificado = '$certificado', nom_banco='$banco', cuenta='$cuenta', beneficiario = '$beneficiario', resp_compra='$responsable', diascred = $plazo, emailpred = '$email1', email2 = '$email2', email3 = '$email3' WHERE CLAVE = '$idprov'";
	    	$rs=$this->EjecutaQuerySimple();
    	}elseif (empty($cer) or $cer == 'No'  ){
    		$this->query="UPDATE PROV01 SET urgencia ='$urgencia', envio= '$envio', recoleccion='$recoleccion', tp_efectivo = '$tp_efe', tp_credito = '$tp_cr', tp_transferencia= '$tp_tr', tp_cheque='$tp_ch', certificado = '$certificado', nom_banco='$banco', cuenta='$cuenta', beneficiario = '$beneficiario', resp_compra='$responsable', fecha_cert = current_timestamp, usr_cert = '$user', num_cert= iif(num_cert is null, 1, num_cert + 1), diascred = $plazo , emailpred = '$email1', email2 = '$email2', email3 = '$email' WHERE CLAVE = '$idprov'";
	    	$rs=$this->EjecutaQuerySimple();
    	}
    	
    	//echo $this->query;
    	//break;
    	return;
    }


    function CreaSubMenuProv(){
    	$user=$_SESSION['user']->NOMBRE;
    	$gerencia = $_SESSION['user']->LETRA;
    	echo 'Usuario: '.$user;
    	if($user =='Gerencia de Compras' or $gerencia == 'G'){
    		$this->query="SELECT pv.clave, pv.nombre, count(p.id) as productos, 
    				(SELECT resp_compra FROM PROV01 WHERE clave = pv.clave) as responsable
		            FROM PREOC01 p
		            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
		            left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
		            WHERE p.rest > 0 and p.id >100000
		            and p.status = 'N'
		            and p.Rec_faltante > 0
		            group by pv.nombre, pv.clave";
		
    	}else{
    		$this->query="SELECT pv.clave, pv.nombre, count(p.id) as productos, '' as responsable
		            FROM PREOC01 p
		            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
		            left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
		            WHERE p.rest > 0 and p.id >100000
		            and (pv.resp_compra = '$user') 
		            and p.status = 'N'
		            and p.Rec_faltante > 0
		            group by pv.nombre, pv.clave";
    	}
		            //echo $this->query;
     	$result = $this->QueryObtieneDatosN();
     	while ($tsArray = ibase_fetch_object($result)){
     		$data[] = $tsArray;
     	}
     		return $data;  
	}

	function verCanasta($idprov, $gerencia){
		$user=$_SESSION['user']->NOMBRE;

		if($user=='Gerencia de Compras' or $gerencia == 'Si'){
				if(empty($idprov)){
						//echo 'Sin Proveedor';
							$this->query="SELECT p.*, ftca.precio as costo_art, ftca.desc1 as desc1a, ftca.desc2 as desc2a, ftca.desc3 as desc3a ,ftca.desc4 as desc4a,
							ftca.costo_t as costo_t,ftca.costo_oc, ftca.impuesto, pv.nombre, '' as responsable
				            FROM PREOC01 p
				            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
				            left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
				            WHERE p.rest > 0 and p.id >100000
				            and p.status='N'
				            and p.rec_faltante > 0
				            and pv.clave is null";
				}else{
						//echo 'Con proveedor';
						$this->query="SELECT p.*, ftca.costo as costo_art, (ftca.costo * (ftca.desc1/100)) as desc1a , (ftca.costo * (ftca.desc2/100)) as desc2a, (ftca.costo * (ftca.desc3/100)) as desc3a, (ftca.costo *(ftca.desc4/100)) as desc4a,
						ftca.costo_t as costo_t,ftca.costo_oc, ftca.impuesto, pv.nombre,
							(select resp_compra from prov01 where trim(clave) = trim('$idprov')) as responsable
				        FROM PREOC01 p
				        left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
				        left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
				        WHERE p.rest > 0 and p.id >100000
				        AND trim(pv.clave) = trim('$idprov')
				        and p.status = 'N'
				        and p.rec_faltante > 0";
				}
		}else{
				if(empty($idprov)){
							$this->query="SELECT p.*, ftca.precio as costo_art, ftca.desc1 as desc1a, ftca.desc2 as desc2a, ftca.desc3 as desc3a ,ftca.desc4 as desc4a,
							ftca.costo_t as costo_t,ftca.costo_oc, ftca.impuesto, pv.nombre
				            FROM PREOC01 p
				            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
				            left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
				            WHERE p.rest > 0 and p.id >100000
				            and (pv.resp_compra = '$user' or pv.resp_compra = '' or pv.resp_compra is null )
				            and p.status='N'
				            and p.rec_faltante > 0
				            and pv.clave is null";
				}else{
						$this->query="SELECT p.*, ftca.costo as costo_art, (ftca.costo * (ftca.desc1/100)) as desc1a , (ftca.costo * (ftca.desc2/100)) as desc2a, (ftca.costo * (ftca.desc3/100)) as desc3a, (ftca.costo *(ftca.desc4/100)) as desc4a,
						ftca.costo_t as costo_t,ftca.costo_oc, ftca.impuesto, pv.nombre
				        FROM PREOC01 p
				        left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
				        left join prov01 pv on trim(pv.clave) = iif(p.prov_alt is null, trim(substring(ftca.clave_distribuidor from 1 for 10)), trim(p.prov_alt)) and p.prod starting with ('PGS')
				        WHERE p.rest > 0 and p.id >100000
				        and (pv.resp_compra = '$user' or pv.resp_compra = '' or pv.resp_compra is null ) 
				        AND trim(pv.clave) = trim('$idprov')
				        and p.status = 'N'
				        and p.rec_faltante > 0";
				}
		}
			
		//echo $this->query;

		//echo 'Trae todos los datos de la preorden'.$this->query.'<p>';
		$rs=$this->QueryObtieneDatosN();
    	while($tsArray = ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
	}


	function subTotalCanasta($idprov){
		$user=$_SESSION['user']->NOMBRE;

		if(empty($idprov)){
					$this->query="SELECT SUM(TOTAL) AS TOTAL
		            FROM PREOC01 p
		            left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
		            left join prov01 pv on pv.clave = substring(ftca.clave_distribuidor from 1 for 10) and p.prod starting with ('PGS')
		            WHERE p.rest > 0 and p.id >100000
		            and (pv.resp_compra = '$user' or pv.resp_compra = '' or pv.resp_compra is null )";
		}else{
				$this->query="SELECT sum(TOTAL) AS TOTAL
		        FROM PREOC01 p
		        left join ftc_articulos ftca on ftca.id = substring(p.prod from 4 for 10) and p.prod starting with ('PGS')
		        left join prov01 pv on pv.clave = substring(ftca.clave_distribuidor from 1 for 10) and p.prod starting with ('PGS')
		        WHERE p.rest > 0 and p.id >100000
		        and (pv.resp_compra = '$user' or pv.resp_compra = '' or pv.resp_compra is null )
		        AND trim(pv.clave) = trim('$idprov')";
		}

		$rs=$this->QueryObtieneDatosN();
		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		//echo 'Este es el subtotal de la Orden:'.$this->query;
		return $data;
	}

	function bajaFTCArticualo($ids){
		$usuario=$_SESSION['user']->NOMBRE;
		$this->query="UPDATE FTC_Articulos SET STATUS = 'B', FECHA_BAJA = current_timestamp, USUARIO_BAJA = '$usuario' WHERE ID = $ids";
		$rs=$this->EjecutaQuerySimple();
		return;
	}

	function rechazaSol($ids, $motivo, $vendedor){
		$user = $_SESSION['user']->NOMBRE;
		$this->query="UPDATE FTC_Articulos SET STATUS = 'R' WHERE ID = $ids";
		$rs=$this->EjecutaQuerySimple();
		
		$this->query="INSERT INTO FTC_Articulos_RECHAZADOS (ID, IDA, VENDEDOR, MOTIVO, FECHA, USUARIO) values (Null, $ids, '$vendedor', '$motivo', current_timestamp, '$user')";
		$rs=$this->EjecutaQuerySimple();
		echo $this->query;

		return;

	}

	function traeFTCArt($ids){
		$this->query="SELECT * FROM FTC_Articulos WHERE ID =$ids";
		//echo $this->query;
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function verRechazo(){
		$user=$_SESSION['user']->NOMBRE;
		$this->query="SELECT COUNT(ID) AS ID FROM  FTC_Articulos_RECHAZADOS where vendedor = '$user' and status = 0";
		$rs=$this->QueryObtieneDatosN();
		$row = ibase_fetch_object($rs);

		if(empty($row)){
			$rechazo = 0;
		}else{
			$rechazo = $row->ID;
		}

		//echo $rechazo;
		//break;
		return $rechazo;
	}

	function traeRechazos(){
		$user = $_SESSION['user']->NOMBRE;
		$this->query="SELECT * FROM VER_RECHAZADOS where vendedor = '$user' and status = 0";
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function enterado($idr){
		$this->query="UPDATE FTC_Articulos_RECHAZADOS SET STATUS = 1 where id = $idr";
		$rs=$this->EjecutaQuerySimple();

		return;
	}



	function preOrdenDeCompra($partidas){
			//echo 'Asi inician <br/><br/>';
			//var_dump($partidas);
			echo'<br/><br/>';
			$usuario = $_SESSION['user']->NOMBRE;
			//var_dump($partidas);
			foreach ($partidas as $key){
				$data=null;
				$idpreoc = $key[1];
				$ftcart = $key[2];
				$cantidad = $key[4];
				$cotizacion = $key[6];
				$this->query = "SELECT * FROM PREOC01 WHERE ID = $idpreoc";
						$rs = $this->EjecutaQuerySimple();
						$row = ibase_fetch_object($rs);
						$canto = $row->CANT_ORIG;
						$cantr = $row->REST;
						$cantord = $row->ORDENADO;
						$rec = $row->RECEPCION;
						/// 1
						/// Obtenemos los productos que estan en una Orden de compra y esperan ser liberados para su recepcion: "PENDIENTES"
						$this->query="SELECT iif(sum(PXR) is null , 0, sum(PXR)) as pendientesOC FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc and pxr > 0 ";   //0
						$rs=$this->EjecutaQuerySimple();
						$rowp=ibase_fetch_object($rs);
						$pendientesOC=$rowp->PENDIENTESOC;
						//// Obtenemos los productos que estan pendientes en una Orden de Compra del sistema de Pegaso.   
						$this->query="SELECT iif(sum(PXR) is null, 0 , sum(PXR)) as pendientes from FTC_POC_DETALLE WHERE IDPREOC = $idpreoc and pxr > 0";
						$rs=$this->EjecutaQuerySimple();
						$rowf=ibase_fetch_object($rs);
						/// 2    
						$pendientesFTC = $rowf->PENDIENTES;
						//// Obtenemps los productos que ya se han validado.
						$this->query="SELECT iif(max(CANT_ACUMULADA) is null, 0, max(CANT_ACUMULADA)) as CantVal FROM VALIDA_RECEPCION WHERE ID_PREOC = $idpreoc ";
						///0
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						$canval = $row2->CANTVAL;

						$this->query="SELECT iif(max(CANTIDAD_REC) is null, 0, max(CANTIDAD_REC)) as CantVal FROM ftc_detalle_recepciones WHERE IDPREOC = $idpreoc ";
						///0
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						$canvalFTC = $row2->CANTVAL;

						$this->query="SELECT SUM(ASIGNADO) AS CANTASIGPEND from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 7";
						$rs = $this->EjecutaQuerySimple();
						$row3 = ibase_fetch_object($rs);
						$cantAsigPend =$row3->CANTASIGPEND;

						$this->query="SELECT SUM(RECIBIDO) AS CANTASIGREC from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 2";
						$rs = $this->EjecutaQuerySimple();
						$row4 = ibase_fetch_object($rs);
						$cantAsigRec =$row4->CANTASIGREC;

						$this->query="SELECT SUM(ASIGNADO) AS CANTASIGDIR from ASIGNACION_BODEGA_PREOC where preoc = $idpreoc and status = 0";
						$rs = $this->EjecutaQuerySimple();
						$row5 = ibase_fetch_object($rs);
						$cantAsigDir =$row5->CANTASIGDIR;
						/// 3 > 4     -----   0 + 180 + 0  + 0
						
						/*echo 'Pendiente: '.$pendientesOC.'<br/>';
						echo 'Pendiente: '.$pendientesFTC.'<br/>';
						echo 'Pendiente: '.$rec.'<br/>';
						echo 'Pendiente: '.$cantAsigPend.'<br/>';
						echo 'Pendiente: '.$cantAsigRec.'<br/>';
						echo 'Pendiente: '.$cantAsigDir.'<br/>';


						echo 'Total:'.($pendientesOC + $pendientesFTC + $canval + $rec + $cantAsigPend +$cantAsigRec + $cantAsigDir).' menos la original '.$canto.' Resultado: '. ($canto - ($pendientesOC + $pendientesFTC + $canval + $rec+ $cantAsigPend +$cantAsigRec + $cantAsigDir)).'<p>';
						*/
						$pp = $canto - ($pendientesOC + $pendientesFTC + $canval + $rec+ $cantAsigPend +$cantAsigRec + $cantAsigDir);
						if($cantidad > $pp){
							$cantidad  =  $pp;
						}
				if( $cantidad > $pp or $pp == 0){
							echo 'La cantidad es mayor  a la solicitada: '.$pendientesOC + $pendientesFTC + $canval.' cantidad maxima '.$canto.'<p>';
							echo 'El pedido necesita: '.$canto.' y hay '.$pendientesOC + $pendientesFTC.' pendientes, por lo que no es posible pedir mas.'.'<p>';
							$this->query="INSERT INTO BODEGA_DUPLICADOS (ID, PROD, CANT, ORIGINAL, RECIBIDO_VALIDADO, COTIZACION, FECHA_COTIZACION, FECHA_VALIDACION, status)
												 VALUES (NULL, '$row->PROD', $canto - $canval, $row->CANT_ORIG, $canval, '$row->COTIZA', '$row->FECHASOL', current_timestamp, 0)";
							$rs=$this->EjecutaQuerySimple();
							$this->query="UPDATE PREOC01 SET RECEPCION = $canval, REC_FALTANTE = $canto - $canval, status='D' where id = $idpreoc";
							$rs=$this->EjecutaQuerySimple();
				}else{
				/// Inicia el analisis de Bodega.		
								$this->query="SELECT count(id) as lineas, sum(restante) as restante FROM INGRESOBODEGA WHERE PRODUCTO = '$ftcart' and restante > 0";
								$rs=$this->EjecutaQuerySimple();
								$row = ibase_fetch_object($rs);
								$lineas = 0;
								if($row->LINEAS > 0 ){
									//echo $this->query.'<br/>';
									//echo 'El Producto se encuentra en: '.$row->LINEAS.' asignacione(s)  con '.$row->RESTANTE.' restantes y la preorden pide: '.$cantidad.'.<br/> '; 
									/// el producto existe en la bodega y tenemos el restante.
									$this->query = "SELECT * from INGRESOBODEGA WHERE PRODUCTO = '$ftcart' and restante > 0";
									$res = $this->EjecutaQuerySimple();
									while ($tsArray=ibase_fetch_object($res)) {
										$data[]=$tsArray;
									}
									$cantPOC = $cantidad;
									echo 'Ingresos en Bodega con restante: '.count($data).'<br/>';
										foreach ($data as $key2) {
											$lineas = $lineas + 1;
											$cantIB= $key2->RESTANTE;
											$prodIB = $key2->PRODUCTO;
											$idIB = $key2->ID;
											$val  = $cantPOC - $cantIB; /// revisamos como se va a afectar, tenemos 3 casos, se solicita lo que hay y el resultado es 0, se solicita menos el resultado es positivo, se solicita mas de lo que hay el resultado es positivo; 
												//400 - 13 = 387
												//8 - 10= -2

											if($val <= 0 ){
												/// hay mas en la bodega.
												////  Se Asignan.
												//// Se elimina la partida para la Preorden.
												$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, PREOC, COTIZA, STATUS, RECIBIDO) VALUES (null, $idIB, $key2->RESTANTE, $cantPOC, $key2->RESTANTE - $cantPOC, current_timestamp,'$usuario', $idpreoc, '$key[6]', 7, 0) ";
												$this->grabaBD();
												$this->query="UPDATE PREOC01 SET ASIGNADO = $cantPOC, REST= REST - $cantPOC, ordenado = ordenado + $cantPOC, status = iif(REST - $cantPOC =0, 'B','N'), canti = canti - $cantPOC where id = $idpreoc";
												$this->EjecutaQuerySimple();
												$this->query="UPDATE INGRESOBODEGA SET ASIGNADO = ASIGNADO + $cantPOC, restante = restante - $cantPOC where id = $idIB";
												$this->EjecutaQuerySimple();
												//echo 'Lineas: '.$lineas.' y valor en $row->Lineas:'.$row->LINEAS.' se analiza el id.'.$idpreoc.' asignado: '.$cantPOC.'<br/>';
												break;
											}elseif($val > 0){
												$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, PREOC, COTIZA, STATUS, RECIBIDO) VALUES (null, $idIB, $key2->RESTANTE, $cantIB, $key2->RESTANTE - $cantIB, current_timestamp,'$usuario', $idpreoc, '$key[6]', 7, 0) ";
												$this->grabaBD();
												$this->query="UPDATE PREOC01 SET ASIGNADO = $cantIB, REST= REST - $cantIB, ordenado = ordenado + $cantIB, status = iif(REST- $cantPOC =0, 'B','N'), canti = canti - $cantIB where id = $idpreoc";
												$this->grabaBD();
												$this->query="UPDATE INGRESOBODEGA SET ASIGNADO = ASIGNADO + $cantIB, restante = restante - $cantIB where id = $idIB";
												$this->grabaBD();
												$cantPOC = $cantPOC - $cantIB;
												//echo '-->Lineas: '.$lineas.' y valor en $row->Lineas:'.$row->LINEAS.' se analiza el id.'.$idpreoc.' asignado: '.$cantIB.'<br/>';
												if($lineas == $row->LINEAS AND $cantPOC > 0){
													$partidasNuevas = array($key[0],$key[1],$key[2],$key[3],$cantPOC, $cantPOC, $key[6],$key[7]);
													$pn[] = $partidasNuevas;
													unset($partidasNuevas);
												}
											}
										}
								}else{
									$partidasNuevas = array($key[0],$key[1],$key[2],$key[3],$key[4],$key[5],$key[6],$key[7]); 
									$pn[] = $partidasNuevas;
									unset($partidasNuevas);
								}
								/// se obtienen todas las partidas que tienen el producto.
							}
				}	
			//echo 'Asi Terminan <br/><br/>';
			//var_dump($pn);
			//break;
			if(count($pn) > 0){
				$this->query="SELECT max(ult_cve) as folio FROM TBLCONTROL01 where ID_TABLA = 80";
				$rs=$this->QueryObtieneDatosN();
				$row = ibase_fetch_object($rs);
				$folioo = $row->FOLIO; /// obtengo el folio Original.
				$folio = $folioo + 1;
				$this->query="UPDATE TBLCONTROL01 SET ULT_CVE = $folio where ID_TABLA = 80";
				$this->grabaBD();
				$rs=$this->crtOrdenDeCompra($pn, $folio);
			}
			return;
	}

		function crtOrdenDeCompra($partidas, $folio){
		$user = $_SESSION['user']->NOMBRE;
		$i = 1;
			$subCostoTotal= 0;
			$subPrecioTotal =0;
			$ivatot=0;
			$desctot=0;
			$this->query="INSERT INTO FTC_POC (CVE_DOC, CVE_PROV, FECHA_DOC, FECHA_PAGO, TP_TES, USUARIO, USUARIO_PAGO, COSTO, PRECIO, IVA, STATUS, Total_IVA, costo_total, fecha_elab, descuento)
		     				values('POC'||$folio, '', current_date, null, NULL,'$user', null, 0, 0, 16, 'Nueva', 0, 0 , current_timestamp, 0)";
							$rs=$this->grabaBD();
		foreach ($partidas as $key){
			$prove = $key[0];
			$idpreoc = $key[1];
			$ftcart = $key[2];
			$costo = $key[3];
			$rest = $key[1];
			$cantidad = $key[4];
			$cotizacion = $key[6];
			$descuento = $key[7];

				echo 'Asi llega la cantidad'.$cantidad.'<p>';
			/// ANALISIS DE LA SITUACION DEL PRODUCTO:
						$this->query = "SELECT * FROM PREOC01 WHERE ID = $idpreoc";
						$rs = $this->EjecutaQuerySimple();
						$row = ibase_fetch_object($rs);
						$canto = $row->CANT_ORIG;
						$cantr = $row->REST;
						$cantord = $row->ORDENADO;
						$rec = $row->RECEPCION;
						/// 1
						/// Obtenemos los productos que estan en una Orden de compra y esperan ser liberados para su recepcion: "PENDIENTES"
						$this->query="SELECT iif(sum(PXR) is null , 0, sum(PXR)) as pendientesOC FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc and pxr > 0 ";   //0
						$rs=$this->EjecutaQuerySimple();
						$rowp=ibase_fetch_object($rs);
						$pendientesOC=$rowp->PENDIENTESOC;
						//// Obtenemos los productos que estan pendientes en una Orden de Compra del sistema de Pegaso.   
						$this->query="SELECT iif(sum(PXR) is null, 0 , sum(PXR)) as pendientes from FTC_POC_DETALLE WHERE IDPREOC = $idpreoc and pxr > 0";
						$rs=$this->EjecutaQuerySimple();
						$rowf=ibase_fetch_object($rs);
						/// 2    
						$pendientesFTC = $rowf->PENDIENTES;
						//// Obtenemps los productos que ya se han validado.
						$this->query="SELECT iif(max(CANT_ACUMULADA) is null, 0, max(CANT_ACUMULADA)) as CantVal FROM VALIDA_RECEPCION WHERE ID_PREOC = $idpreoc ";
						///0
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						$canval = $row2->CANTVAL;


						$this->query="SELECT iif(max(CANTIDAD_REC) is null, 0, max(CANTIDAD_REC)) as CantVal FROM ftc_detalle_recepciones WHERE IDPREOC = $idpreoc ";
						///0
						$rs=$this->EjecutaQuerySimple();
						$row2= ibase_fetch_object($rs);
						$canvalFTC = $row2->CANTVAL;

						/// 3 > 4     -----   0 + 180 + 0  + 0 
						echo 'Total:'.($pendientesOC + $pendientesFTC + $canval + $rec).' menos la original '.$canto.' Resultado: '. ($canto - ($pendientesOC + $pendientesFTC + $canval + $rec)).'<p>';

						$pp = $canto - ($pendientesOC + $pendientesFTC + $canval + $rec);

						if($cantidad > $pp){
							$cantidad  =  $pp;
						}

						$costoTotal = $cantidad * $costo;
						if( $cantidad > $pp or $pp == 0){
							echo 'La cantidad es mayor  a la solicitada: '.$pendientesOC + $pendientesFTC + $canval.' cantidad maxima '.$canto.'<p>';
							echo 'El pedido necesita: '.$canto.' y hay '.$pendientesOC + $pendientesFTC.' pendientes, por lo que no es posible pedir mas.'.'<p>';
							$this->query="INSERT INTO BODEGA_DUPLICADOS (ID, PROD, CANT, ORIGINAL, RECIBIDO_VALIDADO, COTIZACION, FECHA_COTIZACION, FECHA_VALIDACION, status)
												 VALUES (NULL, '$row->PROD', $canto - $canval, $row->CANT_ORIG, $canval, '$row->COTIZA', '$row->FECHASOL', current_timestamp, 0)";
							$rs=$this->EjecutaQuerySimple();
							$this->query="UPDATE PREOC01 SET RECEPCION = $canval, REC_FALTANTE = $canto - $canval, status='D' where id = $idpreoc";
							$rs=$this->EjecutaQuerySimple();
						}else{
							$this->query="SELECT CDFOLIO FROM FTC_COTIZACION WHERE SUBSTRING('$cotizacion' from 1 for 1) = SERIE and folio = substring('$cotizacion' from 2 for 6)";
							$rs=$this->QueryObtieneDatosN();
							$row=ibase_fetch_object($rs);
							$cotfolio = $row->CDFOLIO;
							$this->query="SELECT DBIMPPRE FROM FTC_COTIZACION_DETALLE WHERE CDFOLIO = $cotfolio and cve_art = substring('$ftcart' from 4 for 6)";
							$rs=$this->QueryObtieneDatosN();
							$row= ibase_fetch_object($rs);
							$precio = $row->DBIMPPRE;
							$precioTotal = $cantidad * $precio;
							$this->query="SELECT UM, clave_prod FROM FTC_ARTICULOS WHERE ID = substring('$ftcart' from 4 for 6)";
							$rs=$this->QueryObtieneDatosN();
							$row= ibase_fetch_object($rs);
							$um = $row->UM;
							$cve_prod =$row->CLAVE_PROD;
							$tot_iva = ($costoTotal - $descuento) * .16;
							/// Creamos Partidas ///
							if(($cantidad - $cantr) == 0){
								$nstat = 'X';
							}else{
								$nstat = 'N';
							}
							$this->query= "UPDATE PREOC01 SET ORDENADO = ORDENADO + $cantidad, REST = REST - $cantidad, CANTI = CANT_ORIG - (ORDENADO + $cantidad), status = '$nstat' WHERE ID = $idpreoc ";
							$rs=$this->EjecutaQuerySimple();
							//print_r($rs).'<p>'; 
							//echo $this->query.'<p>';
							if($rs){
								echo 'Rs es verdadero';
								$this->query="INSERT INTO FTC_POC_DETALLE(CVE_DOC, PARTIDA, ART, CANTIDAD, COSTO, PRECIO, COTIZACION, USUARIO, FECHA_ELAB, FECHA_DOC, SERIE, FOLIO, UM, FACCONV, cve_prod, COSTO_TOTAL, PRECIO_TOTAL, idpreoc, tot_iva, PXR, DESCUENTO)
												VALUES('POC'||$folio, $i, '$ftcart', $cantidad, $costo, $precio, '$cotizacion', '$user', current_timestamp, current_date, 'POC', $folio, '$um', 1, '$cve_prod',$cantidad*$costo, $precioTotal, $idpreoc, $tot_iva, $cantidad, $descuento)";
									$rs =$this->EjecutaQuerySimple();
									$i= $i+1;
									$subCostoTotal = $subCostoTotal + $costoTotal;
									$subPrecioTotal =$subPrecioTotal + $precioTotal;
									$ivatot = $ivatot + $tot_iva;
									$desctot += $descuento;
										//echo 'Actualizamos Preorden de Compra: '.$this->query.'<p>';
									//// Afectamos a la tabla de Preorcompra.
							}else{
								echo 'rs es falso';
							}
						}
		}
			if($i > 1){
				$this->query="UPDATE FTC_POC set CVE_PROV = '$prove' , COSTO = $subCostoTotal, PRECIO =  $subPrecioTotal, IVA = 16 , Total_IVA =  $ivatot, costo_total = $subCostoTotal - $desctot + $ivatot, descuento = $desctot where CVE_DOC = 'POC'||$folio";
				$rs=$this->EjecutaQuerySimple();
			//	echo $this->query;
			}

			//break; 
		return;
	}



	function verSolBodega(){
		$usuario = $_SESSION['user']->NOMBRE;
		$rol = $_SESSION['user']->USER_ROL;
		if($rol != 'bodega2'){
				$this->query="SELECT * FROM ASIGNACION_BODEGA_PREOC ab left join preoc01 p on p.id = ab.preoc WHERE FECHA_MOV >= '01.01.2018' AND USUARIO_MOV= '$usuario' AND VERSUM IS NULL";
				$rs =$this->EjecutaQuerySimple();
		}else{
				$this->query="SELECT * FROM ASIGNACION_BODEGA_PREOC ab left join preoc01 p on p.id = ab.preoc WHERE FECHA_MOV >= '01.01.2018' AND (VERSUM IS NULL OR VERSUM = 0)";
				$rs=$this->EjecutaQuerySimple();
		}

		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function quitarSum($ida){
		$rol = $_SESSION['user']->USER_ROL;
		if($rol == 'bodega2'){
			$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET versum = 1 where id = $ida";
			$this->EjecutaQuerySimple();
		}else{
			$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET versum = 0 where id = $ida";
			$this->EjecutaQuerySimple();
		}
		return ;
	}

	function procesarAsigAuto($ida, $tipo){
		if($tipo == 'a'){
			$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET STATUS = 0 WHERE ID = $ida";
			$this->EjecutaQuerySimple();
		}else{
			$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET STATUS = 4 WHERE ID = $ida";
			$this->EjecutaQuerySimple();

			$this->query="SELECT * FROM ASIGNACION_BODEGA_PREOC WHERE ID = $ida";
			$rs=$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($rs);

			$this->query="UPDATE PREOC01 SET STATUS = 'N', REST = REST + $row->ASIGNADO, ORDENADO = ORDENADO - $row->ASIGNADO, CANTI = CANTI + $row->ASIGNADO, asignado = asignado - $row->ASIGNADO WHERE ID = $row->PREOC";
			$this->EjecutaQuerySimple();
				
		}
			$a= array("status"=>'ok');
		
		return $a;
	}



	function datosFTCPOC($idpoc){
		$this->query="SELECT *  FROM CABECERA_POC WHERE CVE_DOC = '$idpoc'";
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		$this->query="SELECT * FROM CABECERA_POC WHERE OC= '$idpoc'";
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return  @$data;
	}

	function detalleFTCPOC($idpoc){
		$this->query="SELECT d.*, current_date as hoy FROM DETALLE_POC d WHERE CVE_DOC = ('$idpoc') and status = 0";
		$rs = $this->EjecutaQuerySimple();
		///echo $this->query;
		//break;
		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		$this->query="SELECT d.*, current_timestamp as hoy from DETALLE_POC D where oc = ('$idpoc') and status = 2";
		@$rs = $this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}

	function verPreOC(){
		$user=$_SESSION['user']->NOMBRE;
		$this->query="SELECT ftc.*, p.nombre, p.emailpred as correo
							FROM FTC_POC ftc
							left join Prov01 p on p.clave = ftc.cve_prov
							WHERE (ftc.STATUS = 'Nueva' or ftc.STATUS = 'En Uso')
							and usuario = '$user'";
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}


	function editaPreoc($idd){
		$this->query="SELECT * FROM DETALLE_POC WHERE ID = $idd";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}


	function eliminaPreOC($poc){
		$this->query="SELECT id FROM FTC_POC_DETALLE WHERE CVE_DOC = '$poc'";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray = ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		foreach ($data as $key) {
			$this->eliminaPartidaPreoc($key->ID);
		}
		$this->query="UPDATE FTC_POC SET STATUS = 'RECHAZADA' WHERE CVE_DOC = '$poc'";
		$rs=$this->EjecutaQuerySimple();
		return;
	}


	function eliminaPartidaPreoc($idd){

		$this->query="SELECT IDPREOC FROM FTC_POC_DETALLE WHERE ID = $idd";
		$res=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($res);
		$idpreoc = $row->IDPREOC;
		//$doa = new idpegaso;
		//$val = $doa->revisaDuplicado($idpreoc);
		
		$this->query="UPDATE FTC_POC_DETALLE SET STATUS = 3 WHERE ID = $idd";
		$rs=$this->EjecutaQuerySimple();
			//// aqui va el codigo para regresarle las partidas canceladas a la tabla de Preoc01 	
			$newCant  = 0;
			$newCost = 0;
			$rs+=$this->editaPartidaPreOC($idd, $newCant, $newCost);

		return;
	}

	function editaPartidaPreOC($idd, $newCant, $newCost){

		echo 'Entro a editar Partida del idd'.$idd.' nueva Cantidad = '.$newCant.' nuevo Costo '.$newCost.'<p>';

		//break;

		$this->query="SELECT STATUS, CANTIDAD, IDPREOC, CVE_DOC, DESCUENTO FROM FTC_POC_DETALLE WHERE ID = $idd ";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$cantActual = $row->CANTIDAD;
		$cvedoc = $row->CVE_DOC;
		$descUnitario = $row->DESCUENTO / $cantActual;
		
					if($row->STATUS == 1){
						$mensaje = 'La Partida se ha cancelado';
						return $mensaje;
					}elseif ($row->STATUS == 2) {
						$mensaje = 'La Pre Orden ya ha sido confirmada, no se pudo cambiar la cantidad';
						return $mensaje; 
					}elseif ($row->STATUS == 0 or $row->STATUS == 3){

			$this->query="SELECT CANT_ORIG, REST, recepcion FROM PREOC01 WHERE ID = $row->IDPREOC";
			$rs=$this->EjecutaQuerySimple();
			$row2=ibase_fetch_object($rs);
			$original = $row2->CANT_ORIG;
			$recepcion = $row2->RECEPCION;
			$rest=$original - $recepcion;

			echo 'Rest = '.$rest;

			if($rest == 0){
				$mensaje= 'Ya se ha recibido el total solicitado, para evitar duplicidad, se cancelara la partida.';
				$this->query="UPDATE FTC_POC_DETALLE SET STATUS = 1 WHERE ID = $idd";
				$rs=$this->EjecutaQuerySimple();
				$this->query="UPDATE PREOC01 SET STATUS = 'B', REST = 0 where id = $key->IDPREOC";
				$rs=$this->EjecutaQuerySimple();
				echo $mensaje;
				//break;
				return $mensaje;
			}elseif ($rest < 0) {
				$mensaje= 'Ya se ha recibido mas del total solicitado, para evitar duplicidad, se cancelara la partida.';
				$this->query="UPDATE FTC_POC_DETALLE SET STATUS = 1 WHERE ID = $idd";
				$rs=$this->EjecutaQuerySimple();
				$this->query="UPDATE PREOC01 SET STATUS = 'B', REST = 0";
				$rs=$this->EjecutaQuerySimple();

				echo $mensaje;
				//break;
				return $mensaje;
			}else{

				$this->query="SELECT iif(SUM(CANTIDAD)is null, 0 , sum(cantidad)) as PENDIENTES FROM FTC_POC_DETALLE WHERE IDPREOC = $row->IDPREOC AND STATUS = 0 and id <> $idd";
				$rs=$this->EjecutaQuerySimple();
				$row1 = ibase_fetch_object($rs);
				$pendientes = $row1->PENDIENTES;
				$total = $pendientes + $newCant;
				//echo $this->query.'<p>';
				//echo 'Total'.$total.'<p>';
				if($total > $rest){
					$mensaje ="Se intenta solicitar mas de lo requerido, favor de revisar, faltante: ".$rest." , solicitado: ".$total.' incluyendo esta Pre Orden';
					echo $mensaje.'<p>';

						$this->query="SELECT CVE_DOC, CANTIDAD, PARTIDA FROM FTC_POC_DETALLE WHERE STATUS = 0 AND IDPREOC = $row->IDPREOC";
						$rs=$this->EjecutaQuerySimple();

						while($tsArray = ibase_fetch_object($rs)){
							$dataA[]=$tsArray;
						}
						foreach ($dataA as $key) {
							echo 'Este producto se encuenta en la Pre Orden: '.$key->CVE_DOC. ', Cantidad: '.$key->CANTIDAD.' partida'.$key->PARTIDA.'<p>';
						}
						echo 'Favor de Cancelar la que mas convenga.';
					//break;
					return $mensaje;
				}elseif ($total <= $rest){
					echo 'Total: '.$total.' Restante'.$rest.'<p>';

					$this->query="UPDATE FTC_POC_DETALLE SET CANTIDAD = $newCant, PXR = $newCant, costo = $newCost, COSTO_TOTAL = $newCant * $newCost, tot_iva = (($newCost*$newCant)*.16), descuento = $descUnitario * $newCant where id=$idd";
					$rs=$this->EjecutaQuerySimple();
					echo $this->query.'<p>';
					//break;
					$this->query="UPDATE FTC_POC SET 
										COSTO = (SELECT SUM(COSTO_TOTAL) FROM FTC_POC_DETALLE WHERE CVE_DOC = '$cvedoc'),
										TOTAL_IVA = (SELECT SUM(TOT_IVA) FROM FTC_POC_DETALLE WHERE CVE_DOC = '$cvedoc'),
										DESCUENTO = (SELECT SUM(DESCUENTO) FROM FTC_POC_DETALLE WHERE CVE_DOC = '$cvedoc'), 
										COSTO_TOTAL = ((SELECT SUM(COSTO_TOTAL) FROM FTC_POC_DETALLE WHERE CVE_DOC = '$cvedoc') + (SELECT SUM(TOT_IVA) FROM FTC_POC_DETALLE WHERE CVE_DOC = '$cvedoc')) 
										WHERE CVE_DOC = '$cvedoc'";
					$rs=$this->EjecutaQuerySimple();
					echo 'Actualiza los Totales '.$this->query.'<p>';
					$mensaje = "Se ha actualizado la partida";
					$nuevo_rest=$rest - $total;

					echo '$nuevo_rest'.$nuevo_rest.'<p>';
					
					if ($nuevo_rest > 0 ) {
						$this->query="UPDATE PREOC01 SET REST = $nuevo_rest, status = 'N', CANTI = $nuevo_rest, ordenado = ordenado - $nuevo_rest where id= $row->IDPREOC";
						$rs=$this->EjecutaQuerySimple();
						echo 'Entro a modificar la cantidad a solicitar';
						if($row->STATUS == 3){
							$this->query="UPDATE FTC_POC_DETALLE SET STATUS = 1 WHERE ID = $idd";
							$rs=$this->EjecutaQuerySimple();	
						}
						
					}
					return $mensaje;
				}
			}
		}			
	}

	function ConfirmaPreOrden($doco, $te, $tptes, $tipo, $conf){
		$usuario= $_SESSION['user']->NOMBRE;
		$this->query="SELECT * FROM FTC_POC_DETALLE WHERE CVE_DOC = '$doco' and status = 0";
		$rs= $this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		$subtotal= 0;

		$this->query="SELECT iif(MAX(FOLIO_OC) is null, 0, max(folio_oc)) AS FOLIO FROM FTC_POC";
		$rs=$this->EjecutaQuerySimple();
		$row = ibase_fetch_object($rs);
		$fn = $row->FOLIO + 1;
		$folio = 'OP'.$fn;

		foreach ($data as $key) {

			$this->query="SELECT REST FROM PREOC01 WHERE ID = $key->IDPREOC";
			$rs=$this->EjecutaQuerySimple();
			$row = ibase_fetch_object($rs);
			$rest=$row->REST;

			$status = '1';

			if($rest > 0 ){
				$status = 'N';				
			}else{
				$status = 'B';
			}

			$this->query="UPDATE PREOC01 SET ORDENADO = $key->CANTIDAD, STATUS = '$status' WHERE ID = $key->IDPREOC";
			$rs=$this->EjecutaQuerySimple();

			$this->query="UPDATE FTC_POC_DETALLE SET STATUS = 2, OC = '$folio' WHERE ID = $key->ID";
			$rs=$this->EjecutaQuerySimple();
			$subtotal = $subtotal + $key->COSTO_TOTAL;
		}

		$this->query="UPDATE FTC_POC SET STATUS = 'ORDEN', OC = '$folio', COSTO = $subtotal, TOTAL_IVA = $subtotal *.16, COSTO_TOTAL = $subtotal *1.16, fecha_oc = current_timestamp, usuario_oc='$usuario', tp_tes_req = '$tptes', tipo = '$tipo', fecha_entrega = '$te', confirmado = '$conf', status_log = 'Nuevo', Docs = 'N', vueltas = 0, folio_oc = $fn where cve_doc = '$doco'";
		$rs=$this->grabaBD();
		//echo $this->query;
		//break;
		return $folio; 
	}



	function traeMaestro($idm, $cvem){
		$this->query="SELECT M.*, 
					(SELECT COUNT(ID) FROM MAESTROS_CCC WHERE CVE_MAESTRO = '$cvem') as CCs,
					(SELECT SUM(PRESUPUESTO_mensual) FROM MAESTROS_CCC WHERE CVE_MAESTRO = '$cvem') as totccs
					 FROM MAESTROS M WHERE CLAVE = '$cvem'";
		$rs=$this->QueryObtieneDatosN();

		//echo $this->query;
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}


	function verCCC($idm, $cvem){
		$this->query="SELECT MCC.*, CL.NOMBRE AS CLIENTE FROM MAESTROS_CCC MCC
					  LEFT JOIN CLIE01 CL ON CL.CLAVE = MCC.INDIVIDUAL
					  WHERE MCC.CVE_MAESTRO = '$cvem'";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}


	function traeIndividuales($cvem){
		$this->query="SELECT * FROM CLIE01 WHERE CVE_MAESTRO = '$cvem'";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		return @$data;
	}

	function creaCC($cvem, $nombre, $contacto, $telefono, $presup, $idm){
		$user=$_SESSION['user']->NOMBRE;

		$this->query="INSERT INTO MAESTROS_CCC(ID, CVE_MAESTRO, PRESUPUESTO_mensual, NOMBRE, COMPRADOR, telefono, USUARIO , FECHA_ALTA, id_maestro) 
							VALUES(null, '$cvem', $presup,'$nombre', '$contacto', '$telefono', '$user', current_timestamp, '$idm' )";
		$rs=$this->EjecutaQuerySimple();

		//echo $this->query;
		//break;
		return;
	}

	function treaeClientesSinCC(){
		$this->query="SELECT CLAVE, NOMBRE, RFC, CALLE, NUMEXT, CAMPLIB7 
					  FROM CLIE01 
					  LEFT JOIN CLIE_CLIB01 ON CLAVE = CVE_CLIE 
					  WHERE (C_COMPRAS IS NULL) and status ='A'";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function verAsociados($cc){
		$this->query="SELECT cl.clave, cl.RFC, cl.nombre, cl.calle, cl.numext, m.nombre as maestro, cc.nombre as ccompra, clib.camplib7, cl.c_compras 
					 FROM CLIE01 cl
					 inner join maestros m on m.clave = cl.cve_maestro
					 inner join maestros_ccc cc on cc.id = cl.c_compras
					 inner join CLIE_CLIB01 clib on clib.cve_clie =cl.clave
					  WHERE C_COMPRAS = $cc";
		$rs = $this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	function asociaCC($cc, $cliente, $cvem){
		$this->query="UPDATE CLIE01 SET C_COMPRAS = $cc, cve_maestro = '$cvem' where CLAVE = '$cliente'";
		$rs=$this->EjecutaQuerySimple();
		return;
	}

	function cancelaAsociacion($cc, $clie){
		$this->query="UPDATE CLIE01 SET C_COMPRAS = null, cve_maestro = '' where CLAVE = '$clie'";
		$rs=$this->EjecutaQuerySimple();
		echo $this->query;
		return;
	}

	function rechazarFTC($idca, $idp, $folio, $urgente){
		$this->query="UPDATE cajas_almacen SET STATUS = 2 WHERE IDca = $idca";
		$rs=$this->EjecutaQuerySimple();

		$this->query="UPDATE FTC_COTIZACION SET INSTATUS = 'RECHAZO BODEGA' WHERE CDFOLIO = $folio";
		$rs=$this->EjecutaQuerySimple();

		$this->query="UPDATE PREOC01 SET STATUS = 'R', PAR = 100 + PAR WHERE COTIZA = '$idp' and status = 'P'";
		$rs=$this->EjecutaQuerySimple();
		// echo $this->query;
		return;
	}

	function aplicacionesAfacturas($fechaIni, $fechaFin){

		$this->query="SELECT * FROM APLICACIONES WHERE FECHA BETWEEN '$fechaIni' and '$fechaFin' and procesado = 0 and cancelado = 0";
		$rs=$this->QueryObtieneDatosN();

		$this->query="UPDATE FACTF01 SET SALDOFINAL = -6  WHERE CVE_DOC = 'A150426'";
		$rs=$this->EjecutaQuerySimple();
		echo 'Este es el resultado'.$rs.'<p>';  
		if($rs){
			echo 'Es verdaero??? existe ';
		}else{
			echo 'Es Verdadero, no existe';
		}
		//break;
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		$i=1;
		foreach ($data as $key){
			
			$this->query="UPDATE FACTF01 SET APLICADO = aplicado + $key->MONTO_APLICADO, 
						 ID_APLICACIONES = iif(id_aplicaciones = '', '$key->ID', id_aplicaciones||', '||'$key->ID'),
						 ID_PAGOS= iif(id_pagos = '', '$key->IDPAGO', id_pagos||', '||'$key->IDPAGO'),
						 PAGOS = PAGOS + $key->MONTO_APLICADO
						 WHERE CVE_DOC = '$key->DOCUMENTO'";
			$rs=$this->EjecutaQuerySimple();

			//echo $this->query.'<p>';
			$i += $i;	

			if($rs == False){
				echo 'AD, Error al aplicar el Documento, '.$key->DOCUMENTO.', de la aplicacion:, '.$key->ID.'<p>';
			}else{
				$this->query="UPDATE APLICACIONES SET PROCESADO = 1 WHERE ID = $key->ID";
				$ra=$this->EjecutaQuerySimple();
				if($ra == False){
					echo 'EAP, No se marco como procesado el pago, '.$key->ID;
				}

				/// actualizacion Carga_Pagos

				$this->query="UPDATE CARGA_PAGOS SET SALDO = MONTO - $key->MONTO_APLICADO, APLICACIONES = APLICACIONES + $key->MONTO_APLICADO WHERE ID= $key->IDPAGO";
				$r=$this->EjecutaQuerySimple();
				if($r == False){
					echo 'Error en el ajuste del saldo al cargo de la aplicacion, '.$key->ID.', del Pago ,'.$key->IDPAGO;
				}
			}
			/// Actualizacion de saldos de facturas.
			$this->query="UPDATE FACTF01 SET SALDOFINAL = IMPORTE - APLICADO WHERE CVE_DOC = '$key->DOCUMENTO'";
			$res=$this->EjecutaQuerySimple();
			if($res == False){
				echo 'No se calculo el saldo correctamente de la factura, '.$key->DOCUMENTO;
			}

			if(substr($key->FORMA_PAGO, 0, 1) == 'A'){
				$this->query="UPDATE ACREEDORES SET APLICADO = iif(aplicado is null, $key->MONTO_APLICADO, APLICADO + $key->MONTO_APLICADO) where id= substring('$key->FORMA_PAGO' FROM 3 FOR 6)";
				$rest=$this->EjecutaQuerySimple();
				if($rest  == False){
					echo "No actualizo: ".$this->query.'<p>';
				}
			}

		}   //// finalizan las actualizaciones en base a las aplicaciones. 
		
		$this->query="SELECT * FROM FACTD01 WHERE FECHAELAB BETWEEN '$fechaIni' and '$fechaFin' and status <> 'C' and aplicado = 0 and serie starting with 'NRB'";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray = ibase_fetch_object($rs)){
			$data2[]=$tsArray;
		}

		foreach ($data2 as $nc) {
			$this->query="UPDATE FACTF01 SET nc_aplicadas = iif(nc_aplicadas = '', '$nc->CVE_DOC', nc_aplicadas||', '||'$nc->CVE_DOC') ,
				importe_nc = importe_nc + $nc->IMPORTE
				where cve_doc = '$nc->DOC_ANT'";
			$result=$this->EjecutaQuerySimple();

			if($result == False){
				echo 'Actualiza factura'.$this->query.'<p>';	
			}
			
			$this->query="UPDATE FACTD01 SET saldo = IMPORTE - $nc->IMPORTE, APLICADO = 1 WHERE CVE_DOC ='$nc->CVE_DOC'";
			$resd=$this->EjecutaQuerySimple();

			if($resd==False){
				echo 'Actualiza NC '.$this->query.'<p>';
			}
			$this->query="UPDATE FACTF01 SET SALDOFINAL = importe - aplicado - $nc->IMPORTE WHERE CVE_DOC = '$nc->DOC_ANT'";
			$res=$this->EjecutaQuerySimple();
		
			if($res == False){
				echo 'Actualiza Saldo'.$this->query.'<p>';	
			}	
		}

		//// actualiza Carga_Pagos
			$this->query="SELECT * FROM ACREEDORES WHERE STATUS = 0 and procesado = 0 ";
			$rs=$this->QueryObtieneDatosN();

			while($tsArray=ibase_fetch_object($rs)){
				$data3[]=$tsArray;
			}

			//var_dump($data3);

			foreach ($data3 as $key){
				$this->query="UPDATE CARGA_PAGOS SET MONTO_ACREEDOR = iif(MONTO_ACREEDOR is null, $key->SALDO, MONTO_ACREEDOR + $key->SALDO) where id= $key->ID_PAGO";
				$result=$this->EjecutaQuerySimple();

				if($result == False){
					echo 'Errror en la actualizacion '.$this->query.'<p>';
				}else{
					$this->query="UPDATE ACREEDORES SET PROCESADO = 1 WHERE ID = $key->ID";
					$rest=$this->EjecutaQuerySimple();
				}
				//echo 'Actualiza Acreedores'.$this->query.'<p>';
			}

			$this->query="UPDATE CARGA_PAGOS SET SALDO = MONTO - APLICACIONES - MONTO_ACREEDOR";
			$res=$this->EjecutaQuerySimple();

		//// cuadre de Carga Pagos
		return;
	}

	function actualizaSaldoM($maestro){

		if($maestro = 'todos'){

			$this->query="UPDATE MAESTROS SET SALDO_2015 = 0, SALDO_2016 = 0, SALDO_2017 = 0, ACREEDOR = 0";
			$res=$this->EjecutaQuerySimple();

			$this->query="SELECT extract(year from fecha_doc) AS ANIO,CVE_MAESTRO ,sum(saldofinal) as SF
			from factf01
			where (deuda2015 is null or (DEUDA2015 = 0))
			group by  extract(year from fecha_doc ), CVE_MAESTRO";	
		}else{


			$this->query="UPDATE MAESTROS SET SALDO_2015 = 0, SALDO_2016 = 0, SALDO_2017 = 0, ACREEDOR = 0, where clave ='$maestro'";
			$res=$this->EjecutaQuerySimple();

			$this->query="SELECT extract(year from fecha_doc) AS ANIO,CVE_MAESTRO ,sum(saldofinal) AS SF
			from factf01
			where (deuda2015 is null or (DEUDA2015 = 0)) AND STATUS <> 'C' AND CVE_MAESTRO ='$maestro'
			group by  extract(year from fecha_doc ), CVE_MAESTRO";
		}
		//echo $this->query;
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		foreach ($data as $key){
			if($key->ANIO == 2016){
				$this->query="UPDATE MAESTROS SET SALDO_2016 = $key->SF where clave ='$key->CVE_MAESTRO'";
				$res=$this->EjecutaQuerySimple();
				//echo $this->query.'<p>';	
			}elseif ($key->ANIO == 2017){
				$this->query="UPDATE MAESTROS SET SALDO_2017 = $key->SF where clave ='$key->CVE_MAESTRO'";
				$res=$this->EjecutaQuerySimple();
				//echo $this->query.'<p>';
			}
		}

		//// Obtenemos el saldo de los acreedores.
		$this->query="SELECT SUM(a.saldo) as saldo, cl.cve_maestro 
			from carga_pagos a 
			left join clie01 cl on trim(cl.clave) = trim(a.cliente) 
			where a.status <> 'C' and tipo_pago is null 
			group by cl.cve_maestro";

		$res=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($res)){
			$data2[]=$tsArray;
		}
		foreach ($data2 as $key){
			$this->query="UPDATE MAESTROS SET ACREEDOR= $key->SALDO where clave = '$key->CVE_MAESTRO'";
			$result =$this->EjecutaQuerySimple();
			if($result == False ){
				echo 'No se actualizo el Maestro: '.$this->query.'<p>';
			}
		}
	}


	function verDocumentosMaestro($maestro){
		$this->query="SELECT f.CVE_MAESTRO,f.CVE_CLPV as Clave, cl.nombre as Cliente, f.cve_doc, f.fecha_doc , f.saldofinal, f.importE, f.PAGOS, f.APLICADO, f.IMPORTE_NC,
					extract(year from f.fecha_doc)as anio, f.deuda2015, f.STATUS, f.ID_APLICACIONES, f.ID_PAGOS, f.nc_aplicadas
					, cp.banco, FOLIO_X_BANCO, FECHA_RECEP, cp.monto, (cp.monto - cp.aplicaciones) As SPago, ac.id as IdA,ac.monto as MA, ac.saldo as sa
					FROM factf01 f
					LEFT JOIN CLIE01 cl on cl.clave = f.cve_clpv
					left join carga_pagos cp on cast(cp.id as varchar(10)) = f.id_pagos
					LEFT JOIN ACREEDORES ac on ac.id = cp.folio_acreedor
					where f.cve_maestro = '$maestro'";
		$rs=$this->QueryObtieneDatosN();
		//echo $this->query;

		while ($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		//sort($data);

		return $data;
	}

	function Cuentas(){
		$this->query="SELECT * from pg_bancos";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function traeDepositos($banco){
		$this->query="SELECT EXTRACT(MONTH FROM CP1.FECHA_RECEP) AS MES ,EXTRACT(YEAR FROM CP1.FECHA_RECEP) AS ANIO, SUM(CP1.MONTO),
					(SELECT SUM(CP.MONTO) FROM CARGA_PAGOS CP WHERE CP.BANCO CONTAINING '$banco' AND EXTRACT(MONTH FROM CP.FECHA_RECEP) =  EXTRACT(MONTH FROM CP1.FECHA_RECEP) AND EXTRACT(YEAR FROM CP.FECHA_RECEP) = EXTRACT(YEAR FROM CP1.FECHA_RECEP) AND TIPO_PAGO IS NULL and CP.status <>'C') AS IPV,
					(SELECT iif(SUM(CP2.MONTO)is null,0,SUM(CP2.MONTO))  FROM CARGA_PAGOS CP2 WHERE CP2.BANCO CONTAINING '$banco' AND EXTRACT(MONTH FROM CP2.FECHA_RECEP) =  EXTRACT(MONTH FROM CP1.FECHA_RECEP) AND EXTRACT(YEAR FROM CP2.FECHA_RECEP) = EXTRACT(YEAR FROM CP1.FECHA_RECEP) AND CP2.TIPO_PAGO = 'oTEC' and CP2.status <> 'C') AS Tec,
					(SELECT iif(SUM(CP3.MONTO)is null,0,SUM(CP3.MONTO))  FROM CARGA_PAGOS CP3 WHERE CP3.BANCO CONTAINING '$banco' AND EXTRACT(MONTH FROM CP3.FECHA_RECEP) =  EXTRACT(MONTH FROM CP1.FECHA_RECEP) AND EXTRACT(YEAR FROM CP3.FECHA_RECEP) = EXTRACT(YEAR FROM CP1.FECHA_RECEP) AND CP3.TIPO_PAGO = 'DC' AND CP3.STATUS <> 'C') AS dCom,
					(SELECT iif(SUM(CP4.MONTO)is null,0,SUM(CP4.MONTO))  FROM CARGA_PAGOS CP4 WHERE CP4.BANCO CONTAINING '$banco' AND EXTRACT(MONTH FROM CP4.FECHA_RECEP) =  EXTRACT(MONTH FROM CP1.FECHA_RECEP) AND EXTRACT(YEAR FROM CP4.FECHA_RECEP) = EXTRACT(YEAR FROM CP1.FECHA_RECEP) AND CP4.TIPO_PAGO = 'DG' AND CP4.STATUS <> 'C') AS dVen,
					(SELECT iif(SUM(CP4.MONTO)is null,0,SUM(CP4.MONTO))  FROM CARGA_PAGOS CP4 WHERE CP4.BANCO CONTAINING '$banco' AND EXTRACT(MONTH FROM CP4.FECHA_RECEP) =  EXTRACT(MONTH FROM CP1.FECHA_RECEP) AND EXTRACT(YEAR FROM CP4.FECHA_RECEP) = EXTRACT(YEAR FROM CP1.FECHA_RECEP) AND CP4.TIPO_PAGO = 'oPCC' AND CP4.STATUS <> 'C') AS oPCC
					 FROM CARGA_PAGOS CP1
					 WHERE CP1.BANCO CONTAINING '$banco' and CP1.status <> 'C'
					 group by EXTRACT(MONTH FROM FECHA_RECEP), EXTRACT(YEAR FROM FECHA_RECEP) order by  EXTRACT(YEAR FROM FECHA_RECEP), EXTRACT(MONTH FROM FECHA_RECEP)";
		$rs=$this->QueryObtieneDatosN();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function traeBanco($banco){
		$this->query="SELECT * FROM PG_BANCOS WHERE NUM_CUENTA = '$banco'";
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function detalleDepositos($banco, $mes, $anio, $tipo){


		if($tipo == 'IPV'){
			$this->query="SELECT ID, CF FROM CARGA_PAGOS WHERE EXTRACT(MONTH FROM FECHA_RECEP ) = $mes AND EXTRACT(YEAR FROM FECHA_RECEP ) = $anio and CF is not null";
			$res=$this->QueryObtieneDatosN();
			while($tsArray=ibase_fetch_object($res)){
				$dataCF[]=$tsArray;
			}
				foreach ($dataCF as $key){
					$idp=$key->ID;
					$cf = $key->CF;
					$cfs = explode(',', $cf);
					$montocf = 0;
					for ($i=0; $i < count($cfs) ; $i++) {
							$this->query="SELECT MONTO FROM CARGO_FINANCIERO WHERE ID = $cfs[$i]";
							$result=$this->QueryObtieneDatosN();
							$row=ibase_fetch_object($result);
							
							if(!empty($row)){
								$monto = $row->MONTO;
								$montocf = $montocf + $monto;
							}
					}
					$this->query="UPDATE CARGA_PAGOS SET MONTO_CF = $montocf where id = $idp";
					$this->EjecutaQuerySimple();
				}

			$this->query="SELECT cp.* 
				FROM CARGA_PAGOS cp 
				WHERE cp.BANCO CONTAINING '$banco' and EXTRACT(MONTH FROM cp.FECHA_RECEP) = $mes and EXTRACT(YEAR FROM cp.FECHA_RECEP) = $anio AND tipo_pago is null and status<> 'C' order by cp.fecha_recep asc";
		}elseif($tipo =='Total'){
			$this->query="SELECT cp.* 
				FROM CARGA_PAGOS cp 
				WHERE cp.BANCO CONTAINING '$banco' and EXTRACT(MONTH FROM cp.FECHA_RECEP) = $mes and EXTRACT(YEAR FROM cp.FECHA_RECEP) = $anio and status<> 'C' order by cp.fecha_recep asc";
		}else{
			$this->query="SELECT cp.*
				FROM CARGA_PAGOS cp 
				WHERE cp.BANCO CONTAINING '$banco' and EXTRACT(MONTH FROM cp.FECHA_RECEP) = $mes and EXTRACT(YEAR FROM cp.FECHA_RECEP) = $anio and status<> 'C'  AND tipo_pago = '$tipo' order by cp.fecha_recep asc";
		}
	
		$rs=$this->QueryObtieneDatosN();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return @$data;
	}

	  function traeMesesVenta(){
    	$this->query="SELECT NOMBRE, NUMERO, ANHIO, 
    				(SELECT SUM(IMPORTE) FROM FACTF01 WHERE FECHA_DOC BETWEEN FECHA_INI AND FECHA_FIN) AS FACTURADO,
    				(SELECT SUM(IMPORTE) FROM FACTF01 WHERE FECHA_DOC BETWEEN FECHA_INI AND FECHA_FIN AND STATUS = 'C') AS CANCELADO,
    				(SELECT SUM(IMPORTE_NC) FROM FACTF01 WHERE FECHA_DOC BETWEEN FECHA_INI AND FECHA_FIN) AS DEVUELTO,
    				(SELECT SUM(SALDOFINAL) FROM FACTF01 WHERE FECHA_DOC BETWEEN FECHA_INI AND FECHA_FIN) AS PENDIENTE
    				FROM PERIODOS_2016 
    				order by anhio, numero";
    	$rs=$this->QueryObtieneDatosN();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function traeDetalle($mes, $anio, $tipo){

    	$this->query="SELECT FECHA_INI, FECHA_FIN FROM PERIODOS_2016 WHERE NUMERO = $mes and anhio = $anio";
    	$rs=$this->QueryObtieneDatosN();
    	$row=ibase_fetch_object($rs);
    	$fi = $row->FECHA_INI;
    	$ff = $row->FECHA_FIN;

    	//echo $tipo;

    	if($tipo == 'venta'){
				$this->query="SELECT f.*, cl.nombre, 
					(select folio_x_banco from carga_pagos where cast(id as varchar(10)) in (id_pagos)) as Banco  
					FROM FACTF01 f
					left join clie01 cl on cl.clave = cve_clpv
					WHERE FECHA_DOC BETWEEN '$fi' and '$ff' order by cve_doc";
    			
    	}elseif ($tipo == 'canceladas') {
    			$this->query="SELECT f.*, cl.nombre, 
					(select folio_x_banco from carga_pagos where cast(id as varchar(10)) in (id_pagos)) as Banco  
					FROM FACTF01 f
					left join clie01 cl on cl.clave = cve_clpv
					WHERE FECHA_DOC BETWEEN '$fi' and '$ff' and f.status = 'C' order by cve_doc ";	
    	}elseif ($tipo == 'devueltas') {
    			$this->query="SELECT f.*, cl.nombre, 
					(select folio_x_banco from carga_pagos where cast(id as varchar(10)) in (id_pagos)) as Banco  
					FROM FACTF01 f
					left join clie01 cl on cl.clave = cve_clpv
					WHERE FECHA_DOC BETWEEN '$fi' and '$ff' and importe_nc <> 0 order by cve_doc ";
    	}elseif ($tipo=='ventaReal') {
    			$this->query="SELECT f.*, cl.nombre, 
					(select folio_x_banco from carga_pagos where cast(id as varchar(10)) in (id_pagos)) as Banco  
					FROM FACTF01 f
					left join clie01 cl on cl.clave = cve_clpv
					WHERE FECHA_DOC BETWEEN '$fi' and '$ff' order by cve_doc";
    	}elseif ($tipo =='detalleAnual') {
    			$this->query="SELECT f.*, cl.nombre, 
					(select folio_x_banco from carga_pagos where cast(id as varchar(10)) in (id_pagos)) as Banco  
					FROM FACTF01 f
					left join clie01 cl on cl.clave = cve_clpv
					WHERE extract(year from fecha_doc) = $anio order by cve_doc";
    	}elseif ($tipo == 'pendientes'){
			$this->query="SELECT f.*, cl.nombre
					 FROM FACTF01 f
					 left join clie01 cl on cl.clave = f.cve_clpv
					  WHERE SALDOFINAL > 10 AND EXTRACT(MONTH FROM FECHA_DOC) = $mes and extract(year from fecha_doc) = $anio";
		}
    	
    	$rs = $this->QueryObtieneDatosN();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	//var_dump($data);
    	//break;
    	return $data;
    }

    function verAcreedores2(){

    	/*
    	$this->query="SELECT cp.fecha_recep as indice,('A-'||a.id) as ID, id_pago, cp.folio_x_banco, cp.MONTO as monto_original, cl.nombre, cp.FECHA_RECEP, a.monto, a.aplicado, a.saldo, a.status , a.cliente
    				FROM ACREEDORES a
    				left join CARGA_PAGOS cp on cp.id  = a.id_pago
    				left join CLIE01 cl on cl.clave = a.cliente
    				 WHERE a.SALDO > 5
    				 order by cp.fecha_recep";
    	$rts=$this->QueryObtieneDatosN();

    	while ($tsArray=ibase_fetch_object($rts)) {
    		$data[]=$tsArray;
    	}*/

    	$this->query="SELECT cp.ID, id AS id_pago, cp.folio_x_banco, cp.monto as monto_original, cl.nombre, cp.fecha_recep, cp.monto, cp.aplicaciones as aplicado, cp.saldo, cp.status, cliente 
    				  FROM CARGA_PAGOS cp
    				  left join clie01 cl on cl.clave = cp.cliente
    				  WHERE cp.saldo > 5
    				  AND cp.TIPO_pago is null
    				  AND cp.STATUS <> 'C' 
    				  order by cp.fecha_recep";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}


    	//var_dump($data);
    	//sort($data);

    	return $data;
    }

    function reasignaAcreedor($nclie, $ida, $oldclie, $saldo){

    	$nclie=explode(':', $nclie);
    	$clave =$nclie[0]; 

    	$this->query="SELECT CVE_MAESTRO FROM CLIE01 WHERE CLAVE = '$clave'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$cvem = $row->CVE_MAESTRO;

    	echo 'Saldo a sumar en el Maestro: '.$saldo.'<p>';

    	$this->query="SELECT SUM(SALDOFINAL) AS SALDOF FROM FACTURAS WHERE CLAVE_MAESTRO ='$cvem'";
    	$res=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($res);
    	$saldoActual = $row->SALDOF;

    	$this->query="SELECT ACREEDOR FROM MAESTROS WHERE CLAVE = '$cvem'";
    	$res=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($res);
    	$acreedorActual=$row->ACREEDOR;

    	$total = $saldoActual - ($saldo + $acreedorActual);

    	if ($total > 0 ){
    		$this->query="UPDATE carga_pagos SET cve_maestro = (select cve_maestro from clie01 where clave = '$clave'), cliente = '$clave' where id = $ida";
	    	$rs = $this->EjecutaQuerySimple();

    		$this->query="SELECT sum(SALDO) as Saldom, CVE_MAESTRO FROM CARGA_PAGOS WHERE STATUS <> 'C' AND TIPO_PAGO IS NULL group by CVE_MAESTRO";
    		$res = $this->EjecutaQuerySimple();

    		while($tsArray=ibase_fetch_object($res)){
    			$data[]=$tsArray;
    		} 

    		foreach($data as $key){
    			$claveM = $key->CVE_MAESTRO;
    			$monto = $key->SALDOM;

    			if($monto < 0 and $monto > -10){
    			$monto = 0;
    			}

    			$this->query="UPDATE MAESTROS SET ACREEDOR = $monto where clave ='$claveM'";
    			$result =$this->EjecutaQuerySimple();
    		}
    	}else{
    		echo '<label>'.'EL SALDO ($ '.number_format($saldoActual,2).') DEL MAESTRO ES MENOR A LA SUMA DE LOS ACREEDORES ($ '.number_format(($saldo + $acreedorActual),2).') NO SE PUEDE GENERAR SALDOS NEGATIVOS EN MAESTROS.'.'<br/>'.' REVISE LA INFORMACION'.'</label>';
    	}	
    	return;
    }


    function verFolio2015(){
    	$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = 2015 order by cve_doc";
    	$rs=$this->EjecutaQuerySimple();

    	//echo $this->query;
    	while($tsArray= ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function verAplicaciones2($anio, $tipo){

    	if($tipo == 'factura' and $anio != 'todo'){
			$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = $anio order by cve_doc";
    	}elseif ($tipo == 'aplicacion' and $anio != 'todo') {
    		$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = $anio order by cve_doc";
    	}elseif ($tipo == 'pagos' and $anio != 'todo'){
    		$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = $anio order by cve_doc";
    	}elseif ($tipo == 'factura' and $anio == 'todo') {
    		$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = $anio order by cve_doc";
    	}elseif ($tipo == 'aplicacion' and $anio == 'todo') {
    		$this->query="SELECT * 
    				FROM FACTF01 
    				left join clie01 cl on cl.clave = cve_clpv
    				left join carga_pagos cp on cast(cp.id as varchar(10)) = id_pagos and  id_pagos not containing(',')
    				WHERE APLICADO > 1 AND EXTRACT(YEAR FROM FECHA_DOC) = $anio order by cve_doc";
    	}elseif ($tipo == 'pagos' and $anio == 'todo') {
    		$this->query="SELECT * 
    				FROM CARGA_PAGOS cp
    				left join factf01 f on f.id_pagos containing (cp.id)
    				left join clie01 cl on cl.clave = f.cve_clpv
    				WHERE cp.status <> 'C' and tipo_pago is null 
    				order by cp.id";
    	}
    			
    	

    	$rs = $this->EjecutaQuerySimple();
    	
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }


    function asignaAcreedor(){
    	/*$this->query="SELECT * FROM CARGA_PAGOS WHERE (CLIENTE IS NULL or cliente = '') and saldo <> monto and saldo > 1";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	foreach ($data as $key){
    		$this->query="SELECT FIRST 1  CVE_CLPV FROM FACTF01 WHERE ID_PAGO CONTAINING ('$key->ID')";
    		$rs=$this->EjecutaQuerySimple();
    		$row=ibase_fetch_object($rs);
    		$cliente = $row->CVE_CLPV;
    		$this->query="UPDATE CARGA_PAGOS SET CLIENTE = '$cliente' where id = $key->ID";
    		$rs=$this->EjecutaQuerySimple();
    	echo 'Se actualizo: ,'.$key->ID.', con el cliente, '.$cliente.'<p>';
    	}
		*/

    	$this->query="UPDATE CARGA_PAGOS SET APLICACIONES = 0";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query = "SELECT * FROM APLICACIONES WHERE CANCELADO = 0";
    	$rs = $this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data2[]=$tsArray;
    	}

    	foreach ($data2 as $key) {
    		$idp = $key->IDPAGO;
    		$this->query = "UPDATE CARGA_PAGOS SET SALDO = MONTO - (APLICACIONES + $key->MONTO_APLICADO) + MONTO_CF - MONTO_ACREEDOR, APLICACIONES = aplicaciones + $key->MONTO_APLICADO WHERE ID = $idp";
    		$rs1=$this->EjecutaQuerySimple();
    		echo 'Proceso el pago '.$idp.'<p>';
    	}

    	return;
    }

    function detallePagoFactura($docf){
    	$this->query="SELECT a.id as idaplicacion, cp.id as idpago, cl.nombre as cliente, f.importe , a.documento, cp.folio_x_banco as banco , cp.fecha_recep, a.monto_aplicado
    				FROM APLICACIONES a
    				left join factf01 f on f.cve_doc = a.documento
    				left join clie01 cl on f.cve_clpv = cl.clave
    				left join carga_pagos cp on cp.id = a.idpago
    				WHERE a.DOCUMENTO = '$docf' and cancelado = 0 ORDER BY a.FECHA ";

    				//echo $this->query;
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }

    function detallePago2($ida){
    	$this->query="SELECT cp.folio_x_banco, cp.id AS IDPAGO, cp.fecha_recep, cp.banco, cp.monto, cp.saldo, a.id as idaplicacion, a.monto_aplicado, a.fecha, a.CANCELADO AS STATUS, a.documento, cl.nombre as cliente from carga_pagos cp 
    				left join aplicaciones a on a.idpago = cp.id
    				left join factf01 f on f.cve_doc = a.documento
    				left join clie01 cl on cl.clave = f.cve_clpv
    				where cp.id = $ida";

    		$rs=$this->EjecutaQuerySimple();
    		while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    		}
    		return @$data;
    }

    function verCPNoIdentificados(){
    	$this->query="SELECT cp.ID, id AS id_pago, cp.folio_x_banco, cp.monto as monto_original, cl.nombre, cp.fecha_recep, cp.monto, cp.aplicaciones as aplicado, cp.saldo, cp.status, cliente 
    				  FROM CARGA_PAGOS cp
    				  left join clie01 cl on cl.clave = cp.cliente
    				  WHERE cp.saldo > 5
    				  AND cp.TIPO_pago is null
    				  AND cp.STATUS <> 'C' 
    				  AND cp.CVE_MAESTRO IS NULL
    				  order by cp.fecha_recep";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}


    	//var_dump($data);
    	//sort($data);

    	return $data;
    }

    function liberarFactura($docf){
    	$this->query="SELECT * FROM APLICACIONES WHERE DOCUMENTO = '$docf' and cancelado = 0";
    	$rs =$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key) {
    		$doc=$key->DOCUMENTO;
    		$ida=$key->ID;
    		$idp=$key->IDPAGO;
    		

    		$this->query="UPDATE APLICACIONES SET CANCELADO = 1 WHERE ID = $key->ID";
    		$res=$this->EjecutaQuerySimple();

    		$this->query="UPDATE CARGA_PAGOS SET APLICACIONES = APLICACIONES - $key->MONTO_APLICADO WHERE ID = $key->IDPAGO";
    		$res=$this->EjecutaQuerySimple();

    		$this->query="UPDATE FACTF01 SET PAGOS = PAGOS - $key->MONTO_APLICADO, aplicado = aplicado - $key->MONTO_APLICADO WHERE CVE_DOC = '$key->DOCUMENTO'";
    		$res=$this->EjecutaQuerySimple();

    		$this->query="UPDATE CARGA_PAGOS SET SALDO = MONTO - APLICACIONES + iif(MONTO_CF is null, 0, MONTO_CF) where id = $key->IDPAGO";
    		$result=$this->EjecutaQuerySimple();

    		$this->query="UPDATE FACTF01 SET SALDOFINAL = IMPORTE - APLICADO - IMPORTE_NC WHERE CVE_DOC ='$key->DOCUMENTO'";
    		$result=$this->EjecutaQuerySimple();
    	}

    		$this->query = "SELECT * FROM CARGA_PAGOS WHERE ID=$idp";
    		$rs=$this->EjecutaQuerySimple();
    		$row =ibase_fetch_object($rs);
    		$saldoCP = $row->SALDO;
    		$folioCP =$row->FOLIO_X_BANCO;
    		$fechaCP =$row->FECHA_RECEP;
    		$bancoCP =$row->BANCO;
    		$this->query= "SELECT * FROM FACTF01 WHERE CVE_DOC ='$doc'";
    		$rs=$this->EjecutaQuerySimple();
    		$row=ibase_fetch_object($rs);
    		$saldoFact=$row->SALDOFINAL;
    		echo 'Se han cancelado las aplicaciones de la factura: '.$doc.' los pago(s) afectado(s) son '.$idp;
    	return;
    }

    function liberarNCCancelada($docf){
    	$this->query="SELECT * FROM FACTD01 WHERE CVE_DOC = '$docf' and status = 'C' and aplicado <> 2";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	if($row == True){
    	$docANT =$row->DOC_ANT;
    	$importe = $row->IMPORTE;
    	}

    	if(!empty($docANT)){
    		$this->query="UPDATE FACTF01 SET IMPORTE_NC = IMPORTE_NC - $importe, saldofinal = saldofinal + $importe, nc_aplicadas = '' where cve_doc = '$docANT'";
    		$rs=$this->EjecutaQuerySimple();

    		echo $this->query;

    		$this->query="UPDATE FACTD01 SET APLICADO = 2 WHERE CVE_DOC = '$docf'";
    		$rs=$this->EjecutaQuerySimple();
    		echo $this->query;

    		$this->query="SELECT * FROM FACTD01 WHERE DOC_ANT = '$docANT' AND STATUS <> 'C'";
    		$rs=$this->EjecutaQuerySimple();

    		while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    		}

    		if(!empty($data)){
    			foreach ($data as $key) {
    				$this->query="UPDATE FACTF01 SET NC_APLICADAS = iif(nc_aplicadas = '' or nc_aplicadas is null, '$key->CVE_DOC', NC_APLICADAS||', '||'$key->CVE_DOC') WHERE CVE_DOC = $key->DOC_ANT";
    				$rs=$this->EjecutaQuerySimple();
    			}
    		}
    	}

    	return;
    }


    function infoMaestro($idm){
    	$this->query="SELECT * FROM MAESTROS WHERE ID = $idm";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function infoSucursales($cvem){
    	/*
    	$this->query="SELECT  f.cve_clpv, sum(f.saldofinal) as total, 
        (select max(nombre) from clie01 where clave = f.cve_clpv) as nombre,
        (select max(diascred) from clie01 where clave = f.cve_clpv) as plazo,
        (select max(limcred) from clie01 where clave = f.cve_clpv) as linea_cred,
        (select sum(saldofinal) from factf01 where extract(year from fecha_doc) = 2017 and f.cve_clpv = cve_clpv) as s17,
        (select sum(saldofinal) from factf01 where extract(year from fecha_doc) = 2016 and f.cve_clpv = cve_clpv) as s16,
        (select sum(saldofinal) from factf01 where status_fact = 'Cobranza' and cve_clpv = f.cve_clpv and extract(year from fecha_doc) >= 2016) as cobranza,
        (select sum(saldofinal) from factf01 where status_fact = 'Revision' and cve_clpv = f.cve_clpv and extract(year from fecha_doc) >= 2016) as revision,
        (select sum(saldofinal) from factf01 where status_fact = 'Logistica' and cve_clpv = f.cve_clpv and extract(year from fecha_doc) >= 2016) as logistica
        from factf01 f
        where cve_maestro = '$cvem'
        AND extract(year from fecha_doc) >=2016
        group by cve_clpv
		";
		*/

		$this->query="SELECT cl.clave as cve_clpv,
			         sum(f.saldofinal) as total,
			         max(cl.nombre) as nombre,
			         max(cl.diascred) as plazo,
			         max(cl.limcred) as linea_cred ,
			         (select sum(saldofinal) from factf01 where extract(year from fecha_doc) = 2017 and cl.clave = cve_clpv) as s17,
			         (select sum(saldofinal) from factf01 where extract(year from fecha_doc) = 2016 and cl.clave = cve_clpv) as s16,
			         (select sum(saldofinal) from factf01 where status_fact = 'Cobranza' and cve_clpv = cl.clave and extract(year from fecha_doc) >= 2016) as cobranza,
			         (select sum(saldofinal) from factf01 where status_fact = 'Revision' and cve_clpv = cl.clave and extract(year from fecha_doc) >= 2016) as revision,
			         (select sum(saldofinal) from factf01 where status_fact = 'Logistica' and cve_clpv = cl.clave and extract(year from fecha_doc) >= 2016) as logistica
			         FROM CLIE01 cl
			         left join facturas f on cl.clave = f.cve_clpv
			         WHERE CVE_MAESTRO = '$cvem' and cl.status <> 'S' and cl.status <> 'B'
			         group by cl.clave";

		//echo $this->query;


    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function docsMaestro($cvem){
    	$this->query="SELECT * FROM FACTURAS WHERE CLAVE_MAESTRO = '$cvem'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function docsSucursal($cvecl){
    	$this->query="SELECT * FROM FACTURAS WHERE CVE_CLPV='$cvecl'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }


    function infoDocumentos($items){
    	$doc=explode(',', $items);
    	for ($i=0; $i < count($doc); $i++) { 
    		$docf = $doc[$i];
    		$this->query="SELECT f.*, nombre from factf01 f left join clie01 on clave = cve_clpv where cve_doc = '$doc[$i]'";
    		//echo $this->query;
    		$rs=$this->EjecutaQuerySimple();
    		while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    		}
    	}
    	return @$data;
    }

    function verPagos3($pagos, $mes, $anio){
    	if($mes != ''){
	    	$this->query="SELECT * FROM CARGA_PAGOS WHERE UPPER(BANCO) CONTAINING UPPER('$pagos') and extract(month from fecha_recep ) = $mes and extract(year from fecha_recep) = $anio and tipo_pago is null and status<>'C'";
			$rs=$this->EjecutaQuerySimple();
	    	while ($tsArray=ibase_fetch_object($rs)) {
	    		$data[]=$tsArray;
	    	}
	    }else{
	    	$this->query="SELECT * FROM CARGA_PAGOS WHERE MONTO CONTAINING ('$pagos')";
	    	$rs=$this->EjecutaQuerySimple();
	    	while ($tsArray=ibase_fetch_object($rs)) {
	    		$data[]=$tsArray;
	    	}
	    	$this->query="SELECT * FROM CARGA_PAGOS WHERE UPPER(FOLIO_X_BANCO) CONTAINING UPPER('$pagos')";
	    	$rs=$this->EjecutaQuerySimple();
	    	while ($tsArray=ibase_fetch_object($rs)) {
	    		$data[]=$tsArray;
	    	}
    	}	

    	return @$data;    	
    }

    function aplicarPago2($idp, $saldop, $items, $total){
    	$resultado = $saldop - $total;
    	$user = $_SESSION['user']->NOMBRE;

    		/// Saldo 10,000.00 Facturas 8,000.00 resultaod 2,000.00
    	if($resultado >= 0 ){
    		$docf= explode(',', $items);
    		var_dump($docf);
    		//echo 'Numero de facturas a Afectar'.count($docf).'<p>';
    		//echo 'Resultado: '.$resultado.'<p>';
    		for($i=0;$i<count($docf); $i++){
    			//echo 'Documento'.$docf[$i].'<p>';
    			$this->query = "SELECT * FROM FACTF01 WHERE CVE_DOC = '$docf[$i]'";
    			$rs=$this->EjecutaQuerySimple();
    			$row = ibase_fetch_object($rs);
    			/// isnertamos la nueva aplicacion.
	    			if($row->SALDOFINAL > 0){

	    			$this->query="INSERT INTO APLICACIONES (ID, FECHA, IDPAGO, DOCUMENTO, MONTO_APLICADO, USUARIO, STATUS, RFC, FORMA_PAGO, CANCELADO, PROCESADO, CIERRE_CC, REC_CONTA) 
	    									VALUES (NULL, current_timestamp, $idp, '$docf[$i]', $row->SALDOFINAL, '$user','E' ,'$row->RFC', '$idp', 0,  0, 0, 0)";
	    			$res=$this->EjecutaQuerySimple();
	    			/// Calculamos los nuevos saldo y totales.
	    			// Saldo del Pago
	    			$this->query="UPDATE CARGA_PAGOS SET APLICACIONES = APLICACIONES + $row->SALDOFINAL WHERE ID = $idp";
	    			$rs = $this->EjecutaQuerySimple();

	    			/// Saldo del Documento

	    			$this->query="UPDATE FACTF01 SET aplicado = aplicado + $row->SALDOFINAL, pagos = pagos + $row->SALDOFINAL, SALDOFINAL = IMPORTE - $row->SALDOFINAL - $row->IMPORTE_NC - APLICADO
	    							WHERE CVE_DOC = '$row->CVE_DOC'";
	    			$res=$this->EjecutaQuerySimple();

	    			$this->query="SELECT MAX(ID) as ID  FROM APLICACIONES WHERE DOCUMENTO = '$row->CVE_DOC' and PROCESADO = 0";
	    			$res=$this->EjecutaQuerySimple();
	    			$row2=ibase_fetch_object($res);
	    			//echo $this->query.'<p>';

	    			$this->query="UPDATE APLICACIONES SET PROCESADO = 1 WHERE ID = $row2->ID";
	    			$result=$this->EjecutaQuerySimple();

	    			// Actualizamos la factura con sus pagos;
	    			$this->query="UPDATE FACTF01 SET ID_APLICACIONES = IIF(id_aplicaciones is null or id_aplicaciones= '', '$row2->ID', id_aplicaciones||', '||'$row2->ID'),
	    			 id_pagos= iif(id_pagos is null or id_pagos='', '$idp', id_pagos||', '||'$idp')
	    			 where cve_doc = '$row->CVE_DOC'";
	    			$rs=$this->EjecutaQuerySimple();
	    			//echo $this->query.'<p>';
	    			/// final
	    			/// Analizamos la situacion del cliente
		    			$this->query="SELECT * FROM CLIE01 WHERE CLAVE = '$row->CVE_CLPV'";
		    			//echo 'Traemos al cliente'.$this->query.'<p>';

		    			$res4=$this->EjecutaQuerySimple();
		    			$row4 = ibase_fetch_object($res4);
		    			if(!empty($row4->STATUS_COBRANZA)){
		    					//echo 'El cliente esta suspendido'.'<p>';
								$this->query="SELECT min(datediff(day from current_date to fecha_vencimiento)) as dias, COUNT(CVE_DOC) AS DOCS 
												from factf01
											    where cve_clpv = '$row4->CLAVE'
											        and status_fact = 'Cobranza'
											        and extract(year from fecha_doc) >= 2016
											        and saldofinal >= 5 ";
								$rs5 = $this->EjecutaQuerySimple();
								$row5 = ibase_fetch_object($rs5);

								//echo 'Traemos los documentos : '.$this->query.'<p>';

								if ($row5->DIAS > -7){
								//	echo 'Ya no tiene documentos';
									$this->query="UPDATE CLIE01 SET STATUS_COBRANZA = NULL, inicio_corte = null, finaliza_corte= null, monto_cobranza= 0 , saldo_monto_cobranza = 0 where clave ='$row4->CLAVE'";
									$rs=$this->EjecutaQuerySimple();
								//	echo 'Libera el Cliente'.$this->query.'<p>';
								}
		    			}
	    			}else {

	    			//break;
	    			return $row->CVE_CLPV;
    				}
    		}
    	}else{
    		echo 'El pago es parcial';
    	}
    	//break;
    	return $row->CVE_CLPV;
    }

    function aplicacionesSinReciboConta(){
    	$this->query="SELECT idpago 
    					FROM APLICACIONES 
    					WHERE usuario_rec_conta is null and status <> 'C' and cancelado = 0 and extract(month from fecha) > 1 and extract(year from fecha) >= 2017
    					group by idpago";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key) {
    		$idp= $key->IDPAGO;

    		$this->query="SELECT * FROM CARGA_PAGOS WHERE ID = $idp";
    		$res=$this->EjecutaQuerySimple();

    		while($tsArray=ibase_fetch_object($res)){
    			$data2[]=$tsArray;
    		}
    	}

    	return @$data2;
    }


    function liberaPedidovsNC($docp, $docd){

    	$docp=strtoupper($docp);
    	$docd= strtoupper($docd);


    	//NRB3 1831
    	///PY126
    	echo $docp;
    	echo $docd;

    	$this->query="SELECT * FROM PAR_FACTD01 WHERE CVE_DOC = '$docd' ";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    		}

    	foreach ($data as $key) {
    		$this->query="SELECT * FROM PAR_FACTP01 WHERE CVE_DOC = '$docp' and CVE_ART = '$key->CVE_ART'";
    		$res=$this->EjecutaQuerySimple();
    		$row = ibase_fetch_object($res);
    		$cantp = $row->CANT;

    		$this->query="UPDATE FACTP01 SET DOC_SIG = NULL, ENLAZADO = 'O' WHERE CVE_DOC = '$docp'";
    		$this->EjecutaQuerySimple();

    		if($key->CANT > $cantp){
    			$this->query="UPDATE PAR_FACTP01 SET pxs = cant where CVE_ART = '$key->CVE_ART' and cve_doc = '$docp'";
	    		$rs=$this->EjecutaQuerySimple();

    		}else{
    			$this->query="UPDATE PAR_FACTP01 SET pxs = pxs + $key->CANT where CVE_ART = '$key->CVE_ART' and cve_doc = '$docp'";
	    		$rs=$this->EjecutaQuerySimple();
    		}
    	}

    	return;
    }

    function verCargaPagosCXC(){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE CIERRE_CONTA IS NULL and status <> 'C'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return  @$data; 
    }


    function verCargaPagosCXCCerrados(){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE CIERRE_CONTA = 1 and status <> 'C'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return  @$data; 
    }

    function verCargaPagosCXCAcreedores(){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE CIERRE_CONTA = 4 and status <> 'C'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return  @$data; 	
    }

    function cerrarPago($idp){
    	$this->query="UPDATE carga_pagos set cierre_conta = 1 where id = $idp";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }

    function solAcreedor($idp, $saldo){
    	$this->query="UPDATE CARGA_PAGOS SET cierre_conta = 4 where id= $idp";
    	$rs=$this->EjecutaQuerySimple();
    	return;
    }

    function recCierreCob(){
    	$this->query="SELECT * FROM CARGA_PAGOS WHERE (CIERRE_CONTA = 1 or cierre_conta = 4)  and status <> 'C'";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return  @$data; 
    }

    function solRestriccion($cveclie){
    	$usuario=$_SESSION['user']->NOMBRE;
    	$this->query ="INSERT INTO SOL_CLIENTES (ID, CVE_CLPV, FECHA_SOL, USUARIO_SOL, FECHA_RES, USUARIO_RES, STATUS) 
    						  VALUES (NULL, '$cveclie', current_timestamp, '$usuario', null, '', 1)";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }

    function solCorte($cveclie){
    	$usuario=$_SESSION['user']->NOMBRE;
    	$this->query ="INSERT INTO SOL_CLIENTES (ID, CVE_CLPV, FECHA_SOL, USUARIO_SOL, FECHA_RES, USUARIO_RES, STATUS) 
    						  VALUES (NULL, '$cveclie', current_timestamp, '$usuario', null, '', 2)";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }


    function traeSolicitudesR($cliente){
    	$this->query="SELECT COUNT(CVE_CLPV) FROM SOL_CLIENTES WHERE STATUS = 1 and cve_clpv = '$cliente'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$sol=$row->COUNT;
    	return $sol;
    }

    function traeSolicitudesC($cliente){
    	$this->query="SELECT COUNT(CVE_CLPV) FROM SOL_CLIENTES WHERE STATUS = 2 and cve_clpv = '$cliente' ";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$sol=$row->COUNT;
    	return $sol;	
    }

    function verSolClientes(){
    	$this->query="SELECT sc.id, sc.CVE_CLPV, cl.NOMBRE, sc.fecha_sol, sc.usuario_sol, sc.status, m.NOMBRE AS MAESTRO, cl.cve_maestro, cl.limcred, cl.diascred,
    	(select sum(saldofinal) from facturas where cve_clpv = sc.cve_clpv and status_fact = 'Cobranza') as saldoCobranza ,
    	(select sum(fp.importe) from factp01 fp where fp.cve_clpv = sc.cve_clpv and fp.status <> 'C' and (tip_doc_sig is null or tip_doc_sig = '')) as montoPedidos,
    	(select sum(fr.importe) from factr01 fr where fr.cve_clpv = sc.cve_clpv and fr.status <> 'C' and (tip_doc_sig is null or tip_doc_sig = '')) as montoRemisiones, 
    	(select sum(ft.dbimptot) from FTC_COTIZACION ft where ft.cve_cliente = sc.cve_clpv and ft.instatus = 'PENDIENTE') as cotizaciones,
    	(select sum(saldofinal) from facturas where cve_clpv = sc.cve_clpv and status_fact <> 'Cobranza') as facturado
    	from sol_clientes sc 
    	inner join clie01 cl on cl.clave = sc.cve_clpv 
    	inner join maestros m on m.clave = cl.cve_maestro
    	where (sc.status =  1 or sc.status = 2)";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

     function verClientesCorte(){
    	$this->query="SELECT CL.*, M.NOMBRE AS MAESTRO,
    					(select sum(saldofinal) from facturas where cve_clpv = CL.CLAVE and status_fact = 'Cobranza') as saldoCobranza ,
    					(select sum(fp.importe) from factp01 fp where fp.cve_clpv = CL.CLAVE and fp.status <> 'C' and (tip_doc_sig is null or tip_doc_sig = '')) as montoPedidos,
    					(select sum(fr.importe) from factr01 fr where fr.cve_clpv = CL.CLAVE and fr.status <> 'C' and (tip_doc_sig is null or tip_doc_sig = '')) as montoRemisiones,
    					(select sum(ft.dbimptot) from FTC_COTIZACION ft where ft.cve_cliente = CL.CLAVE and ft.instatus = 'PENDIENTE') as cotizaciones,
    					(select sum(saldofinal) from facturas where cve_clpv = CL.CLAVE and status_fact <> 'Cobranza') as facturado
    	 			FROM CLIE01 CL
    	 			LEFT JOIN MAESTROS M ON M.CLAVE = CL.CVE_MAESTRO 
    	 			WHERE CL.STATUS_COBRANZA= 1 ";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }


    function cortarCredito($cveclie, $idsolc, $fecha, $monto){
    	$this->query="UPDATE CLIE01 SET STATUS_COBRANZA  = 2, inicio_corte=current_timestamp ,finaliza_corte=dateadd(day, $fecha, current_timestamp), monto_cobranza = $monto, saldo_monto_cobranza = $monto  WHERE TRIM(CLAVE) = TRIM('$cveclie')";
    	$rs=$this->EjecutaQuerySimple();

    	$this->query="UPDATE SOL_CLIENTES SET STATUS = 3 where id = $idsolc";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }

    function traeStatusClie($cliente){
    	$this->query="SELECT cl.*, m.id as idm
    					FROM CLIE01  cl
    					inner join maestros  m  on m.clave = cl.cve_maestro
    					WHERE trim(cl.CLAVE) = trim('$cliente')";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function liberarDeCorte($cveclie, $monto, $dias){
    	    	$this->query="UPDATE CLIE01 SET STATUS_COBRANZA  = 2, inicio_corte=current_timestamp ,finaliza_corte=dateadd(day, $dias, current_timestamp), monto_cobranza = $monto, saldo_monto_cobranza = $monto  WHERE TRIM(CLAVE) = TRIM('$cveclie')";
    	$rs=$this->EjecutaQuerySimple();

    	return;
    }


    function analisis($idpreoc, $fechaIni, $fechaFin){
    		//// Seleccionamos la cantidad validada.
    	$this->query="SELECT ID FROM PREOC01 WHERE FECHASOL >= '$fechaIni' and FECHASOL <= '$fechaFin' and (fact_ant <> 'P' or fact_ant is null)";
    	$rs=$this->EjecutaQuerySimple();

	    	while($tsArray = ibase_fetch_object($rs)){
	    		$dat[] = $tsArray;
	    	}

    	echo 'Consulta: '.$this->query.'<p>';
    	//break;

    	$ids = 0;
    	foreach($dat as $key){
    		$idpreoc = $key->ID;

    		$this->query = "SELECT iif(max(cant_validada) is null, 0, max(cant_validada)) as validado  from valida_recepcion where id_preoc = $idpreoc";
    		$rs=$this->EjecutaQuerySimple();
    		$row = ibase_fetch_object($rs);
    		$validado =$row->VALIDADO;
    		
    		$this->query="UPDATE PREOC01 SET FACT_ANT = 'P' WHERE ID =$idpreoc";
    		$this->EjecutaQuerySimple();

    		//// Seleccionamos lo recibido  (que debe de ser igual a lo validado) y la cantidad Original y la cotizacion.
    		$this->query="SELECT * FROM PREOC01 WHERE ID = $idpreoc";
    		$rs=$this->EjecutaQuerySimple();
    		$preoc = ibase_fetch_object($rs);
    		$valPreoc = $preoc->RECEPCION;
    		$cotizacion = $preoc->COTIZA;
    		$original = $preoc->CANT_ORIG;
    		$fechasol =$preoc->FECHASOL;
    		/// Vemos que lo validado sea igual a lo recibido.

    		if($validado <> $valPreoc){
    			echo 'Diferencia de Validacion con Recepcion'.$idpreoc.', validado = '. $validado.', recepcionado  = '.$valPreoc.'<p>';
    			$this->query ="UPDATE PREOC01 SET RECIBIDO = $validado WHERE ID = $idpreoc";
    			//$rs=$this->EjecutaQuerySimple(); 
    		}
    		//// Si lo validado es mayor a la cantidad original, se envia el mensaje a la consola;
    		
    		if($validado > $original){
    			echo 'Se valido mas de lo solicitado '.$idpreoc.', validado = '.$validado.' original, '.$original.'<p>';
    		}
    			/// Seleccionamos los pendientes en Orden de Compra.
		    	$data2 = array();
		    	$this->query="SELECT iif(PXR is null, 0, PXR) as pxr, NUM_PAR, CVE_DOC FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc and pxr > 0";
		    	$rs=$this->EjecutaQuerySimple();

		    	while($tsArray=ibase_fetch_object($rs)){
		    		$data2[]=$tsArray;
		    	}
		    	/// Si existen pendientes, entonces sumamos la pendientes + lo validado y lo comparamos con los solicitado.
		    	$pendientes= 0;
		    	if(count($data2)> 0){
		    		foreach ($data2 as $pendiente) {
		    		$this->query="SELECT PXR FROM PAR_COMPO01 WHERE ID_PREOC = $idpreoc and pxr > 0";
		    		$rs=$this->EjecutaQuerySimple();
		    		$row3=ibase_fetch_object($rs);
		    		$pendientes = $pendientes + $row3->PXR;
		    		}
		    	}
		    	
		    	$ordenado = $pendientes;
		    	$pendientes = $pendientes + $validado;
		    		
		    		/// Si es mayor lo pendiente y validado con lo solicitado creeamos una anomalia.

		    	if($pendientes > $original){
		    		echo 'Se ha solicitado mas de lo que requiere el pedido: '.$original.', validado: '.$validado.', pendientes, '.$pendientes.'<p>';
		    		$anomalia = $original - $pendientes;
		    		$this->query="INSERT INTO ANOMALIAS (ID, ID_PREOC, COTIZACION, CANT_ORIG, CANT_VALIDADA, CANT_PENDIENTE, ANOMALIA, FECHA, FECHA_SOL )
		    				VALUES (NULL, $idpreoc, '$cotizacion', $original, $validado, $ordenado, $anomalia, current_timestamp, '$fechasol')";
		    		$rs=$this->EjecutaQuerySimple();
		    	}
		    	$ids = $ids + 1;
		}
		    	$fin='Se procesaron '.$ids.'<p>';
		   return $fin;
    }


    function verFacturasCres(){
    	$this->query="SELECT FIRST 1000 X.*, (SELECT FIRST 1 NOMBRE FROM CLIE01 WHERE RFC = CLIENTE) AS NOMBRE
		FROM XML_DATA X";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verDeudores(){
    	$data=array();
    	$this->query="SELECT poc.id_Preoc, poc.cve_doc, poc.cve_art,
    					poc.cant, poc.pxr,
    					(select nombre from producto_ftc pftc where poc.cve_art = pftc.clave) as CAMPLIB7,
    					oc.fechaelab,
    					(SELECT NOMBRE FROM PROV01 P WHERE P.CLAVE = oc.cve_clpv) as nombre,
    					datediff(day, oc.fechaelab, current_timestamp) as dias
    					, poc.fecha_doc_recep
    					, poc.doc_recep
    					, poc.doc_recep_status
    					, poc.vuelta
    					, poc.num_par
    		 			FROM PAR_COMPO01 poc 
    		 			LEFT JOIN COMPO01 oc on oc.cve_doc = poc.cve_doc 
    		 			where poc.status_log2 ='Tesoreria' 
    		 			and poc.pxr > 0 
    		 			and extract(year from oc.fechaelab) >= 2017  
    		 			order by poc.cve_doc asc";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	$this->query="SELECT poc.IDPREOC AS id_preoc, poc.oc as cve_doc,  poc.art as cve_art, 
                             poc.cantidad as cant , poc.pxr,
                             (select nombre from producto_ftc pftc where pftc.clave_ftc = substring(poc.art from 4 for 10) )as camplib7,
                              oc.fecha_oc as fechaelab,
                            (select nombre from prov01 p where p.clave = oc.cve_prov) as nombre,
                            datediff(day, oc.fecha_oc, current_timestamp) as dias
                            , '' as fecha_doc_recep
                            , '' as doc_recep
                            , '' as doc_recep_status
                            , poc.vuelta
                            , poc.partida as num_par
                            from FTC_POC_DETALLE poc 
                            left join FTC_POC oc on oc.cve_doc = poc.cve_doc
                            --left join producto_ftc pftc on pftc.clave_ftc = substring(poc.art from 4 for 10) 
                            WHERE poc.STATUS_LOG2 = 'Tesoreria' and poc.pxr >0";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return @$data;
    }


    function recepcionOC(){
    	$this->query="SELECT 
    	oc.cve_doc
    	,max(doc_sig) as ultima_Remision 
    	,max(importe) as importeOC
        ,(select max(nombre) from prov01 p where p.clave = max(oc.cve_clpv)) as nombre
        ,sum(poc.pxr) as PendientesXRecibir
        ,max(fechaelab) as fechaOC
        ,max(oc.cve_clpv) as cve_clpv
        ,max(poc.usuario_php) as usuario
        ,max(poc.cost) as costo
        ,max(poc.pxr) as pxr
        ,max(oc.urgente) as urgencia
        ,max(poc.vuelta) as vuelta
        ,sum(poc.cant) as cantidad
        ,max(oc.status_recepcion) as status_recepcion
        , max(oc.UNIDAD) AS unidad
        ,max(oc.vueltas) as vueltas 
        , (select max(OPERADOR) FROM UNIDADES WHERE NUMERO = MAX(oc.unidad)) as operador
                         FROM COMPO01 oc 
                         left join par_compo01 poc on poc.cve_doc = oc.cve_doc
                         WHERE (STATUS_LOG = 'Total' or STATUS_LOG = 'secuencia' or status_log = 'admon' or status_log = 'Tiempo' or ruta = 'A') 
                         and (status_recepcion is null or status_recepcion = 9)
                         and extract(year from oc.fechaelab )>= 2017
                         group by oc.cve_doc 
                         having sum(poc.pxr) > 0";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	} 
    	$this->query="SELECT 
                            ftc.oc as cve_doc
                            ,'' as doc_sig
                            ,max(ftc.COSTO_TOTAL) as importeOC
                            , max(p.nombre) as nombre
                            ,sum(ftcpoc.pxr) AS PendientesXRecibir
                            , max(fecha_oc) as fechaoc
                            , max(p.clave) as cve_clpv
                            , max(ftc.usuario_oc) as usuario
                            , max(ftc.costo_total) as costo
                            , sum(ftcpoc.pxr) as pxr
                            , '' as urgencia
                            , max(ftc.vueltas) as vuelta
                            , sum(FTCPOC.cantidad) as cantidad
                            , max(ftc.status_recepcion) as status_recepcion
                            , max(ftc.unidad) as unidad
                            , max(ftc.vueltas) as vueltas
                            , (select max(operador) from unidades where numero = max(ftc.unidad) ) as operador
                            , max(ftc.FECHA_ENTREGA) AS FECHA_ENTREGA
                            from ftc_poc ftc
                            left join FTC_POC_DETALLE ftcpoc on ftcpoc.cve_doc = ftc.cve_doc
                            left join prov01 p on p.clave = ftc.cve_prov
                            where ((ftc.status_log = 'Total' or ftc.status_log = 'secuencia' or ftc.status_log='Tiempo' or ftc.status_log = 'admon' or ftc.status_log='Total' or ruta= 'A') or (ftc.fecha_entrega >= current_date and  ftc.fecha_pago is not null) )
                            and (status_recepcion is null or status_recepcion =9) 
                            group by ftc.oc
                            having sum(ftcpoc.pxr) > 0 ";
        $rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	} 


    	return @$data;
    }

     function cierreRecep($doco){
    	$this->query="SELECT COUNT(NUM_PAR) AS PARTIDAS FROM PAR_COMPO01 WHERE CANT_RECIBIDA IS NOT NULL AND CVE_DOC = '$doco'";
    	$rs=$this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($rs);
    	$partida=$row->PARTIDAS;

    	$this->query="SELECT MAX(NUM_PAR) AS TOT_PAR FROM PAR_COMPO01 WHERE CVE_DOC = '$doco' ";
    	$rs=$this->EjecutaQuerySimple();
    	$row2=ibase_fetch_object($rs);
    	$tot_partida = $row2->TOT_PAR;

    	$val = $tot_partida - $partida;
    	return $val;
    }

    function recibeParOC($cantidad, $idp, $doco, $partida){
    	$usuario=$_SESSION['user']->NOMBRE;

    	$a='';
    	if(substr($doco, 0, 2) == 'OP'){
    		$this->query="SELECT STATUS_RECEPCION, USUARIO_RECIBE FROM FTC_POC WHERE OC = '$doco'";
		    	$rs=$this->EjecutaQuerySimple();
		    	$row = ibase_fetch_object($rs);
		    	$nombre = $row->USUARIO_RECIBE;
		    	$status = $row->STATUS_RECEPCION;
    	}else{
    		$this->query="SELECT STATUS_RECEPCION, USUARIO_RECIBE FROM compo01 WHERE cve_doc = '$doco'";
		    	$rs=$this->EjecutaQuerySimple();
		    	$row = ibase_fetch_object($rs);
		    	$nombre = $row->USUARIO_RECIBE;
		    	$status = $row->STATUS_RECEPCION;
    	}

    	if($nombre == $usuario ){
	    		$this->query="UPDATE PAR_COMPO01 SET CANT_RECIBIDA = $cantidad, usuario_recibe = '$usuario', STATUS_VAL = 9 where cve_doc = '$doco' and num_par = $partida and id_preoc =$idp";
	    		$rs =$this->EjecutaQuerySimple();
    		if($rs){
    			$this->query="UPDATE FTC_POC_DETALLE set CANT_RECIBIDA = $cantidad, usuario_recibe = '$usuario', status_val = 9 where oc = '$doco' and partida = $partida and idpreoc = $idp";
    			$this->EjecutaQuerySimple();
	    	}else{
	    		echo 'Algo no salio como se esperaba, favor de volver a intentar';
	    	}	
    	}else{
    		$a = 'Error';
    	}
    	echo $this->query;
    	//break;
    	return  $a;
    }

    function validaOC($doco){
    	if(substr($doco, 0, 2) == 'OP'){
    		$this->query="SELECT iif(status_recepcion is null, 'A', 'B'||' - Por el Usuario: '||USUARIO_RECIBE) as resultado from ftc_poc where oc = '$doco'";

    	}else{
    		$this->query="SELECT IIF(STATUS_RECEPCION is null, 'A', 'B'||' - Por el Usuario: '||USUARIO_RECIBE) as resultado FROM COMPO01 WHERE CVE_DOC ='$doco'";	
    	}
    	$rs=$this->EjecutaQuerySimple();
    	$row =ibase_fetch_object($rs);
    	$val=$row->RESULTADO;
    	return $val;
    }



    function controlOC($doco){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="UPDATE COMPO01 SET STATUS_RECEPCION = 9, USUARIO_RECIBE = '$usuario' WHERE CVE_DOC = '$doco'";
    	$this->EjecutaQuerySimple();
    	$this->query="UPDATE FTC_POC SET STATUS_RECEPCION = 9, USUARIO_RECIBE = '$usuario' where oc = '$doco'";
    	$this->EjecutaQuerySimple();

    	return;
    }

     function rechazarOC($doco, $tipo){
      	$data=array();

      	
      	if(substr($doco,0,2) == 'OP'){
      		$usuario = $_SESSION['user']->NOMBRE;
		    	$this->query="UPDATE FTC_POC SET STATUS_RECEPCION = 8, STATUS_LOG = 'Rechazada' where OC = '$doco'";
		    	$this->EjecutaQuerySimple();

		    	$this->query="SELECT iif(MAX(ID_rechazo)is null, 0,max(id_rechazo)) AS FOLIO FROM FTC_DETALLE_RECEPCIONES";
		    	$rs=$this->EjecutaQuerySimple();
		    	$row =ibase_fetch_object($rs);
		    	$folr = $row->FOLIO + 1;

		    	$this->query="SELECT PARTIDA, CANTIDAD, CANT_RECIBIDA, IDPREOC, PXR from FTC_POC_DETALLE WHERE OC = '$doco'";
		    	$rs=$this->EjecutaQuerySimple();
		    	while($tsArray=ibase_fetch_object($rs)){
		    		$data[]=$tsArray;
		    	}
		    	foreach ($data as $key) {	
		    		$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, status, fecha, usuario, ID_RECEPCION, ID_Rechazo) VALUES (NULL, '$doco', $key->IDPREOC, $key->CANTIDAD, 0, $key->PARTIDA, 0, current_timestamp, '$usuario', 0, $folr) ";
		    		$this->EjecutaQuerySimple();
		    		if($key->PXR > 0 ){
		    			$this->query="UPDATE FTC_POC_DETALLE SET CANT_RECIBIDA = 0, status_log2 = 'Tesoreria' where OC = '$doco' and PARTIDA = $key->PARTIDA";
		    			$this->EjecutaQuerySimple();
		    			$this->query="UPDATE FTC_POC SET STATUS_LOG = 'Tesoreria' WHERE OC = '$doco' ";
		    			$this->EjecutaQuerySimple();
		    		}
		    	}
    	
      	}else{
      		$usuario = $_SESSION['user']->NOMBRE;
	    	$this->query="UPDATE COMPO01 SET STATUS_RECEPCION = 8, STATUS_LOG = 'Rechazada' where cve_doc = '$doco'";
	    	$this->EjecutaQuerySimple();
	    	$this->query="SELECT iif(MAX(ID_rechazo)is null, 0,max(id_rechazo)) AS FOLIO FROM FTC_DETALLE_RECEPCIONES";
	    	$rs=$this->EjecutaQuerySimple();
	    	$row =ibase_fetch_object($rs);
	    	$folr = $row->FOLIO + 1;
	    	$this->query="SELECT NUM_PAR, CANT, CANT_RECIBIDA, ID_PREOC, PXR from par_compo01 WHERE CVE_DOC = '$doco'";
	    	$rs=$this->EjecutaQuerySimple();
	    	while($tsArray=ibase_fetch_object($rs)){
	    		$data[]=$tsArray;
	    	}
	    	foreach ($data as $key) {	
	    		$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, status, fecha, usuario, ID_RECEPCION, ID_Rechazo) VALUES (NULL, '$doco', $key->ID_PREOC, $key->CANT, 0, $key->NUM_PAR, 0, current_timestamp, '$usuario', 0, $folr) ";
	    		$this->EjecutaQuerySimple();
	    		//echo 'Insercion en FTC_DETALLE_RECEPCIONES: '.$this->query.'<p>';
	    		if($key->PXR > 0 ){
	    			/// aqui se genera el Deudor.....
	    			$this->query="UPDATE PAR_COMPO01 SET CANT_RECIBIDA = NULL, status_log2 = 'Tesoreria' where cve_doc = '$doco' and num_par = $key->NUM_PAR";
	    			$this->EjecutaQuerySimple();
	    			//echo 'Consualta para meter a deudores: '.$this->query.'<p>';	
	    			$this->query="UPDATE COMPO01 SET STATUS_LOG = 'Tesoreria' WHERE CVE_DOC = '$doco' ";
	    			$this->EjecutaQuerySimple();
	    			//echo 'Consulta para enviar el documento a Tesoreria'.$this->query.'<p>';
	    		}
	    	}
    		
      	}
    	//break;
    	return;

    }

     function cerrarRecepcion($doco){
    	$data=array();
    	$usuario = $_SESSION['user']->NOMBRE;
    	$rol = $_SESSION['user']->USER_ROL;
    	$poc = '';

    	if(substr($doco, 0, 2) == 'OP'){
    		$this->query="SELECT STATUS_RECEPCION, USUARIO_RECIBE, cve_doc FROM FTC_POC WHERE OC = '$doco'";
		    	$rs=$this->EjecutaQuerySimple();
		    	$row = ibase_fetch_object($rs);
		    	$nombre = $row->USUARIO_RECIBE;
		    	$status = $row->STATUS_RECEPCION;
		    	$poc = $row->CVE_DOC;
    	}else{
    		$this->query="SELECT STATUS_RECEPCION, USUARIO_RECIBE FROM compo01 WHERE cve_doc = '$doco'";
		    	$rs=$this->EjecutaQuerySimple();
		    	$row = ibase_fetch_object($rs);
		    	$nombre = $row->USUARIO_RECIBE;
		    	$status = $row->STATUS_RECEPCION;
    	}
    	
    	if($nombre == $usuario){
    			    		
		    	if(substr($doco, 0,2) == 'OP'){

		    		$this->query="UPDATE FTC_POC SET STATUS_RECEPCION = 2, STATUS_LOG = 'Validada', STATUS='RECEPCIONADA' where oc = '$doco'";
		    		$this->EjecutaQuerySimple(); /// Actualiza la Orden para cerrar la recepcion.

		   			$this->query="SELECT MAX(ID_RECEPCION) AS FOLIO FROM FTC_DETALLE_RECEPCIONES"; // Seleciona el Folio.
			    	$rs=$this->EjecutaQuerySimple();
			    	$row =ibase_fetch_object($rs);
			    	$foln = $row->FOLIO + 1;

			    	$this->query="SELECT PARTIDA, CANTIDAD, iif(status_val is null, 0, CANT_RECIBIDA) as Cant_Recibida, IDPREOC, PXR, ART, COSTO, UM from FTC_POC_DETALLE WHERE OC = '$doco'";
			    	$rs=$this->EjecutaQuerySimple();  /// Obtiene la informacion capturada durante la recepcion.
			    	while($tsArray=ibase_fetch_object($rs)){
			    		$data[]=$tsArray;
			    	}


			    	foreach ($data as $key) {
			    		$this->query="UPDATE FTC_POC_DETALLE SET PXR = PXR - $key->CANT_RECIBIDA, status_val = null, status_real = 'Recibido' where OC = '$doco' and partida = $key->PARTIDA";
			    		$this->EjecutaQuerySimple();
			    		///// Revisar y validar la actualizacion ... 

			    		if($rol == 'bodega2'){ ///INGRESO A BODEGA.
			    			$equipo=gethostname();
		    			$this->query="INSERT INTO INGRESOBODEGA (ID, DESCRIPCION, CANT, FECHA, MARCA, PROVEEDOR, COSTO, UNIDAD, PRODUCTO, RESTANTE, ASIGNADO, USUARIO, RECIBIDO, ORIGEN ) 
		    						  VALUES (NULL, (SELECT NOMBRE FROM PRODUCTO_FTC WHERE CLAVE = '$key->ART'), $key->CANT_RECIBIDA, CURRENT_TIMESTAMP, (SELECT MARCA FROM PRODUCTO_FTC WHERE CLAVE = '$key->ART'), (SELECT CVE_PROV FROM FTC_POC WHERE OC = '$doco'), $key->COSTO,  '$key->UM','$key->ART', 0,0, (substring('$usuario' from 1 for 49)||' ('||substring('$equipo' from 1 for 18)||')'), 0, 'Orden Interna')";
		    						  $this->grabaBD();
		    						  echo $this->query;
		    			}

			    		$RA =  ibase_affected_rows(); /// REVISAR URGENTE.
			    		if($RA == 1){
			    				$this->query="UPDATE PREOC01 SET RECEPCION = RECEPCION + $key->CANT_RECIBIDA, REC_FALTANTE = REC_FALTANTE - $key->CANT_RECIBIDA WHERE id = $key->IDPREOC";
					    		$this->EjecutaQuerySimple();

					    		$ra=ibase_affected_rows();
					    		if($ra == 1){
					    			$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, status, fecha, usuario, ID_RECEPCION, poc) VALUES (NULL, '$doco', $key->IDPREOC, $key->CANTIDAD, $key->CANT_RECIBIDA, $key->PARTIDA, 0, current_timestamp, '$usuario', $foln, '$poc') ";
					    			$this->EjecutaQuerySimple();

					    			if($key->CANT_RECIBIDA <> $key->PXR){  // Si la cantidad es diferente a la Pendiente por recibir.
					    			/// aqui se genera el Deudor.....
						    			$this->query="UPDATE FTC_POC_DETALLE SET CANT_RECIBIDA = 0, status_log2 = 'Tesoreria', status_real = 'Tesoreria' where OC = '$doco' and partida = $key->PARTIDA";
						    			$this->EjecutaQuerySimple();	

						    			$this->query="UPDATE FTC_POC SET STATUS_LOG = 'Tesoreria', STATUS='TESORERIA' WHERE OC = '$doco' ";
					    				$this->EjecutaQuerySimple();
					    			}	
					    		}else{

					    		}
			    		}else{


			    		}
			    	}
		    	}else{

			    	$this->query="UPDATE COMPO01 SET STATUS_RECEPCION = 2, STATUS_LOG = 'Validada' WHERE CVE_DOC = '$doco' ";
			    	$this->EjecutaQuerySimple();

			    	$this->query="SELECT MAX(ID_RECEPCION) AS FOLIO FROM FTC_DETALLE_RECEPCIONES";
			    	$rs=$this->EjecutaQuerySimple();
			    	$row =ibase_fetch_object($rs);
			    	$foln = $row->FOLIO + 1;


			    	$this->query="SELECT NUM_PAR, CANT, iif(status_val is null, 0, CANT_RECIBIDA) as Cant_Recibida, ID_PREOC, PXR from par_compo01 WHERE CVE_DOC = '$doco'";
			    	$rs=$this->EjecutaQuerySimple();
			    	while($tsArray=ibase_fetch_object($rs)){
			    		$data[]=$tsArray;
			    	}

			    	foreach ($data as $key) {
			    		$this->query="UPDATE PAR_COMPO01 SET PXR = PXR - $key->CANT_RECIBIDA, status_val = null where cve_doc = '$doco' and num_par = $key->NUM_PAR";
			    		$this->EjecutaQuerySimple();

			    		$this->query="UPDATE PREOC01 SET RECEPCION = RECEPCION + $key->CANT_RECIBIDA, REC_FALTANTE = REC_FALTANTE - $key->CANT_RECIBIDA WHERE id = $key->ID_PREOC";
			    		$this->EjecutaQuerySimple();

			    		$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, status, fecha, usuario, ID_RECEPCION, poc) VALUES (NULL, '$doco', $key->ID_PREOC, $key->CANT, $key->CANT_RECIBIDA, $key->NUM_PAR, 0, current_timestamp, '$usuario', $foln, '$poc') ";
			    		$this->EjecutaQuerySimple();

			    		if($key->CANT_RECIBIDA <> $key->PXR){
			    			/// aqui se genera el Deudor.....
			    			$this->query="UPDATE PAR_COMPO01 SET CANT_RECIBIDA = NULL, status_log2 = 'Tesoreria' where cve_doc = '$doco' and num_par = $key->NUM_PAR";
			    			$this->EjecutaQuerySimple();	

			    			$this->query="UPDATE COMPO01 SET STATUS_LOG = 'Tesoreria' WHERE CVE_DOC = '$doco' ";
			    				$this->EjecutaQuerySimple();
			    		}
			    	}

    			}
    	}
    	//break;
    	return;
    }

    function formulario(){
    	$this->query="UPDATE PG_USERS SET NOMBRE = 'A' WHERE ID = 1";
    	$this->EjecutaQuerySimple();
    	return;
    }

    function cancelaRecepcion($doco){
    	$data=array();
    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="UPDATE COMPO01 SET STATUS_RECEPCION = NULL WHERE CVE_DOC = '$doco'";
    	$this->EjecutaQuerySimple();
    	$this->query="UPDATE FTC_POC SET STATUS_RECEPCION = NULL WHERE OC = '$doco'";
    	$this->EjecutaQuerySimple();


    	$this->query="SELECT NUM_PAR, CANT, CANT_RECIBIDA, ID_PREOC from par_compo01 WHERE CVE_DOC = '$doco'";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key) {
    		$this->query="UPDATE PAR_COMPO01 SET CANT_RECIBIDA = NULL where cve_doc = '$doco' and num_par = $key->NUM_PAR";
    		$this->EjecutaQuerySimple();
    	}

    	return;
    }


    function impresionRecepcion($doco){
    	$data=array();
    	$data2 = array();

    	$this->query="SELECT IIF(max(orden) IS NULL, 'A', max(orden)) as Orden FROM FTC_DETALLE_RECEPCIONES WHERE cast(ID_RECEPCION as varchar(20)) = '$doco'";
	    $rs=$this->EjecutaQuerySimple();
	    $row=ibase_fetch_object($rs);
	    $orden = $row->ORDEN;
    	if($orden <>'A'){
    		$doco = $orden;
    	}

    	if(substr($doco,0,2) == 'OP' ){
    		$this->query="SELECT ID_RECEPCION FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco' group by id_recepcion";
	    	$rs2=$this->EjecutaQuerySimple();
	    	while ($tsArray=ibase_fetch_object($rs2)) {
	    		$data2[]=$tsArray;
	    	}
	    	foreach ($data2 as $key) {
	  			$id = $key->ID_RECEPCION;
	  			if(substr($doco, 0,2) <> 'OP'){
	  					$this->query="SELECT oc.*, p.nombre, $id as id_recepcion, (SELECT max(impresion) from FTC_DETALLE_RECEPCIONES where cve_doc = '$doco' and id_recepcion = $id) as impresion  FROM COMPO01 oc left join prov01 p on oc.cve_clpv = p.clave WHERE CVE_DOC = '$doco'";
    			$rs=$this->EjecutaQuerySimple();
		    		while($tsArray=ibase_fetch_object($rs)){
		    			$data[]=$tsArray;
		    		}
	  			}else{
	  				$this->query="SELECT poc.oc as cve_doc, poc.fecha_oc as fecha_doc, poc.tp_tes, poc.status_recepcion,poc.status_log, poc.pago_tes, poc.usuario_recibe, $id as id_recepcion, p.nombre, poc.costo_total as importe,(SELECT max(impresion) from FTC_DETALLE_RECEPCIONES where cve_doc = '$doco' and id_recepcion = $id) as impresion   FROM FTC_POC poc left join prov01 p on p.clave = poc.cve_prov WHERE OC = '$doco' ";
	  				$rs=$this->EjecutaQuerySimple();
	  				//echo $this->query;
	  				while($tsArray=ibase_fetch_object($rs)){
	  					$data[]=$tsArray;
	  				}
	  			}
	    	}	
    	}else{
    		$this->query="SELECT a.id as cve_doc, a.fecha_mov as fecha_doc, 'N/A' as tp_tes, a.status as status_recepcion, 'n/a' as status_log, 'n/a' as pago_tes, ftcd.usuario as usuario_recibe, ftcd.id_recepcion, 'Pegaso (Bodega Interna)' as nombre, 0 as importe, ftcd.impresion FROM ASIGNACION_BODEGA_PREOC a left join ftc_detalle_recepciones ftcd on ftcd.orden = '$doco' WHERE a.ID = $doco";
    		$rs=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($rs)){
    			$data[]=$tsArray;
    		}
    	
    	}
	    
    	return $data;
    }

    function datosFTCRecep($doco){

    	if(substr($doco, 0,2) == 'OP'){
    		$this->query="SELECT oc.*, oc.fecha_oc as fechaelab, p.clave as cve_clpv, p.nombre, p.rfc, p.CALLE, p.numext, p.colonia, p.estado, p.cve_pais, p.tp_efectivo, p.tp_transferencia, p.tp_credito, p.tp_cheque, p.diascred, p.cuenta FROM ftc_poc oc LEFT JOIN PROV01 p ON p.CLAVE = oc.cve_prov WHERE oc = '$doco'";
    	}elseif(gettype($doco) == 'varchar'){
    		$this->query="SELECT oc.*, p.nombre, p.rfc, p.CALLE, p.numext, p.colonia, p.estado, p.cve_pais, p.tp_efectivo, p.tp_transferencia, p.tp_credito, p.tp_cheque, p.diascred, p.cuenta FROM COMPO01 oc LEFT JOIN PROV01 p ON p.CLAVE = oc.cve_clpv WHERE cve_doc = '$doco'";	
    	}
    	
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function detalleFTCRecep($doco, $docr){
    	

    	if(substr($doco,0,2)== 'OP'){
    		if($docr > 0){	
    			$this->query="SELECT ftc.*, poc.*, pc.*, pc.costo as cost   FROM  FTC_DETALLE_RECEPCIONES ftc left join preoc01 poc on poc.id = ftc.idpreoc left join FTC_POC_DETALLE pc on pc.oc = ftc.orden and pc.partida = ftc.partida  WHERE ORDEN = '$doco' and id_recepcion= $docr";	
    		}else{
    			$this->query="SELECT * FROM  FTC_DETALLE_RECEPCIONES ftc left join preoc01 poc on poc.id = ftc.idpreoc left join par_compo01 pc on pc.cve_doc = ftc.orden and pc.num_par = ftc.partida  WHERE ORDEN = '$doco'";	
    		}	
    	}else{
    		if($docr > 0){	
    			$this->query="SELECT * FROM  FTC_DETALLE_RECEPCIONES ftc left join preoc01 poc on poc.id = ftc.idpreoc left join par_compo01 pc on pc.cve_doc = ftc.orden and pc.num_par = ftc.partida  WHERE ORDEN = '$doco' and id_recepcion= $docr";	
    		}else{
    			$this->query="SELECT * FROM  FTC_DETALLE_RECEPCIONES ftc left join preoc01 poc on poc.id = ftc.idpreoc left join par_compo01 pc on pc.cve_doc = ftc.orden and pc.num_par = ftc.partida  WHERE ORDEN = '$doco'";	
    		}
    	}
    	
    	$rd=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rd)) {
    		$data[]=$tsArray;
    	}

    	//echo 'Consulta'.$this->query;

    	return $data;
    }

    function ctrlimprecepciones($doco, $docr){
    	$this->query="SELECT MAX(IMPRESION) AS impresion FROM FTC_DETALLE_RECEPCIONES WHERE orden = '$doco' and id_recepcion = $docr";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$impresion = $row->IMPRESION;

    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET IMPRESION = IMPRESION + 1  WHERE orden = '$doco' and id_recepcion = $docr";
    	$this->EjecutaQuerySimple();
    	return $impresion;
    }

    function verRecepcionDeOrdenes(){
    	/*$this->query="SELECT ftc.ORDEN, SUM(ftc.CANTIDAD_OC) AS ORIGINAL, SUM(ftc.CANTIDAD_REC) AS RECIBIDA, iif(SUM(ftc.CANTIDAD_OC) - SUM(ftc.CANTIDAD_REC) = 0, 'Completa', 'Parcial') as status,
    					max(p.nombre) as nombre , max(oc.fechaelab) as fechaelab, max(oc.cve_clpv) as cve_prov, max(p.rfc) as rfc, max(status_validacion) as status_validacion
    					from FTC_DETALLE_RECEPCIONES ftc
    					LEFT JOIN COMPO01 oc on oc.cve_doc  = ftc.orden
    					left join prov01 p on oc.cve_clpv = p.clave
    					GROUP BY ORDEN HAVING sum(ftc.STATUS)=0 ";
		*/
		$this->query="SELECT ftc.ORDEN, SUM(ftc.CANTIDAD_OC) AS ORIGINAL, SUM(ftc.CANTIDAD_REC) AS RECIBIDA, iif(SUM(ftc.CANTIDAD_OC) - SUM(ftc.CANTIDAD_REC) = 0, 'Completa', 'Parcial') as status,
    					max(p.nombre) as nombre , iif(max(oc.fechaelab) is null, max(ftcpoc.fecha_elab), max(oc.fechaelab)) as fechaelab, 
    					iif(max(oc.cve_clpv) is null, max(ftcpoc.cve_prov), max(oc.cve_clpv)) as cve_prov, max(p.rfc) as rfc, max(status_validacion) as status_validacion, max(ftc.status) as sta, min(fecha_costo) as fecha_costo
    					from FTC_DETALLE_RECEPCIONES ftc
    					LEFT JOIN COMPO01 oc on oc.cve_doc  = ftc.orden
    					LEFT JOIN FTC_POC ftcpoc on ftcpoc.oc = ftc.orden
    					left join prov01 p on oc.cve_clpv = p.clave or ftcpoc.cve_prov = p.clave
    					GROUP BY ORDEN HAVING (avg(ftc.status) = 0 or max(ftc.status) = 7 or avg(ftc.status) = 1) and SUM(ftc.CANTIDAD_REC) > 0";


    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function cierreValRecep($doco){
    	$this->query="SELECT iif(max(val_part) is null, 0, Max(val_part)) AS VALIDACIONES FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco' GROUP BY ORDEN, PARTIDA";
    	$rs=$this->EjecutaQuerySimple(); 	
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	$tot_val = 0;
    	foreach ($data as $key) {
    		$tot_val = $tot_val + $key->VALIDACIONES;
    	}
    	$this->query="SELECT MAX(PARTIDA) AS PARTIDAS FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco'";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$tot_partida = $row->PARTIDAS;
       	if($tot_val == $tot_partida){
    		$cierre = 0;
    	}else{
    		$cierre = 1;
    	}
    	return $cierre;
    }

    function validaStatusValidacion($doco){
    	$this->query="SELECT IIF(MAX(STATUS_VALIDACION) IS NULL, 'A', MAX(STATUS_VALIDACION)) AS VALIDACION FROM FTC_DETALLE_RECEPCIONES WHERE ORDEN = '$doco' ";
    	$rs=$this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($rs);
    	$val = $row->VALIDACION; 
    	return $val;
    }

    function valRecepcion($doco){
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET STATUS_VALIDACION = 9 WHERE ORDEN = '$doco'";
    	$this->EjecutaQuerySimple();

    	

    	$this->query="SELECT ftc.ORDEN, 
    						ftc.partida, 
    						ftc.idpreoc,
    						max(ftcpoc.costo) as costo,
    						max(ftcpoc.pxr) as pxr,
    						(select max(prod) from preoc01 where id = ftc.idpreoc) as art, 
    						(select max(nombre) from producto_ftc where clave = (select max(prod) from preoc01 where id = ftc.idpreoc)) as descripcion,
    						(select max(pxr) from par_compo01 where cve_doc = '$doco' and num_par = ftc.partida) as pxr1,
    						(select max(cost) from par_compo01 where cve_doc = '$doco' and num_par= ftc.partida)  as costo1,
    						(select max(um) from producto_ftc where clave = (select max(prod) from preoc01 where id = ftc.idpreoc)) as UM,
    						(select max(CVE_PROD) from producto_ftc where clave = (select max(prod) from preoc01 where id = ftc.idpreoc)) as CVE_PROD,
    						(select max(NOM_CLI) FROM preoc01 where id= ftc.idpreoc) as CLIENTE,
    						(select max(cotiza) from preoc01 where id= ftc.idpreoc) as COTIZACION, 
    						(select max(fechasol) from preoc01 where id = ftc.idpreoc) as fechasol,
    						(select max(cant_orig) from preoc01 where id = ftc.idpreoc) as cant_orig,
    						max(ftc.desc1) as desc1,
    						max(ftc.desc2) as desc2,
    						max(ftc.desc3) as desc3,
    						max(ftc.descf) as descf,
     						max(ftc.cantidad_oc) as Cantidad, 
     						max(ftc.desc1_m) as desc1_m,
     						max(ftc.desc2_m) as desc2_m,
     						max(ftc.desc3_m) as desc3_m,
     						max(ftc.descf_m) as descf_m,
     						max(ftc.precio_Lista) as precio_Lista,
    						SUM(ftc.cantidad_rec) as Cant_Recibida,
    						max(ftc.total_costo_unitario) as total_costo_unitario,
    						max(ftc.total_costo_partida) as total_costo_partida,
    						(select max(desc1) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as DESCO1,
    						(select max(desc2) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as DESCO2,
    						(select max(desc3) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as DESCO3,
    						(select max(desc4) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as DESCOF,
    						(select max(PRECIO) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as PRECIOO,
    						(select max(COSTO) from ftc_articulos ftca where ('PGS'||ftca.id) = (select max(prod) from preoc01 where id = ftc.idpreoc)) as COSTOO,
    						max(val_part) as Val_PART
    						FROM FTC_DETALLE_RECEPCIONES ftc
    						left join ftc_poc_detalle ftcpoc on ftcpoc.oc = ftc.orden and ftcpoc.partida = ftc.partida
    						where orden = '$doco' 
    						GROUP BY ORDEN, idpreoc, PARTIDA 
    						ORDER BY ORDEN ASC, partida asc";

    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	foreach ($data as $key) {
    		$recibido = $key->CANT_RECIBIDA;
    		$orden = $key->ORDEN;
    		$partida = $key->PARTIDA;
    		$idpre = $key->IDPREOC;
    		if($recibido == 0 ){
    			$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET desc1 = 0, desc2 = 0 , desc3 = 0, descf = 0, desc1_m = 0, desc2_m = 0, desc3_m = 0, descf_m = 0, precio_Lista = 0, total_costo_unitario = 0, total_costo_partida = 0, val_part = 1 WHERE orden = '$orden' and partida = $partida and idPreoc = $idpre";
    			$this->EjecutaQuerySimple();
    		}
    	}

    	return $data;
    }

    function cerrarValidacion($doco){

    	$this->query="SELECT iif(MAX(FOL_VALidacion) is null, 0 , max(FOL_VALidacion)) as folio FROM FTC_DETALLE_RECEPCIONES";
    	$rs=$this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($rs);
    	$foln = $row->FOLIO + 1;
    	$usuario= $_SESSION['user']->NOMBRE;

    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET status_validacion = 2, status = 2, FOL_VALIDACION = $foln, usuario_cierre_val = '$usuario', fecha_cierre_val = current_timestamp WHERE ORDEN = '$doco'";
    	$this->EjecutaQuerySimple();
    	return $foln;  
    }

    function cancelaValidacionRecepcion($doco){
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET STATUS_VALIDACION = NULL WHERE ORDEN = '$doco'";
    	$this->EjecutaQuerySimple();
    	return;
    }

    function infoRecepcion($doco){
    	$this->query="SELECT first 1 ftc.ORDEN, p.nombre as nombre , iif(oc.fechaelab is null, ftcpoc.fecha_elab, oc.fechaelab) as fechaelab, iif(oc.cve_clpv is null, ftcpoc.cve_prov, oc.cve_clpv) as cve_prov, p.rfc as rfc
    					from FTC_DETALLE_RECEPCIONES ftc
    					LEFT JOIN COMPO01 oc on oc.cve_doc  = ftc.orden
    					left join ftc_poc ftcpoc on ftcpoc.oc = ftc.orden 
    					left join prov01 p on oc.cve_clpv = p.clave or ftcpoc.cve_prov = p.clave
    					left join preoc01 poc on poc.id = ftc.idpreoc  
    					left join ftc_articulos ftca on poc.prod = ('PGS'||ftca.id)  
    					where orden = '$doco'";

    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function recibirParOC($idp, $cantidad, $doco, $partida, $desc1, $desc2, $desc3, $descf, $desc1M, $desc2M, $desc3M, $descfM, $precioLista, $totalCosto, $totalPartida){
    	$this->query="SELECT IIF(MAX(VALIDA_COSTO) IS NULL, 0 , MAX(VALIDA_COSTO)) AS VALIDA_COSTO FROM FTC_DETALLE_RECEPCIONES";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$foln = $row->VALIDA_COSTO + 1;

    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET VALIDA_COSTO = $foln, USUARIO_COSTO = '$usuario', CANT_VAL = $cantidad, desc1 = $desc1, desc2 = $desc2, desc3 = $desc3, descf = $descf, precio_Lista = $precioLista, total_costo_unitario = $totalCosto, total_costo_partida = $totalPartida, desc1_m= $desc1M, desc2_m=$desc2M, desc3_m=$desc3M, descf_m=$descf, val_part = 1 where orden = '$doco' and partida = $partida";
    	$this->EjecutaQuerySimple();

    	return;
    }


    function solAutCostos($idp, $cantidad, $doco, $partida, $desc1, $desc2, $desc3, $descf, $desc1M, $desc2M, $desc3M, $descfM, $precioLista, $totalCosto, $totalPartida){
		$this->query="SELECT IIF(MAX(VALIDA_COSTO) IS NULL, 0 , MAX(VALIDA_COSTO)) AS VALIDA_COSTO FROM FTC_DETALLE_RECEPCIONES";
    	$rs=$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);
    	$foln = $row->VALIDA_COSTO + 1;

    	$usuario = $_SESSION['user']->NOMBRE;
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET VALIDA_COSTO = $foln, USUARIO_COSTO = '$usuario', CANT_VAL = $cantidad, desc1 = $desc1, desc2 = $desc2, desc3 = $desc3, descf = $descf, precio_Lista = $precioLista, total_costo_unitario = $totalCosto, total_costo_partida = $totalPartida, desc1_m= $desc1M, desc2_m=$desc2M, desc3_m=$desc3M, descf_m=$descf, val_part = 0, status = 7, fecha_costo = current_timestamp where orden = '$doco' and partida = $partida";
    	$this->EjecutaQuerySimple();
    	return;	
    }


    function solicitudesCosto(){
    	$this->query="SELECT COUNT(ID) as id FROM FTC_DETALLE_RECEPCIONES WHERE precio_Lista > 0 AND VAL_PART = 0 ";
    	$rs=$this->EjecutaQuerySimple();
    	@$row=ibase_fetch_object($rs);
    	@$sol  = $row->ID;
    	return @$sol;
    }

    function verSolCostos(){
    	$this->query="SELECT ftcr.idpreoc, ftcr.partida, ftcr.orden, ftcr.precio_Lista, ftcr.desc1, ftcr.desc1_M,ftcr.desc2, ftcr.desc2_M, ftcr.desc3, ftcr.desc3_M,ftcr.descf, ftcr.descf_M, pftc.NOMBRE, pftc.clave, oc.fechaelab, oc.cve_clpv, p.nombre as prov, oc.importe , oc.tp_tes, oc.pago_tes, pftc.costo_t, (ftcr.total_costo_unitario * 1.16) AS total_costo_val, pftc.impuesto,
    				pftc.costo_suministros as costo, ftcr.total_costo_unitario, pftc.desc1 as descc1, pftc.desc2 as descc2, pftc.desc3 as descc3, pftc.desc4 as descc4, pftc.descf as desccf, pftc.clave_ftc as ida,
    				(select sum(cantidad_rec) from FTC_DETALLE_RECEPCIONES ftc2 where ftc2.orden = ftcr.orden and ftc2.partida = ftcr.partida ) as cantidad
    			from FTC_DETALLE_RECEPCIONES ftcr 
    			left join preoc01 poc on poc.id = ftcr.idpreoc
    			left join producto_ftc pftc on pftc.clave = poc.prod
    			left join compo01 oc on oc.cve_doc = ftcr.orden
    			left join prov01 p on p.clave = oc.cve_clpv
    			where ftcr.val_part = 0";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }


    function aceptarCosto($doco, $par, $costo_o, $costo_n){
    	$usuario =$_SESSION['user']->NOMBRE;
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET VAL_PART  = 1 WHERE ORDEN = '$doco' and PARTIDA = $par";
    	$this->EjecutaQuerySimple();

    	$this->query="INSERT INTO reg_autoriza_costo (id, orden, partida, usuario, fecha, costo_o, costo_n, dif)
    										values (null, '$doco', $par, '$usuario', current_timestamp, $costo_o, $costo_n, ($costo_o - $costo_n)) ";
    	$this->EjecutaQuerySimple();
    	return;
    }



    function recValConta(){
    	$this->query="SELECT ftc.ORDEN, SUM(ftc.CANTIDAD_OC) AS ORIGINAL, SUM(ftc.CANTIDAD_REC) AS RECIBIDA, iif(SUM(ftc.CANTIDAD_OC) - SUM(ftc.CANTIDAD_REC) = 0, 'Completa', 'Parcial') as status,
    					max(p.nombre) as nombre , max(oc.fechaelab) as fechaelab, max(oc.cve_clpv) as cve_prov, max(p.rfc) as rfc, max(status_validacion) as status_validacion, max(ftc.status) as sta, min(fecha_costo) as fecha_costo, MAX(fol_validacion) as folio
    					from FTC_DETALLE_RECEPCIONES ftc
    					LEFT JOIN COMPO01 oc on oc.cve_doc  = ftc.orden
    					left join prov01 p on oc.cve_clpv = p.clave
    					GROUP BY ORDEN HAVING max(fol_validacion) is not null and MAX(usuario_conta) is null";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}

    	return $data;
    }

    function recibirValidacion($doco, $folio){
    	$usuario=$_SESSION['user']->NOMBRE;
    	$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET usuario_conta = '$usuario', fecha_contabilidad = current_timestamp where orden = '$doco' and fol_validacion=$folio";
    	$this->EjecutaQuerySimple();
    	
    	return;
    }

    function verHistorialSaldo($prov){
    	$this->query="SELECT * FROM LIB_PARTIDAS lp left join par_compo01 poc on poc.cve_doc = lp.oc and poc.num_par = lp.partida_oc WHERE trim(PROVEEDOR) = trim('$prov')";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function verOrdenesCompra(){
    	$usuario=$_SESSION['user']->NOMBRE;

    	$this->query="SELECT ftc.fecha_oc, ftc.*, p.nombre FROM FTC_POC ftc left join prov01 p on p.clave = ftc.cve_prov 
    	WHERE OC is not null 
    	and ftc.status <> 'Nueva' 
    	and usuario_oc = '$usuario' 
    	order by ftc.fecha_oc desc";
    	$rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function cambiarProv($ida, $cant, $tipo){
    	$usuario = $_SESSION['user']->NOMBRE;

    	$this->query="SELECT STATUS FROM PREOC01 WHERE ID = $ida";
    	$rs=$this->EjecutaQuerySimple();
    	$row = ibase_fetch_object($rs);
    	$status = $row->STATUS;

    	if($status == 'F' or $tipo == ''){
	    	if($tipo == 'suministros'){
	    		$this->query="UPDATE PREOC01 SET STATUS = 'N' WHERE ID = $ida";
	    		$this->EjecutaQuerySimple();
	    	}else{
			   	$this->query="SELECT iif(prov_alt is null, prove, prov_alt) as cve_prov, 
							(select nombre from prov01 where trim(clave) = trim(iif(prov_alt is null or prov_alt = '999999999', prove, prov_alt))) as nombre_prov,
							nomprod, prod
			    			FROM PREOC01 WHERE ID = $ida";
			    $rs=$this->EjecutaQuerySimple();
			    $row = ibase_fetch_object($rs);

			    $this->query="INSERT INTO FTC_SOLICITUD_PROV (id, cantidad, cve_prod,cve_prov_orig, nombre_prov_orig, idpreoc, descripcion, usuario_solicita, fecha_solicita, usuario_cambia, fecha_cambia, cve_nuevo_prov, nombre_nuevo_prov) 
			    			values(null,$cant,'$row->PROD', '$row->CVE_PROV', '$row->NOMBRE_PROV', $ida, '$row->NOMPROD', '$usuario', current_timestamp, null, null, null, null)";
			    $this->EjecutaQuerySimple();
			    
			    $this->query="UPDATE PREOC01 SET prov_alt = '999999999', status='J' where id = $ida";
			    $this->EjecutaQuerySimple();   
			    $a = 'Se realizo la peticion.';		
	    	}
    	}else{
    		$a='La partida ya se habia procesado con Anterioridad, no se proceso la solicitud';	
    		echo $a;
    	}
    	return;
    }

    function verSolProveedor(){
    	$this->query="SELECT s.*, a.precio, 
    				(a.precio * (a.desc1/100)) as desc1, 
    				(a.precio * (a.desc2/100)) as desc2,
    				(a.precio * (a.desc3/100)) as desc3,
    				(a.precio * (a.desc4/100)) as desc4
    				FROM FTC_SOLICITUD_PROV s LEFT JOIN ftc_articulos a on s.cve_prod = ('PGS'||a.id) 
    				WHERE cve_nuevo_prov is null";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function proveedores(){
    	$this->query="SELECT * FROM PROV01 WHERE STATUS = 'A'";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function cambioProveedor($prov1, $id, $idpreoc){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$prov = split(':',$prov1);	
    	$this->query="UPDATE FTC_SOLICITUD_PROV set cve_nuevo_prov = '$prov[0]', nombre_nuevo_prov = '$prov[1]', usuario_cambia ='$usuario', fecha_cambia= current_timestamp where id = $id";
    	$rs=$this->EjecutaQuerySimple();
    	if($rs=true){
    		$this->query="UPDATE preoc01 set prov_alt = '$prov[0]', status ='N' where id = $idpreoc";
    		$this->EjecutaQuerySimple();
    		echo '<label>Se Ha cambiado a el proveedor: </label> '.$prov1;
    	
    	}else{
    		echo 'No se ha cambiado';
    	}
    	return ;
    }

    function historialCambios($exec){
    	//var_dump($exec);
    	foreach ($exec as $key) {
    		$data=array();
    		$this->query="SELECT * FROM FTC_SOLICITUD_PROV WHERE IDPREOC = $key->ID order by fecha_solicita, idpreoc";
    		$rs=$this->EjecutaQuerySimple();
    		while ($tsArray=ibase_fetch_object($rs)) {
    			$data[]=$tsArray;
    		}
    	}
    	
    	return $data;
    }

    function verProductosLiberados(){
    	$this->query="SELECT p.id, p.fechasol, p.fecha_auto, p.cotiza, p.par, p.status, 
    							p.prod, 
    							p.nomprod,
    							p.canti, p.cant_orig, p.costo, 
    							iif(p.prov_alt is null,  p.prove, p.prov_alt) as prove,
    							(SELECT NOMBRE FROM prov01 where trim(clave) = trim(iif(p.prov_alt is null, p.prove, p.prov_alt))) AS  nom_prov,
    							 p.total, p.rest, p.docorigen, p.urgente, p.um, datediff(day, p.fechasol,current_date) as DIAS, 
    							p.costo_maximo, iif(fecharec is null, current_date, fecharec) as fecharec,
							  (select count(id) from LIB_PARTIDAS where idpreoc = p.id) as Liberaciones,
							  (select resp_compra from prov01 where trim(clave) = trim(iif(p.prov_alt is null, p.prove, p.prov_alt))) as responsable
							  from preoc01 p
							  WHERE status='F' 
							  and rest > 0 
							  and rec_faltante > 0 
							  and (select count(id) from LIB_PARTIDAS where idpreoc = p.id) >= 1
							  ORDER BY  nom_prov  ASC ";
		$result = $this->QueryObtieneDatosN();
			while ( $tsArray = $this->FetchAs($result) ) 
					$data[] = $tsArray;			
		
			return $data;
    }

    function actFecha($tipo, $docu, $fecha){


    	
   
    	$a= array("status"=>"NO","response"=>"No se pudo Actualizar", "fecha"=>$fecha);
    		 switch ($tipo){
                case 1:
                    $tabla = 'carga_pagos';
                    $campo1 = 'fecha_recep';
                    $campo2 = 'folio_x_banco';

                    if(substr($docu,0,2)== 'TR'){
                    	$campo2= 'ID';
                    	$a= split( '-',$docu);
                    	$docu=substr($docu, 2,10);
                    }

                    break;
                case '2':
                    $tabla = 'compo01';
                    $campo1 = 'fecha_edo_cta';
                    $campo2 = 'cve_doc';
                    break;
                case '3':
                    $tabla = 'CR_DIRECTO';
                    $campo1 = 'fecha_edo_cta';
                    $campo2 = 'id';
                    $a = split('-', $docu);
                    $docu = $a[0];
                    break;
                case '4':
                    $tabla = 'gastos';
                    $campo1 = 'fecha_edo_cta';
                    $campo2 ='id';
                    break;
                case '5':
                    $tabla = 'CR_DIRECTO';
                    $campo1 = 'fecha_edo_cta';
                    $campo2 ='id';
                    $a = split('-', $docu);
                    $docu = $a[0];
                    break;
                case '6':
                    $tabla = 'deudores';
                    $campo1 = 'fechaedo_cta';
                    $campo2 = 'iddeudor';
                    break;
                case '7':
                    $tabla = 'Solicitud_pago';
                    $campo1 = 'fecha_edo_cta';
                    $campo2 = 'idsol';

                    substr($docu,4, 10 );
                    substr($docu,2,10);
                    break;
                case '8':
                	$tabla = 'FTC_POC';
                	$campo1 = 'edocta_fecha';
                	$campo2 = 'oc';
                default:
                    break;                  
            }

            if(substr($docu, 0 , 3 ) == 'SOL'){
            	$docu = substr($docu,4,10);
            }elseif(substr($docu, 0,1) == 'D'){
            	$docu = substr($docu, 1,10);
            }

    	if($fecha == 'bbb' ){
    		$this->query="UPDATE $tabla set seleccionado = 0 where $campo2 = '$docu'";
    			$rs=$this->EjecutaQuerySimple();
    	
    	}elseif($fecha == 'aaa'){
    			$this->query="UPDATE $tabla set seleccionado = 1 where $campo2 = '$docu'";
    			$rs=$this->EjecutaQuerySimple();
    			
    	}else{
				$this->query="UPDATE $tabla SET $campo1 = '$fecha', seleccionado = 1 where  $campo2 = '$docu'";
    			$rs = $this->EjecutaQuerySimple();
    	}
      //echo $this->query;
    	if($rs){
    		$consulta = $this->EjecutaQuerySimple();
    		$a = array("status"=>"OK","reponse"=>$docu,"fecha"=>$fecha);
    	}
    	return $a;
    }


    function guardaEdoCta($pagos, $compras, $gastos){
       	
    	$pagos = explode(',', $pagos);
    	foreach ($pagos as $p){
    		$tipo = substr($p,0,1);
    		$iden = substr($p,2,10);
    		$this->query = "UPDATE carga_pagos set seleccionado = 2, guardado = 1 where ID = $iden and seleccionado = 1";
    		$this->EjecutaQuerySimple();
    	}

    	$compras = explode(',', $compras);
    	var_dump($compras);
    	foreach ($compras as $c){
    		$tipo = substr($c, 0,1);
    		$iden = substr($c, 2, 10);

    		if($tipo == 2){
    			$this->query="UPDATE compo01 set seleccionado = 2, guardado = 1  where cve_doc = '$iden' and seleccionado  = 1";
    			$this->EjecutaQuerySimple();	
    		}elseif($tipo == 3 or $tipo == 5){
    			$iden = substr($iden,3,10);
    			$this->query="UPDATE CR_DIRECTO SET seleccionado = 2, guardado = 1  where ID = $iden and seleccionado = 1";
    			$this->EjecutaQuerySimple();
    			//echo 'consulra cr_directo'.$this->query.'<p>';
    		}elseif ($tipo == 4){
    			$iden = substr($iden,3, 10);
    			$this->query="UPDATE GASTOS SET seleccionado = 2, guardado = 1  where ID = $iden and seleccionado = 1";
    			$this->EjecutaQuerySimple();
    		}elseif ($tipo == 6) {
    			$iden = substr($iden, 1,10);
    			$this->query="UPDATE DEUDORES SET seleccionado = 2, guardado = 1  where iddeudor =$iden and seleccionado = 1 ";
    			$this->EjecutaQuerySimple();
    			echo $this->query;

    		}elseif ($tipo  == 7) {
    			$iden = substr($iden, 4, 10);
    			$this->query="UPDATE SOLICITUD_PAGO set seleccionado = 2, guardado = 1  where idsol = $iden and seleccionado =1";
    			$this->EjecutaQuerySimple();
    		}elseif($tipo == 8){
    			$this->query="UPDATE FTC_POC set seleccionado = 2, guardado = 1  where OC = '$iden' and seleccionado =1";
    			$this->EjecutaQuerySimple();
    		}
    		echo $this->EjecutaQuerySimple();
    	}
    	echo $tipo.'<p>  identificador: '.$iden.'<p>';
    //break;
    }


   
    function cerrarEdoCtaMes($mes, $anio, $abonos,$cargos, $inicial, $final, $cuenta, $banco){
    	$usuario = $_SESSION['user']->NOMBRE;
    	$nuevoMes = $mes + 1;

    	//echo 'Nuevo mes:'.$nuevoMes.'  nuevo año: '.$anio;
    	$nuevaFecha = '01.'.$nuevoMes.'.'.$anio;

    	//// carga_Pagos
   
		    	$this->query="UPDATE CARGA_PAGOS SET FECHA_RECEP = '$nuevaFecha' WHERE extract(month from fecha_recep) = $mes and extract(year from fecha_recep) = $anio and (seleccionado = 0 or seleccionado is null) and BANCO = ('$banco'||' - '||'$cuenta') ";
		    	$this->EjecutaQuerySimple();

		    	/// compo01 
		    	$this->query="UPDATE COMPO01 SET edocta_fecha = '$nuevaFecha' where extract(month from edocta_fecha) = $mes and extract(year from edocta_fecha) = $anio and (seleccionado = 0 or seleccionado is null) and BANCO = ('$banco'||' - '||'$cuenta')";
		    	$this->EjecutaQuerySimple();


		    	/// Gastos 
				$this->query="UPDATE GASTOS SET FECHA_EDO_CTA = '$nuevaFecha' where iif(extract(month from fecha_edo_cta) is null, extract(month from fecha_doc), extract(month from fecha_edo_cta))  = $mes and iif(extract(year from fecha_edo_cta) is null, extract(year from fecha_doc), extract(year from fecha_edo_cta))  = $anio and (seleccionado = 0 or seleccionado is null)";
		    	$this->EjecutaQuerySimple();

		    	/// CR_DIRECTO

		    	$this->query="UPDATE CR_DIRECTO SET FECHA_EDO_CTA = '$nuevaFecha' where extract(month from fecha_edo_cta) = $mes and extract(year from fecha_edo_cta) = $anio and (seleccionado = 0 or seleccionado is null) and BANCO = '$banco' and cuenta = '$cuenta'";

		    	$this->EjecutaQuerySimple();
				//// Deudores

		    	$this->query="UPDATE DEUDORES SET FECHAEDO_CTA = '$nuevaFecha' where extract(month from fechaedo_cta) = $mes and extract(year from fechaedo_cta) = $anio and (seleccionado = 0 or seleccionado is null) and banco=('$banco'||' - '||'$cuenta') ";
		    	$this->EjecutaQuerySimple();
				//// SOLICITUD_PAGO
		    	$this->query="UPDATE SOLICITUD_PAGO SET FECHA_EDO_CTA = '$nuevaFecha' 
		    		where iif(fecha_edo_cta is null, extract(month from fecha_reg_pago_final), extract(month from FECHA_EDO_CTA)) = $mes
		    		 and iif(fecha_edo_cta is null, extract(year from fecha_reg_pago_final), extract(year from FECHA_EDO_CTA)) = $anio
		    		 and (seleccionado = 0 or seleccionado is null) 
		    		 and banco_final=('$banco'||' - '||'$cuenta')  ";
		    	$this->EjecutaQuerySimple();

			    	
		    $inicial = str_replace(',', '', $inicial);
		    $abonos = str_replace(',', '',$abonos);
		    $cargos = str_replace(',', '',$cargos);
		    $final = str_replace(',', '',$final);


    	$this->query = "INSERT INTO CIERRE_MENSUAL (MES, ANIO, CUENTA, BANCO, INICIAL, ABONOS, CARGOS, FINAL, fecha_cierre, usuario_cierre, tipo )
    							VALUES( '$mes', '$anio', '$cuenta', '$banco', $inicial, $abonos, $cargos, $final, current_timestamp, '$usuario', 'banco') ";
    	$this->EjecutaQuerySimple();

    	$mes = $mes+ 1; 

    	if(strlen($mes) == 1){
    		$mesr = '0'.$mes;
    	}

    	$campo = 'SALDOI'.$mesr;

    	$this->query="UPDATE PG_BANCOS SET $campo = $final where num_cuenta = '$cuenta' and Banco = '$banco'";
    	$this->EjecutaQuerySimple();

    	//echo $this->query;
		
    	//break;
    	return;

    }

  
  
  function reporteRecibo(){
  	
  	$data=array();
  	$this->query="SELECT ftcdr.orden as orden, ftcdr.id_rechazo as rechazo, ftcdr.id_recepcion, sum(ftcdr.cantidad_rec) as cantidad_rec, max(ftcdr.partida) as partida, max(ftcdr.usuario) as usuario, max(ftcdr.fecha) as fecha, max(ftcdr.impresion) as impresion, max(p.nombre) as nombre
          FROM FTC_DETALLE_RECEPCIONES ftcdr
          left join ftc_poc ftcpoc on ftcpoc.oc = ftcdr.orden
          left join prov01 p on trim(p.clave) = trim(ftcpoc.cve_prov)
           WHERE RECIBO_CONTA IS NULL AND FECHA >= '21.11.2017' group by orden, id_recepcion, id_rechazo";
  	$rs=$this->EjecutaQuerySimple();

  	while($tsArray=ibase_fetch_object($rs)){
  		$data[]=$tsArray;
  	}

  	return $data;
  } 


  function recibeRec($id, $tipo2){
  	
  	$usuario = $_SESSION['user']->NOMBRE; 
  	$id = split('-', $id);
  	$orden = $id[0];
  	$tipo = $id[1];
  	$id = $id[2];
  	//echo 'Tipo:'.$tipo2; 
  	if($tipo2 == 'Seleccion'){
  			  	if(trim($tipo) == 'Recibo'){
				  	$this->query="SELECT iif(USUARIO_RECIBO_CONTA is null, 'No', USUARIO_RECIBO_CONTA ) AS NOMBRE FROM FTC_DETALLE_RECEPCIONES  WHERE id_recepcion = $id and orden = '$orden' group by USUARIO_RECIBO_CONTA";
				  		$rs  = $this->EjecutaQuerySimple();
				  		//echo 'Obtener Nombre'.$this->query;
				  	}elseif (trim($tipo) == 'Rechazo'){
				  		$this->query="SELECT iif(USUARIO_RECIBO_CONTA is null, 'No', USUARIO_RECIBO_CONTA ) AS NOMBRE FROM FTC_DETALLE_RECEPCIONES  WHERE id_rechazo = $id and orden = '$orden' group by USUARIO_RECIBO_CONTA";
				  		$rs  = $this->EjecutaQuerySimple();
				  	}
			  	$row = ibase_fetch_object($rs);
			  	$nombre = $row->NOMBRE;
			  	//echo 'Nombre : '.$nombre;
			  	if($nombre== 'No'){

			  		if(trim($tipo) == 'Recibo'){
			  			$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET USUARIO_RECIBO_CONTA = '$usuario', recibo_conta = 1, fecha_recibo_conta= current_timestamp where id_recepcion = $id and orden = '$orden'";
			  			$this->EjecutaQuerySimple();
			  				//echo 'Consulta de actualizacion: '.$this->query;
			  		}elseif(trim($tipo) == 'Rechazo'){
			  			$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET USUARIO_RECIBO_CONTA = '$usuario', recibo_conta = 1, fecha_recibo_conta= current_timestamp where id_rechazo = $id and orden = '$orden'";
			  			$this->EjecutaQuerySimple();				
			  		}
			  		$response= array("status"=>"ok","response"=>$usuario);
			  	}else{
			  		$response= array("status"=>"no","response"=>$nombre);
			  	}
  	}elseif($tipo2 == 'NoSeleccionado'){
  			if(trim($tipo) == 'Recibo'){
				  	$this->query="SELECT iif(USUARIO_RECIBO_CONTA is null, 'No', USUARIO_RECIBO_CONTA ) AS NOMBRE FROM FTC_DETALLE_RECEPCIONES  WHERE id_recepcion = $id and orden = '$orden' group by USUARIO_RECIBO_CONTA";
				  		$rs  = $this->EjecutaQuerySimple();
				  	}elseif (trim($tipo) == 'Rechazo'){
				  		$this->query="SELECT iif(USUARIO_RECIBO_CONTA is null, 'No', USUARIO_RECIBO_CONTA ) AS NOMBRE FROM FTC_DETALLE_RECEPCIONES  WHERE id_rechazo = $id and orden = '$orden' group by USUARIO_RECIBO_CONTA";
				  		$rs  = $this->EjecutaQuerySimple();
				  	}
			  	$row = ibase_fetch_object($rs);
			  	$nombre = $row->NOMBRE;

			  	if($nombre== 'No'){

			  		if(trim($tipo) == 'Recibido'){
			  			$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET USUARIO_RECIBO_CONTA = '$usuario', recibo_conta = 0, fecha_recibo_conta= current_timestamp where id_recepcion = $id and orden = '$orden'";
			  			$this->EjecutaQuerySimple();	
			  		}elseif(trim($tipo) == 'Rechazo'){
			  			$this->query="UPDATE FTC_DETALLE_RECEPCIONES SET USUARIO_RECIBO_CONTA = '$usuario', recibo_conta = 0, fecha_recibo_conta= current_timestamp where id_rechazo = $id and orden = '$orden'";
			  			$this->EjecutaQuerySimple();				
			  		}
			  		$response= array("status"=>"ok","response"=>$usuario);
			  	}else{
			  		$response= array("status"=>"no","response"=>$nombre);
			  	}

  	}
  	
  	return $response;
  }


   function layoutBBVA($docs){

  	$usuario = $_SESSION['user']->NOMBRE;

  	$TIME = time();
	$HOY = date("Y-m-d THi");
  	$this->query="SELECT iif(MAX(NUMERO) is null, 0, max(numero)) AS NUMERO FROM LAYOUT_BBVA";
  	$rs=$this->EjecutaQuerySimple();
  	$row1 = ibase_fetch_object($rs);
  	$numero  = $row1->NUMERO + 1;

  	$total = 0;
  	
  	for($i=0; $i< count($docs); $i++){

  	if( substr($docs[$i],0,1) == 'O') {
  		$this->query="SELECT COSTO_TOTAL FROM FTC_POC WHERE OC = '$docs[$i]'";
  		$result = $this->EjecutaQuerySimple();
  		$row4=ibase_fetch_object($result);
  		$ct = $row4->COSTO_TOTAL;
  	}else{
  		$this->query="SELECT MONTO FROM SOLICITUD_PAGO WHERE IDsol = $docs[$i]";
  		$res = $this->EjecutaQuerySimple();
  		$row4 = ibase_fetch_object($res);
  		$ct = $row4->MONTO;
  	}
  		$total = $total + $ct;

  	}

  	for ($i=0; $i < count($docs); $i++){ 
  		echo 'Documento '.$i.' : '.$docs[$i].'<p>';

  		if(substr($docs[$i], 0,1) == 'O'){
		  		$this->query="SELECT * FROM FTC_POC F LEFT JOIN PROV01 P ON P.CLAVE = F.CVE_PROV WHERE OC= '$docs[$i]'";
		  		$res = $this->EjecutaQuerySimple();
		  		$row = ibase_fetch_object($res);
		  		$CTT = $row->COSTO_TOTAL;
		  		$this->query="INSERT INTO LAYOUT_BBVA (ID, NUMERO, CLAVE, NOMBRE, DOCUMENTO, IMPORTE, FECHA, USUARIO, CUENTA, status) VALUES (NULL, $numero ,'$row->CLAVE', '$row->NOMBRE', '$docs[$i]', $row->COSTO_TOTAL, CURRENT_TIMESTAMP, '$usuario', '$row->CUENTA', 0)";
		  		$this->EjecutaQuerySimple();
		  	}else{
		  		$this->query="SELECT * FROM SOLICITUD_PAGO S LEFT JOIN PROV01 P ON P.CLAVE = S.PROVEEDOR WHERE IDSOL= $docs[$i]";
		  		$res = $this->EjecutaQuerySimple();
		  		$row = ibase_fetch_object($res);
		  		$CTT = $row->MONTO;

		  		$this->query="INSERT INTO LAYOUT_BBVA (ID, NUMERO, CLAVE, NOMBRE, DOCUMENTO, IMPORTE, FECHA, USUARIO, CUENTA, status) VALUES (NULL, $numero ,'$row->CLAVE', '$row->NOMBRE', '$docs[$i]', $row->MONTO, CURRENT_TIMESTAMP, '$usuario', '$row->CUENTA', 0)";
		  		$this->EjecutaQuerySimple();
		  		
		  	}
  		
  		$file = fopen("app\LayoutBBVA\LayOut_BBVA_".$numero."_".$HOY."_".round($total).".txt","a");

  		if(substr($row->CUENTA,0,3) == '012' or substr($row->CUENTA,0,3) == '000'){
  			if(substr($row->CUENTA,0,3) == '012'){
  				$cuentaProveedor = '00000000'.substr($row->CUENTA,7,10);	
  			}elseif (substr($row->CUENTA,0,3) == '000'){
  				$cuentaProveedor = '00000000'.substr($row->CUENTA,8,10);	
  			}
  			$tipo = 'PTC';
  			$banco = substr($row->CUENTA, 0,3);
  			$importe= str_pad(number_format($CTT, 2, '.',''),16,"0",STR_PAD_LEFT);
  			$motivo = str_pad($docs[$i].$numero, 30, " ");
  			//$refnumerica = str_pad($numero,7,"0",STR_PAD_LEFT);
  			$nombreProveedor = str_pad(substr($row->NOMBRE,0,30),30," ");
  			fwrite($file,$tipo.$cuentaProveedor.'000000000156324495'.'MXP'.$importe.$motivo.PHP_EOL);
  		}else{
  			$tipo = 'PSC';
  			$importe= str_pad(number_format($CTT, 2, '.',''),16,"0",STR_PAD_LEFT);
  			$motivo = str_pad($docs[$i], 30, " ");
  			$refnumerica = str_pad($numero,7,"0",STR_PAD_LEFT);
  			$nombreProveedor = str_pad(substr($row->NOMBRE,0,30),30," ");
  			$cuentaProveedor = $row->CUENTA;
  			$banco = substr($row->CUENTA,0,3);
  			fwrite($file,$tipo.$cuentaProveedor.'000000000156324495'.'MXP'.$importe.$nombreProveedor.'40'.$banco.$motivo.$refnumerica.'H'.PHP_EOL);
  		}


  		fclose($file);

  		if(substr($docs[$i], 0,1) == 'O'){
  			$this->query="UPDATE FTC_POC SET USUARIO_PAGO = '$usuario' where oc = '$docs[$i]'";
  			$this->EjecutaQuerySimple();
  		}else{
  			$this->query="UPDATE SOLICITUD_PAGO SET USUARIO_PAGO = '$usuario' where idsol = $docs[$i]";
  			$this->EjecutaQuerySimple();

  		}
  	}
  	return;
  }


  function verLayOut(){
  		$this->query="SELECT NUMERO, SUM(IMPORTE) as importe , MAX(FECHA) as fecha, MAX(USUARIO) as usuario, MAX(STATUS) as status FROM LAYOUT_BBVA GROUP BY NUMERO";
  		$rs=$this->EjecutaQuerySimple();

  		while($tsArray=ibase_fetch_object($rs)){
  			$data[]=$tsArray;
  		}
  		return $data;
  }


  function generaComprobantes($datos){
  	$usuario = $_SESSION['user']->NOMBRE;
  	foreach ($datos as $key) {
  		//echo 'OC: '.$key['OC'].' Importe: '.$key['IMPORTE'].' STATUS: '.$key['STATUS'].'<p>';
  		$oc = $key['OC'];
  		$importe = $key['IMPORTE'];
  		$status = $key['STATUS'];
  		$proveedor = $key['PROVEEDOR'];
  		$numero = $key['NUMERO'];
  		$status1 = $key['STATUS1'];  		
  		if(substr($oc, 0,1)== 'O'){
  			if(strlen($oc) > 6){
  				$oc = substr($oc,0,6);
  			}
  			$this->query="UPDATE LAYOUT_BBVA SET STATUS = $status1 where status =0 and documento = '$oc' and importe = $importe and numero = $numero";
	  		@$this->EjecutaQuerySimple();	
  		}else{
  			$oc = substr($oc, 0,4);
  			$this->query="UPDATE LAYOUT_BBVA SET STATUS = $status1 where status =0 and documento = '$oc' and importe = $importe";
	  		@$this->EjecutaQuerySimple();
  		}
  		echo 'Documento:'.$oc.' status = '.$status1.'<p>';
  		
  		if($status1 == 6){
  		
  		$st = 'Operado';

  		$this->query="INSERT INTO P_TRANS (TIPO, FECHA, MONTO, BENEFICIARIO, IVA, DOCUMENTO, FECHAELAB, CVE_PROV,STATUS,FECHA_DOC, FECHA_APLI, TRANS, USUARIO_PAGO, BANCO) VALUES ( 'tr', current_timestamp ,$importe, '$proveedor', $importe / 1.16, '$oc', current_timestamp, (SELECT CVE_PROV FROM FTC_POC WHERE OC = trim('$oc')) , 'N',(select FECHA_OC FROM FTC_POC WHERE OC  = trim('$oc')), current_timestamp, '0', '$usuario', 'Bancomer - 0156324495')";
  		@$this->EjecutaQuerySimple();

		  		if(substr($oc, 0,1)== 'O'){
		  		echo 'Inserta Pago: <p>'.$this->query.'<p>';
		  		$this->query="UPDATE ftc_poc SET TP_TES = 'Tr', PAGO_TES = $importe, FECHA_PAGO = current_timestamp, STATUS = 'PAGADA' WHERE Trim(OC) = trim('$oc')";
		  		$this->EjecutaQuerySimple();
		  		echo 'Consulta para Ordenes de compra: '.$this->query.'<p>';
		  		}else{

		  		$this->query="UPDATE SOLICITUD_PAGO SET TP_TES_FINAL = 'Tr',MONTO_FINAL = $importe, BANCO_FINAL = 'Bancomer - 0156324495', fecha_reg_pago_final= CURRENT_DATE, FECHA_PAGO = CURRENT_TIMESTAMP, STATUS = 'Pagado' where idsol = $oc";
		  		$this->EjecutaQuerySimple();
				//echo 'Consulta para solicitudes: '-$this->query.'<p>';
				}
  		echo 'Actualia ftc_poc : <p> '.$this->query.'<p>';
  		}else{

  			if($status1 == 5){
  				$st = 'Rechazado en la operación';
  				
  				if(substr($oc, 0,1)== 'O'){
		  		$this->query="UPDATE FTC_POC SET usuario_pago = null where trim(OC) = trim('$oc')";
  				$this->EjecutaQuerySimple();
				}else{
		  		$this->query="UPDATE SOLICITUD_PAGO SET  usuario_pago = null where idsol = $oc";
		  		$this->EjecutaQuerySimple();
				//echo 'Consulta para solicitudes: '-$this->query.'<p>';
				}


  			}elseif($status1 == 8){
  				$st = 'Rechazado en validación';
  				if(substr($oc, 0,1)== 'O'){
		  		$this->query="UPDATE FTC_POC SET usuario_pago = null where trim(OC) = trim('$oc')";
  				$this->EjecutaQuerySimple();
				}else{
		  		$this->query="UPDATE SOLICITUD_PAGO SET  usuario_pago = null where idsol = $oc";
		  		$this->EjecutaQuerySimple();
				//echo 'Consulta para solicitudes: '-$this->query.'<p>';
				}

  			}else{
  				$st = 'No Identificado';
  			}
  				
  				
  				if(substr($oc, 0,1)== 'O'){
		  			$this->query="UPDATE ftc_poc SET STATUStr = '$st' WHERE Trim(OC) = trim('$oc')";
		  			$this->EjecutaQuerySimple();
		  		}else{

		  		$this->query="UPDATE SOLICITUD_PAGO SET statustr = '$st' where idsol = $oc";
		  		$this->EjecutaQuerySimple();
				//echo 'Consulta para solicitudes: '-$this->query.'<p>';
				}

  		}
  	}
  	//break;
  	return;
  }


  function guardaPedido($target_file, $cotizacion){
  	$this->query="UPDATE CAJAS_ALMACEN SET NOMBRE_ARCHIVO = '$target_file' where pedido = '$cotizacion'";
  	$this->EjecutaQuerySimple();
   	return;
  }

  function actualizaProveedorBBVA($datos){

  		foreach ($datos as $key ){
  			$clave = $key['CVE_PROV'];
  			$res = trim($key['Resultado']);
  			$cuenta = ($key['Cuenta']);
  			$banco =$key['Banco'];
  			/// ALTA EXITOSA
  			/// REGISTRO YA EXISTE 
  			/// CUENTA INEXISTENTE
  			/// CUENTA NO VALIDA
  			if($res=='ALTA EXITOSA' or $res == 'REGISTRO YA EXISTE'){
  				$status = 2;
  			}elseif ($res=='CUENTA INEXISTENTE' OR $res =='CUENTA NO VALIDA'){
  				$status = 8;
  			}else{
  				$status = 9;
  			}
  			if($banco == '000'){
  				$banco = '012';
  			}
  			$this->query="UPDATE PROV01 SET BBVA_ALTA = $status, Ultimo_status = '$res', CUENTA = '$cuenta', banco = '$banco' WHERE trim(clave) = trim('$clave')";
  			$this->EjecutaQuerySimple();
  			//echo $this->query.'<p>';
  		}
  		return;		
  }

    function calculoComisiones($anio , $mes, $vendedor){
  	$a = '';

  	$this->query="UPDATE factd01 set vendedor_real = (select vendedor from ftc_cotizacion where pedido_liberado= cve_cotizacion) where vendedor_real is null";
  	$this->grabaBD();

  	if($vendedor != 'all'){
  		$a = " and vendedor_real  ='".$vendedor."'"; 
  	}
	  	$this->query="SELECT 'f' as tipo, CVE_CLPV, NOMBRE, CVE_DOC, NC_APLICADAS, FECHAELAB, IMPORTE, PAGOS, IMPORTE_NC, SALDOFINAL, PEDIDO, VENDEDOR_REAL
	  	  	FROM FACTURAS f  
	  	  	WHERE EXTRACT(YEAR FROM FECHA_DOC) = $anio 
	  	  		AND EXTRACT(MONTH FROM FECHA_DOC) = $mes $a";
	  	$rs= $this->EjecutaQuerySimple();
	  	while($tsArray=ibase_fetch_object($rs)){
	  		$data[]=$tsArray;
	  	}

	if($vendedor != 'all'){
  		$a = " and nc.vendedor_real  ='".$vendedor."'"; 
  	}

	  	$this->query="SELECT 'nc' as tipo, nc.CVE_CLPV, NOMBRE, nc.CVE_DOC, 0 AS NC_APLICADAS, nc.FECHAELAB, (nc.IMPORTE / 1.16) as importe, 0 AS PAGOS, 0 AS IMPORTE_NC, nc.IMPORTE AS SALDOFINAL, pedido, (select vendedor from ftc_cotizacion where (serie||folio) = pedido) as vendedor_real FROM FACTD01 NC LEFT JOIN FACTURAS F ON NC.DOC_ANT = F.CVE_DOC WHERE nc.status <> 'C' and extract(year from nc.fecha_doc) = $anio and extract(month from nc.fecha_doc) = $mes $a";
	  	$rs=$this->EjecutaQuerySimple();
	  	while ($tsArray = ibase_fetch_object($rs)){
	  		$data[]=$tsArray;
	  	}
  	return @$data;
  }

  function vendedores(){
  	$this->query="SELECT * FROM PG_USERS WHERE USER_ROL='ventasp' and user_status = 'alta'";
  	$rs=$this->EjecutaQuerySimple();

  	while($tsArray=ibase_fetch_object($rs)){
  		$data[] = $tsArray;
  	}
  	return $data;
  }


  function verRemisionesPendientes(){
  	$this->query="SELECT  max(doc_sig) as factura, max(doc_ant) as pedidoPegaso, max(importe) as importe,  max(cl.nombre) as nombre , R.CVE_DOC, SUM(PXS) as pendientes, MAX(FECHAELAB) as fechaelab, max(cve_pedi) as pedido FROM PAR_FACTR01 PR LEFT JOIN FACTR01 R ON R.CVE_DOC = PR.CVE_DOC left join clie01 cl on cl.clave = R.cve_clpv  WHERE R.FECHAELAB >= '01.01.2017' and r.status !='C' GROUP BY R.CVE_DOC HAVING SUM(PXS) > 0";
  	$rs=$this->EjecutaQuerySimple();

  	while ($tsArray=ibase_fetch_object($rs)){
  		$data[]=$tsArray;
  	}
  	return $data;
  }

  function detalleRemision($docf){
  	$this->query="SELECT pf.*, iif((select descr from inve01 i where pf.cve_art = i.cve_art) is null, (select NOMBRE from producto_ftc where clave = pf.cve_art), (select descr from inve01 i where pf.cve_art = i.cve_art)) as descripcion FROM PAR_FACTR01 pf WHERE CVE_DOC = '$docf'";
  	$rs=$this->EjecutaQuerySimple();
  	while ($tsArray=ibase_fetch_object($rs)) {
  		$data[]=$tsArray;
  	}
  	return $data;
  }

  function abrirCajaBodega(){
  	$this->query="SELECT ca.* FROM CAJAS_ALMACEN ca WHERE STATUS = 1 AND FECHA_ALMACEN >= '01.12.2017' order by FECHA_ALMACEN asc";
  	$rs=$this->EjecutaQuerySimple();
  	while ($tsArray=ibase_fetch_object($rs)){
  		$data[]=$tsArray;
  	}
  	return $data;
  }

  function verCajaAlmacen($pedido){
  	$this->query="SELECT * FROM PREOC01 WHERE COTIZA  = '$pedido'";
  	$rs=$this->EjecutaQuerySimple();

  	while ($tsArray=ibase_fetch_object($rs)) {
  		$data[]=$tsArray;
  	}

  	return $data;
  }


  function buscaFacturaRefac($opcion, $docf){
  	$this->query="SELECT * FROM facturas where upper(cve_doc) = trim(upper('$docf'))";
  	$rs=$this->EjecutaQuerySimple();
  	while($tsArray = ibase_fetch_object($rs)){
  		$data[]=$tsArray;
  	}

  	return @$data;
  }

  function historicoRefac($facturas){
  	foreach ($facturas as $key) {
  		$this->query="SELECT * FROM REFACTURACION WHERE FACT_ORIGINAL = UPPER(TRIM('$key->CVE_DOC'))";
  		$rs=$this->EjecutaQuerySimple();
  		
  		while ($tsArray=ibase_fetch_object($rs)) {
  			$data[]=$tsArray;
  		}
  	}
  	return @$data;
  }

    function traeClientes3(){
    	$this->query="SELECT * FROM CLIE01 WHERE STATUS = 'A'";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	return $data;
    }


    function traeDetalleFactura($facturas){
    	//echo 'Este es el tipo de variable: '.gettype($facturas);
	    	if(gettype($facturas) == 'array'){
	    		foreach($facturas as $key) {
	    			$this->query="SELECT * FROM PAR_FACTF01 pf left join producto_ftc ftca on ftca.clave = pf.cve_art WHERE CVE_DOC= '$key->CVE_DOC'";
	    			$rs=$this->EjecutaQuerySimple();
	    			while($tsArray=ibase_fetch_object($rs)){
	    				$data[]=$tsArray;
	    			}
	    		}	
	    	}else{
	    		$this->query="SELECT * FROM PAR_FACTF01 pf left join producto_ftc ftca on ftca.clave = pf.cve_art WHERE CVE_DOC= '$facturas'";
	    		$rs=$this->EjecutaQuerySimple();
	    			while ($tsArray=ibase_fetch_object($rs)) {
	    				$data[]=$tsArray;
	    			}
	    	}
  		return $data;
    }

  	function facturaProcesoCambioFecha($docf){
	  	$usuario = $_SESSION['user']->NOMBRE;
	  	$this->query="SELECT CTRL_FACT, ID_REFACT from FACTF01 WHERE CVE_DOC = '$docf'";
	  	$rs=$this->EjecutaQuerySimple();
	  	$row = ibase_fetch_object($rs);
		  	if($row->CTRL_FACT == 'EN PROCESO'){
		  		$status = 'status: enProceso';
		  	}elseif($row->CTRL_FACT == 'Refacturado'){
		  		$statsu = 'status: refacturado';
		  	}else{
			  	$this->query="UPDATE FACTF01 SET CTRL_FACT = 'EN PROCESO', USUARIO_SOLICITUD= '$usuario' WHERE CVE_DOC = '$docf'";
			  	$this->EjecutaQuerySimple();
			  	$statsu = 'status: ok';
		  	}
	}
	
	function refacturarFecha($docf, $nf, $obs, $opcion){
			$usuario =$_SESSION['user']->NOMBRE;
			$docf = trim($docf);
			$docf = strtoupper($docf);

			$this->query="SELECT * FROM FACTF01 WHERE CVE_DOC = upper(trim('$docf'))";
		  	$rs=$this->EjecutaQuerySimple();
		  	$row =ibase_fetch_object($rs);

		  	$this->query="SELECT MIN(STATUS_SOLICITUD) AS VALIDACION FROM REFACTURACION WHERE FACT_ORIGINAL = '$docf'";
		  	$res=$this->EjecutaQuerySimple();
		  	$row2=ibase_fetch_object($res);

			  	if($row->STATUS != 'C' and $row2->VALIDACION != 1){

			  		if($opcion == 1 ){
				  		$this->query="INSERT INTO REFACTURACION (ID, FACT_ORIGINAL, USUARIO_SOLICITUD, FECHA_SOLICITUD, STATUS_SOLICITUD, TIPO_SOLICITUD, NUEVA_FECHA, observaciones ) VALUES (NULL, '$docf', '$usuario', current_timestamp, 1, 'CAMBIO FECHA','$nf', '$obs' )";
				  		$this->grabaBD();

				  		$this->query="INSERT INTO REFACTURACION_DETALLE (ID_REFAC, NUEVA_FECHA, OBSERVACIONES) VALUES ( (SELECT MAX(ID) FROM REFACTURACION), '$nf', '$obs' )";
				  		$this->grabaBD();

			  		}elseif($opcion == 2){
				  		$this->query="INSERT INTO REFACTURACION (ID, FACT_ORIGINAL, USUARIO_SOLICITUD, FECHA_SOLICITUD, STATUS_SOLICITUD, TIPO_SOLICITUD, NUEVO_CLIENTE, observaciones ) VALUES (NULL, '$docf', '$usuario', current_timestamp, 1, 'CAMBIO CLIENTE','$nf', '$obs' )";
				  		$this->grabaBD();

				  		$this->query="INSERT INTO REFACTURACION_DETALLE (ID_REFAC, NUEVO_CLIENTE, OBSERVACIONES) VALUES ( (SELECT MAX(ID) FROM REFACTURACION), '$nf, '$obs' )";
				  		$this->grabaBD();
			  		}	
		  		}	
  		return; 
    }

    function refacturarDireccion($docf, $calle, $num_ext, $num_int, $colonia, $municipio, $ciudad, $referencia, $obs, $opcion, $cp){
		$usuario =$_SESSION['user']->NOMBRE;
		$docf = trim($docf);
		$docf = strtoupper($docf);
	
		$this->query="SELECT * FROM FACTF01 WHERE CVE_DOC = '$docf'";
	  	$rs=$this->EjecutaQuerySimple();
	  	$row =ibase_fetch_object($rs);

	  	$this->query="SELECT MIN(STATUS_SOLICITUD) AS VALIDACION FROM REFACTURACION WHERE FACT_ORIGINAL = '$docf'";
	  	$res=$this->EjecutaQuerySimple();
	  	$row2=ibase_fetch_object($res);

		    if($row->STATUS != 'C' and $row2->VALIDACION != 1){
			  	/*
			  	$this->query ="UPDATE CLIE01 SET CALLE_ENVIO = '$calle', numext_envio = '$num_ext', numint_envio= '$num_int', colonia_envio = '$colonia', municipio_envio='$municipio', estado_envio= '$ciudad', codigo_envio = '$cp' where clave = '$row->CVE_CLPV'";
			  	$this->EjecutaQuerySimple();
	 	    	echo 'Actualiza Cliente: '.$this->query;
	 	    	*/
	 	    	$this->query="INSERT INTO REFACTURACION (ID, FACT_ORIGINAL, USUARIO_SOLICITUD, FECHA_SOLICITUD, STATUS_SOLICITUD, TIPO_SOLICITUD, observaciones ) VALUES (NULL, '$docf', '$usuario', current_timestamp, 1, 'CAMBIO DOMICILIO','$obs' )";
		  		$this->grabaBD();
		  		//echo 'Ingresa Refacturacion : '.$this->query;

		  		$this->query="INSERT INTO REFACTURACION_DETALLE VALUES (NULL, (SELECT MAX(ID) FROM REFACTURACION), NULL, '$row->CVE_CLPV', '$obs', '$calle', '$num_ext', '$num_int', '$colonia', '$municipio', '$ciudad', '$cp', '$referencia')";
		  		$this->grabaBD();
		  		//echo 'Ingreso a Refacturacion detalle: '.$this->query;
	 	    }
	 	    //break;
	 	return;
	}

    function guardaPartida($docf, $par, $precio){

    	$this->query= "SELECT MIN(STATUS_SOLICITUD) AS VALIDACION  FROM REFACTURACION WHERE FACT_ORIGINAL = '$docf'";
    	$rs =$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);

    	$response = array("status"=>"no", "response"=>'no');
    	if($row->VALIDACION != 1){
    		$this->query="UPDATE FACTF01 SET CTRL_FACT = 'EN ESPERA' WHERE CVE_DOC = '$docf'";
	    	$this->grabaBD();
	    	
	    	$this->query="UPDATE PAR_FACTF01 SET NUEVO_PRECIO = $precio where cve_doc = '$docf' and num_par = $par";
	    	$this->grabaBD();

	    	$response= array("status"=>"ok","response"=>'ok');	
    	}
    	return $response;
    }

    function solicitudPrecio($docf){
    	$usuario=$_SESSION['user']->NOMBRE;

    	$this->query= "SELECT MIN(STATUS_SOLICITUD) AS VALIDACION  FROM REFACTURACION WHERE FACT_ORIGINAL = '$docf'";
    	$rs =$this->EjecutaQuerySimple();
    	$row=ibase_fetch_object($rs);

    	if($row->VALIDACION != 1){
    		$this->query="INSERT INTO REFACTURACION (ID, FACT_ORIGINAL, USUARIO_SOLICITUD, FECHA_SOLICITUD, STATUS_SOLICITUD, TIPO_SOLICITUD ) VALUES (NULL, '$docf', '$usuario', current_timestamp, 1, 'CAMBIO PRECIO')";
	    	$this->grabaBD();
    	}
    	return;
    }

    function solNC(){
    	$this->query="SELECT * FROM REFACTURACION WHERE STATUS_SOLICITUD = 1";
    	$rs=$this->EjecutaQuerySimple();
    	while ($tsArray=ibase_fetch_object($rs)) {
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

    function verSolNC($id){
    	$this->query="SELECT * FROM REFACTURACION where id=$id ";
    	$rs=$this->EjecutaQuerySimple();

    	while ($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return $data;
    }

    function verDetSolNC($id, $tipo){

    	$this->query="SELECT * FROM REFACTURACION_DETALLE WHERE ID_REFAC = $id";
    	$rs=$this->EjecutaQuerySimple();

    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	}
    	return @$data;
    }

	function ejecutaRefacturacion($id){
		$this->quey="SELECT * FROM REFACTURACION WHERE ID = $id";
		$rs=$this->EjecutaQuerySimple();
		$row1=ibase_fetch_object($rs);

		if($row1->STATUS == 1){
			if($row1->TIPO = 'fe'){
				$this->query="UPDATE REFACTURACION SET STATUS = 2 WHERE ID = $id";
				$this->grabaDB();

				$this->query="SELECT * FROM FACTF01 WHERE CVE_DOC = $row1->FACT_ORIGINAL";
  				$rs=$this->EjecutaQuerySimple();
  				$row =ibase_fetch_object($rs);

				$this->query= "INSERT INTO FACTF01 SET (
  				'row->TIPO'
  				,'$row->CVE_DOC'
  				,'$row->CVE_CLPV'
  				,'$row->STATUS'
  				,'$row->DAT_MOSTR'
  				,'$row->CVE_VEND'
  				,'$row->CVE_PEDI'
  				,'$row->FECHA_DOC'
  				,'$row->FECHA_ENT'
  				,'$row->FECHA_VEN'
  				,'$row->FECHA_CANCELA'
  				,$row->CAN_TOT
  				,$row->IMP_TOT1
  				,$row->IMP_TOT2
  				,$row->IMP_TOT3
  				,$row->IMP_TOT4
  				,$row->DES_TOT
  				,$row->DES_FIN
  				,$row->COM_TOT
  				,'$row->CONDICION'
  				,$row->CVE_OBS
  				,$row->NUM_ALMA
  				,'$row->ACT_CXC'
  				,'$row->ACT_COI'
  				,'$row->ENLAZADO'
  				,'$row->TIP_DOC_E'
  				,$row->NUM_MONED
  				,$row->TIPCAMB
  				,$row->NUM_PAGOS
  				,'$row->FECHAELAB'
  				,$row->PRIMERPAGO
  				,'$row->RFC'
  				,$row->CTLPOL
  				,'$row->ESCFD'
  				,$row->AUTORIZA
  				,'$row->SERIE'
  				,$row->FOLIO
  				,'$row->AUTOANIO'
  				,'$row->DAT_ENVIO'
  				,'$row->CONTADO'
  				,$row->CVE_BITA
  				,'$row->BLOQ'
  				,'$row->FORMAENVIO'
  				,$row->DES_FIN_PORC
  				,$row->DES_TOT_PORC
  				,$row->IMPORTE
  				,$row->COM_TOT_PORC
  				,'$row->METODODEPAGO'
  				,'$row->NUMCTAPAGO'
  				,'$row->TIP_DOC_ANT'
  				,'$row->DOC_ANT'
  				,'$row->TIP_DOC_SIG'
  				,'$row->DOC_SIG'
  				,'$row->ID_SEG'
  				,'$row->STATUS_FACT'
  				,'$row->STATUS_MAT'
  				,'$row->CITA'
  				,'$row->STATUS_EMB'
  				,'$row->STATUS_LOG'
  				,'$row->IMPRESO'
  				,$row->VAL_ADUANA
  				,'$row->CONTRARECIBO_CR'
  				,'$row->STATUSCR_CR'
  				,'$row->FECHA_CR'
  				,''
  				,''
  				,'$row->FECHA_VENCIMIENTO'
  				,$row->IDC
  				,'$row->IDCO'
  				,'$row->ENTREGA_BODEGA'
  				,'$row->U_ENTREGA'
  				,'$row->FECHA_ENTREGA'
  				,'$row->LOTE'
  				,'$row->U_RECIBE'
  				,'$row->FECHA_RECIBE'
  				,$row->SALDO
  				,$row->PAGOS
  				,$row->APLICADO
  				,$row->SALDOFINAL
  				,$row->ERROR
  				,$row->IMPORTE_NC
  				,'$row->ID_PAGOS'
  				,'$row->ID_APLICACIONES'
  				,'$row->NC_APLICADAS'
  				,$row->DEUDA2015
  				,'$row->CVE_MAESTRO'
  				,'$row->ENLACE_REMISION'
  				,'$row->CONTABILIZADO'
  				,'$row->POLIZA'
  				,'$row->FECHA_REV'
  				,$row->STATUS_VENCIMIENTO
  				,$row->ACT_DIA
  				,$row->PRORROGA
  				,$row->FOLIO_RUTA_COBRANZA
  				,$row->FORMADEPAGOSAT
  				,$row->USO_CFDI
  				,$row->SALDOFINAL_BU
  				";
  				echo $this->query;
			}
		}


	}


	function verMovInventario($producto){
		$this->query="SELECT FECHA AS FECHA, 'Entrada (Ingreso Bodega)' AS tipo, ID AS IDENTIFICADOR, CANT AS CANTIDAD,  COSTO AS COSTO, UNIDAD AS UNIDAD, PRODUCTO AS PRODUCTO, 0 AS EXISTENCIA, descripcion as descripcion, 'Ing'||id as DOCUMENTO  FROM INGRESOBODEGA where producto = '$producto'";
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		$this->query="SELECT fecha, 'Entrada (Orden de Compra)' AS tipo, D.ID AS IDENTIFICADOR, cantidad_REC as cantidad,  total_costo_unitario AS COSTO, P.UM AS UNIDAD, P.PROD AS PRODUCTO, 0 AS EXISTENCIA,  (select nombre from producto_ftc where clave = p.prod) AS DESCRIPCION, orden as documento   
		 FROM FTC_DETALLE_RECEPCIONES D LEFT JOIN PREOC01 P ON  P.ID = D.IDPREOC WHERE P.PROD = '$producto' AND CANTIDAD_REC > 0 ";
		$rs=$this->EjecutaQuerySimple();

		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		/*

		$this->query="SELECT FECHA_MOV AS FECHA, 'Salida (Facturacion)' AS tipo, A.ID AS IDENTIFICADOR, A.ASIGNADO AS CANTIDAD,  0 AS COSTO, P.UM AS UNIDAD, P.PROD AS PRODUCTO, 0 AS EXISTENCIA,  (select nombre from producto_ftc where clave = p.prod) AS DESCRIPCION, facturas as documento
			 FROM ASIGNACION_BODEGA_PREOC A LEFT JOIN PREOC01 P ON  P.ID = A.PREOC WHERE P.PROD = '$producto'";
		$rs=$this->EjecutaQuerySimple();
		echo $this->query;
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
*/
		$this->query="SELECT FECHA,  'Salida' AS tipo, ID AS IDENTIFICADOR, CANTIDAD, 0 AS COSTO,'' AS UNIDAD, PRODUCTO, 0 AS EXISTENCIA, (select nombre from producto_ftc where clave = PRODUCTO) AS DESCRIPCION, facturas as documento
			FROM CONTROL_FACT_REM WHERE PRODUCTO = '$producto' and pxf <> cantidad";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}

		sort($data); 
		return $data;
	}


function procesarDev($idp, $cantDec, $tipo){
	$usuario=$_SESSION['user']->NOMBRE;
	$this->query="UPDATE PAQUETES SET STATUS = '$tipo' where id = $idp";
	$this->EjecutaQuerySimple();
	

	if($tipo == 'ingresoBodega'){
	
		$this->query="SELECT * FROM PAQUETES WHERE ID = $idp";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$this->query="INSERT INTO INGRESOBODEGA (PRODUCTO, DESCRIPCION, CANT, FECHA, MARCA, Proveedor, Costo, unidad, restante, usuario, origen) 
    	VALUES ('$row->ARTICULO',(select nombre from producto_ftc where clave = '$row->ARTICULO'), $cantDec, current_timestamp, 'DEV-'||$row->FOLIO_DEV, '', (select costo_ventas from producto_ftc where clave = '$row->ARTICULO'), '', $cantDec,'$usuario', 'Devolucion')";
    	$rs =  $this->EjecutaQuerySimple();
	}
	return;
}

   function recepcionOCBdg(){ 
    	$this->query="SELECT 
                            ftc.oc as cve_doc
                            ,'' as doc_sig
                            ,max(ftc.COSTO_TOTAL) as importeOC
                            , max(p.nombre) as nombre
                            ,sum(ftcpoc.pxr) AS PendientesXRecibir
                            , max(fecha_oc) as fechaoc
                            , max(p.clave) as cve_clpv
                            , max(ftc.usuario_oc) as usuario
                            , max(ftc.costo_total) as costo
                            , sum(ftcpoc.pxr) as pxr
                            , '' as urgencia
                            , max(ftc.vueltas) as vuelta
                            , sum(FTCPOC.cantidad) as cantidad
                            , max(ftc.status_recepcion) as status_recepcion
                            , max(ftc.unidad) as unidad
                            , max(ftc.vueltas) as vueltas
                            , (select max(operador) from unidades where numero = max(ftc.unidad) ) as operador
                            , max(ftc.FECHA_ENTREGA) AS FECHA_ENTREGA
                            from ftc_poc ftc
                            left join FTC_POC_DETALLE ftcpoc on ftcpoc.cve_doc = ftc.cve_doc
                            left join prov01 p on p.clave = ftc.cve_prov
                            where ((ftc.status_log = 'Total' or ftc.status_log = 'secuencia' or ftc.status_log='Tiempo' or ftc.status_log = 'admon' or ftc.status_log='Total' or ruta= 'A') or (ftc.fecha_entrega >= current_date and  ftc.fecha_pago is not null) )
                            and (status_recepcion is null or status_recepcion =9)
                            and ftc.OC starting with 'OPI' 
                            group by ftc.oc
                            having sum(ftcpoc.pxr) > 0 ";
        $rs=$this->EjecutaQuerySimple();
    	while($tsArray=ibase_fetch_object($rs)){
    		$data[]=$tsArray;
    	} 
    	return @$data;
    }

function ejecutarRecepcion($ida, $cantRec, $cantOr ){
		$usuario=$_SESSION['user']->NOMBRE;
		$this->query="SELECT * from ASIGNACION_BODEGA_PREOC where id = $ida";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);

		if($row->STATUS == 0){
			if($cantRec == $cantOr){
			$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, USUARIO, FECHA, STATUS, ID_RECEPCION, IMPRESION) VALUES(NULL, '$ida',$row->PREOC, $row->ASIGNADO, $row->ASIGNADO, 1, '$usuario', current_timestamp, 0, (select max(id_recepcion) from ftc_detalle_recepciones)+1, 0)";
			$res= $this->grabaBD();
			$ra=ibase_affected_rows();
			if($ra == 1 ){
				$this->query="SELECT MAX(ID_RECEPCION) AS IDR FROM FTC_DETALLE_RECEPCIONES";
				$res=$this->EjecutaQuerySimple();
				$row2=ibase_fetch_object($res);

				$this->query="UPDATE INGRESOBODEGA SET recibido = recibido + $cantRec where ID = $row->IDINGRESO";
				$this->EjecutaQuerySimple();

				$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET STATUS = 2, recibido = $cantRec WHERE ID = $ida";
				$this->grabaBD();
				

				$this->query="UPDATE PREOC01 SET STATUS = 'N', recepcion = recepcion + $cantRec, rec_faltante = rec_faltante - $cantRec where id = $row->PREOC";
					$this->EjecutaQuerySimple();
					//echo $this->query;
				return array("status"=>"ok", "recepcion"=>$row2->IDR);
			}else{
				return array("status"=>"error", "recepcion"=>"no se genero");
			}
		}elseif($cantRec == 0){
				
				$this->query="UPDATE INGRESOBODEGA SET recibido = recibido + $cantRec where ID = $row->IDINGRESO";
				$this->EjecutaQuerySimple();

				$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET STATUS = 4, recibido = $cantRec WHERE ID = $ida";
				$this->grabaBD();

				$this->query="UPDATE PREOC01 SET STATUS = 'N', ORDENADO = ORDENADO - $cantOr, asignado = asignado - $cantOr, rec_faltante = rec_faltante + $cantOr, rest = rest + $cantOr where id = $row->PREOC";
				$this->EjecutaQuerySimple();

				return array("status"=>"ok", "recepcion"=>'rechazado');
		}elseif($cantRec < $cantOr){

				$dif = $cantOr-$cantRec;
				$this->query="INSERT INTO FTC_DETALLE_RECEPCIONES (ID, ORDEN, IDPREOC, CANTIDAD_OC, CANTIDAD_REC, PARTIDA, USUARIO, FECHA, STATUS, ID_RECEPCION, IMPRESION) VALUES(NULL, '$ida',$row->PREOC, $cantRec, $cantRec, 1, '$usuario', current_timestamp, 0, (select max(id_recepcion) from ftc_detalle_recepciones)+1, 0)";
				$res= $this->grabaBD();
				$ra=ibase_affected_rows();
				if($ra == 1 ){
					$this->query="SELECT MAX(ID_RECEPCION) AS IDR FROM FTC_DETALLE_RECEPCIONES";
					$res=$this->EjecutaQuerySimple();
					$row2=ibase_fetch_object($res);
					$this->query="UPDATE INGRESOBODEGA SET recibido = recibido + $dif where ID = $row->IDINGRESO";
					$this->EjecutaQuerySimple();
					$this->query="UPDATE ASIGNACION_BODEGA_PREOC SET STATUS = 4, recibido = $cantRec WHERE ID = $ida";
					$this->grabaBD();
					//echo $this->query;
					//// 8 - 2 = 6
					$this->query="UPDATE PREOC01 SET STATUS = 'N', ORDENADO = ORDENADO - $dif, asignado = asignado - $dif, recepcion = recepcion + $cantRec, rec_faltante = rec_faltante - $cantRec, rest = rest + $dif where id = $row->PREOC";
					$this->EjecutaQuerySimple();
				

				return array("status"=>"ok", "recepcion"=>$row2->IDR);
				}else{
					return array("status"=>"error", "recepcion"=>"no se genero");
				}				
			}
		}else{

			return array("status"=>"error", "recepcion"=>"La solicitud ya ha sido procesada con anterioridad");
		}			
	}

	function verValesBodega(){
		$data=null;
		$this->query="SELECT ab.*, p.* --,(select avg(costo) from FTC_POC_DETALLE where idpreoc = ab.preoc) as costo  
			FROM ASIGNACION_BODEGA_PREOC ab left join preoc01 p on p.id = ab.preoc WHERE ab.STATUS = 4";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function verInventarioBodega(){
		$this->query="SELECT sum(restante) as restante, max(descripcion) as descripcion, producto, avg(costo) as costo, unidad, max(fecha) as fecha,
				 (select marca from producto_ftc where clave = producto) as marca,
				 (select proveedor from producto_ftc where clave = producto) as proveedor,
				 (select categoria from producto_ftc where clave = producto) as categoria
				 FROM INGRESOBODEGA WHERE RESTANTE > 0 group by producto, unidad ";
		$rs=$this->EjecutaQuerySimple();
		while($tsArray=ibase_fetch_object($rs)){
			$data[]=$tsArray;
		}
		return $data;
	}

	function cierreInvBodega($datos){
			$datos= split(',', $datos);
			//var_dump($datos);
			$usuario = $_SESSION['user']->NOMBRE;
			foreach ($datos as $key) {
				$dato = split(':',$key);
				$canto = $dato[0];
				$cantf = $dato[1];
				$producto = $dato[3];
				$tipo = $dato[4];
				///echo '<br/>'.$canto.' cantidad final: '.$cantf.' producto '.$producto.' tipo '.$tipo.'<br/>';
				if($tipo == 'v'){
					$dif = $canto - $cantf;
					///echo 'esta es la diferencia: '.$dif.'<br/>';
					$this->query="SELECT count(id) as lineas FROM INGRESOBODEGA WHERE PRODUCTO = '$producto' and RESTANTE = $dif";
					$rs=$this->EjecutaQuerySimple();
					$row=ibase_fetch_object($rs);
					///echo 'Consulta'.$this->query.'  Lineas '.$row->LINEAS.'<br/>';
						if($row->LINEAS > 0){
							$this->query="SELECT MIN(ID) as ID FROM INGRESOBODEGA WHERE PRODUCTO = '$producto' and RESTANTE = $dif";
							$res=$this->EjecutaQuerySimple();
							$row2=ibase_fetch_object($res);
							$idi = $row2->ID;
								$this->query="SELECT * FROM INGRESOBODEGA WHERE ID = $idi";
								$result=$this->EjecutaQuerySimple();
								$row3=ibase_fetch_object($result);
								
								$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC  (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, STATUS, VERSUM) VALUES (NULL, $row3->ID, $row3->RESTANTE, $dif, $row3->RESTANTE - $dif, current_timestamp,'$usuario', 4,0)";
								$this->grabaBD();

								$this->query="UPDATE INGRESOBODEGA SET ASIGNADO = $dif, restante= restante - $dif where id = $idi";
								$this->grabaBD();
						}else{
							/// echo 'No hay concidencia exacta, inicia la busqueda: <br/>';
							$this->query="SELECT * from INGRESOBODEGA WHERE PRODUCTO = '$producto' and RESTANTE > 0 ORDER BY ID ASC";
							$rs=$this->EjecutaQuerySimple();
							while ($tsArray=ibase_fetch_object($rs)) {
								$data[]=$tsArray;
							}
							if(count($data) > 0 ){
								$cantRes = $dif; ////
								$a= 0;
								foreach ($data as $key) {		
									$cantRes = $cantRes - $key->RESTANTE; ////  26-17=9  --> 9-2=7 --->  7-4=3-->  3-6 = -3  
									if($cantRes > 0 ){
										$this->query="UPDATE INGRESOBODEGA SET RESTANTE = RESTANTE - $key->RESTANTE, ASIGNADO= ASIGNADO + $key->RESTANTE where id = $key->ID";
										$this->EjecutaQuerySimple();

										$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, STATUS, VERSUM) 
														VALUES (NULL, $key->ID, $key->RESTANTE, $key->RESTANTE, $key->RESTANTE - $key->RESTANTE, current_timestamp,'$usuario', 4,0)";
										$this->EjecutaQuerySimple();
										$a = $a + $key->RESTANTE;  //// 29
									}elseif($cantRes <= 0){
									 	$b = $dif - $a; ////  17 + 2 + 4+6 = 26-29 = -3 
									 	if($b<0){
									 		break;
									 	}else{
									 	//echo 'valor de b: '.$b. ' valor de $a: '.$a.'<br/>';
									 		$this->query="UPDATE INGRESOBODEGA SET RESTANTE = RESTANTE - $b, ASIGNADO= ASIGNADO + $b where id = $key->ID";
											$this->EjecutaQuerySimple();
											
											$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, STATUS, VERSUM) 
														VALUES (NULL, $key->ID, $key->RESTANTE, $b, $key->RESTANTE - $b, current_timestamp,'$usuario', 4,0)";
											$this->EjecutaQuerySimple();
										//echo 'valor de $cantRes: '.$cantRes.'  si es 0 o menos deberia de salir no hacer la insercion.<br/>';
									 break;	
									 	} 
									}else{
										$this->query="UPDATE INGRESOBODEGA SET RESTANTE = RESTANTE - $dif, ASIGNADO= Asignado + $dif WHERE ID = $key->ID";
										$this->grabaBD();
										$this->query="INSERT INTO ASIGNACION_BODEGA_PREOC (ID, IDINGRESO, INICIAL, ASIGNADO, FINAL, FECHA_MOV, USUARIO_MOV, STATUS, VERSUM) 
														VALUES (NULL, $key->ID, $key->RESTANTE, $dif, $key->RESTANTE - $dif, current_timestamp,'$usuario', 4,0)";
										$this->grabaBD();
									}
								}
							}else{
								echo 'error garrafal'; 
							}
						}
				}else{
					$usuario = $_SESSION['user']->NOMBRE;
					$equipo = gethostname();
					$usuario = $usuario.' ('.$equipo.')';
					$this->query="SELECT * FROM PRODUCTO_FTC WHERE CLAVE = '$producto'";
					$res=$this->EjecutaQuerySimple();
					$row3 = ibase_fetch_object($res);
					$prov = explode(":", $row3->PROVEEDOR);
					$proveedor = $prov[0];

					$this->query="INSERT INTO INGRESOBODEGA (id, descripcion, cant, fecha, marca, proveedor, costo, unidad, producto, restante, asignado, usuario, recibido, origen ) 
						VALUES (null, '$row3->NOMBRE', $cantf - $canto, current_timestamp, '$row3->MARCA', '$proveedor', $row3->COSTO_T,'$row3->UM', '$producto', $cantf - $canto, 0, substring('$usuario' from 1 for 80), 0, 'Inventario Fisico')";
					$this->grabaBD();
				}
			}

			$this->query="INSERT INTO CIERRE_MENSUAL (ID, inicial, MES, ANIO, FECHA_CIERRE, USUARIO_CIERRE, tipo) 
				VALUES (NULL, iif(
								(select max(inicial) from CIERRE_MENSUAL where tipo = 'BF') is null,
								 1, 
								 (select max(inicial) from CIERRE_MENSUAL where tipo = 'BF')) + 1,
								  extract(MONTH FROM CURRENT_DATE),
								   extract(YEAR FROM CURRENT_DATE), CURRENT_TIMESTAMP, 
								   '$usuario', 
								   'BF')";
			$this->grabaBD();
		
			return;
	}

	function invPatio(){
		$this->query="SELECT  p.*, (select count(id) from FTC_CTRL_INV_PATIO WHERE PREOC = p.id) as procesado FROM PREOC01 p
						WHERE recepcion > 0 and ID >= 100000 
						AND fechasol > '01.10.2017' 
						and recepcion - empacado <> 0  
						order by cotiza asc, fechasol asc";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}


	function cierreInvPatio($datos){
		$datos= split(',', $datos);
			var_dump($datos);
			$usuario = $_SESSION['user']->NOMBRE;
			
			$this->query="INSERT INTO CIERRE_MENSUAL (ID, inicial, MES, ANIO, FECHA_CIERRE, USUARIO_CIERRE, tipo) 
				VALUES (NULL, iif(
								(select max(inicial) from CIERRE_MENSUAL where tipo = 'PF') is null,
								 1, 
								 (select max(inicial) from CIERRE_MENSUAL where tipo = 'PF')) + 1,
								  extract(MONTH FROM CURRENT_DATE),
								   extract(YEAR FROM CURRENT_DATE), CURRENT_TIMESTAMP, 
								   '$usuario', 
								   'PF')";
				$this->grabaBD();

				$this->query="SELECT MAX(INICIAL) AS INVENTARIO FROM CIERRE_MENSUAL WHERE TIPO = 'PF'";
				$rs=$this->EjecutaQuerySimple();
				$row=ibase_fetch_object($rs);
				$folio=$row->INVENTARIO;

			foreach ($datos as $key) {
				$dato = split(':',$key);
				$canto = $dato[0];
				$cantf = $dato[1];
				$idpreoc = $dato[2];
				$tipo = $dato[7];
				$producto = $dato[4];
				$costo = $dato[5];
				$cotiza = $dato[6];
				//echo '<br/>'.$canto.' cantidad final: '.$cantf.' producto '.$producto.' tipo '.$tipo.' costo: '.$costo.' cotiza: '.$cotiza.'idpreco: '.$idpreoc.'<br/>';
				if($tipo == 'v'){
					$dif = $canto - $cantf;
					//echo 'esta es la diferencia: '.$dif.'<br/>';
					$this->query="INSERT INTO FTC_VALES (id, tipo, usuario, fecha, idpreoc, cant_orig, cant_fis, costo, cotizacion, status, folio) 
									VALUES (NULL, 'patio', '$usuario', current_timestamp, $idpreoc, $canto,$cantf, $costo, '$cotiza', 'Nuevo', $folio )";
					$this->EjecutaQuerySimple();

					/// liberamos la caja para ser solicitada nuevamente:
					$this->query="UPDATE PREOC01 SET ORDENADO = ORDENADO - $dif, REST = REST + $dif, RECEPCION = RECEPCION - $dif, CANTI = $dif, STATUS = 'N', REC_FALTANTE= REC_FALTANTE + $dif WHERE ID = $idpreoc ";
					$this->EjecutaQuerySimple();					
					//echo $this->query;

				}else{
					//$this->query="INSERT INTO INGRESOBODEGA () VALUES ()";
					//$this->grabaBD();
				}
			}
		
			//break;
		return;
	}

	function verValesPatio(){
		$this->query="SELECT * FROM FTC_VALES v left join preoc01 p on p.id = v.idpreoc WHERE v.STATUS = 'Nuevo'";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return @$data;
	}

	function totalValesPatio(){
		$this->query="SELECT COUNT(ID) as vales, SUM(COSTO) as monto FROM FTC_VALES WHERE STATUS = 'Nuevo'";
		$r = $this->EjecutaQuerySimple();
		$row=ibase_fetch_object($r);
		return $row;
	}

	function totalCajas(){
		$this->query="SELECT count(cotiza) FROM PREOC01 WHERE recepcion > 0 and ID >= 100000 AND fechasol > '01.10.2017' and recepcion - empacado <> 0  group by cotiza";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function traeProveedoresOCI(){
		$this->query="SELECT * FROM PROV01";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function traeProductosOCI(){
		$this->query="SELECT * FROM PRODUCTO_FTC";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return $data;
	}

	function temporal(){
		$this->query="SELECT MAX(TEMP) + 1 AS TEMP FROM FTC_OCI";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		return $row;
	}

	function addOCI($prod, $cant, $prov, $temp ){
		$prod = explode(":", $prod);
		$cveprod = $prod[0];
		$costo = $prod[2];
		$usuario =$_SESSION['user']->NOMBRE;
		$equipo = gethostname();
		//echo 'Clave producto: '.$cveprod;
		//echo 'Cantidad Producto: '.$cant;
		$this->query="INSERT INTO FTC_OCI (id, producto, cantidad, proveedor, fecha_oci, usuario_oci, equipo_oci, status, temp, COSTO, COSTO_PARTIDA) 
								VALUES (null,'$cveprod', $cant, '$prov', current_timestamp, '$usuario', '$equipo', 0, $temp, $costo, $cant * $costo )";
		$this->grabaBD();
		//echo $this->query;
		$this->query="SELECT MAX(ID) AS LINEA FROM FTC_OCI";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$total = $cant * $costo;

		$this->query="SELECT COUNT(ID) AS PROD FROM FTC_OCI WHERE TEMP = $temp";
		$rs=$this->EjecutaQuerySimple();
		$row2=ibase_fetch_object($rs);


		return array("status"=>'ok', "producto"=>$prod, "total"=>number_format($total,2),"linea"=>$row->LINEA,"val"=>$row2->PROD);
	}

	function delOCI($linea, $temp){
		$this->query="UPDATE FTC_OCI SET temp = 0 where id = $linea";
		$this->grabaBD();

		$this->query="SELECT COUNT(ID) AS PROD FROM FTC_OCI WHERE TEMP = $temp";
		$rs=$this->EjecutaQuerySimple();
		$row2=ibase_fetch_object($rs);

		//echo $row2->PROD;
		return array("status"=>'ok', "val"=>$row2->PROD);
	}

	

	function ejecutaOCI($idoci){
		$this->query="UPDATE FTC_OCI SET STATUS = '$tipo' where id = $idoci";
		$this->grabaBD();

		if($tipo == 'A'){
			$this->query="INSERT INTO FTC_POC SET () VALUES ()";
			$this->grabaBD();

		}elseif($tipo == 'C'){
			echo 'SE HA CANCELADO LA ORDEN DE COMPRA INTERNA';
		}

		return; 
	}

	function provOI($clave){
		$this->query="SELECT * FROM PROV01 WHERE trim(CLAVE) =trim('$clave')";
		$rs=$this->EjecutaQuerySimple();
		$row = ibase_fetch_object($rs);
		$nombre = $row->NOMBRE;
		return array("nombre"=>$row->NOMBRE, "calle"=>$row->CALLE,"numInt"=>$row->NUMINT,"numExt"=>$row->NUMEXT, "colonia"=>$row->COLONIA, "cp"=>$row->CODIGO, "ciudad"=>$row->ESTADO, "tel"=>$row->TELEFONO);
	}

	function cerrarOCI($temp){
		$this->query="SELECT iif(MAX(OCI) is null, 1, max(OCI)+1) as folio FROM FTC_OCI";
		$rs=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($rs);
		$folio = $row->FOLIO;
		$this->query = "UPDATE FTC_OCI SET OCI = $folio where temp = $temp and OCI is null";
		$this->grabaBD();

		$this->query="SELECT * FROM FTC_OCI WHERE TEMP = $temp and oci = $folio and partida is null ";
		$rs=$this->EjecutaQuerySimple();

		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		$par = 0;
		if(isset($data)){
			foreach ($data as $key) {
			$par = $par + 1;
			$this->query="UPDATE FTC_OCI SET PARTIDA = $par where temp = $temp and oci = $folio and id = $key->ID";
			$this->grabaBD();
		}	
		}
		
		return;
	}


	function OCI($idoci){
		$this->query="SELECT oci.*, p.*, (select nombre from producto_ftc where clave = oci.producto) as descripcion from FTC_OCI oci left join prov01 p on p.clave = oci.proveedor WHERE oci = $idoci";
		$rs=$this->EjecutaQuerySimple();
		//echo $this->query;
			while ($tsArray=ibase_fetch_object($rs)) {
				$data[]=$tsArray;
			}
		return $data;
	}

	function verOCI(){
		//$data=false;
		$this->query="SELECT OCI, MAX(NOMBRE) AS NOMBRE, MAX(PROVEEDOR) AS PROVEEDOR, MAX(FECHA_OCI) AS FECHA_OCI, SUM(COSTO_PARTIDA) AS COSTO, MAX(USUARIO_OCI) USUARIO_OCI, count(id) as PARTIDAS
					 FROM FTC_OCI OCI 
					 	LEFT JOIN PROV01 P ON P.CLAVE = OCI.PROVEEDOR
					 	WHERE OCI IS NOT NULL AND oci.STATUS =0 
					 	GROUP BY OCI";
		$rs=$this->EjecutaQuerySimple();
		while ($tsArray=ibase_fetch_object($rs)) {
			$data[]=$tsArray;
		}
		return @$data;
	}

	function execOCI($idoci, $tipo){
		$usuario = $_SESSION['user']->NOMBRE;
		$equipo = gethostname();

		$this->query="SELECT MIN(STATUS) as status FROM FTC_OCI WHERE OCI= $idoci";
		$r=$this->EjecutaQuerySimple();
		$row=ibase_fetch_object($r);

		if($row->STATUS == 0){
			if($tipo == 'r'){
			$this->query="UPDATE FTC_OCI SET STATUS = 3, usuario_exec='$usuario', equipo_exec='$equipo', fecha_exec= current_timestamp WHERE OCI= $idoci";
			$this->grabaBD();
			return array("status"=>'ok',"tipo"=>'Rechazo');
			}else{
			//echo 'Algoritmo para dar de alta en FTC_POC';

					$this->query="SELECT OCI, MAX(NOMBRE) AS NOMBRE, MAX(PROVEEDOR) AS PROVEEDOR, MAX(FECHA_OCI) AS FECHA_OCI, SUM(COSTO_PARTIDA) AS COSTO, MAX(USUARIO_OCI) USUARIO_OCI, count(id) as PARTIDAS
					 FROM FTC_OCI OCI 
					 	LEFT JOIN PROV01 P ON P.CLAVE = OCI.PROVEEDOR
					 	WHERE OCI IS NOT NULL AND oci.STATUS =0 
					 	GROUP BY OCI ";
					$rs=$this->EjecutaQuerySimple();
					$row=ibase_fetch_object($rs);

					$this->query="SELECT ULT_CVE FROM TBLCONTROL01 WHERE ID_TABLA = 81";
					$rs=$this->EjecutaQuerySimple();
					$row2=ibase_fetch_object($rs);
					$folioOC = $row2->ULT_CVE + 1; 

					$this->query = "UPDATE TBLCONTROL01 SET ULT_CVE  = $folioOC where id_TABLA = 81";
					$this->grabaBD();



				$this->query="INSERT INTO FTC_POC (ID, CVE_DOC, CVE_PROV, FECHA_DOC, TP_TES, USUARIO, COSTO, DESCUENTO, PRECIO, IVA, STATUS, TOTAL_IVA, COSTO_TOTAL, URGENCIA, FECHA_ELAB, OC, FECHA_OC, USUARIO_OC, TP_TES_REQ, FECHA_ENTREGA, CONFIRMADO) 
				VALUES (NULL, ('OCI-'||$idoci), '$row->PROVEEDOR', '$row->FECHA_OCI', NULL, '$usuario', $row->COSTO, 0, 0, 0, 'ORDEN', 0, $row->COSTO * 1.16, 0, current_timestamp, ('OPI'||$folioOC), current_timestamp, '$usuario', 'Cr', current_date, 'Directo Bodega')";
				$this->grabaBD();

				$this->query="SELECT * FROM FTC_OCI WHERE OCI = $idoci";
				$res=$this->EjecutaQuerySimple();
				while ($tsArray=ibase_fetch_object($res)){
					$data[]=$tsArray;
				}

				foreach ($data as $key) {
					$partida = $key->PARTIDA;

					$this->query="INSERT INTO FTC_POC_DETALLE (id, CVE_DOC, PARTIDA, ART, CANTIDAD, COSTO, DESCUENTO, PRECIO, COTIZACION, USUARIO, FECHA_ELAB, FECHA_DOC, SERIE, FOLIO, UM, FACCONV, CVE_PROD, COSTO_TOTAL, PRECIO_TOTAL, IDPREOC, STATUS, TOT_IVA, PXR, OC ) 
					VALUES (NULL, ('OCI-'||$idoci), $partida, trim('$key->PRODUCTO'), $key->CANTIDAD, $key->COSTO, 0, 0, 'Directa', '$usuario', current_timestamp, CURRENT_TIMESTAMP, 'OCI', $folioOC, (SELECT UM FROM PRODUCTO_FTC WHERE trim(CLAVE) = trim('$key->PRODUCTO')), (SELECT FAC_CONV FROM INVE01 WHERE trim(CVE_ART) = trim('$key->PRODUCTO')), (SELECT CVE_PROD FROM PRODUCTO_FTC WHERE trim(CLAVE) = trim('$key->PRODUCTO')), $key->COSTO_PARTIDA, 0,0,0,0,$key->CANTIDAD, ('OPI'||$folioOC))";
					$this->grabaBD();
				}
				$this->query="UPDATE FTC_OCI SET STATUS = 2 WHERE OCI = $idoci";
				$this->EjecutaQuerySimple();

			return array("status"=>'ok',"tipo"=>'CreacionOC');
			}	
		}else{
			return array("status"=>'Ya Procesada',"tipo"=>'Procesada');
		}	
	}

	function ctrlInvPatio($idpreoc, $canto, $cantr, $prod){

		$this->query="SELECT count(id) as contador  from FTC_CTRL_INV_PATIO WHERE preoc = $idpreoc";
		$res=$this->EjecutaQuerySimple();
		echo $this->query;
		$row=ibase_fetch_object($res);

		if($row->CONTADOR == 0){
			$this->query="INSERT INTO FTC_CTRL_INV_PATIO (ID, PREOC, PRODUCTO, CANTO, CANTR, STATUS, FECHA_IF, FECHA_MOV) 
							VALUES (NULL, $idpreoc,'$prod', $canto, $cantr, 0, current_date, current_timestamp)";
			$this->grabaBD();
		}else{
			$this->query="UPDATE FTC_CTRL_INV_PATIO SET preoc = $idpreoc, producto = '$prod', canto = $canto, cantr= $cantr, current_date, current_timestamp where status = 0";
			$this->grabaBD();
		}
		return array("status"=>'ok');
	}

}
?>