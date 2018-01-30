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
                                <th>Conteo</th>
                                <th>Revisado</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                foreach ($inventario as $data):
                                    $color = '';
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
                                        <td>
                                            <input type="number" name="conteo" step="any" value="<?php echo $data->RESTANTE?>" min="0.001" class="conteo" original="<?php echo $data->RESTANTE?>" info="<?php echo $data->RESTANTE.':'.$data->PRODUCTO?>" onchange="revisar(<?php echo $i?>)">
                                        </td>
                                        <td>
                                            <input type="button" name="Revisado" value="Revisar" onclick="revisar(<?php echo $i?>)"  id="boton_<?php echo $i?>">
                                        </td>
                                    </tr>
                                <?php endforeach?>
                           </tbody>
                    </table>
                    <H1><label><font color="brown"><input name = "cerrarInvBodega" value="Cerrar Inventario" type="button" onclick="cerrar()"></font></label></H1>
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

    function revisar(i){
        //alert('Se selecciono la linea' + i);  
        document.getElementById('boton_'+i).classList.add('hide');      
        renglon = document.getElementById('tr_'+i);
        renglon.style.background="red";  
    }

    function cerrar(){
        alert('Se cerrara el Inventario con los datos cargados');
        var datos = new Array();
                 $(".conteo").each(function() {
                     var canto = parseFloat($(this).attr("original"));
                     var cantf = parseFloat(this.value);
                     var info = $(this).attr("info");
                     val = parseFloat(canto) - parseFloat(cantf);
                     //document.getElementByClassName('conteo').classList.add('hide');
                     if(val < 0){ /// si val es menor a 0 se debe ajustar el inventario para arriba.
                            /// se guarda para actualizar el inventario.
                            var a = (canto + ':'+cantf+':'+info +':'+'a');
                            datos.push(a);
                            alert('original: ' + canto + ' capturada ' + cantf + 'del producto: '+ info); 
                     }else if(val > 0 ){
                            /// se guarda para generar el vale.
                            alert('original: ' + canto + ' capturada ' + cantf + 'del producto: '+ info);
                            var a = (canto + ':'+cantf+':'+info+':'+'v');
                            datos.push(a);
                     }
                });
                document.getElementById('datosCierre').value=datos;
                var form = document.getElementById('formCierre');
                form.submit();
    }
</script>