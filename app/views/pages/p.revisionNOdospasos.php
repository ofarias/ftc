<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Facturas para ingreso a Revision.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="verRevision">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Factura</th>
                                            <th>Importe Factura</th>
                                            <th>Cliente<br/> Maestro</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Cobranza</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($exec as $data):                                            
                                           $color = '';
                                           $total = $total + $data->IMPORTE;
                                            ?>
                                       <tr  style="background-color: <?php echo $color;?>">
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input type="text" name="numcr" required="required" maxlength="20" />
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>" />
                                            <td><button type="submit" name="CajaCobranza" class="btn btn-warning" >Cobranza</button></td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 <div>
                                     <label><font size="10pxs">Total Cartera:&nbsp; <font color = "red"> <?php echo '$ '.number_format($total,2)?></font></font></label>
                                 </div>
                                 </table>
                                 
                      </div>
            </div>
        </div>
</div>
</div>

