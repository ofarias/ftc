<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Cobranza del día.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="tabla1">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Remisión</th>
                                            <th>Importe Remisión</th>
                                            <th>Factura</th>
                                            <th>Importe Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Días</th>
                                            <th>Contra Recibo / Motivo Deslinde</th> 
                                            <th>Deslinde</th>
                                            <th>Aplicar Pago</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($revdia as $data):                                            
                                            if($data->CAJA == 'Total cliente') $color = '#99d6ff';
                                                elseif($data->CAJA == 'Total general') $color = '#5cd65c';
                                                    else $color = '';
                                            ?>
                                       <tr  style="background-color: <?php echo $color;?>">
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->RESULTADO;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->IMPREC;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPFACT,2);?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->REV_DOSPASOS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="text" name="numcr" required="required"/>
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>" />
                                                <input type="hidden" name="docf" value="<?php echo $data->FACTURA?>"/>
                                            <td><button type="submit" name="deslindeSinDosPasos" class="btn btn-warning" >Deslinde</button></td>
                                            <td><button type="submit" name="aplicarPagoFactura" class="btn btn-warning" >Aplicar Pago </button></td>
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Cobranza General de la Cartera.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="tabla2">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Remisión</th>
                                            <th>Importe Remisión</th>
                                            <th>Factura</th>
                                            <th>Importe Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Días</th>
                                            <th>Contra Recibo / Motivo Deslinde</th> 
                                            <th>Deslinde</th>
                                            <th>Aplicar Pago</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data):                                            
                                            if($data->CAJA == 'Total cliente') $color = '#99d6ff';
                                                elseif($data->CAJA == 'Total general') $color = '#5cd65c';
                                                    else $color = '';
                                            ?>
                                       <tr  style="background-color: <?php echo $color;?>">
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->RESULTADO;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->IMPREC;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPFACT,2);?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->REV_DOSPASOS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="text" name="numcr" required="required"/>
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>" >
                                            </form>
                                            </td>
                                            <td><button type="submit" name="deslindeSinDosPasos" class="btn btn-warning" >Deslinde</button></td>
                                            <td><button type="submit" name="avanzarCajaCobranza" class="btn btn-warning" >Aplicar Pago</button></td>
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
    
    
    <br /><br />
    <div style="<?php echo (empty($nocr))?'display: none':'' ?>">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Cobranza Sin Cartera.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="tabla3">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Resultado</th>
                                            <th>Aduana</th>
                                            <th>Remisión</th>
                                            <th>Importe Remisión</th>
                                            <th>Factura</th>
                                            <th>Importe Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha Secuencia</th>
                                            <th>Dos pasos</th>
                                            <th>Días</th>
                                            <th>Contra Recibo / Motivo Deslinde</th> 
                                            <th>Deslinde</th>
                                            <th>Aplicar Pago</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($nocr as $data):
                                            if($data->CAJA == 'Total cliente') $color = '#99d6ff';
                                                elseif($data->CAJA == 'Total general') $color = '#5cd65c';
                                                    else $color = '';
                                            ?>
                                       <tr  style="background-color: <?php echo $color;?>">
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PEDIDO;?></td>
                                            <td><?php echo $data->RESULTADO;?></td>
                                            <td><?php echo $data->ADUANA;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->IMPREC;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo '$ '.number_format($data->IMPFACT,2);?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->REV_DOSPASOS;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="text" name="numcr" required="required"/>
                                                <input type="hidden" name="caja" value="<?php echo $data->CAJA;?>"/>
                                                <input type="hidden" name="revdp" value="<?php echo $data->REV_DOSPASOS;?>"/>
                                                <input type="hidden" name="cr" value="<?php echo $data->CR;?>" >
                                            </form>
                                            </td>
                                            <td><button type="submit" name="deslindeSinDosPasos" class="btn btn-warning" >Deslinde</button></td>
                                            <td><button type="submit" name="avanzarCajaCobranza" class="btn btn-warning" >Aplicar Pago </button></td>
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
</div>
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