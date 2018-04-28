<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ordenes en Preruta.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Orden</th>
                                            <th>Importe</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Tipo Pago</th>
                                            <th>Fecha Pago</th>
                                            <th>Monto Pago</th>
                                            <th>Unidad <br/> Operador</th>
                                            <th>Administrar</th>
                                        </tr>
                                    </thead>
                                  <tbody>

                                <?php foreach ($secuenciaDetalle as $oc): ?>
                                <tr>
                                    <td><?php echo $oc->CVE_DOC?></td>
                                    <td><?php echo $oc->NOMBRE?></td>
                                    <td><?php echo $oc->ESTADO?></td>
                                    <td><?php echo $oc->CODIGO?></td>
                                    <td><?php echo $oc->FECHAELAB?></td>
                                    <td><?php echo '$ '.number_format($oc->IMPORTE,2)?></td>
                                    <td><?php echo $oc->DIAS?></td>
                                    <td><?php echo $oc->TP_TES?></td>
                                    <td><?php echo $oc->FECHA_PAGO?></td>
                                    <td><?php echo '$ '.number_format($oc->PAGO_TES,2)?></td>
                                    <td><?php echo $oc->UNIDAD.'<br/>'.$oc->OPERADOR?></td>
                                    <form action="index.php" method="post">
                                            <input name="prov" type="hidden" value="<?php echo $oc->PROV?>"/>
                                            <input name="secuencia" type="hidden" value="1"/>
                                            <input name="uni" type="hidden" value="<?php echo $oc->UNIDAD?>"/>
                                            <input name="fecha" type="hidden" value="<?php echo $oc->FECHAELAB?>"/>
                                            <input name="idu" type="hidden" value="<?php echo $oc->IDU?>" /> 
                                            <input type="hidden" name="doco" value = "<?php echo $oc->CVE_DOC?>" />                          
                                    <td>                                                
                                            <button name="SecUnidad2" type="submit" value="enviar" class="btn btn-warning">Asignar <i class="fa fa-cog fa-spin"></i></button>
                                    </td>
                                    </form>
                                </tr>
                             <?php endforeach ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
            <div class = "panel-footer; hide" >
                <div class="text-right">
                    <form action="index.php" method="post">
                        <input type="hidden" name="unidad" value="<?php echo $unidad; ?>"/>
                        <button type="input" name="ImprimirSecuencia" class="btn btn-primary">Imprimir <i class="fa fa-print" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
</div>



