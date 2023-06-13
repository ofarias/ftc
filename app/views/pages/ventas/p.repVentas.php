<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>'?>
<br/>
<br/>
<div>
    <p><b>Cliente:</b> 
    		<input type="text" name="cliente" placeholder="Nombre o RFC del cliente" size="100"  id="clie" tipo="D" autofocus> Seleccione cliente o RFC. <button id="boton">Agregar</button>
    </p>
    <div id="clientes">
    	<font color="white"><label id="cl"></label></font>
    </div>
    <p><b>Documento: </b>
    		<select id="op6">
                <option value="Facturas">Facturas</option>
                <option value="Prefacturas">Prefacturas</option>
                <option value="Cotizaciones">Cotizaciones</option>      
            </select>
    </p>
    <p><b>Fecha Inicial &nbsp;&nbsp;&nbsp;</b>
            <input type="date" name="doc" placeholder="Fecha inicial" id="fi" > &nbsp;&nbsp;&nbsp;
        <b>Fecha Final:</b>&nbsp;&nbsp;&nbsp; 
            <input type="date" name="doc" placeholder="Fecha Final" id="ff" class="bf" tipo="R">
    </p>
    <p>
    	<b>Traer Documentos por Mes y Año:</b> 
    		<input type="text" name="doc" placeholder="Mes y Año" size="20" class="bf" tipo="M"> Primero el Mes y despues el año, Ejemplo Marzo 2018
    </p>  
    <p><b>Traer Todos los documentos:</b> 
    		<input type="text" name="doc" placeholder="Todos los documetos" size="20" class="bf" tipo="H"> para ejecutar coloque la palabra "si" y de enter.
    </p>
    <p title="Se descarga en automatico en Excel">Descargar en Excel ? <input type="checkbox" id="op1" value="e"></p>
    <p title="Muestra las partidas de cada documento, de lo contrario solo se muestra los importes totales">Detallado? <input type="checkbox" id="op2" value="d"></p>
    <p title="Agrupa el reporte de documentos por cliente, de lo contrario lo acomoda por fecha"> Agrupado por cliente? <input type="checkbox" id="op3" value="A"></p>
    <p>
        <button class="btn btn-success" id="ejecutar">Ejecutar</button> &nbsp;&nbsp;&nbsp; <button class="btn btn-warning" id="limp">Limpiar</button>
    </p>
</div>

<div id="D">
    
</div>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">    

	$("#clie").autocomplete({
		source:"index.v.php?cliente=1",
    	minLength: 2,
    	select: function(event, ui){
    	}
    })

    $("#limp").click(function(){
        if(confirm("Desea limpiar los filtros?")){
            location.reload(true)
        }else{
            return false;
        }
    })

    $("#boton").click(function(){
    	var c = document.getElementById("clie").value 
    	if(confirm('Desea agregare a ' + c + ', al reporte?')){
    		var y = document.getElementById("cl").innerHTML
    		if(y === undefined){
    			t = c
    		}else{
    			t = y + c
    		}
    		document.getElementById("cl").innerHTML= "<p>"+t+",</p>"
    		document.getElementById("clie").value=""	
    	}
    })

    $(".bf").change(function(){
        var valor = $(this).val();
        var tipo = $(this).attr('tipo');
        valor = tipo+":"+valor;
        if(tipo == 'R'){
            var valor2 = document.getElementById("fi").value;
            if(valor2 ==''){
                alert ('Seleccione una fecha inicial');
                return;
            }
            valor= tipo+':'+valor2+":"+valor; 
        }
        //alert('cambio el valor' + valor);
        //window.open("index.php?action=imprimeXML&uuid="+valor,"_self");
    })

    $("#ejecutar").click(function(){
        var op1 = document.getElementById('op1')
        if(op1.checked){
            op1='Excel'
        }else{
            op1='Pantalla'
        }
        var op2 = document.getElementById('op2')
        if(op2.checked){
            op2='Detallado'
        }else{
            op2='General'
        }
        var op3 = document.getElementById('op3')
        if(op3.checked){
            op3='Agrupado'
        }else{
            op3='Por Fecha'
        }
        var op4=document.getElementById('fi').value
        var op5=document.getElementById('ff').value
        var op6=document.getElementById("op6").value
        var op7=''
        var clientes = ''
        var mensaje = ''
        if((document.getElementById("cl").innerHTML).length > 0){
            clientes= document.getElementById("cl").innerHTML
            mensaje = ' de los clientes ' + clientes
            op7 = clientes
        }else{
            mensaje=" de todos los clientes"; 
        }
        $.confirm({
            title:"Reporte de Ventas",
            content:"Ejecuto el reporte para obetner "+ op6 + " en " + op1 + ", "+ op2 + mensaje + " "+op3,
            buttons:{
                Ejecutar:function(){
                    $.ajax({
                        url:'index.v.php',
                        type:'post',
                        dataType:'json',
                        data:{repVenta:1, op1, op2, op3, op4, op5, op6, op7},
                        success:function(data){
                            if(data.status == 'ok' && op6 == 'Facturas' && op2 == 'General'){
                                var datos = data.datos
                                //datos.length
                                document.getElementById("D").innerHTML= 
                                "<div class='row'>" +
                                    "<div class='col-lg-12'>" +
                                        "<div class='panel panel-default'>" +
                                            "<div class='panel-heading'>" +
                                               "Documentos" +
                                            "</div>" +
                                            "<div class='panel-body'>" +
                                                "<div class='table-responsive'>" +
                                                    "<table class='table table-striped table-bordered table-hover' id='dataTables-repventas'>" +
                                                        "<thead>" +
                                                            "<tr>" + 
                                                                "<th>Documento</th>"+
                                                                "<th>Fecha</th>"+
                                                                "<th>Nombre</th>"+
                                                                "<th>Subtotal</th>"+
                                                                "<th>Iva</th>"+
                                                                "<th>Total</th>"+
                                                                "<th>Saldo</th>"+
                                                                "<th>Uso CFDI</th>"+
                                                                "<th>Forma Pago</th>"+
                                                                "<th>Metodo de Pago</th>"+
                                                                "<th>Moneda</th>"+
                                                                "<th>TC</th>"+
                                                                "<th>Usuario</th>"+
                                                                "<th>UUID</th>"+
                                                                "<th>STATUS</th>"+
                                                            "</tr>"+
                                                        "</thead>"+                                   
                                                      "<tbody id='tabla'>"+
                                                    "</tbody>"+
                                                    "</table>"+
                                                    "<input type='button' name='impresion' value='impresion' id='enviar' class='btn btn-info'>"+
                                            "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"

                                        var node = document.getElementById("tabla")
                                        for (var i = datos.length - 1; i >= 0; i--) {
                                            var h = document.createElement("tr")    
                                               
                                               var celda1 = document.createElement("td")
                                               var doc = document.createTextNode(datos[i]['DOCUMENTO'])
                                               celda1.appendChild(doc)
                                               h.appendChild(celda1)
                                               
                                               var celda2 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['FECHA_DOC'])
                                               celda2.appendChild(fecha)
                                               h.appendChild(celda2)

                                               var celda3 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['NOMBRE'])
                                               celda3.appendChild(fecha)
                                               h.appendChild(celda3)

                                               var celda4 = document.createElement("td")
                                               var fecha = document.createTextNode( "$ " + new Intl.NumberFormat().format(datos[i]['SUBTOTAL']))
                                               celda4.appendChild(fecha)
                                               h.appendChild(celda4)
                                               
                                               var celda5 = document.createElement("td")
                                               var fecha = document.createTextNode( "$ " + new Intl.NumberFormat().format(datos[i]['IVA']))
                                               celda5.appendChild(fecha)
                                               h.appendChild(celda5)

                                               var celda6 = document.createElement("td")
                                               var fecha = document.createTextNode( "$ " + new Intl.NumberFormat().format(datos[i]['TOTAL']))
                                               celda6.appendChild(fecha)
                                               h.appendChild(celda6)

                                               var celda7 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['SALDO_FINAL'])
                                               celda7.appendChild(fecha)
                                               h.appendChild(celda7)

                                               var celda8 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['USO_CFDI'])
                                               celda8.appendChild(fecha)
                                               h.appendChild(celda8)
                                               
                                               var celda9 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['FORMADEPAGOSAT'])
                                               celda9.appendChild(fecha)
                                               h.appendChild(celda9)
                                               
                                               var celda10 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['METODO_PAGO'])
                                               celda10.appendChild(fecha)
                                               h.appendChild(celda10)
                                               
                                               var celda11 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['MONEDA'])
                                               celda11.appendChild(fecha)
                                               h.appendChild(celda11)

                                               var celda12 = document.createElement("td")
                                               var fecha = document.createTextNode("$ " + new Intl.NumberFormat({minimumIntegerDigits:2, minimumFractionDigits:2}).format(datos[i]['TIPO_CAMBIO']))
                                               celda12.appendChild(fecha)
                                               h.appendChild(celda12)

                                               var celda13 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['USUARIO'])
                                               celda13.appendChild(fecha)
                                               h.appendChild(celda13)

                                               var celda14 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['UUID'])
                                               celda14.appendChild(fecha)
                                               h.appendChild(celda14)

                                               var celda15 = document.createElement("td")
                                               var fecha = document.createTextNode(datos[i]['UUID'])
                                               celda15.appendChild(fecha)
                                               h.appendChild(celda15)

                                            node.appendChild(h)
                                        }            
                                    } ///Finaliza el if ok
                            
                            if(op1 == 'Excel'){
                                window.open("/EdoCtaXLS/"+data.archivo, 'download' )
                            }
                        },///Finaliza el success
                        error:function(){
                            $.alert('No encontre informacion con las opciones seleccionadas, por favor revise las opciones')
                        }
                    }) /// Finaliza Ajax
                },
                Cancelar:function(){
                    $.alert("Se cancelo el reporte")
                }
            }
        })
    })

    function imprimeNC(nc){
        document.getElementById('fact').value=nc; 
        form = document.getElementById("impNC");
        form.submit();
    }

</script>