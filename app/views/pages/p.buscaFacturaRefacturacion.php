<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="POST">
          <div class="form-group">
            <input type="text" name="docf" class="form-control" placeholder="Numero de Factura">
            <input type="hidden" name="opcion" value="<?php echo $opcion?>">
          </div>
          <button type="submit" value = "enviar" name = "buscaFacturaNC" class="btn btn-default">Buscar</button>
          </form>
    </div>
</div>

<?php 
    $validacion =0;  
    if(!empty($historico)){
        foreach($historico as $val){    
        if($val->STATUS_SOLICITUD >= 0){
            $validacion = 1;
        }     
    }
    
}?>
<?php if(!empty($factura)){?>
<div>
    <label> Usted desea refacturar la factura <font color="blue"> <?php echo $docf?></font>?, debera seleccionar el motivo de la refacturacion.</label>
</div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Seleccionar factura para refacturacion.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Factura</th>
                                            <th>Fecha elaboración</th>
                                            <th>Importe</th>
                                            <th>Pagos Aplicados </th>
                                            <th>NC Aplicadas</th>
                                            <th>Importe NC</th>
                                            <th>Saldo</th>
                                            <th>Vendedor</th>  
                                            <th>Documento Origen</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php foreach ($factura as $data):?>
                                        <tr <?php echo ($data->SALDOFINAL <= 10)? "title='Lo sentimos no se puede refacturar una factura saldada, favor de revisar con el gerente...'":"title='Al refacturar se le dara aviso al gerente y al vendedor de este movimiento...'" ?>>                                            
                                            <td><?php echo '('.$data->CVE_CLPV.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2,'.',',');?></td>
                                            <td><?php echo '$ '.number_format($data->PAGOS,2,'.',',');?></td>
                                            <td><?php echo $data->NC_APLICADAS;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_NC,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2,'.',',');?></td>
                                            <td><?php echo $data->VENDEDOR_REAL;?></td>
                                            <td><?php echo $data->PEDIDO?></td>
                                            <form action="index" method="POST">
                                            <input type="hidden" name="docf" value="<?php echo $data->CVE_DOC?>" id="factura">
                                            <td>
                                                <?php if($data->SALDOFINAL >=10 & $validacion == 0 ){?>
                                                <select required="required" nombre = "tipo" id="tipo" onchange="enviar()" >
                                                    <option value="">Seleccionar un tipo</option>
                                                    <option value="fec"> Cambio de Fecha </option>
                                                    <!--<option value="dir"> Cambio Direccion </option>-->
                                                    <option value="cli"> Cambio de Cliente</option>
                                                    <!--<option value="pre"> Cambio en precios </option>-->
                                                </select>
                                                <?php }?>
                                            </td>
                                        </form>
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

<?php if(!empty($historico)){?>
    <div>
    <label> HISTORICO DE RAFACTURACIONES DEL DOCUMENTO</label>
</div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Historico de las refacturacion del documento.<br/>
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
                                        <?php foreach ($historico as $data2):
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
                                        ?>
                                        <tr>
                                            <td><?php echo $data2->ID?> <br/> <?php echo $data2->TIPO_SOLICITUD?></td>                                         
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
<?php } ?>

<?php }else{?>
    
    <?php if(!empty($docf)){?>
        <label> <font size="6">No se encontro la factura <font color="red"> <?php echo $docf?></font>, favor de verificarlo...</font> </label>
    <?php }?>
<?php }?>

<div class="hide" id="fecha">
    
    <label><font size="6">Selecciono la Refacturacion por fecha, por favor seleccionar la fecha correcta, recuerda que solo se puede elejir fechas igual o posterior al dia de hoy:</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Seleccione la nueva fecha: <input type="text" name="nfecha" class="date" required="required"></label><br/>
        <label>Observaciones </label><input type="text" name="obs" placeholder="Observaciones" required="required" id="obs" size="250"><br/>
        <input type="hidden" name="opcion" value="1">
        <button value="enviar" name="refacturarFecha" class="btn btn-info" > Solicitar </button>
    </form>
</div>

<div class="hide" id="dir">
    <label><font size="6">La Nueva Direccion de Envio del cliente:</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Calle: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<input type="text" name="calle" size="50" required="required" placeholder="Calle"> &nbsp; Numero Exterior:<input type="text" name="exterior" size="20" placeholder="Num. Ext." required="required"> </label> &nbsp; &nbsp; Numero Interior: <input type="text" name="interior" size="20" placeholder="Num. Int" value=""><br/>
        <label>Colonia:&nbsp; &nbsp;&nbsp; &nbsp;</label><input type="text" name="colonia" placeholder="Colonia" required="required" id="obs" size="50"><br/>
        <label>Municipio:&nbsp;&nbsp;<input type="text" name="municipio" required="required" size="50" placeholder="Municipio"> </label><br/>
        <label>Ciudad: &nbsp; &nbsp;&nbsp; &nbsp;<input type="text" name="ciudad" required="required" size="50" placeholder="Ciudad"></label><br/>
        <label>Referencia:&nbsp;<input type="text" name="referencia" size="100" placeholder="Referencia" value=""> CP:&nbsp;&nbsp; <input type="text" name="cp" required="required" placeholder="CP" size="10" > </label><br/>
        <label>Observaciones:<input type="text" name="obs" size="255" placeholder="Observaciones" required="required"></label><br/>
        <input type="hidden" name="opcion" value="3">
        <button value="enviar" name="refacturarDireccion" class="btn btn-info" > Solicitar </button>
    </form>
</div>
<div class="hide" id="cli">
    <label><font size="6">Cambio de cliente:</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Cliente Nuevo: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<br/>
            <select name="nfecha" required="required">
                <option value="">Seleccione el Cliente Nuevo</option>
                <<?php foreach ($cliente as $key): ?>
                    <option value="<?php echo $key->CLAVE?>"><?php echo $key->CLAVE?> - <?php echo $key->NOMBRE ?></option>
                <?php endforeach ?>
            </select>
            <br/>
        <label>Observaciones </label><input type="text" name="obs" placeholder="Observaciones" required="required" id="obs"><br/>
        <input type="hidden" name="opcion" value="2">
        <button value="enviar" name="refacturarFecha" class="btn btn-info" > Solicitar </button>
    </form>
</div>
<div class="hide" id="pre">
    <label><font size="6">Cambio de precios en Productos:</font></label>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Seleccionar los precios que se cambiaran por partida.
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
                                            <td align="right"><input type="number" step="any" name="nuevoPrecio" onchange="totales(<?php echo $partida->NUM_PAR?>,this.value)" id="nuevoPrecio_<?php echo $partida->NUM_PAR?>"><br/><input type="text" size ="8" id="diferencia_<?php echo $partida->NUM_PAR?>" value="0" readonly></td>
                                            <td align="right"><input type="text" size="10" name="nuecoSubTotal" value="0" id="nst_<?php echo $partida->NUM_PAR?>" readonly></td>
                                            <td align="right"><input type="text" size="10" name="ni" id="ni_<?php echo $partida->NUM_PAR?>" value="0" readonly></td>
                                            <td align="right"><input type="text" size="10" name="nt" value="0" id="nt_<?php echo $partida->NUM_PAR?>" readonly> <br/> <input type="text" name="difTot" id="difTotal_<?php echo $partida->NUM_PAR?>" readonly></td>

                                            <input type="hidden" name="cantidad" value="<?php echo $partida->CANT?>" id="cant_<?php echo $partida->NUM_PAR ?>">
                                            <input type="hidden" name="base" value="<?php echo $partida->PREC?>" id="base_<?php echo $partida->NUM_PAR?>">
                                            <input type="hidden" name="docf" id="docf_<?php echo $partida->NUM_PAR?>" value="<?php echo $partida->CVE_DOC?>">
                                        </tr>


                                        <?php endforeach;?>
                                 </tbody>
                            </table>
                              <button class="btn btn-success" onclick="solicitudPrecio(<?php echo $i?>)">Solicitar</button>
                              <input type="hidden" name="iterador" value="<?php echo $i?>" id="iterador?>">
                      </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>


    function solicitudPrecio(p){
        var difTotal = 0;
        document.getElementById('tipo').classList.add('hide');
        for(var i =1; i <= p; i++){
            var pn = document.getElementById('difTotal_'+i).value;
            difTotal = difTotal + pn;
        }
        if(difTotal != 0 ){
            if(confirm('Se procede a la solicitud')){
                
                for(var a = 1; a <=p; a++){
                   
                    var dif= document.getElementById('difTotal_'+a).value;
                    var nuevoPrecio = document.getElementById('nuevoPrecio_'+a).value;
                    var docf = document.getElementById('docf_'+a).value;
                    if(nuevoPrecio != 0){
                        $.ajax({
                            type:"POST",
                            url:"index.php",
                            dataType: "json",
                            data: {guardaPartida:a, precio:nuevoPrecio, partida:a, docf:docf},
                            success: function(data){
                                if(data.status == 'ok'){
                                    alert('Se cambio el precio ...');
                                    $.ajax({
                                        type:"POST",
                                        url:"index.php",
                                        dataType:"json",
                                        data:{solicitudPrecio:1, docf:docf},
                                        success: function(data){
                                            alert('Creo la solicitud....');
                                            window.location.reload(true); 
                                                }
                                        });
                                }else{
                                    alert('No se puede crear por que hay una solicitus en proceso ' );
                                    window.location.reload(true); 
                                }
                            }
                        });    
                    }
                }                   
            }   
        }else{
            alert('No se Detecto diferencia en los totales, favor de revisar');        }
    }


    function totales(P, precio, precioBase){

        var cantidad = parseFloat(document.getElementById('cant_'+P).value,2);
        var precio = parseFloat(precio,2);
        var base = parseFloat(document.getElementById('base_'+P).value,2);
        var dif = (base - precio) * -1; 
        var NST = precio * cantidad;
        var NI = (precio * cantidad) * .16;
        var NT = (precio * cantidad) * 1.16;

        var T = (base * cantidad) *1.16;
        var difTot = (T - NT) *-1

        alert('la diferencia es: ' + dif + ' Base: '+ precio + ' base: '+ base );
        document.getElementById('nst_' + P).value = NST.toFixed(2);
        document.getElementById('ni_'+ P).value = NI.toFixed(2);
        document.getElementById('nt_'+P).value=NT.toFixed(2); 
        document.getElementById('diferencia_'+P).value=dif.toFixed(2);
        document.getElementById('difTotal_'+P).value = difTot.toFixed(2);
    }

  $(document).ready(function() {
    $(".date").datepicker({dateFormat: 'dd.mm.yy'});
  } );
    function enviar(){
        var docf = document.getElementById('factura').value;
        var tipo = document.getElementById('tipo').value;
        
        if(tipo==''){
            alert('Debe seleccionar un tipo y el campo de observacion no debe estar vacio');
        }else{
                if(tipo == 'fec'){
                    document.getElementById("fecha").classList.remove('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');

                }else if( tipo == 'dir'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.remove('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');
                }else if(tipo == 'cli'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.remove('hide');
                    document.getElementById("pre").classList.add('hide');

                }else if(tipo == 'pre'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.remove('hide');

                }                   
            }
        }

</script>