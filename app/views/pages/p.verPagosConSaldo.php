<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Listado de Pagos con Saldo.
            <br>
            <br>
            El pago se enviara a la cuenta de acreedores y no estara disponible para su aplicacion a los cliente.
            <br/>
            <br>
            Para enviar por RFC Generico colocar XXX-AAA-XXX.
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
                                            <th>Enviar a Acreedor</th>              
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
                                            <form action = "index.php" method="post">
                                            <td><?php echo $data->ID;?></td>
                                            <td>
                                            <input type="text" name="rfc" <?php echo (empty($data->CLIENTE))? 'placeholder = "RFC del Cliente"': 'readonly = "readonly"'?> value ="<?php echo $data->CLIENTE?>" required = "required"/>
                                           </td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td> 
                                            
                                                <input type="hidden" name="idp" value ="<?php echo $data->ID?>" />
                                                <input type="hidden" name="saldo" value ="<?php echo $data->SALDO?>" />
                                                <td>
                                                    <button name = "enviaAcreedor" value="enviar" type ="submit" class ="btn btn-warning"> Acreedores </button>
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

