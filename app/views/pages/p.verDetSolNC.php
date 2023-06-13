<div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitudes de las refacturacion del documento.<br/>
                            Si desea ver el detalle de la solicitud dar click en el Tipo de solicitud deseado.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Solicitud <br/> Tipo de Solicitud</th>
                                            <th>Factura</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Usuario Solicitud</th>
                                            <th>Status Soliciud </th>
                                            <th>Fecha Autorizacion</th>
                                            <th>Usuario Autorizacion</th>
                                            <th>Fecha de Ejecucion</th>
                                            <th>Usuario Ejecucion</th>  
                                            <th>Nota de Credito</th>
                                            <th>Factura Nueva</th>
                                            <th>Pedio asociado</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php foreach ($solicitudes as $data2):
                                            if($data2->STATUS_SOLICITUD == 0){
                                                $STATUS = 'Nueva';
                                            }elseif ($data2->STATUS_SOLICITUD == 1) {
                                                $STATUS = 'Autorizada';
                                            }elseif($data2->STATUS_SOLICITUD == 2){
                                                $STATUS = 'Autorizado / Sin Ejecutar';
                                            }elseif($data2->STATUS_SOLICITUD == 3){
                                                $STATUS = 'Rechazado';
                                            }elseif($data2->STATUS_SOLICITUD == 4){
                                                $STATUS = 'Autorizado / Ejecutado';
                                            }elseif($data2->STATUS_SOLICITUD == 5){
                                                $STATUS = 'Autorizado / Ejecutado';
                                            }
                                            if($data2->TIPO_SOLICITUD == 'CAMBIO FECHA'){
                                                $color = "blue";
                                            }elseif ($data2->TIPO_SOLICITUD == 'CAMBIO DOMICILIO') {
                                                $color = "red";
                                            }elseif($data2->TIPO_SOLICITUD == 'CAMBIO PRECIO'){
                                                $color = "#cc00cc";
                                            }elseif($data2->TIPO_SOLICITUD == 'CAMBIO CLIENTE'){
                                                $color = "#00e64d";
                                            }  
                                            $facto = $data2->FACT_ORIGINAL;
                                            $nf=$data2->FECHA_SOLICITUD;
                                            $sol = $data2->ID;
                                            $claveAct = $data2->CVE_CLPV;
                                            $clieAct = $data2->NOMBRE;
                                            $status2 = $data2->STATUS_SOLICITUD;

                                            ?>
                                        <tr>
                                            <td><?php echo $data2->ID?> <br/><font color="<?php echo $color?>"><?php echo $data2->TIPO_SOLICITUD?> </font> </td>                         
                                            <td><?php echo $data2->FACT_ORIGINAL ?></td>
                                            <td><?php echo $data2->FECHA_SOLICITUD ?></td>
                                            <td><?php echo $data2->USUARIO_SOLICITUD ?></td>
                                            <td align="right"><?php echo $STATUS ?></td>
                                            <td><?php echo $data2->FECHA_AUTORIZA ?></td>
                                            <td><?php echo $data2->USUARIO_AUTORIZA ?></td>
                                            <td align="right"><?php echo $data2->FECHA_EJECUTA ?></td>
                                            <td align="right"><?php echo $data2->USUARIO_EJECUTA ?></td>
                                            <td><?php echo $data2->NC?></td>
                                            <td><?php echo $data2->FACTURA_NUEVA?></td>
                                            <td><?php echo $data2->PEDIDO_REMISION_ASOCIADO?></td>
                                        </tr>
                                        <?php endforeach;?>
                                 </tbody>
                            </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($tipo == 'CAMBIO CLIENTE'){ ?>
<?php 
    foreach($detalle as $data):
?>
<div id="cli">
    <label><font size="4">Cambio de cliente:</font></label>
        <label>Cliente Actual: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $claveAct.'--->'.$clieAct?></label><br/>
        <label>Cliente Nuevo: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->NUEVO_CLIENTE.'--->'.$data->NOMBRE ?></label><br/>
        <label>Observaciones: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<n><?php echo $data->OBSERVACIONES?></n> </label><br/>
        <button value="enviar" name="ejecutaRefac" class="btn btn-info" onclick="ejecutar(<?php echo $status2?>,2,<?php echo $sol?>)" > Ejecutar </button>
</div>
<?php endforeach;?>
<?php }elseif($tipo == 'CAMBIO FECHA'){?>
<?php 
    foreach($detalle as $data):
?>
<div id="fecha">
        <label>Nueva Fecha: <?php echo $data->NUEVA_FECHA ?></label><br/>
        <label>Observaciones: &nbsp;&nbsp; </label><?php echo $data->OBSERVACIONES ?><br/>
        <button value="enviar" name="ejecutaRefac" class="btn btn-info" onclick="ejecutar(<?php echo $status2?>,1,<?php echo $sol?>)" > Ejecutar </button>
</div>
<?php endforeach;?>
<?php }elseif($tipo == 'CAMBIO PRECIO'){?>

<div>
    <label><font size="6">Cambio de precios en Productos:</font></label>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                            <th>Cantidad</th>
                                            <th>Nueva Cantidad</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Precio Actual </th>
                                            <td>SubTotal Actual</td>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Precio Nuevo<br/>Diferencia</th>
                                            <th>SubTotal Nuevo</th>
                                            <th>IVA Nuevo</th>
                                            <th>Total Nuevo<br/> Diferencia</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php 
                                            $i = 0 ;
                                            foreach ($detalle as $partida):
                                                $i = $i + 1;
                                                $np = 0;
                                                if(empty($partida->CAMBIO) ){
                                                    $np = $partida->PREC;
                                                    $color = '';                                                    
                                                }else{
                                                    $np=$partida->NUEVO_PRECIO;
                                                    $color="style='background-color:#fdd2d2;'";
                                                }
                                                if(empty($partida->CAMBIO)){
                                                    $ncant = $partida->CANT;
                                                    $color = '';                                                    
                                                }else{
                                                    $ncant=$partida->NUEVA_CANTIDAD;
                                                    $color="style='background-color:#e2d2fd;'";
                                                }

                                                if( ($ncant <> $partida->CANT) and ($np <> $partida->PREC)){
                                                    $color="style='background-color:#ff687d;'";
                                                }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >   
                                        <?php echo $partida->NUEVA_CANTIDAD?>                                        
                                            <td><?php echo $partida->NUM_PAR;?></td>
                                            <td><?php echo $partida->CANT;?></td>
                                            <td><?php echo $ncant?></td>
                                            <td><?php echo $partida->CVE_ART?></td>
                                            <td><?php echo $partida->NOMBRE;?></td>
                                            <td align="right"><?php echo '$ '.number_format($partida->PREC,2,'.',',');?></td>
                                            <td><?php echo '$ '.number_format($partida->PREC * $partida->CANT,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * .16,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * 1.16,2);?></td>
                                            <td align="right"> <font color="red"> <?php echo '$ '.number_format($np,2)?></font><br/>
                                                <font color="red"> <?php echo '$ '.number_format(($partida->PREC - $np) * -1,2)?></font>
                                             </td>
                                            <td align="right"><?php echo '$ '.number_format($np * $ncant,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($np * $ncant) *.16,2)?></td>
                                            <td align="right"> <?php echo '$ '.number_format(($np * $ncant) *1.16,2)?><br/>
                                                <font color="red"><?php echo '$ '.number_format( (($ncant * $partida->PREC)* 1.16 - (($np * $partida->CANT) *1.16)) *-1  ,2) ?> </font</td>
                                            <input type="hidden" name="cantidad" value="<?php echo $partida->CANT?>" id="cant_<?php echo $partida->NUM_PAR ?>">
                                            <input type="hidden" name="base" value="<?php echo $partida->PREC?>" id="base_<?php echo $partida->NUM_PAR?>">
                                            <input type="hidden" name="docf" id="docf_<?php echo $partida->NUM_PAR?>" value="<?php echo $partida->CVE_DOC?>">
                                        </tr>
                                        <?php endforeach;?>
                                 </tbody>
                            </table>
                              <button class="btn btn-success" onclick="ejecutar(<?php echo $status2?>,4,<?php echo $sol?>)">Ejecutar</button>
                              <input type="hidden" name="iterador" value="<?php echo $i?>" id="iterador?>">
                      </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php }elseif($tipo == 'CAMBIO DOMICILIO'){ ?>
<?php 
    foreach($detalle as $data):
?>
<div class="hide" id="dir">
    <label><font size="6">La Nueva Direccion de Envio del cliente:</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Calle: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->CALLE?> &nbsp; Numero Exterior:<?php echo $data->NUM_EXTERIOR ?> </label> &nbsp; &nbsp; Numero Interior: <?php echo $data->NUM_INETERIOR?><br/>
        <label>Colonia:&nbsp; &nbsp;&nbsp; &nbsp;</label><?php echo $data->COLONIA?><br/>
        <label>Municipio:&nbsp;&nbsp;<?php echo $data->MUNICIPIO?> </label><br/>
        <label>Ciudad: &nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->ESTADO?></label><br/>
        <label>Referencia:&nbsp;<?php echo $data->REFERENCIA?> CP:&nbsp;&nbsp; <?php echo $data->CP ?> </label><br/>
        <label>Observaciones:<?php echo $data->OBSERVACIONES?></label><br/>
        <input type="hidden" name="opcion" value="3">
        <button value="enviar" name="refacturarDireccion" class="btn btn-info" > Solicitar </button>
    </form>
</div>
<?php endforeach;?>

<?php }elseif($tipo == 'CAMBIO SAT'){?>
    <label><font size="4">Cambio de Datos Fiscales:</font></label>
        <?php foreach($detalle as $data)?>
        <label>Uso : &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->SAT_USO_ACTUAL.'---  Cambia a --->'.$data->SAT_USO_NUEVO?></label><br/>
        <label>Forma de Pago: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->SAT_FP_ACTUAL.' --- Cambia a --->'.$data->SAT_FP_NUEVO ?></label><br/>
        <label>Metodo de Pago: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?php echo $data->SAT_MP_NUEVO.' --- Cambia a --->'.$data->SAT_MP_NUEVO ?></label><br/>
        <label>Observaciones: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<n><?php echo $data->OBSERVACIONES?></n> </label><br/>
        <button value="enviar" name="ejecutaRefac" class="btn btn-info" onclick="ejecutar(<?php echo $status2?>,5,<?php echo $sol?>)" > Ejecutar </button>
<?php }elseif($tipo == 'Cancela y Sustituye'){?>
    <p><font size="4">Cancela y Sustituye</font></p>
    <p>Se cancelara la Factura <?php echo $facto?> y se creara una nueva con el folio FP.</p>
    <button value="enviar" name="ejecutaRefac" class="btn btn-info" onclick="ejecutar(<?php echo $status2?>,6,<?php echo $sol?>)" > Ejecutar </button>
<?php }?>

<form action="index.php" method="POST" id="formEnvio">
    <input type="hidden" name="ejecutaRefac" value="ejecutaRefac">
    <input type="hidden" name="opcion" id="opcionOut">
    <input type="hidden" name="sol" value="" id="solOut">
</form>

<script type="text/javascript">
    function ejecutar(status, opcion, sol){
        if(status == 10 ){
            alert('Debe primero generar al Nota de Credito');
        }else if(status == 1 || status == 0 ){
            if(opcion == 6){
                var mensaje = 'Al ejecutar se cancelara la Factura y se creara una nueva factura de la serie FP, desea continuar?...';
            }else{
                var mensaje = 'Al ejecutar se creara la Nota de Credio y la nueva factura, desea proceder?...';
            }
            if(confirm(mensaje)){
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{chkstat:sol},
                    success:function(data){
                        if(data.status.trim() == "ok"){
                            document.getElementById('opcionOut').value=opcion;
                            document.getElementById('solOut').value=sol;
                            var form=document.getElementById('formEnvio');
                            form.submit();
                        }else if(data.status== "ejecutado"){
                            alert('La solicitud ya ha sido procesada por ' + data.usuario + ' en la fecha ' + data.fecha + ' y el resultado es la NC '+ data.nc +' con la Refactura: ' + data.rf  );
                        }else{
                            alert('Puede ser que la factura esta siendo procesada por otro colaborador de Ferretera Pegaso, favor de esperar 10 segundos he intentar de nuevo, gracias');
                        }
                    },
                    error:function(data){
                        alert('Algo salio mal, favor de esperar 10 segundos y volver a intentar, si el error continua, le pedimos mil disculpas y lo avise al correo info@ftcenlinea.com , Ferretera Pegaso le agradece su colaboracion, gracias por su colaboracion.')
                    }
                })
            }else{
            }
        }else if(status == '5'){
            alert('Ya se ejecuto esta refacturacion.');
            location.reload(true);
        }
    }

</script>