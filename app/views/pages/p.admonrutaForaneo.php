
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
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Destino Predeterminado</th>
                                            <!--<th>CP</th>-->
                                            <th>Fecha Solicitud</th>
                                            <th>Fecha Factura</th>
                                            <th>Factura</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Guia</th>
                                            <th>Fletera</th>
                                            <th>CP Destino</th>
                                            <th>Destino</th>
                                            <th>Fecha Estimada</th>
                                          <!--  <th>Hora Llegada </th>
                                            <th>Hora Salida </th> -->
                                          <!--  <th>Tipo</th> -->
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($entrega as $data):  
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->DESTINO_PREDETERMINADO;?></td>
                                           <!-- <td><?php echo $data->CODIGO;?></td> -->
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHFACT;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <form action="index.php" method="post" id="form1">
                                            <td><input type="text" name="guia" maxlength="20" required="true" /></td>
                                            <td><input type="text" name="fletera" maxlength="30"  required="true" /></td>
                                            <td><input type="number" name="cpdestino" min="1" max="999999" required="true" /></td>
                                            <td><input type="text" name="destino" maxlength="30" required="true" /></td>
                                            <td><input type="text" name="fechaestimada" class="datepicker1" maxlength="10" required="true" /></td>
                                            <td><input type="file" name="comprobanteFletera" accept="application/pdf,image/*" form="<?php echo $data->CVE_FACT;?>"/>
                                              <button type="submit" name="upComprobanteFletera" class="btn btn-default" form="<?php echo $data->CVE_FACT;?>"><i class="fa fa-save" ></i></button>
                                            </td>
                                                <input name="doc" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />
                                            <td>                                             
                                                <button name="defRutaForaneo" type="submit" value="enviar" class="btn btn-warning">Aduana</button> 
                                            </td>  
                                            </form>                                            
                                          </tr>
                                        <form action="upload.php" method="post" enctype="multipart/form-data" id="<?php echo $data->CVE_FACT;?>" >
                                          <input type="hidden" name="origen" value="RutaUnidad" />
                                          <input type="hidden" name="iduni" value="<?php echo $data->IDU?>" />
                                          <input type="hidden" name="ped" value="<?php echo $data->CVE_FACT;?>" />
                                          <input type="hidden" name="fguia" value="<?php echo $data->F_GUIA_FLETERA;?>" />
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker1" ).datepicker({dateFormat: 'dd-mm-yy'});  
  } );
  </script>
  <!--
  <script>
    document.addEventListener("DOMContentLoaded",function(){
      fguia = document.getElementsByName("fguia");
      cf = document.getElementsByName("comprobanteFletera");
      bf = document.getElementsByName("upComprobanteFletera");
      bfinalizar = document.getElementsByName("defRutaForaneo");

      for(var c = 0; c < fguia.length; c++){
        if(fguia[c].value != ""){
          cf[c].type = 'text';
          cf[c].value = fguia[c].value;
          cf[c].readOnly = true;
          bf[c].disabled = true;
        }else{
          bfinalizar[c].disabled = true;
        }
      }
     // alert("fin");
    });
  </script>-->