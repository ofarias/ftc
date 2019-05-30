
<br/>
<br/>
<?php foreach($pago as $key2){
    $saldo = $key2->SALDO;
}
?>
<div>
    <td>
     <form action="upload_comprobante_pago.php" method="post" enctype="multipart/form-data">
         <input type="file" name="fileToUpload" id="fileToUpload" required>
         <input type="hidden" name="idp" value="<?php echo $idp?>">
         <input type="hidden" name="saldop" value="<?php echo $key2->SALDO?>">
         <input type="hidden" name="items" value="<?php echo $items?>">
         <input type="hidden" name="total" value="<?php echo $total?>">
         <input type="hidden" name="retorno" value="<?php echo $retorno?>">
         <button type="submit" name="Aplicar" value="enviar" >Aplicar Pago </button>
     </form>
    </td>
</div>
<br/>
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
                                            <th>ID / Folio x Banco</th>
                                            <th>Banco</th>
                                            <th>Fecha Edo de Cta</th>
                                            <th>Monto </th>
                                            <th>Aplicado</th>
                                            <th>Saldo Actual</th>
                                            <th>Saldo despues de Aplicacion</th>      
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($pago as $key): 
                                            $color='';
                                            if($key->SALDO >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDO <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                            <td> <?php echo $key->ID. ' / ' .$key->FOLIO_X_BANCO?> </td>
                                            <td><?php echo $key->BANCO?></td>
                                            <td><?php echo $key->FECHA_RECEP;?> </td>
                                            <td><?php echo '$ '.number_format($key->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICACIONES,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDO - $total,2);?> </td>
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