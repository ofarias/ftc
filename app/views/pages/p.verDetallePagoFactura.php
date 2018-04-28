    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>APLICACION</th>
                                            <th>IMPORTE</th>
                                            <th>MONTO <br/> APLICADO</th>
                                            <th>ID PAGO</th>
                                            <th>FOLIO X BANCO</th>
                                            <th>FECHA <br/>EDO CTA </th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($detallePago as $key): 
                                           
                                            
                                        ?>
                                        <tr class="odd gradeX"  >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->DOCUMENTO?> </td>
                                            <td><?php echo $key->CLIENTE?></td>
                                            <td><?php echo $key->IDAPLICACION?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE);?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO_APLICADO);?></td>
                                            <td><?php echo $key->IDPAGO;?></td>
                                            <td><?php echo $key->BANCO;?> </td>
                                            <td><?php echo $key->FECHA_RECEP;?> </td>
                                            
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>