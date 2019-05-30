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
                                <form action="index.php" method="post">
                                
                                    <label> El monto del pago es de: $ <?php echo number_format($key->MONTO,2)?> </label><br>
                                    
                                    <input type="hidden" name="idpago" value="<?php echo $key->ID?>">   
                                    
                                    <label> El saldo actual es de: $ <?php echo number_format($key->SALDO,2)?>   ---------->    </label>   <button name='imprimirComprobante' value="enviar" type="submit" class="btn btn-info">IMPRIMIR RELACION DEL PAGO</button><br> 
                                    <label> El total de monto aplicado es: $ <?php echo number_format($total,2)?></label><br>
                                <?php endforeach; ?>
                                <br/>
                                </form>
                                <p>Tipo de Pago: Transferencia:&nbsp;&nbsp;<input type="radio" name="tipoP" value="03" checked> 
                                                 &nbsp;&nbsp;Cheque:&nbsp;&nbsp;<input type="radio" name="tipoP" value="02">
                                                 &nbsp;&nbsp;Efectivo:&nbsp;&nbsp;<input type="radio" name="tipoP" value="01"> </p>
                                <p>Cuenta Origen: <input type="text" name="cuentaO" id="ctaO" placeholder="Cuenta Origen"></p>
                                <p>Numero de Operacion:<input type="text" name="numOpe" id="numope" placeholder="Numero de Operacion"></p>
                                <p>Banco Origen: <select id="bancoO">
                                        <option value="0" >Seleccione un Banco Origen</option>
                                        <?php foreach($bancos as $banco){?>
                                            <option value="<?php echo $banco->CLAVE?>"><?php echo $banco->BANCO.'-->'.$banco->RFC?></option>
                                        <?php }?>
                                    </select>
                                </p>

                                <p id="boton">Generar Recibo Electronico de Pago<button class="btn btn-success" onclick="generaCEP('<?php echo $folio?>','<?php echo $cliente?>')" >REP</button></p>
                                    <label> &nbsp; &nbsp; Pago de una Financiera o Banco ? &nbsp;&nbsp;&nbsp;<input type="checkbox" name="financiera" onchange="finan()" id ="fide"></label>
                                </table>                                
                                <div class="hide" id="fin">
                                    <select name="financiera" id="sel">
                                        <option value="SS">Seleccione una financiera</option>
                                        <?php foreach ($fin as $data):?>
                                            <option value="<?php echo $data->ID?>"><?php echo $data->NOMBRE ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>     
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
        var c = document.getElementById('fide');
        var fin = document.getElementById('sel').value;
        var ctao = document.getElementById('ctaO').value; 
        var bancoo = document.getElementById('bancoO').value;
        var tipo = document.getElementsByName("tipoP");
        var numope = document.getElementById("numope").value;
        
        if( ctao.length >= 10 || ctao.length== 0){
            if(ctao.length >0){
                alert("La cuenta Origen es" + ctao);
            }else{
                if(confirm("No se coloco ninguna cuenta, desea continuar?")){

                }else{
                    return;
                }
            }
        }else{
            return alert("Solo se permiten 10 o mas digitos favor de revisar los datos..." );
        }

            if(confirm("Desea Continuar con los datos capturados?")){
            
            for(var i=0;i<tipo.length;i++){
            
            if(tipo[i].checked)
                    tipoO=tipo[i].value;
            }
            
            if(c.checked && fin == 'SS' ){
                return alert('Usted debe seleccionar una financiera');
            }else if(c.checked && fin != 'SS'){
                idCliente = 'F'+fin;
            }
            if(confirm('Desea realizar el REP del pago '+ folio +' para el cliente ' + idCliente + 'Banco ' + bancoo)){
                alert('Se realiza el CEP');
                $.ajax({
                    url:'index.cobranza.php',
                    type:'POST',
                    dataType:'json',
                    data:{generaCEPPago:folio, idCliente, ctao, bancoo, tipoO, numope},
                    success:function(data){
                        document.getElementById("boton").innerHTML="<a href='/Facturas/FacturasJson/"+data.archivo+".pdf' download> <img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a> <a href='/Facturas/FacturasJson/"+data.archivo+".xml' download> <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>";
                    }
                });
            }else{
                alert('No se genero el CEP');
            }
        }else{
            return("No se elaboro ningun Complemento");
        }
    }

    function finan(){
        var c = document.getElementById('fide');
        if(c.checked){
            alert('El recibo se realizara al nombrede una Financiera');
            document.getElementById("fin").classList.remove("hide");    
        }else{
            document.getElementById("fin").classList.add("hide");
        }
    }

</script>

