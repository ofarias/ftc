<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 SALDO DE CUENTAS BANCARIAS &nbsp;&nbsp;&nbsp;v.3
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Banco</th>
                                            <th>Cuenta Bancaria</th>
                                            <th>Cuenta Contable</th>
                                            <th>Abonos Mes Actual</th>
                                            <th>Abonos Mes Anterior</th>
                                            <th>Movs. X Relac. Actual</th>
                                            <th>Movs. X Relac. Anterior</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($bancos as $data):                           
                                        ?>
                                       <tr>
                                            <td align="right"><?php echo $data->BANCO;?></td>
                                            <td><?php echo $data->NUM_CUENTA;?></td>
                                            <td><?php echo $data->CTA_CONTAB;?></td>
                                            <td><?php echo $data->ABONOS_ACTUAL;?></td>
                                            <td><?php echo $data->ABONOS_ANTERIOR;?></td>
                                            <td><?php echo $data->MOV_X_REL_AC;?></td>
                                            <td><?php echo $data->MOV_X_REL_AN;?></td>
                                        </tr>
                                      <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Selccione el MES y Año
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive"> 
                            <table width="100%">
                              <thead>
                                <tr>
                                  <th width="10%"> Seleccionar Mes: </th>
                                  <th width="5%"> </th>
                                  <th width="10%"> Seleccionar Año: </th>
                                  <th width="75%"></th>
                                </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                  <form action="index.php" method = "POST">
                                    <td align="center">
                                      <select name = "mes">
                                        <?php foreach ($meses as $val):?>
                                        <option value = "<?php echo $val->NUMERO;?>"><?php echo $val->NOMBRE;?></option>
                                        <?php endforeach?>
                                           </select>
                                    </td>
                                    <td>
                                      
                                    </td>
                                    <td align="center">
                                        <select name = 'anio'>
                                          <option value='2019'> 2019 </option>
                                          <option value='2018'> 2018 </option>
                                        </select>
                                    </td>
                                    <td>
                                    <?php foreach ($bancos as $data):?>
                                          <input type="hidden" name="banco" value="<?php echo $data->BANCO?>">
                                          <input type="hidden" name="cuenta" value="<?php echo $data->NUM_CUENTA?>">
                                    <?php endforeach ?>
                                        <button name='FiltrarEdoCta_v3' type = "submit" value="enviar"> Aplicar </button>
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
<?php if(count($cierre)>0){?>
<?php foreach($cierre as $key):?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Detalle de Tipo de Ingresos del mes <font color="yellow"><b><?php echo $mesactual->NOMBRE.'</b></font>
                          durante el periodo del <font color="yellow"><b>'.substr($mesactual->FECHA_INI,0,10).' al '.substr($mesactual->FECHA_FIN,0,10);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   P E R I O D O   C E R R A D O </b></font>.
                         
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                  <tr>
                                    <?php foreach ($pagosacreedores as $data):
                                      $acreedores = $data->ACREEDORES;
                                      endforeach;
                                    ?>
                                    <td width="50%">
                                   <label><b>Ventas Guardadas</b></label><br/>
                                   <label> Ingresos por Ventas: $ <?php echo number_format($ventas,2) ?> </label> </label> <br>
                                   <label> No Ingresos por Transferencias: $ <label id ="abono_transfer"> <?php echo number_format($transfer,2); ?></label></label> <br>
                                   <label> No Ingresos por Devolucion de Compra: $ <label id = "abono_dc"><?php echo number_format($devCompra,2); ?> </label></label> <br>
                                   <label> No Ingresos por Devolucion de Gastos: $ <label id="abono_dg"><?php echo number_format($devGasto,2); ?></label></label> <br>
                                   <label> No Ingresos por Prestamos: $ <label id = "abono_pp"> <?php echo number_format($pcchica,2);?> </label></label> <br>
                                   <label> Ingresos TOTALES: $<label id="total_abonos2"> <?php echo number_format($ventas + $transfer + $devCompra + $devGasto + $pcchica,2)?></label> </label>
                                    <br/>
                                    <br/>
                                    <label> Saldo Inicial: $ <font color = "blue"><label id="saldo_inicial_header"> <?php echo number_format($key->MONTO_INICIAL,2)?></label></font></label><br/>
                                    <label> Total de Abonos: $ <font color = "green"><label id="abonos_header"><?php echo number_format($key->ABONOS,2)?></label></font></label><br/>
                                    <label> Total de Cargos: $ <font color = "red"><label id="cargos_header"> <?php echo number_format($key->CARGOS,2)?></label></font></label><br/>
                                    <label> Saldo Final Calculado: $ <font color = "#8A4B08"><label  id="saldo_final"><?php echo number_format($key->MONTO_FINAL,2)?></label></font></label><br/>
                                    <br/>
                                    <br/>
                                    <?php foreach($pagosaplicados as $data): ?>
                                    <label>Ingresos por Venta Aplicados: $ <?php echo number_format($data->TOTAL-$acreedores,2)?>   </label><br/>
                                    <?php endforeach ?>
                                    <?php foreach ($pagosacreedores as $data ): $acreedores = $data->ACREEDORES?>
                                    <label>Ingresos por Venta en Acreedores: $ <?php echo number_format($data->ACREEDORES,2)?></label>
                                    <?php endforeach ?>
                                    </td>
                                    <td width="50%">
                                    <label><b>Compras Guardadas</b></label><br/>
                                    <label> Compras: $ <?php echo number_format($totC,2); ?> </label> <br>
                                    <label> Compras a Credito Pagadas: $ <?php echo number_format($totCr,2); ?></label> <br>
                                    <label> Gastos : $ <?php echo number_format($totG,2); ?> </label> <br>
                                    <label> Deudores: $ <?php echo number_format($totD,2); ?></label> <br>
                                    <label> </label> <br>
                                    <label> Egresos TOTALES: $ <?php echo number_format(($totC + $totCr +$totG + $totD),2) ?></label>
                                    <br/>
                                    <br/>
                                    <br/>
                                    </td>
                                    </tr>
                                 </table>
                      </div>
            </div>
        </div>
</div>
</div>
<?php endforeach;?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Pagos Registrados en <?php echo $mesactual->NOMBRE.'
                          durante el periodo del '.$mesactual->FECHA_INI.' al '.$mesactual->FECHA_FIN;?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>TIPO</th>
                                            <th>FOLIO / UUID </th>
                                            <th>FECHA REGISTRO</th>
                                            <th>ABONO</th>
                                            <th>CARGO</th>
                                            <th>POR CONCILIAR/APLICAR</th>
                                            <th>TIPO PAGO</th>
                                            
                                            <th>USUARIO QUE REGISTRO</th>
                                            <th>Contabilizado?</th>
                                            <th>CEP</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php $i = 0;
                                        foreach ($exec as $datos):
                                              $tipo = $datos->TP;
                                              $i++;  
                                            if($tipo == 'DC'){
                                              $desc = 'DEVOLUCION DE COMPRA.';
                                              }elseif ($tipo =='DG'){
                                              $desc = 'DEVOLUCION DE GASTO.';
                                              }elseif ($tipo == 'oTEC'){
                                              $desc = 'TRANSFERENCIA ENTRE CUENTAS PROPIAS.';
                                              }elseif ($tipo == 'oPCC'){
                                              $desc = 'PRESTAMO CAJA CHICA,';
                                              }elseif(empty($tipo) and $datos->TIPO == 'Venta'){
                                                $desc = 'Pago de Factura';
                                              }elseif($tipo == 'Compra'){
                                               $desc = 'Compra'; 
                                              }elseif (substr($tipo,0,3)== 'GTR'){
                                                $desc = $tipo;
                                              }elseif ($tipo == 'Deudor') {
                                                $desc = 'Deudor';
                                              }
                                              
                                               if($datos->FA >= 1){
                                                $desc = 'Acreedor-'.$datos->FA;
                                               }
                                               $color = '';
                                               if($datos->COMPROBADO == '1'){
                                                $color=""; 
                                               }        
                                               $cep = "";
                                               if($datos->CEP > 0 and $datos->CEP<999999){
                                               $color="style='background-color:#A9F5A9'";
                                               $cep = 'P'.$datos->CEP;
                                               }        
                                          ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="<?php echo $i;?>">
                                            <td><?php echO $datos->TIPO;?></td>
                                            <td><?php echo $datos->CONSECUTIVO;?></td>
                                            <td><?php echo substr($datos->FECHAMOV,0, 10) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->ABONO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->CARGO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>
                                            <td>
                                              <a href="index.php?action=pagoFacturas&idp=<?php echo $datos->IDENTIFICADOR?>" target="_blank"?> <?php echo $desc;?> </a>
                                            </td> 
                                            <td><?php echo $datos->USUARIO;?></td>
                                            <td><?php echo $datos->CONTABILIZADO?></td>
                                              <td><?php echo $cep?>
                                              <?php if($datos->CEP > 0 and $datos->CEP<999999){ ?>
                                              <a href="/Facturas/FacturasJson/<?php echo $datos->ARCHIVO_CEP.'.pdf'?>" download > <img border="0" src="app/views/images/pdf.jpg" width="25" height="30"></a>
                                              <a/>XML<a href="/Facturas/FacturasJson/<?php echo $datos->ARCHIVO_CEP.'.xml'?>" download ><img border="0" src="app/views/images/xml.jpg" width="25" height="30"></a> 
                                              <?php }?>
                                            </td> 
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                 </tbody>
                            </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php }else{ ?>
<?php if($mes!=0)
  { ?>
<?php 
if (empty($exec)){
?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Pagos Registrados en <?php echo $mesactual->NOMBRE.'
                          durante el periodo del '.$mesactual->FECHA_INI.' al '.$mesactual->FECHA_FIN;?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                              NO SE ENCONTRO INFORMAICON DEL MES DE <?php echo $mesactual->NOMBRE?>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php }
else

{ 
?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Detalle de Tipo de Ingresos del mes <?php echo $mesactual->NOMBRE.'
                          durante el periodo del '.$mesactual->FECHA_INI.' al '.$mesactual->FECHA_FIN;?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                  <tr>
                                    <?php foreach ($pagosacreedores as $data):
                                      $acreedores = $data->ACREEDORES;
                                      endforeach;
                                    ?>
                                    <td width="50%">
                                   <label> Ingresos por Ventas: $ <?php echo number_format($ventas,2); ?> </label> <br>
                                   <label> No Ingresos por Transferencias: $ <?php echo number_format($transfer,2); ?></label> <br>
                                   <label> No Ingresos por Devolucion de Compra: $ <?php echo number_format($devCompra,2); ?> </label> <br>
                                   <label> No Ingresos por Devolucion de Gastos: $ <?php echo number_format($devGasto,2); ?></label> <br>
                                   <label> No Ingresos por Prestamos: $ <?php echo number_format($pcchica,2); ?></label> <br>
                                   <label> Ingresos TOTALES: $ <?php echo number_format($total,2)?></label>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <?php foreach($pagosaplicados as $data): ?>
                                    <label>Ingresos por Venta Aplicados: $ <?php echo number_format($data->TOTAL-$acreedores,2)?>   </label><br/>
                                    <?php endforeach ?>
                                    <?php foreach ($pagosacreedores as $data ): $acreedores = $data->ACREEDORES?>
                                    <label>Ingresos por Venta en Acreedores: $ <?php echo number_format($data->ACREEDORES,2)?></label>
                                    <?php endforeach ?>
                                    <br/><br/><br/><label>Saldo Inicial:<?php echo '$ '.number_format($inicial,2)?></label><br/>
                                    <label>Total Ingresos:<?php echo '$ '.number_format($total,2)?></label><br/>
                                    <label>Total Egresos:<?php echo '$ '.number_format(($totC + $totG + $totD + $totCr),2) ?></label><br/>
                                    <label>Saldo Final:<?php echo '$ '.number_format(($inicial + $total)-($totC + $totG + $totD + $totCr),2) ?></label>
                                    </td>
                                    <td width="50%">
                                    <label> Compras: $ <?php echo '$ '.number_format($totC,2); ?> </label> <br>
                                    <label> Compras a Credito Pagadas: $ <?php echo '$ '.number_format($totCr,2); ?></label> <br>
                                    <label> Gastos : $ <?php echo '$ '.number_format($totG,2); ?> </label> <br>
                                    <label> Deudores: $ <?php echo '$ '.number_format($totD,2); ?></label> <br>
                                    <label> </label> <br>
                                    <label> Egresos TOTALES: $ <?php echo '$ '.number_format(($totC + $totG + $totD + $totCr),2) ?></label>
                                    <br/>
                                    <br/>
                                    <br/>
                                    </td>
                                    </tr>
                                 </table>

                                 <center>
                            <form action="index.php" method="post">
                              <input type="hidden" name="abonosCierre" id="acierre" value="<?php echo ($total)?>" >
                              <input type="hidden" name="cargosCierre" id="ccierre" value="<?php echo (($totC + $totG + $totD + $totCr)) ?>" >
                              <input type="hidden" name="inicialCierre" id="icierre" value="<?php echo ($inicial)?>" >
                              <input type="hidden" name="finalCierre"  id="fcierre" value="<?php echo (($inicial + $total)-($totC + $totG + $totD + $totCr)) ?>" >
                              <input type="hidden" name="mes" value="<?php echo $mes ?>">
                              <input type="hidden" name="anio" value="<?php echo $anio ?>">
                              <input type="hidden" name="cuenta" value="<?php echo $cuenta?>">
                              <input type="hidden" name="banco" value="<?php echo $banco?>">
                              <button type="submit" name="cerrarEdoCtaMes" value="enviar" > Cierre de Estado de Cuenta</button>
                            </form>
                            </center>
                      </div>
            </div>
        </div>
</div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Pagos Registrados en <?php echo $mesactual->NOMBRE.'
                          durante el periodo del '.$mesactual->FECHA_INI.' al '.$mesactual->FECHA_FIN;?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>TIPO</th>
                                            <th>FOLIO / UUID </th>
                                            <th>FECHA REGISTRO</th>
                                            <th>ABONO</th>
                                            <th>CARGO</th>
                                            <th>POR CONCILIAR/APLICAR</th>
                                            <th>TIPO PAGO</th>
                                            <th>USUARIO QUE REGISTRO</th>
                                            <th>Contabilizado?</th>
                                            <th>CEP</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php $i = 0;
                                        foreach ($exec as $datos):
                                              $tipo = $datos->TP;
                                              $i++;  
                                            if($tipo == 'DC'){
                                              $desc = 'DEVOLUCION DE COMPRA.';
                                              }elseif ($tipo =='DG'){
                                              $desc = 'DEVOLUCION DE GASTO.';
                                              }elseif ($tipo == 'oTEC'){
                                              $desc = 'TRANSFERENCIA ENTRE CUENTAS PROPIAS.';
                                              }elseif ($tipo == 'oPCC'){
                                              $desc = 'PRESTAMO CAJA CHICA,';
                                              }elseif(empty($tipo) and $datos->TIPO == 'Venta'){
                                                $desc = 'Pago de Factura';
                                              }elseif($tipo == 'Compra'){
                                               $desc = 'Compra'; 
                                              }elseif (substr($tipo,0,3)== 'GTR'){
                                                $desc = $tipo;
                                              }elseif ($tipo == 'Deudor') {
                                                $desc = 'Deudor';
                                              }
                                              
                                               if($datos->FA >= 1){
                                                $desc = 'Acreedor-'.$datos->FA;
                                               }
                                               $color = '';
                                               if($datos->COMPROBADO == '1'){
                                                $color=""; 
                                               }
                                               $cep = "";
                                               if($datos->CEP > 0 and $datos->CEP<999999){
                                               $color="style='background-color:#A9F5A9'";
                                               $cep = 'P'.$datos->CEP;
                                               }        
                                          ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="<?php echo $i;?>">
                                            <td><?php echO $datos->TIPO;?></td>
                                            <td><?php echo $datos->CONSECUTIVO.' / '.$datos->TP_TES.'<br/>'.$datos->OBS;?></td>
                                            <td><?php echo substr($datos->FECHAMOV,0, 10) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->ABONO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->CARGO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>
                                            <td>
                                              <?php if($desc=='Pago de Factura'){?>
                                              <a href="index.php?action=pagoFacturas&idp=<?php echo $datos->IDENTIFICADOR?>" target="_blank"?> <?php echo $desc;?> </a>
                                            <?php }else{?>
                                              <?php echo $desc;?> 
                                            <?php }?>
                                            </td>
                                            <td><?php echo $datos->USUARIO;?></td>
                                            <td><?php echo $datos->CONTABILIZADO?></td>
                                            <td><?php echo $cep?>
                                              <?php if($datos->CEP > 0 and $datos->CEP<999999){ ?>
                                              <a href="/Facturas/FacturasJson/<?php echo $datos->ARCHIVO_CEP.'.pdf'?>" download > <img border="0" src="app/views/images/pdf.jpg" width="25" height="30"></a>
                                              <a/>XML<a href="/Facturas/FacturasJson/<?php echo $datos->ARCHIVO_CEP.'.xml'?>" download ><img border="0" src="app/views/images/xml.jpg" width="25" height="30"></a> 
                                              <?php }?>
                                            </td>
                                              
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                 </tbody>
                            </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php } ?>
<?php } ?>
  <form action="index.php" method=post id="formulario1" target="el-iframe"> 
    <input type="hidden" name="fecha" id="fnvaFecha" value=""> 
    <input type="hidden" name="iden" id="fiden" value="">
    <input type="hidden" name="valor" id="valor" value="">
    <input type="hidden" name="regnvafecha"> 
  </form>
  <iframe name="el-iframe" type="hidden"></iframe>
<!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

  $(document).ready(function() {
    $(".date1").datepicker({dateFormat: 'dd.mm.yy'});
  });

  function colores(identificador, env, valor){
      var renglon;
      var nvaf = document.getElementsByClassName("date1");
      var idate = identificador -1 ;
      var nvafi = nvaf[idate].value;

      if(valor == '1'){
        msg =  'Se actualizo la nueva fecha: \n\n' + env + ' :  ' + nvafi + 'valor: ' + nvaf;
        renglon = document.getElementById(identificador);
        renglon.style.background="RED";
        document.getElementById("fiden").value = env;
        document.getElementById("fnvaFecha").value = nvafi;
        document.getElementById("valor").value=valor;
        var form = document.getElementById("formulario1");
        form.submit();
        alert(msg);   
      }else{
        msg =  'Se ha desmarcado la transaccion: \n\n' + env + ' :  ' + nvafi + 'valor' + valor ;
        renglon = document.getElementById(identificador);
        renglon.style.background="white";
        document.getElementById("fiden").value = env;
        document.getElementById("fnvaFecha").value = nvafi;
        document.getElementById("valor").value=valor;
        var form = document.getElementById("formulario1");
        form.submit();
        alert(msg); 
      }
      //location.replace('index.php?action=pagoFacturas&idp='+iden);
  } 
  
  </script>
  <?php }?>