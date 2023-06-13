<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Ordenes de compra:
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Usuario que Relizo</th>
                                            
                                            <th>Autorizar <br/> Rechazar</th>
                                         </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($oci as $data):
                                        ?>
                                       <tr id="color_<?php echo $data->OCI?>">  
                                            <td align="center"><?php echo 'OCI-'.$data->OCI;?></td>
                                            <td><?php echo $data->FECHA_OCI;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO*1.16,2);?></td>
                                            <td><?php echo $data->USUARIO_OCI;?></td>
                                            <td>
                                            <input id="btnA_<?php echo $data->OCI?>" class="btn btn-info" type="button" name="aceptar" value="Aceptar" onclick="execOCI(<?php echo $data->OCI?>, 'a')"><br/><br/>
                                            <input id="btnR_<?php echo $data->OCI?>" class="btn btn-warning" type="button" name="denegar" value="Rechazar" onclick="execOCI(<?php echo $data->OCI?>, 'r')">
                                            </td>
                                            <td>
                                            <form action="index.php" method="post">
                                            <button class="btn btn-success" type="submit" value="enviar" name="imprimeOCI">Imprimir</button>
                                            <input id="btnA_<?php echo $data->OCI?>" type="hidden" name="oci"  value="<?php echo $data->OCI?>">
                                            </form>
                                            </td>

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
    $(document).ready(function() {
    $(".fecha").datepicker({dateFormat:'dd.mm.yy'});
  } );

    function execOCI(idoci, tipo){
        if(tipo == 'a'){
            var mensaje = 'Esta seguro de aceptar la OCI?, segenerara una OC por pagar a Tesoreria';
        }else{
            var mensaje = 'Esta seguro de rechazat la OCI?, no se podra recuperar posteriormente';
        }
        if(confirm(mensaje)){
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
        }
    }

</script>

