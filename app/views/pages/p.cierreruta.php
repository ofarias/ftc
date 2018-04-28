<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cerrar Rutas x Unidad.
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
                                            <th>Documentos Con Operador</th>
                                            <th>Recoger Documentos</th>
                                            <th>Cerrar</th>
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
                                             <form action="index.php" method="post" id = "hola">
                                            <td>                                                
                                               
                                                <button name="actDocs" type="submit" value="enviar" <?php echo ($data->DOC_SIG == 'No' and $data->DOCS == 'S')? '':'disabled';?> class="btn btn-warning"> Recoger Dodumentos</button>
                                            </td>
                                            <td>                                             
                                                <button name="CerrarRuta" type="submit" value="cerrar" <?php echo ($data->DOCS == 'S' and $data->DOC_SIG =='No' or ($data->CIERRE == 'parcial' or $data->CIERRE =='ok' or $data->CIERRE =='Tiempo'))? 'disabled':'';?>  class="btn btn-warning">Cerrar</button>
                                            </td>
                                           
                                                <input name="doc" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="tipo" type="hidden" value="<?php echo $data->STATUS_LOG?>" />
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU;?>" />
                                                 <input name="docslog" type="hidden" value="<?php echo $data->DOCS?>" />
                                                 <input type="hidden" name="idc" value = '0' />
                                              </form>

                                               <form action="index.php" method="post" id = "12345">
                                              <input name="idu" type="hidden" value="<?php echo $data->IDU;?>" />
                                              </form> 
                                          </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                      <div class="panel-footer">
                      <button name="imprimeCierre" form="12345" type="submit" <?php echo ($close == 'No')? 'disabled':'';?> class = "btn btn-warning">Imprimir</button>
                      </div>
            </div>
        </div>
</div>
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
                                                <button name="CerrarRuta" type="submit" value="enviar" <?php echo ((($data->DOCS =='No' and $data->FOLIO_ADUANA_LOGISTICA >= 0) or ($data->DOCS == 'Si' and $data->STATUS_LOG == 'Reenviar')) and $data->CIERRE_UNI != 'ok')? '':'disabled';?> class="btn btn-warning"> <?php echo ($data->CIERRE_UNI == 'ok')? 'Cerrado':'Cerrar'?>  <i class="fa fa-car"></i></button>
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