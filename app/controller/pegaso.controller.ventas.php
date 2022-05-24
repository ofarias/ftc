<?php

////session_cache_limiter('private_no_expire');
require_once('app/model/pegaso.model.php');
require_once('app/model/pegaso.model.coi.php');
require_once('app/model/pegaso.model.ventas.php');
require_once('app/model/imi.php');
require_once('app/fpdf/fpdf.php');
require_once('app/views/unit/commonts/numbertoletter.php');
require 'app/Classes/pos/autoload.php';
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class pegaso_controller_ventas{

	var $contexto = "http://ofa.dyndns.org:8888/ftc/app/";
	
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
        if (isset($_SESSION['user'])){
            $data = new pegaso;
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.cerrarventana.php');
            $exec = $data->reenviaCaja($factura,$caja);
            include 'app/views/pages/p.cerrarventana.php';
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
    }

    function CerrarVentana2(){
        if (isset($_SESSION['user'])){
            $data = new pegaso;
            $pagina=$this->load_template('Pedidos');
            $html = $this->load_page('app/views/pages/p.cerrarventana.php');
            include 'app/views/pages/p.cerrarventana.php';
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
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            ob_start();
            $smb = $datav->parCotSMB($folio,$partida, $por2);
            $cliente = '';
            $articulo = '';
            $descripcion = '';
            $this->CerrarVentana2();
        }
    }

    function verSMB(){
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

    function repVenta($op1, $op2, $op3, $op4, $op5, $op6, $op7){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $datos=$datav->repVenta($op1, $op2, $op3, $op4, $op5, $op6, $op7);
            if($op1= 'Excel'){
                $res=$this->repVentaXLS($datos['datos'], $op4, $op5, $op2);
                return $res;
            }
            return $datos;
        }
    }

    function repVentaXLS($datos, $op4, $op5, $op2){
            $xls= new PHPExcel();
            $data= new pegaso; 
            $df= $data->traeDF($idem = 1);
            $usuario =$_SESSION['user']->NOMBRE;
            $fecha = date('d-m-Y h:i:s');
            $ln = 11; $i = 0; $t=0; $s=0;
            foreach ($datos as $key) {
                $col = 'A';
                $i++;
                $t += $key->TOTAL;
                $s += $key->SALDO_FINAL;
                $xls->setActiveSheetIndex()
                    ->setCellValue($col.$ln,$key->DOCUMENTO)
                    ->setCellValue(++$col.$ln,$key->FECHA_DOC)
                    ->setCellValue(++$col.$ln,$key->NOMBRE)
                ;
                if($op2 == 'Detallado'){
                    $xls->setActiveSheetIndex()
                        ->setCellValue(++$col.$ln,$key->UM)
                        ->setCellValue(++$col.$ln,$key->ARTICULO)
                        ->setCellValue(++$col.$ln,$key->DESCRIPCION)
                        ->setCellValue(++$col.$ln,$key->CANTIDAD)
                        ->setCellValue(++$col.$ln,$key->PRECIO)
                        ->setCellValue(++$col.$ln,$key->DESCUENTO)
                        ->setCellValue(++$col.$ln,$key->SUBTOTAL_P)
                        ->setCellValue(++$col.$ln,($key->IMP1/100) * $key->PRECIO)
                        ->setCellValue(++$col.$ln,$key->IMP2)
                        ->setCellValue(++$col.$ln,$key->IMP3)
                        ->setCellValue(++$col.$ln,$key->TOTAL_P)
                        ->setCellValue(++$col.$ln,$key->CLAVE_SAT)
                        ->setCellValue(++$col.$ln,$key->MEDIDA_SAT)

                    ;
                }else{
                    $xls->setActiveSheetIndex()
                        ->setCellValue(++$col.$ln,$key->SUBTOTAL)
                        ->setCellValue(++$col.$ln,$key->IVA)
                        ->setCellValue(++$col.$ln,$key->TOTAL)
                        ->setCellValue(++$col.$ln,$key->SALDO_FINAL)
                    ;
                }

                $xls->setActiveSheetIndex()
                    ->setCellValue(++$col.$ln,$key->USO_CFDI)
                    ->setCellValue(++$col.$ln,$key->FORMADEPAGOSAT)//number_format($key->SUBTOTAL,2,".",""))
                    ->setCellValue(++$col.$ln,$key->METODO_PAGO)//number_format($key->IVA,2,".",""))
                    ->setCellValue(++$col.$ln,$key->MONEDA)//number_format($key->IVA_RET,2,".",""))
                    ->setCellValue(++$col.$ln,$key->TIPO_CAMBIO)
                    ->setCellValue(++$col.$ln,$key->USUARIO)//number_format($key->IEPS,2,".",""))
                    ->setCellValue(++$col.$ln,$key->UUID)
                    ->setCellValue(++$col.$ln,$key->STATUS)
                ;
                $ln++;
            }
            $ln++;
            $xls->setActiveSheetIndex()
                ->setCellValue('A'.$ln,'Fin del resumen de los documentos.');
    
            $xls->getActiveSheet()
                ->setCellValue('A1',$df->RAZON_SOCIAL)
            ;
            /// CAMBIANDO EL TAMAÑO DE LA LINEA.
            $col= 'A';
            $xls->getActiveSheet()->getColumnDimension($col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(20);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(40);

            
                $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
                $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
                $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);
                $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(15);


            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(30);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(40);
            $xls->getActiveSheet()->getColumnDimension(++$col)->setWidth(10);
            
            // Hacer las cabeceras de las lineas;
            //->setCellValue('9','')
            $col = 'A';
            $xls->getActiveSheet()
                ->setCellValue($col.'10','Documento')
                ->setCellValue(++$col.'10','Fecha')
                ->setCellValue(++$col.'10','Nombre')
            ;
            if($op2 == 'Detallado'){
                $xls->getActiveSheet()
                    ->setCellValue(++$col.'10','UM')
                    ->setCellValue(++$col.'10','Articulo')
                    ->setCellValue(++$col.'10','Descripcion')
                    ->setCellValue(++$col.'10','Cantidad')
                    ->setCellValue(++$col.'10','Precio')
                    ->setCellValue(++$col.'10','Descuento')
                    ->setCellValue(++$col.'10','Sub Total')
                    ->setCellValue(++$col.'10','IVA')
                    ->setCellValue(++$col.'10','IVA RET')
                    ->setCellValue(++$col.'10','IEPS')
                    ->setCellValue(++$col.'10','Total')
                    ->setCellValue(++$col.'10','Clave SAT')
                    ->setCellValue(++$col.'10','Unidad SAT')
                ;
            }

            $xls->getActiveSheet()
                ->setCellValue(++$col.'10','Uso CFDI')
                ->setCellValue(++$col.'10','Forma Pago')
                ->setCellValue(++$col.'10','Metodo Pago')
                ->setCellValue(++$col.'10','Moneda')
                ->setCellValue(++$col.'10','TC')
                ->setCellValue(++$col.'10','Usuario')
                ->setCellValue(++$col.'10','UUID')
                ->setCellValue(++$col.'10','STATUS')
            ;

            $xls->getActiveSheet()
                ->setCellValue('A3','Resumen de Documentos')
                ->setCellValue('A4','Fecha de Emision del Reporte: ')
                ->setCellValue('A5','Fecha Incial: ')
                ->setCellValue('A6','Fecha Final: ')
                ->setCellValue('A7','Total Facturado: ')
                ->setCellValue('A8','Total Saldo: ')
                ->setCellValue('A9','Usuario Elabora')
                
                ;
            $xls->getActiveSheet()
                ->setCellValue('D3','')
                ->setCellValue('D4',$fecha)
                ->setCellValue('D5',$op4)
                ->setCellValue('D6',$op5)
                ->setCellValue('D7','$ '.number_format($t,2))
                ->setCellValue('D8','$ '.number_format($s,2))
                ->setCellValue('D9',$usuario)
                
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
            //Nombre de la hoja
            $xls->getActiveSheet()->setTitle('Resumen de Ventas');

            $xls->getActiveSheet()->getStyle('I10:I102')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $xls->getActiveSheet()->mergeCells('A3:F3');
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
            if(!file_exists($ruta)){
                mkdir($ruta);
            }
            $nom='Detalle de Documentos de '.$df->RAZON_SOCIAL." ".date("d-m-Y H-i-s").'.xlsx';
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
            return array("status"=>'ok', "datos"=>$datos,"archivo"=>$nom);
    }

    function cargaSae($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo){
        if($_SESSION['user']){
            $datav = new pegaso_ventas;
            $dataimi = new imi;
            $ins=$datav->cargaSae($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo);
            $ins=$dataimi->cargaSaeImi($doc, $folio, $serie, $uuid, $ruta, $rfcr, $tipo);
            return $ins;
        }
    }

    function ventasMostrador($doc, $idf){
        if($_SESSION['user']){
            $datav=new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.ventasMostrador.php');
            ob_start();
            $partidas=array();
            if($doc<>'0'){
                $cabecera=$datav->nvCabecera($doc);
                foreach ($cabecera as $s) {
                    $idf = $s->IDF;
                }
                $partidas=$datav->nvPartidas($doc);
            }
            include 'app/views/pages/ventas/p.ventasMostrador.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }

    function prodVM($b){
        $datav=new pegaso_ventas;
        $prod=$datav->prodVM($b);
        return $prod;
    }

    function clieVM($b){
        $datav=new pegaso_ventas;
        $cliente=$datav->clieVM($b);
        return $cliente;
    }

    function docNV($clie, $prod, $cant, $prec, $desc, $iva, $ieps, $descf, $doc, $idf, $add){
        $datav=new pegaso_ventas;
        $insPar=$datav->docNV($clie, $prod, $cant, $prec, $desc, $iva, $ieps, $descf, $doc, $idf, $add);
        return $insPar;
    }

    function dropP($doc, $idf , $p){
        $datav=new pegaso_ventas;
        $par=$datav->dropP($doc, $idf , $p);
        return $par;   
    }

    function cancelaNV($doc){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $cancelar = $data->cancelaNV($doc);
            return $cancelar;
        }
    }

    function cambioCliente($clie, $doc){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $cambio = $data->cambioCliente($clie, $doc);
            return $cambio;
        }
    }

    function pagaNV($tcc,$tcd,$efe,$tef,$val,$cupon,$cr,$doc, $cambio){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $paga = $data->pagaNV($tcc,$tcd,$efe,$tef,$val,$cupon,$cr,$doc, $cambio);
            $this->impresionTicket($doc, $cambio);
            return $paga;
        }
    }

    function impNV($nv, $d){
        $data= new pegaso_ventas;
        //$qr= new qrpegaso;  
        $dataDF = new pegaso;
        $letras=new NumberToLetterConverter;
        $usuario=$_SESSION['user']->NOMBRE;
        $DF=$dataDF->traeDF($ide= 1);
        $Cabecera=$data->cabeceraN_V($nv);/// traemos la nota de venta 
        //$fiscal=$data->infoFiscal($factura);
        $Detalle=$data->detalleNV($nv);
        //$cancelaciones = $data->traeCancelaciones($factura);
        $tipo=3;
        //$genqr=$qr->QRFactura($Cabecera, $fiscal);
        $pdf=new FPDF('P','mm','Letter');
        $pdf->AddPage();
        $pdf->Image('app/views/images/logos/'.$_SESSION['empresa']['logo'],5,1, 60, 30);
        

        $pdf->SetFont('Courier','B', 6);
        $pdf->SetXY(75, 1);
        $pdf->Write(10,$DF->RAZON_SOCIAL);
        $pdf->SetXY(75, 5);
        $pdf->Write(10,'Domicilio Fiscal: '.$DF->CALLE.', '.$DF->EXTERNO.', '.$DF->INTERNO);
        $pdf->SetXY(75, 9);
        $pdf->Write(10,'Col:'.$DF->COLONIA.', CP: '.$DF->CP);
        $pdf->SetXY(75, 13);
        $pdf->Write(10, $DF->DELEGACION.', '.$DF->ESTADO);
        $pdf->SetXY(75, 17);
        $pdf->Write(10,'RFC:'.$DF->RFC.'Regimen Fiscal:'.$DF->REGIMEN_FISCAL);
        $pdf->SetXY(75, 21);
        
        $pdf->SetFont('Courier','B',10);
        $pdf->SetXY(140, 5);
        $pdf->Write(10,'Nota de Venta');
        $pdf->SetXY(140, 10);
        $pdf->Write(10,$nv);

        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(50);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetXY(50, 30);
        $pdf->Write(6, ''); // Control de impresiones.
        $pdf->Ln(8);
        foreach ($Cabecera as $data){
            $pedido = $data->PEDIDO_CLIENTE;
            $documento = $data->DOCUMENTO;
            $maestro= isset($data->MAESTRO)? $data->MAESTRO:'';
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Write(6,'Usuario Imprime: '.$usuario);
        $pdf->Ln(4);
        $pdf->Write(6,'Cliente : ('.$data->CLAVE.')'.utf8_decode($data->NOMBRE).' RFC: '.$data->RFC);
        $pdf->Ln(4);
        $pdf->Write(6,utf8_decode('Dirección: Calle :').$data->CALLE_F.', Num Ext:'.$data->EXTERIOR_F.', Num Int:'.$data->INTERIOR_F);
        $pdf->Ln(4);
        $direccionCompleta=utf8_decode('Dirección: Calle :').$data->CALLE_F.', Num Ext:'.$data->EXTERIOR_F.', Num Int:'.$data->INTERIOR_F;
        //if()
        //$pdf->Write(6,'Calle (continuacion):'.$data->CALLE_F.', Num Ext:'.$data->EXTERIOR_F.', Num Int:'.$data->INTERIOR_F);
        $pdf->Write(6,'Colonia: '.$data->COLONIA_F.' Estado: '.$data->ESTADO_F);
        $pdf->Ln(4);
        $pdf->Write(6,utf8_decode('Código Postal: ').$data->CP_F.' Pais: '.$data->PAIS_F);
        $pdf->Ln(4);
        $pdf->Write(6,'Pedido Cliente:'.$data->PEDIDO_CLIENTE.' -- Pedido: '.$data->COTIZACION.'-- Prefactura: PF'.$data->CAJAF);
        $pdf->Ln(10);
        if(!empty($data->CALLE_E)){
            $pdf->Write(6,'DIRECCION DE ENVIO:');
            $pdf->Ln(4);
            $pdf->Write(6,'Direccion Envio Calle :'.$data->CALLE_E.', Num Ext:'.$data->EXTERIOR_E.', Num Int:'.$data->INTERIOR_E);
            $pdf->Ln(4);
            $pdf->Write(6,'Colonia: '.$data->COLONIA_E.' Estado: '.$data->ESTADO_E);
            $pdf->Ln(6);
            $pdf->Write(6,'Codigo Postal: '.$data->CP_E.', Pais: '.$data->PAIS_F);
            $pdf->Ln(6);
        }
        if(!empty($data->OBSERVACION)){
            $pdf->Write(6,'Observaciones del cliente:'.substr($data->OBSERVACION,0,65));
            $pdf->Ln(4);
            $pdf->Write(6, substr($data->OBSERVACION, 81, 150));
                if(substr($tipoDoc,0,1)!= 'N'){
                    $pdf->Ln(4);
                    $pdf->Write(6, substr($data->OBSERVACIONES,0, 65));
                    $pdf->Ln(4);
                    $pdf->Write(6, 'Banco y Cuenta de Deposito: '.$data->BANCO_PEGASO);
                    $pdf->Ln(4);
                    $pdf->Write(6, 'Banco y Cuenta Origen: '.$data->BANCO_EMISOR.' / '.$data->CTA_EMISORA);
                    $pdf->Ln(6);    
                }
            }
        }
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(6,6,"Part.",1);
        $pdf->Cell(13,6,"Art.",1);
        $pdf->Cell(13,6,"Clave SAT",1);
        $pdf->Cell(13,6,"Unidad SAT",1);
        $pdf->Cell(60,6,"Descripcion",1);
        $pdf->Cell(8,6,"Cant",1);
        $pdf->Cell(10,6,"UM",1);
        $pdf->Cell(13,6,"Precio",1);
        $pdf->Cell(13,6,"Descuento",1);
        $pdf->Cell(15,6,"Subtotal ",1);
        $pdf->Cell(15,6,"Iva",1);
        $pdf->Cell(15,6,"Total",1);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 6);
            $descuento = 0;
            $subtotal = 0;
            $iva = 0;
            $total = 0;
            $partida= 0;
            $descTot=0;
            $PARTIDA=0;
            $totalImp1=0;
        foreach($Detalle as $row){
            if($row->CANTIDAD > 0){
            $PARTIDA++;
            $descpor=number_format((($row->DESC1/($row->PRECIO * $row->CANTIDAD)) *100),2,".","");
            $descuni = $row->PRECIO * ($descpor * 0.0100);
            $subtotal += ($row->PRECIO * $row->CANTIDAD);
            $descTot += ($descuni*$row->CANTIDAD);
            $iva += ($row->IMP1);
            $totalImp1 +=$iva;
            $total += (($row->PRECIO * $row->CANTIDAD)-$row->DESC1)+$row->IMP1;
            $desp = 0;
            $m = $total;
            $Monto=number_format($m,0);
            $M1=number_format($m,2);
            $M4=substr($M1,0,-2);
            $centavos=substr($M1,-2);
            $m5= $M4.'00';
            $res=$letras->to_word($m5);   
            $descr=strlen($row->DESCRIPCION); 
            
                if ($centavos == 00){
                    $leyenda = 'PESOS CON 00/100 MN';
                }else{
                    $leyenda = 'PESOS CON '.$centavos.'/100 MN';
                }
            $pdf->Cell(6,6,($PARTIDA),'L,T,R');
            $pdf->Cell(13,6,(substr($row->ARTICULO,0,8)),'L,T,R');
            $pdf->Cell(13,6,($row->CLAVE_SAT),'L,T,R');
            $pdf->Cell(13,6,($row->MEDIDA_SAT),'L,T,R',0, 'C');
            $pdf->Cell(60,6,substr(utf8_decode($row->DESCRIPCION), 0,45), 'L,T,R');
            $pdf->Cell(8,6,number_format($row->CANTIDAD,0),'L,T,R');
            $pdf->Cell(10,6,$row->UM,'L,T,R',0, 'C');
            $pdf->Cell(13,6,'$ '.number_format($row->PRECIO,2),'L,T,R',0, 'R');
            $pdf->Cell(13,6,'% '.number_format($descpor,2),'L,T,R',0,'R');
            $pdf->Cell(15,6,'$ '.number_format(($row->PRECIO * $row->CANTIDAD)-$row->DESC1,2),'L,T,R',0, 'R');
            $pdf->Cell(15,6,'$ '.number_format($row->IMP1,2),'L,T,R',0, 'R');
            $pdf->Cell(15,6,'$ '.number_format((($row->PRECIO * $row->CANTIDAD)-($row->DESC1))+ $row->IMP1,2),'L,T,R',0, 'R');
            
            if($descr > 95){
                $pdf->Ln(4);                
                $pdf->Cell(6,6,"",'L,R');
                $pdf->SetFont('Arial', 'I', 5);
                $pdf->Cell(13,6,'('.substr($row->DESCCVE,0,20).')','L');
                $pdf->Cell(13,6,"",'R');
                $pdf->SetFont('Arial', 'I', 6);
                $pdf->Cell(13,6,substr($row->DESCUNI,0),'L,R');
                $pdf->Cell(60,6,substr(utf8_decode($row->DESCRIPCION), 45,55),'L,R');
                //$pdf->Cell(8,6,strlen(utf8_decode($row->DESCRIPCION), 56,95),'L,R');
                $pdf->Cell(8,6,'','L,R');
                $pdf->Cell(10,6,"",'L,R');
                $pdf->Cell(13,6,"",'L,R');
                $pdf->Cell(13,6,'$ '.number_format(($descuni),2),'L,R',0, 'R');
                $pdf->Cell(15,6,"",'L,R');
                $pdf->Cell(15,6,"",'L,R');
                $pdf->Cell(15,6,"",'L,R');
            }else{
                $pdf->Ln(4);                
                $pdf->Cell(6,6,"",'L,B,R');
                $pdf->SetFont('Arial', 'I', 5);
                $pdf->Cell(13,6,'('.substr($row->DESCCVE,0,20).')','L,B');
                $pdf->Cell(13,6,"",'B,R');
                $pdf->SetFont('Arial', 'I', 6);
                $pdf->Cell(13,6,substr($row->DESCUNI,0),'L,B,R');
                $pdf->Cell(60,6,substr(utf8_decode($row->DESCRIPCION), 45,55),'L,R,B');
                $pdf->Cell(8,6,"",'L,B,R');
                $pdf->Cell(10,6,"",'L,B,R');
                $pdf->Cell(13,6,"",'L,B,R');
                $pdf->Cell(13,6,'$ '.number_format(($descuni),2),'L,B,R',0, 'R');
                $pdf->Cell(15,6,"",'L,B,R');
                $pdf->Cell(15,6,"",'L,B,R');
                $pdf->Cell(15,6,"",'L,B,R');
            }
            $di=100;
                while($descr > 65 and $di <= $descr){
                    $di=$di;
                    $df=$di+20;
                    if($df <= $descr){
                        $pdf->Ln(4);                
                        $pdf->Cell(6,6,"",'L,R');
                        $pdf->SetFont('Arial', 'I', 5);
                        $pdf->Cell(13,6,"",'L,R');
                        $pdf->Cell(13,6,"",'L,R');
                        $pdf->SetFont('Arial', 'I', 6);
                        $pdf->Cell(13,6,"",'L,R');
                        $pdf->Cell(60,6,substr(utf8_decode($row->DESCRIPCION), $di,55),'L,R');
                        $pdf->Cell(8,6,"",'L,R');
                        $pdf->Cell(10,6,"",'L,R');
                        $pdf->Cell(13,6,"",'L,R');
                        $pdf->Cell(13,6,"",'L,R');
                        $pdf->Cell(15,6,"",'L,R');
                        $pdf->Cell(15,6,"",'L,R');
                        $pdf->Cell(15,6,"",'L,R');
                    }else{
                        $pdf->Ln(4);                
                        $pdf->Cell(6,6,"",'L,B,R');
                        $pdf->SetFont('Arial', 'I', 5);
                        $pdf->Cell(13,6,"",'L,B,R');
                        $pdf->Cell(13,6,"",'L,B,R');
                        $pdf->SetFont('Arial', 'I', 6);
                        $pdf->Cell(13,6,"",'L,B,R');
                        $pdf->Cell(60,6,substr(utf8_decode($row->DESCRIPCION), $di,55),'L,B,R');
                        $pdf->Cell(8,6,"" ,'L,B,R');
                        $pdf->Cell(10,6,"",'L,B,R');
                        $pdf->Cell(13,6,"",'L,B,R');
                        $pdf->Cell(13,6,"",'L,B,R');
                        $pdf->Cell(15,6,"",'L,B,R');
                        $pdf->Cell(15,6,"",'L,B,R');
                        $pdf->Cell(15,6,"",'L,B,R');
                    }           
                    $di = $di +20;
                    //$pdf->Ln();       
                }
            $pdf->Ln();
            }
        }
            $pdf->Cell(6,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(25,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(63,6,"",0);
            $pdf->Cell(15,6,"",0);
            $pdf->Cell(8,6,"",0);

            $pdf->Cell(15,6,"SubTotal",1);
            $pdf->Cell(15,6,'$ '.number_format($subtotal,2),1,0, 'R');
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Ln();
            $pdf->Cell(6,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(122,6,$res.$leyenda,0,0,'C');
            $pdf->Cell(15,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(15,6,"Descuento",1);
            $pdf->Cell(15,6,'$ '.number_format($descTot,2),1,0, 'R');
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Ln();
            $pdf->Cell(6,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(25,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(63,6,"",0);
            $pdf->Cell(15,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(15,6,"IVA",1);
            $pdf->Cell(15,6,'$ '.number_format($totalImp1,2),1,0, 'R');
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Ln();
            $pdf->Cell(6,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(25,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(63,6,"",0);
            $pdf->Cell(15,6,"",0);
            $pdf->Cell(8,6,"",0);
            $pdf->Cell(15,6,"Total",1);
            $pdf->Cell(15,6,'$ '.number_format($total,2),1,0, 'R');
            $pdf->Cell(13,6,"",0);
            $pdf->Cell(20,6,"",0);
            $pdf->Ln(3);
            //$pdf->Image($genqr);
            //$pdf->SetXY(10, 220);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','',6);
            //$pdf->Write(4,'POR ESTE PAGARE DEBEMOS Y PAGAREMOS INCONDICIONALMENTE A LA ORDEN DE '.$DF->RAZON_SOCIAL.' LA CANTIDAD DE $ '.number_format(($subtotal-$descTot)+$iva,2).', ESTA FACTURA CAUSARA INTERESES MORATORIOS DEL 3.5 % MENSUAL, SOBRE EL VALOR TOTAL DE LA MISMA AL NO SER PAGADA A LOS 30 DIAS DE RECEPCION DE ESTE DOCUMENTO');
            $pdf->Ln(6);
            $pdf->Write(4, 'RECIBI DE CONFORMIDAD LOS PRODUCTOS QUE AMPARA LA PRESENTE NOTA DE VENTA');
            $pdf->Ln(6);
            $pdf->Write(4,'Nombre _______________________________________  Cargo: _______________________________________  Firma: ______________________________'); 
            $pdf->Ln(6);
            $pdf->Write(4,utf8_decode('Los datos personales obtenidos en este documento tienen por finalidad dar cumplimiento a las disposiciones establecidas por la Ley Federal de Protección de Datos Personales en Posesión de los Particulares'));
            $pdf->Ln(6);
            $pdf->SetFont('Arial','',5);
            //$pdf->Write(6,'Este documento es una representacion impresa de un CFDI');
            //$pdf->Ln(3);
            //$pdf->Write(6,'Sello digital del CFDI:');
            //$pdf->Ln(6);
            //$pdf->MultiCell(0,3,$selloSAT,1,'j');
            //$pdf->Ln(0);
            //$pdf->Write(6,'Cadena Original del complemento de certificacion digital del SAT:');
            //$pdf->Ln(6);
            //$pdf->MultiCell(0,3,$cadenaSat,1);
            //$pdf->Ln(0);
            //$pdf->Write(6,'Sello digital del SAT:');
            //$pdf->Ln(6);
            //$pdf->MultiCell(0,3,$selloCFD,1,'j');
            $pdf->SetTextColor(255,0,0);
            $pdf->Write(6,'Favor de confirmar con el Cliente la entrega de su pedido. ('.$pedido.')');
            $pdf->Ln(3);
            $pdf->Write(6,'Si tiene algun comentario o duda favor de comunicarse a '.$DF->RAZON_SOCIAL.' por los siguientes medios:');
            $pdf->Ln(3);
            $pdf->Write(6,'Con: '.$usuario);
            $pdf->Ln(3);
            $pdf->Write(6,'Telefonos :55 55 73 38 34 o por Correo a: libreriamedicahorus@gmail.com');
            $pdf->Ln(3);
            $pdf->Write(6,'Linea de Atencion a Quejas: 55 55 73 38 34');
            $pdf->Ln(5);
            $pdf->SetFont('Arial','',14);
            //// informacion de la rerfacturacion de pegaso.
            ob_get_clean();

        $ruta='C:\\xampp\\htdocs\\notas de venta\\';
        if(!file_exists($ruta)){
            mkdir($ruta, 0777,true);
        }
        if($d == 'd'){
            $pdf->Output( $nv.'.pdf',$d );
            $this->ImprimeFacturaPegaso($nv, $d='f');    
        }elseif($d ==  'f'){
            $pdf->Output( 'C:\\xampp\\htdocs\\notas de venta\\'.$nv.'.pdf',$d );
        }
        return array("status"=>'ok');
    }

    function impresionTicket($doc, $cambio){
        if($_SESSION['user']){
            //$contexto = "http://ofa.dyndns.org:8888/ftc/app/";
            $contexto = "http://ofa.dyndns.org:8081/ftc/app/";
            $datav = new pegaso_ventas;
            $cabecera=$datav->nvCabecera($doc);
            $partidas=$datav->nvPartidas($doc);
            $aplicaciones = $datav->traeAplicaciones($doc, $cambio);
            //echo "<script>window.open('".$this->contexto."reports/ticket_am.php', '_blank');</script>";
            $this->impresionPOS($doc, $cabecera, $partidas, $aplicaciones);
            return ($cabecera);        
        }
    }

    function impresionPOS($doc, $cabecera, $partidas, $aplicaciones){
        $data = new pegaso;
        $pagina = "http://www.sat2app.com";
        $telefono ="55- 5055-3392";
        $empresa = $data->traeDF($ide=1);
        /*
            Este ejemplo imprime un hola mundo en una impresora de tickets
            en Windows.
            La impresora debe estar instalada como genérica y debe estar
            compartida
        */
        /*
            Conectamos con la impresora
        */
        /*
            Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
            escribe el nombre de la tuya. Recuerda que debes compartirla
            desde el panel de control
        */
        //$nombre_impresora = "TM-T88V";
        $nombre_impresora = "ECLine";
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        /*
            Imprimimos un mensaje. Podemos usar
            el salto de línea o llamar muchas
            veces a $printer->text()
        */
        # Vamos a alinear al centro lo próximo que imprimamos
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($empresa->RAZON_SOCIAL."\n".$empresa->NOM_COMERCIAL."\n".$empresa->RFC."\n REGIMEN FISCAL:".$empresa->REGIMEN_FISCAL."\n ExpediciÓn: ".$empresa->LUGAR_EXPEDICION);
        /*
            Hacemos que el papel salga. Es como 
            dejar muchos saltos de línea sin escribir nada
        */
        $printer->feed(); 
        /*
            Intentaremos cargar e imprimir
            el logo
        */
        try{
            $logo = EscposImage::load("app/views/images/Logos/LogoFTC.jpg", false);
            $printer->bitImage($logo);
        }catch(Exception $e){/*No hacemos nada si hay error*/}
        /*
            Ahora vamos a imprimir un encabezado
        */
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $linea = str_pad("\n", 43, "-", STR_PAD_LEFT);
        foreach ($cabecera as $c) {
            $vendedor = substr($c->VENDEDOR, 0, 20);
            switch ($c->STATUS) {
                case 'P':
                    $status="Esta Nota esta: PENDIENTE\n";
                    break;
                case 'C':
                    $status="Esta Nota esta: CANCELADA\n";
                    break;
                case 'E':
                    $status="Esta Nota esta: PAGADA\n";
                    break;
                case 'F':
                    $status="Esta Nota esta: FACTURADA\n";
                    break;
                default:
                    break;
            }
                $printer->text($linea);
                $printer->text($status);
                $printer->text($linea);   

            $printer->text("Cliente: " . $c->NOMBRE."\n");
            $printer->text("Direccion: " . $c->CALLE." No. ".$c->NUMEXT.", ".$c->NUMINT."\n");
            $printer->text("Colonia: ".$c->COLONIA." C.P.: ".$c->CODIGO."\n");
            $printer->text("Municipio: ".$c->MUNICIPIO."\n");
            $printer->text("Estado: ".$c->ESTADO." Pais: ".$c->PAIS."\n");
        } 
        #La fecha también
        $printer->text($linea);
        $printer->text("Nota No: ".$doc." Vendedor: ".$vendedor."\n");
        $printer->text("Fecha Nota: ".$c->FECHA_DOC."\n");
        $printer->text("Elabora: ".$c->USUARIO."\n");
        $printer->text($linea);
        //$printer->feed(); 
        /*Alinear a la izquierda para la cantidad y el nombre*/
        //$printer->setJustification(Printer::JUSTIFY_LEFT);
        /*
            Ahora vamos a imprimir los
            productos
        */
        $printer->text("Ln   Articulo   "."      Cantidad   "." Unitario"."\n");
        $printer->setFont(Printer::FONT_B);
        $printer->text("SKU   "."   UPC   "."           Unidad          SAT"."\n");
        $printer->setFont(Printer::FONT_A);
        $printer->text($linea);
        //$printer->feed();
        foreach ($partidas as $p){
            $printer->setFont(Printer::FONT_A);
            $des=substr($p->DESCRIPCION,0,20);
            $des = str_pad($des, 20, " ");
            $cant = str_pad($p->CANTIDAD, 5," ",STR_PAD_LEFT );
            $precio = str_pad("$ ".number_format($p->SUBTOTAL,2), 11," ",STR_PAD_LEFT);
            $printer->text($p->PARTIDA."  ".$des."  ".$cant."".$precio."\n");
            $printer->setFont(Printer::FONT_B);
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            if($p->CANTIDAD > 1 ){
                $printer->text($p->CANTIDAD." X $ ".number_format($p->PRECIO,2)."\n");
            }
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $sku = str_pad($p->ARTICULO,5," ");
            $upc = str_pad($p->SKU,20," ");
            $um = str_pad($p->UM,10, " ");
            $sat = str_pad($p->CLAVE_SAT." ".$p->MEDIDA_SAT, 15, " "); 
            $printer->text($sku." ".$upc." ".$um." ".$sat."\n");

        }
        $printer->setFont(Printer::FONT_A);

        #### Totales ####
        $printer->text($linea);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("SUBTOTAL: $".number_format($c->SUBTOTAL,2)."\n");
        $printer->text("IVA: $".number_format($c->IVA,2)."\n");
        if($c->DESCF >0){
            $printer->text("DESCUENTO FINANCIERO: $".number_format($c->DESCF,2)."\n");
        }
        if( ($c->DESC1 + $c->DESC2) > 0 ){
            $printer->text("DESCUENTO: $".number_format($c->DESC1 + $c->DESC2,2)."\n");
        }
        $printer->text("TOTAL: $".number_format($c->TOTAL,2)."\n");
        $printer->text($linea);

        #### formas de pago ####

        if(count($aplicaciones)){
            foreach ($aplicaciones as $pg){
                switch ($pg->FORMA_PAGO){
                    case 'TCC':
                        $tipo = 'Tarjeta de Credito: ';
                        break;
                    case 'TCD':
                        $tipo = 'Tarjeta de Debito: ';
                        break;
                    case 'EFE':
                        $tipo = 'Efectivo: ';
                        break;
                    case 'TEF':
                        $tipo = 'Transferencia electrónica: ';
                        break;
                    case 'VAL':
                        $tipo = 'Vales: ';
                        break;
                    case 'CUPON':
                        $tipo = 'Cupones: ';
                        break;
                default:
                    break;
                }
                if($pg->FORMA_PAGO != 'EFE'){ 
                    $printer->text($tipo.' $ '.number_format($pg->MONTO_APLICADO)."\n");
                }elseif($pg->CAMBIO > 0 ){
                    $printer->text($tipo.' $ '.number_format($pg->MONTO_APLICADO + $pg->CAMBIO)."\n");
                    $printer->text('Cambio: '.' $ '.number_format($pg->CAMBIO)."\n");
                }else{
                    $printer->text($tipo.' $ '.number_format($pg->MONTO_APLICADO)."\n");
                }
            }
        }

        #### Finaliza las formas de pago ####


        $printer->text($linea);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Fecha de Impresión: ".date("Y-m-d H:i:s") . "\n");
        $printer->text("GRACIAS POR SU COMPRA. VUELVA PRONTO...\n");
        $printer->text("DISFRUTE SU PRODUCTO!!!!\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        $printer->text("Telefono: ".$telefono."\n");
        $printer->text("Visitenos en ".$pagina." para conocer nuestro aviso de privacidad\n");
        $printer->feed();
        /*Y a la derecha para el importe*/
        //$printer->setJustification(Printer::JUSTIFY_RIGHT);
        /* 
            Tipos de Letras
            $fonts = array(Printer::FONT_A, Printer::FONT_B, Printer::FONT_C);
            for ($i = 0; $i < count($fonts); $i++) {
                $printer->setFont($fonts[$i]);
                $printer->text("The quick brown fox jumps over the lazy dog\n");
            }
        */

        /*
            Cortamos el papel. Si nuestra impresora
            no tiene soporte para ello, no generará
            ningún error
        */
        $printer->cut();
         
        /*
        Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
        */
        $printer->pulse();
         
        /*
            Para imprimir realmente, tenemos que "cerrar"
            la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
        */

        $printer->close();
    }

    function chgTipo($tipo, $id, $nt){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $cambio = $data->chgTipo($tipo, $id, $nt);
            return $cambio; 
        }
    }

    function verNV($p, $fi, $ff){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $pagina=$this->load_template('Pedidos');
            $html=$this->load_page('app/views/pages/ventas/p.notasdeventa.php');
            ob_start();
            $info = $data->verNV($p, $fi, $ff);
            include 'app/views/pages/ventas/p.notasdeventa.php';
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }

    function cambiaObs($lin, $doc, $obs){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $res = $data->cambiaObs($lin, $doc, $obs);
            return $res;
        }
    }

    function factNV($doc, $mp, $fp, $uso){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $factura = $data->creaFact($doc, $mp, $fp, $uso);
            $fact = new factura;
            $timbra = $fact->timbraFact($factura, null);
            $mueve = $fact->moverNCSUB($factura, $timbra);
            return array("status"=>'ok',"factura"=>$factura, "mensaje"=>'Se genero la factura: '.$factura);
        }
    }

    function copiaNV($doc){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $exec = $data->copiaNV($doc);
            return $exec;
        }
    }

    function chgEmail($cl, $correo){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $exec = $data->chgEmail($cl, $correo);
            return $exec;
        }   
    }

    function nvcl($cl){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $exec = $data->nvcl($cl);
            return $exec;
        }
    }

    function histProd($id, $per, $fi, $ff, $tipo, $isbn){
        if($_SESSION['user']){
            $data = new pegaso_ventas;
            $pagina=$this->load_template('Historia Producto');
            ob_start();
            if($tipo == 'f'){
                $html=$this->load_page('app/views/pages/ventas/p.histProd.php');
                $inf=$this->sisbn($isbn);
                $info = $inf['datos'];
                $prod = $data->productoF($isbn);
                include 'app/views/pages/ventas/p.histProd.php';
            }else{
                $html=$this->load_page('app/views/pages/ventas/p.histProd.php');
                $prod = $data->producto($id);
                $info = $data->histProd($id, $per, $fi, $ff);
                include 'app/views/pages/ventas/p.histProd.php';
            }
            $table = ob_get_clean();
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms',$table,$pagina);
            $this->view_page($pagina);
        }else{
                $e = "Favor de iniciar Sesión";
                header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }    
    }

    function cargaProd($files2upload){
        echo $files2upload; $res= array();
        if (isset($_SESSION['user'])) {            
            $data = new pegaso_ventas;
            $valid_formats = array("xls", "xlsx", "XLS", "XLSX", "txt", "TXT", "csv", "CSV");
            $max_file_size = 1024 * 1000; //1000 kb
            $target_dir="C:/xampp/htdocs/uploads/listaProductos/";
            if(!file_exists($target_dir)){
            	mkdir($target_dir, 0777, true);
            }
            $count=0;
            $respuesta=0;
            foreach ($_FILES['files']['name'] as $f => $name) {	
                $ext= pathinfo($name, PATHINFO_EXTENSION);
                if ($_FILES['files']['error'][$f] == 4) {
                    continue;
                }
                if ($_FILES['files']['error'][$f] == 0){
                    if ($_FILES['files']['size'][$f] > $max_file_size or $_FILES['files']['size'][$f] == 0){
                        $message[] = "$name es demasiado grande para subirlo.";
                        continue; // Skip large files
                    }elseif(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)){
                        $message[] = "$name no es un archivo permitido.";
                        continue; // Skip invalid file formats
                    }else{ // No error found! Move uploaded files 
                        $archivo = $target_dir.$name;
                        $ar = $name;
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir . $name)){
                        	$count++; // Number of successfully uploaded file
							$res = $data->cargaProd($archivo, $ext);
                        }	
                    }
                }
            }
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
        return $res;
    }

    function cargaImg($files2upload){
        //echo $files2upload; 
        $res= array();
        if (isset($_SESSION['user'])) {            
            $data = new pegaso_ventas;
            $valid_formats = array("jpg", "png", "gif", "webp");
            $max_file_size = 1024 * 1000; //1000 kb
            $target_dir="C:/xampp/htdocs/imagenes/books/";
            if(!file_exists($target_dir)){
            	mkdir($target_dir, 0777, true);
            }
            $count=0;
            $respuesta=0;
            foreach ($_FILES['files']['name'] as $f => $name) {	
                $ext= pathinfo($name, PATHINFO_EXTENSION);
                if ($_FILES['files']['error'][$f] == 4) {
                    continue;
                }
                if ($_FILES['files']['error'][$f] == 0){
                    if ($_FILES['files']['size'][$f] > $max_file_size or $_FILES['files']['size'][$f] == 0){
                        $message[] = "$name es demasiado grande para subirlo.";
                        continue; // Skip large files
                    }elseif(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)){
                        $message[] = "$name no es un archivo permitido.";
                        continue; // Skip invalid file formats
                    }else{ // No error found! Move uploaded files 
                        //$archivo = $target_dir.$name;
                        //$ar=$name;
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $target_dir . $name)){
                        	$count++; // Number of successfully uploaded file
							///$res = $data->cargaProd($archivo, $ext);
                        }	
                    }
                }
            }
        } else {
            $e = "Favor de Iniciar Sesión";
            header('Location: index.php?action=login&e=' . urlencode($e));
            exit;
        }
        $url="index.php?action=catalogoProductosFTC";
			echo "<SCRIPT>window.location='$url';</SCRIPT>";
			//header("Location:$url");
        return $res;
    }


    function sisbn($isbn){
        if(isset($_SESSION['user'])){
            $data = new pegaso_ventas;
            $res=$data->sisbn($isbn);
            return $res;
        }
    }
}
?>