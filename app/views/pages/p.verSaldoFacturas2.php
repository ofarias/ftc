<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Pago a Aplicar.
            </div>

  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Pago</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>IMPORTE</th>
                                            <th>Saldo</th>
                                
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($verPago as $data):
                                            $id=$data->ID;
                                            $monto=$data->SALDO;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.$data->MONTO;?></td>
                                            <td><?php echo '$ '.$data->SALDO;?></td>     
                                        </tr>
                                        
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID pago</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo '$ '.$data->IMPORTE;?></td>
                                            <td><?php echo '$ '.$data->SALDO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="clie" type="hidden" value="<?php echo $data->CVE_CLPV?>"/>
                                            <input name="idpago" type="hidden" value="<?php echo $id?>" />
                                            <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC;?>" />
                                            <input type="hidden" name="monto" value="<?php echo $monto;?>" />
                                            <input type="hidden" name="saldof" value="<?php echo $data->SALDO?>" />
                                            <input type="hidden" name="rfc" value="<?php echo $data->RFC?>" />
                                            <td>
                                                <button name="aplicaPagoFactura" type="submit" value="enviar" class="btn btn-warning">Pagar <i class="fa fa-money"></i></button></td> 
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

