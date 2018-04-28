<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Pago a Aplicar.
            <br>
            <br>
            El pago se podra aplicar hasta que el saldo sea 0.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Pago  / Historial</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>IMPORTE</th>
                                            <th>Saldo</th>              
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($pagos as $data):
                                            $id=$data->ID;
                                            $monto=$data->SALDO;
                                            $tipo=$data->ID;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID.' ----->';?> <a href="index.php?action=verHistorialPago&ida=<?php echo $data->ID?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Ver Historial </a></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>     
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<?php if($xaplicar){
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Facturas seleccionadas.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Pago</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Importe</th>
                                            <th>Monto Aplicado</th>
                                            <th>Saldo</th>              
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($xaplicar as $data):
                                            $idap=$data->ID;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO_APLICADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO_DOC,2);?></td>  
                                            <form action = "index.php" method="post">
                                            <input type="hidden" name="idap" value="<?php echo $data->ID;?>" />
                                            <input type="hidden" name="idp" value="<?php echo $data->IDPAGO?>">
                                            <input type="hidden" name="docf" value="<?php echo $data->DOCUMENTO;?>" />
                                            <input type ="hidden" name ="montoap" value="<?php echo $data->MONTO_APLICADO;?>"/>
                                            <input type="hidden" name="tipo" value= "<?php echo $tipo;?>">
                                            <!--<td>
                                            <button name="cancelaAplicacion" value ="enviar" type="submit" >
                                                Cancelar
                                            </button>   
                                            </td>-->
                                            </form>
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                           <!-- <form action="index.php" method="post">
                            <input name ="idap" value = "<?php echo $idap?>" type = "hidden"/>
                             <button name="confirmaAplicacion" value ="enviar" type="submit" class="btn btn-warning"> Confirma Aplicacion </button>
                            </form>-->
                    </div>
                    </div>
    </div>
</div>
<?php } ?>

<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="docf" class="form-control" placeholder="Numero de Factura">
            <input type="hidden" name="idpago" value ="<?php echo $id;?>">
            <input type="hidden" name="monto" value = "<?php echo $monto;?>"> 
            <input type="hidden" name="tipo" value = "<?php echo $tipo;?>">
          </div>
          <button type="submit" value = "enviar" name = "traeFacturaPago" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>
<br />

