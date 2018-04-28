<div class="row">
    <div class="col-lg-16">
         <div class="col-xs-16 col-md-6">
            <br/><br/>
            <label>&nbsp;&nbsp;Buscar ID:</label>&nbsp;&nbsp;<input type="text" name="idp" value="" placeholder="Coloca ID" id="idp">&nbsp;&nbsp;<input type="button" name="buscar" value="Buscar" class="btn btn-info" id="buscar">
             <div id="resultado">
            </div>
            <div id="o">
            </div>
        </div>
        </div>
       
    </div>
</div>


<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Inventario Fisico</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=verInventarioBodega" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div> 

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Liberar Pedido a Produccion </h4>
                    </div>
                    <div class="panel-body">
                        <p>Cajas y Pedidos.</p>
                        <center><a href="index.php?action=verCajasAlmacen" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>  
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ventas x Mes</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.v.php?action=cajas" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Status Orden</h4>
                    </div>
                    <div class="panel-body">
                        
                        <center><a href="index.php?action=buscaOC2" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Crear Pedido</h4>
                    </div>
                    <div class="panel-body">
                        <p>Crear Pedidos</p>
                        <center><a href="index.v.php?action=consultarCotizacion" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Productos </h4>
                    </div>
                    <div class="panel-body">
                        <p>Asignar Clientes y SKU a Productos</p>
                        <center><a href="index.v.php?action=verFTCArticulosVentas" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

            <?php if($rechazos >= 1){ ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Solicitudes Rechazadas Sin Revisar </h4>
                    </div>
                    <div class="panel-body">
                        <p>Solicitudes rechazadas <?php echo $rechazos?></p>
                        <center><a href="index.php?action=verRechazos" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
            <?php } ?>            
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Estado de Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        
                        <center><a href="index.php?action=pedimento" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
               <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Buscar Cajas por pedido </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=BuscarCajasxPedido" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Lista de Todos los Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=lista_t_pedidos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Relacion Ids </h4>
                    </div>
                    <div class="panel-body">
                        <p> Reporte </p>
                        <center><a href="index.php?action=IdvsComp" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> PRODUCTOS POR RFC </h4>
                    </div>
                    <div class="panel-body">
                        <p> VENTAS POR RFC</p>
                        <center><a href="index.php?action=ProdRFC" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
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
        $("#buscar").click(function(){
            var id = document.getElementById("idp").value;
            if(id ==""){
                alert("Favor de capturar un ID");
            }else{
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{buscaID:id},
                    success:function(data){
                        if(data.idstatus == 'N'){
                            var s = '<font color="red">En cesta, </font>';
                            var mensaje = data.cotiza + '-->' + data.idproducto +', '+ s +  ' Proveedor: ' + data.idprov + ' Proveedor alterno: '+ data.idpalterno;
                        }else if(data.idstatus == 'J'){
                            var s = '<font color="red">Cambio de proveedor,</font> ';
                            var mensaje = data.cotiza +'-->' + data.idproducto +', '+ s +  ' Proveedor: ' + data.idprov + ' Proveedor alterno: '+ data.idpalterno;
                        }else if(data.idstatus == 'X'){
                            var s = '<font color="red">Preorden,</font> ';
                            var mensaje = data.cotiza +'-->' + data.idproducto +', '+  s + ' Proveedor: ' + data.idprov + ' Proveedor alterno: '+ data.idpalterno;
                        }else if(data.idstatus == 'B'){
                            var s= '<font color="red">Ordenado,</font> ';
                            var mensaje = data.cotiza +'-->' + data.idproducto +', '+  s +  ' Proveedor: ' + data.idprov + ' Proveedor alterno: '+ data.idpalterno ;
                        }else if(data.idstatus == 'R'){
                            var mensaje = data.cotiza + ' Rechazado ';
                        }else if(data.idstatus == 'P'){
                            var mensaje = data.cotiza + ' Pendiente ';
                        }else{
                            var mensaje = 'No se encontro informaicon';
                        }
                        if(data.rec_faltante == 0 ){
                            var mensaje = 'Completo';
                        }
                        var i = 0;
                        var orden = '';
                        $.each(data.Ordenes, function(key,value){
                            i+=1;
                            orden += "<p><font size='5pxs' color='orange'>&nbsp;&nbsp; " +  value + "</font></p>"; 
                        });

                        var midiv = document.getElementById('resultado');
                         midiv.innerHTML = "<br/><p><font size='5pxs' color='blue'>&nbsp;&nbsp; " + mensaje + " </font> <font color='red'></font></p>";
                       
                        var midiv2 = document.getElementById('o');
                        midiv2.innerHTML="<p>" + orden +"</p>";
                        while(midiv2.firstChild) {
                            element.appendChild(midiv2.firstChild);
                        }
                        //("status"=>'ok',"resultado"=>'ok', "idstatus"=>$status, "idprov"=>'('.$proveedor.')'.$nomprov,"ordenado"=>$ordenado,"rec_faltante"=>$faltante,  "idpalterno"=>'('.$cvealt.')'.$nomalt,"Ordenes"=>$data);
                    }
                });
            }
        });
       
</script> 

    