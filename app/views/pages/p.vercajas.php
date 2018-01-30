<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-cajas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CP</th> 
                                            <th>Fecha Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Fecha Apertura Caja</th>
                                            <th>Factura o Remision </th>
                                            <th>Embalaje Completo?</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->ID;?></a></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
											<td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo ($data->EMBALAJE == 'TOTAL')? 'Si':'No';?></td>
  
                                            <td>
                                            	<form action="index.php" method="post">
                                            	   <input name="idcaja" type="hidden" value="<?php echo $data->ID?>" /> 
                                                   <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            	   <button name="cerrarcaja" type="submit" value="enviar" class="btn btn-warning" <?php echo ($data->EMBALAJE == 'TOTAL') ? '':'disabled';?> >Cerrar <i class="fa fa-th-large"></i></button></td>
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
