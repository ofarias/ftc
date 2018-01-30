<?php
//session_start();
//session_cache_limiter('private_no_expire');
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');

class pegaso_controller_cobranza{

	var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";

	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
	
	/*Header para login*/
	function load_templateL($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}

	 private function load_page($page){
		return file_get_contents($page);
	}
   
   /* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO
		INPUT
		$html | codigo html
		OUTPUT
		HTML | codigo html		
	*/
   private function view_page($html){
		echo $html;
	}
   
   /* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO
		INPUT
		$out | es el codigo html con el que sera reemplazada la etiqueta CONTENIDO
		$pagina | es el codigo html de la pagina que contiene la etiqueta CONTENIDO
		OUTPUT
		HTML 	| cuando realiza el reemplazo devuelve el codigo completo de la pagina
	*/
   private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
		 return preg_replace($in, $out, $pagina);	 	
	}

	function verCxCRutas(){
		session_cache_limiter('private_no_expire');
		if($_SESSION['user']){
			$data = new pegaso;
	        $pagina=$this->load_template('Pedidos');
	        $html=$this->load_page('app/views/modules/m.msubCxCRutas.php');
	        ob_start();
	        $exec=$data->traeCarterasCobranza(); 
	        if (count($exec)){
	            include 'app/views/modules/m.msubCxCRutas.php';
	            $table = ob_get_clean();
	            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
	        }else{
	            $pagina = $this->replace_content('/\CONTENIDO\#/ms',$html.'<div class="alert-info"><center><h2>No hay datos para mostrar</h2><center></div>', $pagina);
	        }
	    $this->view_page($pagina);
	    }else{
	        $e = "Favor de iniciar Sesión";
	        header('Location: index.php?action=login&e='.urlencode($e)); exit;
	    }
	}
	


    function verRecibidosCobranza($cc){
    	session_cache_limiter('private_no_expire');
    	if($_SESSION['user']){
    		$data=new pegaso;
    		$pagina =$this->load_template('pedidos');
    		$html = $this->load_page('app/views/pages/cobranza/p.verRecibidosCobranza.php');
    		ob_start();
    		$recibidos=$data->verRecibidosCobranza($cc);
    		$habilitaImpresion= count($recibidos);
    		if(count($recibidos)>0){
    			include 'app/views/pages/cobranza/p.verRecibidosCobranza.php';
    			$table=ob_get_clean();
    			$pagina=$this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
    			$this->view_page($pagina);
    		}else{
				$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>NO SE ENCONTRARON DOCUMENTOS RECIBIDOS.</h2><center></div>', $pagina);
    		}
    	}else{
    		$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
    	}
    }

    function guardaSecuencia($idc, $secuencia ,$cc){
    	session_cache_limiter('private_no_expire');
    	if($_SESSION['user']){
    		$data= new pegaso;
    		ob_start();
    		$guarda = $data->guardaSecuencia($idc, $secuencia);
    		$this->verRecibidosCobranza($cc);
    	}else{
    		$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
    	}
    }

	function impRutaCobranza($cc){
		$data = new Pegaso;	
        $folio=$data->creaFolioRutaCobranza($cc);
        $cabecera=$data->datosRutaC($folio, $cc);
        $partidas=$data->datosRutaP($folio, $cc);
        /*$ctrlImp=$data->ctrlImpresiones($idsol);
        if((int)$ctrlImp == 1){
        	$controlImpresion = '#############  Original  #############';
        }else{
        	$controlImpresion = 'Reimpresion No: '.$ctrlImp.'.';
        }*/
        $pdf = new FPDF('P','mm','Letter');
        $pdf->AddPage();
        $pdf->Image('app/views/images/headerVacio.jpg',10,15,205,55);
        $pdf->SetFont('Courier', 'B', 25);
        $pdf->SetTextColor(255,0,0);
        $pdf->SetXY(110, 28);
  		$pdf->Write(10,'Ruta Cobranza');
  		$pdf->SetXY(110, 38);
  		$pdf->Write(10,utf8_decode('Cartera '.$cc));
  		$pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(65);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetXY(60, 60);
  		//$pdf->Write(6, $controlImpresion);
  		$pdf->Ln(10);
  		//$data->IDSOL.utf8_decode(' Folio Pago Crédito CR-').strtoupper($data->TP_TES_FINAL).'-'.$data->FOLIO);
        foreach ($cabecera as $data){
        $pdf->SetFont('Arial', 'B', 9);
  		$pdf->Write(6,'Folio De Ruta :'.$folio);
  		$pdf->Ln();
  		$pdf->Write(6,'Fecha de Elaboracion: '.$data->FECHA_INICIO);
  		$pdf->Ln();
  		$pdf->Write(6,'Valor Estimado: $ '.number_format($data->VALOR_ESTIMADO,2));
  		$pdf->Ln();
  		$pdf->Write(6,'Usuario que Genera: '.$data->USUARIO);
  		$pdf->Ln();
  		$pdf->Write(6,'Esta ruta se cerrara el proximo: '.$data->FECHA_FIN);
  		$pdf->Ln();
  		$pdf->Write(6,'Contiene :'.$data->DOCUMENTOS.' facturas para cobro');
  		$pdf->Ln();
  		$pdf->Ln();
        }
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20,6,"FACTURA",1);
        $pdf->Cell(65,6,"CLIENTE",1);
        $pdf->Cell(20,6,"IMPORTE",1);
        $pdf->Cell(30,6,"FECHA",1);
        $pdf->Cell(15,6,"PROGA?",1);
        $pdf->Cell(15,6," SEC ",1);
        $pdf->Cell(25,6,utf8_decode('RECIBIÓ'),1);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 7);
            $total_oc = 0;
            $total_subtotal = 0;
            $total_iva = 0;
            $total_final = 0;
        foreach($partidas as $row){
            $pdf->Cell(20,6,TRIM($row->DOCUMENTO),'L,T,R');
            $pdf->Cell(65,6,substr($row->NOMBRE,0,37),'L,T,R');
            $pdf->Cell(20,6,'$ '.number_format($row->IMPORTE,2),'L,T,R');
            $pdf->Cell(30,6,$row->FECHAELAB,'L,T,R');
            $pdf->Cell(15,6,$row->PRORROGA,'L,T,R');
            $pdf->Cell(15,6,$row->SECUENCIA_RUTA,'L,T,R');
  			$pdf->Cell(25,6,'', 'L,T,R');
            $pdf->Ln();				// Segunda linea descripcion
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(65,6,substr($row->NOMBRE,38,60),'L,B,R');
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(30,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Cell(25,6,"",'L,B,R');
            $pdf->Ln();
        }
        $pdf->Output('Ruta Cobranza'.$folio.'.pdf','D');	
	} 

	function verRutasVigentes(){
		session_cache_limiter('private_no_expire');
		if(isset($_SESSION['user'])){
			$data= new pegaso;
			$pagina =$this->load_template('pedidos');
    		$html = $this->load_page('app/views/pages/cobranza/p.verRutasVigentes.php');
    		ob_start();
    		$rutas=$data->verRutasVigentes();
    		if(count($rutas)>0){
    			include 'app/views/pages/cobranza/p.verRutasVigentes.php';
    			$table=ob_get_clean();
    			$pagina=$this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
    			$this->view_page($pagina);
    		}else{
				$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>NO SE ENCONTRARON DOCUMENTOS RECIBIDOS.</h2><center></div>', $pagina);
    		}
    	}else{
    		$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e));
            exit;
    	}
    }



	function verPartidasRuta($idf, $cierre){
    	session_cache_limiter('private_no_expire');
    	if(isset($_SESSION['user'])){
    		$data= new pegaso;
    		$pagina =$this->load_template('pedidos');
    		$html = $this->load_page('app/views/pages/cobranza/p.verDocumentosRuta.php');
    		ob_start();
    		$foliosRuta=$data->verPartidasRuta($idf);
    		$foliosPagados=$data->verPartidasPagadas($idf);
    		if(count($foliosRuta)>0){
    			include 'app/views/pages/cobranza/p.verDocumentosRuta.php';
    			$table=ob_get_clean();
    			$pagina=$this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
    			$this->view_page($pagina);
    		}else{
				$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>NO SE ENCONTRARON DOCUMENTOS RECIBIDOS.</h2><center></div>', $pagina);
    		}
    	}else{
    		$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e));
            exit;
    	}		
    }

    function verRutasFinalizadas(){
    	session_cache_limiter('private_no_expire');
    	if(isset($_SESSION['user'])){
			$data= new pegaso;
			$pagina =$this->load_template('pedidos');
    		$html = $this->load_page('app/views/pages/cobranza/p.verRutasVencidas.php');
    		ob_start();
    		$rutas=$data->verRutasFinalizadas();
    		if(count($rutas)>0){
    			include 'app/views/pages/cobranza/p.verRutasVencidas.php';
    			$table=ob_get_clean();
    			$pagina=$this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
    			$this->view_page($pagina);
    		}else{
				$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>NO SE ENCONTRARON DOCUMENTOS RECIBIDOS.</h2><center></div>', $pagina);
    		}
    	}else{
    		$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e));
            exit;
    	}
    }


    function cierreCC($idr){
    	$data = new Pegaso;	
    	$folio=$idr;
  
        $cerrar=$data->cerrarRuta($idr);
        $cabecera=$data->datosRutaC($folio);
        $partidas=$data->datosRutaP($folio);

        foreach ($cabecera as $key) {
        	$cc = $key->CARTERA;
        }

        $pdf = new FPDF('P','mm','Letter');
        $pdf->AddPage();
        $pdf->Image('app/views/images/headerVacio.jpg',10,15,205,55);
        $pdf->SetFont('Courier', 'B', 25);
        $pdf->SetTextColor(255,0,0);
        $pdf->SetXY(110, 28);
  		$pdf->Write(10,'Ruta Cobranza');
  		$pdf->SetXY(110, 38);
  		$pdf->Write(10,utf8_decode('Cartera '.$cc));
  		$pdf->Ln(10);
        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(65);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetXY(60, 60);
  		//$pdf->Write(6, $controlImpresion);
  		$pdf->Ln(10);
  		//$data->IDSOL.utf8_decode(' Folio Pago Crédito CR-').strtoupper($data->TP_TES_FINAL).'-'.$data->FOLIO);

        foreach ($cabecera as $data){
        	$base = $data->VALOR_ESTIMADO;
        	$factor = $data->VALOR_CUMPLIDO;
        	if($factor == 0){
        		$efi = 0;
        	}else{
        		$efi =  $factor / $base;	
        	}
        	
        $pdf->SetFont('Arial', 'B', 9);
  		$pdf->Write(6,'Folio De Ruta :'.$folio);
  		$pdf->Ln();
  		$pdf->Write(6,'Fecha de Elaboracion: '.$data->FECHA_INICIO);
  		$pdf->Ln();
  		$pdf->Write(6,'Monto Estimado : $ '.number_format($data->VALOR_ESTIMADO,2));
  		$pdf->Ln();
  		$pdf->Write(6,'Monto Cobrado : $'.number_format($data->VALOR_CUMPLIDO,2));
  		$pdf->Ln();
  		$pdf->Write(6,'Eficiencia: '.number_format($efi,2).' %');
  		$pdf->Ln();
  		$pdf->Write(6,'Usuario que Genera: '.$data->USUARIO);
  		$pdf->Ln();
  		$pdf->Write(6,'Esta ruta se cerrara el proximo: '.$data->FECHA_FIN);
  		$pdf->Ln();
  		$pdf->Write(6,'Contiene :'.$data->DOCUMENTOS.' facturas para cobro');
  		$pdf->Ln();
  		$pdf->Ln();
        }
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20,6,"FACTURA",1);
        $pdf->Cell(65,6,"CLIENTE",1);
        $pdf->Cell(20,6,"IMPORTE",1);
        $pdf->Cell(30,6,"FECHA",1);
        $pdf->Cell(15,6,"PROGA?",1);
        $pdf->Cell(15,6," SEC ",1);
        $pdf->Cell(25,6,utf8_decode('RECIBIÓ'),1);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 7);

        foreach($partidas as $row){
        	if($row->SALDOFINAL >=6){
            $pdf->Cell(20,6,TRIM($row->DOCUMENTO),'L,T,R');
            $pdf->Cell(65,6,substr($row->NOMBRE,0,37),'L,T,R');
            $pdf->Cell(20,6,'$ '.number_format($row->IMPORTE,2),'L,T,R');
            $pdf->Cell(30,6,$row->FECHAELAB,'L,T,R');
            $pdf->Cell(15,6,$row->PRORROGA,'L,T,R');
            $pdf->Cell(15,6,$row->SECUENCIA_RUTA,'L,T,R');
  			$pdf->Cell(25,6,'', 'L,T,R');
            $pdf->Ln();				// Segunda linea descripcion
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(65,6,substr($row->NOMBRE,38,60),'L,B,R');
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(30,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Cell(25,6,"",'L,B,R');
            $pdf->Ln();
        	}
		}

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Write(6,'DOCUMENTOS COBRADOS');
        $pdf->Ln();
        $pdf->Ln();
         foreach($partidas as $row){
         	if($row->SALDOFINAL <= 5 ){
	            $pdf->Cell(20,6,TRIM($row->DOCUMENTO),'L,T,R');
	            $pdf->Cell(65,6,substr($row->NOMBRE,0,37),'L,T,R');
	            $pdf->Cell(20,6,'$ '.number_format($row->IMPORTE,2),'L,T,R');
	            $pdf->Cell(30,6,$row->FECHAELAB,'L,T,R');
	            $pdf->Cell(15,6,$row->PRORROGA,'L,T,R');
	            $pdf->Cell(15,6,$row->SECUENCIA_RUTA,'L,T,R');
	  			$pdf->Cell(25,6,'', 'L,T,R');
	            $pdf->Ln();				// Segunda linea descripcion
	            $pdf->Cell(20,6,"",'L,B,R');
	            $pdf->Cell(65,6,substr($row->NOMBRE,38,60),'L,B,R');
	            $pdf->Cell(20,6,"",'L,B,R');
	            $pdf->Cell(30,6,"",'L,B,R');
	            $pdf->Cell(15,6,"",'L,B,R');
	            $pdf->Cell(15,6,"",'L,B,R');
	            $pdf->Cell(25,6,"",'L,B,R');
	            $pdf->Ln();
        	}
        }
        $pdf->Output('Cierre de Ruta Cobranza'.$folio.'.pdf','D');	


    }


    function verCargaPagosCXC(){
        session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data=new pegaso;
            $pagina =$this->load_template('pedidos');
            $html = $this->load_page('app/views/pages/cobranza/p.verCargaPagosCXC.php');
            ob_start();
            $pagos=$data->verCargaPagosCXC();
            $pagosCerrados =$data->verCargaPagosCXCCerrados();
            $acreedores=$data->verCargaPagosCXCAcreedores();

            //$habilitaImpresion= count($recibidos);
            if(count($pagos)>0){
                include 'app/views/pages/cobranza/p.verCargaPagosCXC.php';
                $table=ob_get_clean();
                $pagina=$this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
                $this->view_page($pagina);
            }else{
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>NO SE ENCONTRARON DOCUMENTOS RECIBIDOS.</h2><center></div>', $pagina);
            }
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }

    function cerrarPago($idp){
        session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data=new pegaso;
            $pagina =$this->load_template('pedidos');
            $html = $this->load_page('app/views/pages/cobranza/p.verCargaPagosCXC.php');
            ob_start();
            $cerrar=$data->cerrarPago($idp);
            //$habilitaImpresion= count($recibidos);
            $this->verCargaPagosCXC();
            
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }

    function solAcreedor($idp, $saldo){
        session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data=new pegaso;
            $pagina =$this->load_template('pedidos');
            $html = $this->load_page('app/views/pages/cobranza/p.verCargaPagosCXC.php');
            ob_start();
            $cerrar=$data->solAcreedor($idp, $saldo );
            //$habilitaImpresion= count($recibidos);
            $this->verCargaPagosCXC();
            
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }

    }

  function solRestriccion($cveclie){
        session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data=new pegaso;
            $pagina =$this->load_template('pedidos');
            $html = $this->load_page('app/views/pages/cobranza/p.verCargaPagosCXC.php');
            ob_start();
            $solicitudes=$data->solRestriccion($cveclie);
             //&maestro={$maestro}
             $redireccionar = "SaldosxDocumento&cliente={$cveclie}";
             $pagina=$this->load_template('Pedidos');
             $html = $this->load_page('app/views/pages/p.redirectform.php');
             include 'app/views/pages/p.redirectform.php';
             $this->view_page($pagina);       

            
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }

    }

      function solCorte($cveclie, $idsolc){
        session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data=new pegaso;
            $pagina =$this->load_template('pedidos');
            $html = $this->load_page('app/views/pages/cobranza/p.verCargaPagosCXC.php');
            ob_start();
            $solicitudes=$data->solCorte($cveclie, $idsolc); 
            //&maestro={$maestro}
             $redireccionar = "SaldosxDocumento&cliente={$cveclie}";
             $pagina=$this->load_template('Pedidos');
             $html = $this->load_page('app/views/pages/p.redirectform.php');
             include 'app/views/pages/p.redirectform.php';
             $this->view_page($pagina);       
            
            
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }

    }



}
?>