<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Cajas para devolucion o reenviar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-recmcia">
                                    <thead>
                                        <tr>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Factura <br/> Remision</th>
                                            <th>Fecha Documento</th>
                                            
                                            <th>Estatus</th>
                                            <th>Estatus Mercancia</th>
                                            <th>Recibir Documentos</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($entregas as $data): 
                                            $var=$data->DOCS;
                                    ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $data->ID;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FACTURADOC.'<br/><font color="blue">'.$data->REMISIONDOC.'</font>';?></td>
                                            <td><?php echo $data->FECHAFAC.'<br/><font color="blue">'.$data->FECHAREM.'</font>';?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->STATUS_MER;?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                            <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            <input name="fact" type="hidden" value="<?php echo $data->FACTURA?>" />
                                            <input name="docr" type="hidden" value="<?php echo $data->REMISION?>" />
                                            <input name="idcaja" type="hidden" value = "<?php echo $data->ID?>" />
                                            <input name="tipo" type="hidden" value = "<?php echo $data->STATUS_LOG?>"/>
                                             <button name="recmercancia" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($data->STATUS_MER == 'recibido')? "disabled" : "";?> > Recibir Mercancia  <i class="fa fa-floppy-o"></i></button>
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
function refrescar() {
    setTimeout(function(){ window.location.reload(); }, 2000);
}
</script>