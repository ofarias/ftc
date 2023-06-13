<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documento con Saldo.    
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-saldos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Banco</th>
                                            <th>Folio Banco</th>
                                            <th>Fecha <br/>Estado de Cuenta</th>
                                            <th>Cliente</th>
                                            <?php if($t == 'i'){?>
                                                <th>Reasignar</th>
                                            <?php }?>
                                            <th>Fecha <br/> Carga </th>
                                            <th>Monto</th>
                                            <th>Aplicaciones </th>
                                            <th>Saldo</th>
                                          
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php $total = 0;
                                            foreach ($pagos as $data):
                                            $total = $total + $data->SALDO;
                                       ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->PAGO;?></td>
                                            <td><?php echo $data->BANCO?></td>
                                            <td><?php echo $data->FOLIO_BANCO;?></td>
                                            <td><?php echo $data->FECHA_EDO_CTA;?></td>
                                            <td><?php echo '('.$data->CVE_MAESTRO.')',$data->MAESTRO;?></td>
                                            <?php if($t == 'i'){?>
                                                <td><select name="maestro" id="sel_<?php echo $data->PAGO?>">
                                                          <option value="9999">Seleccione un Maestro</option>
                                                          <?php foreach ($maestros as $data2): ?>
                                                            <option value="<?php echo $data2->ID?>"><?php echo $data2->NOMBRE.'('.$data2->CLAVE.') '?></option>    
                                                          <?php endforeach ?>
                                                    </select>
                                                    <input type="button" name="Asignar" value="Asignar" onclick="asigna(<?php echo $data->PAGO?>, <?php echo $data->MONTO?>)">
                                                </td>
                                            <?php }?>
                                            <td><?php echo $data->FECHAELAB?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2)?></td>
                                            <td><a href="index.php?action=pagoFacturas&idp=<?php echo $data->PAGO?>" target="blank"><?php echo '$ '.number_format($data->APLICACIONES,2)?></a></td>                                        
                                            <td><?php echo '$ '.number_format($data->SALDO,2 )?></td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>

                                    </tbody>
                                     <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo '$ '.number_format($total,2)?></td>
                                    
                                </table>

                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    function asigna(pago, monto, idp){
        var sel = document.getElementById('sel_'+pago).value
        if(sel == 9999){
            alert('Seleccionar un Maestro')
        }else{
        alert('zass' + pago +' Id maestro: '+ sel)
            $.ajax({
                url:'index.cobranza.php',
                type:'post',
                dataType:'json',
                data:{valida:sel, monto, idp:pago},
                success:function(data){
                    if(data.status == 'ok'){
                        alert(data.mensaje)
                        location.reload(true)
                    }else{
                        alert(data.mensaje)
                    }
                },
                error:function(){
                    alert('Sucedio algo y no es posible asignarlo al maestro, favor revise la informacion')
                    return false
                }
            })
        }
    }

        function format(numero){
            var long  = numero[0].length;
            if(long > 6){
                var tipo = 'Millones';
                if (long == 9){
                    var mill = 3;
                }else if(long == 8){
                    var mill = 2;
                }else if(long == 7){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + ','+ unidades + '.00';
            }else if(long > 3){
                if (long == 6){
                    var mill = 3;
                }else if(long == 5){
                    var mill = 2;
                }else if(long == 4){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + '.00';
            }else if(long > 0){
                var tipo = 'Ciento';
                var texto = 'No se ha seleccionado ningun valor ';
            }
            return (texto);
        } 
</script>