<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Preparar Material.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <th>Pedido</th>
                                        <th>Caja</th>
                                        <th>Cliente</th>                                         
                                        <th>Paquetes</th>
                                        <th>Fecha Caja</th>
                                        <th>Factura o remision</th>
                                        <th>Fecha Fact o remision</th>
                                            <!--<th>Faltante</th>
                                            <th>Enpacado</th>
                                            <th>Cant a Empacar</th>
                                            <th>Numero Empaque</th>-->
                                        <th>Embalar</th>
                                 <!--       <th>Imprimir</th> -->
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($paquetes as $data): 
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->PAQUETE;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHA_FACT;?></td>
                                            <!-- <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>                                       
                                            <td><?php echo $data->REC_FALTANTE;?></td>
                                            <td><?php echo $data->CANT_VAL;?></td> -->
                                            <form action="index.php" method="post" id="embalaje">
                                            <td>
                                                <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>"/>
                                                <input type="hidden" name="caja" value="<?php echo $data->ID;?>"/>
                                                <button name="embalaje" type="submit" value="embalar" class="btn btn-warning"><i class="fa fa-check">Embalar</i></button>
                                            </td>
                                      <!--      <td>
                                                <button name="impcontenidocaja" type="submit" class="btn btn-warning"><i class = "fa fa-print"></i></button>
                                            </td>   -->
                                            </form>      
                                        </tr>

                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />