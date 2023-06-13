<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-ocf">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>

                                            <th>Orden de Compra</th>
                                            <th>Fecha</th>
                                            <th>Descripcion <br/> Producto <br/> Id</th>
                                            <th>Motivo</th>
                                            <th>Cant<br/>Fallida</th>
                                            <th>Costo</th>
                                            <th>Descuento</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 

                                        $i=0;
                                        foreach ($docf as $data): 
                                           $i++; 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $i;?></td>
                                            <td> <?php echo $data->OC;?> <br/> <a href="index.php?action=detalleOC&doco=<?php echo $data->OC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1800,height=820'); return false;" >Ver Original</a> </td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DESCRIPCION.'<br/>'.$data->ART.'<br/>'.$data->IDPREOC;?></td>
                                            <td><?php echo $data->MOTIVO;?></td>
                                            <td><?php echo $data->CANTIDAD?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->DESCUENTO,2)?></td>
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