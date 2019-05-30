<?php if(count($embalaje) > 0){?>
<br /> <br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Recibir Mercancia de Devolucion a Bodega.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ENVIO</th>
                                            <th>Documento</th>
                                            <th>Caja</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquete</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Cantidad Devuelta</th>
                                            <th>Paquete1</th>
                                            <th>de</th>
                                            <th>Paquete2</th>
                                            <th>Tipo</th>
                                            <th>Peso</th>
                                            <th>Cantidad</th>
                                            <th>Recibir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($embalaje as $data):
                                            $idcaja = $data->IDCAJA;
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->TIPO_ENVIO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->IDCAJA;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->DEVUELTO;?></td>
                                            <td><?php echo $data->PAQUETE1;?></td>
                                            <td> de </td>
                                            <td><?php echo $data->PAQUETE2;?></td>
                                            <td><?php echo $data->TIPO_EMPAQUE;?></td>
                                            <td><?php echo $data->PESO;?></td>  
                                            <form action="index.php" name="form" method="post">
                                            <td><input type="number" step="any" name = "cantr" value ="0" required = "required" min="0.0001" max="<?php echo $data->CANTIDAD - $data->DEVUELTO?>" />
                                            <input name="docf" type="hidden" value="<?php echo $data->DOCUMENTO?>"/>
                                            <input name="idc" type="hidden" value="<?php echo $data->IDCAJA?>" />
                                            <input name="id" type= "hidden" value="<?php echo $data->ID?>"/>
                                            <input name="idpreoc" type = "hidden" value = "<?php echo $data->ID_PREOC?>" />   
                                             <select required="required" name="motivoDev">
                                                    <option value="">Motivo</option>
                                                    <option value="cancela">Cancelacion de Pedido</option>
                                                    <option value="noSol">Materla No Solicitado</option>
                                                    <option value="noExis">No Existe Orden de Compra Cliente</option>
                                                    <option value="malSol">Material Mal Solicitado</option>
                                                    <option value="dañado">Material Dañado</option>
                                            </select>                                            
                                        </td>
                                            <td> 
                                            <button name = "recibirCajaNC" type="submit" value="enviar"> Recibir </button>
                                            </td>    
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                <select  name="motivo" id="motivoGral">
                                     <option value="">Motivo</option>
                                                    <option value="cancela">Cancelacion de Pedido</option>
                                                    <option value="noSol">Materla No Solicitado</option>
                                                    <option value="noExis">No Existe Orden de Compra Cliente</option>
                                                    <option value="malSol">Material Mal Solicitado</option>
                                </select>
                                <input type="button" name="devTodo" onclick="devolucionTotal()" value="Devolucion Total">
                            </div>
                      </div>
            </div>
        </div>
</div>
<br/>
<?php }?>
<?php if(count($devuelto) > 0){
?>

<br /> <br/> <br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mercancia de Devolucion en Bodega.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ENVIO</th>
                                            <th>Documento</th>
                                            <th>Caja</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquete</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Devuelto</th>
                                            <th>Paquete1</th>
                                            <th>de</th>
                                            <th>Paquete2</th>
                                            <th>Tipo</th>
                                            <th>Peso</th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($devuelto as $data):
                                            $idcaja = $data->IDCAJA;
                                            $idDev = $data->FOLIO_DEV;
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->TIPO_ENVIO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->IDCAJA;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->DEVUELTO;?></td>
                                            <td><?php echo $data->PAQUETE1;?></td>
                                            <td> de </td>
                                            <td><?php echo $data->PAQUETE2;?></td>
                                            <td><?php echo $data->TIPO_EMPAQUE;?></td>
                                            <td><?php echo $data->PESO;?></td>
                                            <form action="index.php" name="form1" method="post" id="recimp">
                                            <!--<input name="cantr" type="hidden" value = "<?php echo $data->DEVOLUCION?>" />-->
                                            <input name="docf" type="hidden" value="<?php echo $data->DOCUMENTO?>"/>
                                            <input name="idc" type="hidden" value="<?php echo $data->IDCAJA?>" />
                                            <input name="id" type= "hidden" value="<?php echo $data->ID?>"/>
                                            <input name="idpreoc" type = "hidden" value = "<?php echo $data->ID_PREOC?>" />
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
                      <div class= "panel-footer" >
                            <button name = "ImprimirDevolucion" onclick="generaDevolucion()" id="btn2"> Recibir e Imprimir </button>
                      </div>
            </div>
        </div>

</div>
<br/>
<?php }?>

<form action="index.php" id="formdevtotal" method="POST">
    <input type="hidden" name="idc" value="<?php echo $idcaja?>" id="idCaja">
    <input type="hidden" name="docf" value="<?php echo $docf?>" id="docF">
    <input type="hidden" name="id" value="T">
    <input type="hidden" name="motivoDev" value="" id="motivoGralout">
    <input type="hidden" name="recibirCajaNC" value="T">
    <input type="hidden" name="idpreoc" value="0">
    <input type="hidden" name="cantr" value="0">
</form>

<form action="index.php" method="POST" id="formRecMcia">
    <input type="hidden" name="recibirMercancia" >
</form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>

        function devolucionTotal(){
            var motivo = document.getElementById('motivoGral').value;
            if(motivo==""){
                    alert('Seleccionar un motivo');
            }else{
                    
                if(confirm('Esta Seguro de recibir todas las Partidas al almacen?')){
                    alert('Proceder con la devolucion total');
                    document.getElementById('motivoGralout').value=motivo;
                    var form = document.getElementById('formdevtotal');
                    form.submit();
                }
            }
        }

        function generaDevolucion(){
            var docf = document.getElementById('docF').value;
            var idc = document.getElementById('idCaja').value;
            //alert('Generar el archivo');
            document.getElementById('btn2').classList.add('hide');
            $.ajax({
                url:'index.php',
                method:'POST',
                dataType:'json',
                data:{generaDevolucion:1,docf:docf, idc:idc},
                success:function(data){
                   var folio = data.devolucion;
                   //alert('genera el archivo' + data.devolucion + ' status: ' + data.status);
                   if(data.status == "ok"){
                        //alert('entra a crear el archivo');
                        //var form = document.getElementById('recimp');
                        $.ajax({
                            url:'index.php',
                            method:'POST',
                            dataType:'json',
                            data:{generaPDFdev:1, docf:docf, idc:idc},
                        });
                        
                        $.ajax({
                            url:'index.php',
                            method:'POST',
                            dataType:'json',
                            data:{avisoDevMail:1,docf:docf, idc:idc, dev:data.devolucion},
                        });

                        var form = document.getElementById('formRecMcia');
                        form.submit();
                   }

                }
            });


        }

</script>