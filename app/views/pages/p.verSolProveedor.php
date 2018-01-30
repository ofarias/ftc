<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Ver Solicitudes de Corte y Restriccion.
            </div>
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                
                                <th>Fecha Solicitud</th>
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
                                <td><?php echo $data->FECHA_SOLICITA?></td>
                                <td><?php echo $data->IDPREOC.' / <br/>'.$data->CVE_PROD ;?> </td>
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
                                <form action="index.php" method="post">
                                <td><input type="text" class="prov1" id="prov1_<?php echo $i?>" name="prov1" placeholder ="Codigo proveedor" value="" required='required'/><br></td>
                                <td><input type="hidden" name="id" value = "<?php echo $data->ID?>">
                                    <input type="hidden" name="idpreoc" value="<?php echo $data->IDPREOC?>">
                                    <button class="btn btn-success" name="cambioProveedor" value="enviar" type="submit"> Cambiar </button></td>
                                </form>
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
<script>
        $(".prov1").autocomplete({
        source: "index.v.php?proveedor=1",
        minLength: 2,
        select: function(event, ui){
        }
        })    
</script>