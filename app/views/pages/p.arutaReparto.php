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
<div class="<?php echo $alerta;?>"><center><h2><?php echo $mensaje;?></h2></center></div>
 
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Asignacion de Unidad Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Factura</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Dias de Atraso</th>
                                            <th>Documentos</th>
                                            <th>Recibir Documentos</th>
                                            <th>Seleccionar Unidad</th>
                                            <th>Guardar</th>
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
                                            <td><?php echo $data->ID;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISIONDOC;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            
                                            <form action="index.php" method="post">
                                             <td>
                                             <button name="docsR" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($var == 'No' or $var =='N') ? "" : "disabled";?>>Recibir<i class="fa fa-floppy-o"></i></button>
                                             </td> 
                                             <td>
                                                <input type="hidden" name="docf" value="<?php echo $data->FACTURA?>">
                                                <input type="hidden" name="docr" value="<?php echo $data->REMISIONDOC?>">
                                                <input name="docu" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="edo" type="hidden" value="<?php echo $data->ESTADO?>" />
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID?>" />
                                                <select name="unidad" <?php echo ($var == 'No' or $var == 'N') ? "":"required" ;?>>
                                                    <option value="">--Selecciona Unidad--</option>
                                                <?php foreach($unidad as $u){
                                                    echo '<option value="'.$u->NUMERO.'">"'.$u->NUMERO.'"</option>';
                                                } ?>
                                                </select>
                                            </td>                                           
                                            <td>                                                
                                                <button name="unidadentrega" type="submit" value="enviar" class="btn btn-warning" <?php echo ($var == 'No' )? "disabled":"";?>>Asigna<i class="fa fa-floppy-o"></i></button>
                                            </td>
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
