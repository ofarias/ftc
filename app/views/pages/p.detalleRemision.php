<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Remisiones Pendientes de Facturar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            
                                            <th>Remision</th>
                                            <th>Partida</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Pendiente x Facturar</th>
                                            <th>Precio</th>
                                            <th>Total sin IVA</th>
                                            <th>Total Partida </th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($remision as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td align="center"><?php echo $data->CANT?></td>
                                            <td align="center"><?php echo $data->PXS?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PREC,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->PXS * $data->PREC),2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->TOT_PARTIDA + $data->TOTIMP4)?></td>
                                          </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<script>

document.addEventListener("DOMContentLoaded",function(){
    var fac = document.getElementsByName("factura");
    var boton = document.getElementsByName("asociarFactura");
    var up = document.getElementsByName("archivo"); //uploadfile
    var botonup = document.getElementsByName("comprobanteCaja");
        var xmlfile = document.getElementsByName("xmlfile");
    var cuentaCajas = 0;
    var cuentaUp = 0;   //uploadfile
    for(contador = 0; contador < fac.length; contador++){
        if(fac[contador].value == ""){
            //boton[contador].disabled = true;
            //botonup[contador].disabled = true;
            //fac[contador].readOnly = true;
        }else{
            //boton[contador].disabled = false;
            //fac[contador].readOnly = true;
            cuentaCajas += 1;
        }
        
        if(up[contador].value != ""){   //uploadfile
            cuentaUp += 1;
        }                               //uploadfile
        
        if(xmlfile[contador].value != ""){
            document.getElementsByName("xml")[contador].type = 'text';
            document.getElementsByName("xml")[contador].readOnly = true;
            document.getElementsByName("xml")[contador].value = xmlfile[contador].value;
            document.getElementsByName("xmlFactura")[contador].disabled=true;
            cuentaXml += 1;
        }

        //if(fac[contador].value != "" && up[contador].value == ""){
        //    botonup[contador].disabled = false;
        //}
    }


});

document.getElementById("imprimir").addEventListener("click",function(){
    setTimeout(function(){ window.location.reload(); }, 1000);  
});

/*function validarTextBox(texto,boton1,boton2){
    //alert(texto+boton1+boton2);
    if(texto.length > 5){
        document.getElementById(boton2).disabled = false;
        document.getElementById(boton1).disabled = false;
    }else if(texto.length < 5){
        document.getElementById(boton2).disabled = true;
        document.getElementById(boton1).disabled = true;
    }
}*/

</script>