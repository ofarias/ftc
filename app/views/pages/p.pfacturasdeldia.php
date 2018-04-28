<br /><br />

<div>
 Resumen
 Total Facturas emitidas del dia =  <?php echo $resumen?> --------------Logistica "Boddega" = Aun no se prepara el material o la caja no ha sido cerrada.<br>
 Total de Facturas en aduana = <?php echo $totaduana?>  ------------Logistica "Entregado" = Ya se cuenta con un resultado desde la Administracion de Logistica. <br> 
 Total de Facturas en Logistica =  <?php echo $totlog?> -------------Logistica "admon" estan en espera de que se administre la ruta.<br>
  <br>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Facturación del día
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Logistica</th>
                                            <th>Status</th>
                                            <th>Id Cliente</th>
                                            <th>Nombre</th>
                                            <th>RFC</th>
                                            <th>Fecha Factura</th>
                                            <th>Dias</th>
                                            <th>Impuesto</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data):?>
                                       <tr <?php
                                            $hoy = date("Y-m-d");
                                            /*if($hoy <= $data->FECHA_DOC){
                                                echo "style='background-color:#85e085'";
                                            }else{
                                               echo "style='background-color:#ffff80'"; 
                                            }*/ ?> >
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->LOGISTICA;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->IMP_TOT4;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                               
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>