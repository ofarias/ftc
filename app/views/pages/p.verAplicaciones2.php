

<br>
<div>
    <label> Seleccione el año: </label>
    <form action="index.php" method="POST">
        <select name="anio" required="required">
            <option value="2015"> 2015  </option>
            <option value="2016"> 2016 </option>
            <option value="2017"> 2017 </option>
            <option value="99"> Todos </option>
        </select>

        <select required="required">
            <option value= "">Seleccion el tipo </option>
            <option value="factura"> Ver por Factura </option>
            <option value="aplicacion"> Ver por Aplicacion </option>
            <option value="pagos"> Ver por Pagos</option>
        </select>

        <button value="enviar" type="submit" class = "btn btn-info" name="verAplicaciones2"> ver </button>    
    </form>
    
</div>

<?php if($aplicaciones != 1 ){?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Facturas
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA FACTURACION</th>
                                            <th>IMPORTE</th>
                                            <th>APLICADO</th>
                                            <th>SALDO</th>
                                            <th>PAGO</th>
                                            <th>FECHA EDO CTA</th>
                                            <th>MONTO PAGO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($aplicaciones as $datos): 
                                          ?>
                                       <tr>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td align="center"><?php echo number_format($datos->IMPORTE,2);?></td>
                                            <td><?php echo number_format($datos->APLICADO,2);?></td>
                                            <td><?php echo number_format($datos->SALDOFINAL,2);?></td>
                                            <td><?php echo '('.$datos->ID_PAGOS.')'.$datos->FOLIO_X_BANCO;?></td>
                                           <td><?php echo $datos->FECHA_RECEP?></td>
                                           <td><?php echo number_format($datos->MONTO,2)?></td>
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<?php } ?>


