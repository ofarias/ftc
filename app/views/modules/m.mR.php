 <?php 
        $status5='';
        $status6='';
        $status7='';
        $status8='';
        $status9='';
        $status10='';
        foreach ($docs as $key){     
                    if($key->STATUS_RECEPCION == 5 ){
                        $status5 = 'Por Recibir';
                        $cantidad5 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 6 ){
                        $status6 ='Recibidos';
                        $cantidad6 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 7){
                        $status7 = 'Archivos';
                        $cantidad7 = $key->DOCUMENTOS;
                    }elseif ($key->STATUS_RECEPCION == 8) {
                        $status8  = 'Contrarecibo';
                        $cantidad8 = $key->DOCUMENTOS;
                    }elseif ($key->STATUS_RECEPCION == 9) {
                        $status9 = 'Cobranza';
                        $cantidad9 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 61){
                        $status10 = 'Recibidos';
                        $cantidad10 = $key->DOCUMENTOS;
                    }
        }
?>                
<?php 
    $cantidad5 = isset($cantidad5)? (int)$cantidad5:0;
    $cantidad6 = isset($cantidad6)? (int)$cantidad6:0;
    $cantidad7 = isset($cantidad7)? (int)$cantidad7:0;
    $cantidad8 = isset($cantidad8)? (int)$cantidad8:0;
    $cantidad9 = isset($cantidad9)? (int)$cantidad9:0;
    $cantidad10 = isset($cantidad10)? (int)$cantidad10:0;
    $sinAvanzar = $cantidad5 + $cantidad6 + $cantidad10;
?>
<?php 
    $asignacion = 0;
    $secuencia = 0;
    $admon = 0;
    $total = 0;
    $recep = 0;
    foreach ($logistica as $caja){
    if($caja->STATUS_RECEPCION == 0){
        $asignacion = $caja->CAJA;
    }elseif ($caja->STATUS_RECEPCION == 1 ) {
        $secuencia = $caja->CAJA;
    }elseif ($caja->STATUS_RECEPCION == 2) {
        $admon = $caja->CAJA;
    }elseif ($caja->STATUS_RECEPCION == 3) {
        $recep = $caja->CAJA;
    }
    $total = $admon +  $asignacion + $secuencia;
}
?> 
<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div>
                <label> Bienvenido: <?php echo $usuario?></label>
            </div>
<div class="row">
    <div class="col-lg-16">
         <div class="col-xs-16 col-md-6">
            <br/><br/>
            <label>&nbsp;&nbsp;Ubicar Factura O Pefactura:</label>&nbsp;&nbsp;<input type="text" name="idp" value="" placeholder="Colocar Documento " id="docv">&nbsp;&nbsp;<input type="button" name="buscar" value="Buscar" class="btn btn-info" id="buscar" style="text-transform:uppercase;">
             <div id="resultado">
             </div>
            <div id="o">
            </div>
        </div>
        </div>
    </div>
<div class="row">
    <div class="col-lg-16">
        <div class="col-xs-16 col-md-6">
            <label>Buscar Factura: </label><br/>
            Factura: <input type="text" name="fact"  maxlength="20" minlength="3" id="bfactura" style="text-transform:uppercase;">
            <br/>
            <label id="info"></label>
        </div>
    </div>
</div>

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div class="col-md-4">
               <div class="panel panel-default">
                   <div class="panel-heading"> 
                       <h4><i class="fa fa-list-alt"></i> Recepcion de Logistica </h4>
                   </div>
                   <div class="panel-body">
                       <p>Total de Documento pendientes <?php echo $total?></p>
                       <p><font color="blue">En Asignacion de Unidad </font><font color="red">&nbsp;:&nbsp; <?php echo $asignacion?></font></p>
                       <p><font color="blue">En Secuencia </font><font color="red">&nbsp;:&nbsp;<?php echo $secuencia?></font></p>
                       <p><font color="blue">En Administracion de Ruta </font><font color="red">&nbsp;:&nbsp;<?php echo $admon?></font></p>
                       <p><font color="blue">Documentos Pendientes  por Recibir </font><font color="red">&nbsp;:&nbsp;<?php echo $recep?></font></p>
                       <center><a href="index.php?action=recibirLogistica&ruta=a" class="btn btn-default"><p class="btn btn-info"><?php echo $admon+$recep+$secuencia ?></p></a></center>
                   </div>
               </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> FOLIOS DE FACTURACION </h4>
                    </div>
                    <div class="panel-body">
                        <p>Logistica / Bodega / CxC </p>
                        <center><a href="index.php?action=seguimientoCajas" class="btn btn-default" target="popup" onclick="window.open(this.href, this.target, 'width=800, height=800')"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div>
           <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Docs Recibidos Sin Contrarecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Recibir Documentos</p>
                        <p><?php echo (!isset($status10))? '':$status10.': <font color="green" size="3pxs">'.$cantidad10.'</font>'?></p>
                        <?php if(isset($status5)){?>
                            <p><?php echo 'Finalizados Logistica: <font color="red" size="3.pxs">'.$cantidad5.'</font>'?></p>
                        <?php }?>

                        <p><?php echo 'Pendientes de Recibir: <font color="red" size="3.pxs">'.$cantidad6.'</font>'?></p>
                        <p><?php echo 'Total Sin Avanzar: <font color="red" size="3.pxs">'.$sinAvanzar.'</font>'?></p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" class="btn btn-default"><img src="app/views/images/folder-invoices-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos Con Contarrecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos con Contrarecibo</p>
                        <p>Cantidad: <font color="red"><?php echo $cantidad7?></font> </p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=7" class="btn btn-default"><img src="app/views/images/User-Files-icon.png"></a></center>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function verRuta(idr){
      window.open('index.cobranza.php?action=verRutaCobranza&idr='+idr, '_blank', 'width=1200, height=800')
    }

    function verCedula(idr){
      window.open('index.cobranza.php?action=verCedula&idr='+idr, '_blank', 'width=1200, height=800')
    }

    $("#buscar").click(function(){
            var id = document.getElementById("docv").value;
            if(id ==""){
                alert("Favor de capturar un documento.");
            }else{
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{buscaDocv:id},
                    success:function(data){
                        var seg;
                        if(data.st == 'no'){
                            var s = '<font color="red"> No se encontro informacion del documento:  </font>';
                            var mensaje = id;
                        }else if(data.st == 'ok'){
                            var ventana = "'width=1800,height=1200'";
                            var s = 'Se encontro la informacion: ';
                            var mes = data.fechaCaja.substring(5,7);;
                            var anio = data.fechaCaja.substring(0,4);
                            var dia = data.fechaCaja.substring(8,10);
                            var seg ='<a href="index.php?action=seguimientoCajasDiaDetalle&anio='+ anio + '&mes='+ mes +'&dia='+ dia+'"  class="btn btn-info" target="popup" onclick="window.open(this.href, this.target,'+ ventana +' ); return false;" > Ver Seguimiento de Documentos </a>';
                            var mensaje = '<br/>Caja: ' + data.caja + '<br/> fecha del consecutivo: ' + data.fechaCaja + seg +'<br/> Status logistica: ' + data.logistica + '<br/> Status de la caja: ' + data.status;
                        }
                        var midiv = document.getElementById('resultado');
                         midiv.innerHTML = "<br/><p><font size='5pxs' color='blue'>&nbsp;&nbsp; " + s + " </font> <font size='5pxs' color='red'>"+ mensaje + "</font></p>";
                        //("status"=>'ok',"resultado"=>'ok', "idstatus"=>$status, "idprov"=>'('.$proveedor.')'.$nomprov,"ordenado"=>$ordenado,"rec_faltante"=>$faltante,  "idpalterno"=>'('.$cvealt.')'.$nomalt,"Ordenes"=>$data);
                    }
                });
            }
        });

      function actAcr(){
            if(confirm('Este proceso tardara de 1 a 2 minutos')){
                $.ajax({
                    url:'index.cobranza.php',
                    type:'post',
                    dataType:'json',
                    data:{actAcr:1},
                    success:function(data){
                        alert(data.mensaje)
                        location.reload(true)
                    },
                    error:function(){
                        alert('Ocurrio un error favor de intentar mas tarde...')
                    }
                })
            }else{
                return false;
            }
        }


</script>
    