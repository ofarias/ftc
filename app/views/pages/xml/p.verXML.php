<br/>
<br/>
<input type="hidden" id="anio" value="<?php echo $a?>" >
<?php if($cnxcoi == 'si'){?>
<?php foreach($infoCabecera as $pol){
    $polizas=$pol->POLIZA;
    if($_SESSION['rfc'] == $pol->RFCE){
        $tipo = 'Ingreso';
        $tx = 'Cliente';
    }else{
        $tipo = 'Egreso';
        $tx='Proveedor';
    }
}
?>
<div >
    <input type="button" name="grabaP" onclick="grabaParam('<?php echo $ide?>')" class="btn btn-info" value="Guarda Parametros">
    <input type="hidden" name="tipoxml" id="tipoxml" value="<?php echo substr($ide, 0, -1)?>">
<br/><br/>
    <?php if(empty($pol->PROVI)){?>
        <input type="button" name="grabaP" onclick="crearPolizas('<?php echo $ide?>')" class="btn btn-success" value="Crear Polizas Provision">
        <br/> <b><?php echo $polizas?></b>
    <?php }else{?>
        <b><?php echo $polizas?></b><br/>
    <?php }?>
    <?php if(empty($pol->IDPAGO)){?>
        <input type="button" name="banco" onclick="banco('<?php echo $ide?>')" class="btn btn-info" value="Registro Edo Cta" >
    <?php }else{?>
        <label><?php echo strtoupper($pol->TP_TES).' registrado en '.$pol->BANCO .', fecha: &nbsp;&nbsp;&nbsp;'.substr($pol->FECHA_EDO_CTA,0,10)?></label>
        <?php if($pol->STATUS == 'D' ){?>
            <button onclick="polizaFinal('<?php echo $pol->UUID?>', '<?php echo $tipo?>', <?php echo $pol->IDPAGO?>)" class="btn btn-success">
            Poliza de <?php echo $tipo?>
            </button>
        <?php }?>
        <br/>
    <?php }?>
</div>
<?php }else{ ?>
    <label><font size="5 pxs"> <b>NO SE DETECTO CONEXIÓN CON ASPEL COI.</b></font></label>
<?php }?>
<br/><br/>
 <?php foreach ($infoCabecera as $key0){ 
        $rfcEmpresa = $_SESSION['rfc'];
        $rfce = $key0->RFCE;
        $rfc=$key0->CLIENTE;
        $serie=$key0->SERIE;
        $folio=$key0->FOLIO;
        $uuid=$key0->UUID;
        if($rfcEmpresa == $rfce){
            $r=$rfc; 
        }else{
            $r=$rfce;
        }
    }
?>
<?php if($cnxcoi=='si'){?>
    <?php $dig=$param->NIVELACTU;
        for ($i=1; $i <= $dig ; $i++) { 
            $b = "DIGCTA".$i;
            $c=$param->$b;    
            $p[]=($c);
        }                                                         
    ?>
<?php }?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                
                                <p><?php echo 'Usuario: '.$_SESSION['user']->NOMBRE?><br/><?php echo 'XMLs '.$ide?></p>
                                <p><?php echo 'RFC seleccionado: '.$_SESSION['rfc']?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/'.$ide.'/'.$r.'/'.$rfce.'-'.$serie.$folio.'-'.$uuid.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='55' height='60'></a>&nbsp;&nbsp;
                                        <!--<a href="javascript:impFact(<?php echo "'".$serie.$folio."'"?>)" download><img border='0' src='app/views/images/pdf.jpg' width='55' height='60'></a>-->
                                        <a href="index.php?action=imprimeUUID&uuid=<?php echo $uuid?>" onclick="alert('Se ha descargar tu factura, revisa en tu directorio de descargas')"><img border='0' src='app/views/images/pdf.jpg' width='55' height='60'></a>
                                </p>
                                <p><?php echo 'Empresa Seleccionada: <b>'.$_SESSION['empresa']['nombre']."</b>"?></p>  
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>TIPO</th>
                                            <th>DOCUMENTO</th>
                                            <th>FECHA</th>
                                            <th>RFC Emisor</th>
                                            <th>RFC Receptor</th>
                                            <th>SUBTOTAL</th>
                                            <th>IVA</th>
                                            <th>RETENCION <br/>IVA</th>
                                            <th>IEPS</th>
                                            <th>RETENCION IEPS</th>
                                            <th>RETENCION <br/>ISR</th>
                                            <th>DESCUENTO</th>
                                            <th>TOTAL</th>                    
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php foreach ($infoCabecera as $key): 
                                            $color='';
                                            if($key->TIPO == 'I'){
                                                $tipo = 'Ingreso';
                                                $color =  'style="background-color:orange"';
                                            }elseif ($key->TIPO =='E') {
                                                $tipo = 'Egreso';
                                                $color = 'style="background-color:yellow"';
                                            }
                                            $rfc=$key->CLIENTE;
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td> <?php echo $key->UUID ?> </td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo $key->SERIE.$key->FOLIO?></td>
                                            <td><?php echo $key->FECHA;?> </td>
                                            <td><?php echo '<b>('.$key->RFCE.')'.$key->EMISOR."</b>"?>
                                            <?php if($cccliente == 'Sin Cuenta Actual' and $tx == 'Proveedor'){?>
                                            &nbsp;&nbsp;
                                            <a class="btn-sm btn-primary creaCuenta" uuid="<?php echo $key->UUID?>" tipo="Proveedor" >Alta de Proveedor</a>
                                            <?php }?>
                                            </td>
                                            <td><?php echo '<b>('.$key->CLIENTE.')  '.$key->NOMBRE."</b>";?>
                                                <?php if($cccliente == 'Sin Cuenta Actual' and $tx == 'Cliente'){?>
                                            &nbsp;&nbsp;
                                            <a class="btn-sm btn-primary creaCuenta" uuid="<?php echo $key->UUID?>" tipo="Cliente" >Alta de Cliente</a>
                                            <?php }?>
                                            </td>
                                            
                                            </td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA160,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA_RET,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IEPS,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IEPS_RET,2);?></td>
                                            <td><?php echo '$ '.number_format($key->ISR_RET,2)?></td>
                                            <td><?php echo '$ '.number_format($key->DESCUENTO,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTEXML,2);?> </td>
                                        </tr>
                                        
                                        <tr style="background-color: <?php echo $cccliente=='Sin Cuenta Actual'? '#DFCFF1':'#cff7c4'?>">
                                            <input type="hidden" name="cpv" value="<?php echo '('.$key->RFCE.') '.$key->EMISOR?>" id='clpv'>
                                            <input type="hidden" name="mont" value="<?php echo number_format($key->IMPORTEXML,2)?>" id="monto">
                                            <td colspan="14">
                                                <b><?php echo 'Cuenta Actual: '.$cccliente?></b>
                                                <select id="cClie" >
                                                    <option value="<?php echo empty($cccliente)? '':$rfc.':'.substr($cccliente,-21).':'.$key->UUID.':'.$key->RFCE?>">Cuentas COI </option>
                                                    <?php foreach($ccC as $data):?>
                                                        <option value="<?php echo $rfc.':'.$data->CUENTA_COI.':'.$key->UUID.':'.$key->RFCE?>"><?php echo $data->NOMBRE.'('.$data->CUENTA.')'?></option>
                                                    <?php endforeach;?>

                                                </select>
                                            </td>
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>  
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Part</th>
                                            <th>Doc</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>Unitario</th>
                                            <th>Importe</th>
                                            <th>Descuento</th>
                                            <th>Clave SAT</th>
                                            <th>Unidad SAT</th>
                                            <th>Retencion <br/>ISR (001)</th>                                            
                                            <th>Traslado <br/>IVA (002)</th>                                            
                                            <th>Retencion <br/>IVA (002)</th>                                            
                                            <th>Traslado <br/>IEPS (003)</th>                                            
                                            <th>Retencion<br/>IEPS (003)</th>                                            
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                            $ln= 0;
                                            foreach ($info as $key): 
                                                $color='';
                                                $ln++;
                                                $ccp='Sin Cuenta Definida';
                                                $valor2=$key->PARTIDA.':'.$key->CLAVE_SAT.':'.$key->UNIDAD_SAT.':';  
                                                foreach($ccpartidas as $key0){
                                                    $cuenta = $key0->NUM_CTA;
                                                    $valor='';
                                                    if($key->CUENTA_CONTABLE == $cuenta){
                                                        $ccp= $key0->NUM_CTA.'-->'.$key0->NOMBRE;
                                                        $valor= $key->PARTIDA.':'.$key->CLAVE_SAT.':'.$key->UNIDAD_SAT.':'.$key->CUENTA_CONTABLE.':'.$rfce;
                                                        break;
                                                    }
                                                }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color ?> >

                                           <td><?php echo $key->PARTIDA?></td>
                                            <td> <?php echo $key->DOCUMENTO ?> </td>
                                            <td><?php echo $key->UNIDAD;?> </td>
                                            <td><?php echo $key->CANTIDAD;?></td>
                                            <td><?php echo $key->DESCRIPCION?></td>
                                            <td><?php echo '$ '.number_format($key->UNITARIO,6);?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTE,6);?> </td>
                                            <td><?php echo '$ '.number_format($key->DESCUENTO,2)?></td>
                                            <td><?php echo $key->CLAVE_SAT.'<br/><font color ="blue" size="1.5pxs">'.$key->DESCSAT.'</font>'?></td>
                                            <td><?php echo $key->UNIDAD_SAT?></td>
                                            <td><?php echo '$ '.number_format($key->ISR,2).'<br/>'.$key->FACT_ISR.'<br/>'.$key->TASA_ISR.'<br/><b>Base:'.number_format($key->B_ISR,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IVA,2).'<br/>'.$key->FACT_IVA.'<br/>'.$key->TASA_IVA.'<br/><b>Base:'.number_format($key->B_IVA,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IVA_R,2).'<br/>'.$key->FACT_IVA_R.'<br/>'.$key->TASA_IVA_R.'<br/><b>Base:'.number_format($key->B_IVA_R,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IEPS,2).'<br/>'.$key->FACT_IEPS.'<br/>'.$key->TASA_IEPS.'<br/><b>Base:'.number_format($key->B_IEPS,2)?></td>
                                            <td><?php echo '$ '.number_format($key->IEPS_R,2).'<br/>'.$key->FACT_IEPS_R.'<br/>'.$key->TASA_IEPS_R.'<br/><b>Base:'.number_format($key->B_IEPS_R,2)?></td>
                                            <tr style="background-color: <?php echo $ccp=='Sin Cuenta Definida'? '#DFCFF1':'#cff7c4'?>">
                                                <td colspan="15">
                                                    <?php echo '<b>Cuenta Actual: '.$ccp.'#### Cambiar Cuenta --><b>'?>
                                                    <input type="text" name="cuenta" placeholder="Cuenta Contable" class="cuencont" size="120" id="cPP_<?php echo $key->PARTIDA?>" 
                                                    valor="<?php echo $valor?>" rfc="<?php echo ':'.$rfce?>" x="<?php echo $valor2?>" >
                                                </td>    
                                            </tr>
                                        </tr>
                                        <?php endforeach; ?>
                                        <input type="hidden" name="partidas" id="partidas" value="<?php echo $ln?>" >
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<input type="hidden" name="u" id='uuid' value='<?php echo $uuid?>' doc="<?php echo $serie.$folio?>">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    var a = document.getElementById('anio').value;
    //var b =19;    
    $(".cuencont").autocomplete({
        source: "index.coi.php?cuentas=1&anio=" + a,
        minLength: 3,
        select: function(event, ui){
        }
    })

    $(".creaCuenta").click(function(){
        var uuid = $(this).attr('uuid')
        var tipo = $(this).attr('tipo')
        $.confirm({
            columnClass: 'col-md-8',
            title: 'Alta de cuenta contable ' + tipo,
            content: 'Se creara la cuenta de detalle asociada a la cuenta acumulativa que usted elija' + 
            '<form action="xls_diot.php" method="post" enctype="multipart/form-data" class="formdiot">' +
            '<div class="form-group">'+
            '<br/>Seleccione la cuenta Padre (Acumulativa):'+
                '<select class="ctaPp" >'+
                    <?php foreach ($ctA as $c):?>
                        ' <option value="<?php echo $c->CUENTA_COI.$c->NIVEL?>"><?php echo $c->NOMBRE." ".$c->CUENTA?></option> ' +
                    <?php endforeach;?>
                '</select>' 
            +'<br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Crear Cuenta',
                btnClass: 'btn-blue',
                action: function () {
                    var papa = this.$content.find('.ctaPp').val()
                    exeCC(uuid, papa)    
                }
                },
                cancelar: function () {
                },
            },
        });
        //exeCC(uuid)
    })

    function exeCC(uuid, papa){
        $.confirm({
            content: function () {
                    var self = this;
                    return $.ajax({
                        url: 'index.coi.php',
                        type:'post',
                        dataType: 'json',
                        data: {creaCC:1, uuid, papa}
                    }).done(function (response) {
                        self.setContent(response.mensaje);
                        //self.setContentAppend('<br>Version: ' + response.version);
                        self.setTitle('Alta de cuentas contables en COI');
                    }).fail(function(){
                        self.setTitle('Alta de cuenta');
                        self.setContent('Ocurrio algo inesperado, favor de revisar en COI.');    
                    });
            },
            onContentReady: function(){
                setTimeout(refrescar, 3000);
            }
        });
    }

    function refrescar(){
        location.reload();
    }

    function banco(ide){
        var bancos = "a000"
        $.ajax({
            url:'index.coi.php',
            type:'post',
            dataType:'json',
            data:{verBancos:1},
            success:function(data){
                var sel = ""
                for (var i=0; i < data.length; i++){
                    var info=data[i]
                    info=info.split(":")
                    sel += "'<option value='"+info[0]+"' >"+info[2]+"->"+info[1]+"->"+info[5]+"->"+info[6]+"</option>'+"
                }
                Banco2(sel, ide)
            },
            error:function(){
                alert('Algo paso')
            }
        });    
    }

    function Banco2(sel, ide){
        var prov = document.getElementById('clpv').value
        var monto = document.getElementById('monto').value
        var uuid = document.getElementById('uuid').value
        //alert(ide)
        if(ide == 'Recibidos'){
           $.confirm({
            columnClass: 'col-md-8',
            title: 'Registro Estado de Cuenta',
            content: 'Registro de XML en el Estado de cuenta' + 
            '<form action="index.php" class="formName">' +
            '<div class="form-group">'+
            'Cuenta / Banco: <br/>'+
            '<select name="ctaB" class="ban">'+
                '<option value="">Seleccionar Cuenta de Banco</option>'+
                sel +
            '</select><br/>'+
            'Observaciones:<br/><input name="obs" class="obs" type="text" size="100" maxsize="100" placeholder="Observaciones" ><br/> '+
            'Proveedor:<br/> <input name ="provn" class="prov" type="text" size="100" maxsize="100" readonly value="'+prov +'"><br/>' +
            '<input type="hidden" class="prov" value="'+prov+'">' +
            'Monto: <br/>'+
            '<input type="text" class="mnt" readonly value="$ '+monto+'"><br/>'+
            'Tipo de Egreso: <br/>'+
            '<select class="t" name="tipo">'+
            '<option value="">Seleccione un tipo de Egreso</option>'+
            '<option value="gasto">Gasto</option>'+
            '<option value="compra">Compra de Material</option>'+
            '<option value="otro">Otro</option>'+
            '</select><br/>'+
            'Metodo de pago: <br/>'+
            '<select class="fp" name="tpago">'+
            '<option value="">Seleccione un Metodo de Pago</option>'+
            '<option value="TNS">Transferencia</option>'+
            '<option value="CHQ">Cheque</option>'+
            '<option value="EFE">Efectivo</option>'+
            '<option value="TNSDC">Transferencia x Devolucion de Compra</option>'+
            '</select><br/>'+
            'Fecha en el Estado de cuenta (Fecha de Pago): <br/><input type="date" class="fecha" name="fecha" required ><br/>'+
            '</div><br/><br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Registrar',
                btnClass: 'btn-blue',
                action: function () {
                    var cta = this.$content.find('.ban').val();
                    var obs = this.$content.find('.obs').val();
                    var t = this.$content.find('.t').val();
                    var tpago =this.$content.find('.fp').val();
                    var fecha = this.$content.find('.fecha').val();
                    //var maestr = this.$content.find('mae').val();
                    if(cta == ''){
                        $.alert('Debe de colocar una cuenta Bancaria...');
                        return false;
                    }else if(t ==''){
                        $.alert('Debe seleccionar un tipo de Egreso...');
                        return false;
                    }else if (fecha === ''){
                        $.alert('Seleccione una fecha por favor...');
                        return false;
                    }else if (tpago === ''){
                        $.alert('Seleccione un Metodo de pago por favor...');
                        return false;    
                    }else{
                        $.alert('Se registrara el cargo en el estado de cuenta con la fecha ' + fecha )
                        $.ajax({
                            url:'index.php',
                            type: 'post',
                            dataType: 'json',
                            data:{ctaXML:1, uuid, cta, obs, t, fecha, tpago},
                            success:function(data){
                                if(data.status == 'ok'){
                                    //document.getElementById('l_'+doc).classList.add('hide');
                                    //alert(data.mensaje);   
                                    location.reload(true);
                                }else if(data.status == 'no'){
                                    alert(data.mensaje);
                                }
                            },
                            error:function(){
                                alert('Ocurrio un problema al guardar los datos, favor de verificar la informacion o reportar a sistemas')
                                location.reload(true);
                            }
                        });
                    }
                   }
                },
                cancelar:function (){
                    //document.getElementById().checked=0;
                    //document.getElementById('r_'+doc).checked=0;
                    alert('No se ha realizado ningun cambio...')
                    location.reload(true)
                },
                }
            });
        }else if (ide =='Emitidos'){
            $.confirm({
            columnClass: 'col-md-8',
            title: 'Registro Estado de Cuenta',
            content: 'Registro Abono en el Estado de cuenta' + 
            '<form action="index.php" class="formName">' +
            '<div class="form-group">'+
            'Cuenta / Banco: <br/>'+
            '<select name="ctaB" class="ban">'+
                '<option value="">Seleccionar Cuenta de Banco</option>'+
                sel +
            '</select><br/>'+
            'Observaciones:<br/><input name="obs" class="obs" type="text" size="100" maxsize="100" placeholder="Observaciones" ><br/> '+
            'Cliente:<br/> <input name ="provn" class="prov" type="text" size="100" maxsize="100" readonly value="'+prov +'"><br/>' +
            '<input type="hidden" class="prov" value="'+prov+'">' +
            'Monto: <br/>'+
            '<input type="text" class="mnt" readonly value="$ '+monto+'"><br/>'+
            'Tipo de Ingreso: <br/>'+
            '<select class="t" name="tipo">'+
            '<option value="">Seleccione un tipo de Egreso</option>'+
            '<option value="venta">Ingreso Por Venta</option>'+
            //'<option value="compra">Compra de Material</option>'+
            '<option value="otroIngreso">Otro</option>'+
            '</select><br/>'+
            'Forma de Pago: <br/>'+
            '<select class="fp" name="tpago">'+
            '<option value="">Seleccione un Metodo de Pago</option>'+
            '<option value="TNS">Transferencia</option>'+
            '<option value="CHQ">Cheque</option>'+
            '<option value="EFE">Efectivo</option>'+
            '<option value="TNSDC">Transferencia x Devolucion de Compra</option>'+
            '</select><br/>'+
            'Fecha en el Estado de cuenta (Fecha de Pago): <br/><input type="date" class="fecha" name="fecha" required ><br/>'+
            '</div><br/><br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Registrar',
                btnClass: 'btn-blue',
                action: function () {
                    var cta = this.$content.find('.ban').val();
                    var obs = this.$content.find('.obs').val();
                    var t = this.$content.find('.t').val();
                    var tpago =this.$content.find('.fp').val();
                    var fecha = this.$content.find('.fecha').val();
                    //var maestr = this.$content.find('mae').val();
                    if(cta == ''){
                        $.alert('Dede de colocar una cuenta Bancaria...');
                        return false;
                    }else if(t ==''){
                        $.alert('Dede seleccionar un tipo de Ingreso...');
                        return false;
                    }else if (fecha === ''){
                        $.alert('Seleccione una fecha por favor...');
                        return false;
                    }else if (tpago === ''){
                        $.alert('Seleccione un Metodo de pago por favor...');
                        return false;    
                    }else{
                        $.alert('Se registrara el Abono en el estado de cuenta con la fecha ' + fecha )
                        $.ajax({
                            url:'index.php',
                            type: 'post',
                            dataType: 'json',
                            data:{ctaXML:1, uuid, cta, obs, t, fecha, tpago},
                            success:function(data){
                                if(data.status == 'ok'){
                                    //document.getElementById('l_'+doc).classList.add('hide');
                                    //alert(data.mensaje);   
                                    location.reload(true);
                                }else if(data.status == 'no'){
                                    alert(data.mensaje);
                                }
                            },
                            error:function(){
                                alert('Ocurrio un problema al guardar los datos, favor de verificar la informacion o reportar a sistemas')
                                location.reload(true);
                            }
                        });
                    }
                   }
                },
                cancelar:function (){
                    //document.getElementById().checked=0;
                    //document.getElementById('r_'+doc).checked=0;
                    alert('No se ha realizado ningun cambio...')
                    location.reload(true)
                },
                }
            });
        }
        
    }

    function grabaParam(ide){
        var part=document.getElementById("partidas").value;
        //alert('Total de Partidas' + part);
        var partidas = '';
        for (var i = part; i >= 1; i--) {
            //alert('Partida: '+ i);
            //var valPar = document.getElementById("cP_"+i).value;
            var valPar = ''
            Par = document.getElementById("cPP_"+i).getAttribute('valor');
            x = document.getElementById("cPP_"+i).getAttribute('x')
            var rfc = document.getElementById("cPP_"+i).getAttribute('rfc');
            var cuentaNueva = document.getElementById("cPP_"+i).value 
            if(cuentaNueva != '' && Par == ''){ ///Aqui no habia valor y es una cuenta nueva.
                var t = cuentaNueva.split(":")
                cuenta = t[7]
                valPar = x+cuenta+rfc
            }else if(cuentaNueva != '' && Par != ''){ /// Aqui va haber un cambio en la cuenta.
                var t = cuentaNueva.split(":")
                cuenta = t[7]
                valPar = x+cuenta+rfc
                //alert('entro al cambio')
            }else if(Par != ''){
                valPar = Par
            }
            if(valPar == ''){
                var ln = parseFloat(i) + 0;
                alert ('Revise por favor la partida ' + ln + ' ya que no cuenta con un valor, gracias...');
                return false;
            }else{
                partidas=partidas +'###'+valPar;
            }
        }
        partidas = partidas.substring(3);
        //alert(partidas)
        var cclie = document.getElementById("cClie").value;
        if(cclie == ''){
            alert ('El proveedor debe de tener un valor en el catalogo de cuentas, favor de revisar la informacion.');
            return false;
        }else{
            if(confirm('Se graba parametros, desea continuar?')){
                $.ajax({
                    url:'index.coi.php',
                    type:'post',
                    dataType:'json',
                    data:{creaParam:1,cliente:cclie,partidas, ide},
                    success:function(data){
                        alert(data.mensaje);
                        location.reload(true)
                    },
                    error:function(data){
                        alert('<b>Es penoso, pero un error no calculado ocurrio, favor de intentar de nuevo, de cualquier forma ya se levanto un ticket con el error, le pedimos sea paciente</b>');
                    }
                })
            }
        }
    }

    function impFact(factura){
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{imprimeFact:1, factura:factura},
                success:function(data){
                }
            })
        return;     
        }

    function crearPolizas(ide){
        var ent= document.getElementById('uuid');
        var uuid = ent.value;
        var docu = ent.getAttribute('doc'); 
        var tipo = 'Dr';
        if(confirm('Desea Realizar la poliza de Dr de Documento '+docu+' con estos parametros seleccionados?')){
            $.ajax({
                url:'index.coi.php',
                type:'post',
                dataType:'json',
                data:{creaPoliza:tipo,uuid,ide},
                success:function(data){
                    alert(data.mensaje + ': ' + data.poliza + ' en el  Periodo ' + data.periodo + ' del Ejercicio ' + data.ejercicio + 'Favor de revisar en COI ');
                    location.reload(true)
                }
            })
        }else{
            alert('No se ha realizado ningun cambio');
        }
    }

    function polizaFinal(uuid, tipo, idp){
        var tipoxml = document.getElementById('tipoxml').value;
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{traePago:1, idp, t:tipo},
            success:function(data){
                    var banco=data.banco
                    var cta = data.cuenta
                    var ctacoi = data.cuentaCoi
                    var clpv = data.proveedor
                    var ctaclpv =data.ctaProvCoi
                    var monto = data.monto
                    var obs = data.obs
                    if(ctacoi === null || ctacoi == '' ){
                        $.alert('El Banco ' + banco + ' con la cuenta '+ cta +' no tiene cuenta contable, favor de revisar')
                        return false;
                    }
                    if(ctaclpv === null || ctaclpv == ''){
                        $.alert('El Proveedor ' + clpv + ' no tiene cuenta contable, favor de revisar')
                        return false;   
                    }
                    $.confirm({
                        columnClass: 'col-md-8',
                        title: 'Registro de Poliza de ' + tipo,
                        content: 'Se registrara con los siguientes Valores <br/>' +
                        '<b>Banco:</b> ' + banco + ',<b> cuenta: </b>' + cta + '<b> coi: </b>' + ctacoi + 
                        '<br/><b>Proveedor </b>' + clpv + '<b> coi: </b>' + ctaclpv +
                        '<br/><b>Monto: </b> ' + monto + 
                        '<br/><b>Observaciones:<b/>' + obs  
                        ,
                        buttons: {
                            formSubmit:{
                            text: 'Registrar',
                            btnClass: 'btn-blue', 
                            action:function(){
                                $.alert('Se registrara el cargo en el estado de cuenta con la fecha ' )
                                $.ajax({
                                    url:'index.coi.php',
                                    type:'post',
                                    dataType:'json',
                                    data:{polizaFinal:1, uuid, tipo, idp, tipoxml},
                                    success:function(data){
                                        $.alert('Listo, se creo la Poliza de ' + tipo )
                                        location.reload(true)
                                    },
                                    error:function(){
                                        $.alert('No se pudo crear la poliza de ' + tipo + ' favor de revisar la informacion')
                                        location.reload(true)
                                    }
                                })
                            }
                        },
                        cancelar:function (){
                               //document.getElementById().checked=0;
                              //document.getElementById('r_'+doc).checked=0;
                              $.alert('No se ha realizado ningun cambio...')
                              location.reload(true)
                        },
                        }
                    });
                return false;
            },
            error:function(){
                alert('No se encontro la informacion del pago, favor de reportar a sistemas')
                return false;
            }
        })        
    }
        
</script>