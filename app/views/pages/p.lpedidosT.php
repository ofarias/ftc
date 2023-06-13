<meta http-equiv="Refresh" content="240">
<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Catalogo de Inventarios Almacen 9
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>PEDIDO</th>
											<th>CLIENTE</th>
                                            <th>URGE</th>
                                            <th>TOTAL</th>
                                            <th>FECHA</th>
                                            <th>HOY</th>
                                            <th>DIAS TRANSCURRIDOS</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php

                                    	foreach ($exec as $data): 
                                            $color = $data->DIAS;
                                            $urgencia = $data->URGENTE;
                                            if ($color=='3' and $urgencia == ''){
                                               $color="style='background-color:yellow;'";             
                                            }elseif($color>'3' and $urgencia == ''){
                                            $color="style='background-color:#FFBF00;'";
                                            }elseif ($color == '3' and $urgencia == 'U'){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color > '3' and $urgencia == 'U'){
                                            $color="style='background-color:#81DAF5;'";
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><a href="index.php?action=pedidodet&doc=<?php echo $data->COTIZA?>"><?php echo $data->COTIZA;?></a></td>
											<td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->URGENTE;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->HOY;?></td>
                                            <td><?php echo $data->DIAS;?></td>   
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