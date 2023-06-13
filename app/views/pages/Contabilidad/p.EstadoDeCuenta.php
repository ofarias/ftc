<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 SALDO DE CUENTAS BANCARIAS &nbsp;&nbsp;&nbsp;v.1
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
                                            <th>Carga Edo Cta</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($bancos as $data):                           
                                        ?>
                                       <tr>
                                            <td align="lefth"><?php echo $data->BANCO;?><br/><br/><a class="btn-sm btn-primary" href="index.php?action=verCargas&b=<?php echo $data->BANCO?>&c=<?php echo $data->NUM_CUENTA?>" target="popup" onclick="window.open(this.href, this.target, 'width=1000,height=600'); return false;">Ver cargas</a></td>
                                            <td><?php echo $data->NUM_CUENTA;?></td>
                                            <td><?php echo $data->CTA_CONTAB;?></td>
                                            <td><?php echo $data->ABONOS_ACTUAL;?></td>
                                            <td><?php echo $data->ABONOS_ANTERIOR;?></td>
                                            <td><?php echo $data->MOV_X_REL_AC;?></td>
                                            <td>
                                              <form action="upload_EdoCta.php" method="post" enctype="multipart/form-data">
                                                <input type="file" name="fileToUpload">
                                                <input type="hidden" name="datos" value="<?php echo $data->BANCO.':'.$data->NUM_CUENTA.':'.$data->CTA_CONTAB?>">
                                                <input type="hidden" name="idb" value="<?php echo $data->ID?>">
                                                <input type="hidden" name="mes" value="0">
                                                <input type="hidden" name="anio" value="0">
                                                <input type="hidden" name="datos" value="<?php echo $banco.':'.$cuenta.':0:0'?>">
                                                <input type="hidden" name="o" value="v1">
                                                <input type="submit" name="enviar" value="Cargar">
                                              </form>
                                              <a href="app/tmp/LayOut_edo_cta.xlsx" download>Descarga LayOut</a>
                                            </td>
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
                                  <th width="5%"></th>
                                </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                    <td align="center">
                                      <select name="mes" id="fm">
                                        <?php foreach ($meses as $val):?>
                                        <option value = "<?php echo $val->NUMERO;?>"><?php echo $val->NOMBRE;?></option>
                                        <?php endforeach?>
                                           </select>
                                    </td>
                                    <td>
                                      
                                    </td>
                                    <td align="center">
                                        <select name='anio' id="fa">
                                          <option value="2023">2023</option>
                                          <option value="2022">2022</option>  
                                          <option value="2021">2021</option>
                                          <option value="2020">2020</option>
                                          <option value="2019">2019</option>
                                          <option value="2018">2018</option>
                                        </select>
                                    </td>
                                    <td>
                                    <?php foreach ($bancos as $data):?>
                                          <input type="hidden" name="banco" value="<?php echo $data->BANCO?>" id="fb">
                                          <input type="hidden" name="cuenta" value="<?php echo $data->NUM_CUENTA?>" id="fc">
                                    <?php endforeach ?>
                                        <button name="FiltrarEdoCta" value="enviar" onclick="filtrar()"> Aplicar </button>
                                    </td>
                                    <td align="lefth"> <input type="checkbox" name="f" id="f"><b> Mantener carga Excel</b></td>
                                    </tr>
                              </tbody>
                         </table>                             
                      </div>
            </div>
        </div>
</div>
</div>

<?php if($mes!=0){ ?>

<?php if(empty($exec)){ ?>
    <!--
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
                            </div>
                  </div>
              </div>
      </div>
    -->
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
                                    </td>
                                    <td width="50%">
                                    <label> Compras: $ <?php echo number_format($totC,2); ?> </label> <br>
                                    <label> Compras a Credito Pagadas: $ <?php echo number_format($totCr,2); ?></label> <br>
                                    <label> Gastos : $ <?php echo number_format($totG,2); ?> </label> <br>
                                    <label> Deudores: $ <?php echo number_format($totD,2); ?></label> <br>
                                    <label> </label> <br>
                                    <label> Egresos TOTALES: $ <?php echo number_format(($totC + $totG + $totD),2) ?></label>
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
                                            <th>POR CONCILIAR/APLICAR</th>
                                            <th>TIPO PAGO</th>
                                            <th>REGISTRAR</th>
                                            <th>NUEVA FECHA</th>
                                            <th>USUARIO QUE REGISTRO</th>
                                            <th>Contabilizado?</th>
                                            <th>Contabilizar</th>
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
                                                $color="style='background-color:brown;'"; 
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
                                            <form action = "index.php" method="post">
                                            <td>
                                              <input type="hidden" name="anio" value = "<?php echo $anio?>" />
                                              <input type="hidden" name="idtrans" value="<?php echo $datos->IDENTIFICADOR?>" />
                                              <input type="hidden" name="idmonto" value="<?php echo $datos->ABONO?>" />
                                              <input type="hidden" name="tipo" value="<?php echo $datos->TIPO?>"/>
                                              <input type="hidden" name="mes" value="<?php echo $mesactual->NUMERO?>" />
                                              <input type="hidden" name="banco" value="<?php echo Trim(substr($datos->BANCO, 0, 8))?>" />
                                              <input type="hidden" name="cuenta" value="<?php echo Trim(substr($datos->BANCO,10,11))?>">
                                              <input type="hidden" name="montoCargo" value ="<?php echo $datos->CARGO;?>" />
                                              <input type="hidden" name="comprobado" value ="<?php echo $datos->COMPROBADO?>" />
                                              <button name="regEdoCta" type="submit" value ="enviar" 
                                                <?php echo ($datos->REGISTRO == 1)? "class='btn btn-success'":"class='btn btn-warning'"?>  
                                                <?php echo (
                                                            ($datos->SALDO <= 2 and empty($datos->TP) and ($datos->REGISTRO == 0))
                                                            or  
                                                            ($datos->REGISTRO == 0 and $datos->TP == 'Compra')
                                                            or
                                                            ($datos->REGISTRO == 0 and ($datos->TP == 'oTEC' or $datos->TP =='oPC' or $datos->TP == 'oPCC' or $datos->TP == 'DG' or $datos->TP == 'DC'))
                                                            )?
                                                             '':"disabled='disabled'"?> >
                                                <?php echo ($datos->REGISTRO == 1)? "Registrado":"Registrar"?> 
                                              </button>
                                              <?php if($datos->TIPO == 'Venta'){ ?>
                                              <button value = "enviar" type="submit" class="btn btn-danger" name="cancelarCargaPago"> Cancelar Pago </button>
                                              <?php } ?>
                                              </td>
                                              <td>
                                              <input name = "nvaFechComp" type="text" value="<?php echo $nvaFechComp ?>" class="date1" 
                                                <?php echo ($datos->TIPO == 'Venta')? 'disabled="disabled"':''?> required="required" /><br/>

                                              <!--<button name= "regEdoCta1" type="submit" value="enviar" 
                                                  <?php echo($datos->TIPO == 'Venta' )? 
                                                            'disabled="disabled"':'' ?>
                                                            > Guardar </button>-->
                                              <!--<a onclick="colores('<?php echo $i;?>', '<php echo $datos->IDENTIFICADOR>')" href="index.php?action=pagoFacturas&idp=1" target="_blank">TEST</a>-->
                                             <a href="javascript:colores('<?php echo $i;?>', '<?php echo $datos->IDENTIFICADOR?>','1')" class="btn btn-info">Guardar</a>
                                             <a href="javascript:colores('<?php echo $i;?>','<?php echo $datos->IDENTIFICADOR?>','0')" class="btn btn-success">Desmarcar</a>
                                              </td>
                                            
                                            <td><?php echo $datos->USUARIO;?></td>
                                            <td><?php echo $datos->CONTABILIZADO?></td>
                                               <td>
                                                 <a href="index.php?action=pagoFacturas&idp=<?php echo $datos->IDENTIFICADOR?>" target="_blank"? class='btn btn-success'> Contabilizar </a>
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
<?php 
} 
?>
<?php }
?>
<!--
  <form action="index.php" method=post id="formulario1" target="el-iframe"> 
    <input type="hidden" name="fecha" id="fnvaFecha" value=""> 
    <input type="hidden" name="iden" id="fiden" value="">
    <input type="hidden" name="valor" id="valor" value="">
    <input type="hidden" name="regnvafecha"> 
  </form>
  <iframe name="el-iframe" type="hidden"></iframe>
-->
<!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

   function filtrar(){
    var mes = document.getElementById('fm').value
    var anio = document.getElementById('fa').value
    var cuenta = document.getElementById('fc').value
    var banco = document.getElementById('fb').value
    var f = document.getElementById('f').checked
    if(f){
      f='si'
    }else{
      f='no'
    }
    window.open("index.php?action=FiltrarEdoCta&mes="+mes+"&anio="+anio+"&cuenta="+cuenta+"&banco="+banco+"&f="+f , "_self")

  }

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