<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Ver Solicitudes de Cambio de Proveedor.
            </div>
            
<?php if(count($solicitudes)>0){?>
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                <th>LN</th>
                                <th>Fecha Solicitud <br/> Cotizacion</th>
                                <th>Id <br/> Producto</th>
                                <th>Cantidad </th>
                                <th>Descripcion</th>
                                <th>Proveedor Predeterminado</th>
                                <th>Usuario Solicita</th>
                                <th>Precio <br/> Unitario </th>
                                <th>Desc1 <br/> Unitario </th>
                                <th>Desc2 <br/> Unitario </th>
                                <th>Desc3 <br/> Unitario </th>
                                <th>DescM <br/> Unitario </th>
                                <th>SubTotal</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Nuevo Prov</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i =0;
                        foreach ($solicitudes as $data):
                            $subtotal=$data->PRECIO - $data->DESC1 - $data->DESC2 - $data->DESC3 - $data->DESC4;
                            $iva = $subtotal *.16;
                            $total = $subtotal *1.16;
                            $color = '';
                            $i++;
                        ?>
                            <tr class="odd gradex" <?php echo $color;?> >
                                <td><?php echo $i?></td>
                                <td><?php echo $data->FECHA_SOLICITA.'<br/><font color:"blue">'.$data->COTIZACION.'</font>'?><br/><font color ='red'> <?php echo (empty($data->FECHA_INI)? 'Sin OC':$data->FECHA_INI)?></font> </td>
                                <td><?php echo $data->IDPREOC.' / <br/>'.$data->CVE_PROD?><br/><font color='blue'><?php echo (empty($data->PAGO))? 'Sin Pago':$data->PAGO ;?></font> </td>
                                <td><?php echo $data->CANTIDAD?></td>
                                <td><?php echo substr($data->DESCRIPCION,0,50).'<br/>'.substr($data->DESCRIPCION,50,100) ?></td>
                                <td align="left"><?php echo '('.$data->CVE_PROV_ORIG.')'.substr($data->NOMBRE_PROV_ORIG,0,35).'<br/>'.substr($data->NOMBRE_PROV_ORIG,35,80);?></td>
                                <td> <?php echo $data->USUARIO_SOLICITA ;?></td>
                                <td align="right"><?php echo '$ '.number_format($data->PRECIO,2)?></td>
                                <td align="right"> <?php echo '$ '.number_format($data->DESC1,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($data->DESC2,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($data->DESC3,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($data->DESC4,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($subtotal,2)?></td>
                                <td><?php echo '$ '.number_format($iva,2)?></td>
                                <td><?php echo '$ '.number_format($total,2)?></td>
                                <form action="index.php" method="post" id="form_<?php echo $i?>">
                                <td><input type="text" class="prov1" id="prov1_<?php echo $i?>" name="prov1" placeholder ="Nuevo proveedor" value="" required='required'/><br></td>
                                <td><input type="hidden" name="id" value = "<?php echo $data->ID?>" id="id_<?php echo $i?>">
                                    <input type="hidden" name="idpreoc" value="<?php echo $data->IDPREOC?>" id="idpreoc_<?php echo $i?>">
                                    <input id="l_<?php echo $i ?>" class="btn btn-success cambiar" linea="<?php echo $i?>" name="cambioProveedor" value="Cambiar" type="button" prov="<?php echo $data->CVE_PROV_ORIG?>" nom="<?php echo $data->NOMBRE_PROV_ORIG?>" > 
                                    
                                </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php }?>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
        $(".prov1").autocomplete({
        source: "index.v.php?proveedor=1",
        minLength: 2,
        select: function(event, ui){
        }
        })

        $("input.cambiar").click(function(){
            var i = $(this).attr('linea');
            var prov1 = document.getElementById("prov1_" + i).value;
            var id = document.getElementById('id_'+i).value;
            var idpreoc = document.getElementById('idpreoc_'+ i).value;
            var info = document.getElementById('l_'+i);
            var clave = info.getAttribute('prov');
            var nombre = info.getAttribute('nom');
            if(prov1 == ''){
                if(confirm('Desea dejar al mismo Proveedor?')){
                    prov1 = clave + ':' + nombre;
                }
            }
            if(confirm('Esta Seguro de cambiar al proveedor? ' + prov1)){   
                $.ajax({
                    url:'index.php',
                    type:'POST',
                    dataType:'json',
                    data:{cambioProveedor:prov1,id:id,idpreoc:idpreoc},
                    success:function(data){
                        alert(data.razon);
                        if(data.status == 'OK'){
                            document.getElementById('l_'+i).classList.add('hide');
                        }
                    }
                });
            }else{
                document.getElementById('prov1_'+i).value='';
            }
        })    
</script>