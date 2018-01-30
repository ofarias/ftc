
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Administracion de ruta de Entrega .
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Pedido <br> Caja</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Fecha Factura</th>
                                            <th>Factura / Remision</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Hora Llegada </th>
                                            <th>Hora Salida </th>
                                            <th>Tipo</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($entrega as $data):  
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_FACT;?> </a> <br> <?php echo $data->ID;?> </td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHFACT;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <!--
                                            <td>                                                
                                                <input name="horai" type="time" />                                               
                                            </td>  
                                            <td><input name="horaf" type="time" /></td>
                                            -->
                                            <td>                                               
                                               <!-- hora inicio --> 
                                               <?php
                                               if($data->HORAI == NULL){                                                   
                                                   echo '<a class="btn" href="javascript:inicio(\''.$data->CVE_FACT.'\')">Hora Inicio</a>';
                                               } else {
                                                   echo $data->HORAI;
                                               }
                                               ?>
                                            </td>
                                            <td>
                                                <!-- hora fin -->
                                                <?php
                                               if($data->HORAF == NULL){
                                                   echo '<a class="btn" href="javascript:fin(\''.$data->CVE_FACT.'\')">Hora Fin</a>';
                                               } else {
                                                   echo $data->HORAF;
                                               }
                                               ?>
                                            </td>
                                            <td>
                                              <form action="index.php" method="post">
                                                <input name="doc" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" valie="<?php echo $data->IDU?>" />
                                                <select name="tipo" required="required">
                                                    <option>--Elige tipo fin--</option>
                                                    <option value="Entregado">Entregado</option>
                                                    <option value="NC">Nota de Credito</option>
                                                    <option value="Reenviar">Re-enviar</option>
                                                    <!--<option value="Tiempo">Re-Enrutar(No llego)</option>
                                                    <option value="Fallido">Fallido</option>-->
                                                </select>
                                            </td>
                                            <td>                                             
                                                <button name="defRutaRep" type="submit" value="enviar" class="btn btn-warning">Finalizar<i class="fa fa-car"></i></button>
                                              </form>
                                            </td>                                              
                                          </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
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