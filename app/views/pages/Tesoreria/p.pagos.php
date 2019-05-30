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

                    <table class="table table-striped table-bordered table-hover" id="dataTables-pagos">
                        <thead>
                            <tr>
                                <th>ORDEN DE COMPRA</th>
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
                            <?php foreach ($exec as $data):
                                ?>
                                <tr class="odd gradeX">                                                                                      
                                    <td><a href="index.php?action=documentodet&doc=<?php echo $data->CVE_DOC ?>"><?php echo $data->CVE_DOC; ?></a></td>
                                    <td><?php echo $data->NOMBRE; ?></td>
                                    <td><?php echo $data->FECHAELAB; ?></td>
                            <form action="index.php" method="post">
                                <td>
                                    <select name="cuentabanco" required="required">
                                        <option value="">--Selecciona la Cuenta Banco--</option>
                                        <<?php foreach ($cuentab as $ban): ?>
                                            <option value="<?php echo $ban->BANCO; ?>"><?php echo $ban->BANCO; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input name="docu" type="hidden" value="<?php echo $data->CVE_DOC ?>"/>
                                    <input name="nomprov" type="hidden" value="<?php echo $data->NOMBRE ?>"/>
                                    <input name="cveprov" type="hidden" value="<?php echo $data->CVE_CLPV ?>"/>
                                    <input name="importe" type="hidden" value="<?php echo $data->IMPORTE ?>" />
                                    <input name="fechadoc" type="hidden" value="<?php echo $data->FECHAELAB ?>"/>
                                    <select name="tipopago" required="required">
                                        <option value="">--Elige tipo de pago--</option>
                                        <option value="tr">Transferencia</option>
                                        <<?php echo (substr($data->CVE_DOC, 0, 1) == 'O')? 'option value="cr">Crédito</option>':''?>
                                        <option value="e">Efectivo</option>>
                                        <option value="ch">Cheque</option>
                                        <option value="sf">Saldo a Favor</option>
                                    </select>
                                </td>
                                <td><?php echo "$ " . number_format($data->IMPORTE, 2, '.', ','); ?></td>
                                <td><input name="monto" type="number" required="required" step="any" max="<?php echo ($data->IMPORTE + 1) ?>"/></td>
                                <td>
                                    <button name="formpago" type="submit" value="enviar" class="btn btn-warning">Pagar! <i class="fa fa-floppy-o"></i></button></td>
                            </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(count($detallesaldo)>0){?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           De los saldos liberados del Proveedor
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Seleccionar</th>
                                            <th>Orden</th>
                                            <th>Fecha de Orden</th>
                                            <th>Partida </th>
                                            <th>Cantidad</th>
                                            <th>Producto</th>
                                            <th>Costo en Ordenes </th>
                                            <th>Total Cancelado</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Usuario Libera</th>
                                            <th>Fecha de Liberacion</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($detallesaldo as $data):
                                        ?>
                                       <tr>
                                           <td><input type="checkbox" name="seleccion" id="seleccion_<?php echo $data->OC.$data->PARTIDA?>"></td>
                                            <td><?php echo $data->OC;?></td>
                                            <td align="center"><?php echo $data->FECHA_OC;?></td>
                                            <td align="center"><?php echo $data->PARTIDA_OC?></td>
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="center"><?php echo '('.$data->PROVEEDOR.') '.$data->NOMBRE_PROVEEDOR;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST,2) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST*$data->CANTIDAD,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->CANTIDAD * $data->COST) * .16,2)?></td>
                                            <td align="right"><font color="red"><?php echo '$ '.number_format(($data->CANTIDAD * $data->COST)*1.16,2)?></font></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<?php }?>