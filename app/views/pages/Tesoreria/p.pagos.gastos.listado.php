<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Confirmar Pagos de gastos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">             
                <div class="table-responsive">  
                    <span>Solicitudes de pago por gasto</span>
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>IDENTIFICADOR</th>
                                <th>GASTO</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA ELABORACI&Oacute;N</th>
                                <th>MONTO PAGO</th>
                                <th>PRESUPUESTO</th>
                                <th>CLASIFICACI&Oacute;N</th>
                            </tr>
                        </thead>   
                        <!--<tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Total:</th>
                                <th></th>
                            </tr>
                        </tfoot>-->
                        <tbody>
                            <?php
                            foreach ($exec as $data):
                            ?>
                                <tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                        this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                this.style.cursor = 'default';"
                                    onclick="seleccionaPago('<?php echo $data->ID; ?>');">
                                    <td><a href="index.php?action=documentodet&doc=<?php echo $data->ID ?>"><?php echo $data->ID; ?></a></td>
                                    <td><?php echo $data->CONCEPTO; ?></td>
                                    <td><?php echo $data->PROV; ?></td>
                                    <td><?php echo $data->FECHA_CREACION; ?></td>
                                    <td><?php echo "$ " . number_format($data->MONTO_PAGO, 2, '.', ','); ?></td>
                                    <td><?php echo "$ " . number_format($data->PRESUPUESTO, 2, '.', ','); ?></td>
                                    <td><?php echo $data->DESCRIPCION; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_PAGO_GASTO">
    <input name="documento" id="documento" type="hidden" value=""/>    
    <input name="fecha" id="fechadoc" type="hidden" value=""/>
    <input name="FORM_NAME_GASTO" type="hidden" value="FORM_ACTION_PAGO_GASTO"/>
</form>
<script language="javascript">
    function seleccionaPago(documento, proveedor, claveProveedor, importe, fecha) {
            document.getElementById("documento").value = documento;
            document.getElementById("fechadoc").value = fecha;
            var form = document.getElementById("FORM_ACTION_PAGO_GASTO");
            form.submit();
    }
</script>
