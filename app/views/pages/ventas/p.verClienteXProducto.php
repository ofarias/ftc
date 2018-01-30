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
            <input type="text" name="aguja" class="form-control" required="required" placeholder="Buscar Cliente / Proveedor">
        </div>
          <button type="submit" value = "enviar" name="buscaCliente"  class="btn btn-default">Buscar Cliente nombre o Clave </button>
        </form>
    </div>
</div>
<br />

<?php if($cliente){
    ?>
<br /><br />
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
    <div class="panel panel-heading">

                        <?php foreach ($cliente as $data): ?>
    
                        <form action="index.v.php" method="post">
                            <input type="hidden" name="idclie" value="<?php echo $data->CLAVE?>">
                            <input type="hidden" name="ids" value="<?php echo $ids;?>"/>
                                        <!-- Control para activar e inactivar producto -->
                                        <!-- Fin del control para inactivar producto -->
                            <br>
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Cliente:</label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CLAVE.' - '.$data->NOMBRE?></label>
                                </div>
                            </div>            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Direccion Fiscal:</label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CALLE.', '.$data->NUMEXT.', '.$data->COLONIA?></label>
                                </div>
                            </div>            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Direccion Entrega:</label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CALLE.', '.$data->NUMEXT.', '.$data->COLONIA?></label>
                                </div>
                            </div>            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Sku en Factura ? : </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="skuFact" value="Si" <?php echo ($data->SKU_FACTURA == 'Si')? "checked='checked'":"";?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Sku Cliente : </label>
                                <div class="col-lg-10">
                                    <input type="text" maxlength="30" class="form-control" name="sku" placeholder="Sku Cliente"  required="required" value='<?php echo empty($data->SKU)? '':"$data->SKU"; ?>' />
                                </div>
                            </div>
                           <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Correo Electronico : </label>
                                <div class="col-lg-10">
                                    <input type="text" maxlength="100" class="form-control" name="correo" placeholder="Correo Cliente" value='<?php echo empty($data->CORREO)? '':"$data->CORREO"; ?>'/>
                                </div>
                            </div>
                           <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Agregar a la Lista de Precios del Cliente? : </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="listaCliente" value="Si" <?php echo ($data->LISTA_CLIENTE == 'Si')? "checked='checked'":"";?> />
                                </div>
                            </div>

                           <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Precio de lista para el cliente : </label>
                                <div class="col-lg-10">
                                    <input type="number" step="any" name="precio" class="text text-right text-muted" value='<?php echo ($data->PRECIO == 0)?  "0":"$data->PRECIO"?>' />
                                </div>
                            </div>

                           <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <button value="enviar" type="submit" 
                                    <?php echo empty($data->SKU)? 'class="btn btn-success"':'class="btn btn-warning"'?> 
                                    name="clienteXproducto">
                                    <?php echo (empty($data->SKU))? 'Guardar':'Cambiar'?></button>    
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
</div>

<?php }
?>




