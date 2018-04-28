<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Ruta Cobranza Cierre No Pagadas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Inicio</th>
                                            <th>Fin</th>
                                            <th>Valor</th>
                                            <th>Cobros Al dia</th>
                                            <th>Usuario</th>
                                            <th>Documentos</th>
                                            <th>Cartera</th>
                                            <th>Ver</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($rutas as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $data->FECHA_INICIO;?></td>
                                            <td><?php echo $data->FECHA_FIN;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->VALOR_ESTIMADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->VALOR_CUMPLIDO,2);?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->DOCUMENTOS;?></td>
                                            <td><?php echo $data->CARTERA;?></td>

                                            <form action="index.php" method ="post">
                                            <td>
                                                <input type="hidden" name="idf" value="<?php echo $data->FOLIO?>">
                                                <input type="hidden" name="cierre" value="1" >
                                                <button name="verPartidasRuta" value="enviar" type="submit"> VER <i class="fa fa-file"></i></button>
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
</div>