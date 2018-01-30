<?php
//require_once 'app/model/database.xmlTools.php';
//require_once 'app/model/database.php';


class xml {
	function testsql(){
		$model = new databasexml();
		$rs = $model->consulta("SELECT SUM(total), DATEPART (m, fecha) as mes from dbo.ComprobanteCFDI 
	where receptorRFC = 'FPE980326GH9' AND FECHA > '01.01.2017' 
	 group by receptorRFC, 
			DATEPART (m, fecha)
		ORDER BY DATEPART (m, fecha) ASC ");
		var_dump($rs);
		die();
	}
}


