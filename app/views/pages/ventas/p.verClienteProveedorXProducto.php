<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Producto.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Clave_prod</th>
                                            <th>Categoria</th>
                                            <th>Marca</th>
                                            <th>Descripcion</th>
                                            <th>Medidas</th>
                                            <th>UM</th>
                                            <th>Empaque</th>
                                            <th>Costo </th>
                                            <th>Precio</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php foreach ($producto as $data): ?>
                                       <tr class='odd gradex'>
                                            <td><?php echo $data->CLAVE_PROD;?></td>
                                            <td><?php echo $data->CATEGORIA?></td>
                                            <td><?php echo $data->MARCA?></td>
                                            <td><?php echo $data->GENERICO;?> <?php echo ($data->CALIFICATIVO == '')? '':', '.$data->CALIFICATIVO?> <?php echo ($data->SINONIMO == '')? '':', '.$data->SINONIMO?></td>
                                            <td><?php echo $data->MEDIDAS?></td>
                                            <td><?php echo $data->UM?></td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO,2)?></td>
                                            <td><?php echo '$ '.number_format($data->PRECIO,2)?></td>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>


<div class="row">
    <div class="col-md-6">
        <form action="index.v.php" method="post">
        <div class="form-group">
            <input type="hidden" name="ids" value="<?php echo $ids?>" >
            <input type="text" name="aguja" class="form-control" required="required" placeholder="Buscar Proveedor">
        </div>
          <button type="submit" value = "enviar" name="buscaClienteProveedor"  class="btn btn-default">Buscar Cliente / Proveedor </button>
        </form>
    </div>
</div>
<br />

<?php if($proveedor){
    ?>
<br /><br />

<div class="row">
<div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
    <div class="panel panel-heading">

                        <?php foreach ($proveedor as $data): ?>
                            
                        <form action="index.v.php" method="post">
                            <input type="hidden" name="idprov" value="<?php echo $data->CLAVE?>">
                            <input type="hidden" name="ids" value="<?php echo $ids;?>"/>
                                        
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Nombre del Proveedor</label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CLAVE.' - '.$data->NOMBRE?></label>
                                </div>
                            </div>            

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Direccion: </label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CALLE.', '.$data->NUMEXT.', '.$data->COLONIA?></label>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Empaque / Unidad: </label>
                                <div class="col-lg-10">
                                   
                                    <input type="checkbox" name="pieza" value="Si" <?php echo ($data->PIEZA == 'Si')? "checked='checked'":"";?> > Pieza  <br/>
                                    <input type="checkbox" name="empaque" value="Si" <?php echo ($data->EMPAQUE == 'Si')? "checked='checked'":"";?> > <label>Empaque Piezas x Paquete --></label>
                                    <input type="number" name="pxp" align='right' class="text text-right text-muted" placeholder="Piezas por Paquete" 
                                        value = "<?php echo ($data->PZA_X_EMPAQUE == '')? "0":"$data->PZA_X_EMPAQUE"?>" > 
                                    <label>Costo</label>--><input type="number" step="any" name="costo" class="text text-right text-muted" value="<?php echo ($data->COSTO == 0)? 0:"$data->COSTO"?>" placeholder="Costo del paquete 1"> <label> + IVA </label>
                                    <br/> 
                                    <input type="checkbox" name="empaque2" value="Si" <?php echo ($data->EMPAQUE_2 == 'Si')? "checked='checked'":"";?>>
                                    <label>2do Empaque Piezas x Paquete --></label> 
                                    <input type="number" name="pxp2" class="text text-right text-muted" value = "<?php echo ($data->PZA_X_EMPAQUE2 == '')? "0":"$data->PZA_X_EMPAQUE2"?>" placeholder="Piezas por Paquete">
                                    <label>Costo:</label>--><input type="number" step="any" name="costo2" value="<?php echo ($data->COSTO2 == 0 )? 0:"$data->COSTO2"?>" class="text text-right text-muted" placeholder="Costo del Paquete 2" > <label> + IVA </label>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Urgencia </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="urgencia" value="Si" <?php echo ($data->URGENCIA == 'Si')? "checked='checked'":"";?> > Urgencia 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Tipo </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="entrega" value="Si" <?php echo ($data->ENTREGA == 'Si')? "checked='checked'":"";?> > Entrega  <br/> 
                                    <input type="checkbox" name="recoge" value="Si" <?php echo ($data->RECOGE == 'Si')? "checked='checked'":"";?> > Recoleccion
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Forma de Pago </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="efectivo" value="Si" <?php echo ($data->EFECTIVO == 'Si')? "checked='checked'":"";?> > Efectivo  <br/> 
                                    <input type="checkbox" name="cheque" value="Si" <?php echo ($data->CHEQUE == 'Si')? "checked='checked'":"";?> > Cheque <br/>
                                    <input type="checkbox" name="credito" value="Si" <?php echo ($data->CREDITO == 'Si')? "checked='checked'":"";?> > Credito <br/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <button value="enviar" type="submit" 
                                    <?php echo empty($data->ID)? 'class="btn btn-success"':'class="btn btn-warning"' ?> 
                                    name="proveedorXproducto"> <?php echo empty($data->ID)? 'Guardar':'Cambiar';?></button>    
                                </div>
                            </div>
                            
                            <br/>
                            <hr size="30" />
                           <hr style="color: red;" />
                            </form>
                            <?php endforeach ?>
                      </div>
                </div>
        </div>
    </div>
</div>

<?php }
?>






