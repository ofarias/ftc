<?php
require_once 'app/model/database.mysql.php';
//die(entro);

class test {
	function testmysql(){
		$model = new databasemysql();
		$rs = $model->Read("SELECT * FROM testtable");
		var_dump($rs);
		die();
	}
}


