<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestro   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Sucursales</th>
                                            <th>Cartera Revision</th>
                                            <th>Cartera Cobranza</th>
                                            <th>Saldo 2015</th>
                                            <th>Saldo 2016 </th>
                                            <th>Saldo 2017 </th>
                                            <th>Acreedores</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($infoMaestro as $data):
                                        $TOTAL= $data->SALDO_2015 + $data->SALDO_2016 + $data->SALDO_2017 - $data->ACREEDOR;
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->SUCURSALES;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td><?php echo $data->CARTERA_REVISION;?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_2015,2)?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_2016,2)?></td>                                        
                                            <td><?php echo '$ '.number_format($data->SALDO_2017,2 )?></td>
                                            <td><?php echo '$ '.number_format($data->ACREEDOR,2)?></td>
                                            <td><?php echo '$ '.number_format($TOTAL,2)?></td>
                                             
                                        </tr>
                                        </form>
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

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documentos del Maestro.   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                           
                                            <th>CLiente <br/> Clave</th>
                                            <th>Factura <br/> Fecha </th>
                                            <th>Saldo <br/> Importe</th>
                                            <th>Pagos <br/> Id</th>
                                            <th>Importe NC <br/> Nota de Credito</th>
                                            <th>Año</th>
                                            <th>Banco <br/> Folio Banco </th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto Pago <br/> Saldo Pago </th>
                                            <th> Acreedor <br/> Monto Acreedor -- Saldo </th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($docs as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CLIENTE;?> <br/> (<?php echo $data->CLAVE?>) </td>
                                            <td><?php echo $data->CVE_DOC.'('.$data->STATUS.')';?> <br/> (<?php echo $data->FECHA_DOC?> )</td>
                                            <td><?php echo '$ '.number_format($data->SALDOFINAL,2);?> <br/> (<?php echo '$ '.number_format($data->IMPORTE,2)?>)</td>
                                            <td><?php echo '$ '.number_format($data->APLICADO,2);?> <br/> (<?php echo $data->ID_PAGOS?>)</td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE_NC,2);?> <br/> (<?php echo $data->NC_APLICADAS?>)</td>
                                            <td><?php echo $data->ANIO?></td>
                                            <td><?php echo $data->BANCO?> <br/> <?php echo $data->FOLIO_X_BANCO?></td>
                                            <td><?php echo $data->FECHA_RECEP?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2)?> <br/> <?php echo number_format($data->SPAGO,2)?> </td>
                                            <td><?php echo $data->IDA.' ($ '.$data->MA.' )'?> <br/> <?php echo number_format($data->SA,2) ?></td>
                                            <td>
                                                                                         
                                        </tr>
                                        </form>
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

