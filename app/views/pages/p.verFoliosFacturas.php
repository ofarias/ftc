<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            VENTAS MENSUALES   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                           
                                            <th>Año</th>
                                            <th>NOMBRE</th>
                                            <th>VENTA</th>
                                            <th>CANCELADO</th>
                                            <th>DEVOLUCIONES</th>
                                            <th>TOTAL VENTA <br/> Mensual </th>
                                            <th>CON SALDO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($meses as $data): 

                                            $TOTAL = $data->FACTURADO - $data->CANCELADO - $data->DEVUELTO;
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><a href="index.php?action=detalleVenta&tipo=detalleAnual&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>" onClick="tardado()"> <?php echo $data->ANHIO;?> </a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><a href="index.php?action=detalleVenta&tipo=venta&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>"><?php echo '$ '.number_format($data->FACTURADO,2);?> </td>
                                            <td><a href="index.php?action=detalleVenta&tipo=canceladas&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>"><?php echo '$ '.number_format($data->CANCELADO,2);?> </td>
                                            <td><a href="index.php?action=detalleVenta&tipo=devueltas&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>"><?php echo '$ '.number_format($data->DEVUELTO,2);?> </td>
                                            <td><a href="index.php?action=detalleVenta&tipo=ventaReal&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>"><?php echo '$ '.number_format($TOTAL,2);?> </td>
                                            <td><a href="index.php?action=detalleVenta&tipo=pendientes&mes=<?php echo $data->NUMERO?>&anio=<?php echo $data->ANHIO?>"><?php echo '$ '.number_format($data->PENDIENTE,2);?> </td>                                          
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

<?php if($detalle != '' and ($tipo == 'venta' or $tipo == 'canceladas' or $tipo == 'devueltas')) { ?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                             <?php echo $tipo?>   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>S</th>
                                            <th>FECHA</th>
                                            <th>CLIENTE</th>
                                            <th>IMPORTE</th>
                                            <th>APLICADO</th>
                                            <th>IMPORTE <br/> NOTA DE CREDITO</th>
                                           
                                            <th style="background-color:'#ccffe6'">SALDO</th>
                                            <th>Referencia <br/> Aplicaciones</th> 
                                            <th>Referencia <br/> Pago</th>
                                            <th>Referencia <br/> Notas de Credito</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($detalle as $key): 
                                           
                                            $color='';
                                            if($key->SALDOFINAL >= 10){
                                                $color = "style='background-color:#ffb3b3';";
                                            }elseif ($key->SALDOFINAL <= 10 and $key->STATUS !='C') {
                                                $color="style='background-color:#b3e6ff';";
                                            }elseif($key->STATUS == 'C'){
                                                $color="style='background-color:#ffff33';";
                                            }
                                            $valCan= 0;
                                         
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <a href="index.php?action=detallePagoFactura&docf=<?php echo $key->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">   <?php echo $key->CVE_DOC ?> </a> </td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->FECHA_DOC;?> </td>
                                            <td><?php echo $key->NOMBRE.'('.$key->CVE_CLPV.')';?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICADO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE_NC,2);?> </td>
                                            
                                            <td><?php echo '$ '.number_format($key->SALDOFINAL,2);?></td>
                                            <td><?php echo $key->ID_APLICACIONES?></td>
                                            <td><?php echo $key->ID_PAGOS.'('.$key->BANCO.')'?></td>
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
<?php }elseif($detalle !='' and ($tipo =='ventaReal' or $tipo == 'detalleAnual')){ ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                             <?php echo $tipo?>   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>S</th>
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
                                        <?php foreach ($detalle as $key): 
                                           
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
                                            <td> <a href="index.php?action=detallePagoFactura&docf=<?php echo $key->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">   <?php echo $key->CVE_DOC ?> </a> </td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->FECHA_DOC;?> </td>
                                            <td><?php echo $key->NOMBRE.'('.$key->CVE_CLPV.')';?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,2);?></td>
                                            <td><?php echo '$ '.number_format($key->APLICADO,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE_NC,2);?> </td>
                                            <td><?php echo '$ '.number_format($valCan,2);?> </td>
                                            <td><?php echo '$ '.number_format($key->SALDOFINAL,2);?></td>
                                            <td><?php echo $key->ID_APLICACIONES?></td>
                                            <td><?php echo $key->ID_PAGOS.'('.$key->BANCO.')'?></td>
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
<?php }elseif ($detalle !='' and $tipo =='pendientes'){ ?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                             <?php echo $tipo?>   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>S</th>
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
                                        <?php foreach ($detalle as $key): 
                                           
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
                                            <td><?php echo $key->STATUS?></td>
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
<?php }?>

<script type="text/javascript">
    
    function tardado(){
        alert('Esto va a tardar..... de 10 a 15 minutos');
    }
</script>