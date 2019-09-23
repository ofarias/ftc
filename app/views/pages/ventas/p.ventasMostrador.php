<style type="text/css">
    input[type=number] {
       width: 100px;
    }
</style>    
    

<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>&nbsp;&nbsp;&nbsp;&nbsp;Fecha: &nbsp;&nbsp;'.date("d-m-Y H:i:s")?>
<br/>
<div>
    <p>Tipo De Documento:&nbsp;&nbsp;
        <select id="tipo">
            <option value="nv">Nota de Venta</option>
            <option value="fac">Factura</option>    
        </select>
    </p>
    <p><b>Cliente:</b><input type="text" name="doc" placeholder="Nombre, Clave, RFC o Telefono" size="50" class="cl" id="clie"></p>
    <p><b>Direccion: </b><input type="text" name="doc" placeholder="Calle y Numero" size="40" class="bf" tipo="A">&nbsp;&nbsp;&nbsp;Interior:&nbsp;&nbsp;<input type="" name="" placeholder="Interior"></p>
    <p>Colonia: <input type="text" name="">&nbsp;&nbsp; Delegacion\Municipio:&nbsp;&nbsp; <input type="" name="" placeholder="Delegacion o Municipio">&nbsp;&nbsp;C.P.<input type="" name="" placeholder="Codigo Postal"></p>
    <p>Estado:&nbsp;&nbsp;<input type="" name="" placeholder="Estado">&nbsp;&nbsp;&nbsp;Pais:&nbsp;&nbsp;<input type="" name="" placeholder="Pais">
    </p>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Descuento %</th>
                                            <th>IVA %</th>
                                            <th>IEPS %</th>
                                            <th>SubTotal</th>
                                            <th>Total</th>
                                            <th>Agregar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <tr class="odd gradeX" >
                                           <td><input type="text" size="8" placeholder="Producto" id="bprod"></td>
                                           <td><input type="number" step="any" placeholder="Canitdad"id="cant" class="calc"></td>
                                           <td id="desc"></td>
                                           <td id="prc"></td>
                                           <td id="des"><br/> </td>
                                           <td id="iv"><br/> </td>
                                           <td id="iep"><br/> </td>
                                           <td id="ST"></td>
                                           <td id="T"></td>
                                           <td><input type="button" value="Agregar" class="add"><br/><input type="button" value="Cancelar" class="drop"></td>
                                        </tr>
                                    </tbody>  
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">    
    $("#bprod").autocomplete({
        source: "index.v.php?prodVM=1",
        minLength: 2,
        select: function(event, ui){
        }
    })

    $(".add").click(function(){
        var clie = document.getElementById("clie").value
        var prod = document.getElementById("bprod").value
        var cant = parseFloat(document.getElementById("cant").value)
        var prec = parseFloat(document.getElementById("precio").value)
        var iva  = parseFloat(document.getElementById("iva").value)
        var desc = parseFloat(document.getElementById("descuento").value)
        var ieps = parseFloat(document.getElementById("ieps").value)
        if(confirm("Desea Agrear la Partida?")){
            $.ajax({
                url:"index.v.php",
                type:"post",
                dataType:"json",
                data:{docNV:1, clie, prod,cant, prec, iva, desc, ieps},
                success:function(data){
                    if(data.status=='ok'){
                        $.alert("Se trae el producto " + data.desc)
                    }
                },
                error:function(){
                    $.alert("Revise el codigo del producto por favor")
                }
            })    
        }
        
    })

    $(".calc").change(function(){
        a = totales()
    })

    function calculo(){
        a=totales()
    }

    function totales(){
        var cant=parseFloat(document.getElementById("cant").value)
        var p = document.getElementById("bprod")
        prod = p.value.split(":")
        p.value=prod[0]
        p.readOnly=true
        var precio = parseFloat(document.getElementById("precio").value)
        var iva = parseFloat(document.getElementById("iva").value)
        var desc = parseFloat(document.getElementById("descuento").value)
        var ieps = parseFloat(document.getElementById("ieps").value)
        if(desc != 0){
            desc1 = (precio * (desc/100))
            document.getElementById("bprc").innerHTML = '$ '+ (precio - desc1).toFixed(2)
            document.getElementById("bdes").innerHTML='$ '+ desc1.toFixed(2)
            desc= ((precio*cant) * (desc/100))
        }else{
            document.getElementById("bprc").innerHTML=""
            document.getElementById("bdes").innerHTML=""
        }
        if(iva != 0){
            iva = (((precio*cant)-desc) * (iva/100))
            document.getElementById("biv").innerHTML='$ '+ iva.toFixed(2)
        }else{
            document.getElementById("biv").innerHTML=""
        }
        if(ieps !=0){
            ieps = (((precio*cant)-desc) * (ieps/100))
            document.getElementById("biep").innerHTML='$ '+ ieps.toFixed(2)   
        }else{
            document.getElementById("biep").innerHTML=""  
        }
        var st = ((precio * cant) - desc).toFixed(2)
        var t=(((precio * cant)- desc) + iva + ieps).toFixed(2)
        document.getElementById("ST").innerHTML= "$ "+ st
        document.getElementById("T").innerHTML="$ "+ t
    }

    $("#bprod").change(function(){
        var p = $(this)
        var prod = p.val().split(":")
        document.getElementById("desc").innerHTML=prod[1]
        document.getElementById("prc").innerHTML='<input type="number" step="any" value ='+prod[2]+' id="precio" class="calc" onchange="calculo()"> <br/><label id="bprc"></label>'  
        document.getElementById("des").innerHTML='<input type="number" step="any" value="0" id="descuento" class="calc" onchange="calculo()"> <br/><label id="bdes"></label>'
        document.getElementById("iv").innerHTML='<input type="number" step="any" value="0" id="iva" class="calc" onchange="calculo()"> <br/><label id="biv"></label>'
        document.getElementById("iep").innerHTML='<input type="number" step="any" value="0" id="ieps" class="calc" onchange="calculo()"> <br/><label id="biep"></label>'
        //document.getElementById("bprod").value=prod[0]
        //$.ajax({
        //    url:"index    .v.php",
        //    type:"post",
        //    dataType:"json",
        //    data:{productoVM:1, cveprod},
        //    success:function(data){
        //        if(data.status=='ok'){
        //            $.alert("Se trae el producto " + data.desc)
        //        }
        //    },
        //    error:function(){
        //        $.alert("Revise el codigo del producto por favor")
        //    }
        //})
    })

    function timbrar(doc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{buscaDoc:doc},
            success:function(data){
                alert(data.mensaje)
            },
            error:function(data){

            }
        })
    }

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

    function cancelar(uuid, docf){
        if(confirm('Esta seguro de cancelar la facturas o Nota de Credito: ' +  docf + ', al cancelarla se enviara automaticamente correo a Contabiliad, Gerente de CxC, Vendedor y Sistemas')){
            alert('Inicia proceso de cancelacion');
            $.ajax({
                url:'index.v.php',
                type:'POST',
                dataType:'json',
                data:{cancelar:uuid, docf:docf},
                success:function(data){
                    alert(data.motivo);
                },
                error:function(data){
                    alert(data.motivo);
                }
            });
        }
    }

</script>