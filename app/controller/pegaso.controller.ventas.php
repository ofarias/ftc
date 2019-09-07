<?php

////session_cache_limiter('private_no_expire');
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/model/pegaso.model.ventas.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');

class pegaso_controller_ventas{

	var $contexto = "http://SERVIDOR:8081/pegasoFTC/app/";
	
	function load_template($title='Sin Titulo'){
		$pagina = $this->load_page('app/views/master.php');
		$header = $this->load_page('app/views/sections/s.header.php');
		$pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);		
		return $pagina;
	}
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
   private function view_page($html){
		echo $html;
	}
   private function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
		 return preg_replace($in, $out, $pagina);	 	
	}


	function crearPedido(){
		//session_cache_limiter('private_no_expire');
		$datav = new pegaso_ventas;
		$consultax = $datav->clientes();
		var_dump($consultax);
		//break;
	}
	

      function CerrarVentana(){
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])){
            $data = new pegaso;
            ///$redireccionar = "pantalla2";
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.cerrarventana.php');
            $exec = $data->reenviaCaja($factura,$caja);
            include 'app/views/pages/p.cerrarventana.php';
            //header('Location: index.php?action=mercanciaRecibidaImp');
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

	//// INICIA EL MODULO DE COTIZACIONES CFA--
    function consultarCotizaciones($cerradas=false) {
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina = $this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/ventas/p.cotizacion.php');
            ob_start();
            $exec = $datav->consultarCotizaciones($cerradas);
            include 'app/views/pages/ventas/p.cotizacion.php';
            $table = ob_get_clean();    
            if (count($exec) > 0) {
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            } else {
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table . '<div class="alert-danger"><center><h2>No se han encontrado registros para mostrar.</h2><center></div>', $pagina);
            }
            $this->view_page($pagina);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }

    function actualizaCotizacion($folio, $partida, $articulo, $precio, $descuento, $cantidad, $ida){
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;          
            $datav->actualizaCotizacion($folio, $partida, $articulo, $precio, $descuento, $cantidad, $ida);
            $this->verDetalleCotizacion($folio);      
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function insertaCotizacion($cliente, $identificadorDocumento){
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start();
            $redireccionar = "consultarCotizaciones";          
            $datav->insertaCotizacion($cliente, $identificadorDocumento);
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);       
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function actualizaPedidoCotizacion($folio, $pedido) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;          
            $datav->actualizaPedidoCotizacion($folio, $pedido);
            $this->verDetalleCotizacion($folio);      
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
            
    function avanzaCotizacion($folio){
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;     
            $val = $datav->validacion($folio);
            if($val != 'PENDIENTE'){
                $redireccionar = "consultarCotizaciones";
                $pagina=$this->load_template('Pedidos');
                $html = $this->load_page('app/views/pages/p.redirectform.v.php');
                include 'app/views/pages/p.redirectform.v.php';
                $this->view_page($pagina);      
                echo '<script>alert("La Cotizacion ya ha sido cerrada con anterioridad")</script>';
                return;
            }
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start();
            $datav->avanzaCotizacion($folio);
            $this->verPedidoCerrado($folio);
            $redireccionar = "consultarCotizaciones";
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);      
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }        
    }

    function verPedidoCerrado($folio){
        $data = new Pegaso; 
        $Cabecera=$data->datosCotizacionFTC($folio);
        $Detalle=$data->detalleCotizacionFTC($folio);
        $usuario =$_SESSION['user']->NOMBRE;
        $pdf = new FPDF('P','mm','Letter');
        foreach ($Cabecera as $sta){
            $sts = $sta->INSTATUS;
            $cotiza  = $sta->SERIE.$sta->FOLIO;
        }
        $pdf->AddPage();
        $pdf->Image('app/views/images/logos/'.$_SESSION['empresa']['logo'],10,10,50,15);
        $pdf->SetFont('Courier', 'B', 25);
        $pdf->SetTextColor(255,0,0);
        $pdf->SetXY(110, 15);
        $pdf->Write(10,'Ventas');
        $pdf->SetXY(110, 22);
        $pdf->Write(10,utf8_decode('Cotización'));
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Courier', 'I', 20);
        $pdf->SetXY(10, 42);
        $pdf->Write(10,$sts.'  '.$cotiza);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Ln();
        foreach ($Cabecera as $data){
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Write(6,'Cotizacion:'.$data->SERIE.$data->FOLIO.', Fecha de Cierre:'.date('d-m-Y H:i:s').', Usuario Cierre:'.$usuario);
        $pdf->Ln();
        $pdf->Write(6,'Fecha de Elaboracion: '.$data->DTFECREG.', Estado de la cotizacion: '.$data->INSTATUS);
        $pdf->Ln();
        $pdf->Write(6,'Vendedor : '.$data->CDUSUARI);
        $pdf->Ln();
        $pdf->Write(6,'Cliente : ('.$data->CVE_CLIENTE.')'.$data->NOMBRE.', RFC: '.$data->RFC);
        $pdf->Ln();
        $pdf->Write(6,'Dias de Credito: '.$data->PLAZO.'   #################   Tipo de pago: Transferencia Interbancaria');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(100,6,'Direccion Fiscal','L,R,T',0,'C');
        $pdf->Cell(100,6,'Direccion de Envio','L,R,T',0,'C');
        $pdf->Ln();
        $pdf->Cell(100,6,substr($data->CALLE.','.$data->NUMEXT,0,60),'L,R');
        $pdf->Cell(100,6,substr($data->CALLE_ENVIO.','.$data->NUMEXT_ENVIO.' '.$data->NUMINT_ENVIO,0,60),'L,R');
        $pdf->Ln();
        $pdf->Cell(100,6,substr('Col. '.$data->COLONIA,0,60),'L,R');
        $pdf->Cell(100,6,substr('Col. '.$data->COLONIA_ENVIO.' '.$data->LOCALIDAD_ENVIO,0,60),'L,R');
        $pdf->Ln();
        $pdf->Cell(100,6,substr('Edo. '.$data->ESTADO.', Pais: '.$data->PAIS,0,60),'L,R');
        $pdf->Cell(100,6,substr('Edo. '.$data->ESTADO_ENVIO.', Pais: '.$data->PAIS_ENVIO,0,60),'L,R');
        $pdf->Ln();
        $pdf->Cell(100,6,substr('CP. '.$data->CODIGO.', Municipio: '.$data->MUNICIPIO,0,60),'L,R,B');
        $pdf->Cell(100,6,substr('CP. '.$data->CODIGO_ENVIO.', Municipio: '.$data->MUNICIPIO_ENVIO,0,60),'L,R,B');
        $pdf->Ln();
        //$pdf->Write(6,'Dias de Credito: '.$data->PLAZO.'   #################   Tipo de pago: Transferencia Interbancaria');
        $pdf->Ln();
        $pdf->Ln();
        }
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10,6,"Part.",1);
        $pdf->Cell(20,6,"Art.",1);
        $pdf->Cell(60,6,"Descripcion",1);
        $pdf->Cell(10,6,"Cant",1);
        $pdf->Cell(10,6,"UM",1);
        $pdf->Cell(20,6,"Precio",1);
        $pdf->Cell(20,6,"Descuento",1);
        $pdf->Cell(25,6,"Subtotal ",1);
        $pdf->Cell(15,6,"Iva",1);
        $pdf->Cell(15,6,"Total",1);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 7);
            $descuento = 0;
            $subtotal = 0;
            $iva = 0;
            $total = 0;
            $partida= 0;
            $desctotal=0;
        foreach($Detalle as $row){
            $desc = ($row->DBIMPDES /100);
            $descuento = ($row->DBIMPPRE-($row->DBIMPPRE * $desc))*$row->FLCANTID; 
            $partida = ($partida + 1);
            $subtotal += ($row->DBIMPPRE * $row->FLCANTID);
            $desctotal +=($row->DBIMPPRE * $row->FLCANTID) - $descuento; 
            $iva += ($subtotal - $desctotal) *.16;
            $total += ($subtotal - $desctotal)*1.16;
            $pdf->Cell(10,6,($partida),'L,T,R');
            $pdf->Cell(20,6,($row->CLAVE_PROD),'L,T,R');
            $pdf->Cell(60,6,substr($row->NOMBRE, 0 , 34), 'L,T,R');
            $pdf->Cell(10,6,number_format($row->FLCANTID,2),'L,T,R');
            $pdf->Cell(10,6,$row->UM,'L,T,R');
            $pdf->Cell(20,6,'$ '.number_format($row->DBIMPPRE,2),'L,T,R');
            $pdf->Cell(20,6,'% '.number_format($row->DBIMPDES,2),'L,T,R');
            $pdf->Cell(25,6,'$ '.number_format(($row->DBIMPPRE * $row->FLCANTID) - (($row->DBIMPPRE * $desc) * $row->FLCANTID)  ,2),'L,T,R');
            $pdf->Cell(15,6,'$ '.number_format((  (($row->DBIMPPRE * $row->FLCANTID) - (($row->DBIMPPRE * $desc) * $row->FLCANTID) )* .16),2),'L,T,R');
            $pdf->Cell(15,6,'$ '.number_format(((($row->DBIMPPRE * $row->FLCANTID) - (($row->DBIMPPRE * $desc) * $row->FLCANTID)) * 1.16),2),'L,T,R');
            $pdf->Ln();             // Segunda linea descripcion
            $pdf->Cell(10,6,"",'L,B,R');
            $pdf->Cell(20,6,'( '.$row->CVE_ART.' )','L,B,R');
            $pdf->Cell(60,6,substr($row->NOMBRE, 34 , 68),'L,B,R');
            $pdf->Cell(10,6,"",'L,B,R');
            $pdf->Cell(10,6,"",'L,B,R');
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(20,6,"",'L,B,R');
            $pdf->Cell(25,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Cell(15,6,"",'L,B,R');
            $pdf->Ln();
        }
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(60,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(40,6,"SubTotal",1);
            $pdf->Cell(15,6,'$ '.number_format($subtotal,2),1);
            $pdf->Ln();

            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(60,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(40,6,"Descuento",1);
            $pdf->Cell(15,6,'$ '.number_format($desctotal,2),1);
            $pdf->Ln();

            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(60,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(40,6,"IVA",1);
            $pdf->Cell(15,6,'$ '.number_format(($subtotal -$desctotal)*.16,2),1);
            $pdf->Ln();

            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(60,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(10,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Cell(40,6,"Total",1);
            $pdf->Cell(15,6,'$ '.number_format(($subtotal - $desctotal) *1.16,2),1);
            $pdf->Ln();
            $pdf->SetTextColor(255,0,0);
            $pdf->SetXY(10, 230);
            $pdf->Write(10,'Favor de confirmar con su vendedor la recepcion de esta cotizacion, si tiene algun comentario o duda con respecto a esta cotizacion favor de comunicarse,');
            $pdf->Ln();
            $pdf->Write(10,'a los sigientes numeros: Tel: ; , o pongase en contacto con: ');

        $pdf->Output('Cotizacion_'.$folio.'_.pdf','d');

    }



    function cancelaCotizacion($folio){
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;          
            $datav->cancelaCotizacion($folio);
            $this->consultarCotizaciones();      
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }        
    }
    
    function verDetalleCotizacion($folio) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina = $this->load_template('Pagos');
            $html = '<div class="alert-info"><center><h2>No se han localizado partidas</h2><center></div>';
            ob_start();
            $cabecera = $datav->cabeceraCotizacion($folio);
            $detalle = $datav->detalleCotizacion($folio);
            if (count($detalle) > 0) {
                include 'app/views/pages/ventas/p.detalleCotizacion.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            } else {                
                include 'app/views/pages/ventas/p.detalleCotizacion.php';
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
                //$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-danger"><center><h2>Hubo un error al mostrar los datos</h2><center></div>', $pagina);
            }
            $this->view_page($pagina);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function consultarArticulo($cliente, $folio, $partida, $articulo, $descripcion) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina = $this->load_template('Pagos');
            //$html = $this->load_page('app/views/pages/p.buscaArticulo.php');
            $html = '<div class="alert-info"><center><h2>No se han localizado registros</h2><center></div>';
            ob_start();
            //echo 'descripcion a buscar: '.$descripcion;
            //$pxc = $datav->articuloXcliente($cliente);
            //$pxv = $datav->articuloXvendedor();
            $val = $datav->validacion($folio);
            if($val != 'PENDIENTE'){
                $this->verDetalleCotizacion($folio);
                echo '<script>alert("La Cotizacion ya ha sido cerrada y no se podra Modificar los Articulos")</script>';
                return;
            }
            $pxrfc = $datav->articuloXrfc($cliente);
            $detalle = $datav->listaArticulos($cliente, $articulo, $descripcion, $partida, $folio);
            $_SESSION['cliente'] = $cliente;
            $_SESSION['folio_cotizacion'] = $folio;
            $_SESSION['partida_cotizacion'] = $partida;  
            //echo 'Valor del cliente'.$_SESSION['cliente'].'<p>';
            //echo 'Valor del folio Cotizacion'.$_SESSION['folio_cotizacion'].'<p>';
            //echo 'Valor del partida Cotizacion'.$_SESSION['partida_cotizacion'].'<p>';    
            //echo 'Valor de detalle: '.$detalle.'<p>'; 
            if ($detalle <>'Alta') {
                include 'app/views/pages/ventas/p.buscaArticulo.php';                
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            }else{
                include 'app/views/pages/ventas/p.buscaArticulo.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
                //var_dump($detalle);
                //echo 'Entro a la nada';
                //$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html . '<div class="alert-info"><center><h2>No se han localizado registros</h2><center></div>', $pagina);
                //$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
            }
            $this->view_page($pagina);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function consultarClientes($clave, $cliente) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina = $this->load_template('Pagos');
            $html = '<div class="alert-info"><center><h2>No se han localizado registros</h2><center></div>';
            ob_start();
            $detalle = $datav->listadoClientes($clave, $cliente);
            if (count($detalle) > 0) {
                include 'app/views/pages/ventas/p.buscaCliente.php';                
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            } else {
                include 'app/views/pages/ventas/p.buscaCliente.php';
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
            }
            $this->view_page($pagina);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function quitarPartida($folio, $partida){
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $val = $datav->validacion($folio);
            if($val != 'PENDIENTE'){
                $this->verDetalleCotizacion($folio);
                echo '<script>alert("La Cotizacion ya ha sido cerrada y no se podra Modificar los Articulos")</script>';
                return;
            }
            $datav->quitarCotizacionPartida($folio, $partida);
            $this->verDetalleCotizacion($folio);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }
    
    function moverClienteCotizacion($folio, $cliente) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {            
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start();
            $datav = new pegaso_ventas;
            $datav->moverClienteCotizacion($folio, $cliente);
            $redireccionar = "consultarCotizaciones";
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);  
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }    


    ///// Termina Cotizaciones CFA-


//// Inicia el Modulo de Productos


	function CapturaProductos(){
		//session_cache_limiter('private_no_expire');
		if(isset($_SESSION['user'])){
			$pagina = $this->load_template('Menu Admin');
			$html = $this->load_page('app/views/pages/ventas/p.capturaproductos.php');
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
			$this->view_page($pagina);
        	}else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        	}
	}

    function VerCat10($alm) {
        //session_cache_limiter('private_no_expire');
        if (isset($_SESSION['user'])) {
            $data = new pegaso;
            $datav = new pegaso_ventas;
            $pagina = $this->load_template('Pagos');
            $html = '<div class="alert-info"><center><h2>No se han localizado registros</h2><center></div>';
            ob_start();
            $productos = $data->VerCat10($alm);
            if (count($productos) > 0) {
                include 'app/views/pages/ventas/p.productos.php';                
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            } else {
                include 'app/views/pages/ventas/p.productos.php';
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
            }
            $this->view_page($pagina);
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
    }

	function editProd($id){
		 //session_cache_limiter('private_no_expire');
		 if(isset($_SESSION['user'])){
			$data = new pegaso;
            $datav = new pegaso_ventas;				
		$pagina=$this->load_template('Alta Unidades');				
		$html = $this->load_page('app/views/pages/ventas/p.editproductos.php');
		ob_start(); 
		//generamos consultas
				$prod=$data->EditProd($id);
				if(count($prod) > 0){
					include 'app/views/pages/ventas/p.editproductos.php';
					$table = ob_get_clean(); 
						$pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
							}else{
								$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html.'<div class="alert-danger"><center><h2>Hubo un error al mostrar los datos</h2><center></div>', $pagina);
							}		
							$this->view_page($pagina);	
		}else{
			$e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}


    function altaProdVentas($descripcion, $cotizacion, $cliente){
        //session_cache_limiter('private_no_expire');
        if(isset($_SESSION['user'])){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.altaProductoVentas.php');
            ob_start(); 
            //catalogos //
            $marcas = $datav->traeMarcas();
            $marcasxcat = $datav->traeMarcasxCat();
            $proveedores = $datav->traeProveedores();
            $categorias = $datav->traeCategorias();
            $lineas = $datav->traelineas();
            $um = $datav->traeUM();
            // fin Catalogos // 
            //echo 'ln 343 Esta es la cotizacion: '.$cotizacion;
            //echo 'ln 344 Este es el cliente: '.$cliente;
            include 'app/views/pages/ventas/p.altaProductoVentas.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
                   
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function TraeProveedores($prov){    
        $datav = new pegaso_ventas;
        $exec = $datav->traeProveedores($prov);
        return $exec;
    }
    
    function TraeProductos($prod){  
        $datav = new pegaso_ventas;
        $exec = $datav->traeProductos($prod);
        return $exec;
    }

    function TraeProductosFTC($descripcion){
        $datav= new pegaso_ventas;
        $exec = $datav->traeProductosFTC($descripcion);
        return $exec;
    }

    function TraeClientes($cliente){
        $datav= new pegaso_ventas;
        $exec=$datav->traeClientes($cliente);
        return $exec;
    }


    function solicitarAlta($categoria, $descripcion, $marca, $cotizacion, $cliente, $unidadmedida,$empaque, $cantsol){
    //($categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $cotizacion, $cliente){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $insertaSolicitud=$datav->insertaSol($categoria, $descripcion, $marca, $cotizacion, $cliente, $unidadmedida,$empaque, $cantsol);
            //($categoria, $linea, $descripcion, $marca, $generico, $sinonimos, $calificativo, $medidas, $unidadmedida, $empaque, $prov1, $codigo_prov1, $sku, $costo_prov, $iva, $desc1, $desc2, $desc3, $desc4, $desc5, $impuesto, $costo_total, $cotizacion, $cliente);
            $folio = $cotizacion;
            $this->verDetalleCotizacion($folio);   
        }
    }

    function crearCategoria(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.altaCategoria.php');
            ob_start(); 
            $usuarios = $datav->usuariosCompras();
            include 'app/views/pages/ventas/p.altaCategoria.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function altaCategoria($nombreCategoria, $abreviatura, $responsable, $status){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos');  
            $redireccionar = 'verCategorias';           
            $html = $this->load_page('app/views/pages/p.redirectform.php');
            ob_start();
            $altaCat=$datav->altaCategoria($nombreCategoria, $abreviatura, $responsable, $status);
             include 'app/views/pages/p.redirectform.php';
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function editaCategoria($idcat){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.editaCategoria.php');
            ob_start(); 
            $usuarios = $datav->usuariosCompras();
            $categoria =$datav->editaCategoria($idcat);
            include 'app/views/pages/ventas/p.editaCategoria.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function editarCategoria($nombreCategoria, $abreviatura, $responsable, $status, $idcat){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos');  
            $redireccionar = 'verCategorias';           
            $html = $this->load_page('app/views/pages/p.redirectform.php');
            ob_start();
            $altaCat=$datav->editarCategoria($nombreCategoria, $abreviatura, $responsable, $status, $idcat);
             include 'app/views/pages/p.redirectform.php';
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }


       function verMarcas(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data= new pegaso;
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verMarcas.php');
            ob_start();
            $marcas = $datav->traeMarcas();
            $marcasT = $datav->traeMarcasT();
            include 'app/views/pages/ventas/p.verMarcas.php';
            $table = ob_get_clean();    
            if (count($marcas)>0){
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            }else{
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table.'<div class="alert-info"><center><h2>No hay datos para mostrar</h2><center></div>', $pagina);
                    }
        $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }


    function crearMarca(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.altaMarca.php');
            ob_start(); 
            //$usuarios = $datav->usuariosCompras();
            include 'app/views/pages/ventas/p.altaMarca.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function altaMarca($cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos');  
            $redireccionar = 'verMarcas';           
            $html = $this->load_page('app/views/pages/p.redirectform.php');
            ob_start();
            $altaCat=$datav->altaMarca($cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d);
             include 'app/views/pages/p.redirectform.php';
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }


    function editaMarca($idm){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.editaMarca.php');
            ob_start(); 
            //$usuarios = $datav->usuariosCompras();
            $marca =$datav->editaMarca($idm);

            include 'app/views/pages/ventas/p.editaMarca.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }


    function editarMarca($idm, $cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos');  
            $redireccionar = 'verMarcas';           
            $html = $this->load_page('app/views/pages/p.redirectform.php');
            ob_start();
            $altaCat=$datav->editarMarca($idm, $cm, $nc, $rz, $dir, $tel, $cont, $s, $p, $d);
             include 'app/views/pages/p.redirectform.php';
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }


    function verMarcasxCategoria($idcat, $marca){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Alta Unidades');              
            $html = $this->load_page('app/views/pages/ventas/p.verMarcasxCategorias.php');
            ob_start(); 
            //echo 'valor de marca desde asignar marca. '.var_dump($marca);
            $categoria = $datav->verCategoria($idcat);
            if($marca == true){
                $marcas = $datav->buscaMarca($marca, $idcat);    
            }else{
               $marcas = false;
            }
            //var_dump($marcas);
            //break;
            $catxmarca=$datav->categoriaxMarca($idcat);
            include 'app/views/pages/ventas/p.verMarcasxCategorias.php';
            $table = ob_get_clean(); 
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$table , $pagina);
            $this->view_page($pagina);
        }else{
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }


    function asignarMarca($idcat, $idmca){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            //pagoFacturas&idp={$idp}
            ob_start();
            $marca=false; 
            $redireccionar="verMarcasxCategoria&idcat={$idcat}&marca={$marca}";
            //echo $idcat;
            //echo $redireccionar;
            $asignaMca=$datav->asignarMarca($idcat, $idmca);
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            //echo 'Valor de Marca'.var_dump($marca);
            //break;
            $this->view_page($pagina);
        }
    }

    function desasignarMarca($idcat, $idmca){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start();
            $marca=false; 
            $redireccionar="verMarcasxCategoria&idcat={$idcat}&marca={$marca}";
            $asignaMca=$datav->desasignarMarca($idcat, $idmca);
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);
        }   
    }


    function cltprovXprod($ids){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data= new pegaso;
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verClienteProveedorXProducto.php');
        ob_start();
            $producto=$datav->traeProducto($ids);
            $cliente = false;
            $proveedor = false;
            if (count($producto)>0){
                include 'app/views/pages/ventas/p.verClienteProveedorXProducto.php';
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

     function cltXprod($ids){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data= new pegaso;
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verClienteXProducto.php');
        ob_start();
            $producto=$datav->traeProducto($ids);
            $cliente = false;
            if (count($producto)>0){
                include 'app/views/pages/ventas/p.verClienteXProducto.php';
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
    

    function buscaClienteProveedor($ids, $aguja){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data= new pegaso;
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verClienteProveedorXProducto.php');
        ob_start();
            $producto=$datav->traeProducto($ids);
            //$cliente = $datav->traeCliente($aguja, $ids);
            $proveedor = $datav->traeProveedor($aguja, $ids);
            if (count($producto)>0){
                include 'app/views/pages/ventas/p.verClienteProveedorXProducto.php';
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

    function buscaCliente($ids, $aguja){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $data= new pegaso;
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verClienteXProducto.php');
        ob_start();
            $producto=$datav->traeProducto($ids);
            $cliente = $datav->traeCliente($aguja, $ids);
            if (count($producto)>0){
                include 'app/views/pages/ventas/p.verClienteXProducto.php';
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

    function proveedorXproducto($ids, $idprov, $pieza, $empaque, $pxp, $empaque2, $pxp2, $urgencia, $entrega, $recoleccion, $efectivo, $cheque, $credito, $costo, $costo2){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start(); 
            $redireccionar="cltprovXprod&ids={$ids}";
            $inserta=$datav->proveedorXproducto($ids, $idprov, $pieza, $empaque, $pxp, $empaque2, $pxp2, $urgencia, $entrega, $recoleccion, $efectivo, $cheque, $credito, $costo, $costo2);
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);
        }   
    }
	
    function clienteXproducto($idclie, $ids, $sku, $skuFact, $listaCliente, $correo, $precio){
       //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pagos'); 
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            ob_start(); 

            $redireccionar="cltXprod&ids={$ids}";
            $inserta=$datav->clienteXproducto($idclie, $ids, $sku, $skuFact, $listaCliente, $correo, $precio);
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.redirectform.v.php');
            include 'app/views/pages/p.redirectform.v.php';
            $this->view_page($pagina);
        }      
    }

    function verFTCArticulosVentas(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verFTCArticulosVentas.php');
        ob_start();
            $productos=$datav->traeProductos();
            if (count($productos)>0){
                include 'app/views/pages/ventas/p.verFTCArticulosVentas.php';
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

    function asociarFTCArticuloCliente(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verFTCArticulosVentas.php');
        ob_start();
            $producto=$datav->traeProducto($ids);
            $cliente = $datav->traeCliente($aguja, $ids);
            $proveedor = $datav->traeProveedor($aguja, $ids);
            if (count($producto)>0){
                include 'app/views/pages/ventas/p.verFTCArticulosVentas.php';
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


    function parCotSMB($folio, $partida, $por2){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            ob_start();
            $smb = $datav->parCotSMB($folio,$partida, $por2);
            $cliente = '';
            $articulo = '';
            $descripcion = '';
            $this->CerrarVentana();
        }
    }

    function verSMB(){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav = new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verSMB.php');
            ob_start();
            $smb = $datav->verSMB();
            include 'app/views/pages/ventas/p.verSMB.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
            }
    }

    function autMB($folio, $partida, $utilAuto, $precio){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            ob_start();
            $autmb = $datav->autMB($folio, $partida, $utilAuto, $precio);
            $this->verSMB();
        }
    }

    function marcarUrgente($folio){
        //session_cache_limiter('private_no_expire');
        if ($_SESSION['user']){
            $datav=new pegaso_ventas;
            ob_start();
            $marcaU=$datav->marcarUrgente($folio);
            $this->consultarCotizaciones($cerradas=false);
        }
    }

    function solLiberacion($folio, $cliente){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            ob_start();
            $solLib=$datav->solLiberacion($folio, $cliente);
            $this->consultarCotizaciones($cerradas=false);
        }
    }

    function verSKUS($cliente, $cdfolio){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verSKUS.php');
            ob_start();
            $skus =$datav->verSKUS($cliente, $cdfolio);
            include 'app/views/pages/ventas/p.verSKUS.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
            }
    }

    function guardaSKU($producto, $sku, $cliente, $cdfolio, $nombre, $descripcion, $cotizacion, $sku_cliente, $sku_otro){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina =$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.verSKUS.php');
            ob_start();
            $guardar =$datav->guardaSKU($producto, $sku, $cliente, $cdfolio, $nombre, $descripcion, $cotizacion, $sku_cliente, $sku_otro);
            $this->verSKUS($cliente, $cdfolio);
        }
    }

    function copiarCotizacion($cotizacion){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            ob_start();
            $response = $datav->copiarCotizacion($cotizacion);
            return $response;
        }

    }

    function copiar($cotizacion){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            ob_start();
            $response = $datav->copiar($cotizacion);
            return $response;
        }
    }

    function guardaPartida($producto, $cotizacion, $tipo, $cantidad, $precio, $descuento, $mb, $mm, $costo){
        //session_commit('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            ob_start();
            $val = $datav->validacion($cotizacion);
            if($val != 'PENDIENTE'){
                $response = array("status"=>'no');
                return $response;
            }
            $response = $datav->guardaPartida($producto, $cotizacion, $tipo, $cantidad, $precio, $descuento, $mb, $mm, $costo);
            return $response;
        }
    }

    function solicitarMargenBajo($cotizacion , $partida){
        //session_cache_limiter('private_no_expire');
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
                $pagina=$this->load_template('Pedidos');
                $html=$this->load_page('app/views/pages/ventas/p.solicitarMargenBajo.php');
            ob_start();
            $skus =$datav->solicitarMargenBajo($cotizacion, $partida);
                include 'app/views/pages/ventas/p.solicitarMargenBajo.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function cajas($tipo, $var, $mes, $anio){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            if($tipo == 1){
                $cajas =$datav->cajas($tipo, $var, $mes, $anio);  
                $html=$this->load_page('app/views/modules/m.cajasxmes.php'); 
                ob_start();
                include 'app/views/modules/m.cajasxmes.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
            }elseif($tipo == 2){
                $cajas = $datav->cajas($tipo, $var, $mes, $anio);
                $html=$this->load_page('app/views/modules/m.cajasxmes.php');
                ob_start();
                include 'app/views/modules/m.cajasxmes.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina); 
            }     
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }   
    }

    function detalleFaltante($docf){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
                $pagina=$this->load_template('Pedidos');
                $html=$this->load_page('app/views/pages/ventas/p.detalleFaltante.php');
            ob_start();
                $datos =$datav->detalleFaltante($docf);
                include 'app/views/pages/ventas/p.detalleFaltante.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
            }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function recalcular($idpreoc, $tipo){
        if($_SESSION['user']){
            $datav = new pegaso_ventas;
            $response= $datav->recalcular($idpreoc, $tipo);
            return $response;
        }
    }

    function cancelar($docf, $uuid){
        if($_SESSION['user'] && $_SESSION['user']->CC == 'G'){
            $datav= new pegaso_ventas;
            $res=$datav->cancelar($docf, $uuid);
            if($res['status'] == 'ok'){
                $this->informaCancelacion($docf, $uuid);
            }
            return $res;
        }else{
            $usuario = $_SESSION['user']->NOMBRE;
            return $res=array("status"=>'No', "motivo"=>"El usuario ".$usuario." no esta autirizado para Cancelar Facturas favor de revisarlo");
        }
    }

    function informaCancelacion($docf, $uuid){
        $dao=new pegaso_ventas; /// Invocamos la classe pegaso para usar la BD.
        $docf=$docf;   /// Ejecutamos las consultas y obtenemos los datos.
        $exec=$dao->informacionFactura($docf);  /// Ejecutamos las consultas y obtenemos los datos.
        $infoCancela=$dao->procesaCancelado($docf, $uuid);
        $correo='genseg@hotmail.com';    /// correo electronico.
        $_SESSION['correo']=$correo;
        $_SESSION['docf'] = $docf;   //// guardamos los datos en la variable goblal $_SESSION.
        $_SESSION['exec'] = $exec;    //// guardamos los datos en la variable goblar $_SESSION.
        $_SESSION['titulo'] = 'Aviso de Cancelacion de factura';   //// guardamos los datos en la variable global $_SESSION
        include 'app/mailer/send.avisoCancelacion.php';   ///  se incluye la classe Contrarecibo     
    }

    function traePendientes($prod){
        if($_SESSION['user']){
            $datav =  new pegaso_ventas;
            $res = $datav->traePendientes($prod);
            return $res;
        }
    }

    function buscaCaja($docf){
        if($_SESSION['user']){
            $correo='genseg@hotmail.com';    /// correo electronico.
            $_SESSION['correo']=$correo;
            $_SESSION['docf'] = $docf;   //// guardamos los datos en la variable goblal $_SESSION.
            $_SESSION['titulo'] = 'Favor de encontrar la caja de la factura '.$docf;   //// guardamos los datos en la variable global $_SESSION
            include 'app/mailer/send.buscaCaja.php';
        }
    }

    function actPartida($docf, $cantidad, $precio, $descuento, $partida, $uso, $mp, $fp, $clie){
        if($_SESSION['user']){
            $datav = new pegaso_ventas;
            $response = $datav->actPartida($docf, $cantidad, $precio, $descuento, $partida, $uso, $mp, $fp, $clie);
            return $response;
        }
    }

    function verPagos(){
        if($_SESSION['user']){
            $usuario = $_SESSION['user']->NOMBRE; 
            $datav = new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/Pagos/p.verPagos.php');
            ob_start();
                $pagos =$datav->verPagos();
                include 'app/views/pages/Pagos/p.verPagos.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function realizaCEP($folios){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $realiza=$datav->realizaCEP($folios);
            $this->verPagos();
        }
    }

    function realizaNCBonificacion($docf, $monto, $concepto, $obs, $caja){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $ncBon=$datav->realizaNCBonificacion($docf, $monto, $concepto, $obs, $caja);
            return;
        }
    }

    function conteoCopias($docf){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $res=$datav->conteoCopias($docf);
            return $res;
        }
    }

    function copiaFP($docf){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $res=$datav->copiaFP($docf);
            return $res;
        }
    }

    function cajaNC($idc){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $res=$datav->cajaNC($idc);
            return $res;
        }
    }

    function verNCC($serie){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $info=$datav->verNCC($serie);
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/Facturacion/p.verNCC.php');
            ob_start();
                $pagos =$datav->verNCC($serie);
                include 'app/views/pages/Facturacion/p.verNCC.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function aplicaNC($docn){
        if($_SESSION['user']){
            $datav= new pegaso_ventas;
            $res=$datav->aplicaNC($docn);
            return $res;
        }
    }

    function verPartidas($idc){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/Facturacion/p.verPartidas.php');
            ob_start();
                $par=$datav->verPartidas($idc);
                $Cabecera=$datav->verCabecera($idc);
                include 'app/views/pages/Facturacion/p.verPartidas.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function anexoDescr($tipo, $idc, $par, $descr){
        $datav=new pegaso_ventas;
        $res=$datav->anexoDescr($tipo, $idc, $par, $descr);
        return $res;
    }

    function repVentas($tipo, $clie, $inicio, $fin){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.repVentas.php');
            ob_start();
                $info=$datav->repVentas($tipo, $clie, $inicio, $fin);
                include 'app/views/pages/ventas/p.repVentas.php';
                $table = ob_get_clean();
                $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
                $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }

    function cargaSae($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo){
        if($_SESSION['user']){
            $datav = new pegaso_ventas;
            $ins=$datav->cargaSae($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo);
            return $ins;
        }
    }

}
?>