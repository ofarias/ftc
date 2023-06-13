<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del calculo de las operaciones a Proveedores para presentacion de la DIOT.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-iva">
                                    <thead>
                                        <tr>
                                            <th>Documento<br/>UUID</th>
                                            <th>RFC Emisor</th>
                                            <th>Proveedor</th>
                                            <th>Tipo Tercero<br/> Tipo Operacion</th>
                                            <th>Importe <br/>Documento</th>
                                            <th><font color="brown">Cargo</font></th>
                                            <th>Fecha</th>
                                            <th>Forma Pago</th>
                                            <th>Banco Receptor</th>
                                            <th>No Operacion</th>
                                            <th>Fecha Pago</th>
                                            <th>Referencia <br/> Estado de Cuenta</th>
                                            <th>Porcentaje Pago</th>
                                            <th>IVA del <br/>Documento</th>
                                            <th>Iva Trunco</th>
                                            <th>Iva Pagado</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $total = 0;
                                            $totCar =0;
                                            $totAbn = 0;
                                            foreach ($cargos as $c):
                                                $num = explode(".", $c->TOTAL_IVA);
                                                $num = $num[0];
                                                $totalIVA = $num * $c->NAT;
                                                $total += $totalIVA;
                                                $totCar += $num;
                                         ?>
                                            <tr>
                                                <td><?php echo $c->DOCUMENTO;?><br/><?php echo $c->UUID?></td>
                                                <td id="prv"><?php echo $c->RFC;?></td>
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
                                                    <br/>
                                                    <select id="p_o">
                                                        <?php if (!empty($c->TIPO_OPE)){?>
                                                            <option value="<?php echo substr($c->TIPO_OPE, 0, 2)?>"><?php echo $c->TIPO_OPE?></option>
                                                        <?php }?>
                                                        <option value="">Tipo de Operaciones</option>
                                                        <option>03 - Prestación de Servicios Profesionales</option>
                                                        <option>06 - Arrendamiento de Inmuebles</option>
                                                        <option>85 - Otros</option>
                                                    </select>
                                                    <br/> <input type="button" id="save" value="Grabar" class="btn-sm btn-info g" >
                                                </td>
                                                <td align="right"><font color="blue"><b><?php echo '$ '.number_format($c->IMPORTE,2);?></b></font></td>
                                                <td align="right"><font color="brown"><b><?php echo '$ '.number_format($c->CARGO,2);?></b></font></td>
                                                <td><?php echo $c->FECHA_DOC;?></td>
                                                <td><?php echo $c->FORMA_PAGO?></td>
                                                <td><?php echo $c->BANCO_CUENTA;?></td>
                                                <td><?php echo $c->REF_EDO?></td>
                                                <td><?php echo $c->FECHA_PAGO;?></td>
                                                <td><?php echo $c->REF_EDO_BAN?></td>
                                                <td align="center"><?php echo number_format(($c->PORCENTAJE*100),2)." %"?></td>
                                                <td align="right"><?php echo '$ '.number_format($c->IVA,2)?></td>
                                                <td align="right"><?php echo '$ '.number_format($totalIVA,2)?></td>
                                                <td align="right"><font color="brown"><?php echo '$ '.number_format($c->TOTAL_IVA,2)?></font></td>
                                                
                                            </tr>
                                        <?php endforeach;?>
                                 </tbody>
                                 <tfoot>
                                        <tr>
                                            <td colspan="13"></td>
                                            <td align="right"><b><?php echo '$ '. number_format($total,0)?></b></td>
                                            <td align="right"><b><?php echo '$ '.number_format($totCar,0)?></b></td>
                                            
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
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
        var pt = document.getElementById('p_t').value
        var po = document.getElementById('p_o').value
        var rfc = document.getElementById('prv').innerHTML
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