<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Vencimientos del día.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Factura</th>
                                <th>Importe Factura</th>
                                <th>Remisión</th>
                                <th>Importe Remisión</th>
                                <th>CC</th>
                                <th>Días</th>
                                <th>Fecha Secuencia</th>
                                <th>Fecha Vencimiento</th>
                                <th>Cortar Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($exec as $data):?>
                            <tr>

                                <td><?php echo $data->CVE_FACT;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->FACTURA;?></td>
                                <td><?php echo "$ ".number_format($data->IMPFAC,2,".",",");?></td>
                                <td><?php echo $data->REMISION;?></td>
                                <td><?php echo "$ ".number_format($data->IMPREM,2,".",",");?></td>
                                <td><?php echo $data->CARTERA_COB;?></td>
                                <td><?php echo $data->DIAS;?></td>
                                <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                <td><?php echo $data->FECHA_VEN;?></td>
                        <form>
                            <td><button type="submit" name="cortarCredito" class="btn btn-warning">Cortar Credito <i class="fa fa-scissors"></i></button></td>
                        </form>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>