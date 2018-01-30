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
                                            <th>Unidad</th>
                                            <th>Administrar</th>
                                        </tr>
                                    </thead>
                                  <tbody>

<!--
                                        <?php
                                        foreach ($secuencia as $data):  
                                        ?>
                                       <tr>
                                            <td>
                                                <a class="collapsed" data-toggle="collapse" href="<?php echo '#'.ltrim($data->PROV);?>" aria-expanded="false" aria-controls="<?php echo ltrim($data->PROV);?>"> <?php echo $data->NOMBRE;?> </a>
                                                <div id="<?php echo ltrim($data->PROV);?>" class="collapse"  aria-expanded="false" aria-controls="<?php echo ltrim($data->PROV);?>">
                                                    <ul>
                                                        <?php
                                                            foreach($secuenciaDetalle as $oc){
                                                                echo ($oc->CVE_CLPV == $data->PROV) ? "<li>".$oc->CVE_DOC."     Fecha: ".substr($oc->FECHA_DOC,0,10)."  Días: ".$oc->DIAS."</li><br>":"";
                                                            }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td>
                                            	<form action="index.php" method="post">
                                            	<input name="prov" type="hidden" value="<?php echo $data->PROV?>"/>
                                            	<input name="secuencia" type="number" required = "required"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>"/>
                                                <input name="fecha" type="hidden" value="<?php echo $data->FECHA?>"/>
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />                                             
                                            </td>  

                                            <td>                                            	
                                            	<button name="SecUnidad2" type="submit" value="enviar" class="btn btn-warning">Asignar <i class="fa fa-cog fa-spin"></i></button></td>
                                            	</form>
                                             </tr>
                                            
                                        <?php endforeach; ?>
-->
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
                                    <td><?php echo $oc->UNIDAD?></td>
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



