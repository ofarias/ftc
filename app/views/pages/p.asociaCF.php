<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Aplicar Cargo Financiero
            </div>

  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Banco / Cuenta</th>
                                            <th>Fecha de Cargo</th>
                                            <th>Importe</th>
                                            <th>Saldo</th>
                                           
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($cf as $data):
                                            $idcf = $data->ID;
                                            $montoc = $data->SALDO;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->BANCO;?> / <?php echo $data->CUENTA?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>  
                                            <
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
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="monto" class="form-control"  placeholder="Buscar Pago por Monto">
            <input type="hidden" name="idcf" value ="<?php echo $idcf;?>" />
          </div>
          <button type="submit" name = "traePagos" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>
<?php if($pagos){ 
?>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Pago a Aplicar.
            <br>
            <br>
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
                                            <th>Carga </th>              
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($pagos as $data):
                                            $id=$data->ID;
                                            $monto=$data->SALDO;
                                            $tipo=$data->CLIENTE;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <form acction="index.php" method="post">
                                            <input type="hidden" name="idp" value ="<?php echo $data->ID?>" />
                                            <input type="hidden" name="idcf" value ="<?php echo $idcf;?>" />
                                            <input type="hidden" name="montoc" value ="<?php echo $montoc;?>" />
                                            <td>
                                                <button name="cargaCF" type="submit" value = "enviar" class="bnt btn-warning"> Carga CF</button>
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
<br />
<?php }else{ 
    ?>
<div>
    <label> No se encontraron pagos con los criterios de busqueda.</label>
</div>
<?php }?>

