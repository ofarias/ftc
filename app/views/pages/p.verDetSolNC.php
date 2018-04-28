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
                                            if($data2->STATUS_SOLICITUD == 1){
                                                $STATUS = 'Nueva';
                                            }elseif($data2->STATUS_SOLICITUD == 2){
                                                $STATUS = 'Autorizado / Sin Ejecutar';
                                            }elseif($data2->STATUS_SOLICITUD == 3){
                                                $STATUS = 'Rechazado';
                                            }elseif($data2->STATUS_SOLICITUD == 4){
                                                $STATUS = 'Autorizado / Ejecutado';
                                            }else{
                                                $STATUS = 'Otro';
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
<?php echo $tipo?>
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
<?php 
    foreach($detalle as $partida):
?>
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
                                            ?>
                                        <tr>                                            
                                            <td><?php echo $partida->NUM_PAR;?></td>
                                            <td><?php echo $partida->CANT;?></td>
                                            <td><?php echo $partida->CVE_ART?></td>
                                            <td><?php echo $partida->NOMBRE;?></td>
                                            <td align="right"><?php echo '$ '.number_format($partida->PREC,2,'.',',');?></td>
                                            <td><?php echo '$ '.number_format($partida->PREC * $partida->CANT,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * .16,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * 1.16,2);?></td>
                                            <td align="right"> <font color="red"> <?php echo '$ '.number_format($partida->NUEVO_PRECIO,2)?></font><br/>
                                                <font color="red"> <?php echo '$ '.number_format(($partida->PREC - $partida->NUEVO_PRECIO) * -1,2)?></font>
                                             </td>
                                            <td align="right"><?php echo '$ '.number_format($partida->NUEVO_PRECIO * $partida->CANT,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->NUEVO_PRECIO * $partida->CANT) *.16,2)?></td>
                                            <td align="right"> <?php echo '$ '.number_format(($partida->NUEVO_PRECIO * $partida->CANT) *1.16,2)?><br/>
                                                <font color="red"><?php echo '$ '.number_format( (($partida->CANT * $partida->PREC)* 1.16 - (($partida->NUEVO_PRECIO * $partida->CANT) *1.16)) *-1  ,2) ?> </font</td>

                                            <input type="hidden" name="cantidad" value="<?php echo $partida->CANT?>" id="cant_<?php echo $partida->NUM_PAR ?>">
                                            <input type="hidden" name="base" value="<?php echo $partida->PREC?>" id="base_<?php echo $partida->NUM_PAR?>">
                                            <input type="hidden" name="docf" id="docf_<?php echo $partida->NUM_PAR?>" value="<?php echo $partida->CVE_DOC?>">
                                        </tr>


                                        <?php endforeach;?>
                                 </tbody>
                            </table>
                              <button class="btn btn-success" onclick="solicitudPrecio(<?php echo $i?>)">Ejecutar</button>
                              <input type="hidden" name="iterador" value="<?php echo $i?>" id="iterador?>">
                      </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php endforeach;?>
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

<?php }?>

<form action="index.php" method="POST" id="formEnvio">
    <input type="hidden" name="ejecutaRefac" value="ejecutaRefac">
    <input type="hidden" name="opcion" id="opcionOut">
    <input type="hidden" name="sol" value="" id="solOut">
    
</form>


<script type="text/javascript">
    
    function ejecutar(status, opcion, sol){

        if(status == 1){
            alert('Debe primero generar al Nota de Credito');
        }else if(status == 5){
            document.getElementById('opcionOut').value=opcion;
            document.getElementById('solOut').value=sol;
            var form=document.getElementById('formEnvio');
            form.submit();
        }
    }

</script>