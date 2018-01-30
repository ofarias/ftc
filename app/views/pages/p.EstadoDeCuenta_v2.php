<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 SALDO DE CUENTAS BANCARIAS
                        </div>

                        <?php foreach ($saldos as $sdos ):
                            
                          if($mes == 1 ){
                            $saldoInicial = $sdos->SALDOI;
                          }elseif ($mes == 2) {
                            $saldoInicial = $sdos->SALDOI02;
                          }elseif ($mes == 3) {
                            $saldoInicial = $sdos->SALDOI03;
                          }elseif ($mes == 4) {
                            $saldoInicial = $sdos->SALDOI04;
                          }elseif ($mes == 5) {
                            $saldoInicial = $sdos->SALDOI05;
                          }elseif ($mes == 6) {
                            $saldoInicial = $sdos->SALDOI06;
                          }elseif ($mes == 7) {
                            $saldoInicial = $sdos->SALDOI07;
                          }elseif ($mes == 8) {
                            $saldoInicial = $sdos->SALDOI08;
                          }elseif ($mes == 9) {
                            $saldoInicial = $sdos->SALDOI09;
                          }elseif ($mes == 10) {
                            $saldoInicial = $sdos->SALDOI10;
                          }elseif ($mes == 11) {
                            $saldoInicial = $sdos->SALDOI11;
                          }elseif ($mes == 12) {
                            $saldoInicial = $sdos->SALDOI12;
                          }
                         ?>
                        <?php endforeach ?>
                        <input type="hidden" name="saldo_inicial" id="saldo_inicial" value="<?php echo $saldoInicial?>">
                        <input type="hidden" name="sventas" id="abonos_a" value="<?php echo $ventas + $transfer + $devCompra + $devGasto + $pcchica?>">
                        <input type="hidden" name="scompras" id= "cargos_a" value="<?php echo $totC + $totCr +  $totG + $totD?>">
                      


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
                                          <option value = '2016'> 2016 </option>
                                          <option value = '2017'> 2017 </option>
                                          <option value="2015"> 2015 </option>
                                        </select>
                                    </td>
                                    <td>
                                    <?php foreach ($bancos as $data):?>
                                          <input type="hidden" name="banco" value="<?php echo $data->BANCO?>">
                                          <input type="hidden" name="cuenta" value="<?php echo $data->NUM_CUENTA?>">
                                    <?php endforeach ?>
                                        <button name='FiltrarEdoCta' type = "submit" value="enviar"> Aplicar </button>
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
                                   <label><b>Ventas Guardadas</b></label><br/>
                                   <label> Ingresos por Ventas: $ <?php echo number_format($ventas,2) ?> </label> </label> <br>
                                   <label> No Ingresos por Transferencias: $ <label id ="abono_transfer"> <?php echo number_format($transfer,2); ?></label></label> <br>
                                   <label> No Ingresos por Devolucion de Compra: $ <label id = "abono_dc"><?php echo number_format($devCompra,2); ?> </label></label> <br>
                                   <label> No Ingresos por Devolucion de Gastos: $ <label id="abono_dg"><?php echo number_format($devGasto,2); ?></label></label> <br>
                                   <label> No Ingresos por Prestamos: $ <label id = "abono_pp"> <?php echo number_format($pcchica,2);?> </label></label> <br>
                                   <label> Ingresos TOTALES: $<label id="total_abonos2"> <?php echo number_format($ventas + $transfer + $devCompra + $devGasto + $pcchica,2)?></label> </label>
                                    <br/>
                                    <br/>
                                    <label> Saldo Inicial: $ <font color = "blue"><label id="saldo_inicial_header"> <?php echo number_format($saldoInicial,2)?></label></font></label><br/>
                                    <label> Total de Abonos: $ <font color = "green"><label id="abonos_header">0.00</label></font></label><br/>
                                    <label> Total de Cargos: $ <font color = "red"><label id="cargos_header"> 0.00</label></font></label><br/>
                                    <label> Saldo Final Calculado: $ <font color = "#8A4B08"><label  id="saldo_final">0.00</label></font></label><br/>
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
                                           <!-- <th>POR CONCILIAR/APLICAR</th> -->
                                            <th>TIPO PAGO</th>
                                            <th>REGISTRAR</th>
                                            <th>USUARIO QUE REGISTRO</th>
                                            <th>Contabilizado?</th>
                                           
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php $i = 0;
                                              $desc1 = '';
                                        foreach ($exec as $datos):
                                              
                                              if(empty($datos->TP) and $datos->TIPO = 'Venta'){
                                                $tipo = 'Venta';
                                              } else{
                                                $tipo = $datos->TP;  
                                              }
                                              
                                              $i++;  

                                            if($tipo == 'DC'){
                                              $desc = 'DEVOLUCION DE COMPRA.';
                                              }elseif ($tipo =='DG'){
                                              $desc = 'DEVOLUCION DE GASTO.';
                                              }elseif ($tipo == 'oTEC'){
                                              $desc = 'TRANSFERENCIA ENTRE CUENTAS PROPIAS.';
                                              }elseif ($tipo == 'oPCC'){
                                              $desc = 'PRESTAMO CAJA CHICA,';
                                              }elseif ($tipo == 'Venta'){
                                                $desc = 'Pago de Factura';
                                              }elseif($tipo == 'Compra'){
                                               $desc = 'Compra'; 
                                              }elseif (substr($tipo,0,3)== 'GTR'){
                                                $desc = $tipo;
                                                $desc1 = 'gasto';
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

                                          ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="<?php echo $i;?>">
                                            <td><?php echO $datos->TIPO;?></td>
                                            <td><?php echo $datos->CONSECUTIVO.' / '.$datos->TP_TES;?></td>
                                            <td><?php echo substr($datos->FECHAMOV,0, 10) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->ABONO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->CARGO,2);?></td>
                                            <!--<td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>-->
                                            <td>
                                              <a href="index.php?action=pagoFacturas&idp=<?php echo $datos->IDENTIFICADOR?>" target="_blank"?> <?php echo $desc;?> </a>
                                            </td>
                                            <form action = "index.php" method="post">
                                            <td>
                                              <input type="hidden" name="anio" value = "<?php echo $anio?>"/>
                                              <input type="hidden" name="idtrans" value="<?php echo $datos->IDENTIFICADOR?>" />
                                              <input type="hidden" name="idmonto" value="<?php echo $datos->ABONO?>" />
                                              <input type="hidden" name="tipo" value="<?php echo $datos->TIPO?>"/>
                                              <input type="hidden" name="mes" value="<?php echo $mesactual->NUMERO?>" />
                                              <input type="hidden" name="banco" value="<?php echo Trim(substr($datos->BANCO, 0, 8))?>" />
                                              <input type="hidden" name="cuenta" value="<?php echo Trim(substr($datos->BANCO,10,11))?>">
                                              <input type="hidden" name="montoCargo" value ="<?php echo $datos->CARGO;?>" />
                                              <input type="hidden" name="comprobado" value ="<?php echo $datos->COMPROBADO?>" />


                                              <input type ="text" name = "fecha_edo" value="<?php echo $datos->FECHAMOV?>" class="date1" 
                                                onchange="actFecha('<?php echo $datos->CONSECUTIVO?>', '<?php echo $datos->S?>', this.value, <?php echo $i?>)"/> 
                                              
                                              <input type="checkbox" 
                                              <?php echo $datos->S > 1? 'name="compras[]"':''?>
                                              <?php echo $datos->S == 1? 'name="abonos[]"':''?>
                                              
                                               <?php echo $datos->SELECCIONADO == 1? 'checked="checked"':'' ?> 

                                               onchange="test('<?php echo $i?>', '<?php echo $datos->CONSECUTIVO?>', '<?php echo $datos->S?>')" 
                                               id ="caja_<?php echo $i?>" 

                                               value ='<?php echo ($desc=='Compra' or $desc1 =='gasto')? "$datos->CARGO":"$datos->ABONO"?>' 
                                               docu="<?php echo $datos->S.'+'.$datos->IDENTIFICADOR;?>"
                                        

                                               <?php echo $datos->S > 1? 'class="compra"':''?>
                                               <?php echo $datos->S == 1? 'class="abono"':''?>
                                                >                                             
                                              </td>
                                             
                                            <td><?php echo $datos->USUARIO;?></td>
                                            <td><?php echo $datos->CONTABILIZADO?></td>
                                               
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                 </tbody>
                            </table>
                            <center><input type="button" value="Guardar Estado de Cuenta" name = "enviar" id="btn" onclick="test('a', 'c', 'd')"></center>
                            <br/>
                            <center><form action="index.php" method="post">
                              <input type="hidden" name="abonosCierre" id="acierre" value="" >
                              <input type="hidden" name="cargosCierre" id="ccierre" value="" >
                              <input type="hidden" name="inicialCierre" id="icierre" value="" >
                              <input type="hidden" name="finalCierre"  id="fcierre" value="" >
                              <input type="hidden" name="mes" value="<?php echo $mes ?>">
                              <input type="hidden" name="anio" value="<?php echo $anio ?>">
                              <input type="hidden" name="cuenta" value="<?php echo $cuenta?>">
                              <input type="hidden" name="banco" value="<?php echo $banco?>">
                              <button type="submit" name="cerrarEdoCtaMes" value="enviar" > Cierre de Estado de Cuenta</button>
                            </form>
                            </center>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php } ?>
<?php } ?>

<div>
    <div id="column-left">
            <font size="4px" color="black">SaldoIncial =</font> <font color="blue" size="4pxs" id="si" > <?php echo '$ '.number_format($saldoInicial,2)?> </font> <br/>
            <font size="4px" color="black"> Abonos (seleccionados) = </font> <font color="green" size="4pxs" id = "total_abonos"> $ 0.00 </font><br/>
            <font size="4px" color="black"> Cargos (seleccionados)= </font> <font color = "red" size="4pxs" id = "total_cargos"> $ 0.00 </font><br/>
            <font size="4px" color="black"> Saldo Final = </font> <font color = "#FE2EF7" size="4pxs" id = "saldoFinal"> $ 0.00 </font>
    </div>
</div>
  <form action="index.php" method=post id="formulario1" target="el-iframe"> 
    <input type="hidden" name="fecha" id="fnvaFecha" value=""> 
    <input type="hidden" name="iden" id="fiden" value="">
    <input type="hidden" name="valor" id="valor" value="">
    <input type="hidden" name="regnvafecha"> 
  </form>
<iframe name="el-iframe" type="hidden"></iframe>
<!--Modified by GDELEON 3/Ago/2016-->

<form action="index.php" id="formGuardar" method="post">
  <input type="hidden" name="abonos" id="pagosA" value="">
  <input type="hidden" name="compras" id ="comprasA" value="">
  <input type="hidden" name="gastos" id="gastosA" value="">
   <input type="hidden" name="mes" value="<?php echo $mes?>">
    <input type="hidden" name="banco" value="<?php echo $banco?>">
    <input type="hidden" name="cuenta" value="<?php echo $cuenta?>">
    <input type="hidden" name="anio" value ="<?php echo $anio?>">
  <input type="hidden" name="guardaEdoCta" value="enviar">
</form>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>

  $(document).ready(function() {
    $(".date1").datepicker({dateFormat: 'yy-mm-dd'});
    //var a = test('j','b', 'c');
      var abonos = 0;
      var pagos = '';
    $("input:checkbox:checked.abono").each(function() {
             var  docs = $(this).attr("docu");
             var tipo = $(this).attr("tipo");
             //alert('Documento' +  docs);
             var a = parseFloat(this.value,2);
             abonos = abonos + a;
             pagos = pagos +','+ docs;
        });
    var abonosActuales = document.getElementById('abonos_a').value; 
    
    abonos = parseFloat(abonos,2) + parseFloat(abonosActuales,2);

    var tete = currency(abonos);
    document.getElementById('pagosA').value=pagos;  

    var compras = 0;
    var docCompras= '';
      $("input:checkbox:checked.compra").each(function() {
             var comp = $(this).attr("docu");
             var tipo = $(this).attr("tipo");
             var a = parseFloat(this.value,2);
             compras = compras + a;
             docCompras = docCompras + ',' + comp;
        });
    document.getElementById('comprasA').value  = docCompras;
    var comprasActuales = document.getElementById('cargos_a').value;

    compras = parseFloat(compras,2) + parseFloat(comprasActuales,2);

    var comp = currency(compras);

    var gastos = 0;
    var docGastos = '';
     $("input:checkbox:checked.gasto").each(function() {
             var gtos =  $(this).attr("docu");
             var tipo = $(this).attr("tipo"); 
             var a = parseFloat(this.value,2);
             gastos = gastos + a;
             docGastos = docGastos + ',' + gtos;
        });
     document.getElementById('gastosA').value = docGastos;
     

     //var gastos = currency(gastos);

  var totalAbonos  = abonos;
  var totalCompras = compras + gastos;
  var saldoInicial = document.getElementById('saldo_inicial').value;
 
  var saldoFinal=parseFloat(saldoInicial,2) + parseFloat((totalAbonos - totalCompras),2);

  var totalAbonos = currency(totalAbonos);
  var totalCompras = currency(totalCompras);
  var saldoFinal = currency(saldoFinal);
  var saldoInicial = currency(saldoInicial);

  


  document.getElementById('total_abonos').innerHTML = '$ '+ tete;
  //document.getElementById('total_abonos').innerHTML = '$' + tete;
  document.getElementById('total_cargos').innerHTML='$ '+ comp;
  document.getElementById('saldoFinal').innerHTML = '$' + saldoFinal;   
      
     document.getElementById('saldo_inicial_header').innerHTML = saldoInicial;
     document.getElementById('abonos_header').innerHTML = tete;
     document.getElementById('cargos_header').innerHTML = totalCompras;
     document.getElementById('saldo_final').innerHTML =  saldoFinal;

     document.getElementById('icierre').value=saldoInicial;
     document.getElementById('acierre').value=tete;
     document.getElementById('ccierre').value=totalCompras;
     document.getElementById('fcierre').value=saldoFinal;


  });


function actFecha(docu, tipo, nuevaFecha, identificador){
        alert('Se cambio la fecha del documento ' + docu + ' de tipo ' + tipo + 'nueva fecha' + nuevaFecha);
  
        $.ajax({
               type: 'POST',
               url: 'index.php',
               dataType: "json",
               data: {actFecha:tipo,tipo:tipo,docu:docu,fecha:nuevaFecha},
               success: function(data){
                      console.log('status'+data.status);

                      if(data.status=="OK"){
                          renglon = document.getElementById(identificador);
                              renglon.style.background="#BEF4BB";
                              document.getElementById('caja_'+identificador).checked=true;
                           alert("El Registro se Actualizo correctamente");
                              
                      }else if(data.status == "NO"){
                           alert("No se pudo actualizar, intente mas tarde, favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                              renglon = document.getElementById(identificador);
                              renglon.style.background="#407E9D";
                      }
                    },
                error: function(data){
                    alert("No se pudo actualizar, intente mas tarde, favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                    renglon = document.getElementById(identificador);
                    renglon.style.background="#E37777";
                }
                });
        //window.setTimeout(test(indentificador),100);
      alert('Actualizacion de Saldo...');
     
  }

var selected = new Array();

function test(a, docu, tipo){
    //alert('Valor de CONSECUTIVO' + a + ' Valor de docu: ' + docu + ' tipo ' + tipo );
    if (docu != 'c'){
      //alert('Entro');
      var c = document.getElementById('caja_'+ a ); 
                    if(c.checked == true){
                      var nuevaFecha='aaa';
                      //alert('Seleccionado');
                          $.ajax({
                               type: 'POST',
                               url: 'index.php',
                               dataType: "json",
                               data: {actFecha:tipo,tipo:tipo,docu:docu,fecha:nuevaFecha},
                               success: function(data){
                                      console.log('status'+data.status);
                                      if(data.status=="OK"){
                                          renglon = document.getElementById(a);
                                              renglon.style.background="#BEF4BB";
                                              document.getElementById('caja_'+a).checked=true;
                                           alert("El Registro se Actualizo correctamente");
                                              
                                      }else if(data.status == "NO"){
                                           alert("No se pudo actualizar, intente mas tarde, favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                                              renglon = document.getElementById(a);
                                              renglon.style.background="#407E9D";
                                      }
                                    },
                                error: function(data){
                                    alert("No se pudo actualizar, intente mas tarde, favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                                    renglon = document.getElementById(a);
                                    renglon.style.background="#E37777";
                                    document.getElementById('caja_'+a).checked=0;   
                                }
                                });
                    }else{      
                      var nuevaFecha='bbb';
                        $.ajax({
                               type: 'POST',
                               url: 'index.php',
                               dataType: "json",
                               data: {actFecha:tipo,tipo:tipo,docu:docu,fecha:nuevaFecha},

                               success: function(data){
                                      console.log('status'+data.status);

                                      if(data.status=="OK"){
                                          renglon = document.getElementById(a);
                                              renglon.style.background="#BEF4BB";
                                              document.getElementById('caja_'+a).checked=false;
                                           alert("El Registro se Actualizo correctamente");
                                              
                                      }else if(data.status == "NO"){
                                           alert("Favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                                              renglon = document.getElementById(a);
                                              renglon.style.background="#407E9D";
                                      }
                                    },
                                error: function(data){
                                    alert("No se pudo actualizar, intente mas tarde, favor de enviar correo con la informacion a sistemas, (ofarias@ftcenlinea.com)");
                                    renglon = document.getElementById(a);
                                    renglon.style.background="#E37777";
                                    document.getElementById('caja_'+a).checked=0;      
                                }
                                });  
                    
                    }
    }

    if(a != 'j'){
    alert('Actualizando el Saldo...');
    }


              var abonos = 0;
              var pagos = '';
              
            $(document).ready(function() {
            $("input:checkbox:checked.abono").each(function() {
                     var  docs = $(this).attr("docu");
                
                     var a = parseFloat(this.value,2);
                     abonos = abonos + a;
                     pagos = pagos +','+ docs;
                });
              });
             var abonosActuales = document.getElementById('abonos_a').value; 
    
            abonos = parseFloat(abonos,2) + parseFloat(abonosActuales,2);
        
            var tete = currency(abonos);
            document.getElementById('pagosA').value=pagos;

          
            var compras = 0;
            var docCompras= '';
            $(document).ready(function() {
            $("input:checkbox:checked.compra").each(function() {
                     var comp = $(this).attr("docu");
                     var tipo = $(this).attr("tipo");
                     var a = parseFloat(this.value,2);
                     compras = compras + a;
                     docCompras = docCompras + ',' + comp;
                });
              });
              document.getElementById('comprasA').value  = docCompras;
       

            var gastos = 0;
            var docGastos = '';
            $(document).ready(function() {
            $("input:checkbox:checked.gasto").each(function() {
                     var gtos =  $(this).attr("docu"); 
                     var tipo = $(this).attr("tipo");
                     var a = parseFloat(this.value,2);
                     gastos = gastos + a;
                     docGastos = docGastos + ',' + gtos;
                });
              });
              //alert('Documentos de Gastos' +  docGastos);
            document.getElementById('gastosA').value = docGastos;
              //var gastos = currency(gastos);
              //document.getElementById('total_gastos').innerHTML='$ '+ gastos;

            var saldoInicial = document.getElementById('saldo_inicial').value;
                
                //var saldoInicial = currency(saldoInicial);
                var comprasActuales = document.getElementById('cargos_a').value;
                
                //alert('compras Actuales');

                var totalAbonos  = abonos;
                var totalCompras = parseFloat(compras,2) + parseFloat(gastos,2) + parseFloat(comprasActuales,2);
              
                var saldoFinal  = parseFloat(saldoInicial) + parseFloat((totalAbonos - totalCompras),2);
                var totalCompras = currency(totalCompras);
                var saldoFinal = currency(saldoFinal);
                var saldoInicial = currency(saldoInicial);  

                //document.getElementById('saldo_inicial').innerHTML = '$ ' +  saldoInicial;
                document.getElementById('total_abonos').innerHTML = '$ '+ tete;
                //document.getElementById('total_abonos').innerHTML = '$ ' + tete;
                document.getElementById('total_cargos').innerHTML='$ '+ totalCompras;
                document.getElementById('saldoFinal').innerHTML = '$' + saldoFinal; 

              document.getElementById('saldo_inicial_header').innerHTML = saldoInicial;
              document.getElementById('abonos_header').innerHTML = tete;
              document.getElementById('cargos_header').innerHTML = totalCompras;
              document.getElementById('saldo_final').innerHTML =  saldoFinal;
               

     document.getElementById('icierre').value=saldoInicial;
     document.getElementById('acierre').value=tete;
     document.getElementById('ccierre').value=totalCompras;
     document.getElementById('fcierre').value=saldoFinal;

      if(a == 'a'){
        $("#formGuardar").submit();
      }
}


 function currency(value, decimals, separators) {
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || [',', ",", '.'];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return (parts.length == 3 ? '-' : '') + result;
}




  
  
  </script>