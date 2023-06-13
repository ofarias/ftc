<br/><br/>
<?php ?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Liberar partidas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ORDEN DE COMPRA</th>
                                            <th>CANTIDAD</th>
											<th>CLAVE PRODUCTO</th>
                                            <th>NOMBRE PRODUCTO</th>
                                            <th>CANTIDAD</th>
                                            <th>PENDIENTE</th>
											<th>PROVEEDOR</th>
                                            <th>FECHA DE RECEPCION</th>
                                            <th>RECEPCION</th>
                                            <th>ESTATUS RECEPCION</th>
                                            <th>Vueltas Producto</th>
                                            <th>LIBERAR</th>
                                            <th>Reenrutar</th>
                                        </tr>
                                    </thead>   
								
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                        ?>
                                            
                                       <tr>
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data ->CVE_DOC;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
											<td><?php echo $data->CAMPLIB7;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_DOC_RECEP;?></td>
                                            <td><?php echo $data->DOC_RECEP;?></td>
                                            <td><?php echo $data->DOC_RECEP_STATUS;?></td>
                                            <td><?php echo $data->VUELTA;?></td>
                                            <form action="index.php" method="POST">
                                            <td>
                                            <button name="liberaPendientes" 
                                                    type="submit" 
                                                    value="<?php echo $data->ID_PREOC?>" 
                                                    class="btn btn-warning" 
                                                    id="val_<?php echo $data->ID_PREOC?>" 
                                                    onclick="ocultar(val_<?php echo $data->ID_PREOC?>.value)"
                                            > Libera Pago
                                            </button>

                                            </td>
                                            <td>
                                            <button name="reEnrutar" type="submit" value="reenrutar" 
                                            > Reenrutar OC </button>
                                            <input name="doco" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                            <input name="id_preoc" type="hidden" value="<?php echo $data->ID_PREOC?>"/>
                                            <input name="pxr" type="hidden" value="<?php echo $data->PXR?>"/>  
                                            </td>
                                            </form>
                                        </tr>
                                            <?php endforeach; ?>
                                    </tbody>                    
                                </table>
                            </div>
                  </div>
            </div>
        </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
    window.addEventListener('load',CalculaMontosPR,false);
    window.addEventListener('keypress',CalculaMontosPR,false);
    function ocultar(a){
        //alert('El renglon es ' + a);
        document.getElementById('val_' + a).classList.add('hide');

    }

   
</script>