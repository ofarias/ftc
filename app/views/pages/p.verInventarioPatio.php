<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Listado de Recepciones de &oacute;rdenes de compra
            </div>
            <div class="panel-body">             
                <div class="table-responsive">  
                    <table class="table table-striped table-bordered table-hover" id="dataTables-inventarioBodega">
                        <thead>
                            <tr>   
                                <th>Producto</th>
                                <th>Descripcion</th>
                                <th>Pedido</th>
                                <th>Proveedor</th>
                                <th>Recibido</th>
                                <th>Empacado</th>
                                <th>En Bodega</th>
                                <th>Fisico</th>
                                <th>Unidad</th>
                                <th>Costo Unitario</th>
                                <th>Costo Total</th>
                                <th>Validar</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                foreach ($inventario as $data):
                                    if($data->PROCESADO > 0 ){
                                        $color = "style='background-color:green;'";
                                    }else{
                                        $color = '';
                                    }
                                    $OCS = str_replace(',', '<br/>', $data->OC);
                                    $i++;
                            ?>
                                    <tr class="odd gradeX"  id="tr_<?php echo $i?>" <?php echo $color?>>
                                        <td><a href="index.php?action=verMovInventario&producto=<?php echo $data->PROD?>" target="blank"><?php echo $data->PROD.'<br/>'.$data->ID?></a> <br/> <?php echo  ($OCS); ?></td>
                                        <input type="hidden" name="idpreo" id="idpreoc_<?php echo $i?>" value="<?php echo $data->ID?>" >
                                        <input type="hidden" name="canto" id="canto_<?php echo $i?>" value="<?php echo $data->RECEPCION?>">
                                        <input type="hidden" name="prod" id="prod_<?php echo $i?>" value="<?php echo $data->PROD?>">
                                        <td><?php echo $data->NOMPROD; ?></td>
                                        <td><?php echo $data->COTIZA?></td>
                                        <td><?php echo $data->NOM_PROV?></td>
                                        <td><?php echo $data->RECEPCION?> <br/><font color="blue">Original : <?php echo $data->CANT_ORIG?></font></td>
                                        <td><?php echo $data->EMPACADO?></td>
                                        <td><?php echo $data->RECEPCION -$data->EMPACADO?></td>
                                        <td><input name= "cantidad" type="text" value="<?php echo $data->RECEPCION -$data->EMPACADO;?>" min="0.001" class="conteo" original="<?php echo $data->RECEPCION-$data->EMPACADO?>" info="<?php echo $data->ID.':'.($data->RECEPCION-$data->EMPACADO).':'.$data->PROD.':'.(($data->COSTO*1.23) * 1.16).':'.$data->COTIZA?>"  onchange="revisar(<?php echo $i?>)" id="cantf_<?php echo $i?>" size="8" > </td>
                                        <td><input type="text" name="unidad" placeholder="Unidad de Medida" value="<?php echo $data->UM;?>" disabled="disabled" size='5'></td>
                                        <td align="right"><input type="text" size="8" name="costo" placeholder="<?php echo (($data->COSTO*1.23) * 1.16)?>" value="<?php echo (empty($data->COSTO))? '0':(($data->COSTO*1.23) * 1.16); ?>"  disabled="disabled" /> </td>
                                        <td><?php echo (empty($data->COSTO))? '0':'$ '.number_format(((($data->COSTO*1.23) * 1.16) * ($data->RECEPCION -$data->EMPACADO)),2); ?></td>
                                        <td>
                                            <input type="button" name="Revisado" value="Revisar" onclick="revisar(<?php echo $i?>)" id="boton_<?php echo $i?>" >
                                            
                                        </td>
                                    </tr>
                                <?php endforeach?>
                           </tbody>
                    </table>
                </div>

                                   <div>
                    <?php if($usuario == 'Alejandro Perla'){?>
                    <button class="btn btn-danger" onclick="quitarCaja()" > Quitar Caja</button>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>


 <input type="hidden" name="caja" id="caja" value=<?php echo $caja?> >



<form action="index.php" method="POST" id="formCierre">
    <input type="hidden" name="cierreInvPatio" value="">
    <input type="hidden" name="datos" value="" id="datosCierre">
</form>
<script type="text/javascript">

    function revisar(i){
        
        var idpreoc = document.getElementById('idpreoc_'+i).value;
        var canto = document.getElementById('canto_'+i).value;
        var cantf = document.getElementById('cantf_'+i).value;
        var prod = document.getElementById('prod_'+i).value;
        $.ajax({   
            url:"index.php",
            method:"POST",
            dataType:"json",
            data:{ctrlinvPatio:1,idpreoc:idpreoc,canto:canto,cantf:cantf, prod:prod},
            success:function(data){
                if(data.status == 'ok'){
                    alert('OK');
                    //alert('OK');
                    document.getElementById('boton_'+i).classList.add('hide');      
                    renglon = document.getElementById('tr_'+i);
                    renglon.style.background="#A9E2F3";
                }
            }
        })
    }

    
 function quitarCaja(){
    var caja = document.getElementById('caja').value;

    if(confirm('Se registrara el usuario y el horario...' + caja)){

        $.ajax({
            url:'index.php',
            method: 'POST',
            dataType: 'json',
            data:{quitarCaja:1,caja:caja},
            success:function(data){
             window.close()
            }
        })
    }
 }
/*
 $.ajax({
                url:"index.php",
                method:"POST",
                dataType:'json',
                data:{execOCI:1,idoci:idoci,tipo:tipo},
                success:function(data){
                    document.getElementById('btnA_'+idoci).classList.add('hide');
                    document.getElementById('btnR_'+idoci).classList.add('hide');
                    var renglon= document.getElementById('color_'+idoci);
                    if(data.tipo == 'Rechazo'){
                        renglon.style.background="#F5A9A9";/// Rehazado:    
                    }else if(data.tipo== 'CreacionOC'){
                        renglon.style.background="#CEF6D8";/// Rehazado:
                    }else{
                     renglon.style.background="#F2F5A9";   
                    }           
                }
            })
*/

    function cerrar(){
        alert('Se cerrara el Inventario con los datos cargados');
        var datos = new Array();
                 $(".conteo").each(function() {
                     var canto = parseFloat($(this).attr("original"));
                     var cantf = parseFloat(this.value);
                     var info = $(this).attr("info");
                     val = parseFloat(canto) - parseFloat(cantf);
                     //document.getElementByClassName('conteo').classList.add('hide');
                     if(val < 0){ /// si val es menor a 0 se debe ajustar el inventario para arriba.
                            /// se guarda para actualizar el inventario.
                            var a = (canto + ':'+cantf+':'+info +':'+'a');
                            datos.push(a);
                            //alert('original: ' + canto + ' capturada ' + cantf + 'del producto: '+ info); 
                     }else if(val > 0 ){
                            /// se guarda para generar el vale.
                            //alert('original: ' + canto + ' capturada ' + cantf + 'del producto: '+ info);
                            var a = (canto + ':'+cantf+':'+info+':'+'v');
                            datos.push(a);
                     }
                });
                 
                if(confirm('Se generaran ' + datos.length + ' vales.')){
                    document.getElementById('datosCierre').value=datos;
                    var form = document.getElementById('formCierre');
                    form.submit();    
                }
    }
</script>