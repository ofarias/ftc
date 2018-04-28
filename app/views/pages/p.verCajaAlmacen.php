<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <font size="5px"> Informacion General del Pedido <?php echo $pedido?></font>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> ID <br/> Seguimiento</th>
                                            <th>Descripcion</th>
                                            <th> Cotizacion </th>
                                            <th> Status </th>
                                            <th> Fecha Cotizacion </th>
                                            <th> Cantidad <br/> del Pedido</th>
                                            <th> Cantidad <br/> por solicitar</th>
                                            <th> Cantidad <br/> Recepcionada </th>
                                            <th> Pendiente de <br/> Recepcionar </th>
                                            <th> En Almacen </th>
                                            <th> Empacado </th>
                                            <th> Remisionado </th>
                                            <th> Facturado </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($id as $data):
                                            if($data->STATUS == 'P'){
                                                 $statusID = 'Pendiente en Liberacion';     
                                            }elseif ($data->STATUS == 'N') {
                                                $statusID = 'Suministros';
                                            }elseif ($data->STATUS == 'B' and $data->REC_FALTANTE > 0 ) {
                                                $statusID = 'Ordenado';
                                            }elseif ($data->STATUS == 'S') {
                                                $statusID = 'No Suministrables';
                                            }elseif ($data->STATUS == 'B' and $data->REC_FALTANTE <= 0) {
                                                $statusID='Completo';
                                            }elseif($data->STATUS == 'X'){
                                                $statusID= 'En Pre Orden';
                                            }elseif($data->STATUS == 'F'){
                                                $statusID='Producto liberado por Tesoreria s(Costos)';
                                            }else{
                                                $statusID = 'Error Reportar a Sistenas';
                                            }

                                            $enAlmacen = $data->RECEPCION - $data->EMPACADO;

                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=historiaIDPREOC&amp;id=<?php echo $data->ID?>" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID?></a></td>

                                            <td><font size="4px"><b><?php echo $data->NOMPROD;?></b></font></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $statusID?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td align="center"><?php echo ($data->CANT_ORIG);?></td>
                                            <td align="center"><?php echo $data->REST?></td>
                                            <td align="center"><?php echo $data->RECEPCION?></td>
                                            <td align="center"><?php echo $data->REC_FALTANTE;?></td>
                                            <td align="center"><font color="red" size="4px"><?php echo $enAlmacen?></font></td>
                                            <td align="center"><?php echo $data->EMPACADO?></td>
                                            <td align="center"><?php echo $data->REMISIONADO?></td>
                                            <td align="center"><?php echo $data->FACTURADO?></td>
                                        </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
