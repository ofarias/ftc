<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Acuse.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Pedido</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Cliente</th>
                                            <th>Caja</th>
                                            <th>Unidad</th>
                                            <th>Estatus Logistica</th>
                                            <th>Docs Operador</th>
                                            <th>Comprobante</th><!-- Botón para subir archivo -->
                                            <th>Guia</th>
                                            <th>Fletera</th>
                                            <th>Guardar</th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($nc as $data):?>
                                       <tr>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->DOCFACTURA;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->DOCS;?></td>
                                            <form action="upload.php" method="post" enctype="multipart/form-data" id="<?php echo $data->ID;?>"> <!-- formulario para subir archivo -->
                                                <input type="hidden" name="caja" value="<?php echo $data->ID?>"/>
                                                <input type="hidden" name="archivo" value="<?php echo $data->ARCHIVO?>"/>
                                                <input type="hidden" name="origen" value="VerFacturasAcuse"/>
                                            </form>                                                                             <!-- FINALIZA formulario para subir archivo -->
                                             <td> <!-- Botón para subir archivo -->
                                                <input type="file" form="<?php echo $data->ID;?>" accept="application/pdf,image/*" required class="" name="compToUpload" id="compToUpload" value="<?php echo $data->ARCHIVO;?>" />
                                                <button type="submit" name="comprobanteCaja" id="comprobanteCaja" class="btn btn-default pull-right" form="<?php echo $data->ID;?>" <?php echo (!empty($data->ARCHIVO))?"disabled":"";?>><i class="fa fa-save"></i></button>
                                             </td> <!-- Botón para subir archivo -->
                                            <form action="index.php" method="post">
                                            <td>    
                                                <input name="guia" type="text" required="required" maxlenght="50" value="<?php echo $data->GUIA_FLETERA;?>"/>
                                            </td>
                                            <td>    
                                                <input name="fletera" type="text" required="required" maxlenght="50" value="<?php echo $data->FLETERA;?>" />
                                            </td>

                                            <td>
                                                <input name="docp" type="hidden" value="<?php echo $data->PEDIDO;?>"/>
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID;?>"/>
                                                <button name="guardarAcuse" type="submit" value="enviar" class="btn btn-warning">Guardar <i class="fa fa-save"></i>
                                                </button>
                                            </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        <div class="panel-footer text-right">
            <form action="index.php" method="post">
                <button name="imprmirfacturasacuse" id="imprimir" class="btn btn-warning" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button>
            </form>
        </div>
        </div>
</div>

<script>
document.addEventListener("DOMContentLoaded",function(){
    var guia = document.getElementsByName("guia");
    var fletera = document.getElementsByName("fletera");
    var boton = document.getElementsByName("guardarAcuse");
    var up = document.getElementsByName("archivo"); //uploadfile
    var cuentaCajas = 0;
    var cuentaUp = 0;   //uploadfile
    for(contador = 0; contador < guia.length; contador++){
        if(guia[contador].value == "" || fletera[contador].value == ""){
            boton[contador].disabled = false;
        }else{
            boton[contador].disabled = true;
            guia[contador].readOnly = true;
            fletera[contador].readOnly = true;
            cuentaCajas += 1;
        }
        
        if(up[contador].value != ""){   //uploadfile
            
            cuentaUp += 1;
        }                               //uploadfile
    }

    if(cuentaCajas == guia.length && cuentaUp == fac.length)     //uploadfile
        document.getElementById("imprimir").disabled = false;
        else 
            document.getElementById("imprimir").disabled = true; 
});

document.getElementById("imprimir").addEventListener("click",function(){
    setTimeout(function(){ window.location.reload(); }, 1000);  
});
</script>