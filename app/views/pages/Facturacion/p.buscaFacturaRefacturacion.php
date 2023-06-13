
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
                                            <th>NC Aplicadas <br/> 
                                                <?php if($tipoUsuario == 'G'){?>
                                                <a class="rnc">Nota de Credito</a>                                                    
                                                <?php }?>
                                            </th>
                                            <th>Importe NC</th>
                                            <th>Saldo</th>
                                            <th>Vendedor</th>  
                                            <th>Documento Origen</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php foreach ($factura as $data):
                                            $clie = $data->CVE_CLPV;?>
                                        <tr <?php echo ($data->SALDOFINAL <= 10)? "title='Lo sentimos no se puede refacturar una factura saldada, favor de revisar con el gerente...'":"title='Al refacturar se le dara aviso al gerente y al vendedor de este movimiento...'" ?>>                                            
                                            <td><?php echo '('.$data->CVE_CLPV.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_DOC.'<br/>'.$data->CAJA;?></td>
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
                                                <?php if($data->SALDOFINAL >=10 & $validacion == 0 & !empty($data->CAJA)){?>     
                                                <select required="required" nombre = "tipo" id="tipo" onchange="enviar()" >
                                                    <option value="">Seleccionar un tipo</option>
                                                    <option value="fec"> Cambio de Fecha </option>
                                                    <option value="dir"> Cambio Direccion </option>
                                                    <option value="cli"> Cambio de Cliente</option>
                                                    <option value="pre"> Cambio en precios </option>
                                                    <option value="sat">Cambio de Datos Fiscales</option>
                                                    <option value="cancela"> Cancela y Sustituye</option>
                                                    <?php if(substr($data->CVE_DOC,0,3) == 'FAA' or (substr($data->CVE_DOC,0,2)== 'RF' and substr($data->CVE_DOC,0,3) != 'RFP')){?>
                                                    <option value="migrar">Migrar factura</option>
                                                    <?php }?>
                                                    <?php if(  strpos(strtoupper($data->NOMBRE_MAESTRO) ,'SUBURBIA') !== false && $tipoUsuario== 'G'){?>
                                                        <option value="suburbia">Descuento Logistico Suburbia </option>
                                                    <?php }?>
                                                </select>
                                                <?php }else{?>
                                                    <a onclick="buscaCaja('<?php echo $data->CVE_DOC?>')">Sin Caja<br/>Buscar Caja</a>
                                                <?php }?>
                                            </td>                                            
                                        </form>
                                        <input type="hidden" name="saldo" id="info" value="<?php echo '$ '.number_format($data->SALDOFINAL,2)?>" nombre="<?php echo $data->NOMBRE?>" clave="<?php echo $data->CVE_CLPV?>" fact="<?php echo $data->CVE_DOC?>" imp="<?php echo '$ '.number_format($data->IMPORTE,2)?>" pagos="<?php echo '$ '.number_format($data->IMPORTE_NC+$data->PAGOS,2)?>" s="<?php echo $data->SALDOFINAL?>" p="<?php echo $data->IMPORTE_NC+$data->PAGOS?>" i="<?php echo $data->IMPORTE?>" c="<?php echo $data->CAJA?>" d="<?php echo $data->CVE_DOC?>">
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
                                            if($data2->STATUS_SOLICITUD == 0){
                                                $STATUS = 'Nueva';
                                            }elseif($data2->STATUS_SOLICITUD == 1){
                                                $STATUS = 'Autorizado / Sin Ejecutar';
                                            }elseif($data2->STATUS_SOLICITUD == 2){
                                                $STATUS = 'Rechazado';
                                            }elseif($data2->STATUS_SOLICITUD == 3){
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

<div class="hide" id="cys">
    <label><font size="6">Cancela y Sustituye:</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Observaciones </label><input type="text" name="obs" size="200" placeholder="Observaciones" required="required" id="obs">
        <input type="hidden" name="opcion" value="6">
        <input type="hidden" name="nfecha" value="">
        <button value="enviar" name="refacturarFecha" class="btn btn-info" > Solicitar </button>
    </form>
</div>

<div class="hide" id="sat">
    <label><font size="6">Datos Fiscales :</font></label>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <label>Nuevos datos Fiscales: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<br/>
            
            <label>Colocar los datos Fiscales</label> <br/>
            <br/>Uso de CFDI     : <select name="satUso" required class="uso">
                <option value="">"Uso CFDI"</option>
                <option value="G01">"G01 Adquisición de mercancias"</option>
                <option value="G02">"G02 Devoluciones, descuentos o bonificaciones"</option>
                <option value="G03">"G03 Gastos en general"</option>
                <option value="I01">"I01 Construcciones"</option>
                <option value="I02">"I02Mobilario y equipo de oficina por inversiones"</option>
                <option value="I03">"I03Equipo de transporte"</option>
                <option value="I04">"I04Equipo de computo y accesorios"</option>
                <option value="I05">"I05Dados, troqueles, moldes, matrices y herramental"</option>
                <option value="I06">"I06Comunicaciones telefónicas"</option>
                <option value="I07">"I07Comunicaciones satelitales"</option>
                <option value="I08">"I08Otra maquinaria y equipo"</option>
                <option value="P01">"P01 Por definir"</option>
            </select><br/>
            <br/>Tipo de pago    : <select name="satMP" required class="tpago">
                <option value="">"Metodo de Pago"</option>
                <option value="PUE">"PUE Pago en una sola exhibición"</option>
                <option value="PPD">"PPD Pago en parcialidades o diferido"</option>
            </select><br/>
            <br/>Forma de Pago: <select name="satFP" required class="mpago">
                <option value="">"Forma de Pago"</option>
                <option value="03">"03 Transferencia Electronica de Fondos"</option>
                <option value="01">"01 Efectivo"</option>
                <option value="02">"02 Cheque Nominativo"</option>
                <option value="04">"04 Tarjeta de Credito"</option>
                <option value="05">"05 Monedero Electronico"</option>
                <option value="15">"15 Condonacion"</option>
                <option value="17">"17 Compensacion"</option>
                <option value="30">"30 Aplicacion de Anticipos"</option>
                <option value="99">"99 Por Definir"</option>
            </select><br/>
            <br/>
        <label>Observaciones </label><input type="text" name="obs" placeholder="Observaciones" required="required" id="obs"><br/>
        <input type="hidden" name="opcion" value="3">
        <button value="enviar" name="refacturarSAT" class="btn btn-info" > Solicitar </button>
    </form>
</div>


<div class="hide" id="pre">
    <div>
        <input type="hidden" name="docf" value="<?php echo $docf?>" id= >
        <label>Cliente Nuevo: &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<br/>
            <select name="nfecha" required="required" id="nfecha">
                <option value="<?php echo $clie?>">Seleccione el Cliente Nuevo</option>
                <?php foreach ($cliente as $key): ?>
                    <option value="<?php echo $key->CLAVE?>"><?php echo $key->CLAVE?> - <?php echo $key->NOMBRE ?></option>
                <?php endforeach ?>
            </select>
    </div>
    <div>
        <p><b>Colocar los datos Fiscales</b></p>
            <br/>Uso de CFDI     : <select name="satUso" required class="uso" id="satUso">
                <option value="">"Uso CFDI"</option>
                <option value="G01">"G01 Adquisición de mercancias"</option>
                <option value="G02">"G02 Devoluciones, descuentos o bonificaciones"</option>
                <option value="G03">"G03 Gastos en general"</option>
                <option value="I01">"I01 Construcciones"</option>
                <option value="I02">"I02Mobilario y equipo de oficina por inversiones"</option>
                <option value="I03">"I03Equipo de transporte"</option>
                <option value="I04">"I04Equipo de computo y accesorios"</option>
                <option value="I05">"I05Dados, troqueles, moldes, matrices y herramental"</option>
                <option value="I06">"I06Comunicaciones telefónicas"</option>
                <option value="I07">"I07Comunicaciones satelitales"</option>
                <option value="I08">"I08Otra maquinaria y equipo"</option>
                <option value="P01">"P01 Por definir"</option>
            </select><br/>
            <br/>Tipo de pago    : <select name="satMP" required class="tpago" id="satMP">
                <option value="">"Metodo de Pago"</option>
                <option value="PUE">"PUE Pago en una sola exhibición"</option>
                <option value="PPD">"PPD Pago en parcialidades o diferido"</option>
            </select><br/>
            <br/>Forma de Pago: <select name="satFP" required class="mpago" id="satFP">
                <option value="">"Forma de Pago"</option>
                <option value="03">"03 Transferencia Electronica de Fondos"</option>
                <option value="01">"01 Efectivo"</option>
                <option value="02">"02 Cheque Nominativo"</option>
                <option value="04">"04 Tarjeta de Credito"</option>
                <option value="05">"05 Monedero Electronico"</option>
                <option value="15">"15 Condonacion"</option>
                <option value="17">"17 Compensacion"</option>
                <option value="30">"30 Aplicacion de Anticipos"</option>
                <option value="99">"99 Por Definir"</option>
            </select><br/>
            <br/>
        <p>Observaciones </p><input type="text" name="obs" placeholder="Observaciones" required="required" id="obs2"><br/>
 </div>
    <p><font size="6">Cambio de precios en Productos:</font></p>
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
                                            ?>
                                        <tr>                                            
                                            <td><?php echo $partida->NUM_PAR;?></td>
                                            <td><?php echo $partida->CANT;?></td>
                                            <td><input type="number" name="ncant" value="<?php echo $partida->CANT?>" id="ncant_<?php echo $partida->NUM_PAR?>" Style='width:70px' onchange="totales(<?php echo $partida->NUM_PAR?>, nuevoPrecio_<?php echo $partida->NUM_PAR?>.value)"></td>
                                            <td><?php echo $partida->CVE_ART?></td>
                                            <td><?php echo $partida->NOMBRE;?></td>
                                            <td align="right"><?php echo '$ '.number_format($partida->PREC,2,'.',',');?></td>
                                            <td><?php echo '$ '.number_format($partida->PREC * $partida->CANT,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * .16,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format(($partida->CANT * $partida->PREC) * 1.16,2);?></td>
                                            <td align="right"><input type="number" step="any" name="nuevoPrecio" value="<?php echo $partida->PREC?>" onchange="totales(<?php echo $partida->NUM_PAR?>,this.value)" id="nuevoPrecio_<?php echo $partida->NUM_PAR?>"><br/><input type="text" size ="8" id="diferencia_<?php echo $partida->NUM_PAR?>" value="0" readonly></td>
                                            <td align="right"><input type="text" size="10" name="nuecoSubTotal" value="0" id="nst_<?php echo $partida->NUM_PAR?>" readonly></td>
                                            <td align="right"><input type="text" size="10" name="ni" id="ni_<?php echo $partida->NUM_PAR?>" value="0" readonly></td>
                                            <td align="right"><input type="text" size="10" name="nt" value="0" id="nt_<?php echo $partida->NUM_PAR?>" readonly> <br/> <input type="text" name="difTot" id="difTotal_<?php echo $partida->NUM_PAR?>" readonly></td>

                                            <input type="hidden" name="cantidad" value="<?php echo $partida->CANT?>" id="canto_<?php echo $partida->NUM_PAR ?>">
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

<div class="hide" id="migrar">
    <p><font size="3pxs"> <b>Se migrara la factura a un folio FP, el cual no se timbrara hasta se cuadre, favor de realizar posterior mente la funcion de Cambio de precio</b></font></p>
    <form action="index.php" method="post">
        <input type="hidden" name="docf" value="<?php echo $docf?>">
        <input type="hidden" name="refacturarFecha">
        <input type="hidden" name="opcion" value="3">
        <input type="hidden" name="nfecha" value="">
        <p>Observaciones:</p>
        <p><input type="text" name="obs" placeholder="Observaciones" required="required" id="obs" size="250"></p>
        <p><button value="enviar" name="refacturarFecha" class="btn btn-info" > Solicitar </button></p>
    </form>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function buscaCaja(docf){
        if(confirm('Se buscara la caja para la factura '+docf+' y se le enviara un correo cuando se haya concluido, el proceso puede durar de 24 a 48 horas, le suplicamos sea paciente.'))
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{buscaCaja:docf}
        })
    }

    function calcula(ncn, i, p, s ){
        var res = s - ncn;
        document.getElementById('saldoNuevo').innerHTML='<b>'+res+'</b>';
    }


    $(".rnc").click(function(){
        var saldoFact= document.getElementById('info').value;
        var clienteN = document.getElementById('info').getAttribute('nombre');
        var clienteC = document.getElementById('info').getAttribute('clave');
        var factura = document.getElementById('info').getAttribute('fact');
        var importe = document.getElementById('info').getAttribute('imp');
        var pagos = document.getElementById('info').getAttribute('pagos');
        var saldoIns = document.getElementById('info').value;
        var i = document.getElementById('info').getAttribute('i');
        var s = document.getElementById('info').getAttribute('s');
        var p = document.getElementById('info').getAttribute('p');
        var caja = document.getElementById('info').getAttribute('c');
        var docf = document.getElementById('info').getAttribute('d');
         $.confirm({
            columnClass: 'col-md-4',
            title: 'Nota de Credito',
            content: '<font size="4pxs">Realizar NC por Bonificacion</font> <br/>' + 
            '<form action="index.v.php" class="formName">' +
            '<div class="form-group">'+
            '<br/>'+
            'Factura: <b>'+ factura +'</b><br/>'+
            'Cliente: <b>'+ clienteN +'</b><br/>'+
            'Importe: <b>' + importe +'</b><br/>'+
            'Pagos y NC aplicadas : <b>'+ pagos + '</b><br/>'+
            'Saldo Insoluto: <font color ="red"><b> ' + saldoIns+'</b></font><br/>'+
            'Importe Nueva NC: <br/> <input name="impNC" type="number" step="any" placeholder="Importe NC" class="impNCN" onchange="calcula(this.value,' + i +','+ p+','+ s +' )" >'+'<br/>'+
            'Saldo despues de la NC: <br/><p id="saldoNuevo">'+saldoIns +'</p><br/>' +'<br/>'+
            '<p><input type="text" name="obs" placeholder="Observaciones" class="obser"></p>'+ 
            '<input type="hidden" name="caja" value="'+caja+'">'+
            '<input type="hidden" name="realizaNCBonificacion">'+
            '</div><br/><br/>'+'<br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Crear Nota de Credito',
                btnClass: 'btn-blue',
                action: function () {
                    var importeNCN = this.$content.find('.impNCN').val(); 
                    //var maestr = this.$content.find('mae').val(); 
                    var concepto = 'Bonificacion';
                    var obs = this.$content.find('.obser').val();
                    alert('Importe Capturado: ' + importeNCN + 'Importe del Saldo' + s );
                    if(clienteC==''){
                        $.alert('No se encontro el cliente...');
                        return false;
                    }else if(factura== ''){
                        $.alert('No se encontro la Factura...');
                        return false;   
                    }else if(parseInt(importeNCN) > parseInt(s)){
                        $.alert('El importe es mayor que el saldo Insoluto del documento');
                        return false;   
                    }else if(importeNCN <= 0){
                        $.alert('No se permite notas en negativo ni en 0.00');
                        return false;
                    }else if(parseInt(s) < .01){
                        $.alert('No se permite saldos insolutos menores a 0.00');
                        return false;
                    }
                    else{
                        $.alert('Se creara la Solicitud de alta del cliente ' + clienteC);
                        $.ajax({
                            url:'index.v.php',
                            type:'post',
                            dataType:'json',
                            data:{realizaNCBonificacion:1, docf, monto:importeNCN, concepto, obs, caja },
                            success:function(data){
                                //alert('Se intenta Realizar la NC');
                                location.reload();    
                            }

                        });
                    }
                   }
            },
            cancelar: function () {
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            //alert(jc);
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
    })

    $("select").change(function(){
        var tipo = $(this).val();
        var docf = document.getElementById('factura').value;
        if(tipo == 'suburbia'){
            if(confirm('Selecciono el descuento logistico de suburbia, si continua, no podra hacer NC porsteriores.?')){
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{nclog:docf, tipo:tipo},
                    success:function(data){
                        if(data.status == 'no'){
                            alert('No se pudo validar el documento: ' + docf +', puede ser que tenga una Validacion previa.');
                            location.reload(true);
                        }else if(data.status == 'ok'){
                            alert('Se aprovo la solicitud, ahora puede realizar la NC de descuento logistico');
                            location.reload(true);
                        }
                    }
                });

            }else{
                document.getElementById('tipo').value='';
            }
        }
    })

    function solicitudPrecio(p){
        var difTotal = 0;

        var clie=document.getElementById('nfecha').value; 
        var suso = document.getElementById('satUso').value; 
        var smp = document.getElementById('satMP').value; 
        var sfp = document.getElementById('satFP').value; 
        var obs = document.getElementById('obs2').value; 

        if(suso==""||smp==""||sfp==""||obs==""){
            alert('Uso' +  suso + ", MP:" + smp + ' FP:' + sfp + ' obs: '+ obs);
            alert('Favor de llenar los datos fiscales y las observaciones.');
            return;
        }

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
                    var ncant =document.getElementById('ncant_'+a).value;
                    var cant = document.getElementById('canto_'+a).value;
                    if(nuevoPrecio != 0 || ncant != cant){
                        $.ajax({
                            type:"POST",
                            url:"index.php",
                            dataType: "json",
                            data: {guardaPartida:a, precio:nuevoPrecio, partida:a, docf:docf, ncant:ncant},
                            success: function(data){
                                if(data.status == 'ok'){
                                    //alert('Se cambio el precio ...');
                                    $.ajax({
                                        type:"POST",
                                        url:"index.php",
                                        dataType:"json",
                                        data:{solicitudPrecio:1, docf:docf, clie:clie, suso:suso, smp:smp, sfp:sfp, obs:obs},
                                        success: function(data){
                                            //alert('Creo la solicitud....');
                                            location.reload(true); 
                                                }
                                        });
                                }else{
                                    alert('No se puede crear por que hay una solicitus en proceso ' );
                                    location.reload(true); 
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
        var cantidad = parseFloat(document.getElementById('ncant_'+P).value,2);
        var canto= parseFloat(document.getElementById('canto_'+P).value,2);
        var precio = parseFloat(precio,2);
        var base = parseFloat(document.getElementById('base_'+P).value,2);
        var dif = (base - precio) * -1; 
        var NST = precio * cantidad;
        var NI = (precio * cantidad) * .16;
        var NT = (precio * cantidad) * 1.16;

        var T = (base * canto) *1.16;
        var difTot=(T-NT) * -1

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
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if( tipo == 'dir'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.remove('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if(tipo == 'cli'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.remove('hide');
                    document.getElementById("pre").classList.add('hide');
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if(tipo == 'pre'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.remove('hide');
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if(tipo == 'sat'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');
                    document.getElementById("sat").classList.remove('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if(tipo == 'cancela'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.remove('hide');
                    document.getElementById("migrar").classList.add('hide');
                }else if(tipo == 'migrar'){
                    document.getElementById("fecha").classList.add('hide');
                    document.getElementById("dir").classList.add('hide');
                    document.getElementById("cli").classList.add('hide');
                    document.getElementById("pre").classList.add('hide');
                    document.getElementById("sat").classList.add('hide');
                    document.getElementById("cys").classList.add('hide');
                    document.getElementById("migrar").classList.remove('hide');
                }                       
            }
        }

</script>