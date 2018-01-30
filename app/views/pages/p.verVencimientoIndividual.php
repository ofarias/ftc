<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               <label><?php echo $descripcion?></label>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Clave</th>
                                            <th>Nombre Cliente</th>
                                            <th>Cartera</th>
                                            <th>Saldo Vencido</th>
                                            <th>Ver Detalle</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($individual as $data):
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td  align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input type="hidden" name="cliente" value="<?php echo $data->CVE_CLPV?>">
                                                <button value="enviar" type="submit" name="DetalleCliente" class="btn btn-info"> Detalle </button>
                                            </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
    </div>
</div>
