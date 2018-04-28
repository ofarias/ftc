<div class="row">
  <br />
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Facturas
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>ANTERIOR</th>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA FACTURACION</th>
                                            <th>IMPORTE</th>
                                            <th>SALDO</th>
                                            <th>STATUS LOGISTICA</th>
                                            <th>STATUS ADUANA</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($factura as $datos): 
                                          ?>
                                       <tr>
                                            <td><?php echo $datos->DOC_ANT?></td>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td><?php echo $datos->IMPORTE;?></td>
                                            <td><?php echo $datos->SALDO;?></td>
                                            <td><?php echo $datos->STATUS_LOG;?></td>
                                            <td><?php echo $datos->ADUANA;?></td>
                                           
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Partida Facturas.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>PARTIDA</th>
                                            <th>PRODUCTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO</th>
                                            <th>SUBTOTAL</th>
                                            <th>IVA</th>
                                            <th>TOTAL</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($detalleFactura as $datos): 
                                          ?>
                                       <tr>
                                            <td><?php echo $datos->NUM_PAR;?></td>
                                            <td><?php echo $datos->CVE_ART?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->CANT;?></td>
                                            <td><?php echo number_format($datos->PREC,2);?></td>
                                            <td><?php echo number_format($datos->CANT * $datos->PREC,2);?></td>
                                            <td><?php echo number_format(($datos->CANT*$datos->PREC) * .16,2);?></td>
                                            <td><?php echo number_format(($datos->CANT*$datos->PREC) * 1.16,2);?></td>
                                            
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>