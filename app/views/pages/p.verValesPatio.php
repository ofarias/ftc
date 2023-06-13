<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de productos Asignados automaticamente;
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th align="center">Folio Inventario<br/> Vale</th>
                                            <th align="center">Identificador <br/> IDPREOC </th>
                                            <th>Clave <br/>Pegaso</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad Recibida</th>
                                            <th align="center">Cantidad <br/> Empacada </th>
                                            <th>En Bodega</th>
                                            <th>Piezas del Vale</th>
                                            <th>Fecha del <br/> Movimiento </th>
                                            <th>Usuario de <br/> Suministros</th>
                                            <th>Cotizacion <br/> Asociada</th>
                                            <th>Status</th>
                                            <th>Costo <br/>Unitario</th>
                                            <th>Tipo de Vale</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $totalVales = 0;
                                        foreach ($vales as $data):
                                               
                                                $status = $data->STATUS;
                                                $costoVale = (($data->COSTO));
                                                $totalVales = $totalVales +  $costoVale;
                                            ?>
                                        <tr>
                                            <td align="center"><?php echo '<b>'.$data->FOLIO.'</b><br/><font color="grey">'.$data->ID.'</font>';?></td>
                                            <td align="center"><?php echo $data->IDPREOC;?></td>
                                            <td> <?php echo $data->PROD?></td>
                                            <td> <?php echo $data->NOMPROD?> </td>
                                            <td align="center"><?php echo $data->CANT_ORIG;?></td>
                                            <td align="center"><?php echo $data->EMPACADO?></td>
                                            <td><?php echo $data->CANT_FIS?></td>
                                            <td align="center"><font size="3pxs" color="red"><n><?php echo ($data->CANT_ORIG - $data->EMPACADO  - $data->CANT_FIS)?></n></font></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->COTIZA?></td>
                                            <td><font color="red"><b><?php echo $status?></b></font></td>
                                            <td><?php echo '$ '.number_format(($data->COSTO),2)?></td>
                                            <td align="center">
                                               <?php echo strtoupper($data->TIPO)?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label><font color="red" size="12 px">Costo Total de Vales: <?php echo '$ '.number_format($totalVales,2)?></font></label>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

function quitarSum(ida){
    //var ida = document.getElementById('ida'_).value;
        document.getElementById('boton_'+ ida).classList.add('hide');
    $.ajax({
        url:'index.php',
        method: 'POST',
        dataType:'json',
        data:{quitarSum:ida}
    });
}

</script>
