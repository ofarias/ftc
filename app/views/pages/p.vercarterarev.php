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
                                            <th>Fecha Factura</th>
                                            <th>Fecha Revision</th>
                                            <th>Cliente</th>
                                            <th>Pedido</th>
                                            <th>Caja</th>
                                            <th>Unidad</th>
                                            <th>Estatus Logistica</th>
                                            <th>Docs en Cobranza</th>
                                            <th>Dias</th>
                                            <th>Vueltas</th>
                                            <th>Folio Cierre</th>
                                            <th>Recibir Docs</th>
                                            <th>Deslinde a Revision</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($docsrevision as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_REV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->ENCOBRANZA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->VUELTAS;?></td>
                                            <td><?php echo $data->FOLIO_CIERRE;?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="aduana" value="<?php echo $data->ADUANA;?>" id ="<?php echo $data->DOC.$data->FOLIO_RM;?>" />
                                                <input name="docf" type="hidden" value="<?php echo $data->FACTURA;?>"/>
                                                <input name="docp" type="hidden" value="<?php echo $data->CVE_FACT;?>"/>
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID;?>"/>
                                                <input name="tipo" type="hidden" value="<?php echo $data->STATUS_LOG;?>"/>
                                                <input name="clavecli" type="hidden" value="<?php echo $data->CVE_CLIE;?>"/>
                                            
                                            <td>
                                             <button name="recDocCob" type="submit" value="enviar " class= "btn btn-warning"
                                                <?php echo ($data->ENCOBRANZA == 'No' ) ? "" : "disabled";?>> 
                                                Recibir <i class="fa fa-file"></i></button>
                                             </td> 
                                             <td>

                                            <button name = "desDocCob" type="submut" value="enviar" class="btn btn-warning">
                                                Deslinde a Revision<i class ="fa fa-stop"></i></button></td>
                                            </form>

                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>

                            <!-- /.table-responsive -->
                      </div>
                      <label>Pendientes por imprimir: <?php echo $habilitaImpresion;?> </label>
                      <form action = "index.php" method="post">
                        <button name= "impRecCobranza" value = "enviar" class="btn btn-warning" <?php echo  (($habilitaImpresion>=1)? '':'disabled') ?>  id="gccr" > Imprimir Recepcion y Avanzar a Cartera  </button>  
                      </form>
                        
            </div>
        </div>
</div>

<script>

    document.getElementById("gccr").addEventListener("click",function(){    //función para recargar la pagina al enviar form
        setTimeout(function(){ window.location.reload(); }, 2000);          // uwu algún día usaremos ajax.. pero no aquí
    });

</script>