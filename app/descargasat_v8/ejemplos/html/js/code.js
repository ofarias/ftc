
function disableInputs() {
	$('#main select, #main input, #main button').attr('disabled', 'disabled');
}
function enableInputs() {
	$('#main select, #main input, #main button').removeAttr('disabled');
}

$('.login-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));

	window.sesionDM = null;
	
	disableInputs();
	$('.tablas-resultados').removeClass('listo');
	$('.tablas-resultados tbody').empty();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);
			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}
				$('.tablas-resultados').addClass('listo');
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
	});

    return false;
});

$('#recibidos-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);

	var tablaBody = $('#tabla-recibidos tbody');

	tablaBody.empty();
	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}

				var items = response.data.items;
				var html = '';

				for(var i in items) {
					var item = items[i];
					html += '<tr>'
						+ '<td class="text-center">'+('<input type="checkbox" checked="checked" name="xml['+item.folioFiscal+']" value="'+item.urlDescargaXml+'"/>')+'</td>'
						+ '<td class="text-center">'+(item.urlAcuseXml ? '<input type="checkbox" checked="checked" name="acuse['+item.folioFiscal+']" value="'+item.urlAcuseXml+'"/>' : '-')+'</td>'
						+ '<td>'+item.efecto+'</td>'
						+ '<td class="blur">'+item.emisorNombre+'</td>'
						+ '<td class="blur">'+item.emisorRfc+'</td>'
						+ '<td>'+item.estado+'</td>'
						+ '<td class="blur">'+item.folioFiscal+'</td>'
						+ '<td>'+item.fechaEmision+'</td>'
						+ '<td>'+item.total+'</td>'
						+ '<td>'+item.fechaCertificacion+'</td>'
						+ '<td>'+(item.fechaCancelacion || '-')+'</td>'
						+ '<td class="blur">'+item.pacCertifico+'</td>'
						+ '</tr>'
					;
				}

				tablaBody.html(html);
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
	});

    return false;
});

$('#emitidos-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);
	var tablaBody = $('#tabla-emitidos tbody');
	
	tablaBody.empty();
	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}

				var items = response.data.items;
				var html = '';

				for(var i in items) {
					var item = items[i];
					html += '<tr>'
						+ '<td class="text-center">'+('<input type="checkbox" checked="checked" name="xml['+item.folioFiscal+']" value="'+item.urlDescargaXml+'"/>')+'</td>'
						+ '<td class="text-center">'+(item.urlAcuseXml ? '<input type="checkbox" checked="checked" name="acuse['+item.folioFiscal+']" value="'+item.urlAcuseXml+'"/>' : '-')+'</td>'
						+ '<td>'+item.efecto+'</td>'
						+ '<td class="blur">'+item.receptorNombre+'</td>'
						+ '<td class="blur">'+item.receptorRfc+'</td>'
						+ '<td>'+item.estado+'</td>'
						+ '<td class="blur">'+item.folioFiscal+'</td>'
						+ '<td>'+item.fechaEmision+'</td>'
						+ '<td>'+item.total+'</td>'
						+ '<td>'+item.fechaCertificacion+'</td>'
						+ '<td class="blur">'+item.pacCertifico+'</td>'
						+ '</tr>'
					;
				}

				tablaBody.html(html);
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
	});

    return false;
});

$('.descarga-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);

	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
	});

    return false;
});
