<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <?php foreach($oc as $n){$usuario =$n->USUARIO;}?>
                           Ordenes de compra del Usuario <?php echo $usuario?>.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Fecha Confirmacion</th>
                                            <th>Usuario Confirmacion<br/> Pegaso </th>
                                            <th>Persona que Confirma <br/> Proveedor</th>
                                            <th>Pago Requerido</th>
                                            <th>Partida </th>
                                            <th>Importe</th>
                                            <th>Enviar x Correo</th>
                                            <th>Tipo Pago Tesoreria</th>
                                            <th>Monto Pago Tesoreria</th>
                                            <th>Fecha de Pago Tesoreria</th>
                                            <th>Usuario Pago Tesoreria</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($oc as $data):
                                        ?>
                                       <tr>
                                            <td><?php echo $data->OC;?></td>
                                            <td align="center"><?php echo $data->FECHA_OC;?></td>
                                            <td align="center"><?php echo $data->USUARIO_OC?></td>
                                            <td><?php echo $data->CONFIRMADO?></td>
                                            <td><?php echo $data->TP_TES_REQ?></td>
                                            <td><?php echo $data->NOMBRE?></td>
                                            <td align="center"><?php echo '$ '.number_format($data->COSTO_TOTAL,2);?></td>
                                            <td align="right">
                                           <!-- <form action="index.php" method="post">-->
                                                <input type="email" name="tipo"  placeholder="Colocar correo" id="correo_<?php echo $data->OC?>">
                                                 <input type="hidden" name="doco" value="<?php echo $data->OC?>">
                                                 <input type="hidden" name="tipo1" value="f">
                                                 <br/> 
                                                <button class="btn btn-info" onclick="enviaCorreo('<?php echo $data->OC?>', 'email')" name="guardaOC">Enviar</button>
                                                <form action="index.php" method="POST">
                                                <input type="hidden" name="tipo" value="f">
                                                <input type="hidden" name="tipo2" value = "impresion">
                                                <input type="hidden" name="doco" value="<?php echo $data->OC?>">
                                                <button class="btn btn-info" name="guardaOC" value="enviar" > Descargar</button>
                                                </form>

                                                </td>
                                           <!-- </form> -->
                                            <td align="right"><?php echo $data->TP_TES;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PAGO_TES,2)?></td>
                                            <td align="right"><?php echo $data->FECHA_PAGO?></td>
                                            <td align="right"><font color="red"><?php echo $data->USUARIO_PAGO?></font></td>
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


    function enviaCorreo(i, tipo){
        var email = document.getElementById('correo_'+i).value;
        if (tipo == 'email'){
            if(email == ''){
                alert('No se ha capturado ningun correo:');    
            }else{
                alert('Se intentara enviar el correo a la direccion: ' + email);
                $.ajax({
                    type:'GET',
                    url: 'index.php',
                    data: 'action=guardaOC&doco='+i+'&tipo=f'+'&tipo2='+tipo,
                });
                $.ajax({
                    type:'GET',
                    url:'index.php',
                    data:'action=enviaCorreoOC&doco='+i+'&correo='+email,
                    });
            }
        }else{
            alert('Se genera el archivo pdf de la Orden de Compra ' + i);
                $.ajax({
                type:'GET',
                url: 'index.php',
                data: 'action=guardaOC&doco='+i+'&tipo=f'+'&tipo2='+tipo,
                });
                
        }
        /*if(email){
            alert('Se intentara enviar la preorden '+poc+', a el correo: '+ email);
             $.ajax({
            type:'GET',
            url: 'index.php',
            data: 'action=guardaPOC&idpoc='+poc+'&tipo=f',
            });
            $.ajax({
                type:'GET',
                url:'index.php',
                data:'action=enviarPOCcorreo&idpoc='+poc+'&correo='+email,
            });
            alert('Se ha enviado el correo, favor de revisar los datos.');     
        }else{
            alert("No se ha captura ningun correo");
        }*/
    }
    
    function rechazar(ids){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + ids );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
