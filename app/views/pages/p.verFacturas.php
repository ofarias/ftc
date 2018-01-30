<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision de Facturacion.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Factura</th>
                                            <th>Rec mercancia</th>
                                            <th>Fecha Factura</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Cliente</th>
                                            <th>Pedido</th>
                                            <th>Caja</th>
                                            <th>Unidad</th>
                                            <th>Estatus Logistica</th>
                                            <th>Docs Operador</th>
                                            <th>Dias</th>
                                            <th>Vueltas</th>
                                            <th>Solucion</th>
                                            <th>Retorno a Aduana</th>
                                            <th>Recibir Docs</th>
                                            <th>Nuevo Status</th>
                                            <th>Avanzar</th>
                                            <th>Comprobante</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($facturas as $data): 
                                            $var=$data->DOCS;
                                            $var2=$data->RESULTADO;
                                        ?>
                                       <tr>
                                            <td><?php echo $data->DOC;?></td>
                                            <td><?php echo $data->FOLIO_RM;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->VUELTAS;?></td>
                                            <td><?php echo $data->SOL_DESLINDE;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="aduana" value="<?php echo $data->ADUANA;?>" id ="<?php echo $data->DOC.$data->FOLIO_RM;?>" />
                                            <td>
                                             <button name="recDocFact" type="submit" value="enviar " class= "btn btn-warning"
                                                <?php echo (($data->DOCS == 'Si') or ($data->DOCS) == 'S') ? "" : "disabled";?>> 
                                                Recibir <i class="fa fa-floppy-o"></i></button>
                                             </td> 
                                             <td>
                                                <select  name="nstatus" required="required" onchange="validarSelect('<?php echo $data->DOC.$data->FOLIO_RM;?>')" id = "S<?php echo $data->DOC.$data->FOLIO_RM;?>">
                                                    <option>--Elige Nuevo Status--</option>
                                                    <option value ="Reenviar">Reenviar</option>
                                                    <option value ="Facturar">Realizar Facturar</option>
                                                    <option value ="NC">Hacer NC</option>
                                                    <option value ="Deslinde">Deslinde </option>
                                                    <option value="Revision">Revisión</option>
                                                    <option value="Revision2p">Revisión 2 Pasos</option>
                                                </select>

                                             </td>
            
                                            <td>
                                                <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC;?>"/>
                                                <input name="docp" type="hidden" value="<?php echo $data->PEDIDO;?>"/>
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID;?>"/>
                                                <input name="tipo" type="hidden" value="<?php echo $data->STATUS_LOG;?>"/>
                                                <input name="clavecli" type="hidden" value="<?php echo $data->CVE_CLIE;?>"/>
                                                <button name="avanzaCobranza" type="submit" value="enviar" class="btn btn-warning" <?php echo (($var == 'No' or $var == 'N') and ($var2 != 'Recibido' or $var2 != 'GenerarNC' or $var2 != 'Reenviar'))? "":"disabled";?>>Avanzar <i class="fa fa-floppy-o"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button name="impCompFact" type="submit" value="enviar" class="btn btn-warning" <?php echo ($var2 == 'Recibido' or $var2 =='Reenviar' or $var2=='GenerarNC')? "":"disabled";?>> Imprimir <i class="fa fa-print"></i></button>
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

<script>
    function validarSelect(id){

        valorAduana = document.getElementById(id).value;
        select = document.getElementById('S'+id);
        //alert(valorAduana);
        switch (valorAduana){
            case 'Facturado':
                if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento facturado. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;
            
            case 'Devuelto':
            if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento devuelto. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;

            case 'Acuse':
            if(select.value == 'Reenviar'){
                    alert("No se puede Reenviar un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Facturar'){
                    alert("No se puede Facturar un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'NC'){
                    alert("No se puede devolver un documento acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }else if(select.value == 'Acuse'){
                    alert("No se puede enviar acuse de un documento que ta tiene acuse. Use Revisión o Deslinde");
                    select.selectedIndex = 0;
                }
            break;
            
            default:
            break;

        }// fin switch

    }// fin función 
</script>