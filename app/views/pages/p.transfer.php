<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Crear nuevo Deudor:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Banco Origen</th>
                                            <th>Banco Destino</th>
                                            <th>Metodo</th>
                                            <th>Tipo de Transaccion</th>
                                            <th>Referencia</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                       <tr>  
                                       <form action = "index.php" method="post" >
                                            <td><input type="text" name="fechaedo" class = "fecha" value="<?php echo $fechaedo?>" required= "required"></td>
                                            <td><input type="number" step ="any" name="monto" required="required"></td>
                                            <td>
                                            <select name="bancoO" >
                                                <option value="0">--Banco Origen --</option>
                                                <?php foreach ($banco as $data): ?>
                                                <option value = "<?php echo $data->BANCO;?>"><?php echo $data->BANCO;?></option>
                                            <?php endforeach; ?>
                                            </select>
                                            </td>
                                            <td><select name="bancoD">
                                                <option value = "0">--Banco Destino--</option>
                                                <option value = "99">-No Aplica (Pago Prestamo)-</option>
                                             <?php foreach ($banco as $data):?>
                                                <option value="<?php echo $data->BANCO?>"><?php echo $data->BANCO?></option>>   
                                             <?php endforeach ?>
                                             </select>
                                            </td>
                                            <td>
                                                <select name = "tpf" required="required">
                                                       <option value="0">-Seleccionar-</option>
                                                       <option value="tr"> Transferencia</option>
                                                       <option value="ch"> Cheques </option>
                                                       <option value="e"> Efectivo</option>
                                                     
                                                </select>
                                            </td>
                                            <td>
                                                <select name="TT">
                                                  <option value = "Transferencia"> Trans vs Cuentas </option>
                                                  <option value = "Prestamo"> Pago de Prestamo </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="referencia" required="required">
                                            </td>
                                            <td>
                                                <button name="guardaTransPago" value="enviar" type ="submit" class="btn btn-success"> Guardar </button>
                                            </td>
                                        </form>
                                        </tr> 
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Deudores dados de Alta:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Tipo Movimiento</th>
                                            <th>Banco Origen</th>
                                            <th>Tipo</th>
                                            <th>Referencia</th>
                                            <th>Cuenta Destino</th>
                                            <th>Status</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                   <?php foreach($transfer as $key): ?>
                                       <tr>  
                                            <td><?php echo $key->FECHAEDO_CTA?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?></td>
                                            <td><?php echo $key->TIPO_DEUDOR;?></td>
                                            <td><?php echo $key->BANCO?></td>
                                            <td><?php echo $key->TIPO?></td>
                                            <td><?php echo $key->REFERENCIA?></td>
                                            <td><?php echo $key->CUENTA_DESTINO?></td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->USUARIO?></td>
                                        <?php endforeach;?>
                                            </form>
                                        </tr> 
                                 </tbody>
                                 </table>

                      </div>
            </div>
        </div>
</div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
  } );

</script>

