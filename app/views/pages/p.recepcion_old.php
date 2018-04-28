<div class="row">
	<br />
</div>

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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>Orden de Compra</th>
                                            <th>Recepcion</th>
                                            <th>Proveedor</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Fecha Recoleccion</th>
                                            <th>Estado Recoleccion</th>
                                            <th>Fecha Recepcion</th>
                                            <th>Estado de la Recepcion</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($Recepciones as $data): 
                                            /*$color=$data->ORDENADO;
                                            $color2=$data->RECEPCION;
                                            if ($color == '0'){
                                               $color="style='background-color:yellow;'";             
                                            }elseif($color2=='0'){
                                            $color="style='background-color:#FFBF00;'";
                                            }*/
                                            

                                            ?>
                                        <tr class="odd gradeX"> <!-- <?php echo $color;?>>-->
                                       
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->ENLAZADO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="doc" type="hidden" value="<?php echo $data->RECEPCION?>"/>
                                            <td>
                                                <button name="imprimeRecepcion" type="submit" value="enviar" class="btn btn-warning">Imprime Comprobante! <i class="fa fa-print"></i></button></td> 
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