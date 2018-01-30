<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Solicitudes Pendientes.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>COTIZACION</th>
                                            <th>VENDEDOR</th>
                                            <th>CLIENTE</th>
                                            <th>CANTIDAD</th>
                                            <th>PRODUCTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>COSTO</th>
                                            <th>PRECIO</th>
                                            <th>UTILIDAD COTIZACION</th>
                                            <th>UTILIDAD SOLICITADA</th>
                                            <th>UTILIDAD AUTORIZADA</th>
                                            <th>AUTORIZAR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                       foreach ($smb as $data): 
                                        ?>
                                       <tr>
                                         <td><?php echo $data->SERIE.$data->FOLIO;?></td>
                                            <td><?php echo $data->CDUSUARI;?></td>
                                            <td><?php echo '('.$data->CLAVE.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->FLCANTID?>
                                            <td><?php echo $data->CLAVE_PROD?></td>
                                            <td><?php echo $data->GENERICO;?></td>
                                            <td><?php echo $data->DBIMPCOS;?></td>
                                            <td><?php echo $data->DBIMPPRE;?></td>
                                            <td><?php echo ''?></td>
                                            <td><?php echo number_format($data->UTILIDAD,2).' %'?> <br/> <br/>$ <?php echo number_format((($data->DBIMPCOS * ($data->UTILIDAD /100)) + $data->DBIMPCOS ),2)?></td>
                                            <form action="index.v.php" method="post">
                                                <input id="COSTO_VENTAS" type="hidden" name="costo" value="<?php echo $data->DBIMPCOS?>">
                                            <td>
                                            Porcentaje: <input id="por" type="number" step="any" min="-100" max="100" name="utilAuto" required="required"><br/><br/>
                                            Precio: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input id="prec" type="number" step="any" min="0" name="precio" required="required">
                                            </td>
                                            <input type="hidden" name="folio" value="<?php echo $data->CDFOLIO;?>"/>
                                            <input type="hidden" name="partida" value="<?php echo $data->CVE_ART?>">
                                            <td>
                                             <button name="autMB" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Autorizar</button>
                                             </td> 
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
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

 $(document).ready(function(){
            $('#prec').change(function(){
                var costo = document.getElementById('COSTO_VENTAS').value;
                var precio = document.getElementById('prec').value;
                var porcentaje = (parseFloat(precio,3) / parseFloat(costo,3)*100)-100;
                //alert("Cargo Jquery" + porcentaje.toFixed(3));
                document.getElementById('por').value=porcentaje.toFixed(3);

            });
            $('#por').change(function(){
                var costo = document.getElementById('COSTO_VENTAS').value;
                var por = document.getElementById('por').value;
                
                var porcentaje = (parseFloat(costo,2) * (parseFloat(por,2)/100));
                document.getElementById('prec').value=(parseFloat(costo,2)+porcentaje);
                if(por > 23 ){
                    alert('Para autorizar es necesario un margen menor al 23 %');
                    
                }
                //alert("Codigo JQuery" + porcentaje);
            });
    });

</script>