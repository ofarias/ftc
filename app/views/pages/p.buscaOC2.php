<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
                        <div class="panel-heading">
                            Historial de Ordenes de compra.
                        </div>
        <div class="row">
            <br />
        </div>
        <div class="row">
                <div class="col-md-6">
                    <form action="index.php" method="post">
                    <div class="form-group">
                        <input type="text" name="doco" class="form-control" required="required" placeholder="Buscar Numero u Orden de compra"> <br/>
                        <input type="hidden" name="fechaedo" value ="<?php echo $fechaedo;?>">
                        <label> Ejemplo: para encontrar la Orden de compra OC1010, puede buscar por 1010 o OC o OC1010 o oc1010.</label>
                    </div>
                      <button type="submit" value = "enviar" name = "buscaOC2" class="btn btn-info">Buscar OC</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br />


<?php if($ho <> 'a'){
    ?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Informacion la Orden de compra <?php echo $doco?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Orden de <br/> Compra</th>
                                            <th>Fecha Documento</th>
                                            <th>Importe</th>
                                            <th>Folio Pago</th>
                                            <th>Monto Pago </th>
                                            <th>Ubicacion</th>
                                            <th>Status Validacion</th>
                                            <th>Logistica o Suministros </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($ho as $data):  

                                            if(empty($data->TP_TES)){
                                                $ubicacion1='Tesoreria'; 
                                            }elseif(!empty($data->TP_TES) and substr($data->CVE_DOC,0,2) == 'OP'){
                                                if($data->STATUS_LOG == 'Validada'){
                                                    $ubicacion1='Proceso Terminado: Ordenado-Pagado-Recibido-Validado';
                                                }elseif ($data->STATUS_LOG == 'Rechazada'){
                                                    $ubicacion1='Se rechazo por Recibo, ahora en Tesoreria.';
                                                }elseif($data->STATUS == 'CANCELADA_PAR'){
                                                    $ubicacion1 = 'Se Cancelo 1 o mas partidas';
                                                }elseif($data->STATUS == 'CANCELADA_TOT'){
                                                    $ubicacion1= 'Se cancelaron todas las partidas de la Orden';
                                                }
                                            }elseif(!empty($data->TP_TES) and strtoupper($data->STATUS_LOG) == strtoupper('nuevo')){
                                                $ubicacion1='Logistica';
                                            }elseif (!empty($data->TP_TES) and strtoupper($data->STATUS_LOG) == strtoupper('secuencia')){
                                                $ubicacion1='Asignacion de Secuencia (Se puede Recibir)';
                                            }elseif(!empty($data->TP_TES) and strtoupper($data->STATUS_LOG) == strtoupper('admon')){
                                                $ubicacion1='Administracion de Ruta (Se puede Recibir)';
                                            }elseif (!empty($data->TP_TES) and (strtoupper($data->STATUS_LOG)== strtoupper('Total') or strtoupper($data->STATUS_LOG) == strtoupper('pnr'))) {
                                                $ubicacion1 = 'Recepcion';
                                            }elseif (!empty($data->TP_TES) and strtoupper($data->STATUS_LOG) == strtoupper('fallido')) {
                                                $ubicacion1= 'Administrar Fallidos';
                                            }elseif (!empty($data->TP_TES) and strtoupper($data->STATUS_LOG) == strtoupper('tiempo')) {
                                                $ubicacion1='Corrige Ruta';
                                            }

                                            if((empty($data->STATUS_LOG2) and !empty($data->DOC_SIG)) or $data->STATUS_LOG2 == 'R' ){
                                                $ubicacion = 'Validacion';
                                            }else{
                                                $ubicacion = 'Suministros';
                                            }
                                        ?>
                                       <tr>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_DOC;?><br/> <a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" >Ver Original</a></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td><?php echo $data->TP_TES?></td>
                                            <td><?php echo $data->PAGO_TES?></td>
                                            <td><?php echo $ubicacion1;?><br/> <?php echo 'Unidad: '.$data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_REC?></td>
                                            <td><?php echo $ubicacion?></td>
                                        </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if($liberadas){?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Partidas liberadas de la OC de la Orden de compra <?php echo $doco?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Orden de <br/> Compra</th>
                                            <th>Partida</th>
                                            <th>ID</th>
                                            <th>Descripcion</th>
                                            <th>Importe</th>
                                            <th></th>
                                            <!--<th>Cant</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($liberadas as $data):  
                                        ?>
                                       <tr class="odd gradeX" style='background-color:#F5A9A9;' >
                                            <td align="center"><?php echo $data->CVE_DOC;?></td>
                                            <td align="center"><?php echo $data->NUM_PAR;?></td>
                                            <td align="center">
                                            <a href="index.php?action=historiaIDPREOC&id=<?php echo $data->ID_PREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <?php echo $data->ID_PREOC?></a>
                                            </td>
                                            <td><?php echo empty($data->NOMBREFTC)? $data->NOMBREINVE:$data->NOMBREFTC?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->TOT_PARTIDA,2);?></td>
                                            <td align="center"><?php echo $data->TOT_PARTIDA;?></td>   
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>

<?php }?>

<?php if($recepcionadas){?>

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Partidas Recepcionadas de la Orden de compra <?php echo $doco?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Recepcion de <br/> Compra</th>
                                            <th>Partida Recepcion</th>
                                            <th>ID Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <!--<th>Cant</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($recepcionadas as $data):  
                                        ?>
                                       <tr class="odd gradeX" style='background-color:#CED8F6;'>
                                            <td align="center"><?php echo $data->CVE_DOC;?></td>
                                            <td align="center"><?php echo $data->NUM_PAR;?></td>
                                            <td align="center"><?php echo $data->ID_PREOC?></td>
                                            <td><?php echo empty($data->NOMBREFTC)? $data->NOMBREINVE:$data->NOMBREFTC?></td>
                                            <td align="center"><?php echo $data->CANT;?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->TOT_PARTIDA,2);?></td>   
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>

<?php }?>

<?php if($validadas){?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Partidas Validadas de la Orden de compra <?php echo $doco?>.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Orden de Compra</th>
                                            <th>Recepcion <br/> Validada </th>
                                            <th>Partida Orden de compra</th>
                                            <th>ID Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad Original <br/> De la Orden de Compra </th>
                                            <th>Cantidad Validada <br/> De la Recepcion </th>
                                            <th>Cantidad Acumulada <br/> Total Validado </th>
                                            <th>Costo Validado x Unidad</th>
                                            <!--<th>Cant</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($validadas as $data):  

                                            $color = "style='background-color:#CEF6D8;'";
                                            if($data->CANT_OC > $data->CANT_VALIDADA){
                                                $color = "style='background-color:#F5D0A9'";
                                            }
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color?>>
                                            <td align="center"><?php echo $data->DOCUMENTO;?></td>
                                            <td align="center"><?php echo empty($data->DOC_RECEPCION)? 'FALLIDO':$data->DOC_RECEPCION; ?></td>
                                            <td align="center"><?php echo $data->PARTIDA;?></td>
                                            <td align="center"><?php echo $data->ID_PREOC?></td>
                                            <td><?php echo empty($data->NOMBREFTC)? $data->NOMBREINVE:$data->NOMBREFTC?></td>
                                            <td align="center"><?php echo $data->CANT_OC?></td>
                                            <td align="center"><?php echo $data->CANT_VALIDADA;?></td>
                                            <td align="center"><?php echo $data->TOTALVALIDACIONES?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->COSTO_VALIDADO,2);?></td>
                                               
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
