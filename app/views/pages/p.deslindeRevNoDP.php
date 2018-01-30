<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision dos pasos.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Remisión</th>
                                            <th>Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Días</th>
                                            <th>Deslinde</th>
                                            <th>Cobranza</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($revdia as $data):?>
                                       <tr>
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->RESULTADO;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->REV_DOSPASOS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <form action="index.php" method="post" id="f1">
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>"/>
                                            <td><input type="text" name="motivodelinde" maxlength="30"/></td>
                                            <td><button type="submit" name="salvaMotivoDeslindeNodp" class="btn btn-warning">Guardar <i class="fa fa-save"></i></button></td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision dos pasos.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Remisión</th>
                                            <th>Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Días</th>
                                            <th>Deslinde</th>
                                            <th>Cobranza</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data):?>
                                       <tr>
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->RESULTADO;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->REV_DOSPASOS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <form action="index.php" method="post" id="f1">
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>"/>
                                            <td><input type="text" name="motivodelinde" maxlength="30"/></td>
                                            <td><button type="submit" name="salvaMotivoDeslindeNodp" class="btn btn-warning">Guardar <i class="fa fa-save"></i></button></td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>