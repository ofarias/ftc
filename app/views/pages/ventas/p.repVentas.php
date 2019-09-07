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
    		<input type="text" name="doc" placeholder="Documento Administrativo )" size="40" class="bf" tipo="A"> Pedidos, PreFacturas.
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

    $("#boton").click(function(){
    	var c = document.getElementById("clie").value 
    	if(confirm('Desea agregare a ' + c + ', al reporte?')){
    		var y = document.getElementById("cl").innerHTML
    		if(y === undefined){
    			t = c
    		}else{
    			t = y + c
    		}
    		document.getElementById("cl").innerHTML= "<p>"+t+"</p>"
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
        window.open("index.php?action=imprimeXML&uuid="+valor,"_self");
    })

    function imprimeNC(nc){
        document.getElementById('fact').value=nc; 
        form = document.getElementById("impNC");
        form.submit();
    }

</script>