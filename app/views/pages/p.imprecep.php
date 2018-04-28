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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recep">
                                    <thead>
                                        <tr>
                                            <th>Orden de Compra</th>
                                            <th>Recepcion</th>
                                            <th>Proveedor</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Fecha Recepcion</th>
                                            <th>Monto Doc SAE</th>
                                            <th>Monto Factura Proveedor</th>
                                            <th>Saldo del Documento</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($Recepciones as $data): 

                                            $toto=$data->CAN_TOT;
                                            $totv=$data->COST_REC;
                                            $saldo = ($toto - $totv) * -1 ;
                                            $color = "style='background-color:white;'";
                                            $s= (float) 10;

                                            if ((float)$saldo < $s){
                                                  $color = "style='background-color:orange;'";
                                            }                
                                            ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CAN_TOT;?></td>
                                            <td><?php echo $data->COST_REC;?></td>
                                            <td><?php echo $saldo;?></td>
                                            <form action="index.php" method="post">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="doco" type= "hidden" value="<?php echo $data->OC?>"/>
                                            <td>
                                                <button name="impSadoRec" type="submit" value="enviar" class="btn btn-warning" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button></td> 
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