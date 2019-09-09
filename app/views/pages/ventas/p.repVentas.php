<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>'?>
<br/>
<br/>
<div>
    <p><b>Cliente:</b> 
    		<input type="text" name="cliente" placeholder="Nombre o RFC del cliente" size="100"  id="clie" tipo="D"> Seleccione cliente o RFC. <button id="boton">Agregar</button>
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
        <button class="btn btn-success" id="ejecutar">Ejecutar</button> &nbsp;&nbsp;&nbsp; <button class="btn btn-warning" id="limp">Actualizar</button>
    </p>
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
                    $.alert('Ejecucion em ajax del reporte')
                    $.ajax({
                        url:'index.v.php',
                        type:'post',
                        dataType:'json',
                        data:{repVenta:1, op1, op2, op3, op4, op5, op6, op7},
                        success:function(data){

                        },
                        error:function(){
                            $.alert('No encontre informacion con las opciones seleccionadas, por favor revise las opciones')
                        }
                    })
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