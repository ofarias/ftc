<br/>
<br/>
<div class="row">
                <div class="panel panel-default">
                        <div class="panel-heading">
                           Asignaciones desde bodega.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Impre<br/>sion</th>
                                            <th>Ingreso Bodega</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Usuario Ingreso </th>
                                            <th>Fecha Asignacion</th>
                                            <th>Usuario Asignacion</th>
                                            <th>Producto</th>
                                            <th>Cantidad Asignada</th>
                                            <th>Por Recibir</th>
                                            <th>Pedido</th>
                                            <th>Recibir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($asignaciones as $data):
                                            $i++;   
                                            ?>
                                        <tr id="titulo_<?php echo $i?>">
                                            <td><?php echo $data->FOLIO_IMP?></td>
                                            <td><?php echo $data->IDINGRESO;?></td>
                                            <td><?php echo $data->FECHA?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><?php echo $data->FECHA_MOV ;?></td>
                                            <td><?php echo $data->USUARIO_MOV?></td>
                                            <td><?php echo $data->DESCRIPCION?></td>
                                            <td><?php echo $data->ASIG?></td>
                                            <td><input type="number" name="cantRec" max="<?php echo $data->ASIG?>" min="0" id="cantRec_<?php echo $i?>" onchange="valida(<?php echo $i?>)">
                                                <input type="hidden" name="cantOr" id="cantOr_<?php echo $i?>" value="<?php echo $data->ASIG?>">
                                            </td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            
                                            <td><a onclick="ejecutarRecepcion(<?php echo $i?>, 'a')" value="<?php echo $i?>" class="btn btn-success" id="boton_<?php echo $i?>">Recibir</a><br/><br/>
                                                <a onclick="ejecutarRecepcion(<?php echo $i?>, 'r')" value="<?php echo $i?>" class="btn btn-danger" id="boton2_<?php echo $i?>" >Cancelar</a>
                                            </td>           
                                            <input type="hidden" name="ida" id="ida_<?php echo $i?>" value ="<?php echo $data->ID?>" >

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />

<form action="index.php" method="POST" id="recOC">
    <input type="hidden" value="" id="doc" name="doco">
    <input type="hiiden" value="" id="tip" name="tipo">
    <input type="hidden" value="" id="btn1" name="recibirOC">
</form>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">


    function valida(i){
        var cantidad = parseFloat(document.getElementById('cantRec_'+i).value);
        var cantmax = parseFloat(document.getElementById('cantOr_'+i).value);
        if(cantidad > cantmax || cantidad < 0){
            alert('La cantidad que intentas recibir es mayor a la asignada');
            document.getElementById('cantRec_'+i).value = cantmax;
        }
    }


    function ejecutarRecepcion(i, tipo){
        var cantRec = parseFloat(document.getElementById('cantRec_'+i).value);
        var cantOr = parseFloat(document.getElementById('cantOr_' + i).value);
        //alert('cantRec: ' + cantRec + ' Cant Original' + cantOr);
        if(tipo == 'r'){
            cantRec = 0;
            alert('Se cancelara la Asignacion');
        }

        if(cantRec <= cantOr && cantRec >= 0){
            var ida = document.getElementById('ida_'+i).value;
            if(confirm('Esta seguro de recibir o cancelar el material?')){
                document.getElementById("boton2_"+i).classList.add('hide');
                document.getElementById("boton_"+i).classList.add('hide');
                $.ajax({
                    type:"POST",
                    url:"index.php",
                    dataType:"json",
                    data:{ejecutarRecepcion:1,ida:ida, cantRec:cantRec, cantOr:cantOr},
                    success: function(data){
                        if(data.status == 'ok'){
                            alert('Se creo la recepcion:' + data.recepcion);
                        }
                    },
                    error: function(data){
                        alert('No se genero la recepcion favor de revisar la informacion o avisar a sistemas ');
                    }
                });
            }      
        }else{

            if(isNaN(cantRec)){
                alert('Debe de colocar el Valor a Recibir');
            }else{
                alert('La cantidad ' + cantRec + ' en la columna por Recibir no puede ser mayor a la asignada o menor a 0, revise la informacion por favor ');         
            }
        }
        
    }
   
   

</script>
