<?php
session_cache_limiter('private_no_expire');
//require_once('app/model/pegaso.model.php');

$arr = array('prueba1', 'trata2', 'intento3', 'prueba4', 'prueba5');

echo json_encode($arr);
exit;

?>