<style type="text/css">
    input[type=number] {
       width: 100px;
    }
</style>    
<!--- Area del cliente -->
    <?php if(isset($cabecera)){?>
        <?php foreach ($cabecera as $cbc){
                $nombre = $cbc->NOMBRE;
                $cliente = $cbc->CLAVE.':'.$cbc->NOMBRE;
                $dir = $cbc->CALLE.', '.$cbc->NUMEXT.'.';
                $int = $cbc->NUMINT;
                $colonia = $cbc->COLONIA;
                $delegacion = $cbc->MUNICIPIO;
                $cp = $cbc->CODIGO;
                $estado = $cbc->ESTADO;
                $pais = $cbc->PAIS;
                if($cbc->STATUS == 'C'){
                    $sta = 'CANCELADO';
                }elseif ($cbc->STATUS == 'P') {
                    $sta = 'PENDIENTE';
                }elseif ($cbc->STATUS == 'E') {
                    $sta = 'EMITIDA';
                }elseif ($cbc->STATUS == 'F') {
                    $sta = 'FACTURADA';
                }
        } ?>
    <?php }?>
<br/>
<?php echo 'Usuario:<b>'.$_SESSION['user']->NOMBRE.'</b>&nbsp;&nbsp;&nbsp;&nbsp;Fecha: &nbsp;&nbsp;'.date("d-m-Y H:i:s")?>
<br/>
<div>
    <input type="hidden" id="doc" value="<?php echo $doc?>">
    <input type="hidden" id="idf" value="<?php echo $idf?>">
    <?php if(empty($doc)){?>
    <p>Tipo De Documento:&nbsp;&nbsp;
        <select id="tipo">
            <option value="nv">Nota de Venta</option>
            <option value="fac">Factura</option>    
        </select>
        <input type="text" placeholder="Traer NV" id="traeNV" oninput="this.value = this.value.toUpperCase()" autofocus>
    </p>
    <?php }else{?>
        <p><font color="red" size="5pxs">Documento: <?php echo $doc?> --> Estado: <?php echo $sta.' ('.$cbc->METODO_PAGO.')'?> </font></p>
        <input type="text" placeholder="Traer NV" id="traeNV" oninput="this.value = this.value.toUpperCase()">
    <?php }?>
        <input type="button" name="nv" value="Notas de Venta" class="btn-sm btn-info verNV">
    <br/>
    <br/>
         
    <p><b>Cliente:</b><input type="text" name="doc" placeholder="Nombre, Clave, RFC o Telefono" size="100" class="clinv" id="clie" value = "<?php echo (!empty($cliente))? $cliente:''?>" <?php echo (!empty($cliente) and $sta == 'PENDIENTE')? 'onchange="revisarCambio()"':'onchange="nuevoCliente(this.value)"'?>></p>

    <p><b>Direccion: </b><input type="text" name="doc" placeholder="Calle y Numero" size="40" class="bf" tipo="A" value="<?php echo (!empty($dir)? $dir:'')?>" readonly>&nbsp;&nbsp;&nbsp;Interior:&nbsp;&nbsp;<input type="" name="" placeholder="Interior" value="<?php echo (!empty($int))? $int:''?>" readonly></p>
    <p>Colonia: <input type="text" name="" value="<?php echo !empty($colonia)? $colonia:'' ?>" size="80" readonly>&nbsp;&nbsp; Delegacion\Municipio:&nbsp;&nbsp; <input type="" name="" placeholder="Delegacion o Municipio" value="<?php echo !empty($delegacion)? $delegacion:''?>" readonly>&nbsp;&nbsp;C.P.<input type="" name="" placeholder="Codigo Postal" value="<?php echo !empty($cp)? $cp:''?>" readonly></p>
    <p>Estado:&nbsp;&nbsp;<input type="" name="" placeholder="Estado" value="<?php echo !empty($estado)? $estado:''?>" readonly>&nbsp;&nbsp;&nbsp;Pais:&nbsp;&nbsp;<input type="" name="" placeholder="Pais" value="<?php echo !empty($pais)? $pais:''?>" readonly>&nbsp;&nbsp; Descuento Global: <input type="number" value="0" id="descf" min="0" max="100" step="any">
    &nbsp;&nbsp;<font color="black" style="background-color:yellow"><b> Factura Fiscal</b> </font>
    &nbsp;&nbsp; Uso CFDI: <select id="UF">
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
            </select> 
    &nbsp;&nbsp; Forma de Pago: <select id="MP">
                <option value="">"Forma de Pago"</option> 
                <option value="03">"03 Transferencia Electronica de Fondos"</option>
                <option value="01">"01 Efectivo"</option>
                <option value="02">"02 Cheque Nominativo"</option>
                <option value="04">"04 Tarjeta de Credito"</option>
                <option value="28">"28 Tarjeta de débito"</option>
                <option value="29">"29 Tarjeta de servicios"</option>
                <option value="05">"05 Monedero Electronico"</option>
                <option value="06">"06 Dinero Electronico"</option>
                <option value="08">"08 Vales de despensa"</option>
                <option value="12">"12 Dación en pago"</option>
                <option value="13">"13 Pago por subrogación"</option>
                <option value="14">"14 Pago por consignación"</option>
                <option value="15">"15 Condonacion"</option>
                <option value="17">"17 Compensacion"</option>
                <option value="23">"23 Novación"</option>
                <option value="24">"24 Confusión"</option>
                <option value="25">"25 Remisión de Deuda"</option>
                <option value="26">"26 Prescripción o caducidad"</option>
                <option value="27">"27 A satisfacción del acreedor"</option>
                <option value="30">"30 Aplicacion de Anticipos"</option>
                <option value="31">"31 Intermedirarios pagos"</option>
                <option value="99">"99 Por Definir"</option>
            </select>
    &nbsp;&nbsp; Metodo de Pago: <select id="FP">
                <option value="">"Metodo de Pago"</option>
                <option value="PUE">"PUE Pago en una sola exhibición"</option>
                <option value="PPD">"PPD Pago en parcialidades o diferido"</option>
            </select>
    </p>
    <!-- Finaliza el area del cliente -->
<?php if(!isset($sta) or $sta == 'PENDIENTE'){ ?>
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
                                            <th>Producto</th>
                                            <th>Cantidad<br/><font color="blue"><b>Existencia</b></font></th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Descuento %</th>
                                            <th>IVA %</th>
                                            <th>IEPS %</th>
                                            <th>SubTotal</th>
                                            <th>Total</th>
                                            <th>Agregar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <tr class="odd gradeX" >
                                           <td WIDTH="5%"><input type="text" size="8" placeholder="Producto" id="bprod"></td>
                                           <td WIDTH="5%"><input type="number" step="any" placeholder="Canitdad"id="cant" class="calc"><br/><label id="ext"></label></td>
                                           <td id="desc" WIDTH="41%"></td>
                                           <td id="prc" WIDTH="7%"></td>
                                           <td id="des" WIDTH="7%"><br/> </td>
                                           <td id="iv" WIDTH="7%"><br/> </td>
                                           <td id="iep" WIDTH="7%"><br/> </td>
                                           <td id="ST" WIDTH="7%"></td>
                                           <td id="T" WIDTH="7%"></td>
                                           <td><input type="button" value="Agregar" class="add" WIDTH="7%"><br/><input type="button" value="Cancelar" class="act"></td>
                                        </tr>
                                    </tbody>  
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<?php }?>

<?php if(count($partidas)>0){?>
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
                                            <th>Partida</th>
                                            <th>Producto</th>
                                            <th>Cantidad<br/><font color="blue"><b>Existencia</b></font></th>
                                            <th>Descripcion<br/>Informacion SAT <font color="red">Clave - Unidad</font></th>
                                            <th>Precio</th>
                                            <th>Descuento %</th>
                                            <th>IVA %</th>
                                            <th>IEPS %</th>
                                            <th>SubTotal</th>
                                            <th>Total</th>
                                            <th>Eliminar</th>
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php $tdesc=0; $tiva = 0; $tieps=0; $subtotal = 0; $tt=0;
                                            foreach ($partidas as $p):
                                            $subt = $p->PRECIO * $p->CANTIDAD;
                                            $desc= ($p->PRECIO * ($p->DESC1/100)) * $p->CANTIDAD;  
                                            $iva= (($p->PRECIO * $p->CANTIDAD) - $desc) * ($p->IMP1 /100);
                                            $ieps = ($subt - $desc + $iva) * ($p->IMP2/100);
                                            $tdesc += $desc;
                                            $tiva += $iva;
                                            $tieps += $ieps;
                                            $subtotal +=$subt;
                                            $tt= $subtotal - $tdesc + $tiva + $tieps; 
                                        ?>
                                        <tr class="odd gradeX" >
                                           <td width="3%"><?php echo $p->PARTIDA?></td>
                                           <td width="5%"><?php echo $p->ARTICULO?></td>
                                           <td width="5%"><?php echo $p->CANTIDAD.'<br/><font color="blue">'.$p->EXISTENCIA.'</font>'?></td>
                                           <td width="41%"><?php echo $p->DESCRIPCION.'<br/><font color="red">'.$p->CLAVE_SAT.' - '.$p->MEDIDA_SAT.'</font>'?>
                                               <?php if($sta !='FACTURADA'){?> 
                                               <a onclick="chgObs(<?php echo $p->PARTIDA?>)" >cambiar obs</a>
                                               <br/>
                                               <textarea id="obs_<?php echo $p->PARTIDA?>" placeholder="<?php echo substr($p->DESCRIPCION, strlen($p->PRODUCTO))?>" class="hidden" sentences autofocus cols='80' rows='5'><?php echo substr($p->DESCRIPCION, strlen($p->PRODUCTO))?></textarea>                                           
                                               <a class="hidden cambiaObs" id ="chg_<?php echo $p->PARTIDA?>" lin="<?php echo $p->PARTIDA?>" doc="<?php echo $doc?>"> <font color="green">Cambiar</font> / </a>  
                                               <a class="hidden ocultar" id="ocl_<?php echo $p->PARTIDA?>" lin="<?php echo $p->PARTIDA?>" ><font color="blue">Ocultar</font></a>
                                               <?php }?>
                                           </td>
                                           <td width="6%" align="right"><?php echo '$ '.number_format($p->PRECIO,2)?></td>
                                           <td width="6%" align="right"><?php echo number_format($p->DESC1,2).'% <br/> '.$desc?></td>
                                           <td width="6%" align="right"><?php echo number_format($p->IMP1,2).'% <br/> '.$iva?></td>
                                           <td width="7%" align="right"><?php echo number_format($p->IMP2,2).'%  <br/>'.$ieps?></td>
                                           <td width="7%" align="right"><?php echo '$ '.number_format($p->SUBTOTAL,2)?></td>
                                           <td width="7%" align="right"><?php echo '$ '.number_format($p->TOTAL,2)?></td>
                                           <td width="7%"><input type="button" value="quitar" p="<?php echo $p->PARTIDA?>" class="drop"></td>
                                        </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td align="right" colspan="8">SubTotal:</td>
                                            <td align="right"><?php echo "$ ".number_format($subtotal,2)?></td>                                            
                                        </tr>
                                        <?php if($tdesc>0){?>
                                        <tr>
                                            <td align="right" colspan="8">Descuento:</td>
                                            <td align="right"><?php echo "$ ".number_format($tdesc,2)?></td>
                                        </tr>
                                        <?php }?>
                                        <?php if($tiva>0){?>                                        
                                        <tr>
                                            <td align="right" colspan="8">IVA:</td>
                                            <td align="right"><?php echo "$ ".number_format($tiva,2)?></td>

                                        </tr>
                                        <?php }?>
                                        <?php if($tieps>0){?>
                                        <tr>
                                            <td align="right" colspan="8">IEPS:</td>
                                            <td align="right"><?php echo "$ ".number_format($tieps,2)?></td>

                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td align="right" colspan="8">Total:</td>
                                            <td align="right"><?php echo "$ ".number_format($tt,2)?></td>
                                            <input type="hidden" id="imp" value="<?php echo number_format($tt,2)?>">
                                        </tr>
                                    </tbody>  
                                </table>
                                <input type="button" name="" value="Nueva"  class="btn btn-warning nuevo">
                                <input type="button" name="" value="Copiar" class="btn btn-primary copiar">
                                <?php if(!isset($sta) or $sta == 'PENDIENTE'){?>
                                    <input type="button" name="" value="Cancelar" class="btn btn-danger cancelar">
                                    <input type="button" name="" value="Pagar"    class="btn btn-success pagar">
                                    <input type="button" name="" value="Facturar" class="btn btn-info facturar">
                                <?php }elseif($sta == 'FACTURADA'){?>
                                    <input type="button" name="" value="Enviar" class="btn btn-success enviar">
                                <?php }?>
                                <input type="button" name="" value="Re-Imprimir" class="btn btn-warning reimpresion">
                            </div>
                      </div>
            </div>
        </div>
    </div>
<?php }?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript"> 

    var doc = <?php echo "'".$doc."'"?>  

    $(".copiar").click(function(){
        $.confirm({
            title: 'Copia de Nota de Venta',
            content: '¿Seguro que deseas copiar la nota de venta '+ doc+ ' ?',
            buttons: {
                Si: function () {
                    $.ajax({
                        type: "POST",
                        url: 'index.v.php',
                        dataType: "json",
                        data: {copiaNV:1, doc},
                        beforeSend: function () {
                            var popup = $('#pop');
                            popup.css({
                                'position': 'absolute',
                                'left': ($(window).width() / 2 - $(popup).width() / 2) + 'px',
                                'top': ($(window).height() / 2 - $(popup).height() / 2) + 'px'
                            });
                            popup.show();
                        },
                        success: function (data)
                        {
                            $('#pop').hide();
                            if (data.status == "ok") {
                                $.alert(data.mensaje)
                                window.open('index.v.php?action=nv2&doc='+data.NNV+'&idf=0', '_self')
                            } else {
                                $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                console.log("XML:"+data.status);
                            }
                        }
                    });
                },
                Cancelar: {
                }
            }
        });
    })

    function chgObs(lin){
        var a = document.getElementById('obs_'+lin)
        var b = document.getElementById('chg_'+lin)
        var c = document.getElementById('ocl_'+lin)
        a.classList.remove("hidden")
        b.classList.remove("hidden")
        c.classList.remove("hidden")
    }

    $(".cambiaObs").click(function(){
        var lin = $(this).attr('lin')
        var obs = document.getElementById('obs_'+lin).value
        var doc = $(this).attr('doc')
        //alert('Acualizamos con Ajax el cambio de la descripcion : '+ obs)
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{cambiaObs:1, lin, doc, obs},
            success:function(data){
                location.reload(true)
            },
            error:function(data){

            }
        })
    })

    $(".ocultar").click(function(){
        var lin = $(this).attr('lin')
        var a = document.getElementById('obs_'+lin)
        var b = document.getElementById('chg_'+lin)
        var c = document.getElementById('ocl_'+lin)
        a.classList.add("hidden")
        b.classList.add("hidden")   
        c.classList.add("hidden")
    })

    $(".act").click(function(){
        location.reload(true)
    })

    function pago(){
        //$.alert('Se realiza el calculo y se intenta actualizar')
        var importe = parseFloat( document.getElementById("imp").value.replace(",",""))
        var tcc = parseFloat(document.getElementById("tcc").value)
        var tcd = parseFloat(document.getElementById("tcd").value)
        var efe = parseFloat(document.getElementById("efe").value)
        var tef = parseFloat(document.getElementById("tef").value)
        var val = parseFloat(document.getElementById("val").value)
        var cr = parseFloat(document.getElementById("cr").value)
        var cupon = parseFloat(document.getElementById("cupon").value)
        var pago = tcc + tcd + efe + tef + cupon + cr
        var cambio = pago - importe
        document.getElementById('pagado').innerHTML= '$ ' + pago 
        document.getElementById('cambio').innerHTML = '$ ' + cambio
        document.getElementById('c1').value = cambio
    } 

    $(".pagar").click(function(){
        var doc = document.getElementById("doc").value
        var importe = document.getElementById("imp").value
        var cambio = 0
        $.confirm({
            title: 'Pagar Nota de Venta',
            content: '' +
            '<form action="index.v.php" method="post" class="formName">' +
            '<div class="fcol-xs-3">' +
            '<label>Pagar la Nota de Venta: </label>'+ doc + '<br/>' +
            '<label><b>Importe:</b></label><font color="blue" size="8pxs">  <p id="calc">$ ' + importe + '</p></font><br/>' +
            '<label><b>Pagado:</b><font color="red" size="8pxs"><p id="pagado"></p></font></label><br/'+
            '<label><b>Cambio:</b><font color="green" size="8pxs"><p id="cambio"></p></font></label><br/>'+
            '<input type="hidden" class="cambio" value="'+cambio +'" id="c1" value="" name="cambio">'+
            '<input type="hidden" value="enviar" name="pagaNV">'+
            '<input type="hidden" value="'+doc+'" name="doc">'+
            'Tarjeta de Credito: <input type="number" step="any" class="tccre form-control" required value="0" onchange="pago()" id ="tcc" name="tcc"/><br/>' +
            'Tarjeta de Debito: <input type="number" step="any" class="tcdeb form-control" required value="0" id="tcd" onchange="pago()" name="tcd"/>'+
            'Efectivo: <input type="number" step="any" class="efe form-control" required value="0" id="efe" onchange="pago()" name="efe"/>'+
            'Depósito: <input type="number" step="any" class="tef form-control" required value="0" id="tef" onchange="pago()" name="tef"/>'+
            'Vales: <input type="number" step="any" class="val form-control" required value="0" id="val" onchange="pago()" name="val"/>'+
            'Crédito: <input type="number" step="any" class="cr form-control" required value="0" id="cr" onchange="pago()" name="cr"/>'+
            'Cupón / Otros: <input type="number" step="any" class="cupon form-control" required value="0" id="cupon" onchange="pago()" name="cupon"/>'+
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Pagar',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.tccre').val();
                        var cambio = parseFloat(this.$content.find('.cambio').val());
                        alert(cambio - 1)
                        if(cambio >= 0 && cambio != ""){
                            $.alert('Recuerda entregar el cambio al momento...');
                            var form = this.$content.find('form')
                            form.submit()
                        }else if(cambio < 0.0  || cambio==""){
                            $.alert('Debe de saldar la nota para poder proceder');
                            return false;   
                        }
                    }
                },
                cancelar:{
                    text:'Cancelar',
                    btnClass:'btn-danger',
                    action: function(){
                    }
                },
            },
            ///onContentReady: function () {
            ///    // bind to events
            ///    var jc = this;
            ///    this.$content.find('form').on('submit', function (e) {
            ///        // if the user submits the form by pressing enter in the field.
            ///        e.preventDefault();
            ///        jc.$$formSubmit.trigger('click'); // reference the button and click it
            ///    });
            ///}
        });
    })

    $(".nuevo").click(function(){
        if(confirm("Se cerrara la Nota de venta actual, Los Cambios se guardaran en Automatico")){
           window.open("index.v.php?action=ventasMostrador", "_blank")
        }
    })
    $(".cancelar").click(function(){
        var doc= document.getElementById("doc").value
        if(confirm("Desea cancelar la Nota de Venta "+ doc+"?, no se podra recuperar...")){
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{cancelaNV:doc},
                succcess:function(data){                    
                    alert(data.status)
                },
                error:function(){

                }
            })
        }  
    })

    $(".reimpresion").click(function(){
        var doc = document.getElementById('doc').value
        alert('Se reimprime el ticket: ' + doc)
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{impresionTicket:doc},
            succcess:function(){
                
            },
            error:function(){
            }
        })
    })

    $("#bprod").autocomplete({
        source: "index.v.php?prodVM=1",
        minLength: 2,
        select: function(event, ui){
        }
    })

    $(".clinv").autocomplete({
        source:"index.v.php?clieVM=1",
        minLength: 3,
        select: function(event,ui){
        }
    })

    $(".drop").click(function(){
        var p = $(this).attr("p")
        var doc = document.getElementById("doc").value
        var idf = document.getElementById("idf").value
        if(confirm("Desea Eliminar la Partida " + p + " ?")){
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{dropP:1, doc, idf, p},
                success:function(data){
                    if(data.status=='ok'){
                        window.open("index.v.php?action=nv2&doc="+doc+"&idf="+idf,"_self")
                    }
                },
                error:function(){
                    $.alert("No se pudo eliminar la partida, favor de revisar la informacion.")
                }
            })
        }else{
            return false
        }
    })

    $(".facturar").click(function(){
        var uf = document.getElementById('UF').value
        var mp = document.getElementById('MP').value
        var fp = document.getElementById('FP').value
        if(uf == '' || fp == '' || mp == ''){
            alert('Favor de colocar los datos Fiscales')
            document.getElementById('UF').focus()
            return false;
        }
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{factNV:1, doc, uf, mp, fp},
            success:function(data){
                setTimeout(alert(data.mensaje),4000)
                location.reload(true)
            },
            error:function(){
            }
        })
    })

    $(".add").click(function(){
        var clie  = document.getElementById("clie").value
        var prod  = document.getElementById("bprod").value
        var cant  = parseFloat(document.getElementById("cant").value)
        var prec  = parseFloat(document.getElementById("precio").value)
        var iva   = parseFloat(document.getElementById("iva").value)
        var desc  = parseFloat(document.getElementById("descuento").value)
        var ieps  = parseFloat(document.getElementById("ieps").value)
        var descf = parseFloat(document.getElementById("descf").value)
        var doc   = document.getElementById("doc").value
        var idf   = document.getElementById("idf").value
        var add = document.getElementById("desAdd").value
        if(confirm("Desea Agrear la Partida?")){
            $.ajax({
                url:"index.v.php",
                type:"post",
                dataType:"json",
                data:{docNV:1, clie, prod,cant, prec, iva, desc, ieps, descf, doc, idf, add},
                success:function(data){
                    if(data.status=='ok'){
                        $.alert("Se trae el producto " + data.desc)
                        document.getElementById("doc").value=data.doc
                        document.getElementById("idf").value=data.idf
                        window.open("index.v.php?action=nv2&doc="+data.doc+"&idf="+data.idf,"_self")
                    }
                },
                error:function(){
                    $.alert("Revise el codigo del producto por favor")
                }
            })    
        }
    })

    $(".calc").change(function(){
        a = totales()
    })

    function calculo(){
        a=totales()
    }

    function totales(){
        var cant=parseFloat(document.getElementById("cant").value)
        var p = document.getElementById("bprod")
        prod = p.value.split(":")
        p.value=prod[0]
        p.readOnly=true
        var precio = parseFloat(document.getElementById("precio").value)
        var iva = parseFloat(document.getElementById("iva").value)
        var desc = parseFloat(document.getElementById("descuento").value)
        var ieps = parseFloat(document.getElementById("ieps").value)
        if(desc != 0){
            desc1 = (precio * (desc/100))
            document.getElementById("bprc").innerHTML = '$ '+ (precio - desc1).toFixed(2)
            document.getElementById("bdes").innerHTML='$ '+ desc1.toFixed(2)
            desc= ((precio*cant) * (desc/100))
        }else{
            document.getElementById("bprc").innerHTML=""
            document.getElementById("bdes").innerHTML=""
        }
        if(iva != 0){
            iva = (((precio*cant)-desc) * (iva/100))
            document.getElementById("biv").innerHTML='$ '+ iva.toFixed(2)
        }else{
            document.getElementById("biv").innerHTML=""
        }
        if(ieps !=0){
            ieps = (((precio*cant)-desc) * (ieps/100))
            document.getElementById("biep").innerHTML='$ '+ ieps.toFixed(2)   
        }else{
            document.getElementById("biep").innerHTML=""  
        }
        var st = ((precio * cant) - desc).toFixed(2)
        var t=(((precio * cant)- desc) + iva + ieps).toFixed(2)
        document.getElementById("ST").innerHTML= "$ "+ st
        document.getElementById("T").innerHTML="$ "+ t
    }

    $("#bprod").change(function(){
        var p = $(this)
        var prod = p.val().split(":")
        document.getElementById("ext").innerHTML="<font color='blue'><b>"+prod[6]+"</b></font>"
        document.getElementById("desc").innerHTML= prod[1] + "<br/><textarea name='descAdd' sentences autofocus cols='80' rows='5' placeholder = 'Descripcion Adicional del producto' id='desAdd'></textarea>"
        document.getElementById("prc").innerHTML='<input type="number" step="any" value="'+prod[2]+'" id="precio" class="calc" onchange="calculo()"> <br/><label id="bprc"></label>'  
        document.getElementById("des").innerHTML='<input type="number" step="any" value="0" id="descuento" class="calc" onchange="calculo()"> <br/><label id="bdes"></label>'
        document.getElementById("iv").innerHTML='<input type="number" step="any" id="iva" class="calc" onchange="calculo()" value="'+prod[5]+'" readonly> <br/><label id="biv"></label>'
        document.getElementById("iep").innerHTML='<input type="number" step="any" value="0" id="ieps" class="calc" onchange="calculo()" readonly> <br/><label id="biep"></label>'
        //document.getElementById("bprod").value=prod[0]
        //$.ajax({
        //    url:"index    .v.php",
        //    type:"post",
        //    dataType:"json",
        //    data:{productoVM:1, cveprod},
        //    success:function(data){
        //        if(data.status=='ok'){
        //            $.alert("Se trae el producto " + data.desc)
        //        }
        //    },
        //    error:function(){
        //        $.alert("Revise el codigo del producto por favor")
        //    }
        //})
    })

    function timbrar(doc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{buscaDoc:doc},
            success:function(data){
                alert(data.mensaje)
            },
            error:function(data){

            }
        })
    }

    $(".bf").change(function(){
        var valor = $(this).val();
        var tipo = $(this).attr('tipo');
        valor = tipo+":"+valor;
        if(tipo == 'R'){
            var valor2 = document.getElementById("fi").value;
            if(valor2 ==''){
                alert ('Seleccione una fecha inicial');
                return;
            }
            valor= tipo+':'+valor2+":"+valor; 
        }
        //alert('cambio el valor' + valor);
        window.open("index.php?action=imprimeXML&uuid="+valor,"_self");
    })

    function imprimeNC(nc){
        document.getElementById('fact').value=nc; 
        form = document.getElementById("impNC");
        form.submit();
    }

    function cancelar(uuid, docf){
        if(confirm('Esta seguro de cancelar la facturas o Nota de Credito: ' +  docf + ', al cancelarla se enviara automaticamente correo a Contabiliad, Gerente de CxC, Vendedor y Sistemas')){
            alert('Inicia proceso de cancelacion');
            $.ajax({
                url:'index.v.php',
                type:'POST',
                dataType:'json',
                data:{cancelar:uuid, docf:docf},
                success:function(data){
                    alert(data.motivo);
                },
                error:function(data){
                    alert(data.motivo);
                }
            });
        }
    }

    $("#traeNV").change(function(){
        var nv= $(this).val()
        window.open("index.v.php?action=nv2&doc="+nv+"&idf=0", "_self")
    })

    function revisarCambio(){
        var clie = document.getElementById('clie').value
        var doc = document.getElementById('doc').value
        if(confirm('Desea cambiar el cliente a: '+clie +'?')){
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{cambioCliente:clie, doc},
                success:function(data){
                    location.reload(true)

                },
                error:function(){
                    alert('Revise que la informacion sea correcta he intentelo de nuevo...')
                }
            })
        }else{
            alert('No se procede el cambio')
            location.reload(true)
        }
    }

    $(".verNV").click(function(){
        window.open('index.v.php?action=verNV', '_blank')
    })
    
    function nuevoCliente(clie){
        revisaCliente(clie)    
    }

    function revisaCliente(clie){
        var v = 'A';
        cl = clie.substring(0,10)
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{nvcl:cl},
            success:function(data){
              },
            error:function(){
                v = 'N'
            }
        }).done(function(data) {
          console.log('se mando');
          console.log(data.n)
            v = data.n
            if(v == 'N' || v === null){
                $.confirm('El cliente : <b>' + clie + '</b> ,no existe, desea darlo de alta?')

            }else{
               // alert('El cliente es: ' + v)
            }
            //read(0);
            //reload(); //En este punto se llama
        })
        return v
    }

</script>