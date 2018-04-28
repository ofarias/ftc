



Historial del ID Pegaso.

<a href="index.php?action=historiaIDPREOC&amp;id=106885" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">106885</a>


Otra forma de lanzar una ventana emergente:

onClick="window.open(this.href, this.target, 'width=300,height=400'); return false;"
                                            

 <?php 

 <td>
    <input name="fecha" type="text" required="required" class="date" value="<?php echo $fecha?>" />
 </td>

  <button name="ingresarPago" type="submit" value="enviar" class ="btn btn-success" onclick="ocultar(mnt.value)" id= "btnPago"  style="display:inline;">Agregar</button> 

<input type="number" step="any" class="form-control" name="desc2" id="desc2" value="0.00" placeholder ="Descuento 2" min="0" max="100" onChange="CostoTotal(costo_prov.value,desc1.value,this.value,desc3.value,desc4.value,iva);"/><br>


  <!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

  $(document).ready(function() {
    $(".date").datepicker({dateFormat: 'dd.mm.yy'});
  } );

  function ocultar(a){
    if(a == ''){
      //alert('El valor esta vacio' + a);
    }else{
      //alert('Presiono el boton con valor : '+ a);
      document.getElementById('btnPago').classList.add('hide');
     

      //document.getElementById('formCliente').style.display='block
    }
  }
  
</script>

 <a href="index.php?action=docsSucursal&cvecl=<?php echo $sc->CVE_CLPV?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <?php echo '('.$sc->CVE_CLPV.')'.$sc->NOMBRE?> </a>
 

Ocualtar por ID con style:

document.getElementById('modificar').style.display = 'none';
document.getElementById('modificar').style.display = 'hidden';
document.getElementById('modificar').style.display = 'inline';
window.onload=function(){
        var r = document.getElementById('restric').value;
        var c = document.getElementById('cort').value;
    if(r > 0){
        alert('El cliente tiene '+ r + ' documentos con vencimiento de mas de 45 dias, se puede solicitar la restriccion');
      document.getElementById('btnRestr').style.display='inline';
    }
    if(c > 0){
         alert('El cliente tiene '+ c + ' documentos con vencimiento de mas de 45 dias, se puede solicitar el corte de credito');
      document.getElementById('btnCorte').style.display='inline';
     }
  }


<?php 

Refirect 

function guardaCargoFinanciero($monto, $fecha, $banco){
    	session_cache_limiter('private_no_expire');        
     	if (isset($_SESSION['user'])) {            
             $data = new pegaso;
             $pagina = $this->load_template('Pagos');        	            
             ob_start();
             $registro=$data->guardaCargoFinanciero($monto, $fecha, $banco);
             &maestro={$maestro}
             $redireccionar = "regCargosFinancieros";
             $pagina=$this->load_template('Pedidos');
             $html = $this->load_page('app/views/pages/p.redirectform.php');
             include 'app/views/pages/p.redirectform.php';
             $this->view_page($pagina);                     
     	} else {
             $e = "Favor de Iniciar Sesión";
             header('Location: index.php?action=login&e=' . urlencode($e));
             exit;
     	}	
    }
?>
/// Enviar formulario con Script
<form action="index.php" method="POST" id="FORM_ACTION_PAGOS">
  <input name="documento" id="docu" type="hidden" value=""/>
  <input name="proveedor" id="nomprov" type="hidden" value=""/>
  <input name="claveProveedor" id="cveprov" type="hidden" value=""/>
  <input name="importe" id="importe" type="hidden" value="" />
  <input name="fecha" id="fechadoc" type="hidden" value=""/>
  <input name="FORM_NAME" type="hidden" value="FORM_ACTION_PAGO"/>
</form>

<script language="javascript">
  function seleccionaPago(documento, proveedor, claveProveedor, importe, fecha) {
      if (confirm("Esta seguro de realizar el pago de este documento?")) {
          document.getElementById("docu").value = documento;
          document.getElementById("nomprov").value = proveedor;
          document.getElementById("cveprov").value = claveProveedor;
          document.getElementById("importe").value = importe;
          document.getElementById("fechadoc").value = fecha;
          var form = document.getElementById("FORM_ACTION_PAGOS");
          form.submit();
      } else {
          //nada
      }
  }
</script>




Colores 
  $color="style='background-color:brown;'";
  <tr class="odd gradeX" <?php echo $color;?> id="<?php echo $i;?>">

?>



Ver Orden de compra Original 


<a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" >Ver Original</a>


Ver Historial de ID
<a href="index.php?action=historiaIDPREOC&id=<?php echo $data->ID_PREOC?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> <?php echo $data->ID_PREOC?></a>




evitar en enter en los formularios:

en la etiqueta <input onkeypress="return pulsar(event)/>
en el Javascript
 function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 


enviar un formulario en especifico utilizando jquery

 <form action="index.php" method="POST" id="FORM_ACTION">
                                <input type="hidden" name="seleccion_cr" id="seleccion_cr" value="" />
                                <input type="hidden" name="items" id="items" value="" />
                                <input type="hidden" name="total" id="total" value="" />
                                <input type="hidden" name="FORM_ACTION_CR_PAGO" value="FORM_ACTION_CR_PAGO" />
                                <input type="button" id="enviar" value="Realizar pago" class="btn btn-success" />
                            </form>

                            

$("#enviar").click(function (){
        var items = $("#items");
        var folios = "";
        $("input:checked").each(function(index){
            folios+= this.value+",";
        });
        folios = folios.substr(0, folios.length-1);
        console.log("FOLIOS: "+folios);
        items.val(folios);       
        $("#FORM_ACTION").submit();
    });





///// Metodo para enviar por correo:
<?php 
function detallePagoCreditoContrareciboImprime($tipo, $identificador, $montor, $facturap){
        $dao=new pegaso; /// Invocamos la classe pegaso para usar la BD.
        $folio = $dao->almacenarFolioContrarecibo($tipo, $identificador, $montor, $facturap);   /// Ejecutamos las consultas y obtenemos los datos.
        $exec = $dao->detallePagoCredito($tipo, $identificador);    /// Ejecutamos las consultas y obtenemos los datos.
        $_SESSION['folio'] = $folio;   //// guardamos los datos en la variable goblal $_SESSION.
        $_SESSION['exec'] = $exec;    //// guardamos los datos en la variable goblar $_SESSION.
        $_SESSION['titulo'] = 'Contrarecibo de credito';   //// guardamos los datos en la variable global $_SESSION
        echo "<script>window.open('".$this->contexto."reports/impresion.contrarecibo.php', '_blank');</script>";  //// se manda a un conexto para generar el pdf del pago.
        include 'app/mailer/send.contrarecibo.php';   ///  se incluye la classe Contrarecibo
        $act=$dao->actualizaPagoCreditoContrarecibo($tipo, $identificador);  
        $act+=$dao->actualizarFolioContrarecibo($folio);
        $act+=$dao->actualizarRecepcion($identificador);
        echo "Registro actualizado:$act";
        $this->verListadoPagosCredito();
     }
?>




//// Metodo para usar el .ajax

<?php 
 if(COSTO.length != 0 && PROVE.length != 0 && CANTIDA.length != 0){
            $.ajax({
               type: 'GET',
               url: 'index.php',
               data: 'action=preocVerificaProv&provedorr='+prove,   
               success: function(data){
                    var d=data;
                    var res = d.split("|");
                    
                    if(res[0]=="existe"){
                            //SE ACTUALIZA EL REGISTRO
                            var nomProvedor=res[1];
                            $.ajax({
                               type: 'GET',
                               url: 'index.php',
                               data: 'action=preocAct&costo='+costo+'&provedor='+prove+'&provcostid='+provcostid+'&total='+total+'&nombreprovedor='+nomProvedor+'&cantidad='+cantidad+'&rest='+rest,   
                               success: function(data){
                                  if(data=="ok"){
                                        OpenSuccess("El Registro se Actualizo correctamente");
                                  }else{
                                        OpenWarning("No se pudo actualizar, intente mas tarde");
                                  }
                                 
                               }
                            });
                    }else{
                        OpenWarning("Verifica el Proveedor, NO existe");
                        return false;
                    }  
                }
            });   
        }
        $("#costoupdate_"+id).attr("disabled",true);
        $("#prove_"+id).attr("disabled",true);
        $("#cantidad_"+id).attr("disabled",true);
    
        $("#lapiz_"+id).attr("style","display:block");
        $("#disco_"+id).attr("style","display:none");
 
    }
}
?>



<?php 
      function detallePagoCreditoContrareciboImprime($tipo, $identificador, $montor, $facturap){
        $dao=new pegaso;
        $folio = $dao->almacenarFolioContrarecibo($tipo, $identificador, $montor, $facturap);
        $exec = $dao->detallePagoCredito($tipo, $identificador);
        $_SESSION['folio'] = $folio;
        $_SESSION['exec'] = $exec;
        $_SESSION['titulo'] = 'Contrarecibo de credito';
        echo "<script>window.open('".$this->contexto."reports/impresion.contrarecibo.php', '_blank');</script>";
        include 'app/mailer/send.contrarecibo.php';
        $act=$dao->actualizaPagoCreditoContrarecibo($tipo, $identificador);
        $act+=$dao->actualizarFolioContrarecibo($folio);
        $act+=$dao->actualizarRecepcion($identificador);
        echo "Registro actualizado:$act";
        $this->verListadoPagosCredito();
     }
?>


<?php
Autocompletar

en el Index:

elseif(isset($_GET['term']) && isset($_GET['descripcion'])){
    $buscar = $_GET['term'];
    $nombres = $controller->TraeProductosFTC($buscar);
    echo json_encode($nombres);
    exit;
    break;
}

En el controller:

  function TraeProductosFTC($descripcion){
        $datav= new pegaso_ventas;
        $exec = $datav->traeProductosFTC($descripcion);
        return $exec;
    }

En el models:

  function traeProductosFTC($descripcion){
        $this->query="SELECT * FROM producto_ftc where upper(nombre) containing upper('$descripcion')";
        $rs=$this->QueryDevuelveAutocompletePFTC();
        return @$rs;
    }

En el DataBase:
    
    protected function QueryDevuelveAutocompletePFTC(){
      $this->AbreCnx();
      $rs = ibase_query($this->cnx, $this->query);
      while($row = ibase_fetch_object($rs)){
        $row->CLAVE = htmlentities(stripcslashes($row->CLAVE));
        $row->NOMBRE = htmlentities(stripcslashes($row->NOMBRE));
        //$row_set[] = $row->CLAVE;
        $row_set[] = $row->CLAVE." : ".$row->NOMBRE;
      }
      return $row_set;
      unset($this->query);  
      $this->CierraCnx(); 
    }

En el formulario:
  <input type="text" class="form-control" id="prov1" name="prov1" placeholder ="Codigo proveedor1" value="<?php echo $data->CLAVE_DISTRIBUIDOR?>"/><br> 
$("#prov1").autocomplete({
    source: "index.v.php?descripcion=1",
    minLength: 2,
    select: function(event, ui){
    }
  })



?>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script>
                                       function enviaxml(id) {
                                            //alert(id);
                                            $.confirm({
                                                title: 'Envío de xml',
                                                content: '¿Seguro que deseas validar el xml del folio de factura ' + id + '?',
                                                buttons: {
                                                    Enviar: function () {
                                                        // here the key 'something' will be used as the text.
                                                        var url = "index.php"; // El script a dónde se realizará la petición.
                                                        $.ajax({
                                                            type: "POST",
                                                            url: url,
                                                            dataType: "json",
                                                            data: {compruebaXml: id}, // Adjuntar los campos del formulario enviado.
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
                                                                //console.log(data);
                                                                $('#pop').hide();
                                                                if (data.status == "OK") {
                                                                    //después de que la valiadacion sea correcta, eliminamos el row
                                                                    $('#' + id + '').remove();
                                                                    //y avisamos que se validó
                                                                    $.alert('Se validó correctamente.');
                                                                } else {
                                                                    $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                                                    console.log("XML:"+data.xml);
                                                                }


                                                            }
                                                        });

                                                    },
                                                    Cancelar: {
                                                        //text: 'Something else &*', // Some Non-Alphanumeric characters
//                                                        action: function () {
//                                                            $.alert('You clicked on something else');
//                                                        }
                                                    }
                                                }
                                            });
                                        }
</script>



Mensaje Confirm con Jquery
<div id="pop">
    <center><i class="fa fa-spinner fa-spin fa-5x" aria-hidden="true"></i></center>
</div>
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

                                            $.confirm({
                                                title: 'Liberar Orden de Compra',
                                                content: 'Puede ser que la Orde ' + b + ' , se este recepcionando, favor de verificar...',
                                                buttons: {
                                                    Liberar: function () {
                                                        // here the key 'something' will be used as the text.
                                                        var url = "index.php"; // El script a dónde se realizará la petición.
                                                       



                                                       $.ajax({
                                                            type: "POST",
                                                            url: url,
                                                            dataType: "json",
                                                            data: {test9: b}, // Adjuntar los campos del formulario enviado.
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
                                                                //console.log(data);
                                                                $('#pop').hide();
                                                                if (data.status == "OK") {
                                                                    //después de que la valiadacion sea correcta, eliminamos el row
                                                                    $('#' + b + '').remove();
                                                                    //y avisamos que se validó
                                                                    $.alert('Se validó correctamente.');
                                                                } else {
                                                                    $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                                                    console.log("XML:"+data.test);
                                                                }


                                                            }
                                                        });

                                                    },
                                                    Cancelar: {
                                                        //text: 'Something else &*', // Some Non-Alphanumeric characters
//                                                        action: function () {
//                                                            $.alert('You clicked on something else');
//                                                        }
                                                    }
                                                }
                                            });
</script>

<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
function OpenWarning(mensaje) {
                var mensaje = mensaje || "Algo no salió como se esperaba...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-warning warning\"></i>",
                    className: "modal modal-message modal-warning fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-warning",
                            callback: function () {
                            console.log("XML:"+data.xml);
                            }
                        }
                    }
                });
}

function OpenSuccess(mensaje) {
                var mensaje = mensaje || "Todo bien...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-check success\"></i>",
                    className: "modal modal-message modal-success fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-success",
                            callback: function () {
                                 window.location="index.php?action=ordcomp";
                            }
                        }
                    }
                });
}

</script>

jquery

$("#GOC").click(function() {
    if($(".Selct").is(":checked")){
        document.frmOrdCom.submit();
//OpenWarning("Estamos trabajando en esta seccion");
    }else{
        OpenWarning("Seleccione al menos una Partida");
    }
});


$(document).ready(function() {
            $("input:checkbox:checked.compra").each(function() {
                     var comp = $(this).attr("docu");
                     var tipo = $(this).attr("tipo");
                     var a = parseFloat(this.value,2);
                     compras = compras + a;
                     docCompras = docCompras + ',' + comp;
                });
              });

document.addEventListener("DOMContentLoaded",function(){
    var fac = document.getElementsByName("factura");
    var boton = document.getElementsByName("asociarFactura");
    var up = document.getElementsByName("archivo"); //uploadfile
    var botonup = document.getElementsByName("comprobanteCaja");
        var xmlfile = document.getElementsByName("xmlfile");
    var cuentaCajas = 0;
    var cuentaUp = 0;   //uploadfile
    for(contador = 0; contador < fac.length; contador++){
        if(fac[contador].value == ""){
            //boton[contador].disabled = true;
            //botonup[contador].disabled = true;
            //fac[contador].readOnly = true;
        }else{
            //boton[contador].disabled = false;
            //fac[contador].readOnly = true;
            cuentaCajas += 1;
        }
        
        if(up[contador].value != ""){   //uploadfile
            cuentaUp += 1;
        }                               //uploadfile
        if(xmlfile[contador].value != ""){
            document.getElementsByName("xml")[contador].type = 'text';
            document.getElementsByName("xml")[contador].readOnly = true;
            document.getElementsByName("xml")[contador].value = xmlfile[contador].value;
            document.getElementsByName("xmlFactura")[contador].disabled=true;
            cuentaXml += 1;
        }

        //if(fac[contador].value != "" && up[contador].value == ""){
        //    botonup[contador].disabled = false;
        //}
    }


});

document.getElementById("imprimir").addEventListener("click",function(){
    setTimeout(function(){ window.location.reload(); }, 1000);  
});

/*function validarTextBox(texto,boton1,boton2){
    //alert(texto+boton1+boton2);
    if(texto.length > 5){
        document.getElementById(boton2).disabled = false;
        document.getElementById(boton1).disabled = false;
    }else if(texto.length < 5){
        document.getElementById(boton2).disabled = true;
        document.getElementById(boton1).disabled = true;
    }
}*/



<script>
    document.addEventListener('DOMContentLoaded',function(){
        tabla1= document.getElementById("tabla1");
        for (c = 0; c < tabla1.rows.length; c++){
            if(tabla1.rows[c].cells[0].innerHTML == 'Total cliente' || tabla1.rows[c].cells[0].innerHTML == 'Total general'){
                tabla1.rows[c].cells[12].innerHTML = '';
                tabla1.rows[c].cells[13].innerHTML = '';
            }
        }

        tabla2= document.getElementById("tabla2");
        for (c = 0; c < tabla2.rows.length; c++){
            if(tabla2.rows[c].cells[0].innerHTML == 'Total cliente' || tabla2.rows[c].cells[0].innerHTML == 'Total general'){
                tabla2.rows[c].cells[12].innerHTML = '';
                tabla2.rows[c].cells[13].innerHTML = '';
            }
        }

        tabla3= document.getElementById("tabla3");
        for (c = 0; c < tabla3.rows.length; c++){
            if(tabla3.rows[c].cells[0].innerHTML == 'Total cliente' || tabla3.rows[c].cells[0].innerHTML == 'Total general'){
                tabla3.rows[c].cells[12].innerHTML = '';
                tabla3.rows[c].cells[13].innerHTML = '';
            }
        }

    });
</script>


INSERTAR EN EL HISTORIAL DE CAJAS 


$this->query="INSERT INTO FTC_HISTORIA_CAJA VALUES(NULL,(SELECT STATUS_RECEPCION FROM CAJAS WHERE ID = $idcaja), 6, CURRENT_TIMESTAMP, '$usuario', $idcaja, (SELECT iif(factura = '', remision , factura) from cajas where id = $idcaja))";
$this->grabaBD();


$this->query="INSERT INTO FTC_HISTORIA_CAJA VALUES(NULL,(SELECT STATUS_RECEPCION FROM CAJAS WHERE ID = $cotizacion), 6, CURRENT_TIMESTAMP, '$usuario', $cotizacion, (SELECT iif(factura = '', remision , factura) from cajas where id = $cotizacion))";
$this->grabaBD();



$mysql= new pegaso_rep;
$datos = array($unidad, $idcaja);
$sql = $mysql->asignaUnidad($datos);  

###############################    Crear elementos con javascript o jquery  #######################################

                                var midiv = document.createElement("div");
                                var del = document.createElement("input");
                                midiv.setAttribute("id","div_"+data.linea);
                                del.setAttribute("type","button");
                                del.setAttribute("id",data.linea);
                                del.setAttribute("onclick","borrar("+data.linea+")");
                                del.setAttribute("value","Eliminar");
                                //midiv.setAttribute("id","d_");
                                //midiv.setAttribute("otros atributos","otros");
                                midiv.innerHTML = "<p>"+ data.prod + " <font color='blue'>&nbsp;&nbsp; Cantidad: " + cant + " </font> <font color='red'>&nbsp;&nbsp; Total : $ "+ data.total + "</font>"+"</p>";
                                document.getElementById('cuerpo').appendChild(midiv); // Lo pones en "body", si quieres ponerlo dentro de algún id en concreto usas     document.getElementById('donde lo quiero poner').appendChild(midiv);*/
                                document.getElementById('cuerpo').appendChild(del);

######################################################################################################################                              