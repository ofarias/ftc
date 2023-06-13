<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ordenes en Preruta.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Orden</th>
                                            <th>Proveedor</th>
                                            <th>Estado <br/> CP</th>
                                            <th>Fecha Orden</th>
                                            <th>Importe</th>
                                            <th>Dias <br/>Trans</th>
                                            <th>Tipo <br/>Pago</th>
                                            <th>Fecha Pago</th>
                                            <th>Monto Pago</th>
                                            <th>Unidad <br/> Operador</th>
                                            <th>Cambiar <br> Unidad</th>
                                            <th>Administrar</th>
                                        </tr>
                                    </thead>
                                  <tbody>

                                <?php $i=0;
                                foreach ($secuenciaDetalle as $oc): $i++;?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $oc->CVE_DOC.'<br/>'.$oc->STATUS.'<br/>'.$oc->STATUS_LOG?></td>
                                    <td><?php echo $oc->NOMBRE?></td>
                                    <td><?php echo $oc->ESTADO.'<br/><font color="blue">'.$oc->CODIGO.'</font>'?></td>
                                    <td><?php echo $oc->FECHAELAB?></td>
                                    <td><?php echo '$ '.number_format($oc->IMPORTE,2)?></td>
                                    <td align="center"><font color="red"><?php echo $oc->DIAS?></font></td>
                                    <td><?php echo $oc->TP_TES?></td>
                                    <td><?php echo $oc->FECHA_PAGO?></td>
                                    <td align="right"><?php echo '$ '.number_format($oc->PAGO_TES,2)?></td>
                                    <td><?php echo $oc->UNIDAD.'<br/>'.$oc->OPERADOR?></td>
                                    <td>
                                        <input type="hidden" name="poc" value="<?php echo $oc->CVE_DOC?>" id="p_<?php echo $i?>">
                                        <input type="hidden" name="ac" id="act_<?php echo $i?>" value="<?php echo $oc->UNIDAD.'/'.$oc->OPERADOR?>">
                                        <select name="unidad" onchange="cambiarUnidad(<?php echo $i?>, this.value, p_<?php echo $i?>.value)" id="select_<?php echo $i?>">
                                            <option value="nada">Cambiar Unidad</option>
                                            <?php foreach ($unidades as $u): ?>
                                            <option value="<?php echo $u->IDUNIDAD?>" uni="<?php echo $u->NUMERO?>" id="sel_<?php echo $i.$u->IDUNIDAD?>"><?php echo $u->NUMERO.' / '.$u->OPERADOR?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <form action="index.php" method="post">
                                            <input name="prov" type="hidden" value="<?php echo $oc->PROV?>"/>
                                            <input name="secuencia" type="hidden" value="1"/>
                                            <input name="uni" type="hidden" value="<?php echo $oc->UNIDAD?>"/>
                                            <input name="fecha" type="hidden" value="<?php echo $oc->FECHAELAB?>"/>
                                            <input name="idu" type="hidden" value="<?php echo $oc->IDU?>" /> 
                                            <input type="hidden" name="doco" value = "<?php echo $oc->CVE_DOC?>" />                          
                                    <td>    
                                        <input type="checkbox" name="sel" class="docos" value="<?php echo $oc->CVE_DOC?>">                                         
                                           <!-- <button name="SecUnidad2" type="submit" value="enviar" class="btn btn-warning" id="btn_<?php echo $i?>"> Asignar <i class="fa fa-cog fa-spin"></i></button>-->
                                    </td>
                                    </form>
                                </tr>
                             <?php endforeach ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>

            <div class="panel-footer" id="impresion">
                <div class="text-right">
                    <form action="index.php" method="post">
                        <input type="hidden" name="unidad" value="<?php echo $unidad; ?>"/>
                        <input type="hidden" name="docs" value="" id="dcs">
                        <button type="input" name="ImprimirSecuencia" class="btn btn-primary">Imprimir<i class="fa fa-print" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
            <div class="panel-footer hide" id="actualizar">
                <div class="text-right">
                    <a class="btn btn-info" onclick="act()">Actualizar</a>
                </div>
            </div>
        </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    var idu = <?php echo $unidad?>;
    $(".docos").change(function(){
        folios="";
        $("input:checked").each(function(index){
            var doc=$(this).val();
            $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{valCheck:doc, idu},
                    success:function(data){
                        if(data.status == 'ok'){
                            folios+= ","+ doc;
                            document.getElementById("dcs").value= folios;
                        }else{
                            alert(data.mensaje);
                        }
                    }
            });
        });
    })

    function cambiarUnidad(i, sec, poc){
        var uni = document.getElementById("sel_"+i+sec).getAttribute('uni');
        var act = document.getElementById("act_"+i).value;
        document.getElementById("btn_"+i).classList.add("hide");
        document.getElementById("impresion").classList.add("hide");
        if(confirm('Desea Cambiar el documento '+ poc +' a unidad: '+ uni + ' ?')){
            $.ajax({
            url:"index.php",
            method:"POST",
            dataType:"json",
            data:{cambiaPOCuni:1, poc, idu:sec},
            success:function(data){
                    alert(data.mensaje);
                    document.getElementById("actualizar").classList.remove('hide');
                },
            error:function(data){
                    alert("Algo no funciono correctamente favor de intentarlo nuevamente");
                    alert('No se realizo ningun Cambio');
                    document.getElementById("select_"+i).value="nada";
                    document.getElementById("btn_"+i).classList.remove('hide');
                }
            })
        }else{
            alert('No se realizo ningun Cambio');
            document.getElementById("select_"+i).value="nada";
            document.getElementById("btn_"+i).classList.remove('hide');
            
        }
    }

    function act(){
        location.reload(true);
    }
</script>