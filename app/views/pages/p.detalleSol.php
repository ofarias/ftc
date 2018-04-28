<br />

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitud
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>FOLIO</th>
                                            <th>NOMBRE</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>BANCO</th>
                                            <th>MONTO</th>
                                            <th>FECHA SOLICITUD</th>
                                            <th>TIPO PAGO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        //var_dump($exec); 
                                        foreach ($sol as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->IDSOL;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td ><?php echo $data->BANCO;?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->TIPO;?></td>
                                            <td><?php echo $data->USUARIO;?></td>        
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
<br>
<br>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones de la Solicitud
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>DOCUMENTO</th>
                                            <th>NOMBRE</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>SUBTOTAL</th>
                                            <th>TOTAL</th>
                                            <th>HOY</th>
                                            <th>DIAS</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($solicitud as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->CAN_TOT,2);?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
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
<br /><br />
