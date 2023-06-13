<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Acreedores pendientes de contabilizar.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                           
                                            <th>Pago</th>
                                            <th>Folio Banco</th>
                                            <th>Monto Original</th>
                                            <th>Cliente / Clave</th>
                                            <th>Fecha Estado de Cuenta</th>
                                            <th>Monto</th>
                                            <th>Monto Aplicado</th>
                                            <th>Saldo</th>
                                            <th>Status</th>
                                            
                                            <th>Reasignar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($acreedores as $data): 

                                            if($data->STATUS == 0){
                                                $status='Vigente';
                                            }else{
                                                $status='Cancelado';
                                            }
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                           
                                            <td><?php echo $data->ID_PAGO?></td>
                                            <td><?php echo $data->FOLIO_X_BANCO?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO_ORIGINAL,2)?></td>
                                            <td><?php echo '('.$data->CLIENTE.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->APLICADO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2)?></td> 
                                            <td><?php echo $status;?></td>   
                                           
                                            <form action="index.php" method="post">
                                            <input name="ida" type="hidden" value="<?php echo $data->ID_PAGO?>"/> 
                                            <input name="saldo" type="hidden" value="<?php echo $data->SALDO?>"/>
                                            <input type="hidden" name="clie2" value="<?php echo $data->CLIENTE?>">                     
                                            <td>
                                               <input type="text" name="clie1" class="clie" required="required" >
                                                <button name="reasignaAcreedor" type="submit" value="enviar" class="btn btn-warning"  <?php echo ($data->APLICADO > 1)? 'disabled="disabled"':'' ?>   >Reasignar<i class="fa fa-money"></i></button></td> 
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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    
$(".clie").autocomplete({
        source: "index.php?cliente=1",
        minLength: 2,
        select: function(event, ui){
        }
    })

</script>
