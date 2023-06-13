<br /><br />
<div class="row">
        <?php if(!empty($recibedoc)){
            if($recibedoc == true){
                $alerta = "alert alert-success";
                $mensaje = "Documentos asignados correctamente.";
                }else{
                $alerta = "alert alert-error";
                $mensaje = "Los documentos no se pudieron asignar.";                    
                }
            }else{
                $alerta = "";
                $mensaje = "";
            } 
    ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Lote de Facturas del dia.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Status</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Factura</th>
                                            <th>Caja</th>
                                            <th>Remision</th>
                                            <th>Dias de Atraso</th>
                                            <th>Documentos</th>
                                            <th>Usuario Aduana</th>
                                            <th>Usuario Bodega</th>
                                            <th>Usuario Logistica</th>
                                            <th>Entrega Aduana</th>
                                            <th>Recibe Bodega </th>
                                            <th>Recibe Logistica</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($reenrutar as $data): 
                                            $color = $data->DIAS;
                                            //$urgencia = $data->URGENCIA;
                                            $urgencia= 'A';
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: red;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            }
                                            $var=$data->DOCS;
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->REMISIONDOC;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td><?php echo $data->U_ENTREGA;?></td>
                                            <td><?php echo $data->U_RECIBE;?></td>
                                            <td><?php echo $data->U_LOGISTICA;?></td>
                                            <form action="index.php" method="post">
                                             <td><button name="entaduana" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->ENTREGA_BODEGA == 'No')? "":"disabled";?> >Entrega</button></td>
                                             <td><button name="recbodega" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->ENTREGA_BODEGA =='Si')? "":"disabled";?>>Recibe Bodega</button></td>
                                             <td><button name="reclogistica" type="submit" value="enviar " class= "btn btn-warning" <?php echo (empty($data->ID) or empty($data->U_RECIBE) or $data->U_LOGISTICA)? "disabled":"";?>>Recibe Logistica</button></td> 
                                             <input name="idc" type = "hidden" value = "<?php echo $data->ID?>" />
                                             <input name="docf" type ="hidden" value ="<?php echo $data->FACTURA?>" />
                                             <input type="hidden" name="docp" value= "<?php echo $data->CVE_FACT?>"/>
                                            <!-- <button name="ctrDocEntrega" type="submit" value="enviar" class="btn btn-warning" <?php echo (($var == 'No' or $var == 'N') and ($var2 != 'Recibido' or $var2 != 'GenerarNC' or $var2 != 'Reenviar'))? "":"disabled";?>>Avanzar <i class="fa fa-floppy-o"></i>
                                                </button>-->
                                            
                                            </form>
                                            <form action="index.php" method ="post" id="impLoteFact">

                                            </form>       
                                            </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                      <div class= "panel-footer" >
                            <button class = "btn btn-warning" form = "impLoteFact" name = "impLoteFact"> Recibir </button>
                      </div>
                </div>
            </div>
        <div>

        </div>
    </div>
</div>

<br /><br />
<div class="row">
        <?php if(!empty($recibedoc)){
            if($recibedoc == true){
                $alerta = "alert alert-success";
                $mensaje = "Documentos asignados correctamente.";
                }else{
                $alerta = "alert alert-error";
                $mensaje = "Los documentos no se pudieron asignar.";                    
                }
            }else{
                $alerta = "";
                $mensaje = "";
            } 
    ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Lote de Facturas Reenrutar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Factura</th>
                                            <th>Caja</th>
                                            <th>Remision</th>
                                            <th>Dias de Atraso</th>
                                            <th>Documentos</th>
                                            <th>Usuario Aduana</th>
                                            <th>Usuario Bodega</th>
                                            <th>Usuario Logistica</th>
                                            <th>Entrega Aduana</th>
                                            <th>Recibe Bodega </th>
                                            <th>Recibe Logistica</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($entrega as $data): 
                                            $color = $data->DIAS;
                                            //$urgencia = $data->URGENCIA;
                                            $urgencia= 'A';
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: red;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            }
                                            $var=$data->DOCS;
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->REMISIONDOC;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td><?php echo $data->U_ENTREGA;?></td>
                                            <td><?php echo $data->U_BODEGA;?></td>
                                            <td><?php echo $data->U_LOGISTICA;?></td>
                                            <form action="index.php" method="post">
                                             <td><button name="entaduana" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->STATUS_CTRL_DOC_ENTREGA == '')? "":"disabled";?> >Entrega</button></td>
                                             <td><button name="recbodega" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->STATUS_CTRL_DOC_ENTREGA =='Bodega')? "":"disabled";?>>Recibe Bodega</button></td>
                                             <td><button name="reclogistica" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->STATUS_CTRL_DOC_ENTREGA =='Logistica')? "":"disabled";?>>Recibe Logistica</button></td> 
                                             <input name="idc" type = "hidden" value = "<?php echo $data->ID?>" />
                                             <input name="docf" type ="hidden" value ="<?php echo $data->FACTURA?>" />
                                             <input type="hidden" name="docp" value= "<?php echo $data->CVE_FACT?>"/>
                                            <!-- <button name="ctrDocEntrega" type="submit" value="enviar" class="btn btn-warning" <?php echo (($var == 'No' or $var == 'N') and ($var2 != 'Recibido' or $var2 != 'GenerarNC' or $var2 != 'Reenviar'))? "":"disabled";?>>Avanzar <i class="fa fa-floppy-o"></i>
                                                </button>-->
                                            
                                            </form>
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
