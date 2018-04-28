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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Pago</th>
                                            <th>Folio Banco</th>
                                            <th>Cliente / Clave</th>
                                            <th>Fecha Estado de Cuenta</th>
                                            <th>Monto</th>
                                            <th>BANCO</th>
                                            <th>Recibir y Contabilizar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($acreedores as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->PAGO?></td>
                                            <td><?php echo $data->FOLIO_X_BANCO?></td>
                                            <td><?php echo $data->CL;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="ida" type="hidden" value="<?php echo $data->ID?>"/>
                                            <input name="cliente" type="hidden" value="<?php echo $data->CL?>">
                                            <td>
                                                <button name="contabilizarAcreedor" type="submit" value="enviar" class="btn btn-warning"> Recibir y Contabilizar <i class="fa fa-money"></i></button></td> 
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

