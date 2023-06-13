<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Deslindes de Aduana.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Pedido</th>
                                            <th>Factura</th>
                                            <th>Remision</th>
                                            <th>Caja</th>
                                            <th>Unidad</th>
                                            <th>Estatus Logistica</th>
                                            <th>Docs Operador</th>
                                            <th>Fecha Aduana</th>
                                            <th>Dias</th>
                                            <th>Vueltas</th>
                                            <th>Tipo deslinde</th>
                                            <th>Recibir Docs</th>
                                            <th>Solucion Deslinde</th>
                                            <th>Avanzar a Aduana</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($documentos as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td><?php echo $data->FECHA_ADUANA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->VUELTAS;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                             <button name="recDocFact" type="ssubmit" value="enviar " class= "btn btn-warning"
                                                <?php echo ($data->DOCS == 'S') ? "" : "disabled";?>> 
                                                Recibir <i class="fa fa-floppy-o"></i></button>
                                             </td> 

                                            <td>
                                                <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC;?>"/>
                                                <input name="docp" type="hidden" value="<?php echo $data->PEDIDO;?>"/>
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID;?>"/>
                                                <input name="tipo" type="hidden" value="<?php echo $data->STATUS_LOG;?>"/>
                                                <input name="clavecli" type="hidden" value="<?php echo $data->CVE_CLIE;?>"/>
                                                <input name="soldesaduana" type="text" required="required" />
                                               <!-- <button name="avanzaCobranza" type="submit" value="enviar" class="btn btn-warning" <?php echo (($var == 'No' or $var == 'N') and ($var2 != 'Recibido' or $var2 != 'GenerarNC' or $var2 != 'Reenviar'))? "":"disabled";?>>Avanzar <i class="fa fa-floppy-o"></i>
                                                </button>-->
                                            </td>
                                            <td>
                                                <button name="DesaAdu" type="submit" value="enviar" class="btn btn-warning" > Regresa a Aduana </button>
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