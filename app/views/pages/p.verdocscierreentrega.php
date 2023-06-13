<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                          Cierre día Entrega.
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
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                            </div>
            </div>
                        <div class="panel-footer text-right">
                            <form action="index.php" method="post">
                                <button type="submit" name="generarCierreEnt" class="btn btn-warning" formtarget="_blank" onclick="refrescar()" >Generar Cierre <i class="fa fa-save"></i></button>
                            </form>                            
                        </div>
        </div>
    </div>
</div>
    
<script>
function refrescar() {
    setTimeout(function(){ window.location.reload(); }, 2000);
}
</script>