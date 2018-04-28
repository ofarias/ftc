<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Ver Solicitudes de Corte y Restriccion.
            </div>
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>
                                
                                <th>Cliente</th>
                                <th>Maestro</th>
                                <th>Saldo Vencido</th>
                                <th>Fecha Solicitud</th>
                                <th>Usuario Solicita</th>
                                <th>Tipo Solicitus</th>
                                <th>Credito</th>
                                <th>Comprometido <br/> Cotizaciones</th>
                                <th>Comprometido <br/> Pedidos</th>
                                <th>Comprometido <br/> Remisiones</th>
                                <th>Monto A Autorizar</th>
                                <th>Dias</th>
                                <th>Ejecutar</th>
                                <th>Rechazar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach ($solicitudes as $data):
                            if($data->STATUS == 1){
                                $tipo = 'Restriccion';
                                $color = "style='background-color:#ffa64d'";    
                            }elseif ($data->STATUS == 2) {
                                $tipo = 'Corte';
                                $color = "style='background-color:#cc99ff'";
                            }
                            $totalComp = $data->COTIZACIONES + $data->MONTOPEDIDOS + $data->MONTOREMISIONES;
                            $maximo =$data->LIMCRED - ($data->SALDOCOBRANZA + $totalComp) ;
                        ?>
                            <tr class="odd gradex" <?php echo $color;?>>
                                <td>
                                    <?php echo $data->CVE_CLPV.' / '.$data->NOMBRE?> 
                                </td>
                                <td><?php echo $data->CVE_MAESTRO.' / '.$data->MAESTRO ;?> </td>
                                <td><?php echo '$ '.number_format($data->SALDOCOBRANZA,2)?></td>
                                <td><?php echo $data->FECHA_SOL?></td>
                                <td align="right"><?php echo $data->USUARIO_SOL;?></td>
                                <td> <?php echo $tipo ;?></td>
                                <td align="right"><?php echo '$ '.number_format($data->LIMCRED,2)?></td>
                                <td align="right"> <?php echo '$ '.number_format($data->COTIZACIONES,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($data->MONTOPEDIDOS,2)?></td>
                                <td align="right"><?php echo '$ '.number_format($data->MONTOREMISIONES,2)?></td>
                                <form action="index.php" method="post">
                                    <input type="hidden" name="idsolc" value="<?php echo $data->ID?>">
                                    <input type="hidden" name="cveclie" value ="<?php echo $data->CVE_CLPV?>">
                                    <input type="hidden" name="total" id="total_<?php echo $data->ID?>" value="<?php echo $totalComp?>">
                                    <input type="hidden" name="saldo" id="saldo_<?php echo $data->ID?>" value="<?php echo $data->SALDOCOBRANZA?>">
                                    <input type="hidden" name="credito" id="cred_<?php echo $data->ID?>" value="<?php echo $data->LIMCRED?>">
                                    <input type="hidden" name="cli">
                                <td>
                                    <input type="number" name="monto" step="any" id="monto" onchange="valida(saldo_<?php echo $data->ID?>.value, total_<?php echo $data->ID?>.value, cred_<?php echo $data->ID?>.value)" 
                                    max="<?php echo $maximo?>">
                                </td>
                                <td>
                                    <select required="required" name="fecha">
                                        <option value="1"> 1 Dia </option>
                                        <option value="2"> 2 Dias </option>
                                        <option value="3"> 3 Dias </option>
                                        <option value="4"> 4 Dias </option>
                                        <option value="5"> 5 Dias </option>
                                        <option value="6"> 6 Dias </option>
                                        <option value="7"> 7 Dias </option>
                                        <option value="8"> 8 Dias </option>
                                        <option value="9"> 9 Dias </option>
                                        <option value="10"> 10 Dias </option>
                                        <option value="11"> 11 Dias </option>
                                        <option value="12"> 12 Dias </option>
                                        <option value="13"> 13 Dias </option>
                                        <option value="14"> 14 Dias </option>
                                        <option value="15"> 15 Dias </option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-success" name="cortarCredito" value="enviar" type="submit"> <?php echo ($tipo == 'Restriccion')? 'Restringir':'Cortar Credito'?> </button>   
                                </td>
                                <td> 
                                    <button class="btn btn-success" name="rechazarSolicitud" value="enviar" type="submit"> Rechazar Solicitud </button>
                                </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
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
<script>

function valida(saldo, max, cred){
    var maximo = (saldo + max) - cred;
    maximo = parseFloat(maximo);
    //alert('Maximo = ' + cred);
    //document.getElementById('monto').max=maximo;

}

</script>