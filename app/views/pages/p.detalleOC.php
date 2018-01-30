<div class="row">
	<br />
</div>
<!--<div class="row">
	<div class="col-md-6">
		<form action="index.php" method="post">
		  <div class="form-group">
		    <input type="text" name="ped" class="form-control" id="pedido" placeholder="Numero de Pedido">
		  </div>
		  <button type="submit" id="pedido" class="btn btn-default">Buscar</button>
		  </form>
	</div>
</div>-->
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>DOCUMENTO</th>
                                            <th>NOMBRE</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>IMPORTE</th>
                                            <th>HOY</th>
                                            <th>DIAS</th>
                                            <th>TIPO</th>
                                            <th>FOLIO PAGO</th>
                                            <th>MONTO PAGO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($cabecera as $data): 
                                            $TIME = time();
                                            $HOY = date("Y-m-d H:i:s", $TIME); 
											if($data->CAMPLIB2 == 'E')
												$tipo = 'Entrega';
												elseif($data->CAMPLIB2 == 'R')
													$tipo = 'Recolección';
												else 
													$tipo = 'No reconocido'; ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CAN_TOT;?></td>
                                            <td><?php echo $HOY;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $tipo;?></td>
                                            <td><?php echo $data->TP_TES?></td>
                                            <td><?php echo $data->PAGO_TES?></td>                                                  
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalle Documento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ORDEN</th>
                                        	<th>PARTIDA</th>
                                            <th>CLAVE</th>
                                            <th>DESCRIPCION</th>
                                            <th>CANTIDAD</th>
                                            <th>PXR</th>
                                            <th>COSTO</th>
                                            <th>ESTADO</th>
                                            <th>RECEPCION</th>
                                            <th>FECHA DE RECEPCION DE DOC</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($detalle as $data): 

                                            $color = $data->PXR;
                                            if ($color > 0){
                                                $color = "style='background-color:yellow;'";
                                            }

                                            if($data->STATUS == 'L'){
                                                $status = 'Liberado (Por Solicitar o en otra Orden)';
                                            }else{
                                                $status='En proceso';
                                            }

                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><a href="index.php?action=historiaIDPREOC&id=<?php echo $data->ID_PREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID_PREOC;?></a></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $status;?></td>
                                            <td><?php echo $data->RECEP;?></td>
                                            <td><?php echo $data->FECHA_DOC_RECEP;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                <a href="index.php?action=imprimeOC&oc=<?php echo $data->CVE_DOC?>"><button class="btn"><img src="http://icons.iconarchive.com/icons/iconshow/hardware/64/Printer-icon.png"></button></a>
                                    <!--<button onclick="window.print()" >Imprimir! <img src="http://icons.iconarchive.com/icons/iconshow/hardware/64/Printer-icon.png"></button>-->
                                </div>
                                </div>
                                
                            </div>
                            <!-- /.table-responsive -->
			          </div>
			</div>
		</div>
</div>
