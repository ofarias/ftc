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
                                            <th>SALDO</th>
                                            <th>STATUS LOGISTICA</th>
                                            <th>STATUS ADUANA</th>
                                            <th>ENVIA A:</th>
                                            <th>Enviar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($factura as $datos): 
                                          ?>
                                       <tr>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td><?php echo $datos->IMPORTE;?></td>
                                            <td><?php echo $datos->SALDO;?></td>
                                            <td><?php echo $datos->STATUS_LOG;?></td>
                                            <td><?php echo $datos->ADUANA;?></td>
                                            <form action="index.php" method="POST">
                                            <td>
                                              <select name="tipo">
                                                  <option value = "C">Cobranza</option>
                                                  <option value = "R">Revision</option>
                                              </select> 
                                            </td>
                                            <td>
                                            <input name= "docf1" type="hidden" value="<?php echo $datos->CVE_DOC;?>"/>
                                              <button name="cambiarFactura" type = "submit" value = "enviar">Cambiar</button>
                                            </td>
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