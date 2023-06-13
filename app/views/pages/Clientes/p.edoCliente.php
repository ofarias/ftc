<br>

<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Saldos por cliente del Maestro <?php echo $nombre;?>
            </div>
            <div class="panel-body">
                 <div class="table-responsive">                            
                        <table class="table table-bordered" id="dataTables-CarteraXCliente">
                            <thead>
                                  <tr>
                                        <td colspan="6" align="right">
                                            <input type="button" name="impimir" value="Ver Productos" class="btn-info" id="productos">
                                            
                                        </td>
                                        <td colspan="1" align="right">
                                            <input type="button" name="impimir" value="Descargar a Excel" class="btn-info" onclick="utilerias('<?php echo $maestro?>', this.value, 'x')">
                                            <p id="descarga"></p>
                                        </td>
                                        <td>
                                            <input type="button" name="impimir" value="impimir PDF" class="btn-info" onclick="utilerias('<?php echo $maestro?>', this.value, 'i')">
                                        </td>
                                        <td colspan="3">
                                            <input type="email" name="correo" value="" placeholder="Correo Cliente" multiple id="co" size="30"><br/>
                                            <input type="button" name="impimir" value="Enviar Correo" class="btn-info" onclick="utilerias('<?php echo $maestro?>', this.value,'e')">
                                        </td>
                                    </tr>
                            <tr  id='HFact'>
                                <th>Ln</th>
                                <th>Sel</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Importe</th>
                                <th>Fecha Documento /<br/> Fecha Cobranza </th>
                                <th>Vencimiento</th>
                                <th>Aplicaciones</th>
                                <th>Notas de <br/>Credito</th>
                                <th>Saldo Factura</th>
                            </tr>
                        </thead>
                        <tbody id="BFact">
                            <?php $total = 0;
                            $i = 0;
                            foreach($facturas as $doc):
                                //$linea=$sc->LINEA_CRED;
                                $i++;
                                $color = '';
                                if($doc->VENCIMIENTO >= 0 AND $doc->VENCIMIENTO <= 29){
                                    $color="style='background-color:#C4FFBE;'";
                                }elseif($doc->VENCIMIENTO > 29 ){
                                    $color = "style='background-color:#FFE798;'";
                                }elseif($doc->VENCIMIENTO < 0 ){
                                    $color = "style='background-color:#bbfab6;'";
                                }
                                $total = $total + $doc->SALDOFINAL;
                            ?>     
                                    <tr class="odd gradeX" <?php echo $color?> >
                                        <td><?php echo $i?></td>
                                        <td><input type="checkbox" name="sel"  <?php echo ($doc->MARCA == 'S')? 'checked':''?> 
                                        class="facturas" doc="<?php echo $doc->CVE_DOC?>" monto="<?php echo number_format($doc->SALDOFINAL,2,".","")?>" id="<?php echo $doc->CVE_DOC?>">
                                        <input type="hidden" name="clie" id="cli_<?php echo $i?>" value="<?php echo $doc->CVE_CLPV?>"></td>
                                        <td><?php echo $doc->CVE_DOC?><br/><?php echo $doc->STATUS?>
                                            <a href="/Facturas/facturaPegaso/<?php echo $doc->CVE_DOC.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='12' height='15'></a>
                                            <a href="index.php?action=imprimeFact&factura=<?php echo $doc->CVE_DOC?>" onclick="alert('Se ha descargado tu factura.')"><img border='0' src='app/views/images/pdf.jpg' width='12' height='15'></a>
                                        </td>
                                        <td><?php echo '( '.$doc->CVE_CLPV.') '.$doc->NOMBRE?></td>                                    
                                        <td align="right"><?php echo '$ '.number_format($doc->IMPORTE,2);?></td>
                                        <td> <?php echo '<font color="purple">'.$doc->FECHA_DOC.'</font><br/> <font color="blue">'.$doc->FECHA_INI_COB.'</font>'?></td>
                                       <td align="center"><b><?php echo $doc->VENCIMIENTO?></b></td>
                                        <td align="right"><font color="red"><b><?php echo '$ '.number_format($doc->PAGOS,2,".",",");?></b></font></td>
                                        <td align="right"><font color="red"><b><?php echo '$ '.number_format($doc->IMPORTE_NC,2);?></b></font></td>
                                        <td align="right"><b><?php echo '$ '.number_format($doc->SALDOFINAL,2);?></b>
                                        </td>
                                    </tr> 
                            <?php endforeach;?>
                        </tbody>
                                    <tr>
                                        
                                        <td colspan="9" align="right"><b>Total Por Cobrar: </b></td>
                                        <td colspan="1"><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($total,2)?></font></b></td>
                                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <form action="index.cobranza.php" method="POST" id="FORM_ACTION">
        <input type="hidden" name="seleccion_cr" id="seleccion_cr" value="" />
        <input type="hidden" name="items" id="items" value="" />
        <input type="hidden" name="total" id="total" value="" />
        <input type="hidden" name="retorno" value="cobranza">
        <input type="hidden" name="maestro" value="<?php echo $doc->CVE_MAESTRO?>" id="cve_maestro">
        <input type="hidden" name="FORM_ACTION_PAGO_FACTURAS_NUEVO" value="FORM_ACTION_PAGO_FACTURAS" />
    </form>
    <form action="index.cobranza.php" method="POST" id="formUtilerias">
        <input type="hidden" name="utileriaCobranza" value="" id="met">
        <input type="hidden" name="maestro" value="" id="m">
        <input type="hidden" name="sel" value="" id="s">        
    </form>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>

<script type="text/javascript">
    var cte = <?php echo "'".$cliente."';"?>
    $("#productos").click(function(){
        
        alert("Traemos los productos del cliente, generamos la consulta con el numero de cliente la  " + cte)
    })

    function altaCC(i){
       var m = document.getElementById('mae').value
       var c = document.getElementById('cli_'+i).value
       window.open("index.cobranza.php?action=verCC&cveMaestro="+m+"&cveCliente="+c, 'popup', 'width=1000,height=900')
       return false
    }

    function utilerias(maestro, tipo, metodo){
        var val=0;
        $("input:checkbox:checked").each(function(){
            val=val + 1;
        });
        if(val != 0){
            var sel='Si';
            if(confirm('Solo se incluiran los documentos seleccionados' + tipo)){
                alert('Procede la descarga de solo los seleccionados');
            }else{
                return false;
            }        
        }else{
            var sel='No';
            if(confirm('Se incluiran todos los documentos' + tipo)){
                alert('Procede la descarga de Todos los documentos.');
            }else{
                return false;
            }
        }
        if(tipo == 'impimir PDF'){
            document.getElementById('met').value=metodo;
            document.getElementById('m').value=maestro;
            document.getElementById('s').value=sel;
            var form = document.getElementById('formUtilerias');
            form.submit();
        }else if(tipo =='Enviar Correo'|| tipo =='Descargar a Excel'){
            var correo = document.getElementById('co').value;
            metodo = metodo + ':' + correo; 
            $.ajax({
            url:'index.cobranza.php',
            type:'post',
            dataType:'json',
            data:{utileriaCobranza:metodo, maestro, sel},
            success:function(data){
                if(data.status=='ok'){
                    window.open("/edoCtaXLS/"+data.archivo, 'download' );
                    //document.getElementById("descarga").innerHTML='<a href="/edoCtaXLS/Documentos 24.xlsx" download>Descargar</a>'
                }
            }
            })     
        }
    }

    $(document).ready(function(){
            var factura='';
            var total =0;
            $("input:checkbox:checked.facturas").each(function(){
                var documento = $(this).attr('doc');
                var monto = parseFloat($(this).attr('monto'));
                total = total + monto;
                factura = factura + documento + ',';   
            });
            total= String(total).split(".");
            total = format(total);
            factura = factura.slice(0,-1);     
            //document.getElementById("algo").innerHTML='Documentos a pagar: ' + factura;
            //document.getElementById("algo2").innerHTML='Por un monto de: <font color="blue"> ' + total + '</font>';
            //document.getElementById("boton").innerHTML="<input type='button' value='Pagar' class='btn btn-success' onclick='aplicarPago()'>";
            var maestro = document.getElementById('cve_maestro').value;

        $("input:checkbox.facturas").change(function(){
           var docu = $(this).attr('doc');
           if($(this).is(':checked')){
             var tipo = 'S';
           }else{
             var tipo ='N';
           }
           var validacion = seleccion(docu, tipo, maestro);
        });
    });

    function seleccion(documento, tipo, maestro){
            var status='';
            var maestro = document.getElementById('cve_maestro').value;
            $.ajax({
                    url:'index.cobranza.php',
                    type:'POST',
                    dataType:'json',
                    data:{marcaDoc:documento, tipo, maestro},
                    success:function(data){
                        if(data.status == 'ok'){
                            status = data.status;
                            //alert('se ha ejecutado correctamente');
                                var factura='';
                                var total =0;
                                 $("input:checkbox:checked.facturas").each(function(){
                                    var documento = $(this).attr('doc');
                                    var monto = parseFloat($(this).attr('monto'));
                                    total = total + monto;
                                    factura = factura + documento + ',';   
                                });
                                total= String(total).split(".");
                                total = format(total);     
                                factura = factura.slice(0,-1);
                                document.getElementById("algo").innerHTML='Documentos a pagar: ' + factura;
                                document.getElementById("algo2").innerHTML='Por un monto de: <font color="blue"> ' + total + '</font>';
                                document.getElementById("boton").innerHTML="<input type='button' value='Pagar' class='btn btn-success' onclick='aplicarPago()'>";
                            }else{
                                alert('El documento esta en proceso por ' + data.usuario + 'desde el ' + data.fecha);
                                document.getElementById(documento).checked=0;
                        }
                        return status
                    } 
            });
    }

    function format(numero){
            var long = numero[0].length;
            var cent = '00';
            if(long > 6){
                var tipo = 'Millones';
                if (long == 9){
                    var mill = 3;
                }else if(long == 8){
                    var mill = 2;
                }else if(long == 7){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + ','+ unidades +'.' + cent;
            }else if(long > 3){
                if (long == 6){
                    var mill = 3;
                }else if(long == 5){
                    var mill = 2;
                }else if(long == 4){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles +'.' + cent;
            }else if(long > 0){
                if (long == 3){
                    var mill = 3;
                }else if(long == 4){
                    var mill = 2;
                }else if(long == 1){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones +'.' + cent;
            }else if(long == 0){
                var tipo = 'Menos de peso';
                var texto = 'Entro: ' + tipo;
            }
            return (texto);
    } 


    function aplicarPago(){
        //alert('aplicaicon de pago');
           var factura='';
           var total =0;
            $("input:checkbox:checked.facturas").each(function(){
            var documento = $(this).attr('doc');
            var monto = parseFloat($(this).attr('monto'),2);
            total = total + monto;
            factura = factura + documento + ','; 
            });
            total= String(total).split(".");
            total = format(total);
            factura = factura.slice(0,-1);
            if(confirm("Desea aplicar el pago de las siguientes facturas?" + factura + 'por un monto de: ' + total)){
                var form = document.getElementById("FORM_ACTION");
                document.getElementById("items").value=factura;
                document.getElementById("total").value=total;
                form.submit();    
            }

            
    }

         /*   
        $(document).ready(function() {
            var semanal = 0;
            var total = 0;            
            $("input.montos").each(function() {
                    var sem = parseFloat($(this).attr("semanal"),2);
                    semanal = semanal + sem;
                    var monTotal = parseFloat($(this).attr("total"),2);
                    total = total + monTotal;  
            });
            var numero = String(semanal).split(".");
            var numero2 = String(total).split(".");
            var texto = format(numero);
            var texto2 = format(numero2);
            document.getElementById('Total').innerHTML="Por cobrar a 7 dias: <font size='4pxs' color='red'>"+texto+"</font>";
            document.getElementById('comp').innerHTML=" Total de los clientes mostrados: <font size='4pxs' color='blue'>"+texto2+"</font>";
        });
*/
   $("#bfactura").change(function(){
        var docf = this.value;
        var info = '';
        var info2 = '';
        docf = docf.toUpperCase();
        alert("Se busca la factura" + docf);
        var list=document.getElementById("info");
        $.ajax({
            url:'index.cobranza.php',
            type:'post',
            dataType:'json',
            data:{traeFactura:docf},
            success:function(data){
                info= "<font color ='blue'>" +
                      "Factura: " + data.factura + "<br/>"+
                      "Cliente: " + data.cliente + "<br/>"+
                      "Fecha: " + data.fecha + "<br/>"+
                      "Importe: " + data.importe + "<br/>"+
                      "Saldo: " + data.saldo + "<br/>"+
                      "Aplicado: " + data.aplicado + "<br/>"+
                      "Aplicacion: " + data.aplicacion + "<br/>"+
                      "Importe_nc: " + data.importe_nc + "<br/>"+
                      "Nc: " + data.nc + "<br/>"+
                      "PagoAplicado: " + data.pagoAplicado + "<br/>"+
                      "FolioBanco: " + data.folioBanco + "<br/>"+
                      "Maestro: " + data.maestro + "<br/>"+
                      "Cve_maestro: " + data.cve_maestro + "<br/>"+
                      "</font>";

                var x= '';
                var x1 = '';
                if(data.saldo <= 0){
                    factura = "'"+data.factura+"'";
                    x = '<th>Ver Aplicaciones</th>';
                    x1 = '<input type="button" value="Ver Aplicaciones" class="btn btn-info" onclick="verAplicaciones('+factura+')">'
                }
                var imp=data.importe;
                imp=String(imp).split(".")
                imp=format(imp);

                var sal=data.saldo;
                sal=String(sal).split(".")
                sal=format(sal)

                var apl=data.aplicado
                apl=String(apl).split(".")
                apl=format(apl)

                var impnc=data.importe_nc
                impnc=String(impnc).split(".")
                impnc=format(impnc)

                info2=  '<div class="row">'+
                            '<div class="col-lg-12">'+
                                '<div class="panel panel-default">'+ 
                                    '<div class="panel-heading">'+
                                        'Informacion de Factura'+
                                    '</div>'+
                        '<div class="panel-body">' +
                            '<div class="table-responsive">'+
                                '<table class="table table-striped table-bordered table-hover">'+
                                    '<thead>' +
                                        '<tr>'+
                                            '<th>Factura</th>'+
                                            '<th>Cliente</th>'+
                                            '<th>Fecha</th>'+
                                            '<th>Importe</th>'+
                                            '<th>Saldo</th>'+
                                            '<th>Aplicado</th>'+
                                            '<th>Aplicacion</th>'+
                                            '<th>Importe NC</th>'+
                                            '<th>NC</th>'+
                                            '<th>Pago Aplicado</th>'+
                                            '<th>Folio Banco</th>'+
                                            '<th>Clave <br/> Maestro</th>'+
                                            '<th>Nombre <br/> Maestro</th>'+
                                            x + 
                                        '</tr>'+
                                        '<tbody>'+
                                            '<tr>'+
                                            '<td>' + data.factura + '</td>'+
                                            '<td>' + data.cliente + '</td>'+
                                            '<td>' + data.fecha + '</td>'+
                                            '<td>' + imp + '</td>'+
                                            '<td>' + sal + '</td>'+
                                            '<td>' + apl + '</td>'+
                                            '<td>' + data.aplicacion + '</td>'+
                                            '<td>' + impnc + '</td>'+
                                            '<td>' + data.nc + '</td>'+
                                            '<td>' + data.pagoAplicado + '</td>'+
                                            '<td>' + data.folioBanco + '</td>'+
                                            '<td>' + data.cve_maestro + '</td>'+
                                            '<td>' + data.maestro + '</td>'+
                                            '<td>' + x1 + '</td>' +
                                        '</tbody>'+
                                    '</tr>'+
                                    '</thead>'+
                                '</table>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';         
            list.innerHTML=info2;    
            }, 
            error:function(data){
                list.innerHTML="<br/><p>No se encontro Informacion de la Factura <font color='blue'>"+ docf +"</font>, favor de revisar la informacion. </p>";
            }
        })
    })

    function verAplicaciones(docf){
        alert('Ver las aplicaciones de la factura ' + docf);
        window.open("index.cobranza.php?action=verAplicacion&docf="+docf, "popup", 'width=1220,height=600');
    }
</script>