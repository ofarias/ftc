<?php
$tipo = null;
switch (empty($_GET['tipo']) ? null : $_GET['tipo']) {
	case 'ciec':
		$tipo = 'ciec';
		break;
	case 'fiel':
		$tipo = 'fiel';
		break;
	case 'ciecc':
	default:
		$tipo = 'ciecc';
		require dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'DescargaMasivaCfdi.php';
		$descargaCfdi = new DescargaMasivaCfdi;
		break;
	
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Descarga Masiva de CFDIs</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-brand">Descarga Masiva de CFDIs 3.1.0</span>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo ($tipo == 'ciecc') ? 'active' : '' ?>"><a href="?tipo=ciecc">CIEC con Captcha</a></li>
						<li class="<?php echo ($tipo == 'ciec') ? 'active' : '' ?>"><a href="?tipo=ciec">CIEC</a></li>
						<li class="<?php echo ($tipo == 'fiel') ? 'active' : '' ?>"><a href="?tipo=fiel">FIEL</a></li>
					</ul>
				</div>
			</div>
		</nav>

	    <div id="main">
			<div class="container-fluid">
<?php
if($tipo == 'ciec') {
	echo '<h2>Inicio de sesión con CIEC</h2>';
	require 'form-login-ciec.inc.php';
}elseif($tipo == 'fiel'){
	echo '<h2>Inicio de sesión con FIEL</h2>';
	require 'form-login-fiel.inc.php';
}else{
	echo '<h2>Inicio de sesión con CIEC/Captcha</h2>';
	require 'form-login-ciec-captcha.inc.php';	
}
?>
				<hr/>

				<h2>Descarga</h2>
				<div class="tablas-resultados">
					<div class="overlay"></div>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#recibidos" aria-controls="recibidos" role="tab" data-toggle="tab">Recibidos</a></li>
						<li role="presentation"><a href="#emitidos" aria-controls="emitidos" role="tab" data-toggle="tab">Emitidos</a></li>
					</ul>
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="recibidos">
					    	<?php require 'form-recibidos.inc.php' ?>
							<form method="POST" class="descarga-form">
								<input type="hidden" name="accion" value="descargar-recibidos" />
								<input type="hidden" name="sesion" class="sesion-ipt" />
								<div style="overflow:auto">
									<table class="table table-hover table-condensed tblexportar" id="tabla-recibidos">
										<thead>
											<tr>
												<th class="text-center">XML</th>
												<th class="text-center">Acuse</th>
												<th>Efecto</th>
												<th>Razón Social</th>
												<th>RFC</th>
												<th>Estado</th>
												<th>Folio Fiscal</th>
												<th>Emisión</th>
												<th>Total</th>
												<th>Certificación</th>
												<th>Cancelación</th>
												<th>PAC</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="text-right">
									<button class="btnExportaRecibidos btn btn-success">EXPORTAR EXCEL</button>
									<button type="submit" class="btn btn-success">Descargar seleccionados</button>
								</div>
							</form>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="emitidos">
							<?php require 'form-emitidos.inc.php' ?>
							<form method="POST" class="descarga-form">
								<input type="hidden" name="accion" value="descargar-emitidos" />
								<input type="hidden" name="sesion" class="sesion-ipt" />
								<div style="overflow:auto">
									<table class="table table-hover table-condensed tblexportar" id="tabla-emitidos">
										<thead>
											<tr>
												<th class="text-center">XML</th>
												<th class="text-center">Acuse</th>
												<th>Efecto</th>
												<th>Razón Social</th>
												<th>RFC</th>
												<th>Estado</th>
												<th>Folio Fiscal</th>
												<th>Emisión</th>
												<th>Total</th>
												<th>Certificación</th>
												<th>PAC</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="text-right">
									<button class="btnExportaEmitidos btn btn-success">EXPORTAR EXCEL</button>
									<button type="submit" class="btn btn-success">Descargar seleccionados</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/code.js"></script>



		<script type="text/javascript">
			
			$(".btnExportaRecibidos").click(function(){
				xport.toCSV('tabla-recibidos');
			});

			$(".btnExportaEmitidos").click(function(){
				xport.toCSV('tabla-emitidos');
			})


var xport = {
  _fallbacktoCSV: true,  
  toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;
    
    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls'); 
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};


		</script>


	</body>
</html>

