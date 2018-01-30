</div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitudes de las refacturacion del documento.<br/>
                            Si desea ver el detalle de la solicitud dar click en el Tipo de solicitud deseado.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Solicitud <br/> Tipo de Solicitud</th>
                                            <th>Factura</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Usuario Solicitud</th>
                                            <th>Status Soliciud </th>
                                            <th>Fecha Autorizacion</th>
                                            <th>Usuario Autorizacion</th>
                                            <th>Fecha de Ejecucion</th>
                                            <th>Usuario Ejecucion</th>  
                                            <th>Nota de Credito</th>
                                            <th>Factura Nueva</th>
                                            <th>Pedio asociado</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php foreach ($solicitudes as $data2):
                                            if($data2->STATUS_SOLICITUD == 1){
                                                $STATUS = 'Nueva';
                                            }elseif($data2->STATUS_SOLICITUD == 2){
                                                $STATUS = 'Autorizado / Sin Ejecutar';
                                            }elseif($data2->STATUS_SOLICITUD == 3){
                                                $STATUS = 'Rechazado';
                                            }elseif($data2->STATUS_SOLICITUD == 4){
                                                $STATUS = 'Autorizado / Ejecutado';
                                            }else{
                                                $STATUS = 'Otro';
                                            }
                                            
                                            if($data2->TIPO_SOLICITUD == 'CAMBIO FECHA'){
                                                $color = "blue";
                                            }elseif ($data2->TIPO_SOLICITUD == 'CAMBIO DOMICILIO') {
                                                $color = "red";
                                            }elseif($data2->TIPO_SOLICITUD == 'CAMBIO PRECIO'){
                                                $color = "#cc00cc";
                                            }elseif($data2->TIPO_SOLICITUD == 'CAMBIO CLIENTE'){
                                                $color = "#00e64d";
                                            }
                                            ?>
                                        <tr>
                                            <td><?php echo $data2->ID?> <br/><a href="index.php?action=verDetSolNC&id=<?php echo $data2->ID?>&tipo=<?php echo $data2->TIPO_SOLICITUD?>&factura=<?php echo TRIM($data2->FACT_ORIGINAL)?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" > <font color="<?php echo $color?>"><?php echo $data2->TIPO_SOLICITUD?> </font></a> </td>                         
                                            <td><?php echo $data2->FACT_ORIGINAL ?></td>
                                            <td><?php echo $data2->FECHA_SOLICITUD ?></td>
                                            <td><?php echo $data2->USUARIO_SOLICITUD ?></td>
                                            <td align="right"><?php echo $STATUS ?></td>
                                            <td><?php echo $data2->FECHA_AUTORIZA ?></td>
                                            <td><?php echo $data2->USUARIO_AUTORIZA ?></td>
                                            <td align="right"><?php echo $data2->FECHA_EJECUTA ?></td>
                                            <td align="right"><?php echo $data2->USUARIO_EJECUTA ?></td>
                                            <td><?php echo $data2->NC?></td>
                                            <td><?php echo $data2->FACTURA_NUEVA?></td>
                                            <td><?php echo $data2->PEDIDO_REMISION_ASOCIADO?></td>
                                        </tr>
                                        <?php endforeach;?>
                                 </tbody>
                            </table>
                      </div>
            </div>
        </div>
    </div>
</div>
</div>