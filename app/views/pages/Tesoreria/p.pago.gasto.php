<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Confirmar Pagos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">  
                    <span>Pago de documentos</span>

                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th>GASTO</th>
                                <th>PROVEEDOR</th>
                                <th>FECHA ELABORACION</th>
                                <th>CUENTA PAGO</th>
                                <th>TIPO PAGO TESORERIA</th>
                                <th>PAGO REQUERIDO</th>                  
                                <th>MONTO PAGO TESORERIA</th>
                                <th>GUARDAR</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            foreach ($exec as $data):
                                ?>
                                <tr class="odd gradeX">                                                                                      
                                    <td><?php echo $data->CONCEPTO; ?></a></td>
                                    <td><?php echo $data->PROVEEDOR; ?></td>
                                    <td><?php echo $data->FECHA_CREACION; ?></td>
                            <form action="index.php" method="post">
                                <td>
                                    <select name="cuentabanco" required="required">
                                        <option value="">--Selecciona la Cuenta Banco--</option>
                                        <<?php foreach ($cuentaBancarias as $ban): ?>
                                            <option value="<?php echo $ban->BANCO; ?>"><?php echo $ban->BANCO; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input name="documento" type="hidden" value="<?php echo $data->ID ?>"/>
                                    <input name="proveedor" type="hidden" value="<?php echo $data->NOMBRE ?>"/>
                                    <input name="claveProveedor" type="hidden" value="<?php echo $data->CONCEPTO ?>"/>
                                    <input name="importe" type="hidden" value="<?php echo $data->MONTO_PAGO ?>" />
                                    <input name="fechadocumento" type="hidden" value="<?php echo $data->FECHA_CREACION ?>"/>
                                    <select name="tipopago" required="required">
                                        <option value="">--Elige tipo de pago--</option>
                                        <option value="tr">Transferencia</option>
                                        <option value="cr">Crédito</option>
                                        <option value="ef">Efectivo</option>
                                        <option value="ch">Cheque</option>
                                    </select>
                                </td>
                                <td><?php echo "$ " . number_format($data->MONTO_PAGO, 2, '.', ','); ?></td>
                                <td><input name="monto" type="number" step="any" required="required" min="0" max="<?php echo $data->MONTO_PAGO + 1?>"/></td>
                                <td>
                                    <button name="formpago_gasto" type="submit" value="enviar" class="btn btn-success">Pagar <i class="fa fa-money"></i></button>                                            
                                </td>
                            </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
