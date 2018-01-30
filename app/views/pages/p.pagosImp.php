<div class="row">
	<br />
</div>

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos en Efectivo
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                        	<th>Orde de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Monto</th>
                                            <th>Estatus</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($efectivosImp as $data): 
    
                                                ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->EFECTIVO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->STATUS;?></td> 
                                            <td><center><a href="index.php?action=imprimeEfectivo&id=<?php echo $data->ID;?>&doc=<?php echo $data->DOCUMENTO;?>"><i class="fa fa-print"></i></a></center></td>                                              
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
			          </div>
			</div>
		</div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Pagos por Transferencias
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Orde de Compra</th>
                                            <th>Proveedor</th>
                                            <th>CLABE</th>
                                            <th>Telefono</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Monto</th>
                                            <th>Estatus</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($transImp as $data): 
                                            ?>
                                        <tr class="odd gradeX" >
                                            <td><?php echo $data->TRANS;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td><?php echo $data->CLABE;?></td>
                                            <td><?php echo $data->TELEFONO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><center><a href="index.php?action=imprimeTrans&id=<?php echo $data->ID;?>&doc=<?php echo $data->DOCUMENTO;?>"><i class="fa fa-print"></i></a></center></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                
                            </div>
			          </div>
			</div>
		</div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos por Cheques
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Orde de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Fecha Aplicacion</th>
                                            <th>Monto</th>
                                            <th>Estatus</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($chequesImp as $data): 

                                            ?>
                                        <tr class="odd gradeX" >
                                            <td><?php echo $data->CHEQUE;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->FECHA_APLI;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><center><a href="index.php?action=imprimeCheque&id=<?php echo $data->ID;?>&doc=<?php echo $data->DOCUMENTO;?>"><i class="fa fa-print"></i></a></center></td>
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
                            Pagos A Credito
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Orde de Compra</th>
                                            <th>Proveedor</th>
                                            <th>CLABE</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Fecha Aplicacion</th>
                                            <th>Monto</th>
                                            <th>Estatus</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($creditosImp as $data): 

                                            ?>
                                        <tr class="odd gradeX" >
                                            <td><?php echo $data->CREDITO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->BENEFICIARIO;?></td>
                                            <td><?php echo $data->CLABE;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->FECHA_APLI;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                           <td><center><a href="index.php?action=imprimeCredito&id=<?php echo $data->ID;?>&doc=<?php echo $data->DOCUMENTO;?>"><i class="fa fa-print"></i></a></center></td>
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