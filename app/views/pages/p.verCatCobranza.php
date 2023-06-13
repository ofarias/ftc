<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                Cobrados Sin Cierre x Cartera <?php echo $cc?>.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Contra Recibo</th>
                                <th>Cliente</th>
                                <th>Fecha Elaboracion</th>
                                <th>Fecha Vencimiento</th>
                                <th>Importe</th>
                                <th>Aplicado</th>
                                <th>Saldo Documento</th>
                                <th>Dias desde Facturacion</th>
                                <th>Dias para Gerencia Cobranza </th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cobsincierre as $data):?>
                            <tr>

                                <td><?php echo $data->DOCUMENTO;?></td>
                                <td><?php echo $data->CONTRARECIBO_CR?></td>
                                <td><?php echo $data->NOMBRE;?></td>
                                <td><?php echo $data->FECHA;?></td>
                                <td><?php echo $data->VENCIMIENTO;?></td>
                                <td><?php echo "$ ".number_format($data->IMPORTE,2)?></td>
                                <td><?php echo "$ ".number_format($data->APLICADO,2)?></td>    
                                <td><?php echo "$ ".number_format($data->SALDOFINAL,2,".",",");?></td>
                                <td><?php echo $data->DIAS;?></td>
                                <td><?php echo $data->DIASGC;?></td>

                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>

<form action="index.php" method="post">
<input type="hidden" name="cc" value = "<?php echo $cc?>">
<button value="enviar" type ="submit" name="genCierreCobranza" class="btn btn-warning" > Cierre de Documentos</button>
</form>
    </div>
</div>


<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="imprimeme">
            <div class="panel-heading">
                No Cobrados Hoy de la cartera <?php echo $cc?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="tb1">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Contra Recibo</th>
                                <th>Cliente</th>
                                <th>Fecha Elaboracion</th>
                                <th>Vencimiento</th>
                                <th>Importe</th>
                                <th>Aplicado</th>
                                <th>Saldo Documento</th>
                                <th>Dias desde Facturacion</th>
                                <th>Dias para Gerencia Cobranza </th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sinCobroDia as $data):?>
                            <tr>

                                <td><?php echo $data->CVE_DOC;?></td>
                                <td><?php echo $data->CR?></td>
                                <td><?php echo $data->NOMBRE;?></td>
                                <td><?php echo $data->FECHA;?></td>
                                <td><?php echo $data->VENCIMIENTO;?></td>
                                <td><?php echo "$ ".number_format($data->IMPORTE,2)?></td>
                                <td><?php echo "$ ".number_format($data->APLICADO,2)?></td>
                                <td><?php echo "$ ".number_format($data->SALDOFINAL,2,".",",");?></td>
                                <td><?php echo $data->DIASVENCIDO;?></td>
                                <td><?php echo $data->DIASGC;?></td>

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

