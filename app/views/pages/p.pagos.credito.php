<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Pagos Cr&eacute;ditos
            </div>
            <div class="panel-body">
                <div class="table-responsive">  
                    <span>Impresi&oacute;n de contrarecibo</span>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-credito-contrarecibo">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>BENEFICIARIO</th>
                                <th>MONTO</th>
                                <th>RECEPCION</th>
                                <th>OC</th>
                                <th>FECHA RECEPCION</th>
                                <th>VENCIMIENTO</th>
                                <th>PROMESA PAGO</th>

                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            foreach ($exec as $data):
                                ?>
                                <tr onmousemove="this.style.fontWeight = 'bold';
                                        this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                                this.style.cursor = 'default';" 
                                    onclick="generaContrarecibo('<?php echo trim($data->TIPO);?>', '<?php echo $data->ID;?>');" >
                                    <td><?php echo $data->TIPO;?></td>
                                    <td><?php echo $data->BENEFICIARIO; ?></td>
                                    <td align="right"><?php echo '$ '.number_format($data->MONTO, 2, '.', ','); ?></td>
                                    <td align="right"><?php echo $data->RECEPCION?></td>
                                    <td><?php echo $data->OC;?></td>
                                    <td><?php echo $data->FECHA_DOC; ?></td>
                                    <td><?php echo $data->VENCIMIENTO; ?></td>                                    
                                    <td><?php echo $data->PROMESA_PAGO; ?></td>
                                                                   
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_PAGOS_CREDITO">
    <input name="identificador" id="identificador" type="hidden" value=""/>
    <input name="tipo" id="tipo" type="hidden" value=""/>
    <input name="FORM_ACTION_PAGO_CREDITO_CONTRARECIBO" type="hidden" value="FORM_ACTION_PAGO_CREDITO_CONTRARECIBO"/>
</form>

<script language="javascript">
    function generaContrarecibo(tipo, identificador) {
        if (confirm("Esta seguro de generar el contrarecibo de este crédito?")) {
            document.getElementById("identificador").value = identificador;
            document.getElementById("tipo").value = tipo;
            var form = document.getElementById("FORM_ACTION_PAGOS_CREDITO");
            form.submit();
        } else {
       //nada
        }
    }
</script>