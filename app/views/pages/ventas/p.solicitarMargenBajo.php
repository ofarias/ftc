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
                                            <th>CLIENTE</th>
                                            <th>PRODUCTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO SUGERIDO <br/> PRECIO REQUERIDO</th>
                                            <th>UTILIDAD SUGUERIDA <br/>UTILIDAD REQUERIDA</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                       foreach ($skus as $data): 
                                        ?>
                                       <tr>
                                         <td><?php echo '('.$data->CVE_CLIENTE.') '.$data->CLIENTE;?></td>
                                            <td><?php echo 'PGS'.$data->CVE_ART;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                             <td><?php echo $data->FLCANTID?></td>
                                            
                                            <form action="index.v.php" method="post">
                                            <td>
                                                <?php echo '$ '.number_format($data->COSTO_VENTAS,3)?><br/>
                                                <input type="number" step="any" name="precion" id="prec" value="">
                                                <input type="hidden" name="costo" id="COSTO_VENTAS" value="<?php echo $data->COSTO_VENTAS?>">
                                                <input type="hidden" name="folio" value="<?php echo $cotizacion?>">
                                                <input type="hidden" name="partida" value="<?php echo $partida?>">
                                                <input type="hidden" name="cantidad" value="<?php echo $data->FLCANTID?>">
                                            </td>
                                            <td>23 % <br/><input type="number" step="any" name="porcentaje" id="por" value="" required="required" max="23"></td>
                                            <td><button name="enviarSolicitudMB" type="submit" value="enviar " class= "btn btn-success">Solicitar</button></td> 
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