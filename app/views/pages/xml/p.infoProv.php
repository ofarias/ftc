<!-- <meta http-equiv="Refresh" content="240">-->
<style type="text/css">
    .setDiot, .setDoc{
        color: black;
    }
</style>
<br/>
<?php foreach($info['detalle'] as $inf){}?>
<br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Informacion del <?php echo $tipo=='Recibidos'? 'Proveedor ':'Cliente '?> " <font color="white" size="2 px"><b><?php echo $inf->NOMBRE?></b></font> "
                            <br/>
                            <label>Total facturas recibidas: $ <?php echo number_format($inf->TOTAL_GRAL,2)?> </label><br/>
                            <ol>
                                <?php foreach($info['tot_anl'] as $tot):?>
                                    <li><?php echo $tot->EJERCICIO.' = $ '.number_format($tot->IMPORTE,2)?></li>
                                <?php endforeach;?>
                            </ol>

                            <label>Tipo de facturas: </label><br/>
                            Predefinifo: <label id="tdcs"><?php echo $inf->TIPO_DOC? $inf->TIPO_DOC:'<b>No Definido</b>'?></label>  &nbsp;&nbsp; Cambiar:&nbsp;&nbsp;
                                <select class="setDoc">
                                    <option value="">Tipo de documentos:</option>
                                    <?php foreach($info['tipoDocs'] as $tpdoc):?>
                                        <option value="<?php echo $tpdoc->ID_TIPO?>"><?php echo $tpdoc->DESCRIPCION?></option>
                                    <?php endforeach;?>
                                </select>
                                &nbsp;&nbsp; Todas: <input type="radio" value="t" name="t2" class="t2d"> &nbsp;&nbsp;&nbsp; Sin Definir: <input type="radio" name="t2" value="s" checked class="t2d">
                            <ol>
                                <?php foreach($info['tipo_doc'] as $td):?>
                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $td->DESCRIPCION.' = '.$td->DOCUMENTOS?></li>
                                <?php endforeach;?>
                            </ol>
                            <?php if($tipo == 'Recibidos'){?>
                            <label>Datos DIOT : </label><br/>
                            Tipo Operacion = <label id="top"><?php echo $inf->TIPO_OPERACION_SAT? $inf->TIPO_OPERACION_SAT:'<b>No Definido</b>' ?></label>
                                                                                <select class="setDiot" t="to" name="top"> 
                                                                                    <option value="">Seleccione un Tipo de Operacion</option>
                                                                                    <option>03 - Prestación de Servicios Profesionales</option>
                                                                                    <option>06 - Arrendamiento de Inmuebles</option>
                                                                                    <option>85 - Otros</option>
                                                                                </select><br/>
                            Tipo Tercero  = <label id="tte"><?php echo $inf->TIPO_TERCERO_SAT? $inf->TIPO_TERCERO_SAT:'<b>No Definido</b>'?></label>
                                                                                <select class="setDiot" t="tt" name="tter">
                                                                                    <option value="">Seleccione un Tipo de Tercero</option>
                                                                                    <option >04 - Proveedor Nacional</option>
                                                                                    <option >05 - Proveedor Extranjero</option>
                                                                                    <option >15 - Proveedor Global</option>
                                                                                </select><br/></font>
                            <?php }?>
                        </div> 
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-provdetalle">
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>DOCUMENTO</th>
											<th>FECHA</th>
                                            <th>TIPO DE CAMBIO</th>
                                            <th>TIPO DE DOCUMENTO</th>
                                            <th>MONEDA</th>
                                            <th>FORMA DE PAGO</th>
                                            <th>METODO DE PAGO</th>
                                            <th>SUBTOTAL</th>
                                            <th>TOTAL</th>
                                            <th>ESTADO</th>
                                            <th>TIPO DOCUMENTO</th>
                                            <th>ANIO</th>
                                            <th>FECHA DE PAGO</th>
                                            <th>BANCO</th>
                                            <th>REFERENCIA</th>
                                            <th>FOLIO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($info['detalle'] as $data): 
                                        ?>                 
                                        <tr>
                                            <td><?php echo $data->UUID?></td>
                                            <td><?php echo $data->DOCUMENTO ?></td>
                                            <td><?php echo $data->FECHA ?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->TIPOCAMBIO,2)?></td>
                                            <td><?php echo $data->TIPO?></td>
                                            <td><?php echo $data->MONEDA?></td>
                                            <td><?php echo $data->FORMAPAGO ?></td>
                                            <td><?php echo $data->METODOPAGO?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2)?></td>
                                            <td><?php echo $data->STATUS?></a></td>
                                            <td><?php echo $data->TIPO_DOC?></td>
                                            <td><?php echo date("Y", strtotime($data->FECHA))?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
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

    var rfc = <?php echo "'".$rfc."'"?>;
    var t3 = <?php echo "'".$tipo."'"?>;

    $(".setDiot").change(function(){   
        var tipo = $(this).attr('t')
        var val = $(this).val()
        if(tipo == 'to'){
            var t = document.getElementById("top").innerHTML
        }else if(tipo == 'tt'){
            var t = document.getElementById('tte').innerHTML
        }
        if(val == ""){
            $.alert('Seleccione un valor por favor...')
            return
        }else{
            $.alert('Se guardara el')
        }
    })

    $(".setDoc").change(function(){
        var ta = document.getElementById('tdcs').innerHTML
        var t = $(this).val()
        var t2 = $('input:radio[name=t2]:checked').val();
        
        $.confirm({
            title: 'Cambio tipo de Documentos',
            content: 'Tipo de documentos',
            buttons:{
                ok : function(){
                    $.ajax({
                        url:'index.xml.php',
                        type:'post',
                        dataType:'json',
                        data:{setTD:1, t, rfc, t2, t3},
                        success:function(data){
                            location.reload(true)
                        },
                        error:function(){
                            $.alert(t)
                        }
                    })
                },
                cancelar: function(){
                    return
                }
            }
        })
    })

</script>