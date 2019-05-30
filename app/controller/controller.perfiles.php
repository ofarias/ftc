<?php 

	function MenuCostos(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'costos'){
			$pagina = $this->load_template('Menu Admin');			
			$html = $this->load_page('app/views/modules/m.mcostos.php');
			$pagina = $this->replace_content('/\#CONTENIDO\#/ms', $html, $pagina);
			$this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}

	/*
 		if(isset($_SESSION['user'])){
            $pagina = $this->load_template('Menu Admin');
            //$html = $this->load_page('app/views/modules/m.mad.php');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mad.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
        }else{
            $e = "Favor de Revisar sus datos";
            header('Location: index.php?action=login&e='.urlencode($e)); exit;
        }
	*/
	function MenuCobranza(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'cobranza'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mcobranza.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuVentas(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'ventas'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mventas.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuSuministros(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'suministros'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.msuministros.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuTesoreria(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'tesoreria'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mtesoreria.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuLogistica(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'logistica'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mlogistica.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuBodega(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'bodega'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mbodega.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
	function MenuEmpaque(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'empaque'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mempaque.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}
		}
	function MenuRevision(){
		if(isset($_SESSION['user']) && $_SESSION['user']->USER_ROL == 'revision'){
			$pagina = $this->load_template('Menu Admin');
            ob_start();
            $table =ob_get_clean();
            $usuario=$_SESSION['user']->NOMBRE;    
            include 'app/views/modules/m.mrevision.php';
            $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $table, $pagina);
            $this-> view_page($pagina);
		}else{
			$e = "Favor de Revisar sus datos";
			header('Location: index.php?action=login&e='.urlencode($e)); exit;
		}
	}