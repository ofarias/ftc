<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Facturas recibidas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Remision</th>
                                            <th>Fecha Remision</th>
                                            <th>Estatus</th>
                                            <th>Contra recibo</th>
                                            <th>Guardar</th>
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
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHAFAC;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FECHAREM;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                  <form action="index.php" method="post">
                                      <td><input type="text" name="contraRecibo" class="form-control"/></td>
                                      <input type="hidden" name="idcaja" value="<?php echo $data->ID?>"/>
                                      <td><button name="contraReciboFact" class="btn btn-warning">Guardar <i class="fa fa-save"></i></button></td>
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