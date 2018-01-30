<br><br>
<div class="form-horizontal">
<div class="panel panel-default">
    <div class="panel panel-heading">
        <h4>Busqueda</h4>
    </div>
<div class="panel panel-body">
        
        <form action="index.php" method="get"> 
            <div class ="form-group">
                <label for="buscarPedido" class="col-lg-1 control-label">Pedido: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="buscarPedido" maxlength="20" />   
                    </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <button type="submit" name="action" value="MuestraCaja" class="btn btn-info">Buscar <i class="fa fa-search"></i></button>
                 </div>
            </div>
        </form>
    </div>
</div>
</div>

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas: 
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>CAJA</th>
                                            <th>Documento</th>
                                            <th>Status</th>
                                            <th>Status Logistica</th>
                                            <th>Creación Caja</th>
                                            <th>Factura</th>
                                            <th>Importe</th>
                                            <th>Fecha Fac</th>
                                            <th>Remision</th>
                                            <th>Importe</th>
                                            <th>Fecha Rec</th>
                                            <th>Aduana</th>                                           
                                            <th>Cartera Revision</th>
                                            <th>Cartera cobranza</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php foreach ($exec as $data):?>
                                    <tr>
                                        <td><?php echo $data->ID;?></td>                          
                                        <td><?php echo $data->CVE_FACT;?></td>
                                        <td><?php echo $data->STATUS;?></td>
                                        <td><?php echo $data->STATUS_LOG;?></td>
                                        <td><?php echo $data->FECHA_CREACION;?></td>
                                        <td><?php echo $data->FACTURA;?></td>
                                        <td><?php echo $data->IMPFAC;?></td>
                                        <td><?php echo $data->FECHAFAC;?></td>
                                        <td><?php echo $data->REMISION;?></td>
                                        <td><?php echo $data->IMPREC;?></td>
                                        <td><?php echo $data->FECHAREC;?></td>
                                        <td><?php echo $data->ADUANA;?></td>
                                        <td><?php echo $data->CR;?></td>
                                        <td><?php echo $data->CC;?></td>                                            
                                    </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>