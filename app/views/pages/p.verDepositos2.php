<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestro   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>BANCO</th>
                                            <th>CUENTA</th>
                                          
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($infoBanco as $data):
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->BANCO;?></td>
                                            <td><?php echo $data->NUM_CUENTA;?></td>
                                           
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
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalle de Estado de Cuenta   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                           
                                            <th>Año</th>
                                            <th>Mes  </th>
                                            <th>Total Depositos</th>
                                            <th>Ingresos por Venta</th>
                                            <th>Ingresos por Transferencia</th>
                                            <th>Ingresos por Devolucion Compra</th>
                                            <th>Ingresos por Devolucion Venta </th>
                                            <th>Ingresos por Prestamo</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($infoDepositos as $data): 
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ANIO;?> </td>
                                            <td><?php echo $data->MES;?></td>
                                            <td><a href="index.php?action=detalleMonto&tipo=Total&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"> <?php echo '$ '.number_format($data->SUM,2);?> </a></td>
                                            <td><a href="index.php?action=detalleMonto&tipo=IPV&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"><?php echo '$ '.number_format($data->IPV,2);?> </a> </td>
                                            <td><a href="index.php?action=detalleMonto&tipo=oTEC&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"><?php echo '$ '.number_format($data->TEC,2);?> </td>
                                            <td><a href="index.php?action=detalleMonto&tipo=DC&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"><?php echo '$ '.number_format($data->DCOM,2);?> </td>
                                            <td><a href="index.php?action=detalleMonto&tipo=DG&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"><?php echo '$ '.number_format($data->DVEN,2);?> </td>
                                            <td><a href="index.php?action=detalleMonto&tipo=oPCC&banco=<?php echo $banco?>&mes=<?php echo $data->MES?>&anio=<?php echo $data->ANIO?>"><?php echo '$ '.number_format($data->OPCC,2);?> </td>
                                                                                        
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

<?php if($detalle != '') { ?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($tipo == 'IPV'){
                                $etiqueta = 'Ingresos por Venta';
                            }elseif ($tipo == 'oTEC'){
                                $etiqueta = 'Transferencias entre cuentas'; 
                            }elseif ($tipo == 'DC') {
                                $etiqueta = 'Devolucion de Compra';
                            }elseif ($tipo == 'DG') {
                                $etiqueta = 'Devolucion de Gasto';
                            }elseif ($tipo == 'oPCC') {
                                $etiqueta = 'Prestamo';
                            }elseif($tipo == 'Total'){
                                $etiqueta = 'Ingresos Generales';
                            }
                             ?>
                             <?php echo $etiqueta?>   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>TIPO</th>
                                            <th>FOLIO</th>
                                            <th>FECHA</th>
                                            <th>MONTO</th>
                                            <th>CARGO FINANCIERO</th>
                                            <th>APLICADO</th>
                                            <th>ACREEDOR</th>
                                            <th>SALDO</th>
                                            <th>FOLIO ACREEDOR</th>
                                            <th>APLICACIONES</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($detalle as $key): 
                                           
                                            if(empty($key->TIPO_PAGO)){
                                                $etiqueta = 'Ingresos por Venta';
                                            }elseif ($key->TIPO_PAGO == 'oTEC'){
                                                $etiqueta = 'Transferencias'; 
                                            }elseif ($key->TIPO_PAGO == 'DC') {
                                                $etiqueta = 'Devolucion de Compra';
                                            }elseif ($key->TIPO_PAGO == 'DG') {
                                                $etiqueta = 'Devolucion de Gasto';
                                            }elseif ($key->TIPO_PAGO == 'oPCC') {
                                                $etiqueta = 'Prestamo';
                                            }elseif($key->TIPO_PAGO == 'Total'){
                                                $etiqueta = 'Ingresos Generales';
                                            }
                                            $color='';
                                            if($etiqueta == 'Ingresos por Venta' and $key->SALDO > 10){
                                                $color = "style='background-color:orange';";
                                            }elseif ($etiqueta == 'Ingresos por Venta' and $key->SALDO < -1) {
                                                $color="style='background-color:red';";
                                            }
                                            
                                        ?>

                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $etiqueta ?></td>
                                            <td><?php echo $key->FOLIO_X_BANCO;?> </td>
                                            <td><?php echo $key->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($key->MONTO,2);?></td>
                                            <td><?php echo $key->CF.' -> $ '.number_format($key->MONTO_CF,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICACIONES,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO_ACREEDOR,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO,2);?></td>
                                            <td><?php echo $key->FOLIO_ACREEDOR;?> </td>
                                            <td>
                                                <?php if($etiqueta == 'Ingresos por Venta' and $key->SALDO < $key->MONTO){?>
                                                <a href="index.php?action=pagoFacturas&idp=<?php echo $key->ID?>" target="_blank" class="btn-sm btn-info"> Ver Aplicaciones</a>
                                                <?php }?>
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