<br/><br/>
<style type="text/css">
    .linea:link{
        background-color: 'red';
    }
</style>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Proyección <?php echo $id?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-proyeccion-gastos">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Mes</th>
                                <th>Ejercicio</th>
                                <th>Monto Ventas <br/> Presupuestado</th>
                                <th>Monto Gastos <br/> Presupuestado</th>
                                <th>Resultado</th>
                                <th>Monto Ventas <br/> Confirmado</th>
                                <th>Monto Ingresos <br/> Confirmado</th>
                                <th>Resultado</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totVi=0; $totGi=0; foreach($crea['cabecera'] as $row):
                                $utilidad = $row->MONTO_INI_V - $row->MONTO_INI_G;
                                $resultado = $row->MONTO_FIN_V - $row->MONTO_FIN_G;
                                $totVi += $row->MONTO_INI_V;
                                $totGi += $row->MONTO_FIN_G;
                                $color = '';
                            ?>
                            <tr id="col<?php echo $row->ID?>" <?php echo $color?> onmouseover = "this.style.fontWeight='bold'" onmouseout = "this.style.fontWeight=''" class="linea">
                                <td align="center"><input type="checkbox" class="sel" value="<?php echo $p?>" tpp="<?php echo $row->ID?>" tm="<?php echo $row->TIPO?>" id="selval<?php echo $row->ID?>"></td>
                                <td align="center"><?php echo $row->IDPR?></td>
                                <td align="center"><?php echo $row->TIPO;?></td>
                                <td align="center"><?php echo $row->MES;?></td>
                                <td align="center"><?php echo $row->EJERCICIO;?></td>
                                <td align="right"><?php echo '$ '.number_format($row->MONTO_INI_V,2);?></td>
                                <td align="right"><?php echo '$ '.number_format($row->MONTO_INI_G,2);?></td>
                                <td align="right"><?php echo '$ '.number_format($utilidad,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($row->MONTO_FIN_V,2);?></td>
                                <td align="right"><?php echo '$ '.number_format($row->MONTO_FIN_G,2);?></td>
                                <td align="right"><?php echo '$ '.number_format($resultado,2)?></td>
                                <td><?php echo $row->ESTADO?></td>                                
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="0" ></td>
                                <td><b>Total Ventas</b></td>
                                <td align="right" id="tvm"><?php echo '$ '.number_format($totVi,2);?></td><td></td>
                                <td><b>Total Gastos</b></td>
                                <td align="right" id="tgm"><?php echo '$ '.number_format($totGi,2);?></td><td></td>
                                <td align="right" ><label>Proyeccion Mensual:</label> </td>
                                <td align="right" id="tpm"><?php echo '$ '.number_format(0,2);?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="0"></td>
                                <td colspan="2" align="right"><b>Total Venta Seleccionada:</b></td>
                                <td><label id="rv"></label></td>
                                <td colspan="2" align="right"><b>Total Gastos Seleccionados:</b></td>
                                <td><label id="rg"></label></td>
                                <td colspan="3"><input type="button" value="Genera Proyeccion Mensual" id="pro"></td>
                                <td><a target="_blank" href="index.php?action=imprimircatgastos" class="btn btn-info">Imprimir <i class="fa fa-print"></i></a></td>
                                <td><a href="index.php?action=nuevogasto&tipo=<?php echo $tipo?> "class="btn btn-info">Agregar <i class="fa fa-plus"></i></a></td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br/><br/>
<div class="row <?php echo $id>0? '':'hidden'?>" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Proyección <?php echo $tipo=='B'? 'Mensual':'de '.$tipo ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-proyeccion-gastos">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Concepto</th>
                                <th>Descripción</th>
                                <th>IVA</th>
                                <th>Centro de costos</th>
                                <th>Cuenta Contable</th>
                                <th>Gasto</th>
                                <th>Periodicidad</th>
                                <th>Presupuesto</th>
                                <th>Tipo</th>
                                <th>Mensual</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estatus</th>
                                <th>Tipo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalMensual=0; $totG=0; $totV=0; $factor=0; foreach($crea['detalle'] as $row):
                                $color='';
                                $p = ($row->PRESUPUESTO * $row->FACTOR ) / 12;
                                if($row->TIPO == 'G'){
                                    $color ="style='background-color:#ffe2b8';";
                                    $tp = 'Gasto';
                                    $factor= -1;
                                    $totG += $p;
                                }elseif ($row->TIPO == 'V') {
                                    $color ="style='background-color:#b8ffe6';";
                                    $tp = 'Venta';
                                    $factor = 1;
                                    $totV += $p;
                                }
                                $mensual=(($row->PRESUPUESTO * $row->FACTOR ) / 12)*$factor;
                                $p = $p * $factor;
                                $totalMensual += $mensual; 
                            ?>
                            <tr id="col<?php echo $row->ID?>" <?php echo $color?>>

                                <td><input type="checkbox" class="sel" value="<?php echo $p?>" tpp="<?php echo $row->ID?>" tm="<?php echo $row->TIPO?>" id="selval<?php echo $row->ID?>"></td>
                                <td><?php echo $row->ID?></td>
                                <td><?php echo $row->CONCEPTO;?></td>
                                <td><?php echo $row->DESCRIPCION;?></td>
                                <td><?php echo $row->CAUSA_IVA;?></td>
                                <td><?php echo $row->CENTRO_COSTOS;?></td>
                                <td><?php echo $row->CUENTA_CONTABLE;?></td>
                                <td><?php echo $row->CLASIFICACION?></td>
                                <td><?php echo $row->PER_PAG?></td>
                                <td align="right" ><input type="text" id="imp_<?php echo $row->ID?>" value="<?php echo '$ ' . number_format($row->PRESUPUESTO,2,'.',',');?>" onchange="actImp(this.value, <?php echo $row->ID?>, '<?php echo '$ '.number_format($row->PRESUPUESTO,2)?>', <?php echo $factor?>)" ></td> 
                                <td><?php echo $row->GASTO;?></td>
                                <td align="right" ><?php echo '$ '.number_format($mensual,2)?></td>
                                <td><?php echo $row->FECHA_INI?></td>
                                <td><?php echo $row->FECHA_FIN?></td>
                                <td><?php echo empty($row->STATUS)? 'Activo':'Inactivo' ?></td>
                                <td><?php echo $tp?></td>
                                <form action="index.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row->ID;?>"/>
                                    <td><button type="submit" name="editcuentagasto" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i></button></td>
                                    <td><button type="submit" name="delcuentagasto" class="btn btn-warning" onclick="return confirm('¿Seguro que desea eliminar la cuenta?');" ><i class="fa fa-trash"></i></button></td>
                                </form>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" ></td>
                                <td><b>Total Ventas</b></td>
                                <td align="right" id="tvm"><?php echo '$ '.number_format($totV,2);?></td><td></td>
                                <td><b>Total Gastos</b></td>
                                <td align="right" id="tgm"><?php echo '$ '.number_format($totG,2);?></td><td></td>
                                <td align="right" ><label>Proyeccion Mensual:</label> </td>
                                <td align="right" id="tpm"><?php echo '$ '.number_format($totalMensual,2);?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="2" align="right"><b>Total Venta Seleccionada:</b></td>
                                <td><label id="rv"></label></td>
                                <td colspan="2" align="right"><b>Total Gastos Seleccionados:</b></td>
                                <td><label id="rg"></label></td>
                                <td colspan="3"><input type="button" value="Genera Proyeccion Mensual" id="pro"></td>
                                <td><a target="_blank" href="index.php?action=imprimircatgastos" class="btn btn-info">Imprimir <i class="fa fa-print"></i></a></td>
                                <td><a href="index.php?action=nuevogasto&tipo=<?php echo $tipo?> "class="btn btn-info">Agregar <i class="fa fa-plus"></i></a></td>
                                <td></td>
                                <td></td>

                            </tr>
                        </tfoot>
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
    
    function actImp(val, id, ant, f ){
        $.confirm({
            title: 'Cambio de Importe',
            content:'Se va actualizar el monto del gasto, desea proceder?',
            buttons:{
                confirmar:function(){
                    $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{actImpG:1, idg:id, val, f},
                    success:function(data){
                        document.getElementById('imp_'+id).value = data.val
                        document.getElementById('selval'+id).value = data.v
                        renglon = document.getElementById('col'+id)
                        renglon.style.background="#cce6ff";
                        var a = totales()

                        document.getElementById('tvm').innerHTML = '$ '+ a[0]
                        document.getElementById('tgm').innerHTML = '$ '+ a[1]
                        document.getElementById('tpm').innerHTML = '$ '+ a[2]

                        $.alert(data.mensaje)
                    },
                    error:function(){
                        $.alert('Error.')
                    }
                    })
                },    
                cancelar:function(){
                    document.getElementById('imp_'+id).value = ant
                    return;
                }
            }
        });
    }

    $(".sel").change(function(){
        var a = gastos()
    })

    $("#pro").click(function(){
        var a = gastos()
        var sel = a[0]

            var res = 'Utilidad'
            if(a[4] + a[5] < 0 ){
                var resn = ' Perdida de '
            }else{
                var resn = ' Utilidad de '
            }
            var genval = a[4] + a[5]
            genval = formatMoney(genval)
            v = a[2]; g=a[3];
        if(sel == 0){
            alert('No se selecciono ningun registro, por lo cual se tomaran todos los registros para la proyeccion mensual')
            a  = totales()
            v = a[0]; g = a[1]; genval = a[2];
            if(a[0] + a[1] < 0 ){
                var resn = ' Perdida de '
            }else{
                var resn = ' Utilidad de '
            }
        }
            $.confirm({
                columnClass: 'col-md-8',
                title: 'Creacion de Proyeccion de Ingresos / Egresos Mensual',
                content: 'Favor de seleccionar el mes de proyeccion' + 
                '<form action="index.php" method="post" class="pr">' +
                    '<div class="form-group">'+
                        '<label> Se contemplan Ventas por ' + v + " gatos por " + g + ' generando una ' + resn + genval + ' </label><br/>'+
                        '<br/><select class="m" name="mes"> '+
                            '<option value ="">Seleccione un mes</option>'+
                            '<option value ="1">Enero</option>' +
                            '<option value ="2">Febrero</option>' +
                            '<option value ="3">Marzo</option>' +
                            '<option value ="4">Abril</option>' +
                            '<option value ="5">Mayo</option>' +
                            '<option value ="6">Junio</option>' +
                            '<option value ="7">Julio</option>' +
                            '<option value ="8">Agosto</option>' +
                            '<option value ="9">Septiembre</option>' +
                            '<option value ="10">Octubre</option>' +
                            '<option value ="11">Noviembre</option>' +
                            '<option value ="12">Diciembre</option>' +
                        '</select>'+
                        '&nbsp;&nbsp;&nbsp;&nbsp;'+
                        '<select class ="y" name="anio"> '+
                            '<option value ="">Seleccione un Año</option>'+
                            '<option value ="<?php echo date('Y')?>" ><?php echo date('Y')?></option>' +
                            '<option value ="<?php echo (date('Y')-1) ?>" > <?php echo (date('Y')-1) ?> </option>' +
                        '</select><br/>'+
                        '<br/> <input type="hidden" name="creaProy" value="1">' +
                        '<br/> <input type="hidden" name="tipo" value="'+sel+'">' +
                        '<br/>"Se genera la proyeccion del mes seleccionado"' +
                    '</div>'+
                '</form>',
                buttons: {
                        formSubmit: {
                        text: 'Generar',
                        btnClass: 'btn-blue',
                        action: function () {
                            var m = this.$content.find('.m').val();
                            var y = this.$content.find('.y')
                            var form = this.$content.find('.pr')
                            if( m != '' || y != ''){
                                $.alert('Al no seleccionar mes ni año, se toma como valor el mes actual y el año actual ')     
                            }
                            form.submit()
                        }
                    },
                    cancelar: function () {
                    },
                },
            });
        
    })  

    function gastos(){
        var sel = 0;
        var tm = '';
        var v = 0;
        var g = 0; 
        $("input:checkbox:checked.sel").each(function() {
            sel++
            tm = $(this).attr('tm')
            if(tm == 'G'){
                g += parseFloat($(this).val())
            }else if(tm == 'V'){
                v += parseFloat($(this).val())
            }
        });
        gf = formatMoney(g  * -1)
        vf = formatMoney(v)
        document.getElementById('rg').innerHTML = '$ ' + gf
        document.getElementById('rv').innerHTML = '$ ' + vf
        var a = [sel, tm, vf, gf, v, g]
        return a;
    }

    function totales(){
        var tm = '';
        var v = 0;
        var g = 0; 
        $("input:checkbox").each(function() {
            tm = $(this).attr('tm')
            if(tm == 'G'){
                g += parseFloat($(this).val())
            }else if(tm == 'V'){
                v += parseFloat($(this).val())
            }
        });
        var t = v+g
        v = formatMoney(v)
        g = formatMoney(g * -1)
        t = formatMoney(t)
        var a = [v, g, t]
        return a;
    }

    function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };


</script>