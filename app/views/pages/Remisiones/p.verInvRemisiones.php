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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-remisiones">
                                    <thead>
                                        <tr> 
                                            <th>Remision</th>
                                            <th>Nombre</th>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Costo</th>
                                            <th>Diferencia</th>
                                            <th>Total sin IVA</th>
                                            <th>Total Partida </th>
                                          <!--  <th>Comprobante</th>-->
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                            $total = 0;
                                            $totalVenta = 0;
                                        foreach ($remisiones as $data): 
                                            $total = $total + $data->COSTO_TOTAL;
                                            $totalVenta = $totalVenta + ($data->PRECIO * $data->CANTIDAD); 
                                            $color = '';
                                            $color2 = 'red';
                                            if ($data->COSTOS > $data->PRECIO){
                                                $color = "style= 'background-color:red'";
                                                $color2 = "white";
                                            }
                                            $Diferencia = $data->PRECIO - $data->COSTOS;
                                        ?>
                                       <tr  class="odd gradeX" <?php echo $color?>>
                                            <td><a href="index.php?action=detalleRemision&docf=<?php echo $data->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->PRODUCTO?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td align="center"><?php echo $data->CANTIDAD?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTOS,2);?> <br/> <font color = "<?php echo $color2?>"> <?php echo '$ '.number_format($data->PRECIO,2)?></font></td>
                                            <td align="right"><?php echo '$ '.number_format($Diferencia)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->CANTIDAD * $data->COSTOS),2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO_TOTAL)?></td>
                                          </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                                      <div>
                <h1>TOTAL COSTO <font color = 'blue'><?php echo number_format($total,2)?></font> <br/>
                    TOTAL VENTA <font color = 'red'><?php echo number_format($totalVenta,2)?></font>
                </h1>
            </div>
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