<br>
<div class="row">
<div class="container">
<div class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h4>Comisiones por Vendedor</h4>
        </div>
        <div class="panel panel-body">
            <form action="index.php" method="POST"> 
                <div class ="form-group">
                    <label for="mes" class="col-lg-1 control-label">Mes:</label>
                    <div class="col-lg-2">
                        <select  class="form-control" name="mes" required>
                            <option value="">Seleccionar Mes</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <label for="anio" class="col-lg-1 control-label">Año:</label>
                    <div class="col-lg-2">
                        <select name="anio" required="required" class="form-control">
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                        </select>   
                    </div>
                </div>
                <div class ="form-group">

                    <label for="vendedor" class="col-lg-1 control-label">Vendedor:</label>
                    <div class="col-lg-8">
                        <select class="form-control" required="required" name = "vendedor">
                            <option value="">Seleccionar Vendedor</option>
                            <option value="all"> Todos </option>
                            <?php foreach ($vendedores as $key2): ?>
                                <option value="<?php echo $key2->NOMBRE;?>"><?php echo $key2->NOMBRE.' ('.$key2->LETRA_NUEVA.')' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-10">
                        <button name="calculoComisiones" type="submit" value="enviar" class="btn btn-info">Filtrar <i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<br/>

<?php echo !empty($comisiones)? "":'<div class="alert-danger"><center><h2>SELECCIONAR EL MES Y EL USUARIO PARA CONTINUAR.</h2><center></div>'?>
<div id ="envoltura" style="display: <?php echo (empty($comisiones))? 'none':'block';?>">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reporte de calculo de comisiones.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-ventasvscobrado">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Referencia</th>
                                            <th>NC</th>
                                            <th>Fecha elabioración</th>
                                            <th>Importe vendido </th>
                                            <th>Base comision = <br/> Importe Documento sin IVA </th>
                                            <th>Importe cobrado</th>
                                            <th>Importe NC</th>
                                            <th>Saldo</th>
                                            <th>Comision</th>
                                            <th>Vendedor</th>  
                                            <th>Documento Origen</th>
                                        </tr>
                                    </thead>   
                                  <tbody>
                                        <?php
                                            $total = 0;
                                            $totalFacturas = 0;
                                            $totalNC  = 0; 
                                            $comisionNegativa = 0;
                                        foreach ($comisiones as $data):
                                            $comision = 0;
                                                if($data->TIPO == 'f' ){
                                                    $comision = ($data->IMPORTE * 0.01) / 1.16;
                                                    $total = $total + $comision;
                                                }
                                                if($data->TIPO == 'f'){
                                                    $totalFacturas = $totalFacturas + ($data->IMPORTE / 1.16);
                                                }
                                                if($data->TIPO == 'nc'){
                                                    $totalNC = $totalNC + ($data->IMPORTE);
                                                    $comisionNegativa = $comisionNegativa + (($data->IMPORTE) * 0.01);
                                                }
                                            ?>
                                        <tr>                                            
                                            <td><?php echo '('.$data->CVE_CLPV.')'.$data->NOMBRE;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NC_APLICADAS;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2,'.',',');?></td>
                                            <td><?php echo ($data->TIPO =='f')? '$ '.number_format($data->IMPORTE / 1.16,2):"0.00"?></td>
                                            <td><?php echo '$ '.number_format($data->PAGOS,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_NC,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2,'.',',');?></td>
                                            <td align="right"><?php echo '$ '.number_format($comision,2,'.',',');?></td>
                                            <td><?php echo $data->VENDEDOR_REAL;?></td>
                                            <td><?php echo $data->PEDIDO?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label>Se muestra el mes: <?php echo $mes?> del año <?php echo $anio?> </label><br/>
                                 <label>Comisiones para el Vendedor: <?phpe echo $vendedor?></label><br/>
                                 <label>Total Ventas (Sin IVA): <?php echo '$ '.number_format($totalFacturas,2)?></label><br/>
                                 <label>Total Notas de Credrito (Sin IVA): <?php echo '$ '.number_format($totalNC,2)?></label><br/>
                                 <label><font color="blue"><b>Total de Venta : <?php echo '$ '.number_format($totalFacturas-$totalNC,2) ?></b></font></label><br/>
                                 <label>Total Comisiones : <?php echo '$ '.number_format($total,2)?></label><br/>
                                 <label>Total Descuento Comision x NC : <?php echo '$ '.number_format($comisionNegativa,2)?> </label><br/>
                                 <label><font color="red"><b>Comision Final: <?php echo '$ '.number_format($total - $comisionNegativa,2)?></b></font></label>
                            </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>

</div>