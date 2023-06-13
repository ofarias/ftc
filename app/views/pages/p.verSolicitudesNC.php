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
                                            <th>No. Solicitud / Caja <br/> Tipo de Solicitud</th>
                                            <th>Factura<br/>Observaciones</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Usuario Solicitud</th>
                                            <th>Status Soliciud </th>
                                            <th>Fecha Autorizacion</th>
                                            <th>Usuario Autorizacion</th>
                                            <th>Fecha de Ejecucion</th>
                                            <th>Usuario Ejecucion</th>  
                                            <th>Nota de Credito</th>
                                            <th>Doc para Refacturar</th>
                                            <th>Pedio asociado</th>
                                            <th>Nueva Factura(s)</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php foreach ($solicitudes as $data2):
                                            $STATUS='';
                                            if($data2->STATUS_SOLICITUD == 0){
                                                $STATUS = 'Nueva';
                                            }elseif($data2->STATUS_SOLICITUD == 1){
                                                $STATUS = 'Autorizado';
                                            }elseif($data2->STATUS_SOLICITUD == 2){
                                                $STATUS = 'Autorizado / Sin Nota de Credito';
                                            }elseif($data2->STATUS_SOLICITUD == 3){
                                                $STATUS = 'Rechazado';
                                            }elseif($data2->STATUS_SOLICITUD == 4){
                                                $STATUS = 'Autorizado / Ejecutado';
                                            }elseif($data2->STATUS_SOLICITUD == 5){
                                                $STATUS = 'Listo para Refactura';
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
                                            <td align="center"><?php echo $data2->ID.'/'.$data2->CAJA?><br/>
                                                <?php if($data2->STATUS_SOLICITUD == 0 or $data2->STATUS_SOLICITUD == 1){?>
                                                <a href="index.php?action=verDetSolNC&id=<?php echo $data2->ID?>&tipo=<?php echo $data2->TIPO_SOLICITUD?>&factura=<?php echo TRIM($data2->FACT_ORIGINAL)?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" > <font color="<?php echo $color?>"><?php echo $data2->TIPO_SOLICITUD?> </font></a> 
                                                    <?php if($data2->STATUS_SOLICITUD == 0){?>
                                                        <br/><input type="button" name="autorizar" value="Autorizar" onclick="autorizar(<?php echo $data2->ID?>,'a')">&nbsp;&nbsp;&nbsp;<input type="button" name="rechazar" value="Rechazar" onclick="autorizar(<?php echo $data2->ID?>,'r')">
                                                    <?php }?>
                                                <?php }elseif($data2->STATUS_SOLICITUD == 2){?>
                                                <label><font color="green">Ejecutado</font></label>
                                                <?php }elseif($data2->STATUS_SOLICITUD == 3){?>
                                                <label><font color="red">Rechazado</font></label>
                                                <?php }elseif($data2->STATUS_SOLICITUD == 5){?>
                                                <a href="index.php?action=verDetSolNC&id=<?php echo $data2->ID?>&tipo=<?php echo $data2->TIPO_SOLICITUD?>&factura=<?php echo TRIM($data2->FACT_ORIGINAL)?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" > <font color="<?php echo $color?>"><?php echo $data2->TIPO_SOLICITUD?> </font></a> 
                                                <?php }?>
                                            </td>                         
                                            <td><?php echo $data2->FACT_ORIGINAL.'<br/>'.$data2->OBSERVACIONES?></td>
                                            <td><?php echo $data2->FECHA_SOLICITUD ?></td>
                                            <td><?php echo $data2->USUARIO_SOLICITUD ?></td>
                                            <td align="right"><?php echo $STATUS ?></td>
                                            <td><?php echo $data2->FECHA_AUTORIZA ?></td>
                                            <td><?php echo $data2->USUARIO_AUTORIZA ?></td>
                                            <td align="right"><?php echo $data2->FECHA_EJECUTA ?></td>
                                            <td align="right"><?php echo $data2->USUARIO_EJECUTA ?></td>
                                            <td><?php echo $data2->NC?></td>
                                            <td><a href="index.php?action=verRefacNueva&docref=<?php echo $data2->FACTURA_NUEVA?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data2->FACTURA_NUEVA?></a> <br/><font color="red"><n><?php echo $data2->PENDIENTE?></n></font></td>
                                            <td><?php echo $data2->PEDIDO_REMISION_ASOCIADO?></td>
                                            <td></td>
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

<script type="text/javascript">
    
    function autorizar(idsol, tipo){
        if(tipo == 'a'){
            var mensaje = 'Desea Autorizar la Solicitud de refacturacion?.' + idsol;
        }else{
            var mensaje = 'Desea Rechazar la Solicitud de Refacturacion?.' + idsol;
        }
        if(confirm(mensaje)){
            $.ajax({
                url:"index.php",
                type:"POST",
                dataType:"json",
                data:{solRefac:1,idsol:idsol,tipo:tipo},
                success:function(data){
                    alert(data.status);
                    location.reload(true);
                }
            })

        }

    }

</script>