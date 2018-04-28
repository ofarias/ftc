<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Pedidos Anticipados.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Clave</th>
                                            <th>Fehca Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Factura </th>
                                            <th>Fecha Factura </th>
                                            <th>Recibidos</th>
                                            <th>Empacados</th>
                                            <th>Faltante</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pedidos as $data): ?>
                                       <tr>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data->NOM_CLI;?></td>
                                            <td><?php echo $data->CLIEN;?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->FECHA_FACT;?></td>
                                            <td><?php echo $data->RECIBIDO;?></td>
                                            <td><?php echo $data->EMPACADO;?></td>
                                            <td><?php echo $data->FALTANTE;?></td>
                                            <td>
                                                <form action="index.php" method="post">
                                                   <input name="doc" type="hidden" value="<?php echo $data->COTIZA?>" />                                           
                                                   <button name="preparamaterial" type="submit" value="enviar" class="btn btn-warning">Preparar <i class="fa fa-th-large"></i></button></td>
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
