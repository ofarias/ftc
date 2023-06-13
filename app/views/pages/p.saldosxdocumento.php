


<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Datos del cliente.
            </div>
            <div class="panel-body">
                <?php foreach($datacli as $data):
                    $bancoDeposito = $data->BANCO_DEPOSITO;
                    $bancoOrigen = $data->BANCO_ORIGEN;
                    $metodoPago = $data->METODO_PAGO;
                    $referEdo = $data->REFER_EDO;
                ?>
                <div class="form-group col-md-8">
                    <label> Cliente: <?php echo $data->NOMBRE?> (<?php echo $data->RFC?>) Cliente SAE: (<?php echo $data->CLAVE?>)</label> <br>   
                    <label> <?php echo $data->DIRECCION?> . Tel: <?php echo (empty($data->TELEFONO))? 'Sin Informacion':$data->TELEFONO;?></label>   <br>
                    <label> Email :  <?php echo $data->EMAILPRED;?> -- Vendedor Asignado: <?php echo (empty($data->VENDEDOR))? 'Sin Definir':$data->VENDEDOR?> Descuento: <?php echo $data->DESCUENTO?> -- Lista de Precios : <?php echo $data->LISTA_PREC?></label><br/>
                    <label>  Dias de Credito: &nbsp;&nbsp;<b> <?php echo $data->DIASCRED?></b></label> <br/>
                    <a href="index.php?action=datosCarteraCliente&idcliente=<?php echo $data->CLAVE?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200, height=820'); return false;"> <font color="red" class="btn-sm btn-info"> Editar </font> </a>
                     &nbsp;&nbsp; <a name="boton" value="refrescar" onclick="javascript:window.location.reload();" class="btn-sm btn-info"> Actualizar </a>

                </div>
                <div class="form-group col-md-4"> 
                    <button id="contactos" type="button" class="btn btn-default">Contactos <i class="fa fa-users"></i></button>
                </div>
            </div>  
                <?php endforeach;?>
            <div class="panel-heading">
                Cartera y linea de credito al <?php echo date("d-m-Y")?>.
            </div>
                <table width="100%" cellspacing="0" cellpadding="0" border="1">
                    <?php foreach ($saldo as $data):
                        $lc= $data->LINEA_CRED;
                        $pedidos = $data->PEDIDOS;
                        $facturas = $data->FACTURAS;
                        $lcc = $pedidos + $facturas;
                        $sd = $lc - $lcc;
                        $ac = $data->ACREEDORES;
                        $sv = $data->SALDO_VENCIDO;
                        $sc = $data->SALDO_CORRIENTE;
                        $st = ($sv + $sc) - $ac;
                    ?>
                    <tr>
                        <td width="47%"><label>&nbsp;&nbsp;&nbsp; Linea de Crédito: $ <?php echo number_format($data->LINEA_CRED,2);?></label></td>
                        <td width="6%"></td>
                        <td width="47%"><label style="color:#DF3A01">&nbsp;&nbsp; Saldo Vencido: $ <?php echo number_format($data->SALDO_VENCIDO,2)?></label></td>
                    </tr>
                    <tr>
                        <td><label>&nbsp;&nbsp;&nbsp; Pedidos en Transito: $ <?php echo number_format($data->PEDIDOS,2,".",",");?> </label></td>
                        <td width="6%"></td>
                        <td><label style = "color:#0080FF">&nbsp;&nbsp; Saldo sin Vencer: $ <?php echo number_format($data->SALDO_CORRIENTE,2)?> </label><br></td>
                    </tr>
                    <tr>
                        <td> <label style="color:green" >&nbsp;&nbsp;&nbsp; Pedidos Facturados: $ <?php echo number_format($data->FACTURAS,2)?></label></td>
                        <td width="6%"></td>
                        <td> <label style="color:#01DFA5">&nbsp;&nbsp; Acreedores: $ <?php echo number_format($data->ACREEDORES,2) ?></label></td>
                    </tr>
                    <tr>
                        <td><label style="color:#FF8000">&nbsp;&nbsp;&nbsp; Linea de Credito Comprometida: $ <?php echo number_format($lcc,2)?> </label></td>
                        <td width="6%"></td>
                        <td><label <?php echo ($st > $lc )? 'style="color:red"':'style="color:#5858FA"'?>>&nbsp;&nbsp; Saldo Total: $ <?php echo number_format($st,2)?></label></td>
                    </tr>
                    <tr>
                        <td><label <?php echo ($sd < 0)? 'style="color:red"':'style:"color:blue"'?>>&nbsp;&nbsp;&nbsp;Saldo Disponible: $ <?php echo number_format($sd,2);?></label></td>
                        <td width="6%"></td>
                        <td><label>&nbsp;&nbsp;Promedio ponderado de dias de pago:</label></td>
                    </tr>
                      <tr>
                      <?php foreach ($statusClie as $key): 

                                $sa = $key->STATUS_COBRANZA;
                                $idm = $key->CVE_MAESTRO;
                                $cvem = $key->IDM;

                            if($key->STATUS_COBRANZA == ''){
                                $status='Al Corriente';
                            }elseif ($key->STATUS_COBRANZA == 1){
                                $status = 'Corte de Credito, con una prorroga para venta del: '.$key->INICIO_CORTE.' al '.$key->FINALIZA_CORTE.'.';
                            }
                      ?>
                        <td><label <?php echo ($sd < 0)? 'style="color:red"':'style:"color:blue"'?>>&nbsp;&nbsp;&nbsp;Status Actual del cliente: <?php echo $status;?></label></td>
                        <td width="6%"></td>
                        <td><label style="color:blue">&nbsp;&nbsp;</label></td> 
                        <?php endforeach ?>
                    </tr>
                     <tr>
                        <td><label <?php echo ($sd < 0)? 'style="color:blue"':'style:"color:blue"'?>>&nbsp;&nbsp;&nbsp;Banco de Deposito:  <?php echo $bancoDeposito;?></label></td>
                        <td width="6%"></td>
                        <td><label style="color:blue">&nbsp;&nbsp;Banco con el que el cliente paga: <?php echo $bancoOrigen;?></label></td>
                    </tr>
                    <tr>
                        <td><label <?php echo ($sd < 0)? 'style="color:blue"':'style:"color:blue"'?>>&nbsp;&nbsp;&nbsp;Metodo de Pago :  <?php echo $metodoPago;?></label></td>
                        <td width="6%"></td>
                        <td><label style="color:blue">&nbsp;&nbsp;Como Se identifica en el Edo Cta de pegaso: <?php echo $referEdo;?></label></td>
                    </tr>

                <?php endforeach; ?>
                </table>
        </div>
    </div>
</div>
<div>
<form action="index.php" method="post">
<?php foreach($datacli as $data): 
?>
<input type="hidden" value="<?php echo $data->CLAVE;?>" name="cveclie" />
<!--<button name="FacturaPago" type = "submit" value ="enviar" class="btn btn-success">Aplicar Facturas a Pago</button>-->
<!--<button name="PagoFactura" type = "submit" value ="enviar" class="btn btn-info"> Aplicar Pagos a Facturas </button>-->
<button name=<?php echo ($historico =='Si')? '"DetalleCliente"':'"SaldosxDocumentoH"'?> type="submit" value = "enviar" 
    <?php echo ($historico=='Si')? 'class="btn btn-success"':"class='btn btn-info'"?>> 
    <?php echo ($historico == 'Si')? 'Ver Facturas Pendientes':'Ver Estado de Cuenta'?> </button>

    <button class="btn btn-danger" class="cred" style="display:none;" id ="btnCorte" name = "solCorte" <?php echo ($solC > 0 or $sa==1)? "disabled='disabled'":""?> > <?php echo ($solC>0 or $sa == 1)? "En espera de Corte de Credito o en Corte de Credito":"Solicitar Corte de Credito" ?></button> 

<?php endforeach; ?>
</form>  
<br/>
<form action="index.php" method="post">
    <input type="hidden" name="idm" value = "<?php echo $cvem?>">
    <input type="hidden" name="cvem" value ="<?php echo $idm?>">
    <button class = 'btn-lg btn-warning' name="detalleMaestro"> Regresar </button>
</form>



        <br/>
              <label colspan="4" style="text-align: right; font-weight: bold; font-size: 25px">Total  $ </label>
              <label colspan="4" style="text-align: right; font-weight: bold; font-size: 25px"><div id="totales_check"> 0.00 </div></label>
              <br/>
              <br/>
              <form action="index.php" method="POST" id="FORM_ACTION">
                    <input type="hidden" name="seleccion_cr" id="seleccion_cr" value="" />
                    <input type="hidden" name="items" id="items" value="" />
                    <input type="hidden" name="total" id="total" value="" />
                    <input type="hidden" name="FORM_ACTION_PAGO_FACTURAS" value="FORM_ACTION_PAGO_FACTURAS" />
                    <input type="button" id="enviar" value="Saldar Facturas"  class="btn btn-success" />
              </form>
        <br/>
</div>


<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Movimientos al <?php echo date("d-m-Y h:i:s A")?>.
            </div>

          
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Factura <br/> Pedido Cliente</th>
                                <th>Fecha/ Hora</th>
                                <th>Documentos</th>
                                <th>Importe</th>
                                <th>Pagos</th>
                                <th>Notas de Credito</th>
                                <th>Dias</th>
                                <th>Saldo Sin Vencer</th>
                                <th>Saldo Vencido</th>
                                <th>ContraRecibo</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $vencidas = 0;
                            $corriente = 0;
                            $total = 0;
                            $pagos = 0;
                            $nc = 0;
                            $restriccion = 0;
                            $corte = 0;
                            $totalimp = 0;

                        foreach ($exec as $data):
                                $v = $data->SALDOFINAL;
                                if($data->DIAS < 0){
                                    $vencidas = $vencidas + $v;    
                                }else{
                                    $corriente = $corriente + $v;
                                }
                                $nc = $nc + $data->IMPORTE_NC;
                                $pagos = $pagos + $data->APLICADO;             
                                $total = $total + $v;
                                $totalimp = $totalimp + $data->IMPORTE;

                                $color = "";

                                if($data->DIAS <= -60 and $data->SALDOFINAL > 0){
                                    $color="style='background-color:#E3CEF6'";
                                    $corte = $corte + 1;
                                }elseif ($data->DIAS <= -45 and $data->SALDOFINAL >= 5){
                                    $color ="style='background-color:#E3CEF6'";
                                    $restriccion = $restriccion + 1; 
                                    $corte = $corte +1;
                                }elseif ($data->DIAS <= -30 and $data->SALDOFINAL >= 5) {
                                    $color = "style='background-color:#F7818B'";
                                    $restriccion = $restriccion + 1;
                                    $corte = $corte +1;
                                }elseif ($data->DIAS <= -15 and $data->SALDOFINAL >= 5) {
                                    $color="style='background-color:#F7818B'";
                                    $corte = $corte +1;
                                }elseif($data->DIAS <= -7 and $data->SALDOFINAL >= 5){
                                    $color ="style='background-color:#F6CECE'";
                                }elseif($data->DIAS > -7){
                                    $color = "";
                                    $corte = $corte +1;
                                }
                                
                        ?>
                            <tr class="odd gradex" <?php echo $color;?>>
                                <td>
                                    <input type="checkbox" name="marcar" monto="<?php echo $data->SALDOFINAL;?>" value="<?php echo $data->CVE_DOC;?>" /> 
                                </td>
                                <td><?php echo $data->CVE_DOC;?> </td>
                                <td><?php echo substr($data->FECHAELAB,0,10)?></td>
                                <td>
                                     <button name="comprobanteFletera" class="btn btn-warning"> <i class="fa fa-file-text-o"></i></button>
                                     <button name="pdf" class="btn btn-info"> <i class="fa fa-file-pdf-o"></i></button>
                                     <button name="xml" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i></button>
                                </td>
                                <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                <td align="right" style="color:#DF013A"> <?php echo '$ '.number_format($data->APLICADO,2);?></td>
                                <td align="right" style="color:#DF013A"><?php echo '$ '.number_format($data->IMPORTE_NC,2)?></td>
                                <td align="center"> <?php echo $data->DIAS?> </td>
                                <td align="right" style="color:blue">$ <?php echo ($data->DIAS >= 0)? number_format($data->SALDOFINAL,2):"0.00"?></td>
                                <td align="right" <?php echo ($data->SALDOFINAL > 3)? 'style="color:red"':'style="color:#0101DF"'?>><b>$ <?php echo ($data->DIAS < 0 )? number_format($data->SALDOFINAL,2):"0.00";?></b></td>
                                <td><?php echo $data->CONTRARECIBO_CR;?></td>
                            </tr>
                                <td></td>
                                <td><?php echo $data->PEDIDO?></td>
                                <td><?php echo substr($data->FECHAELAB, 11,9)?></td>
                                <td></td>
                                <td></td>
                                <td style="color:#DF013A"><?php echo $data->INFO_PAGO?></td>
                                <td style="color:#DF013A"><?php echo $data->NC_APLICADAS?></td>
                                <td></td>
                                <td></td>

                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <td>
                                <input type="hidden" name="text" value=<?php echo $restriccion?> id ="restric" >
                                <input type="hidden" name="cort" value=<?php echo $corte?> id = "cort" >
                            </td>
                            <td align="right" style="color:red; font-weight: bold; font-size: 25px"  >Totales:</td>
                            <td></td>
                            <td></td>
                            <td align="right" style="font-size: 20px"> <b><?php echo '$ '.number_format($totalimp,2)?></b></td>
                            <td align="right" style="font-size: 20px; color:red;"><?php echo '$ '.number_format($pagos,2)?></td>
                            <td align="right" style="font-size: 20px; color:red;"><?php echo '$ '.number_format($nc,2)?></td>
                            <td></td>
                            <td align="right" style="font-size: 20px; color:blue;"><?php echo '$ '.number_format($corriente,2)?></td>
                            <td align="right" style="font-size: 20px; color:red;"><?php echo '$ '.number_format($vencidas,2)?></td>
                        </tfoot>

                    </table>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>

    var total = parseFloat("0");
    var seleccionados = parseInt("0");
    
    $("input[type=checkbox]").on("click", function(){
        var monto = $(this).attr("monto");
        //alert('Monto Seleccionado' + monto);
        monto = monto.replace("$", "");
        monto = monto.replace(",", "");     
        monto = parseFloat(monto);        
        
        if(this.checked){
            total+=monto;
        } else {
            total-=monto;
        }
        //alert("Total: "+total);
        $("#totales_check").text(total);
        seleccionados = $("input:checked").length;
        $("#seleccion_cr").val(seleccionados);
        $("#total").val(total);
    });


    $("#enviar").click(function (){
        var items = $("#items");
        var folios = "";
        $("input:checked").each(function(index){
            folios+= this.value+",";
        });
        folios = folios.substr(0, folios.length-1);
        console.log("FOLIOS: "+folios);
        items.val(folios);       
        $("#FORM_ACTION").submit();
    });

    window.onload=function(){
        //var r = document.getElementById('restric').value;
        var c = document.getElementById('cort').value;
    //alert('cargo js' + c);
    if(c > 0){
         alert('El cliente tiene documentos con vencimiento de mas de 7 dias, se puede solicitar el corte de credito');
      document.getElementById('btnCorte').style.display='inline';
    }
  }
  

    /// Codigo para ver los contactos.
    /*document.getElementById("contactos").addEventListener("click",function(){
        var id = document.getElementById("clave");
        var link = "index.php?action=ContactosCliente&cliente="+id.value;
        myWindow = window.open(link, "", "width=550, height=600");
    });
    }*/

</script>