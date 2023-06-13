<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Revision de rutas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Orden de Compra
                                            <?php if($tipo == 'total'){?>
                                              <br/><font color="red"><b>Recepcion</b></font>
                                            <?php }?>
                                            </th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Orden</th>
                                            <th>PAGO </th>
                                            <th>FECHA PAGO</th>
                                            <th>Dias <br/>Transcurridos</th>
                                            <th>Unidad</th>
                                            <!--<th>Secuencia</th>-->
                                            <th>Fecha Ruta</th>
                                            <th>Hora Llegada </th>
                                            <th>Hora Salida </th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $ln=0;
                                        foreach ($unidad as $data):  
                                          $ln++;
                                          $s = 'Parcial';
                                          $recibido = !isset($data->RECIBIDO)? 0:$data->RECIBIDO ;
                                          $cant_ord = !isset($data->CANT_ORD)? 0:$data->CANT_ORD;
                                          if($recibido == $cant_ord) $s ='Total';
                                          if($recibido == 0) $s = 'Fallida';
                                        ?>
                                       <tr title="<?php echo 'Cantidad Recibida en esta Orden: '.$data->RECIBIDO.', Cantidad en la Orden:'.$data->CANT_ORD?>">
                                        <td><?php echo $ln?></td>
                                          <td>
                                            <a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data->CVE_DOC;?></a><br/>
                                            <?php if($tipo == 'total'){?>
                                            <a href="index.php?action=verRecepcion&idr=<?php echo $data->RECEPCION?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">
                                            <font color="red"><b><?php echo $data->RECEPCION?></b></a></font>&nbsp;&nbsp;(<b><?php echo $s?></b>)
                                            <?php }?>
                                          </td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo '$ '.number_format($data->PAGO_TES,2);?><br/><font color="blue"><?php echo $data->TP_TES?></font></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <!--<td><?php echo $data->SECUENCIA;?></td>-->
                                            <td><?php echo $data->HOY;?></td>
                                            <td>                                        
                                               <?php
                                               if($data->HORAI == NULL){                                                   
                                                   echo '<a class="btn" href="javascript:inicio(\''.$data->CVE_DOC.'\')">Hora Inicio</a>';
                                               } else {
                                                   echo $data->HORAI;
                                               }
                                               ?>
                                            </td>
                                            <td>
                                                <?php
                                               if($data->HORAF == NULL){
                                                   echo '<a class="btn" href="javascript:fin(\''.$data->CVE_DOC.'\')">Hora Fin</a>';
                                               } else {
                                                   echo $data->HORAF;
                                               }
                                               ?>
                                            </td>
                                            <?php if($tipo != 'total'){?>
                                            <td>
                                              <form action="index.php" method="post">
                                                <input name="doc" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU;?>" />
                                                <input type="hidden" name="tipo" value="Total">                                   
                                                <button name="defRuta" type="submit" value="enviar" class="btn btn-warning">Finalizar  <i class="fa fa-car"></i></button>
                                              </form>
                                            </td>
                                            <?php }else{?>
                                              <td><a onclick="impAsignacion(<?php echo $data->RECEPCION?>, '<?php echo $data->CVE_DOC?>')" class="btn btn-info">Imp Recep</a></td>
                                            <?php }?>                                              
                                          </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                           </table>
                      </div>
            </div>
        </div>
</div>
<form method="POST" action="index.php" id="hora_inicio">
    <input type="hidden" name="documento" id="documento_inicio" value="xxxxxx" maxlength="12" />
    <input type="hidden" name="defineHoraInicio" id="action" value="defineHoraInicio" />
</form>
<form method="POST" action="index.php" id="hora_fin">
    <input type="hidden" name="documento" id="documento_fin" value="xxxxxx" maxlength="12" />
    <input type="hidden" name="defineHoraFin" id="action" value="defineHoraFin" />
</form>

<form action="index.php" method="POST" id="formulario">
    <input type="hidden" name="doco" value="" id="doco">
    <input type="hidden" name="idr" value="" id="folioImp">
    <input type="hidden" name="tipo" value="d">
    <input type="hidden" name="imprimeRecep" >
</form>
<script>
    function inicio(documento){
        document.getElementById('documento_inicio').value = documento;
        frm = document.getElementById("hora_inicio");
        frm.submit();
    }
    function fin(documento){
        document.getElementById('documento_fin').value = documento;
        frm = document.getElementById("hora_fin");
        frm.submit();
    }    
    function impAsignacion(idr, doco){
        document.getElementById('folioImp').value=idr;
        document.getElementById('doco').value=doco;
        if(confirm('Se imprimiran todos la recepcion del folio de impresion' + idr + ' de la orden de compra ' + doco)){
            var form = document.getElementById('formulario');
            form.submit();
        }  

    }

</script>