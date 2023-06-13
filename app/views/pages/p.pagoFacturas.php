 <?php 
    foreach ($facturas as $data){
        $cliente = $data->CLAVE;
    }                         
?>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
                A P L I C A C I O N.  
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                <?php 
                                    foreach ($pago as $key):
                                        $folio = $key->ID;
                                ?>
                                    <label> El monto del pago es de: $ <?php echo number_format($key->MONTO,2)?> </label><br>
                                    <form action="index.php" method="post">
                                    <input type="hidden" name="idpago" value="<?php echo $key->ID?>">   
                                    
                                    <label> El saldo actual es de: $ <?php echo number_format($key->SALDO,2)?>   ---------->    </label>   <button name='imprimirComprobante' value="enviar" type="submit" class="btn btn-info">IMPRIMIR RELACION DEL PAGO</button><br> 
                                    </form>
                                    <label> El total de monto aplicado es: $ <?php echo number_format($total,2)?></label><br>
                                <?php endforeach; ?>
                                <br/>
                                <p>Generar Recibo Electronico de Pago</p><button class="btn btn-success" onclick="generaCEP('<?php echo $folio?>','<?php echo $cliente?>')">REP</button>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
                R e l a c i o n ---  D e  ---   F a c t u r a s  ---   P a g a d a s.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Aplicacion</th>
                                            <th>Clave</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Aplicacion</th>
                                            <th>Documento</th>
                                            <th>Importe</th>
                                            <th>Saldo Documento</th>
                                            <th>Monto Aplicado</th>
                                            <th>Saldo Pago</th>
                                            <th>Usuario</th>
                                            <?php if($rol == 'cxcc'){?>
                                            <th></th>
                                            <?php }else{?>
                                            <th>Contabilizar</th>
                                            <?php }?>
                                           
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data):
                                    
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLAVE?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DOCUMENTO.'<font color="red"> FP:'.$data->FORMADEPAGOSAT.'</font><font color="blue">MP:'.$data->METODODEPAGO.'</font><font color="green">USO:'.$data->USO_CFDI.'</font>';?></td>
                                            <td><?php echo '$ '.number_format($data->IMPORTE,2)?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_DOC,2);?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO_APLICADO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO_PAGO,2)?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <form action="index.php" method="post">
                                            <?php if($rol== 'cxcc'){?>
                                            <td>
                                            
                                            </td>
                                            <?php }else{?>
                                            <td>
                                                <button type ="submit" value="enviar" name="contVenta" <?php echo ($data->CONTABILIZADO == 'OK')? "class='btn btn-success'":"class='btn btn-info'"?> <?php echo ($data->CONTABILIZADO == 'OK')? "disabled = 'disabled'":"" ?> > <?php echo ($data->CONTABILIZADO == 'OK')? 'Contabilizado':'Contabilizar' ?> </button>
                                            </td>
                                            <?php }?>
                                                 
                                            </form>
                                        </tr>
                                        
                                        <?php endforeach; ?>
                            
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<script type="text/javascript">
    
    function generaCEP(folio, idCliente){
        if(confirm('Desea realizar el REP del pago '+ folio +' para el cliente ' + idCliente)){
            alert('Se realiza el CEP');
            $.ajax({
                url:'index.cobranza.php',
                type:'POST',
                dataType:'json',
                data:{generaCEPPago:folio, idCliente}
            });
        }else{
            alert('No se genero el CEP');
        }
    }

</script>

