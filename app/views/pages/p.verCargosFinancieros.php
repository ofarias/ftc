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
                                            <th>Aplicar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($cf as $data):
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->BANCO;?> / <?php echo $data->CUENTA?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>  
                                            <form action = "index.php" method = "post">
                                            <input type="hidden" value ="<?php echo $data->ID?>" name = "idcf" />
                                            <input type="hidden" name="rfc" value ="<?php echo $data->RFC?>" />
                                            <input type="hidden" name="banco" value="<?php echo $data->BANCO?>" />
                                            <input type="hidden" name="cuenta" value="<?php echo $data->CUENTA?>" />
                                            <td>
                                               <button name="asociarCF" value="enviar" type = "submit" class = "btn btn-warning"> Asociar</button> 
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


