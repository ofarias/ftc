<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Factura a Saldar
            </div>

  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Factura</th>
                                            <th>Fecha Documento</th>
                                            <th>Fecha FACTURA</th>
                                            <th>IMPORTE</th>
                                            <th>Saldo</th>
                                
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($factura as $data):
                                        $docf =$data->CVE_DOC;
                                        $saldof=$data->SALDO; 
                                        $cliente =$data->CVE_CLPV;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo '$ '.$data->IMPORTE;?></td>
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
                            Pagos Registrados al Estado de cuenta.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID pago</th>
                                            <th>Cliente</th>
                                            <th>Fecha Edo de Cuenta</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>BANCO</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($pagos as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.$data->MONTO;?></td>
                                            <td><?php echo '$ '.$data->SALDO;?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="clie" type="hidden" value="<?php echo $cliente?>"/>
                                            <input name="idpago" type="hidden" value="<?php echo $data->ID?>" />
                                            <input name="docf" type="hidden" value="<?php echo $docf;?>" />
                                            <input type="hidden" name="monto" value="<?php echo $data->SALDO;?>" />
                                            <input type="hidden" name="rfc" value="<?php echo $data->RFC?>" />
                                            <input type="hidden" name="saldof" value="<?php echo $saldof?>" />
                                            <td>
                                                <button name="aplicaPagoxFactura" type="submit" value="enviar" class="btn btn-warning">Pagar <i class="fa fa-money"></i></button></td> 
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

