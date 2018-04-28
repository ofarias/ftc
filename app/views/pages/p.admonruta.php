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
                                            <th>Orden de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Orden</th>
                                            <th>PAGO TESORERIA</th>
                                            <th>FECHA PAGO</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Fecha</th>
                                            <th>Hora Llegada </th>
                                            <th>Hora Salida </th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($unidad as $data):  
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"  target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->PAGO_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
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
</script>