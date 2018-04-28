<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Solicitudes Pendientes.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>COTIZACION</th>
                                            <th>VENDEDOR</th>
                                            <th>CLIENTE</th>
                                            <th>SALDO CORRIENTE</th>
                                            <th>SALDO VENCIDO</th>
                                            <th>FECHA SOLICITUD</th>
                                            <th>IMPORTE</th>
                                            <th>COSTO</th>
                                            <th>UTILIDAD</th>
                                            <th>EJECUTAR</th>
                                            <!--<th></th>
                                            <th>UTILIDAD AUTORIZADA</th>
                                            <th>AUTORIZAR</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pendientes as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->SERIE.$data->FOLIO;?></td>
                                            <td><?php echo $data->CDUSUARI;?></td>
                                            <td><?php echo '('.$data->CVE_CLIENTE.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->SALDO_CORRIENTE?>
                                            <td><?php echo $data->SALDO_VENCIDO?></td>
                                            <td><?php echo $data->FECHA_SOL_LIB;?></td>
                                            <td><?php echo $data->DBIMPTOT;?></td>
                                            <td><?php echo $data->COSTO;?></td>
                                            <td><?php echo number_format(($data->DBIMPTOT - $data->COSTO),2);?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="folio" value="<?php echo $data->CDFOLIO;?>"/>
                                            <input type="hidden" name="respuesta" value="LIBERADO">
                                            <button name="deslib" type="submit" value="enviar" class="btn-xs btn-success"> 
                                                Autorizar</button> <br/>
                                            </form>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="folio" value="<?php echo $data->CDFOLIO;?>">
                                            <input type="hidden" name="respuesta" value="RECHAZADO">
                                            <button name="desLib" type="submit" value="enviar" class="btn-xs btn-danger"> Denegar </button>
                                            </form>
                                            </td> 
                                            
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                    
            </div>
        </div>
    </div>
</div>
