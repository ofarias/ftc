<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Listado de Ordenes de compra.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Clave / Nombre </th>
                                            <th>Usuario</th>
                                            <th>Costo <br/> Bruto </th>
                                            <th>Descuento </th>
                                            <th>Valor IVA</th>
                                            <th>Costo Neto</th>
                                            <th></th>
                                            <th>Status Actual </th>
                                            <th>Contiene <br/> Urgencia</th>
                                            <th>Imprimir</th>
                                            <th>Ver / Editar</th>
                                            <th>Cancelar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
<?php if(count($preoc)>0){ ?>
                                        <?php 
                                        foreach ($preoc as $data):
                                            $ids=$data->ID;
                                            ?>
                                        <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_PROV. '/ '.$data->NOMBRE;?></td>
                                            <td><?php echo $data->USUARIO ;?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->DESCUENTO,2)?></td>
                                            <td><?php echo '$ '.number_format($data->TOTAL_IVA,2);?></td>
                                            <td><?php echo '$ '.number_format($data->COSTO_TOTAL,2);?></td>
                                            <td></td>
                                            <td><?php echo $data->STATUS?></td>
                                            <td><?php echo $data->URGENCIA?></td>
                                            <td>
                                                <form action="index.php" method="post">
                                                    <input name="idpoc" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                                    <button name="impPOC" type="submit" value="enviar" class="btn btn-info"> Imprimir</button>
                                                    <br/>
                                                </form>   
                                                
                                                    <input type="email" name="correoProv" value ="<?php echo $data->CORREO?>" required = "required" id="correo_<?php echo $data->ID?>"/>
                                                    <button name="correo" class="btn btn-success" value="<?php echo $data->CVE_DOC ?>"onclick="guardaPOC(this.value, <?php echo $data->ID?>)"> Enviar</button>
                                                </td>
                                            <td>
                                                <form action="index.php" method="post">
                                                    <input type="hidden" name="doco" value="<?php echo $data->CVE_DOC?>" />
                                                    <button name="confirmarPreOC" type="submit" value="enviar" class="btn btn-info">
                                                       <?php echo ($data->STATUS == 'A')? '':'Confirmar'?>    
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                  <form action = "index.php" method="post">
                                                <button class="btn btn-danger" name="eliminaPreOC" value="submit">Rechazar Preoc</button>
                                                <input type="hidden" name="poc" value="<?php echo $data->CVE_DOC?>">
                                                </form>
                                            </td>     
                                        </tr>
                                        <?php endforeach; ?>
<?php }?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
<br />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">


    function guardaPOC(poc, i){
        var email = document.getElementById('correo_'+i).value;
        if(email){
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
        }
    }
    
    function rechazar(ids){
        //var recWindow = window.open("index.php?action=verSolProdVentas","Mensaje","width=200,height=100")
        //recWindow.document.write("<p> Esta es la ventana</p>")
        var id = ids;
        alert('Se rechazara la Solicitud de alta del Producto :' + ids );
        window.open('index.php?action=rechazarSol&ids='+ids,"","width=800,height=800")
    }

</script>
