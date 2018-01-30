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
                                            <th>UBICACION</th>
                                            <th>FECHA</th>
                                            <th>CLIENTE</th>
                                            <th>IMPORTE</th>
                                            <th>APLICADO</th>
                                            <th>IMPORTE <br/> NOTA DE CREDITO</th>
                                            <th>CANCELACION </th>
                                            <th style="background-color:'#ccffe6'">SALDO</th>
                                            <th>Referencia <br/> Aplicaciones</th> 
                                            <th>Referencia <br/> Pago</th>
                                            <th>Referencia <br/> Notas de Credito</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($documentos as $key): 
                                            $color='';
                                            if($key->SALDOFINAL >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDOFINAL <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                            if($key->STATUS == 'C'){
                                                $valCan = $key->IMPORTE;    
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->CVE_DOC ?> </td>
                                            <td><?php echo $key->STATUS_FACT?></td>
                                            <td><?php echo $key->FECHA_DOC;?> </td>
                                            <td><?php echo $key->NOMBRE.'('.$key->CVE_CLPV.')';?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICADO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE_NC,2);?> </td>
                                            <td><?php echo '$ '.number_format($valCan,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDOFINAL,2);?></td>
                                            <td><?php echo $key->ID_APLICACIONES?></td>
                                            <td><?php echo $key->ID_PAGOS?></td>
                                            <td><?php echo $key->NC_APLICADAS?></td>
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
