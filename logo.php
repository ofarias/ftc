<?php 
require_once('app/model/pegaso.model.php'); //importamos el archivo de conexiÃ³n
	$ide=$_GET['ide'];
	$data = new pegaso;
	$imagen = $data->fObtenerMime($ide);
	$mime = $imagen['mime'];
	$contenido = $imagen['contenido'];
	$imagen='example.jpg';
	$src= 'data:'.$mime.';base64,'.$contenido;
	header("Content-type:$mime");
	echo "<img src=\"$src\" alt=\"\" />";
	//print $contenido; 
