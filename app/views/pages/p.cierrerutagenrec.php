<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cerrar Ruta General del Dia Recolección.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Orden de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Fecha Orden</th>
                                            <th>PAGO TESORERIA</th>
                                            <th>FECHA PAGO</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Fecha</th>
                                            <th>Hora Llegada </th>
                                            <th>Hora Salida </th>
                                            <th>Tipo</th>
                                            <th>Recepcion</th>
                                            <th>Documentos Con Coordinador</th>
                                            <th>Cerrado?</th>
                                            <th>Intentos</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($rutaunidadrec as $data):
                                           
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->PAGO_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->HOY;?></td>
                                            <td>                                               
                                               <!-- hora inicio --> 
                                               <?php
                                               if($data->HORAI == NULL){                                                   
                                                   echo '<a class="btn" href="javascript:inicio(\''.$data->CVE_DOC.'\')">Hora Inicio</a>';
                                               } else {
                                                   echo $data->HORAI;
                                               }
                                               ?>

                                            </td>
                                            <td>
                                                <!-- hora fin -->
                                                <?php
                                               if($data->HORAF == NULL){
                                                   echo '<a class="btn" href="javascript:fin(\''.$data->CVE_DOC.'\')">Hora Fin</a>';
                                               } else {
                                                   echo $data->HORAF;
                                               }
                                               ?>
                                            </td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td><?php echo $data->CIERRE_UNI;?></td>
                                            <td>                                                
                                                <?php echo $data->VUELTAS;?>
                                            </td>                                            
                                          </tr>
                                        <?php
                                            $docs[] = [$data->CVE_DOC,$data->STATUS_LOG,$data->VUELTAS];
                                        endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
            <div class="panel-footer">
            <div class="text-right">
            <form action="index.php" method = "post">
                <input type="hidden" name="documentos" value="<?php echo htmlentities(serialize($docs));?>"/>
                <button name="cerrargenrec" type="submit" value="cerrar" class= "btn btn-warning" onclick="refrescar()" formtarget="_blank" <?php echo $permitircerrar == false ? 'disabled':'' ;?> > Cerrar RUTA </button>
            </form>
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
    
    function refrescar() {
    setTimeout(function(){ window.location.reload(); }, 2000);
    }
</script>