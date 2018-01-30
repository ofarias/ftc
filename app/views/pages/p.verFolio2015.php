<div class="row">
  <br />
</div>
<div class="row">
  <div class="col-md-6">
    <form action="index.php" method="post">
      <div class="form-group">
        <input type="text" name="docf" class="form-control" placeholder="Numero de Factura">
      </div>
      <button type="submit" value = "enviar" name = "traeFactura" class="btn btn-default">Buscar</button>
      </form>
  </div>
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
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA FACTURACION</th>
                                            <th>IMPORTE</th>
                                            <th>APLICADO</th>
                                            <th>SALDO</th>
                                            <th>PAGO</th>
                                            <th>FECHA EDO CTA</th>
                                            <th>MONTO PAGO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($folios as $datos): 
                                          ?>
                                       <tr>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td align="center"><?php echo number_format($datos->IMPORTE,2);?></td>
                                            <td><?php echo number_format($datos->APLICADO,2);?></td>
                                            <td><?php echo number_format($datos->SALDOFINAL,2);?></td>
                                            <td><?php echo '('.$datos->ID_PAGOS.')'.$datos->FOLIO_X_BANCO;?></td>
                                           <td><?php echo $datos->FECHA_RECEP?></td>
                                           <td><?php echo number_format($datos->MONTO,2)?></td>
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>