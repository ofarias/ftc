<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Calculo de las operaciones a Proveedores para presentacion de la DIOT del mes <?php echo $mes.' del Ejercicio '.$anio ?>.
                            <br/>
                            <?php if($mes > 0){?>
                                <input type="button" value="Genera Archivo DIOT" class="btn-sm btn-info">
                            <?php }?>
                            <input type="button" value="Descarga Excel" class="btn-sm btn-success">
                            
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-iva">
                                    <thead>
                                        <tr>
                                            <th>RFC Emisor</th>
                                            <th>Proveedor</th>
                                            <th>Tipo Tercero</th>
                                            <th>Tipo Operacion</th>
                                            <th>Grabar</th>
                                            <th>Importe</th>
                                            <th>Total Documentos</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $total = 0;
                                            $totCar =0;
                                            $totAbn = 0;
                                            $ln = 0;
                                            foreach ($cargos as $c):
                                                $num = explode(".", $c->TOTAL_IVA);
                                                $num = $num[0];
                                                $totalIVA = $num * $c->NAT;
                                                $total += $totalIVA;
                                                $totCar += $num;
                                                $color = '';
                                                if($c->TIPO_TER == '' OR $c->TIPO_OPE== ''){
                                                    $color="style='background-color:#FCE4E4'";
                                                }
                                                $ln++;
                                         ?>
                                            <tr <?php echo $color?> class="odd gradeX">
                                                <td id="prv<?php echo $ln?>"><?php echo $c->RFC;?></td>
                                                <td><?php echo $c->NOMBRE;?></td>
                                                <td><select id="p_t">
                                                        <?php if (!empty($c->TIPO_TER)){?>
                                                            <option value="<?php echo substr($c->TIPO_TER, 0, 2)?>"><?php echo $c->TIPO_TER?></option>
                                                        <?php }?>
                                                        <option value="">Tipo de Proveedor</option>
                                                        <option >04 - Proveedor Nacional</option>
                                                        <option >05 - Proveedor Extranjero</option>
                                                        <option >15 - Proveedor Global</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="p_o">
                                                        <?php if (!empty($c->TIPO_OPE)){?>
                                                            <option value="<?php echo substr($c->TIPO_OPE, 0, 2)?>"><?php echo $c->TIPO_OPE?></option>
                                                        <?php }?>
                                                        <option value="">Tipo de Operaciones</option>
                                                        <option>03 - Prestación de Servicios Profesionales</option>
                                                        <option>06 - Arrendamiento de Inmuebles</option>
                                                        <option>85 - Otros</option>
                                                    </select>
                                                    </td>
                                                <td>
                                                    <input type="button" id="save" value="Grabar" class="btn-sm btn-info g" ln="<?php echo $ln?>" >
                                                </td>
                                                <td align="right"><?php echo '$ '.number_format($totalIVA,2)?></td>
                                                <td align="center"><?php echo $c->DOCUMENTOS?></td>
                                            </tr>
                                        <?php endforeach;?>
                                 </tbody>
                                 <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td align="right"><b><?php echo '$ '. number_format($total,0)?></b></td>
                                            <td align="right"><b><?php echo '$ '.number_format($totCar,0)?></b></td>
                                            
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<br/>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    
    $(".g").click(function(){
        var ln = $(this).attr('ln')
        var pt = document.getElementById('p_t').value
        var po = document.getElementById('p_o').value
        var rfc = document.getElementById('prv'+ln).innerHTML
        if(pt == '' || po == '' ){
            $.alert('Favor de seleccionar un valor valido')
            return false
        }
        $.confirm({
            title:'Grabar datos del proveedor ' +rfc,
            content:'Se trata de guarda el proveedor <b>' + rfc + '</b> de tipo  <b>' + pt + '</b> de operaciones <b>' + po +'</b>',
            buttons:{
                ok:{
                    text:'ok',
                    btnClass:'btn-blue',
                    action: function(){
                                $.ajax({
                                    url:'index.xml.php',
                                    type:'post',
                                    dataType:'json',
                                    data:{gpd:1, pt, po, rfc},
                                    success:function(data){
                                        $.alert('Se ha guardado correctamente')
                                    },
                                    error:function(){
                                        $.alert('Algo no salio como se esperaba')
                                    }
                                })    
                    }
                },
                cancelar:{
                    text:'Cancelar',
                    btnClass:'btn-red',
                    action:function(){
                        return;
                    }
                }
            }
        })
    })

</script>