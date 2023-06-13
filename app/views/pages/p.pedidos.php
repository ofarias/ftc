<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Pedidos pendientes de Facturar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CLAVE DEL CLIENTE:</th>
                                            <th>CP</th>
                                            <th>Fehca Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Recibidos</th>
                                            <th>Empacados</th>
                                            <th>Facturado</th>
                                            <th>Pendiente</th>
                                            <th>Remisionado</th>
                                            <th>Pendiente <br/> Remisionar</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pedidos as $data): 
                                        
                                        $faltante = $data->FALTANTE;
                                        $recibido = $data->RECIBIDO;
                                        $facturado = $data->FACTURADO;
                                        $remisionado = $data->REMISIONADO;
                                        $pfact = $data->PENFACT;
                                        $prem = $data->PENREM;
                                        if ($faltante == 0){
                                            $color = "style='background-color: #A9F5BC;'";    
                                        }
                                        
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>           
                                       
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->COTIZA?>"><?php echo $data->COTIZA;?></a></td>
                                            <td><?php echo $data->NOM_CLI;?></td>
                                            <td><?php echo $data->CLIEN;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->RECIBIDO;?></td>
                                            <td><?php echo $data->EMPACADO;?></td>
                                            <td><?php echo $data->FACTURADO;?></td>
                                            <td><?php echo $data->PENFACT;?></td>
                                            <td><?php echo $data->REMISIONADO;?></td>
                                            <td><?php echo $data->PENREM;?></td>
                                            <td>
                                                <form action="index.php" method="post">
                                                   <input name="doc" type="hidden" value="<?php echo $data->COTIZA?>" />                                           
                                                   <button name="preparamaterial" type="submit" value="enviar" class="btn btn-warning">Preparar <i class="fa fa-th-large"></i></button></td>
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
