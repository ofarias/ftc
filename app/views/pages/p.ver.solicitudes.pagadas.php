<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes pendientes de Impresión.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Proveedor</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                            <th>Tipo Solicitud</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Banco</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($solicitudes as $data): 
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $data->IDSOL;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO_FINAL,2);?></td>
                                            <td><?php echo $data->USUARIO_PAGO;?></td>
                                            <td align="center"><?php echo $data->TP_TES_FINAL;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->BANCO_FINAL?></td>
                                            <form action="index.php" method="post">
                                            <input name="idsol" type="hidden" value="<?php echo $data->IDSOL?>"/>
                                            <td>
                                                <button name="ImpSolPagada" type="submit" value="enviar" <?php echo ($data->IMPRESO == 0)? 'class="btn btn-info"':'class="bnt btn-link"'?>> 
                                                <?php echo ($data->IMPRESO == 0)? 'Imprimir':'Reimprimir'?> 
                                                <i class="fa fa-print"></i></button></td> 
                                            </form>      
                                        </tr>
                                        
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />
