<br/>
<br/>
<input type="hidden" name="temp" id="temporal" value="<?php echo $temp->TEMP?>"> 
<div id="selProv">
    <input type="text" class="form-control" onchange="proveedor(this.value)" id="prov1" name="prov1" placeholder ="Buscar Proveedor por Nombre o clave" value="" > 
</div>
<br/>
<br/>
<div class="hide" id="datosProv">
    <label>Nombre del Proveedor :</label><p id="pNombre"></p>
    <label>Direccion :&nbsp;&nbsp; </label><label id="pCalle"></label>,&nbsp;<label id="pNumExt"></label>,&nbsp;<label id="pNumInt"></label>
    <label id="pColonia"></label>,&nbsp;<label id="pCP"></label>,&nbsp;<label id="pCiudad"></label>,&nbsp; Telefono : <label id="pTel"></label>
    </label>
</div>

<div class="hide" id="buscaProd">
    <br/>
    <label>Seleccion el producto a agregar:</label>
    <div>
        <input type="text" class="form-control" name='descripcion' id='descripcion' value='' class="text" maxlength="90" style="width: 100%" placeholder="Se puede buscar por SKU, Descripcion, Numero de Parte...." /><br/>
        <label>Cantidad :&nbsp;</label><input type="number" step="any" name="cant" id="cant" min="1" max="999999"><br/><br/>
        <label><input type="button" name="agregar" value="Agregar" class="btn btn-success" onclick="agregar()"></label>

    </div>
</div>
<div class="row, hide" id="listaProd">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="cuerpo">                               
                            </div>
                      </div>
            </div>
        </div>
</div>
<br />
<div class="hide" id="Ordenar">
    <button onclick="crearOrden(this.value)" value="<?php echo $temp->TEMP?>" class="btn btn-success">Crear Orden</button>    
</div>

<form action="index.php" method="POST" id="formCrear">
    <input type="hidden" name="cerrarOCI" value="" id="cerrarOCI">
</form>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">


    function crearOrden(temp){
        var form = document.getElementById('formCrear');
        if(confirm('Esta Seguro de crear la Orden?')){
                document.getElementById('cerrarOCI').value=temp;
                form.submit();
        }
    }

    $("#prov1").autocomplete({
    source: "index.v.php?proveedor=1",
    minLength: 3,
    select: function(event, ui){
    }
    })

    function proveedor(clave){
        var clv  =  clave.split(":"); 
       
        //alert('se busca la clave: ' + clv[0]);
        clave = clv[0];
        $.ajax({
            url:'index.php',
            method:'POST',
            dataType:'json',
            data:{provOI:clave},
            success:function(data){
                var Nombre = data.nombre;
                var Calle = data.calle;
                var numInt = data.numInt;
                var numExt = data.numExt;
                var colonia = data.colonia;
                var cp = data.cp;
                var ciudad = data.ciudad;
                var tel=data.tel;
                //alert('Nombre' + Nombre);
                document.getElementById("datosProv").classList.remove('hide');
                document.getElementById("pNombre").innerHTML=Nombre;
                document.getElementById("pCalle").innerHTML=Calle;
                document.getElementById("pNumInt").innerHTML=numInt;
                document.getElementById("pNumExt").innerHTML=numExt;
                document.getElementById("pColonia").innerHTML=colonia;
                document.getElementById("pCP").innerHTML=cp;
                document.getElementById("pCiudad").innerHTML=ciudad;
                document.getElementById("pTel").innerHTML=tel;
                document.getElementById("buscaProd").classList.remove('hide');
            }
        });
    }

    function agregar(){
        
        var prod = document.getElementById('descripcion').value;
        var cant = document.getElementById('cant').value;
        var prov = document.getElementById('prov1').value;
        var temp = document.getElementById('temporal').value;
        
        prov = prov.split(":");
        prov = prov[0];
        alert('clave proveedor' + prov);
        if(cant <= 0 || cant >= 999999){
            alert('No se capturo la cantidad o se supero el maximo a solicitar, revise la informacion');
        }else{
            if(confirm('se intenta agregar el prod ' + prod + ' con la cantidad de: '+ cant)){
                $.ajax({
                    url:'index.php',
                    dataType:'json',
                    method:'POST',
                    data:{addOCI:1, clave:prod, cant:cant, prov:prov, temp:temp},
                    success:function(data){
                            document.getElementById('listaProd').classList.remove('hide');
                            document.getElementById('Ordenar').classList.remove('hide');
                            document.getElementById('selProv').classList.add('hide');
                                var midiv = document.createElement("div");
                                var del = document.createElement("input");
                                midiv.setAttribute("id","div_"+data.linea);
                                del.setAttribute("type","button");
                                del.setAttribute("id",data.linea);
                                del.setAttribute("onclick","borrar("+data.linea+")");
                                del.setAttribute("value","Eliminar");
                                //midiv.setAttribute("id","d_");
                                //midiv.setAttribute("otros atributos","otros");
                                midiv.innerHTML = "<p>"+ data.prod + " <font color='blue'>&nbsp;&nbsp; Cantidad: " + cant + " </font> <font color='red'>&nbsp;&nbsp; Total : $ "+ data.total + "</font>"+"</p>";
                                document.getElementById('cuerpo').appendChild(midiv); // Lo pones en "body", si quieres ponerlo dentro de algún id en concreto usas     document.getElementById('donde lo quiero poner').appendChild(midiv);*/
                                document.getElementById('cuerpo').appendChild(del);
                                if(data.val == 0 ){
                                    document.getElementById('Ordenar').classList.add('hide');
                                    document.getElementById('Ordenar').classList.add('hide');
                                    document.getElementById('listaProd').classList.add('hide');
                                }
                            }   
                });    
            }    
        }        
    }

    function borrar(linea){
        alert('Se intenta borrar la linea' + linea);
        var temp = document.getElementById('temporal').value;
        $.ajax({
            url:'index.php',
            dataType:'json',
            type:'POST',
            data:{delOCI:1,linea:linea, temp:temp},
            success:function(data){
                document.getElementById('div_'+linea).classList.add('hide');
                document.getElementById(linea).classList.add('hide');
                if(data.val == 0 ){
                    document.getElementById('Ordenar').classList.add('hide');
                    document.getElementById('listaProd').classList.add('hide');
                }
            }
        })
    }

     $("#descripcion").autocomplete({
        source: "index.v.php?descAuto=1",
        minLength: 3,
        select: function(event, ui){
        }
    })
</script>



