<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>UBICACION</th>
                                            <th>FECHA</th>
                                            <th>CLIENTE</th>
                                            <th>IMPORTE</th>
                                            <th>APLICADO</th>
                                            <th>IMPORTE <br/> NOTA DE CREDITO</th>
                                            <th>CANCELACION </th>
                                            <th style="background-color:'#ccffe6'">SALDO</th>
                                            <th>Referencia <br/> Aplicaciones</th> 
                                            <th>Referencia <br/> Pago</th>
                                            <th>Referencia <br/> Notas de Credito</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php $total=0?>
                                        <?php foreach ($documentos as $key): 
                                            $color='';
                                            if($key->SALDOFINAL >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDOFINAL <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                            if($key->STATUS == 'C'){
                                                $valCan = $key->IMPORTE;    
                                            }
                                            $total = $total + $key->SALDOFINAL;
                                            $maestro = $key->CLAVE_MAESTRO;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->CVE_DOC ?> </td>
                                            <td><?php echo $key->STATUS_FACT?></td>
                                            <td><?php echo $key->FECHA_DOC;?> </td>
                                            <td><?php echo $key->NOMBRE.'('.$key->CVE_CLPV.')';?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICADO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE_NC,2);?> </td>
                                            <td><?php echo '$ '.number_format($valCan,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDOFINAL,2);?></td>
                                            <td><?php echo $key->ID_APLICACIONES?></td>
                                            <td><?php echo $key->ID_PAGOS?></td>
                                            <td><?php echo $key->NC_APLICADAS?></td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td align="left" style="font-size: 20px"><b>Total de Saldo Facturas</b></td>
                                     <td align="right" style="font-size: 20px; color:blue"><b><?php echo '$ '.number_format($total,2)?></b></td>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<div>
    <label>Buscar Pagos </label> <br/>
    <label>Busqueda por Monto o Folio </label><br/>
    <form action="index.cobranza.php" method="post">
        <input type="hidden" name="items" value="<?php echo $items?>">
        <input type="hidden" name="total" value="<?php echo $total?>">
        <input type="hidden" name="seleccion_cr" value="<?php echo $seleccion_cr?>">
        <input type="text" name="pagos" placeholder="Buscar" required="required">
        <input type="hidden" name="retorno" value="<?php echo $retorno?>">
        <button name="FORM_ACTION_PAGO_FACTURAS_NUEVO" type="submit" value="enviar" class = "btn btn-info"> Buscar </button>    
    </form>
</div>

<div>
    <label>Busqueda por Banco </label><br/>
    <form action="index.cobranza.php" method="post">
        <input type="hidden" name="items" value="<?php echo $items?>">
        <input type="hidden" name="total" value="<?php echo $total?>">
        <input type="hidden" name="seleccion_cr" value="<?php echo $seleccion_cr?>">
        <select required="required" name="pagos">
            <option>Seleccion el Banco</option>
            <?php foreach($bancos as $data):?>
            <option value="<?php echo $data->BANCO?>"><?php echo $data->BANCO.' --> '.$data->NUM_CUENTA?></option>
            <?php endforeach;?>
        </select>
        
        <select name = "mes" required="required">
            <option value="" > Seleccionar un Mes </option>
            <option value = "1" >Enero</option>
            <option value = "2" >Febrero</option>
            <option value = "3" >Marzo</option>
            <option value = "4" >Abril</option>
            <option value = "5" >Mayo</option>
            <option value = "6" >Junio</option>
            <option value = "7" >Julio</option>
            <option value = "8" >Agosto</option>
            <option value = "9" >Septiembre</option>
            <option value = "10" >Octubre</option>
            <option value = "11" >Noviembre</option>
            <option value = "12" >Diciembre</option>
        </select>
        <br/>
        <select name = "anio" required="required">
            <option value=""> Seleccione un año </option>    
            <option value = "2016" > 2016 </option>
            <option value = "2017" > 2017 </option>
            <option value = "2018" > 2018 </option>
        </select>
         <input type="hidden" name="retorno" value="<?php echo $retorno?>">
        <button name="FORM_ACTION_PAGO_FACTURAS_NUEVO" type="submit" value="enviar" class = "btn btn-info"> Buscar </button>    
    </form>
</div>
<?php if($pagos != 0 ){ ?>
<br/>
<br/>
<div>
    <td>
     <form action="upload_comprobante_pago.php" method="post" enctype="multipart/form-data">
     <input type="file" name="fileToUpload" id="fileToUpload" required>
     <input type="hidden" name="maestro" value="<?php echo $maestro?>">
     <input type="hidden" name="items" value="<?php echo $items?>">
     <input type="submit" value="Subir Pedido" name="submit" >
     </form>
    </td>
</div>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID / Folio x Banco</th>
                                            <th>Banco</th>
                                            <th>Fecha Edo de Cta</th>
                                            <th>Monto </th>
                                            <th>Aplicado</th>
                                            <th>Saldo Actual</th>
                                            <th>Saldo despues de Aplicacion</th>
                                            <th>Aplicar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($pagos as $key): 
                                            $color='';
                                            if($key->SALDO >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDO <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->ID. ' / ' .$key->FOLIO_X_BANCO?> </td>
                                            <td><?php echo $key->BANCO?></td>
                                            <td><?php echo $key->FECHA_RECEP;?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICACIONES,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO - $total,2);?> </td>
                                            <td>

                                                <form action="index.php" method="post">
                                                    <input type="hidden" name="idp" value="<?php echo $key->ID?>">
                                                    <input type="hidden" name="saldop" value="<?php echo $key->SALDO?>">
                                                    <input type="hidden" name="items" value="<?php echo $items?>">
                                                    <input type="hidden" name="total" value="<?php echo $total?>">
                                                    <input type="hidden" name="retorno" value="<?php echo $retorno?>">
                                                    <button type="submit" name="comprobantePago" value="enviar" <?php echo (($key->SALDO - $total)< -5)? "disabled='disabled'":""?> >Aplicar Pago </button>
                                                </form>
                                                </td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<?php } ?>

<?php 
if($acreedor){?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID / Folio x Banco</th>
                                            <th>Banco</th>
                                            <th>Fecha Edo de Cta</th>
                                            <th>Monto </th>
                                            <th>Aplicado</th>
                                            <th>Saldo Actual</th>
                                            <th>Saldo despues de Aplicacion</th>
                                            <th>Aplicar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($acreedor as $key): 
                                            $color='';
                                            if($key->SALDO >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDO <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->ID. ' / ' .$key->FOLIO_X_BANCO?> </td>
                                            <td><?php echo $key->BANCO?></td>
                                            <td><?php echo $key->FECHA_RECEP;?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICACIONES,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO - $total,2);?> </td>
                                            <td>
                                                <form action="index.php" method="post">
                                                    <input type="hidden" name="idp" value="<?php echo $key->ID?>">
                                                    <input type="hidden" name="saldop" value="<?php echo $key->SALDO?>">
                                                    <input type="hidden" name="items" value="<?php echo $items?>">
                                                    <input type="hidden" name="total" value="<?php echo $total?>">
                                                    <input type="hidden" name="retorno" value="<?php echo $retorno?>">
                                                    <button type="submit" name="comprobantePago" value="enviar" <?php echo (($key->SALDO - $total)< -5)? "disabled='disabled'":""?> >Aplicar Pago </button>
                                                </form>
                                                </td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<?php }?>