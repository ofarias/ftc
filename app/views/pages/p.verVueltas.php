<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de productos Asignados automaticamente;
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th align="center"> Caja </th>
                                            <th align="center">Pedido </th>
                                            <th>Documento</th>
                                            <th>Unidad</th>
                                            <th align="center">Operador</th>
                                            <th align="center">Fecha </th>
                                            <th>Vuelta</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $totalVales = 0;
                                        foreach ($vueltas as $data):    
                                            ?>
                                        <tr>
                                            <td align="center"><?php echo $data->CAJA?></td>
                                            <td align="center"><?php echo $data->PEDIDO;?></td>
                                            <td> <?php echo $data->DOCUMENTO?></td>
                                            <td> <?php echo $data->UNIDAD?> </td>
                                            <td align="center"><?php echo $data->CHOFER;?></td>
                                            <td align="center"><?php echo $data->FECHA?></td>
                                            <td align="center"><font size="3pxs" color="red"><n><?php echo $data->VUELTA?></n></font></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody></font></label>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br/>