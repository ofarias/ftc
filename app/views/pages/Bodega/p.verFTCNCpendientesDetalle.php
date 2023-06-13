<br/>
<div>
    <?php foreach ($nc as $key){
        $cliente = '( '.$key->CLIENTE.') '.$key->NOMBRE;
        //$direccion = $key->DIRECCION;
        $uso = $key->USO_CFDI;
        $mp = $key->METODO_PAGO;
        $fp = $key->FORMADEPAGOSAT;
        $factura = $key->NOTAS_CREDITO;
        $status = $key->STATUS;
    }?>
    <b>
    <p>Cliente:<?php echo $cliente?></p>
    <p>Uso CFDI:<?php echo $uso?></p>
    <p>Metodo de Pago:<?php echo $mp?></p>
    <p>Forma de Pago:<?php echo $fp?></p>
    <p>Facturas: <?php echo $factura?></p>
    <?php if($status==7 and substr($docnc,0,3) == 'NCD'){?>
    <p><button onclick="timbrar('<?php echo $factura?>', '<?php echo $docnc?>')" id="timbrar">Timbrar</button>
    <?php }elseif(substr($docnc,0,3)=='NCI'){?>
        <form action="index.php" method="post">
        <p><font size="4pxs" color="blue"><button>Imprimir Nota de Credito Interna</button></font></p>
        <input type="hidden" name="imprimeNCI">
        <input type="hidden" name="factura" value="<?php echo $docnc?>">
        </form>
    <?php }else{?>
        <p><font size="4pxs" color="blue">Ya procesada, puede descargar el pdf y xml desde la pantalla Ver Facturas</font></p>
    <?php }?>
    </b>
</div>
<div id="boton">
    
</div>
                
<br/>
<div class="row">
                <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalles de la <font size="3.5pxs" color="white"><?php echo $docnc?></font>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Partida</th>
                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>IVA</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th>Total</th>
                                            <th>Usuario Recepcion</th>   
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($nc as $data):
                                            $i++;   
                                            ?>
                                        <tr id="titulo_<?php echo $i?>">
                                            <td><?php echo $data->DOCUMENTO?></td>
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->ARTICULO.'<br/>'.$data->CLAVE_SAT.'<br/>'.$data->MEDIDA_SAT?></td>
                                            <td><?php echo $data->CANTIDAD?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo '$ '.number_format($data->PRECIO,2)?></td>
                                            <td><?php echo '% '.$data->IMP1?></td>
                                            <td><?php echo '$ '.number_format($data->DESC1,2)?></td>
                                            <td><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                                            <td><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                                            <td><?php echo $data->USUARIO?><br/>
                                            </td>           
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
        </div>
    </div>

<br />

<form action="index.php" method="POST" id="recOC">
    <input type="hidden" value="" id="doc" name="doco">
    <input type="hidden" value="" id="tip" name="tipo">
    <input type="hidden" value="" id="btn1" name="recibirOC">
</form>

<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function timbrar(docn, docf){
            if(confirm('Desea procesar la NC para la factura' + docn)){
                document.getElementById('timbrar').classList.add('hide');
                $.ajax({
                    url:'index.php',
                    method:'post',
                    dataType:'json',
                    data:{timbraNC:1, docn:docn, docf:docf},
                    success:function(data){
                       
                        $.ajax({
                            url:'index.php',
                            method:'post',
                            dataType:'json',
                            data:{imprimeFact:1,factura:data.factura}
                        });
                        var rfc = data.rfc; 
                        var factura=data.factura;
                        var fecha = data.fecha;
                        var archivo = rfc+'('+factura+')'+fecha;
                       
                        document.getElementById("boton").innerHTML="<a href='/Facturas/facturaPegaso/"+factura+".pdf' download> <img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a> <a href='/Facturas/facturaPegaso/"+factura+".xml' download> <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>";
                         alert('Se timbro correctamente la Nota de credito');
                    }
                });
            }
    }
        
    function cancelar(){
        alert('Se debde de cancelar la NC');
    }

</script>
