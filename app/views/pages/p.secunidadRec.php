<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ruta de Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Factura</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($secuenciaentrega as $data):  
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->IDU;?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input name="idcaja" type="hidden" value="<?php echo $data->ID?>"/>
                                                <input name="clie" type="hidden" value="<?php echo $data->NOMBRE?>"/>
                                                <input name="secuencia" type="number" required = "required"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>"/>
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />
                                                <input name="fecha" type="hidden" value="<?php echo $data->FECHA?>"/> 
                                                <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            </td>  
                                            <td>                                                
                                                <button name="SecUnidadEntrega" type="submit" value="enviar" class="btn btn-warning">Asignar  <i class="fa fa-cog fa-spin"></i></button>
                                            </td>
                                            </form>
                                             </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
                <div class = "panel-footer">
                    <div class="text-right">
                        <form action="index.php" method="post">
                            <input type="hidden" name="unidad" value="<?php echo $unidad; ?>"/>
                            <button type="input" name="ImprimirSecuenciaEntrega" class="btn btn-primary">Imprimir <i class="fa fa-print" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
        </div>
</div>
</div>