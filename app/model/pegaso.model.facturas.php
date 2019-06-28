<?php
//session_start();
//session_cache_limiter('private_no_expire');
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');

class pegaso_controller_facturacion{

	function verificaDatos($pedido) {//// Obtenemos los datos de la factura y los veridficamos.

		$cliente = array("clave"=>$clave, "nombre"=>$nombre, "direccion"=>$direccion, "rfc"=>$rfc, "cp"=>$cp, "edo"=>$edo, "municipio"=>$municipio, "telefono"=>$telefono, "ubicacionMaps"=>$ubicacionMaps, "usoCFDISat"=>$usoCFDISat,"formaPagoSat"=>$formaPagoSat, "metodoPagoSat"=>$metodoPagoSat);
		$pegaso = array("clave"=>$clave, "nombre"=>$nombre, "direccion"=>$direccion, "rfc"=>$rfc, "cp"=>$cp, "edo"=>$edo, "municipio"=>$municipio, "telefono"=>$telefono, "ubicacionMaps"=>$ubicacionMaps, "usoCFDISat"=>$usoCFDISat,"formaPagoSat"=>$formaPagoSat, "metodoPagoSat"=>$metodoPagoSat);

		foreach ($par as $key){
			$impuestos=array("Base"=>$base, "Impuesto"=>$impuesto,"TipoFactor"=>$tipoFactor, "TasaOCuota"=>$tasaOCuota, "Importe"=>$importe);
			$partida=array(
				"noIdentificacion"=>$clave, 
				"ClaveProdServ"=>$claveSat, 
				"unidad"=>$um, 
				"ClaveUnidad"=>$umSat, 
				"partida"=>$partida, 
				"Cantidad"=>$cantidad , 
				"descripcion"=>$descripcion,
				"ValorUnitario"=>$precio, 
				"descuento"=>$descuento,
				"iva"=>$iva,
				"tasa"=>$tasa,
				"Importe"=>$importe,
				"Impuestos"=>$impuestos);
		}
	
		/*
			{
				  "conceptos": [
				    {
				      "ClaveProdServ": "15101505",
				      "ClaveUnidad": "LTR",
				      "noIdentificacion": "16",
				      "unidad": "LTS",
				      "Cantidad": "2",
				      "descripcion": "  DIESEL",
				      "ValorUnitario": "14.44",
				      "Importe": "28.88",
				      "Impuestos": {
				        "Traslados": [
				          {
				            "Base": "28.88",
				            "Impuesto": "002",
				            "TipoFactor": "Tasa",
				            "TasaOCuota": "0.160000",
				            "Importe": "4.62"
				          },
				          {
				            "Base": "2",
				            "Impuesto": "003",
				            "TipoFactor": "Cuota",
				            "TasaOCuota": "0.315400",
				            "Importe": "0.63"
				          }
				        ]
				      }
				    },
		*/


		$partida[] = json_encode($partida);

		$this->crearFactura($partidas, $clientes);

	}

	function crearFactura($partidas, $cliente){ ////  Si la factura esta ok, armamos la factura y la eniamos a Timbrar.

	}

	function enviarFactura($factura){ /// Leemos la fatura timbrada y enviamos los correos al cliente  y la publicamos en el portal WEB,

	}

	function crearNotaDeCrdito($factura){ 

	}

	function cancelarFactura($factura){

	}

}

?>