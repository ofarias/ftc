<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Notas de credito Pendientes de asociar.
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
                                            <th>Recibir Docs</th><!-- Botón para subir archivo -->
                                            <th>XML</th>
                                            <th>Comprobante PDF</th>
                                            <th>Nota de Credito SAE</th>
                                            <th>Asociar NC</th>
                                            <th>Deslinde </th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($nc as $data): 
                                            $var=$data->DOCS;
                                            $var2=$data->NC;
                                        ?>
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
                                                <input name="nc" type="hidden" value="<?php echo $data->DOC_SIG;?>"/>
                                                <input name="xmlfile" type="hidden" value="<?php echo $data->XMLFILE;?>"/>
                                                <input type="hidden" name="origen" value="NCFactura"/>
                                            </form>                                                                             <!-- FINALIZA formulario para subir archivo -->
                                            <form action="index.php" method="post">
                                            <td>
                                             <button name="recDocFactNC" type="submit" value="enviar " class= "btn btn-warning"
                                                <?php echo ($data->DOCS == 'S') ? "" : "disabled";?>> 
                                                Recibir <i class="fa fa-floppy-o"></i></button>
                                             </td> 
                                             <td><!-- Botón para subir xml -->
                                                <input type="file" form="<?php echo $data->ID;?>" accept="text/xml" s name="xml" id="xml"  />
                                                <button type="submit" name="xmlNc" class="btn btn-default pull-right" form="<?php echo $data->ID;?>"> <i class="fa fa-code">XML</i></button>
                                             </td><!-- Fin Botón para subir xml -->
                                            <td> <!-- Botón para subir archivo -->
                                                <input type="file" form="<?php echo $data->ID;?>" accept="application/pdf,image/*"  class="" name="compToUpload" id="compToUpload" value="<?php echo $data->ARCHIVO;?>" />
                                                <button type="submit" name="comprobanteCaja" class="btn btn-default pull-right" form="<?php echo $data->ID;?>" <?php echo (!empty($data->ARCHIVO))?"disabled":"";?>><i class="fa fa-save">PDF</i></button>
                                             </td> <!-- Botón para subir archivo -->
                                             
                                             <td>
                                                 <input name="nc" type="text" required="required" value="<?php echo $data->DOC_SIG;?>" readonly="true" />
                                             </td>
                                            <td>
                                                <input name="docp" type="hidden" value="<?php echo $data->PEDIDO;?>"/>
                                                <input name="docf" type="hidden" value="<?php echo $data->FACTURA?>" />
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID;?>"/>
                                                <input name = "tipo" type = "hidden" value = "Error"/>
                                                <button name="asociarNC" type="submit" value="enviar" class="btn btn-warning" <?php echo (empty($data->DOC_SIG))? "disabled":""; ?>> Asociar NC </i>
                                                </button>                                                
                                               
                                            </td>
                                            <td>
                                                <button name="DesNC" type="submit" value="enviar" class="btn btn-warning"> Deslinde </button>
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

document.addEventListener("DOMContentLoaded",function(){
    var fac = document.getElementsByName("nc");
    //var boton = document.getElementsByName("asociarNC");
    var up = document.getElementsByName("archivo"); //uploadfile
    var botonup = document.getElementsByName("comprobanteCaja");
    var xmlfile = document.getElementsByName("xmlfile");
    var cuentaUp = 0;   //uploadfile
    var cuentaCajas = 0;
    var cuentaXml = 0;
    for(contador = 0; contador < fac.length; contador++){
        if(fac[contador].value == ""){
            //boton[contador].disabled = true;
            botonup[contador].disabled = true;
            fac[contador].readOnly = true;
        }else{
            cuentaCajas += 1;
            fac[contador].readOnly = true;
        }
        if(up[contador].value != ""){   //uploadfile
            cuentaUp += 1;
        }                             //uploadfile
        
        if(xmlfile[contador].value != ""){
            document.getElementsByName("xml")[contador].type = 'text';
            document.getElementsByName("xml")[contador].readOnly = true;
            document.getElementsByName("xml")[contador].value = xmlfile[contador].value;
            document.getElementsByName("xmlNc")[contador].disabled=true;
            cuentaXml += 1;
        }
        

        if(fac[contador].value == "" && up[contador].value != ""){
            botonup[contador].disabled = true;
        }
        
    }
});

document.getElementById("imprimir").addEventListener("click",function(){
    setTimeout(function(){ window.location.reload(); }, 1000);  
});

/*function validarTextBox(texto,boton1,boton2){
    //alert(texto+boton1+boton2);
    if(texto.length > 5){
        document.getElementById(boton2).disabled = false;
        document.getElementById(boton1).disabled = false;
    }else if(texto.length < 5){
        document.getElementById(boton2).disabled = true;
        document.getElementById(boton1).disabled = true;
    }
}*/

</script>