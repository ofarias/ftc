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
                                            <th>Seleccionar</th>
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
                                            <td><input type="checkbox" name="marcar" monto="<?php echo $key->SALDOFINAL;?>" value="<?php echo $key->CVE_DOC;?>" /> </td>
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

   
</script>