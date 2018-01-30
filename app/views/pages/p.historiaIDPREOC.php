<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Informacion General del Producto <?php echo $id?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th> Cotizacion </th>
                                            <th> Status </th>
                                            <th> Fecha Cotizacion </th>
                                            <th> Cantidad <br/> del Pedido</th>
                                            <th> Cantidad <br/> en Preorden</th>
                                            <th> Cantidad <br/> en OC en Transito </th>
                                            <th> Cantidad <br/> por solicitar</th>
                                            <th> Cantidad <br/> Recepcionada </th>
                                            <th> Pendiente de <br/> Recepcionar </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($historico as $data):
                                            if($data->STATUS == 'P'){
                                                 $statusID = 'Pendiente en Liberacion';     
                                            }elseif ($data->STATUS == 'N') {
                                                $statusID = 'Suministros';
                                            }elseif ($data->STATUS == 'B' and $data->REC_FALTANTE > 0 ) {
                                                $statusID = 'Ordenado';
                                            }elseif ($data->STATUS == 'S') {
                                                $statusID = 'No Suministrables';
                                            }elseif ($data->STATUS == 'B' and $data->REC_FALTANTE <= 0) {
                                                $statusID='Completo';
                                            }elseif($data->STATUS == 'X'){
                                                $statusID= 'En Pre Orden';
                                            }elseif($data->STATUS == 'F'){
                                                $statusID='Producto liberado por Tesoreria s(Costos)';
                                            }else{
                                                $statusID = 'Error Reportar a Sistenas';
                                            }
                                        ?>
                                       <tr>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $statusID?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td align="center"><?php echo ($data->CANT_ORIG);?></td>
                                            <td align="center"><?php echo $data->CANT_PREOC; ?></td>
                                            <td align="center"><?php echo $data->ENORDENES + $data->ENORDENESN ;?></td>
                                            <td align="center"><?php echo $data->REST?></td>
                                            <td align="center"><?php echo $data->RECEPCION?></td>
                                            <td align="center"><?php echo $data->REC_FALTANTE;?></td>
                                        
                                        </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
<?php if(count($ordenes)>0){?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ordenes de compra del id <?php echo $id?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Pre Orden</th>
                                            <th>Orden de <br/> Compra</th>
                                            <th>Partida</th>
                                            <th>ID</th>
                                            <th>Status</th>
                                            <th>Cantidad</th>
                                            <th>Pendientes <br/> de Validar</th>
                                            <th>Descripcion</th>
                                            <th>Realiza Orden:</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($ordenes as $data):
                                                $status = $data->STATUS_LOG2;
                                                $color = "";

                                                if(substr($data->CVE_DOC, 0, 2) <>'OP'){
                                                         if(trim(strtoupper($status)) == 'T'){
                                                              $status = 'Total Recibido';
                                                              $color = "style='background-color:#BCF5A9;'";
                                                         }elseif (empty($data->CVE_DOC)) {
                                                            $status = 'Sin Orden de Compra';
                                                         }elseif(($status == 'Liberado' or $status == 'Cancelado') and $data->CANTIDAD_REC == 0){
                                                          $status = 'Cancelado Total de Esta Orden';
                                                          $color = "style='background-color:#F5A9A9;'";
                                                         }elseif(($status == 'Liberado' or $status == 'Cancelado') and $data->CANTIDAD_REC > 0){
                                                          $status = 'Cancelado Parcial de Esta Orden, solo llegaron '.$data->CANTIDAD_REC.', de los '.$data->CANT.', solicitados.';
                                                          $color = "style='background-color:#F5A9A9;'";
                                                         }elseif ($status == 'par') {
                                                             $status = 'Llego Parcial en la Orden';
                                                         }elseif(empty($data->TP_TES)){
                                                              $status = 'Tesoreria (Pendiente de Pago)';
                                                         }elseif ($status == 'Tesoreria' and $data->CANTIDAD_REC == 0) {
                                                             $status = 'Tesoreria (Pendeinte de Liberacion o Reenrutar)';
                                                         }elseif ($status=='Tesoreria' and $data->CANTIDAD_REC > 0) {
                                                             $status = 'Tesoreria (Recepcion Parcial('.$data->CANTIDAD_REC.' ) ), aun quedan: '.($data->CANT - $data->CANTIDAD_REC).' pendientes por Liberar o Reenrutar';
                                                         }
                                                         elseif (empty($status) and !empty($data->TP_TES) and $data->STATUS_ORDEN == 'Nuevo') {
                                                             $status = 'En Asignar Unidad Logistica, desde el '.$data->FECHA_PAGO.'.';
                                                         }elseif(empty($status) and !empty($data->TP_TES) and $data->STATUS_ORDEN == 'secuencia'){
                                                               $status = 'En Asignar Secuencia de la Unidad, '.$data->UNIDAD;
                                                         }elseif (empty($status) and !empty($data->TP_TES) and $data->STATUS_ORDEN == 'admon'){
                                                               $status = 'En Administracion de Ruta desde el '.$data->FECHA_SECUENCIA.', YA SE PUEDE RECIBIR O FALLAR EN RECIBO!!!';
                                                         }elseif (empty($status) and !empty($data->TP_TES) and $data->STATUS_ORDEN == 'Total') {
                                                               $status ='En Recepcion de Mercancia';
                                                         }
                                                }else{
                                                          $status = $data->STATUS_REAL;
                                                }
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color?> >
                                            <td align="center"><?php echo $data->CVE_FTCPOC?></td>
                                            <td align="center"><?php echo $data->CVE_DOC;?></td>
                                            <td align="center"><?php echo $data->NUM_PAR;?></td>
                                            <td align="center"><?php echo $data->ID_PREOC?></td>
                                            <td><?php echo (empty($status))? 'Tesoreria(Pago)':$status; ?></td>
                                            <td><?php echo $data->CANT?></td>
                                            <td align="center"><?php echo $data->PXR;?></td>
                                            <td><?php echo empty($data->NOMBREFTC)? $data->NOMBREINVE:$data->NOMBREFTC?></td>
                                            <td><?php echo $data->REALIZA?></td>
                                            
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

<?php if(count($recepciones)>0){?>

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
                                        foreach ($recepciones as $data):  
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

<?php if(count($newrec)>0){?>

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Partidas Recepcionadas Nuevo Sistema del ID: <?php echo $id?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Recepcion de <br/> Orden de Compra</th>
                                            <th>Partida</th>
                                            <th>ID Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Usuario Recibe <br/> Fecha de Recepcion <br/> Folio de recepcion</th>
                                            <!--<th>Cant</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($newrec as $data):  
                                        ?>
                                       <tr class="odd gradeX" style='background-color:#CED8F6;'>
                                            <td align="center"><?php echo $data->ORDEN;?></td>
                                            <td align="center"><?php echo $data->PARTIDA;?></td>
                                            <td align="center"><?php echo $data->IDPREOC?></td>
                                            <td><?php echo $data->NOMBRE ?></td>
                                            <td align="center"><?php echo $data->CANTIDAD_REC;?></td>
                                            <td><?php echo $data->USUARIO?> <br/> <?php echo $data->FECHA?> <br/> <?php echo $data->ID_RECEPCION?></td>
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

<?php if(count($validaciones)>0){?>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Validaciones.
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
                                           
                                            <th>Cantidad Validada <br/> De la Recepcion </th>
                                            <th>Cantidad Acumulada <br/> Total Validado </th>
                                            <th>Costo Validado x Unidad</th>
                                            <!--<th>Cant</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($validaciones as $data):  

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
