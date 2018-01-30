<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de factura
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Status</th>
                                            <th>Id Cliente</th>
                                            <th>Nombre</th>
                                            <th>RFC</th>
                                            <th>Fecha Documento</th>
                                        <!--    <th>IVA</th> -->
                                            <th>Importe</th>
                                            <th>Costo</th>
                                            <th>$ Utilidad</th>
                                            <th>% Utilidad</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): ?>
                                       <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                        <!--    <td><?php echo $data->IMP_TOT4;?></td> -->
                                            <td class="text-right"><?php echo "$ ". number_format($data->CAN_TOT,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COSTO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->MONTO_UTILIDAD,2,".",",");?></td>
                                            <td class="text-right"><?php echo $data->UTILIDAD;?></td>
                                            
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


<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de factura
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Factura</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Costo</th>
                                            <th>Total Partida</th>
                                            <th>Total Costo</th>
                                            <th>$ Utilidad</th>                                            
                                            <th>% Utilidad</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <?php foreach($total as $data): 
                                        if($data->ORO == 'si'){
                                            $color = " #E7AE18";
                                        }else{
                                            if($data->UTILIDAD_TOTAL_PONDERADA < 0) $color = "#FF4000";
                                                elseif($data->UTILIDAD_TOTAL_PONDERADA > 0 && $data->UTILIDAD_TOTAL_PONDERADA < 25) $color = "#81BEF7";
                                                    elseif($data->UTILIDAD_TOTAL_PONDERADA >= 25) $color ="#04B431";
                                        }
                                    ?>
                                        <tr style="background-color:<?php echo $color;?>">
                                            <td colspan="3"></td>
                                            <td ><?php echo $data->CANTIDAD_TOTAL;?> <td>
                                            <td></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->PARTIDA_TOTAL,2,".",",");?> </td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->TOT_COSTO,2,".",",");?> </td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->MONTO_UTILIDAD_TOTAL,2,".",",");?> </td>
                                            <td class="text-right"><?php echo number_format($data->UTILIDAD_TOTAL_PONDERADA,2);?> </td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        foreach ($partidas as $data): ?>
                                       <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->PREC,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->COST,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->TOT_PARTIDA,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->TOT_COSTO,2,".",",");?></td>
                                            <td class="text-right"><?php echo "$ ". number_format($data->MONTO_UTILIDAD,2,".",",");?></td>
                                            <td class="text-right"><?php echo number_format($data->UTILIDAD,2);?></td>
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