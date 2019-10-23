<?php foreach($info as $data){
    $uuid = $data->UUID;
    $folio=$data->FOLIO;
    $rfce=$data->RFCE;
    $cliente=$data->CLIENTE;
    $monto=$data->MONTO;
    $fecha=$data->FECHA;
    $forma=$data->FORMA;
    $rbb=$data->RFC_BANCO_BENEFICIARIO;
    $cb=$data->CTA_BENEFICIARIO;
    $no=$data->NUMOPERACION;
    $rbo=$data->RFC_BANCO_ORDENANTE;
    $co=$data->CTA_ORDENANTE;
    }
?>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del Recibo Electronico de Pago.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Folio<br/>UUID</th>
                                            <th>Emisor</th>
                                            <th>Receptor</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                            <th>Forma Pago</th>
                                            <th>Banco Receptor</th>
                                            <th>Cuenta Receptor</th>
                                            <th>No Operacion</th>
                                            <th>Banco Emisor</th>
                                            <th>Cuenta Emisor</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <tr>
                                            <td><?php echo $folio;?><br/><?php echo $uuid?></td>
                                            <td><?php echo $rfce;?></td>
                                            <td><?php echo $cliente;?></td>
                                            <td align="right"><font color="blue"><b><?php echo '$ '.number_format($monto,2);?></b></font></td>
                                            <td><?php echo $fecha;?></td>
                                            <td><?php echo $forma?></td>
                                            <td><?php echo $rbb;?></td>
                                            <td><?php echo $cb;?></td>
                                            <td><?php echo $no?></td>
                                            <td><?php echo $rbo?></td>
                                            <td><?php echo $co?></td>
                                        </tr>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del Recibo Electronico de Pago.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Documento</th>
                                            <th>Fecha Documento</th>
                                            <th>UUID</th>
                                            <th>Saldo Anterior</th>
                                            <th>Aplicacion</th>
                                            <th>Saldo Insoluto</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($info as $data): 
                                            ?>
                                        <tr>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DOC;?></td>
                                            <td><?php echo $data->FECHA_DOC?></td>
                                            <td><?php echo $data->ID_DOCUMENTO;?></td>
                                            <td align="right"><font color="blue"><b><?php echo '$ '.number_format($data->SALDO_ANTERIOR,2);?></b></font></td>
                                            <td align="right"><font color="red"><b><?php echo '$ '.number_format($data->APLICACION,2);?></b></font></td>
                                            <td align="right"><font color="black"><b><?php echo '$ '.number_format($data->SALDO_INSOLUTO,2);?></b></font></td>
                                            
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