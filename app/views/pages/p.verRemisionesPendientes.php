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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-remisionesPendientes">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            
                                            <th>Remision</th>
                                            <th>Fecha Remision</th>
                                            <th>Cliente</th>
                                            <th>Pedido Cliente</th>
                                            <th>Pedido Pegaso</th>
                                            <th>Importe</th>
                                            <th>Factura</th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $TOTAL= 0;
                                        foreach ($remisiones as $data): 
                                            $TOTAL=$TOTAL + $data->IMPORTE;

                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=detalleRemision&docf=<?php echo $data->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td align="center"><?php echo $data->PEDIDO?></td>
                                            <td align="center"><?php echo $data->PEDIDOPEGASO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2)?></td>
                                            <td><?php echo $data->FACTURA?></td>
                                          </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label><font size="15px">TOTAL PENDIENTE POR FACTURAR:</font> &nbsp;  &nbsp;  &nbsp; <font color="blue" size="20px"><b><?php echo '$ '.number_format($TOTAL,2)?></b></font></label>
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