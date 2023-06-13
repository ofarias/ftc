<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Recepciones de &oacute;rdenes de compra
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-inventarioBodega">
                         <?php 
                           $Total = 0;
                        foreach ($inventario as $key){
                                    $Total= $Total + $key->COSTO * $key->RESTANTE;
                        
                        } 
                        ?>    
                        <label><font size="14pxs">Total de costo Inventario Bodega :</font>&nbsp;&nbsp;<font color="red" size="12pxs"><?php echo '$ '.number_format($Total,2)?></font></label>

                        <thead>
                            <tr>   
                                <th>Clave</th>
                                <th>Descripcion</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Proveedor</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Fecha</th>
                                <th>Costo x Unidad</th>
                                  <?php if($rol != 'ventasp'){?>
                                <th>Conteo</th>
                                <th>Revisado</th>   
                                 <?php } ?>                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                foreach ($inventario as $data):
                                    $color = '';
                                    if($data->NUEVA<>9999999){
                                        $color = "style='background-color:#b3e6ff'";
                                    }

                                  
                                    $i++;
                            ?>
                                    <tr class="odd gradeX" <?php echo $color?> id="tr_<?php echo $i?>">
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PRODUCTO?>" target="_blank"><?php echo $data->PRODUCTO?></a></td>
                                        <td><?php echo $data->DESCRIPCION; ?></td>
                                        <td><?php echo $data->MARCA?></td>
                                        <td><?php echo $data->CATEGORIA?></td>
                                        <td><?php echo $data->PROVEEDOR?></td>
                                        <td><input name= "cantidad" type="number" step="any" value="<?php echo $data->RESTANTE;?>" disabled="disabled" </td>
                                        <td><input type="text" name="unidad" placeholder="Unidad de Medida" value="<?php echo $data->UNIDAD;?>" disabled="disabled"></td>
                                        <td><?php echo $data->FECHA; ?></td>
                                        <td align="right"><input type="number" step="any" name="costo" placeholder="<?php echo $data->COSTO?>" value="<?php echo (empty($data->COSTO))? '0':$data->COSTO; ?>"  disabled="disabled" /> </td>
                                        <?php if($rol != 'ventasp'){?>
                                        <td>
                                            <input type="number" name="conteo" step="any" value="<?php echo ($data->NUEVA == 9999999)? $data->RESTANTE:$data->NUEVA?>" min="0.001" class="conteo" original="<?php echo $data->RESTANTE?>" info="<?php echo $data->RESTANTE.':'.$data->PRODUCTO?>" info2="<?php echo $data->UNIDAD?>" onchange="revisar(<?php echo $i?>,'<?php echo $data->PRODUCTO?>', <?php echo $data->RESTANTE?>,this.value, '<?php echo $data->UNIDAD?>')" id='conteo_<?php echo $i?>'>
                                            <br/>
                                        </td>
                                        <td>
                                            <input type="button" name="Revisado" value="Revisar" onclick="revisar(<?php echo $i?>,'<?php echo $data->PRODUCTO?>', <?php echo $data->RESTANTE?>,<?php echo $data->RESTANTE?>)"  id="boton_<?php echo $i?>">
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php endforeach?>
                           </tbody>
                    </table>
                    <?php if($rol != 'ventasp'){?>
                    <H1><label><font color="brown"><input name = "cerrarInvBodega" value="Cerrar Inventario" type="button" onclick="cerrar()"></font></label></H1>
                      <?php } ?>  
                </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="formCierre">
    <input type="hidden" name="cierreInvBodega" value="">
    <input type="hidden" name="datos" value="" id="datosCierre">
</form>
<script type="text/javascript">


function revisar(i, prod, canto, cantn, um){
        renglon = document.getElementById('tr_'+i);
        if(cantn < 0 ){
            alert('El Valor debe de ser mayor o igual a 0');
            document.getElementById('conteo_'+i).value = canto;
        }else{
            document.getElementById('boton_'+i).classList.add('hide');      
          $.ajax({ 
            url:'index.php',
            type:'POST',
            dataType:'json',
            data:{invFisBod:1, prod:prod, canto:canto, cantn:cantn, um:um},
            success:function(data){
                if(data.status == 'ok'){
                    renglon.style.background="red";
                }else{
                    alert('No se logro registrar intente nuevamente o reporte a sistemas.');        
                }
            }
          })    
        }
    }
function cerrar(){
        alert('Se cerrara el Inventario con los datos cargados');
        var datos = new Array();
                 $(".conteo").each(function() {
                     var canto = parseFloat($(this).attr("original"));
                     var cantf = parseFloat(this.value);
                     var info = $(this).attr("info");
                     var um = $(this).attr("info2");
                     val = parseFloat(canto) - parseFloat(cantf);
                     //document.getElementByClassName('conteo').classList.add('hide');
                     if(val < 0){ /// si val es menor a 0 se debe ajustar el inventario para arriba.
                            var a = (canto + ':'+cantf+':'+info +':'+'a'+':'+um);
                            datos.push(a);
                     }else if(val > 0 ){
                            var a = (canto + ':'+cantf+':'+info+':'+'v'+':'+um);
                            datos.push(a);
                     }
                });
            document.getElementById('datosCierre').value=datos;
            var form = document.getElementById('formCierre');
            form.submit();
    }
</script>