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
                                            <th>STATUS DE <br/> LA APLICACION</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($detallePago as $key): 
                                           if($key->STATUS == 1){
                                            $status = 'Cancelado';
                                            $color = "style='background-color:#ff6666'";
                                           }else{
                                            $status = 'Aplicado';
                                            $color = '';
                                           }                                            
                                        ?>
                                        <tr class="odd gradeX"  <?php echo $color?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->DOCUMENTO?> </td>
                                            <td><?php echo $key->CLIENTE?></td>
                                            <td><?php echo $key->IDAPLICACION?></td>
                                            <td><?php echo '$ '.number_format($key->MONTO);?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO_APLICADO);?></td>
                                            <td><?php echo $key->IDPAGO;?></td>
                                            <td><?php echo $key->BANCO;?> </td>
                                            <td><?php echo $key->FECHA_RECEP;?> </td>
                                            <td><?php echo $status;?></td>
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