<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ruta de Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            
                                            <th>Caja</th>
                                            <th>Documento</th>
                                            <th>Original</th>
                                            <th>Nuevo</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($historia as $data):  
                                            $i++;
                                            $color = '';
                                            $tipoo = '';
                                            $tipod = '';
                                            if($data->STATUS_ORIG == 0 ){
                                                $color = "style='background-color:#FA5858'";
                                                $tipoo ='Asignacion de Unidad';
                                            }elseif ($data->STATUS_ORIG == 1) {
                                                $color = "style='background-color:#FA5858'";
                                                $tipoo = 'Secuencia';
                                            }elseif($data->STATUS_ORIG == 2){
                                                $color = "style='background-color:#FA5858'";
                                                $tipoo = 'Administracion';
                                            }elseif($data->STATUS_ORIG == 3){
                                                $color = "style='background-color:#FA5858'";
                                                $tipoo = 'En Bodega';
                                            }elseif($data->STATUS_ORIG == 4){
                                                $color = "style='background-color:#FA5858'";
                                                $tipoo = 'En Bodega Cambio de Status';
                                            }elseif ($data->STATUS_ORIG == 5){
                                                $color = "style='background-color:#F2F5A9'";
                                                $tipoo = 'Procesado';
                                            }elseif($data->STATUS_ORIG == 6){
                                                $color = "style='background-color: #CEE3F6'";
                                                $tipoo = 'Con Comprobante <br/> Listo para Recepcion';
                                            }elseif ($data->STATUS_ORIG == 7){
                                                $color = "style='background-color:#81BEF7'";
                                                $tipoo = 'Recibido, Sin Contra Recibo';
                                            }elseif ($data->STATUS_ORIG == 8){
                                                $color = "style='background-color:#6699ff'";
                                                $tipoo = 'Recibido, Con Contra Recibo';
                                            }elseif ($data->STATUS_ORIG == 9){
                                                $color = "style='background-color:#6699ff'";
                                                $tipoo = 'Listo para Cobrar';
                                            }elseif ($data->STATUS_ORIG == 10){
                                                $color = "style='background-color:#ffb3ff'";
                                                $tipoo = 'Vencido';
                                            }elseif ($data->STATUS_ORIG == 11){
                                                $color = "style='background-color:#2d862d'";
                                                $tipoo = 'Cobrado';
                                            }elseif ($data->STATUS_ORIG ==22){
                                                $color = "style='background-color:#2d862d'";
                                                $tipoo = 'Nota de Credito Total';
                                            }elseif ($data->STATUS_ORIG ==33){
                                                $color = "style='background-color:#2d862d'";
                                                $tipoo = 'Nota de credito Parcial';
                                            }elseif ($data->STATUS_ORIG ==44){
                                                $color = "style='background-color:#2d862d'";
                                                $tipoo = 'Refacturado';
                                            }
                                            if($data->STATUS_DEST == 0 ){
                                                $color = "style='background-color:#FA5858'";
                                                $tipod ='Asignacion de Unidad';
                                            }elseif ($data->STATUS_DEST == 1) {
                                                $color = "style='background-color:#FA5858'";
                                                $tipod = 'Secuencia';
                                            }elseif($data->STATUS_DEST == 2){
                                                $color = "style='background-color:#FA5858'";
                                                $tipod = 'Administracion';
                                            }elseif($data->STATUS_DEST == 3){
                                                $color = "style='background-color:#FA5858'";
                                                $tipod = 'En Bodega';
                                            }elseif($data->STATUS_DEST == 4){
                                                $color = "style='background-color:#FA5858'";
                                                $tipod = 'En Bodega Cambio de Status';
                                            }elseif ($data->STATUS_DEST == 5){
                                                $color = "style='background-color:#F2F5A9'";
                                                $tipod = 'Procesado';
                                            }elseif($data->STATUS_DEST == 6){
                                                $color = "style='background-color: #CEE3F6'";
                                                $tipod = 'Con Comprobante <br/> Listo para Recepcion';
                                            }elseif($data->STATUS_DEST == 61){
                                                $color = "style='background-color:#f2c294'";
                                                $tipod = 'Procesado, Recibido en Contra Recibo';
                                            }elseif ($data->STATUS_DEST == 7){
                                                $color = "style='background-color:#81BEF7'";
                                                $tipod = 'Recibido, Sin Contra Recibo';
                                            }elseif($data->STATUS_DEST == 71){
                                                $color = "style='background-color:#f2c294'";
                                                $tipod = 'Con Contra Recibo, Recibido en Cobranza';
                                            }elseif ($data->STATUS_DEST == 8){
                                                $color = "style='background-color:#6699ff'";
                                                $tipod = 'Recibido, Con Contra Recibo';
                                            }elseif ($data->STATUS_DEST == 9){
                                                $color = "style='background-color:#6699ff'";
                                                $tipod = 'Listo para Cobrar';
                                            }elseif ($data->STATUS_DEST == 10){
                                                $color = "style='background-color:#ffb3ff'";
                                                $tipod = 'Vencido';
                                            }elseif ($data->STATUS_DEST == 11){
                                                $color = "style='background-color:#2d862d'";
                                                $tipod = 'Cobrado';
                                            }elseif ($data->STATUS_DEST ==22){
                                                $color = "style='background-color:#2d862d'";
                                                $tipod = 'Nota de Credito Total';
                                            }elseif ($data->STATUS_DEST ==33){
                                                $color = "style='background-color:#2d862d'";
                                                $tipod = 'Nota de credito Parcial';
                                            }elseif ($data->STATUS_DEST ==44){
                                                $color = "style='background-color:#2d862d'";
                                                $tipod = 'Refacturado';
                                            }
                                            

                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="linea_<?php echo $i?>">
                                           
                                            <td align="center"><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $tipoo;?></td>
                                            <td><?php echo $tipod;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>