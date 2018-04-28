
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Productos de la Preorden de compra.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Costo <br/> Unitario Bruto </th>
                                            <th>Costo <br> Total Bruto</th>
                                            <th>Valor IVA</th>
                                            <th>Costo Neto</th>
                                            <th>Unidad <br/> de Medida </th>
                                            <th>Clave <br/> Proveedor</th>
                                            <th>Identificador <br/> Unico Ventas</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 

                                            $subtotal = 0;
                                            $iva = 0;
                                            $total =0;
                                        foreach ($detalle as $data):
                                            $ids=$data->ID;
                                            $subtotal = $subtotal +  ($data->COSTO_TOTAL);
                                            ?>
                                        <tr title="<?php echo 'Cliente del Pedido: '.$data->CLIENTE.' de la cotizacion '.$data->COTIZACION.' con Fecha del '.$data->FECHASOL?>">
                                            <td align="center">
                                                    <?php echo $data->PARTIDA;?> <br/> 
                                            </td>
                                            <td><?php echo $data->ART?></td>
                                            <td><?php echo $data->DESCRIPCION?></td>
                                            <td>
                                                <input name="cantidadn" type = "number" step="any" value = "<?php echo $data->CANTIDAD ;?>" onchange="totales(this.value, costo.value)" min="1" max="<?php echo $data->CANTIDAD?>" id="cantoriginal">
                                                <input name="canto" type="hidden" value="<?php echo $data->CANTIDAD?>" id="canto">
                                            </td>
                                            <td align="right">
                                            <input name='coston' type="number" step="any" value="<?php echo $data->COSTO;?>" id="costo" onchange="totales(cantoriginal.value, this.value)" readonly>
                                            </td>
                                            <td align="right"><input type="text" name="costoTotal" value="<?php echo '$ '.number_format($data->COSTO_TOTAL,2);?>" disabled="disabled" id="costot"> </td>
                                            <td align="right"><input type="text" name="ivaTotal" value="<?php echo '$ '.number_format(($data->COSTO_TOTAL*.16),2);?>" disabled = "disabled" id="ivat"> </td>  
                                            <td align="right"><input type="text" name="costoNeto" value="<?php echo '$ '.number_format($data->COSTO_TOTAL*1.16,2)?>" id="costonet" disabled="disabled"> </td>      
                                            <td><?php echo $data->UM?></td>
                                            <td><?php echo $data->CVE_PROD?></td>
                                            <td><?php echo $data->IDPREOC?></td>     
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idd" value="<?php echo $idd?>" >
                                                <button name="eliminaPartidaPreoc" type="submit" value="enviar"  onclick="Elimiar()" > Eliminar Partida</button>
                                            </form>
                                                </td>                                 
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">SubTotal</td>
                                            <td align="right">
                                                    <input type="text" name="costoTotal2" value="<?php echo '$ '.number_format($subtotal,2)?>" disabled="disabled" id="aaa">
                                            </td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">IVA</td>
                                            <td align="right">
                                               <input type="text"  name="iva2" value="<?php echo '$ '.number_format($subtotal*.16,2)?>" id="bbb" disabled="disabled"> </td>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idd" value="<?php echo $idd?>" >
                                                <input type="hidden" name="new_cant" id="newCant" value ="">
                                                <input type="hidden" name="new_cost" id="newCost" value ="">
                                                <button class="btn btn-success" id="btnSave" name="editaPartidaPreOC" type="submit" value ="enviar" onclick="ocultar()"> Guardar </button>
                                            </form>
                                            
                                            </td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td> 
                                            </td>
                                            <td></td>
                                            <td align="right">Total</td>
                                            <td align="right">
                                               <input type="text" name="total2" value="<?php echo '$ '.number_format($subtotal*1.16,2)?>" id='ccc' disabled="disabled"></td>
                                     </tr>
                                 </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<script type="text/javascript">

    function totales(cant, costo){

        //alert('cantidad '+cant+' costo '+costo );
        var canto = document.getElementById('canto').value;
        var coston = parseFloat(cant,2) * parseFloat(costo,2);
        document.getElementById('ivat').value='$ ' + (coston*.16).toFixed(2);
        document.getElementById('costot').value='$ ' + coston.toFixed(2);
        document.getElementById('costonet').value = '$ ' + (coston*1.16).toFixed(2); 
        document.getElementById('aaa').value = '$ ' + (coston).toFixed(2);
        document.getElementById('bbb').value ='$ '+ (coston*.16).toFixed(2);
        document.getElementById('ccc').value='$ '+ (coston*1.16).toFixed(2);
        if(parseFloat(cant,2) > parseFloat(canto,2)){
            alert('No es posible solicitar de mas, si es necesario elimine la partida y genere una nueva Pre Orden de Compra.');
            document.getElementById('btnSave').classList.add('disabled');
        }else if(parseFloat(cant,2) <=0){
            alert('La cantidad debe ser mayor a 0.');
            document.getElementById('btnSave').classList.add('hide');
        }else{
            document.getElementById('newCost').value=costo;
            document.getElementById('newCant').value=cant;
            document.getElementById('btnSave').classList.remove('disabled');
            document.getElementById('btnSave').classList.remove('hide');
        }
    }
    
    function Elimiar(){
        alert('La Partida se eliminara de la Pre Orden, debera actualizar para que los cambios se vean afectados');
    }   

    function ocultar(){
        document.getElementById('btnSave').classList.add('hide');
    }

</script>
