<style type="text/css">
  #carga{
    height: 100%; 
    width:20%;
    float: left;

  }

  #descarga{
    height: 100%;
    width:80%;
    float: right;
  }

  div.img.span{
     line-height:normal;
     font-size:11px;
     display:table-caption;
     margin:0;
     background:#646464;
     color:white;
     font-style:italic;
     padding:5px;
     text-align:center;
  }
</style>

  <br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 SALDO DE CUENTAS BANCARIAS &nbsp;&nbsp;&nbsp;v.2
                        </div>
                        <?php 
                          $saldoInicial = 0;
                          foreach ($saldos as $sdos ):
                          $saldoInicial = $sdos->MONTO_FINAL;
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
                                            <th>Dias de Corte</th>
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
                                            <td><?php echo $data->BANCO;?><input type="hidden" name="banco" id="banco" value="<?php echo $data->BANCO?>"><p><a class="btn-sm btn-primary" href="index.php?action=verCargas&b=<?php echo $data->BANCO?>&c=<?php echo $data->NUM_CUENTA?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=600'); return false;">Cargas</a></p></td>
                                            <td><?php echo $data->NUM_CUENTA;?><input type="hidden" name="banco" id="cuenta" value="<?php echo $data->NUM_CUENTA?>"></td>
                                            <td><?php echo $data->CTA_CONTAB;?></td>
                                            <td align="center"><b><?php echo $data->DIA_CORTE?></b></td>
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
                                        <td align="lefth"> <!--<input type="checkbox" name="f" id="f"><b> Mantener carga Excel</b>--></td>
                                    </td>
                                    </tr>
                              </tbody>
                         </table>                             
                      </div>
            </div>
        </div>
  </div>
</div>
<div class="<?php echo $mes !=0? '':'hidden' ?>" id="cont">
  <div id="carga">
    <label>Adjuntar Estado de cuenta</label>
      <form action="upload_edocta.php" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf">
          <input type="hidden" name="idb" value="<?php echo $data->ID?>">
          <input type="hidden" name="mes" value="<?php echo $mes?>">
          <input type="hidden" name="anio" value="<?php echo $anio?>">
          <input type="hidden" name="datos" value="<?php echo $banco.':'.$cuenta.':'.$mes.':'.$anio?>">
          <input type="hidden" name="o" value="v2">
          <button name="subirEdoCta" type="submit" value="enviar">Adjuntar</button>
      </form>  
  </div>
  <div id="descarga">
    <?php if(count($desc) > 0){?>
      <?php $i=0; foreach ($desc as $d): $i++; ?>
          <?php $x = explode(":", $d->DESCRIPCION);
                $da = $x[1];$dm = $x[0];
                if($da == $anio and $i < 14): ?>
                  <a title="<?php echo substr($d->NOMBRE,21).'--> '.$dm.'-->'.$da ?>" href="/uploads/edocta/<?php echo $d->NOMBRE?>" download ><img border='0' src='app/views/images/pdf.jpg' width='80' height='80'></a>&nbsp;&nbsp;
          <?php endif; ?>
      <?php endforeach ?>
    <?php }?>
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
<?php }else{ ?>
<?php if($mes!=0){ ?>

<?php if (empty($exec)){?>

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
<?php }else{?>
<br/><br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Detalle de Tipo de Ingresos del mes <font color="yellow"><b><?php echo $mesactual->NOMBRE.'</b></font>
                          durante el periodo del <font color="yellow"><b>'.$data->DIA_CORTE.' de '.$mesactual->NOMBRE.' al '.($data->DIA_CORTE-1).' de '.$mesactual->SIGUIENTE;?></b></font>.
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
                          Movimientos Registrados en <?php echo $mesactual->NOMBRE.'
                          durante el periodo del '.$mesactual->FECHA_INI.' al '.$mesactual->FECHA_FIN;?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                                                 
                                <table class="table table-striped table-bordered table-hover" id="dataTables-EdoCtaV3">
                                    <thead>
                                        <tr style='background:yellow'>
                                            <th></th>
                                            <th>Tipo</th>
                                            <th>Folio / UUID </th>
                                            <th>Fecha Registro</th>
                                            <th>Abono</th>
                                            <th>Cargo</th>
                                            <th>Por Conciliar/Aplicar</th>
                                            <th>Tipo Pago</th>
                                            <th>Registrar / <font color="#8d99ff">Tipo</font></th>
                                            <th>Usuario Registro</th>
                                            <th>Tipo</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php $i = 0;
                                              $desc1 = '';
                                              $desc = '';
                                        foreach ($exec as $datos):
                                              if(empty($datos->TP) and $datos->TIPO == 'Venta'){
                                                $tipo = 'Venta';
                                              } else{
                                                $tipo = $datos->TP;  
                                              }
                                              $i++;  
                                              if($tipo == 'DC' or $datos->TIPO == 'DC'){
                                              $desc = 'DEVOLUCION DE COMPRA.';
                                              }elseif ($tipo =='DG' or $datos->TIPO == 'DG'){
                                              $desc = 'DEVOLUCION DE GASTO.';
                                              }elseif ($tipo == 'oTEC' or $datos->TIPO == 'oTEC'){
                                              $desc = 'TRANSFERENCIA ENTRE CUENTAS PROPIAS.' ;
                                              }elseif ($tipo == 'oPCC' or $datos->TIPO == 'oPCC'){
                                              $desc = 'PRESTAMO CAJA CHICA,';
                                              }elseif ($tipo == 'Venta'){
                                                $desc = 'Aplicacion de Factura';
                                              }elseif($tipo == 'Compra'){
                                               $desc = 'Compra'; 
                                              }elseif(substr($tipo,0,3)== 'GTR' or (substr($tipo,0,3))== 'GEF' or (substr($tipo,0,3)== 'GCH')){
                                                $desc = $tipo;
                                                $desc1 = 'gasto';
                                              }elseif ($tipo == 'Deudor') {
                                                $desc = 'Deudor';
                                              }elseif ($tipo == 'DV') {
                                                $desc = 'DEVOLUCION DE VENTA';
                                              }

                                              if($datos->FA >= 1){
                                                $desc = 'Acreedor-'.$datos->FA;
                                              }
                                               $color = '';
                                              if($datos->COMPROBADO == '1'){
                                                $color=""; 
                                              }
                                              if($datos->DUPLICADOS >= 1){
                                                $color = "style='background-color:#F1E4FF' title='Se encontraron ".$datos->DUPLICADOS." posibles duplicados, favor de revisar la información.'";
                                              }        

                                          ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="<?php echo $i;?>">
                                            <td><?php echo $i?></td>
                                            <td><?php echo $datos->S==4? 'Gasto':$datos->TIPO;?></td>
                                            <td><?php echo $datos->CONSECUTIVO.' / '.$datos->TP_TES.'<br/>'.$datos->OBS;?></td>
                                            <td><?php echo substr($datos->FECHAMOV,0, 10) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->ABONO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->CARGO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>
                                            <td>
                                              <?php if($datos->S == 1 ){?>
                                              <a href="index.php?action=pagoFacturas&idp=<?php echo $datos->IDENTIFICADOR?>" target="_blank"?> <?php echo $desc;?> </a>
                                            <?php }elseif($datos->S == 4){?>
                                              <a href="index.php?action=detalleGasto&idg=<?php echo $datos->CONSECUTIVO?>" target="_blank">Aplicar <?php echo $desc?></a>
                                              <?php }else{?>
                                              <?php echo $desc;?> 
                                              <?php }?>
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
                                              <input type="hidden" name="fecha_o" value="<?php echo $datos->FECHAMOV?>" id="fo_<?php echo $i?>">
                                              <input type="text" name="fecha_edo" value="<?php echo $datos->FECHAMOV?>" class="date1" id="fn_<?php echo $i?>"
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

                                              <input type="button" class="chgTipo" v="<?php echo $datos->ABONO+$datos->CARGO-$datos->SALDO?>" ln="<?php echo $i?>" tipo="<?php echo $datos->S?>" iden="<?php echo $datos->IDENTIFICADOR?>">
                                              <?php switch ($datos->TP) {
                                                case 'DC':
                                                    $tipo = 'Dev. de Compra';
                                                  break;
                                                case 'DG':
                                                    $tipo = 'Dev. de Gasto';
                                                  break;
                                               case 'DV':
                                                    $tipo = 'Dev. de Venta';
                                                  break;
                                               case 'oIng':
                                                    $tipo = 'Otros Ingresos';
                                                  break;
                                               case 'oEgr':
                                                    $tipo = 'Otros Egresos';
                                                  break;
                                               case 'venta':
                                                    $tipo = 'Venta';
                                                  break;
                                               case 'Gasto':
                                                    $tipo = 'Gasto';
                                                  break;
                                               case 'Compra':
                                                    $tipo = 'Compra';
                                                  break;
                                               case 'intGan':
                                                    $tipo = 'Intereses Ganados';
                                                  break;
                                               case 'DC':
                                                    $tipo = 'Intereses Pagados';
                                                  break;
                                               
                                                default:
                                                    $tipo = 'Sin Definir';
                                                  break;
                                              } 
                                                echo '<font color="#8d99ff">'.$tipo.'</font>';
                                              ?> 

                                              </td>
                                            <td><?php echo $datos->USUARIO;?></td>
                                            <td><?php echo $datos->TP_TES?></td>
                                            </form>
                                            <td><input type="button" value="Eliminar" class="btn btn-sm btn-danger eliminar" tipo="<?php echo $datos->S?>" iden="<?php echo $datos->IDENTIFICADOR?>" ></td>
                                            
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
                              <input type="hidden" name="f" value="<?php echo $f?>">
                              <button type="submit" name="cerrarEdoCtaMes" value="enviar" > Cierre de Estado de Cuenta</button>
                            </form>
                            </center>
                      </div>
            </div>
        </div>
</div>
<?php } ?>
<?php } ?>
<div>
    <div id="column-left">
            <font size="4px" color="black">SaldoIncial =</font> <font color="blue" size="4pxs" id="si" > <?php echo '$ '.number_format($saldoInicial,2)?> </font> <br/>
            <font size="4px" color="black"> Abonos (seleccionados) = </font><b><font color="blue" size="5pxs" id = "total_abonos"> $ 0.00 </font></b><br/>
            <font size="4px" color="black"> Cargos (seleccionados)= </font><b><font color = "black" size="5pxs" id = "total_cargos"> $ 0.00 </font></b><br/>
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
    <input type="hidden" name="f" value="<?php echo $f?>">
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

  $(".chgTipo").click(function(){
      var v = parseFloat($(this).attr('v'))
      var ln = $(this).attr('ln')
      var tipo = $(this).attr('tipo')
      var id = $(this).attr('iden')
      renglon = document.getElementById(ln);
      renglon.style.background="#ACD6E5";
      $.confirm({
        title: 'Cambio de tipo',
        content: 'Desea Cambiar el tipo de Registro?' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Seleccione el nuevo tipo:</label>' +
        '<select name="sel" class="sel from-control" required>' +
          '<option value="oTEC">Transferencia entre Cuentas</option>'+
          '<option value="DC">Devolucion de Compra</option>'+
          '<option value="DG">Devolucion de Gasto</option>'+
          '<option value="DV">Devolucion de Venta</option>'+
          '<option value="oIng">Otros Ingresos</option>'+
          '<option value="oEgr">Otros Egresos</option>'+
          '<option value="venta">Venta</option>'+
          '<option value="gasto">Gasto</option>'+ 
          '<option value="compra">Compra</option>'+ 
          '<option value="intGan">Intereses Ganados</option>'+ 
          '<option value="intPag">Intereses Pagados</option>'+ 
        '</select>'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Cambiar',
                btnClass: 'btn-blue',
                action: function () {
                    var nt = this.$content.find('.sel').val();
                    if(v != 0){
                        $.alert('Solo se puede cambiar Movimientos sin aplicaciones...');
                        return false;
                    }
                    //$.alert('Procede al cambio... a ' + name + ' del tipo: '+ nt + ' identificador: ' + id);
                    $.ajax({
                      url:'index.v.php',
                      type:'post',
                      dataType:'json',
                      data:{chgTipo:1, tipo, id, nt},
                      success:function(data){
                        location.reload(true)
                        //$.alert(data.mensaje)
                      },
                      error:function(data){
                        $.alert(data.mensaje)
                      } 
                    })
                }
            },
            cancelar: function () {
                //close
                renglon.style.background="";
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
  })

  $(".eliminar").click(function(){
    var id = $(this).attr("iden")
    var tipo = $(this).attr("tipo")
    $.confirm({
      title: 'Eliminar Registro',
      content: 'Desea Elminiar el Registro?',
      buttons: {
          Si: function () {
              $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{delEdoCta:1, tipo, id},
                success:function(data){
                  $.alert(data.mensaje)
                },
                error:function(){
                  $.alert('No se pudo eliminar el registro, favor de revisar la informacion o reportar a sistemas')
                }
              })
          },
          No: function () {
              $.alert('No se realizo ningun cambio');
          },
      }
    });
  })

  $(document).ready(function() {
    $(".date1").datepicker({dateFormat: 'yy-mm-dd'});
      var abonos = 0;
      var pagos = '';
    $("input:checkbox:checked.abono").each(function() {
             var  docs = $(this).attr("docu");
             var tipo = $(this).attr("tipo");
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
        var value= document.getElementById('caja_'+identificador);
        var banco = document.getElementById('banco').value;
        var cuenta = document.getElementById('cuenta').value;
        var fo = document.getElementById('fo_'+identificador).value;
        if(value.checked == true){
          alert('No se puede carmbiar la fecha en registros seleccionados');
          document.getElementById('fn_'+identificador).value=fo;
        }else{
        if(confirm('Desea cambiar la fecha del documento ' + docu + ' de tipo ' + tipo + 'nueva fecha' + nuevaFecha)){
          $.ajax({
            type:'POST',
            url:'index.php',
            dataType:'json',
            data:{validaEdoCta:1,banco:banco,cuenta:cuenta,fecha:nuevaFecha},
            success:function(data){
              if(data.status== 'No'){
                renglon = document.getElementById(identificador);
                renglon.style.background="#407E9D";
                document.getElementById('fn_'+identificador).value=fo;
                alert('El mes a donde quieres mover el movimiento se encuentra auditado por contabilidad');
              }else if(data.status=='ok'){
                  $.ajax({
                       type: 'POST',
                       url: 'index.php',
                       dataType: "json",
                       data: {actFecha:tipo,tipo:tipo,docu:docu,fecha:nuevaFecha},
                       success: function(data){
                              if(data.status=="OK"){
                                  renglon = document.getElementById(identificador);
                                      renglon.style.background="#BEF4BB";
                                      document.getElementById('caja_'+identificador).checked=true;
                                      var actSaldo = actualizaSaldo()
                                      //alert("El Registro se Actualizo correctamente");
                                      
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
              }
            }
          });
        //window.setTimeout(test(indentificador),100);
      }else{
        alert('No se Registro Ningun Movimiento');
      }
    }
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
                                              document.getElementById('fn_'+a).readOnly=true;
                                           //alert("El Registro se Actualizo correctamente...");
                                              
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
                                    document.getElementById('fn_'+a).readOnly=false;   
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
                                              document.getElementById('fn_'+a).readOnly=true;
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
                                    document.getElementById('fn_'+a).readOnly=false;      
                                }
                                });  
                    
                    }
    }

    if(a != 'j'){
    //alert('Actualizando el Saldo...');
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

function actualizaSaldo(){
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
<?php }?>