<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Saldos de los Maestros.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto</th>
                                            <th>Aplicaciones</th>
                                            <th>Saldo</th>
                                            <th>Tipo Pago</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Usuario Registra</th>
                                            <th>Cerrar</th>
                                            <th>Acreedor</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($info as $data):

                                        if(empty($data->TIPO_PAGO)){
                                            $tipo = 'Ingreso por Venta';
                                            }else{
                                               $tipo = 'No Ingreso';
                                            } 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICACIONES,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <form action="index.php" method ="post">
                                            <td>
                                                <input type="hidden" name="idp" value="<?php echo $data->ID?>">
                                                <input type="hidden" name="saldo" value="<?php echo $data->SALDO?>">
                                                <button name="cerrarPago" value="enviar" type="submit" class="btn btn-warning" <?php echo ($data->SALDO <= 1)? '':'disabled="disabled"'?> > Cerrar <i class="fa fa-file"></i></button>
                                            </td>
                                            <td>
                                                <button name="solAcreedor" value="enviar" type="submit" class="btn btn-success" id="btnSol" onclick="ocultar()" <?php echo (empty($data->TIPO_PAGO) and ($data->SALDO >=1))? '':'disabled="disabled"' ?>  > Solicitar Acreedor </button>
                                            </td>
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
                            <!-- /.table-responsive -->
<br/><br />

<?php if(count($pagosCerrados) > 0){ ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Documentos En Espera de Ser Recibidos por Contabilidad.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto</th>
                                            <th>Aplicaciones</th>
                                            <th>Saldo</th>
                                            <th>Tipo Pago</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Usuario Registra</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php

                                        $totalCerrados=0;
                                        foreach ($pagosCerrados as $data):
                                            $totalCerrados= $totalCerrados + $data->MONTO;
                                        if(empty($data->TIPO_PAGO)){
                                            $tipo = 'Ingreso por Venta';
                                            }else{
                                               $tipo = 'No Ingreso';
                                            } 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICACIONES,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                    
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td>Total Cerrados: </td>
                                     <td><?php echo '$ '.number_format($totalCerrados,2)?></td>
                                     <td></td>
                                 </tfoot>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }?>

<?php if(count($acreedores) > 0){ ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Documentos que esperan autorizacion de Acreedores.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RutasActivas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Folio</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto</th>
                                            <th>Aplicaciones</th>
                                            <th>Saldo</th>
                                            <th>Tipo Pago</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Usuario Registra</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php

                                        $total = 0;

                                        foreach ($acreedores as $data):
                                            $total = $total + $data->SALDO;

                                        if(empty($data->TIPO_PAGO)){
                                            $tipo = 'Ingreso por Venta';
                                            }else{
                                               $tipo = 'No Ingreso';
                                            } 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICACIONES,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                    
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td>Total En Acreedores</td>
                                     <td><?php echo '$ '.number_format($total,2)?></td>
                                 </tfoot>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }?>