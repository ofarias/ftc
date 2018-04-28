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
            <div class="col-lg-16">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>


            <?php foreach($fallido as $data){?>
             <div class="col-xs-16 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Fecha de Elaboracion: (<font color="red" size="4pxs"><?php echo $data->FECHA_DOC?></font>) 
                                Fecha de Fallo:<font color="red" size="4pxs"><?php echo $data->FECHA_SECUENCIA?></font>
                                UNIDAD:<font color="red" size="4pxs"><?php echo $data->UNIDAD?></font>
                         </h4>
                    </div>
                    <div class="panel-body">
                        <p><font size="4pxs"><b><?php echo $data->NOMBRE?></b></font></p>
                        <p> OC <font size="3pxs" color="red"><b><?php echo $data->OC?></b></font> </p>
                        <p> Confirmado Pegaso <font size="3pxs" color="red" ><b><?php echo $data->USUARIO?></b></font> </p>                        
                        <p> Falla Pegaso: <font size="3pxs" color="red" > <b><?php echo $data->USUARIO_RECIBE?></b></font></p>
                        <center> 
                            <form action="index.php" method="post">
                                <input name="idpoc" type="hidden" value="<?php echo $data->OC?>"/>
                              
                            </form> 
                        </center>
                    </div>
                </div>
            </div>
            <?php }?>


            <?php foreach($preordenes as $key){?>
             <div class="col-xs-16 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Fecha de Elaboracion: (<font color="white" size="4pxs"><?php echo $key->FECHA_DOC?></font>) </h4>
                    </div>
                    <div class="panel-body">
                        <p><font size="4pxs"><b><?php echo $key->NOMBRE?></b></font></p>
                        <p> Preorden de compra <font size="3pxs" color="blue"><b><?php echo $key->CVE_DOC?></b></font> </p>
                        <p> Confirmado Pegaso <font size="3pxs" color="green" ><b><?php echo $key->USUARIO?></b></font> </p>
                        <center> 
                            <form action="index.php" method="post">
                                <input name="idpoc" type="hidden" value="<?php echo $key->CVE_DOC?>"/>
                                <button name="impPOC" type="submit" value="enviar" class="btn btn-info"> Imprimir</button>
                            </form> 
                        </center>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php foreach($cestas as $key){?>
            <div class="col-xs-16 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><font size="2px"><?php echo empty($key->NOMBRE)?  ' Productos Sin Proveedor':substr($key->NOMBRE,0,30) ?></font> </h4>
                        </div>
                        <div class="panel-body">
                            <p><font size="1.5px"><?php echo '('.$key->CLAVE.') '.substr($key->NOMBRE,0,50);?></font> </p>
                            <p>Productos Pendientes: <?php echo $key->PRODUCTOS;?></p>
                            <?php if( $user == 'Gerencia de Compras' or $gerencia == 'G'){?>
                            <p>Responsable: <font color="blue"><?php echo empty($key->RESPONSABLE)? 'Gerente de Compras':$key->RESPONSABLE  ?></font></p>
                             <?php } ?>
                            <center><a href="index.php?action=verCanasta&idprov=<?php echo $key->CLAVE;?>" class="btn btn-default"><img src="app/views/images/Shopping-basket-refresh-icon_small.png"></a></center>
                        </div>
                    </div>
                </div>    
            <?php }?>
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