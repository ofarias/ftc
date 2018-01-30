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
                                            <th>No.Pago</th>
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
                                            $tipo = $data->ID;
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
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
                                            <th>IMPORTE</th>
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
                                            <td><?php echo '$ '.number_format($data->MONTO_APLICADO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_DOC,2);?></td>  
                                            <form action = "index.php" method="post">
                                            <input type="hidden" name="idap" value="<?php echo $data->ID;?>" />
                                            <input type="hidden" name="idp" value="<?php echo $data->IDPAGO?>">
                                            <input type="hidden" name="docf" value="<?php echo $data->DOCUMENTO;?>" />
                                            <input type ="hidden" name ="montoap" value="<?php echo $data->MONTO_APLICADO;?>"/>
                                            <input type="hidden" name="tipo" value= "<?php echo $tipo;?>">
                                            <td>
                                            <!--<button name="cancelaAplicacion" value ="enviar" type="submit" >
                                                Cancelar
                                            </button>-->   
                                            </td>
                                            </form>
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!--<form action="index.php" method="post">
                            <input name ="idap" value = "<?php echo $idap?>" type = "hidden"/>
                             <button name="confirmaAplicacion" value ="enviar" type="submit" class="btn btn-warning"> Confirma Aplicacion </button>
                            </form>-->
                    </div>
                    </div>
    </div>
</div>
<?php } ?>
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" name="docf" class="form-control" placeholder="Numero de Factura">
            <input type="hidden" name="idpago" value ="<?php echo $id;?>">
            <input type="hidden" name="monto" value = "<?php echo $monto?>">
            <input type="hidden" name="tipo" value = "<?php echo $tipo?>">
          </div>
          <button type="submit" value = "enviar" name = "traeFacturaPago" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>
<br />
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDOFINAL,2);?></td>
                                            <form action="index.php" method="post">
                                            <input name="clie" type="hidden" value="<?php echo $data->CVE_CLPV?>"/>
                                            <input name="idpago" type="hidden" value="<?php echo $id?>" />
                                            <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC;?>" />
                                            <input type="hidden" name="monto" value="<?php echo $monto;?>" />
                                            <input type="hidden" name="saldof" value="<?php echo $data->SALDOFINAL?>" />
                                            <input type="hidden" name="rfc" value="<?php echo $data->RFC?>" />
                                            <input type="hidden" name="tipo" value= "<?php echo $tipo;?>">
                                            <input type="hidden" name="tipo2" value="<?php echo $tipo2;?>">
                                            <td>
                                                <button name="PagoDirecto" type="submit" value="enviar" class="btn btn-warning" id='pagar' onclick="boton()">Pagar <i class="fa fa-money"></i></button></td> 
                                            </form>      
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />

<script type="text/javascript">
    
function boton(){
    document.getElementById('pagar').classList.add('hide');
}
</script>



