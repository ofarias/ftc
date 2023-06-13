<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Saldos de los Maestros. 
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-maestros">    
                                    <p id="Total"></p>
                                    <p id="comp"></p>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Clave</th>
                                            <th>Sucursales</th>
                                            <th>Comprometido</th>
                                            <th>Saldo <bt/> 2018 </th>
                                            <th>Limite de Credito <br/> Global</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($info as $data):
                                        ?>
                                           <tr>
                                                <td><a href="index.cobranza.php?action=verDocumentosMaestro&maestro=<?php echo $data->CLAVE?>" onclick="window.open(this.href, this.target, 'width=1200,height=1320'); return false;"><?php echo $data->NOMBRE;?></a></td>
                                                <td><?php echo $data->CLAVE;?></td>
                                                <td><a href="index.cobranza.php?action=CarteraxCliente&cve_maestro=<?php echo $data->CLAVE;?>"  class="btn btn-info" onclick="window.open(this.href, this.target, 'width=1200,height=1320'); return false;"><?php echo $data->SUCURSALES?></a></td>
                                                <td title="En Cotizaciones" align="right"><font color="blue"><?php echo '$ '.number_format($data->LOGISTICA,2);?></font></td>
                                                <td align="right"><b><?php echo '$ '.number_format($data->SALDO_2018,2);?></b></td>
                                                <td align="right"><?php echo '$ '.number_format($data->LINEACRED_CALCULADA,2)?></td>
                                                <td><?php echo $data->OBSERVACIONES?></td>
                                                <input type="hidden" name="factura" class="factura" monto="<?php echo $data->SALDO_2018?>" compr="<?php echo $data->LOGISTICA?>">
                                            </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<br/>
<br/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
        $(document).ready(function() {
            var montoTotal = 0;
            var comprometido = 0; 
            alert('alert'); 
                      
            $("input.factura").each(function() {
                    var monto = parseFloat($(this).attr("monto"),2);
                    montoTotal = montoTotal + monto;
                    var compr = parseFloat($(this).attr("compr"),2);
                    comprometido = comprometido+compr;  
            });

            var numero = String(montoTotal).split(".");
            var numero2 = String(comprometido).split(".");
            
            var long = numero[0].length;
            var long2 = numero2[0].length;

            if(numero[0].length > 6){
                var tipo = 'Millones';
                if (long == 9){
                    var mill = 3;
                }else if(long == 8){
                    var mill = 2;
                }else if(log == 7){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                //alert( millones  + ',' + miles + ',' + unidades+ '.00' );
                var texto = '$  '+ millones + ',' + miles + ','+ unidades + '.00';
            }else if(numero[0].length > 3){
                var tipo = 'Miles';
                var texto = 'Numero de Miles';
            }else if(numero[0].length > 0){
                var tipo = 'Ciento';
                var texto = 'Numero de ciento '
            }
            
            if(numero2[0].length > 6){
                var tipo2 = 'Millones';
                if (long2 == 9){
                    var mill2 = 3;
                }else if(long2 == 8){
                    var mill2 = 2;
                }else if(log2 == 7){
                    var mill2 = 1
                }
                var millones2 = numero2[0].substring(0,mill2);
                var miles2 = numero2[0].substring(mill2, mill2 + 3 );
                var unidades2 = numero2[0].substring(mill2 + 3, mill2 +6);
                //alert( millones  + ',' + miles + ',' + unidades+ '.00' );
                var texto2 = '$  '+ millones2 + ',' + miles2 + ','+ unidades2 + '.00';
            }else if(numero2[0].length > 3){
                var tipo2 = 'Miles';
                var texto2= 'Numero de Miles';
            }else if(numero2[0].length > 0){
                var tipo2 = 'Ciento';
                var texto2= 'Numero de ciento '
            }

            document.getElementById('Total').innerHTML="Total 2018: <font size='4pxs' color='red'>"+texto+"</font>";
            document.getElementById('comp').innerHTML=" Comprometido: <font size='4pxs' color='green'>"+texto2+"</font>";
        });


</script>