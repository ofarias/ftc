<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Recepciones de &oacute;rdenes de compra
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-oc-recepciones">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
<!--                                <th>FOLIO</th>-->
                                <th>RECEPCION</th>
                                <th>OC</th>
                                <th>FACTURA</th>
                                <th>PROVEEDOR</th>
                                <th>PROMESA PAGO</th>
                                <th>IMPORTE</th>
                                <th>F. RECEPCION</th>                                
                            </tr>
                        </thead>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td colspan="4" style="text-align: right;font-weight: bold">Total</td>
                        <td><div id="totales_check"> 0.00</div></td>
                        <td>
                            <form action="index.php" method="POST" id="FORM_ACTION">
                                <input type="hidden" name="seleccion_cr" id="seleccion_cr" value="" />
                                <input type="hidden" name="items" id="items" value="" />
                                <input type="hidden" name="total" id="total" value="" />
                                <input type="hidden" name="FORM_ACTION_CR_PAGO" value="FORM_ACTION_CR_PAGO" />
                                <input type="button" id="enviar" value="Realizar pago" class="btn btn-success" />
                            </form>
                        </td>
                        </tfoot>
                        <tbody>
                            <?php
                            if ($exec != null) {
                                foreach ($exec as $data):
                                    ?>
                                    <tr class="odd gradeX">
                                        <td>
                                            <input type="checkbox" name="marcar" monto="<?php echo $data->MONTOR;?>" value="<?php echo $data->FOLIO;?>" />&nbsp;CRP<?php echo $data->FOLIO;?>&nbsp;
                                        </td>
        <!--                                        <td><?php echo $data->FOLIO; ?></td>-->
                                        <td><?php echo $data->RECEPCION; ?></td>
                                        <td><?php echo $data->OC;?></td>
                                        <td><?php echo $data->FACTURA;?></td>
                                        <td><?php echo $data->BENEFICIARIO; ?></td>
                                        <td><?php echo $data->PROMESA_PAGO; ?></td>
                                        <td><?php echo "$ " . number_format($data->MONTOR, 2, '.', ','); ?></td>
                                        <td><?php echo $data->FECHA_IMPRESION; ?></td>
                                    </tr>                                
                                    <?php
                                endforeach;
                            } else {
                                ?>                               
                                <tr class="odd gradeX">
                                    <td colspan="6">No hay datos</td>
                                </tr>
                                <?php
                            }
                            ?>
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
        alert('Monto Seleccionado' + monto);
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
