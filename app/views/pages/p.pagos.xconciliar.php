<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Recepci&oacute;n de pagos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">           	 
                <div class="table-responsive">                  	
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>IDENTIFICADOR</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA ELABORACION</th>
                                <th>IMPORTE</th>
                                <th>CONCILIAR</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if ($pagos != null) {
                                foreach ($pagos as $data):
                                    ?>
                                    <tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                                this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                        this.style.cursor = 'default';"
                                        onclick="seleccionaPago('<?php echo $data->IDENTIFICADOR; ?>', '<?php echo $data->TIPO; ?>');">
                                        <td><?php echo $data->TIPO; ?></td>
                                        <td><?php echo $data->IDENTIFICADOR; ?></td>
                                        <td><?php echo $data->NOMBRE; ?></td>
                                        <td><?php echo $data->FECHA_PAGO; ?></td>
                                        <!-- <td><?ph echo $data->CUENTA;?></td> -->                                             	 
                                        <td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                                        <td><input type="button" onclick="conciliar('<?php echo $data->TIPO; ?>', '<?php echo $data->IDENTIFICADOR; ?>')" name="FORM_ACTION_PAGOS_RECIBIR" value="Conciliar" /></td>
                                    </tr>
                                    <?php
                                endforeach;
                            } else {
                                ?>                          	 
                                <tr class="odd gradeX">
                                    <td colspan="6">No hay datos</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<form id="FORM_ACTION_PAGOS" method="POST" action="index.php">
    <input type="hidden" name="identificador" value="" id="identificador" />
    <input type="hidden" name="tipo" value="" id="tipo" />
    <input type="hidden" name="FORM_ACTION_PAGOS_CONCILIAR" value="FORM_ACTION_PAGOS_CONCILIAR" id="FORM_ACTION_PAGOS" />
</form>

<script language="javascript">
    function conciliar(tipo, documento) {
        if (confirm("Esta seguro de marcar el pago para conciliar?")) {
            document.getElementById("identificador").value = documento;
            document.getElementById("tipo").value = tipo;
            var form = document.getElementById("FORM_ACTION_PAGOS");
            form.submit();
        } else {
            //nada
        }
    }
</script>