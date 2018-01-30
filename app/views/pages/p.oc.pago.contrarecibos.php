<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Pago de <?php echo $cantidad ?> &oacute;rdenes de compra, por un monto de <?php echo $monto; ?> 
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-recepciones">
                        <thead>
                            <tr>
                                <th>FOLIO</th>
                                <th>RECEPCION</th>
                                <th>OC</th>
                                <th>FACTURA</th>
                                <th>PROVEEDOR</th>
                                <th>PROMESA PAGO</th>
                                <th>IMPORTE</th>
                                <th>F. RECEPCION</th>                                
                            </tr>
                        </thead>
                        <tfoot>
                        <form action="index.php" method="POST">
                            <td colspan="6" style="text-align: right">
                                <label for="medio">Medio de pago: </label>
                                <select name="medio" required="required">
                                    <option selected value="-1">-SELECCIONE-</option>
                                    <option value="ch">CHEQUE</option>
                                    <option value="tr">TRANSFERENCIA</option>
                                    <option value="e">EFECTIVO</option>
                                </select>
                            
                                <label for="cuentabanco">Cuenta bancaria: </label>
                                <select name="cuentabanco" required="required">
                                    <option>--Selecciona la Cuenta Banco--</option>
                                    <<?php foreach ($cuentaBancarias as $ban): ?>
                                    <option value="<?php echo $ban->BANCO; ?>"><?php echo $ban->BANCO; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <label for="monto_pago">Importe de pago: </label>
                                <input type="text" name="monto_pago" value="<?php echo "$ " . number_format($monto, 2, '.', ',');?>" readonly />
                                <input type="hidden" name="monto" value="<?php echo $monto;?>" />
                                <input type="hidden" name="folios" value="<?php echo $folios;?>" />
                            </td>
                            <td style="text-align: center">
                                <button type="submit" value="enviar" name="FORM_ACTION_CR_PAGO_APLICAR"> Solocitar Pago</button>
                            </td>

                            <td>
                                <button type="submit" value = "enviar" name="enviarConta" > Pago Directo </button>
                            </td>

                          </form>
                        </tfoot>
                        <tbody>
                            <?php
                            if ($exec != null) {
                                foreach ($exec as $data):
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>CRP-<?php echo $data->FOLIO; ?></td>
                                        <td><?php echo $data->RECEPCION; ?></td>
                                        <td><?php echo $data->OC;?></td>
                                        <td><?php echo $data->FACTURA;?></td>
                                        <td><?php echo $data->BENEFICIARIO; ?></td>
                                        <td><?php echo $data->PROMESA_PAGO; ?></td>
                                        <td><?php echo "$ " . number_format($data->MONTOR, 2, '.', ','); ?></td>
                                        <td><?php echo $data->FECHA_IMPRESION; ?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
    $("#enviar").click(function() {
        $("#FORM_ACTION_CR_PAGO").submit();
    });

</script>
