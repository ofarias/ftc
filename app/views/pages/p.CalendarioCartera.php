<br /><br/>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Totales por cartera.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Responsable de la Cartera</th>
                                <th align="center">Semana</th>
                                <th align="center">Por cobrar Semana actual</th>
                                <th align="center">Cobrado en esta semana</th>
                                <th align="center">Valor de la Cartera</th>
                                <th align="center">Fecha Actual</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Nombre del responsable </td>
                                <td align="center"><?php echo date("W");?></td>
                                <td align="center"><?php echo "$ ".number_format($totalSemana,2,".",",");?></td>
                                <td align="center">$ 0.00</td>
                                <td align="center"><?php echo "$ ".number_format($totales,2,".",",");?></td>
                                <td><?php echo date('m-d-Y');?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Vencimientos del día de la Cartera <?php echo $cartera?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-calendariocartera">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Fecha Vencimiento</th>
                                <th>Importe</th>
                                <th>Saldo</th>
                                
                                <th>Registrar Pago</th>
                                <th>Deslindar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($calendario as $data):?>
                            <tr>

                                <td><?php echo $data->CVE_DOC;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->FECHA_VENCIMIENTO;?></td>
                                <td><?php echo "$ ".number_format($data->IMPORTE,2,".",",");?></td>
                                <td><?php echo "$ ".number_format($data->SALDOFINAL,2,".",",");?></td>
                                <td>
                                    <button class="btn btn-warning">Registrar Pago</button>
                                </td>
                                <td>
                                    <button class="bnt btn-danger">Enviar a Deslinde</button>
                                </td>
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
