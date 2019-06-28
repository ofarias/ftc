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
<!--                            	<th>CUENTA BANCARIA</th>-->
                                <th>IMPORTE</th>
                                <th>RECIBIR</th>
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
                                        <!-- <td><?php echo $data->CUENTA;?></td> -->                                             	 
                                        <td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                                        <td><input type="button" onclick="recibir('<?php echo $data->TIPO; ?>', '<?php echo $data->IDENTIFICADOR; ?>', '<?php echo $data->FECHA_PAGO; ?>', '<?php echo $data->BANCO;?>', '<?php echo $data->MONTO; ?>')" name="FORM_ACTION_PAGOS_RECIBIR" value="Recibir" /></td>
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
    <input type="hidden" name="tipo" value="" id="tipo"/>
    <input type="hidden" name="fecha" value= "" id="fecha"/>
    <input type="hidden" name="banco" value="" id="banco" />
    <input type="hidden" name="monto" value="" id="monto" />
    <input type="hidden" name="FORM_ACTION_PAGOS_RECIBIR" value="FORM_ACTION_PAGOS_RECIBIR" id="FORM_ACTION_PAGOS" />
</form>

<script language="javascript">
    function recibir(tipo, documento, fecha, banco, monto) {
        if (confirm("Esta seguro de marcar como recibido este pago?")) {
            document.getElementById("identificador").value = documento;
            document.getElementById("tipo").value = tipo;
            document.getElementById("fecha").value= fecha;
            document.getElementById("banco").value= banco;
            document.getElementById("monto").value= monto;
            var form = document.getElementById("FORM_ACTION_PAGOS");
            form.submit();
        } else {
            //nada
        }
    }
</script>