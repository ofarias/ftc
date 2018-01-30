
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cierre de unidade por ruta.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Pedido <br> Caja </th>
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
                                            <th>Fin Logistica</th>
                                            <th>Aduana</th>
                                            <th>Documentos Logistica</th>
                                            <th>Recoger Documentos</th>
                                            <th>Cerrar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($rutaunidadent as $data):  
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_FACT;?></a> <br> <?php echo $data->ID?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHFACT;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <td><?php echo $data->HORAI;?></td>
                                            <td><?php echo $data->HORAF;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->FOLIO_ADUANA_LOGISTICA;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td>
                                              <form action="index.php" method="post">
                                                <input name="doc" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />
                                                <input name="tipo" type="hidden" value="<?php echo $data->STATUS_LOG?>" />
                                                <input name="docslog" type="hidden" value="<?php echo $data->DOCS?>" />
                                                <input type="hidden" name="idc" value ="<?php echo $data->ID?>" /> 
                                                <!--<button name="actDocs" type="submit" value ="enviar" class="btn btn-warning">Recoger Documentos</button>-->
                                                <button name="actDocs" type="submit" value="enviar" <?php echo ($data->DOCS == 'No' and $data->STATUS_LOG == 'Reenviar')? '':'disabled';?> class="btn btn-warning"> <?php echo ($data->DOCS == 'Si' and $data->FOLIO_ADUANA_LOGISTICA == 0)? 'Esperando Folio Aduana':'Recoger Documentos'?></button>
                                            </td>
                                            <td>                                             
                                                <button name="CerrarRutaRep" type="submit" value="enviar" <?php echo ((($data->DOCS =='No' and $data->FOLIO_ADUANA_LOGISTICA >= 0) or ($data->DOCS == 'Si' and $data->STATUS_LOG == 'Reenviar')) and $data->CIERRE_UNI != 'ok')? '':'disabled';?> class="btn btn-warning"> <?php echo ($data->CIERRE_UNI == 'ok')? 'Cerrado':'Cerrar'?>  <i class="fa fa-car"></i></button>
                                              </form>
                                            </td>                                              
                                          </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                        <div class="panel-footer">
                        <form action="index.php" method="post">
                        <input type="hidden" name="idr" value = "<?php echo $idr?>">
                        <button name="imprimeCierreEnt" type="submit" value = "enviar" <?php echo ($close_ent == 'No')? 'disabled':'';?> class = "btn btn-warning">Imprimir</button>    
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
</script>