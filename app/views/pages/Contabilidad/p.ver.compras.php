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
                                            <th>Compra Con:</th>
                                            <th>Proveedor</th>
                                            <th>Monto</th>
                                            <th>Orden de Compra</th>
                                            <th>Recepciones SAE</th>
                                            <th>Tipo Solicitud</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Banco</th>
                                            <th>Usuario</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($compras as $data): 
                                            if($data->STATUS == 'I'){
                                                $STATUS = 'IMPRESO';
                                            }
                                            if(substr($data->FOLIO, 0,2) == 'ch'){
                                                $tipo = 'Cheque';
                                            }elseif(substr($data->FOLIO, 0,2)== 'tr'){
                                                $tipo = 'Transferencia';
                                            }elseif (substr($data->FOLIO, 0,1)== 'e'){
                                                $tipo = 'Efectivo';
                                            }

                                            ?>
                                        <tr>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $tipo;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td></td>
                                            <td><?php echo $STATUS;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->BANCO?></td>
                                            <td><?php echo $data->USUARIO_PAGO?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <button name="recConta" value = "enviar" type="submit" class="btn btn-danger">Recibir</button>
                                            </td>
                                            <input name="folio" type="hidden" value="<?php echo $data->FOLIO?>"/>
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
