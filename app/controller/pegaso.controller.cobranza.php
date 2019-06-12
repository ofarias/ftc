<?php
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.cxc.php');
require_once('app/model/facturacion.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require_once 'app/Classes/PHPExcel.php';

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

    function load_template_popup($title='Ferretera Pegaso'){
        $pagina = $this->load_page('app/views/master.php');
        $header = $this->load_page('app/views/sections/s.header2.php');
        $pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
        $pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);        
        return $pagina;
    }


	private function load_page($page){
		return file_get_contents($page);
	}
    private function view_page($html){
		echo $html;
	}
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
	        header('Location: index.php?action=login&e='.urlencode($e)); 
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
            
        }

    }

      function solCorte($cveclie, $idsolc){
        if($_SESSION['user']){
            $data=new pegasoCobranza;
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
        }
    }

   function cobranza(){     //14062016
        if(isset($_SESSION['user'])){
            $data=new pegasoCobranza;
            $usuario = $_SESSION['user']->NOMBRE;
            ob_start();
            $table = ob_get_clean();
            $pagina = $this->load_template('Menu Admin');
            $info = array();
            $info=$data->cobranza();
            $abonos =$data->pendientesAplicar();
            $pendientes=$data->pendientesIdentificar();
            if(count($info)>0){  
                include 'app/views/modules/m.cobranza.php';
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            }else{
                include 'app/views/modules/m.mbloqueocobranza.php';
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina); 
            }
            $this-> view_page($pagina);
        }else{
            $e = "Favor de Revisar sus datos";
            header('Location: index.php?action=login&e='.urlencode($e)); 
        }  
    }

    function verDocumentosMaestro($maestro){
        if(isset($_SESSION['user'])){
            $data= new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.verDocumentosMaestro.php');
            ob_start();
                $idm = '';
                $cvem = $maestro;
                $infoMaestro = $data->traeMaestro($idm, $cvem);
                $docs=$data->verDocumentosMaestro($maestro);
                if (count($infoMaestro)){
                    include 'app/views/pages/cobranza/p.verDocumentosMaestro.php';
                    $table = ob_get_clean();
                        $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                }else{
                    $pagina = $this->replace_content('/\CONTENIDO\#/ms',$html.'<div class="alert-danger"><center><h2>Hubo un error al mostrar los datos</h2><center></div>', $pagina);
                }
                $this->view_page($pagina);
        }else{
            $e = "Favor de iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); 
        }           
    }

    function CarteraxCliente($cve_maestro, $tipo, $maestro){
        if (isset($_SESSION['user'])){
        $data = new pegasoCobranza;
        $pagina=$this->load_template_popup('Pedidos');
        $html=$this->load_page('app/views/pages/cobranza/p.saldosxcliente.php');
        ob_start();
        //$saldoIndividual=$data->saldoIndividual($cve_maestro);
        //$saldoIMaestro=$data->saldoIndMaestro($cve_maestro);
        $saldoIndividual=array("status"=>"a");
        $facturas =$data->facturasMaestro($cve_maestro, $tipo);
        include 'app/views/pages/cobranza/p.saldosxcliente.php';
        $table = ob_get_clean();    
            if (count($saldoIndividual)>0){
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            }else{
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table.'<div class="alert-info"><center><h2>No hay datos para mostrar</h2><center></div>', $pagina);
            }
        $this->view_page($pagina);
        }else{
            $e = "Favor de iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); 
        } 
    }

    function SaldosxDocumento($cliente){    //19072016
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])){
        $data = new pegasoCobranza;
        $pagina=$this->load_template('Pedidos');
        $html=$this->load_page('app/views/pages/cobranza/p.saldosxdocumento.php');
        ob_start();
        $historico = 'No';
        $statusClie=$data->traeStatusClie($cliente); 
        //$solR = $data->traeSolicitudesR($cliente);
        $solC = $data->traeSolicitudesC($cliente);
        $datacli = $data->traeDatacliente($cliente);    // trae los datos del cliente
        $saldo = $data->SaldosDelCliente($cliente);
        $exec = $data->traeSaldosDoc($cliente, $historico);
        //$csaldo=$data->saldoCliente($cliente);
        //$saldovencido=$data->saldoVencidoCliente($cliente);
        if (count($datacli)){
            include 'app/views/pages/cobranza/p.saldosxdocumento.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
        }else{
            $pagina = $this->replace_content('/\CONTENIDO\#/ms',$html.'<div class="alert-info"><center><h2>No hay datos para mostrar</h2><center></div>', $pagina);
                }
            $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); 
            }
    }

    function detalleComprometido($cliente){
        if(isset($_SESSION['user'])){
            $data = new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.detalleComprometido.php');
            ob_start();
            $facturado = array();
            $liberado = $data->detalleComprometidoCot($cliente);
            //$facturado = $data->detalleCobranza($cliente);
            include 'app/views/pages/cobranza/p.detalleComprometido.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); 
            }       
    }
    
    function detalleCobranzaCliente($cliente){
            if(isset($_SESSION['user'])){
            $data = new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.detalleCobranza2.php');
            ob_start();
            //$liberado = $data->detalleComprometidoCot($cliente);
            $facturado = $data->detalleCobranzaCliente($cliente);
            include 'app/views/pages/cobranza/p.detalleCobranza2.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); 
            }   
    }

    function detalleCobranza($maestro, $tipo){
        if(isset($_SESSION['user'])){
            $data = new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.detalleCobranza.php');
            ob_start();
            $usuario=$_SESSION['user']->NOMBRE;
            $tipoUsuario = $_SESSION['user']->LETRA;
            //$liberado = $data->detalleComprometidoCot($cliente);
            $datos = $data->detalleCobranza($maestro, $tipo);
            $abonos =$data->pendientesAplicar();
            include 'app/views/pages/cobranza/p.detalleCobranza.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); 
        }   
    } 

    function marcaDoc($doc, $tipo){
        if(isset($_SESSION['user'])){
            $data = new pegasoCobranza;
            $response=$data->marcaDoc($doc, $tipo);
            return $response;
        }
    }

     function pagarFacturas($items, $total, $pagos, $mes, $anio, $retorno, $maestro){
        if(isset($_SESSION['user'])){
            $data= new pegaso;
            $data2= new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.pagarFacturasCobranza.php');
            ob_start();
                $bancos = $data2->bancos();
                $acreedor =$data2->acreedorMaestro($maestro);
                if($pagos != '0'){
                    $pagos = $data->verPagos3($pagos, $mes, $anio);
                }
                $documentos=$data2->infoDocumentos($items);
                if (count($documentos) > 0 ){
                    include 'app/views/pages/cobranza/p.pagarFacturasCobranza.php';
                    $table = ob_get_clean();
                        $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                }else{
                    $pagina = $this->replace_content('/\CONTENIDO\#/ms',$html.'<div class="alert-danger"><center><h2>Hubo un error al mostrar los datos</h2><center></div>', $pagina);
                }
                $this->view_page($pagina);
        }else{
            $e = "Favor de iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e));
        }       
    }

    function guardaComprobante($target_file, $items, $idp ){
        if(isset($_SESSION['user'])){
            $data=new pegasoCobranza;
            $response = $data->guardaComprobante($target_file, $items, $idp);
            return;
        }
    }

    function verComprobantesPago($docf){
        if (isset($_SESSION['user'])) {
            $data= new pegasoCobranza;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/cobranza/p.verComprobantesPago.php');
            ob_start();
                $comprobantes = $data->verComprobantesPago($docf);
                include 'app/views/pages/cobranza/p.verComprobantesPago.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
            $e = "Favor de iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e));
        }       
    }


    function seguimientoCajasRecibir($tipo){
        if($_SESSION['user']){
            $data=new pegasoCobranza;
            $pagina =$this->load_template('Pedidos');
            if($tipo == 62){
                $tipo2 =6;
                $html=$this->load_page('app/views/pages/cobranza/p.seguimientoCajasRecibir.php');
            }elseif($tipo == 6){
                $html=$this->load_page('app/views/pages/cobranza/p.seguimientoCajasRecibirCartera.php');    
            }elseif ($tipo == 7){
                $html=$this->load_page('app/views/pages/cobranza/p.seguimientoCajasRecibir.php');
            }
            ob_start();
            $usuario = $_SESSION['user']->NOMBRE;
            $tipoUsuario = $_SESSION['user']->LETRA;
            $tipo2=$tipo;
            $documentos=$data->seguimientoCajasRecibir($tipo);
            $saldos = $data->saldosRevision();
            if($tipo == 62){
                $tipo2 = 6;
            include 'app/views/pages/cobranza/p.seguimientoCajasRecibir.php';
            }elseif($tipo == 6 ){
            include 'app/views/pages/cobranza/p.seguimientoCajasRecibirCartera.php';    
            }elseif($tipo == 7 ){
            include 'app/views/pages/cobranza/p.seguimientoCajasRecibir.php';    
            }
            
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }   
    }

    function verSaldosPagos($t){
        if($_SESSION['user']){
            $data = new pegasoCobranza;
            $pagina =$this->load_template('Pedidos');
               $html=$this->load_page('app/views/pages/cobranza/p.verSaldosPagos.php');
            ob_start();
            $usuario = $_SESSION['user']->NOMBRE;
            $tipoUsuario = $_SESSION['user']->LETRA;
            $pagos=$data->verSaldosPagos($t);
            $maestros = $data->traeMaestros();
            include 'app/views/pages/cobranza/p.verSaldosPagos.php';    
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }
    }

    function creaSolRev($docf, $docp, $idc, $obs, $motivo){
        if($_SESSION['user']){
            $data= new pegasoCobranza;
            $response = $data->creaSolRev($docf, $docp, $idc, $obs, $motivo);
            return $response;
        }
    }

    function generaCEPPago($folios, $idCliente, $ctaO, $bancoO,$tipoO, $numope){
       if($_SESSION['user']){
            $data = new pegasoCobranza;
            $fact = new factura;
            $response=$fact->generaCEPPago($folios, $idCliente, $ctaO, $bancoO,$tipoO, $numope);
            return $response;
       }
    }

    function envFac($docf){
        $data = new pegasoCobranza;
        $pagina =$this->load_template('Pedidos');
        $html=$this->load_page('app/views/pages/Facturacion/p.envFac.php');
        ob_start();
        $usuario = $_SESSION['user']->NOMBRE;
        $tipoUsuario = $_SESSION['user']->LETRA;
        $fact=$data->envFac($docf);
        include 'app/views/pages/Facturacion/p.envFac.php';    
        $table = ob_get_clean();
        $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
        $this->view_page($pagina);
    }

    function enviarFact($docf, $correo, $mensaje){
        $_SESSION['correo']=$correo;
        $_SESSION['docf'] = $docf;   //// guardamos los datos en la variable goblal $_SESSION.
        $_SESSION['mensaje'] = $mensaje;    //// guardamos los datos en la variable goblar $_SESSION.
        $_SESSION['titulo'] = 'Envio de Factura Electronica';   //// guardamos los datos en la variable global $_SESSION
        include 'app/mailer/envioFact.php';   ///  se incluye la classe Contrarecibo     
        if($mensaje == ''){
            
        }else{
            echo '<script> alert("Se ha enviado el correo favor de confirmar con el remitente..."); window.close();</script>';
        }
        return;
    }

    function valida($m, $monto, $idp){
        $data=new pegasoCobranza;
        $res=$data->valida($m, $monto, $idp);
        return $res;
    }

    function cancelaAplicacion($ida, $doc, $idp ){
        if ($_SESSION['user']){
            $data = new pegasoCobranza;
            $res = $data->cancelaAplicacion($ida, $doc, $idp);
            return $res;
        }
    }

    function utileriaCobranza($metodo, $maestro, $sel){
        if(isset($_SESSION['user'])){
            $data = new pegasoCobranza;
            $documentos = $data->traeDocumentos($sel, $maestro);
            if(strpos($metodo, ":")){
                $m=explode(":", $metodo);
                $correo=$m[1]; 
            }
            $metodo = substr($metodo, 0,1);
            if($metodo== 'x'){
                /// codigo para la descarga de excel;
                $nombre=$this->descargaEdoXLS($documentos);
                return array("status"=>'ok',"archivo"=>$nombre);
            }elseif($metodo =='e'){
                /// codigo para el envio del correo electronico;
                $this->imprimeEdoDocs($documentos, $sel, $des='f');
                $this->envioCorreo($documentos,$correo);
                return;
            }elseif($metodo == 'i') {
                /// codigo pata la impresion en PDF.
                $this->imprimeEdoDocs($documentos, $sel, $des='d');
            }
        }
    }

    function descargaEdoXLS($documentos){
        $xls= new PHPExcel();
        $data = new pegaso();
        //// insertamos datos a al objeto excel.
        // Fecha inicio y fecha fin
        $df= $data->traeDF($ide = 1);
        $usuario =$_SESSION['user']->NOMBRE;
        $fecha = date('d-m-Y h:i:s');
        $ln = 10;
        //print_r($documentos);
        $totalSaldo=0;
        foreach ($documentos as $key ) {
            $maestro=$key->MAESTRO;
            $totalSaldo += $key->SALDO;
            $xls->setActiveSheetIndex()
                ->setCellValue('A'.$ln, $key->CVE_DOC)
                ->setCellValue('B'.$ln,$key->FECHAELAB)
                ->setCellValue('C'.$ln,'$ '.number_format($key->SALDOFINAL-$key->IMP_TOT4,2))
                ->setCellValue('D'.$ln,'$ '.number_format($key->IMP_TOT4,2))
                ->setCellValue('E'.$ln,'$ '.number_format($key->IMPORTE,2))
                ->setCellValue('F'.$ln,'$ '.number_format($key->SALDO,2))
                ->setCellValue('G'.$ln,$key->FECHA_INI_COB)
                ->setCellValue('H'.$ln,$key->CVE_PEDI)
                ->setCellValue('I'.$ln,$key->OC);
            $ln++;
        }
        $ln++;
        $xls->setActiveSheetIndex()
                ->setCellValue('A'.$ln,'Fin del resumen de documentos.');
                //->setCellValue('B'.$ln,'')
                //->setCellValue('C'.$ln,'$ '.number_format($key->SALDOFINAL-$key->IMP_TOT4,2))
                //->setCellValue('D'.$ln,'$ '.number_format($key->IMP_TOT4,2))
                //->setCellValue('E'.$ln,'$ '.number_format($key->IMPORTE,2))
                //->setCellValue('F'.$ln,'$ '.number_format($key->SALDO,2))
                //->setCellValue('G'.$ln,$key->FECHA_INI_COB)
                //->setCellValue('H'.$ln,$key->CVE_PEDI)
                //->setCellValue('I'.$ln,$key->OC);
        /// 
            $xls->getActiveSheet()
                ->setCellValue('A1',$df->RAZON_SOCIAL);
        /// CAMBIANDO EL TAMAÑO DE LA LINEA.
        $xls->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $xls->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $xls->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $xls->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $xls->getActiveSheet()->getColumnDimension('E')->setWidth(13);
        $xls->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $xls->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        
        // Hacer las cabeceras de las lineas;
        $xls->getActiveSheet()
            ->setCellValue('A9','Documento')
            ->setCellValue('B9','Fecha')
            ->setCellValue('C9','SubTotal')
            ->setCellValue('D9','IVA')
            ->setCellValue('E9','TOTAL')
            ->setCellValue('F9','Saldo')
            ->setCellValue('G9','Fecha de Envio')
            ->setCellValue('H9','Pedido')
            ->setCellValue('I9','Orden de Compra')
            ;

        $xls->getActiveSheet()
            ->setCellValue('A3','Resumen de Documentos del Mestro: ')
            ->setCellValue('A4','Fecha de Emision del Reporte: ')
            ->setCellValue('A5','Total de Documentos: ')
            ->setCellValue('A6','Importe Total de los Documentos: ')
            ->setCellValue('A7','Usuario Elabora')
            ->setCellValue('A8','')
            ;
        $xls->getActiveSheet()
            ->setCellValue('D3',$key->NOMBRE_MAESTRO)
            ->setCellValue('D4',$fecha)
            ->setCellValue('D5',count($documentos))
            ->setCellValue('D6','$ '.number_format($totalSaldo,2))
            ->setCellValue('D7',$usuario)
            ->setCellValue('D8','')
            ;
        /// Unir celdas
        $xls->getActiveSheet()->mergeCells('A1:O1');
        // Alineando
        $xls->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        /// Estilando
        $xls->getActiveSheet()->getStyle('A1')->applyFromArray(
            array('font' => array(
                    'size'=>20,
                )
            )
        );

        $xls->getActiveSheet()->mergeCells('A3:C3');
        $xls->getActiveSheet()->getStyle('D3')->applyFromArray(
            array('font' => array(
                    'size'=>15,
                )
            )
        );

        $xls->getActiveSheet()->getStyle('A3:D3')->applyFromArray(
            array(
                'font'=> array(
                    'bold'=>true
                ),
                'borders'=>array(
                    'allborders'=>array(
                        'style'=>PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        //// Crear una nueva hoja 
            //$xls->createSheet();
        /// Crear una nueva hoja llamada Mis Datos
        /// Descargar
            $ruta='C:\\xampp\\htdocs\\EdoCtaXLS\\';
            $nom='Documentos '.$maestro.'.xlsx';
            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //header("Content-Disposition: attachment;filename=01simple.xlsx");
            //header('Cache-Control: max-age=0');
        /// escribimos el resultado en el archivo;
            $x=PHPExcel_IOFactory::createWriter($xls,'Excel2007');
        /// salida a descargar
            $x->save($ruta.$nom);
            ob_end_clean();
           // $x->save('php://output');
        /// salida a ruta :
            return $nom;
    }

    function envioCorreo($documentos, $correo){
        $exec = $documentos;  /// Ejecutamos las consultas y obtenemos los datos.
        //$correo = 'genseg@hotmail.com';    /// correo electronico.
        $_SESSION['correos']=$correo;
        $_SESSION['exec'] = $exec;    //// guardamos los datos en la variable goblar $_SESSION.
        $_SESSION['titulo'] = 'Facturas Pendiente de Pago';   //// guardamos los datos en la variable global $_SESSION
        include 'app/mailer/send.DocumentosCobranza.php';   ///  se incluye la classe Contrarecibo     
    }

    function imprimeEdoDocs($documentos, $sel, $des){
        ob_start();      
        $usuario=$_SESSION['user']->NOMBRE; 
        $pdf = new FPDF('P','mm','Letter');
        $monto = 0;
        $x=0;
        foreach ($documentos as $key) {
            $maestro = $key->NOMBRE_MAESTRO;
            $monto += $key->SALDOFINAL;
            if(!empty($key->NOMBRE)){
                $x++;
            }
        }
        $pdf->AddPage(); 
        //$pdf->Image('app/views/images/headerVacio.jpg',10,5,205,40);
        $pdf->Ln(70);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFont('Courier', 'B', 20);
        $pdf->SetTextColor(255,0,0);
        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0,0,0);
        $pdf->Write(10,'Reporte Documentos');
        $pdf->SetXY(110, 20);
        $pdf->Write(10,'Pendientes de Pago');
        $pdf->SetXY(110, 45);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetX(10);
        $pdf->Write(8,"Resumen de Documentos del Maestro ".$maestro);
        $pdf->Ln(4);
        $pdf->SetX(10);
        $pdf->Write(8,"Fecha de emision del Reporte: ".date('d-m-Y H:i:s'));
        $pdf->Ln(4);
        $pdf->SetX(10);
        $pdf->Write(8,"Total de Documentos: ".$x);
        $pdf->Ln(4);
        $pdf->SetX(10);
        $pdf->Write(8,"Importe total de los documentos $ ".number_format($monto,2));
        $pdf->Ln(4);
        $pdf->SetX(10);
        $pdf->Write(8,"Usuario genera: ".$usuario);
        $pdf->Ln();
        $pdf->Cell(5,5,"Ln",'L,T,R');
        $pdf->Cell(50,5,"Cliente",'L,T,R');
        $pdf->Cell(15,5,"Documento",'L,T,R');
        $pdf->Cell(15,5,"Orden",'L,T,R');
        $pdf->Cell(17,5,"Importe",'L,T,R');
        $pdf->Cell(17,5,"Fecha ",'L,T,R');
        $pdf->Cell(17,5,"Fecha ",'L,T,R');
        $pdf->Cell(7,5,"Dias",'L,T,R');
        $pdf->Cell(17,5,"Aplicaciones",'L,T,R');
        $pdf->Cell(17,5,"Notas",'L,T,R');
        $pdf->Cell(17,5,"Saldo",'L,T,R');
        $pdf->Ln();
        $pdf->Cell(5,5,"",'L,R,B');
        $pdf->Cell(50,5,"",'L,R,B');
        $pdf->Cell(15,5,"",'L,R,B');
        $pdf->Cell(15,5,"Compra",'L,R,B');
        $pdf->Cell(17,5,"",'L,R,B');
        $pdf->Cell(17,5,"Emision",'L,R,B');
        $pdf->Cell(17,5,"Cobranza",'L,R,B');
        $pdf->Cell(7,5,"",'L,R,B');
        $pdf->Cell(17,5,"",'L,R,B');
        $pdf->Cell(17,5,"Credito",'L,R,B');
        $pdf->Cell(17,5,"",'L,R,B');
        
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 7);
        $J=0;
        foreach($documentos as $row){
            $J++;
            if(strlen($row->NOMBRE)>25 and !empty($row->NOMBRE)){
                $pdf->Cell(5,5,$J,'L,T,R');
                $pdf->Cell(50,5,'('.trim($row->CVE_CLPV).')'.substr($row->NOMBRE, 0, 25),'L,T,R');
                $pdf->Cell(15,5,$row->CVE_DOC,'L,T,R');
                $pdf->Cell(15,5,substr($row->OC,0,9),'L,T,R');
                $pdf->Cell(17,5,'$ '.number_format($row->IMPORTE,2),'L,T,R', 'R');
                $pdf->Cell(17,5,substr($row->FECHAELAB,0,10),'L,T,R');
                $pdf->Cell(17,5,substr($row->FECHA_INI_COB,0,10),'L,T,R');
                $pdf->Cell(7,5,$row->VENCIMIENTO,'L,T,R');
                $pdf->Cell(17,5,'$ '.number_format($row->APLICADO,2),'L,T,R');
                $pdf->Cell(17,5,'$ '.number_format($row->IMPORTE_NC,2),'L,T,R');
                $pdf->Cell(17,5,'$ '.number_format($row->SALDOFINAL,2),'L,T,R');
                $pdf->Ln();
                $pdf->Cell(5,5,"",'L,B,R');
                $pdf->Cell(50,5,substr($row->NOMBRE,30,60),'L,B,R');
                $pdf->Cell(15,5,"",'L,B,R');
                $pdf->Cell(15,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Cell(7,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Cell(17,5,"",'L,B,R');
                $pdf->Ln();    
            }elseif(strlen($row->NOMBRE)<25 and !empty($row->NOMBRE)){
                $pdf->Cell(5,5,$J,'L,T,R,B');
                $pdf->Cell(50,5,'('.trim($row->CVE_CLPV).')'.substr($row->NOMBRE, 0, 25),'L,T,R,B');
                $pdf->Cell(15,5,$row->CVE_DOC,'L,T,R,B');
                $pdf->Cell(15,5,substr($row->OC,0,9),'L,T,R,B');
                $pdf->Cell(17,5,'$ '.number_format($row->IMPORTE,2),'L,T,R,B',0,'R');
                $pdf->Cell(17,5,substr($row->FECHAELAB,0,10),'L,T,R,B');
                $pdf->Cell(17,5,substr($row->FECHA_INI_COB,0,10),'L,T,R,B');
                $pdf->Cell(7,5,$row->VENCIMIENTO,'L,T,R,B');
                $pdf->Cell(17,5,'$ '.number_format($row->APLICADO,2),'L,T,R,B',0,'R');
                $pdf->Cell(17,5,'$ '.number_format($row->IMPORTE_NC,2),'L,T,R,B',0,'R');
                $pdf->Cell(17,5,'$ '.number_format($row->SALDOFINAL,2),'L,T,R,B',0,'R');
                $pdf->Ln();
            }
        }
        if($sel == 'Si'){
            $usuario = $_SESSION['user']->NOMBRE;
            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Write(6,"Incluye solo los doumentos seleccionados por el usuario ".$usuario);
            $pdf->Ln(10);
            $pdf->Write(6,"Los Documentos en esta Relacion no tienen registro de pago.");
        }
        ob_get_clean();        
        if($des == 'd'){
            $usuario = $_SESSION['user']->NOMBRE;
            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Write(6,"Los Documentos en esta Relacion no tienen registro de pago.");
            $pdf->Output('Relacion de Documentos '.date('d-m-Y').'.pdf','d');
        }elseif($des == 'f'){
            $usuario = $_SESSION['user']->NOMBRE;
            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Write(6,"Los Documentos en esta Relacion no tienen registro de pago.");
            $pdf->Output('C:\\xampp\\htdocs\EdoCtaCorreo\\Relacion de Documentos '.date('d-m-Y').'.pdf','f');
        }
    }

    function enviaCorreoRuta($correo, $adjunto, $mensaje, $response){
        $dao=new pegasoCobranza; /// Invocamos la classe pegaso para usar la BD.
        $exec= $dao->traeDocumentosRuta($response);
        if($adjunto == 1){
            $zip= new ZipArchive();
            $x= date("dmYHis");
            //echo $x;
            $filename= "C:\\xampp\\htdocs\\Facturas\\FacturasFerreteraPegaso".$x.".zip";
            //filename="./test.zip";
            if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
               exit("cannot open <$filename>\n");
            }
            foreach($exec as $d){
                $doc = $d->CVE_DOC;
                $thisdir="C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\";
                $zip->addFile($thisdir.$doc.".pdf",$doc.".PDF");
                $zip->addFile($thisdir.$doc.".xml",$doc.".XML");
            }
            //echo "numficheros: " . $zip->numFiles . "\n";
            //echo "estado:" . $zip->status . "\n";
            $zip->close();
        }
        // $documentos = $data->traeDocumentos($sel, $maestro);
        $_SESSION['correos']=$correo;
        $_SESSION['adjunto'] = $adjunto;   //// guardamos los datos en la variable goblal $_SESSION.
        $_SESSION['file']=$filename;
        $_SESSION['info']=$response;
        $_SESSION['exec'] = $exec;    //// guardamos los datos en la variable goblar $_SESSION.
        $_SESSION['mensaje']=$mensaje;
        $_SESSION['titulo'] = 'Envio de Documentos Cuenta por Cobrar FERRETERA PEGASO SA DE CV';   //// guardamos los datos en la variable global $_SESSION
        include 'app/mailer/send.enviaRutaCobranza.php';   ///  se incluye la classe Contrarecibo     
    }

    function actAcr(){
        if($_SESSION['user']){
            $data = new pegasoCobranza;
            $act=$data->actAcr();
            return $act;
        }
    }

    function edoCliente($cliente, $tipo, $nombre ){
        if (isset($_SESSION['user'])){
        $data = new pegasoCobranza;
        $pagina=$this->load_template_popup('Pedidos');
        $html=$this->load_page('app/views/pages/Clientes/p.edoCliente.php');
        ob_start();
        $facturas=$data->facturasCliente($cliente, $tipo);
        include 'app/views/pages/Clientes/p.edoCliente.php';
        $table = ob_get_clean();    
            if (count($facturas)>0){
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            }else{
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table.'<div class="alert-info"><center><h2>No hay facturas del cliente '.$nombre.'.</h2><center></div>', $pagina);
            }
        $this->view_page($pagina);
        }else{
            $e = "Favor de iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); 
        } 
    }

}
?>