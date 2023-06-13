<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class = "panel-heading">
                Seleccionar mes y Vendedor 
            </div>
            <div class= "panel-body">
                <table width="100%" cellspacing="0" cellpadding="0" border="1">
                    <tr>
                        <form action="index.php" method="post">
                        <td width="25%" align="center">
                            <select name="mes">
                            <option value ="errorfecha">---Seleccionar Mes---</option>
                            <?php foreach ($meses as $data):?>
                            <option value="<?php echo $data->NUMERO;?>" > <?php echo $data->NOMBRE?></option>   
                            <?php endforeach ?>
                            </select>
                        </td>
                        <td width="25%" align="center">
                            <select name="anio">
                            <option value ="erroranio">---Seleccionar Año---</option>
                            <option value="2015" > 2015 </option>
                            <option value="2016"> 2016 </option>
                            <option value="2017"> 2017 </option> 
                            <option value="99"> Deuda 2015 </option>  
                            </select>
                        </td>
                        <td width="25%" align="center">
                            <select name="vendedor">
                                <option>--- Seleccionar  Vendedor ---</option>
                                <?php foreach ($vendedores as $data):?>
                                    <option value="cve_vend"> <?php echo $data->NOMBRE?> </option>>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td width="%25" align="center">
                            <button name="filtroDirVerFacturas" type ="submit" value="enviar" class="btn btn-info"> Aplicar Filtro</button>
                        </td>
                        </form>
                    </tr>    
                </table>
                  
            
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class = "panel-heading">
            
                Resumen de Movimientos del mes de <?php echo $mesActual->NOMBRE;?> del <?php echo $anio;?>
            </div>
            <div class= "panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            <th> </th>
                            <th> SubTotal</th>
                            <th> IVA</th>
                            <th> Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <?php foreach($facturasFAA as $data): ?>
                            <td>Venta Folio <?php echo ($anio == 99)? 'A':'FAA'?> <?php echo ($anio == 99)? 'Deuda 2015':" del mes de $mesActual->NOMBRE"?></td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach; ?>
                        </tr>
                        <tr>
                         <?php foreach($facturasG as $data): ?>
                            <td>Venta Folio G <?php echo ($anio == 99)? 'Deuda 2015':" del mes de $mesActual->NOMBRE"?></td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach; ?>
                        </tr>
                        <tr>
                        <?php foreach($facturasE as $data):?>
                            <td>Venta Folio E <?php echo ($anio == 99)? 'Deuda 2015':" del mes de $mesActual->NOMBRE"?> :</td>
                           <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach;?>
                        </tr>
                        <tr bgcolor="#A9E2F3">
                        <?php foreach($ventasMes as $data):?>
                            <td>Venta Mensual <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach?>  
                        </tr>             
                        <tr>
                        <?php foreach ($NotasCreditoMes as $data):?>
                            <td>Notas de Credito <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach ?>
                        </tr>
                         <tr style="background-color:#81DAF5 ">
                            <td>Venta Total <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format( $ventaTotal / 1.16,2)?></td>
                            <td align="right"><?php echo '$ '.number_format(( $ventaTotal- ($ventaTotal / 1.16)),2)?></td>
                            <td align="right"><?php echo '$ '.number_format($ventaTotal,2)?></td>
                        </tr>
                          <tr style="background-color:#E0F8E0">
                        <?php foreach ($pagosDelMes as $data):?>
                            <td>Facturas Pagadas <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach ?>
                        </tr>
                          <tr style="background-color: #F8E0E6">
                        <?php foreach ($NotasCreditoAplicadas as $data):?>
                            <td>Notas de Credito Aplicadas en <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format(($data->IMPORTE_NC/1.16),2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_NC - ($data->IMPORTE_NC / 1.16),2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_NC,2)?></td>
                        <?php endforeach ?>
                        </tr>
                        </tr>
                          <tr style="background-color: #F8E0E6">
                        <?php foreach ($saldoFacturas as $data):?>
                            <td>Saldo del Mes <?php echo ($anio == 99)? 'Deuda 2015':" $mesActual->NOMBRE"?>:</td>
                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->IVA,2)?></td>
                            <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                        <?php endforeach ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($mes))
{?>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision de Facturacion.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-OC">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Factura</th>
                                            <th>Nombre Cliente</th>
                                            <th>Fecha</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Importe</th>
                                            <th>Pagos</th>
                                            <th>Importe NC</th>
                                            <th>Saldo</th>
                                            <th>Vendedor</th>
                                            <th>Nota de Credito</th>
                                            <th>Pagos</th>
                                            <th>Aplicaciones</th>
                                            <th>Ver info del Pago</th>
                                          
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($facturas as $data):
                                         $color = "";
                                         if($data->CVE_DOC == 'TOTAL'){
                                            $color = 'style="background-color:red"';
                                         }elseif ($data->STATUS== 'C') {
                                            $color = 'style="background-color:#E2A9F3"';
                                         } 
                                        ?>
                                       <tr <?php echo $color?>>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo substr($data->NOMBRE,0,30).' ('.$data->CVE_CLPV.' )';?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->CAN_TOT,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMP_TOT4,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->APLICADO,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTENC,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOFINAL,2);?></td>
                                            <td><?php echo $data->CVE_VEND;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo $data->ID_PAGOS;?></td>
                                            <td><?php echo $data->ID_APLICACIONES?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="docf" value="<?php echo $data->CVE_DOC;?>"/>
                                            <td>
                                             <button name="verPagosxFactura" type="submit" value="enviar " class= "btn btn-success"
                                                <?php echo (($data->SALDO == $data->IMPORTE))? "disabled":"";?>> 
                                                Ver Info del Pago.</button>
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

<?php
}
 ?>