<br>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="campo" class="form-control" placeholder="Numero de Factura"/>
            </div>
          <button type="submit" value = "enviar" name = "buscarPagos" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>
<br />
<br />

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Resultados encontrados.
            <br>
            Seleccione el pago a cancelar.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Pago</th>
                                            <th>Banco</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto</th>
                                            <th>Saldo</th>              
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($res as $data):
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td>
                                            <form action = "index.php" method="post">
                                                <input type="hidden" name="idp" value= "<?php echo $data->ID?>" />
                                                <button value="submit" name = "cancelarPago" type="submit" <?php echo ($data->MONTO == $data->SALDO)? 'class="bnt btn-danger"':'class="bnt btn-success"' ?>  <?php echo ($data->MONTO == $data->SALDO)? '':'disabled = "disabled"' ?>> <?php echo ($data->SALDO != $data->MONTO)? 'Aplicado':'Cancelar'?> </button>
                                            </td> 
                                            </form>    
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>




