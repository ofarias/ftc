<br /><br />
 <div class="row">
 <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Contrarecibo de pago de cr&eacute;dito.
             </div>
             <div class="panel-body">
                 <div class="table-responsive">  
                     <table class="table table-striped table-bordered table-hover" id="dataTables-oc-credito-contrarecibos">
                         <thead>
                             <tr>
                                 <th>TIPO</th>
                                 <th>BENEFICIARIO</th>
                                 <th>MONTO</th>
                                 <th>RECEPCION</th>
                                 <th>OC</th>
                                 <th>FECHA DOC</th>
                                 <th>VENCIMIENTO</th>
                                 <th>PROMESA PAGO</th>
                                 <th>MONTO REAL</th>
                                 <th>FACTURA PROVEEDOR</th>
                                 <th>IMPRIMIR</th>
                             </tr>
                         </thead>   
                         <tbody>
                             <?php
                             foreach ($exec as $data):
                                 ?>
                             <form id="FORM_ACTION_PAGOS_CREDITO" method="POST" action="index.php">
                                 <tr  onmousemove="this.style.fontWeight = 'bold';">
                                     <td>
                                         <input type="hidden" name="identificador" value="<?php echo "$data->ID";?>" />
                                         <input type="hidden" name="tipo" value="<?php echo trim($data->TIPO);?>" />
                                         <?php echo $data->TIPO; ?></td>
                                     <td><?php echo $data->BENEFICIARIO; ?></td>
                                     <td align="right"><?php echo '$ '.number_format($data->MONTO, 2, '.', ','); ?></td>
                                     <td><?php echo $data->RECEPCION; ?></td>
                                     <td><?php echo $data->OC;?></td>
                                     <td><?php echo $data->FECHA_DOC; ?></td>
                                     <td><?php echo $data->VENCIMIENTO; ?></td>                                    
                                     <td><?php echo $data->PROMESA_PAGO; ?></td>
                                     <td align="right">
                                        <input type="number" step="any" name="montor" value="<?php echo $data->MONTO?>"  required="required" />
                                     </td>                                        
                                     <td align="right">
                                        <input type="text" name="facturap" value="<?php echo $data->FACTURA?>" required="required">
                                        <input type="hidden" name="recepcion" value ="<?php echo $data->RECEPCION?>">
                                     </td>
                                     <td><input type="submit" name="FORM_ACTION_PAGO_CREDITO_CONTRARECIBO_IMPRIMIR" value="Imprimir" /></td>                                    
                                 </tr>

                             </form>

                         <?php endforeach; ?>

                         </tbody>

                     </table>

                 </div>

             </div>

         </div>

     </div> 