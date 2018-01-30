<div class="row">
    <br />
</div>

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Facturas con saldo pendiente. 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>No.Factura</th>
                                            <th>Fecha Documento</th>
                                            <th>Fecha Entrega</th>
                                            <th>Unidad de Entrega:</th>
                                            <th>Fecha Cobranza</th>
                                            <th>Saldo</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data): 

                                            $statusrec = $data->ENLAZADO;
                                            $statuslog = $data->STATUS_LOG;

                                            if($statusrec == 'T'){
                                                $statusrec = 'Total';
                                            }elseif($statusrec == 'P'){
                                                $statusrec = 'Parcial';
                                            }else{
                                                $statusrec = 'Otro';
                                            }

                                            if ($statuslog == $statusrec){
                                                $color = "style='background-color:FFFFFF;'";
                                            }else{
                                                $color = "style='background-color:orange;'";
                                            }                        
                                            ?>
                                        <tr >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_DOC?> </td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->FECHA_REC_COBRANZA;?></td>
                                            <td><?php echo '$ '.$data->SALDO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="clie" type="hidden" value="<?php echo $data->CVE_CLPV?>">
                                            <input name="rfc" type="hidden" value="<?php echo $data->RFC?>"/>
                                            <td>
                                                <button name="PagoxFactura" type="submit" value="enviar" class="btn btn-warning">Aplicar Pago  <i class="fa fa-money"></i></button></td> 
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