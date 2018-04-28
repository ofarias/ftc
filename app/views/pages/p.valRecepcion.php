<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>RFC</th>
                                            <th>Descuento <br/> Financiero</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($recepciones as $data):
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->ORDEN;?></td>
                                            <td><?php echo $data->FECHAELAB?></td>
                                            <td><?php echo '('.$data->CVE_PROV.') '.$data->NOMBRE?></td>
                                            <td><?php echo $data->RFC?></td>
                                            <td><input type="number" name="descf" id="descfing" value = "0" onchange="actPrecio()" ></td>              
                                        </tr>
                                 </tbody>
                                 <?php endforeach; ?>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Productos de la Orden de compra.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                           
                                            <th>Descripcion <br/> Clave Prov</th>
                                            <th>Cantidad <br/> Orden</th>
                                            <th>Pendiente <br/> Orden </th>
                                            <th>Costo <br/> Unitario Bruto </th>
                                            <th>Costo <br> Total Bruto</th>
                                            <th>Valor IVA</th>
                                            <th>Costo Neto</th>
                                            <th>Unidad <br/> de Medida </th>
                                            <th>Identificador <br/> Unico Ventas</th>
                                            <th>Cantidad <br/> Recepcion</th>
                                            <th>Precio <br/> Lista</th>
                                            <th>Desc 1 <br/> % <br/> $ </th>
                                            <th>Desc 2 <br/> % <br/> $ </th>
                                            <th>Desc 3 <br/> % <br/> $ </th>
                                            <th>Desc Fin <br/> % <br/> $ </th>
                                            <th>Costo Total <br/> x Unidad </th>
                                            <th>Costo Total <br> x Partida</th>
                                            <th>Finalizar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $subtotal = 0;
                                            $iva = 0;
                                            $total =0;
                                            $i = 0;
                                        foreach ($orden as $data):
                                            $i=$i +1;
                                            $subtotal = $subtotal +  (($data->COSTO*$data->CANT_RECIBIDA) * 1.16);
                                            $color ='';
                                            $val='';
                                            if($data->CANT_RECIBIDA == 0){
                                                $color = "style='background-color:#ffc2b3'";
                                            }elseif ($data->CANT_RECIBIDA < $data->CANTIDAD) {
                                                $color ="style= 'background-color:#b3ffff'";
                                            }elseif ($data->CANT_RECIBIDA == $data->CANTIDAD) {
                                                $color = "style= 'background-color:#d9ffb3'";
                                            }

                                            if(!empty($data->PRECIO_LISTA) and $data->VAL_PART  == 0 ){
                                                $color = "style='background-color:#E6E0F8'";
                                                $val = 'Autorizacion de Costo';
                                            }

                                            ?>
                                        <tr title="<?php echo 'Cliente del Pedido: '.$data->CLIENTE.' de la cotizacion '.$data->COTIZACION.' con Fecha del '.$data->FECHASOL.' Cantidad Original Ventas :'.$data->CANT_ORIG ?>" class="odd gradeX" <?php echo $color;?>>
                                            <input type="hidden" name="parR" id="parReal_<?php echo $i?>" value="<?php echo $data->PARTIDA?>">

                                            <td align="center"><?php echo $data->PARTIDA?> <br/> <?php echo $val?></td>
                                        
                                            <td><?php echo $data->ART?> <br/><?php echo $data->DESCRIPCION?><br/> <?php echo $data->CVE_PROD?></td>
                                            <td><?php echo $data->CANTIDAD ;?></td>
                                            <td><?php echo $data->PXR?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO * $data->CANTIDAD,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->COSTO *$data->CANTIDAD ) * .16,2);?></td>  
                                            <td align="right"><font color="red"> <?php echo '$ '.number_format( ($data->COSTO * $data->CANTIDAD)*1.16,2)?></font>
                                            
                                            <input type="hidden" name="cnet" readonly="readonly" value="<?php echo (($data->COSTOO * $data->CANTIDAD)*1.16)?>" id="costnet_<?php echo $data->PARTIDA?>"> </td>      
                                            
                                            <td><?php echo $data->UM?></td>
                                          
                                            <td><a href="index.php?action=historiaIDPREOC&id=<?php echo $data->IDPREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <?php echo $data->IDPREOC?></a></td>
                                            <form action="index.php" method="post">

                                            <td><?php echo $data->CANT_RECIBIDA?></td>
                                            <td>
                                                <input type="number" name="precioLista" step="any" max="99999999" required="required" min="0" onkeypress="return pulsar(event)" onchange="actPrecio(<?php echo $data->PARTIDA?>)" id="pl_<?php echo $data->PARTIDA?>" value="<?php echo (empty($data->PRECIO_LISTA))? 0:$data->PRECIO_LISTA?>">
                                                <br/> Precio de Lista Costo:
                                                <br/><?php echo '$ '.number_format($data->PRECIOO,2)?>
                                            </td> 
                                            <td>
                                                <input type="number" name="desc1" step="any" min="0" max="100" value="<?php echo (empty($data->DESC1))? '0':$data->DESC1 ?>" id="desc1_<?php echo $data->PARTIDA?>" onchange="actPrecio(<?php echo $data->PARTIDA?>)"> 
                                                <br/> <input type="text" name="desc1M" id="desc1m_<?php echo $data->PARTIDA?>" readonly="readonly" value="<?php echo (empty($data->DESC1_M))? 0:$data->DESC1_M ?>" maxlenght="5">
                                                <br/><?php echo $data->DESCO1.' %'?>
                                            </td>
                                            <td><input type="number" name="desc2" step="any" min="0" max="100" value="<?php echo (empty($data->DESC2))? '0':$data->DESC2 ?>" id="desc2_<?php echo $data->PARTIDA?>" onchange="actPrecio(<?php echo $data->PARTIDA?>)">
                                                <br/> <input type="text" name="desc2M" id="desc2m_<?php echo $data->PARTIDA?>" readonly="readonly" value="<?php echo (empty($data->DESC2_M))? 0:$data->DESC2_M ?>" maxlenght="5">
                                                <br/><?php echo $data->DESCO2.' %'?>
                                            </td>
                                            <td><input type="number" name="desc3" step="any" min="0" max="100" value="<?php echo (empty($data->DESC3))? '0':$data->DESC3 ?>" id="desc3_<?php echo $data->PARTIDA?>" onchange="actPrecio(<?php echo $data->PARTIDA?>)">
                                            <br/> <input type="text" name="desc3M" id="desc3m_<?php echo $data->PARTIDA?>" readonly="readonly" value="<?php echo (empty($data->DESC3_M))? 0:$data->DESC3_M ?>" maxlenght="5">
                                                <br/><?php echo $data->DESCO3.' %'?>
                                            </td>
                                            <td><input type="number" name="descf" step="any" min="0" max="100" value="<?php echo (empty($data->DESCF))? '0':$data->DESCF?>" id="descFin_<?php echo $data->PARTIDA?>" onchange="actPrecio(<?php echo $data->PARTIDA?>)" readonly="readonly">
                                                <br/> <input type="text" name="descfM" id="descfm_<?php echo $data->PARTIDA?>" readonly="readonly" value="<?php echo (empty($data->DESCF_M))? 0:$data->DESCF_M ?>" maxlenght="5">
                                                <br/><?php echo $data->DESCOF.' %'?>
                                            </td>
                                            <td>
                                                <input type="number" name="totalCosto" max="99999999" min="0" readonly="readonly" value = "<?php echo (empty($data->TOTAL_COSTO_UNITARIO))? 0:$data->TOTAL_COSTO_UNITARIO?>" id="ctotal_<?php echo $data->PARTIDA?>"  >
                                            </td>
                                            <td>
                                                <input type="text" name="totalPartida" maxlength="10" readonly="readonly" value="<?php echo (empty($data->TOTAL_COSTO_PARTIDA))? 0:$data->TOTAL_COSTO_PARTIDA?>" id="ctotpar_<?php echo $data->PARTIDA?>"> 
                                                <br/> IVA: <input type="text" name="totIvaPar" max="10" readonly="readonly" value="<?php echo (empty($data->TOTAL_COSTO_PARTIDA))? 0:number_format($data->TOTAL_COSTO_PARTIDA/1.16,2)?>" id="totIvaP_<?php echo $data->PARTIDA?>">
                                                <br/> <font color="red">Total:<input type="text" name="totCostPar" max="10" readonly="readonly" value="<?php echo (empty($data->TOTAL_COSTO_PARTIDA))? 0:number_format($data->TOTAL_COSTO_PARTIDA * 1.16,2)?>"  id ="totCostP_<?php echo $data->PARTIDA?>"></font>
                                            </td>
                                            <td>
                                                <input type="hidden" name="cantidad" value="<?php echo $data->CANT_RECIBIDA?>" id="cant_<?php echo $data->PARTIDA?>" >
                                                <input type="hidden" name="idp" value="<?php echo $data->IDPREOC?>" id="idp_<?php echo $data->PARTIDA?>">
                                                <input type="hidden" name="doco" value="<?php echo $doco?>" id="doco_<?php echo $data->PARTIDA?>">
                                                <input type="hidden" name="partida" value="<?php echo $data->PARTIDA?>"  >
                                                <input type="button" name="recibirParOC" value="Recibir" class="hide" id="btnR_<?php echo $data->PARTIDA?>" onclick="recibir(<?php echo $data->PARTIDA?>)">
                                                <br/>
                                                <button value="enviar" type="submit" name="solAutCostos" class="hide" id="btnS_<?php echo $data->PARTIDA?>"> Solicitar Autorizacion Costos</button>
                                            </td> 
                                            </form> 

                                              <input type="hidden" name="cants" value=<?php echo $data->CANT_RECIBIDA?> id="cants_<?php echo $i?>">

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <tfoot>
                                     <tr>
                                            <input type="hidden" name="iterador" value="<?php echo $i?>" id="partidas">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">SubTotal Recibido</td>
                                            <td align="right"><?php echo '$ '.number_format($subtotal,2)?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>SubTotal Validado</td>
                                            <td><input type="tex" name="subtot" value="0" id="subtotval"></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">IVA</td>
                                            <td align="right"><?php echo '$ '.number_format($subtotal*.16,2)?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Desc Validado</td>
                                            <td><input type="tex" name="subtot" value="0" id="descval"></td>
                                     
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">Total</td>
                                            <td align="right"><?php echo '$ '.number_format($subtotal*1.16,2)?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">Desc Financiero</td>
                                            <td align="right"><input type="tex" name="subtot" value="0" id="descfval"></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">IVA </td>
                                            <td align="right"><input type="tex" name="subtot" value="0" id="ivaval"></td>
                                     </tr>
                                     <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">TOTAL </td>
                                            <td align="right"><input type="tex" name="subtot" value="0" id="totalval"></td>
                                     </tr>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />
<div>
    <form action="index.php" method="post" id="form1">
    <input type="hidden" name="doco" value="<?php echo $doco?>" id="docoimp">
    <label <?php echo ($cierre==0)? "title='Se genera la validacion'":"title='El boton se habilitara hasta que todo tenga valor en la columna recibido.'"?> >
     <button name="cerrarValidacion" value="enviar" type="submit" <?php echo ($cierre == 0)? '':"disabled"?>  class="btn btn-info" id="btnCerrar"> Cerrar Validacion de Costos </button>
     <button name="cancelaValidacionRecepcion" value="enviar" type="submit" > Cancelar </button>
     </label>
    </form>
</div>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

$(document ).ready(subTotales);
    function subTotales(){
      //  alert('Entro desde la actualizacion');
        var par = document.getElementById('partidas').value;
        var subrec = 0;
            var descv = 0
            var ivav = 0;
            var totv = 0;
            var descfing = parseFloat(document.getElementById('descfing').value,2);

         for (var i = 1 ; i <= par; i++) {
        //        alert('entro'+ par + 'entro al for');
                var parr = document.getElementById('parReal_' + i).value;
                var cant2 = parseFloat(document.getElementById('cant_'+parr).value,2);
                var pl2 = parseFloat(document.getElementById('ctotpar_'+parr).value,2);
                var desc1s = parseFloat(document.getElementById('desc1m_'+parr).value,2)*cant2;
                var desc2s = parseFloat(document.getElementById('desc2m_'+parr).value,2)*cant2;
                var desc3s = parseFloat(document.getElementById('desc3m_'+parr).value,2)*cant2;
                var descfs = parseFloat(document.getElementById('descfm_'+parr).value,2)*cant2;
                subrec = subrec + (pl2 + (desc1s + desc2s + desc3s + descfs));
                descv = descv + ((desc1s + desc2s + desc3s + descfs));
                //alert('Total descuentos: '+ descv);
                //alert ('Total descuento: '+ descv);
            }

                ivav = parseFloat((subrec - descv) * 0.16,2);
                totv = parseFloat((subrec - descv)  * 1.16,2);
            document.getElementById('subtotval').value = subrec.toFixed(2);
            document.getElementById('descval').value = descv.toFixed(2);
            document.getElementById('ivaval').value = ivav.toFixed(2);
            document.getElementById('totalval').value= totv.toFixed(2);
    }

    function actPrecio(id){
        var par = document.getElementById('partidas').value;
        var subrec = 0;
        var descv = 0
        var ivav = 0;
        var totv = 0;
        var descfing = parseFloat(document.getElementById('descfing').value,2);

        var pl = document.getElementById('pl_'+id).value;
        var desc1 = document.getElementById('desc1_'+id).value / 100;
        var desc2 = document.getElementById('desc2_'+id).value / 100;
        var desc3 = document.getElementById('desc3_'+id).value / 100;
        var descFin = document.getElementById('descFin_'+id).value / 100;
        var cant = document.getElementById('cant_'+id).value;
        var cnet = document.getElementById('costnet_'+id).value;
        var variacion = cnet * .30; 
        var vartot = parseFloat(cnet,2) + parseFloat(variacion,2); 
        var CTotal= 0;

        desc1 = pl * desc1;
        sub1 = pl - desc1;
        desc2 = sub1 * desc2;
        sub2 = sub1 - desc2;
        desc3 = sub2 * desc3;
        sub3 = sub2 - desc3;
        descFin = sub3 * descFin;
        sub4 = sub3 - descFin;
        CTotal = pl - desc1 - desc2 - desc3 - descFin; 
        ctotpar = CTotal * cant;
        totIP= ctotpar * 0.16;
        totCP = ctotpar *1.16;
        document.getElementById('ctotal_'+id).value=CTotal.toFixed(2);
        document.getElementById('desc1m_'+id).value=desc1.toFixed(2);
        document.getElementById('desc2m_'+id).value=desc2.toFixed(2);
        document.getElementById('desc3m_'+id).value=desc3.toFixed(2);
        document.getElementById('descfm_'+id).value=descFin.toFixed(2);
        document.getElementById('ctotpar_'+id).value=ctotpar.toFixed(2);
        document.getElementById('totIvaP_'+id).value=totIP.toFixed(2);
        document.getElementById('totCostP_'+id).value=totCP.toFixed(2);
        document.getElementById('btnS_'+id).classList.add('hide');
        document.getElementById('btnR_'+id).classList.remove('hide');


                //// Calculo de subtotales y descuentos.
        for (var i = 1 ; i <= par; i++) {
            var parr = document.getElementById('parReal_' + i).value;
            var totpar = parseFloat(document.getElementById('pl_'+parr).value,2);
            var desc1m=parseFloat(document.getElementById('desc1m_'+parr).value,2);
            var desc2m=parseFloat(document.getElementById('desc2m_'+parr).value,2);
            var desc3m=parseFloat(document.getElementById('desc3m_'+parr).value,2);
            var descfm=parseFloat(document.getElementById('descfm_'+parr).value,2);
            var cant = parseFloat(document.getElementById('cant_'+parr).value,2);
            descv = descv + (cant * (desc1m + desc2m + desc3m + descfm));  
            subrec = subrec + (cant * totpar);
        }

            ivav = parseFloat((subrec - descv) * 0.16,2);
            totv = parseFloat((subrec - descv)  * 1.16,2);

        document.getElementById('subtotval').value = subrec.toFixed(2);
        document.getElementById('descval').value = descv.toFixed(2);
        document.getElementById('ivaval').value = ivav.toFixed(2);
        document.getElementById('totalval').value= totv.toFixed(2);

    } 
  
    function pulsar(e) { 
        tecla = (document.all) ? e.keyCode :e.which; 
         return (tecla!=13); 
    } 

    function recibir(i){
        alert('Recibir partida: '+ i);

        var idp = document.getElementById("idp_"+i).value;
        var cantidad = document.getElementById("cant_"+i).value;
        var doco = document.getElementById("doco_"+1).value;
        var partida = i;
        var desc1 = document.getElementById("desc1_"+i).value;
        var desc2 = document.getElementById("desc2_"+i).value;
        var desc3 = document.getElementById("desc3_"+i).value;
        var descf = document.getElementById("descFin_"+i).value;
        var desc1M = document.getElementById("desc1m_"+i).value;
        var desc2M = document.getElementById("desc2m_"+i).value;
        var desc3M = document.getElementById("desc3m_"+i).value;
        var descfM = document.getElementById("descfm_"+i).value;
        var precioLista = document.getElementById("pl_"+i).value;
        var totalCosto = document.getElementById("ctotal_"+i).value;
        var totalPartida = document.getElementById("totCostP_"+i).value;

        if(confirm('Desea guardar los valores?')){
            alert('Se guardo');
            $.ajax({
                url:'index.php',
                method:'POST',
                dataType:'json',
                data:{recibirParOC:1, idp:idp, cantidad:cantidad, doco:doco, partida:partida, desc1:desc1, desc2:desc2, desc3:desc3, descf:descf, desc1M:desc1M, desc2M:desc2M,desc3M:desc3M,descfM:descfM, precioLista:precioLista, totalCosto:totalCosto, totalPartida:totalPartida},
                success:function(data){
                    if(data.status == 'ok'){
                        alert('Se guardo la informacion');
                        if(data.cierre == 0){
                            alert('Ahora se puede cerrar la validacion');
                            document.getElementById("btnCerrar").disabled=false;         
                        }
                    }else{
                        alert('no se pudo guardar la informacion favor de revisar');
                    }
                }
            })
        }    
    }



</script>
